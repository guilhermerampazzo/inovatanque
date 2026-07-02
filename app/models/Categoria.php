<?php

class Categoria extends Model
{
    protected string $table = 'categorias';

    public function getAtivas(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE ativo = 1 ORDER BY ordem ASC, nome ASC");
        return $stmt->fetchAll();
    }

    public function getArvore(): array
    {
        $todas = $this->getAtivas();
        $tree = [];
        foreach ($todas as $cat) {
            if ($cat['parent_id'] == 0) {
                $cat['filhas'] = array_filter($todas, fn($c) => $c['parent_id'] == $cat['id']);
                $tree[] = $cat;
            }
        }
        return $tree;
    }

    /**
     * Monta o menu do header a partir de uma LISTA FIXA de configurações
     * (Carreta Simples, Bitrem, Bitrenzão, Rodotrem, Vanderleia 3ED), tendo como
     * subitens os MATERIAIS (categorias) que possuem produtos naquela configuração.
     * Configurações e materiais sem produto não aparecem.
     *
     * @param array $configs Lista de ['label'=>, 'valor'=>, 'like'=>] (valor = valor usado no filtro)
     * @return array [ ['label'=>, 'valor'=>, 'materiais'=>[['id'=>,'nome'=>], ...]], ... ]
     */
    public function getMenuPorConfiguracao(array $configs): array
    {
        $menu = [];
        foreach ($configs as $cfg) {
            $stmt = $this->db->prepare("
                SELECT DISTINCT c.id AS cat_id, c.nome AS cat_nome
                FROM produtos p
                JOIN categorias c ON c.id = p.categoria_id
                WHERE c.ativo = 1
                  AND LOWER(p.configuracao) LIKE ?
                ORDER BY c.nome ASC
            ");
            $stmt->execute(['%' . mb_strtolower($cfg['like']) . '%']);
            $materiais = [];
            foreach ($stmt->fetchAll() as $r) {
                $materiais[] = ['id' => (int) $r['cat_id'], 'nome' => $r['cat_nome']];
            }
            if (!empty($materiais)) {
                $menu[] = [
                    'label' => $cfg['label'],
                    'valor' => $cfg['valor'],
                    'materiais' => $materiais,
                ];
            }
        }
        return $menu;
    }
}
