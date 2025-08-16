@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<main>
    <div class="content">
        <section class="login-form px-4 bg-auth-images"
            style="background-image: linear-gradient(rgb(0 0 0 / 50%), rgb(0 0 0 / 50%)), url('/frontend-css/img/webimg/bg-auth.jpg');">
            <div class="row align-items-center justify-content-center">
                <div class="col-sm-9 col-md-7 col-xxl-5" data-aos="fade-up" data-aos-duration="2000">
                    <div class="p-4">
                        <div class="form-box-container jacques">
                            <form id="loginForm" action="{{ route('login.attempt') }}" method="POST" autocomplete="off" novalidate>
                                @csrf
                                <div class="row form-box">
                                    {{-- Email --}}
                                    <div class="col-md-12 mb-4">
                                        <label class="form-label" for="login_email">Email</label>
                                        <input class="form-control" type="email" name="email" id="login_email" placeholder="Enter your registered email">
                                        <small class="invalid-feedback d-block" data-field="email"></small>
                                    </div>

                                    {{-- Password --}}
                                    <div class="col-md-12 mb-4">
                                        <label class="form-label" for="login_password">Password</label>
                                        <input class="form-control" type="password" name="password" id="login_password" placeholder="Enter your password">
                                        <small class="invalid-feedback d-block" data-field="password"></small>
                                    </div>

                                    {{-- Remember + Forgot --}}
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <p class="m-0">
                                            <label for="login_remember" class="user-select-none">
                                                <input type="checkbox" name="remember" id="login_remember" value="1">
                                                Remember Me
                                            </label>
                                        </p>
                                        <p class="m-0">
                                            <strong>
                                                <a href="{{ route('frontend.password.request') }}">Forgot Password</a>
                                            </strong>
                                        </p>
                                    </div>

                                    {{-- Submit --}}
                                    <div class="d-flex flex-column">
                                        <button class="btn btn-dark" id="loginSubmitBtn" type="submit">Login</button>
                                    </div>

                                    {{-- Register link --}}
                                    <center class="pt-2">
                                        <a class="text-decoration-underline h5" href="{{ route('frontend.register') }}">Create account</a>
                                    </center>
                                </div>
                            </form>
                        </div> <!-- /.form-box-container -->
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
@endsection

@push('scripts')
<script>
$(function () {
  function getCsrfToken() {
    // 1) Try <meta name="csrf-token">
    var t = $('meta[name="csrf-token"]').attr('content');
    if (t && t.length) return t;

    // 2) Fallback to cookie "XSRF-TOKEN" (Laravel sets this)
    var m = document.cookie.match(/(?:^|;\s*)XSRF-TOKEN=([^;]+)/);
    if (m && m[1]) {
      try { return decodeURIComponent(m[1]); } catch(e) { return m[1]; }
    }
    return null;
  }

  function ensureAjaxCsrf() {
    var token = getCsrfToken();
    if (token) {
      $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': token }});
    }
    return token;
  }

  // Set a default header at page load
  ensureAjaxCsrf();

  $('#loginForm').on('submit', function (e) {
    e.preventDefault();

    var $form = $(this);
    var $btn  = $('#loginSubmitBtn');
    var redirectUrl = `{{ route('index') }}`;

    clearFieldErrors($form);
    $btn.prop('disabled', true).text('Please wait...');

    // Always fetch a fresh token and include it in BOTH header and body
    var token = ensureAjaxCsrf();

    // Build form data and make sure _token is present
    var dataArr = $form.serializeArray();
    var hasToken = dataArr.some(function (p) { return p.name === '_token'; });
    if (!hasToken) dataArr.push({ name: '_token', value: token || '' });

    $.ajax({
      url: $form.attr('action'),
      method: 'POST',
      data: $.param(dataArr),
      dataType: 'json',
      // Double-safety: set header explicitly for this request too
      beforeSend: function (xhr) {
        if (token) xhr.setRequestHeader('X-CSRF-TOKEN', token);
      }
    })
    .done(function (resp) {
      if (resp && resp.status === 'success') {
        // If backend returns a fresh token, update it before any other AJAX
        if (resp.csrf) {
          $('meta[name="csrf-token"]').attr('content', resp.csrf);
          $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': resp.csrf }});
        }
        Swal.fire({
          icon: 'success',
          title: 'Logged In!',
          text: resp.message || 'Login successful',
          timer: 1200,
          showConfirmButton: false
        }).then(function () {
          // Always do a full reload/navigation so the new CSRF cookie/meta are in sync
          window.location.href = (resp.redirect || redirectUrl);
        });
      } else {
        Swal.fire({ icon: 'warning', title: 'Hmm...', text: 'Unexpected response from server.' });
      }
    })
    .fail(function (xhr) {
      if (xhr.status === 419) {
        Swal.fire({
          icon: 'warning',
          title: 'Session Updated',
          text: 'Security token expired or changed. Please reload and try again.'
        }).then(function () {
          window.location.reload();
        });
        return;
      }

      if (xhr.status === 422) {
        var json = xhr.responseJSON || {};
        var errors = json.errors || {};
        showFieldErrors($form, errors);
        Swal.fire({
          icon: 'error',
          title: 'Login Failed',
          text: json.message || 'Please check your credentials and try again.'
        });
      } 
      else if (xhr.status === 403) { 
        var json = xhr.responseJSON || {};
        showFieldErrors($form, json.errors || {});
        Swal.fire({
          icon: 'error',
          title: 'Account Disabled',
          text: json.message || 'Your account has been disabled. Please contact support.'
        });
      }
      else {
        Swal.fire({
          icon: 'error',
          title: 'Server Error',
          text: 'Something went wrong. Please try again later.'
        });
      }
    })
    .always(function () {
      $btn.prop('disabled', false).text('Login');
    });
  });

  function clearFieldErrors($form) {
    $form.find('.is-invalid').removeClass('is-invalid');
    $form.find('.invalid-feedback[data-field]').text('');
  }

  function showFieldErrors($form, errors) {
    $.each(errors, function (field, messages) {
      var $input = $form.find('[name="' + field + '"]');
      var $feedback = $form.find('.invalid-feedback[data-field="' + field + '"]');
      if ($input.length) { $input.addClass('is-invalid'); }
      if ($feedback.length) { $feedback.text(messages.join(' ')); }
    });
  }
});
</script>

@endpush
