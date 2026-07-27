<?php
/**
 * Migration da tabela PRODUTOS (executável via navegador).
 *
 *   1) Adiciona a coluna produtos.carroceria (nível intermediário do menu:
 *      Implemento > Carroceria > Material).
 *   2) Backfill: para produtos já existentes sem carroceria preenchida,
 *      deriva Implemento/Carroceria a partir do título (sem depender da
 *      API da Loja Integrada — roda direto sobre o banco local).
 *
 * USO (protegido por token):
 *   https://seusite.com.br/migrate_produtos.php?token=INOVA2025
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
require_once __DIR__ . '/../app/helpers/produto_parser.php';

header('Content-Type: text/html; charset=utf-8');
echo "<pre style='font:14px/1.5 monospace;padding:24px;background:#111;color:#eee'>";
echo "== Migration da tabela produtos" . ($dryRun ? " (DRY-RUN — nada será gravado)" : "") . " ==\n\n";

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
        DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );

    $colunas = $pdo->query("SHOW COLUMNS FROM produtos")->fetchAll();
    $existe = fn(string $col): bool => in_array($col, array_column($colunas, 'Field'), true);

    $migrations = [
        'carroceria' => "ALTER TABLE produtos ADD COLUMN carroceria VARCHAR(100) DEFAULT NULL AFTER configuracao",
    ];

    foreach ($migrations as $coluna => $sql) {
        if ($existe($coluna)) {
            echo "[ok] coluna '{$coluna}' já existe, nada a fazer\n";
            continue;
        }
        echo "[cria] coluna '{$coluna}'\n  SQL: {$sql}\n";
        if ($dryRun) continue;
        $pdo->exec($sql);
        echo "  -> criada com sucesso\n";
    }

    echo "\n== Backfill de Implemento/Carroceria (produtos sem carroceria) ==\n";
    $produtos = $pdo->query("SELECT id, titulo, configuracao, carroceria FROM produtos WHERE carroceria IS NULL OR carroceria = ''")->fetchAll();
    if (empty($produtos)) {
        echo "Nenhum produto pendente — todos já têm carroceria preenchida.\n";
    } else {
        $upd = $pdo->prepare("UPDATE produtos SET configuracao = ?, carroceria = ? WHERE id = ?");
        foreach ($produtos as $p) {
            $parsed = parse_implemento_carroceria($p['titulo']);
            $config = $parsed['config'] ?: $p['configuracao'];
            $carroceria = $parsed['carroceria'];
            echo "[{$p['id']}] {$p['titulo']}\n  -> implemento: " . ($config ?: '(nao identificado)') . " | carroceria: {$carroceria}\n";
            if (!$dryRun) {
                $upd->execute([$config, $carroceria, $p['id']]);
            }
        }
        echo "\nTotal processado: " . count($produtos) . "\n";
    }

    echo "\n== Colunas atuais da tabela produtos ==\n";
    foreach ($pdo->query("SHOW COLUMNS FROM produtos")->fetchAll() as $col) {
        echo str_pad($col['Field'], 20) . " " . $col['Type'] . "\n";
    }

    echo "\n✅ Concluído" . ($dryRun ? " (dry-run)" : "") . ". APAGUE este arquivo do servidor após o uso.\n";
} catch (Exception $e) {
    echo "❌ ERRO: " . htmlspecialchars($e->getMessage()) . "\n";
}
echo "</pre>";
