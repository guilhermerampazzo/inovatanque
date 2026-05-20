<?php

class AdminAuthController extends Controller
{
    public function loginForm(): void
    {
        if (Session::isAdmin()) {
            $this->redirect('/admin');
        }
        $this->view('admin/login');
    }

    public function login(): void
    {
        if (!csrf_verify()) {
            Session::flash('error', 'Token inválido.');
            $this->redirect('/admin/login');
        }

        $email = sanitize($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';

        $adminModel = new Admin();
        $admin = $adminModel->findBy('email', $email);

        if (!$admin || !password_verify($senha, $admin['senha'])) {
            Session::flash('error', 'E-mail ou senha incorretos.');
            $this->redirect('/admin/login');
        }

        if (!$admin['ativo']) {
            Session::flash('error', 'Conta desativada.');
            $this->redirect('/admin/login');
        }

        Session::set('admin_id', $admin['id']);
        Session::set('admin_nome', $admin['nome']);
        Session::set('admin_role', $admin['role']);
        $this->redirect('/admin');
    }

    public function logout(): void
    {
        Session::remove('admin_id');
        Session::remove('admin_nome');
        Session::remove('admin_role');
        $this->redirect('/admin/login');
    }
}
