<?php $pageTitle = sanitize($post['titulo']) . ' - Blog Inova Tanque'; ?>
<?php $pageDescription = sanitize($post['resumo'] ?? $post['titulo']); ?>
<?php $ogType = 'article'; ?>
<?php $ogImage = $post['imagem'] ? url($post['imagem']) : null; ?>
<?php $schemaMarkup = json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    'headline' => $post['titulo'],
    'description' => $post['resumo'] ?? '',
    'image' => $post['imagem'] ? url($post['imagem']) : '',
    'datePublished' => date('c', strtotime($post['publicado_em'])),
    'author' => ['@type' => 'Organization', 'name' => 'Inova Tanque'],
    'publisher' => [
        '@type' => 'Organization',
        'name' => 'Inova Tanque',
        'logo' => ['@type' => 'ImageObject', 'url' => url('/logo.svg')],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>
<?php require APP_ROOT . '/app/views/site/header.php'; ?>

<article style="padding-top: 32px; padding-bottom: 96px;">
    <div class="container">
        <nav class="breadcrumb">
            <a href="/">Home</a>
            <span>/</span>
            <a href="/blog">Blog</a>
            <span>/</span>
            <span style="color: var(--color-on-surface);"><?= sanitize($post['titulo']) ?></span>
        </nav>

        <div class="blog-post-layout">
            <div class="blog-post-main">
                <?php if ($post['imagem']): ?>
                    <div class="blog-post-image">
                        <img src="<?= url($post['imagem']) ?>" alt="<?= sanitize($post['titulo']) ?>">
                    </div>
                <?php endif; ?>

                <div class="blog-post-meta">
                    <span><?= date('d/m/Y', strtotime($post['publicado_em'])) ?></span>
                </div>

                <h1 class="blog-post-title"><?= sanitize($post['titulo']) ?></h1>

                <div class="blog-post-content">
                    <?= $post['conteudo'] ?>
                </div>

                <!-- Compartilhamento -->
                <div class="blog-post-share">
                    <span>Compartilhar:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(url('/blog/' . $post['slug'])) ?>" target="_blank" rel="noopener">Facebook</a>
                    <a href="https://api.whatsapp.com/send?text=<?= urlencode($post['titulo'] . ' - ' . url('/blog/' . $post['slug'])) ?>" target="_blank" rel="noopener">WhatsApp</a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode(url('/blog/' . $post['slug'])) ?>" target="_blank" rel="noopener">LinkedIn</a>
                </div>
            </div>
        </div>

        <!-- Posts Relacionados -->
        <?php if (!empty($relacionados)): ?>
            <div style="margin-top: 64px;">
                <div class="section-header">
                    <div><h2>Posts Relacionados</h2></div>
                </div>
                <div class="blog-grid">
                    <?php foreach ($relacionados as $rel): ?>
                        <a href="/blog/<?= $rel['slug'] ?>" class="blog-card">
                            <div class="blog-card-image">
                                <?php if ($rel['imagem']): ?>
                                    <img src="<?= url($rel['imagem']) ?>" alt="<?= sanitize($rel['titulo']) ?>">
                                <?php endif; ?>
                            </div>
                            <div class="blog-card-body">
                                <span class="blog-card-date"><?= date('d/m/Y', strtotime($rel['publicado_em'])) ?></span>
                                <h3><?= sanitize($rel['titulo']) ?></h3>
                                <p><?= sanitize($rel['resumo'] ?? '') ?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</article>

<?php require APP_ROOT . '/app/views/site/footer.php'; ?>
