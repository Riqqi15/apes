<aside class="sidebar d-flex flex-column p-3 text-white">
    <a href="{{ url('/') }}" class="d-flex align-items-center mb-3 text-white text-decoration-none">
        <div class="me-2 logo-circle">A</div>
        <span class="fs-5 fw-bold">APES</span>
    </a>
    <hr class="text-white-50">
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('dashboard.hr') }}" class="nav-link text-white">Dashboard HR</a>
        </li>
        <li>
            <a href="{{ route('dashboard.direktur') }}" class="nav-link text-white">Dashboard Direktur</a>
        </li>
        <li>
            <a href="{{ route('dashboard.karyawan') }}" class="nav-link text-white">Dashboard Karyawan</a>
        </li>
        <li>
            <a href="{{ route('rekap') }}" class="nav-link text-white">Rekap Penilaian</a>
        </li>
    </ul>
    <hr class="text-white-50">
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('kelola.karyawan') }}" class="nav-link text-white">Kelola Karyawan</a>
        </li>
        <li>
            <a href="{{ route('kelola.variabel') }}" class="nav-link text-white">Kelola Variabel</a>
        </li>
        <li>
            <a href="{{ route('kelola.indikator') }}" class="nav-link text-white">Kelola Indikator</a>
        </li>
        <li>
            <a href="{{ route('kelola.penilaian') }}" class="nav-link text-white">Kelola Penilaian</a>
        </li>
    </ul>
    <div class="mt-auto">
        <a href="{{ route('login') }}" class="btn btn-warning w-100 text-dark">Login</a>
    </div>
</aside>
