<?php

class AdminCategoriaController extends Controller
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
        $categoriaModel = new Categoria();
        $categorias = $categoriaModel->findAll('ordem ASC, nome ASC');
        $this->view('admin/categorias/index', compact('categorias'));
    }

    public function create(): void
    {
        $categoriaModel = new Categoria();
        $pais = $categoriaModel->findAllBy('parent_id', 0, 'nome ASC');
        $this->view('admin/categorias/form', ['categoria' => null, 'pais' => $pais]);
    }

    public function store(): void
    {
        if (!csrf_verify()) {
            Session::flash('error', 'Token inválido.');
            $this->redirect('/admin/categorias/criar');
        }

        $nome = sanitize($_POST['nome'] ?? '');
        $data = [
            'nome' => $nome,
            'slug' => $this->slugify($nome),
            'parent_id' => (int) ($_POST['parent_id'] ?? 0),
            'ordem' => (int) ($_POST['ordem'] ?? 0),
            'ativo' => isset($_POST['ativo']) ? 1 : 0,
        ];

        $categoriaModel = new Categoria();
        $categoriaModel->insert($data);

        Session::flash('success', 'Categoria criada com sucesso.');
        $this->redirect('/admin/categorias');
    }

    public function edit(string $id): void
    {
        $categoriaModel = new Categoria();
        $categoria = $categoriaModel->findById((int) $id);
        if (!$categoria) {
            $this->redirect('/admin/categorias');
        }
        $pais = $categoriaModel->findAllBy('parent_id', 0, 'nome ASC');
        $this->view('admin/categorias/form', compact('categoria', 'pais'));
    }

    public function update(string $id): void
    {
        if (!csrf_verify()) {
            Session::flash('error', 'Token inválido.');
            $this->redirect('/admin/categorias/editar/' . $id);
        }

        $nome = sanitize($_POST['nome'] ?? '');
        $data = [
            'nome' => $nome,
            'slug' => $this->slugify($nome),
            'parent_id' => (int) ($_POST['parent_id'] ?? 0),
            'ordem' => (int) ($_POST['ordem'] ?? 0),
            'ativo' => isset($_POST['ativo']) ? 1 : 0,
        ];

        $categoriaModel = new Categoria();
        $categoriaModel->update((int) $id, $data);

        Session::flash('success', 'Categoria atualizada.');
        $this->redirect('/admin/categorias');
    }

    public function destroy(string $id): void
    {
        $categoriaId = (int) $id;
        $categoriaModel = new Categoria();

        $produtoModel = new Produto();
        $produtosVinculados = $produtoModel->count('categoria_id = ?', [$categoriaId]);
        if ($produtosVinculados > 0) {
            Session::flash('error', 'Não é possível excluir: existem ' . $produtosVinculados . ' produto(s) vinculado(s) a esta categoria. Mova ou exclua os produtos antes.');
            $this->redirect('/admin/categorias');
        }

        $subcategorias = $categoriaModel->count('parent_id = ?', [$categoriaId]);
        if ($subcategorias > 0) {
            Session::flash('error', 'Não é possível excluir: existem ' . $subcategorias . ' subcategoria(s) vinculada(s). Exclua-as primeiro.');
            $this->redirect('/admin/categorias');
        }

        try {
            $categoriaModel->delete($categoriaId);
            Session::flash('success', 'Categoria excluída.');
        } catch (PDOException $e) {
            Session::flash('error', 'Não foi possível excluir a categoria por restrição de integridade.');
        }
        $this->redirect('/admin/categorias');
    }

    private function slugify(string $text): string
    {
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        $text = preg_replace('/[^a-zA-Z0-9\s-]/', '', $text);
        $text = preg_replace('/[\s-]+/', '-', $text);
        return strtolower(trim($text, '-'));
    }
}
