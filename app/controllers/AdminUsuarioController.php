<?php

class AdminUsuarioController extends Controller
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
        $adminModel = new Admin();
        $usuarios = $adminModel->findAll('nome ASC');
        $this->view('admin/usuarios/index', compact('usuarios'));
    }

    public function create(): void
    {
        $this->view('admin/usuarios/form', ['usuario' => null]);
    }

    public function store(): void
    {
        if (!csrf_verify()) {
            Session::flash('error', 'Token inválido.');
            $this->redirect('/admin/usuarios/criar');
        }

        $data = [
            'nome' => sanitize($_POST['nome'] ?? ''),
            'email' => sanitize($_POST['email'] ?? ''),
            'senha' => password_hash($_POST['senha'] ?? '', PASSWORD_DEFAULT),
            'role' => sanitize($_POST['role'] ?? 'editor'),
            'ativo' => isset($_POST['ativo']) ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $adminModel = new Admin();
        $adminModel->insert($data);

        Session::flash('success', 'Usuário criado com sucesso.');
        $this->redirect('/admin/usuarios');
    }

    public function edit(string $id): void
    {
        $adminModel = new Admin();
        $usuario = $adminModel->findById((int) $id);
        if (!$usuario) {
            $this->redirect('/admin/usuarios');
        }
        $this->view('admin/usuarios/form', compact('usuario'));
    }

    public function update(string $id): void
    {
        if (!csrf_verify()) {
            Session::flash('error', 'Token inválido.');
            $this->redirect('/admin/usuarios/editar/' . $id);
        }

        $data = [
            'nome' => sanitize($_POST['nome'] ?? ''),
            'email' => sanitize($_POST['email'] ?? ''),
            'role' => sanitize($_POST['role'] ?? 'editor'),
            'ativo' => isset($_POST['ativo']) ? 1 : 0,
        ];

        if (!empty($_POST['senha'])) {
            $data['senha'] = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        }

        $adminModel = new Admin();
        $adminModel->update((int) $id, $data);

        Session::flash('success', 'Usuário atualizado.');
        $this->redirect('/admin/usuarios');
    }

    public function destroy(string $id): void
    {
        if ((int) $id === Session::get('admin_id')) {
            Session::flash('error', 'Você não pode excluir sua própria conta.');
            $this->redirect('/admin/usuarios');
        }

        $adminModel = new Admin();
        $adminModel->delete((int) $id);
        Session::flash('success', 'Usuário excluído.');
        $this->redirect('/admin/usuarios');
    }
}
