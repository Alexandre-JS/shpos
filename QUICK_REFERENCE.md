# Quick Reference - Design System CSS Variables

## Color Variables

### Primary

```css
--navy-blue: #1A2B49          /* Main color for text & backgrounds */
--gold: #C8A559               /* Accent color for CTAs & highlights */
--white: #FFFFFF              /* Primary background */
```

### Navy Variants

```css
--navy-dark: #0A1B39          /* Darker navy for hover states */
--navy-light: #2A3B59         /* Lighter navy for hover backgrounds */
```

### Gold Variants

```css
--gold-dark: #A67C3B          /* Darker gold for hover states */
--gold-light: #E8D5BA         /* Lighter gold for subtle accents */
```

### Grays

```css
--gray-50: #F9FAFB            /* Lightest gray */
--gray-100: #F3F4F6
--gray-200: #E5E7EB
--gray-300: #D1D5DB
--gray-400: #9CA3AF
--gray-500: #6B7280
--gray-600: #4B5563
--gray-700: #374151
--gray-800: #1F2937
--gray-900: #111827           /* Darkest gray */
```

### Neutral

```css
--neutral-light: #f5f3f0; /* Off-white */
```

---

## Spacing Variables

```css
--space-xs: 0.5rem    /* 8px */
--space-sm: 0.75rem   /* 12px */
--space-md: 1rem      /* 16px */
--space-lg: 1.5rem    /* 24px */
--space-xl: 2rem      /* 32px */
--space-2xl: 3rem     /* 48px */
--space-3xl: 6rem     /* 96px */
```

---

## Border Radius Variables

```css
--radius-sm: 4px      /* Small radius */
--radius-md: 8px      /* Medium radius */
--radius-lg: 12px     /* Large radius */
--radius-xl: 16px     /* Extra large radius */
```

---

## Shadow Variables

```css
--shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05)
--shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1)
--shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1)
--shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1)
```

---

## Transition Variables

```css
--transition-fast: 150ms      /* Quick transitions */
--transition-base: 250ms      /* Standard transitions */
--transition-slow: 350ms      /* Slower transitions */
```

---

## Typography Variables

```css
--font-serif: Playfair Display    /* Headlines, elegant text */
--font-sans: Inter                /* Body, UI elements */
```

---

## Common Usage Patterns

### Button (Gold - Primary CTA)

```blade
<button style="
    background: var(--gold);
    color: var(--navy-blue);
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    cursor: pointer;
    transition: background var(--transition-base);
"
onmouseover="this.style.background='var(--gold-dark)'"
onmouseout="this.style.background='var(--gold)'">
    Action
</button>
```

### Button (White - Secondary)

```blade
<button style="
    background: var(--white);
    color: var(--navy-blue);
    border: 1px solid var(--gray-200);
    padding: 0.5rem 1rem;
    border-radius: 4px;
    cursor: pointer;
    transition: background var(--transition-base);
"
onmouseover="this.style.background='var(--gray-50)'"
onmouseout="this.style.background='var(--white)'">
    Cancel
</button>
```

### Card

```blade
<div style="
    background: var(--white);
    border: 1px solid var(--gray-200);
    border-radius: var(--radius-md);
    padding: var(--space-lg);
    box-shadow: var(--shadow-sm);
    transition: box-shadow var(--transition-base);
">
    Content
</div>
```

### Form Input

```blade
<input style="
    width: 100%;
    border: 1px solid var(--gray-200);
    border-radius: 4px;
    padding: var(--space-xs) var(--space-sm);
    font-size: 0.875rem;
    font-family: var(--font-sans);
" />
```

### Badge (Navy)

```blade
<span style="
    background: var(--navy-blue);
    color: var(--white);
    padding: 0.25rem 0.5rem;
    border-radius: 3px;
    font-size: 0.625rem;
    font-weight: 600;
    text-transform: uppercase;
">
    Badge
</span>
```

### Badge (Gold)

```blade
<span style="
    background: var(--gold);
    color: var(--navy-blue);
    padding: 0.25rem 0.5rem;
    border-radius: 3px;
    font-size: 0.625rem;
    font-weight: 600;
">
    Special
</span>
```

### Responsive Grid

```blade
<style>
    .grid { display: grid; grid-template-columns: 1fr; gap: var(--space-md); }
    @media (min-width: 640px) { .grid { grid-template-columns: repeat(2, 1fr); } }
    @media (min-width: 1024px) { .grid { grid-template-columns: repeat(3, 1fr); } }
</style>
<div class="grid"><!-- items --></div>
```

---

## Responsive Breakpoints

```css
/* Mobile (default) */
/* < 640px */

/* Tablet */
@media (min-width: 640px) {
}

/* Small Desktop */
@media (min-width: 768px) {
}

/* Desktop */
@media (min-width: 1024px) {
}

/* Large Desktop */
@media (min-width: 1280px) {
}

/* Extra Large */
@media (min-width: 1536px) {
}
```

---

## Utility Classes

These are defined in `app.css` and available throughout:

-   `.container` - Max-width container with padding
-   `.section` - Wrapper for content sections with padding
-   `.section-title` - Styled heading for sections
-   `.nav-amz` - Amazon-style navbar wrapper
-   `.nav-amz-top` - Top navbar bar
-   `.nav-amz-sub` - Sub navbar bar
-   `.product-grid` - Responsive product grid
-   `.card` - Card component styling

---

## Migration Notes

✅ All templates migrated from Tailwind utilities to design system
✅ All colors use CSS variables
✅ All spacing uses design scale
✅ All transitions use base timing
✅ Responsive design via media queries in `<style>` tags
✅ Mobile-first approach implemented
✅ Hover effects on all interactive elements
✅ Alpine.js for interactivity (navbars, modals, toggles)

---

**See DESIGN_SYSTEM.md for detailed documentation and examples**
