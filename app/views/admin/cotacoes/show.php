<?php $pageTitle = 'Cotação #' . $cotacao['id']; ?>
<?php require APP_ROOT . '/app/views/admin/header.php'; ?>

<div class="admin-header">
    <h1>Cotação #<?= $cotacao['id'] ?></h1>
    <a href="/admin/cotacoes" class="btn btn-secondary">Voltar</a>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 48px; max-width: 900px;">
    <div>
        <h3 style="font-family: var(--font); font-size: 16px; font-weight: 600; color: var(--color-accent); margin-bottom: 16px;">Dados do Lead</h3>
        <table class="produto-specs">
            <tr><td>Nome</td><td><?= sanitize($cotacao['nome']) ?></td></tr>
            <tr><td>E-mail</td><td><?= sanitize($cotacao['email']) ?></td></tr>
            <tr><td>Telefone</td><td><?= sanitize($cotacao['telefone'] ?? '-') ?></td></tr>
            <tr><td>Data</td><td><?= date('d/m/Y H:i', strtotime($cotacao['created_at'])) ?></td></tr>
            <?php if ($cliente): ?>
                <tr><td>Cliente</td><td><a href="/admin/clientes/<?= $cliente['id'] ?>" style="color: var(--color-accent);"><?= sanitize($cliente['nome_razao']) ?></a></td></tr>
            <?php endif; ?>
            <?php if ($produto): ?>
                <tr><td>Produto</td><td><?= sanitize($produto['titulo']) ?> (<?= $produto['codigo'] ?? '' ?>)</td></tr>
            <?php endif; ?>
        </table>

        <?php if ($cotacao['mensagem']): ?>
            <h3 style="font-family: var(--font); font-size: 16px; font-weight: 600; color: var(--color-accent); margin: 24px 0 12px;">Mensagem</h3>
            <p style="font-size: 14px; color: var(--color-text-secondary); line-height: 1.7; background: var(--color-muted); padding: 16px; border-radius: var(--radius-md);"><?= nl2br(sanitize($cotacao['mensagem'])) ?></p>
        <?php endif; ?>
    </div>

    <div>
        <h3 style="font-family: var(--font); font-size: 16px; font-weight: 600; color: var(--color-accent); margin-bottom: 16px;">Atualizar</h3>
        <form method="POST" action="/admin/cotacoes/<?= $cotacao['id'] ?>">
            <?= csrf_field() ?>
            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <?php foreach (['nova' => 'Nova', 'em_atendimento' => 'Em Atendimento', 'fechada' => 'Fechada', 'perdida' => 'Perdida'] as $val => $label): ?>
                        <option value="<?= $val ?>" <?= $cotacao['status'] === $val ? 'selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Notas Internas</label>
                <textarea name="notas_internas" rows="5"><?= sanitize($cotacao['notas_internas'] ?? '') ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</div>

<?php require APP_ROOT . '/app/views/admin/footer.php'; ?>
