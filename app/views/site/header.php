<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Inova Tanque - Locação e Venda de Carretas-Tanque' ?></title>
    <meta name="description" content="<?= $pageDescription ?? 'Locação e venda de carretas-tanque em Paulínia/SP. Pronta entrega, manutenção própria e seguro incluso.' ?>">
    <meta property="og:title" content="<?= $pageTitle ?? 'Inova Tanque' ?>">
    <meta property="og:description" content="<?= $pageDescription ?? '' ?>">
    <meta property="og:type" content="website">
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/components.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/sections.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/responsive.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@600;700;800&display=swap" rel="stylesheet">
</head>
<body>
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
