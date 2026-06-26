-- Migration: adiciona coluna duracao na tabela banners
ALTER TABLE banners ADD COLUMN IF NOT EXISTS duracao INT NOT NULL DEFAULT 5000 AFTER ordem;
