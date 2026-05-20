<?php $pageTitle = 'Dashboard'; ?>
<?php require APP_ROOT . '/app/views/admin/header.php'; ?>

<div class="admin-header">
    <h1>Dashboard</h1>
    <span style="font-size: 14px; color: var(--color-text-secondary);">Olá, <?= Session::get('admin_nome') ?></span>
</div>

<div class="admin-stats">
    <div class="admin-stat-card stat-accent">
        <div class="stat-label">Cotações Novas</div>
        <div class="stat-number"><?= $cotacoesNovas ?></div>
    </div>
    <div class="admin-stat-card">
        <div class="stat-label">Total Cotações</div>
        <div class="stat-number"><?= $totalCotacoes ?></div>
    </div>
    <div class="admin-stat-card stat-success">
        <div class="stat-label">Clientes</div>
        <div class="stat-number"><?= $totalClientes ?></div>
    </div>
    <div class="admin-stat-card">
        <div class="stat-label">Produtos</div>
        <div class="stat-number"><?= $totalProdutos ?></div>
    </div>
</div>

<div class="admin-section-header">
    <h2>Últimas Cotações</h2>
    <a href="/admin/cotacoes">Ver todas &rarr;</a>
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
                        <td><a href="/admin/cotacoes/<?= $cot['id'] ?>"><?= sanitize($cot['nome']) ?></a></td>
                        <td><?= sanitize($cot['email']) ?></td>
                        <td><span class="status-badge status-<?= $cot['status'] ?>"><?= ucfirst(str_replace('_', ' ', $cot['status'])) ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div style="text-align: center; padding: 48px 24px; background: #fff; border-radius: 12px; box-shadow: var(--shadow-sm);">
        <p style="color: var(--color-text-secondary); font-size: 15px;">Nenhuma cotação recebida ainda.</p>
    </div>
<?php endif; ?>

<?php require APP_ROOT . '/app/views/admin/footer.php'; ?>
