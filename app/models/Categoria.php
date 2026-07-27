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

    /**
     * Monta o menu do header em 3 niveis a partir de uma LISTA FIXA de Implementos
     * (config): Implemento > Carroceria (produtos.carroceria) > Material (categorias).
     * Implementos, carrocerias e materiais sem produto nao aparecem.
     *
     * @param array $configs Lista de ['label'=>, 'valor'=>, 'like'=>] (like = filtro em produtos.configuracao)
     * @return array [ ['label'=>, 'valor'=>, 'carrocerias'=>[ ['nome'=>, 'materiais'=>[['id'=>,'nome'=>], ...]] ] ] ]
     */
    public function getMenuTresNiveis(array $configs): array
    {
        $menu = [];
        foreach ($configs as $cfg) {
            $stmt = $this->db->prepare("
                SELECT DISTINCT p.carroceria AS carroceria, c.id AS cat_id, c.nome AS cat_nome
                FROM produtos p
                JOIN categorias c ON c.id = p.categoria_id
                WHERE c.ativo = 1
                  AND LOWER(p.configuracao) LIKE ?
                  AND p.carroceria IS NOT NULL AND p.carroceria <> ''
                ORDER BY p.carroceria ASC, c.nome ASC
            ");
            $stmt->execute(['%' . mb_strtolower($cfg['like']) . '%']);

            $carrocerias = [];
            foreach ($stmt->fetchAll() as $r) {
                $nomeCarroceria = $r['carroceria'];
                if (!isset($carrocerias[$nomeCarroceria])) {
                    $carrocerias[$nomeCarroceria] = ['nome' => $nomeCarroceria, 'materiais' => []];
                }
                $carrocerias[$nomeCarroceria]['materiais'][] = ['id' => (int) $r['cat_id'], 'nome' => $r['cat_nome']];
            }

            if (!empty($carrocerias)) {
                $menu[] = [
                    'label' => $cfg['label'],
                    'valor' => $cfg['valor'],
                    'carrocerias' => array_values($carrocerias),
                ];
            }
        }
        return $menu;
    }
}
