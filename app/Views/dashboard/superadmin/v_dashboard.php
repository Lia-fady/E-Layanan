<?= $this->extend('layout/L_master_superadmin') ?>

<?= $this->section('title') ?><?= esc($title ?? 'dashboard') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
// Set timezone to Asia/Jakarta and locale to Indonesian
date_default_timezone_set('Asia/Jakarta');
$hari = [
    'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat',
    'Saturday' => 'Sabtu'
];
$bulan = [
    'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret',
    'April' => 'April', 'May' => 'Mei', 'June' => 'Juni',
    'July' => 'Juli', 'August' => 'Agustus', 'September' => 'September',
    'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'
];
$current_day = $hari[date('l')];
$current_date = date('d');
$current_month = $bulan[date('F')];
$current_year = date('Y');
$formatted_date = "$current_day, $current_date $current_month $current_year";
?>

<style>
    /* Custom premium styling for dashboard */
    .welcome-card {
        background: linear-gradient(135deg, #093c71 0%, #0c5b9b 100%);
        border-radius: 16px;
        color: #ffffff;
        border: none;
        box-shadow: 0 10px 20px rgba(9, 60, 113, 0.15);
    }
    .stat-card {
        background-color: #ffffff;
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
    }
    .icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .icon-blue {
        background-color: #eef4fc;
        color: #0c5b9b;
    }
    .icon-purple {
        background-color: #f5f0fc;
        color: #6f42c1;
    }
    .icon-light-blue {
        background-color: #eef9fc;
        color: #0dcaf0;
    }
    .badge-custom-blue {
        background-color: rgba(255, 255, 255, 0.2);
        color: #ffffff;
        font-weight: 500;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
    }
    .badge-custom-green {
        background-color: #2ec4b6;
        color: #ffffff;
        font-weight: 500;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
    }
    .activity-list-item {
        border-bottom: 1px solid #f0f2f5;
        padding: 12px 0;
    }
    .activity-list-item:last-child {
        border-bottom: none;
    }
    .custom-progress {
        height: 8px;
        border-radius: 4px;
        background-color: #eef2f7;
    }
    .custom-progress-bar {
        border-radius: 4px;
    }
</style>

<!-- Header Dashboard -->
<div class="mb-4">
    <h1 class="fw-bold mb-0 text-dark" style="font-size: 2.1rem; letter-spacing: -0.5px;">E-LAYANAN</h1>
    <p class="text-muted fs-6 mb-0">Permohonan & Kegiatan Akademik</p>
</div>

<!-- Welcome Card -->
<div class="card welcome-card p-4 mb-4">
    <div class="card-body p-2">
        <span class="text-white-50 d-block fs-6 mb-1">Super Administrator,</span>
        <h2 class="fw-bold mb-2" style="font-size: 2.3rem; letter-spacing: -0.5px;"><?= esc(session()->get('nama_user') ?? 'Dias Delia') ?></h2>
        <p class="mb-3 text-white-50">
            Dinas Komunikasi dan Informatika Kota Tangerang &bull; <?= $formatted_date ?>
        </p>
        <div class="d-flex gap-2">
            <span class="badge-custom-blue"><i class="fas fa-shield-alt me-1"></i> Full Access</span>
            <span class="badge-custom-green"><i class="fas fa-check-circle me-1"></i> Sistem Online</span>
        </div>
    </div>
</div>

<!-- Statistik Dashboard (3 Card Sejajar) -->
<div class="row g-3 mb-4">
    <!-- Card 1 -->
    <div class="col-md-4">
        <div class="card stat-card h-100">
            <div class="card-body p-4 d-flex align-items-center">
                <div class="icon-circle icon-blue me-3">
                    <i class="fas fa-user-friends fa-lg"></i>
                </div>
                <div>
                    <span class="text-muted small fw-semibold d-block">Total Pengguna</span>
                    <h3 class="fw-bold text-dark mb-0 my-1"><?= esc($totalPengguna) ?></h3>
                    <span class="text-muted small">Total semua peran</span>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top py-3 d-flex justify-content-between align-items-center">
                <a href="<?= base_url('superadmin/manajemen-pengguna') ?>" class="text-decoration-none small fw-semibold text-primary">Lihat Detail</a>
                <i class="fas fa-chevron-right text-primary small"></i>
            </div>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="col-md-4">
        <div class="card stat-card h-100">
            <div class="card-body p-4 d-flex align-items-center">
                <div class="icon-circle icon-purple me-3">
                    <i class="fas fa-th-large fa-lg"></i>
                </div>
                <div>
                    <span class="text-muted small fw-semibold d-block">Menu Aktif</span>
                    <h3 class="fw-bold text-dark mb-0 my-1"><?= esc($menuAktif) ?></h3>
                    <span class="text-muted small">Status aktif</span>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top py-3 d-flex justify-content-between align-items-center">
                <a href="<?= base_url('superadmin/manajemen-menu') ?>" class="text-decoration-none small fw-semibold text-primary">Lihat Detail</a>
                <i class="fas fa-chevron-right text-primary small"></i>
            </div>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="col-md-4">
        <div class="card stat-card h-100">
            <div class="card-body p-4 d-flex align-items-center">
                <div class="icon-circle icon-light-blue me-3">
                    <i class="fas fa-file-alt fa-lg"></i>
                </div>
                <div>
                    <span class="text-muted small fw-semibold d-block">Total Permohonan</span>
                    <h3 class="fw-bold text-dark mb-0 my-1"><?= esc($totalPermohonan) ?></h3>
                    <span class="text-muted small">Total keseluruhan</span>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top py-3 d-flex justify-content-between align-items-center">
                <a href="<?= base_url('superadmin/jenis-permohonan') ?>" class="text-decoration-none small fw-semibold text-primary">Lihat Detail</a>
                <i class="fas fa-chevron-right text-primary small"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Aktivitas Terbaru -->
    <div class="col-lg-6">
        <div class="card stat-card p-4">
            <h5 class="fw-bold text-dark mb-3"><i class="fas fa-history me-2 text-secondary"></i> Aktivitas Terbaru</h5>
            <div class="activity-list">
                <?php if (!empty($aktivitasTerbaru)): ?>
                    <?php foreach ($aktivitasTerbaru as $act): ?>
                        <div class="activity-list-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold text-dark d-block">Permohonan Baru</span>
                                <small class="text-muted"><?= esc($act['jenis_permohonan'] ?? 'Magang/Riset') ?> (<?= esc($act['nama_mahasiswa']) ?>)</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-light text-dark small d-block">Mahasiswa</span>
                                <small class="text-muted"><?= date('d M Y, H:i', strtotime($act['created_at'])) ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-muted small text-center py-3">Belum ada aktivitas.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Statistik Pengguna per Role -->
    <div class="col-lg-6">
        <div class="card stat-card p-4">
            <h5 class="fw-bold text-dark mb-4"><i class="fas fa-chart-pie me-2 text-secondary"></i> Distribusi Pengguna per Peran</h5>
            
            <?php
            $colors = [
                'Mahasiswa' => '#0d6efd',
                'Sekretariat' => '#20c997',
                'Kepala Bidang' => '#6f42c1',
                'Super Admin' => '#212529'
            ];
            foreach ($distribusiPeran as $role => $count): 
                $percentage = $totalPengguna > 0 ? round(($count / $totalPengguna) * 100) : 0;
                $color = $colors[$role] ?? '#6c757d';
            ?>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="fw-semibold text-secondary small"><?= esc($role) ?></span>
                        <span class="fw-bold text-dark small"><?= esc($count) ?></span>
                    </div>
                    <div class="progress custom-progress">
                        <div class="progress-bar custom-progress-bar" role="progressbar" style="width: <?= $percentage ?>%; background-color: <?= $color ?>;"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
