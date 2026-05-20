<?php $pageTitle = 'Recuperar Senha - Inova Tanque'; ?>
<?php require APP_ROOT . '/app/views/site/header.php'; ?>

<section>
    <div class="container">
        <div class="form-page">
            <h1>Recuperar Senha</h1>
            <p class="subtitle">Informe seu e-mail para receber as instruções de recuperação</p>

            <form method="POST" action="/recuperar-senha">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <button type="submit" class="btn btn-primary btn-lg">Enviar</button>
            </form>

            <div class="form-footer">
                <p><a href="/login">Voltar para o login</a></p>
            </div>
        </div>
    </div>
</section>

<?php require APP_ROOT . '/app/views/site/footer.php'; ?>
