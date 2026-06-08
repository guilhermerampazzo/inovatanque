<?php $pageTitle = 'Cliente: ' . sanitize($cliente['nome_razao']); ?>
<?php require APP_ROOT . '/app/views/admin/header.php'; ?>

<div class="admin-header">
    <h1><?= sanitize($cliente['nome_razao']) ?></h1>
    <a href="/admin/clientes" class="btn btn-secondary">Voltar</a>
</div>

<div style="max-width: 600px; margin-bottom: 48px;">
    <table class="produto-specs">
        <tr><td>Tipo</td><td><?= $cliente['tipo'] === 'pj' ? 'Pessoa Jurídica' : 'Pessoa Física' ?></td></tr>
        <tr><td>CPF/CNPJ</td><td><?= sanitize($cliente['cpf_cnpj'] ?? '-') ?></td></tr>
        <tr><td>E-mail</td><td><?= sanitize($cliente['email']) ?></td></tr>
        <tr><td>Telefone</td><td><?= sanitize($cliente['telefone'] ?? '-') ?></td></tr>
        <tr><td>WhatsApp</td><td><?= sanitize($cliente['whatsapp'] ?? '-') ?></td></tr>
        <tr><td>Endereço</td><td><?= sanitize($cliente['endereco'] ?? '-') ?>, <?= sanitize($cliente['cidade'] ?? '') ?>/<?= sanitize($cliente['uf'] ?? '') ?></td></tr>
        <tr><td>Cadastro</td><td><?= date('d/m/Y H:i', strtotime($cliente['created_at'])) ?></td></tr>
        <tr><td>Status</td><td><?= $cliente['ativo'] ? 'Ativo' : 'Inativo' ?></td></tr>
    </table>
</div>

<?php if (!empty($cotacoes)): ?>
    <h2 style="font-family: var(--font); font-size: 20px; font-weight: 600; color: var(--color-accent); margin-bottom: 16px;">Cotações deste cliente</h2>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Produto</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cotacoes as $cot): ?>
                    <tr>
                        <td><?= date('d/m/Y', strtotime($cot['created_at'])) ?></td>
                        <td><?= $cot['produto_id'] ? '#' . $cot['produto_id'] : '-' ?></td>
                        <td><span class="status-badge status-<?= $cot['status'] ?>"><?= ucfirst(str_replace('_', ' ', $cot['status'])) ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php require APP_ROOT . '/app/views/admin/footer.php'; ?>
