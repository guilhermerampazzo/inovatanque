<?php

// Carrega o .env (se existir) para dentro do getenv(). Nada mais no projeto
// fazia isso antes — o .env ficava so decorativo, e o site rodava com os
// fallbacks hardcoded em config/database.php (root sem senha).
if (!defined('ENV_LOADED')) {
    define('ENV_LOADED', true);

    $envFile = dirname(__DIR__) . '/.env';
    if (is_file($envFile)) {
        foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
                continue;
            }
            [$key, $value] = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            if (getenv($key) === false) {
                putenv("{$key}={$value}");
            }
        }
    }
}
