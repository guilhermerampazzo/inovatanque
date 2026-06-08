<?php $pageTitle = 'Contato - Inova Tanque'; ?>
<?php $pageDescription = 'Entre em contato com a Inova Tanque. Locação e venda de carretas-tanque em Paulínia/SP.'; ?>
<?php require APP_ROOT . '/app/views/site/header.php'; ?>

<section style="padding-top: 48px; padding-bottom: 96px;">
    <div class="container">
        <div class="section-header" style="margin-bottom: 48px;">
            <div>
                <h2>Contato</h2>
                <p>Fale conosco para cotações, dúvidas ou parcerias</p>
            </div>
        </div>

        <div class="contato-layout">
            <!-- Formulário -->
            <div>
                <form method="POST" action="/contato">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="nome">Nome *</label>
                        <input type="text" id="nome" name="nome" required value="<?= old('nome') ?>">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">E-mail *</label>
                            <input type="email" id="email" name="email" required value="<?= old('email') ?>">
                        </div>
                        <div class="form-group">
                            <label for="telefone">Telefone</label>
                            <input type="tel" id="telefone" name="telefone" value="<?= old('telefone') ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mensagem">Mensagem *</label>
                        <textarea id="mensagem" name="mensagem" rows="5" required><?= old('mensagem') ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg">Enviar Mensagem</button>
                </form>
            </div>

            <!-- Info -->
            <div class="contato-info">
                <h2>Nossos Dados</h2>

                <div class="contato-info-item">
                    <div>
                        <strong>Endereço</strong>
                        Rodovia Prof. Zeferino Vaz (SP 332) — KM 125<br>
                        Santa Terezinha, Paulínia/SP<br>
                        CEP 13140-774
                    </div>
                </div>

                <div class="contato-info-item">
                    <div>
                        <strong>Telefone / WhatsApp</strong>
                        <a href="<?= whatsapp_link(WHATSAPP_PRINCIPAL) ?>" style="color: var(--color-accent);"><?= TELEFONE ?></a>
                    </div>
                </div>

                <div class="contato-info-item">
                    <div>
                        <strong>E-mail</strong>
                        <a href="mailto:<?= EMAIL_CONTATO ?>" style="color: var(--color-accent);"><?= EMAIL_CONTATO ?></a>
                    </div>
                </div>

                <div class="contato-info-item">
                    <div>
                        <strong>Redes Sociais</strong>
                        <a href="<?= FACEBOOK_URL ?>" target="_blank" rel="noopener" style="color: var(--color-accent);">Facebook</a> &middot;
                        <a href="<?= INSTAGRAM_URL ?>" target="_blank" rel="noopener" style="color: var(--color-accent);">Instagram</a>
                    </div>
                </div>

                <div class="contato-mapa">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3676.5!2d-47.15!3d-22.76!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjLCsDQ1JzM2LjAiUyA0N8KwMDknMDAuMCJX!5e0!3m2!1spt-BR!2sbr!4v1" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require APP_ROOT . '/app/views/site/footer.php'; ?>
