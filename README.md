# Analise Roland — Strategic Advisory

Laravel 11 application serving the five marketing pages: home, services, case
studies, testimonials, contact.

This was a static five-file HTML site. The design, stylesheet, and JavaScript
are unchanged — what changed is that the shared chrome (head, nav, footer,
WhatsApp button) now lives in one Blade layout instead of being copy-pasted
into all five pages.

## Requirements

- PHP 8.2+ with `openssl`, `pdo_mysql`, `mbstring`, `tokenizer`, `xml`,
  `ctype`, `json`, `bcmath`, `curl`, `fileinfo` (add `pdo_sqlite` too if you
  want to run the test suite as-is — see "Tests")
- Composer 2
- A MySQL (or MariaDB) database — the admin panel and the lead form both
  need one now

## Local setup

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Create a database and point `DB_*` in `.env` at it, then:

```bash
php artisan migrate
```

Set `ADMIN_EMAIL` and `ADMIN_PASSWORD` in `.env` to whatever the client should
log in with, then seed that account:

```bash
php artisan db:seed
```

```bash
php artisan serve
```

Open http://localhost:8000 for the site, http://localhost:8000/admin for the
admin panel.

## Layout

```
routes/web.php                     five page routes + POST /leads
config/site.php                    phone, WhatsApp, admin email, nav items
resources/views/
  layouts/app.blade.php            <head>, <body>, the shared skeleton
  partials/nav.blade.php           header, desktop nav, mobile drawer
  partials/footer.blade.php        footer nav, disclaimer, copyright
  partials/whatsapp.blade.php      floating WhatsApp button
  pages/*.blade.php                the five pages — body content only
  emails/leads/*.blade.php         admin notification + lead autoresponder
public/css/styles.css              unchanged from the static site, +1 rule
public/js/script.js                lead form now posts to the server for real
app/Models/{User,Lead}.php
app/Http/Controllers/LeadController.php
app/Http/Requests/StoreLeadRequest.php
app/Mail/{NewLeadReceived,LeadAutoresponder}.php
app/Providers/Filament/AdminPanelProvider.php   registers the /admin panel
app/Filament/Resources/LeadResource.php         the leads inbox UI
database/migrations/                            users, leads
database/seeders/AdminUserSeeder.php            creates the one admin login
tests/Feature/PageTest.php              smoke tests: every page renders, 200s
tests/Feature/LeadSubmissionTest.php    lead form: happy path, validation,
                                         honeypot, rate limiting
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

## Admin panel

Filament, at `/admin`. Log in with the `ADMIN_EMAIL` / `ADMIN_PASSWORD` you
seeded (see "Local setup"). Right now it has one resource: **Leads** — every
contact-form submission, newest first, filterable by status and source page.
Opening a lead lets you move it from New → Contacted → Archived; nothing else
on it is editable, since it's a record of what the person submitted.

To change the admin password later, update `ADMIN_PASSWORD` in `.env` and
re-run `php artisan db:seed` — the seeder updates the existing account rather
than creating a second one.

## Lead form

Both the home and contact forms post to `POST /leads`
(`app/Http/Controllers/LeadController.php`). What happens on submit:

1. `StoreLeadRequest` validates name, email, and project details are present.
2. A hidden `website` field acts as a honeypot — humans never see it, so
   anything that fills it is treated as a bot and gets a fake success
   response without touching the database.
3. On success, a `Lead` row is saved, and two queued emails go out: one to
   `SITE_ADMIN_EMAIL` with the submission, one to the sender confirming it
   arrived (`app/Mail/NewLeadReceived.php`, `app/Mail/LeadAutoresponder.php`).
4. The route is rate-limited to 5 submissions per hour per IP
   (`RateLimiter::for('leads', ...)` in `AppServiceProvider`).

The frontend (`public/js/script.js`) submits via `fetch`, keeping the same
success animation as before; if JavaScript fails to load, the form still
works as a plain HTML POST with a full-page redirect back.

With `MAIL_MAILER=log` (the `.env.example` default), queued mail is written
to `storage/logs/laravel.log` instead of actually sending — good enough for
local testing. Point `MAIL_MAILER` at `smtp` and fill in `MAIL_HOST` etc. to
send for real.

## Tests

```bash
php artisan test
```

`tests/Feature/PageTest.php` covers: each page returns 200 and carries its
own `<title>`, each page includes the shared chrome, the nav marks exactly
the current page, and every route name in `config/site.php` resolves.

`tests/Feature/LeadSubmissionTest.php` covers: a valid submission creates a
`Lead` and queues both emails, an AJAX submission gets a JSON response, a
submission with missing fields is rejected with 422s, the honeypot silently
drops the submission without saving it or sending mail, and a sixth
submission within an hour from the same IP is throttled.

These use an in-memory SQLite database (`phpunit.xml` sets `DB_CONNECTION`),
so they don't touch whatever's in `.env` — but your PHP build needs the
`pdo_sqlite` extension enabled for that to work.

## What is not done yet

Phases 1 (admin panel + auth) and 2 (lead form backend, above) from the
architecture plan (`Analise-Roland-Laravel-Server-Architecture-Plan.docx`)
are done. Still outstanding:

- **Database-backed content.** Testimonials, case studies, and pricing tiers
  are still hard-coded in the views — the admin panel can't edit them yet.
- **Gated pricing pages** via signed, expiring URLs.
- **Real contact details.** `hello@analiseroland.com`, `[City, State]`, the
  WhatsApp number, and the case-study copy are all still placeholders.

## Deployment

See `Analise-Roland-Laravel-Server-Architecture-Plan.docx` for the full CyberPanel
VPS plan. The one setting that matters most: point the site's document root at
`public/`, not the project root — otherwise `.env`, `app/`, and `storage/` are
served over HTTP.
