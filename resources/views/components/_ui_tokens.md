# UI Tokens (Design System Base)

## Spacing Scale

2, 4, 6, 8, 12, 16, 24, 32 (multiplicadores base de 4)

## Radius

-   `rounded-sm` → 4px
-   `rounded-md` → 8px
-   `rounded-lg` → 12px

## Shadows

-   `shadow-sm` (cards)
-   `shadow-md` (hover)
-   `shadow-lg` (destaque)

## Typography

| Papel | Classes                                         |
| ----- | ----------------------------------------------- |
| h1    | `text-3xl md:text-4xl font-bold`                |
| h2    | `text-xl font-semibold`                         |
| h3    | `text-sm uppercase tracking-wide text-gray-500` |
| body  | `text-sm md:text-base leading-relaxed`          |
| meta  | `text-xs text-gray-500`                         |

## Paleta / Primitivas de Cor

Migrado de DaisyUI para classes próprias. Conceitos → cores base:

| Conceito    | Cor / Classe Base      | Uso principal                 |
| ----------- | ---------------------- | ----------------------------- |
| primary     | #2563eb (blue-600)     | Ações principais / CTA        |
| success     | #059669 (emerald-600)  | Estados positivos             |
| warning     | #d97706 (amber-600)    | Atenção leve                  |
| danger      | #dc2626 (red-600)      | Erros / destrutivo            |
| surface     | #ffffff                | Fundo cartão / painéis        |
| surface-alt | #f3f4f6 (gray-100)     | Background neutro alternativo |
| border      | #e5e7eb (gray-200)     | Bordas padrão                 |
| text        | #1f2937 (gray-800)     | Texto principal               |
| text-subtle | #6b7280 (gray-500/600) | Texto secundário / meta       |

## Componentes Internos Planeados

-   `<x-app-container>`: Wrapper de largura padrão.
-   `<x-card>`: Variantes `product`, `entity`, `stat` (futuro) – hoje usamos utilidade `.card`.
-   `<x-empty>`: Estado vazio padrão com ícone + mensagem.
-   `<x-skeleton>`: Placeholder de carregamento (grid + linha).

## Estados

| Estado   | Elementos                                    |
| -------- | -------------------------------------------- |
| Empty    | Ícone + mensagem curta + ação opcional       |
| Loading  | Skeletons visuais (evitar flash)             |
| Error    | Mensagem com cor `error` + retry opcional    |
| Disabled | Botões usam `.btn-disabled` (classe própria) |

## Regras Rápidas

1. Se repetir bloco de classes >3x → vira componente.
2. Evitar misturar muitas cores utilitárias; preferir tokens.
3. Todas imagens precisam de `alt` descritivo.
4. Foco: garantir visibilidade com outline custom se necessário.
5. Cards: manter altura visual consistente (imagem fixa + bloco conteúdo).

---

Remoção DaisyUI: concluída (plugin retirado e classes substituídas em `resources/css/app.css`).

Última revisão: {{ date('Y-m-d') }}
