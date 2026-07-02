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
     * Monta o menu do header por CONFIGURAÇÃO (Bitrem, Bitrenzão...),
     * tendo como subitens os MATERIAIS (categorias) que possuem produtos
     * naquela configuração. Configurações/materiais sem produto não aparecem.
     *
     * Retorna: [ ['configuracao' => 'Bitrem', 'materiais' => [ ['id'=>.., 'nome'=>..], ... ] ], ... ]
     */
    public function getMenuPorConfiguracao(): array
    {
        $sql = "
            SELECT p.configuracao AS conf, c.id AS cat_id, c.nome AS cat_nome
            FROM produtos p
            JOIN categorias c ON c.id = p.categoria_id
            WHERE p.configuracao IS NOT NULL AND p.configuracao <> ''
              AND c.ativo = 1
            GROUP BY p.configuracao, c.id, c.nome
            ORDER BY p.configuracao ASC, c.nome ASC
        ";
        $rows = $this->db->query($sql)->fetchAll();

        $menu = [];
        foreach ($rows as $r) {
            $conf = $r['conf'];
            if (!isset($menu[$conf])) {
                $menu[$conf] = ['configuracao' => $conf, 'materiais' => []];
            }
            $menu[$conf]['materiais'][] = ['id' => (int) $r['cat_id'], 'nome' => $r['cat_nome']];
        }
        return array_values($menu);
    }
}
