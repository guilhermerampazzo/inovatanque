<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Inova Tanque</title>
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/components.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/blog-forms.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center;">
        <div class="form-page">
            <img src="/logo.svg" alt="Inova Tanque" style="height: 48px; margin: 0 auto 32px; display: block;">
            <h1>Painel Administrativo</h1>
            <p class="subtitle">Acesso restrito</p>

            <?php $flash_error = Session::flash('error'); ?>
            <?php if ($flash_error): ?>
                <div class="alert alert-error" style="margin-bottom: 16px; border-radius: var(--radius-md);"><?= $flash_error ?></div>
            <?php endif; ?>

            <form method="POST" action="/admin/login">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" required>
                </div>
                <button type="submit" class="btn btn-primary btn-lg">Entrar</button>
            </form>
        </div>
    </div>
</body>
</html>
