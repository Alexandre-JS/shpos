# Shops Marketplace - Design System Guide

## Table of Contents

1. [Color Palette](#color-palette)
2. [Slogan](#slogan)

---

## Color Palette

### Primary Colors (Orange + White)

| Name           | Value     | CSS Variable          | Usage                              |
| -------------- | --------- | --------------------- | ---------------------------------- |
| Brand Orange   | `#EA580C` | `var(--color-primary)`| Primary brand color, headers, CTAs |
| Accent Orange  | `#F97316` | `var(--color-accent)` | Highlighting, secondary actions    |
| White          | `#FFFFFF` | `var(--color-white)`  | Backgrounds, contrast              |

---

## Slogan

**DESCUBRA · CONECTE · COMPRE**

Esta frase define o ecossistema da plataforma:
1. **Descubra**: O utilizador navega e encontra produtos/serviços.
2. **Conecte**: O utilizador entra em contacto direto com o vendedor.
3. **Compre**: A finalização do negócio fora da plataforma.

---

## Spacing Scale

All spacing follows a consistent scale based on 0.5rem increments:

```css
--space-xs:    0.5rem   /* 8px  - Small gaps, padding */
--space-sm:    0.75rem  /* 12px - Compact spacing */
--space-md:    1rem     /* 16px - Standard spacing */
--space-lg:    1.5rem   /* 24px - Section separation */
--space-xl:    2rem     /* 32px - Large gaps */
--space-2xl:   3rem     /* 48px - Very large gaps */
--space-3xl:   6rem     /* 96px - Massive gaps */
```

---

## Typography

### Font Families

-   **Sans-serif**: `var(--font-sans)` → Inter / Instrument Sans (body text, UI elements)

### Font Sizes (Reference)

-   H1: `2rem` (32px)
-   H2: `1.5rem` (24px)
-   H3: `1.125rem` (18px)
-   Body: `0.875rem` (14px)
-   Small: `0.75rem` (12px)
-   Tiny: `0.625rem` (10px)

### Extended Colors

| Variant    | Color     | CSS Variable                                |
| ---------- | --------- | ------------------------------------------- |
| Navy Dark  | `#0A1B39` | `var(--navy-dark)`                          |
| Navy Light | `#2A3B59` | `var(--navy-light)`                         |
| Gold Dark  | `#A67C3B` | `var(--gold-dark)`                          |
| Gold Light | `#E8D5BA` | `var(--gold-light)`                         |
| Gray 50    | `#F9FAFB` | `var(--gray-50)`                            |
| Gray 100   | `#F3F4F6` | `var(--gray-100)`                           |
| ...        | ...       | `var(--gray-200)` through `var(--gray-900)` |

### Usage Guidelines

-   **Navy Blue**: Headlines, navigation, primary content
-   **Gold**: Buttons, links, interactive elements, decorative accents
-   **Grays**: Text hierarchy, borders, backgrounds for secondary content
-   **Dark variants**: Hover states for interactive elements
-   **Light variants**: Disabled states, low-contrast backgrounds

---

## Spacing Scale

All spacing follows a consistent scale based on 0.5rem increments:

```css
--space-xs:    0.5rem   /* 8px  - Small gaps, padding */
--space-sm:    0.75rem  /* 12px - Compact spacing */
--space-md:    1rem     /* 16px - Standard spacing */
--space-lg:    1.5rem   /* 24px - Section separation */
--space-xl:    2rem     /* 32px - Large gaps */
--space-2xl:   3rem     /* 48px - Very large gaps */
--space-3xl:   6rem     /* 96px - Massive gaps */
```

### Usage

```blade
<!-- Padding -->
<div style="padding: var(--space-md);">Content</div>

<!-- Margin -->
<div style="margin: var(--space-lg);">Spaced content</div>

<!-- Gaps in Flexbox -->
<div style="display: flex; gap: var(--space-md);">Items</div>

<!-- Grid Gaps -->
<div style="display: grid; gap: var(--space-md);">Grid items</div>
```

---

## Typography

### Font Families

-   **Serif**: `var(--font-serif)` → Playfair Display (headlines, elegant text)
-   **Sans-serif**: `var(--font-sans)` → Inter (body text, UI elements)

### Font Sizes (Reference)

-   H1: `2rem` (32px)
-   H2: `1.5rem` (24px)
-   H3: `1.125rem` (18px)
-   Body: `0.875rem` (14px)
-   Small: `0.75rem` (12px)
-   Tiny: `0.625rem` (10px)

### Example

```blade
<h1 style="font-family: var(--font-serif); font-size: 1.875rem; color: var(--navy-blue);">
    Heading
</h1>
<p style="font-family: var(--font-sans); font-size: 0.875rem; color: var(--gray-700);">
    Body text
</p>
```

---

## Components

### Buttons

#### Primary Button (CTA)

```blade
<button style="
    background: var(--gold);
    color: var(--navy-blue);
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: background var(--transition-base);
"
onmouseover="this.style.background='var(--gold-dark)'"
onmouseout="this.style.background='var(--gold)'">
    Click Me
</button>
```

#### Secondary Button (Cancel)

```blade
<button style="
    background: var(--white);
    color: var(--navy-blue);
    border: 1px solid var(--gray-200);
    padding: 0.5rem 1rem;
    border-radius: 4px;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: background var(--transition-base);
"
onmouseover="this.style.background='var(--gray-50)'"
onmouseout="this.style.background='var(--white)'">
    Cancel
</button>
```

### Cards

```blade
<div style="
    background: var(--white);
    border: 1px solid var(--gray-200);
    border-radius: var(--radius-md);
    padding: var(--space-lg);
    box-shadow: var(--shadow-sm);
    transition: box-shadow var(--transition-base);
"
onmouseover="this.style.boxShadow='var(--shadow-md)'"
onmouseout="this.style.boxShadow='var(--shadow-sm)'">
    Card content
</div>
```

### Forms

```blade
<div style="display: flex; flex-direction: column; gap: 0.25rem;">
    <label style="font-size: 0.75rem; font-weight: 600; color: var(--gray-700);">
        Label
    </label>
    <input
        style="
            width: 100%;
            border: 1px solid var(--gray-200);
            border-radius: 4px;
            padding: var(--space-xs) var(--space-sm);
            font-size: 0.875rem;
        "
        placeholder="Placeholder text"
    />
</div>
```

### Badges

```blade
<!-- Navy Badge -->
<span style="
    background: var(--navy-blue);
    color: var(--white);
    font-size: 0.625rem;
    font-weight: 600;
    padding: 0.25rem 0.5rem;
    border-radius: 3px;
    text-transform: uppercase;
">
    Badge
</span>

<!-- Gold Badge -->
<span style="
    background: var(--gold);
    color: var(--navy-blue);
    font-size: 0.625rem;
    font-weight: 600;
    padding: 0.25rem 0.5rem;
    border-radius: 3px;
">
    Special
</span>
```

---

## Responsive Design

### Breakpoints

```
Mobile:        < 640px
Tablet:        640px - 1023px
Desktop:       1024px - 1280px
Large:         1280px +
```

### Media Query Pattern

Place all responsive styles in `<style>` tag, not inline attributes:

```blade
<style>
    .responsive-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: var(--space-md);
    }

    @media (min-width: 768px) {
        .responsive-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 1024px) {
        .responsive-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
</style>

<div class="responsive-grid">
    <!-- Items -->
</div>
```

### Common Patterns

#### Hide/Show Elements

```blade
<style>
    .desktop-only { display: none; }
    @media (min-width: 1024px) {
        .desktop-only { display: block; }
    }

    .mobile-only { display: block; }
    @media (min-width: 1024px) {
        .mobile-only { display: none; }
    }
</style>
```

#### Responsive Grid

```blade
<style>
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: var(--space-md);
    }

    @media (min-width: 1024px) {
        .product-grid {
            grid-template-columns: repeat(5, 1fr);
        }
    }

    @media (min-width: 1536px) {
        .product-grid {
            grid-template-columns: repeat(6, 1fr);
        }
    }
</style>
```

#### Responsive Flexbox

```blade
<style>
    .navbar-top {
        display: flex;
        gap: var(--space-md);
        flex-wrap: wrap;
    }

    @media (min-width: 993px) {
        .navbar-region { display: flex; }
        .navbar-account { display: flex; }
    }
</style>
```

---

## Examples

### Complete Example: Product Card

```blade
<div style="
    display: flex;
    flex-direction: column;
    border-radius: var(--radius-md);
    border: 1px solid var(--gray-200);
    background: var(--white);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    transition: box-shadow var(--transition-base);
"
onmouseover="this.style.boxShadow='var(--shadow-md)'"
onmouseout="this.style.boxShadow='var(--shadow-sm)'">
    <!-- Image -->
    <a href="#" style="
        aspect-ratio: 4/3;
        display: block;
        overflow: hidden;
        background: var(--gray-100);
        text-decoration: none;
    ">
        <img src="#" alt="Product" style="
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform var(--transition-base);
        " />
    </a>

    <!-- Content -->
    <div style="padding: var(--space-md); display: flex; flex-direction: column; flex: 1;">
        <h3 style="
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--navy-blue);
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        ">
            Product Name
        </h3>

        <p style="
            font-size: 0.75rem;
            color: var(--gray-600);
            margin: var(--space-sm) 0 0 0;
        ">
            Product description...
        </p>

        <!-- Footer -->
        <div style="
            margin-top: var(--space-md);
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        ">
            <div style="font-weight: 700; color: var(--navy-blue);">
                1,234.56 MT
            </div>
            <a href="#" style="
                background: var(--gold);
                color: var(--navy-blue);
                border: none;
                padding: 0.375rem 0.75rem;
                border-radius: 4px;
                font-size: 0.75rem;
                font-weight: 600;
                text-decoration: none;
                cursor: pointer;
                transition: background var(--transition-base);
            "
            onmouseover="this.style.background='var(--gold-dark)'"
            onmouseout="this.style.background='var(--gold)'">
                Ver
            </a>
        </div>
    </div>
</div>
```

### Complete Example: Form Section

```blade
<div style="max-width: 50rem; background: var(--white); border: 1px solid var(--gray-200); border-radius: var(--radius-md); padding: var(--space-lg); display: flex; flex-direction: column; gap: var(--space-lg);">
    <h2 style="margin: 0; color: var(--navy-blue); font-size: 1.125rem; font-weight: 600;">
        Form Title
    </h2>

    <form style="display: flex; flex-direction: column; gap: var(--space-lg);">
        <!-- Input Grid -->
        <div style="display: grid; grid-template-columns: 1fr; gap: var(--space-md); @media (min-width: 768px) { grid-template-columns: 1fr 1fr; }">
            <!-- Field 1 -->
            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                <label style="font-size: 0.75rem; font-weight: 600; color: var(--gray-700);">
                    Field Label
                </label>
                <input style="
                    width: 100%;
                    border: 1px solid var(--gray-200);
                    border-radius: 4px;
                    padding: var(--space-xs) var(--space-sm);
                    font-size: 0.875rem;
                " />
            </div>

            <!-- Field 2 -->
            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                <label style="font-size: 0.75rem; font-weight: 600; color: var(--gray-700);">
                    Another Field
                </label>
                <select style="
                    width: 100%;
                    border: 1px solid var(--gray-200);
                    border-radius: 4px;
                    padding: var(--space-xs) var(--space-sm);
                    font-size: 0.875rem;
                ">
                    <option>Option 1</option>
                    <option>Option 2</option>
                </select>
            </div>
        </div>

        <!-- Textarea -->
        <div style="display: flex; flex-direction: column; gap: 0.25rem;">
            <label style="font-size: 0.75rem; font-weight: 600; color: var(--gray-700);">
                Description
            </label>
            <textarea style="
                width: 100%;
                border: 1px solid var(--gray-200);
                border-radius: 4px;
                padding: var(--space-xs) var(--space-sm);
                font-size: 0.875rem;
                font-family: var(--font-sans);
                min-height: 120px;
            "></textarea>
        </div>

        <!-- Buttons -->
        <div style="
            display: flex;
            justify-content: flex-end;
            gap: var(--space-md);
            padding-top: var(--space-lg);
            border-top: 1px solid var(--gray-200);
        ">
            <button style="
                background: var(--white);
                color: var(--navy-blue);
                border: 1px solid var(--gray-200);
                padding: 0.5rem 1rem;
                border-radius: 4px;
                font-size: 0.875rem;
                font-weight: 600;
                cursor: pointer;
                transition: background var(--transition-base);
            "
            onmouseover="this.style.background='var(--gray-50)'"
            onmouseout="this.style.background='var(--white)'">
                Cancelar
            </button>
            <button type="submit" style="
                background: var(--gold);
                color: var(--navy-blue);
                border: none;
                padding: 0.5rem 1.5rem;
                border-radius: 4px;
                font-size: 0.875rem;
                font-weight: 600;
                cursor: pointer;
                transition: background var(--transition-base);
            "
            onmouseover="this.style.background='var(--gold-dark)'"
            onmouseout="this.style.background='var(--gold)'">
                Salvar
            </button>
        </div>
    </form>
</div>
```

---

## Best Practices

1. **Always use CSS variables** for colors, spacing, and transitions
2. **Place media queries in `<style>` tags**, not inline style attributes
3. **Use flexbox for 1D layouts**, CSS Grid for 2D layouts
4. **Include hover effects** on interactive elements
5. **Maintain consistent spacing** throughout the page
6. **Use semantic HTML** elements
7. **Ensure sufficient color contrast** for accessibility
8. **Test on mobile devices** first (mobile-first approach)
9. **Use `transition: property var(--transition-base)`** for smooth interactions
10. **Document complex component logic** with comments

---

## Resources

-   **CSS Variables** defined in `resources/css/app.css`
-   **Examples** in:
    -   `resources/views/layouts/app.blade.php` (navbar)
    -   `resources/views/home/index.blade.php` (sections)
    -   `resources/views/dashboard/` (admin layouts)
    -   `resources/views/components/` (reusable components)

---

**Last Updated:** Design System Migration Complete
**Status:** Active - All templates using design system
