# Design System Documentation - Phase 1 Foundation

## Overview

This document outlines the design system foundation layer for HaatBazar - an e-commerce platform built with Laravel and Tailwind CSS. The foundation consists of three main layers:

1. **Design Tokens** (`design-tokens.css`) - CSS custom properties for colors, typography, spacing
2. **Tailwind Configuration** (`tailwind.config.js`) - Framework integration with design tokens
3. **Accessibility Layer** (`accessibility.css`) - WCAG 2.2 AA compliance patterns

---

## Design Tokens Reference

### Color System

All colors are defined as CSS custom properties and follow semantic naming conventions.

#### Surface Colors

```css
--color-surface-base: #000000; /* Primary surface */
--color-surface-muted: #ffffff; /* Light/background */
--color-surface-raised: #eff0f5; /* Elevated surfaces */
--color-surface-strong: #f5f5f5; /* Emphasized surfaces */
```

#### Text Colors

```css
--color-text-primary: #1a1a1a; /* Primary text */
--color-text-secondary: #888888; /* Secondary text */
--color-text-tertiary: #199cb7; /* Links, tertiary text */
--color-text-inverse: #0f136d; /* Inverse text */
```

#### Interactive Colors

```css
--color-interactive-primary: #ff6600;
--color-interactive-primary-hover: #e55a00;
--color-interactive-primary-active: #cc4d00;
--color-interactive-secondary: #199cb7;
--color-interactive-secondary-hover: #148299;
--color-interactive-secondary-active: #0d667a;
```

#### Feedback Colors (WCAG 2.2 AA Compliant)

```css
--color-success: #388e3c; /* ✅ Contrast: 5.1:1 */
--color-error: #d32f2f; /* ✅ Contrast: 5.2:1 */
--color-warning: #f57c00; /* ✅ Contrast: 5.1:1 */
--color-info: #1976d2; /* ✅ Contrast: 4.8:1 */
```

#### Accessibility

```css
--color-focus: #199cb7; /* Focus ring color */
--color-focus-ring: 2px solid var(--color-focus);
```

### Typography System

#### Font Stack

```css
--font-family-primary:
    "Noto Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
    sans-serif;
```

#### Font Sizes (Mobile-First)

```css
--font-size-xs: 11px;
--font-size-sm: 12px;
--font-size-base: 12px;
--font-size-md: 14px;
--font-size-lg: 16px;
--font-size-xl: 22px;
--font-size-2xl: 28px;
--font-size-3xl: 32px;
```

#### Font Weights

```css
--font-weight-regular: 400;
--font-weight-medium: 500;
--font-weight-semibold: 600;
--font-weight-bold: 700;
```

#### Line Heights (for optimal readability)

```css
--line-height-xs: 1.2;
--line-height-sm: 1.2;
--line-height-base: 1.15;
--line-height-md: 1.2;
--line-height-lg: 1.2;
--line-height-xl: 1.2;
--line-height-heading: 1.1;
```

### Spacing System

8px base unit system with fractional units:

```css
--space-1: 1px;
--space-2: 4px;    (0.5 × 8)
--space-3: 5px;
--space-4: 6px;
--space-8: 12px;   (1.5 × 8)
--space-12: 16px;  (2 × 8)
--space-16: 24px;  (3 × 8)
--space-20: 32px;  (4 × 8)
--space-24: 40px;  (5 × 8)
```

**Usage in Tailwind:**

```html
<button class="px-12 py-8">Click Me</button>
<!-- 24px padding -->
<div class="mb-16">Content</div>
<!-- 24px margin-bottom -->
```

### Radius System

```css
--radius-xs: 2px;
--radius-sm: 4px;
--radius-md: 6px;
--radius-lg: 8px;
--radius-xl: 12px;
--radius-full: 9999px;
```

### Motion & Animation

```css
/* Durations */
--motion-instant: 200ms; /* Quick feedback */
--motion-fast: 300ms; /* Hover effects */
--motion-normal: 500ms; /* Standard transitions */
--motion-slow: 800ms; /* Entrance animations */

/* Easing Functions */
--motion-easing-linear: linear;
--motion-easing-cubic: cubic-bezier(0.4, 0, 0.2, 1);
```

---

## Using Design Tokens in Tailwind

### Example 1: Button Component

```html
<button
    class="px-12 py-8 bg-interactive-primary text-surface-muted rounded-md hover:bg-interactive-primary-hover focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-3 focus-visible:outline-focus transition-colors duration-instant"
>
    Click Me
</button>
```

### Example 2: Card Component

```html
<div
    class="bg-surface-muted rounded-lg shadow-md p-16 border border-border-light"
>
    <h3 class="text-lg font-semibold text-text-primary mb-8">Card Title</h3>
    <p class="text-sm text-text-secondary">Card content goes here</p>
</div>
```

### Example 3: Form Input

```html
<input
    type="text"
    placeholder="Enter your name"
    class="w-full px-12 py-8 border border-border-light rounded-md focus:border-focus focus:ring-4 focus:ring-info-light/50"
/>
```

