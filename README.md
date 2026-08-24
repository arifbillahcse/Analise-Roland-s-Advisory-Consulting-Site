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
app/Models/{User,Lead,Testimonial,CaseStudy}.php
app/Http/Controllers/PageController.php         testimonials + case studies
app/Http/Controllers/LeadController.php
app/Http/Requests/StoreLeadRequest.php
app/Mail/{NewLeadReceived,LeadAutoresponder}.php
app/Providers/Filament/AdminPanelProvider.php   registers the /admin panel
app/Filament/Resources/
  LeadResource.php                the leads inbox UI
  TestimonialResource.php         carousel + quote grid content
  CaseStudyResource.php           the case studies grid content
database/migrations/                users, leads, testimonials, case_studies
database/seeders/
  AdminUserSeeder.php              creates the one admin login
  TestimonialSeeder.php           sample carousel + grid quotes
  CaseStudySeeder.php             sample case study cards
tests/Feature/PageTest.php              smoke tests: every page renders, 200s
tests/Feature/LeadSubmissionTest.php    lead form: happy path, validation,
                                         honeypot, rate limiting
tests/Feature/ContentPagesTest.php      testimonials/case studies render
                                         from the database, empty states 200
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
seeded (see "Local setup"). Three resources:

- **Leads** — every contact-form submission, newest first, filterable by
  status and source page. Opening one lets you move it from New →
  Contacted → Archived; nothing else on it is editable, since it's a record
  of what the person submitted.
- **Testimonials** — the quotes on the testimonials page. The "Show in the
  featured carousel" toggle decides whether one appears at the top of the
  page (as a large slide) or in the quote grid below. Rows are
  drag-to-reorder in the table, which controls the order they render in.
- **Case Studies** — the cards on the case studies page, with the category
  that drives the filter buttons (Advisory Retainer / Custom Project /
  Institutional), and are likewise drag-to-reorder.

To change the admin password later, update `ADMIN_PASSWORD` in `.env` and
re-run `php artisan db:seed` — the seeder updates the existing account rather
than creating a second one. That same command seeds a starter set of sample
testimonials and case studies the first time it runs (skipped on later runs
if either table already has rows), so the pages aren't empty before the
client has added real content. Both pages still carry a "Sample content —
replace before launch" banner in the markup; that's a static reminder, not
something the seeder or admin panel toggles off — remove it by hand once
real content is in.

Pricing (the `services` page) is intentionally **not** database-backed. It's
two fixed offerings (Advisory Retainer, Custom Project) described in full
prose — panels, a terms list, a comparison table — not a repeatable card
that a "pricing tier" model would meaningfully represent. Changing the
wording or the `$20,000 base` figure is a copy edit to
`resources/views/pages/services.blade.php`.

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

`tests/Feature/ContentPagesTest.php` covers: a featured testimonial renders
in the carousel and a non-featured one in the grid, both pages still return
200 with zero rows in their table, and a case study's category drives both
its `data-cat` filter attribute and its tag styling.

These use an in-memory SQLite database (`phpunit.xml` sets `DB_CONNECTION`),
so they don't touch whatever's in `.env` — but your PHP build needs the
`pdo_sqlite` extension enabled for that to work.

## What is not done yet

Phases 1 (admin panel + auth), 2 (lead form backend), and 3 (database-backed
testimonials and case studies) from the architecture plan
(`Analise-Roland-Laravel-Server-Architecture-Plan.docx`) are done. Still
outstanding:

- **Gated pricing pages** via signed, expiring URLs.
- **Real contact details.** `hello@analiseroland.com`, `[City, State]`, the
  WhatsApp number, and the case-study copy are all still placeholders.

## Deployment

See `Analise-Roland-Laravel-Server-Architecture-Plan.docx` for the full CyberPanel
VPS plan. The one setting that matters most: point the site's document root at
`public/`, not the project root — otherwise `.env`, `app/`, and `storage/` are
served over HTTP.
