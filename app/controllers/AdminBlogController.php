<?php

class AdminBlogController extends Controller
{
    public function __construct()
    {
        if (!Session::isAdmin()) {
            header('Location: /admin/login');
            exit;
        }
    }

    public function index(): void
    {
        $postModel = new Post();
        $posts = $postModel->findAll('created_at DESC');
        $this->view('admin/blog/index', compact('posts'));
    }

    public function create(): void
    {
        $categoriaModel = new PostCategoria();
        $categorias = $categoriaModel->findAll('nome ASC');
        $this->view('admin/blog/form', ['post' => null, 'categorias' => $categorias]);
    }

    public function store(): void
    {
        if (!csrf_verify()) {
            Session::flash('error', 'Token inválido.');
            $this->redirect('/admin/blog/criar');
        }

        $data = $this->getData();

        if (!empty($_FILES['imagem']['name'])) {
            $data['imagem'] = upload_image($_FILES['imagem'], 'uploads/blog');
        }

        $postModel = new Post();
        $postModel->insert($data);

        Session::flash('success', 'Post criado com sucesso.');
        $this->redirect('/admin/blog');
    }

    public function edit(string $id): void
    {
        $postModel = new Post();
        $post = $postModel->findById((int) $id);
        if (!$post) {
            $this->redirect('/admin/blog');
        }

        $categoriaModel = new PostCategoria();
        $categorias = $categoriaModel->findAll('nome ASC');

        $this->view('admin/blog/form', compact('post', 'categorias'));
    }

    public function update(string $id): void
    {
        if (!csrf_verify()) {
            Session::flash('error', 'Token inválido.');
            $this->redirect('/admin/blog/editar/' . $id);
        }

        $data = $this->getData();

        if (!empty($_FILES['imagem']['name'])) {
            $data['imagem'] = upload_image($_FILES['imagem'], 'uploads/blog');
        }

        $postModel = new Post();
        $postModel->update((int) $id, $data);

        Session::flash('success', 'Post atualizado.');
        $this->redirect('/admin/blog');
    }

    public function destroy(string $id): void
    {
        $postModel = new Post();
        $postModel->delete((int) $id);
        Session::flash('success', 'Post excluído.');
        $this->redirect('/admin/blog');
    }

    private function getData(): array
    {
        $titulo = sanitize($_POST['titulo'] ?? '');
        return [
            'titulo' => $titulo,
            'slug' => $this->slugify($titulo),
            'categoria_id' => (int) ($_POST['categoria_id'] ?? 0),
            'resumo' => sanitize($_POST['resumo'] ?? ''),
            'conteudo' => $_POST['conteudo'] ?? '',
            'autor_id' => Session::get('admin_id'),
            'status' => sanitize($_POST['status'] ?? 'rascunho'),
            'publicado_em' => $_POST['publicado_em'] ?? date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
        ];
    }

    private function slugify(string $text): string
    {
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        $text = preg_replace('/[^a-zA-Z0-9\s-]/', '', $text);
        $text = preg_replace('/[\s-]+/', '-', $text);
        return strtolower(trim($text, '-'));
    }
}
