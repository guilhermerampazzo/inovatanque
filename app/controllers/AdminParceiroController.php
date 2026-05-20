<?php

class AdminParceiroController extends Controller
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
        $parceiroModel = new Parceiro();
        $parceiros = $parceiroModel->findAll('ordem ASC');
        $this->view('admin/parceiros/index', compact('parceiros'));
    }

    public function create(): void
    {
        $this->view('admin/parceiros/form', ['parceiro' => null]);
    }

    public function store(): void
    {
        if (!csrf_verify()) {
            Session::flash('error', 'Token inválido.');
            $this->redirect('/admin/parceiros/criar');
        }

        $data = [
            'nome' => sanitize($_POST['nome'] ?? ''),
            'ordem' => (int) ($_POST['ordem'] ?? 0),
            'ativo' => isset($_POST['ativo']) ? 1 : 0,
        ];

        if (!empty($_FILES['logo']['name'])) {
            $data['logo'] = upload_image($_FILES['logo'], 'uploads/parceiros');
        }

        $parceiroModel = new Parceiro();
        $parceiroModel->insert($data);

        Session::flash('success', 'Parceiro adicionado.');
        $this->redirect('/admin/parceiros');
    }

    public function destroy(string $id): void
    {
        $parceiroModel = new Parceiro();
        $parceiroModel->delete((int) $id);
        Session::flash('success', 'Parceiro removido.');
        $this->redirect('/admin/parceiros');
    }
}
