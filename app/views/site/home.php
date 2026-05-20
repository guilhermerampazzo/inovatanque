<?php $pageTitle = 'Inova Tanque - Locação e Venda de Carretas-Tanque | Pronta Entrega'; ?>
<?php $pageDescription = 'Locação e venda de carretas-tanque em Paulínia/SP. Pronta entrega, manutenção própria e seguro incluso. Aço, Inox e Térmica.'; ?>
<?php require APP_ROOT . '/app/views/site/header.php'; ?>

<!-- Hero Compacto -->
<section class="hero-ecommerce">
    <?php if (!empty($banners)): ?>
        <?php foreach ($banners as $i => $banner): ?>
            <?php $tipo = $banner['tipo'] ?? 'cor_texto'; ?>

            <?php if ($tipo === 'imagem_link'): ?>
                <!-- Tipo: só imagem clicável -->
                <a href="<?= sanitize($banner['link'] ?? '#') ?>" class="hero-slide <?= $i === 0 ? 'active' : '' ?>" style="cursor: pointer;">
                    <img src="<?= url($banner['imagem']) ?>" alt="<?= sanitize($banner['titulo'] ?? 'Banner') ?>">
                </a>

            <?php elseif ($tipo === 'imagem_texto'): ?>
                <!-- Tipo: imagem + texto + botão -->
                <div class="hero-slide <?= $i === 0 ? 'active' : '' ?>">
                    <img src="<?= url($banner['imagem']) ?>" alt="<?= sanitize($banner['titulo'] ?? '') ?>">
                    <div class="hero-overlay"></div>
                    <div class="container hero-content">
                        <?php if ($banner['titulo']): ?>
                            <h2><?= $banner['titulo'] ?></h2>
                        <?php endif; ?>
                        <?php if ($banner['subtitulo']): ?>
                            <p><?= sanitize($banner['subtitulo']) ?></p>
                        <?php endif; ?>
                        <?php if (!empty($banner['cta_texto']) && !empty($banner['cta_link'])): ?>
                            <a href="<?= sanitize($banner['cta_link']) ?>" class="btn btn-primary"><?= sanitize($banner['cta_texto']) ?></a>
                        <?php endif; ?>
                    </div>
                </div>

            <?php else: ?>
                <!-- Tipo: cor de fundo + texto + botão -->
                <div class="hero-slide <?= $i === 0 ? 'active' : '' ?>" style="background: <?= sanitize($banner['cor_fundo'] ?? '#1a1a1a') ?>;">
                    <div class="container hero-content">
                        <?php if ($banner['titulo']): ?>
                            <h2><?= $banner['titulo'] ?></h2>
                        <?php endif; ?>
                        <?php if ($banner['subtitulo']): ?>
                            <p><?= sanitize($banner['subtitulo']) ?></p>
                        <?php endif; ?>
                        <?php if (!empty($banner['cta_texto']) && !empty($banner['cta_link'])): ?>
                            <a href="<?= sanitize($banner['cta_link']) ?>" class="btn btn-primary"><?= sanitize($banner['cta_texto']) ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

        <?php endforeach; ?>
    <?php else: ?>
        <div class="hero-slide active" style="background: #1a1a1a;">
            <div class="container hero-content">
                <h2>Carretas-Tanque em <span class="text-gold">Pronta Entrega</span></h2>
                <p>Locação e venda com manutenção própria e seguro incluso</p>
                <a href="/catalogo" class="btn btn-primary">Ver Catálogo Completo</a>
            </div>
        </div>
    <?php endif; ?>
    <?php if (count($banners ?? []) > 1): ?>
    <div class="hero-indicators">
        <?php foreach ($banners as $i => $b): ?>
            <button class="hero-dot <?= $i === 0 ? 'active' : '' ?>" data-slide="<?= $i ?>"></button>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</section>

