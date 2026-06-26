<?php
/**
 * Sincroniza produtos da loja Integrando.se (Loja Integrada) para o banco local.
 *
 * USO VIA CLI:
 *   php scripts/sync_integrandose.php              # sincroniza todos
 *   php scripts/sync_integrandose.php --debug      # exibe resposta bruta da API e para
 *   php scripts/sync_integrandose.php --dry-run    # simula sem gravar no banco
 *   php scripts/sync_integrandose.php --limit=50   # limita a N produtos
 *   php scripts/sync_integrandose.php --ocultos    # inclui produtos ocultos/inativos
 *
 * USO VIA WEB (protegido):
 *   https://seusite.com.br/scripts/sync_integrandose.php?token=SYNC2025&debug=1
 */

// ─── Proteção web ────────────────────────────────────────────────────────────
$webToken = 'SYNC2025';
$isCli    = PHP_SAPI === 'cli';

if (!$isCli) {
    if (($_GET['token'] ?? '') !== $webToken) {
        http_response_code(403);
        die("Acesso negado. Use ?token={$webToken}\n");
    }
    header('Content-Type: text/plain; charset=utf-8');
    ob_implicit_flush(true);
}

// ─── Argumentos ──────────────────────────────────────────────────────────────
$args   = $isCli ? array_slice($argv, 1) : [];
$debug  = in_array('--debug', $args)    || isset($_GET['debug']);
$dryRun = in_array('--dry-run', $args)  || isset($_GET['dry_run']);
$incluiOcultos = in_array('--ocultos', $args) || isset($_GET['ocultos']);
$limitArg = 0;
foreach ($args as $a) {
    if (str_starts_with($a, '--limit=')) {
        $limitArg = (int) substr($a, 8);
    }
}

// ─── Bootstrap ───────────────────────────────────────────────────────────────
define('APP_ROOT', dirname(__DIR__));
require APP_ROOT . '/config/app.php';
require APP_ROOT . '/config/database.php';
require APP_ROOT . '/app/core/Autoload.php';
require APP_ROOT . '/app/helpers/functions.php';

$pdo = Database::connect();

// ─── Configuração da API ──────────────────────────────────────────────────────
// chave_aplicacao: identifica a LOJA (fornecida pelo cliente)
// chave_api: identifica a APLICAÇÃO que consome a API
// Para criar uma chave_api: acesse painel Loja Integrada → Minha Conta → API
const LOJA_CHAVE_APLICACAO = 'daf928cc7bcd43e9f5b3';
const LOJA_CHAVE_API       = '';  // ← preencher se necessário (normalmente não precisa para leitura pública)
const LOJA_BASE_URL        = 'https://api.awsli.com.br';

// ─── Upload dir ──────────────────────────────────────────────────────────────
$uploadDir = APP_ROOT . '/public/uploads/produtos/integrandose';
if (!$dryRun && !is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// ─────────────────────────────────────────────────────────────────────────────
// HELPERS
// ─────────────────────────────────────────────────────────────────────────────
function log_out(string $msg): void
{
    echo $msg . "\n";
    flush();
}

function api_get(string $path, array $params = []): array
{
    $params['chave_aplicacao'] = LOJA_CHAVE_APLICACAO;
    if (LOJA_CHAVE_API !== '') {
        $params['chave_api'] = LOJA_CHAVE_API;
    }

    $url = LOJA_BASE_URL . $path . '?' . http_build_query($params);

    $ctx = stream_context_create([
        'http' => [
            'method'  => 'GET',
            'timeout' => 30,
            'header'  => [
                'Accept: application/json',
                'User-Agent: InovaTanque-Sync/1.0',
            ],
            'ignore_errors' => true,
        ],
        'ssl' => ['verify_peer' => false],
    ]);

    $raw = @file_get_contents($url, false, $ctx);

    // Verifica status HTTP
    $status = 0;
    foreach ($http_response_header ?? [] as $h) {
        if (preg_match('#HTTP/\d\.\d\s+(\d+)#', $h, $m)) {
            $status = (int) $m[1];
        }
    }

    if ($raw === false || $raw === '') {
        throw new RuntimeException("Falha ao conectar em: {$url} (status {$status})");
    }

    $data = json_decode($raw, true);
    if ($data === null) {
        throw new RuntimeException("Resposta não é JSON válido (status {$status}):\n" . substr($raw, 0, 500));
    }

    if ($status >= 400) {
        $msg = $data['detail'] ?? $data['error'] ?? json_encode($data);
        throw new RuntimeException("Erro HTTP {$status}: {$msg}");
    }

    return $data;
}

function slugify_local(string $text): string
{
    $text = mb_strtolower(trim($text), 'UTF-8');
    $text = strtr($text, [
        'á'=>'a','à'=>'a','ã'=>'a','â'=>'a','ä'=>'a',
        'é'=>'e','è'=>'e','ê'=>'e','ë'=>'e',
        'í'=>'i','ì'=>'i','î'=>'i','ï'=>'i',
        'ó'=>'o','ò'=>'o','õ'=>'o','ô'=>'o','ö'=>'o',
        'ú'=>'u','ù'=>'u','û'=>'u','ü'=>'u',
        'ç'=>'c','ñ'=>'n',
    ]);
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    return trim($text, '-');
}

function download_image(string $url, string $destDir): ?string
{
    if (empty($url)) return null;

    $ext  = strtolower(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION)) ?: 'jpg';
    $ext  = in_array($ext, ['jpg','jpeg','png','webp','gif']) ? $ext : 'jpg';
    $name = md5($url) . '.' . $ext;
    $dest = $destDir . '/' . $name;
    $rel  = '/uploads/produtos/integrandose/' . $name;

    if (file_exists($dest)) return $rel;

    $ctx = stream_context_create([
        'http' => ['timeout' => 20, 'ignore_errors' => true],
        'ssl'  => ['verify_peer' => false],
    ]);
    $img = @file_get_contents($url, false, $ctx);
    if ($img === false || strlen($img) < 100) return null;

    file_put_contents($dest, $img);
    return $rel;
}

