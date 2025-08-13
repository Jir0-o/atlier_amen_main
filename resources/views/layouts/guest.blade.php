<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'portfolio Admin')</title>

  <!-- plugins:css -->
    <!-- bootstrap 5.3.7 start -->
    <link rel="stylesheet" href="{{ asset('frontend-css/css/bootstrap.min.css') }}">
    <!-- bootstrap 5.3.7 end -->
    <!-- aos animation start -->
    <link rel="stylesheet" href="{{ asset('frontend-css/aos/dist/aos.css') }}">
    <!-- aos animation end -->
    <!-- remixicon css start -->
    <link rel="stylesheet" href="{{ asset('frontend-css/font/remixicon/remixicon.css') }}">
    <!-- remixicon css end -->
    <!-- custom css start -->
    <link rel="stylesheet" href="{{ asset('frontend-css/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend-css/css/media.css') }}">
    <!-- custom css end -->
</head>
<body class="primary">
<div class="container-scroller">
    <header>
        <div class="header-box">
            @include('frontend.partials._navbar')
        </div>
    </header>
    <div class="main-panel">
      <div class="content-wrapper">
        @yield('content')
      </div>
        <!-- Footer -->
        @include('frontend.partials._footer')
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- SweetAlert2 CDN (place in your guest layout head or before closing body) -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <!-- all scripts -->
    <!-- custom js start -->
    <script src="{{ asset('frontend-css/js/index.js') }}"></script>
    <!-- custom js end -->
    <!-- aos animation js start -->
    <script src="{{ asset('frontend-css/aos/dist/aos.js') }}"></script>
    <!-- aos animation js end -->
    <!-- bootstrap js start -->
    <script src="{{ asset('frontend-css/js/bootstrap.bundle.min.js') }}"></script>
    <!-- bootstrap js end -->
@stack('scripts')
    <script>
      @if(session('success'))
        Swal.fire({
          icon: 'success',
          title: 'Thank you!',
          text: "{{ session('success') }}",
          confirmButtonText: 'Close'
        });
      @endif
    </script>
</body>
</html>