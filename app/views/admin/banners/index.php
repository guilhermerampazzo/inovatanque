<?php $pageTitle = 'Banners'; ?>
<?php require APP_ROOT . '/app/views/admin/header.php'; ?>

<div class="admin-header">
    <h1>Banners do Hero</h1>
    <a href="/admin/banners/criar" class="btn btn-primary">Novo Banner</a>
</div>

<div class="table-responsive">
    <table class="data-table">
        <thead>
            <tr>
                <th>Imagem</th>
                <th>Título</th>
                <th>Ordem</th>
                <th>Ativo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($banners as $b): ?>
                <tr>
                    <td><?php if ($b['imagem']): ?><img src="<?= url($b['imagem']) ?>" style="width: 80px; height: 40px; object-fit: cover; border-radius: var(--radius-sm);"><?php endif; ?></td>
                    <td><?= sanitize($b['titulo'] ?? '-') ?></td>
                    <td><?= $b['ordem'] ?></td>
                    <td><?= $b['ativo'] ? 'Sim' : 'Não' ?></td>
                    <td style="display: flex; gap: 8px;">
                        <a href="/admin/banners/editar/<?= $b['id'] ?>" class="btn btn-secondary" style="padding: 4px 10px; font-size: 11px;">Editar</a>
                        <form method="POST" action="/admin/banners/excluir/<?= $b['id'] ?>" onsubmit="return confirm('Excluir?')">
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
