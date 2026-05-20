<?php
/**
 * Script temporário para debug de login admin.
 * APAGUE ESTE ARQUIVO APÓS USAR.
 */
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/database.php';
require_once APP_ROOT . '/app/core/Autoload.php';
require_once APP_ROOT . '/app/helpers/functions.php';

$pdo = new PDO(
    'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET,
    DB_USER,
    DB_PASS
);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$novaSenha = password_hash('admin123', PASSWORD_DEFAULT);

// Atualiza senha
$pdo->prepare("UPDATE admins SET senha = ?, ativo = 1 WHERE email = ?")->execute([$novaSenha, 'admin@inovatanque.com.br']);

// Simula exatamente o que o AdminAuthController faz
$adminModel = new Admin();
$admin = $adminModel->findBy('email', 'admin@inovatanque.com.br');

echo "<pre>";
echo "=== Simulação do login ===\n\n";
echo "findBy retornou: " . ($admin ? 'SIM' : 'NULL') . "\n";

if ($admin) {
    echo "ID: " . $admin['id'] . "\n";
    echo "Email: " . $admin['email'] . "\n";
    echo "Ativo: " . $admin['ativo'] . "\n";
    echo "Role: " . $admin['role'] . "\n";
    echo "Hash no banco: " . $admin['senha'] . "\n";
    echo "Tamanho hash: " . strlen($admin['senha']) . "\n\n";
    echo "password_verify('admin123', hash_do_banco): " . (password_verify('admin123', $admin['senha']) ? 'OK ✓' : 'FALHOU ✗') . "\n";
} else {
    echo "PROBLEMA: Admin não encontrado pelo Model!\n";
    echo "Verificando direto no PDO...\n";
    $stmt = $pdo->query("SELECT id, email, senha FROM admins WHERE email = 'admin@inovatanque.com.br'");
    $row = $stmt->fetch();
    echo "PDO encontrou: " . ($row ? 'SIM (id=' . $row['id'] . ')' : 'NÃO') . "\n";
}
echo "</pre>";

echo "<br><strong style='color:red;'>APAGUE ESTE ARQUIVO DO SERVIDOR!</strong>";
