<?php
/**
 * Kode    : L_navbar.php
 * Path    : app/Views/layout/L_navbar.php
 * Deskripsi : Komponen navbar (topbar) sesuai desain mockup.
 *             Menampilkan teks E-LAYANAN di tengah, dan
 *             profil Admin Sekretariat dengan dropdown di kanan.
 */
?>

<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Page Title: E-LAYANAN -->
    <div class="navbar-brand-center d-none d-md-block">
        <div class="navbar-brand-title">E-LAYANAN</div>
        <div class="navbar-brand-subtitle">Permohonan & Kegiatan Akademik</div>
    </div>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="<?= base_url('img/undraw_profile.svg') ?>" alt="Profile"
                     style="width: 36px; height: 36px;">
                <span class="nav-profile-name d-none d-lg-inline ml-2">
                    Admin Sekretariat <i class="fas fa-chevron-down fa-xs ml-1"></i>
                </span>
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?= base_url('sekretariat/profile') ?>">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->
