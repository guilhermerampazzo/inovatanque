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
            <span style="color: var(--color-text);"><?= sanitize($post['titulo']) ?></span>
        </nav>

        <div class="blog-post-layout blog-post-layout--with-sidebar">
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

            <!-- Sidebar direita -->
            <aside class="blog-post-sidebar">
                <div class="blog-sidebar-cta">
                    <img src="/logonova.svg" alt="Inova Tanque" style="height: 56px; margin-bottom: 16px;">
                    <h3>Precisa de uma carreta-tanque?</h3>
                    <p>Locação e venda com pronta entrega, manutenção própria e seguro incluso.</p>
                    <a href="<?= whatsapp_link(WHATSAPP_PRINCIPAL, 'Olá! Li um artigo no blog e gostaria de informações sobre carretas-tanque.') ?>" class="btn btn-whatsapp" target="_blank" style="width: 100%; justify-content: center; margin-top: 12px;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
                        Fale pelo WhatsApp
                    </a>
                    <a href="/catalogo" class="btn btn-secondary" style="width: 100%; justify-content: center; margin-top: 8px;">Ver Catálogo</a>
                </div>

                <?php if (!empty($relacionados)): ?>
                <div class="blog-sidebar-related">
                    <h4>Posts Relacionados</h4>
                    <?php foreach (array_slice($relacionados, 0, 3) as $rel): ?>
                        <a href="/blog/<?= $rel['slug'] ?>" class="blog-sidebar-post">
                            <?php if ($rel['imagem']): ?>
                                <img src="<?= url($rel['imagem']) ?>" alt="<?= sanitize($rel['titulo']) ?>">
                            <?php endif; ?>
                            <div>
                                <span><?= date('d/m/Y', strtotime($rel['publicado_em'])) ?></span>
                                <strong><?= sanitize($rel['titulo']) ?></strong>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <div class="blog-sidebar-contact">
                    <h4>Contato direto</h4>
                    <p><?= TELEFONE ?></p>
                    <p><?= EMAIL_CONTATO ?></p>
                </div>
            </aside>
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
