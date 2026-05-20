<?php

class AdminDepoimentoController extends Controller
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
        $depoimentoModel = new Depoimento();
        $depoimentos = $depoimentoModel->findAll('ordem ASC');
        $this->view('admin/depoimentos/index', compact('depoimentos'));
    }

    public function create(): void
    {
        $this->view('admin/depoimentos/form', ['depoimento' => null]);
    }

    public function store(): void
    {
        if (!csrf_verify()) {
            Session::flash('error', 'Token inválido.');
            $this->redirect('/admin/depoimentos/criar');
        }

        $data = [
            'nome' => sanitize($_POST['nome'] ?? ''),
            'empresa' => sanitize($_POST['empresa'] ?? ''),
            'cargo' => sanitize($_POST['cargo'] ?? ''),
            'texto' => sanitize($_POST['texto'] ?? ''),
            'ordem' => (int) ($_POST['ordem'] ?? 0),
            'ativo' => isset($_POST['ativo']) ? 1 : 0,
        ];

        if (!empty($_FILES['foto']['name'])) {
            $data['foto'] = upload_image($_FILES['foto'], 'uploads/depoimentos');
        }

        $depoimentoModel = new Depoimento();
        $depoimentoModel->insert($data);

        Session::flash('success', 'Depoimento criado com sucesso.');
        $this->redirect('/admin/depoimentos');
    }

    public function edit(string $id): void
    {
        $depoimentoModel = new Depoimento();
        $depoimento = $depoimentoModel->findById((int) $id);
        if (!$depoimento) {
            $this->redirect('/admin/depoimentos');
        }
        $this->view('admin/depoimentos/form', compact('depoimento'));
    }

    public function update(string $id): void
    {
        if (!csrf_verify()) {
            Session::flash('error', 'Token inválido.');
            $this->redirect('/admin/depoimentos/editar/' . $id);
        }

        $data = [
            'nome' => sanitize($_POST['nome'] ?? ''),
            'empresa' => sanitize($_POST['empresa'] ?? ''),
            'cargo' => sanitize($_POST['cargo'] ?? ''),
            'texto' => sanitize($_POST['texto'] ?? ''),
            'ordem' => (int) ($_POST['ordem'] ?? 0),
            'ativo' => isset($_POST['ativo']) ? 1 : 0,
        ];

        if (!empty($_FILES['foto']['name'])) {
            $data['foto'] = upload_image($_FILES['foto'], 'uploads/depoimentos');
        }

        $depoimentoModel = new Depoimento();
        $depoimentoModel->update((int) $id, $data);

        Session::flash('success', 'Depoimento atualizado.');
        $this->redirect('/admin/depoimentos');
    }

    public function destroy(string $id): void
    {
        $depoimentoModel = new Depoimento();
        $depoimentoModel->delete((int) $id);
        Session::flash('success', 'Depoimento excluído.');
        $this->redirect('/admin/depoimentos');
    }
}
