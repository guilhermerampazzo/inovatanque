<?php
/**
 * Corrige a estrutura de categorias após o seed:
 *  - Reorganiza Aço Inox e Aço Carbono como filhas de "Aço"
 *  - Mantém Asfáltica como filha de Térmica
 *  - Remove categorias vazias e sem filhas (Inox e Vegetal originais do seed)
 *  - Marca produtos importados como destaque para aparecerem em "Equipamentos Disponíveis"
 *
 * Uso (CLI):
 *   php scripts/fix_categorias.php
 *
 * Idempotente.
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

function idBySlug(PDO $pdo, string $slug): ?int {
    $stmt = $pdo->prepare('SELECT id FROM categorias WHERE slug = ?');
    $stmt->execute([$slug]);
    $row = $stmt->fetch();
    return $row ? (int) $row['id'] : null;
}

/* ----------------------------------------------------------------------
 * 1) Reorganizar hierarquia de categorias
 * ---------------------------------------------------------------------- */
$idAco       = idBySlug($pdo, 'aco');
$idAcoInox   = idBySlug($pdo, 'aco-inox');
$idAcoCarb   = idBySlug($pdo, 'aco-carbono');
$idInoxAntigo= idBySlug($pdo, 'inox');
$idTermica   = idBySlug($pdo, 'termica');
$idAsfaltica = idBySlug($pdo, 'asfaltica');
$idVegetal   = idBySlug($pdo, 'vegetal');
$idAluminio  = idBySlug($pdo, 'aluminio');
$idGraneleiro= idBySlug($pdo, 'graneleiro');
$idSider     = idBySlug($pdo, 'sider');

if ($idAco && $idAcoInox) {
    $pdo->prepare('UPDATE categorias SET parent_id = ?, ordem = 1 WHERE id = ?')->execute([$idAco, $idAcoInox]);
    echo "[cat] Aço Inox virou filha de Aço\n";
}
if ($idAco && $idAcoCarb) {
    $pdo->prepare('UPDATE categorias SET parent_id = ?, ordem = 2 WHERE id = ?')->execute([$idAco, $idAcoCarb]);
    echo "[cat] Aço Carbono virou filha de Aço\n";
}

/* Garante ordens dos parents */
$ordens = [
    'aco'        => 10,
    'termica'    => 20,
    'aluminio'   => 30,
    'graneleiro' => 40,
    'sider'      => 50,
];
foreach ($ordens as $slug => $ord) {
    $pdo->prepare('UPDATE categorias SET ordem = ?, parent_id = 0, ativo = 1 WHERE slug = ?')->execute([$ord, $slug]);
}

/* ----------------------------------------------------------------------
 * 2) Remover categorias antigas vazias (Inox e Vegetal do seed inicial)
 *    Só remove se não tiverem produtos e nem filhas.
 * ---------------------------------------------------------------------- */
foreach (['inox' => $idInoxAntigo, 'vegetal' => $idVegetal] as $slug => $cid) {
    if (!$cid) continue;
    $hasProd = (int) $pdo->query("SELECT COUNT(*) FROM produtos WHERE categoria_id = {$cid}")->fetchColumn();
    $hasChild = (int) $pdo->query("SELECT COUNT(*) FROM categorias WHERE parent_id = {$cid}")->fetchColumn();
    if ($hasProd === 0 && $hasChild === 0) {
        $pdo->prepare('DELETE FROM categorias WHERE id = ?')->execute([$cid]);
        echo "[cat] removida (vazia): {$slug}\n";
    } else {
        echo "[cat] mantida (tem vínculos): {$slug}\n";
    }
}

/* ----------------------------------------------------------------------
 * 3) Marca produtos importados como destaque (pronta entrega/disponíveis)
 *    para alimentar "Equipamentos Disponíveis" na home.
 * ---------------------------------------------------------------------- */
$upd = $pdo->prepare("UPDATE produtos SET destaque = 1 WHERE status IN ('disponivel','pronta_entrega') AND destaque = 0");
$upd->execute();
$marcados = $upd->rowCount();
echo "[prod] marcados como destaque: {$marcados}\n";

/* ----------------------------------------------------------------------
 * 4) Resumo
 * ---------------------------------------------------------------------- */
echo "\n==== Categorias atuais ====\n";
$stmt = $pdo->query("
    SELECT c.id, c.nome, c.slug, c.parent_id, c.ordem,
           (SELECT COUNT(*) FROM produtos p WHERE p.categoria_id = c.id) AS qtd
    FROM categorias c
    ORDER BY (c.parent_id = 0) DESC, c.parent_id ASC, c.ordem ASC
");
foreach ($stmt as $r) {
    $pad = $r['parent_id'] == 0 ? '' : '  └ ';
    echo str_pad($r['id'], 4) . " {$pad}{$r['nome']} (slug={$r['slug']}, parent={$r['parent_id']}, produtos={$r['qtd']})\n";
}

echo "\nOK.\n";
