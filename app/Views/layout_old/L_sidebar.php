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

<style>
    /* CSS: wrap teks panjang di sidebar (menghindari nama terlalu panjang terpotong jika di-ellipsis) */
    .sidebar .nav-item .nav-link span {
        white-space: normal !important;
        word-wrap: break-word !important;
        overflow: visible !important;
        text-overflow: clip !important;
        display: inline-block;
        line-height: 1.2;
        vertical-align: middle;
    }
    .sidebar .nav-item .nav-link {
        height: auto !important;
        padding-top: 0.75rem !important;
        padding-bottom: 0.75rem !important;
        display: flex;
        align-items: center;
    }
    
    /* FIX: Submenu UI/UX Sidebar Super Admin */
    .sidebar .nav-item .collapse {
        position: relative !important;
        width: 100% !important;
        z-index: 1;
    }
    .sidebar .nav-item .collapse .collapse-inner {
        background-color: transparent !important; /* Menghilangkan background putih */
        padding: 0 !important;
        margin: 0 !important;
        box-shadow: none !important; /* Menghilangkan bayangan */
        border-radius: 0 !important;
    }
    .sidebar .nav-item .collapse .collapse-inner .collapse-item {
        color: rgba(255, 255, 255, 0.7) !important;
        padding: 0.5rem 1rem 0.5rem 3rem !important; /* Indentasi submenu lebih rapi dan masuk ke dalam */
        white-space: normal !important;
        margin: 0 !important;
        border-radius: 0 !important;
        display: block;
        text-decoration: none;
    }
    .sidebar .nav-item .collapse .collapse-inner .collapse-item::before {
        content: none !important; /* Menghilangkan bullet/titik bawaan jika ada */
    }
    .sidebar .nav-item .collapse .collapse-inner .collapse-item:hover,
    .sidebar .nav-item .collapse .collapse-inner .collapse-item.active {
        color: #fff !important;
        background-color: rgba(255, 255, 255, 0.1) !important;
        font-weight: 600;
    }
</style>

