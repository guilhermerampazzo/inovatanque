<?php

class AdminClienteController extends Controller
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
        $clienteModel = new Cliente();
        $clientes = $clienteModel->findAll('created_at DESC');
        $this->view('admin/clientes/index', compact('clientes'));
    }

    public function show(string $id): void
    {
        $clienteModel = new Cliente();
        $cliente = $clienteModel->findById((int) $id);
        if (!$cliente) {
            $this->redirect('/admin/clientes');
        }

        $cotacaoModel = new Cotacao();
        $cotacoes = $cotacaoModel->findAllBy('cliente_id', (int) $id, 'created_at DESC');

        $this->view('admin/clientes/show', compact('cliente', 'cotacoes'));
    }

    public function toggle(string $id): void
    {
        $clienteModel = new Cliente();
        $cliente = $clienteModel->findById((int) $id);
        if ($cliente) {
            $clienteModel->update((int) $id, ['ativo' => $cliente['ativo'] ? 0 : 1]);
        }
        Session::flash('success', 'Status do cliente atualizado.');
        $this->redirect('/admin/clientes');
    }
}
