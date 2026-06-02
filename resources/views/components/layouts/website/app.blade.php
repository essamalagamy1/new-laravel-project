<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
  @php
    $site_setting = siteSetting();
    $site_name = $site_setting?->name ?? config('app.name');
    $site_description = $site_setting?->description ?? '';
    $favicon = $site_setting?->getFirstMediaUrl('favicon') ?: asset('favicon.ico');
    $logo_black = $site_setting?->getFirstMediaUrl('logo_black') ?: asset('logo.svg');
  @endphp
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>{{ $site_name }} | @yield('title')</title>
  <meta name="description" content="{{ $site_description }}">
  <meta name="keywords" content="{{ $site_description }}">

  <!-- Favicons -->
  <link href="{{ $favicon }}" rel="icon">
  <link href="{{ $favicon }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Tajawal:wght@300;400;500;700;900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  @if(app()->getLocale() == 'ar')
    <link href="{{ asset('website/assets/vendor/bootstrap/css/bootstrap.rtl.min.css') }}" rel="stylesheet">
  @else
  <link href="{{ asset('website/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  @endif
  <link href="{{ asset('website/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('website/assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('website/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('website/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('website/assets/css/main.css') }}?v={{ filemtime(public_path('website/assets/css/main.css')) }}" rel="stylesheet">
    <!-- Custom CSS File -->
  <link href="{{ asset('website/assets/css/custom.css') }}?v={{ filemtime(public_path('website/assets/css/custom.css')) }}" rel="stylesheet">

  @stack('styles')
  <style>
    /* Ensure toasts appear above the sticky header (z-index: 997) */
    .fl-container, .fl-wrapper, .swal2-container, .toastr, #toast-container {
      z-index: 99999 !important;
    }
  </style>
</head>

<body class="index-page" style="background-color:#0d0f14; color:#94a3b8;">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between w-100">

      <a href="{{ route('home') }}" class="logo d-flex align-items-center text-decoration-none" wire:navigate>
       <img src="{{ $logo_black }}" alt="{{ $site_name }}" class="img-fluid" style="width:38px; height:38px; object-fit:contain; border-radius:8px;">
       <h4 class="sitename mb-0 fw-bold" style="color:#f1f5f9; font-family:var(--heading-font); font-size:1.2rem; {{ app()->getLocale() === 'ar' ? 'margin-right:10px;' : 'margin-left:10px;' }}">{{ $site_name }}</h4>
      </a>

      <x-website.nav />

    </div>
  </header>

  <main class="main">

    @yield('content')

  </main>

  <x-website.footer />

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{ asset('website/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('website/assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('website/assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('website/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('website/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('website/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('website/assets/js/main.js') }}?v={{ filemtime(public_path('website/assets/js/main.js')) }}"></script>

</body>

</html>
