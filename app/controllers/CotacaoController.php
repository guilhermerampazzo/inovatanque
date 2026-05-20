<?php

class CotacaoController extends Controller
{
    public function store(): void
    {
        if (!csrf_verify()) {
            Session::flash('error', 'Token inválido.');
            $this->redirect($_SERVER['HTTP_REFERER'] ?? '/');
        }

        $data = [
            'cliente_id' => Session::get('cliente_id'),
            'nome' => sanitize($_POST['nome'] ?? ''),
            'email' => sanitize($_POST['email'] ?? ''),
            'telefone' => sanitize($_POST['telefone'] ?? ''),
            'produto_id' => (int) ($_POST['produto_id'] ?? 0),
            'mensagem' => sanitize($_POST['mensagem'] ?? ''),
            'status' => 'nova',
            'created_at' => date('Y-m-d H:i:s'),
        ];

        if (!$data['nome'] || !$data['email'] || !$data['produto_id']) {
            Session::flash('error', 'Preencha todos os campos obrigatórios.');
            $this->redirect($_SERVER['HTTP_REFERER'] ?? '/');
        }

        $cotacaoModel = new Cotacao();
        $cotacaoModel->insert($data);

        Session::flash('success', 'Cotação enviada com sucesso! Entraremos em contato em breve.');
        $this->redirect($_SERVER['HTTP_REFERER'] ?? '/');
    }
}
