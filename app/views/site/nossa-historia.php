<?php $pageTitle = 'Nossa História - Inova Tanque'; ?>
<?php $pageDescription = 'A história da Inova Tanque: desde 2009 trazendo soluções para o ramo de transportes, com locação e venda de carretas-tanque em Paulínia/SP.'; ?>
<?php require APP_ROOT . '/app/views/site/header.php'; ?>

<section style="padding-top: 48px; padding-bottom: 96px;">
    <div class="container">
        <div class="section-header" style="margin-bottom: 48px;">
            <div>
                <h2>Nossa História</h2>
                <p>Força, coragem e inovação — como uma Pantera Negra</p>
            </div>
        </div>

        <div class="blog-post-layout">
            <div class="blog-post-content">
                <?php if (!empty($pagina['conteudo'])): ?>
                    <?= $pagina['conteudo'] ?>
                <?php else: ?>
                    <p>A <strong>Inova Tanque</strong> com força e coragem, assim como uma <em>Pantera Negra</em>, apresenta-se ao mercado com uma nova "cara", porém com a mesma qualidade e inovação.</p>

                    <p>Nossa jornada teve início em <strong>2009</strong>, trazendo soluções para o ramo de transportes, atuando na área de locação e vendas de carreta-tanque.</p>

                    <p>O fundador conta com uma experiência de <strong>27 anos</strong> atuando no ramo de transportes e manutenção de carreta-tanque. Esse caminho de experiência e conhecimento foi trilhado juntamente com a empresa <strong>Paulitanque</strong>, especializada em manutenção de carreta-tanque, que segue sendo nossa parceira.</p>

                    <h3>Marcos da nossa jornada</h3>
                    <ul>
                        <li><strong>2009</strong> — Fundação da Inova Tanque, em Paulínia/SP.</li>
                        <li><strong>27 anos</strong> — Experiência acumulada do fundador no setor.</li>
                        <li><strong>Parceria Paulitanque</strong> — Manutenção especializada como base da nossa qualidade.</li>
                        <li><strong>Hoje</strong> — Frota com pronta entrega, 100% segurada, atendendo as principais transportadoras do país.</li>
                    </ul>

                    <h3>Nossa essência</h3>
                    <p>A renovação visual da marca traz a identidade da Pantera Negra — símbolo de agilidade, resistência e adaptação. Mantemos a essência que nos trouxe até aqui: qualidade na manutenção, agilidade na entrega e compromisso com o cliente.</p>

                    <p style="margin-top: 32px;">
                        <a href="/catalogo" class="btn btn-primary">Ver Equipamentos Disponíveis</a>
                        <a href="/contato" class="btn btn-secondary">Fale Conosco</a>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php require APP_ROOT . '/app/views/site/footer.php'; ?>
