# AUTUMN Design System

AUTUMN uses a dark, presentation-ready visual language based on the existing Hercules prototype screenshots.

## Theme

- Background: pitch-black / AMOLED
- Panels: dark gray cards
- Accent 1: red
- Accent 2: orange
- Supporting accents: blue for IT, green for CS, purple for CODES
- Borders: thin, low-contrast, not heavy shadows

## Tokens

Defined in `public/assets/autumn.css`:

```css
--bg
--bg-soft
--panel
--line
--line-strong
--text
--muted
--red
--orange
--radius
```

## Typography

- Headings use condensed uppercase styling.
- Body text uses clean system sans-serif.
- Section titles should be large, uppercase, and spacious.
- Do not use lorem ipsum.

## Buttons

- Primary: red filled button
- Outline: transparent with thin border
- Danger: dark red destructive action
- Ghost: low-priority navigation

## Cards

- Dark card background
- Thin border
- Rounded corners around 16 to 18px
- Keep spacing generous
- Avoid heavy glassmorphism and random glow

## Tables

- Tables must be wrapped in `.table-wrap`.
- Use status pills for statuses.
- Keep admin actions grouped and confirm destructive changes.

## Forms

- Inputs use dark backgrounds and thin borders.
- Focus state uses subtle orange outline.
- Validation errors are shown close to fields.

## Admin UI

- Use `admin-sidebar` for admin navigation.
- Dashboard stats appear as cards.
- Tables must not overflow outside the viewport.
- Avoid raw scaffold UI.

## Animation rules

- Keep animations subtle.
- Use hover lift only on major cards/buttons.
- Do not use distracting neon/cyberpunk effects.

## Avoid

- React/Inertia UI patterns
- Cyberpunk clutter
- Overdecorated gradients
- Heavy glassmorphism
- Dead buttons
- Placeholder-only pages
- Hercules branding
