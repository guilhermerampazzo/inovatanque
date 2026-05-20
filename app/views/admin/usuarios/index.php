<?php $pageTitle = 'Usuários'; ?>
<?php require APP_ROOT . '/app/views/admin/header.php'; ?>

<div class="admin-header">
    <h1>Usuários Admin</h1>
    <a href="/admin/usuarios/criar" class="btn btn-primary">Novo Usuário</a>
</div>

<div class="table-responsive">
    <table class="data-table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Nível</th>
                <th>Ativo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td><?= sanitize($u['nome']) ?></td>
                    <td><?= sanitize($u['email']) ?></td>
                    <td><?= ucfirst($u['role']) ?></td>
                    <td><?= $u['ativo'] ? 'Sim' : 'Não' ?></td>
                    <td style="display: flex; gap: 8px;">
                        <a href="/admin/usuarios/editar/<?= $u['id'] ?>" class="btn btn-secondary" style="padding: 4px 10px; font-size: 11px;">Editar</a>
                        <?php if ($u['id'] !== Session::get('admin_id')): ?>
                            <form method="POST" action="/admin/usuarios/excluir/<?= $u['id'] ?>" onsubmit="return confirm('Excluir?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-secondary" style="padding: 4px 10px; font-size: 11px; color: var(--color-error);">Excluir</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require APP_ROOT . '/app/views/admin/footer.php'; ?>
