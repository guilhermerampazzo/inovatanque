<?php $pageTitle = 'Banners'; ?>
<?php require APP_ROOT . '/app/views/admin/header.php'; ?>

<div class="admin-header">
    <h1>Banners do Hero <span style="font-size: 14px; font-weight: 400; color: var(--color-text-secondary);">(<?= count($banners) ?>/5)</span></h1>
    <?php if (count($banners) < 5): ?>
        <a href="/admin/banners/criar" class="btn btn-primary">Novo Banner</a>
    <?php endif; ?>
</div>

<div class="table-responsive">
    <table class="data-table">
        <thead>
            <tr>
                <th>Preview</th>
                <th>Tipo</th>
                <th>Título</th>
                <th>Ordem</th>
                <th>Ativo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($banners as $b): ?>
                <tr>
                    <td>
                        <?php if ($b['imagem']): ?>
                            <img src="<?= url($b['imagem']) ?>" style="width: 100px; height: 50px; object-fit: cover; border-radius: 6px;">
                        <?php elseif ($b['cor_fundo']): ?>
                            <div style="width: 100px; height: 50px; background: <?= sanitize($b['cor_fundo']) ?>; border-radius: 6px;"></div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php
                        $tipos = ['cor_texto' => 'Cor + Texto', 'imagem_texto' => 'Imagem + Texto', 'imagem_link' => 'Só Imagem'];
                        echo $tipos[$b['tipo'] ?? 'cor_texto'] ?? 'Cor + Texto';
                        ?>
                    </td>
                    <td><?= sanitize($b['titulo'] ?? '-') ?></td>
                    <td><?= $b['ordem'] ?></td>
                    <td><?= $b['ativo'] ? 'Sim' : 'Não' ?></td>
                    <td style="display: flex; gap: 8px;">
                        <a href="/admin/banners/editar/<?= $b['id'] ?>" class="btn btn-secondary" style="padding: 4px 10px; font-size: 11px;">Editar</a>
                        <form method="POST" action="/admin/banners/excluir/<?= $b['id'] ?>" onsubmit="return confirm('Excluir este banner?')">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-secondary" style="padding: 4px 10px; font-size: 11px; color: var(--color-error);">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if (empty($banners)): ?>
    <p style="text-align: center; color: var(--color-text-muted); padding: 40px 0;">Nenhum banner cadastrado.</p>
<?php endif; ?>

<?php require APP_ROOT . '/app/views/admin/footer.php'; ?>
