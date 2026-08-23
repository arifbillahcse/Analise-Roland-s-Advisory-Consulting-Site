<footer class="footer">
  <div class="wrap">
    <div class="footer__top">
      <a class="logo logo--footer" href="{{ route('home') }}">
        <svg class="logo__mark" viewBox="0 0 40 40" aria-hidden="true">
          <path pathLength="1" d="M6 32 L20 8 L34 32" />
          <path pathLength="1" d="M12 24 L28 24" />
        </svg>
        <span class="logo__type">Analise Roland</span>
      </a>

      <nav class="footer__links" aria-label="Footer">
@foreach (config('site.nav') as $route => $label)
        <a href="{{ route($route) }}">{{ $label }}</a>
@endforeach
      </nav>

      <address class="footer__contact">
        <a href="#">[hello@analiseroland.com]</a><br>
        [City, State]
      </address>
    </div>

    <p class="footer__legal">
      [Analise Roland Advisory is not a registered broker-dealer or investment adviser.
      Nothing on this site constitutes an offer to sell, a solicitation of an offer to buy any
      security, or financial, legal, or investment advice. @hasSection('legal_extra')@yield('legal_extra') @endif— Final legal language pending
      client's counsel.]
    </p>

    <p class="footer__copy">© <span id="year">{{ date('Y') }}</span> Analise Roland. All rights reserved.</p>
  </div>
</footer>
