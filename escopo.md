# Escopo — Novo Site Inova Tanque

## 1. Visão Geral

Reescrita completa do site da **Inova Tanque** (atualmente em Loja Integrada) para uma stack própria em **PHP puro**, com painel administrativo customizado, área do cliente, blog e catálogo de implementos rodoviários (carretas-tanque).

**Foco principal do site:** locação de carretas-tanque (locação > venda > consignação).

---

## 2. Stack e Convenções Técnicas

### Stack
- **Backend:** PHP puro (sem framework — estrutura própria MVC ou similar)
- **Banco de dados:** MySQL ou PostgreSQL (a definir conforme hospedagem)
- **Frontend:** HTML5 + CSS3 + JavaScript vanilla (ou Alpine.js se necessário)
- **UI Design:** **Google Stitch MCP obrigatório** antes de qualquer código de frontend (toda página passa por Stitch antes de virar HTML/CSS)
- **Versionamento:** Git + GitHub (push obrigatório após cada mudança)
- **Logo:** `logo.svg` na raiz da pasta do projeto

### Convenções
- Código em PHP puro estruturado (controllers, models, views, routes)
- Sem builds, sem bundlers, sem Node.js no projeto
- Sem testes locais — desenvolvimento direto, validação em staging do cliente
- Senhas com `password_hash()` / `password_verify()`
- CSRF token em todos os formulários
- Prepared statements em todas as queries (PDO)
- Sessões PHP nativas
- Upload de imagens com validação de MIME e dimensões

### Estrutura de pastas sugerida
```
/
├── logo.svg
├── public/                  (document root)
│   ├── index.php
│   ├── .htaccess
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
│   └── uploads/             (imagens de produtos, blog)
├── app/
│   ├── controllers/
│   ├── models/
│   ├── views/
│   │   ├── site/            (frontend público)
│   │   ├── admin/           (painel)
│   │   └── cliente/         (área do cliente)
│   ├── core/                (Router, DB, Session, etc)
│   └── helpers/
├── config/
│   ├── database.php
│   └── app.php
└── database/
    └── migrations.sql
```

---

## 3. Informações da Empresa (dados do cliente)

| Campo | Valor |
|---|---|
| Nome | Inova Tanque |
| Razão social | Renato T. Sattin Peças e Implementos Rodoviários ME |
| CNPJ | 08.436.403/0001-90 |
| Endereço | Rodovia Professor Zeferino Vaz (SP 332) — KM 125, Santa Terezinha, Paulínia/SP |
| CEP | 13140-774 |
| Telefone | (19) 97406-0706 |
| WhatsApp principal | (19) 97406-0706 |
| WhatsApp Consignação | (19) 97416-2357 |
| E-mail geral | contato@inovatanque.com.br |
| E-mail Consignação | renato@inovatanque.com.br |
| Facebook | https://facebook.com/inovatanque |
| Instagram | https://instagram.com/inovatanque |

---

## 4. Identidade Visual

| Item | Valor |
|---|---|
| Cor base (do site atual) | `#201F1F` (preto/grafite) |
| Conceito | "Pantera Negra" — força, robustez, premium |
| Logo | `logo.svg` na raiz |

Paleta e tipografia finais devem ser definidas no Google Stitch.

---

## 5. Páginas do Site Público (Frontend)

### 5.1 Home

Seções na ordem:

1. **Header**
   - Logo + menu principal + WhatsApp / telefone visível
   - Menu de tipos de carreta com dropdown:
     - Aço
     - Aço Carbono
     - Inox
     - Térmica → submenu:
       - Asfáltica
       - Vegetal

2. **Hero em carrossel**
   - Múltiplas chamadas (slides)
   - Chamada de **pronta entrega deve estar no hero** (é o principal argumento de conversão)
   - CTAs direcionando para WhatsApp ou catálogo

3. **Seção de Pronta Entrega**
   - Logo abaixo do hero (reforço do argumento principal)
   - Destaque dos equipamentos disponíveis para entrega imediata

4. **Seção de Locação (foco principal)**
   - Ênfase nos serviços de locação
   - CTAs para cotação

5. **Seção de Qualidade dos Equipamentos**
   - Checklist próprio
   - Manutenção própria
   - Seguro
   - Outros diferenciais técnicos

6. **Seção de Clientes**
   - Grid/carrossel de logos de transportadoras importantes
   - Destaque visual (clientes de peso é argumento forte)

7. **Seção de Depoimentos**
   - Próxima da seção de clientes
   - Cards com depoimento + nome + empresa

8. **Seção de Prova Social e Científica**
   - Números (anos de mercado, frota, clientes atendidos)
   - Certificações, parcerias técnicas
   - Parceria com Paulitanque (manutenção especializada)

9. **CTA final**
   - Bloco de contato/cotação

10. **Footer**
    - Endereço completo
    - Contatos (telefone, WhatsApp, e-mail)
    - Links institucionais (Sobre, Blog, Política de Privacidade, Termos)
    - Redes sociais
    - CNPJ + copyright

---

### 5.2 Catálogo (página exclusiva)

Sai da home e vira página própria.

