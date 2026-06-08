<?php
if (($_GET['token'] ?? '') !== 'inovatanque_migrate_2026') { http_response_code(403); die('Forbidden'); }
require_once __DIR__ . '/../app/core/config.php';
try {
    $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4', DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $sqls = [
        "ALTER TABLE banners ADD COLUMN IF NOT EXISTS tipo ENUM('image','color','gradient') NOT NULL DEFAULT 'color' AFTER id",
        "ALTER TABLE banners ADD COLUMN IF NOT EXISTS cor_fundo VARCHAR(100) NULL AFTER tipo",
        "ALTER TABLE banners ADD COLUMN IF NOT EXISTS subtitulo VARCHAR(255) NULL AFTER titulo",
        "ALTER TABLE banners ADD COLUMN IF NOT EXISTS cta_texto VARCHAR(100) NULL AFTER subtitulo",
        "ALTER TABLE banners ADD COLUMN IF NOT EXISTS cta_link VARCHAR(255) NULL AFTER cta_texto",
        "ALTER TABLE banners ADD COLUMN IF NOT EXISTS link VARCHAR(255) NULL AFTER cta_link",
    ];
    foreach ($sqls as $sql) { $pdo->exec($sql); echo "<p style='color:green'>OK: ".htmlspecialchars($sql)."</p>"; }
    echo "<h2 style='color:green'>Migracao concluida!</h2><p><strong>DELETE ESTE ARQUIVO AGORA.</strong></p>";
} catch (Exception $e) { echo "<p style='color:red'>ERRO: ".htmlspecialchars($e->getMessage())."</p>"; }
