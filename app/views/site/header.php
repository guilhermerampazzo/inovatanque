<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Inova Tanque - Locação e Venda de Carretas-Tanque' ?></title>
    <meta name="description" content="<?= $pageDescription ?? 'Locação e venda de carretas-tanque em Paulínia/SP. Pronta entrega, manutenção própria e seguro incluso.' ?>">
    <link rel="canonical" href="<?= $pageCanonical ?? url($_SERVER['REQUEST_URI']) ?>">

    <!-- Open Graph -->
    <meta property="og:title" content="<?= $pageTitle ?? 'Inova Tanque' ?>">
    <meta property="og:description" content="<?= $pageDescription ?? 'Locação e venda de carretas-tanque em Paulínia/SP. Pronta entrega, manutenção própria e seguro incluso.' ?>">
    <meta property="og:type" content="<?= $ogType ?? 'website' ?>">
    <meta property="og:url" content="<?= $pageCanonical ?? url($_SERVER['REQUEST_URI']) ?>">
    <meta property="og:image" content="<?= $ogImage ?? url('/logo.svg') ?>">
    <meta property="og:site_name" content="Inova Tanque">
    <meta property="og:locale" content="pt_BR">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $pageTitle ?? 'Inova Tanque' ?>">
    <meta name="twitter:description" content="<?= $pageDescription ?? 'Locação e venda de carretas-tanque em Paulínia/SP.' ?>">
    <meta name="twitter:image" content="<?= $ogImage ?? url('/logo.svg') ?>">

    <!-- Schema.org LocalBusiness -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "Inova Tanque",
        "description": "Locação e venda de carretas-tanque em Paulínia/SP",
        "url": "<?= APP_URL ?>",
        "logo": "<?= url('/logonova.svg') ?>",
        "telephone": "<?= TELEFONE ?>",
        "email": "<?= EMAIL_CONTATO ?>",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Rodovia Prof. Zeferino Vaz (SP 332) - KM 125, Santa Terezinha",
            "addressLocality": "Paulínia",
            "addressRegion": "SP",
            "postalCode": "13140-774",
            "addressCountry": "BR"
        },
        "sameAs": [
            "<?= FACEBOOK_URL ?>",
            "<?= INSTAGRAM_URL ?>"
        ]
    }
    </script>
    <?php if (!empty($schemaMarkup)): ?>
    <script type="application/ld+json"><?= $schemaMarkup ?></script>
    <?php endif; ?>

    <!-- Google Tag Manager -->
    <?php $gtmId = Configuracao::get('gtm_id'); ?>
    <?php if ($gtmId): ?>
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','<?= sanitize($gtmId) ?>');</script>
    <?php endif; ?>

    <!-- Meta Pixel -->
    <?php $pixelId = Configuracao::get('meta_pixel_id'); ?>
    <?php if ($pixelId): ?>
    <script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
    n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
    document,'script','https://connect.facebook.net/en_US/fbevents.js');
    fbq('init','<?= sanitize($pixelId) ?>');fbq('track','PageView');</script>
    <?php endif; ?>

    <!-- Google Ads -->
    <?php $gadsId = Configuracao::get('google_ads_id'); ?>
    <?php if ($gadsId): ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= sanitize($gadsId) ?>"></script>
    <script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?= sanitize($gadsId) ?>');</script>
    <?php endif; ?>

    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/components.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/sections.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/responsive.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/pages.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/blog-forms.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- GTM noscript -->
    <?php if ($gtmId): ?>
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?= sanitize($gtmId) ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <?php endif; ?>

    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-inner">
                <a href="/" class="logo">
                    <img src="/logonova.svg" alt="Inova Tanque">
                    <div class="logo-tagline">
                        <span>Soluções em vendas e locações de carretas tanque</span>
                    </div>
                </a>
                <div class="header-actions">
                    <a href="<?= INSTAGRAM_URL ?>" class="btn-header-icon" target="_blank" aria-label="Instagram">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                    </a>
                    <a href="<?= whatsapp_link(WHATSAPP_PRINCIPAL, 'Olá! Gostaria de informações.') ?>" class="btn-header-icon btn-header-icon--whatsapp" target="_blank" aria-label="WhatsApp">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
                    </a>
                    <a href="<?= LINKEDIN_URL ?>" class="btn-header-icon" target="_blank" aria-label="LinkedIn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
                    </a>
                    <button class="btn-header-icon search-toggle" aria-label="Buscar">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </button>
                </div>
                <button class="menu-toggle" aria-label="Abrir menu">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>
    </header>

    <!-- Search Overlay -->
    <div class="search-overlay" id="searchOverlay">
        <div class="search-overlay-inner">
            <form class="search-overlay-form" action="/catalogo" method="GET">
                <input type="text" name="busca" placeholder="Buscar por tipo, capacidade, código..." value="<?= sanitize($_GET['busca'] ?? '') ?>" autofocus>
                <button type="submit" aria-label="Buscar">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </button>
            </form>
            <button class="search-overlay-close" id="searchClose" aria-label="Fechar busca">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
    </div>

    <?php
    // Menu por Configuração (lista fixa) com materiais como subitens.
    // 'like' = termo usado para casar o campo livre 'configuracao' dos produtos.
    $configsFixas = [
        ['label' => 'Carreta Simples', 'valor' => 'carreta',    'like' => 'carreta'],
        ['label' => 'Bitrem',          'valor' => 'bitrem',     'like' => 'bitrem'],
        ['label' => 'Bitrenzão',       'valor' => 'bitrenz',    'like' => 'bitrenz'],
        ['label' => 'Rodotrem',        'valor' => 'rodotrem',   'like' => 'rodotrem'],
        ['label' => 'Vanderleia 3ED',  'valor' => 'vanderleia', 'like' => 'vanderleia'],
    ];
    $menuConfigs = (new Categoria())->getMenuPorConfiguracao($configsFixas);
    ?>

    <!-- Navegação principal -->
    <nav class="categories-bar">
        <div class="container">
            <ul class="categories-list">
                <li><a href="/" class="<?= is_active('/') ?>">Home</a></li>
                <li><a href="/catalogo" class="<?= is_active('/catalogo') ?>">Catálogo</a></li>
                <?php foreach ($menuConfigs as $conf): ?>
                    <li class="has-dropdown">
                        <a href="/catalogo?configuracao=<?= urlencode($conf['valor']) ?>"><?= sanitize($conf['label']) ?></a>
                        <button type="button" class="cat-dropdown-toggle" aria-label="Expandir <?= sanitize($conf['label']) ?>" aria-expanded="false"></button>
                        <ul class="cat-dropdown cat-dropdown--material">
                            <li class="cat-dropdown-title"><?= sanitize($conf['label']) ?></li>
                            <?php foreach ($conf['materiais'] as $mat): ?>
                                <li><a href="/catalogo?configuracao=<?= urlencode($conf['valor']) ?>&categoria=<?= $mat['id'] ?>"><?= sanitize($mat['nome']) ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
                <li><a href="/sobre" class="<?= is_active('/sobre') ?>">Sobre</a></li>
                <li><a href="/blog" class="<?= is_active('/blog') ?>">Blog</a></li>
                <li><a href="/contato" class="<?= is_active('/contato') ?>">Contato</a></li>
            </ul>
        </div>
    </nav>

    <?php $flash_success = Session::flash('success'); ?>
    <?php $flash_error = Session::flash('error'); ?>
    <?php if ($flash_success): ?>
        <div class="alert alert-success"><?= $flash_success ?></div>
    <?php endif; ?>
    <?php if ($flash_error): ?>
        <div class="alert alert-error"><?= $flash_error ?></div>
    <?php endif; ?>

    <main>
