<?php

class AdminDashboardController extends Controller
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
        $cotacaoModel = new Cotacao();
        $clienteModel = new Cliente();
        $produtoModel = new Produto();

        $totalCotacoes = $cotacaoModel->count();
        $cotacoesNovas = $cotacaoModel->count('status = ?', ['nova']);
        $totalClientes = $clienteModel->count();
        $totalProdutos = $produtoModel->count();
        $ultimasCotacoes = $cotacaoModel->findAll('created_at DESC', 10);

        $this->view('admin/dashboard', compact(
            'totalCotacoes', 'cotacoesNovas', 'totalClientes', 'totalProdutos', 'ultimasCotacoes'
        ));
    }
}
