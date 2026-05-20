<?php $pageTitle = 'Cotações'; ?>
<?php require APP_ROOT . '/app/views/admin/header.php'; ?>

<div class="admin-header">
    <h1>Cotações / Leads</h1>
    <div style="display: flex; gap: 8px;">
        <a href="/admin/cotacoes" class="btn btn-secondary <?= !$status ? 'btn-primary' : '' ?>" style="padding: 6px 12px; font-size: 12px;">Todas</a>
        <a href="/admin/cotacoes?status=nova" class="btn btn-secondary <?= $status === 'nova' ? 'btn-primary' : '' ?>" style="padding: 6px 12px; font-size: 12px;">Novas</a>
        <a href="/admin/cotacoes?status=em_atendimento" class="btn btn-secondary <?= $status === 'em_atendimento' ? 'btn-primary' : '' ?>" style="padding: 6px 12px; font-size: 12px;">Em Atendimento</a>
        <a href="/admin/cotacoes?status=fechada" class="btn btn-secondary <?= $status === 'fechada' ? 'btn-primary' : '' ?>" style="padding: 6px 12px; font-size: 12px;">Fechadas</a>
    </div>
</div>

<div class="table-responsive">
    <table class="data-table">
        <thead>
            <tr>
                <th>Data</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Produto</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cotacoes as $cot): ?>
                <tr>
                    <td><?= date('d/m/Y H:i', strtotime($cot['created_at'])) ?></td>
                    <td><?= sanitize($cot['nome']) ?></td>
                    <td><?= sanitize($cot['email']) ?></td>
                    <td><?= sanitize($cot['telefone'] ?? '-') ?></td>
                    <td><?= $cot['produto_id'] ? '#' . $cot['produto_id'] : '-' ?></td>
                    <td><span class="status-badge status-<?= $cot['status'] ?>"><?= ucfirst(str_replace('_', ' ', $cot['status'])) ?></span></td>
                    <td><a href="/admin/cotacoes/<?= $cot['id'] ?>" class="btn btn-secondary" style="padding: 4px 10px; font-size: 11px;">Ver</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require APP_ROOT . '/app/views/admin/footer.php'; ?>
