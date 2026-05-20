<?php $pageTitle = 'Sobre Nós - Inova Tanque'; ?>
<?php $pageDescription = 'Conheça a Inova Tanque. Locação e venda de carretas-tanque em Paulínia/SP.'; ?>
<?php require APP_ROOT . '/app/views/site/header.php'; ?>

<section style="padding-top: 48px; padding-bottom: 96px;">
    <div class="container">
        <div class="section-header" style="margin-bottom: 48px;">
            <div>
                <h2>Sobre Nós</h2>
                <p>Conheça a Inova Tanque</p>
            </div>
        </div>

        <div class="blog-post-layout">
            <div class="blog-post-content">
                <?php if (!empty($pagina['conteudo'])): ?>
                    <?= $pagina['conteudo'] ?>
                <?php else: ?>
                    <p>Conteúdo em breve.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php require APP_ROOT . '/app/views/site/footer.php'; ?>