- Listagem de produtos (carretas-tanque)
- Filtros laterais:
  - Tipo de material (Aço, Aço Carbono, Inox, Térmica)
  - Subtipo Térmica (Asfáltica, Vegetal)
  - Configuração (Carreta simples, Bitrem, Bitrenzão, Rodotrem, Vanderleia 3ED)
  - Capacidade (faixas em litros)
  - Tipo de carregamento (Top / Bottom)
  - Modalidade (Locação / Venda / Consignação)
  - Ano
  - Fabricante
- Grid de cards de produto com imagem, título, código, capacidade, modalidade
- Paginação
- Ordenação (mais recentes, capacidade, ano)

### 5.3 Página de Produto Individual

- Galeria de imagens
- Título e código do produto
- Ficha técnica estruturada:
  - Material
  - Configuração
  - Capacidade
  - Ano
  - Fabricante
  - Tipo de carregamento
  - Modalidade
  - Características adicionais
- CTAs:
  - WhatsApp com mensagem pré-preenchida do produto
  - Formulário de cotação (gera lead no admin)
- Produtos relacionados

### 5.4 Sobre Nós

Página institucional — conteúdo a ser fornecido pelo cliente.

### 5.5 Blog (listagem)

- Grid de posts com imagem destacada, título, data, resumo
- Filtro por categoria
- Paginação
- Sidebar com posts recentes e categorias

### 5.6 Blog (post individual)

- Imagem destacada
- Título, autor, data
- Conteúdo
- Botões de compartilhamento
- Posts relacionados

### 5.7 Cadastro / Login de Cliente

- Página de cadastro completo (área do cliente)
- Página de login
- Recuperação de senha por e-mail

### 5.8 Contato

- Formulário de contato
- Dados completos da empresa
- Mapa do endereço em Paulínia

---

## 6. Área do Cliente (Logado)

Cliente cria conta, faz login e tem acesso a:

- **Dashboard** — visão geral
- **Meu perfil** — editar dados cadastrais, trocar senha
- **Minhas cotações** — histórico de cotações solicitadas
- **Meus favoritos** — produtos salvos do catálogo
- **Mensagens** — comunicação com o admin (opcional)
- **Logout**

### Campos do cadastro do cliente
- Tipo: Pessoa Física / Pessoa Jurídica
- Nome / Razão Social
- CPF / CNPJ
- Inscrição Estadual (se PJ)
- E-mail
- Telefone
- WhatsApp
- Endereço completo
- Senha (com confirmação)
- Aceite de termos e política de privacidade

---

## 7. Painel Administrativo

Login restrito ao(s) admin(s) da Inova Tanque. Desenvolvido também em PHP puro dentro do mesmo projeto.

### 7.1 Dashboard
- Resumo de cotações recentes
- Novos cadastros de clientes
- Produtos mais visualizados
- Estatísticas básicas

### 7.2 Gestão de Produtos (CRUD)
- Listar todos os produtos com filtros
- Criar / Editar / Excluir produto
- Campos:
  - Título
  - Código/SKU
  - Categoria (Aço, Aço Carbono, Inox, Térmica)
  - Subcategoria Térmica (Asfáltica, Vegetal — quando aplicável)
  - Configuração (Carreta, Bitrem, Bitrenzão, Rodotrem, Vanderleia 3ED)
  - Capacidade (L)
  - Ano
  - Fabricante
  - Tipo de carregamento (Top/Bottom)
  - Modalidade (Locação, Venda, Consignação) — pode ser múltipla
  - Status (Disponível, Pronta Entrega, Locado, Vendido)
  - Descrição rica
  - Galeria de imagens (upload múltiplo)
  - Imagem principal
  - Destaque na home (sim/não)
- Ordenação manual ou por data

### 7.3 Gestão de Categorias
- CRUD das categorias e subcategorias
- Permite expansão futura sem código

### 7.4 Gestão de Clientes
- Listar todos os clientes cadastrados
- Ver detalhes, histórico de cotações
- Ativar/desativar conta
- Exportar lista (CSV)

### 7.5 Gestão de Cotações (Leads)
- Listar todas as cotações recebidas (com ou sem login)
- Status (Nova, Em atendimento, Fechada, Perdida)
- Detalhes da cotação + dados do cliente + produto
- Notas internas do atendimento
- Exportar leads (CSV)

### 7.6 Gestão de Blog
- CRUD de posts
- Campos:
  - Título
  - Slug
  - Categoria
  - Imagem destacada
  - Resumo
  - Conteúdo (editor WYSIWYG simples — TinyMCE ou similar via CDN)
  - Autor
  - Data de publicação
  - Status (Rascunho, Publicado)
- CRUD de categorias do blog

### 7.7 Gestão de Clientes/Parceiros (Home)
- Upload de logos das transportadoras
- Ordenação
- Ativar/desativar

### 7.8 Gestão de Depoimentos
- CRUD de depoimentos
- Campos: Nome, empresa, cargo, foto (opcional), texto, ativo

### 7.9 Gestão de Banners do Hero
- CRUD dos slides do carrossel da home
- Campos: imagem, título, subtítulo, link/CTA, ordem, ativo

