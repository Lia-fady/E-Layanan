<?php
/**
 * Kode    : L_navbar.php
 * Path    : app/Views/layout/L_navbar.php
 * Deskripsi : Komponen navbar (topbar) sesuai desain Figma.
 *             Menampilkan judul halaman di kiri, ikon notifikasi
 *             dan profil user di kanan.
 */
?>

<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Page Title -->
    <h1 class="page-title d-none d-md-block"><?= $title ?? 'Dashboard' ?></h1>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Notifications -->
        <li class="nav-item mx-1">
            <a class="nav-link position-relative" href="#" title="Notifikasi">
                <i class="fas fa-bell fa-fw" style="font-size: 1.1rem;"></i>
                <span class="notification-badge"></span>
            </a>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="<?= base_url('img/undraw_profile.svg') ?>" alt="Profile">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <div class="dropdown-item-text">
                    <strong><?= session('nama_user') ?? 'User' ?></strong><br>
                    <small class="text-muted"><?= session('role_name') ?? 'Sekretariat' ?></small>
                </div>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profil
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
