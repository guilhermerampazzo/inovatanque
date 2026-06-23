<?php
// Script temporario de migration — APAGAR APOS USO
require_once __DIR__ . '/../config/database.php';

$sqls = [
    "UPDATE categorias SET nome = 'Aço Inox', parent_id = 1, ordem = 1 WHERE slug = 'inox'",
    "UPDATE categorias SET parent_id = 1, ordem = 2 WHERE slug = 'aco-carbono'",
];

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
        DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    echo "<h2>Migration: Hierarquia de Categorias</h2><pre>";

    // Estado antes
    echo "=== ANTES ===\n";
    foreach ($pdo->query("SELECT id, nome, slug, parent_id FROM categorias ORDER BY id")->fetchAll(PDO::FETCH_ASSOC) as $row) {
        echo implode(" | ", $row) . "\n";
    }

    // Executa
    echo "\n=== EXECUTANDO ===\n";
    foreach ($sqls as $sql) {
        $affected = $pdo->exec($sql);
        echo "OK ({$affected} linha(s)): $sql\n";
    }

    // Estado depois
    echo "\n=== DEPOIS ===\n";
    foreach ($pdo->query("SELECT id, nome, slug, parent_id FROM categorias ORDER BY id")->fetchAll(PDO::FETCH_ASSOC) as $row) {
        echo implode(" | ", $row) . "\n";
    }

    echo "\n✅ Migration concluida com sucesso!\n";
    echo "</pre>";

} catch (Exception $e) {
    echo "<pre>❌ ERRO: " . htmlspecialchars($e->getMessage()) . "</pre>";
}
