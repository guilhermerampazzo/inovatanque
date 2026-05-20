<?php $pageTitle = $banner ? 'Editar Banner' : 'Novo Banner'; ?>
<?php require APP_ROOT . '/app/views/admin/header.php'; ?>

<div class="admin-header">
    <h1><?= $banner ? 'Editar Banner' : 'Novo Banner' ?></h1>
    <a href="/admin/banners" class="btn btn-secondary">Voltar</a>
</div>

<form method="POST" action="/admin/banners/<?= $banner ? 'editar/' . $banner['id'] : 'criar' ?>" enctype="multipart/form-data" style="max-width: 600px;">
    <?= csrf_field() ?>

    <div class="form-group">
        <label>Título</label>
        <input type="text" name="titulo" value="<?= sanitize($banner['titulo'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label>Subtítulo</label>
        <input type="text" name="subtitulo" value="<?= sanitize($banner['subtitulo'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label>Link/CTA</label>
        <input type="text" name="link" value="<?= sanitize($banner['link'] ?? '') ?>">
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Ordem</label>
            <input type="number" name="ordem" value="<?= $banner['ordem'] ?? 0 ?>">
        </div>
        <div class="form-group" style="display: flex; align-items: center; gap: 10px; padding-top: 28px;">
            <input type="checkbox" name="ativo" id="ativo" <?= ($banner['ativo'] ?? 1) ? 'checked' : '' ?> style="accent-color: var(--color-gold);">
            <label for="ativo" style="text-transform: none; letter-spacing: 0; font-size: 14px; color: var(--color-on-surface);">Ativo</label>
        </div>
    </div>

    <div class="form-group">
        <label>Imagem</label>
        <input type="file" name="imagem" accept="image/*" style="color: var(--color-on-surface-variant);">
        <?php if (!empty($banner['imagem'])): ?>
            <img src="<?= url($banner['imagem']) ?>" alt="" style="width: 200px; height: 100px; object-fit: cover; border-radius: var(--radius-md); margin-top: 8px;">
        <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-primary btn-lg">Salvar</button>
</form>

<?php require APP_ROOT . '/app/views/admin/footer.php'; ?>
