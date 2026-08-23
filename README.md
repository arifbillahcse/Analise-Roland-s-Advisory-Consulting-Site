# Analise Roland — Strategic Advisory

Laravel 11 application serving the five marketing pages: home, services, case
studies, testimonials, contact.

This was a static five-file HTML site. The design, stylesheet, and JavaScript
are unchanged — what changed is that the shared chrome (head, nav, footer,
WhatsApp button) now lives in one Blade layout instead of being copy-pasted
into all five pages.

## Requirements

- PHP 8.2+ with `openssl`, `pdo_mysql`, `mbstring`, `tokenizer`, `xml`,
  `ctype`, `json`, `bcmath`, `curl`, `fileinfo`
- Composer 2

## Local setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

Then open http://localhost:8000.

No database is needed to run the site as it stands — every page is a static
Blade view. The `DB_*` values in `.env.example` are there for the lead-form
work described under "What is not done yet".

## Layout

```
routes/web.php                     five named routes, one per page
config/site.php                    phone, WhatsApp number, nav items
resources/views/
  layouts/app.blade.php            <head>, <body>, the shared skeleton
  partials/nav.blade.php           header, desktop nav, mobile drawer
  partials/footer.blade.php        footer nav, disclaimer, copyright
  partials/whatsapp.blade.php      floating WhatsApp button
  pages/*.blade.php                the five pages — body content only
public/css/styles.css              unchanged from the static site
public/js/script.js                unchanged from the static site
tests/Feature/PageTest.php         smoke tests: every page renders, 200s
```

### How a page supplies its own metadata

Each page view sets a few strings the layout yields:

```blade
@extends('layouts.app')

@section('title', 'Services — Analise Roland')
@section('description', '...')
@section('og_title', '...')
@section('og_description', '...')
@section('wa_text', 'Hi%20Analise%20...')   {{-- WhatsApp message prefill --}}
@section('legal_extra', '...')              {{-- optional extra disclaimer --}}

@section('content')
  ...
@endsection
```

`legal_extra` is optional — services, case studies, and testimonials each add
one sentence to the shared footer disclaimer; home and contact don't.

### Adding a page

1. Add the view under `resources/views/pages/`.
2. Add a route in `routes/web.php` with a name.
3. Add that route name and its label to `config/site.php`'s `nav` array.

The nav, the mobile drawer, and the footer all read that array, and the current
page is highlighted by `request()->routeIs()` — there is nothing per-page to
keep in sync.

### Changing the phone or WhatsApp number

`SITE_PHONE` and `SITE_WHATSAPP` in `.env`, or the defaults in
`config/site.php`. `SITE_WHATSAPP` is international format, digits only — no
`+`, spaces, or dashes (e.g. `+1 (415) 555-0142` → `14155550142`). It is still
the placeholder `15550000000` and must be set before launch.

Note that `tel:` links inside page bodies are still literal and were not
touched by this conversion; only the nav's "Book a Call" buttons read config.

## Configuration

Only `config/site.php` is committed. Laravel 11 merges its own defaults for
every config file an application omits, so there is nothing to maintain until
a default actually needs changing. To materialise one:

```bash
php artisan config:publish        # pick from a list
php artisan config:publish mail   # or name it
```

## Tests

```bash
php artisan test
```

Covers: each page returns 200 and carries its own `<title>`, each page includes
the shared chrome, the nav marks exactly the current page, and every route name
in `config/site.php` resolves. These are shallow by design — they catch a Blade
view that throws at render time, which is the failure this conversion makes
possible.

## What is not done yet

The conversion stopped at parity with the static site. Still outstanding, in
the order the architecture plan
(`Analise-Roland-Laravel-Server-Architecture-Plan.docx`) puts them:

- **Lead form backend.** Both the home and contact forms are still the original
  client-side demo: `script.js` calls `preventDefault()` and shows the success
  state without sending anything. Needs a `Lead` model, a migration, a
  `FormRequest`, a `LeadController`, queued notification + autoresponder mail,
  and rate limiting plus a honeypot on the route.
- **Database-backed content.** Testimonials, case studies, and pricing tiers
  are hard-coded in the views.
- **Filament admin** for the leads inbox and that content.
- **Gated pricing pages** via signed, expiring URLs.
- **Real contact details.** `hello@analiseroland.com`, `[City, State]`, the
  WhatsApp number, and the case-study copy are all still placeholders.

## Deployment

See `Analise-Roland-Laravel-Server-Architecture-Plan.docx` for the full CyberPanel
VPS plan. The one setting that matters most: point the site's document root at
`public/`, not the project root — otherwise `.env`, `app/`, and `storage/` are
served over HTTP.
