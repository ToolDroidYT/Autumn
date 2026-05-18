# AUTUMN Design System

AUTUMN uses a dark, final-presentation-ready visual system derived from the provided reference screenshots, cleaned up for a reusable Laravel Blade implementation.

## Theme

- Background: pitch-black / AMOLED-first
- Panels: near-black dark gray cards
- Accent 1: red for primary action and AUTUMN emphasis
- Accent 2: orange for secondary emphasis and leaf identity
- Supporting accents: blue for IT, green for CS, purple for CODES
- Borders: thin, low-contrast lines
- Shadows: soft and restrained, never glowing or cyberpunk-heavy

## Tokens

Defined in `public/assets/autumn.css`:

```css
--bg
--bg-soft
--panel
--panel-2
--line
--line-strong
--text
--muted
--muted-2
--red
--orange
--radius
--shadow
--font-heading
--font-body
--font-ui
```

## Typography

- Headings: `Sora`
- Body copy: `Inter`
- UI, labels, buttons, navigation, table headers: `Lexend Deca`
- Section titles are uppercase, bold, and compact.
- Avoid excessive letter spacing, especially in the logo/header.

## Logo / Header

- Use a compact AUTUMN wordmark with only one visual gap between the leaf icon and wordmark.
- Do not split `AUTUMN` into separated chunks.
- Desktop shows full navigation.
- Mobile shows only the menu toggle and a clean mobile panel.
- Mobile toggle must use `<x-icon name="menu" />`.

## Icons

All icons must use the reusable Blade component:

```blade
<x-icon name="shopping-bag" class="h-5 w-5" />
```

Do not add emoji icons, raw random SVGs, or mixed icon libraries in views.

## Buttons

- Primary: red filled button
- Outline: transparent button with thin border
- Danger: dark red destructive action
- Ghost: low-priority action
- Use subtle hover lift only.
- Keep focus rings visible.

## Cards

- Dark card background
- Thin border
- 16px radius
- Soft shadow only
- Hover border shift is allowed, but no heavy glow

## Metadata / Badges / Status

- Avoid loud chips and visual clutter.
- Section labels use a small left-border eyebrow style.
- Statuses use compact left-border text, not bulky pill badges.
- Product/program metadata uses muted inline icon + text.

## Tables

- Tables must be wrapped in `.table-wrap`.
- Admin tables must stay horizontally scrollable on small screens.
- Status values should use `<x-status-pill />`, which renders the minimal status treatment.

## Forms

- Inputs use dark backgrounds and thin borders.
- Focus state uses subtle orange ring.
- Validation errors stay close to fields.

## Admin UI

- Use `<x-admin-sidebar />` for admin navigation.
- Dashboard stats use cards.
- Tables must not overflow outside the viewport.
- Every visible action must submit, navigate, update state, open UI, or show a real disabled state.

## Animation Rules

- Keep animations under 200ms where possible.
- Use fade, slight lift, and scale-in for modals.
- Respect `prefers-reduced-motion`.
- Avoid bouncing, slow transitions, neon glow, and animated gradients.

## Avoid

- React/Inertia UI patterns
- Cyberpunk clutter
- Heavy glassmorphism
- Loud chip-heavy layouts
- Random emoji icons
- Dead buttons
- Placeholder-only pages
- Third-party builder branding
