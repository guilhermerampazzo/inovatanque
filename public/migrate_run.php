<?php
if (($_GET['token'] ?? '') !== 'inovatanque_migrate_2026') { http_response_code(403); die('Forbidden'); }
header('Content-Type: text/html; charset=utf-8');
try {
    $pdo = new PDO('mysql:host=localhost;dbname=inova;charset=utf8mb4', 'inova', 'XDxbLEmy7HyRnmkL', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // 1. Mostrar estrutura atual da coluna tipo
    echo "<h3>Estado ANTES:</h3><pre>";
    foreach ($pdo->query("SHOW COLUMNS FROM banners WHERE Field='tipo'")->fetchAll(PDO::FETCH_ASSOC) as $col) {
        echo htmlspecialchars(json_encode($col)) . "\n";
    }
    echo "</pre>";

    // 2. Normaliza valores antigos que nao existem no novo enum (evita truncate)
    $pdo->exec("UPDATE banners SET tipo='cor_texto' WHERE tipo NOT IN ('cor_texto','imagem_texto','imagem_link')");

    // 3. Garante colunas
    $sqls = [
        "ALTER TABLE banners ADD COLUMN IF NOT EXISTS tipo VARCHAR(20) NOT NULL DEFAULT 'cor_texto' AFTER id",
        "UPDATE banners SET tipo='cor_texto' WHERE tipo NOT IN ('cor_texto','imagem_texto','imagem_link')",
        "ALTER TABLE banners MODIFY COLUMN tipo ENUM('cor_texto','imagem_texto','imagem_link') NOT NULL DEFAULT 'cor_texto'",
        "ALTER TABLE banners ADD COLUMN IF NOT EXISTS cor_fundo VARCHAR(100) NULL AFTER tipo",
        "ALTER TABLE banners ADD COLUMN IF NOT EXISTS subtitulo VARCHAR(255) NULL AFTER titulo",
        "ALTER TABLE banners ADD COLUMN IF NOT EXISTS cta_texto VARCHAR(100) NULL AFTER subtitulo",
        "ALTER TABLE banners ADD COLUMN IF NOT EXISTS cta_link VARCHAR(255) NULL AFTER cta_texto",
        "ALTER TABLE banners ADD COLUMN IF NOT EXISTS link VARCHAR(255) NULL AFTER cta_link",
    ];
    foreach ($sqls as $sql) {
        try { $pdo->exec($sql); echo "<p style='color:green'>OK: ".htmlspecialchars($sql)."</p>"; }
        catch (Exception $e) { echo "<p style='color:orange'>SKIP: ".htmlspecialchars($sql)." => ".htmlspecialchars($e->getMessage())."</p>"; }
    }

    // 4. Estado final
    echo "<h3>Estado DEPOIS:</h3><pre>";
    foreach ($pdo->query("SHOW COLUMNS FROM banners")->fetchAll(PDO::FETCH_ASSOC) as $col) {
        echo htmlspecialchars($col['Field'] . " — " . $col['Type']) . "\n";
    }
    echo "</pre>";

    echo "<h2 style='color:green'>Migracao concluida! DELETE ESTE ARQUIVO.</h2>";
} catch (Exception $e) { echo "<p style='color:red'>ERRO: ".htmlspecialchars($e->getMessage())."</p>"; }
