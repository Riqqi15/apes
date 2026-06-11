<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','APES - Auth')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/apes.css') }}">
  @stack('head')
</head>
<body class="auth-body">
  @yield('content')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const autoHideDelay = 1;
      const hiddenIcon = `
        <path d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z"/>
        <path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
      `;
      const visibleIcon = `
        <path d="M3 3l18 18"/>
        <path d="M10.58 10.58a2 2 0 0 0 2.83 2.83"/>
        <path d="M9.88 5.09A10.94 10.94 0 0 1 12 4.88c6 0 9.75 7.12 9.75 7.12a18.17 18.17 0 0 1-4.13 4.77"/>
        <path d="M6.61 6.61C4.24 8.08 2.75 12 2.75 12s3.75 7.12 9.25 7.12a10.7 10.7 0 0 0 3.02-.43"/>
      `;

      document.querySelectorAll('[data-password-toggle]').forEach(function (button) {
        const input = document.getElementById(button.dataset.inputTarget);
        const icon = button.querySelector('[data-password-icon]');

        if (!input || !icon) {
          return;
        }

        let autoHideTimer;

        const syncState = function (isVisible) {
          input.type = isVisible ? 'text' : 'password';
          button.setAttribute('aria-label', isVisible ? 'Sembunyikan password' : 'Tampilkan password');
          button.setAttribute('aria-pressed', isVisible ? 'true' : 'false');
          icon.innerHTML = isVisible ? visibleIcon : hiddenIcon;
        };

        const clearAutoHideTimer = function () {
          window.clearTimeout(autoHideTimer);
        };

        const scheduleAutoHide = function () {
          clearAutoHideTimer();
          autoHideTimer = window.setTimeout(function () {
            syncState(false);
          }, autoHideDelay);
        };

        button.addEventListener('click', function () {
          const shouldShowPassword = input.type === 'password';

          syncState(shouldShowPassword);

          if (shouldShowPassword) {
            scheduleAutoHide();
            return;
          }

          clearAutoHideTimer();
        });

        syncState(false);
      });
    });
  </script>
  <script src="{{ asset('js/apes.js') }}" defer></script>
  @stack('scripts')
</body>
</html>
