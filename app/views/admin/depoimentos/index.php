<?php $pageTitle = 'Depoimentos'; ?>
<?php require APP_ROOT . '/app/views/admin/header.php'; ?>

<div class="admin-header">
    <h1>Depoimentos</h1>
    <a href="/admin/depoimentos/criar" class="btn btn-primary">Novo Depoimento</a>
</div>

<div class="table-responsive">
    <table class="data-table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Empresa</th>
                <th>Ordem</th>
                <th>Ativo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($depoimentos as $dep): ?>
                <tr>
                    <td><?= sanitize($dep['nome']) ?></td>
                    <td><?= sanitize($dep['empresa'] ?? '-') ?></td>
                    <td><?= $dep['ordem'] ?></td>
                    <td><?= $dep['ativo'] ? 'Sim' : 'Não' ?></td>
                    <td style="display: flex; gap: 8px;">
                        <a href="/admin/depoimentos/editar/<?= $dep['id'] ?>" class="btn btn-secondary" style="padding: 4px 10px; font-size: 11px;">Editar</a>
                        <form method="POST" action="/admin/depoimentos/excluir/<?= $dep['id'] ?>" onsubmit="return confirm('Excluir?')">
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