/**
 * Tenta extrair campos técnicos do nome/título do produto.
 * Formato típico: "Bitrenzao tanque aco carbono Randon 200708 62000L carregamento top"
 */
function parse_titulo(string $titulo): array
{
    $t = mb_strtolower($titulo, 'UTF-8');

    // Configuração
    $config = null;
    $configs = [
        'vanderleia 3ed' => 'Vanderleia 3ED',
        'vanderleia'     => 'Vanderleia 3ED',
        'bitrenzao'      => 'Bitrenzao',
        'bitrenzão'      => 'Bitrenzao',
        'bitrem'         => 'Bitrem',
        'rodotrem'       => 'Rodotrem',
        'carreta'        => 'Carreta',
    ];
    foreach ($configs as $key => $val) {
        if (str_contains($t, $key)) { $config = $val; break; }
    }

    // Capacidade (ex: 62000L ou 62.000L)
    $capacidade = null;
    if (preg_match('/(\d[\d.]{2,})\s*l\b/i', $titulo, $m)) {
        $capacidade = (int) preg_replace('/\D/', '', $m[1]);
    }

    // Carregamento
    $carregamento = null;
    if (str_contains($t, 'top'))    $carregamento = 'top';
    if (str_contains($t, 'bottom')) $carregamento = 'bottom';

    // Fabricante
    $fabricante = null;
    $fabricantes = ['Randon', 'Guerra', 'Noma', 'Librelato', 'Facchini',
                    'Serrano', 'Cegonheiro', 'Fruehauf', 'Krone', 'Schmitz'];
    foreach ($fabricantes as $f) {
        if (stripos($titulo, $f) !== false) { $fabricante = $f; break; }
    }

    // Ano (4 dígitos entre 1990–2030, ou no formato AAAAMM nos primeiros 8 dígitos do código)
    $ano = null;
    if (preg_match('/\b(19[9]\d|20[012]\d)\b/', $titulo, $m)) {
        $ano = (int) $m[1];
    }

    // Modalidade
    $modalidade = 'Locação';
    if (str_contains($t, 'venda'))       $modalidade = 'Venda';
    if (str_contains($t, 'locaç'))       $modalidade = 'Locação';
    if (str_contains($t, 'consignaç'))   $modalidade = 'Consignação';

    return compact('config', 'capacidade', 'carregamento', 'fabricante', 'ano', 'modalidade');
}

/**
 * Resolve categoria_id pelo nome vindo da Loja Integrada.
 */
