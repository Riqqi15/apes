@extends('layouts.auth')

@section('title', 'Login - APES')

@section('content')
<main class="auth-page">
  <section class="auth-shell" aria-label="APES login">
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
        <h2>Login</h2>
        <span class="auth-panel-note">
          <span class="auth-panel-note-line">Selamat datang di APES</span>
          <span class="auth-panel-note-line">Masuk untuk melanjutkan ke sistem penilaian kinerja.</span>
        </span>
      </div>

      <form class="auth-form" method="POST" action="{{ route('login.attempt') }}">
        @csrf

        @if (session('status'))
          <div class="alert alert-success mb-3" role="alert">
            {{ session('status') }}
          </div>
        @endif

        <div class="form-field">
          <label class="form-label" for="username">Username</label>
          <input id="username" name="username" class="form-control" type="text" placeholder="Masukkan username" autocomplete="username" value="{{ old('username') }}">
          @error('username')
            <small class="text-danger d-block mt-2">{{ $message }}</small>
          @enderror
        </div>

        <div class="form-field">
          <label class="form-label" for="password">Password</label>
          <div class="password-control">
            <input id="password" name="password" class="form-control" type="password" placeholder="Masukkan password" autocomplete="current-password">
            <button class="password-toggle" type="button" data-password-toggle data-input-target="password" aria-label="Tampilkan password" aria-pressed="false">
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

        <div class="auth-form-meta">
          <a href="#">Lupa Password?</a>
        </div>

        <button class="btn btn-apes auth-submit" type="submit">Login</button>

        <div class="auth-switch">
          Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
        </div>
      </form>
    </div>

    <p class="auth-footer">&copy; 2026 PT ENERGI NUSANTARA</p>
  </section>
</main>
@endsection
