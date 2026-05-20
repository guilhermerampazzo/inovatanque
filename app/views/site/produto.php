<?php $pageTitle = sanitize($produto['titulo']) . ' - Inova Tanque'; ?>
<?php $pageDescription = sanitize($produto['titulo']) . ' - ' . ($produto['capacidade'] ? number_format($produto['capacidade'], 0, ',', '.') . 'L' : '') . '. Locação e venda de carretas-tanque.'; ?>
<?php $ogImage = !empty($imagens) ? url($imagens[0]['arquivo']) : null; ?>
<?php $ogType = 'product'; ?>
<?php $schemaMarkup = json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    'name' => $produto['titulo'],
    'description' => $pageDescription,
    'image' => !empty($imagens) ? url($imagens[0]['arquivo']) : '',
    'brand' => ['@type' => 'Brand', 'name' => 'Inova Tanque'],
    'offers' => [
        '@type' => 'Offer',
        'availability' => $produto['disponivel'] ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
        'priceCurrency' => 'BRL',
        'url' => url('/produto/' . $produto['slug']),
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>
<?php require APP_ROOT . '/app/views/site/header.php'; ?>

<section style="padding-top: 32px; padding-bottom: 96px;">
    <div class="container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a href="/">Home</a>
            <span>/</span>
            <a href="/catalogo">Catálogo</a>
            <span>/</span>
            <span style="color: var(--color-on-surface);"><?= sanitize($produto['titulo']) ?></span>
        </nav>

        <!-- Produto -->
        <div class="produto-layout">
            <!-- Galeria -->
            <div class="produto-gallery">
                <div class="main-image" id="mainImage">
                    <?php if (!empty($imagens)): ?>
                        <img src="<?= url($imagens[0]['arquivo']) ?>" alt="<?= sanitize($produto['titulo']) ?>" id="mainImg">
                    <?php endif; ?>
                </div>
                <?php if (count($imagens) > 1): ?>
                    <div class="thumbnails">
                        <?php foreach ($imagens as $i => $img): ?>
                            <img src="<?= url($img['arquivo']) ?>" alt="Imagem <?= $i + 1 ?>" class="<?= $i === 0 ? 'active' : '' ?>" onclick="changeImage(this, '<?= url($img['arquivo']) ?>')">
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Info -->
            <div class="produto-info">
                <h1><?= sanitize($produto['titulo']) ?></h1>
                <?php if ($produto['codigo']): ?>
                    <p class="sku">Código: <?= sanitize($produto['codigo']) ?></p>
                <?php endif; ?>

                <?php if ($produto['status'] === 'pronta_entrega'): ?>
                    <div style="display: inline-flex; align-items: center; gap: 8px; padding: 6px 12px; background: rgba(245, 176, 65, 0.1); border: 1px solid rgba(245, 176, 65, 0.3); border-radius: var(--radius-md); margin-bottom: 24px;">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: var(--color-gold);"></span>
                        <span style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: var(--color-gold);">Pronta Entrega</span>
                    </div>
                <?php endif; ?>

                <!-- Ficha Técnica -->
                <table class="produto-specs">
                    <?php if ($produto['configuracao']): ?>
                        <tr><td>Configuração</td><td><?= sanitize($produto['configuracao']) ?></td></tr>
                    <?php endif; ?>
                    <?php if ($produto['capacidade']): ?>
                        <tr><td>Capacidade</td><td><?= number_format($produto['capacidade'], 0, ',', '.') ?> litros</td></tr>
                    <?php endif; ?>
                    <?php if ($produto['ano']): ?>
                        <tr><td>Ano</td><td><?= $produto['ano'] ?></td></tr>
                    <?php endif; ?>
                    <?php if ($produto['fabricante']): ?>
                        <tr><td>Fabricante</td><td><?= sanitize($produto['fabricante']) ?></td></tr>
                    <?php endif; ?>
                    <?php if ($produto['carregamento']): ?>
                        <tr><td>Carregamento</td><td><?= ucfirst($produto['carregamento']) ?></td></tr>
                    <?php endif; ?>
                    <?php if ($produto['modalidade']): ?>
                        <tr><td>Modalidade</td><td><?= sanitize($produto['modalidade']) ?></td></tr>
                    <?php endif; ?>
                </table>

                <!-- CTAs -->
                <div class="produto-ctas">
                    <?php
                    $whatsMsg = str_replace(
                        ['{produto}', '{codigo}'],
                        [$produto['titulo'], $produto['codigo'] ?? ''],
                        'Olá! Tenho interesse no produto: {produto} (Código: {codigo}). Gostaria de mais informações.'
                    );
                    ?>
                    <a href="<?= whatsapp_link(WHATSAPP_PRINCIPAL, $whatsMsg) ?>" class="btn btn-whatsapp btn-lg" target="_blank">WhatsApp</a>
                    <button class="btn btn-primary btn-lg" onclick="document.getElementById('cotacaoModal').style.display='flex'">Solicitar Cotação</button>
                </div>

                <?php if (Session::isLoggedIn()): ?>
                    <form method="POST" action="/cliente/favoritar/<?= $produto['id'] ?>" style="margin-top: 16px;">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-secondary" style="width: 100%;">&#9825; Adicionar aos Favoritos</button>
                    </form>
                <?php endif; ?>

                <!-- Descrição -->
                <?php if ($produto['descricao']): ?>
                    <div class="produto-descricao">
                        <h2>Descrição</h2>
                        <div><?= $produto['descricao'] ?></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Produtos Relacionados -->
        <?php if (!empty($relacionados)): ?>
            <div style="margin-top: 64px;">
                <div class="section-header">
                    <div>
                        <h2>Produtos Relacionados</h2>
                    </div>
                    <a href="/catalogo">Ver todos &rarr;</a>
                </div>
                <div class="products-grid" style="grid-template-columns: repeat(4, 1fr);">
                    <?php foreach ($relacionados as $rel): ?>
                        <a href="/produto/<?= $rel['slug'] ?>" class="card-metallic">
                            <div class="card-image">
                                <?php if (!empty($rel['imagem_principal'])): ?>
                                    <img src="<?= url($rel['imagem_principal']) ?>" alt="<?= sanitize($rel['titulo']) ?>">
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <h3><?= sanitize($rel['titulo']) ?></h3>
                                <p><?= $rel['capacidade'] ? number_format($rel['capacidade'], 0, ',', '.') . 'L' : '' ?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Modal Cotação -->
<div id="cotacaoModal" style="display: none; position: fixed; inset: 0; z-index: 1000; background: rgba(0,0,0,0.8); align-items: center; justify-content: center; padding: 16px;">
    <div style="background: var(--color-surface-container); border: 1px solid var(--color-outline-variant); border-radius: var(--radius-lg); padding: 32px; max-width: 500px; width: 100%; position: relative;">
        <button onclick="document.getElementById('cotacaoModal').style.display='none'" style="position: absolute; top: 16px; right: 16px; background: none; border: none; color: var(--color-on-surface-variant); font-size: 24px; cursor: pointer;">&times;</button>
        <h3 style="font-family: var(--font-display); font-size: 20px; font-weight: 600; color: var(--color-primary); margin-bottom: 24px;">Solicitar Cotação</h3>
        <form method="POST" action="/cotacao">
            <?= csrf_field() ?>
            <input type="hidden" name="produto_id" value="<?= $produto['id'] ?>">
            <?php if (!Session::isLoggedIn()): ?>
                <div style="margin-bottom: 16px;">
                    <input type="text" name="nome" placeholder="Seu nome *" required style="width: 100%; padding: 12px; background: var(--color-surface); border: 1px solid var(--color-outline-variant); border-radius: var(--radius-md); color: var(--color-on-surface); font-size: 14px;">
                </div>
                <div style="margin-bottom: 16px;">
                    <input type="email" name="email" placeholder="Seu e-mail *" required style="width: 100%; padding: 12px; background: var(--color-surface); border: 1px solid var(--color-outline-variant); border-radius: var(--radius-md); color: var(--color-on-surface); font-size: 14px;">
                </div>
                <div style="margin-bottom: 16px;">
                    <input type="tel" name="telefone" placeholder="Telefone" style="width: 100%; padding: 12px; background: var(--color-surface); border: 1px solid var(--color-outline-variant); border-radius: var(--radius-md); color: var(--color-on-surface); font-size: 14px;">
                </div>
            <?php else: ?>
                <input type="hidden" name="nome" value="<?= Session::get('cliente_nome') ?>">
                <input type="hidden" name="email" value="">
            <?php endif; ?>
            <div style="margin-bottom: 16px;">
                <textarea name="mensagem" placeholder="Mensagem (opcional)" rows="3" style="width: 100%; padding: 12px; background: var(--color-surface); border: 1px solid var(--color-outline-variant); border-radius: var(--radius-md); color: var(--color-on-surface); font-size: 14px; resize: vertical;"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Enviar Cotação</button>
        </form>
    </div>
</div>

<script>
function changeImage(thumb, src) {
    document.getElementById('mainImg').src = src;
    document.querySelectorAll('.thumbnails img').forEach(function(img) {
        img.classList.remove('active');
    });
    thumb.classList.add('active');
}
</script>

<?php require APP_ROOT . '/app/views/site/footer.php'; ?>
