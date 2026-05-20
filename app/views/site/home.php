<?php $pageTitle = 'Inova Tanque - Locação e Venda de Carretas-Tanque | Pronta Entrega'; ?>
<?php $pageDescription = 'Locação e venda de carretas-tanque em Paulínia/SP. Pronta entrega, manutenção própria e seguro incluso. Aço, Inox e Térmica.'; ?>
<?php require APP_ROOT . '/app/views/site/header.php'; ?>

<!-- Hero Carrossel com texto por slide -->
<section class="hero">
    <?php if (!empty($banners)): ?>
        <?php foreach ($banners as $i => $banner): ?>
            <div class="hero-slide <?= $i === 0 ? 'active' : '' ?>">
                <?php if ($banner['imagem']): ?>
                    <img src="<?= url($banner['imagem']) ?>" alt="<?= sanitize($banner['titulo'] ?? 'Inova Tanque') ?>">
                <?php endif; ?>
                <div class="hero-overlay"></div>
                <div class="container hero-content">
                    <?php if ($banner['titulo']): ?>
                        <h2><?= $banner['titulo'] ?></h2>
                    <?php endif; ?>
                    <?php if ($banner['subtitulo']): ?>
                        <p><?= sanitize($banner['subtitulo']) ?></p>
                    <?php endif; ?>
                    <?php if ($banner['cta_texto'] && $banner['cta_link']): ?>
                        <a href="<?= sanitize($banner['cta_link']) ?>" class="btn btn-primary btn-lg"><?= sanitize($banner['cta_texto']) ?></a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="hero-slide active">
            <div class="hero-overlay" style="background: linear-gradient(135deg, var(--color-surface) 0%, rgba(20,19,19,0.6) 100%);"></div>
            <div class="container hero-content">
                <div class="hero-badge">
                    <span class="pulse"></span>
                    <span class="text-label">Disponível Agora</span>
                </div>
                <h2>PRONTA <span class="text-gold">ENTREGA</span></h2>
                <p>Carretas-tanque prontas para operação imediata. Locação com manutenção própria e seguro incluso.</p>
                <a href="/catalogo" class="btn btn-primary btn-lg">Ver Catálogo</a>
            </div>
        </div>
    <?php endif; ?>

    <!-- Indicadores do carrossel -->
    <?php if (count($banners ?? []) > 1): ?>
    <div class="hero-indicators">
        <?php foreach ($banners as $i => $b): ?>
            <button class="hero-dot <?= $i === 0 ? 'active' : '' ?>" data-slide="<?= $i ?>"></button>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</section>

<!-- Pronta Entrega (destaque principal) -->
<section class="section-pronta-entrega">
    <div class="container">
        <div class="section-header">
            <div>
                <h2>Pronta <span class="text-gold">Entrega</span></h2>
                <p>Equipamentos disponíveis para entrega imediata — o diferencial que mais importa para sua operação</p>
            </div>
            <a href="/catalogo?status=pronta_entrega" class="btn btn-secondary">Ver todos &rarr;</a>
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

<!-- Qualidade dos Equipamentos -->
<section class="section-qualidade">
    <div class="container">
        <div class="section-header">
            <div>
                <h2>Qualidade <span class="text-gold">Comprovada</span></h2>
                <p>Diferenciais técnicos que garantem segurança e eficiência na sua operação</p>
            </div>
        </div>
        <div class="quality-grid">
            <div class="quality-card">
                <div class="icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg></div>
                <h3>Manutenção Própria</h3>
                <p>Oficina especializada com equipe técnica dedicada para manutenção preventiva e corretiva de toda a frota.</p>
            </div>
            <div class="quality-card">
                <div class="icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg></div>
                <h3>Checklist Rigoroso</h3>
                <p>Inspeção completa de 47 pontos em cada equipamento antes da entrega ao cliente.</p>
            </div>
            <div class="quality-card">
                <div class="icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
                <h3>Seguro Completo</h3>
                <p>100% da frota com seguro abrangente. Substituição imediata em caso de sinistro.</p>
            </div>
            <div class="quality-card">
                <div class="icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg></div>
                <h3>Parceria Paulitanque</h3>
                <p>Manutenção especializada em parceria com a Paulitanque para máxima qualidade técnica.</p>
            </div>
            <div class="quality-card">
                <div class="icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg></div>
                <h3>Documentação em Dia</h3>
                <p>Licenciamento, ANTT e toda documentação sempre atualizada e regularizada.</p>
            </div>
            <div class="quality-card">
                <div class="icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg></div>
                <h3>Suporte 24h</h3>
                <p>Equipe de suporte técnico disponível 24 horas para emergências operacionais.</p>
            </div>
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

<!-- Clientes (destaque) -->
<?php if (!empty($parceiros)): ?>
<section class="section-clientes">
    <div class="container">
        <div class="section-header" style="text-align: center;">
            <div>
                <span class="text-label text-gold" style="display: block; margin-bottom: 8px;">Quem confia na Inova Tanque</span>
                <h2>Grandes <span class="text-gold">Transportadoras</span> são nossos clientes</h2>
                <p>Empresas líderes do setor de transporte confiam na nossa frota para suas operações diárias</p>
            </div>
        </div>
        <div class="clientes-grid">
            <?php foreach ($parceiros as $parceiro): ?>
                <div class="cliente-logo-card">
                    <img src="<?= url($parceiro['logo']) ?>" alt="<?= sanitize($parceiro['nome']) ?>">
                    <span class="cliente-nome"><?= sanitize($parceiro['nome']) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Depoimentos -->
<?php if (!empty($depoimentos)): ?>
<section class="section-depoimentos">
    <div class="container">
        <div class="section-header">
            <div>
                <h2>O que dizem nossos <span class="text-gold">clientes</span></h2>
                <p>Depoimentos reais de quem opera com nossos equipamentos</p>
            </div>
        </div>
        <div class="testimonials-grid">
            <?php foreach ($depoimentos as $dep): ?>
                <div class="testimonial-card">
                    <div class="testimonial-quote">&ldquo;</div>
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

<!-- Prova Social + Certificações -->
<section class="section-prova-social">
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
        <div class="certificacoes-grid">
            <div class="cert-item">
                <div class="cert-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" y1="22" x2="4" y2="15"/></svg></div>
                <strong>ANTT</strong>
                <span>Registro ativo</span>
            </div>
            <div class="cert-item">
                <div class="cert-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg></div>
                <strong>INMETRO</strong>
                <span>Conformidade atestada</span>
            </div>
            <div class="cert-item">
                <div class="cert-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg></div>
                <strong>NR-13</strong>
                <span>Vasos de pressão</span>
            </div>
            <div class="cert-item">
                <div class="cert-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div>
                <strong>SASSMAQ</strong>
                <span>Segurança no transporte</span>
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
            <a href="<?= whatsapp_link(WHATSAPP_PRINCIPAL, 'Olá! Gostaria de uma cotação.') ?>" class="btn btn-whatsapp btn-lg" target="_blank"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg> WhatsApp</a>
            <a href="/contato" class="btn btn-secondary btn-lg">Formulário de Contato</a>
        </div>
    </div>
</section>

<?php require APP_ROOT . '/app/views/site/footer.php'; ?>
