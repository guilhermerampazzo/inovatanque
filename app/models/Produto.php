<?php

class Produto extends Model
{
    protected string $table = 'produtos';

    public function getDestaques(int $limit = 8): array
    {
        $stmt = $this->db->prepare("SELECT p.*, pi.arquivo as imagem_principal FROM {$this->table} p LEFT JOIN produto_imagens pi ON pi.produto_id = p.id AND pi.principal = 1 WHERE p.destaque = 1 AND p.status IN ('disponivel','pronta_entrega') ORDER BY p.ordem ASC LIMIT ?");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    public function getProntaEntrega(int $limit = 4): array
    {
        $stmt = $this->db->prepare("SELECT p.*, pi.arquivo as imagem_principal FROM {$this->table} p LEFT JOIN produto_imagens pi ON pi.produto_id = p.id AND pi.principal = 1 WHERE p.status = 'pronta_entrega' ORDER BY p.created_at DESC LIMIT ?");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    public function getByModalidade(string $modalidade, int $limit = 4): array
    {
        $stmt = $this->db->prepare("SELECT p.*, pi.arquivo as imagem_principal FROM {$this->table} p LEFT JOIN produto_imagens pi ON pi.produto_id = p.id AND pi.principal = 1 WHERE p.modalidade LIKE ? AND p.status IN ('disponivel','pronta_entrega') ORDER BY p.created_at DESC LIMIT ?");
        $stmt->execute(['%' . $modalidade . '%', $limit]);
        return $stmt->fetchAll();
    }

    public function getByCategoria(int $categoriaId, int $limit = 4): array
    {
        $stmt = $this->db->prepare("SELECT p.*, pi.arquivo as imagem_principal FROM {$this->table} p LEFT JOIN produto_imagens pi ON pi.produto_id = p.id AND pi.principal = 1 WHERE p.categoria_id = ? AND p.status IN ('disponivel','pronta_entrega') ORDER BY p.created_at DESC LIMIT ?");
        $stmt->execute([$categoriaId, $limit]);
        return $stmt->fetchAll();
    }

    public function getRelacionados(int $excludeId, int $categoriaId, int $limit = 4): array
    {
        $stmt = $this->db->prepare("SELECT p.*, pi.arquivo as imagem_principal FROM {$this->table} p LEFT JOIN produto_imagens pi ON pi.produto_id = p.id AND pi.principal = 1 WHERE p.id != ? AND p.categoria_id = ? AND p.status IN ('disponivel','pronta_entrega') ORDER BY RAND() LIMIT ?");
        $stmt->execute([$excludeId, $categoriaId, $limit]);
        return $stmt->fetchAll();
    }

    public function countFiltered(array $filters): int
    {
        $where = "status IN ('disponivel','pronta_entrega')";
        $params = [];
        $where = $this->applyFilters($where, $params, $filters);
        return $this->count($where, $params);
    }

    public function getFiltered(array $filters, string $orderBy, int $limit, int $offset): array
    {
        $where = "p.status IN ('disponivel','pronta_entrega')";
        $params = [];
        $where = $this->applyFilters($where, $params, $filters, 'p');

        $allowedOrders = [
            'created_at DESC' => 'p.created_at DESC',
            'capacidade ASC' => 'p.capacidade ASC',
            'capacidade DESC' => 'p.capacidade DESC',
            'ano DESC' => 'p.ano DESC',
        ];
        $order = $allowedOrders[$orderBy] ?? 'p.created_at DESC';

        $sql = "SELECT p.*, pi.arquivo as imagem_principal FROM {$this->table} p LEFT JOIN produto_imagens pi ON pi.produto_id = p.id AND pi.principal = 1 WHERE {$where} ORDER BY {$order} LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    private function applyFilters(string $where, array &$params, array $filters, string $prefix = ''): string
    {
        $p = $prefix ? $prefix . '.' : '';
        if (!empty($filters['categoria_id'])) {
            $where .= " AND {$p}categoria_id = ?";
            $params[] = (int) $filters['categoria_id'];
        }
        if (!empty($filters['configuracao'])) {
            $where .= " AND {$p}configuracao = ?";
            $params[] = $filters['configuracao'];
        }
        if (!empty($filters['carregamento'])) {
            $where .= " AND {$p}carregamento = ?";
            $params[] = $filters['carregamento'];
        }
        if (!empty($filters['modalidade'])) {
            $where .= " AND {$p}modalidade LIKE ?";
            $params[] = '%' . $filters['modalidade'] . '%';
        }
        if (!empty($filters['ano'])) {
            $where .= " AND {$p}ano = ?";
            $params[] = (int) $filters['ano'];
        }
        if (!empty($filters['fabricante'])) {
            $where .= " AND {$p}fabricante = ?";
            $params[] = $filters['fabricante'];
        }
        return $where;
    }
}
