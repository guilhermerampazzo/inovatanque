<?php
/**
 * Reorganiza a hierarquia de categorias de MATERIAL (executável via navegador).
 *
 *   Aço (pai)        → Aço Carbono, Aço Inox
 *   Térmica (pai)    → Asfáltica, Vegetal
 *   Alumínio (pai, sem filhos)
 *   Graneleiro (pai, sem filhos)
 *   Sider (pai, sem filhos)
 *
 * Ordem alfabética entre pais e entre filhos.
 *
 * USO (protegido por token):
 *   https://seusite.com.br/reorganizar-categorias.php?token=INOVA2025
 *   Adicione &dry_run=1 para simular sem gravar.
 *
 * APAGAR APÓS O USO.
 */

$webToken = 'INOVA2025';
if (($_GET['token'] ?? '') !== $webToken) {
    http_response_code(403);
    die("Acesso negado. Use ?token={$webToken}");
}

$dryRun = isset($_GET['dry_run']);

require_once __DIR__ . '/../config/database.php';

header('Content-Type: text/html; charset=utf-8');
echo "<pre style='font:14px/1.5 monospace;padding:24px;background:#111;color:#eee'>";
echo "== Reorganização de categorias" . ($dryRun ? " (DRY-RUN — nada será gravado)" : "") . " ==\n\n";

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
        DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );

    function slugify(string $t): string {
        $t = iconv('UTF-8', 'ASCII//TRANSLIT', $t);
        $t = strtolower($t);
        $t = preg_replace('/[^a-z0-9]+/', '-', $t);
        return trim($t, '-');
    }

    function bySlug(PDO $pdo, string $slug): ?array {
        $s = $pdo->prepare('SELECT * FROM categorias WHERE slug = ?');
        $s->execute([$slug]);
        return $s->fetch() ?: null;
    }

    function ensure(PDO $pdo, bool $dry, string $slug, string $nome, int $parent, int $ordem): int {
        $ex = bySlug($pdo, $slug);
        if ($ex) {
            if ($ex['nome'] !== $nome || (int)$ex['parent_id'] !== $parent || (int)$ex['ordem'] !== $ordem || (int)$ex['ativo'] !== 1) {
                echo "[ajuste] {$nome} (slug={$slug}): parent {$ex['parent_id']}→{$parent}, ordem {$ex['ordem']}→{$ordem}\n";
                if (!$dry) {
                    $pdo->prepare('UPDATE categorias SET nome=?, parent_id=?, ordem=?, ativo=1 WHERE id=?')
                        ->execute([$nome, $parent, $ordem, $ex['id']]);
                }
            }
            return (int)$ex['id'];
        }
        echo "[cria] {$nome} (slug={$slug}, parent={$parent})\n";
        if ($dry) return -1;
        $pdo->prepare('INSERT INTO categorias (nome, slug, parent_id, ordem, ativo) VALUES (?,?,?,?,1)')
            ->execute([$nome, $slug, $parent, $ordem]);
        return (int)$pdo->lastInsertId();
    }

    function mergeInto(PDO $pdo, bool $dry, array $from, int $to): void {
        $fid = (int)$from['id'];
        if ($fid === $to) return;
        $c = $pdo->prepare('SELECT COUNT(*) FROM produtos WHERE categoria_id=?');
        $c->execute([$fid]);
        $qtd = (int)$c->fetchColumn();
        echo "[merge] '{$from['nome']}' (id={$fid}) → id={$to} ({$qtd} produto(s))\n";
        if ($dry) return;
        $pdo->prepare('UPDATE produtos SET categoria_id=? WHERE categoria_id=?')->execute([$to, $fid]);
        $pdo->prepare('UPDATE categorias SET parent_id=? WHERE parent_id=?')->execute([$to, $fid]);
        $pdo->prepare('DELETE FROM categorias WHERE id=?')->execute([$fid]);
    }

    // 1) Pais (ordem alfabética) e filhos
    $idAco        = ensure($pdo, $dryRun, 'aco', 'Aço', 0, 10);
    $idAluminio   = ensure($pdo, $dryRun, 'aluminio', 'Alumínio', 0, 20);
    $idGraneleiro = ensure($pdo, $dryRun, 'graneleiro', 'Graneleiro', 0, 30);
    $idSider      = ensure($pdo, $dryRun, 'sider', 'Sider', 0, 40);
    $idTermica    = ensure($pdo, $dryRun, 'termica', 'Térmica', 0, 50);

    $idAcoCarbono = ensure($pdo, $dryRun, 'aco-carbono', 'Aço Carbono', $idAco, 1);
    $idAcoInox    = ensure($pdo, $dryRun, 'aco-inox', 'Aço Inox', $idAco, 2);
    $idAsfaltica  = ensure($pdo, $dryRun, 'asfaltica', 'Asfáltica', $idTermica, 1);
    $idVegetal    = ensure($pdo, $dryRun, 'vegetal', 'Vegetal', $idTermica, 2);

    $canon = [$idAco,$idAluminio,$idGraneleiro,$idSider,$idTermica,$idAcoCarbono,$idAcoInox,$idAsfaltica,$idVegetal];

    // 2) Consolida categorias soltas por nome
    $mapa = [
        $idAcoCarbono => ['carbono'],
        $idAcoInox    => ['inox'],
        $idAsfaltica  => ['asfalt'],
        $idVegetal    => ['vegetal'],
    ];
    foreach ($pdo->query('SELECT * FROM categorias')->fetchAll() as $cat) {
        if (in_array((int)$cat['id'], $canon, true)) continue;
        $nl = mb_strtolower($cat['nome']);
        foreach ($mapa as $dest => $palavras) {
            foreach ($palavras as $p) {
                if (str_contains($nl, $p)) { mergeInto($pdo, $dryRun, $cat, $dest); continue 3; }
            }
        }
    }

    // 3) Achata filhas indevidas de Sider/Alumínio/Graneleiro
    foreach ([$idSider=>'Sider',$idAluminio=>'Alumínio',$idGraneleiro=>'Graneleiro'] as $pai=>$nomePai) {
        $s = $pdo->prepare('SELECT * FROM categorias WHERE parent_id=?');
        $s->execute([$pai]);
        foreach ($s->fetchAll() as $filha) {
            echo "[flatten] '{$filha['nome']}' era filha de {$nomePai}\n";
            mergeInto($pdo, $dryRun, $filha, $pai);
        }
    }

    // 4) Resumo
    echo "\n== Categorias após reorganização ==\n";
    $q = $pdo->query("
        SELECT c.id,c.nome,c.slug,c.parent_id,c.ordem,
               (SELECT COUNT(*) FROM produtos p WHERE p.categoria_id=c.id) qtd
        FROM categorias c
        ORDER BY (c.parent_id=0) DESC, c.parent_id ASC, c.ordem ASC
    ");
    foreach ($q as $r) {
        $pad = $r['parent_id']==0 ? '' : '   └ ';
        echo str_pad($r['id'],4) . " {$pad}{$r['nome']} (slug={$r['slug']}, parent={$r['parent_id']}, produtos={$r['qtd']})\n";
    }

    echo "\n✅ Concluído" . ($dryRun ? " (dry-run)" : "") . ". APAGUE este arquivo do servidor após o uso.\n";
} catch (Exception $e) {
    echo "❌ ERRO: " . htmlspecialchars($e->getMessage()) . "\n";
}
echo "</pre>";
