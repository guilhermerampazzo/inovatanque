<?php

class PaginaController extends Controller
{
    public function sobre(): void
    {
        $paginaModel = new Pagina();
        $pagina = $paginaModel->findBy('slug', 'sobre');
        $this->view('site/sobre', compact('pagina'));
    }

    public function nossaHistoria(): void
    {
        $paginaModel = new Pagina();
        $pagina = $paginaModel->findBy('slug', 'nossa-historia');
        $this->view('site/nossa-historia', compact('pagina'));
    }

    public function contato(): void
    {
        $this->view('site/contato');
    }

    public function enviarContato(): void
    {
        if (!csrf_verify()) {
            Session::flash('error', 'Token inválido. Tente novamente.');
            $this->redirect('/contato');
        }

        $nome = sanitize($_POST['nome'] ?? '');
        $email = sanitize($_POST['email'] ?? '');
        $telefone = sanitize($_POST['telefone'] ?? '');
        $mensagem = sanitize($_POST['mensagem'] ?? '');

        if (!$nome || !$email || !$mensagem) {
            Session::flash('error', 'Preencha todos os campos obrigatórios.');
            $this->redirect('/contato');
        }

        // Salvar como cotação genérica
        $cotacaoModel = new Cotacao();
        $cotacaoModel->insert([
            'nome' => $nome,
            'email' => $email,
            'telefone' => $telefone,
            'mensagem' => $mensagem,
            'status' => 'nova',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        Session::flash('success', 'Mensagem enviada com sucesso! Entraremos em contato em breve.');
        $this->redirect('/contato');
    }

    public function privacidade(): void
    {
        $paginaModel = new Pagina();
        $pagina = $paginaModel->findBy('slug', 'politica-de-privacidade');
        $this->view('site/pagina', compact('pagina'));
    }

    public function termos(): void
    {
        $paginaModel = new Pagina();
        $pagina = $paginaModel->findBy('slug', 'termos-de-uso');
        $this->view('site/pagina', compact('pagina'));
    }
}
