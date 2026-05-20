<?php $pageTitle = 'Inova Tanque - Locação e Venda de Carretas-Tanque | Pronta Entrega'; ?>
<?php $pageDescription = 'Locação e venda de carretas-tanque em Paulínia/SP. Pronta entrega, manutenção própria e seguro incluso. Aço, Inox e Térmica.'; ?>
<?php require APP_ROOT . '/app/views/site/header.php'; ?>

<!-- Hero Carrossel -->
<section class="hero">
    <?php if (!empty($banners)): ?>
        <?php foreach ($banners as $i => $banner): ?>
            <div class="hero-slide <?= $i === 0 ? 'active' : '' ?>">
                <img src="<?= url($banner['imagem']) ?>" alt="<?= sanitize($banner['titulo'] ?? 'Inova Tanque') ?>">
                <div class="hero-overlay"></div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="hero-slide active">
            <div class="hero-overlay" style="background: linear-gradient(135deg, var(--color-surface) 0%, rgba(20,19,19,0.6) 100%);"></div>
        </div>
    <?php endif; ?>

    <div class="container hero-content">
        <div class="hero-badge">
            <span class="pulse"></span>
            <span class="text-label">Disponível Agora</span>
        </div>
        <h1>PRONTA <span class="text-gold">ENTREGA</span></h1>
        <p>Carretas-tanque prontas para operação imediata. Locação, venda e consignação com manutenção própria e seguro incluso.</p>
        <div class="hero-buttons">
            <a href="<?= whatsapp_link(WHATSAPP_PRINCIPAL, 'Olá! Gostaria de informações sobre carretas-tanque disponíveis.') ?>" class="btn btn-primary btn-lg" target="_blank">Falar com Consultor</a>
            <a href="/catalogo" class="btn btn-secondary btn-lg">Ver Catálogo</a>
        </div>
    </div>
</section>

<!-- Pronta Entrega -->
<section class="section-pronta-entrega">
    <div class="container">
        <div class="section-header">
            <div>
                <h2>Pronta Entrega</h2>
                <p>Equipamentos disponíveis para entrega imediata</p>
            </div>
            <a href="/catalogo?status=pronta_entrega">Ver todos &rarr;</a>
        </div>
        <div class="products-grid">
            <?php if (!empty($destaques)): ?>
                <?php foreach (array_slice($destaques, 0, 6) as $produto): ?>
                    <a href="/produto/<?= $produto['slug'] ?>" class="card-metallic">
                        <div class="card-image">
                            <?php if ($produto['imagem_principal']): ?>
                                <img src="<?= url($produto['imagem_principal']) ?>" alt="<?= sanitize($produto['titulo']) ?>">
                            <?php endif; ?>
                            <?php if ($produto['status'] === 'pronta_entrega'): ?>
                                <div class="card-badge"><span>Pronta Entrega</span></div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <h3><?= sanitize($produto['titulo']) ?></h3>
                            <p><?= $produto['capacidade'] ? number_format($produto['capacidade'], 0, ',', '.') . 'L' : '' ?> <?= sanitize($produto['configuracao'] ?? '') ?></p>
                            <div class="card-footer">
                                <span class="text-label"><?= sanitize($produto['modalidade'] ?? 'Consulte') ?></span>
                                <span class="btn btn-secondary" style="padding: 6px 12px; font-size: 12px;">Detalhes</span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: var(--color-on-surface-variant); grid-column: 1/-1; text-align: center;">Em breve novos equipamentos disponíveis.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Locação (foco principal) -->
