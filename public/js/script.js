/* =========================================================
   Analise Roland — Strategic Advisory
   Homepage interactions
   ---------------------------------------------------------
   All motion runs on transform/opacity only, and every
   effect degrades to a plain fade when the visitor has
   "reduce motion" switched on.
   ========================================================= */

(function () {
  'use strict';

  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* -------------------------------------------------------
     1. Placeholder links — every menu item is a blank "#"
        for this demo, so stop the page from jumping to top.
     ------------------------------------------------------- */
  document.addEventListener('click', function (e) {
    var link = e.target.closest('a[href="#"]');
    if (link) e.preventDefault();
  });

  /* -------------------------------------------------------
     2. Navigation — compress + frost on scroll
     ------------------------------------------------------- */
  var nav = document.getElementById('nav');
  var navToggle = document.getElementById('navToggle');
  var waFloat = document.getElementById('waFloat');

  function onScroll() {
    nav.classList.toggle('is-stuck', window.scrollY > 24);

    // Hold the WhatsApp button back until the hero is behind them, so it
    // never competes with the hero's own call to action.
    if (waFloat) {
      waFloat.classList.toggle('is-shown', window.scrollY > window.innerHeight * 0.6);
    }
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  // Logo mark draws itself once the fonts and layout have settled.
  requestAnimationFrame(function () {
    requestAnimationFrame(function () {
      nav.classList.add('is-loaded');
    });
  });

  // Mobile menu
  navToggle.addEventListener('click', function () {
    var open = nav.classList.toggle('is-open');
    navToggle.setAttribute('aria-expanded', String(open));
    navToggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
  });

  document.querySelectorAll('#navMobile a').forEach(function (a) {
    a.addEventListener('click', function () {
      nav.classList.remove('is-open');
      navToggle.setAttribute('aria-expanded', 'false');
      navToggle.setAttribute('aria-label', 'Open menu');
    });
  });

  /* -------------------------------------------------------
     3. Hero entrance — staggered, on load
     ------------------------------------------------------- */
  var HERO_REVEAL_SELECTORS = ['.hero__eyebrow', '.hero__title', '.hero__lede', '.hero__actions', '.orbit'];

  function revealHero() {
    HERO_REVEAL_SELECTORS.forEach(function (sel) {
      var el = document.querySelector(sel);
      if (el) el.classList.add('is-visible');
    });
  }

  window.addEventListener('load', revealHero);
  // Fallback in case `load` has already fired (cached assets).
  setTimeout(revealHero, 400);

  /* -------------------------------------------------------
     4. Scroll reveal — sections rise and their icons draw
     ------------------------------------------------------- */
  var revealables = document.querySelectorAll('.reveal');

  if (!('IntersectionObserver' in window)) {
    revealables.forEach(function (el) { el.classList.add('is-visible'); });
  } else {
    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;

        var el = entry.target;
        var delay = parseInt(el.dataset.delay || '0', 10);
        el.style.setProperty('--reveal-delay', delay + 'ms');
        el.classList.add('is-visible');

        observer.unobserve(el);
      });
    }, {
      threshold: 0.18,
      rootMargin: '0px 0px -60px 0px'
    });

    revealables.forEach(function (el) { observer.observe(el); });
  }

  /* -------------------------------------------------------
     5. Parallax drift on the approach block
     ------------------------------------------------------- */
  var parallaxEls = document.querySelectorAll('[data-parallax]');

  if (parallaxEls.length && !reduceMotion) {
    var ticking = false;

    var updateParallax = function () {
      parallaxEls.forEach(function (el) {
        var rect = el.getBoundingClientRect();
        var viewH = window.innerHeight;

        if (rect.bottom < 0 || rect.top > viewH) return;

        // -1 (entering from below) → 1 (leaving at the top)
        var progress = (viewH / 2 - (rect.top + rect.height / 2)) / (viewH / 2);
        el.style.transform = 'translate3d(0, ' + (progress * -26).toFixed(2) + 'px, 0)';
      });
      ticking = false;
    };

    window.addEventListener('scroll', function () {
      if (!ticking) {
        window.requestAnimationFrame(updateParallax);
        ticking = true;
      }
    }, { passive: true });

    updateParallax();
  }

  /* -------------------------------------------------------
     6. FAQ accordion — one panel open at a time
     ------------------------------------------------------- */
  var faqButtons = document.querySelectorAll('.faq__q');

  faqButtons.forEach(function (btn) {
    btn.addEventListener('click', function () {
      var item = btn.closest('.faq__item');
      var isOpen = item.classList.contains('is-open');

      // Close whatever else is open, so the section never sprawls.
      document.querySelectorAll('.faq__item.is-open').forEach(function (other) {
        if (other === item) return;
        other.classList.remove('is-open');
        other.querySelector('.faq__q').setAttribute('aria-expanded', 'false');
      });

      item.classList.toggle('is-open', !isOpen);
      btn.setAttribute('aria-expanded', String(!isOpen));
    });
  });

  /* -------------------------------------------------------
     7. Case study filters
     ------------------------------------------------------- */
  var filters = document.querySelectorAll('.filter');
  var caseGrid = document.getElementById('caseGrid');
  var casesEmpty = document.getElementById('casesEmpty');

  if (filters.length && caseGrid) {
    var caseCards = caseGrid.querySelectorAll('.case-card');

    filters.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var want = btn.dataset.filter;

        filters.forEach(function (other) {
          var active = other === btn;
          other.classList.toggle('is-active', active);
          other.setAttribute('aria-pressed', String(active));
        });

        var shown = 0;
        caseCards.forEach(function (card) {
          var match = want === 'all' || card.dataset.cat === want;

          // Restart the entrance animation for cards coming back in.
          card.classList.remove('is-entering');
          if (match) {
            card.classList.remove('is-filtered');
            void card.offsetWidth;
            card.classList.add('is-entering');
            shown++;
          } else {
            card.classList.add('is-filtered');
          }
        });

        if (casesEmpty) casesEmpty.hidden = shown > 0;
      });
    });
  }

  /* -------------------------------------------------------
     8. Testimonial carousel
        Auto-advances, pauses on hover/focus, and stays put
        entirely when the visitor has asked for less motion.
     ------------------------------------------------------- */
  var carousel = document.getElementById('carousel');

  if (carousel) {
    var slides = carousel.querySelectorAll('.slide');
    var dots = carousel.querySelectorAll('.dot');
    var SLIDE_MS = 7000;
    var current = 0;
    var timer = null;

    function show(next) {
      slides[current].classList.remove('is-active');
      slides[current].hidden = true;
      dots[current].classList.remove('is-active');
      dots[current].setAttribute('aria-selected', 'false');

      current = (next + slides.length) % slides.length;

      slides[current].hidden = false;
      slides[current].classList.add('is-active');
      dots[current].classList.add('is-active');
      dots[current].setAttribute('aria-selected', 'true');
    }

    function start() {
      if (reduceMotion) return;
      // The slides come from the database now, so one featured testimonial
      // is a real state. Nothing to advance to — don't run the timer.
      if (slides.length < 2) return;
      stop();
      timer = setInterval(function () { show(current + 1); }, SLIDE_MS);
    }
    function stop() {
      if (timer) { clearInterval(timer); timer = null; }
    }

    dots.forEach(function (dot) {
      dot.addEventListener('click', function () {
        show(parseInt(dot.dataset.goto, 10));
        start();
      });
    });

    // Pause while someone is reading or tabbing through.
    function activeDot() { return carousel.querySelector('.dot.is-active'); }

    ['mouseenter', 'focusin'].forEach(function (evt) {
      carousel.addEventListener(evt, function () {
        stop();
        var dot = activeDot();
        if (dot) dot.classList.add('is-paused');
      });
    });
    ['mouseleave', 'focusout'].forEach(function (evt) {
      carousel.addEventListener(evt, function () {
        var dot = activeDot();
        if (dot) dot.classList.remove('is-paused');
        start();
      });
    });

    // Don't run the timer for a tab nobody is looking at.
    document.addEventListener('visibilitychange', function () {
      if (document.hidden) stop(); else start();
    });

    start();
  }

  /* -------------------------------------------------------
     9. Lead form — validation, then a drawn success mark
     ------------------------------------------------------- */
  var form = document.getElementById('leadForm');
  var success = document.getElementById('formSuccess');
  var serverError = document.getElementById('formServerError');

  var MESSAGES = {
    name:    'Please add your name.',
    email:   'Please add a valid email address.',
    project: 'A sentence or two is plenty.'
  };

  function fieldOf(input) { return input.closest('.field'); }

  function setError(input, message) {
    var field = fieldOf(input);
    // Not every input the server can complain about is wrapped in a .field
    // — the hidden "source" input isn't. Fall back to the shared banner
    // rather than throwing on a null wrapper.
    if (!field) return false;

    var slot = field.querySelector('[data-error-for="' + input.id + '"]');
    if (slot) slot.textContent = message || '';
    field.classList.toggle('has-error', Boolean(message));
    input.setAttribute('aria-invalid', message ? 'true' : 'false');
    return true;
  }

  function showBanner(message) {
    if (!serverError) return;
    serverError.textContent = message;
    serverError.hidden = false;
  }

  function validate(input) {
    var value = input.value.trim();

    if (!value) {
      setError(input, MESSAGES[input.id]);
      return false;
    }
    if (input.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(value)) {
      setError(input, MESSAGES.email);
      return false;
    }
    setError(input, '');
    return true;
  }

  if (form) {
    var required = Array.prototype.slice.call(form.querySelectorAll('[required]'));

    // Clear the error the moment they start fixing it.
    required.forEach(function (input) {
      input.addEventListener('input', function () {
        if (fieldOf(input).classList.contains('has-error')) validate(input);
      });
      input.addEventListener('blur', function () {
        if (input.value.trim()) validate(input);
      });
    });

    form.addEventListener('submit', function (e) {
      e.preventDefault();

      var valid = true;
      var firstBad = null;

      required.forEach(function (input) {
        if (!validate(input)) {
          valid = false;
          if (!firstBad) firstBad = input;
        }
      });

      if (!valid) {
        firstBad.focus();
        return;
      }

      if (serverError) serverError.hidden = true;

      var submitBtn = form.querySelector('button[type="submit"]');
      if (submitBtn) submitBtn.disabled = true;

      fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: { 'Accept': 'application/json' }
      })
        .then(function (response) {
          if (response.ok) {
            showSuccess();
            return;
          }
          if (response.status === 422) {
            return response.json().then(showValidationErrors);
          }
          if (response.status === 429) {
            // Rate limiter: 5 submissions an hour from one address.
            showBanner('You’ve sent this a few times already. Give it an hour, or email hello@analiseroland.com directly.');
            return;
          }
          if (response.status === 419) {
            // Session/CSRF token expired — the page has been open a while.
            showBanner('This page has been open a while and the form expired. Please refresh and send it again.');
            return;
          }
          throw new Error('Unexpected response: ' + response.status);
        })
        .catch(function () {
          showBanner('Something went wrong sending that — please try again, or email hello@analiseroland.com directly.');
        })
        .finally(function () {
          if (submitBtn) submitBtn.disabled = false;
        });

      function showSuccess() {
        form.hidden = true;
        success.hidden = false;

        requestAnimationFrame(function () {
          success.classList.add('is-drawn');
        });

        success.setAttribute('role', 'status');
        success.setAttribute('tabindex', '-1');
        success.focus({ preventScroll: true });
      }

      function showValidationErrors(payload) {
        var errors = (payload && payload.errors) || {};
        var firstInvalid = null;
        var unplaced = [];

        Object.keys(errors).forEach(function (field) {
          var input = form.querySelector('[name="' + field + '"]');
          if (input && setError(input, errors[field][0])) {
            if (!firstInvalid) firstInvalid = input;
          } else {
            // No visible field to hang it on (e.g. the hidden "source").
            unplaced.push(errors[field][0]);
          }
        });

        if (unplaced.length) showBanner(unplaced.join(' '));

        if (firstInvalid) {
          firstInvalid.focus();
        } else if (!unplaced.length) {
          showBanner('Please check the form and try again.');
        }
      }
    });
  }

  /* -------------------------------------------------------
     10. Footer year
     ------------------------------------------------------- */
  var year = document.getElementById('year');
  if (year) year.textContent = String(new Date().getFullYear());
})();
