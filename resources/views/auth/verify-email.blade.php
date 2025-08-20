@extends('layouts.guest')

@section('title', 'Verify Email')

@section('content')
<main class="container py-5">
  @if (session('status'))
    <div class="alert alert-success mb-3">{{ session('status') }}</div>
  @endif

  <h1 class="h4 mb-3">Verify your email</h1>
  <p class="mb-4">We’ve sent a verification link to your email address. Click the link to verify your account.</p>

  <form method="POST" action="{{ route('verification.send') }}">
    @csrf
    <button type="submit" class="btn btn-dark">Resend Verification Email</button>
  </form>
</main>
@endsection
