<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'Plus Admin')</title>

  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('plus-admin/vendors/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plus-admin/vendors/flag-icon-css/css/flag-icon.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plus-admin/vendors/css/vendor.bundle.base.css') }}">
  <!-- Plugin css -->
  <link rel="stylesheet" href="{{ asset('plus-admin/vendors/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plus-admin/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
  <!-- Custom styles -->
  <link rel="stylesheet" href="{{ asset('plus-admin/css/demo_1/style.css') }}">
  <link rel="shortcut icon" href="{{ asset('plus-admin/images/favicon.png') }}">
</head>
<body>
<div class="container-scroller">
  <!-- Sidebar -->
  @include('backend.partials._sidebar')
  <!-- Settings Panel -->
  @include('backend.partials._settings-panel')

  <div class="container-fluid page-body-wrapper">
    <!-- Navbar -->
    @include('backend.partials._navbar')

    <div class="main-panel">
      <div class="content-wrapper">
        @yield('content')
      </div>

      <!-- Footer -->
      @include('partials._footer')
    </div>
  </div>
</div>

  <!-- JS files -->
  <script src="{{ asset('plus-admin/vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('plus-admin/js/off-canvas.js') }}"></script>
  <script src="{{ asset('plus-admin/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('plus-admin/js/misc.js') }}"></script>
  <script src="{{ asset('plus-admin/js/settings.js') }}"></script>
  <script src="{{ asset('plus-admin/js/todolist.js') }}"></script>
</body>
</html>
