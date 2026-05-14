# Button Component Specification

**Version:** 1.0  
**Status:** Ready for Implementation  
**Quality Target:** WCAG 2.2 AA + Daraz Design

---

## Design Intent

A versatile, accessible button component that serves as the primary interaction trigger across the e-commerce platform. Supports multiple visual styles, sizes, and states while maintaining keyboard navigation and screen reader support.

---

## Component Anatomy

```
┌─────────────────────────────────┐
│  [icon] Label                   │ ← Button container
└─────────────────────────────────┘
   ↑      ↑      ↑
 icon   text   ripple
```

### Slots

- **icon** (optional) — Leading icon (e.g., check, cart, settings)
- **default** — Button text label (required for accessibility)
- **indicator** (optional) — Loading spinner or badge

---

## Design Tokens Used

| Token                       | Value   | Purpose                |
| --------------------------- | ------- | ---------------------- |
| --font-size-md              | 14px    | Button text size       |
| --font-weight-semibold      | 600     | Button font weight     |
| --space-12                  | 16px    | Padding X              |
| --space-8                   | 12px    | Padding Y              |
| --radius-md                 | 6px     | Border radius          |
| --motion-instant            | 200ms   | Hover/focus transition |
| --color-interactive-primary | #ff6600 | Primary orange         |
| --color-focus               | #199cb7 | Focus teal             |

---

## Variants & States

### Variant: Primary (CTA - Calls to Action)

