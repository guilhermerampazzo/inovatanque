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
        "logo": "<?= url('/logo.svg') ?>",
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
                    <img src="/logo.svg" alt="Inova Tanque">
                </a>
                <form class="header-search" action="/catalogo" method="GET">
                    <input type="text" name="busca" placeholder="Buscar carretas-tanque por tipo, capacidade..." value="<?= sanitize($_GET['busca'] ?? '') ?>">
                    <button type="submit"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></button>
                </form>
                <div class="header-actions">
                    <a href="<?= whatsapp_link(WHATSAPP_PRINCIPAL, 'Olá! Gostaria de informações.') ?>" class="btn-header-whatsapp" target="_blank">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
                        <span>WhatsApp</span>
                    </a>
                    <?php if (Session::isLoggedIn()): ?>
                        <a href="/cliente/dashboard" class="btn-header-account"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg> Minha Conta</a>
                    <?php else: ?>
                        <a href="/login" class="btn-header-account"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg> Entrar</a>
                    <?php endif; ?>
                </div>
                <button class="menu-toggle" aria-label="Abrir menu">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>
    </header>

    <!-- Categorias -->
    <nav class="categories-bar">
        <div class="container">
            <ul class="categories-list">
                <li><a href="/catalogo" class="<?= is_active('/catalogo') ?>">Todos</a></li>
                <li><a href="/catalogo?categoria=1">Aço</a></li>
                <li><a href="/catalogo?categoria=2">Aço Carbono</a></li>
                <li><a href="/catalogo?categoria=3">Inox</a></li>
                <li class="has-dropdown">
                    <a href="/catalogo?categoria=4">Térmica</a>
                    <ul class="cat-dropdown">
                        <li><a href="/catalogo?categoria=5">Asfáltica</a></li>
                        <li><a href="/catalogo?categoria=6">Vegetal</a></li>
                    </ul>
                </li>
                <li class="cat-separator"></li>
                <li><a href="/sobre">Sobre</a></li>
                <li><a href="/nossa-historia">Nossa História</a></li>
                <li><a href="/blog">Blog</a></li>
                <li><a href="/contato">Contato</a></li>
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
