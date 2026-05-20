<?php

class ProdutoController extends Controller
{
    public function show(string $slug): void
    {
        $produtoModel = new Produto();
        $produto = $produtoModel->findBy('slug', $slug);

        if (!$produto) {
            http_response_code(404);
            require APP_ROOT . '/app/views/site/404.php';
            return;
        }

        $imagemModel = new ProdutoImagem();
        $imagens = $imagemModel->findAllBy('produto_id', $produto['id'], 'ordem ASC');

        $relacionados = $produtoModel->getRelacionados($produto['id'], $produto['categoria_id'], 4);

        $this->view('site/produto', compact('produto', 'imagens', 'relacionados'));
    }
}
