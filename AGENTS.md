# AGENTS.md

## Stack and layout

- Laravel 13 / PHP 8.3 / Livewire 4 + Flux UI / Tailwind v4 + Vite. Default DB is SQLite (`database/database.sqlite`); tests use in-memory SQLite.
- Public storefront: store routes in `routes/web.php` -> `TiendaController` -> `app/Livewire/Tienda/*` + `resources/views/tienda/*`, using `layouts/tienda`.
- Authenticated admin/POS: `dashboard` and resource routes -> Livewire `app/Livewire/<Domain>/Index` + `resources/views/livewire/<domain>/*`, using `layouts/app` (Flux sidebar). Auth is Fortify; account/settings routes are in `routes/settings.php`.
- UI and domain copy are Spanish. `APP_NAME` defaults to `KodeTech`; `WHATSAPP_NUMBER` drives the checkout redirect.
- `public/build` is gitignored. Run `npm run build` after pulling asset changes or when Vite manifest errors appear.

## Commands

- First setup: `composer setup` (composer install, `.env`, key, migrate, npm install/build).
- Dev server: `composer dev` (runs `artisan serve`, queue listener, and Vite together). Frontend only: `npm run dev`.
- Full verification: `composer test` = config clear -> Pint check -> PHPStan level 7 -> Pest. Run this before finishing.
- Format PHP: `composer lint`. Checks only: `composer lint:check`, `composer types:check`.
- Single test: `php artisan test tests/Feature/Tienda/TiendaTest.php` or `php artisan test --filter="contact page"`.
- Feature tests use `RefreshDatabase`; Unit tests do not.

## Conventions

- Admin CRUD follows: controller handles HTTP and calls `app/Services/<Domain>/<Domain>Service`; validation lives in `app/Http/Requests/<Domain>/...`; searchable lists live in Livewire `Index` components. Keep new CRUD in this shape.
- Models own constants (`PAGINATION`, `Venta::ESTADO_*` / `METODO_*`, `Pedido::ESTADO_*`). Reuse them instead of hardcoding status or payment strings.
- Products use boolean `activo`; categories use `estado` = `activo|inactivo`. Do not mix the two.
- Cart state is session-backed (`CarritoService`, key `carrito`). Checkout creates a pending `Pedido` and redirects to WhatsApp; it must not change stock. Stock changes only in `VentaService::store()` (decrement) and `VentaService::anular()` (restore). Confirming a pending order links it to the created sale via `PedidoService::confirmar`.
- Theme tokens and utilities are in `resources/css/app.css` (`bg-bg`, `text-text-primary`, `ui-card`, `ui-btn-*`). Use those and Flux components instead of the default Tailwind palette.
- Only `UserFactory` exists. Tests create `Producto`, `Cliente`, `Pedido`, and `Venta` directly with `Model::create([...])`.
- Feature tests assert exact Spanish copy. Update the matching test whenever visible text changes.

## Known baseline

- If `TiendaTest` contact page is the only failure on `Contactanos` vs `Contáctanos`, it is a known pre-existing accent mismatch, not a regression from your change.

## Local instruction sources

- `.github/skills/impeccable/SKILL.md` and `.github/agents/*` (gitignored) contain the repo-local UI/design workflow. Read them before large visual redesigns.
