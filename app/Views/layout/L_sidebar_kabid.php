<?php
/**
 * Kode    : L_sidebar_kabid.php
 * Path    : app/Views/layout/L_sidebar_kabid.php
 * Deskripsi : Komponen sidebar navigasi untuk Kepala Bidang.
 *             Menggunakan warna dark navy blue dengan menu navigasi
 *             modul Kabid: Dashboard, Persetujuan Penempatan.
 */
?>

<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark-navy sidebar-dark accordion d-flex flex-column" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center" href="<?= base_url('kabid/dashboard') ?>">
        <div class="sidebar-brand-icon">
            <img src="<?= base_url('favicon.ico'); ?>" alt="Logo" style="width: 40px; height: 40px;">
        </div>
        <div class="sidebar-brand-text mx-2">
            <span class="font-weight-bold">KOTA TANGERANG</span>
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- User Profile -->
    <div class="sidebar-user-profile">
        <div class="sidebar-user-avatar">
            <i class="fas fa-user"></i>
        </div>
        <div class="sidebar-user-info">
            <div class="sidebar-user-name"><?= session('nama_user') ?? 'User' ?></div>
            <div class="sidebar-user-role"><?= session('role_name') ?? 'Kepala Bidang' ?></div>
        </div>
    </div>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= (isset($active_menu) && $active_menu == 'dashboard') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('kabid/dashboard') ?>">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading: PENEMPATAN -->
    <div class="sidebar-heading">
        PENEMPATAN
    </div>

    <!-- Nav Item - Persetujuan Penempatan -->
    <li class="nav-item <?= (isset($active_menu) && $active_menu == 'penempatan') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('kabid/penempatan') ?>">
            <i class="fas fa-fw fa-user-check"></i>
            <span>Persetujuan Penempatan</span>
        </a>
    </li>

</ul>
<!-- End of Sidebar -->
