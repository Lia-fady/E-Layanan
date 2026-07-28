<nav class="navbar navbar-expand navbar-light bg-white topbar static-top" role="navigation" aria-label="Topbar"
     style="border-bottom: 1px solid #e8ecf4; box-shadow: 0 1px 6px rgba(12,57,117,0.07); padding: 0 28px; min-height: 60px;">

    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" aria-label="Toggle sidebar">
        <i class="fa fa-bars" aria-hidden="true"></i>
    </button>

    <!-- Brand / Title -->
    <div class="navbar-brand d-none d-md-flex flex-column justify-content-center" style="line-height:1.15;">
        <div style="font-size: 1rem; font-weight: 800; color: #0c3975; letter-spacing: 0.5px;">E-LAYANAN</div>
        <div style="font-size: 0.76rem; color: #7a8aab; font-weight: 400;">Permohonan &amp; Kegiatan Akademik</div>
    </div>

    <!-- Right: User info -->
    <ul class="navbar-nav ml-auto align-items-center">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#"
               id="userDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false"
               style="color: #1c2d4a; font-weight: 600;">
                <!-- Avatar circle -->
                <div class="rounded-circle d-flex align-items-center justify-content-center mr-2"
                     style="width:36px; height:36px; background:#e8ecf4; border: 2px solid #d0d9ec;">
                    <i class="fas fa-user" style="color:#1a5ca8; font-size:0.95rem;"></i>
                </div>
                <span class="d-none d-lg-inline" style="font-size: 0.88rem;">
                    <?= esc($nama_kabid ?? 'Dias Delia') ?>
                </span>
                <i class="fas fa-chevron-down ml-1" style="font-size:0.7rem; color:#7a8aab;"></i>
            </a>
            <!-- Dropdown -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="userDropdown">
                <div class="dropdown-header text-center">
                    <small class="text-muted">Kepala Bidang</small>
                </div>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Keluar</a>
            </div>
        </li>
    </ul>
</nav>