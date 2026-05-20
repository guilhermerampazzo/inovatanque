<?php $pageTitle = 'Páginas'; ?>
<?php require APP_ROOT . '/app/views/admin/header.php'; ?>

<div class="admin-header">
    <h1>Páginas Institucionais</h1>
</div>

<div class="table-responsive">
    <table class="data-table">
        <thead>
            <tr>
                <th>Título</th>
                <th>Slug</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($paginas as $pag): ?>
                <tr>
                    <td><?= sanitize($pag['titulo']) ?></td>
                    <td><?= sanitize($pag['slug']) ?></td>
                    <td><a href="/admin/paginas/editar/<?= $pag['id'] ?>" class="btn btn-secondary" style="padding: 4px 10px; font-size: 11px;">Editar</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require APP_ROOT . '/app/views/admin/footer.php'; ?>
