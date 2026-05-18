# AUTUMN

**AUTUMN** means **Automated Unified Merchandise Network**.

It is a Laravel Blade merchandise ordering and batch management system for the Department of Computing Education at UM Tagum College.

## Stack

- Laravel
- Blade templates and reusable Blade components
- Vanilla JavaScript
- Clean committed CSS in `public/assets/autumn.css`
- SQLite by default
- MySQL-compatible migrations
- Laravel session authentication

No React, Inertia, OTP, magic links, email verification, or external backend service is used.

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Open:

```txt
http://127.0.0.1:8000
```

## Demo accounts

```txt
student@umindanao.edu.ph / password
admin@umindanao.edu.ph / password
superadmin@umindanao.edu.ph / password
```

## SQLite

SQLite is the default. `.env.example` uses:

```env
DB_CONNECTION=sqlite
```

Laravel will use `database/database.sqlite` unless `DB_DATABASE` is set.

## MySQL

Update `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=autumn
DB_USERNAME=root
DB_PASSWORD=
```

Then run:

```bash
php artisan migrate:fresh --seed
```

## Verification

```bash
php artisan test
php artisan route:list
php artisan migrate:fresh --seed
npm run build
```

`npm run build` is intentionally a no-op because CSS and JS are already committed in `public/assets`.

## Implemented features

- Public landing page matching the AUTUMN visual direction
- Product catalog and product detail pages
- Register/login restricted to `@umindanao.edu.ph`
- Program selection during registration
- Session cart
- Checkout and order creation
- Payment proof upload
- Order tracking
- Receipt page with print support
- Announcements
- FAQ accordion
- Admin dashboard
- Product, batch, order, payment, announcement, voting, and user role management
- Seeded demo data

## Known limitations

- Payment proof verification is admin-managed and does not connect to real payment APIs.
- QR receipt output is represented by a verification hash/code, not a generated image QR.
- Product image management uses seeded local SVG assets and a default placeholder for newly created products.
