<?php $pageTitle = $usuario ? 'Editar Usuário' : 'Novo Usuário'; ?>
<?php require APP_ROOT . '/app/views/admin/header.php'; ?>

<div class="admin-header">
    <h1><?= $usuario ? 'Editar Usuário' : 'Novo Usuário' ?></h1>
    <a href="/admin/usuarios" class="btn btn-secondary">Voltar</a>
</div>

<form method="POST" action="/admin/usuarios/<?= $usuario ? 'editar/' . $usuario['id'] : 'criar' ?>" style="max-width: 500px;">
    <?= csrf_field() ?>

    <div class="form-group">
        <label>Nome *</label>
        <input type="text" name="nome" required value="<?= sanitize($usuario['nome'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label>E-mail *</label>
        <input type="email" name="email" required value="<?= sanitize($usuario['email'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label>Senha <?= $usuario ? '(deixe em branco para manter)' : '*' ?></label>
        <input type="password" name="senha" <?= $usuario ? '' : 'required' ?>>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Nível</label>
            <select name="role">
                <option value="admin" <?= ($usuario['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="editor" <?= ($usuario['role'] ?? 'editor') === 'editor' ? 'selected' : '' ?>>Editor</option>
            </select>
        </div>
        <div class="form-group" style="display: flex; align-items: center; gap: 10px; padding-top: 28px;">
            <input type="checkbox" name="ativo" id="ativo" <?= ($usuario['ativo'] ?? 1) ? 'checked' : '' ?> style="accent-color: var(--color-accent);">
            <label for="ativo" style="text-transform: none; letter-spacing: 0; font-size: 14px; color: var(--color-text);">Ativo</label>
        </div>
    </div>

    <button type="submit" class="btn btn-primary btn-lg">Salvar</button>
</form>

<?php require APP_ROOT . '/app/views/admin/footer.php'; ?>
