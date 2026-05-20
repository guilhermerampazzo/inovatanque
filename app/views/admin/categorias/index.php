<?php $pageTitle = 'Categorias'; ?>
<?php require APP_ROOT . '/app/views/admin/header.php'; ?>

<div class="admin-header">
    <h1>Categorias</h1>
    <a href="/admin/categorias/criar" class="btn btn-primary">Nova Categoria</a>
</div>

<div class="table-responsive">
    <table class="data-table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Slug</th>
                <th>Pai</th>
                <th>Ordem</th>
                <th>Ativo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categorias as $cat): ?>
                <tr>
                    <td><?= sanitize($cat['nome']) ?></td>
                    <td><?= sanitize($cat['slug']) ?></td>
                    <td><?= $cat['parent_id'] ?: '-' ?></td>
                    <td><?= $cat['ordem'] ?></td>
                    <td><?= $cat['ativo'] ? 'Sim' : 'Não' ?></td>
                    <td style="display: flex; gap: 8px;">
                        <a href="/admin/categorias/editar/<?= $cat['id'] ?>" class="btn btn-secondary" style="padding: 4px 10px; font-size: 11px;">Editar</a>
                        <form method="POST" action="/admin/categorias/excluir/<?= $cat['id'] ?>" onsubmit="return confirm('Excluir?')">
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
