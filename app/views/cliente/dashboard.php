<?php $pageTitle = 'Minha Conta - Inova Tanque'; ?>
<?php require APP_ROOT . '/app/views/site/header.php'; ?>

<section style="padding-top: 48px; padding-bottom: 96px;">
    <div class="container">
        <div class="cliente-layout">
            <!-- Sidebar -->
            <aside class="cliente-sidebar">
                <div style="margin-bottom: 24px;">
                    <strong style="color: var(--color-accent); font-size: 16px;"><?= Session::get('cliente_nome') ?></strong>
                </div>
                <nav>
                    <a href="/cliente/dashboard" class="<?= is_active('/cliente/dashboard') ?>">Dashboard</a>
                    <a href="/cliente/perfil" class="<?= is_active('/cliente/perfil') ?>">Meu Perfil</a>
                    <a href="/cliente/cotacoes" class="<?= is_active('/cliente/cotacoes') ?>">Minhas Cotações</a>
                    <a href="/cliente/favoritos" class="<?= is_active('/cliente/favoritos') ?>">Meus Favoritos</a>
                    <a href="/logout">Sair</a>
                </nav>
            </aside>

            <!-- Conteúdo -->
            <div class="cliente-main">
                <h1 style="font-family: var(--font); font-size: 28px; font-weight: 700; color: var(--color-accent); margin-bottom: 32px;">Dashboard</h1>

                <div class="cliente-stats">
                    <div class="cliente-stat-card">
                        <div class="number"><?= $totalCotacoes ?></div>
                        <div class="label">Cotações Enviadas</div>
                    </div>
                    <div class="cliente-stat-card">
                        <div class="number"><?= $totalFavoritos ?></div>
                        <div class="label">Produtos Favoritos</div>
                    </div>
                </div>

                <div style="margin-top: 48px;">
                    <h2 style="font-family: var(--font); font-size: 20px; font-weight: 600; color: var(--color-accent); margin-bottom: 16px;">Ações Rápidas</h2>
                    <div style="display: flex; gap: 16px; flex-wrap: wrap;">
                        <a href="/catalogo" class="btn btn-primary">Ver Catálogo</a>
                        <a href="/cliente/cotacoes" class="btn btn-secondary">Ver Cotações</a>
                        <a href="/cliente/favoritos" class="btn btn-secondary">Ver Favoritos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require APP_ROOT . '/app/views/site/footer.php'; ?>
