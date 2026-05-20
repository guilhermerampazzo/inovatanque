<?php

class AdminCotacaoController extends Controller
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
        $status = $_GET['status'] ?? null;

        if ($status) {
            $cotacoes = $cotacaoModel->findAllBy('status', $status, 'created_at DESC');
        } else {
            $cotacoes = $cotacaoModel->findAll('created_at DESC');
        }

        $this->view('admin/cotacoes/index', compact('cotacoes', 'status'));
    }

    public function show(string $id): void
    {
        $cotacaoModel = new Cotacao();
        $cotacao = $cotacaoModel->findById((int) $id);
        if (!$cotacao) {
            $this->redirect('/admin/cotacoes');
        }

        $produtoModel = new Produto();
        $produto = $cotacao['produto_id'] ? $produtoModel->findById($cotacao['produto_id']) : null;

        $clienteModel = new Cliente();
        $cliente = $cotacao['cliente_id'] ? $clienteModel->findById($cotacao['cliente_id']) : null;

        $this->view('admin/cotacoes/show', compact('cotacao', 'produto', 'cliente'));
    }

    public function update(string $id): void
    {
        if (!csrf_verify()) {
            Session::flash('error', 'Token inválido.');
            $this->redirect('/admin/cotacoes/' . $id);
        }

        $data = [
            'status' => sanitize($_POST['status'] ?? 'nova'),
            'notas_internas' => $_POST['notas_internas'] ?? '',
        ];

        $cotacaoModel = new Cotacao();
        $cotacaoModel->update((int) $id, $data);

        Session::flash('success', 'Cotação atualizada.');
        $this->redirect('/admin/cotacoes/' . $id);
    }
}
