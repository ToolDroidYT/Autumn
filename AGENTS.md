# AGENTS.md

Rules for AI coding agents working on AUTUMN.

## Project identity

- Project: AUTUMN
- Full name: Automated Unified Merchandise Network
- Purpose: DCE merchandise ordering and batch management system for UM Tagum College

## Working rules

1. Inspect before editing.
2. Keep changes narrow, safe, and reviewable.
3. Do not refactor unrelated files.
4. Preserve Blade-first architecture.
5. Do not introduce React, Inertia, OTP, magic links, or external backend services.
6. Use reusable Blade components when adding UI.
7. Preserve the dark AUTUMN design tokens and component classes.
8. Avoid dead UI. Every visible action must work, navigate, submit, open a modal, print, update state, or show a disabled state.
9. Keep mobile responsiveness intact.
10. Do not invent unsupported business rules.
11. Update docs when setup, commands, routes, or behavior changes.

## Required verification

Run relevant checks after changes:

```bash
php artisan test
php artisan route:list
php artisan migrate:fresh --seed
npm run build
```

If a command cannot be run, state exactly why.

## Output expectation

Every agent response should include:

- Changed files
- What changed
- Verification commands and results
- Manual test checklist for affected pages
