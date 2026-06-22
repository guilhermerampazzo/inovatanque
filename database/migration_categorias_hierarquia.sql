-- Ajuste de hierarquia das categorias de Aço
-- Antes: "Aço Carbono" e "Inox" estavam como categorias principais (parent_id = 0)
-- Depois: ambas passam a ser filhas de "Aço" (id 1), e "Inox" vira "Aço Inox"
-- Uso: mysql -u USUARIO -pSENHA BANCO < migration_categorias_hierarquia.sql

UPDATE categorias SET nome = 'Aço Inox', parent_id = 1, ordem = 1 WHERE slug = 'inox';
UPDATE categorias SET parent_id = 1, ordem = 2 WHERE slug = 'aco-carbono';
