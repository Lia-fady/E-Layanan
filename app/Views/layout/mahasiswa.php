<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'E-Layanan Akademik' ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Global CSS -->
    <link rel="stylesheet" href="<?= base_url('css/mahasiswa/global.css') ?>">
    
    <!-- Flatpickr CSS for Datepicker (Airbnb Theme) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css">
    
    <!-- Extra CSS from Views -->
    <?= $this->renderSection('extra_css') ?>
    
    <style>
        /* --- UTAMA & SKEMA WARNA METROPOLIS --- */
        :root {
            --primary-navy: #0A1D37;       /* Midnight Navy Super Gelap & Solid */
            --primary-royal: #13325B;      /* Royal Navy Sekunder */
            --bg-workspace: #F3F4F6;       /* Off-White Soft Premium */
            --accent-blue-soft: #0EA5E9;   /* Biru Soft / Cyan Premium */
            --text-dark: #0A1D37;          /* Warna teks utama netral gelap */
            --text-muted: #6B7280;         /* Warna teks sekunder */
            --card-white: #FFFFFF;         /* Putih bersih container */
        }

        body {
            background-color: var(--bg-workspace) !important;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: var(--text-dark);
            margin: 0;
            padding: 0;
        }

        /* --- SIDEBAR NAVIGASI (LAYOUT LAMA + WARNA MIDNIGHT NAVY PREMIUM) --- */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #0A1D37; /* Warna Utama Baru (Midnight Navy) */
            color: #ffffff;
            z-index: 1000;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.05);
        }

        .sidebar .brand-area {
            padding: 24px 20px;
            font-size: 1.02rem;
            font-weight: 800;
            line-height: 1.3;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sidebar .menu-group {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.3); /* Muted text elegan */
            padding: 20px 20px 5px 20px;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.7);
            padding: 11px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        /* Hover & Efek Aktif Memakai Warna Soft Blue Semi-Transparan Di Atas Midnight Navy */
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: #ffffff !important;
            background-color: rgba(14, 165, 233, 0.15); /* Kombinasi Biru Soft Premium */
            border-left: 4px solid #0ea5e9; /* Garis Aksen Cyan Cerah */
        }

        .sidebar .nav-link.logout-link {
            color: rgba(255, 255, 255, 0.5);
        }

        .sidebar .nav-link.logout-link:hover {
            color: #ffffff !important;
            background-color: rgba(255, 255, 255, 0.03);
            border-left: 4px solid rgba(255, 255, 255, 0.2);
        }

        /* --- LAYOUT UTAMA --- */
        .main-workspace {
            margin-left: 260px;
            width: calc(100% - 260px);
            min-height: 100vh;
        }

        .top-bar {
            background-color: var(--card-white);
            height: 75px;
            padding: 0 40px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .content-space { 
            padding: 40px; 
        }

        /* --- AVATAR BULAT --- */
        .avatar-circle {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0ea5e9 0%, #0369a1 100%);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            letter-spacing: 1px;
            box-shadow: 0 4px 10px rgba(14, 165, 233, 0.2);
            border: 2px solid #ffffff;
        }

        /* --- DROPDOWN PROFILE --- */
        .dropdown-menu-custom {
            border-radius: 16px !important;
            padding: 12px !important;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08) !important;
            border: 1px solid rgba(0, 0, 0, 0.04) !important;
            min-width: 250px;
            animation: slideDownFade 0.2s ease;
        }
        @keyframes slideDownFade {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .dropdown-item-custom {
            border-radius: 10px;
            padding: 10px 15px !important;
            font-size: 0.9rem !important;
            font-weight: 600 !important;
            color: var(--text-dark) !important;
            transition: all 0.2s;
            display: flex;
            align-items: center;
        }
        .dropdown-item-custom:hover {
            background-color: #f1f5f9 !important;
            color: #0ea5e9 !important;
            transform: translateX(4px);
        }
        .dropdown-item-custom.text-danger:hover {
            background-color: #fef2f2 !important;
            color: #ef4444 !important;
        }

        /* --- PENYESUAIAN LAYOUT TERPUSAT --- */
        .sidebar { width: 268px; background: linear-gradient(180deg, #102a43 0%, #0b2035 100%); box-shadow: 8px 0 26px rgba(8, 28, 48, 0.13); }
        .sidebar .brand-area { min-height: 86px; padding: 21px 22px; font-size: 0.98rem; letter-spacing: 0.25px; }
        .sidebar .menu-group { padding: 23px 22px 8px; color: rgba(255,255,255,0.45); font-size: 0.67rem; letter-spacing: 1.25px; }
        .sidebar .nav-link { margin: 3px 12px; padding: 12px 14px; border-radius: 8px; font-size: 0.88rem; font-weight: 600; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(55,155,211,0.18); transform: translateX(2px); border-left: 0; }
        .sidebar .nav-link.active { position: relative; }
        .sidebar .nav-link.active::before { content: ''; position: absolute; left: -12px; top: 8px; bottom: 8px; width: 3px; border-radius: 0 3px 3px 0; background: #66c2ee; }
        .main-workspace { margin-left: 268px; width: calc(100% - 268px); }
        .top-bar { height: 76px; padding: 0 38px; border-bottom-color: #dce5ec; box-shadow: 0 2px 12px rgba(16,42,67,0.035); }
        .content-space { padding: 34px 38px 46px; max-width: 1400px; margin: 0 auto; }
        .card-flat { border-color: #dce5ec; border-radius: 12px; box-shadow: 0 10px 28px rgba(16,42,67,0.07); }
        .card-flat:hover { box-shadow: 0 14px 34px rgba(16,42,67,0.12); }
        .mobile-nav-toggle { display: none; width: 40px; height: 40px; border: 1px solid #dce5ec; border-radius: 8px; background: #fff; color: #102a43; font-size: 1.15rem; }
        .mobile-nav-backdrop { display: none; }

        @media (max-width: 991.98px) {
            .mobile-nav-toggle { display: inline-flex; align-items: center; justify-content: center; }
            .sidebar { transform: translateX(-100%); }
            body.sidebar-open .sidebar { transform: translateX(0); }
            .mobile-nav-backdrop { position: fixed; inset: 0; z-index: 1035; background: rgba(8,28,48,0.42); }
            body.sidebar-open .mobile-nav-backdrop { display: block; }
            .main-workspace { margin-left: 0; width: 100%; }
            .top-bar { padding: 0 22px; }
            .content-space { padding: 28px 22px 38px; }
        }

        @media (max-width: 575.98px) {
            .top-bar { height: 68px; padding: 0 15px; }
            .top-bar > .small, .top-bar .text-end { display: none; }
            .content-space { padding: 22px 15px 32px; }
            .card-flat { padding: 18px; border-radius: 10px; }
        }

        /* --- SIDEBAR MINI STATE --- */
        .sidebar, .main-workspace { transition: margin-left 0.3s ease, width 0.3s ease, transform 0.3s ease; }
        @media (min-width: 992px) {
            body.sidebar-mini .sidebar { width: 80px; }
            body.sidebar-mini .sidebar .brand-area img { margin: 0 auto; display: block; }
            body.sidebar-mini .sidebar .brand-area div { display: none; }
            body.sidebar-mini .sidebar .menu-group { display: none; }
            body.sidebar-mini .sidebar .nav-link { padding: 12px; justify-content: center; }
            body.sidebar-mini .sidebar .nav-link span { display: none; }
            body.sidebar-mini .sidebar .nav-link i { margin: 0 !important; font-size: 1.3rem; }
            body.sidebar-mini .main-workspace { margin-left: 80px; width: calc(100% - 80px); }
        }
        
        <?= $this->renderSection('extra_css') ?>
    </style>
</head>
<body>
<script>
    if (localStorage.getItem('sidebar_mini') === 'true') {
        document.body.classList.add('sidebar-mini');
    }
</script>

<button type="button" class="mobile-nav-toggle position-fixed top-0 start-0 m-3 shadow-sm" id="mobile-nav-toggle" aria-label="Buka menu navigasi" aria-controls="student-sidebar" aria-expanded="false">
    <i class="bi bi-list"></i>
</button>
<div class="mobile-nav-backdrop" id="mobile-nav-backdrop"></div>

<?php
    $currentURL = uri_string();
    $stateInfo = $state ?? 1;
    $jenisInfo = $jenis_permohonan_aktif ?? (isset($jenis_permohonan) && is_scalar($jenis_permohonan) ? $jenis_permohonan : null);
?>

<!-- SIDEBAR -->
<div class="sidebar" id="student-sidebar">
    <div class="brand-area d-flex align-items-center gap-3">
        <img src="<?= base_url('img/kota tng_nobg.png') ?>" alt="Logo Tangerang" style="width: 40px; height: 40px; object-fit: contain;">
        <div style="line-height: 1.2;">E-LAYANAN AKADEMIK<br><small class="fw-normal text-white-50" style="font-size: 0.72rem;">KOMINFO TANGERANG</small></div>
    </div>
    <div class="nav flex-column mt-2">
        <a href="<?= base_url('mahasiswa/dashboard') ?>" class="nav-link <?= (strpos($currentURL, 'mahasiswa/dashboard') !== false) ? 'active' : '' ?>" title="Dashboard">
            <i class="bi bi-grid-1x2"></i> <span>Dashboard</span>
        </a>
        
        <div class="menu-group">Layanan Pengajuan</div>
        
        <a href="<?= base_url('mahasiswa/permohonan') ?>" class="nav-link <?= (strpos($currentURL, 'mahasiswa/permohonan') !== false && strpos($currentURL, 'status') === false) ? 'active' : '' ?>" title="Ajukan Permohonan">
            <i class="bi bi-file-earmark-plus"></i> <span>Ajukan Permohonan</span>
        </a>

        <a href="<?= base_url('mahasiswa/status') ?>" class="nav-link <?= (strpos($currentURL, 'mahasiswa/status') !== false) ? 'active' : '' ?>" title="Riwayat Permohonan">
            <i class="bi bi-clock-history"></i> <span>Riwayat Permohonan</span>
        </a>

        <div class="menu-group">Kegiatan Akademik</div>
        
        <a href="<?= base_url('mahasiswa/logbook') ?>" class="nav-link <?= (strpos($currentURL, 'mahasiswa/logbook') !== false) ? 'active' : '' ?>" title="Logbook">
            <i class="bi bi-journal-check"></i> <span><?= ($stateInfo == 5) ? 'Logbook' : 'Logbook' ?></span>
        </a>
        
        <a href="<?= base_url('mahasiswa/sertifikat') ?>" class="nav-link <?= (strpos($currentURL, 'mahasiswa/sertifikat') !== false) ? 'active' : '' ?>" title="Unduh Dokumen">
            <i class="bi bi-download"></i> <span>Unduh Dokumen</span>
        </a>
        
        <div class="menu-group">Keluar</div>
        <a href="#" id="btn-logout" class="nav-link logout-link" title="Keluar">
            <i class="bi bi-box-arrow-left"></i> <span>Keluar</span>
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('btn-logout').addEventListener('click', function(e) {
    e.preventDefault();

    Swal.fire({
        title: 'Keluar Aplikasi?',
        text: 'Sesi Anda saat ini akan diakhiri dan Anda harus masuk kembali untuk mengakses layanan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d', 
        confirmButtonText: 'Ya, Keluar',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        background: '#ffffff',
        customClass: {
            title: 'fw-bold text-dark'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "<?= base_url('logout') ?>";
        }
    });
});

const mobileNavToggle = document.getElementById('mobile-nav-toggle');
const mobileNavBackdrop = document.getElementById('mobile-nav-backdrop');
const closeMobileNav = function() {
    document.body.classList.remove('sidebar-open');
    mobileNavToggle.setAttribute('aria-expanded', 'false');
};
mobileNavToggle.addEventListener('click', function() {
    const isOpen = document.body.classList.toggle('sidebar-open');
    this.setAttribute('aria-expanded', String(isOpen));
});
mobileNavBackdrop.addEventListener('click', closeMobileNav);
document.querySelectorAll('.sidebar .nav-link').forEach(function(link) {
    link.addEventListener('click', closeMobileNav);
});

document.addEventListener('DOMContentLoaded', function() {
    const desktopNavToggle = document.getElementById('desktop-nav-toggle');
    if(desktopNavToggle) {
        desktopNavToggle.addEventListener('click', function() {
            document.body.classList.toggle('sidebar-mini');
            localStorage.setItem('sidebar_mini', document.body.classList.contains('sidebar-mini'));
        });
    }
});

document.querySelectorAll('.locked-menu').forEach(item => {
    item.addEventListener('click', function(e) {
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Akses Terkunci 🔒',
            text: 'Fitur Logbook & Sertifikat hanya tersedia bagi mahasiswa yang diwajibkan oleh instansi terkait.',
            confirmButtonColor: '#0ea5e9',
            confirmButtonText: 'Mengerti'
        });
    });
});
</script>

<!-- MAIN WORKSPACE -->
<div class="main-workspace">
    <!-- TOP BAR -->
    <div class="top-bar d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <button type="button" class="d-none d-lg-flex align-items-center justify-content-center border-0 bg-transparent text-dark p-0" id="desktop-nav-toggle" style="width:36px; height:36px; opacity: 0.7; transition: opacity 0.2s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.7'">
                <i class="bi bi-list fs-4"></i>
            </button>
            <div style="font-size: 0.95rem;">
                <?= $this->renderSection('breadcrumb') ?>
            </div>
        </div>
        <div class="d-flex align-items-center gap-3">
            <?php
                // Ambil nama dari session secara langsung agar selalu ada di semua halaman
                $nama_user = session()->get('nama') ?? 'Mahasiswa';
                // Membuat Inisial Nama (Max 2 huruf)
                $words = explode(" ", $nama_user);
                $inisial = "";
                foreach ($words as $w) {
                    if(!empty($w)) $inisial .= mb_substr($w, 0, 1);
                }
                $inisial = strtoupper(mb_substr($inisial, 0, 2));
                $foto_profil = session()->get('foto_profil');
            ?>
            <div class="text-end">
                <div class="fw-bold text-dark mb-0" style="font-size: 0.88rem;"><?= esc($nama_user) ?></div>
                <div class="text-muted" style="font-size: 0.75rem; letter-spacing: 0.3px; font-weight: 500;"><?= session()->get('kategori_pelajar') ?? 'Mahasiswa' ?></div>
            </div>
            <div class="dropdown">
                <?php if (!empty($foto_profil)): ?>
                    <div type="button" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        <img src="<?= base_url('uploads/profil/' . esc($foto_profil)) ?>" alt="Avatar" class="shadow-sm" style="width: 42px; height: 42px; border-radius: 50%; object-fit: cover; border: 2px solid #ffffff;">
                    </div>
                <?php else: ?>
                    <div class="avatar-circle shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        <?= esc($inisial) ?>
                    </div>
                <?php endif; ?>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm mt-2" style="min-width: 160px; font-size: 0.85rem; border: 1px solid #e2e8f0; border-radius: 8px;">
                    <li>
                        <a class="dropdown-item py-2 text-dark" href="<?= base_url('mahasiswa/profil') ?>">
                            <i class="bi bi-person fa-fw me-2 text-secondary"></i> Profil Saya
                        </a>
                    </li>
                    <li><hr class="dropdown-divider my-1 opacity-25"></li>
                    <li>
                        <a class="dropdown-item py-2 text-dark" href="#" onclick="document.getElementById('btn-logout').click();">
                            <i class="bi bi-box-arrow-right fa-fw me-2 text-secondary"></i> Keluar Akun
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- CONTENT SPACE -->
    <div class="content-space">
        <?= $this->renderSection('content') ?>
    </div>
</div>

<!-- Bootstrap 5 Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    <?php if (session()->getFlashdata('sweet_success')) : ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '<?= session()->getFlashdata('sweet_success') ?>',
            confirmButtonColor: '#0ea5e9'
        });
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('sweet_error')) : ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '<?= session()->getFlashdata('sweet_error') ?>',
            confirmButtonColor: '#dc3545'
        });
    <?php endif; ?>
</script>

<!-- Flatpickr JS & Locale -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
<script>
    // Inisialisasi Flatpickr global untuk semua input berkelas flatpickr-id
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr(".flatpickr-id", {
            locale: "id",
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d/m/Y", // format tampilan: dd/mm/yyyy
            allowInput: true
        });
    });
</script>

<?= $this->renderSection('extra_js') ?>
</body>
</html>
