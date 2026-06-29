# Radio Component Specification

**Version:** 1.0  
**Status:** Ready for Implementation  
**Quality Target:** WCAG 2.2 AA + Daraz Design

---

## Design Intent

A custom-styled radio button component that allows single selection from a group of options. Maintains full accessibility while providing clean, modern design. Radio buttons work as groups where only one option can be selected at a time.

---

## Component Anatomy

```
◯ Option 1
● Option 2 (selected)
◯ Option 3
```

### Structure (Group)

- **Radio Group** — Container for related options
- **Radio button** — 20×20px circle for each option
- **Dot indicator** — Filled circle when selected
- **Label** — Associated text for each option

### Slots & Props (Individual)

- **label** — Associated label text (required)
- **name** — Input name (same for group)
- **value** — Option value
- **checked** — Initial selected state
- **disabled** — Disabled state
- **error** — Error message (group-level)
- **helper** — Helper text (group-level)

---

## Design Tokens Used

| Token                       | Value   | Purpose            |
| --------------------------- | ------- | ------------------ |
| --color-border              | #e0e0e0 | Unselected border  |
| --color-interactive-primary | #ff6600 | Selected indicator |
| --color-focus               | #199cb7 | Focus outline      |
| --space-4                   | 6px     | Spacing            |
| --radius-full               | 9999px  | Circle shape       |
| --motion-instant            | 200ms   | Transition         |

---

## States & Styling

| State      | Appearance                        | Details                           |
| ---------- | --------------------------------- | --------------------------------- |
| Unselected | 20×20px circle, light gray border | Background: white, no fill        |
| Selected   | 20×20px circle, orange border     | Orange dot inside (8px)           |
| Focus      | Blue outline + 2px offset         | Shows focus ring                  |
| Disabled   | Light gray background             | Cursor: not-allowed, opacity: 0.6 |
| Error      | Red border (2px)                  | Group error message below         |

---

## Responsive Behavior

| Breakpoint | Behavior                       |
| ---------- | ------------------------------ |
| Mobile     | Stacked vertically, full width |
| Tablet+    | Inline or grid layout          |
| All        | Touch target ≥ 44px            |

---

## Accessibility Requirements

### Keyboard Support

- ✅ Tab to first radio in group
- ✅ Arrow keys to navigate group (Up/Down or Left/Right)
- ✅ Space to select focused radio
- ✅ Focus ring visible (2px teal)

### Screen Reader Support

- ✅ `<fieldset>` with `<legend>` for groups
- ✅ `<input type="radio">` with `<label>`
- ✅ `aria-describedby` for group error/helper
- ✅ `aria-invalid` for error state
- ✅ Group name announced

### Touch Support

- ✅ 44×44px minimum touch target
- ✅ Adequate spacing between options

---

## Anti-Patterns

❌ **No fieldset/legend** — Always group with semantic HTML  
❌ **Mixed names in group** — All radios in group must have same name  
❌ **No focus indicator** — Show clear focus ring  
❌ **No keyboard nav** — Arrow keys must work in group

---

## Implementation Checklist

- [ ] Create `resources/views/components/radio.blade.php`
- [ ] Create `resources/css/components/radio.css`
- [ ] Create `resources/views/components/radio-group.blade.php`
- [ ] Support selected/unselected states
- [ ] Support group layout
- [ ] Support error state with message
- [ ] Support disabled state
- [ ] Support helper text
- [ ] Custom SVG indicator
- [ ] Proper label association
- [ ] Fieldset with legend for groups
- [ ] Keyboard navigation (arrow keys)
- [ ] Test with screen reader
- [ ] Verify focus indicator
- [ ] Test dark mode
- [ ] Test RTL
- [ ] Document with examples

---

## Usage Examples

```blade
{{-- Single option (rare) --}}
<x-radio
  name="option"
  value="yes"
  label="Yes"
/>

{{-- Radio group --}}
<x-radio-group label="Choose delivery speed" name="shipping" error="Please select a shipping method">
  <x-radio value="standard" label="Standard (5-7 days)" />
  <x-radio value="express" label="Express (2-3 days)" />
  <x-radio value="overnight" label="Overnight" />
</x-radio-group>

{{-- With helper text --}}
<x-radio-group
  label="Select payment method"
  name="payment"
  helper="Card payments are most secure"
>
  <x-radio value="card" label="Credit/Debit Card" />
  <x-radio value="mobile" label="Mobile Money" />
  <x-radio value="bank" label="Bank Transfer" />
</x-radio-group>
```

---

## QA Checklist

- [ ] Radio renders as circle
- [ ] Indicator dot visible when selected
- [ ] Focus ring visible and correct color
- [ ] Arrow keys navigate group
- [ ] Space key selects option
- [ ] Only one option selected at a time
- [ ] Disabled state non-interactive
- [ ] Error message displays
- [ ] Touch target ≥ 44px
- [ ] Works with keyboard navigation
- [ ] Screen reader announces group + options
- [ ] Respects dark mode
- [ ] Respects RTL
- [ ] No console errors
