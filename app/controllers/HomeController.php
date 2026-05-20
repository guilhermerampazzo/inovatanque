<?php

class HomeController extends Controller
{
    public function index(): void
    {
        $bannerModel = new Banner();
        $depoimentoModel = new Depoimento();
        $parceiroModel = new Parceiro();
        $produtoModel = new Produto();
        $categoriaModel = new Categoria();

        $banners = $bannerModel->getAtivos();
        $depoimentos = $depoimentoModel->getAtivos();
        $parceiros = $parceiroModel->getAtivos();
        $destaques = $produtoModel->getDestaques();

        // Busca categorias ativas e produtos de cada uma
        $categorias = $categoriaModel->getAtivas();
        $produtosPorCategoria = [];
        foreach ($categorias as $cat) {
            $produtos = $produtoModel->getByCategoria((int) $cat['id'], 4);
            if (!empty($produtos)) {
                $produtosPorCategoria[] = [
                    'categoria' => $cat,
                    'produtos' => $produtos,
                ];
            }
        }

        $this->view('site/home', compact('banners', 'depoimentos', 'parceiros', 'destaques', 'produtosPorCategoria'));
    }
}
