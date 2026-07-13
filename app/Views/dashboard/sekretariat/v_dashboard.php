<?php

/**
 * Kode: v_dashboard.php
 * Path: app/Views/dashboard/sekretariat/v_dashboard.php
 * Deskripsi: View halaman Dashboard Sekretariat sesuai desain Figma.
 *            Menampilkan welcome card, 4 kartu statistik, daftar permohonan
 *            pending, donut chart distribusi jenis, ringkasan hari ini,
 *            dan line chart tren permohonan bulanan.
 */

?>

<?= $this->extend('layout/L_master') ?>

<?= $this->section('title') ?>
<?= esc($title) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Welcome Card -->
<div class="welcome-card">
    <div class="welcome-label">Selamat datang,</div>
    <div class="welcome-name"><?= esc(session('nama_user') ?? 'User') ?></div>
    <div class="welcome-role"><?= esc(session('role_name') ?? 'Sekretariat') ?> · Dinas Kominfo Kota Tangerang</div>
    <div>
        <span class="welcome-badge welcome-badge-date"><?= esc($tanggal_formatted) ?></span>
        <?php if ($total_verifikasi > 0) : ?>
            <span class="welcome-badge welcome-badge-alert">
                <i class="fas fa-exclamation-triangle"></i> <?= $total_verifikasi ?> berkas menunggu verifikasi
            </span>
        <?php endif; ?>
    </div>
</div>

<!-- Stat Cards Row -->
<div class="row mb-4">
    <!-- Permohonan Masuk -->
    <div class="col-xl-3 col-md-6 mb-3">
        <a href="<?= site_url('sekretariat/permohonan-masuk') ?>" class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-icon blue">
                    <i class="fas fa-inbox"></i>
                </div>
                <div class="stat-card-title">Permohonan Masuk</div>
            </div>
            <div class="stat-card-value"><?= esc($total_permohonan) ?></div>
            <div class="stat-card-desc">Bulan <?= esc($nama_bulan) ?></div>
        </a>
    </div>

    <!-- Menunggu Verifikasi -->
    <div class="col-xl-3 col-md-6 mb-3">
        <a href="<?= site_url('sekretariat/verifikasi') ?>" class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-icon yellow">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div class="stat-card-title">Menunggu Verifikasi</div>
            </div>
            <div class="stat-card-value"><?= esc($total_verifikasi) ?></div>
            <div class="stat-card-desc">Perlu ditindak</div>
        </a>
    </div>

    <!-- Berkas Terverifikasi -->
    <div class="col-xl-3 col-md-6 mb-3">
        <a href="<?= site_url('sekretariat/verifikasi') ?>" class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-icon green">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-card-title">Berkas Terverifikasi</div>
            </div>
            <div class="stat-card-value"><?= esc($total_terverifikasi) ?></div>
            <div class="stat-card-desc">Bulan ini</div>
        </a>
    </div>

    <!-- Sudah Didisposisi -->
    <div class="col-xl-3 col-md-6 mb-3">
        <a href="<?= site_url('sekretariat/disposisi') ?>" class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-icon teal">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <div class="stat-card-title">Sudah Didisposisi</div>
            </div>
            <div class="stat-card-value"><?= esc($total_disposisi) ?></div>
            <div class="stat-card-desc">Ke kepala bidang</div>
        </a>
    </div>
</div>