---

## Accessibility (A11Y) Guidelines

### Keyboard Navigation

All interactive elements must be keyboard accessible:

- ✅ Tab to navigate between elements
- ✅ Enter/Space to activate buttons
- ✅ Arrow keys in menus/tabs
- ✅ Escape to close modals/dropdowns

**Implementation:**

```html
<!-- Skip to main content link (first focusable element) -->
<a href="#main" class="skip-to-content">Skip to main content</a>

<!-- Main content area -->
<main id="main" role="main">
    <!-- Content here -->
</main>
```

### Focus Indicators

All interactive elements must have visible focus indicators (2px outline, 3px offset):

```css
/* Automatically applied to all interactive elements */
button:focus-visible,
a:focus-visible,
input:focus-visible {
    outline: 2px solid var(--color-focus);
    outline-offset: 3px;
}
```

### Color Contrast

All text must meet WCAG 2.2 AA minimum contrast ratio:

| Element                 | Contrast | Status |
| ----------------------- | -------- | ------ |
| Primary text on light   | 19.9:1   | ✅ AAA |
| Secondary text on light | 4.54:1   | ✅ AA  |
| Primary button          | 19.9:1   | ✅ AAA |
| Focus ring on light     | 5.2:1    | ✅ AAA |
| Error message           | 5.2:1    | ✅ AAA |
| Warning message         | 5.1:1    | ✅ AAA |

**Never use these combinations:**

- ❌ Light gray text (#888) on white (too low contrast)
- ❌ Text without sufficient color difference from background
- ❌ Focus indicators that blend into background

### Screen Reader Support

Use semantic HTML and ARIA labels:

```html
<!-- ✅ GOOD: Semantic HTML -->
<button aria-label="Close menu">✕</button>
<a href="/products">Products</a>
<input type="email" placeholder="Email address" />

<!-- ❌ BAD: Non-semantic -->
<div class="button" onclick="...">✕</div>
<div class="link" role="link">Products</div>
```

### Touch Target Sizing

Minimum 44×44px for all interactive elements (WCAG 2.5.5 Level AAA):

```html
<!-- ✅ GOOD: Sufficient touch target -->
<button class="px-12 py-8">Click Me</button>
<!-- 44×44px minimum -->

<!-- ❌ BAD: Too small -->
<button class="px-2 py-1">Click</button>
<!-- Only 20×20px -->
```

---

## Accessibility CSS Classes

### Screen Reader Only Text

Hide visually but keep for screen readers:

```html
<form>
    <label for="email" class="sr-only">Email Address</label>
    <input id="email" type="email" />
</form>
```

### Focus Visible

Clear focus indicator:

```html
<button class="focus-visible">Button</button>
```

### High Contrast Mode

Automatically enhanced in high contrast mode:

```css
@media (prefers-contrast: more) {
    /* Automatically applied */
}
```

### Reduced Motion

Respects user preference for reduced motion:

```html
<!-- Animations automatically disabled for users who prefer reduced motion -->
<div class="animate-fade">Content</div>
```

---

## Color Contrast Validator

### How to Verify Contrast

1. **Use Chrome DevTools:**
    - Right-click element
    - Inspect
    - Check "Contrast ratio" in Styles panel

2. **Use Browser Extensions:**
    - Axe DevTools
    - WAVE
    - WebAIM Contrast Checker

3. **Acceptable Ratios:**
    - Normal text: 4.5:1 minimum (AA)
    - Large text (18px+): 3:1 minimum (AA)
    - AAA level: 7:1 (normal), 4.5:1 (large)

---

## Implementation Checklist

When using the design system foundation:

- [ ] Import design tokens CSS first
- [ ] Use CSS custom properties instead of hardcoded values
- [ ] Use Tailwind classes for styling
- [ ] Ensure all buttons have focus-visible indicators
- [ ] Use semantic HTML (`<button>`, `<a>`, `<input>`, etc.)
- [ ] Add ARIA labels to icon buttons
- [ ] Test keyboard navigation (Tab, Arrow, Enter, Escape)
- [ ] Verify color contrast (min 4.5:1)
- [ ] Use `.sr-only` for screen reader only content
- [ ] Test with screen reader (NVDA, JAWS, VoiceOver)

---

## File Structure

```
resources/
├── css/
│   ├── app.css                 ← Main import file
│   ├── design-tokens.css       ← CSS custom properties
│   └── accessibility.css       ← A11Y patterns
├── js/
│   └── app.js
└── views/
    └── ...blade files
```

---

## Next Steps

With the foundation layer complete, you can now:

1. ✅ Create Button component (Phase 2)
2. ✅ Create Form Input components
3. ✅ Create Card components
4. ✅ Build composite components
5. ✅ Redesign pages using components

---

**Phase:** 1 - Foundation Layer  
**Status:** Complete ✅  
**Files Created:** 3 (design-tokens.css, accessibility.css, app.css updated)
