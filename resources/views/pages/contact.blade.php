@extends('layouts.app')

@section('title', 'Contact — Analise Roland')
@section('description', 'Book a thirty-minute intro call with Analise Roland, or send a note about what you\'re building. She replies personally, usually within a day.')
@section('og_title', 'Contact — Analise Roland')
@section('og_description', 'Book a thirty-minute intro call, or send a note about what you\'re building.')
@section('wa_text', 'Hi%20Analise%20%E2%80%94%20I%27d%20like%20to%20talk%20about%20an%20engagement.')

@section('content')

  <!-- ================= PAGE HERO ================= -->
  <section class="page-hero page-hero--tight">
    <div class="page-hero__mesh" aria-hidden="true"></div>
    <div class="wrap page-hero__inner">
      <p class="eyebrow hero__eyebrow">
        <span class="eyebrow__rule" aria-hidden="true"></span>
        Contact
      </p>
      <h1 class="page-hero__title hero__title">
        <span class="line"><span>Start with a conversation.</span></span>
        <span class="line"><span><em>Thirty minutes, no deck.</em></span></span>
      </h1>
      <p class="page-hero__lede hero__lede">
        You describe what you're building and where you're stuck. She tells you honestly whether
        she's the right person for it — and if she isn't, she'll usually know who is.
      </p>
    </div>
  </section>

  <!-- ================= FORM + CHANNELS ================= -->
  <section class="reach" id="book">
    <div class="wrap reach__grid">

      <div class="reach__form reveal">
        <h2 class="reach__title">Send her a note</h2>
        <p class="reach__lede">
          A few sentences is plenty. The more concrete you are about the problem, the more useful
          her reply will be.
        </p>

        <form class="form" id="leadForm" novalidate method="POST" action="{{ route('leads.store') }}" @if (session('lead_sent')) hidden @endif>
          @csrf
          <input type="hidden" name="source" value="contact">
          <div style="position:absolute; left:-9999px;" aria-hidden="true" tabindex="-1">
            <label for="website">Leave this field blank</label>
            <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
          </div>

          {{-- The no-JavaScript path: the browser posts normally, Laravel
               redirects back with the errors, and the directives below
               render them and repopulate what was typed instead of the form
               coming back blank. With JS on, script.js fills the same
               slots from the JSON response. --}}
          <div class="field @error('name') has-error @enderror">
            <input type="text" id="name" name="name" placeholder=" " autocomplete="name" required
                   value="{{ old('name') }}" @error('name') aria-invalid="true" @enderror>
            <label for="name">Name</label>
            <span class="field__underline" aria-hidden="true"></span>
            <p class="field__error" data-error-for="name">@error('name'){{ $message }}@enderror</p>
          </div>

          <div class="field @error('email') has-error @enderror">
            <input type="email" id="email" name="email" placeholder=" " autocomplete="email" required
                   value="{{ old('email') }}" @error('email') aria-invalid="true" @enderror>
            <label for="email">Email</label>
            <span class="field__underline" aria-hidden="true"></span>
            <p class="field__error" data-error-for="email">@error('email'){{ $message }}@enderror</p>
          </div>

          <div class="field @error('company') has-error @enderror">
            <input type="text" id="company" name="company" placeholder=" " autocomplete="organization"
                   value="{{ old('company') }}">
            <label for="company">Company <span class="opt">(optional)</span></label>
            <span class="field__underline" aria-hidden="true"></span>
          </div>

          <div class="field @error('project') has-error @enderror">
            <textarea id="project" name="project" rows="4" placeholder=" " required
                      @error('project') aria-invalid="true" @enderror>{{ old('project') }}</textarea>
            <label for="project">What are you building, and where are you stuck?</label>
            <span class="field__underline" aria-hidden="true"></span>
            <p class="field__error" data-error-for="project">@error('project'){{ $message }}@enderror</p>
          </div>

          <button class="btn btn--solid btn--block" type="submit">
            <span>Send it over</span>
            <svg class="arrow" viewBox="0 0 20 12" aria-hidden="true">
              <path d="M0 6h17M12 1l5 5-5 5" />
            </svg>
          </button>

          <p class="form__fineprint">
            Your details go straight to Analise. No list, no newsletter, no follow-up sequence.
          </p>

          <p class="form__servererror" id="formServerError" role="alert"
             @unless ($errors->has('source')) hidden @endunless>@error('source'){{ $message }}@enderror</p>
        </form>

        <div class="form-success" id="formSuccess" @unless (session('lead_sent')) hidden @endunless>
          <svg class="success-mark" viewBox="0 0 64 64" aria-hidden="true">
            <circle class="success-mark__circle" pathLength="1" cx="32" cy="32" r="27" />
            <path class="success-mark__check" pathLength="1" d="M19 33.5l9 9 17-19" />
          </svg>
          <h3>Message sent.</h3>
          <p>Analise will come back to you personally, usually within a day.</p>
        </div>
      </div>

      <aside class="reach__side">

        <div class="channels reveal" data-delay="100">
          <h2 class="channels__title">Or reach her directly</h2>

          <a class="channel" href="tel:+8801779440297">
            <span class="channel__icon">
              <svg viewBox="0 0 32 32" aria-hidden="true">
                <rect class="draw" pathLength="1" x="5" y="7" width="22" height="21" rx="3" />
                <path class="draw draw--d2" pathLength="1" d="M5 13h22M11 4v5M21 4v5" />
                <path class="draw draw--d3" pathLength="1" d="M12 19l3 3 6-6" />
              </svg>
            </span>
            <span class="channel__body">
              <span class="channel__label">Book the intro call</span>
              <span class="channel__note">+880 1779 440297 &middot; 30 minutes</span>
              <span class="placeholder-note">[Swap for the calendar embed once Kelsey has it set up]</span>
            </span>
            <svg class="arrow channel__arrow" viewBox="0 0 20 12" aria-hidden="true">
              <path d="M0 6h17M12 1l5 5-5 5" />
            </svg>
          </a>

          <a class="channel" href="https://wa.me/15550000000?text=Hi%20Analise%20%E2%80%94%20I%27d%20like%20to%20talk%20about%20an%20engagement."
             target="_blank" rel="noopener noreferrer">
            <span class="channel__icon channel__icon--wa">
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
              </svg>
            </span>
            <span class="channel__body">
              <span class="channel__label">WhatsApp</span>
              <span class="channel__note">Quickest for a short question</span>
            </span>
            <svg class="arrow channel__arrow" viewBox="0 0 20 12" aria-hidden="true">
              <path d="M0 6h17M12 1l5 5-5 5" />
            </svg>
          </a>

          <a class="channel" href="#">
            <span class="channel__icon">
              <svg viewBox="0 0 32 32" aria-hidden="true">
                <rect class="draw" pathLength="1" x="4" y="7" width="24" height="18" rx="3" />
                <path class="draw draw--d2" pathLength="1" d="M5 9l11 8 11-8" />
              </svg>
            </span>
            <span class="channel__body">
              <span class="channel__label">[hello@analiseroland.com]</span>
              <span class="channel__note">For anything with an attachment</span>
            </span>
            <svg class="arrow channel__arrow" viewBox="0 0 20 12" aria-hidden="true">
              <path d="M0 6h17M12 1l5 5-5 5" />
            </svg>
          </a>
        </div>

        <div class="next reveal" data-delay="180">
          <h2 class="next__title">What happens after you hit send</h2>
          <ol class="next__list">
            <span class="next__rail" aria-hidden="true"></span>
            <li class="next__item">
              <span class="next__num">01</span>
              <p><strong>She reads it herself.</strong> No assistant, no intake form routed to someone else.</p>
            </li>
            <li class="next__item">
              <span class="next__num">02</span>
              <p><strong>A reply within a day, usually</strong> — including when the answer is that she isn't the right fit.</p>
            </li>
            <li class="next__item">
              <span class="next__num">03</span>
              <p><strong>A thirty-minute call</strong> if there's something worth exploring.</p>
            </li>
          </ol>
        </div>

        <div class="where reveal" data-delay="240">
          <h2 class="where__title">Where she works</h2>
          <p class="where__body">
            Based in <span class="placeholder-inline">[City, State]</span>, working with clients
            across the US and occasionally further afield. Most engagements run remotely, with
            in-person time where the work genuinely calls for it.
          </p>
        </div>

      </aside>
    </div>
  </section>

  <!-- ================= FIT ================= -->
  <section class="fit">
    <div class="wrap">
      <header class="section-head reveal">
        <p class="eyebrow">
          <span class="eyebrow__rule" aria-hidden="true"></span>
          Before You Write
        </p>
        <h2 class="section-title">Worth knowing what she isn't.</h2>
        <p class="fit__lede">
          She takes four advisory clients and one project at a time, so being direct about fit saves
          everybody a call.
        </p>
      </header>

      <div class="fit__grid">

        <div class="fit__col fit__col--yes reveal">
          <h3 class="fit__heading">
            <svg class="fit__icon" viewBox="0 0 24 24" aria-hidden="true">
              <circle class="draw" pathLength="1" cx="12" cy="12" r="9.5" />
              <path class="draw draw--d2" pathLength="1" d="M7.5 12.5l3 3 6-6.5" />
            </svg>
            Probably a fit
          </h3>
          <ul class="fit__list">
            <li>You want ongoing judgment across the whole business, not a single deliverable.</li>
            <li>You have a specific, bounded problem with a real deadline attached.</li>
            <li>You're an institution or allocator who needs a framework that will survive committee.</li>
            <li>You can commit to six months, or fund a scoped project properly.</li>
            <li>You're willing to show the real numbers and the real constraints early.</li>
          </ul>
        </div>

        <div class="fit__col fit__col--no reveal" data-delay="120">
          <h3 class="fit__heading">
            <svg class="fit__icon" viewBox="0 0 24 24" aria-hidden="true">
              <circle class="draw" pathLength="1" cx="12" cy="12" r="9.5" />
              <path class="draw draw--d2" pathLength="1" d="M8.5 8.5l7 7M15.5 8.5l-7 7" />
            </svg>
            Probably not
          </h3>
          <ul class="fit__list">
            <li>You need a one-off workshop, a deck, or a single strategy document.</li>
            <li>You want someone to execute a plan rather than think alongside you.</li>
            <li>You need the work finished inside a few weeks on a retainer basis.</li>
            <li>Introductions to investors are the main thing you're after — that isn't what this practice does.</li>
            <li>The decision to hire her isn't actually yours to make yet.</li>
          </ul>
        </div>

      </div>
    </div>
  </section>

  <!-- ================= DISCLOSURES ================= -->
  <section class="disclosures reveal">
    <div class="wrap disclosures__inner">
      <svg class="disclosures__icon" viewBox="0 0 48 48" aria-hidden="true">
        <path class="draw" pathLength="1" d="M24 6l14 6v12c0 8-6 14-14 18-8-4-14-10-14-18V12z" />
        <path class="draw draw--d2" pathLength="1" d="M24 18v8" />
        <path class="draw draw--d3" pathLength="1" d="M24 30v.01" />
      </svg>
      <div class="disclosures__copy">
        <h2 class="disclosures__title">Important disclosures</h2>
        <p class="disclosures__body">
          Analise Roland Advisory is not a registered broker-dealer, investment adviser, or placement
          agent. Nothing on this site or in any conversation that begins here constitutes an offer to
          sell, a solicitation of an offer to buy any security, or financial, legal, tax, or
          investment advice.
        </p>
        <p class="disclosures__body">
          Advisory engagements are strategic and operational in nature. Figures shown across this
          site are indicative starting points; final scope, fees, and terms are set only in a signed
          written engagement agreement. Case studies and testimonials describe past engagements and
          are not a promise or prediction of future results.
        </p>
        <p class="disclosures__body placeholder-note">
          [Final disclosure language pending review by Analise's legal counsel — replace this whole
          section with their approved wording before launch.]
        </p>
      </div>
    </div>
  </section>

@endsection