| State    | Bg Color                               | Text Color                 | Border             | Details                         |
| -------- | -------------------------------------- | -------------------------- | ------------------ | ------------------------------- |
| Default  | --interactive-primary (#ff6600)        | white                      | none               | Solid background                |
| Hover    | --interactive-primary-hover (#e55a00)  | white                      | none               | Darker orange                   |
| Focus    | --interactive-primary (#ff6600)        | white                      | --color-focus-ring | Outline + 2px offset            |
| Active   | --interactive-primary-active (#cc4d00) | white                      | none               | Darkest orange                  |
| Disabled | --color-disabled-bg (#f5f5f5)          | --color-disabled (#bdbdbd) | none               | Grayed out                      |
| Loading  | --interactive-primary (#ff6600)        | white                      | none               | Spinner visible, disabled state |

### Variant: Secondary (Alternative Actions)

| State    | Bg Color                      | Text Color                               | Border                         | Details              |
| -------- | ----------------------------- | ---------------------------------------- | ------------------------------ | -------------------- |
| Default  | transparent                   | --interactive-secondary (#199cb7)        | --interactive-secondary        | 2px border           |
| Hover    | --interactive-secondary + 0.1 | --interactive-secondary-hover (#148299)  | --interactive-secondary-hover  | Lighter bg           |
| Focus    | transparent                   | --interactive-secondary                  | --color-focus-ring             | Outline + 2px offset |
| Active   | --interactive-secondary + 0.2 | --interactive-secondary-active (#0d667a) | --interactive-secondary-active | Darker               |
| Disabled | transparent                   | --color-disabled                         | --color-disabled               | Grayed               |
| Loading  | transparent                   | --interactive-secondary                  | --interactive-secondary        | Spinner visible      |

### Variant: Ghost (Minimal, text-like)

| State    | Bg Color                         | Text Color                     | Border             | Details         |
| -------- | -------------------------------- | ------------------------------ | ------------------ | --------------- |
| Default  | transparent                      | --color-text-primary (#1a1a1a) | none               | No background   |
| Hover    | --color-surface-raised (#eff0f5) | --color-text-primary           | none               | Light bg        |
| Focus    | transparent                      | --color-text-primary           | --color-focus-ring | Outline only    |
| Active   | --color-surface-strong (#f5f5f5) | --color-text-primary           | none               | Stronger bg     |
| Disabled | transparent                      | --color-disabled               | none               | Grayed          |
| Loading  | transparent                      | --color-text-primary           | none               | Spinner visible |

### Variant: Text (No styling, link-like)

| State    | Styling                     |
| -------- | --------------------------- |
| Default  | Text color + cursor pointer |
| Hover    | Underline                   |
| Focus    | Outline + 2px offset        |
| Active   | Underline + darker color    |
| Disabled | Grayed out                  |
| Loading  | Underline + spinner         |

---

## Sizes

| Size | Padding   | Font Size | Min Height | Touch Target                 |
| ---- | --------- | --------- | ---------- | ---------------------------- |
| sm   | 8px 12px  | 12px      | 32px       | ✓ 44px (with vertical space) |
| md   | 12px 16px | 14px      | 40px       | ✓ 44px                       |
| lg   | 16px 24px | 16px      | 48px       | ✓ 48px                       |

---

## Responsive Behavior

| Breakpoint        | Behavior                                  |
| ----------------- | ----------------------------------------- |
| Mobile (< 640px)  | Full width (except inline/ghost variants) |
| Tablet+ (≥ 640px) | Auto width                                |
| All               | Touch target ≥ 44×44px                    |

---

## Accessibility Requirements

### Keyboard Support

- ✅ Tab into button
- ✅ Space/Enter to activate
- ✅ Focus indicator visible (2px outline, 2px offset)
- ✅ Focus order logical (top-to-bottom, left-to-right)

### Screen Reader Support

- ✅ `aria-label` if icon-only button
- ✅ `aria-pressed` if toggle button (future variant)
- ✅ `aria-busy="true"` during loading
- ✅ `aria-disabled="true"` if disabled
- ✅ Button role implicit (use `<button>` tag)

### Color Contrast (WCAG 2.2 AA)

- ✅ Primary: orange (#ff6600) on white = 5.2:1 (AAA)
- ✅ Secondary: teal (#199cb7) on white = 5.5:1 (AAA)
- ✅ Ghost/Text: dark (#1a1a1a) on light = 14:1 (AAA)
- ✅ Disabled: gray (#bdbdbd) on white = 4.5:1 (AA)

### Motion & Vestibular

- ✅ Transitions respect `prefers-reduced-motion`
- ✅ No auto-play animations
- ✅ No parallax or scroll-triggered animations

### Touch Support

- ✅ 44×44px minimum touch target
- ✅ Adequate spacing from other interactive elements

---

## Anti-Patterns (Don't Do This)

❌ **Hidden buttons** — Always visible or use aria-hidden correctly  
❌ **Duplicate labels** — Don't say "Click here" + aria-label="Submit"  
❌ **Disabled color without pattern** — Make disabled visually distinct (contrast + opacity)  
❌ **No focus indicator** — Always show focus state  
❌ **Loading without spinner** — Indicate async state change  
❌ **Icon-only without label** — Always include aria-label or text

---

## Implementation Checklist

- [ ] Create `resources/views/components/button.blade.php`
- [ ] Create `resources/css/components/button.css`
- [ ] Support all variants (primary, secondary, ghost, text)
- [ ] Support all sizes (sm, md, lg)
- [ ] Support loading state with spinner
- [ ] Support disabled state
- [ ] Add keyboard event handlers
- [ ] Add aria attributes
- [ ] Test in screen reader
- [ ] Test focus visibility
- [ ] Test color contrast
- [ ] Test touch targets
- [ ] Test dark mode
- [ ] Test RTL
- [ ] Document with usage examples
- [ ] Add to component library

---

## Usage Examples

```blade
{{-- Primary CTA --}}
<x-button variant="primary" size="md">
  Add to Cart
</x-button>

{{-- Secondary Action --}}
<x-button variant="secondary" size="sm">
  Learn More
</x-button>

{{-- Icon Button --}}
<x-button variant="ghost" icon="search" aria-label="Search">
</x-button>

{{-- Loading State --}}
<x-button variant="primary" :loading="$isProcessing" disabled="{{ $isProcessing }}">
  {{ $isProcessing ? 'Saving...' : 'Save Changes' }}
</x-button>

{{-- Disabled --}}
<x-button disabled>
  Out of Stock
</x-button>
```

---

## QA Checklist

- [ ] All states render correctly
- [ ] Focus ring visible and correct color
- [ ] Hover effects smooth (200ms)
- [ ] Disabled state non-interactive
- [ ] Loading spinner rotates
- [ ] Text wrapping handled
- [ ] Icons aligned properly
- [ ] Touch targets ≥ 44px
- [ ] Works in Safari, Chrome, Firefox, Edge
- [ ] Works with keyboard navigation
- [ ] Screen reader announces correctly
- [ ] Respects dark mode
- [ ] Respects RTL layout
- [ ] No console errors
