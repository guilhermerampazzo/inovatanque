<?php

class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data);
        require APP_ROOT . '/app/views/' . $view . '.php';
    }

    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }

    protected function json(array $data, int $code = 200): void
    {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
