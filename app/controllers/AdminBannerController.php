<?php

class AdminBannerController extends Controller
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
        $bannerModel = new Banner();
        $banners = $bannerModel->findAll('ordem ASC');
        $this->view('admin/banners/index', compact('banners'));
    }

    public function create(): void
    {
        $bannerModel = new Banner();
        $total = count($bannerModel->findAll());
        if ($total >= 5) {
            Session::flash('error', 'Máximo de 5 banners atingido.');
            $this->redirect('/admin/banners');
        }
        $this->view('admin/banners/form', ['banner' => null]);
    }

    public function store(): void
    {
        if (!csrf_verify()) {
            Session::flash('error', 'Token inválido.');
            $this->redirect('/admin/banners/criar');
        }

        $bannerModel = new Banner();
        $total = count($bannerModel->findAll());
        if ($total >= 5) {
            Session::flash('error', 'Máximo de 5 banners atingido.');
            $this->redirect('/admin/banners');
        }

        $tipo = $_POST['tipo'] ?? 'cor_texto';
        if (!in_array($tipo, ['cor_texto', 'imagem_texto', 'imagem_link'])) {
            $tipo = 'cor_texto';
        }

        $data = [
            'tipo' => $tipo,
            'cor_fundo' => sanitize($_POST['cor_fundo'] ?? '#1a1a1a'),
            'titulo' => sanitize($_POST['titulo'] ?? ''),
            'subtitulo' => sanitize($_POST['subtitulo'] ?? ''),
            'cta_texto' => sanitize($_POST['cta_texto'] ?? ''),
            'cta_link' => sanitize($_POST['cta_link'] ?? ''),
            'link' => sanitize($_POST['link'] ?? ''),
            'ordem' => (int) ($_POST['ordem'] ?? 0),
            'ativo' => isset($_POST['ativo']) ? 1 : 0,
        ];

        if (!empty($_FILES['imagem']['name'])) {
            $data['imagem'] = upload_image($_FILES['imagem'], 'uploads/banners');
        }

        $bannerModel->insert($data);

        Session::flash('success', 'Banner criado com sucesso.');
        $this->redirect('/admin/banners');
    }

    public function edit(string $id): void
    {
        $bannerModel = new Banner();
        $banner = $bannerModel->findById((int) $id);
        if (!$banner) {
            $this->redirect('/admin/banners');
        }
        $this->view('admin/banners/form', compact('banner'));
    }

    public function update(string $id): void
    {
        if (!csrf_verify()) {
            Session::flash('error', 'Token inválido.');
            $this->redirect('/admin/banners/editar/' . $id);
        }

        $tipo = $_POST['tipo'] ?? 'cor_texto';
        if (!in_array($tipo, ['cor_texto', 'imagem_texto', 'imagem_link'])) {
            $tipo = 'cor_texto';
        }

        $data = [
            'tipo' => $tipo,
            'cor_fundo' => sanitize($_POST['cor_fundo'] ?? '#1a1a1a'),
            'titulo' => sanitize($_POST['titulo'] ?? ''),
            'subtitulo' => sanitize($_POST['subtitulo'] ?? ''),
            'cta_texto' => sanitize($_POST['cta_texto'] ?? ''),
            'cta_link' => sanitize($_POST['cta_link'] ?? ''),
            'link' => sanitize($_POST['link'] ?? ''),
            'ordem' => (int) ($_POST['ordem'] ?? 0),
            'ativo' => isset($_POST['ativo']) ? 1 : 0,
        ];

        if (!empty($_FILES['imagem']['name'])) {
            $data['imagem'] = upload_image($_FILES['imagem'], 'uploads/banners');
        }

        $bannerModel = new Banner();
        $bannerModel->update((int) $id, $data);

        Session::flash('success', 'Banner atualizado.');
        $this->redirect('/admin/banners');
    }

    public function destroy(string $id): void
    {
        $bannerModel = new Banner();
        $bannerModel->delete((int) $id);
        Session::flash('success', 'Banner excluído.');
        $this->redirect('/admin/banners');
    }
}
