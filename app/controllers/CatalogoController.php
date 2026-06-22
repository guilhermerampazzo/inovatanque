<?php

class CatalogoController extends Controller
{
    public function index(): void
    {
        $produtoModel = new Produto();
        $categoriaModel = new Categoria();

        $page = (int) ($_GET['page'] ?? 1);
        $filters = [
            'categoria_id' => $_GET['categoria'] ?? null,
            'configuracao' => $_GET['configuracao'] ?? null,
            'carregamento' => $_GET['carregamento'] ?? null,
            'modalidade' => $_GET['modalidade'] ?? null,
            'ano_min' => $_GET['ano_min'] ?? null,
            'ano_max' => $_GET['ano_max'] ?? null,
            'fabricante' => $_GET['fabricante'] ?? null,
            'busca' => $_GET['busca'] ?? null,
        ];
        $orderBy = $_GET['ordem'] ?? 'created_at DESC';

        $total = $produtoModel->countFiltered($filters);
        $pagination = paginate($total, ITEMS_PER_PAGE, $page);
        $produtos = $produtoModel->getFiltered($filters, $orderBy, ITEMS_PER_PAGE, $pagination['offset']);
        $categorias = $categoriaModel->getAtivas();

        $this->view('site/catalogo', compact('produtos', 'categorias', 'pagination', 'filters'));
    }
}
