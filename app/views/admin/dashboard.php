<?php $pageTitle = 'Dashboard'; ?>
<?php require APP_ROOT . '/app/views/admin/header.php'; ?>

<div class="admin-header">
    <h1>Dashboard</h1>
    <span style="font-size: 14px; color: var(--color-on-surface-variant);">Olá, <?= Session::get('admin_nome') ?></span>
</div>

<div class="cliente-stats" style="margin-bottom: 48px;">
    <div class="cliente-stat-card">
        <div class="number"><?= $cotacoesNovas ?></div>
        <div class="label">Cotações Novas</div>
    </div>
    <div class="cliente-stat-card">
        <div class="number"><?= $totalCotacoes ?></div>
        <div class="label">Total Cotações</div>
    </div>
    <div class="cliente-stat-card">
        <div class="number"><?= $totalClientes ?></div>
        <div class="label">Clientes</div>
    </div>
    <div class="cliente-stat-card">
        <div class="number"><?= $totalProdutos ?></div>
        <div class="label">Produtos</div>
    </div>
</div>

<h2 style="font-family: var(--font-display); font-size: 20px; font-weight: 600; color: var(--color-primary); margin-bottom: 16px;">Últimas Cotações</h2>

<?php if (!empty($ultimasCotacoes)): ?>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ultimasCotacoes as $cot): ?>
                    <tr>
                        <td><?= date('d/m/Y H:i', strtotime($cot['created_at'])) ?></td>
                        <td><a href="/admin/cotacoes/<?= $cot['id'] ?>" style="color: var(--color-gold);"><?= sanitize($cot['nome']) ?></a></td>
                        <td><?= sanitize($cot['email']) ?></td>
                        <td><span class="status-badge status-<?= $cot['status'] ?>"><?= ucfirst(str_replace('_', ' ', $cot['status'])) ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <p style="color: var(--color-on-surface-variant);">Nenhuma cotação recebida ainda.</p>
<?php endif; ?>

<?php require APP_ROOT . '/app/views/admin/footer.php'; ?>
