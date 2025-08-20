@extends('layouts.app') {{-- or layouts.master --}}

@section('title', 'Profile Settings')

@section('content')
<div class="container py-4">
  @if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <div class="row">
    {{-- Profile card --}}
    <div class="col-md-6 mb-4">
      <div class="card">
        <div class="card-header">Profile</div>
        <div class="card-body">
          @php
            $photo = $user->photo_path ? asset($user->photo_path)
                                        : asset('plus-admin/images/faces/face1.jpg');
          @endphp

          <div class="mb-3 text-center">
            <img src="{{ $photo }}" alt="Avatar" class="rounded-circle" width="96" height="96">
          </div>

          <form action="{{ route('admin.settings.profile', $enc) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
              <label class="form-label">Name</label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                     value="{{ old('name', $user->name) }}" required>
              @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Optional email change --}}
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input disabled type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                     value="{{ old('email', $user->email) }}">
              @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Profile Photo</label>
              <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
              @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-primary">Save Profile</button>
          </form>
        </div>
      </div>
    </div>

    {{-- Password card --}}
    <div class="col-md-6 mb-4">
      <div class="card">
        <div class="card-header">Change Password</div>
        <div class="card-body">
          <form action="{{ route('admin.settings.password', $enc) }}" method="POST">
            @csrf

            <div class="mb-3">
              <label class="form-label">Current Password</label>
              <input type="password" name="current_password"
                     class="form-control @error('current_password') is-invalid @enderror" required>
              @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
              <label class="form-label">New Password</label>
              <input type="password" name="password"
                     class="form-control @error('password') is-invalid @enderror" required>
              @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
              <small class="text-muted d-block mt-1">
                Minimum 8 characters, at least 1 uppercase & 1 special character.
              </small>
            </div>

            <div class="mb-3">
              <label class="form-label">Confirm New Password</label>
              <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-dark">Update Password</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
