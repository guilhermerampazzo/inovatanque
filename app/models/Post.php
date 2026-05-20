<?php

class Post extends Model
{
    protected string $table = 'posts';

    public function countPublicados(array $filters = []): int
    {
        $where = "status = 'publicado'";
        $params = [];
        if (!empty($filters['categoria_id'])) {
            $where .= " AND categoria_id = ?";
            $params[] = $filters['categoria_id'];
        }
        return $this->count($where, $params);
    }

    public function getPublicados(array $filters = [], int $limit = 12, int $offset = 0): array
    {
        $where = "status = 'publicado'";
        $params = [];
        if (!empty($filters['categoria_id'])) {
            $where .= " AND categoria_id = ?";
            $params[] = $filters['categoria_id'];
        }
        $params[] = $limit;
        $params[] = $offset;
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$where} ORDER BY publicado_em DESC LIMIT ? OFFSET ?");
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getRecentes(int $limit = 5): array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE status = 'publicado' ORDER BY publicado_em DESC LIMIT ?");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    public function findPublicado(string $slug): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE slug = ? AND status = 'publicado'");
        $stmt->execute([$slug]);
        return $stmt->fetch() ?: null;
    }

    public function getRelacionados(int $excludeId, int $categoriaId, int $limit = 3): array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id != ? AND categoria_id = ? AND status = 'publicado' ORDER BY publicado_em DESC LIMIT ?");
        $stmt->execute([$excludeId, $categoriaId, $limit]);
        return $stmt->fetchAll();
    }
}
