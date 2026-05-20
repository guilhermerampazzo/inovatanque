<?php

class Depoimento extends Model
{
    protected string $table = 'depoimentos';

    public function getAtivos(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE ativo = 1 ORDER BY ordem ASC");
        return $stmt->fetchAll();
    }
}
