@php
    $currentUser = auth()->user();
    $pageRole = $currentUser?->akses_user ?? ($pageRole ?? 'hr');
    $periods = $periods ?? [];
    $userName = $currentUser?->hr?->nama_hr
        ?? $currentUser?->direktur?->nama_direktur
        ?? $currentUser?->karyawan?->nama_lengkap
        ?? ($userName ?? 'APES User');
    $userRoleLabel = $currentUser?->akses_user
        ? ucfirst($currentUser->akses_user)
        : ($userRoleLabel ?? ucfirst($pageRole));
    $pageSubtitle = $pageSubtitle ?? 'Dashboard operasional';
@endphp

<header class="topbar">
    <div class="topbar-inner">
        <div class="topbar-copy">
            <span class="topbar-kicker">APES Workspace</span>
            <h1>@yield('page_title', 'Dashboard')</h1>
            <p>{{ $pageSubtitle }}</p>
        </div>

        <div class="topbar-actions">
            <div class="topbar-filter">
                <span>Periode</span>
                <select class="form-select form-select-sm">
                    @forelse($periods as $period)
                        <option value="{{ $period['value'] }}">{{ $period['label'] }}</option>
                    @empty
                        <option>Triwulan II 2026</option>
                    @endforelse
                </select>
            </div>

            <div class="dropdown">
                <a class="topbar-user" href="#" role="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="topbar-avatar" src="{{ asset('images/avatar-default.svg') }}" alt="{{ $userName }}">
                    <span class="topbar-user-copy">
                        <strong>{{ $userName }}</strong>
                        <small>{{ $userRoleLabel }}</small>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userMenu">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item" type="submit">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
