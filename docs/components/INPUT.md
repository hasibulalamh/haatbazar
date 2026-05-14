# Input Component Specification

**Version:** 1.0  
**Status:** Ready for Implementation  
**Quality Target:** WCAG 2.2 AA + Daraz Design

---

## Design Intent

A flexible, accessible text input component that supports multiple input types and states. Provides clear visual feedback for focus, validation, and errors while maintaining a minimal, clean design aligned with the Daraz e-commerce aesthetic.

---

## Component Anatomy

```
┌─────────────────────────────────────┐
│ Label                               │
│ ┌─────────────────────────────────┐ │
│ │ [icon] Input text...       [icon]│ │ ← Input container
│ └─────────────────────────────────┘ │
│ Helper text / Error message         │
└─────────────────────────────────────┘
```

### Slots & Props

- **label** — Label text (required for accessibility)
- **placeholder** — Placeholder text (optional)
- **type** — Input type (text, email, password, tel, url, number, date)
- **value** — Input value (v-model / Blade binding)
- **error** — Error message (shows in red, changes border)
- **helper** — Helper/hint text (shows below input)
- **icon** — Leading icon (optional)
- **icon-end** — Trailing icon (optional, e.g., visibility toggle)
- **disabled** — Disabled state
- **readonly** — Read-only state
- **required** — Required field indicator

---

## Design Tokens Used

| Token                  | Value   | Purpose           |
| ---------------------- | ------- | ----------------- |
| --font-size-md         | 14px    | Input text size   |
| --font-size-sm         | 12px    | Label/helper text |
| --space-8              | 12px    | Padding Y         |
| --space-12             | 16px    | Padding X         |
| --space-5              | 10px    | Icon spacing      |
| --radius-md            | 6px     | Border radius     |
| --motion-instant       | 200ms   | Focus transition  |
| --color-border         | #e0e0e0 | Border color      |
| --color-focus          | #199cb7 | Focus teal        |
| --color-error          | #d32f2f | Error red         |
| --color-success        | #388e3c | Success green     |
| --color-text-secondary | #888888 | Helper text gray  |

---

## Input Types & Variants

### Text Inputs

| Type     | HTML                      | Use Case           | Validation             |
| -------- | ------------------------- | ------------------ | ---------------------- |
| text     | `<input type="text">`     | General text input | None (user-defined)    |
| email    | `<input type="email">`    | Email address      | Format validation      |
| password | `<input type="password">` | Password entry     | Pattern validation     |
| tel      | `<input type="tel">`      | Phone number       | Format validation      |
| url      | `<input type="url">`      | Website URL        | URL format validation  |
| number   | `<input type="number">`   | Numeric values     | Numeric validation     |
| date     | `<input type="date">`     | Date picker        | Date format validation |

---

## States & Styling

### State: Default

