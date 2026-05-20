<?php $pageTitle = $post ? 'Editar Post' : 'Novo Post'; ?>
<?php require APP_ROOT . '/app/views/admin/header.php'; ?>

<div class="admin-header">
    <h1><?= $post ? 'Editar Post' : 'Novo Post' ?></h1>
    <a href="/admin/blog" class="btn btn-secondary">Voltar</a>
</div>

<form method="POST" action="/admin/blog/<?= $post ? 'editar/' . $post['id'] : 'criar' ?>" enctype="multipart/form-data" style="max-width: 800px;">
    <?= csrf_field() ?>

    <div class="form-group">
        <label>Título *</label>
        <input type="text" name="titulo" required value="<?= sanitize($post['titulo'] ?? '') ?>">
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Categoria</label>
            <select name="categoria_id">
                <option value="">Sem categoria</option>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= ($post['categoria_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>><?= sanitize($cat['nome']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status">
                <option value="rascunho" <?= ($post['status'] ?? 'rascunho') === 'rascunho' ? 'selected' : '' ?>>Rascunho</option>
                <option value="publicado" <?= ($post['status'] ?? '') === 'publicado' ? 'selected' : '' ?>>Publicado</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label>Resumo</label>
        <textarea name="resumo" rows="2"><?= sanitize($post['resumo'] ?? '') ?></textarea>
    </div>

    <div class="form-group">
        <label>Conteúdo</label>
        <textarea name="conteudo" rows="15" id="conteudo"><?= $post['conteudo'] ?? '' ?></textarea>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Data de Publicação</label>
            <input type="datetime-local" name="publicado_em" value="<?= $post ? date('Y-m-d\TH:i', strtotime($post['publicado_em'] ?? 'now')) : date('Y-m-d\TH:i') ?>">
        </div>
        <div class="form-group">
            <label>Imagem Destacada</label>
            <input type="file" name="imagem" accept="image/*" style="color: var(--color-on-surface-variant);">
            <?php if (!empty($post['imagem'])): ?>
                <img src="<?= url($post['imagem']) ?>" alt="" style="width: 120px; height: 80px; object-fit: cover; border-radius: var(--radius-md); margin-top: 8px;">
            <?php endif; ?>
        </div>
    </div>

    <button type="submit" class="btn btn-primary btn-lg">Salvar Post</button>
</form>

<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script>
<script>
tinymce.init({
    selector: '#conteudo',
    skin: 'oxide-dark',
    content_css: 'dark',
    height: 400,
    plugins: 'lists link image',
    toolbar: 'undo redo | bold italic | bullist numlist | link image',
    menubar: false
});
</script>

<?php require APP_ROOT . '/app/views/admin/footer.php'; ?>
