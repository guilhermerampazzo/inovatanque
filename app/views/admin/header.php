<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Painel Admin' ?> - Inova Tanque</title>
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/components.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/sections.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/blog-forms.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="admin-layout">
        <aside class="admin-sidebar">
            <div class="admin-logo">
                <img src="/logo.svg" alt="Inova Tanque">
            </div>
            <nav>
                <a href="/admin" class="<?= is_active('/admin') ?>">Dashboard</a>
                <a href="/admin/produtos" class="<?= is_active('/admin/produtos') ?>">Produtos</a>
                <a href="/admin/categorias" class="<?= is_active('/admin/categorias') ?>">Categorias</a>
                <a href="/admin/cotacoes" class="<?= is_active('/admin/cotacoes') ?>">Cotações</a>
                <a href="/admin/clientes" class="<?= is_active('/admin/clientes') ?>">Clientes</a>
                <a href="/admin/blog" class="<?= is_active('/admin/blog') ?>">Blog</a>
                <a href="/admin/banners" class="<?= is_active('/admin/banners') ?>">Banners</a>
                <a href="/admin/depoimentos" class="<?= is_active('/admin/depoimentos') ?>">Depoimentos</a>
                <a href="/admin/parceiros" class="<?= is_active('/admin/parceiros') ?>">Parceiros</a>
                <a href="/admin/paginas" class="<?= is_active('/admin/paginas') ?>">Páginas</a>
                <a href="/admin/configuracoes" class="<?= is_active('/admin/configuracoes') ?>">Configurações</a>
                <a href="/admin/usuarios" class="<?= is_active('/admin/usuarios') ?>">Usuários</a>
                <a href="/admin/logout">Sair</a>
            </nav>
        </aside>
        <main class="admin-main">
            <?php $flash_success = Session::flash('success'); ?>
            <?php $flash_error = Session::flash('error'); ?>
            <?php if ($flash_success): ?>
                <div class="alert alert-success"><?= $flash_success ?></div>
            <?php endif; ?>
            <?php if ($flash_error): ?>
                <div class="alert alert-error"><?= $flash_error ?></div>
            <?php endif; ?>
