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

    <!-- Page Title: E-LAYANAN (Pojok Kiri Navbar) -->
    <div class="d-none d-md-flex flex-column ml-1 ml-md-3">
        <div class="navbar-brand-title" style="font-size: 1.3rem; letter-spacing: 0.5px;">E-LAYANAN</div>
        <div class="navbar-brand-subtitle" style="font-size: 0.8rem;">Permohonan & Kegiatan Akademik</div>
    </div>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="<?= base_url('img/undraw_profile.svg') ?>" alt="Profile"
                     style="width: 36px; height: 36px;">
                <span class="nav-profile-name d-none d-lg-inline ml-2" title="<?= session()->get('nama') ? esc(session()->get('nama')) : 'User' ?>">
                    <?php 
                        // Untuk kabid: tampilkan nama bidang, untuk lainnya: nama personal
                        if (session('role') === 'kabid' && session('nama_bidang')) {
                            $displayName = session('nama_bidang');
                        } else {
                            $displayName = session()->get('nama') ? session()->get('nama') : 'User';
                        }
                        echo esc(mb_strlen($displayName) > 20 ? mb_substr($displayName, 0, 20) . '...' : $displayName);
                    ?>
                    <i class="fas fa-chevron-down fa-xs ml-1"></i>
                </span>
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <?php 
                $profileLink = '#';
                $profileText = 'Profile';
                
                if(session('role') == 'mahasiswa') {
                    $profileLink = base_url('mahasiswa/profile');
                } elseif(session('role') == 'sekretariat') {
                    $profileLink = base_url('sekretariat/profile');
                } elseif(session('role') == 'kabid') {
                    $profileLink = base_url('kabid/profil-bidang');
                    $profileText = 'Profil Bidang';
                }
                ?>
                <a class="dropdown-item" href="<?= $profileLink ?>">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    <?= $profileText ?>
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
