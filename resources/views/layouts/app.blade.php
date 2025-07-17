<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

  <!-- bootstrap-icons CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

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
      @include('backend.partials._footer')
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- SweetAlert2 CDN (place in your guest layout head or before closing body) -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

  <!-- JS files -->

  <script src="{{ asset('plus-admin/vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('plus-admin/js/off-canvas.js') }}"></script>
  <script src="{{ asset('plus-admin/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('plus-admin/js/misc.js') }}"></script>
  <script src="{{ asset('plus-admin/js/settings.js') }}"></script>
  <script src="{{ asset('plus-admin/js/todolist.js') }}"></script>

  <!-- DataTables JS -->
 <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
 <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
 <!-- CKEditor -->
 <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>

 <!-- Bootstrap Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>
