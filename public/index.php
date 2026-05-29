<?php

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/database.php';
require_once APP_ROOT . '/app/core/Autoload.php';
require_once APP_ROOT . '/app/helpers/functions.php';

Session::start();

$router = new Router();

// SEO
$router->get('/sitemap.xml', 'SitemapController', 'index');
$router->get('/robots.txt', 'SitemapController', 'robots');

// Site público
$router->get('/', 'HomeController', 'index');
$router->get('/catalogo', 'CatalogoController', 'index');
$router->get('/produto/{slug}', 'ProdutoController', 'show');
$router->get('/blog', 'BlogController', 'index');
$router->get('/blog/{slug}', 'BlogController', 'show');
$router->get('/sobre', 'PaginaController', 'sobre');
$router->get('/nossa-historia', 'PaginaController', 'nossaHistoria');
$router->get('/contato', 'PaginaController', 'contato');
$router->post('/contato', 'PaginaController', 'enviarContato');
$router->get('/politica-de-privacidade', 'PaginaController', 'privacidade');
$router->get('/termos-de-uso', 'PaginaController', 'termos');
$router->get('/login', 'AuthController', 'loginForm');
$router->post('/login', 'AuthController', 'login');
$router->get('/cadastro', 'AuthController', 'cadastroForm');
$router->post('/cadastro', 'AuthController', 'cadastro');
$router->get('/logout', 'AuthController', 'logout');
$router->get('/recuperar-senha', 'AuthController', 'recuperarForm');
$router->post('/recuperar-senha', 'AuthController', 'recuperar');
$router->post('/cotacao', 'CotacaoController', 'store');

// Área do cliente
$router->get('/cliente/dashboard', 'ClienteController', 'dashboard');
$router->get('/cliente/perfil', 'ClienteController', 'perfil');
$router->post('/cliente/perfil', 'ClienteController', 'atualizarPerfil');
$router->get('/cliente/cotacoes', 'ClienteController', 'cotacoes');
$router->get('/cliente/favoritos', 'ClienteController', 'favoritos');
$router->post('/cliente/favoritar/{id}', 'ClienteController', 'favoritar');
$router->post('/cliente/desfavoritar/{id}', 'ClienteController', 'desfavoritar');

// Painel admin
$router->get('/admin/login', 'AdminAuthController', 'loginForm');
$router->post('/admin/login', 'AdminAuthController', 'login');
$router->get('/admin/logout', 'AdminAuthController', 'logout');
$router->get('/admin', 'AdminDashboardController', 'index');
$router->get('/admin/produtos', 'AdminProdutoController', 'index');
$router->get('/admin/produtos/criar', 'AdminProdutoController', 'create');
$router->post('/admin/produtos/criar', 'AdminProdutoController', 'store');
$router->get('/admin/produtos/editar/{id}', 'AdminProdutoController', 'edit');
$router->post('/admin/produtos/editar/{id}', 'AdminProdutoController', 'update');
$router->post('/admin/produtos/excluir/{id}', 'AdminProdutoController', 'destroy');
$router->get('/admin/categorias', 'AdminCategoriaController', 'index');
$router->get('/admin/categorias/criar', 'AdminCategoriaController', 'create');
$router->post('/admin/categorias/criar', 'AdminCategoriaController', 'store');
$router->get('/admin/categorias/editar/{id}', 'AdminCategoriaController', 'edit');
$router->post('/admin/categorias/editar/{id}', 'AdminCategoriaController', 'update');
$router->post('/admin/categorias/excluir/{id}', 'AdminCategoriaController', 'destroy');
$router->get('/admin/clientes', 'AdminClienteController', 'index');
$router->get('/admin/clientes/{id}', 'AdminClienteController', 'show');
$router->post('/admin/clientes/toggle/{id}', 'AdminClienteController', 'toggle');
$router->get('/admin/cotacoes', 'AdminCotacaoController', 'index');
$router->get('/admin/cotacoes/{id}', 'AdminCotacaoController', 'show');
$router->post('/admin/cotacoes/{id}', 'AdminCotacaoController', 'update');
$router->get('/admin/blog', 'AdminBlogController', 'index');
$router->get('/admin/blog/criar', 'AdminBlogController', 'create');
$router->post('/admin/blog/criar', 'AdminBlogController', 'store');
$router->get('/admin/blog/editar/{id}', 'AdminBlogController', 'edit');
$router->post('/admin/blog/editar/{id}', 'AdminBlogController', 'update');
$router->post('/admin/blog/excluir/{id}', 'AdminBlogController', 'destroy');
$router->get('/admin/banners', 'AdminBannerController', 'index');
$router->get('/admin/banners/criar', 'AdminBannerController', 'create');
$router->post('/admin/banners/criar', 'AdminBannerController', 'store');
$router->get('/admin/banners/editar/{id}', 'AdminBannerController', 'edit');
$router->post('/admin/banners/editar/{id}', 'AdminBannerController', 'update');
$router->post('/admin/banners/excluir/{id}', 'AdminBannerController', 'destroy');
$router->get('/admin/depoimentos', 'AdminDepoimentoController', 'index');
$router->get('/admin/depoimentos/criar', 'AdminDepoimentoController', 'create');
$router->post('/admin/depoimentos/criar', 'AdminDepoimentoController', 'store');
$router->get('/admin/depoimentos/editar/{id}', 'AdminDepoimentoController', 'edit');
$router->post('/admin/depoimentos/editar/{id}', 'AdminDepoimentoController', 'update');
$router->post('/admin/depoimentos/excluir/{id}', 'AdminDepoimentoController', 'destroy');
$router->get('/admin/parceiros', 'AdminParceiroController', 'index');
$router->get('/admin/parceiros/criar', 'AdminParceiroController', 'create');
$router->post('/admin/parceiros/criar', 'AdminParceiroController', 'store');
$router->post('/admin/parceiros/excluir/{id}', 'AdminParceiroController', 'destroy');
$router->get('/admin/paginas', 'AdminPaginaController', 'index');
$router->get('/admin/paginas/editar/{id}', 'AdminPaginaController', 'edit');
$router->post('/admin/paginas/editar/{id}', 'AdminPaginaController', 'update');
$router->post('/admin/upload-imagem', 'AdminConfigController', 'uploadImagem');
$router->get('/admin/configuracoes', 'AdminConfigController', 'index');
$router->post('/admin/configuracoes', 'AdminConfigController', 'update');
$router->get('/admin/usuarios', 'AdminUsuarioController', 'index');
$router->get('/admin/usuarios/criar', 'AdminUsuarioController', 'create');
$router->post('/admin/usuarios/criar', 'AdminUsuarioController', 'store');
$router->get('/admin/usuarios/editar/{id}', 'AdminUsuarioController', 'edit');
$router->post('/admin/usuarios/editar/{id}', 'AdminUsuarioController', 'update');
$router->post('/admin/usuarios/excluir/{id}', 'AdminUsuarioController', 'destroy');

$router->dispatch();
