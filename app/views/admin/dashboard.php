<?php $pageTitle = 'Dashboard'; ?>
<?php require APP_ROOT . '/app/views/admin/header.php'; ?>

<div class="admin-header">
    <h1>Dashboard</h1>
    <span style="font-size: 14px; color: var(--color-on-surface-variant); background: var(--color-surface); padding: 8px 16px; border-radius: 20px; border: 1px solid rgba(75,69,71,0.12);">👋 Olá, <?= Session::get('admin_nome') ?></span>
</div>

<div class="cliente-stats" style="margin-bottom: 40px;">
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

<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
    <h2 style="font-family: var(--font-display); font-size: 18px; font-weight: 600; color: var(--color-primary);">Últimas Cotações</h2>
    <a href="/admin/cotacoes" style="font-size: 13px; color: var(--color-gold); text-decoration: none;">Ver todas &rarr;</a>
</div>

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
                        <td><a href="/admin/cotacoes/<?= $cot['id'] ?>" style="color: var(--color-gold); font-weight: 500;"><?= sanitize($cot['nome']) ?></a></td>
                        <td><?= sanitize($cot['email']) ?></td>
                        <td><span class="status-badge status-<?= $cot['status'] ?>"><?= ucfirst(str_replace('_', ' ', $cot['status'])) ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div style="text-align: center; padding: 48px 24px; background: var(--color-surface); border-radius: 12px; border: 1px solid rgba(75,69,71,0.12);">
        <p style="color: var(--color-on-surface-variant); font-size: 15px;">Nenhuma cotação recebida ainda.</p>
    </div>
<?php endif; ?>

<?php require APP_ROOT . '/app/views/admin/footer.php'; ?>
