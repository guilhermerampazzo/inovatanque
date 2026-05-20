<?php

class BlogController extends Controller
{
    public function index(): void
    {
        $postModel = new Post();
        $categoriaModel = new PostCategoria();

        $page = (int) ($_GET['page'] ?? 1);
        $categoriaSlug = $_GET['categoria'] ?? null;

        $filters = [];
        if ($categoriaSlug) {
            $cat = $categoriaModel->findBy('slug', $categoriaSlug);
            if ($cat) {
                $filters['categoria_id'] = $cat['id'];
            }
        }

        $total = $postModel->countPublicados($filters);
        $pagination = paginate($total, ITEMS_PER_PAGE, $page);
        $posts = $postModel->getPublicados($filters, ITEMS_PER_PAGE, $pagination['offset']);
        $categorias = $categoriaModel->findAll('nome ASC');
        $recentes = $postModel->getRecentes(5);

        $this->view('site/blog', compact('posts', 'categorias', 'pagination', 'recentes'));
    }

    public function show(string $slug): void
    {
        $postModel = new Post();
        $post = $postModel->findPublicado($slug);

        if (!$post) {
            http_response_code(404);
            require APP_ROOT . '/app/views/site/404.php';
            return;
        }

        $relacionados = $postModel->getRelacionados($post['id'], $post['categoria_id'], 3);

        $this->view('site/blog-post', compact('post', 'relacionados'));
    }
}
