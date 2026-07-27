-- Adiciona o campo "Carroceria" (nivel intermediario do menu: Implemento > Carroceria > Material)
-- Ex: Tanque Graneleiro, Tanque Sider, Tanque Rodocacamba
-- Uso: mysql -u USUARIO -pSENHA BANCO < migration_carroceria.sql

ALTER TABLE produtos ADD COLUMN carroceria VARCHAR(100) DEFAULT NULL AFTER configuracao;