function resolve_categoria(string $nomeCategoria, PDO $pdo): int
{
    static $cache = [];
    $key = mb_strtolower(trim($nomeCategoria));

    if (isset($cache[$key])) return $cache[$key];

    $mapa = [
        'aco'         => 'aco',
        'aço'         => 'aco',
        'inox'        => 'aco-inox',
        'aco inox'    => 'aco-inox',
        'aço inox'    => 'aco-inox',
        'carbono'     => 'aco-carbono',
        'aco carbono' => 'aco-carbono',
        'aço carbono' => 'aco-carbono',
        'termica'     => 'termica',
        'térmica'     => 'termica',
        'asfaltica'   => 'asfaltica',
        'asfáltica'   => 'asfaltica',
        'vegetal'     => 'vegetal',
        'sider'       => 'sider',
        'aluminio'    => 'aluminio',
        'alumínio'    => 'aluminio',
        'graneleiro'  => 'graneleiro',
    ];

    $slug = null;
    foreach ($mapa as $k => $v) {
        if (str_contains($key, $k)) { $slug = $v; break; }
    }

    if ($slug) {
        $stmt = $pdo->prepare("SELECT id FROM categorias WHERE slug = ?");
        $stmt->execute([$slug]);
        $row = $stmt->fetch();
        if ($row) {
            $cache[$key] = (int) $row['id'];
            return $cache[$key];
        }
    }

    // Fallback: primeira categoria pai
    $row = $pdo->query("SELECT id FROM categorias WHERE parent_id = 0 AND ativo = 1 ORDER BY ordem LIMIT 1")->fetch();
    $id = $row ? (int) $row['id'] : 1;
    $cache[$key] = $id;
    return $id;
}

