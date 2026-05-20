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

// Verifica diretórios
$dirs = ['uploads', 'uploads/produtos', 'uploads/blog', 'uploads/editor'];
foreach ($dirs as $d) {
    $full = APP_ROOT . '/public/' . $d;
    $exists = is_dir($full);
    $writable = $exists ? is_writable($full) : false;
    $perms = $exists ? substr(sprintf('%o', fileperms($full)), -4) : '----';
    $owner = $exists ? posix_getpwuid(fileowner($full))['name'] ?? fileowner($full) : '-';
    echo "$d => existe: " . ($exists ? 'SIM' : 'NAO') . " | writable: " . ($writable ? 'SIM' : 'NAO') . " | perms: $perms | owner: $owner\n";
}

echo "\nPHP user: " . (function_exists('posix_getpwuid') ? posix_getpwuid(posix_geteuid())['name'] : get_current_user()) . "\n";

// Testa criar arquivo
echo "\n=== Teste de escrita ===\n";
$testFile = APP_ROOT . '/public/uploads/produtos/test_write.txt';
$result = @file_put_contents($testFile, 'test');
if ($result !== false) {
    echo "Escrita em uploads/produtos: OK\n";
    @unlink($testFile);
} else {
    echo "Escrita em uploads/produtos: FALHOU\n";
}

// Verifica produto e imagens
$pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

echo "\n=== Produto ID 1 ===\n";
$stmt = $pdo->query("SELECT id, titulo, slug FROM produtos WHERE id = 1");
$p = $stmt->fetch();
if ($p) {
    echo "Titulo: {$p['titulo']}\n";
    $imgs = $pdo->query("SELECT * FROM produto_imagens WHERE produto_id = 1");
    $imagens = $imgs->fetchAll();
    if (empty($imagens)) {
        echo "Imagens: NENHUMA no banco\n";
    } else {
        foreach ($imagens as $img) {
            $fullPath = APP_ROOT . '/public/' . $img['arquivo'];
            echo "  arquivo: {$img['arquivo']} | principal: {$img['principal']} | no disco: " . (file_exists($fullPath) ? 'SIM' : 'NAO') . "\n";
        }
    }
} else {
    echo "Produto ID 1 nao encontrado\n";
}

// Lista arquivos em uploads/produtos
$dir = APP_ROOT . '/public/uploads/produtos';
if (is_dir($dir)) {
    $files = array_diff(scandir($dir), ['.', '..']);
    echo "\nArquivos em uploads/produtos: " . count($files) . "\n";
    foreach (array_slice($files, 0, 5) as $f) {
        echo "  $f\n";
    }
}

echo "\nupload_max_filesize: " . ini_get('upload_max_filesize') . "\n";
echo "post_max_size: " . ini_get('post_max_size') . "\n";
echo "</pre>";

// Form de teste de upload
echo '<hr><h3>Teste de Upload Direto</h3>';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_FILES['teste'])) {
    echo '<pre>';
    echo "FILES recebido:\n";
    print_r($_FILES['teste']);
    $path = upload_image($_FILES['teste'], 'uploads/produtos');
    echo "\nResultado upload_image(): " . ($path ?: 'NULL (falhou)') . "\n";
    if ($path) {
        echo "Arquivo salvo em: " . APP_ROOT . '/public/' . $path . "\n";
        echo "Existe: " . (file_exists(APP_ROOT . '/public/' . $path) ? 'SIM' : 'NAO') . "\n";
    }
    echo '</pre>';
}
echo '<form method="POST" enctype="multipart/form-data">';
echo '<input type="file" name="teste" accept="image/*">';
echo '<button type="submit">Testar Upload</button>';
echo '</form>';

echo "<br><strong style='color:red;'>APAGUE ESTE ARQUIVO!</strong>";
