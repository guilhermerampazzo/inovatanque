<?php $pageTitle = 'Produtos'; ?>
<?php require APP_ROOT . '/app/views/admin/header.php'; ?>

<div class="admin-header">
    <h1>Produtos</h1>
    <a href="/admin/produtos/criar" class="btn btn-primary">Novo Produto</a>
</div>

<div class="table-responsive">
    <table class="data-table">
        <thead>
            <tr>
                <th>Código</th>
                <th>Título</th>
                <th>Capacidade</th>
                <th>Modalidade</th>
                <th>Status</th>
                <th>Destaque</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produtos as $p): ?>
                <tr>
                    <td><?= sanitize($p['codigo'] ?? '-') ?></td>
                    <td><?= sanitize($p['titulo']) ?></td>
                    <td><?= $p['capacidade'] ? number_format($p['capacidade'], 0, ',', '.') . 'L' : '-' ?></td>
                    <td><?= sanitize($p['modalidade'] ?? '-') ?></td>
                    <td><span class="status-badge status-<?= $p['status'] ?>"><?= ucfirst(str_replace('_', ' ', $p['status'])) ?></span></td>
                    <td><?= $p['destaque'] ? 'Sim' : '-' ?></td>
                    <td style="display: flex; gap: 8px;">
                        <a href="/produto/<?= $p['slug'] ?>" class="btn btn-secondary" style="padding: 4px 10px; font-size: 11px;" target="_blank">Ver</a>
                        <a href="/admin/produtos/editar/<?= $p['id'] ?>" class="btn btn-secondary" style="padding: 4px 10px; font-size: 11px;">Editar</a>
                        <form method="POST" action="/admin/produtos/excluir/<?= $p['id'] ?>" onsubmit="return confirm('Excluir este produto?')">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-secondary" style="padding: 4px 10px; font-size: 11px; color: var(--color-error);">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require APP_ROOT . '/app/views/admin/footer.php'; ?>
