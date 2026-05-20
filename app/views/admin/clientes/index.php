<?php $pageTitle = 'Clientes'; ?>
<?php require APP_ROOT . '/app/views/admin/header.php'; ?>

<div class="admin-header">
    <h1>Clientes</h1>
</div>

<div class="table-responsive">
    <table class="data-table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Tipo</th>
                <th>Telefone</th>
                <th>Cadastro</th>
                <th>Ativo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientes as $cli): ?>
                <tr>
                    <td><a href="/admin/clientes/<?= $cli['id'] ?>" style="color: var(--color-gold);"><?= sanitize($cli['nome_razao']) ?></a></td>
                    <td><?= sanitize($cli['email']) ?></td>
                    <td><?= strtoupper($cli['tipo']) ?></td>
                    <td><?= sanitize($cli['telefone'] ?? '-') ?></td>
                    <td><?= date('d/m/Y', strtotime($cli['created_at'])) ?></td>
                    <td><?= $cli['ativo'] ? 'Sim' : 'Não' ?></td>
                    <td style="display: flex; gap: 8px;">
                        <a href="/admin/clientes/<?= $cli['id'] ?>" class="btn btn-secondary" style="padding: 4px 10px; font-size: 11px;">Ver</a>
                        <form method="POST" action="/admin/clientes/toggle/<?= $cli['id'] ?>">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-secondary" style="padding: 4px 10px; font-size: 11px;"><?= $cli['ativo'] ? 'Desativar' : 'Ativar' ?></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require APP_ROOT . '/app/views/admin/footer.php'; ?>