<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark-navy sidebar-dark accordion d-flex flex-column" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center" href="<?= (session('id_user_group') == 1) ? base_url('superadmin/dashboard') : base_url('sekretariat/dashboard') ?>">
        <div class="sidebar-brand-icon">
            <img src="<?= base_url('images/kota tng_nobg.png'); ?>" alt="Logo" style="width: 40px; height: 40px;">
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
            <?php if(!empty(session('foto_profil'))): ?>
                <img src="<?= base_url('uploads/profil/' . session('foto_profil')) ?>" alt="Profile" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
            <?php else: ?>
                <i class="fas fa-user"></i>
            <?php endif; ?>
        </div>
        <div class="sidebar-user-info">
            <div class="sidebar-user-name"><?= esc(!empty(session('nama_user')) ? session('nama_user') : (!empty(session('nama')) ? session('nama') : 'User')) ?></div>
            <div class="sidebar-user-role"><?= esc(!empty(session('kode_unor')) ? session('kode_unor') : (!empty(session('role_name')) ? session('role_name') : (!empty(session('role')) ? session('role') : 'Sekretariat'))) ?></div>
        </div>
    </div>

    <?php if (session('id_user_group') == 1): ?>
        <!-- ============================== -->
        <!-- MENU SUPER ADMIN               -->
        <!-- ============================== -->
        <div class="sidebar-heading mt-3">
            SUPER ADMIN
        </div>

        <li class="nav-item <?= (isset($active_menu) && $active_menu == 'dashboard') ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('superadmin/dashboard') ?>">
                <i class="fas fa-fw fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item <?= (isset($active_menu) && in_array($active_menu, ['manajemen_menu', 'manajemen_pengguna'])) ? 'active' : '' ?>">
            <a class="nav-link <?= (isset($active_menu) && in_array($active_menu, ['manajemen_menu', 'manajemen_pengguna'])) ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapseManajemen" aria-expanded="true" aria-controls="collapseManajemen">
                <i class="fas fa-fw fa-cogs"></i>
                <span>Manajemen</span>
            </a>
            <div id="collapseManajemen" class="collapse <?= (isset($active_menu) && in_array($active_menu, ['manajemen_menu', 'manajemen_pengguna'])) ? 'show' : '' ?>" aria-labelledby="headingManajemen" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item <?= (isset($active_menu) && $active_menu == 'manajemen_menu') ? 'active' : '' ?>" href="<?= base_url('superadmin/manajemen-menu') ?>">Manajemen Menu</a>
                    <a class="collapse-item <?= (isset($active_menu) && $active_menu == 'manajemen_pengguna') ? 'active' : '' ?>" href="<?= base_url('superadmin/manajemen-pengguna') ?>">Manajemen Pengguna</a>
                </div>
            </div>
        </li>

        <li class="nav-item <?= (isset($active_menu) && in_array($active_menu, ['fakultas', 'prodi', 'instansi', 'mahasiswa', 'user_mahasiswa', 'jenis_permohonan', 'file', 'odp', 'bidang', 'kuota', 'komponen_penilaian'])) ? 'active' : '' ?>">
            <a class="nav-link <?= (isset($active_menu) && in_array($active_menu, ['fakultas', 'prodi', 'instansi', 'mahasiswa', 'user_mahasiswa', 'jenis_permohonan', 'file', 'odp', 'bidang', 'kuota', 'komponen_penilaian'])) ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapseMaster" aria-expanded="true" aria-controls="collapseMaster">
                <i class="fas fa-fw fa-database"></i>
                <span>Data Master</span>
            </a>
            <div id="collapseMaster" class="collapse <?= (isset($active_menu) && in_array($active_menu, ['fakultas', 'prodi', 'instansi', 'mahasiswa', 'user_mahasiswa', 'jenis_permohonan', 'file', 'odp', 'bidang', 'kuota', 'komponen_penilaian'])) ? 'show' : '' ?>" aria-labelledby="headingMaster" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item <?= (isset($active_menu) && $active_menu == 'fakultas') ? 'active' : '' ?>" href="<?= base_url('superadmin/fakultas') ?>">Fakultas</a>
                    <a class="collapse-item <?= (isset($active_menu) && $active_menu == 'prodi') ? 'active' : '' ?>" href="<?= base_url('superadmin/prodi') ?>">Program Studi</a>
                    <a class="collapse-item <?= (isset($active_menu) && $active_menu == 'instansi') ? 'active' : '' ?>" href="<?= base_url('superadmin/instansi-pendidikan') ?>">Instansi Pendidikan</a>
                    <a class="collapse-item <?= (isset($active_menu) && $active_menu == 'mahasiswa') ? 'active' : '' ?>" href="<?= base_url('superadmin/mahasiswa') ?>">Mahasiswa</a>
                    <a class="collapse-item <?= (isset($active_menu) && $active_menu == 'user_mahasiswa') ? 'active' : '' ?>" href="<?= base_url('superadmin/user-mahasiswa') ?>">User Mahasiswa</a>
                    <a class="collapse-item <?= (isset($active_menu) && $active_menu == 'jenis_permohonan') ? 'active' : '' ?>" href="<?= base_url('superadmin/jenis-permohonan') ?>">Jenis Permohonan</a>
                    <a class="collapse-item <?= (isset($active_menu) && $active_menu == 'file') ? 'active' : '' ?>" href="<?= base_url('superadmin/file') ?>">File Persyaratan</a>
                    <a class="collapse-item <?= (isset($active_menu) && $active_menu == 'odp') ? 'active' : '' ?>" href="<?= base_url('superadmin/odp') ?>">OPD</a>
                    <a class="collapse-item <?= (isset($active_menu) && $active_menu == 'bidang') ? 'active' : '' ?>" href="<?= base_url('superadmin/bidang') ?>">Bidang</a>
                    <a class="collapse-item <?= (isset($active_menu) && $active_menu == 'kuota') ? 'active' : '' ?>" href="<?= base_url('superadmin/kuota') ?>">Kuota</a>
                    <a class="collapse-item <?= (isset($active_menu) && $active_menu == 'komponen_penilaian') ? 'active' : '' ?>" href="<?= base_url('superadmin/komponen-penilaian') ?>">Komponen Penilaian</a>
                </div>
            </div>
        </li>

    <?php else: ?>
        <!-- ============================== -->
        <!-- MENU SEKRETARIAT               -->
        <!-- ============================== -->
        <!-- Nav Item - Dashboard -->
        <li class="nav-item <?= (isset($active_menu) && $active_menu == 'dashboard') ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('sekretariat/dashboard') ?>">
                <i class="fas fa-fw fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item <?= (isset($active_menu) && $active_menu == 'verifikasi') ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('sekretariat/verifikasi') ?>">
                <i class="fas fa-fw fa-clipboard-check"></i>
                <span>Verifikasi Permohonan</span>
            </a>
        </li>

        <li class="nav-item <?= (isset($active_menu) && $active_menu == 'upload_surat_penerimaan') ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('sekretariat/upload-surat-penerimaan') ?>">
                <i class="fas fa-fw fa-file-upload"></i>
                <span>Upload Surat Penerimaan</span>
            </a>
        </li>

        <li class="nav-item <?= (isset($active_menu) && $active_menu == 'riwayat') ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('sekretariat/riwayat') ?>">
                <i class="fas fa-fw fa-history"></i>
                <span>Riwayat</span>
            </a>
        </li>
    <?php endif; ?>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('auth/logout') ?>" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>

</ul>
<!-- End of Sidebar -->
