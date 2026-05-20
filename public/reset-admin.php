<?php
/**
 * Debug: testa upload de imagem
 */
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/database.php';
require_once APP_ROOT . '/app/core/Autoload.php';
require_once APP_ROOT . '/app/helpers/functions.php';

echo "<pre>";
echo "=== Debug Upload ===\n\n";

// Verifica diretório
$dir = APP_ROOT . '/public/uploads/produtos';
echo "Diretório: $dir\n";
echo "Existe: " . (is_dir($dir) ? 'SIM' : 'NAO') . "\n";

if (!is_dir($dir)) {
    $result = mkdir($dir, 0755, true);
    echo "Criado: " . ($result ? 'SIM' : 'FALHOU') . "\n";
}

echo "Permissão: " . substr(sprintf('%o', fileperms(APP_ROOT . '/public/uploads')), -4) . "\n";
echo "Writable uploads: " . (is_writable(APP_ROOT . '/public/uploads') ? 'SIM' : 'NAO') . "\n";

if (is_dir($dir)) {
    echo "Writable produtos: " . (is_writable($dir) ? 'SIM' : 'NAO') . "\n";
}

// Verifica últimos produtos e imagens
$pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

echo "\n=== Últimos 3 produtos ===\n";
$stmt = $pdo->query("SELECT id, titulo, slug FROM produtos ORDER BY id DESC LIMIT 3");
foreach ($stmt->fetchAll() as $p) {
    echo "ID: {$p['id']} | {$p['titulo']} | slug: {$p['slug']}\n";

    $imgs = $pdo->prepare("SELECT * FROM produto_imagens WHERE produto_id = ?");
    $imgs->execute([$p['id']]);
    $imagens = $imgs->fetchAll();
    if (empty($imagens)) {
        echo "  -> SEM IMAGENS\n";
    } else {
        foreach ($imagens as $img) {
            $fullPath = APP_ROOT . '/public/' . $img['arquivo'];
            echo "  -> {$img['arquivo']} | principal: {$img['principal']} | existe no disco: " . (file_exists($fullPath) ? 'SIM' : 'NAO') . "\n";
        }
    }
}

echo "\n=== Upload max ===\n";
echo "upload_max_filesize: " . ini_get('upload_max_filesize') . "\n";
echo "post_max_size: " . ini_get('post_max_size') . "\n";
echo "</pre>";

echo "<br><strong style='color:red;'>APAGUE ESTE ARQUIVO!</strong>";
