@extends('layouts.auth')

@section('title', 'Register - APES')

@section('content')
<main class="auth-page">
  <section class="auth-shell auth-shell--register" aria-label="APES register">
    <div class="auth-hero">
      <div class="auth-copy auth-copy--simple">
        <div class="auth-brand">
          <img class="auth-brand-logo" src="{{ asset('images/logo.svg') }}" alt="PT Energi Nusantara">
        </div>
        <h1>APES</h1>
        <p class="auth-subtitle">AKHLAK Performance Evaluation System</p>
        <p class="auth-description">Sistem Penilaian Kinerja 360&deg; Berbasis Core Values AKHLAK.</p>
      </div>
    </div>

    <div class="auth-panel">
      <div class="auth-panel-header">
        <h2>Register</h2>
        <span class="auth-panel-note">
          <span class="auth-panel-note-line">Selamat datang di APES</span>
          <span class="auth-panel-note-line">Buat akun untuk mengakses sistem APES.</span>
        </span>
      </div>

      <form class="auth-form" method="POST" action="{{ route('register.store') }}">
        @csrf

        <div class="form-field">
          <label class="form-label" for="full_name">Full Name</label>
          <input id="full_name" name="full_name" class="form-control" type="text" placeholder="Nama lengkap" value="{{ old('full_name') }}">
          @error('full_name')
            <small class="text-danger d-block mt-2">{{ $message }}</small>
          @enderror
        </div>
        <div class="form-field">
          <label class="form-label" for="username">Username</label>
          <input id="username" name="username" class="form-control" type="text" placeholder="Username" value="{{ old('username') }}">
          @error('username')
            <small class="text-danger d-block mt-2">{{ $message }}</small>
          @enderror
        </div>
        <div class="form-field">
          <label class="form-label" for="email">Email</label>
          <input id="email" name="email" class="form-control" type="email" placeholder="Email" value="{{ old('email') }}">
          @error('email')
            <small class="text-danger d-block mt-2">{{ $message }}</small>
          @enderror
        </div>
        <div class="form-field">
          <label class="form-label" for="register-password">Password</label>
          <div class="password-control">
            <input id="register-password" name="password" class="form-control" type="password" placeholder="Password" autocomplete="new-password">
            <button class="password-toggle" type="button" data-password-toggle data-input-target="register-password" aria-label="Tampilkan password" aria-pressed="false">
              <svg data-password-icon xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z"/>
                <path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
              </svg>
            </button>
          </div>
          @error('password')
            <small class="text-danger d-block mt-2">{{ $message }}</small>
          @enderror
        </div>
        <div class="form-field">
          <label class="form-label" for="register-password-confirmation">Confirm Password</label>
          <div class="password-control">
            <input id="register-password-confirmation" name="password_confirmation" class="form-control" type="password" placeholder="Confirm password" autocomplete="new-password">
            <button class="password-toggle" type="button" data-password-toggle data-input-target="register-password-confirmation" aria-label="Tampilkan password" aria-pressed="false">
              <svg data-password-icon xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z"/>
                <path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
              </svg>
            </button>
          </div>
        </div>
        <div class="form-field">
          <label class="form-label" for="role">Role</label>
          <div class="auth-select-control">
            <select id="role" name="role" class="form-select">
              <option value="hr" @selected(old('role') === 'hr')>HR</option>
              <option value="direktur" @selected(old('role') === 'direktur')>Direktur</option>
              <option value="karyawan" @selected(old('role', 'karyawan') === 'karyawan')>Karyawan</option>
            </select>
          </div>
          @error('role')
            <small class="text-danger d-block mt-2">{{ $message }}</small>
          @enderror
        </div>

        <button class="btn btn-apes auth-submit" type="submit">Register</button>

        <div class="auth-switch">
          Sudah punya akun? <a href="{{ route('login') }}">Login</a>
        </div>
      </form>
    </div>

    <p class="auth-footer">&copy; 2026 PT ENERGI NUSANTARA</p>
  </section>
</main>
@endsection
