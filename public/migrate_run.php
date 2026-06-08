<?php
if (($_GET['token'] ?? '') !== 'inovatanque_migrate_2026') { http_response_code(403); die('Forbidden'); }
header('Content-Type: text/html; charset=utf-8');
try {
    $pdo = new PDO('mysql:host=localhost;dbname=inova;charset=utf8mb4', 'inova', 'XDxbLEmy7HyRnmkL', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    echo "<h3>Estado ANTES:</h3><pre>";
    foreach ($pdo->query("SHOW COLUMNS FROM banners")->fetchAll(PDO::FETCH_ASSOC) as $col) {
        echo htmlspecialchars($col['Field'] . " — " . $col['Type']) . "\n";
    }
    echo "</pre>";

    $run = function($sql) use ($pdo) {
        try { $pdo->exec($sql); echo "<p style='color:green'>OK: ".htmlspecialchars($sql)."</p>"; }
        catch (Exception $e) { echo "<p style='color:orange'>SKIP: ".htmlspecialchars($sql)." => ".htmlspecialchars($e->getMessage())."</p>"; }
    };

    // Dropa a coluna tipo se existir (com enum errado) e recria do zero
    $run("ALTER TABLE banners DROP COLUMN tipo");
    $run("ALTER TABLE banners ADD COLUMN tipo ENUM('cor_texto','imagem_texto','imagem_link') NOT NULL DEFAULT 'cor_texto' AFTER id");

    // Demais colunas
    $run("ALTER TABLE banners ADD COLUMN IF NOT EXISTS cor_fundo VARCHAR(100) NULL AFTER tipo");
    $run("ALTER TABLE banners ADD COLUMN IF NOT EXISTS subtitulo VARCHAR(255) NULL AFTER titulo");
    $run("ALTER TABLE banners ADD COLUMN IF NOT EXISTS cta_texto VARCHAR(100) NULL AFTER subtitulo");
    $run("ALTER TABLE banners ADD COLUMN IF NOT EXISTS cta_link VARCHAR(255) NULL AFTER cta_texto");
    $run("ALTER TABLE banners ADD COLUMN IF NOT EXISTS link VARCHAR(255) NULL AFTER cta_link");

    echo "<h3>Estado DEPOIS:</h3><pre>";
    foreach ($pdo->query("SHOW COLUMNS FROM banners")->fetchAll(PDO::FETCH_ASSOC) as $col) {
        echo htmlspecialchars($col['Field'] . " — " . $col['Type']) . "\n";
    }
    echo "</pre>";

    echo "<h2 style='color:green'>Migracao concluida! DELETE ESTE ARQUIVO.</h2>";
} catch (Exception $e) { echo "<p style='color:red'>ERRO: ".htmlspecialchars($e->getMessage())."</p>"; }
