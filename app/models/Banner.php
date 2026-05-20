<?php

class Banner extends Model
{
    protected string $table = 'banners';

    public function getAtivos(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE ativo = 1 ORDER BY ordem ASC");
        return $stmt->fetchAll();
    }
}
