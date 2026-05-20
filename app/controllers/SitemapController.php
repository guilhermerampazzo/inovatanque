<?php

class SitemapController extends Controller
{
    public function index(): void
    {
        $urls = [];

        // Páginas estáticas
        $urls[] = ['loc' => url('/'), 'priority' => '1.0', 'changefreq' => 'daily'];
        $urls[] = ['loc' => url('/catalogo'), 'priority' => '0.9', 'changefreq' => 'daily'];
        $urls[] = ['loc' => url('/sobre'), 'priority' => '0.5', 'changefreq' => 'monthly'];
        $urls[] = ['loc' => url('/contato'), 'priority' => '0.6', 'changefreq' => 'monthly'];
        $urls[] = ['loc' => url('/blog'), 'priority' => '0.7', 'changefreq' => 'daily'];
        $urls[] = ['loc' => url('/politica-de-privacidade'), 'priority' => '0.3', 'changefreq' => 'yearly'];
        $urls[] = ['loc' => url('/termos-de-uso'), 'priority' => '0.3', 'changefreq' => 'yearly'];

        // Produtos
        $produtoModel = new Produto();
        $produtos = $produtoModel->findAll('created_at DESC');
        foreach ($produtos as $p) {
            $urls[] = [
                'loc' => url('/produto/' . $p['slug']),
                'lastmod' => date('Y-m-d', strtotime($p['created_at'])),
                'priority' => '0.8',
                'changefreq' => 'weekly',
            ];
        }

        // Blog posts
        $postModel = new Post();
        $posts = $postModel->getPublicados([], 1000, 0);
        foreach ($posts as $post) {
            $urls[] = [
                'loc' => url('/blog/' . $post['slug']),
                'lastmod' => date('Y-m-d', strtotime($post['publicado_em'])),
                'priority' => '0.6',
                'changefreq' => 'monthly',
            ];
        }

        header('Content-Type: application/xml; charset=UTF-8');
        require APP_ROOT . '/app/views/site/sitemap.php';
        exit;
    }

    public function robots(): void
    {
        header('Content-Type: text/plain');
        echo "User-agent: *\n";
        echo "Allow: /\n";
        echo "Disallow: /admin/\n";
        echo "Disallow: /cliente/\n";
        echo "Disallow: /login\n";
        echo "Disallow: /cadastro\n\n";
        echo "Sitemap: " . url('/sitemap.xml') . "\n";
        exit;
    }
}
