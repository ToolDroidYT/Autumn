# AUTUMN Agent Rules

AUTUMN is a Laravel Blade project for the Automated Unified Merchandise Network.

## Workflow

1. Inspect existing files before editing.
2. Keep patches small and directly related to the requested task.
3. Do not rewrite business logic unless the UI task strictly requires it.
4. Preserve Laravel Blade, reusable components, Tailwind-style utility structure, and vanilla JavaScript.
5. Do not introduce React, Vue, Inertia, external auth, OTP, email verification, or magic links.
6. Do not invent unsupported product behavior.
7. Run verification commands after edits where the environment supports them.
8. Report changed files and verification results.

## Design Rules

- Use `public/assets/autumn.css` tokens.
- Headings: Sora.
- Body: Inter.
- UI, labels, buttons, navigation: Lexend Deca.
- Use `<x-icon name="..." />` for all icons.
- Use reusable components instead of duplicating button/card/table/header markup.
- Keep status and metadata treatments minimal. Avoid loud chips.
- Keep the header compact. Do not add awkward spacing inside the AUTUMN wordmark.
- Mobile navigation must not duplicate desktop navigation visually.
- Keep animations subtle and respect reduced motion.

## Verification

Preferred checks:

```bash
php artisan view:clear
php artisan route:list
npm run build
```

If Composer/vendor dependencies are unavailable, run what is possible and state the limitation.
