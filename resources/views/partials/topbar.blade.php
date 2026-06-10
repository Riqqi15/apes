<header class="topbar bg-white border-bottom p-2">
    <div class="container-fluid d-flex align-items-center justify-content-between">
        <div>
            <h5 class="mb-0">@yield('page_title','Dashboard')</h5>
        </div>
        <div class="d-flex align-items-center">
            <select class="form-select form-select-sm me-3" style="width:auto;">
                <option>Periode: Default</option>
            </select>
            <div class="dropdown">
                <a class="d-flex align-items-center text-decoration-none" href="#" role="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://via.placeholder.com/34" alt="avatar" class="rounded-circle me-2">
                    <strong>User</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="#">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>
