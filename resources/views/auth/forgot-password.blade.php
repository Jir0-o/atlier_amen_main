@extends('layouts.guest')

@section('title', 'Forgot Password')

@section('content')
<main>
  <div class="content">
    <section class="login-form px-4">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="d-none d-md-block">
            <img class="login-thumb" src="{{ asset('frontend-css/img/login.png')}}" alt="Art time" loading="lazy">
          </div>
        </div>
        <div class="col-md-6">
          <div class="p-4">
            <div class="form-box-container jacques">
              {{-- Status flash message --}}
              @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
              @endif

              {{-- Validation errors --}}
              @if ($errors->any())
                <div class="alert alert-danger">
                  <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              <form action="{{ route('user.forgot-password.email') }}" method="post">
                @csrf
                <div class="row form-box">
                  <div class="col-md-12 mb-4">
                    <label class="form-label" for="email">Email</label>
                    <input class="form-control" type="email" name="email" id="email" placeholder="Enter your registered email" required>
                  </div>
                  <div class="d-flex flex-column">
                    <button class="btn btn-dark" type="submit">Send Reset Link</button>
                  </div>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</main>
@endsection
