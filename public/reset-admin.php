<?php
/**
 * Script temporário para resetar senha do admin.
 * APAGUE ESTE ARQUIVO APÓS USAR.
 */
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/database.php';

$pdo = new PDO(
    'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET,
    DB_USER,
    DB_PASS
);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$novaSenha = password_hash('admin123', PASSWORD_DEFAULT);

// Mostra info do admin
$stmt = $pdo->query("SELECT * FROM admins LIMIT 1");
$admin = $stmt->fetch();

if ($admin) {
    // Força update de senha E ativo
    $update = $pdo->prepare("UPDATE admins SET senha = ?, ativo = 1 WHERE id = ?");
    $update->execute([$novaSenha, $admin['id']]);

    echo "<pre>";
    echo "Admin encontrado:\n";
    echo "ID: " . $admin['id'] . "\n";
    echo "Email: " . $admin['email'] . "\n";
    echo "Ativo: " . $admin['ativo'] . "\n";
    echo "Role: " . $admin['role'] . "\n";
    echo "Tamanho coluna senha: " . strlen($admin['senha']) . "\n";
    echo "\nNova hash gerada: " . $novaSenha . "\n";
    echo "Tamanho nova hash: " . strlen($novaSenha) . "\n";
    echo "\nVerificação: " . (password_verify('admin123', $novaSenha) ? 'OK' : 'FALHOU') . "\n";
    echo "</pre>";
    echo "<br><strong>Senha resetada e ativo = 1. Tente logar com:</strong><br>";
    echo "Email: " . $admin['email'] . "<br>";
    echo "Senha: admin123<br><br>";
} else {
    $insert = $pdo->prepare("INSERT INTO admins (nome, email, senha, role, ativo) VALUES (?, ?, ?, ?, ?)");
    $insert->execute(['Administrador', 'admin@inovatanque.com.br', $novaSenha, 'admin', 1]);
    echo "Admin criado!<br>Email: admin@inovatanque.com.br<br>Senha: admin123<br>";
}

echo "<br><strong style='color:red;'>APAGUE ESTE ARQUIVO DO SERVIDOR AGORA!</strong>";
