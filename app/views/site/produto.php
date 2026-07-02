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
        'availability' => ($produto['status'] === 'disponivel' || $produto['status'] === 'pronta_entrega') ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
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
            <span style="color: var(--color-text);"><?= sanitize($produto['titulo']) ?></span>
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
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: var(--color-accent);"></span>
                        <span style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: var(--color-accent);">Pronta Entrega</span>
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

                <!-- Compartilhar -->
                <div class="produto-share">
                    <span>Compartilhar:</span>
                    <a href="https://api.whatsapp.com/send?text=<?= urlencode($produto['titulo'] . ' - ' . url('/produto/' . $produto['slug'])) ?>" target="_blank" rel="noopener" class="produto-share-btn produto-share-btn--whatsapp" aria-label="Compartilhar no WhatsApp">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(url('/produto/' . $produto['slug'])) ?>" target="_blank" rel="noopener" class="produto-share-btn produto-share-btn--facebook" aria-label="Compartilhar no Facebook">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode(url('/produto/' . $produto['slug'])) ?>" target="_blank" rel="noopener" class="produto-share-btn produto-share-btn--linkedin" aria-label="Compartilhar no LinkedIn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
                    </a>
                    <button onclick="if(navigator.share){navigator.share({title:'<?= addslashes(sanitize($produto['titulo'])) ?>',url:window.location.href})}" class="produto-share-btn" aria-label="Compartilhar" style="display: navigator.canShare ? 'flex' : 'none'">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                    </button>
                </div>

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
                <div class="products-grid">
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
<div id="cotacaoModal" style="display: none; position: fixed; inset: 0; z-index: 1000; background: rgba(0,0,0,0.7); align-items: center; justify-content: center; padding: 16px;" onclick="if(event.target===this)closeCotacaoModal()">
    <div style="background: var(--color-bg); border: 1px solid var(--color-border); border-radius: var(--radius-lg); padding: 32px; max-width: 500px; width: 100%; position: relative; box-shadow: var(--shadow-lg);">
        <button type="button" onclick="closeCotacaoModal()" aria-label="Fechar" style="position: absolute; top: 16px; right: 16px; background: none; border: none; color: var(--color-text-secondary); font-size: 24px; cursor: pointer; line-height: 1;">&times;</button>
        <h3 style="font-size: 20px; font-weight: 600; color: var(--color-text); margin-bottom: 24px;">Solicitar Cotação</h3>
        <form method="POST" action="/cotacao">
            <?= csrf_field() ?>
            <input type="hidden" name="produto_id" value="<?= $produto['id'] ?>">
            <?php if (!Session::isLoggedIn()): ?>
                <div style="margin-bottom: 16px;">
                    <input type="text" name="nome" placeholder="Seu nome *" required style="width: 100%; padding: 12px; background: var(--color-muted); border: 1px solid var(--color-border); border-radius: var(--radius-md); color: var(--color-text); font-size: 14px;">
                </div>
                <div style="margin-bottom: 16px;">
                    <input type="email" name="email" placeholder="Seu e-mail *" required style="width: 100%; padding: 12px; background: var(--color-muted); border: 1px solid var(--color-border); border-radius: var(--radius-md); color: var(--color-text); font-size: 14px;">
                </div>
                <div style="margin-bottom: 16px;">
                    <input type="tel" name="telefone" placeholder="Telefone" style="width: 100%; padding: 12px; background: var(--color-muted); border: 1px solid var(--color-border); border-radius: var(--radius-md); color: var(--color-text); font-size: 14px;">
                </div>
            <?php else: ?>
                <input type="hidden" name="nome" value="<?= Session::get('cliente_nome') ?>">
                <input type="hidden" name="email" value="">
            <?php endif; ?>
            <div style="margin-bottom: 16px;">
                <textarea name="mensagem" placeholder="Mensagem (opcional)" rows="3" style="width: 100%; padding: 12px; background: var(--color-muted); border: 1px solid var(--color-border); border-radius: var(--radius-md); color: var(--color-text); font-size: 14px; resize: vertical;"></textarea>
            </div>
            <div style="display: flex; gap: 12px;">
                <button type="button" class="btn btn-secondary" style="flex: 1;" onclick="closeCotacaoModal()">Cancelar</button>
                <button type="submit" class="btn btn-primary" style="flex: 1;">Enviar Cotação</button>
            </div>
        </form>
    </div>
</div>

<script>
function closeCotacaoModal() {
    document.getElementById('cotacaoModal').style.display = 'none';
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        var modal = document.getElementById('cotacaoModal');
        if (modal && modal.style.display !== 'none' && modal.style.display !== '') {
            closeCotacaoModal();
        }
    }
});
function changeImage(thumb, src) {
    document.getElementById('mainImg').src = src;
    document.querySelectorAll('.thumbnails img').forEach(function(img) {
        img.classList.remove('active');
    });
    thumb.classList.add('active');
}
</script>

<?php require APP_ROOT . '/app/views/site/footer.php'; ?>
