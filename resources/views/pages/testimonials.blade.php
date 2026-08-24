@extends('layouts.app')

@section('title', 'Testimonials — Analise Roland')
@section('description', 'What founders, operators, and institutional allocators say about working with Analise Roland.')
@section('og_title', 'Testimonials — Analise Roland')
@section('og_description', 'What founders, operators, and institutional allocators say about working with Analise Roland.')
@section('wa_text', 'Hi%20Analise%20%E2%80%94%20I%20was%20reading%20your%20testimonials%20and%20I%27d%20like%20to%20talk%20about%20an%20engagement.')
@section('legal_extra', 'Testimonials reflect the experience of individual clients and are not a promise or prediction of future results.')

@section('content')

  <!-- ================= PAGE HERO ================= -->
  <section class="page-hero">
    <div class="page-hero__mesh" aria-hidden="true"></div>
    <div class="wrap page-hero__inner">
      <p class="eyebrow hero__eyebrow">
        <span class="eyebrow__rule" aria-hidden="true"></span>
        Testimonials
      </p>
      <h1 class="page-hero__title hero__title">
        <span class="line"><span>What people say once</span></span>
        <span class="line"><span><em>the work is done.</em></span></span>
      </h1>
      <p class="page-hero__lede hero__lede">
        Analise has never advertised. Every client so far has arrived through someone who worked
        with her first — which makes what they say the closest thing this practice has to a
        marketing department.
      </p>
    </div>
  </section>

  <!-- ================= FEATURED CAROUSEL ================= -->
  <section class="featured">
    <div class="wrap">

      <!-- ============================================================
           SAMPLE CONTENT NOTICE — DELETE THIS WHOLE BLOCK BEFORE LAUNCH
           along with replacing every quote on this page with real ones.
           ============================================================ -->
      <aside class="sample-notice reveal">
        <svg class="sample-notice__icon" viewBox="0 0 24 24" aria-hidden="true">
          <circle cx="12" cy="12" r="9" />
          <path d="M12 8v5" />
          <path d="M12 16.5v.01" />
        </svg>
        <p>
          <strong>Sample content.</strong> Every quote on this page is an illustrative example
          written to demonstrate structure, tone, and length — not a real client statement. Replace
          them with Analise's actual testimonials, with permission, before launch.
        </p>
      </aside>

      @if ($featuredTestimonials->isNotEmpty())
      <div class="carousel reveal" id="carousel" aria-roledescription="carousel"
           aria-label="Featured testimonials">
        <div class="carousel__main">
        <div class="carousel__track" aria-live="polite">

          @foreach ($featuredTestimonials as $testimonial)
            <figure class="slide @if ($loop->first) is-active @endif" data-slide="{{ $loop->index }}" @unless ($loop->first) hidden @endunless>
              <svg class="quote" viewBox="0 0 44 32" aria-hidden="true">
                <path class="draw" pathLength="1" d="M18 2C8 5 3 12 3 22v8h15V16H10c0-6 3-10 9-12z" />
                <path class="draw draw--d2" pathLength="1" d="M41 2c-10 3-15 10-15 20v8h15V16h-8c0-6 3-10 9-12z" />
              </svg>
              <blockquote>
                <p>{{ $testimonial->quote }}</p>
              </blockquote>
            </figure>
          @endforeach

        </div>

        </div>

        <div class="carousel__nav" role="tablist" aria-label="Choose a testimonial">
          @foreach ($featuredTestimonials as $testimonial)
            <button class="dot @if ($loop->first) is-active @endif" type="button" role="tab" aria-selected="{{ $loop->first ? 'true' : 'false' }}" data-goto="{{ $loop->index }}">
              <span class="dot__meta">
                <span class="dot__name">{{ $testimonial->name }}</span>
                <span class="dot__role">{{ $testimonial->role }}</span>
              </span>
              <span class="dot__track" aria-hidden="true"><span class="dot__fill"></span></span>
            </button>
          @endforeach
        </div>
      </div>
      @endif

    </div>
  </section>

  <!-- ================= QUOTE GRID ================= -->
  <section class="voices">
    <div class="wrap">
      <header class="section-head reveal">
        <p class="eyebrow">
          <span class="eyebrow__rule" aria-hidden="true"></span>
          In Their Words
        </p>
        <h2 class="section-title">The shorter version.</h2>
      </header>

      <div class="voices__grid">

        @foreach ($regularTestimonials as $testimonial)
          <figure class="voice reveal" data-delay="{{ ($loop->index % 3) * 90 }}">
            <blockquote><p>{{ $testimonial->quote }}</p></blockquote>
            <figcaption>
              <span class="voice__name">{{ $testimonial->name }}</span>
              <span class="voice__role">{{ $testimonial->role }}</span>
            </figcaption>
          </figure>
        @endforeach

      </div>
    </div>
  </section>

  <!-- ================= PRIVATE REFERENCES ================= -->
  <section class="references reveal">
    <div class="wrap references__inner">
      <svg class="references__icon" viewBox="0 0 48 48" aria-hidden="true">
        <rect class="draw" pathLength="1" x="10" y="21" width="28" height="19" rx="3" />
        <path class="draw draw--d2" pathLength="1" d="M17 21v-6a7 7 0 0114 0v6" />
        <path class="draw draw--d3" pathLength="1" d="M24 29v4" />
      </svg>
      <div class="references__copy">
        <h2 class="references__title">Some references are given privately.</h2>
        <p class="references__body">
          A number of Analise's institutional clients can't be quoted publicly, and several founders
          would rather speak to you directly than be printed on a website. Ask, and she'll arrange
          the introduction — or send a private link to the references relevant to your situation.
        </p>
        <a class="link-arrow" href="{{ route('contact') }}#book">
          <span>Request private references</span>
          <svg class="arrow" viewBox="0 0 20 12" aria-hidden="true"><path d="M0 6h17M12 1l5 5-5 5" /></svg>
        </a>
      </div>
    </div>
  </section>

  <!-- ================= CTA BAND ================= -->
  <section class="cta-band reveal">
    <span class="approach__wipe" aria-hidden="true"></span>
    <div class="wrap cta-band__inner">
      <h2 class="cta-band__title">The next one of these could be yours.</h2>
      <p class="cta-band__body">
        Thirty minutes, no deck required. You describe what you're building and where you're stuck,
        and she tells you honestly whether she's the right person for it.
      </p>
      <div class="cta-band__actions">
        <a class="btn btn--solid btn--light" href="tel:+8801779440297">
          <span>Book a strategy call</span>
          <svg class="arrow" viewBox="0 0 20 12" aria-hidden="true">
            <path d="M0 6h17M12 1l5 5-5 5" />
          </svg>
        </a>
        <a class="btn btn--ghost btn--ghost-light" href="{{ route('case-studies') }}">
          <span>Read the case studies</span>
        </a>
      </div>
    </div>
  </section>

@endsection
