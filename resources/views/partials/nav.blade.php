<header class="nav" id="nav">
  <div class="nav__inner">
    <a class="logo" href="{{ route('home') }}" aria-label="Analise Roland — home">
      <svg class="logo__mark" viewBox="0 0 40 40" aria-hidden="true">
        <path class="draw" pathLength="1" d="M6 32 L20 8 L34 32" />
        <path class="draw draw--d2" pathLength="1" d="M12 24 L28 24" />
      </svg>
      <span class="logo__type">Analise Roland</span>
    </a>

    <nav class="nav__links" aria-label="Primary">
@foreach (config('site.nav') as $route => $label)
      <a href="{{ route($route) }}"@if (request()->routeIs($route)) aria-current="page"@endif>{{ $label }}</a>
@endforeach
    </nav>

    <a class="btn btn--solid btn--sm nav__cta" href="tel:{{ config('site.phone') }}">
      <span>Book a Call</span>
      <svg class="arrow" viewBox="0 0 20 12" aria-hidden="true">
        <path d="M0 6h17M12 1l5 5-5 5" />
      </svg>
    </a>

    <button class="nav__toggle" id="navToggle" aria-label="Open menu" aria-expanded="false">
      <span></span><span></span>
    </button>
  </div>

  <div class="nav__mobile" id="navMobile">
@foreach (config('site.nav') as $route => $label)
    <a href="{{ route($route) }}"@if (request()->routeIs($route)) aria-current="page"@endif>{{ $label }}</a>
@endforeach
    <a class="btn btn--solid" href="tel:{{ config('site.phone') }}"><span>Book a Call</span></a>
  </div>
</header>
