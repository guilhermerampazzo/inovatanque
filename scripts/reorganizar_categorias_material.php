<?php
/**
 * Reorganiza a hierarquia de categorias de MATERIAL para o formato pedido pelo cliente:
 *
 *   Aço (pai)
 *     └ Aço Carbono
 *     └ Aço Inox
 *   Térmica (pai)
 *     └ Vegetal
 *     └ Asfáltica
 *   Sider (pai, sem filhos)
 *   Alumínio (pai, sem filhos)
 *   Graneleiro (pai, sem filhos)
 *
 * Hoje o banco tem "muitos pais e poucos filhos" (categorias soltas no nível raiz
 * que deveriam ser subcategorias de Aço/Térmica). Este script:
 *  - Garante que os 5 pais acima existem, ativos, com a ordem correta.
 *  - Garante que as 4 subcategorias (Aço Carbono, Aço Inox, Vegetal, Asfáltica) existem
 *    como filhas do pai certo.
 *  - Qualquer categoria "solta" cujo nome bata com essas subcategorias (ex: "Carbono",
 *    "Inox" avulsos) tem seus produtos migrados para a subcategoria canônica e é removida.
 *  - Qualquer categoria que hoje seja filha de Sider/Alumínio/Graneleiro é "achatada":
 *    produtos migram para o pai e a filha é removida (esses 3 não devem ter filhos).
 *  - Categorias que sobrarem sem mapeamento claro NÃO são alteradas — apenas listadas
 *    no resumo final para revisão manual.
 *
 * Uso (CLI):
 *   php scripts/reorganizar_categorias_material.php
 *   php scripts/reorganizar_categorias_material.php --dry-run
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

$dryRun = in_array('--dry-run', $argv, true);

$pdo = Database::connect();

function slugify(string $texto): string
{
    $texto = trim($texto);
    $texto = iconv('UTF-8', 'ASCII//TRANSLIT', $texto);
    $texto = strtolower($texto);
    $texto = preg_replace('/[^a-z0-9]+/', '-', $texto);
    return trim($texto, '-');
}

function findBySlug(PDO $pdo, string $slug): ?array
{
    $stmt = $pdo->prepare('SELECT * FROM categorias WHERE slug = ?');
    $stmt->execute([$slug]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function ensureCategoria(PDO $pdo, bool $dryRun, string $slug, string $nome, int $parentId, int $ordem): int
{
    $existing = findBySlug($pdo, $slug);
    if ($existing) {
        if ($existing['nome'] !== $nome || (int)$existing['parent_id'] !== $parentId || (int)$existing['ordem'] !== $ordem || (int)$existing['ativo'] !== 1) {
            echo "[cat] ajustando '{$nome}' (slug={$slug}): parent {$existing['parent_id']}->{$parentId}, ordem {$existing['ordem']}->{$ordem}\n";
            if (!$dryRun) {
                $pdo->prepare('UPDATE categorias SET nome = ?, parent_id = ?, ordem = ?, ativo = 1 WHERE id = ?')
                    ->execute([$nome, $parentId, $ordem, $existing['id']]);
            }
        }
        return (int) $existing['id'];
    }

    echo "[cat] criando '{$nome}' (slug={$slug}, parent={$parentId})\n";
    if ($dryRun) {
        return -1;
    }
    $pdo->prepare('INSERT INTO categorias (nome, slug, parent_id, ordem, ativo) VALUES (?, ?, ?, ?, 1)')
        ->execute([$nome, $slug, $parentId, $ordem]);
    return (int) $pdo->lastInsertId();
}

/**
 * Move produtos e (se houver) filhas de $fromId para $toId, depois apaga $fromId.
 * Usado para consolidar categorias soltas/duplicadas na categoria canônica.
 */
function mergeCategoria(PDO $pdo, bool $dryRun, array $from, int $toId): void
{
    $fromId = (int) $from['id'];
    if ($fromId === $toId) {
        return;
    }

    $stmtQtd = $pdo->prepare('SELECT COUNT(*) FROM produtos WHERE categoria_id = ?');
    $stmtQtd->execute([$fromId]);
    $qtdProd = (int) $stmtQtd->fetchColumn();

    echo "[merge] '{$from['nome']}' (id={$fromId}) -> id={$toId} ({$qtdProd} produto(s))\n";

    if ($dryRun) {
        return;
    }

    $pdo->prepare('UPDATE produtos SET categoria_id = ? WHERE categoria_id = ?')->execute([$toId, $fromId]);
    $pdo->prepare('UPDATE categorias SET parent_id = ? WHERE parent_id = ?')->execute([$toId, $fromId]);
    $pdo->prepare('DELETE FROM categorias WHERE id = ?')->execute([$fromId]);
}

