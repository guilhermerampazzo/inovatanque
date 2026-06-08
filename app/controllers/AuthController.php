<?php

class AuthController extends Controller
{
    public function loginForm(): void
    {
        if (Session::isLoggedIn()) {
            $this->redirect('/cliente/dashboard');
        }
        $this->view('site/login');
    }

    public function login(): void
    {
        if (!csrf_verify()) {
            Session::flash('error', 'Token inválido.');
            $this->redirect('/login');
        }

        $email = sanitize($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Session::flash('error', 'E-mail inválido.');
            $this->redirect('/login');
        }

        $clienteModel = new Cliente();
        $cliente = $clienteModel->findBy('email', $email);

        if (!$cliente || !password_verify($senha, $cliente['senha'])) {
            Session::flash('error', 'E-mail ou senha incorretos.');
            $this->redirect('/login');
        }

        if (!$cliente['ativo']) {
            Session::flash('error', 'Conta desativada. Entre em contato conosco.');
            $this->redirect('/login');
        }

        Session::set('cliente_id', $cliente['id']);
        Session::set('cliente_nome', $cliente['nome_razao']);
        $this->redirect('/cliente/dashboard');
    }

    public function cadastroForm(): void
    {
        if (Session::isLoggedIn()) {
            $this->redirect('/cliente/dashboard');
        }
        $this->view('site/cadastro');
    }

    public function cadastro(): void
    {
        if (!csrf_verify()) {
            Session::flash('error', 'Token inválido.');
            $this->redirect('/cadastro');
        }

        $data = [
            'tipo' => sanitize($_POST['tipo'] ?? 'pf'),
            'nome_razao' => sanitize($_POST['nome_razao'] ?? ''),
            'cpf_cnpj' => sanitize($_POST['cpf_cnpj'] ?? ''),
            'ie' => sanitize($_POST['ie'] ?? ''),
            'email' => sanitize($_POST['email'] ?? ''),
            'telefone' => sanitize($_POST['telefone'] ?? ''),
            'whatsapp' => sanitize($_POST['whatsapp'] ?? ''),
            'endereco' => sanitize($_POST['endereco'] ?? ''),
            'cidade' => sanitize($_POST['cidade'] ?? ''),
            'uf' => sanitize($_POST['uf'] ?? ''),
            'cep' => sanitize($_POST['cep'] ?? ''),
            'ativo' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $senha = $_POST['senha'] ?? '';
        $senhaConfirm = $_POST['senha_confirmacao'] ?? '';

        if (!$data['nome_razao'] || !$data['email'] || !$senha) {
            Session::flash('error', 'Preencha todos os campos obrigatórios.');
            $this->redirect('/cadastro');
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            Session::flash('error', 'E-mail inválido.');
            $this->redirect('/cadastro');
        }

        if (!$data['telefone'] && !$data['whatsapp']) {
            Session::flash('error', 'Informe pelo menos um número de telefone ou WhatsApp.');
            $this->redirect('/cadastro');
        }

        if (strlen($senha) < 8) {
            Session::flash('error', 'A senha deve ter no mínimo 8 caracteres.');
            $this->redirect('/cadastro');
        }

        if (!preg_match('/[A-Z]/', $senha)) {
            Session::flash('error', 'A senha deve conter pelo menos uma letra maiúscula.');
            $this->redirect('/cadastro');
        }

        if (!preg_match('/[0-9]/', $senha)) {
            Session::flash('error', 'A senha deve conter pelo menos um número.');
            $this->redirect('/cadastro');
        }

        if ($senha !== $senhaConfirm) {
            Session::flash('error', 'As senhas não conferem.');
            $this->redirect('/cadastro');
        }

        $clienteModel = new Cliente();
        if ($clienteModel->findBy('email', $data['email'])) {
            Session::flash('error', 'E-mail já cadastrado.');
            $this->redirect('/cadastro');
        }

        $data['senha'] = password_hash($senha, PASSWORD_DEFAULT);
        $clienteModel->insert($data);

        Session::flash('success', 'Cadastro realizado com sucesso! Faça login.');
        $this->redirect('/login');
    }

    public function logout(): void
    {
        Session::remove('cliente_id');
        Session::remove('cliente_nome');
        $this->redirect('/');
    }

    public function recuperarForm(): void
    {
        $this->view('site/recuperar-senha');
    }

    public function recuperar(): void
    {
        if (!csrf_verify()) {
            Session::flash('error', 'Token inválido.');
            $this->redirect('/recuperar-senha');
        }

        $email = sanitize($_POST['email'] ?? '');
        $clienteModel = new Cliente();
        $cliente = $clienteModel->findBy('email', $email);

        if ($cliente) {
            // TODO: enviar e-mail com link de recuperação
        }

        Session::flash('success', 'Se o e-mail estiver cadastrado, você receberá as instruções de recuperação.');
        $this->redirect('/recuperar-senha');
    }
}
