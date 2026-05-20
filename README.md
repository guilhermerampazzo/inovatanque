# Inova Tanque

Site institucional da Inova Tanque — locação e venda de carretas-tanque.

## Stack
- PHP puro (MVC próprio)
- MySQL
- HTML/CSS/JS vanilla
- Design: Google Stitch (conceito "Pantera Negra")

## Estrutura
```
public/          → Document root (Apache)
app/             → Controllers, Models, Views, Core, Helpers
config/          → Configurações (app, database)
database/        → SQL de migração
logo.svg         → Logo da empresa
```

## Setup
1. Apontar o document root do Apache para `public/`
2. Importar `database/migrations.sql` no MySQL
3. Ajustar `config/database.php` com credenciais do banco
4. Acessar `/admin/login` com: `admin@inovatanque.com.br` / `admin123`
