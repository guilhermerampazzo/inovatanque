<?php $pageTitle = $depoimento ? 'Editar Depoimento' : 'Novo Depoimento'; ?>
<?php require APP_ROOT . '/app/views/admin/header.php'; ?>

<div class="admin-header">
    <h1><?= $depoimento ? 'Editar Depoimento' : 'Novo Depoimento' ?></h1>
    <a href="/admin/depoimentos" class="btn btn-secondary">Voltar</a>
</div>

<form method="POST" action="/admin/depoimentos/<?= $depoimento ? 'editar/' . $depoimento['id'] : 'criar' ?>" enctype="multipart/form-data" style="max-width: 600px;">
    <?= csrf_field() ?>

    <div class="form-row">
        <div class="form-group">
            <label>Nome *</label>
            <input type="text" name="nome" required value="<?= sanitize($depoimento['nome'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Empresa</label>
            <input type="text" name="empresa" value="<?= sanitize($depoimento['empresa'] ?? '') ?>">
        </div>
    </div>

    <div class="form-group">
        <label>Cargo</label>
        <input type="text" name="cargo" value="<?= sanitize($depoimento['cargo'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label>Texto *</label>
        <textarea name="texto" rows="4" required><?= sanitize($depoimento['texto'] ?? '') ?></textarea>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Ordem</label>
            <input type="number" name="ordem" value="<?= $depoimento['ordem'] ?? 0 ?>">
        </div>
        <div class="form-group" style="display: flex; align-items: center; gap: 10px; padding-top: 28px;">
            <input type="checkbox" name="ativo" id="ativo" <?= ($depoimento['ativo'] ?? 1) ? 'checked' : '' ?> style="accent-color: var(--color-gold);">
            <label for="ativo" style="text-transform: none; letter-spacing: 0; font-size: 14px; color: var(--color-on-surface);">Ativo</label>
        </div>
    </div>

    <div class="form-group">
        <label>Foto</label>
        <input type="file" name="foto" accept="image/*" style="color: var(--color-on-surface-variant);">
        <?php if (!empty($depoimento['foto'])): ?>
            <img src="<?= url($depoimento['foto']) ?>" alt="" style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%; margin-top: 8px;">
        <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-primary btn-lg">Salvar</button>
</form>

<?php require APP_ROOT . '/app/views/admin/footer.php'; ?>
