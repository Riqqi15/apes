@php
    $currentUser = auth()->user();
    $pageRole = $currentUser?->akses_user ?? ($pageRole ?? 'hr');
    $pageRoleLabel = match ($pageRole) {
        'direktur' => 'Direktur',
        'karyawan' => 'Karyawan',
        default => 'HR Department',
    };
    $navGroups = [
        'hr' => [
            ['label' => 'Dashboard', 'route' => 'dashboard.hr', 'icon' => 'dashboard', 'patterns' => ['dashboard.hr']],
            ['label' => 'Kelola Karyawan', 'route' => 'kelola.karyawan', 'icon' => 'groups', 'patterns' => ['kelola.karyawan', 'kelola.karyawan.create', 'kelola.karyawan.edit']],
            ['label' => 'Kelola Variabel', 'route' => 'kelola.variabel', 'icon' => 'schema', 'patterns' => ['kelola.variabel']],
            ['label' => 'Kelola Indikator', 'route' => 'kelola.indikator', 'icon' => 'list_alt', 'patterns' => ['kelola.indikator']],
            ['label' => 'Kelola Penilaian', 'route' => 'kelola.penilaian', 'icon' => 'event', 'patterns' => ['kelola.penilaian', 'penilaian.assignments', 'penilaian.form', 'penilaian.hasil']],
        ],
        'direktur' => [
            ['label' => 'Dashboard', 'route' => 'dashboard.direktur', 'icon' => 'dashboard', 'patterns' => ['dashboard.direktur']],
            ['label' => 'Rekap Penilaian', 'route' => 'rekap', 'icon' => 'summarize', 'patterns' => ['rekap', 'rekap.show']],
        ],
        'karyawan' => [
            ['label' => 'Dashboard', 'route' => 'dashboard.karyawan', 'icon' => 'dashboard', 'patterns' => ['dashboard.karyawan']],
            ['label' => 'Melakukan Penilaian', 'route' => 'penilaian.assignments', 'icon' => 'fact_check', 'patterns' => ['penilaian.assignments', 'penilaian.form']],
            ['label' => 'Hasil Pribadi', 'route' => 'penilaian.hasil', 'icon' => 'workspace_premium', 'patterns' => ['penilaian.hasil']],
            ['label' => 'Edit Biodata', 'route' => 'biodata.edit', 'icon' => 'person', 'patterns' => ['biodata.edit']],
        ],
    ];
    $navItems = $navGroups[$pageRole] ?? $navGroups['hr'];
@endphp

<aside class="sidebar">
    <a href="{{ url('/') }}" class="sidebar-brand">
        <span class="sidebar-brand-mark">A</span>
        <span class="sidebar-brand-copy">
            <strong>APES</strong>
            <small>AKHLAK Performance Evaluation</small>
        </span>
    </a>

    <div class="sidebar-role">
        <span class="sidebar-role-caption">Role</span>
        <strong class="sidebar-role-label">{{ $pageRoleLabel }}</strong>
    </div>

    <nav class="sidebar-nav">
        @foreach($navItems as $item)
            <a
                href="{{ route($item['route']) }}"
                class="sidebar-link {{ request()->routeIs($item['patterns']) ? 'active' : '' }}"
            >
                <span class="sidebar-link-icon material-symbols-rounded">{{ $item['icon'] }}</span>
                <span class="sidebar-link-text">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-footer-card">
            <span class="sidebar-footer-label">Period aktif</span>
            <strong>Triwulan II 2026</strong>
            <small>Data demo untuk preview dashboard</small>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-logout btn btn-apes btn-with-icon w-100">
                <span class="material-symbols-rounded">logout</span>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>
