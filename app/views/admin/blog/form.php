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
            <label>Data de Publicacao</label>
            <input type="datetime-local" name="publicado_em" value="<?= $post ? date('Y-m-d\TH:i', strtotime($post['publicado_em'] ?? 'now')) : date('Y-m-d\TH:i') ?>">
        </div>
    </div>

    <div class="form-group">
        <label>Resumo</label>
        <textarea name="resumo" rows="2"><?= sanitize($post['resumo'] ?? '') ?></textarea>
    </div>

    <div class="form-group">
        <label>Conteúdo</label>
        <div class="tiptap-wrapper">
            <div class="tiptap-toolbar" id="toolbar">
                <button type="button" data-action="bold" title="Negrito"><b>B</b></button>
                <button type="button" data-action="italic" title="Itálico"><i>I</i></button>
                <button type="button" data-action="strike" title="Riscado"><s>S</s></button>
                <span class="toolbar-divider"></span>
                <button type="button" data-action="heading" data-level="2" title="Título">H2</button>
                <button type="button" data-action="heading" data-level="3" title="Subtítulo">H3</button>
                <span class="toolbar-divider"></span>
                <button type="button" data-action="bulletList" title="Lista">• Lista</button>
                <button type="button" data-action="orderedList" title="Lista numerada">1. Lista</button>
                <span class="toolbar-divider"></span>
                <button type="button" data-action="link" title="Link">🔗</button>
                <button type="button" data-action="image" title="Imagem">🖼️</button>
                <span class="toolbar-divider"></span>
                <button type="button" data-action="undo" title="Desfazer">↩</button>
                <button type="button" data-action="redo" title="Refazer">↪</button>
            </div>
            <div class="tiptap-editor" id="editor"></div>
        </div>
        <input type="hidden" name="conteudo" id="conteudo-hidden" value="<?= htmlspecialchars($post['conteudo'] ?? '', ENT_QUOTES) ?>">
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Data de Publicacao</label>
            <input type="datetime-local" name="publicado_em" value="<?= $post ? date('Y-m-d\TH:i', strtotime($post['publicado_em'] ?? 'now')) : date('Y-m-d\TH:i') ?>">
        </div>
        <div class="form-group">
            <label>Imagem Destacada</label>
            <div class="upload-area" id="uploadAreaBlog" style="padding: 20px;">
                <input type="file" name="imagem" accept="image/*" id="inputImagemBlog" style="display: none;">
                <div class="upload-placeholder">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    <p><strong>Selecionar imagem</strong></p>
                </div>
            </div>
            <?php if (!empty($post['imagem'])): ?>
                <img src="<?= url($post['imagem']) ?>" alt="" style="width: 120px; height: 80px; object-fit: cover; border-radius: 8px; margin-top: 8px;">
            <?php endif; ?>
        </div>
    </div>

    <!-- Botoes de acao -->
    <div style="display: flex; gap: 12px; margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--color-border-light);">
        <button type="submit" name="status" value="publicado" class="btn btn-primary btn-lg">Publicar</button>
        <button type="submit" name="status" value="rascunho" class="btn btn-secondary btn-lg">Salvar Rascunho</button>
    </div>
</form>

<style>
.upload-area {
    border: 2px dashed var(--color-border);
    border-radius: 12px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease;
    background: var(--color-muted);
}
.upload-area:hover {
    border-color: var(--color-accent);
    background: var(--color-accent-light);
}
.upload-placeholder svg {
    color: var(--color-text-muted);
    margin-bottom: 8px;
}
.upload-placeholder p {
    font-size: 13px;
    color: var(--color-text);
    margin: 0;
}
</style>

<script>
document.getElementById('uploadAreaBlog').addEventListener('click', function() {
    document.getElementById('inputImagemBlog').click();
});
document.getElementById('inputImagemBlog').addEventListener('change', function() {
    if (this.files.length > 0) {
        document.querySelector('#uploadAreaBlog .upload-placeholder p').innerHTML = '<strong>' + this.files[0].name + '</strong>';
    }
});
</script>

<link rel="stylesheet" href="<?= asset('css/tiptap.css') ?>">
<script type="module" src="<?= asset('js/tiptap-editor.js') ?>"></script>

<?php require APP_ROOT . '/app/views/admin/footer.php'; ?>