### 7.10 Gestão de Conteúdo Institucional
- Editar página "Sobre Nós"
- Editar textos da home (seção qualidade, prova social, números)

### 7.11 Configurações Gerais
- Dados de contato (telefone, WhatsApp, e-mail, endereço)
- Mensagens pré-preenchidas do WhatsApp
- Redes sociais
- Códigos de tracking (GTM, Meta Pixel, Google Ads)
- SEO básico (meta title/description por página)

### 7.12 Usuários Admin
- CRUD de usuários do painel
- Níveis de acesso (Admin, Editor)

---

## 8. Fluxos do Sistema

### Fluxo 1 — Cotação via WhatsApp (visitante anônimo)
```
Home/Catálogo → Produto → Botão WhatsApp → Conversa externa
```

### Fluxo 2 — Cotação via formulário (visitante anônimo)
```
Produto → Formulário de cotação → Lead salvo no admin → E-mail para admin + cliente
```

### Fluxo 3 — Cadastro e login do cliente
```
Site → Cadastrar → Preencher dados → Confirmação por e-mail → Login → Dashboard cliente
```

### Fluxo 4 — Cotação com cliente logado
```
Login → Catálogo → Produto → Solicitar cotação → Lead vinculado ao cliente → Histórico em "Minhas cotações"
```

### Fluxo 5 — Favoritar produto
```
Cliente logado → Produto → Favoritar → "Meus favoritos" no painel do cliente
```

### Fluxo 6 — Publicação de post no blog
```
Admin → Blog → Novo post → Preencher campos + editor → Publicar → Aparece em /blog
```

### Fluxo 7 — Cadastro de novo produto pelo admin
```
Admin → Produtos → Novo → Preencher ficha + upload de imagens → Salvar → Aparece no catálogo
```

### Fluxo 8 — Atendimento de lead
```
Lead chega → Admin recebe e-mail + notificação no painel → Abre cotação → Muda status → Adiciona notas
```

---

## 9. Banco de Dados — Tabelas Principais

- `admins` (id, nome, email, senha, role, ativo, created_at)
- `clientes` (id, tipo, nome_razao, cpf_cnpj, ie, email, senha, telefone, whatsapp, endereco, cidade, uf, cep, ativo, created_at)
- `categorias` (id, nome, slug, parent_id, ordem, ativo)
- `produtos` (id, codigo, titulo, slug, categoria_id, configuracao, capacidade, ano, fabricante, carregamento, modalidade, status, descricao, destaque, ordem, created_at)
- `produto_imagens` (id, produto_id, arquivo, ordem, principal)
- `cotacoes` (id, cliente_id_nullable, nome, email, telefone, produto_id, mensagem, status, notas_internas, created_at)
- `favoritos` (id, cliente_id, produto_id, created_at)
- `posts` (id, titulo, slug, categoria_id, imagem, resumo, conteudo, autor_id, status, publicado_em, created_at)
- `post_categorias` (id, nome, slug)
- `depoimentos` (id, nome, empresa, cargo, foto, texto, ordem, ativo)
- `clientes_logos` (id, nome, logo, ordem, ativo)
- `banners` (id, imagem, titulo, subtitulo, link, ordem, ativo)
- `configuracoes` (chave, valor) — key/value para configs gerais
- `paginas` (id, slug, titulo, conteudo) — para Sobre Nós e textos institucionais

---

## 10. Integrações e Tracking

- Google Tag Manager
- Google Ads (conversão)
- Meta Pixel
- Links de WhatsApp com mensagem pré-preenchida por produto
- Envio de e-mails transacionais (cadastro, recuperação de senha, cotação) — via PHPMailer ou SMTP nativo

---

## 11. SEO

- URLs amigáveis (`/catalogo`, `/produto/[slug]`, `/blog/[slug]`)
- Meta title e description configuráveis por página/produto/post
- Schema.org (Product, Article, LocalBusiness)
- Sitemap.xml gerado dinamicamente
- robots.txt
- Open Graph e Twitter Cards

---

## 12. Workflow de Desenvolvimento

### Por página/tela
1. **Google Stitch MCP** — gerar design da tela (obrigatório antes de qualquer código de frontend)
2. Implementar HTML/CSS conforme o Stitch
3. Implementar lógica PHP (controller + model + view)
4. Push no GitHub
5. Próxima tela

### Regras
- Sem builds, sem bundlers, sem Node.js
- Sem testes locais — código é desenvolvido e enviado direto pro repositório
- Toda página passa pelo Google Stitch antes de virar código
- Push no GitHub após cada mudança significativa (obrigatório)
- `logo.svg` fica na raiz da pasta do projeto

---

## 13. Categorias de Produtos (Menu Final)

```
Tipos de Carreta
├── Aço
├── Aço Carbono
├── Inox
└── Térmica
    ├── Asfáltica
    └── Vegetal
```

> Diferente do site atual (que tem 8 categorias misturando material e aplicação), o novo menu fica simplificado para essas 4 categorias principais com submenu apenas em Térmica.
