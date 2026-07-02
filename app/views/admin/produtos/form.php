<?php $pageTitle = $produto ? 'Editar Produto' : 'Novo Produto'; ?>
<?php require APP_ROOT . '/app/views/admin/header.php'; ?>

<div class="admin-header">
    <h1><?= $produto ? 'Editar Produto' : 'Novo Produto' ?></h1>
    <div style="display: flex; gap: 10px;">
        <?php if ($produto): ?>
            <a href="/produto/<?= $produto['slug'] ?>" class="btn btn-secondary" target="_blank">Ver no Site</a>
        <?php endif; ?>
        <a href="/admin/produtos" class="btn btn-secondary">Voltar</a>
    </div>
</div>

<form method="POST" action="/admin/produtos/<?= $produto ? 'editar/' . $produto['id'] : 'criar' ?>" enctype="multipart/form-data" style="max-width: 800px;">
    <?= csrf_field() ?>

    <div class="form-row">
        <div class="form-group">
            <label>Título *</label>
            <input type="text" name="titulo" required value="<?= sanitize($produto['titulo'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Código/SKU</label>
            <input type="text" name="codigo" value="<?= sanitize($produto['codigo'] ?? '') ?>">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Categoria *</label>
            <select name="categoria_id" required>
                <option value="">Selecione</option>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= ($produto['categoria_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>><?= sanitize($cat['nome']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Configuração</label>
            <select name="configuracao">
                <option value="">Selecione</option>
                <?php foreach (['Carreta', 'Bitrem', 'Bitrenzao', 'Rodotrem', 'Vanderleia 3ED'] as $cfg): ?>
                    <option value="<?= $cfg ?>" <?= ($produto['configuracao'] ?? '') === $cfg ? 'selected' : '' ?>><?= $cfg ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Capacidade (L)</label>
            <input type="number" name="capacidade" value="<?= $produto['capacidade'] ?? '' ?>">
        </div>
        <div class="form-group">
            <label>Ano</label>
            <input type="number" name="ano" value="<?= $produto['ano'] ?? '' ?>">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Fabricante</label>
            <input type="text" name="fabricante" value="<?= sanitize($produto['fabricante'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Carregamento</label>
            <select name="carregamento">
                <option value="">Selecione</option>
                <option value="top" <?= ($produto['carregamento'] ?? '') === 'top' ? 'selected' : '' ?>>Top</option>
                <option value="bottom" <?= ($produto['carregamento'] ?? '') === 'bottom' ? 'selected' : '' ?>>Bottom</option>
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Modalidade</label>
            <input type="text" name="modalidade" placeholder="Locação, Venda" value="<?= sanitize($produto['modalidade'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status">
                <?php foreach (['disponivel' => 'Disponível', 'pronta_entrega' => 'Pronta Entrega', 'locado' => 'Locado', 'vendido' => 'Vendido'] as $val => $label): ?>
                    <option value="<?= $val ?>" <?= ($produto['status'] ?? 'disponivel') === $val ? 'selected' : '' ?>><?= $label ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label>Descrição</label>
        <textarea name="descricao" rows="6"><?= $produto['descricao'] ?? '' ?></textarea>
    </div>

    <!-- Ordem e Destaque -->
    <div class="form-row" style="align-items: end;">
        <div class="form-group">
            <label>Ordem de exibição</label>
            <input type="number" name="ordem" value="<?= $produto['ordem'] ?? 0 ?>" style="max-width: 120px;">
        </div>
        <div class="form-group">
            <label class="toggle-label">
                <input type="checkbox" name="destaque" id="destaque" <?= ($produto['destaque'] ?? 0) ? 'checked' : '' ?>>
                <span class="toggle-switch"></span>
                <span>Destaque na Home</span>
            </label>
        </div>
    </div>

    <!-- Upload de Imagens -->
    <div class="form-group">
        <label>Imagens do Produto</label>
        <div class="upload-area" id="uploadArea">
            <input type="file" name="imagens[]" multiple accept="image/*" id="inputImagens" style="display: none;">
            <div class="upload-placeholder">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                <p><strong>Clique para selecionar</strong> ou arraste imagens aqui</p>
                <span>JPG, PNG ou WebP (máx. 5MB cada)</span>
            </div>
        </div>
    </div>

    <?php if (!empty($imagens)): ?>
        <div class="form-group">
            <label>Imagens atuais</label>
            <div class="image-gallery-admin">
                <?php foreach ($imagens as $img): ?>
                    <div class="image-thumb">
                        <img src="<?= url($img['arquivo']) ?>" alt="">
                        <?php if ($img['principal']): ?>
                            <span class="thumb-badge">Principal</span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Botões de ação -->
    <div style="display: flex; gap: 12px; margin-top: 32px;">
        <button type="submit" class="btn btn-primary btn-lg">Salvar Produto</button>
        <button type="submit" name="rascunho" value="1" class="btn btn-secondary btn-lg">Salvar como Rascunho</button>
    </div>
</form>

<style>
.upload-area {
    border: 2px dashed var(--color-border);
    border-radius: 12px;
    padding: 40px 24px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease;
    background: var(--color-muted);
}
.upload-area:hover,
.upload-area.dragover {
    border-color: var(--color-accent);
    background: var(--color-accent-light);
}
.upload-placeholder svg {
    color: var(--color-text-muted);
    margin-bottom: 12px;
}
.upload-placeholder p {
    font-size: 14px;
    color: var(--color-text);
    margin-bottom: 4px;
}
.upload-placeholder span {
    font-size: 12px;
    color: var(--color-text-muted);
}
.image-gallery-admin {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}
.image-thumb {
    position: relative;
    width: 100px;
    height: 75px;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid var(--color-border-light);
}
.image-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.thumb-badge {
    position: absolute;
    bottom: 4px;
    left: 4px;
    background: var(--color-accent);
    color: #fff;
    font-size: 10px;
    font-weight: 600;
    padding: 2px 6px;
    border-radius: 4px;
}
.toggle-label {
    display: flex !important;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    font-size: 14px !important;
    text-transform: none !important;
    letter-spacing: 0 !important;
    color: var(--color-text) !important;
    padding: 10px 0;
}
.toggle-label input {
    display: none;
}
.toggle-switch {
    width: 40px;
    height: 22px;
    background: var(--color-border);
    border-radius: 11px;
    position: relative;
    transition: background 0.2s;
    flex-shrink: 0;
}
.toggle-switch::after {
    content: '';
    position: absolute;
    top: 3px;
    left: 3px;
    width: 16px;
    height: 16px;
    background: #fff;
    border-radius: 50%;
    transition: transform 0.2s;
}
.toggle-label input:checked + .toggle-switch {
    background: var(--color-accent);
}
.toggle-label input:checked + .toggle-switch::after {
    transform: translateX(18px);
}
</style>

<script>
const uploadArea = document.getElementById('uploadArea');
const inputImagens = document.getElementById('inputImagens');

uploadArea.addEventListener('click', () => inputImagens.click());
uploadArea.addEventListener('dragover', (e) => { e.preventDefault(); uploadArea.classList.add('dragover'); });
uploadArea.addEventListener('dragleave', () => uploadArea.classList.remove('dragover'));
uploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadArea.classList.remove('dragover');
    inputImagens.files = e.dataTransfer.files;
    updateUploadText();
});
inputImagens.addEventListener('change', updateUploadText);

function updateUploadText() {
    const count = inputImagens.files.length;
    if (count > 0) {
        uploadArea.querySelector('.upload-placeholder p').innerHTML = '<strong>' + count + ' imagem(ns) selecionada(s)</strong>';
    }
}
</script>

<?php require APP_ROOT . '/app/views/admin/footer.php'; ?>
