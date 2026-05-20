-- Banco de dados: inovatanque
-- Charset: utf8mb4

CREATE DATABASE IF NOT EXISTS inovatanque CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE inovatanque;

-- Admins
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    role ENUM('admin', 'editor') NOT NULL DEFAULT 'editor',
    ativo TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Clientes
CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('pf', 'pj') NOT NULL DEFAULT 'pf',
    nome_razao VARCHAR(255) NOT NULL,
    cpf_cnpj VARCHAR(20) DEFAULT NULL,
    ie VARCHAR(30) DEFAULT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    telefone VARCHAR(20) DEFAULT NULL,
    whatsapp VARCHAR(20) DEFAULT NULL,
    endereco VARCHAR(255) DEFAULT NULL,
    cidade VARCHAR(100) DEFAULT NULL,
    uf CHAR(2) DEFAULT NULL,
    cep VARCHAR(10) DEFAULT NULL,
    ativo TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Categorias
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    parent_id INT NOT NULL DEFAULT 0,
    ordem INT NOT NULL DEFAULT 0,
    ativo TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

-- Produtos
CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(50) DEFAULT NULL,
    titulo VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    categoria_id INT NOT NULL,
    configuracao VARCHAR(100) DEFAULT NULL,
    capacidade INT DEFAULT NULL,
    ano INT DEFAULT NULL,
    fabricante VARCHAR(100) DEFAULT NULL,
    carregamento ENUM('top', 'bottom') DEFAULT NULL,
    modalidade VARCHAR(100) DEFAULT NULL,
    status ENUM('disponivel', 'pronta_entrega', 'locado', 'vendido') NOT NULL DEFAULT 'disponivel',
    descricao TEXT DEFAULT NULL,
    destaque TINYINT(1) NOT NULL DEFAULT 0,
    ordem INT NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Imagens de produtos
CREATE TABLE produto_imagens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    arquivo VARCHAR(255) NOT NULL,
    ordem INT NOT NULL DEFAULT 0,
    principal TINYINT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Cotações / Leads
CREATE TABLE cotacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT DEFAULT NULL,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telefone VARCHAR(20) DEFAULT NULL,
    produto_id INT DEFAULT NULL,
    mensagem TEXT DEFAULT NULL,
    status ENUM('nova', 'em_atendimento', 'fechada', 'perdida') NOT NULL DEFAULT 'nova',
    notas_internas TEXT DEFAULT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE SET NULL,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Favoritos
CREATE TABLE favoritos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    produto_id INT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_favorito (cliente_id, produto_id),
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Categorias do blog
CREATE TABLE post_categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- Posts do blog
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    categoria_id INT DEFAULT NULL,
    imagem VARCHAR(255) DEFAULT NULL,
    resumo TEXT DEFAULT NULL,
    conteudo LONGTEXT DEFAULT NULL,
    autor_id INT DEFAULT NULL,
    status ENUM('rascunho', 'publicado') NOT NULL DEFAULT 'rascunho',
    publicado_em DATETIME DEFAULT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES post_categorias(id) ON DELETE SET NULL,
    FOREIGN KEY (autor_id) REFERENCES admins(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Depoimentos
CREATE TABLE depoimentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    empresa VARCHAR(255) DEFAULT NULL,
    cargo VARCHAR(100) DEFAULT NULL,
    foto VARCHAR(255) DEFAULT NULL,
    texto TEXT NOT NULL,
    ordem INT NOT NULL DEFAULT 0,
    ativo TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

-- Logos de clientes/parceiros
CREATE TABLE clientes_logos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    logo VARCHAR(255) NOT NULL,
    ordem INT NOT NULL DEFAULT 0,
    ativo TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

-- Banners do hero
CREATE TABLE banners (
    id INT AUTO_INCREMENT PRIMARY KEY,
    imagem VARCHAR(255) DEFAULT NULL,
    titulo VARCHAR(255) DEFAULT NULL,
    subtitulo VARCHAR(255) DEFAULT NULL,
    link VARCHAR(255) DEFAULT NULL,
    ordem INT NOT NULL DEFAULT 0,
    ativo TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

-- Configurações gerais (key/value)
CREATE TABLE configuracoes (
    chave VARCHAR(100) PRIMARY KEY,
    valor TEXT DEFAULT NULL
) ENGINE=InnoDB;

-- Páginas institucionais
CREATE TABLE paginas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(100) NOT NULL UNIQUE,
    titulo VARCHAR(255) NOT NULL,
    conteudo LONGTEXT DEFAULT NULL
) ENGINE=InnoDB;

-- Dados iniciais

-- Admin padrão (senha: admin123)
INSERT INTO admins (nome, email, senha, role, ativo) VALUES
('Administrador', 'admin@inovatanque.com.br', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 1);

-- Categorias padrão
INSERT INTO categorias (nome, slug, parent_id, ordem, ativo) VALUES
('Aço', 'aco', 0, 1, 1),
('Aço Carbono', 'aco-carbono', 0, 2, 1),
('Inox', 'inox', 0, 3, 1),
('Térmica', 'termica', 0, 4, 1);

INSERT INTO categorias (nome, slug, parent_id, ordem, ativo) VALUES
('Asfáltica', 'asfaltica', 4, 1, 1),
('Vegetal', 'vegetal', 4, 2, 1);

-- Páginas institucionais
INSERT INTO paginas (slug, titulo, conteudo) VALUES
('sobre', 'Sobre Nós', '<p>Conteúdo da página Sobre Nós.</p>');

-- Configurações padrão
INSERT INTO configuracoes (chave, valor) VALUES
('telefone', '(19) 97406-0706'),
('whatsapp', '5519974060706'),
('whatsapp_consignacao', '5519974162357'),
('email', 'contato@inovatanque.com.br'),
('endereco', 'Rodovia Professor Zeferino Vaz (SP 332) — KM 125, Santa Terezinha, Paulínia/SP'),
('cep', '13140-774'),
('facebook', 'https://facebook.com/inovatanque'),
('instagram', 'https://instagram.com/inovatanque'),
('gtm_id', ''),
('meta_pixel_id', ''),
('google_ads_id', ''),
('whatsapp_msg_produto', 'Olá! Tenho interesse no produto: {produto} (Código: {codigo}). Gostaria de mais informações.'),
('meta_title', 'Inova Tanque - Locação e Venda de Carretas-Tanque'),
('meta_description', 'Locação e venda de carretas-tanque em Paulínia/SP. Pronta entrega, manutenção própria e seguro incluso.');