<!-- Destaques rápidos -->
<section class="quick-highlights">
    <div class="container">
        <div class="highlights-grid">
            <div class="highlight-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <span>Pronta Entrega</span>
            </div>
            <div class="highlight-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                <span>Seguro Incluso</span>
            </div>
            <div class="highlight-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                <span>Manutenção Própria</span>
            </div>
            <div class="highlight-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                <span>Documentação em Dia</span>
            </div>
        </div>
    </div>
</section>

<!-- Produtos em Destaque -->
<section class="section-produtos">
    <div class="container">
        <div class="section-header">
            <div>
                <h2>Equipamentos Disponíveis</h2>
                <p><?= count($destaques ?? []) ?> equipamentos encontrados</p>
            </div>
            <a href="/catalogo">Ver todos &rarr;</a>
        </div>
        <div class="products-grid">
            <?php if (!empty($destaques)): ?>
                <?php foreach (array_slice($destaques, 0, 8) as $produto): ?>
                    <a href="/produto/<?= $produto['slug'] ?>" class="product-card">
                        <div class="product-image">
                            <?php if ($produto['imagem_principal']): ?>
                                <img src="<?= url($produto['imagem_principal']) ?>" alt="<?= sanitize($produto['titulo']) ?>">
                            <?php else: ?>
                                <div class="product-no-image"><svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div>
                            <?php endif; ?>
                            <?php if ($produto['status'] === 'pronta_entrega'): ?>
                                <span class="product-badge badge-pronta">Pronta Entrega</span>
                            <?php endif; ?>
                        </div>
                        <div class="product-info">
                            <h3><?= sanitize($produto['titulo']) ?></h3>
                            <div class="product-specs">
                                <?php if ($produto['capacidade']): ?>
                                    <span class="spec"><?= number_format($produto['capacidade'], 0, ',', '.') ?>L</span>
                                <?php endif; ?>
                                <?php if (!empty($produto['configuracao'])): ?>
                                    <span class="spec"><?= sanitize($produto['configuracao']) ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="product-bottom">
                                <span class="product-modalidade"><?= sanitize($produto['modalidade'] ?? 'Consulte') ?></span>
                                <span class="product-cta">Ver detalhes</span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: var(--color-on-surface-variant); grid-column: 1/-1; text-align: center; padding: 48px 0;">Em breve novos equipamentos disponíveis.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Produtos por Categoria -->
<?php if (!empty($produtosPorCategoria)): ?>
    <?php foreach ($produtosPorCategoria as $grupo): ?>
    <section class="section-produtos">
        <div class="container">
            <div class="section-header">
                <div>
                    <h2><?= sanitize($grupo['categoria']['nome']) ?></h2>
                    <p><?= count($grupo['produtos']) ?> equipamentos</p>
                </div>
                <a href="/catalogo?categoria=<?= $grupo['categoria']['id'] ?>">Ver todos &rarr;</a>
            </div>
            <div class="products-grid">
                <?php foreach ($grupo['produtos'] as $produto): ?>
                    <a href="/produto/<?= $produto['slug'] ?>" class="product-card">
                        <div class="product-image">
                            <?php if ($produto['imagem_principal']): ?>
                                <img src="<?= url($produto['imagem_principal']) ?>" alt="<?= sanitize($produto['titulo']) ?>">
                            <?php else: ?>
                                <div class="product-no-image"><svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div>
                            <?php endif; ?>
                            <?php if ($produto['status'] === 'pronta_entrega'): ?>
                                <span class="product-badge badge-pronta">Pronta Entrega</span>
                            <?php endif; ?>
                        </div>
                        <div class="product-info">
                            <h3><?= sanitize($produto['titulo']) ?></h3>
                            <div class="product-specs">
                                <?php if ($produto['capacidade']): ?>
                                    <span class="spec"><?= number_format($produto['capacidade'], 0, ',', '.') ?>L</span>
                                <?php endif; ?>
                                <?php if (!empty($produto['configuracao'])): ?>
                                    <span class="spec"><?= sanitize($produto['configuracao']) ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="product-bottom">
                                <span class="product-modalidade"><?= sanitize($produto['modalidade'] ?? 'Consulte') ?></span>
                                <span class="product-cta">Ver detalhes</span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endforeach; ?>
