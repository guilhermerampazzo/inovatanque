<?php $pageTitle = 'Meu Perfil - Inova Tanque'; ?>
<?php require APP_ROOT . '/app/views/site/header.php'; ?>

<section style="padding-top: 48px; padding-bottom: 96px;">
    <div class="container">
        <div class="cliente-layout">
            <aside class="cliente-sidebar">
                <div style="margin-bottom: 24px;">
                    <strong style="color: var(--color-accent); font-size: 16px;"><?= Session::get('cliente_nome') ?></strong>
                </div>
                <nav>
                    <a href="/cliente/dashboard">Dashboard</a>
                    <a href="/cliente/perfil" class="active">Meu Perfil</a>
                    <a href="/cliente/cotacoes">Minhas Cotações</a>
                    <a href="/cliente/favoritos">Meus Favoritos</a>
                    <a href="/logout">Sair</a>
                </nav>
            </aside>

            <div class="cliente-main">
                <h1 style="font-family: var(--font); font-size: 28px; font-weight: 700; color: var(--color-accent); margin-bottom: 32px;">Meu Perfil</h1>

                <form method="POST" action="/cliente/perfil" style="max-width: 600px;">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label>Nome / Razão Social</label>
                        <input type="text" name="nome_razao" value="<?= sanitize($cliente['nome_razao']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" value="<?= sanitize($cliente['email']) ?>" disabled style="opacity: 0.6;">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Telefone</label>
                            <input type="tel" name="telefone" value="<?= sanitize($cliente['telefone'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>WhatsApp</label>
                            <input type="tel" name="whatsapp" value="<?= sanitize($cliente['whatsapp'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Endereço</label>
                        <input type="text" name="endereco" value="<?= sanitize($cliente['endereco'] ?? '') ?>">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Cidade</label>
                            <input type="text" name="cidade" value="<?= sanitize($cliente['cidade'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>UF</label>
                            <input type="text" name="uf" maxlength="2" value="<?= sanitize($cliente['uf'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>CEP</label>
                        <input type="text" name="cep" value="<?= sanitize($cliente['cep'] ?? '') ?>">
                    </div>
                    <div class="form-group" style="margin-top: 32px; padding-top: 24px; border-top: 1px solid rgba(75,69,71,0.2);">
                        <label>Nova Senha (deixe em branco para manter)</label>
                        <input type="password" name="nova_senha">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require APP_ROOT . '/app/views/site/footer.php'; ?>
