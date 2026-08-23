<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title')</title>
<meta name="description" content="@yield('description')">

<meta property="og:type" content="website">
<meta property="og:title" content="@yield('og_title')">
<meta property="og:description" content="@yield('og_description')">
<meta name="twitter:card" content="summary_large_image">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Instrument+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap">
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' fill='%234A1520'/><text x='16' y='23' font-family='Georgia,serif' font-size='19' fill='%23FAF7F2' text-anchor='middle'>A</text></svg>">
@stack('head')
</head>
<body>

<a class="skip-link" href="#main">Skip to content</a>

@include('partials.nav')

<main id="main">
@yield('content')
</main>

@include('partials.footer')
@include('partials.whatsapp')

<script src="{{ asset('js/script.js') }}"></script>
@stack('scripts')
</body>
</html>
