<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Inova Tanque</title>
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: #f9fafb; padding: 24px;">
        <div style="width: 100%; max-width: 380px;">
            <div style="text-align: center; margin-bottom: 32px;">
                <img src="/logo.svg" alt="Inova Tanque" style="height: 32px; margin-bottom: 24px;">
                <h1 style="font-size: 20px; font-weight: 700; color: var(--color-text); margin-bottom: 6px;">Painel Administrativo</h1>
                <p style="font-size: 14px; color: var(--color-text-secondary);">Faça login para continuar</p>
            </div>

            <div style="background: #fff; border-radius: 16px; padding: 32px; box-shadow: var(--shadow-md);">
                <?php $flash_error = Session::flash('error'); ?>
                <?php if ($flash_error): ?>
                    <div class="alert alert-error"><?= $flash_error ?></div>
                <?php endif; ?>

                <form method="POST" action="/admin/login">
                    <?= csrf_field() ?>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--color-text); margin-bottom: 6px;">E-mail</label>
                        <input type="email" name="email" required placeholder="seu@email.com" style="width: 100%; padding: 11px 14px; border: 1px solid var(--color-border); border-radius: 10px; font-size: 14px; color: var(--color-text); background: #fff; transition: all 0.15s ease; outline: none;" onfocus="this.style.borderColor='var(--color-accent)';this.style.boxShadow='0 0 0 3px var(--color-accent-light)'" onblur="this.style.borderColor='var(--color-border)';this.style.boxShadow='none'">
                    </div>
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--color-text); margin-bottom: 6px;">Senha</label>
                        <input type="password" name="senha" required placeholder="••••••••" style="width: 100%; padding: 11px 14px; border: 1px solid var(--color-border); border-radius: 10px; font-size: 14px; color: var(--color-text); background: #fff; transition: all 0.15s ease; outline: none;" onfocus="this.style.borderColor='var(--color-accent)';this.style.boxShadow='0 0 0 3px var(--color-accent-light)'" onblur="this.style.borderColor='var(--color-border)';this.style.boxShadow='none'">
                    </div>
                    <button type="submit" style="width: 100%; padding: 12px; background: var(--color-accent); color: #fff; font-size: 14px; font-weight: 600; border: none; border-radius: 10px; cursor: pointer; transition: background 0.15s ease;" onmouseover="this.style.background='var(--color-accent-hover)'" onmouseout="this.style.background='var(--color-accent)'">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