/* ----------------------------------------------------------------------
 * 1) Garantir os 5 pais + 4 filhos canônicos
 * ---------------------------------------------------------------------- */
$idAco = ensureCategoria($pdo, $dryRun, 'aco', 'Aço', 0, 10);
$idTermica = ensureCategoria($pdo, $dryRun, 'termica', 'Térmica', 0, 20);
$idSider = ensureCategoria($pdo, $dryRun, 'sider', 'Sider', 0, 30);
$idAluminio = ensureCategoria($pdo, $dryRun, 'aluminio', 'Alumínio', 0, 40);
$idGraneleiro = ensureCategoria($pdo, $dryRun, 'graneleiro', 'Graneleiro', 0, 50);

$idAcoCarbono = ensureCategoria($pdo, $dryRun, 'aco-carbono', 'Aço Carbono', $idAco, 1);
$idAcoInox = ensureCategoria($pdo, $dryRun, 'aco-inox', 'Aço Inox', $idAco, 2);
$idVegetal = ensureCategoria($pdo, $dryRun, 'vegetal', 'Vegetal', $idTermica, 1);
$idAsfaltica = ensureCategoria($pdo, $dryRun, 'asfaltica', 'Asfáltica', $idTermica, 2);

/* ----------------------------------------------------------------------
 * 2) Consolidar categorias soltas que deveriam ser filhas de Aço/Térmica
 *    (busca por nome, ignorando as canônicas já tratadas acima)
 * ---------------------------------------------------------------------- */
$mapaFilhos = [
    $idAcoCarbono => ['carbono'],
    $idAcoInox    => ['inox'],
    $idVegetal    => ['vegetal'],
    $idAsfaltica  => ['asfalt'],
];
$canonicos = [$idAco, $idTermica, $idSider, $idAluminio, $idGraneleiro, $idAcoCarbono, $idAcoInox, $idVegetal, $idAsfaltica];

$todas = $pdo->query('SELECT * FROM categorias')->fetchAll();
foreach ($todas as $cat) {
    $catId = (int) $cat['id'];
    if (in_array($catId, $canonicos, true)) {
        continue;
    }
    $nomeLower = mb_strtolower($cat['nome']);
    foreach ($mapaFilhos as $destino => $palavras) {
        foreach ($palavras as $p) {
            if (str_contains($nomeLower, $p)) {
                mergeCategoria($pdo, $dryRun, $cat, $destino);
                continue 3;
            }
        }
    }
}

/* ----------------------------------------------------------------------
 * 3) Achatar Sider / Alumínio / Graneleiro: eles não devem ter filhas.
 * ---------------------------------------------------------------------- */
foreach ([$idSider => 'Sider', $idAluminio => 'Alumínio', $idGraneleiro => 'Graneleiro'] as $pai => $nomePai) {
    $stmt = $pdo->prepare('SELECT * FROM categorias WHERE parent_id = ?');
    $stmt->execute([$pai]);
    foreach ($stmt->fetchAll() as $filha) {
        echo "[flatten] '{$filha['nome']}' era filha de {$nomePai}, produtos migrados para {$nomePai} e categoria removida\n";
        mergeCategoria($pdo, $dryRun, $filha, $pai);
    }
}

/* ----------------------------------------------------------------------
 * 4) Resumo final
 * ---------------------------------------------------------------------- */
echo "\n==== Categorias após reorganização" . ($dryRun ? ' (DRY-RUN, nada foi gravado)' : '') . " ====\n";
$stmt = $pdo->query("
    SELECT c.id, c.nome, c.slug, c.parent_id, c.ordem,
           (SELECT COUNT(*) FROM produtos p WHERE p.categoria_id = c.id) AS qtd
    FROM categorias c
    ORDER BY (c.parent_id = 0) DESC, c.parent_id ASC, c.ordem ASC
");
$naoMapeadas = [];
foreach ($stmt as $r) {
    $pad = $r['parent_id'] == 0 ? '' : '  └ ';
    echo str_pad($r['id'], 4) . " {$pad}{$r['nome']} (slug={$r['slug']}, parent={$r['parent_id']}, produtos={$r['qtd']})\n";
    if (!$dryRun && !in_array((int) $r['id'], $canonicos, true)) {
        $naoMapeadas[] = $r['nome'];
    }
}

if ($naoMapeadas) {
    echo "\n[aviso] Categorias que não bateram com nenhuma regra automática e ficaram como estavam:\n";
    foreach ($naoMapeadas as $n) {
        echo "  - {$n}\n";
    }
    echo "Revise manualmente pelo admin (/admin/categorias) se alguma delas deveria virar filha de Aço/Térmica.\n";
}

echo "\nOK.\n";
