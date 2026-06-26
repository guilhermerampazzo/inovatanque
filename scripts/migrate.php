<?php
/**
 * Roda migrações SQL pendentes.
 *
 * Uso (CLI):
 *   php scripts/migrate.php
 *
 * Ou via web (protegido por token):
 *   https://seusite.com.br/scripts/migrate.php?token=MIGRAR2025
 */

// Proteção web
$webToken = 'MIGRAR2025';
if (PHP_SAPI !== 'cli') {
    if (($_GET['token'] ?? '') !== $webToken) {
        http_response_code(403);
        die("Acesso negado. Use ?token={$webToken} ou execute via CLI.\n");
    }
    header('Content-Type: text/plain; charset=utf-8');
}

define('APP_ROOT', dirname(__DIR__));
require APP_ROOT . '/config/app.php';
require APP_ROOT . '/config/database.php';
require APP_ROOT . '/app/core/Autoload.php';

$pdo = Database::connect();

// ─── Cria tabela de controle de migrações se não existir ────────────────────
$pdo->exec("CREATE TABLE IF NOT EXISTS _migrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL UNIQUE,
    executada_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB");

// ─── Lista de migrações em ordem de execução ────────────────────────────────
$migracoes = [

    'add_banner_duracao' => "
        ALTER TABLE banners
        ADD COLUMN IF NOT EXISTS duracao INT NOT NULL DEFAULT 5000
        AFTER ordem;
    ",

    'add_produto_externo_id' => "
        ALTER TABLE produtos
        ADD COLUMN IF NOT EXISTS externo_id VARCHAR(100) DEFAULT NULL AFTER codigo,
        ADD COLUMN IF NOT EXISTS externo_fonte VARCHAR(50) DEFAULT NULL AFTER externo_id;
    ",

    'add_produto_hidden' => "
        ALTER TABLE produtos
        MODIFY COLUMN status ENUM('disponivel','pronta_entrega','locado','vendido','oculto')
        NOT NULL DEFAULT 'disponivel';
    ",

    'categorias_hierarquia' => "
        INSERT IGNORE INTO categorias (nome, slug, parent_id, ordem, ativo) VALUES
            ('Aço',        'aco',        0, 10, 1),
            ('Térmica',    'termica',    0, 20, 1),
            ('Sider',      'sider',      0, 30, 1),
            ('Alumínio',   'aluminio',   0, 40, 1),
            ('Graneleiro', 'graneleiro', 0, 50, 1);

        -- Torna Carbono e Inox filhos de Aço
        UPDATE categorias SET parent_id = (SELECT id FROM (SELECT id FROM categorias WHERE slug='aco') x)
        WHERE slug IN ('aco-carbono','aco-inox');

        -- Torna Vegetal e Asfáltica filhas de Térmica
        UPDATE categorias SET parent_id = (SELECT id FROM (SELECT id FROM categorias WHERE slug='termica') x)
        WHERE slug IN ('asfaltica','vegetal');
    ",

];

// ─── Executa ─────────────────────────────────────────────────────────────────
$executadas = 0;
$puladas    = 0;
$erros      = 0;

foreach ($migracoes as $nome => $sql) {
    // Verifica se já foi executada
    $stmt = $pdo->prepare("SELECT id FROM _migrations WHERE nome = ?");
    $stmt->execute([$nome]);
    if ($stmt->fetch()) {
        echo "[PULADA]  {$nome}\n";
        $puladas++;
        continue;
    }

    echo "[RODANDO] {$nome} ...\n";

    try {
        // Executa cada statement separadamente
        $statements = array_filter(array_map('trim', explode(';', $sql)));
        foreach ($statements as $statement) {
            if ($statement !== '') {
                $pdo->exec($statement);
            }
        }

        // Registra como executada
        $ins = $pdo->prepare("INSERT INTO _migrations (nome) VALUES (?)");
        $ins->execute([$nome]);

        echo "[OK]      {$nome}\n";
        $executadas++;
    } catch (PDOException $e) {
        echo "[ERRO]    {$nome}: " . $e->getMessage() . "\n";
        $erros++;
    }
}

echo "\n";
echo "────────────────────────────────────\n";
echo "Executadas: {$executadas} | Puladas: {$puladas} | Erros: {$erros}\n";
echo "────────────────────────────────────\n";