// ─────────────────────────────────────────────────────────────────────────────
// MODO DEBUG — exibe resposta bruta e para
// ─────────────────────────────────────────────────────────────────────────────
if ($debug) {
    log_out("=== MODO DEBUG — primeiros 2 produtos ===\n");

    // Tenta endpoint de produto
    $endpoints = [
        '/v1/produto/search/'    => ['limit' => 2, 'offset' => 0],
        '/v1/produto/'           => ['limit' => 2, 'offset' => 0],
        '/api/v1/produto/'       => ['limit' => 2, 'offset' => 0],
    ];

    foreach ($endpoints as $path => $params) {
        log_out("Tentando: " . LOJA_BASE_URL . $path);
        try {
            $data = api_get($path, $params);
            log_out("✓ Sucesso!\n");
            log_out(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            exit(0);
        } catch (RuntimeException $e) {
            log_out("✗ " . $e->getMessage() . "\n");
        }
    }

    log_out("\nNenhum endpoint funcionou.");
    log_out("Verifique a chave_api e chave_aplicacao.");
    log_out("Talvez precise de chave_api — acesse o painel da Loja Integrada → Minha Conta → API.");
    exit(1);
}

// ─────────────────────────────────────────────────────────────────────────────
// SINCRONIZAÇÃO
// ─────────────────────────────────────────────────────────────────────────────
log_out("=== Sync Integrando.se → Inova Tanque ===");
log_out("Modo: " . ($dryRun ? "DRY-RUN (sem gravação)" : "PRODUÇÃO"));
log_out(str_repeat("─", 50));

$stats = ['criados' => 0, 'atualizados' => 0, 'ocultos' => 0, 'erros' => 0, 'total_api' => 0];

$offset  = 0;
$perPage = 50;
$hasMore = true;

while ($hasMore) {
    $params = [
        'limit'  => $perPage,
        'offset' => $offset,
        'ativo'  => $incluiOcultos ? '' : 'true',
    ];

    try {
        $response = api_get('/v1/produto/search/', $params);
    } catch (RuntimeException $e) {
        // Tenta endpoint alternativo
        try {
            $response = api_get('/v1/produto/', $params);
        } catch (RuntimeException $e2) {
            log_out("[FATAL] " . $e2->getMessage());
            log_out("Execute com --debug para diagnosticar.");
            exit(1);
        }
    }

    $produtos = $response['objects'] ?? [];
    $total    = (int) ($response['meta']['total_count'] ?? count($produtos));

    if ($offset === 0) {
        log_out("Total encontrado na API: {$total}");
        $stats['total_api'] = $total;
    }

    if (empty($produtos)) {
        $hasMore = false;
        break;
    }

    foreach ($produtos as $p) {
        $stats = processar_produto($p, $pdo, $uploadDir, $dryRun, $stats);

        if ($limitArg > 0 && ($stats['criados'] + $stats['atualizados'] + $stats['ocultos']) >= $limitArg) {
            $hasMore = false;
            break;
        }
    }

    // Paginação
    $offset += $perPage;
    if ($offset >= $total || empty($response['meta']['next'])) {
        $hasMore = false;
    }

    if ($hasMore) {
        usleep(300_000); // 300ms entre páginas — evita rate-limit
    }
}

// ─── Resumo ───────────────────────────────────────────────────────────────────
log_out("\n" . str_repeat("─", 50));
log_out("RESUMO:");
log_out("  Total na API  : {$stats['total_api']}");
log_out("  Criados       : {$stats['criados']}");
log_out("  Atualizados   : {$stats['atualizados']}");
log_out("  Ocultos       : {$stats['ocultos']}");
log_out("  Erros         : {$stats['erros']}");
log_out(str_repeat("─", 50));

// ─────────────────────────────────────────────────────────────────────────────
// PROCESSA UM PRODUTO
// ─────────────────────────────────────────────────────────────────────────────
function processar_produto(array $p, PDO $pdo, string $uploadDir, bool $dryRun, array $stats): array
{
    // ── Campos básicos da API ─────────────────────────────────────────────────
    $externoId = (string) ($p['id'] ?? '');
    $ativo     = (bool)   ($p['ativo'] ?? true);
    $disponivel = (bool)  ($p['disponivel'] ?? true);

    $nome      = trim($p['nome'] ?? '');
    $descricao = trim($p['descricao_completa'] ?? $p['descricao'] ?? '');
    $codigo    = trim($p['codigo'] ?? $p['sku'] ?? '');

    // slug: usa o da API ou gera
    $slugApi   = trim($p['slug'] ?? '');
    $slug      = $slugApi ?: slugify_local($nome);
    if (empty($slug)) {
        $slug = 'produto-' . $externoId;
    }

    // ── Imagens ───────────────────────────────────────────────────────────────
    $imagens = $p['imagens'] ?? [];
    // Normaliza: alguns endpoints retornam array de strings, outros de objetos
    $imagensUrls = [];
    foreach ($imagens as $img) {
        if (is_string($img)) {
            $imagensUrls[] = $img;
        } elseif (is_array($img)) {
            $url = $img['url'] ?? $img['imagem'] ?? $img['link'] ?? '';
            if ($url) $imagensUrls[] = $url;
        }
    }

    // ── Categorias ────────────────────────────────────────────────────────────
    $categorias  = $p['categorias'] ?? [];
    $nomeCategoria = '';
    if (!empty($categorias)) {
        $first = $categorias[0];
        $nomeCategoria = is_array($first) ? ($first['nome'] ?? '') : (string) $first;
    }
    $categoriaId = resolve_categoria($nomeCategoria ?: $nome, $pdo);

    // ── Parseia campos técnicos do título ─────────────────────────────────────
    $parsed = parse_titulo($nome);
    $configuracao = $parsed['config'];
    $capacidade   = $parsed['capacidade'];
    $carregamento = $parsed['carregamento'];
    $fabricante   = $parsed['fabricante'];
    $ano          = $parsed['ano'];
    $modalidade   = $parsed['modalidade'];

    // Sobrescreve com atributos da API se existirem
    $atributos = $p['atributos'] ?? [];
    foreach ($atributos as $at) {
        $chave = mb_strtolower(trim($at['chave'] ?? ''));
        $valor = trim($at['valor'] ?? '');
        switch ($chave) {
            case 'capacidade': $capacidade = (int) preg_replace('/\D/', '', $valor); break;
            case 'configuracao':
            case 'configuração': $configuracao = $valor; break;
            case 'carregamento': $carregamento = in_array($valor, ['top','bottom']) ? $valor : null; break;
            case 'fabricante':   $fabricante = $valor; break;
            case 'ano':          $ano = (int) $valor; break;
            case 'modalidade':   $modalidade = $valor; break;
        }
    }

    // ── Status ────────────────────────────────────────────────────────────────
    $status = 'disponivel';
    if (!$ativo || !$disponivel) {
        $status = 'oculto';
    }
    // Tenta inferir pronta_entrega
    if ($ativo && $disponivel && str_contains(mb_strtolower($nome), 'pronta entrega')) {
        $status = 'pronta_entrega';
    }

    // ── Verifica se já existe ─────────────────────────────────────────────────
    $existente = null;
    if ($externoId) {
        $stmt = $pdo->prepare("SELECT id, slug FROM produtos WHERE externo_id = ? AND externo_fonte = 'integrandose' LIMIT 1");
        $stmt->execute([$externoId]);
        $existente = $stmt->fetch() ?: null;
    }
    if (!$existente) {
        $stmt = $pdo->prepare("SELECT id, slug FROM produtos WHERE slug = ? LIMIT 1");
        $stmt->execute([$slug]);
        $existente = $stmt->fetch() ?: null;
    }

    // ── Slug único ────────────────────────────────────────────────────────────
    $slugFinal = $slug;
    if (!$existente) {
        $base = $slug;
        $i = 1;
        while (true) {
            $chk = $pdo->prepare("SELECT id FROM produtos WHERE slug = ?");
            $chk->execute([$slugFinal]);
            if (!$chk->fetch()) break;
            $slugFinal = $base . '-' . (++$i);
        }
    } else {
        $slugFinal = $existente['slug'];
    }

    $label = $status === 'oculto' ? '[OCULTO]' : ($existente ? '[UPDATE]' : '[NOVO]  ');
    log_out("{$label} {$nome}" . ($codigo ? " [{$codigo}]" : ''));

    if ($dryRun) {
        if ($status === 'oculto') $stats['ocultos']++;
        elseif ($existente)       $stats['atualizados']++;
        else                      $stats['criados']++;
        return $stats;
    }

    // ── Garante colunas externo_id / externo_fonte (caso migração não rodou) ──
    try {
        $pdo->exec("ALTER TABLE produtos ADD COLUMN IF NOT EXISTS externo_id VARCHAR(100) DEFAULT NULL AFTER codigo");
        $pdo->exec("ALTER TABLE produtos ADD COLUMN IF NOT EXISTS externo_fonte VARCHAR(50) DEFAULT NULL AFTER externo_id");
    } catch (PDOException $e) { /* ignora se já existir */ }

    // ── Insere ou atualiza produto ────────────────────────────────────────────
    $dados = [
        'titulo'        => $nome,
        'slug'          => $slugFinal,
        'codigo'        => $codigo,
        'externo_id'    => $externoId,
        'externo_fonte' => 'integrandose',
        'categoria_id'  => $categoriaId,
        'configuracao'  => $configuracao,
        'capacidade'    => $capacidade,
        'ano'           => $ano,
        'fabricante'    => $fabricante,
        'carregamento'  => $carregamento,
        'modalidade'    => $modalidade,
        'status'        => $status,
        'descricao'     => $descricao ?: null,
    ];

    try {
        if ($existente) {
            $sets  = implode(', ', array_map(fn($k) => "{$k} = ?", array_keys($dados)));
            $stmt  = $pdo->prepare("UPDATE produtos SET {$sets} WHERE id = ?");
            $stmt->execute([...array_values($dados), $existente['id']]);
            $produtoId = (int) $existente['id'];
            if ($status === 'oculto') $stats['ocultos']++;
            else $stats['atualizados']++;
        } else {
            $cols  = implode(', ', array_keys($dados));
            $marks = implode(', ', array_fill(0, count($dados), '?'));
            $stmt  = $pdo->prepare("INSERT INTO produtos ({$cols}) VALUES ({$marks})");
            $stmt->execute(array_values($dados));
            $produtoId = (int) $pdo->lastInsertId();
            if ($status === 'oculto') $stats['ocultos']++;
            else $stats['criados']++;
        }

        // ── Imagens ───────────────────────────────────────────────────────────
        if (!empty($imagensUrls)) {
            // Remove imagens antigas que vieram de integração (mantém as manuais)
            $pdo->prepare("DELETE FROM produto_imagens WHERE produto_id = ? AND arquivo LIKE '/uploads/produtos/integrandose/%'")->execute([$produtoId]);

            foreach ($imagensUrls as $idx => $imgUrl) {
                $localPath = download_image($imgUrl, $uploadDir);
                if (!$localPath) continue;

                $isPrincipal = $idx === 0 ? 1 : 0;
                if ($isPrincipal) {
                    // garante que só uma seja principal
                    $pdo->prepare("UPDATE produto_imagens SET principal = 0 WHERE produto_id = ?")->execute([$produtoId]);
                }
                $pdo->prepare("INSERT INTO produto_imagens (produto_id, arquivo, ordem, principal) VALUES (?, ?, ?, ?)")
                    ->execute([$produtoId, $localPath, $idx, $isPrincipal]);
            }
        }

    } catch (PDOException $e) {
        log_out("  [ERRO DB] " . $e->getMessage());
        $stats['erros']++;
    }

    return $stats;
}
