<?php
// ARQUIVO TEMPORÁRIO — REMOVA APÓS USO
if ($_SERVER['REQUEST_METHOD'] !== 'GET' || ($_GET['token'] ?? '') !== 'inovatanque_migrate_2026') {
    http_response_code(403);
    exit('Acesso negado.');
}

require_once __DIR__ . '/../config/database.php';
$pdo = new PDO(
    'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
    DB_USER, DB_PASS,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$sqls = [
    "ALTER TABLE banners ADD COLUMN IF NOT EXISTS tipo ENUM('cor_texto','imagem_texto','imagem_link') NOT NULL DEFAULT 'cor_texto' AFTER id",
    "ALTER TABLE banners ADD COLUMN IF NOT EXISTS cor_fundo VARCHAR(7) DEFAULT '#1a1a1a' AFTER tipo",
    "ALTER TABLE banners ADD COLUMN IF NOT EXISTS subtitulo TEXT DEFAULT NULL AFTER titulo",
    "ALTER TABLE banners ADD COLUMN IF NOT EXISTS cta_texto VARCHAR(100) DEFAULT NULL AFTER subtitulo",
    "ALTER TABLE banners ADD COLUMN IF NOT EXISTS cta_link VARCHAR(255) DEFAULT NULL AFTER cta_texto",
    "ALTER TABLE banners ADD COLUMN IF NOT EXISTS link VARCHAR(255) DEFAULT NULL AFTER cta_link",
];

echo "<pre>Executando migração...\n\n";
foreach ($sqls as $sql) {
    try {
        $pdo->exec($sql);
        echo "✅ OK: " . substr($sql, 0, 80) . "...\n";
    } catch (PDOException $e) {
        echo "⚠️  " . $e->getMessage() . "\n";
    }
}

$cols = $pdo->query("SHOW COLUMNS FROM banners")->fetchAll(PDO::FETCH_COLUMN);
echo "\nColunas atuais: " . implode(', ', $cols) . "\n";
echo "\n✅ Migração concluída. REMOVA este arquivo do servidor!\n</pre>";
