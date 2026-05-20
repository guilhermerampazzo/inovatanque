<?php $pageTitle = $categoria ? 'Editar Categoria' : 'Nova Categoria'; ?>
<?php require APP_ROOT . '/app/views/admin/header.php'; ?>

<div class="admin-header">
    <h1><?= $categoria ? 'Editar Categoria' : 'Nova Categoria' ?></h1>
    <a href="/admin/categorias" class="btn btn-secondary">Voltar</a>
</div>

<form method="POST" action="/admin/categorias/<?= $categoria ? 'editar/' . $categoria['id'] : 'criar' ?>" style="max-width: 500px;">
    <?= csrf_field() ?>

    <div class="form-group">
        <label>Nome *</label>
        <input type="text" name="nome" required value="<?= sanitize($categoria['nome'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label>Categoria Pai</label>
        <select name="parent_id">
            <option value="0">Nenhuma (raiz)</option>
            <?php foreach ($pais as $pai): ?>
                <option value="<?= $pai['id'] ?>" <?= ($categoria['parent_id'] ?? 0) == $pai['id'] ? 'selected' : '' ?>><?= sanitize($pai['nome']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Ordem</label>
            <input type="number" name="ordem" value="<?= $categoria['ordem'] ?? 0 ?>">
        </div>
        <div class="form-group" style="display: flex; align-items: center; gap: 10px; padding-top: 28px;">
            <input type="checkbox" name="ativo" id="ativo" <?= ($categoria['ativo'] ?? 1) ? 'checked' : '' ?> style="accent-color: var(--color-gold);">
            <label for="ativo" style="text-transform: none; letter-spacing: 0; font-size: 14px; color: var(--color-on-surface);">Ativo</label>
        </div>
    </div>

    <button type="submit" class="btn btn-primary btn-lg">Salvar</button>
</form>

<?php require APP_ROOT . '/app/views/admin/footer.php'; ?>