<?php endif; ?>

<!-- Por que a Inova Tanque -->
<section class="section-diferenciais">
    <div class="container">
        <div class="section-header">
            <div>
                <h2>Por que a Inova Tanque?</h2>
            </div>
        </div>
        <div class="diferenciais-grid">
            <div class="diferencial-card">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <div>
                    <h3>Pronta Entrega</h3>
                    <p>Equipamentos disponíveis para retirada imediata. Sem espera.</p>
                </div>
            </div>
            <div class="diferencial-card">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                <div>
                    <h3>Manutenção Própria</h3>
                    <p>Oficina especializada. Checklist de 47 pontos antes de cada entrega.</p>
                </div>
            </div>
            <div class="diferencial-card">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                <div>
                    <h3>Seguro Completo</h3>
                    <p>100% da frota segurada. Substituição imediata em caso de sinistro.</p>
                </div>
            </div>
            <div class="diferencial-card">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <div>
                    <h3>ANTT, INMETRO, NR-13</h3>
                    <p>Toda documentação e certificações em dia. Conformidade garantida.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Clientes -->
<?php if (!empty($parceiros)): ?>
<section class="section-clientes-ecommerce">
    <div class="container">
        <div class="section-header">
            <div>
                <h2>Quem confia na Inova Tanque</h2>
                <p>Grandes transportadoras são nossos clientes</p>
            </div>
        </div>
        <div class="clientes-logos">
            <?php foreach ($parceiros as $parceiro): ?>
                <div class="cliente-logo">
                    <img src="<?= url($parceiro['logo']) ?>" alt="<?= sanitize($parceiro['nome']) ?>">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Depoimentos -->
<?php if (!empty($depoimentos)): ?>
<section style="padding: 64px 0;">
    <div class="container">
        <div class="section-header">
            <div>
                <h2>Avaliações de Clientes</h2>
            </div>
        </div>
        <div class="testimonials-grid">
            <?php foreach (array_slice($depoimentos, 0, 3) as $dep): ?>
                <div class="testimonial-card">
                    <div class="testimonial-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                    <p><?= sanitize($dep['texto']) ?></p>
                    <div class="author">
                        <?php if ($dep['foto']): ?>
                            <img src="<?= url($dep['foto']) ?>" alt="<?= sanitize($dep['nome']) ?>">
                        <?php endif; ?>
                        <div class="author-info">
                            <strong><?= sanitize($dep['nome']) ?></strong>
                            <span><?= sanitize($dep['cargo'] ?? '') ?> <?= $dep['empresa'] ? '— ' . sanitize($dep['empresa']) : '' ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CTA -->
<section class="section-cta-ecommerce">
    <div class="container">
        <div class="cta-box">
            <div class="cta-text">
                <h2>Precisa de uma carreta-tanque?</h2>
                <p>Fale com nosso consultor e receba uma cotação em minutos.</p>
            </div>
            <div class="cta-actions">
                <a href="<?= whatsapp_link(WHATSAPP_PRINCIPAL, 'Olá! Gostaria de uma cotação.') ?>" class="btn btn-whatsapp btn-lg" target="_blank"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg> WhatsApp</a>
                <a href="/contato" class="btn btn-secondary btn-lg">Formulário</a>
            </div>
        </div>
    </div>
</section>

<!-- WhatsApp Flutuante -->
<a href="<?= whatsapp_link(WHATSAPP_PRINCIPAL, 'Olá! Vim pelo site e gostaria de informações.') ?>" class="whatsapp-float" target="_blank" aria-label="Falar no WhatsApp">
    <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
</a>

<?php require APP_ROOT . '/app/views/site/footer.php'; ?>
