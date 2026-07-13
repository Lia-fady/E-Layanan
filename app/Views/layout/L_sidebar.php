<?php
/**
 * Kode    : L_sidebar.php
 * Path    : app/Views/layout/L_sidebar.php
 * Deskripsi : Komponen sidebar navigasi sesuai desain Figma.
 *             Menggunakan warna dark teal dengan menu navigasi
 *             modul Sekretariat: Dashboard, Permohonan Masuk,
 *             Verifikasi Berkas, Disposisi ke Bidang, Monitoring Status,
 *             Laporan, dan Pengaturan.
 */
?>

<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark-teal sidebar-dark accordion d-flex flex-column" id="accordionSidebar" style="background: linear-gradient(180deg, #1a3c34 0%, #1e4a3f 100%) !important;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center" href="<?= base_url('sekretariat/dashboard') ?>" style="padding: 1.2rem 1rem; height: auto;">
        <div class="sidebar-brand-icon">
            <img src="<?= base_url('favicon.ico'); ?>" alt="Icon" style="width: 36px; height: 36px;">
        </div>
        <div class="sidebar-brand-text mx-2" style="text-align: left; line-height: 1.3;">
            E-Layanan Akademik
            <span class="sidebar-brand-subtitle">Kominfo Kota Tangerang</span>
        </div>
    </a>

    <!-- User Profile -->
    <div class="sidebar-user-profile">
        <div class="sidebar-user-avatar">
            <i class="fas fa-user"></i>
        </div>
        <div class="sidebar-user-info">
            <div class="sidebar-user-name"><?= session('nama_user') ?? 'User' ?></div>
            <div class="sidebar-user-role"><?= session('role_name') ?? 'Sekretariat' ?></div>
        </div>
    </div>

    <!-- Heading: SEKRETARIAT -->
    <div class="sidebar-heading" style="color: #6cc4a1;">
        <span class="sidebar-heading-dot"></span> SEKRETARIAT
    </div>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= (isset($active_menu) && $active_menu == 'dashboard') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('sekretariat/dashboard') ?>">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Nav Item - Permohonan Masuk -->
    <li class="nav-item <?= (isset($active_menu) && $active_menu == 'permohonan_masuk') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('sekretariat/permohonan-masuk') ?>">
            <i class="fas fa-fw fa-inbox"></i>
            <span>Permohonan Masuk</span>
        </a>
    </li>

    <!-- Nav Item - Verifikasi Berkas -->
    <li class="nav-item <?= (isset($active_menu) && $active_menu == 'verifikasi') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('sekretariat/verifikasi') ?>">
            <i class="fas fa-fw fa-clipboard-check"></i>
            <span>Verifikasi Berkas</span>
        </a>
    </li>

    <!-- Nav Item - Disposisi ke Bidang -->
    <li class="nav-item <?= (isset($active_menu) && $active_menu == 'disposisi') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('sekretariat/disposisi') ?>">
            <i class="fas fa-fw fa-share-square"></i>
            <span>Disposisi ke Bidang</span>
        </a>
    </li>

    <!-- Nav Item - Monitoring Status -->
    <li class="nav-item <?= (isset($active_menu) && $active_menu == 'monitoring') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('sekretariat/monitoring-status') ?>">
            <i class="fas fa-fw fa-chart-line"></i>
            <span>Monitoring Status</span>
        </a>
    </li>

    <!-- Nav Item - Laporan -->
    <li class="nav-item <?= (isset($active_menu) && $active_menu == 'laporan') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('sekretariat/laporan') ?>">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Laporan</span>
        </a>
    </li>

    <!-- Nav Item - Pengaturan -->
    <li class="nav-item <?= (isset($active_menu) && $active_menu == 'pengaturan') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('sekretariat/pengaturan') ?>">
            <i class="fas fa-fw fa-cog"></i>
            <span>Pengaturan</span>
        </a>
    </li>

    <!-- Spacer -->
    <div class="flex-grow-1"></div>

    <!-- Keluar dari Sistem -->
    <div class="sidebar-logout">
        <li class="nav-item" style="list-style: none;">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-fw fa-sign-out-alt"></i>
                <span>Keluar dari Sistem</span>
            </a>
        </li>
    </div>

</ul>
<!-- End of Sidebar -->
