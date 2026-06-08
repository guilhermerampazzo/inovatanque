<?php $pageTitle = 'Configurações'; ?>
<?php require APP_ROOT . '/app/views/admin/header.php'; ?>

<div class="admin-header">
    <h1>Configurações Gerais</h1>
</div>

<form method="POST" action="/admin/configuracoes" style="max-width: 700px;">
    <?= csrf_field() ?>

    <h3 style="font-family: var(--font); font-size: 16px; font-weight: 600; color: var(--color-accent); margin-bottom: 16px;">Contato</h3>

    <div class="form-row">
        <div class="form-group">
            <label>Telefone</label>
            <input type="text" name="telefone" value="<?= sanitize($configs['telefone'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>WhatsApp (só números)</label>
            <input type="text" name="whatsapp" value="<?= sanitize($configs['whatsapp'] ?? '') ?>">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>WhatsApp Consignação</label>
            <input type="text" name="whatsapp_consignacao" value="<?= sanitize($configs['whatsapp_consignacao'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>E-mail</label>
            <input type="email" name="email" value="<?= sanitize($configs['email'] ?? '') ?>">
        </div>
    </div>

    <div class="form-group">
        <label>Endereço</label>
        <input type="text" name="endereco" value="<?= sanitize($configs['endereco'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label>CEP</label>
        <input type="text" name="cep" value="<?= sanitize($configs['cep'] ?? '') ?>">
    </div>

    <h3 style="font-family: var(--font); font-size: 16px; font-weight: 600; color: var(--color-accent); margin: 32px 0 16px;">Redes Sociais</h3>

    <div class="form-row">
        <div class="form-group">
            <label>Facebook</label>
            <input type="url" name="facebook" value="<?= sanitize($configs['facebook'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Instagram</label>
            <input type="url" name="instagram" value="<?= sanitize($configs['instagram'] ?? '') ?>">
        </div>
    </div>

    <h3 style="font-family: var(--font); font-size: 16px; font-weight: 600; color: var(--color-accent); margin: 32px 0 16px;">Tracking</h3>

    <div class="form-row">
        <div class="form-group">
            <label>Google Tag Manager ID</label>
            <input type="text" name="gtm_id" placeholder="GTM-XXXXXXX" value="<?= sanitize($configs['gtm_id'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Meta Pixel ID</label>
            <input type="text" name="meta_pixel_id" value="<?= sanitize($configs['meta_pixel_id'] ?? '') ?>">
        </div>
    </div>

    <div class="form-group">
        <label>Google Ads ID</label>
        <input type="text" name="google_ads_id" value="<?= sanitize($configs['google_ads_id'] ?? '') ?>">
    </div>

    <h3 style="font-family: var(--font); font-size: 16px; font-weight: 600; color: var(--color-accent); margin: 32px 0 16px;">WhatsApp</h3>

    <div class="form-group">
        <label>Mensagem pré-preenchida (produto)</label>
        <textarea name="whatsapp_msg_produto" rows="3"><?= sanitize($configs['whatsapp_msg_produto'] ?? '') ?></textarea>
        <small style="color: var(--color-text-secondary); font-size: 12px;">Use {produto} e {codigo} como variáveis.</small>
    </div>

    <h3 style="font-family: var(--font); font-size: 16px; font-weight: 600; color: var(--color-accent); margin: 32px 0 16px;">SEO</h3>

    <div class="form-group">
        <label>Meta Title (padrão)</label>
        <input type="text" name="meta_title" value="<?= sanitize($configs['meta_title'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label>Meta Description (padrão)</label>
        <textarea name="meta_description" rows="2"><?= sanitize($configs['meta_description'] ?? '') ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary btn-lg" style="margin-top: 16px;">Salvar Configurações</button>
</form>

<?php require APP_ROOT . '/app/views/admin/footer.php'; ?>
