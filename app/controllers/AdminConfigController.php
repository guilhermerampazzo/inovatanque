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

    public function uploadImagem(): void
    {
        header('Content-Type: application/json');

        if (empty($_FILES['imagem'])) {
            echo json_encode(['error' => 'Nenhum arquivo enviado.']);
            exit;
        }

        $path = upload_image($_FILES['imagem'], 'uploads/editor');

        if (!$path) {
            echo json_encode(['error' => 'Formato inválido. Use JPG, PNG, WebP ou GIF.']);
            exit;
        }

        echo json_encode(['url' => '/' . $path]);
        exit;
    }
}
