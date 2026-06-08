<?php $pageTitle = 'Minhas Cotações - Inova Tanque'; ?>
<?php require APP_ROOT . '/app/views/site/header.php'; ?>

<section style="padding-top: 48px; padding-bottom: 96px;">
    <div class="container">
        <div class="cliente-layout">
            <aside class="cliente-sidebar">
                <div style="margin-bottom: 24px;">
                    <strong style="color: var(--color-accent); font-size: 16px;"><?= Session::get('cliente_nome') ?></strong>
                </div>
                <nav>
                    <a href="/cliente/dashboard">Dashboard</a>
                    <a href="/cliente/perfil">Meu Perfil</a>
                    <a href="/cliente/cotacoes" class="active">Minhas Cotações</a>
                    <a href="/cliente/favoritos">Meus Favoritos</a>
                    <a href="/logout">Sair</a>
                </nav>
            </aside>

            <div class="cliente-main">
                <h1 style="font-family: var(--font); font-size: 28px; font-weight: 700; color: var(--color-accent); margin-bottom: 32px;">Minhas Cotações</h1>

                <?php if (!empty($cotacoes)): ?>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Produto</th>
                                    <th>Status</th>
                                    <th>Mensagem</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cotacoes as $cot): ?>
                                    <tr>
                                        <td><?= date('d/m/Y', strtotime($cot['created_at'])) ?></td>
                                        <td><?= $cot['produto_id'] ? '#' . $cot['produto_id'] : '-' ?></td>
                                        <td><span class="status-badge status-<?= $cot['status'] ?>"><?= ucfirst(str_replace('_', ' ', $cot['status'])) ?></span></td>
                                        <td><?= sanitize(mb_substr($cot['mensagem'] ?? '', 0, 50)) ?><?= mb_strlen($cot['mensagem'] ?? '') > 50 ? '...' : '' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p style="color: var(--color-text-secondary);">Você ainda não enviou nenhuma cotação. <a href="/catalogo" style="color: var(--color-accent);">Explore nosso catálogo</a>.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php require APP_ROOT . '/app/views/site/footer.php'; ?>
