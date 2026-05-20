<?php $pageTitle = 'Login - Inova Tanque'; ?>
<?php require APP_ROOT . '/app/views/site/header.php'; ?>

<section>
    <div class="container">
        <div class="form-page">
            <h1>Entrar</h1>
            <p class="subtitle">Acesse sua conta para gerenciar cotações e favoritos</p>

            <form method="POST" action="/login">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" required value="<?= old('email') ?>">
                </div>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" required>
                </div>
                <button type="submit" class="btn btn-primary btn-lg">Entrar</button>
            </form>

            <div class="form-footer">
                <p><a href="/recuperar-senha">Esqueceu a senha?</a></p>
                <p style="margin-top: 8px;">Não tem conta? <a href="/cadastro">Cadastre-se</a></p>
            </div>
        </div>
    </div>
</section>

<?php require APP_ROOT . '/app/views/site/footer.php'; ?>
