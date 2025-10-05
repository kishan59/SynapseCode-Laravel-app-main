# SynapseCode — Laravel

SynapseCode is a personal code snippet manager originally implemented as a Flask app and now ported to Laravel. It helps you save, search, and organize code snippets (title, code, language, description, notes, source URL, and tags) in a lightweight, dark-themed web UI.

Repository: https://github.com/kishan59/SynapseCode-Laravel-app-main

## Quick demo

No public demo is published for the Laravel port at the moment. If you want me to deploy this repository (for example to Render, Heroku, or another host) I can prepare a deployment guide or create a deployment for you.

## Key features

- Secure user accounts (register, login, logout).
- Full CRUD for snippets (add, view in a modal, edit, delete).
- Organic keyword search across title, description, code, notes, and tags.
- Optional language filter and paginated listing.
- Syntax highlighting via Prism.js and copy-to-clipboard support.
- Responsive UI built with Bootstrap 5 and a consistent dark theme.

## Requirements

- PHP 8.0+ (match your project's composer.json requirement).
- Composer
- SQLite (used in this repository by default) or another DB supported by Laravel
- Node.js & npm (for front-end assets, optional if you only use the prebuilt `public/` assets)

## Local setup (development)

1. Clone the repository (if you haven't already):

```powershell
git clone https://github.com/kishan59/SynapseCode-Laravel-app-main.git
cd SynapseCode-Laravel-app-main
```

2. Install PHP dependencies:

```powershell
composer install
```

3. Copy the example env and generate an app key:

```powershell
copy .env.example .env
php artisan key:generate
```

4. (Optional) If you're using SQLite (recommended for quick local setup):

```powershell
# make sure database path exists
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
php artisan migrate
```

If you prefer MySQL/Postgres, update `.env` database settings and run `php artisan migrate`.

5. Install frontend deps and build assets (optional if using `public/` assets already present):

```powershell
npm install
npm run build
```

6. Run the app locally:

```powershell
php artisan serve
```

Open http://127.0.0.1:8000 and register a new user.

## Project layout (Laravel specific)

- `app/` — Controllers, Models, and Providers (authentication and snippet logic live here).
- `resources/views/` — Blade templates (index, layout, auth, snippets views like `my_snippets.blade.php`).
- `public/` — Compiled CSS/JS and static assets (Prism.js, main.js, etc.).
- `routes/web.php` — Web routes for snippets, auth, and home.
- `database/` — Migrations and seeders. This repo includes a `database.sqlite` for convenience.
- `config/` — Laravel configuration files.

## How this port differs from the Flask original

- Uses Laravel's authentication and middleware for route protection.
- Controllers are implemented as standard Laravel controllers (`app/Http/Controllers`).
- Blade templates replace Flask/Jinja templates — layout and modal behavior are preserved where possible.
- The AJAX modal JSON endpoints and delete handlers are implemented to match Laravel routing and CSRF protection.

## Running tests

This project includes a basic PHPUnit test scaffold. Run tests with:

```powershell
php artisan test
# or
vendor/bin/phpunit
```

## Design choices & rationale

- Laravel was chosen for this port to leverage its powerful routing, Eloquent ORM, and built-in authentication scaffolding.
- Bootstrap 5 provides responsive layout and quick UI iteration.
- Prism.js is used for client-side syntax highlighting and copy-to-clipboard convenience.
- The search is intentionally "organic" — a single input that searches multiple fields with AND logic for natural keyword queries.

## Security notes

- Don't commit `.env` or any secrets to the repository. Use environment variables in production.
- Ensure `APP_KEY` is set in `.env` and keep your production database credentials secure.

## Acknowledgements

Thanks to the open-source tools used in this project:

- Laravel
- Bootstrap 5
- Prism.js
- Composer and NPM