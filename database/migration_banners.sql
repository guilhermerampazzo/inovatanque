-- Migração: adiciona colunas ausentes na tabela banners
-- Rodar: mysql -u USUARIO -pSENHA BANCO < migration_banners.sql

ALTER TABLE banners
    ADD COLUMN IF NOT EXISTS tipo ENUM('cor_texto', 'imagem_texto', 'imagem_link') NOT NULL DEFAULT 'cor_texto' AFTER id,
    ADD COLUMN IF NOT EXISTS cor_fundo VARCHAR(7) DEFAULT '#1a1a1a' AFTER tipo,
    ADD COLUMN IF NOT EXISTS subtitulo TEXT DEFAULT NULL AFTER titulo,
    ADD COLUMN IF NOT EXISTS cta_texto VARCHAR(100) DEFAULT NULL AFTER subtitulo,
    ADD COLUMN IF NOT EXISTS cta_link VARCHAR(255) DEFAULT NULL AFTER cta_texto,
    ADD COLUMN IF NOT EXISTS link VARCHAR(255) DEFAULT NULL AFTER cta_link;