<section class="section-locacao">
    <div class="container">
        <div class="locacao-content">
            <div>
                <h2>Locação de <span class="text-gold">Carretas-Tanque</span></h2>
                <p>Soluções flexíveis de locação para sua operação. Frota própria com manutenção inclusa, seguro completo e suporte técnico dedicado.</p>
                <ul class="locacao-features">
                    <li>Contratos flexíveis de curto e longo prazo</li>
                    <li>Manutenção preventiva e corretiva inclusa</li>
                    <li>Seguro completo da frota</li>
                    <li>Substituição imediata em caso de sinistro</li>
                    <li>Documentação e licenciamento em dia</li>
                    <li>Suporte técnico 24h</li>
                </ul>
                <a href="<?= whatsapp_link(WHATSAPP_PRINCIPAL, 'Olá! Gostaria de uma cotação de locação de carreta-tanque.') ?>" class="btn btn-primary btn-lg" target="_blank">Solicitar Cotação</a>
            </div>
            <div style="background: var(--color-surface-high); border-radius: var(--radius-lg); min-height: 400px; display: flex; align-items: center; justify-content: center;">
                <img src="/logo.svg" alt="Inova Tanque" style="max-width: 200px; opacity: 0.3;">
            </div>
        </div>
    </div>
</section>

<!-- Qualidade dos Equipamentos -->
<section>
    <div class="container">
        <div class="section-header">
            <div>
                <h2>Qualidade dos Equipamentos</h2>
                <p>Diferenciais técnicos que garantem segurança e eficiência</p>
            </div>
        </div>
        <div class="quality-grid">
            <div class="quality-card">
                <div class="icon">&#9881;</div>
                <h3>Manutenção Própria</h3>
                <p>Oficina especializada com equipe técnica dedicada para manutenção preventiva e corretiva.</p>
            </div>
            <div class="quality-card">
                <div class="icon">&#9989;</div>
                <h3>Checklist Rigoroso</h3>
                <p>Inspeção completa em cada equipamento antes da entrega ao cliente.</p>
            </div>
            <div class="quality-card">
                <div class="icon">&#128737;</div>
                <h3>Seguro Completo</h3>
                <p>Toda a frota com seguro abrangente para sua tranquilidade operacional.</p>
            </div>
            <div class="quality-card">
                <div class="icon">&#128295;</div>
                <h3>Parceria Paulitanque</h3>
                <p>Manutenção especializada em parceria com a Paulitanque para máxima qualidade.</p>
            </div>
        </div>
    </div>
</section>

<!-- Clientes / Parceiros -->
<?php if (!empty($parceiros)): ?>
<section>
    <div class="container">
        <div class="section-header">
            <div>
                <h2>Nossos Clientes</h2>
                <p>Transportadoras que confiam na Inova Tanque</p>
            </div>
        </div>
        <div class="partners-grid">
            <?php foreach ($parceiros as $parceiro): ?>
                <img src="<?= url($parceiro['logo']) ?>" alt="<?= sanitize($parceiro['nome']) ?>">
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Depoimentos -->
<?php if (!empty($depoimentos)): ?>
<section style="background: var(--color-surface-container);">
    <div class="container">
        <div class="section-header">
            <div>
                <h2>O que dizem nossos clientes</h2>
                <p>Depoimentos de quem confia no nosso trabalho</p>
            </div>
        </div>
        <div class="testimonials-grid">
            <?php foreach ($depoimentos as $dep): ?>
                <div class="testimonial-card">
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

<!-- Prova Social / Números -->
<section>
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="number">15+</div>
                <div class="label">Anos de Mercado</div>
            </div>
            <div class="stat-item">
                <div class="number">200+</div>
                <div class="label">Equipamentos na Frota</div>
            </div>
            <div class="stat-item">
                <div class="number">500+</div>
                <div class="label">Clientes Atendidos</div>
            </div>
            <div class="stat-item">
                <div class="number">100%</div>
                <div class="label">Frota Segurada</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Final -->
<section class="section-cta">
    <div class="container">
        <h2>Precisa de uma <span class="text-gold">carreta-tanque</span>?</h2>
        <p>Entre em contato agora e receba uma cotação personalizada para locação ou compra.</p>
        <div class="cta-buttons">
            <a href="<?= whatsapp_link(WHATSAPP_PRINCIPAL, 'Olá! Gostaria de uma cotação.') ?>" class="btn btn-whatsapp btn-lg" target="_blank">WhatsApp</a>
            <a href="/contato" class="btn btn-secondary btn-lg">Formulário de Contato</a>
        </div>
    </div>
</section>

<?php require APP_ROOT . '/app/views/site/footer.php'; ?>
