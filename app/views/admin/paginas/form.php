<?php $pageTitle = 'Editar: ' . sanitize($pagina['titulo']); ?>
<?php require APP_ROOT . '/app/views/admin/header.php'; ?>

<div class="admin-header">
    <h1>Editar: <?= sanitize($pagina['titulo']) ?></h1>
    <a href="/admin/paginas" class="btn btn-secondary">Voltar</a>
</div>

<form method="POST" action="/admin/paginas/editar/<?= $pagina['id'] ?>" enctype="multipart/form-data" style="max-width: 800px;">
    <?= csrf_field() ?>

    <div class="form-group">
        <label>Título</label>
        <input type="text" name="titulo" value="<?= sanitize($pagina['titulo']) ?>">
    </div>

    <?php if ($pagina['slug'] === 'sobre'): ?>
    <div class="form-group">
        <label>Imagem de Destaque</label>
        <div class="upload-area" id="uploadAreaPagina" style="padding: 20px;">
            <input type="file" name="imagem" accept="image/*" id="inputImagemPagina" style="display: none;">
            <div class="upload-placeholder" style="cursor:pointer;" onclick="document.getElementById('inputImagemPagina').click()">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                <p><strong>Selecionar imagem</strong></p>
                <p id="nomeArquivoPagina" style="font-size:12px;color:#666;"></p>
            </div>
        </div>
        <?php if (!empty($pagina['imagem'])): ?>
            <div style="margin-top: 8px; display: flex; align-items: center; gap: 12px;">
                <img src="<?= url($pagina['imagem']) ?>" alt="" style="width: 160px; height: 100px; object-fit: cover; border-radius: 8px;">
                <label style="display:flex;align-items:center;gap:6px;cursor:pointer;font-size:13px;color:#e53e3e;">
                    <input type="checkbox" name="remover_imagem" value="1"> Remover imagem
                </label>
            </div>
        <?php endif; ?>
        <script>
            document.getElementById('inputImagemPagina').addEventListener('change', function() {
                document.getElementById('nomeArquivoPagina').textContent = this.files[0] ? this.files[0].name : '';
            });
        </script>
    </div>
    <?php endif; ?>

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
