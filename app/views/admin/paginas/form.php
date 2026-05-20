<?php $pageTitle = 'Editar: ' . sanitize($pagina['titulo']); ?>
<?php require APP_ROOT . '/app/views/admin/header.php'; ?>

<div class="admin-header">
    <h1>Editar: <?= sanitize($pagina['titulo']) ?></h1>
    <a href="/admin/paginas" class="btn btn-secondary">Voltar</a>
</div>

<form method="POST" action="/admin/paginas/editar/<?= $pagina['id'] ?>" style="max-width: 800px;">
    <?= csrf_field() ?>

    <div class="form-group">
        <label>Título</label>
        <input type="text" name="titulo" value="<?= sanitize($pagina['titulo']) ?>">
    </div>

    <div class="form-group">
        <label>Conteúdo</label>
        <textarea name="conteudo" rows="15" id="conteudo"><?= $pagina['conteudo'] ?? '' ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary btn-lg">Salvar</button>
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
