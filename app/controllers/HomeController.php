<?php

class HomeController extends Controller
{
    public function index(): void
    {
        $bannerModel = new Banner();
        $depoimentoModel = new Depoimento();
        $parceiroModel = new Parceiro();
        $produtoModel = new Produto();

        $banners = $bannerModel->getAtivos();
        $depoimentos = $depoimentoModel->getAtivos();
        $parceiros = $parceiroModel->getAtivos();
        $destaques = $produtoModel->getDestaques();
        $prontaEntrega = $produtoModel->getProntaEntrega(4);
        $locacao = $produtoModel->getByModalidade('Locação', 4);
        $venda = $produtoModel->getByModalidade('Venda', 4);

        $this->view('site/home', compact('banners', 'depoimentos', 'parceiros', 'destaques', 'prontaEntrega', 'locacao', 'venda'));
    }
}
