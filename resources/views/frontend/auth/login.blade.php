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
$(function() {
    // Ensure CSRF token is available from <meta>
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

    $('#loginForm').on('submit', function(e) {
        e.preventDefault();

        const $form = $(this);
        const $btn  = $('#loginSubmitBtn');
        const redirectUrl = `{{ route("index") }}`;

        clearFieldErrors($form);
        $btn.prop('disabled', true).text('Please wait...');

        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize(),
            dataType: 'json'
        })
        .done(function(resp) {
            if (resp.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Logged In!',
                text: resp.message,
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                window.location.href = resp.redirect || redirectUrl;
            });
            } else {
                Swal.fire({icon: 'warning', title: 'Hmm...', text: 'Unexpected response from server.'});
            }
        })
        .fail(function(xhr) {
            if (xhr.status === 422) {
                const json = xhr.responseJSON || {};
                const errors = json.errors || {};
                showFieldErrors($form, errors);

                Swal.fire({
                    icon: 'error',
                    title: 'Login Failed',
                    text: json.message || 'Please check your credentials and try again.'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Something went wrong. Please try again later.'
                });
            }
        })
        .always(function() {
            $btn.prop('disabled', false).text('Login');
        });
    });

    function clearFieldErrors($form) {
        $form.find('.is-invalid').removeClass('is-invalid');
        $form.find('.invalid-feedback[data-field]').text('');
    }

    function showFieldErrors($form, errors) {
        $.each(errors, function(field, messages) {
            const $input = $form.find('[name="' + field + '"]');
            const $feedback = $form.find('.invalid-feedback[data-field="' + field + '"]');
            if ($input.length) { $input.addClass('is-invalid'); }
            if ($feedback.length) { $feedback.text(messages.join(' ')); }
        });
    }
});
</script>
@endpush
