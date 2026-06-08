<?php $pageTitle = 'Meus Favoritos - Inova Tanque'; ?>
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
                    <a href="/cliente/cotacoes">Minhas Cotações</a>
                    <a href="/cliente/favoritos" class="active">Meus Favoritos</a>
                    <a href="/logout">Sair</a>
                </nav>
            </aside>

            <div class="cliente-main">
                <h1 style="font-family: var(--font); font-size: 28px; font-weight: 700; color: var(--color-accent); margin-bottom: 32px;">Meus Favoritos</h1>

                <?php if (!empty($favoritos)): ?>
                    <div class="products-grid" style="grid-template-columns: repeat(3, 1fr);">
                        <?php foreach ($favoritos as $fav): ?>
                            <div class="card-metallic">
                                <div class="card-image">
                                    <?php if (!empty($fav['imagem_principal'])): ?>
                                        <img src="<?= url($fav['imagem_principal']) ?>" alt="<?= sanitize($fav['titulo']) ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <h3><a href="/produto/<?= $fav['slug'] ?>" style="color: inherit;"><?= sanitize($fav['titulo']) ?></a></h3>
                                    <p><?= $fav['capacidade'] ? number_format($fav['capacidade'], 0, ',', '.') . 'L' : '' ?></p>
                                    <div class="card-footer">
                                        <span class="text-label"><?= sanitize($fav['modalidade'] ?? '') ?></span>
                                        <form method="POST" action="/cliente/desfavoritar/<?= $fav['produto_id'] ?>">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-secondary" style="padding: 4px 10px; font-size: 11px;">Remover</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p style="color: var(--color-text-secondary);">Você ainda não favoritou nenhum produto. <a href="/catalogo" style="color: var(--color-accent);">Explore nosso catálogo</a>.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php require APP_ROOT . '/app/views/site/footer.php'; ?>
