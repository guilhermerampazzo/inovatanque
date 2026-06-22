<?php $pageTitle = 'Catálogo de Carretas-Tanque - Inova Tanque'; ?>
<?php $pageDescription = 'Catálogo completo de carretas-tanque para locação e venda. Aço, Inox, Térmica. Filtros por capacidade, configuração e modalidade.'; ?>
<?php require APP_ROOT . '/app/views/site/header.php'; ?>

<section style="padding-top: 48px; padding-bottom: 96px;">
    <div class="container">
        <div class="catalogo-layout">
            <!-- Sidebar Filtros -->
            <aside class="catalogo-sidebar" id="filterSidebar">
                <form method="GET" action="/catalogo">
                    <div class="filter-group">
                        <h3>Material</h3>
                        <?php foreach ($categorias as $cat): ?>
                            <?php if ($cat['parent_id'] == 0): ?>
                                <label>
                                    <input type="radio" name="categoria" value="<?= $cat['id'] ?>" <?= ($filters['categoria_id'] ?? '') == $cat['id'] ? 'checked' : '' ?>>
                                    <?= sanitize($cat['nome']) ?>
                                </label>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php foreach ($categorias as $cat): ?>
                            <?php if ($cat['parent_id'] != 0): ?>
                                <label style="padding-left: 20px;">
                                    <input type="radio" name="categoria" value="<?= $cat['id'] ?>" <?= ($filters['categoria_id'] ?? '') == $cat['id'] ? 'checked' : '' ?>>
                                    <?= sanitize($cat['nome']) ?>
                                </label>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <div class="filter-group">
                        <h3>Configuração</h3>
                        <select name="configuracao">
                            <option value="">Todas</option>
                            <option value="Carreta" <?= ($filters['configuracao'] ?? '') === 'Carreta' ? 'selected' : '' ?>>Carreta Simples</option>
                            <option value="Bitrem" <?= ($filters['configuracao'] ?? '') === 'Bitrem' ? 'selected' : '' ?>>Bitrem</option>
                            <option value="Bitrenzao" <?= ($filters['configuracao'] ?? '') === 'Bitrenzao' ? 'selected' : '' ?>>Bitrenzão</option>
                            <option value="Rodotrem" <?= ($filters['configuracao'] ?? '') === 'Rodotrem' ? 'selected' : '' ?>>Rodotrem</option>
                            <option value="Vanderleia 3ED" <?= ($filters['configuracao'] ?? '') === 'Vanderleia 3ED' ? 'selected' : '' ?>>Vanderleia 3ED</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <h3>Carregamento</h3>
                        <label>
                            <input type="radio" name="carregamento" value="" <?= empty($filters['carregamento']) ? 'checked' : '' ?>>
                            Todos
                        </label>
                        <label>
                            <input type="radio" name="carregamento" value="top" <?= ($filters['carregamento'] ?? '') === 'top' ? 'checked' : '' ?>>
                            Top
                        </label>
                        <label>
                            <input type="radio" name="carregamento" value="bottom" <?= ($filters['carregamento'] ?? '') === 'bottom' ? 'checked' : '' ?>>
                            Bottom
                        </label>
                    </div>

                    <div class="filter-group">
                        <h3>Modalidade</h3>
                        <label>
                            <input type="radio" name="modalidade" value="" <?= empty($filters['modalidade']) ? 'checked' : '' ?>>
                            Todas
                        </label>
                        <label>
                            <input type="radio" name="modalidade" value="Locação" <?= ($filters['modalidade'] ?? '') === 'Locação' ? 'checked' : '' ?>>
                            Locação
                        </label>
                        <label>
                            <input type="radio" name="modalidade" value="Venda" <?= ($filters['modalidade'] ?? '') === 'Venda' ? 'checked' : '' ?>>
                            Venda
                        </label>
                        <label>
                            <input type="radio" name="modalidade" value="Consignação" <?= ($filters['modalidade'] ?? '') === 'Consignação' ? 'checked' : '' ?>>
                            Consignação
                        </label>
                    </div>

                    <div class="filter-group">
                        <h3>Ano</h3>
                        <div style="display: flex; gap: 8px; align-items: center;">
                            <select name="ano_min" style="flex: 1;">
                                <option value="">De</option>
                                <?php for ($y = 2000; $y <= date('Y'); $y++): ?>
                                    <option value="<?= $y ?>" <?= ($filters['ano_min'] ?? '') == $y ? 'selected' : '' ?>><?= $y ?></option>
                                <?php endfor; ?>
                            </select>
                            <span style="color: var(--color-text-secondary); font-size: 12px;">até</span>
                            <select name="ano_max" style="flex: 1;">
                                <option value="">Até</option>
                                <?php for ($y = date('Y'); $y >= 2000; $y--): ?>
                                    <option value="<?= $y ?>" <?= ($filters['ano_max'] ?? '') == $y ? 'selected' : '' ?>><?= $y ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">Filtrar</button>
                    <a href="/catalogo" style="display: block; text-align: center; margin-top: 12px; font-size: 13px; color: var(--color-text-secondary);">Limpar filtros</a>
                </form>
            </aside>

            <!-- Conteúdo Principal -->
            <div class="catalogo-main">
                <div class="catalogo-topbar">
                    <div class="result-count">
                        <strong><?= $pagination['total'] ?></strong> equipamento<?= $pagination['total'] !== 1 ? 's' : '' ?> encontrado<?= $pagination['total'] !== 1 ? 's' : '' ?>
                    </div>
                    <button class="btn btn-secondary filter-toggle" style="display: none;" onclick="document.getElementById('filterSidebar').classList.toggle('open')">Filtros</button>
                    <select onchange="window.location.href='/catalogo?ordem='+this.value+'&<?= http_build_query(array_filter($filters)) ?>'">
                        <option value="created_at DESC" <?= ($_GET['ordem'] ?? '') === 'created_at DESC' ? 'selected' : '' ?>>Mais recentes</option>
                        <option value="capacidade DESC" <?= ($_GET['ordem'] ?? '') === 'capacidade DESC' ? 'selected' : '' ?>>Maior capacidade</option>
                        <option value="capacidade ASC" <?= ($_GET['ordem'] ?? '') === 'capacidade ASC' ? 'selected' : '' ?>>Menor capacidade</option>
                        <option value="ano DESC" <?= ($_GET['ordem'] ?? '') === 'ano DESC' ? 'selected' : '' ?>>Ano (mais novo)</option>
                        <option value="ano ASC" <?= ($_GET['ordem'] ?? '') === 'ano ASC' ? 'selected' : '' ?>>Ano (mais antigo)</option>
                    </select>
                </div>

                <div class="products-grid">
                    <?php if (!empty($produtos)): ?>
                        <?php foreach ($produtos as $produto): ?>
                            <a href="/produto/<?= $produto['slug'] ?>" class="card-metallic">
                                <div class="card-image">
                                    <?php if (!empty($produto['imagem_principal'])): ?>
                                        <img src="<?= url($produto['imagem_principal']) ?>" alt="<?= sanitize($produto['titulo']) ?>" loading="lazy">
                                    <?php endif; ?>
                                    <?php if ($produto['status'] === 'pronta_entrega'): ?>
                                        <div class="card-badge"><span>Pronta Entrega</span></div>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <h3><?= sanitize($produto['titulo']) ?></h3>
                                    <p>
                                        <?php if ($produto['capacidade']): ?>
                                            <span><?= number_format($produto['capacidade'], 0, ',', '.') ?>L</span>
                                        <?php endif; ?>
                                        <?php if ($produto['configuracao']): ?>
                                            <span>•</span><span><?= sanitize($produto['configuracao']) ?></span>
                                        <?php endif; ?>
                                        <?php if ($produto['ano']): ?>
                                            <span>•</span><span><?= $produto['ano'] ?></span>
                                        <?php endif; ?>
                                    </p>
                                    <div class="card-footer">
                                        <span class="text-label"><?= sanitize($produto['modalidade'] ?? 'Consulte') ?></span>
                                        <span class="btn">Ver detalhes →</span>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="color: var(--color-text-secondary); grid-column: 1/-1; text-align: center; padding: 64px 0;">Nenhum equipamento encontrado com os filtros selecionados.</p>
                    <?php endif; ?>
                </div>

                <!-- Paginação -->
                <?php if ($pagination['total_pages'] > 1): ?>
                    <div class="pagination">
                        <?php if ($pagination['current_page'] > 1): ?>
                            <a href="/catalogo?page=<?= $pagination['current_page'] - 1 ?>&<?= http_build_query(array_filter($filters)) ?>">&laquo;</a>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                            <?php if ($i === $pagination['current_page']): ?>
                                <span class="active"><?= $i ?></span>
                            <?php else: ?>
                                <a href="/catalogo?page=<?= $i ?>&<?= http_build_query(array_filter($filters)) ?>"><?= $i ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                            <a href="/catalogo?page=<?= $pagination['current_page'] + 1 ?>&<?= http_build_query(array_filter($filters)) ?>">&raquo;</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php require APP_ROOT . '/app/views/site/footer.php'; ?>
