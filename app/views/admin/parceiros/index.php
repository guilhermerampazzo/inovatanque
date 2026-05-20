<?php $pageTitle = 'Parceiros'; ?>
<?php require APP_ROOT . '/app/views/admin/header.php'; ?>

<div class="admin-header">
    <h1>Parceiros / Logos de Clientes</h1>
    <a href="/admin/parceiros/criar" class="btn btn-primary">Novo Parceiro</a>
</div>

<div class="table-responsive">
    <table class="data-table">
        <thead>
            <tr>
                <th>Logo</th>
                <th>Nome</th>
                <th>Ordem</th>
                <th>Ativo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($parceiros as $p): ?>
                <tr>
                    <td><?php if ($p['logo']): ?><img src="<?= url($p['logo']) ?>" style="height: 30px; width: auto;"><?php endif; ?></td>
                    <td><?= sanitize($p['nome']) ?></td>
                    <td><?= $p['ordem'] ?></td>
                    <td><?= $p['ativo'] ? 'Sim' : 'Não' ?></td>
                    <td>
                        <form method="POST" action="/admin/parceiros/excluir/<?= $p['id'] ?>" onsubmit="return confirm('Excluir?')">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-secondary" style="padding: 4px 10px; font-size: 11px; color: var(--color-error);">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require APP_ROOT . '/app/views/admin/footer.php'; ?>
