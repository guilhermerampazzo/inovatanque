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
                    <div class="container">
                        <div class="hero-content">
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
                </div>

            <?php else: ?>
                <!-- Tipo: cor de fundo + texto + botão -->
                <div class="hero-slide <?= $i === 0 ? 'active' : '' ?>" style="background: <?= sanitize($banner['cor_fundo'] ?? '#1a1a1a') ?>;">
                    <div class="container">
                        <div class="hero-content">
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
                </div>
            <?php endif; ?>

        <?php endforeach; ?>
    <?php else: ?>
        <div class="hero-slide active hero-fallback">
            <div class="container">
                <div class="hero-content">
                    <span class="hero-tag">Disponibilidade Imediata</span>
                    <h2>Carretas-Tanque em Pronta Entrega</h2>
                    <p>Locação e venda com manutenção própria e seguro incluso. Retire hoje mesmo.</p>
                    <div class="hero-actions">
                        <a href="<?= whatsapp_link(WHATSAPP_PRINCIPAL, 'Olá! Quero uma cotação de carreta-tanque.') ?>" class="btn btn-primary btn-lg" target="_blank">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
                            Solicitar Cotação
                        </a>
                        <a href="/catalogo" class="btn btn-outline-light btn-lg">Ver Equipamentos</a>
                    </div>
                </div>
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
                <span>Pronta Entrega Imediata</span>
            </div>
            <div class="highlight-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                <span>Seguro Total Incluso</span>
            </div>
            <div class="highlight-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                <span>Manutenção Própria</span>
            </div>
            <div class="highlight-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
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
                                <span class="product-cta">Solicitar Cotação →</span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: var(--color-text-muted); grid-column: 1/-1; text-align: center; padding: 48px 0;">Em breve novos equipamentos disponíveis.</p>
            <?php endif; ?>
        </div>
    </div>
</section>


<!-- Faixa de Urgência -->
<section class="urgency-bar">
    <div class="container">
        <div class="urgency-content">
            <div class="urgency-text">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <span><strong>Equipamentos com alta procura.</strong> Garanta o seu antes que acabe.</span>
            </div>
            <a href="<?= whatsapp_link(WHATSAPP_PRINCIPAL, 'Olá! Vi no site que vocês têm equipamentos a pronta entrega. Quero garantir o meu!') ?>" class="btn btn-primary btn-sm" target="_blank">Garantir Agora</a>
        </div>
    </div>
</section>

<!-- Por que a Inova Tanque -->
<section class="section-diferenciais">
    <div class="container">
        <div class="section-header">
            <div>
                <h2>Por que a Inova Tanque?</h2>
                <p>O que nos diferencia no mercado</p>
            </div>
        </div>
        <div class="diferenciais-grid">
            <div class="diferencial-card">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <div>
                    <h3>Pronta Entrega</h3>
                    <p>Equipamentos disponíveis para retirada imediata. Sem espera, sem burocracia.</p>
                </div>
            </div>
            <div class="diferencial-card">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                <div>
                    <h3>Manutenção Própria</h3>
                    <p>Oficina especializada com checklist de 47 pontos antes de cada entrega.</p>
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
        <div style="text-align: center; margin-top: 32px;">
            <a href="<?= whatsapp_link(WHATSAPP_PRINCIPAL, 'Olá! Quero saber mais sobre os equipamentos disponíveis.') ?>" class="btn btn-primary btn-lg" target="_blank">Falar com Consultor Agora</a>
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

<!-- Prova Social e Números -->
<section class="section-prova-social">
    <div class="container">
        <div class="prova-social-grid">
            <div class="prova-social-item">
                <div class="prova-numero">500+</div>
                <div class="prova-label">Carretas locadas</div>
            </div>
            <div class="prova-social-item">
                <div class="prova-numero">15</div>
                <div class="prova-label">Anos de mercado</div>
            </div>
            <div class="prova-social-item">
                <div class="prova-numero">200+</div>
                <div class="prova-label">Clientes ativos</div>
            </div>
            <div class="prova-social-item">
                <div class="prova-numero">100%</div>
                <div class="prova-label">Frota segurada</div>
            </div>
        </div>
        <div class="prova-certificacoes">
            <span class="prova-cert-badge">ANTT</span>
            <span class="prova-cert-badge">INMETRO</span>
            <span class="prova-cert-badge">NR-13</span>
            <span class="prova-cert-badge">ISO 9001</span>
        </div>
    </div>
</section>

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
                <h2>Não perca tempo. Garanta sua carreta-tanque hoje.</h2>
                <p>Equipamentos com alta demanda. Fale agora com nosso consultor e receba uma cotação em minutos.</p>
            </div>
            <div class="cta-actions">
                <a href="<?= whatsapp_link(WHATSAPP_PRINCIPAL, 'Olá! Gostaria de uma cotação urgente.') ?>" class="btn btn-whatsapp btn-lg" target="_blank"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg> Cotação pelo WhatsApp</a>
                <a href="/contato" class="btn btn-secondary btn-lg">Solicitar por E-mail</a>
            </div>
        </div>
    </div>
</section>

<!-- WhatsApp Flutuante -->
<a href="<?= whatsapp_link(WHATSAPP_PRINCIPAL, 'Olá! Vim pelo site e gostaria de informações.') ?>" class="whatsapp-float" target="_blank" aria-label="Falar no WhatsApp">
    <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
</a>

<?php require APP_ROOT . '/app/views/site/footer.php'; ?>
