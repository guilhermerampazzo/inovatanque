<?php

class ClienteController extends Controller
{
    public function __construct()
    {
        if (!Session::isLoggedIn()) {
            Session::flash('error', 'Faça login para acessar esta área.');
            header('Location: /login');
            exit;
        }
    }

    public function dashboard(): void
    {
        $clienteId = Session::get('cliente_id');
        $cotacaoModel = new Cotacao();
        $favoritoModel = new Favorito();

        $totalCotacoes = $cotacaoModel->count('cliente_id = ?', [$clienteId]);
        $totalFavoritos = $favoritoModel->count('cliente_id = ?', [$clienteId]);

        $this->view('cliente/dashboard', compact('totalCotacoes', 'totalFavoritos'));
    }

    public function perfil(): void
    {
        $clienteModel = new Cliente();
        $cliente = $clienteModel->findById(Session::get('cliente_id'));
        $this->view('cliente/perfil', compact('cliente'));
    }

    public function atualizarPerfil(): void
    {
        if (!csrf_verify()) {
            Session::flash('error', 'Token inválido.');
            $this->redirect('/cliente/perfil');
        }

        $clienteId = Session::get('cliente_id');
        $data = [
            'nome_razao' => sanitize($_POST['nome_razao'] ?? ''),
            'telefone' => sanitize($_POST['telefone'] ?? ''),
            'whatsapp' => sanitize($_POST['whatsapp'] ?? ''),
            'endereco' => sanitize($_POST['endereco'] ?? ''),
            'cidade' => sanitize($_POST['cidade'] ?? ''),
            'uf' => sanitize($_POST['uf'] ?? ''),
            'cep' => sanitize($_POST['cep'] ?? ''),
        ];

        $novaSenha = $_POST['nova_senha'] ?? '';
        if ($novaSenha) {
            $data['senha'] = password_hash($novaSenha, PASSWORD_DEFAULT);
        }

        $clienteModel = new Cliente();
        $clienteModel->update($clienteId, $data);

        Session::set('cliente_nome', $data['nome_razao']);
        Session::flash('success', 'Perfil atualizado com sucesso.');
        $this->redirect('/cliente/perfil');
    }

    public function cotacoes(): void
    {
        $clienteId = Session::get('cliente_id');
        $cotacaoModel = new Cotacao();
        $cotacoes = $cotacaoModel->findAllBy('cliente_id', $clienteId, 'created_at DESC');
        $this->view('cliente/cotacoes', compact('cotacoes'));
    }

    public function favoritos(): void
    {
        $clienteId = Session::get('cliente_id');
        $favoritoModel = new Favorito();
        $favoritos = $favoritoModel->getComProduto($clienteId);
        $this->view('cliente/favoritos', compact('favoritos'));
    }

    public function favoritar(string $id): void
    {
        $produtoId = (int) $id;
        $clienteId = Session::get('cliente_id');
        $favoritoModel = new Favorito();

        if (!$favoritoModel->existe($clienteId, $produtoId)) {
            $favoritoModel->insert([
                'cliente_id' => $clienteId,
                'produto_id' => $produtoId,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }

        $this->redirect($_SERVER['HTTP_REFERER'] ?? '/catalogo');
    }

    public function desfavoritar(string $id): void
    {
        $produtoId = (int) $id;
        $clienteId = Session::get('cliente_id');
        $favoritoModel = new Favorito();
        $favoritoModel->remover($clienteId, $produtoId);
        $this->redirect($_SERVER['HTTP_REFERER'] ?? '/cliente/favoritos');
    }
}
