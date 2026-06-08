<?php $pageTitle = sanitize($pagina['titulo'] ?? 'Página') . ' - Inova Tanque'; ?>
<?php require APP_ROOT . '/app/views/site/header.php'; ?>

<section style="padding-top: 32px; padding-bottom: 96px;">
    <div class="container" style="max-width: 800px;">
        <h1 style="font-family: var(--font); font-size: 32px; font-weight: 700; color: var(--color-accent); margin-bottom: 32px;">
            <?= sanitize($pagina['titulo'] ?? 'Página não encontrada') ?>
        </h1>

        <?php if (!empty($pagina['conteudo'])): ?>
            <div class="blog-post-content">
                <?= $pagina['conteudo'] ?>
            </div>
        <?php else: ?>
            <p style="color: var(--color-text-secondary);">Conteúdo em breve.</p>
        <?php endif; ?>
    </div>
</section>

<?php require APP_ROOT . '/app/views/site/footer.php'; ?>
