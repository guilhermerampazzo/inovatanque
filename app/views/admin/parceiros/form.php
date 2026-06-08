<?php $pageTitle = 'Novo Parceiro'; ?>
<?php require APP_ROOT . '/app/views/admin/header.php'; ?>

<div class="admin-header">
    <h1>Novo Parceiro</h1>
    <a href="/admin/parceiros" class="btn btn-secondary">Voltar</a>
</div>

<form method="POST" action="/admin/parceiros/criar" enctype="multipart/form-data" style="max-width: 500px;">
    <?= csrf_field() ?>

    <div class="form-group">
        <label>Nome *</label>
        <input type="text" name="nome" required>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Ordem</label>
            <input type="number" name="ordem" value="0">
        </div>
        <div class="form-group" style="display: flex; align-items: center; gap: 10px; padding-top: 28px;">
            <input type="checkbox" name="ativo" id="ativo" checked style="accent-color: var(--color-accent);">
            <label for="ativo" style="text-transform: none; letter-spacing: 0; font-size: 14px; color: var(--color-text);">Ativo</label>
        </div>
    </div>

    <div class="form-group">
        <label>Logo *</label>
        <input type="file" name="logo" accept="image/*" required style="color: var(--color-text-secondary);">
    </div>

    <button type="submit" class="btn btn-primary btn-lg">Salvar</button>
</form>

<?php require APP_ROOT . '/app/views/admin/footer.php'; ?>
