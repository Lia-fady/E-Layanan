<?php
/**
 * Kode    : L_sidebar.php
 * Path    : app/Views/layout/L_sidebar.php
 * Deskripsi : Komponen sidebar navigasi sesuai desain mockup.
 *             Menggunakan warna dark navy blue dengan menu navigasi
 *             modul Sekretariat: Dashboard, Verifikasi Berkas,
 *             Pilih Bidang Tujuan, dan Riwayat.
 */
?>

<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark-navy sidebar-dark accordion d-flex flex-column" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center" href="<?= base_url('sekretariat/dashboard') ?>">
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
            <div class="sidebar-user-role"><?= session('role_name') ?? 'Sekretariat' ?></div>
        </div>
    </div>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= (isset($active_menu) && $active_menu == 'dashboard') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('sekretariat/dashboard') ?>">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Verifikasi Berkas -->
    <li class="nav-item <?= (isset($active_menu) && $active_menu == 'verifikasi') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('sekretariat/verifikasi') ?>">
            <i class="fas fa-fw fa-clipboard-check"></i>
            <span>Verifikasi Berkas</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Pilih Bidang Tujuan -->
    <li class="nav-item <?= (isset($active_menu) && $active_menu == 'disposisi') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('sekretariat/disposisi') ?>">
            <i class="fas fa-fw fa-share-square"></i>
            <span>Pilih bidang tujuan</span>
        </a>
    </li>

    <!-- Nav Item - Riwayat -->
    <li class="nav-item <?= (isset($active_menu) && $active_menu == 'riwayat') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('sekretariat/riwayat') ?>">
            <i class="fas fa-fw fa-history"></i>
            <span>Riwayat</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Upload Surat Penerimaan -->
    <li class="nav-item <?= (isset($active_menu) && $active_menu == 'upload_surat_penerimaan') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('sekretariat/upload-surat-penerimaan') ?>">
            <i class="fas fa-fw fa-file-upload"></i>
            <span>Upload Surat Penerimaan</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Nav Item - Logout -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('auth/logout') ?>" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>

</ul>
<!-- End of Sidebar -->
