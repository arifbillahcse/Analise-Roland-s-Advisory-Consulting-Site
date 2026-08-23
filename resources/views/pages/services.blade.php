@extends('layouts.app')

@section('title', 'Services — Analise Roland')
@section('description', 'Two ways to work with Analise Roland: a six-month advisory retainer starting at $20,000, or a scoped custom project. Terms are built to your stage.')
@section('og_title', 'Services — Analise Roland')
@section('og_description', 'An advisory retainer or a scoped project. Two ways to bring Analise onto your team.')
@section('wa_text', 'Hi%20Analise%20%E2%80%94%20I%20was%20reading%20your%20services%20page%20and%20I%27d%20like%20to%20talk%20about%20an%20engagement.')
@section('legal_extra', 'Figures shown are indicative starting points; final terms are set in a written engagement agreement.')

@section('content')

  <!-- ================= PAGE HERO ================= -->
  <section class="page-hero">
    <div class="page-hero__mesh" aria-hidden="true"></div>
    <div class="wrap page-hero__inner">
      <p class="eyebrow hero__eyebrow">
        <span class="eyebrow__rule" aria-hidden="true"></span>
        Services
      </p>
      <h1 class="page-hero__title hero__title">
        <span class="line"><span>Two ways to work together.</span></span>
        <span class="line"><span><em>Both built around your stage.</em></span></span>
      </h1>
      <p class="page-hero__lede hero__lede">
        Analise doesn't sell packages. She takes a small number of clients, goes deep, and
        structures the terms around what the business can actually carry right now — cash, equity,
        or a blend of the two.
      </p>
    </div>
  </section>

  <!-- ================= SERVICE 01 — RETAINER ================= -->
  <section class="service" id="retainer">
    <div class="wrap">
      <div class="service__head reveal">
        <span class="service__index">01</span>
        <div class="service__headtext">
          <p class="eyebrow">
            <span class="eyebrow__rule" aria-hidden="true"></span>
            Advisory Retainer
          </p>
          <h2 class="service__title">A strategic partner on your side of the table, every week.</h2>
          <p class="service__lede">
            The closest thing to having a co-founder who has already done it — without giving up a
            co-founder's share. She works across strategy, brand, and product development, and stays
            close enough to the business to catch problems while they're still small.
          </p>
        </div>
      </div>

      <div class="service__body">

        <div class="panel reveal">
          <h3 class="panel__title">What's included</h3>
          <ul class="ticks">
            <li>
              <svg class="tick" viewBox="0 0 16 16" aria-hidden="true"><path class="draw" pathLength="1" d="M3 8.5L6.5 12L13 4.5" /></svg>
              <span><strong>Weekly one-hour strategy calls</strong> — a standing slot, not ad-hoc availability</span>
            </li>
            <li>
              <svg class="tick" viewBox="0 0 16 16" aria-hidden="true"><path class="draw" pathLength="1" d="M3 8.5L6.5 12L13 4.5" /></svg>
              <span><strong>72-hour response time</strong> between calls, for the questions that can't wait a week</span>
            </li>
            <li>
              <svg class="tick" viewBox="0 0 16 16" aria-hidden="true"><path class="draw" pathLength="1" d="M3 8.5L6.5 12L13 4.5" /></svg>
              <span><strong>Direct access to her network</strong> — operators, specialists, and institutional contacts, introduced when they're genuinely the right person</span>
            </li>
            <li>
              <svg class="tick" viewBox="0 0 16 16" aria-hidden="true"><path class="draw" pathLength="1" d="M3 8.5L6.5 12L13 4.5" /></svg>
              <span><strong>Strategy and positioning</strong> — where the business is going and how it's understood</span>
            </li>
            <li>
              <svg class="tick" viewBox="0 0 16 16" aria-hidden="true"><path class="draw" pathLength="1" d="M3 8.5L6.5 12L13 4.5" /></svg>
              <span><strong>Brand and product development</strong> — the work that turns a plan into something people recognise and use</span>
            </li>
          </ul>
        </div>

        <div class="panel panel--alt reveal" data-delay="120">
          <h3 class="panel__title">Who it's for</h3>
          <p class="panel__body">
            Founders and teams who don't need another consultant producing a deck — they need
            someone who will hold the whole picture with them week after week, and who has enough
            operating history to say "don't do that" and be right.
          </p>
          <p class="panel__body">
            It works best when it starts early enough to shape decisions, rather than to clean up
            after them.
          </p>
        </div>

      </div>

      <dl class="terms reveal">
        <div class="terms__item">
          <dt>Commitment</dt>
          <dd>Six months minimum</dd>
        </div>
        <div class="terms__item">
          <dt>Starting at</dt>
          <dd>$20,000 base</dd>
        </div>
        <div class="terms__item">
          <dt>Structure</dt>
          <dd>Cash, equity, or blended</dd>
        </div>
        <div class="terms__item">
          <dt>Availability</dt>
          <dd>Four clients at a time</dd>
        </div>
      </dl>

      <div class="service__cta reveal">
        <a class="btn btn--solid" href="{{ route('contact') }}#book">
          <span>Discuss a retainer</span>
          <svg class="arrow" viewBox="0 0 20 12" aria-hidden="true">
            <path d="M0 6h17M12 1l5 5-5 5" />
          </svg>
        </a>
        <p class="service__cta-note">The base figure is a starting point for the conversation, not a fixed rate.</p>
      </div>
    </div>
  </section>

  <!-- ================= SERVICE 02 — PROJECT ================= -->
  <section class="service service--alt" id="project">
    <div class="wrap">
      <div class="service__head reveal">
        <span class="service__index">02</span>
        <div class="service__headtext">
          <p class="eyebrow">
            <span class="eyebrow__rule" aria-hidden="true"></span>
            Custom Project Work
          </p>
          <h2 class="service__title">One defined problem, taken all the way to done.</h2>
          <p class="service__lede">
            When the need is specific and bounded — a market to enter, a team to build, a strategy
            that exists on paper and nowhere else — she takes it on as a scoped engagement with a
            beginning and an end.
          </p>
        </div>
      </div>

      <div class="service__body">

        <div class="panel reveal">
          <h3 class="panel__title">Typical engagements</h3>
          <ul class="ticks">
            <li>
              <svg class="tick" viewBox="0 0 16 16" aria-hidden="true"><path class="draw" pathLength="1" d="M3 8.5L6.5 12L13 4.5" /></svg>
              <span><strong>Building the team</strong> — defining the roles, finding the people, and getting them working</span>
            </li>
            <li>
              <svg class="tick" viewBox="0 0 16 16" aria-hidden="true"><path class="draw" pathLength="1" d="M3 8.5L6.5 12L13 4.5" /></svg>
              <span><strong>Strategy implementation</strong> — taking a direction the business has already chosen and making it real</span>
            </li>
            <li>
              <svg class="tick" viewBox="0 0 16 16" aria-hidden="true"><path class="draw" pathLength="1" d="M3 8.5L6.5 12L13 4.5" /></svg>
              <span><strong>Market and category entry</strong> — how to arrive somewhere new without burning the first attempt</span>
            </li>
            <li>
              <svg class="tick" viewBox="0 0 16 16" aria-hidden="true"><path class="draw" pathLength="1" d="M3 8.5L6.5 12L13 4.5" /></svg>
              <span><strong>Institutional and venture projects</strong> — including work with university endowment programs</span>
            </li>
          </ul>
        </div>

        <div class="panel panel--alt reveal" data-delay="120">
          <h3 class="panel__title">How it's scoped</h3>
          <p class="panel__body">
            Every project is quoted on its own terms — complexity, timeline, and how much of the
            execution sits with her rather than with your team. There is no day rate, because the
            projects aren't comparable to each other.
          </p>
          <p class="panel__body">
            She runs one at a time. A project engagement gets the attention it needs because nothing
            else of its size is running alongside it.
          </p>
        </div>

      </div>

      <dl class="terms reveal">
        <div class="terms__item">
          <dt>Commitment</dt>
          <dd>Scoped to the project</dd>
        </div>
        <div class="terms__item">
          <dt>Pricing</dt>
          <dd>Quoted per engagement</dd>
        </div>
        <div class="terms__item">
          <dt>Structure</dt>
          <dd>Cash, equity, or blended</dd>
        </div>
        <div class="terms__item">
          <dt>Availability</dt>
          <dd>One at a time</dd>
        </div>
      </dl>

      <div class="service__cta reveal">
        <a class="btn btn--solid" href="{{ route('contact') }}#book">
          <span>Describe your project</span>
          <svg class="arrow" viewBox="0 0 20 12" aria-hidden="true">
            <path d="M0 6h17M12 1l5 5-5 5" />
          </svg>
        </a>
        <p class="service__cta-note">Bring the problem, not a brief. The scoping conversation is part of the work.</p>
      </div>
    </div>
  </section>

  <!-- ================= CAPACITY ================= -->
  <section class="capacity reveal">
    <div class="wrap capacity__inner">
      <div class="capacity__copy">
        <p class="eyebrow eyebrow--light">
          <span class="eyebrow__rule" aria-hidden="true"></span>
          Capacity
        </p>
        <h2 class="capacity__title">Four advisory clients. One project. That's the whole roster.</h2>
        <p class="capacity__body">
          The weekly call and the 72-hour response only mean something if the number of people
          holding those commitments stays small. The cap isn't scarcity marketing — it's the reason
          the service works.
        </p>
      </div>

      <div class="capacity__viz" aria-hidden="true">
        <div class="slots">
          <span class="slot slot--advisory"></span>
          <span class="slot slot--advisory"></span>
          <span class="slot slot--advisory"></span>
          <span class="slot slot--advisory"></span>
          <span class="slot slot--project"></span>
        </div>
        <div class="slots__legend">
          <span><i class="key key--advisory"></i> Advisory retainer &times;4</span>
          <span><i class="key key--project"></i> Project &times;1</span>
        </div>
      </div>
    </div>
  </section>

  <!-- ================= COMPARISON ================= -->
  <section class="compare">
    <div class="wrap">
      <header class="section-head reveal">
        <p class="eyebrow">
          <span class="eyebrow__rule" aria-hidden="true"></span>
          Side by Side
        </p>
        <h2 class="section-title">Which one fits what you're facing?</h2>
      </header>

      <div class="compare__scroll reveal">
        <table class="compare__table">
          <caption class="visually-hidden">Advisory retainer compared with custom project work</caption>
          <thead>
            <tr>
              <th scope="col"><span class="visually-hidden">Aspect</span></th>
              <th scope="col">Advisory Retainer</th>
              <th scope="col">Custom Project</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">The need</th>
              <td>Ongoing judgment across the whole business</td>
              <td>One specific problem with a finish line</td>
            </tr>
            <tr>
              <th scope="row">Commitment</th>
              <td>Six months minimum</td>
              <td>Scoped to the project</td>
            </tr>
            <tr>
              <th scope="row">Starting point</th>
              <td>$20,000 base</td>
              <td>Quoted per engagement</td>
            </tr>
            <tr>
              <th scope="row">Rhythm</th>
              <td>Weekly one-hour calls</td>
              <td>Working sessions as the work demands</td>
            </tr>
            <tr>
              <th scope="row">Between sessions</th>
              <td>72-hour response</td>
              <td>72-hour response</td>
            </tr>
            <tr>
              <th scope="row">Best for</th>
              <td>Founders who need a partner, not a deliverable</td>
              <td>Teams who know the goal and need it executed</td>
            </tr>
            <tr>
              <th scope="row">Availability</th>
              <td>Four at a time</td>
              <td>One at a time</td>
            </tr>
          </tbody>
        </table>
      </div>

      <p class="compare__note reveal">
        Not sure which one you need? That's a normal place to start — the intro call usually settles it in
        the first ten minutes.
      </p>
    </div>
  </section>

  <!-- ================= DEAL STRUCTURES ================= -->
  <section class="structures">
    <div class="wrap">
      <header class="section-head reveal">
        <p class="eyebrow">
          <span class="eyebrow__rule" aria-hidden="true"></span>
          Terms
        </p>
        <h2 class="section-title">How engagements are structured.</h2>
        <p class="structures__lede">
          A pre-revenue company and an institution with a budget cycle shouldn't be quoted the same
          way. These are the shapes an engagement usually takes.
        </p>
      </header>

      <div class="structures__grid">

        <article class="structure reveal" data-delay="0">
          <svg class="structure__icon" viewBox="0 0 48 48" aria-hidden="true">
            <circle class="draw" pathLength="1" cx="24" cy="24" r="14" />
            <path class="draw draw--d2" pathLength="1" d="M24 16v16" />
            <path class="draw draw--d3" pathLength="1" d="M28 20h-6a3 3 0 000 6h4a3 3 0 010 6h-6" />
          </svg>
          <h3 class="structure__title">Cash</h3>
          <p class="structure__body">
            A straightforward monthly fee. Cleanest for funded companies and institutional clients
            with a defined budget, and the simplest to end when the work is done.
          </p>
        </article>

        <article class="structure reveal" data-delay="120">
          <svg class="structure__icon" viewBox="0 0 48 48" aria-hidden="true">
            <path class="draw" pathLength="1" d="M24 8l14 8v16l-14 8-14-8V16z" />
            <path class="draw draw--d2" pathLength="1" d="M24 8v16l14 8" />
            <path class="draw draw--d3" pathLength="1" d="M24 24L10 32" />
          </svg>
          <h3 class="structure__title">Equity</h3>
          <p class="structure__body">
            Starting around 1%, vesting over the engagement. Preserves runway for early-stage
            companies, and puts her on the same side of the outcome as the founders.
          </p>
        </article>

        <article class="structure reveal" data-delay="240">
          <svg class="structure__icon" viewBox="0 0 48 48" aria-hidden="true">
            <path class="draw" pathLength="1" d="M10 32V16h12v16" />
            <path class="draw draw--d2" pathLength="1" d="M22 32h16V22" />
            <path class="draw draw--d3" pathLength="1" d="M6 36h36" />
          </svg>
          <h3 class="structure__title">Blended</h3>
          <p class="structure__body">
            A reduced cash fee alongside a smaller equity position — the most common arrangement,
            because it fits the widest range of stages. Other arrangements are considered case by case.
          </p>
        </article>

      </div>

      <div class="pricing-cta reveal" id="pricing">
        <div class="pricing-cta__copy">
          <h3 class="pricing-cta__title">Detailed pricing is shared privately.</h3>
          <p class="pricing-cta__body">
            Because terms are set per client, the full breakdown isn't published here. Ask for it and
            you'll get a private link to the tier that matches your situation.
          </p>
        </div>
        <a class="btn btn--solid" href="{{ route('contact') }}#book">
          <span>Request pricing details</span>
          <svg class="arrow" viewBox="0 0 20 12" aria-hidden="true">
            <path d="M0 6h17M12 1l5 5-5 5" />
          </svg>
        </a>
      </div>
    </div>
  </section>

  <!-- ================= CTA BAND ================= -->
  <section class="cta-band reveal">
    <span class="approach__wipe" aria-hidden="true"></span>
    <div class="wrap cta-band__inner">
      <h2 class="cta-band__title">Still deciding? Start with the call.</h2>
      <p class="cta-band__body">
        Thirty minutes, no deck required. You describe what you're building and where you're stuck;
        she tells you honestly whether she's the right person for it.
      </p>
      <div class="cta-band__actions">
        <a class="btn btn--solid btn--light" href="tel:+8801779440297">
          <span>Book a strategy call</span>
          <svg class="arrow" viewBox="0 0 20 12" aria-hidden="true">
            <path d="M0 6h17M12 1l5 5-5 5" />
          </svg>
        </a>
        <a class="btn btn--ghost btn--ghost-light" href="{{ route('home') }}">
          <span>Back to the homepage</span>
        </a>
      </div>
    </div>
  </section>

@endsection
