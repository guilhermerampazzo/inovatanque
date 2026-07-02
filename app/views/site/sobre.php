<?php $pageTitle = 'Sobre Nós - Inova Tanque | Locação e Venda de Carretas-Tanque'; ?>
<?php $pageDescription = 'Conheça a Inova Tanque. Localizada em Paulínia/SP, próximo a um dos maiores polos petroquímicos do país. Locação e venda de carretas-tanque para transporte de líquidos.'; ?>
<?php require APP_ROOT . '/app/views/site/header.php'; ?>

<section style="padding-top: 48px; padding-bottom: 96px;">
    <div class="container">
        <div class="sobre-grid">
            <div class="sobre-content">
                <div class="section-header" style="margin-bottom: 20px;">
                    <div>
                        <h2>Sobre Nós</h2>
                        <p>Soluções em vendas e locações de carretas-tanque</p>
                    </div>
                </div>

                <?php if (!empty($pagina['conteudo'])): ?>
                    <?= $pagina['conteudo'] ?>
                <?php else: ?>
                    <p>A <strong>Inova Tanque</strong> está localizada estrategicamente na cidade de Paulínia, próximo a um dos maiores polos petroquímicos do país. Atuamos na área de locação e venda dos implementos rodoviários tanques, incluindo todos os tipos de transportes de líquidos.</p>

                    <p>Sempre buscando solucionar as necessidades do mercado e com uma equipe de manutenção sempre pronta para fazer as entregas com qualidade de seus equipamentos.</p>

                    <h3>Tipos de Equipamentos</h3>
                    <p>Trabalhamos com uma ampla variedade de implementos rodoviários para atender diferentes segmentos do transporte de cargas:</p>
                    <ul>
                        <li>Aço Inox</li>
                        <li>Asfáltica</li>
                        <li>Graneleira</li>
                        <li>Aço Carbono</li>
                        <li>Alumínio</li>
                        <li>Sider</li>
                        <li>Térmicas</li>
                        <li>Tanque para Chassis</li>
                    </ul>

                    <h3>Nossos Diferenciais</h3>
                    <ul>
                        <li><strong>Pronta entrega</strong> — equipamentos disponíveis para retirada imediata.</li>
                        <li><strong>Manutenção própria</strong> — em parceria com a Paulitanque, especializada em manutenção de carreta-tanque.</li>
                        <li><strong>Seguro incluso</strong> — frota 100% segurada.</li>
                        <li><strong>Documentação em dia</strong> — ANTT, INMETRO e NR-13.</li>
                        <li><strong>Localização estratégica</strong> — Paulínia/SP, próximo ao maior polo petroquímico do país.</li>
                    </ul>

                    <p style="margin-top: 32px;">
                        <a href="/contato" class="btn btn-primary">Fale Conosco</a>
                        <a href="/catalogo" class="btn btn-secondary">Ver Equipamentos</a>
                    </p>
                <?php endif; ?>
            </div>

            <div class="sobre-media">
                <div class="sobre-map">
                    <iframe
                        src="https://maps.google.com/maps?q=-22.7945201,-47.1351713&z=15&hl=pt-BR&output=embed"
                        title="Localização da Inova Tanque no Google Maps"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen>
                    </iframe>
                </div>
                <div class="sobre-map-endereco">
                    <strong>Rodovia Professor Zeferino Vaz (SP 332) — KM 125</strong>
                    <span>Santa Terezinha, Paulínia - SP, CEP 13140-774</span>
                    <a href="https://www.google.com/maps?q=-22.7945201,-47.1351713" target="_blank" rel="noopener">Ver no Google Maps →</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require APP_ROOT . '/app/views/site/footer.php'; ?>
