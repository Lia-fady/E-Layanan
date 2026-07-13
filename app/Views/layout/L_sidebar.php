<?php
$uri = service('uri');
$segment = $uri->getSegment(3) ?: 'dashboard';
$activeClass = function(string $name) use ($segment): string {
    return $segment === $name ? ' active text-white' : ' text-white-50';
};
$activeStyle = function(string $name) use ($segment): string {
    return $segment === $name ? 'background-color: #6f42c1;' : '';
};
?>

<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #0c3975; min-height: 100vh;">
    <a class="sidebar-brand d-flex align-items-center justify-content-start px-3 my-3 text-decoration-none" href="<?= base_url('sekretariat/c_kabid') ?>">
        <img src="https://upload.wikimedia.org/wikipedia/commons/8/82/Logo_Kota_Tangerang.svg" alt="Logo Tangerang" style="width: 38px; height: auto;" class="mr-2">
        <div class="sidebar-brand-text text-left text-white font-weight-bold" style="line-height: 1.2; font-size: 0.8rem; letter-spacing: 0.3px;">
            DINAS KOMINFO<br>
            <span style="font-size: 0.9rem; color: #ffffff;">KOTA TANGERANG</span>
        </div>
    </a>

    <hr class="sidebar-divider my-2" style="border-top: 1px solid rgba(255,255,255,0.15);">

    <div class="sidebar-user px-3 py-2 text-white d-flex align-items-center mb-3">
        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center mr-3 shadow-sm" style="width: 40px; height: 40px;">
            <i class="fas fa-user text-primary" style="font-size: 1.2rem;"></i>
        </div>
        <div style="line-height: 1.2;">
            <div class="font-weight-bold" style="font-size: 0.85rem; color: #ffffff;">Dias Delia</div>
            <small class="text-white-50" style="font-size: 0.75rem;">Kepala bidang</small>
        </div>
    </div>

    <li class="nav-item mb-2">
        <a class="nav-link rounded d-flex align-items-center py-3<?= $activeClass('dashboard') ?>" href="<?= base_url('sekretariat/c_kabid') ?>" style="<?= $activeStyle('dashboard') ?>">
            <i class="fas fa-fw fa-tachometer-alt mr-2" style="font-size: 1.1rem;"></i>
            <span class="font-weight-bold">Dashboard</span>
        </a>
    </li>

    <div class="sidebar-heading text-white-50 font-weight-bold mt-3 mb-1 px-3" style="font-size: 0.7rem; letter-spacing: 0.5px; text-transform: uppercase;">
        Persetujuan Penempatan
    </div>

    <li class="nav-item mb-2">
        <a class="nav-link rounded py-2 px-3 d-flex align-items-center<?= $activeClass('persetujuan') ?>" href="<?= base_url('sekretariat/c_kabid/persetujuan') ?>" style="<?= $activeStyle('persetujuan') ?>">
            <span style="font-size: 0.85rem;">Disposisi Bidang</span>
        </a>
    </li>
    <li class="nav-item mb-2">
        <a class="nav-link rounded py-2 px-3 d-flex align-items-center<?= $activeClass('penempatan') ?>" href="<?= base_url('sekretariat/c_kabid/penempatan') ?>" style="<?= $activeStyle('penempatan') ?>">
            <span style="font-size: 0.85rem;">Kelola Bidang</span>
        </a>
    </li>

    <div class="sidebar-heading text-white-50 font-weight-bold mt-3 mb-1 px-3" style="font-size: 0.7rem; letter-spacing: 0.5px; text-transform: uppercase;">
        Penilaian
    </div>

    <li class="nav-item mb-2">
        <a class="nav-link rounded py-2 px-3 d-flex align-items-center<?= $activeClass('penilaian') ?>" href="<?= base_url('sekretariat/c_kabid/penilaian') ?>" style="<?= $activeStyle('penilaian') ?>">
            <span style="font-size: 0.85rem;">Input nilai</span>
        </a>
    </li>

    <div class="sidebar-heading text-white-50 font-weight-bold mt-3 mb-1 px-3" style="font-size: 0.7rem; letter-spacing: 0.5px; text-transform: uppercase;">
        Sertifikat
    </div>

    <li class="nav-item mb-2">
        <a class="nav-link rounded py-2 px-3 d-flex align-items-center text-white-50" href="#">
            <span style="font-size: 0.85rem;">Upload Sertifikat</span>
        </a>
    </li>
</ul>
