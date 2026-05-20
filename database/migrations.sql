-- Banco de dados: inovatanque
-- Charset: utf8mb4
-- Uso: mysql -u USUARIO -pSENHA BANCO < migrations.sql

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
    tipo ENUM('cor_texto', 'imagem_texto', 'imagem_link') NOT NULL DEFAULT 'cor_texto',
    cor_fundo VARCHAR(7) DEFAULT '#1a1a1a',
    imagem VARCHAR(255) DEFAULT NULL,
    titulo VARCHAR(255) DEFAULT NULL,
    subtitulo TEXT DEFAULT NULL,
    cta_texto VARCHAR(100) DEFAULT NULL,
    cta_link VARCHAR(255) DEFAULT NULL,
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
('sobre', 'Sobre Nós', '<p>Conteúdo da página Sobre Nós.</p>'),
('politica-de-privacidade', 'Política de Privacidade', '<h2>1. Informações que coletamos</h2><p>Coletamos informações pessoais que você nos fornece diretamente, como nome, e-mail, telefone e dados de empresa ao preencher formulários de contato, cotação ou cadastro em nosso site.</p><h2>2. Como usamos suas informações</h2><p>Utilizamos seus dados para: responder solicitações de cotação, enviar informações sobre nossos produtos e serviços, melhorar a experiência no site e cumprir obrigações legais.</p><h2>3. Compartilhamento de dados</h2><p>Não vendemos ou compartilhamos seus dados pessoais com terceiros, exceto quando necessário para prestação de serviços (ex: seguradoras parceiras) ou por exigência legal.</p><h2>4. Cookies e rastreamento</h2><p>Utilizamos cookies e ferramentas de análise (Google Analytics, Meta Pixel) para entender como nosso site é utilizado e melhorar nossos serviços. Você pode desabilitar cookies nas configurações do seu navegador.</p><h2>5. Segurança</h2><p>Adotamos medidas técnicas e organizacionais para proteger seus dados contra acesso não autorizado, perda ou destruição.</p><h2>6. Seus direitos (LGPD)</h2><p>Conforme a Lei Geral de Proteção de Dados (Lei 13.709/2018), você tem direito a: acessar, corrigir, excluir seus dados pessoais, revogar consentimento e solicitar portabilidade. Entre em contato pelo e-mail contato@inovatanque.com.br.</p><h2>7. Contato</h2><p>Para dúvidas sobre esta política, entre em contato: contato@inovatanque.com.br</p>'),
('termos-de-uso', 'Termos de Uso', '<h2>1. Aceitação dos termos</h2><p>Ao acessar e utilizar o site da Inova Tanque, você concorda com estes Termos de Uso. Caso não concorde, por favor não utilize nosso site.</p><h2>2. Serviços</h2><p>A Inova Tanque oferece locação e venda de carretas-tanque. As informações no site são de caráter informativo e não constituem oferta vinculante. Preços e disponibilidade estão sujeitos a confirmação.</p><h2>3. Cadastro</h2><p>Ao se cadastrar, você se compromete a fornecer informações verdadeiras e manter seus dados atualizados. Você é responsável pela segurança de sua senha.</p><h2>4. Cotações</h2><p>Solicitações de cotação pelo site não geram obrigação de compra ou locação. Os valores finais serão confirmados por nossa equipe comercial.</p><h2>5. Propriedade intelectual</h2><p>Todo o conteúdo do site (textos, imagens, logotipos, layout) é de propriedade da Inova Tanque e protegido por leis de propriedade intelectual.</p><h2>6. Limitação de responsabilidade</h2><p>A Inova Tanque não se responsabiliza por danos decorrentes do uso do site, indisponibilidade temporária ou informações desatualizadas.</p><h2>7. Foro</h2><p>Fica eleito o foro da comarca de Paulínia/SP para dirimir quaisquer questões decorrentes destes termos.</p>');

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
