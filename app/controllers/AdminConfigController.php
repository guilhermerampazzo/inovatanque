<?php

class AdminConfigController extends Controller
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
        $configModel = new Configuracao();
        $configs = $configModel->getAll();
        $this->view('admin/configuracoes/index', compact('configs'));
    }

    public function update(): void
    {
        if (!csrf_verify()) {
            Session::flash('error', 'Token inválido.');
            $this->redirect('/admin/configuracoes');
        }

        $configModel = new Configuracao();
        foreach ($_POST as $chave => $valor) {
            if ($chave === '_csrf_token') continue;
            $configModel->set($chave, $valor);
        }

        Session::flash('success', 'Configurações atualizadas.');
        $this->redirect('/admin/configuracoes');
    }
}
