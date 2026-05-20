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
    <style>
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);
            padding: 24px;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            background: var(--color-surface);
            border: 1px solid rgba(75, 69, 71, 0.15);
            border-radius: 20px;
            padding: 48px 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        .login-card .logo {
            display: block;
            height: 36px;
            margin: 0 auto 32px;
            opacity: 0.9;
        }
        .login-card h1 {
            font-family: var(--font-display);
            font-size: 22px;
            font-weight: 700;
            text-align: center;
            color: var(--color-primary);
            margin-bottom: 6px;
        }
        .login-card .subtitle {
            text-align: center;
            font-size: 14px;
            color: var(--color-on-surface-variant);
            margin-bottom: 32px;
        }
        .login-card .form-group {
            margin-bottom: 20px;
        }
        .login-card label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--color-on-surface-variant);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .login-card input {
            width: 100%;
            padding: 12px 16px;
            background: var(--color-bg);
            border: 1px solid rgba(75, 69, 71, 0.2);
            border-radius: 10px;
            color: var(--color-text);
            font-size: 15px;
            transition: all 0.2s;
        }
        .login-card input:focus {
            outline: none;
            border-color: var(--color-gold);
            box-shadow: 0 0 0 3px rgba(245, 176, 65, 0.15);
        }
        .login-card .btn {
            width: 100%;
            padding: 14px;
            margin-top: 8px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <img src="/logo.svg" alt="Inova Tanque" class="logo">
            <h1>Painel Administrativo</h1>
            <p class="subtitle">Acesso restrito</p>

            <?php $flash_error = Session::flash('error'); ?>
            <?php if ($flash_error): ?>
                <div class="alert alert-error" style="margin-bottom: 20px; padding: 12px 16px; border-radius: 10px; font-size: 14px; background: rgba(244,67,54,0.1); border: 1px solid rgba(244,67,54,0.25); color: #f44336;"><?= $flash_error ?></div>
            <?php endif; ?>

            <form method="POST" action="/admin/login">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" placeholder="seu@email.com" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn btn-primary btn-lg">Entrar</button>
            </form>
        </div>
    </div>
</body>
</html>
