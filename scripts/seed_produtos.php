<?php
/**
 * Importa produtos do site inovatanque.com.br atual.
 * Baixa imagens para public/uploads/produtos/seed/ e insere no banco.
 *
 * Uso (CLI):
 *   php scripts/seed_produtos.php
 *
 * Idempotente: se o slug já existir, pula o produto.
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("Execute via CLI.\n");
}

define('APP_ROOT', dirname(__DIR__));
require APP_ROOT . '/config/app.php';
require APP_ROOT . '/config/database.php';
require APP_ROOT . '/app/core/Autoload.php';
require APP_ROOT . '/app/helpers/functions.php';

$pdo = Database::connect();

$uploadDir = APP_ROOT . '/public/uploads/produtos/seed';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

/* --------------------------------------------------------------------------
 * Categorias usadas
 * ------------------------------------------------------------------------*/
$categoriasNecessarias = [
    'aco-inox'    => ['nome' => 'Aço Inox',   'parent_id' => 0, 'ordem' => 10],
    'aco-carbono' => ['nome' => 'Aço Carbono','parent_id' => 0, 'ordem' => 20],
    'aluminio'    => ['nome' => 'Alumínio',   'parent_id' => 0, 'ordem' => 30],
    'asfaltica'   => ['nome' => 'Asfáltica',  'parent_id' => 0, 'ordem' => 40],
    'graneleiro'  => ['nome' => 'Graneleiro', 'parent_id' => 0, 'ordem' => 50],
    'sider'       => ['nome' => 'Sider',      'parent_id' => 0, 'ordem' => 60],
];

$catIds = [];
foreach ($categoriasNecessarias as $slug => $info) {
    $stmt = $pdo->prepare('SELECT id FROM categorias WHERE slug = ?');
    $stmt->execute([$slug]);
    $row = $stmt->fetch();
    if ($row) {
        $catIds[$slug] = (int) $row['id'];
        continue;
    }
    $ins = $pdo->prepare('INSERT INTO categorias (nome, slug, parent_id, ordem, ativo) VALUES (?, ?, ?, ?, 1)');
    $ins->execute([$info['nome'], $slug, $info['parent_id'], $info['ordem']]);
    $catIds[$slug] = (int) $pdo->lastInsertId();
    echo "[cat] criada: {$slug}\n";
}

/* --------------------------------------------------------------------------
 * Helpers
 * ------------------------------------------------------------------------*/
function slugify(string $text): string {
    $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
    $text = preg_replace('/[^a-zA-Z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    return strtolower(trim($text, '-'));
}

function normCarregamento(?string $v): ?string {
    if (!$v) return null;
    $v = strtolower($v);
    if (strpos($v, 'top') !== false) return 'top';
    if (strpos($v, 'bott') !== false) return 'bottom';
    return null;
}

function firstYear($v): ?int {
    if ($v === null || $v === '') return null;
    if (preg_match('/(\d{4})/', (string)$v, $m)) return (int) $m[1];
    return null;
}

function baixarImagem(string $url, string $destDir, string $slug): ?string {
    if (!$url) return null;
    $ext = strtolower(pathinfo(parse_url($url, PHP_URL_PATH) ?? '', PATHINFO_EXTENSION)) ?: 'jpg';
    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) $ext = 'jpg';
    $filename = $slug . '.' . $ext;
    $dest = $destDir . '/' . $filename;

    if (file_exists($dest)) {
        return 'uploads/produtos/seed/' . $filename;
    }

    $ctx = stream_context_create([
        'http'  => ['timeout' => 30, 'user_agent' => 'Mozilla/5.0 (compatible; InovaSeed/1.0)'],
        'https' => ['timeout' => 30, 'user_agent' => 'Mozilla/5.0 (compatible; InovaSeed/1.0)'],
    ]);
    $data = @file_get_contents($url, false, $ctx);
    if ($data === false || strlen($data) < 200) {
        echo "  [img] falhou: {$url}\n";
        return null;
    }
    file_put_contents($dest, $data);
    return 'uploads/produtos/seed/' . $filename;
}

/* --------------------------------------------------------------------------
 * Produtos
 * ------------------------------------------------------------------------*/
$produtos = require __DIR__ . '/produtos_data.php';

$inseridos = 0;
$pulados = 0;
$semImagem = 0;

foreach ($produtos as $p) {
    $titulo = trim($p['titulo']);
    $slug = slugify($titulo . '-' . ($p['codigo'] ?? ''));

    $check = $pdo->prepare('SELECT id FROM produtos WHERE slug = ? OR (codigo IS NOT NULL AND codigo = ?)');
    $check->execute([$slug, $p['codigo'] ?? null]);
    if ($check->fetch()) {
        echo "[skip] já existe: {$slug}\n";
        $pulados++;
        continue;
    }

    $catSlug = $p['categoria'];
    if (!isset($catIds[$catSlug])) {
        echo "[erro] categoria desconhecida: {$catSlug}\n";
        continue;
    }

    $data = [
        'codigo'       => $p['codigo'] ?? null,
        'titulo'       => $titulo,
        'slug'         => $slug,
        'categoria_id' => $catIds[$catSlug],
        'configuracao' => $p['configuracao'] ?? null,
        'capacidade'   => $p['capacidade'] ?? null,
        'ano'          => firstYear($p['ano'] ?? null),
        'fabricante'   => $p['fabricante'] ?? null,
        'carregamento' => normCarregamento($p['carregamento'] ?? null),
        'modalidade'   => $p['modalidade'] ?? null,
        'status'       => $p['status'] ?? 'disponivel',
        'descricao'    => $p['descricao'] ?? null,
        'destaque'     => 0,
        'ordem'        => 0,
        'created_at'   => date('Y-m-d H:i:s'),
    ];

    $fields = implode(', ', array_keys($data));
    $ph = implode(', ', array_fill(0, count($data), '?'));
    $ins = $pdo->prepare("INSERT INTO produtos ({$fields}) VALUES ({$ph})");
    $ins->execute(array_values($data));
    $produtoId = (int) $pdo->lastInsertId();
    echo "[ok] {$slug}\n";
    $inseridos++;

    if (!empty($p['imagem_url'])) {
        $arquivo = baixarImagem($p['imagem_url'], $uploadDir, $slug);
        if ($arquivo) {
            $imgIns = $pdo->prepare('INSERT INTO produto_imagens (produto_id, arquivo, ordem, principal) VALUES (?, ?, 0, 1)');
            $imgIns->execute([$produtoId, $arquivo]);
        } else {
            $semImagem++;
        }
    } else {
        $semImagem++;
    }
}

echo "\n==== Resumo ====\n";
echo "Inseridos:   {$inseridos}\n";
echo "Pulados:     {$pulados}\n";
echo "Sem imagem:  {$semImagem}\n";
