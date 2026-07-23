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
        
        <?= $this->renderSection('extra_css') ?>
    </style>
</head>
<body>

<?php
    $currentURL = uri_string();
    $stateInfo = $state ?? 1;
    $jenisInfo = $jenis_permohonan_aktif ?? (isset($jenis_permohonan) && is_scalar($jenis_permohonan) ? $jenis_permohonan : null);
?>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="brand-area d-flex align-items-center gap-2">
        <i class="bi bi-mortarboard-fill fs-3" style="color: #EAB308;"></i>
        <div>E-LAYANAN AKADEMIK<br><small class="fw-normal text-white-50" style="font-size: 0.72rem;">KOMINFO TANGERANG</small></div>
    </div>
    <div class="nav flex-column mt-2">
        <a href="<?= base_url('mahasiswa/dashboard') ?>" class="nav-link <?= (strpos($currentURL, 'mahasiswa/dashboard') !== false) ? 'active' : '' ?>">
            <i class="bi bi-grid-1x2"></i> Dashboard
        </a>
        
        <div class="menu-group">Layanan Pengajuan</div>
        
        <a href="<?= base_url('mahasiswa/permohonan') ?>" class="nav-link <?= (strpos($currentURL, 'mahasiswa/permohonan') !== false && strpos($currentURL, 'status') === false) ? 'active' : '' ?>">
            <i class="bi bi-file-earmark-plus"></i> Ajukan Permohonan
        </a>

        <a href="<?= base_url('mahasiswa/status') ?>" class="nav-link <?= (strpos($currentURL, 'mahasiswa/status') !== false) ? 'active' : '' ?>">
            <i class="bi bi-clock-history"></i> Status Permohonan
        </a>

        <div class="menu-group">Kegiatan Akademik</div>
        
        <a href="<?= base_url('mahasiswa/logbook') ?>" class="nav-link <?= (strpos($currentURL, 'mahasiswa/logbook') !== false) ? 'active' : '' ?>">
            <i class="bi bi-journal-check"></i> <?= ($stateInfo == 5) ? 'Riwayat Logbook' : 'Logbook' ?>
        </a>
        
        <a href="<?= base_url('mahasiswa/sertifikat') ?>" class="nav-link <?= (strpos($currentURL, 'mahasiswa/sertifikat') !== false) ? 'active' : '' ?>">
            <i class="bi bi-award"></i> Unduh Sertifikat
        </a>
        
        <div class="menu-group">Keluar</div>
        <a href="#" id="btn-logout" class="nav-link logout-link">
            <i class="bi bi-box-arrow-left"></i> Logout Akun
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('btn-logout').addEventListener('click', function(e) {
    e.preventDefault();

    Swal.fire({
        title: 'Yakin ingin Keluar?',
        text: "Sesi login Anda di sistem E-Layanan akan diselesaikan.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e1d600',
        cancelButtonColor: '#dc3545', 
        confirmButtonText: 'Ya, Keluar!',
        cancelButtonText: 'Batal',
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
        <div class="small fw-semibold text-muted" style="font-size: 0.78rem;">
            <?= $this->renderSection('breadcrumb') ?>
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
            ?>
            <div class="text-end">
                <div class="fw-bold text-dark mb-0" style="font-size: 0.88rem;"><?= esc($nama_user) ?></div>
                <div class="text-muted" style="font-size: 0.72rem;">Aktor: Mahasiswa</div>
            </div>
            <div class="dropdown">
                <div class="avatar-circle shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    <?= esc($inisial) ?>
                </div>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom mt-3" style="min-width: 220px;">
                    <li>
                        <a class="dropdown-item dropdown-item-custom" href="<?= base_url('mahasiswa/profil') ?>">
                            <i class="bi bi-person-circle fs-5 me-3 text-primary"></i> Profil Saya
                        </a>
                    </li>
                    <li><hr class="dropdown-divider my-2 mx-2 opacity-50"></li>
                    <li>
                        <a class="dropdown-item dropdown-item-custom text-danger" href="#" onclick="document.getElementById('btn-logout').click();">
                            <i class="bi bi-box-arrow-right fs-5 me-3"></i> Keluar Akun
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

<?= $this->renderSection('extra_js') ?>
</body>
</html>
