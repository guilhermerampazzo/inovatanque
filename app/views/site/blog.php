<?php $pageTitle = 'Blog - Inova Tanque'; ?>
<?php $pageDescription = 'Blog da Inova Tanque. Novidades, dicas e informações sobre carretas-tanque e transporte rodoviário.'; ?>
<?php require APP_ROOT . '/app/views/site/header.php'; ?>

<section style="padding-top: 48px; padding-bottom: 96px;">
    <div class="container">
        <div class="section-header" style="margin-bottom: 48px;">
            <div>
                <h2>Blog</h2>
                <p>Novidades e informações sobre o setor de transporte</p>
            </div>
        </div>

        <div class="blog-layout">
            <!-- Posts -->
            <div class="blog-main">
                <?php if (!empty($posts)): ?>
                    <div class="blog-grid">
                        <?php foreach ($posts as $post): ?>
                            <a href="/blog/<?= $post['slug'] ?>" class="blog-card">
                                <div class="blog-card-image">
                                    <?php if ($post['imagem']): ?>
                                        <img src="<?= url($post['imagem']) ?>" alt="<?= sanitize($post['titulo']) ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="blog-card-body">
                                    <span class="blog-card-date"><?= date('d/m/Y', strtotime($post['publicado_em'])) ?></span>
                                    <h3><?= sanitize($post['titulo']) ?></h3>
                                    <p><?= sanitize($post['resumo'] ?? '') ?></p>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>

                    <!-- Paginação -->
                    <?php if ($pagination['total_pages'] > 1): ?>
                        <div class="pagination">
                            <?php if ($pagination['current_page'] > 1): ?>
                                <a href="/blog?page=<?= $pagination['current_page'] - 1 ?>">&laquo;</a>
                            <?php endif; ?>
                            <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                                <?php if ($i === $pagination['current_page']): ?>
                                    <span class="active"><?= $i ?></span>
                                <?php else: ?>
                                    <a href="/blog?page=<?= $i ?>"><?= $i ?></a>
                                <?php endif; ?>
                            <?php endfor; ?>
                            <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                                <a href="/blog?page=<?= $pagination['current_page'] + 1 ?>">&raquo;</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <p style="color: var(--color-on-surface-variant); text-align: center; padding: 64px 0;">Nenhum post publicado ainda.</p>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <aside class="blog-sidebar">
                <?php if (!empty($recentes)): ?>
                    <div class="sidebar-widget">
                        <h4>Posts Recentes</h4>
                        <ul>
                            <?php foreach ($recentes as $rec): ?>
                                <li><a href="/blog/<?= $rec['slug'] ?>"><?= sanitize($rec['titulo']) ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (!empty($categorias)): ?>
                    <div class="sidebar-widget">
                        <h4>Categorias</h4>
                        <ul>
                            <?php foreach ($categorias as $cat): ?>
                                <li><a href="/blog?categoria=<?= $cat['slug'] ?>"><?= sanitize($cat['nome']) ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </aside>
        </div>
    </div>
</section>

<?php require APP_ROOT . '/app/views/site/footer.php'; ?>
