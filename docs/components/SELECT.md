# Select Component Specification

**Version:** 1.0  
**Status:** Ready for Implementation  
**Quality Target:** WCAG 2.2 AA + Daraz Design

---

## Design Intent

A custom-styled dropdown select component that replaces the native `<select>` element. Provides a clean, modern design while maintaining full accessibility and keyboard navigation. Supports single selection with searchable options (future enhancement).

---

## Component Anatomy

```
┌─────────────────────────┐
│ Select an option    ▼   │ ← Closed state
└─────────────────────────┘

┌─────────────────────────┐
│ Option 1            ▲   │
│ Option 2 (selected) │   │
│ Option 3            │   │
│ Option 4            ▼   │
└─────────────────────────┘ ← Open state
```

### Structure

- **Select trigger** — Button showing current selection
- **Dropdown list** — Container for options
- **Option items** — Individual selection items
- **Chevron icon** — Indicates dropdown state

### Slots & Props

- **label** — Associated label text
- **name** — Input name
- **options** — Array of { value, label } objects
- **value** — Selected value
- **placeholder** — Placeholder text (e.g., "Choose...")
- **disabled** — Disabled state
- **error** — Error message
- **helper** — Helper text
- **searchable** — Enable search (future)

---

## Design Tokens Used

| Token                  | Value   | Purpose              |
| ---------------------- | ------- | -------------------- |
| --color-border         | #e0e0e0 | Border               |
| --color-focus          | #199cb7 | Focus/open indicator |
| --color-text-secondary | #888888 | Placeholder          |
| --space-8              | 12px    | Padding              |
| --space-12             | 16px    | Padding X            |
| --radius-md            | 6px     | Border radius        |
| --motion-fast          | 300ms   | Open/close animation |
| --z-dropdown           | 1000    | Stacking             |

---

## States & Styling

| State            | Appearance                          | Details                               |
| ---------------- | ----------------------------------- | ------------------------------------- |
| Closed (default) | 44px height, border, arrow down     | Shows selected value or placeholder   |
| Open             | Expanded, arrow up, options visible | Z-index: 1000, smooth slide animation |
| Hover            | Subtle background change            | Light hover effect                    |
| Focus            | Teal outline + 2px offset           | Shows focus ring when closed          |
| Disabled         | Gray background, gray text          | Cursor: not-allowed, opacity: 0.6     |
| Error            | Red border (2px)                    | Error message below                   |

---

## Responsive Behavior

| Breakpoint         | Behavior                                 |
| ------------------ | ---------------------------------------- |
| Mobile (< 640px)   | Full width, dropdown aligned to viewport |
| Tablet (640-768px) | Full width or fixed width                |
| Desktop (≥ 768px)  | Auto width, smart positioning            |
| All                | Touch target ≥ 44px                      |

---

## Keyboard Support

| Key         | Action                                              |
| ----------- | --------------------------------------------------- |
| Tab         | Move to/from select                                 |
| Space/Enter | Open dropdown when closed, select when open         |
| Arrow Down  | Move down in open list, cycle through closed values |
| Arrow Up    | Move up in open list, cycle through closed values   |
| Escape      | Close dropdown                                      |
| Home        | Jump to first option                                |
| End         | Jump to last option                                 |
| Letter keys | Jump to option starting with letter (future)        |

---

## Accessibility Requirements

### Keyboard Support

- ✅ Tab to focus
- ✅ Space/Enter to open
- ✅ Arrow keys to navigate
- ✅ Escape to close
- ✅ Focus ring visible (2px teal)

### Screen Reader Support

- ✅ `<label>` associated with select
- ✅ `aria-describedby` for error/helper
- ✅ `aria-invalid` for error
- ✅ `aria-expanded` shows open/closed state
- ✅ `aria-selected` on each option
- ✅ Options announced with count

### Touch Support

- ✅ 44px minimum height
- ✅ Touch-friendly option spacing
- ✅ Mobile-optimized positioning

---

## Anti-Patterns

❌ **No label association** — Always use <label>  
❌ **Hidden native select** — Keep for fallback  
❌ **No keyboard navigation** — Must support arrow keys  
❌ **Focus loss on open** — Maintain focus within dropdown

---

## Implementation Checklist

- [ ] Create `resources/views/components/select.blade.php`
- [ ] Create `resources/css/components/select.css`
- [ ] Create Alpine.js toggle logic for open/close
- [ ] Support open/closed states
- [ ] Support selected value display
- [ ] Support placeholder
- [ ] Support error state with message
- [ ] Support disabled state
- [ ] Support helper text
- [ ] Keyboard navigation (arrow keys, Home/End)
- [ ] Escape to close
- [ ] Focus management
- [ ] Option hover states
- [ ] Dropdown positioning (avoid viewport overflow)
- [ ] Test with screen reader
- [ ] Verify focus indicator
- [ ] Test dark mode
- [ ] Test RTL
- [ ] Document with examples

---

## Usage Examples

```blade
{{-- Basic select --}}
<x-select
  name="category"
  label="Select Category"
  :options="[
    ['value' => 'electronics', 'label' => 'Electronics'],
    ['value' => 'fashion', 'label' => 'Fashion'],
    ['value' => 'home', 'label' => 'Home & Garden'],
  ]"
/>

{{-- With placeholder --}}
<x-select
  name="country"
  label="Country"
  placeholder="Choose a country..."
  :options="$countries"
/>

{{-- With error --}}
<x-select
  name="shipping"
  label="Shipping Method"
  error="Please select a shipping method"
  :options="$shippingMethods"
/>

{{-- With helper text --}}
<x-select
  name="payment"
  label="Payment Method"
  helper="Card payments are most secure"
  :options="$paymentMethods"
/>
```

---

## QA Checklist

- [ ] Dropdown opens/closes on click
- [ ] Options display correctly
- [ ] Selected option is highlighted
- [ ] Arrow keys navigate options
- [ ] Space/Enter selects option
- [ ] Escape closes dropdown
- [ ] Focus ring visible when closed
- [ ] Disabled state non-interactive
- [ ] Error message displays
- [ ] Touch target ≥ 44px
- [ ] Dropdown doesn't overflow viewport
- [ ] Works with keyboard navigation
- [ ] Screen reader announces options
- [ ] Respects dark mode
- [ ] Respects RTL
- [ ] No console errors
