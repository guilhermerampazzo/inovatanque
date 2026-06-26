<?php $pageTitle = $banner ? 'Editar Banner' : 'Novo Banner'; ?>
<?php require APP_ROOT . '/app/views/admin/header.php'; ?>

<div class="admin-header">
    <h1><?= $banner ? 'Editar Banner' : 'Novo Banner' ?></h1>
    <a href="/admin/banners" class="btn btn-secondary">Voltar</a>
</div>

<form method="POST" action="/admin/banners/<?= $banner ? 'editar/' . $banner['id'] : 'criar' ?>" enctype="multipart/form-data" style="max-width: 640px;">
    <?= csrf_field() ?>

    <div class="form-group">
        <label>Tipo de Banner</label>
        <select name="tipo" id="banner-tipo" onchange="toggleBannerFields()">
            <option value="cor_texto" <?= ($banner['tipo'] ?? 'cor_texto') === 'cor_texto' ? 'selected' : '' ?>>Cor de fundo + Texto + Botão</option>
            <option value="imagem_texto" <?= ($banner['tipo'] ?? '') === 'imagem_texto' ? 'selected' : '' ?>>Imagem + Texto + Botão</option>
            <option value="imagem_link" <?= ($banner['tipo'] ?? '') === 'imagem_link' ? 'selected' : '' ?>>Só Imagem (clicável)</option>
        </select>
    </div>

    <!-- Cor de fundo (só para tipo cor_texto) -->
    <div class="form-group" id="field-cor">
        <label>Cor de Fundo</label>
        <input type="color" name="cor_fundo" value="<?= sanitize($banner['cor_fundo'] ?? '#1a1a1a') ?>" style="width: 60px; height: 40px; padding: 2px; cursor: pointer;">
    </div>

    <!-- Imagem (para imagem_texto e imagem_link) -->
    <div class="form-group" id="field-imagem">
        <label>Imagem</label>
        <input type="file" name="imagem" accept="image/*">
        <?php if (!empty($banner['imagem'])): ?>
            <img src="<?= url($banner['imagem']) ?>" alt="" style="width: 240px; height: 120px; object-fit: cover; border-radius: 8px; margin-top: 8px;">
        <?php endif; ?>
    </div>

    <!-- Texto (para cor_texto e imagem_texto) -->
    <div id="field-texto">
        <div class="form-group">
            <label>Título</label>
            <input type="text" name="titulo" value="<?= sanitize($banner['titulo'] ?? '') ?>" placeholder="Ex: Carretas-Tanque em Pronta Entrega">
        </div>

        <div class="form-group">
            <label>Subtítulo</label>
            <input type="text" name="subtitulo" value="<?= sanitize($banner['subtitulo'] ?? '') ?>" placeholder="Ex: Locação com manutenção própria e seguro incluso">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Texto do Botão</label>
                <input type="text" name="cta_texto" value="<?= sanitize($banner['cta_texto'] ?? '') ?>" placeholder="Ex: Ver Catálogo">
            </div>
            <div class="form-group">
                <label>Link do Botão</label>
                <input type="text" name="cta_link" value="<?= sanitize($banner['cta_link'] ?? '') ?>" placeholder="Ex: /catalogo">
            </div>
        </div>
    </div>

    <!-- Link (para imagem_link) -->
    <div class="form-group" id="field-link">
        <label>Link ao clicar na imagem</label>
        <input type="text" name="link" value="<?= sanitize($banner['link'] ?? '') ?>" placeholder="Ex: /catalogo ou https://...">
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Ordem</label>
            <input type="number" name="ordem" value="<?= $banner['ordem'] ?? 0 ?>" min="0">
        </div>
        <div class="form-group">
            <label>Tempo de exibição (segundos)</label>
            <input type="number" name="duracao_segundos" value="<?= (int)(($banner['duracao'] ?? 5000) / 1000) ?>" min="1" max="30" placeholder="5">
        </div>
        <div class="form-group" style="display: flex; align-items: center; gap: 10px; padding-top: 28px;">
            <input type="checkbox" name="ativo" id="ativo" <?= ($banner['ativo'] ?? 1) ? 'checked' : '' ?>>
            <label for="ativo" style="font-size: 14px;">Ativo</label>
        </div>
    </div>

    <button type="submit" class="btn btn-primary btn-lg">Salvar</button>
</form>

<script>
function toggleBannerFields() {
    var tipo = document.getElementById('banner-tipo').value;
    var fieldCor = document.getElementById('field-cor');
    var fieldImagem = document.getElementById('field-imagem');
    var fieldTexto = document.getElementById('field-texto');
    var fieldLink = document.getElementById('field-link');

    fieldCor.style.display = tipo === 'cor_texto' ? 'block' : 'none';
    fieldImagem.style.display = tipo !== 'cor_texto' ? 'block' : 'none';
    fieldTexto.style.display = tipo !== 'imagem_link' ? 'block' : 'none';
    fieldLink.style.display = tipo === 'imagem_link' ? 'block' : 'none';
}
toggleBannerFields();
</script>

<?php require APP_ROOT . '/app/views/admin/footer.php'; ?>
