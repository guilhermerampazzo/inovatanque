<?php $pageTitle = 'Blog'; ?>
<?php require APP_ROOT . '/app/views/admin/header.php'; ?>

<div class="admin-header">
    <h1>Blog</h1>
    <a href="/admin/blog/criar" class="btn btn-primary">Novo Post</a>
</div>

<div class="table-responsive">
    <table class="data-table">
        <thead>
            <tr>
                <th>Título</th>
                <th>Status</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $post): ?>
                <tr>
                    <td><?= sanitize($post['titulo']) ?></td>
                    <td><span class="status-badge status-<?= $post['status'] === 'publicado' ? 'fechada' : 'nova' ?>"><?= ucfirst($post['status']) ?></span></td>
                    <td><?= $post['publicado_em'] ? date('d/m/Y', strtotime($post['publicado_em'])) : '-' ?></td>
                    <td style="display: flex; gap: 8px;">
                        <a href="/admin/blog/editar/<?= $post['id'] ?>" class="btn btn-secondary" style="padding: 4px 10px; font-size: 11px;">Editar</a>
                        <form method="POST" action="/admin/blog/excluir/<?= $post['id'] ?>" onsubmit="return confirm('Excluir?')">
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
