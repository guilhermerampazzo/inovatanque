<?php

class Favorito extends Model
{
    protected string $table = 'favoritos';

    public function existe(int $clienteId, int $produtoId): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM {$this->table} WHERE cliente_id = ? AND produto_id = ?");
        $stmt->execute([$clienteId, $produtoId]);
        return (int) $stmt->fetchColumn() > 0;
    }

    public function remover(int $clienteId, int $produtoId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE cliente_id = ? AND produto_id = ?");
        return $stmt->execute([$clienteId, $produtoId]);
    }

    public function getComProduto(int $clienteId): array
    {
        $stmt = $this->db->prepare("SELECT f.*, p.titulo, p.slug, p.capacidade, p.modalidade, pi.arquivo as imagem_principal FROM {$this->table} f JOIN produtos p ON p.id = f.produto_id LEFT JOIN produto_imagens pi ON pi.produto_id = p.id AND pi.principal = 1 WHERE f.cliente_id = ? ORDER BY f.created_at DESC");
        $stmt->execute([$clienteId]);
        return $stmt->fetchAll();
    }
}
