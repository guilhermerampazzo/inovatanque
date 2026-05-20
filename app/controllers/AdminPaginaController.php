<?php

class AdminPaginaController extends Controller
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
        $paginaModel = new Pagina();
        $paginas = $paginaModel->findAll('titulo ASC');
        $this->view('admin/paginas/index', compact('paginas'));
    }

    public function edit(string $id): void
    {
        $paginaModel = new Pagina();
        $pagina = $paginaModel->findById((int) $id);
        if (!$pagina) {
            $this->redirect('/admin/paginas');
        }
        $this->view('admin/paginas/form', compact('pagina'));
    }

    public function update(string $id): void
    {
        if (!csrf_verify()) {
            Session::flash('error', 'Token inválido.');
            $this->redirect('/admin/paginas/editar/' . $id);
        }

        $data = [
            'titulo' => sanitize($_POST['titulo'] ?? ''),
            'conteudo' => $_POST['conteudo'] ?? '',
        ];

        $paginaModel = new Pagina();
        $paginaModel->update((int) $id, $data);

        Session::flash('success', 'Página atualizada.');
        $this->redirect('/admin/paginas');
    }
}
