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
        <input type="hidden" name="conteudo" id="conteudo-hidden" value="<?= htmlspecialchars($pagina['conteudo'] ?? '', ENT_QUOTES) ?>">
    </div>

    <button type="submit" class="btn btn-primary btn-lg">Salvar</button>
</form>

<link rel="stylesheet" href="<?= asset('css/tiptap.css') ?>">
<script type="module" src="<?= asset('js/tiptap-editor.js') ?>"></script>

<?php require APP_ROOT . '/app/views/admin/footer.php'; ?>
