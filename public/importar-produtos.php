<?php
/**
 * Runner WEB para importar produtos da Loja Integrada (Integrando.se).
 * Inclui os produtos OCULTOS/INATIVOS (os que faltam — locados etc.).
 *
 * USO (protegido por token):
 *   Teste (não grava):   https://seusite.com.br/importar-produtos.php?token=IMPORTAR2025&dry_run=1
 *   Diagnóstico da API:  https://seusite.com.br/importar-produtos.php?token=IMPORTAR2025&debug=1
 *   Importar de verdade: https://seusite.com.br/importar-produtos.php?token=IMPORTAR2025
 *
 * Reexecutar é seguro (idempotente): atualiza os existentes e cria os que faltam.
 * APAGAR ESTE ARQUIVO do servidor após o uso.
 */

if (($_GET['token'] ?? '') !== 'IMPORTAR2025') {
    http_response_code(403);
    die('Acesso negado. Use ?token=IMPORTAR2025');
}

// Repassa as opções para o script de sincronização (que roda em modo web):
$_GET['token']   = 'SYNC2025';   // token interno esperado pelo sync_integrandose.php
$_GET['ocultos'] = '1';          // <-- inclui inativos/ocultos (os que faltam)

if (!isset($_GET['dry_run'])) {
    // mantém como veio (presente = simula; ausente = grava)
}

@set_time_limit(0);
ignore_user_abort(true);

require __DIR__ . '/../scripts/sync_integrandose.php';
