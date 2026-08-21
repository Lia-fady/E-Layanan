<!-- Sidebar Super Admin -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('superadmin/dashboard') ?>">
        <div class="sidebar-brand-icon">
            <i class="fas fa-university"></i>
        </div>
        <div class="sidebar-brand-text mx-3">E-Layanan <sup>Magang</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= (isset($active_menu) && $active_menu == 'dashboard') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('superadmin/dashboard') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Master Data Sistem
    </div>

    <li class="nav-item <?= (isset($active_menu) && in_array($active_menu, ['opd', 'bidang', 'kuota'])) ? 'active' : '' ?>">
        <a class="nav-link <?= (isset($active_menu) && in_array($active_menu, ['opd', 'bidang', 'kuota'])) ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapseInstansi" aria-expanded="true" aria-controls="collapseInstansi">
            <i class="fas fa-fw fa-building"></i>
            <span>Data Instansi</span>
        </a>
        <div id="collapseInstansi" class="collapse <?= (isset($active_menu) && in_array($active_menu, ['opd', 'bidang', 'kuota'])) ? 'show' : '' ?>" aria-labelledby="headingInstansi" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Komponen Instansi:</h6>
                <a class="collapse-item <?= (isset($active_menu) && $active_menu == 'opd') ? 'active' : '' ?>" href="<?= base_url('superadmin/opd') ?>">OPD</a>
                <a class="collapse-item <?= (isset($active_menu) && $active_menu == 'bidang') ? 'active' : '' ?>" href="<?= base_url('superadmin/bidang') ?>">Bidang</a>
                <a class="collapse-item <?= (isset($active_menu) && $active_menu == 'kuota') ? 'active' : '' ?>" href="<?= base_url('superadmin/kuota') ?>">Kuota</a>
            </div>
        </div>
    </li>

    <li class="nav-item <?= (isset($active_menu) && in_array($active_menu, ['instansi', 'fakultas', 'program_studi'])) ? 'active' : '' ?>">
        <a class="nav-link <?= (isset($active_menu) && in_array($active_menu, ['instansi', 'fakultas', 'program_studi'])) ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapsePendidikan" aria-expanded="true" aria-controls="collapsePendidikan">
            <i class="fas fa-fw fa-graduation-cap"></i>
            <span>Data Pendidikan</span>
        </a>
        <div id="collapsePendidikan" class="collapse <?= (isset($active_menu) && in_array($active_menu, ['instansi', 'fakultas', 'program_studi'])) ? 'show' : '' ?>" aria-labelledby="headingPendidikan" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Instansi & Fakultas:</h6>
                <a class="collapse-item <?= (isset($active_menu) && $active_menu == 'instansi') ? 'active' : '' ?>" href="<?= base_url('superadmin/instansi-pendidikan') ?>">Instansi Pendidikan</a>
                <a class="collapse-item <?= (isset($active_menu) && $active_menu == 'fakultas') ? 'active' : '' ?>" href="<?= base_url('superadmin/fakultas') ?>">Fakultas</a>
                <a class="collapse-item <?= (isset($active_menu) && $active_menu == 'program_studi') ? 'active' : '' ?>" href="<?= base_url('superadmin/program-studi') ?>">Program Studi</a>
            </div>
        </div>
    </li>

    <li class="nav-item <?= (isset($active_menu) && in_array($active_menu, ['jenis_permohonan', 'file_persyaratan'])) ? 'active' : '' ?>">
        <a class="nav-link <?= (isset($active_menu) && in_array($active_menu, ['jenis_permohonan', 'file_persyaratan'])) ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapsePermohonan" aria-expanded="true" aria-controls="collapsePermohonan">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Data Permohonan</span>
        </a>
        <div id="collapsePermohonan" class="collapse <?= (isset($active_menu) && in_array($active_menu, ['jenis_permohonan', 'file_persyaratan'])) ? 'show' : '' ?>" aria-labelledby="headingPermohonan" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Aturan Permohonan:</h6>
                <a class="collapse-item <?= (isset($active_menu) && $active_menu == 'jenis_permohonan') ? 'active' : '' ?>" href="<?= base_url('superadmin/jenis-permohonan') ?>">Jenis Permohonan</a>
                <a class="collapse-item <?= (isset($active_menu) && $active_menu == 'file_persyaratan') ? 'active' : '' ?>" href="<?= base_url('superadmin/file-persyaratan') ?>">File Persyaratan</a>
            </div>
        </div>
    </li>

    <li class="nav-item <?= (isset($active_menu) && in_array($active_menu, ['mahasiswa', 'user_mahasiswa'])) ? 'active' : '' ?>">
        <a class="nav-link <?= (isset($active_menu) && in_array($active_menu, ['mahasiswa', 'user_mahasiswa'])) ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapseUser" aria-expanded="true" aria-controls="collapseUser">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Mahasiswa</span>
        </a>
        <div id="collapseUser" class="collapse <?= (isset($active_menu) && in_array($active_menu, ['mahasiswa', 'user_mahasiswa'])) ? 'show' : '' ?>" aria-labelledby="headingUser" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Manajemen Mahasiswa:</h6>
                <a class="collapse-item <?= (isset($active_menu) && $active_menu == 'mahasiswa') ? 'active' : '' ?>" href="<?= base_url('superadmin/mahasiswa') ?>">Profil Mahasiswa</a>
                <a class="collapse-item <?= (isset($active_menu) && $active_menu == 'user_mahasiswa') ? 'active' : '' ?>" href="<?= base_url('superadmin/user-mahasiswa') ?>">Akun Mahasiswa</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Sistem
    </div>

    <!-- Nav Item - Manajemen Pengguna -->
    <li class="nav-item <?= (isset($active_menu) && $active_menu == 'manajemen_pengguna') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('superadmin/manajemen-pengguna') ?>">
            <i class="fas fa-fw fa-user-cog"></i>
            <span>Manajemen Pegawai</span>
        </a>
    </li>

    <!-- Nav Item - Manajemen Menu -->
    <li class="nav-item <?= (isset($active_menu) && $active_menu == 'manajemen_menu') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('superadmin/manajemen-menu') ?>">
            <i class="fas fa-fw fa-bars"></i>
            <span>Manajemen Menu</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar Super Admin -->
