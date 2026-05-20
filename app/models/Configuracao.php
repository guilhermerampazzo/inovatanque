<?php

class Configuracao extends Model
{
    protected string $table = 'configuracoes';

    public static function get(string $chave, string $default = ''): string
    {
        $instance = new self();
        return $instance->getValue($chave, $default);
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        $rows = $stmt->fetchAll();
        $configs = [];
        foreach ($rows as $row) {
            $configs[$row['chave']] = $row['valor'];
        }
        return $configs;
    }

    public function getValue(string $chave, string $default = ''): string
    {
        $stmt = $this->db->prepare("SELECT valor FROM {$this->table} WHERE chave = ?");
        $stmt->execute([$chave]);
        $result = $stmt->fetchColumn();
        return $result !== false ? $result : $default;
    }

    public function set(string $chave, string $valor): void
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM {$this->table} WHERE chave = ?");
        $stmt->execute([$chave]);
        if ((int) $stmt->fetchColumn() > 0) {
            $stmt = $this->db->prepare("UPDATE {$this->table} SET valor = ? WHERE chave = ?");
            $stmt->execute([$valor, $chave]);
        } else {
            $stmt = $this->db->prepare("INSERT INTO {$this->table} (chave, valor) VALUES (?, ?)");
            $stmt->execute([$chave, $valor]);
        }
    }
}
