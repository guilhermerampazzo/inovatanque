# Inovatanque - Instruções para Claude Code

## Google Stitch MCP (Geração de UI/Layout)

O MCP do Google Stitch está configurado globalmente (`-s user`) e disponível em todas as sessões.
Endpoint: `https://stitch.googleapis.com/mcp`

### Quando usar o Stitch

- Criação de layouts, telas e interfaces web
- Prototipagem rápida de UI
- Geração de variantes de design
- Aplicação de design systems consistentes

### Tools disponíveis via MCP

#### Projetos
- `create_project` — Cria um novo projeto (param: `title`)
- `get_project` — Detalhes de um projeto (param: `name`)
- `list_projects` — Lista projetos ativos (param: `filter` para owned/shared)

#### Telas
- `list_screens` — Lista telas de um projeto (param: `projectId`)
- `get_screen` — Detalhes de uma tela (param: `name`)

#### Geração AI
- `generate_screen_from_text` — Gera tela a partir de prompt de texto
  - Params: `projectId`, `prompt`, `modelId` (`GEMINI_3_FLASH` ou `GEMINI_3_1_PRO`)
- `edit_screens` — Edita telas existentes com prompt
  - Params: `projectId`, `selectedScreenIds`, `prompt`
- `generate_variants` — Gera variações de telas existentes
  - Params: `projectId`, `selectedScreenIds`, `prompt`, `variantOptions` (count, creative range, aspects)

#### Design Systems
- `create_design_system` — Cria design system com tokens
- `update_design_system` — Atualiza design system existente
- `list_design_systems` — Lista design systems do projeto
- `apply_design_system` — Aplica design system a telas selecionadas

### Fluxo padrão de uso

1. **Listar projetos existentes** com `list_projects` para ver se já existe um projeto relevante
2. **Criar projeto** com `create_project` se necessário
3. **Gerar telas** com `generate_screen_from_text` usando prompts descritivos em inglês
4. **Iterar** com `edit_screens` para refinar
5. **Explorar alternativas** com `generate_variants`
6. **Aplicar consistência** com design systems

### Boas práticas

- Prompts para geração devem ser em **inglês** e descritivos (ex: "Modern SaaS landing page with hero section, features grid, pricing cards, and footer")
- Usar `GEMINI_3_1_PRO` para resultados de maior qualidade
- Usar `GEMINI_3_FLASH` para iterações rápidas
- Sempre listar projetos antes de criar um novo para evitar duplicatas
- Ao gerar variantes, usar `count: 3` como padrão para ter opções suficientes

### Exemplo de uso

Quando o usuário pedir para criar um layout ou interface:

```
1. list_projects → verificar projetos existentes
2. create_project(title: "Nome do Projeto") → criar se necessário
3. generate_screen_from_text(projectId: "...", prompt: "descrição detalhada", modelId: "GEMINI_3_1_PRO")
4. list_screens(projectId: "...") → ver resultado
```
