<?php $pageTitle = 'Cadastro - Inova Tanque'; ?>
<?php require APP_ROOT . '/app/views/site/header.php'; ?>

<section style="padding: 48px 0 80px;">
    <div class="container" style="max-width: 640px;">
        <div style="text-align: center; margin-bottom: 40px;">
            <h1 style="font-size: 28px; font-weight: 700; color: var(--color-text); margin-bottom: 8px;">Criar Conta</h1>
            <p style="font-size: 15px; color: var(--color-text-secondary);">Cadastre-se para solicitar cotações e acompanhar seus pedidos</p>
        </div>

        <div style="background: #fff; border-radius: 16px; padding: 40px; box-shadow: var(--shadow-sm); border: 1px solid var(--color-border-light);">

            <?php $flash_error = Session::flash('error'); ?>
            <?php if ($flash_error): ?>
                <div style="padding: 12px 16px; background: #fef2f2; border-left: 4px solid var(--color-error); border-radius: 8px; color: #991b1b; font-size: 14px; margin-bottom: 24px;"><?= $flash_error ?></div>
            <?php endif; ?>

            <form method="POST" action="/cadastro">
                <?= csrf_field() ?>

                <!-- Tipo de pessoa -->
                <div style="margin-bottom: 28px;">
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--color-text); margin-bottom: 10px;">Tipo de cadastro</label>
                    <div style="display: flex; gap: 12px;">
                        <label class="radio-card">
                            <input type="radio" name="tipo" value="pf" checked>
                            <span class="radio-card-content">
                                <strong>Pessoa Física</strong>
                                <small>CPF</small>
                            </span>
                        </label>
                        <label class="radio-card">
                            <input type="radio" name="tipo" value="pj">
                            <span class="radio-card-content">
                                <strong>Pessoa Jurídica</strong>
                                <small>CNPJ</small>
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Dados principais -->
                <div class="form-section-title">Dados principais</div>

                <div class="form-group">
                    <label for="nome_razao">Nome / Razão Social *</label>
                    <input type="text" id="nome_razao" name="nome_razao" required value="<?= old('nome_razao') ?>" placeholder="Nome completo ou razão social">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="cpf_cnpj">CPF / CNPJ</label>
                        <input type="text" id="cpf_cnpj" name="cpf_cnpj" value="<?= old('cpf_cnpj') ?>" placeholder="000.000.000-00">
                    </div>
                    <div class="form-group">
                        <label for="ie">Inscrição Estadual</label>
                        <input type="text" id="ie" name="ie" value="<?= old('ie') ?>" placeholder="Opcional">
                    </div>
                </div>

                <!-- Contato -->
                <div class="form-section-title">Contato</div>

                <div class="form-group">
                    <label for="email">E-mail *</label>
                    <input type="email" id="email" name="email" required value="<?= old('email') ?>" placeholder="seu@email.com">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="telefone">Telefone</label>
                        <input type="tel" id="telefone" name="telefone" value="<?= old('telefone') ?>" placeholder="(00) 0000-0000">
                    </div>
                    <div class="form-group">
                        <label for="whatsapp">WhatsApp</label>
                        <input type="tel" id="whatsapp" name="whatsapp" value="<?= old('whatsapp') ?>" placeholder="(00) 00000-0000">
                    </div>
                </div>

                <!-- Endereço -->
                <div class="form-section-title">Endereço</div>

                <div class="form-group">
                    <label for="cep">CEP</label>
                    <input type="text" id="cep" name="cep" value="<?= old('cep') ?>" placeholder="00000-000" style="max-width: 200px;">
                </div>

                <div class="form-group">
                    <label for="endereco">Endereço</label>
                    <input type="text" id="endereco" name="endereco" value="<?= old('endereco') ?>" placeholder="Rua, número, complemento">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="cidade">Cidade</label>
                        <input type="text" id="cidade" name="cidade" value="<?= old('cidade') ?>" placeholder="Cidade">
                    </div>
                    <div class="form-group" style="max-width: 100px;">
                        <label for="uf">UF</label>
                        <input type="text" id="uf" name="uf" maxlength="2" value="<?= old('uf') ?>" placeholder="SP">
                    </div>
                </div>

                <!-- Senha -->
                <div class="form-section-title">Segurança</div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="senha">Senha *</label>
                        <input type="password" id="senha" name="senha" required placeholder="Mínimo 6 caracteres">
                    </div>
                    <div class="form-group">
                        <label for="senha_confirmacao">Confirmar Senha *</label>
                        <input type="password" id="senha_confirmacao" name="senha_confirmacao" required placeholder="Repita a senha">
                    </div>
                </div>

                <!-- Termos -->
                <div style="margin: 24px 0 28px;">
                    <label style="display: flex; align-items: flex-start; gap: 10px; cursor: pointer; font-size: 13px; color: var(--color-text-secondary); line-height: 1.5;">
                        <input type="checkbox" required style="accent-color: var(--color-accent); margin-top: 3px; width: 16px; height: 16px; flex-shrink: 0;">
                        Li e aceito os <a href="#" style="color: var(--color-accent); font-weight: 500;">Termos de Uso</a>&nbsp;e a&nbsp;<a href="#" style="color: var(--color-accent); font-weight: 500;">Política de Privacidade</a>.
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-lg" style="width: 100%; padding: 14px; font-size: 15px; border-radius: 10px;">Criar Conta</button>
            </form>
        </div>

        <p style="text-align: center; margin-top: 24px; font-size: 14px; color: var(--color-text-secondary);">
            Já tem conta? <a href="/login" style="color: var(--color-accent); font-weight: 500;">Faça login</a>
        </p>
    </div>
</section>

<style>
.radio-card {
    flex: 1;
    cursor: pointer;
}
.radio-card input {
    display: none;
}
.radio-card-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    padding: 16px;
    border: 2px solid var(--color-border);
    border-radius: 12px;
    text-align: center;
    transition: all 0.15s ease;
}
.radio-card-content strong {
    font-size: 14px;
    color: var(--color-text);
}
.radio-card-content small {
    font-size: 12px;
    color: var(--color-text-muted);
}
.radio-card input:checked + .radio-card-content {
    border-color: var(--color-accent);
    background: var(--color-accent-light);
}
.radio-card input:checked + .radio-card-content strong {
    color: var(--color-accent-hover);
}
.form-section-title {
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--color-text-muted);
    margin: 28px 0 16px;
    padding-bottom: 8px;
    border-bottom: 1px solid var(--color-border-light);
}
</style>

<?php require APP_ROOT . '/app/views/site/footer.php'; ?>
