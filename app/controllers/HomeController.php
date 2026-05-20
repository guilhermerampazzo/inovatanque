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

        $this->view('site/home', compact('banners', 'depoimentos', 'parceiros', 'destaques'));
    }
}
