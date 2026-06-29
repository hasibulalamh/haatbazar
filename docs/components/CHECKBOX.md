# Checkbox Component Specification

**Version:** 1.0  
**Status:** Ready for Implementation  
**Quality Target:** WCAG 2.2 AA + Daraz Design

---

## Design Intent

A custom-styled checkbox component that maintains full accessibility while providing a clean, modern design consistent with the Daraz e-commerce aesthetic. Supports single checkboxes and checkbox groups with proper label association and validation states.

---

## Component Anatomy

```
┌─ ☑ ─┐
│  ✓  │  Label Text
└─────┘
```

### Structure

- **Checkbox box** — 20×20px container with custom border/background
- **Checkmark** — SVG icon (only visible when checked)
- **Label** — Associated text
- **Helper/Hint** — Optional description

### Slots & Props

- **label** — Associated label text (required)
- **name** — Input name for form submission
- **value** — Checkbox value
- **checked** — Initial checked state (v-model compatible)
- **disabled** — Disabled state
- **error** — Error message (shows below)
- **helper** — Helper text (shows below)
- **indeterminate** — Partially checked state (for group headers)

---

## Design Tokens Used

| Token                       | Value   | Purpose            |
| --------------------------- | ------- | ------------------ |
| --color-border              | #e0e0e0 | Unchecked border   |
| --color-interactive-primary | #ff6600 | Checked background |
| --color-focus               | #199cb7 | Focus outline      |
| --space-4                   | 6px     | Box spacing        |
| --radius-xs                 | 2px     | Box border radius  |
| --motion-instant            | 200ms   | Transition         |

---

## States & Styling

| State         | Appearance                           | Details                           |
| ------------- | ------------------------------------ | --------------------------------- |
| Unchecked     | 20×20px box, light gray border       | Background: white                 |
| Checked       | 20×20px box, orange background       | Checkmark visible                 |
| Indeterminate | 20×20px box, orange background       | Dash visible (not checkmark)      |
| Focus         | Blue outline + 2px offset            | Shows focus ring                  |
| Disabled      | Light gray background, grayed border | Cursor: not-allowed, opacity: 0.6 |
| Error         | Red border (2px)                     | Error message below               |

---

## Accessibility Requirements

### Keyboard Support

- ✅ Tab to focus
- ✅ Space to toggle check
- ✅ Focus visible (2px teal outline)

### Screen Reader Support

- ✅ `<input type="checkbox">` with `<label>`
- ✅ `aria-checked` for state (native checkbox handles this)
- ✅ `aria-describedby` for error/helper
- ✅ `aria-invalid` for error state
- ✅ `aria-disabled` for disabled state

### Touch Support

- ✅ 44×44px minimum touch target (20px box + spacing)
- ✅ Adequate label click area

---

## Anti-Patterns

❌ **Hidden native checkbox** — Keep it in DOM, just style it  
❌ **No label** — Always associate label with id  
❌ **No focus indicator** — Show clear focus ring  
❌ **Icon-only without semantics** — Use native `<input type="checkbox">`

---

## Implementation Checklist

- [ ] Create `resources/views/components/checkbox.blade.php`
- [ ] Create `resources/css/components/checkbox.css`
- [ ] Support checked/unchecked/indeterminate states
- [ ] Support error state with message
- [ ] Support disabled state
- [ ] Support helper text
- [ ] Custom SVG checkmark
- [ ] Proper label association
- [ ] Test with screen reader
- [ ] Verify focus indicator
- [ ] Test dark mode
- [ ] Test RTL
- [ ] Document with examples

---

## Usage Examples

```blade
{{-- Single checkbox --}}
<x-checkbox
  name="terms"
  label="I agree to terms and conditions"
  required
/>

{{-- With helper text --}}
<x-checkbox
  name="newsletter"
  label="Subscribe to our newsletter"
  helper="We'll send updates weekly"
/>

{{-- Error state --}}
<x-checkbox
  name="confirm"
  label="Please confirm"
  error="You must confirm to proceed"
/>

{{-- Disabled --}}
<x-checkbox
  name="archived"
  label="This is archived"
  disabled
/>
```

---

## QA Checklist

- [ ] Checkbox renders correctly
- [ ] Checkmark visible when checked
- [ ] Focus ring visible and correct color
- [ ] Space key toggles checkbox
- [ ] Disabled state non-interactive
- [ ] Error message displays
- [ ] Touch target ≥ 44px
- [ ] Works with keyboard navigation
- [ ] Screen reader announces correctly
- [ ] Respects dark mode
- [ ] Respects RTL
- [ ] No console errors
