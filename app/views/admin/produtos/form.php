<?php $pageTitle = $produto ? 'Editar Produto' : 'Novo Produto'; ?>
<?php require APP_ROOT . '/app/views/admin/header.php'; ?>

<div class="admin-header">
    <h1><?= $produto ? 'Editar Produto' : 'Novo Produto' ?></h1>
    <a href="/admin/produtos" class="btn btn-secondary">Voltar</a>
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
            <input type="text" name="modalidade" placeholder="Locação, Venda, Consignação" value="<?= sanitize($produto['modalidade'] ?? '') ?>">
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

    <div class="form-row">
        <div class="form-group">
            <label>Ordem</label>
            <input type="number" name="ordem" value="<?= $produto['ordem'] ?? 0 ?>">
        </div>
        <div class="form-group" style="display: flex; align-items: center; gap: 10px; padding-top: 28px;">
            <input type="checkbox" name="destaque" id="destaque" <?= ($produto['destaque'] ?? 0) ? 'checked' : '' ?> style="accent-color: var(--color-gold);">
            <label for="destaque" style="text-transform: none; letter-spacing: 0; font-size: 14px; color: var(--color-on-surface);">Destaque na Home</label>
        </div>
    </div>

    <div class="form-group">
        <label>Imagens (upload múltiplo)</label>
        <input type="file" name="imagens[]" multiple accept="image/*" style="color: var(--color-on-surface-variant);">
    </div>

    <?php if (!empty($imagens)): ?>
        <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 24px;">
            <?php foreach ($imagens as $img): ?>
                <img src="<?= url($img['arquivo']) ?>" alt="" style="width: 80px; height: 60px; object-fit: cover; border-radius: var(--radius-md); border: 1px solid var(--color-outline-variant);">
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <button type="submit" class="btn btn-primary btn-lg">Salvar Produto</button>
</form>

<?php require APP_ROOT . '/app/views/admin/footer.php'; ?>
