<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow" role="navigation" aria-label="Topbar">
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" aria-label="Toggle sidebar">
        <i class="fa fa-bars" aria-hidden="true"></i>
    </button>

    <div class="navbar-brand d-none d-md-flex align-items-center">
        <div class="mr-3">
            <i class="fas fa-building fa-lg text-primary" aria-hidden="true"></i>
        </div>
        <div>
            <div class="h6 mb-0 font-weight-bold"><?= esc($title ?? 'Dashboard') ?></div>
            <div class="small text-muted">Layanan Elektronik Kominfo</div>
        </div>
    </div>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Kepala Bidang</span>
                <img class="img-profile rounded-circle" src="https://startbootstrap.github.io/startbootstrap-sb-admin-2/img/undraw_profile.svg" alt="Profil">
            </a>
        </li>
    </ul>
</nav>