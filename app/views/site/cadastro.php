<?php $pageTitle = 'Cadastro - Inova Tanque'; ?>
<?php require APP_ROOT . '/app/views/site/header.php'; ?>

<section>
    <div class="container">
        <div class="form-page" style="max-width: 600px;">
            <h1>Criar Conta</h1>
            <p class="subtitle">Cadastre-se para solicitar cotações e salvar favoritos</p>

            <form method="POST" action="/cadastro">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label>Tipo</label>
                    <div style="display: flex; gap: 24px; margin-top: 8px;">
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; text-transform: none; letter-spacing: 0; font-size: 15px; color: var(--color-on-surface);">
                            <input type="radio" name="tipo" value="pf" checked style="accent-color: var(--color-gold);"> Pessoa Física
                        </label>
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; text-transform: none; letter-spacing: 0; font-size: 15px; color: var(--color-on-surface);">
                            <input type="radio" name="tipo" value="pj" style="accent-color: var(--color-gold);"> Pessoa Jurídica
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="nome_razao">Nome / Razão Social *</label>
                    <input type="text" id="nome_razao" name="nome_razao" required value="<?= old('nome_razao') ?>">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="cpf_cnpj">CPF / CNPJ</label>
                        <input type="text" id="cpf_cnpj" name="cpf_cnpj" value="<?= old('cpf_cnpj') ?>">
                    </div>
                    <div class="form-group">
                        <label for="ie">Inscrição Estadual</label>
                        <input type="text" id="ie" name="ie" value="<?= old('ie') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">E-mail *</label>
                    <input type="email" id="email" name="email" required value="<?= old('email') ?>">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="telefone">Telefone</label>
                        <input type="tel" id="telefone" name="telefone" value="<?= old('telefone') ?>">
                    </div>
                    <div class="form-group">
                        <label for="whatsapp">WhatsApp</label>
                        <input type="tel" id="whatsapp" name="whatsapp" value="<?= old('whatsapp') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="endereco">Endereço</label>
                    <input type="text" id="endereco" name="endereco" value="<?= old('endereco') ?>">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="cidade">Cidade</label>
                        <input type="text" id="cidade" name="cidade" value="<?= old('cidade') ?>">
                    </div>
                    <div class="form-group">
                        <label for="uf">UF</label>
                        <input type="text" id="uf" name="uf" maxlength="2" value="<?= old('uf') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="cep">CEP</label>
                    <input type="text" id="cep" name="cep" value="<?= old('cep') ?>">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="senha">Senha *</label>
                        <input type="password" id="senha" name="senha" required>
                    </div>
                    <div class="form-group">
                        <label for="senha_confirmacao">Confirmar Senha *</label>
                        <input type="password" id="senha_confirmacao" name="senha_confirmacao" required>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 8px;">
                    <label style="display: flex; align-items: flex-start; gap: 10px; cursor: pointer; text-transform: none; letter-spacing: 0; font-size: 13px; color: var(--color-on-surface-variant);">
                        <input type="checkbox" required style="accent-color: var(--color-gold); margin-top: 2px;">
                        Li e aceito os <a href="#" style="color: var(--color-gold);">Termos de Uso</a> e a <a href="#" style="color: var(--color-gold);">Política de Privacidade</a>.
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-lg">Criar Conta</button>
            </form>

            <div class="form-footer">
                <p>Já tem conta? <a href="/login">Faça login</a></p>
            </div>
        </div>
    </div>
</section>

<?php require APP_ROOT . '/app/views/site/footer.php'; ?>
