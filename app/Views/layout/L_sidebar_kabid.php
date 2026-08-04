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
            <img src="<?= base_url('images/kota tng_nobg.png'); ?>" alt="Logo" style="width: 40px; height: 40px;">
        </div>
        <div class="sidebar-brand-text mx-2">
            <span class="font-weight-bold">KOTA TANGERANG</span>
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- User Profile (Static Display) -->
    <div class="sidebar-user-profile">
        <div class="sidebar-user-avatar">
            <i class="fas fa-building"></i>
        </div>
        <div class="sidebar-user-info">
            <?php
                $namaBidang = session('nama_bidang') ?? session('nama') ?? 'Kepala Bidang';
                $namaBidangShort = mb_strlen($namaBidang) > 20 ? mb_substr($namaBidang, 0, 20) . '...' : $namaBidang;
            ?>
            <div class="sidebar-user-name" title="<?= esc($namaBidang) ?>">
                <?= esc($namaBidangShort) ?>
            </div>
            <div class="sidebar-user-role">Kepala Bidang</div>
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

    <!-- Heading: PENEMPATAN & PENGAWASAN -->
    <div class="sidebar-heading">
        MANAJEMEN MAGANG
    </div>

    <!-- Nav Item - Disposisi Masuk -->
    <li class="nav-item <?= (isset($active_menu) && $active_menu == 'disposisi') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('kabid/disposisi') ?>">
            <i class="fas fa-fw fa-inbox"></i>
            <span>Disposisi Masuk</span>
        </a>
    </li>

    <!-- Nav Item - Logbook -->
    <li class="nav-item <?= (isset($active_menu) && $active_menu == 'logbook') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('kabid/logbook') ?>">
            <i class="fas fa-fw fa-book"></i>
            <span>Logbook Mahasiswa</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading: ADMINISTRASI -->
    <div class="sidebar-heading">
        ADMINISTRASI
    </div>

    <!-- Nav Item - Kuota Bidang -->
    <li class="nav-item <?= (isset($active_menu) && $active_menu == 'kuota') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('kabid/kuota') ?>">
            <i class="fas fa-fw fa-chart-pie"></i>
            <span>Kuota Bidang</span>
        </a>
    </li>

    <!-- Nav Item - Upload Dokumen -->
    <li class="nav-item <?= (isset($active_menu) && $active_menu == 'upload_dokumen') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('kabid/upload-dokumen') ?>">
            <i class="fas fa-fw fa-file-upload"></i>
            <span>Upload Dokumen</span>
        </a>
    </li>

</ul>
<!-- End of Sidebar -->
