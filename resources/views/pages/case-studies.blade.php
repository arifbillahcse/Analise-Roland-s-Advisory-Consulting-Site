@extends('layouts.app')

@section('title', 'Case Studies — Analise Roland')
@section('description', 'Selected engagements from Analise Roland\'s advisory and project work with founders, funds, and institutional allocators.')
@section('og_title', 'Case Studies — Analise Roland')
@section('og_description', 'Selected engagements — what the problem was, what the work involved, and what it changed.')
@section('wa_text', 'Hi%20Analise%20%E2%80%94%20I%20was%20reading%20your%20case%20studies%20and%20I%27d%20like%20to%20talk%20about%20an%20engagement.')
@section('legal_extra', 'Case studies describe past engagements and are not a promise or prediction of future results.')

@section('content')

  <!-- ================= PAGE HERO ================= -->
  <section class="page-hero">
    <div class="page-hero__mesh" aria-hidden="true"></div>
    <div class="wrap page-hero__inner">
      <p class="eyebrow hero__eyebrow">
        <span class="eyebrow__rule" aria-hidden="true"></span>
        Case Studies
      </p>
      <h1 class="page-hero__title hero__title">
        <span class="line"><span>The problem, the work,</span></span>
        <span class="line"><span><em>and what it changed.</em></span></span>
      </h1>
      <p class="page-hero__lede hero__lede">
        Strategy is easy to claim and hard to evidence. These are engagements described the way
        Analise would describe them on a call — what was actually stuck, what she did about it, and
        what the business could do afterwards that it couldn't before.
      </p>
    </div>
  </section>

  <!-- ================= CASE GRID ================= -->
  <section class="cases">
    <div class="wrap">

      <!-- ============================================================
           SAMPLE CONTENT NOTICE — DELETE THIS WHOLE BLOCK BEFORE LAUNCH
           along with replacing the case studies below with real ones.
           ============================================================ -->
      <aside class="sample-notice reveal">
        <svg class="sample-notice__icon" viewBox="0 0 24 24" aria-hidden="true">
          <circle cx="12" cy="12" r="9" />
          <path d="M12 8v5" />
          <path d="M12 16.5v.01" />
        </svg>
        <p>
          <strong>Sample content.</strong> The engagements below are illustrative examples written
          to demonstrate structure, tone, and length — not real client work. Replace them with
          Analise's actual case studies before launch.
        </p>
      </aside>


      <div class="filters reveal" role="group" aria-label="Filter case studies by engagement type">
        <button class="filter is-active" type="button" data-filter="all" aria-pressed="true">
          <span>All</span>
          <span class="filter__count">6</span>
        </button>
        <button class="filter" type="button" data-filter="advisory" aria-pressed="false">
          <span>Advisory Retainer</span>
          <span class="filter__count">2</span>
        </button>
        <button class="filter" type="button" data-filter="project" aria-pressed="false">
          <span>Custom Project</span>
          <span class="filter__count">2</span>
        </button>
        <button class="filter" type="button" data-filter="institutional" aria-pressed="false">
          <span>Institutional</span>
          <span class="filter__count">2</span>
        </button>
      </div>

      <div class="cases__grid" id="caseGrid">

        <article class="case-card reveal" data-cat="advisory" data-delay="0">
          <div class="case-card__top">
            <span class="case-card__index">01</span>
            <span class="tag tag--advisory">Advisory Retainer</span>
          </div>
          <p class="case-card__sector">Consumer fintech · Seed to Series A</p>
          <h2 class="case-card__title"><a class="case-card__link" href="#">From feature set to category position</a></h2>
          <p class="case-card__metric"><span class="case-card__metric-val">&minus;38%</span><span class="case-card__metric-lab">Average sales cycle</span></p>
          <p class="case-card__outcome">Rebuilt the company&rsquo;s positioning around a category it could credibly own, and gave the whole team one sentence they could all say the same way.</p>
          <div class="case-card__foot">
            <span class="case-card__meta">2025 · 9 months</span>
            <span class="case-card__read" aria-hidden="true">
              <span>Read</span>
              <svg class="arrow" viewBox="0 0 20 12"><path d="M0 6h17M12 1l5 5-5 5" /></svg>
            </span>
          </div>
        </article>

        <article class="case-card reveal" data-cat="project" data-delay="90">
          <div class="case-card__top">
            <span class="case-card__index">02</span>
            <span class="tag tag--project">Custom Project</span>
          </div>
          <p class="case-card__sector">Real estate development · Ground-up mixed use</p>
          <h2 class="case-card__title"><a class="case-card__link" href="#">A development team, hired in eleven weeks</a></h2>
          <p class="case-card__metric"><span class="case-card__metric-val">On time</span><span class="case-card__metric-lab">Broke ground</span></p>
          <p class="case-card__outcome">Defined five roles, ran the search end to end, and handed over a team that broke ground on schedule.</p>
          <div class="case-card__foot">
            <span class="case-card__meta">2025 · 11 weeks</span>
            <span class="case-card__read" aria-hidden="true">
              <span>Read</span>
              <svg class="arrow" viewBox="0 0 20 12"><path d="M0 6h17M12 1l5 5-5 5" /></svg>
            </span>
          </div>
        </article>

        <article class="case-card reveal" data-cat="institutional" data-delay="180">
          <div class="case-card__top">
            <span class="case-card__index">03</span>
            <span class="tag tag--institutional">Institutional</span>
          </div>
          <p class="case-card__sector">University endowment · Venture allocation</p>
          <h2 class="case-card__title"><a class="case-card__link" href="#">A venture allocation the committee could defend</a></h2>
          <p class="case-card__metric"><span class="case-card__metric-val">Unanimous</span><span class="case-card__metric-lab">Committee approval</span></p>
          <p class="case-card__outcome">Turned an informal manager shortlist into a written selection framework the investment committee approved unanimously.</p>
          <div class="case-card__foot">
            <span class="case-card__meta">2024 · 6 months</span>
            <span class="case-card__read" aria-hidden="true">
              <span>Read</span>
              <svg class="arrow" viewBox="0 0 20 12"><path d="M0 6h17M12 1l5 5-5 5" /></svg>
            </span>
          </div>
        </article>

        <article class="case-card reveal" data-cat="advisory" data-delay="0">
          <div class="case-card__top">
            <span class="case-card__index">04</span>
            <span class="tag tag--advisory">Advisory Retainer</span>
          </div>
          <p class="case-card__sector">Climate hardware · Series A</p>
          <h2 class="case-card__title"><a class="case-card__link" href="#">A roadmap that matched the capital plan</a></h2>
          <p class="case-card__metric"><span class="case-card__metric-val">Zero</span><span class="case-card__metric-lab">Missed dates since</span></p>
          <p class="case-card__outcome">Cut the product roadmap down to what eighteen months of runway could actually ship — and the team stopped missing dates.</p>
          <div class="case-card__foot">
            <span class="case-card__meta">2024–2025 · 12 months</span>
            <span class="case-card__read" aria-hidden="true">
              <span>Read</span>
              <svg class="arrow" viewBox="0 0 20 12"><path d="M0 6h17M12 1l5 5-5 5" /></svg>
            </span>
          </div>
        </article>

        <article class="case-card reveal" data-cat="project" data-delay="90">
          <div class="case-card__top">
            <span class="case-card__index">05</span>
            <span class="tag tag--project">Custom Project</span>
          </div>
          <p class="case-card__sector">DTC wellness · Retail expansion</p>
          <h2 class="case-card__title"><a class="case-card__link" href="#">Into retail without losing the brand</a></h2>
          <p class="case-card__metric"><span class="case-card__metric-val">3 chains</span><span class="case-card__metric-lab">National retail</span></p>
          <p class="case-card__outcome">Built the wholesale playbook and packaging strategy that took the brand into national retail on its own terms.</p>
          <div class="case-card__foot">
            <span class="case-card__meta">2024 · 4 months</span>
            <span class="case-card__read" aria-hidden="true">
              <span>Read</span>
              <svg class="arrow" viewBox="0 0 20 12"><path d="M0 6h17M12 1l5 5-5 5" /></svg>
            </span>
          </div>
        </article>

        <article class="case-card reveal" data-cat="institutional" data-delay="180">
          <div class="case-card__top">
            <span class="case-card__index">06</span>
            <span class="tag tag--institutional">Institutional</span>
          </div>
          <p class="case-card__sector">Single-family office · First venture program</p>
          <h2 class="case-card__title"><a class="case-card__link" href="#">Standing up a first venture program</a></h2>
          <p class="case-card__metric"><span class="case-card__metric-val">First 6</span><span class="case-card__metric-lab">Direct investments</span></p>
          <p class="case-card__outcome">Designed the diligence process, pacing model, and reporting cadence for a family office making its first direct investments.</p>
          <div class="case-card__foot">
            <span class="case-card__meta">2023–2024 · 8 months</span>
            <span class="case-card__read" aria-hidden="true">
              <span>Read</span>
              <svg class="arrow" viewBox="0 0 20 12"><path d="M0 6h17M12 1l5 5-5 5" /></svg>
            </span>
          </div>
        </article>

      </div>

      <p class="cases__empty" id="casesEmpty" hidden>No case studies in this category yet.</p>
    </div>
  </section>

  <!-- ================= ANATOMY / TEMPLATE ================= -->
  <section class="anatomy">
    <div class="wrap">
      <header class="section-head reveal">
        <p class="eyebrow">
          <span class="eyebrow__rule" aria-hidden="true"></span>
          What a Full Case Study Looks Like
        </p>
        <h2 class="section-title">The shape each write-up follows.</h2>
        <p class="anatomy__lede">
          Every case study on this page opens out into this format. One filled in properly is worth
          more than ten client names in a logo row — the detail is what makes it credible.
        </p>
      </header>

      <article class="study reveal">

        <div class="study__head">
          <span class="tag tag--advisory">Advisory Retainer</span>
          <h3 class="study__title">From feature set to category position</h3>
        </div>

        <dl class="study__meta">
          <div><dt>Client</dt><dd>A Seed-stage consumer fintech</dd></div>
          <div><dt>Sector</dt><dd>Consumer fintech</dd></div>
          <div><dt>Engagement</dt><dd>Advisory retainer</dd></div>
          <div><dt>Duration</dt><dd>9 months, 2025</dd></div>
        </dl>

        <div class="study__arc">
          <span class="study__line" aria-hidden="true"></span>
          <ol class="study__steps">
            <li class="study__step">
              <span class="study__num">01</span>
              <h4>The situation</h4>
              <p>The product worked and early users liked it, but every conversation started from
                 scratch. The team described themselves five different ways depending on who was in
                 the room, and the deck listed eleven features with no through-line. Growth had been
                 flat for two quarters and nobody could agree on why.</p>
            </li>
            <li class="study__step">
              <span class="study__num">02</span>
              <h4>The work</h4>
              <p>Weekly sessions pulling apart what the product actually did for people versus what
                 the team assumed it did. Twelve interviews with their most engaged users surfaced
                 the job it was really being hired for. From there: a single category claim, a
                 rebuilt narrative, and a roadmap cut down to the three things that claim required.
                 Analise sat in on the first four sales calls using the new framing, then rewrote it
                 twice more.</p>
            </li>
            <li class="study__step">
              <span class="study__num">03</span>
              <h4>What changed</h4>
              <p>The company now leads with one sentence its whole team says the same way. Two
                 features that had absorbed a quarter of engineering time were cut outright. Sales
                 conversations got shorter, and positioning stopped being re-litigated in every
                 meeting.</p>
            </li>
          </ol>
        </div>

        <div class="study__metrics">
          <div class="metric">
            <span class="metric__value">11&thinsp;&rarr;&thinsp;3</span>
            <span class="metric__label">Roadmap priorities</span>
          </div>
          <div class="metric">
            <span class="metric__value">&minus;38%</span>
            <span class="metric__label">Average sales cycle</span>
          </div>
          <div class="metric">
            <span class="metric__value">12</span>
            <span class="metric__label">User interviews behind it</span>
          </div>
        </div>

        <blockquote class="study__quote">
          <svg class="quote" viewBox="0 0 44 32" aria-hidden="true">
            <path class="draw" pathLength="1" d="M18 2C8 5 3 12 3 22v8h15V16H10c0-6 3-10 9-12z" />
            <path class="draw draw--d2" pathLength="1" d="M41 2c-10 3-15 10-15 20v8h15V16h-8c0-6 3-10 9-12z" />
          </svg>
          <p>She made us say the hard thing out loud, then made us say it in one sentence. Six months
             later that sentence is our homepage.</p>
          <footer>Founder &amp; CEO &mdash; consumer fintech client</footer>
        </blockquote>

      </article>
    </div>
  </section>

  <!-- ================= CONFIDENTIALITY ================= -->
  <section class="confidential reveal">
    <div class="wrap confidential__inner">
      <svg class="confidential__icon" viewBox="0 0 48 48" aria-hidden="true">
        <path class="draw" pathLength="1" d="M24 6l14 6v12c0 8-6 14-14 18-8-4-14-10-14-18V12z" />
        <path class="draw draw--d2" pathLength="1" d="M17 24l5 5 10-11" />
      </svg>
      <div class="confidential__copy">
        <h2 class="confidential__title">Some of this work can't be named.</h2>
        <p class="confidential__body">
          A share of Analise's engagements — particularly the institutional ones — sit under
          confidentiality. Those appear here anonymized, described by sector and stage rather than by
          client. Where a prospective client needs the specifics, she shares them directly under a
          private link.
        </p>
        <a class="link-arrow" href="{{ route('contact') }}#book">
          <span>Request the confidential portfolio</span>
          <svg class="arrow" viewBox="0 0 20 12" aria-hidden="true"><path d="M0 6h17M12 1l5 5-5 5" /></svg>
        </a>
      </div>
    </div>
  </section>

  <!-- ================= CTA BAND ================= -->
  <section class="cta-band reveal">
    <span class="approach__wipe" aria-hidden="true"></span>
    <div class="wrap cta-band__inner">
      <h2 class="cta-band__title">Recognise your own situation in one of these?</h2>
      <p class="cta-band__body">
        That's usually the best reason to book the call. Thirty minutes, no deck required — you
        describe where you're stuck, and she tells you honestly whether she's the right person for it.
      </p>
      <div class="cta-band__actions">
        <a class="btn btn--solid btn--light" href="tel:+8801779440297">
          <span>Book a strategy call</span>
          <svg class="arrow" viewBox="0 0 20 12" aria-hidden="true">
            <path d="M0 6h17M12 1l5 5-5 5" />
          </svg>
        </a>
        <a class="btn btn--ghost btn--ghost-light" href="{{ route('services') }}">
          <span>See how engagements work</span>
        </a>
      </div>
    </div>
  </section>

@endsection
