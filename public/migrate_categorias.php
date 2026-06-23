<?php
// Script temporario de migration — APAGAR APOS USO
require_once __DIR__ . '/../config/database.php';

$migrations = [
    'categorias_hierarquia' => [
        "UPDATE categorias SET nome = 'Aço Inox', parent_id = 1, ordem = 1 WHERE slug = 'inox'",
        "UPDATE categorias SET parent_id = 1, ordem = 2 WHERE slug = 'aco-carbono'",
    ],
    'paginas_imagem' => [
        "ALTER TABLE paginas ADD COLUMN IF NOT EXISTS imagem VARCHAR(255) DEFAULT NULL AFTER conteudo",
    ],
];

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
        DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    echo "<h2>Migrations Inova Tanque</h2><pre>";

    foreach ($migrations as $nome => $sqls) {
        echo "\n=== $nome ===\n";
        foreach ($sqls as $sql) {
            try {
                $affected = $pdo->exec($sql);
                echo "OK ({$affected} linha(s)): $sql\n";
            } catch (Exception $e) {
                echo "AVISO: " . $e->getMessage() . "\n  SQL: $sql\n";
            }
        }
    }

    echo "\n=== Estado das categorias ===\n";
    foreach ($pdo->query("SELECT id, nome, slug, parent_id FROM categorias ORDER BY id")->fetchAll(PDO::FETCH_ASSOC) as $row) {
        echo implode(" | ", $row) . "\n";
    }

    echo "\n=== Colunas da tabela paginas ===\n";
    foreach ($pdo->query("SHOW COLUMNS FROM paginas")->fetchAll(PDO::FETCH_ASSOC) as $col) {
        echo $col['Field'] . " (" . $col['Type'] . ")\n";
    }

    echo "\n✅ Migrations concluidas!\n";
    echo "</pre>";

} catch (Exception $e) {
    echo "<pre>❌ ERRO: " . htmlspecialchars($e->getMessage()) . "</pre>";
}
