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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <!-- GTM noscript -->
    <?php if ($gtmId): ?>
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?= sanitize($gtmId) ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <?php endif; ?>

    <header class="header">
        <div class="container">
            <div class="header-inner">
                <a href="/" class="logo">
                    <img src="/logo.svg" alt="Inova Tanque">
                </a>
                <nav class="nav-main">
                    <ul>
                        <li><a href="/" class="<?= is_active('/') ?>">Home</a></li>
                        <li class="has-dropdown">
                            <a href="/catalogo" class="<?= is_active('/catalogo') ?>">Catálogo</a>
                            <ul class="dropdown">
                                <li><a href="/catalogo?categoria=1">Aço</a></li>
                                <li><a href="/catalogo?categoria=2">Aço Carbono</a></li>
                                <li><a href="/catalogo?categoria=3">Inox</a></li>
                                <li class="has-dropdown">
                                    <a href="/catalogo?categoria=4">Térmica</a>
                                    <ul class="dropdown-sub">
                                        <li><a href="/catalogo?categoria=5">Asfáltica</a></li>
                                        <li><a href="/catalogo?categoria=6">Vegetal</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="/sobre" class="<?= is_active('/sobre') ?>">Sobre</a></li>
                        <li><a href="/blog" class="<?= is_active('/blog') ?>">Blog</a></li>
                        <li><a href="/contato" class="<?= is_active('/contato') ?>">Contato</a></li>
                    </ul>
                </nav>
                <div class="header-actions">
                    <a href="<?= whatsapp_link(WHATSAPP_PRINCIPAL) ?>" class="btn-whatsapp" target="_blank">
                        <?= TELEFONE ?>
                    </a>
                    <?php if (Session::isLoggedIn()): ?>
                        <a href="/cliente/dashboard" class="btn-area-cliente">Minha Conta</a>
                    <?php else: ?>
                        <a href="/login" class="btn-area-cliente">Entrar</a>
                    <?php endif; ?>
                </div>
                <button class="menu-toggle" aria-label="Abrir menu">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>
    </header>

    <?php $flash_success = Session::flash('success'); ?>
    <?php $flash_error = Session::flash('error'); ?>
    <?php if ($flash_success): ?>
        <div class="alert alert-success"><?= $flash_success ?></div>
    <?php endif; ?>
    <?php if ($flash_error): ?>
        <div class="alert alert-error"><?= $flash_error ?></div>
    <?php endif; ?>

    <main>