<!-- Content Row: Pending List + Chart + Summary -->
<div class="row">

    <!-- Permohonan Menunggu Verifikasi Berkas -->
    <div class="col-lg-7 mb-4">
        <div class="chart-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="card-title mb-0">Permohonan Menunggu Verifikasi Berkas</div>
                <span class="pending-badge"><?= $total_verifikasi ?> pending</span>
            </div>

            <?php if (!empty($permohonan_pending)) : ?>
                <?php foreach ($permohonan_pending as $p) : ?>
                    <div class="pending-item">
                        <div class="pending-avatar teal">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="pending-info">
                            <div class="pending-name"><?= esc($p->nama_mahasiswa ?? '-') ?></div>
                            <div class="pending-detail">
                                <?= esc($p->nim ?? '-') ?> · <?= esc($p->jenis_permohonan ?? '-') ?> · <?= !empty($p->tgl_pengajuan) ? date('d M Y', strtotime($p->tgl_pengajuan)) : '-' ?>
                            </div>
                        </div>
                        <div class="pending-actions">
                            <span class="status-badge menunggu">Menunggu</span>
                            <a href="<?= base_url('sekretariat/verifikasi/detail/' . $p->id_persetujuan_magang) ?>" class="action-icon view" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                    <p class="mb-0">Tidak ada permohonan yang menunggu verifikasi.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Right Column: Distribusi + Ringkasan -->
    <div class="col-lg-5 mb-4">
        <!-- Distribusi Jenis Permohonan -->
        <div class="chart-card mb-4">
            <div class="card-title">Distribusi Jenis Permohonan</div>
            <div class="chart-container" style="height: 180px;">
                <canvas id="donutChart"></canvas>
            </div>
            <ul class="chart-legend mt-3">
                <?php
                $colors = ['#1a73e8', '#28a745', '#f5a623', '#f04438', '#6f42c1', '#17a2b8'];
                $i = 0;
                foreach ($distribusi_jenis as $dj) :
                    $color = $colors[$i % count($colors)];
                ?>
                    <li>
                        <span>
                            <span class="chart-legend-dot" style="background-color: <?= $color ?>;"></span>
                            <span class="chart-legend-label"><?= esc($dj['label']) ?></span>
                        </span>
                        <span class="chart-legend-value"><?= $dj['persen'] ?>%</span>
                    </li>
                <?php $i++; endforeach; ?>
            </ul>
        </div>

        <!-- Ringkasan Hari Ini -->
        <div class="summary-card">
            <div class="card-title">Ringkasan Hari Ini</div>
            <div class="summary-item">
                <span class="summary-label">Permohonan masuk baru</span>
                <span class="summary-value blue"><?= $ringkasan['masuk'] ?></span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Berkas diverifikasi</span>
                <span class="summary-value green"><?= $ringkasan['verifikasi'] ?></span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Didisposisi ke bidang</span>
                <span class="summary-value teal"><?= $ringkasan['disposisi'] ?></span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Dikembalikan / ditolak</span>
                <span class="summary-value red"><?= $ringkasan['ditolak'] ?></span>
            </div>
        </div>
    </div>
</div>

<!-- Tren Permohonan Bulanan -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="chart-card">
            <div class="card-title">Tren Permohonan Bulanan</div>
            <div class="tren-chart-container">
                <canvas id="trenChart"></canvas>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// ============================================================
// DONUT CHART - Distribusi Jenis Permohonan
// ============================================================
(function() {
    const donutCtx = document.getElementById('donutChart');
    if (!donutCtx) return;

    const distribusiData = <?= json_encode($distribusi_jenis) ?>;
    const colors = ['#1a73e8', '#28a745', '#f5a623', '#f04438', '#6f42c1', '#17a2b8'];

    new Chart(donutCtx, {
        type: 'doughnut',
        data: {
            labels: distribusiData.map(d => d.label),
            datasets: [{
                data: distribusiData.map(d => d.total),
                backgroundColor: colors.slice(0, distribusiData.length),
                borderWidth: 2,
                borderColor: '#fff',
                hoverOffset: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1d2939',
                    titleFont: { family: 'Inter', size: 13 },
                    bodyFont: { family: 'Inter', size: 12 },
                    padding: 10,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + ' permohonan';
                        }
                    }
                }
            }
        }
    });
})();

// ============================================================
// LINE CHART - Tren Permohonan Bulanan
// ============================================================
(function() {
    const trenCtx = document.getElementById('trenChart');
    if (!trenCtx) return;

    const labels = <?= json_encode($tren_labels) ?>;
    const trenData = <?= json_encode($tren_bulanan) ?>;

    new Chart(trenCtx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Masuk',
                    data: trenData.map(t => t.masuk),
                    borderColor: '#1a8a6a',
                    backgroundColor: 'rgba(26, 138, 106, 0.08)',
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#1a8a6a',
                    pointHoverRadius: 6,
                },
                {
                    label: 'Disetujui',
                    data: trenData.map(t => t.disetujui),
                    borderColor: '#28a745',
                    borderWidth: 2,
                    fill: false,
                    tension: 0.4,
                    pointRadius: 3,
                    pointBackgroundColor: '#28a745',
                    pointHoverRadius: 5,
                },
                {
                    label: 'Ditolak',
                    data: trenData.map(t => t.ditolak),
                    borderColor: '#f04438',
                    borderWidth: 2,
                    borderDash: [5, 5],
                    fill: false,
                    tension: 0.4,
                    pointRadius: 3,
                    pointBackgroundColor: '#f04438',
                    pointHoverRadius: 5,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index',
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { family: 'Inter', size: 12 },
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle',
                    }
                },
                tooltip: {
                    backgroundColor: '#1d2939',
                    titleFont: { family: 'Inter', size: 13 },
                    bodyFont: { family: 'Inter', size: 12 },
                    padding: 10,
                    cornerRadius: 8,
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { family: 'Inter', size: 12 }, color: '#98a2b3' }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#f2f4f7' },
                    ticks: {
                        font: { family: 'Inter', size: 12 },
                        color: '#98a2b3',
                        stepSize: 9,
                    }
                }
            }
        }
    });
})();
</script>
<?= $this->endSection() ?>
