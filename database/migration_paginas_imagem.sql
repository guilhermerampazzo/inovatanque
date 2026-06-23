-- Adiciona coluna de imagem de destaque na tabela paginas
ALTER TABLE paginas ADD COLUMN imagem VARCHAR(255) DEFAULT NULL AFTER conteudo;
