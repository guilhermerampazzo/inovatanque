<?php

class AdminProdutoController extends Controller
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
        $produtoModel = new Produto();
        $produtos = $produtoModel->findAll('created_at DESC');
        $this->view('admin/produtos/index', compact('produtos'));
    }

    public function create(): void
    {
        $categoriaModel = new Categoria();
        $categorias = $categoriaModel->getAtivas();
        $this->view('admin/produtos/form', ['produto' => null, 'categorias' => $categorias]);
    }

    public function store(): void
    {
        if (!csrf_verify()) {
            Session::flash('error', 'Token inválido.');
            $this->redirect('/admin/produtos/criar');
        }

        $data = $this->getData();
        $produtoModel = new Produto();
        $produtoId = $produtoModel->insert($data);

        $this->handleImages($produtoId);

        Session::flash('success', 'Produto criado com sucesso.');
        $this->redirect('/admin/produtos');
    }

    public function edit(string $id): void
    {
        $produtoModel = new Produto();
        $produto = $produtoModel->findById((int) $id);
        if (!$produto) {
            $this->redirect('/admin/produtos');
        }

        $categoriaModel = new Categoria();
        $categorias = $categoriaModel->getAtivas();

        $imagemModel = new ProdutoImagem();
        $imagens = $imagemModel->findAllBy('produto_id', (int) $id, 'ordem ASC');

        $this->view('admin/produtos/form', compact('produto', 'categorias', 'imagens'));
    }

    public function update(string $id): void
    {
        if (!csrf_verify()) {
            Session::flash('error', 'Token inválido.');
            $this->redirect('/admin/produtos/editar/' . $id);
        }

        $data = $this->getData();
        $produtoModel = new Produto();
        $produtoModel->update((int) $id, $data);

        $this->handleImages((int) $id);

        Session::flash('success', 'Produto atualizado com sucesso.');
        $this->redirect('/admin/produtos');
    }

    public function destroy(string $id): void
    {
        $produtoModel = new Produto();
        $produtoModel->delete((int) $id);
        Session::flash('success', 'Produto excluído.');
        $this->redirect('/admin/produtos');
    }

    private function getData(): array
    {
        $titulo = sanitize($_POST['titulo'] ?? '');
        return [
            'codigo' => sanitize($_POST['codigo'] ?? ''),
            'titulo' => $titulo,
            'slug' => $this->slugify($titulo),
            'categoria_id' => (int) ($_POST['categoria_id'] ?? 0),
            'configuracao' => sanitize($_POST['configuracao'] ?? ''),
            'capacidade' => (int) ($_POST['capacidade'] ?? 0),
            'ano' => (int) ($_POST['ano'] ?? 0),
            'fabricante' => sanitize($_POST['fabricante'] ?? ''),
            'carregamento' => sanitize($_POST['carregamento'] ?? ''),
            'modalidade' => sanitize($_POST['modalidade'] ?? ''),
            'status' => sanitize($_POST['status'] ?? 'disponivel'),
            'descricao' => $_POST['descricao'] ?? '',
            'destaque' => isset($_POST['destaque']) ? 1 : 0,
            'ordem' => (int) ($_POST['ordem'] ?? 0),
            'created_at' => date('Y-m-d H:i:s'),
        ];
    }

    private function handleImages(int $produtoId): void
    {
        if (empty($_FILES['imagens']['name'][0])) {
            return;
        }

        $imagemModel = new ProdutoImagem();
        $files = $_FILES['imagens'];
        $existePrincipal = (bool) $imagemModel->findBy('produto_id', $produtoId);

        for ($i = 0; $i < count($files['name']); $i++) {
            $file = [
                'name' => $files['name'][$i],
                'type' => $files['type'][$i],
                'tmp_name' => $files['tmp_name'][$i],
                'error' => $files['error'][$i],
                'size' => $files['size'][$i],
            ];

            $path = upload_image($file, 'uploads/produtos');
            if ($path) {
                $principal = (!$existePrincipal && $i === 0) ? 1 : 0;
                $imagemModel->insert([
                    'produto_id' => $produtoId,
                    'arquivo' => $path,
                    'ordem' => $i,
                    'principal' => $principal,
                ]);
                if ($principal) $existePrincipal = true;
            }
        }
    }

    private function slugify(string $text): string
    {
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        $text = preg_replace('/[^a-zA-Z0-9\s-]/', '', $text);
        $text = preg_replace('/[\s-]+/', '-', $text);
        return strtolower(trim($text, '-'));
    }
}
