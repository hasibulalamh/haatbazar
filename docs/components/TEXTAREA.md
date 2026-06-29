# Textarea Component Specification

**Version:** 1.0  
**Status:** Ready for Implementation  
**Quality Target:** WCAG 2.2 AA + Daraz Design

---

## Design Intent

A flexible, accessible textarea component for multi-line text input. Provides character counting, auto-resize capability, and full validation state support while maintaining consistency with the Input component.

---

## Component Anatomy

```
┌─────────────────────────────────┐
│ Label                           │
│ ┌─────────────────────────────┐ │
│ │ Your message here...        │ │
│ │                             │ │
│ │                             │ │ ← Textarea grows with content
│ └─────────────────────────────┘ │
│ Helper text / Error message     │
│ Character count: 123 / 500      │
└─────────────────────────────────┘
```

### Structure

- **Label** — Associated text label
- **Textarea** — Multi-line text input
- **Char counter** — Optional character count display
- **Helper/Error** — Feedback text

### Slots & Props

- **label** — Label text (required)
- **name** — Input name
- **value** — Initial text value
- **placeholder** — Placeholder text
- **rows** — Minimum rows (default: 4)
- **maxlength** — Character limit (optional)
- **autosize** — Grow/shrink with content (boolean)
- **error** — Error message
- **helper** — Helper text
- **disabled** — Disabled state
- **readonly** — Read-only state

---

## Design Tokens Used

| Token            | Value   | Purpose       |
| ---------------- | ------- | ------------- |
| --font-size-md   | 14px    | Text size     |
| --font-size-sm   | 12px    | Label/helper  |
| --space-8        | 12px    | Padding Y     |
| --space-12       | 16px    | Padding X     |
| --radius-md      | 6px     | Border radius |
| --color-border   | #e0e0e0 | Border        |
| --color-focus    | #199cb7 | Focus teal    |
| --motion-instant | 200ms   | Transition    |

---

## States & Styling

| State         | Appearance                      | Details                  |
| ------------- | ------------------------------- | ------------------------ |
| Default       | 4 rows (104px), light border    | Background: white        |
| Focus         | Teal border (2px) + shadow ring | Enhanced visual feedback |
| Error         | Red border (2px)                | Error message below      |
| Success       | Green border (2px)              | Success message below    |
| Disabled      | Gray bg, gray border, no cursor | Opacity: 0.6             |
| Readonly      | Light raised bg, non-editable   | Cursor: default          |
| At char limit | Warn color for counter          | Visual indicator         |

---

## Character Counting

### Display Format

```
"Helpful hint (123/500 characters)"
```

### Behavior

- Show counter when maxlength set
- Update in real-time as user types
- Change color when near limit (80%+)
- Prevent input beyond limit

### Styling

- Normal (0-79%): Gray color
- Warning (80-99%): Orange color
- Limit reached (100%): Red color
- Red text + disabled input when at limit

---

## Auto-Resize Behavior

When `autosize="true"`:

- Textarea grows as content exceeds rows
- Minimum height: 4 rows (or specified rows prop)
- Maximum height: 20 rows (scrolls if more)
- Smooth height transitions

---

## Responsive Behavior

| Breakpoint        | Behavior                                    |
| ----------------- | ------------------------------------------- |
| Mobile (< 640px)  | Full width, 16px font (iOS zoom prevention) |
| Tablet+ (≥ 640px) | Full width or fixed width, 14px font        |
| All               | Touch target ≥ 44px                         |

---

## Accessibility Requirements

### Keyboard Support

- ✅ Tab to focus
- ✅ Shift+Tab backward
- ✅ Enter for line break (native)
- ✅ Focus indicator visible (2px outline)

### Screen Reader Support

- ✅ Associated `<label>`
- ✅ `aria-describedby` for helper/error/counter
- ✅ `aria-invalid` for error
- ✅ Character limit announced

### Touch Support

- ✅ 44px minimum height
- ✅ 16px font size on mobile (prevents zoom)
- ✅ Adequate spacing for keyboard

---

## Anti-Patterns

❌ **No label** — Always include visible label or aria-label  
❌ **Hardcoded height** — Use rows prop or autosize  
❌ **No char limit warning** — Always warn near limit  
❌ **No focus indicator** — Show clear focus ring  
❌ **Word wrap not enabled** — Use word-wrap: break-word

---

## Implementation Checklist

- [ ] Create `resources/views/components/textarea.blade.php`
- [ ] Create `resources/css/components/textarea.css`
- [ ] Support minRows and maxRows
- [ ] Support autosize option
- [ ] Support character counting (if maxlength)
- [ ] Support error state
- [ ] Support success state
- [ ] Support disabled state
- [ ] Support readonly state
- [ ] Support helper text
- [ ] Support placeholder
- [ ] Proper label association
- [ ] aria-describedby for counter/helper/error
- [ ] Test auto-resize
- [ ] Test character counter
- [ ] Test screen reader
- [ ] Verify focus indicator
- [ ] Test dark mode
- [ ] Test RTL
- [ ] Document with examples

---

## Usage Examples

```blade
{{-- Basic textarea --}}
<x-textarea
  name="message"
  label="Your Message"
  placeholder="Type your message here..."
  rows="5"
/>

{{-- With character limit --}}
<x-textarea
  name="bio"
  label="About You"
  placeholder="Tell us about yourself..."
  maxlength="500"
  rows="4"
/>

{{-- With auto-resize --}}
<x-textarea
  name="feedback"
  label="Feedback"
  placeholder="Share your thoughts..."
  autosize
  rows="3"
/>

{{-- With error --}}
<x-textarea
  name="comment"
  label="Comment"
  error="Comment is required and must be at least 10 characters"
  maxlength="1000"
/>

{{-- With helper text --}}
<x-textarea
  name="description"
  label="Product Description"
  helper="Include key features and benefits (max 500 chars)"
  maxlength="500"
/>
```

---

## QA Checklist

- [ ] Textarea renders with correct rows
- [ ] Text wraps properly
- [ ] Focus border visible (teal, 2px)
- [ ] Character counter updates in real-time
- [ ] Counter warns at 80% of limit
- [ ] Input prevents beyond maxlength
- [ ] Auto-resize grows with content (if enabled)
- [ ] Auto-resize shrinks when text removed
- [ ] Disabled state non-interactive
- [ ] Readonly state non-editable
- [ ] Error message displays
- [ ] Helper text displays
- [ ] Touch target ≥ 44px
- [ ] Works with keyboard (Tab, Shift+Tab)
- [ ] Screen reader announces label and maxlength
- [ ] Color contrast meets WCAG AA
- [ ] Respects dark mode
- [ ] Respects RTL
- [ ] Mobile: 16px font (no zoom)
- [ ] No console errors
