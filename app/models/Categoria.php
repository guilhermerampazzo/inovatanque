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
}
