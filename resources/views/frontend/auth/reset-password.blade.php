@extends('layouts.guest')

@section('title', 'Reset Password')

@section('content')
<main>
  <div class="content">
    <section class="login-form px-4">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="p-4">
            <div class="form-box-container jacques">
              @if ($errors->any())
                <div class="alert alert-danger">
                  <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              <form method="POST" action="{{ route('user.password.update') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                  <label class="form-label" for="email">Email</label>
                  <input class="form-control" id="email" type="email" name="email" value="{{ old('email', $email) }}" required autofocus>
                </div>

                <div class="mb-3">
                  <label class="form-label" for="password">New Password</label>
                  <input class="form-control" id="password" type="password" name="password" required>
                  <small class="text-muted d-block mt-1">
                    Minimum 8 characters, at least 1 uppercase & 1 special character.
                  </small>
                </div>

                <div class="mb-4">
                  <label class="form-label" for="password_confirmation">Confirm Password</label>
                  <input class="form-control" id="password_confirmation" type="password" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-dark w-100">Reset Password</button>
              </form>

            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</main>
@endsection