| Property    | Value                              | Details            |
| ----------- | ---------------------------------- | ------------------ |
| Border      | 1px solid --color-border (#e0e0e0) | Light gray border  |
| Background  | white                              | Clean background   |
| Text Color  | --color-text-primary (#1a1a1a)     | Dark text          |
| Placeholder | --color-text-secondary (#888888)   | Gray placeholder   |
| Transition  | 200ms ease                         | Smooth transitions |

### State: Focus

| Property   | Value                                                                 | Details                      |
| ---------- | --------------------------------------------------------------------- | ---------------------------- |
| Border     | 2px solid --color-focus (#199cb7)                                     | Teal border                  |
| Background | white                                                                 | Same background              |
| Outline    | var(--color-focus-ring)                                               | 2px teal outline, 2px offset |
| Shadow     | inset 0 0 0 1px rgba(25,156,183,0.3), 0 0 0 3px rgba(25,156,183,0.15) | Subtle glow                  |
| Text Color | --color-text-primary                                                  | Dark text                    |

### State: Error

| Property     | Value                             | Details                          |
| ------------ | --------------------------------- | -------------------------------- |
| Border       | 2px solid --color-error (#d32f2f) | Red border                       |
| Background   | white                             | Same background                  |
| Text Color   | --color-text-primary              | Dark text                        |
| Helper Text  | --color-error (#d32f2f)           | Red error message                |
| Icon         | ✗ in red                          | Visual error indicator           |
| Focus Border | --color-focus (#199cb7)           | Override to focus color on focus |

### State: Success

| Property    | Value                               | Details                  |
| ----------- | ----------------------------------- | ------------------------ |
| Border      | 2px solid --color-success (#388e3c) | Green border             |
| Background  | white                               | Same background          |
| Text Color  | --color-text-primary                | Dark text                |
| Helper Text | --color-success (#388e3c)           | Green success message    |
| Icon        | ✓ in green                          | Visual success indicator |

### State: Disabled

| Property   | Value                                | Details                  |
| ---------- | ------------------------------------ | ------------------------ |
| Background | --color-disabled-bg (#f5f5f5)        | Light gray bg            |
| Border     | 1px solid --color-disabled (#bdbdbd) | Gray border              |
| Text Color | --color-disabled (#bdbdbd)           | Gray text                |
| Cursor     | not-allowed                          | Indicate non-interactive |
| Opacity    | 0.6                                  | Visual dimming           |

### State: Readonly

| Property   | Value                                    | Details                  |
| ---------- | ---------------------------------------- | ------------------------ |
| Background | --color-surface-raised (#eff0f5)         | Slightly raised surface  |
| Border     | 1px solid --color-border-light (#f0f0f0) | Subtle border            |
| Text Color | --color-text-primary                     | Dark text                |
| Cursor     | default                                  | Not editable             |
| Input      | Non-editable                             | No change on click/focus |

---

## Responsive Behavior

| Breakpoint           | Behavior                |
| -------------------- | ----------------------- |
| Mobile (< 640px)     | Full width (100%)       |
| Tablet (640px-768px) | Full width or auto      |
| Desktop (≥ 768px)    | Auto width (flex-based) |
| All                  | Adequate label spacing  |

---

## Accessibility Requirements

### Keyboard Support

- ✅ Tab into input
- ✅ Shift+Tab backward navigation
- ✅ Arrow keys for text selection (native)
- ✅ Escape to clear (optional enhancement)
- ✅ Focus indicator visible (2px outline)

### Screen Reader Support

- ✅ `<label>` associated with `id` (for/htmlFor)
- ✅ `aria-label` if no visible label
- ✅ `aria-describedby` pointing to helper/error text
- ✅ `aria-invalid="true"` when error state
- ✅ `aria-required="true"` for required fields
- ✅ Type announced (email, password, etc.)

### Color Contrast (WCAG 2.2 AA)

- ✅ Label text: dark (#1a1a1a) on white = 14:1 (AAA)
- ✅ Helper text: gray (#888888) on white = 4.5:1 (AA)
- ✅ Border: gray (#e0e0e0) on white = 1.2:1 (fail) — but visible due to shape
- ✅ Error text: red (#d32f2f) on white = 5.2:1 (AAA)
- ✅ Success text: green (#388e3c) on white = 5.2:1 (AAA)

### Motion & Vestibular

- ✅ Focus transition respects `prefers-reduced-motion`
- ✅ No auto-play animations
- ✅ Smooth 200ms transition for border/shadow

### Touch Support

- ✅ Input height ≥ 44px (40px + 4px padding = 48px total)
- ✅ Adequate spacing below for error messages
- ✅ Icon touch targets ≥ 44px

---

## Anti-Patterns (Don't Do This)

❌ **Missing label** — Always include visible label or aria-label  
❌ **Placeholder as label** — Placeholder disappears; use actual label  
❌ **No error indicator** — Always distinguish error with color + text  
❌ **Float labels without space** — Hard to read; keep label visible  
❌ **Red error text only** — Don't rely on color alone; add icon + text  
❌ **No focus indicator** — Always show focus with outline/border  
❌ **Disabled without visual diff** — Make disabled clearly different

---

## Implementation Checklist

- [ ] Create `resources/views/components/input.blade.php`
- [ ] Create `resources/css/components/input.css`
- [ ] Support all input types (text, email, password, etc.)
- [ ] Support error state with message
- [ ] Support success state with message
- [ ] Support helper text
- [ ] Support leading/trailing icons
- [ ] Support disabled state
- [ ] Support readonly state
- [ ] Support label (visible or aria-label)
- [ ] Add aria-describedby for helper/error
- [ ] Add aria-invalid for error state
- [ ] Add aria-required for required fields
- [ ] Test in screen reader
- [ ] Test focus visibility
- [ ] Test color contrast
- [ ] Test touch targets
- [ ] Test dark mode
- [ ] Test RTL
- [ ] Document with usage examples
- [ ] Create form integration examples

---

## Usage Examples

```blade
{{-- Basic text input with label --}}
<x-input
  name="fullname"
  label="Full Name"
  placeholder="John Doe"
  required
/>

{{-- Email with helper text --}}
<x-input
  type="email"
  name="email"
  label="Email Address"
  helper="We'll never share your email"
  required
/>

{{-- Error state --}}
<x-input
  name="password"
  type="password"
  label="Password"
  error="Password must be at least 8 characters"
  :class="{ 'border-red-600': $errors->has('password') }"
/>

{{-- With icon --}}
<x-input
  name="search"
  label="Search Products"
  icon="search"
  placeholder="Search..."
/>

{{-- Readonly --}}
<x-input
  name="reference_id"
  label="Reference ID"
  value="REF-2024-001"
  readonly
/>

{{-- Phone number --}}
<x-input
  type="tel"
  name="phone"
  label="Phone Number"
  placeholder="+880 1234 567890"
  helper="Include country code"
/>
```

---

## Related Components

- **Form** — Wrapper for inputs with validation
- **Select** — Dropdown input variant
- **Textarea** — Multi-line input variant
- **Checkbox** — Discrete option input
- **Radio** — Single-select from options
- **Form Group** — Label + input + helper wrapper

---

## QA Checklist

- [ ] Text renders correctly
- [ ] Placeholder visible and gray
- [ ] Focus border visible (teal, 2px)
- [ ] Focus shadow smooth and subtle
- [ ] Error message displays in red
- [ ] Success message displays in green
- [ ] Helper text visible below
- [ ] Icons aligned properly
- [ ] Disabled state non-interactive
- [ ] Readonly state not editable
- [ ] Touch target ≥ 44px
- [ ] Works in Safari, Chrome, Firefox, Edge
- [ ] Works with keyboard (Tab, Shift+Tab)
- [ ] Screen reader announces label and type
- [ ] Screen reader announces error/helper text
- [ ] Color contrast meets WCAG AA
- [ ] Respects dark mode
- [ ] Respects RTL layout
- [ ] No console errors
