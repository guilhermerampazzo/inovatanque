<?php
/**
 * Script temporário para resetar senha do admin.
 * APAGUE ESTE ARQUIVO APÓS USAR.
 */
require_once __DIR__ . '/../bootstrap.php';

$db = Database::getInstance();
$novaSenha = password_hash('admin123', PASSWORD_DEFAULT);

// Verifica se existe admin
$stmt = $db->query("SELECT id, email FROM admins LIMIT 1");
$admin = $stmt->fetch();

if ($admin) {
    $update = $db->prepare("UPDATE admins SET senha = ? WHERE id = ?");
    $update->execute([$novaSenha, $admin['id']]);
    echo "Senha resetada com sucesso!<br>";
    echo "Email: " . $admin['email'] . "<br>";
    echo "Nova senha: admin123<br><br>";
} else {
    // Cria admin se não existir
    $insert = $db->prepare("INSERT INTO admins (nome, email, senha, role, ativo) VALUES (?, ?, ?, ?, ?)");
    $insert->execute(['Administrador', 'admin@inovatanque.com.br', $novaSenha, 'admin', 1]);
    echo "Admin criado com sucesso!<br>";
    echo "Email: admin@inovatanque.com.br<br>";
    echo "Senha: admin123<br><br>";
}

echo "<strong style='color:red;'>APAGUE ESTE ARQUIVO DO SERVIDOR AGORA!</strong>";
