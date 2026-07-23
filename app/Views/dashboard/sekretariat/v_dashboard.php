<?php
/**
 * Kode: v_dashboard.php
 * Path: app/Views/dashboard/sekretariat/v_dashboard.php
 * Deskripsi: View halaman Dashboard Sekretariat sesuai desain mockup.
 *            Menampilkan welcome card, 5 kartu statistik, daftar permohonan
 *            pending, donut chart status verifikasi, dan ringkasan hari ini.
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

<!-- Stat Cards Row (5 cards) -->
<div class="row mb-4">
    <!-- Total Permohonan -->
    <div class="col-xl col-md-6 mb-3">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-icon blue">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-card-title">Total Permohonan</div>
            </div>
            <div class="stat-card-value"><?= esc($total_permohonan) ?></div>
            <div class="stat-card-desc">Semua permohonan masuk</div>
            <a href="<?= site_url('sekretariat/riwayat') ?>" class="stat-card-link blue">
                Lihat Detail <i class="fas fa-chevron-right fa-xs"></i>
            </a>
        </div>
    </div>

    <!-- Menunggu Verifikasi -->
    <div class="col-xl col-md-6 mb-3">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-icon yellow">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-card-title">Menunggu Verifikasi</div>
            </div>
            <div class="stat-card-value"><?= esc($total_verifikasi) ?></div>
            <div class="stat-card-desc">Pemohon perlu diverifikasi</div>
            <a href="<?= site_url('sekretariat/verifikasi') ?>" class="stat-card-link yellow">
                Lihat Detail <i class="fas fa-chevron-right fa-xs"></i>
            </a>
        </div>
    </div>

    <!-- Disetujui -->
    <div class="col-xl col-md-6 mb-3">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-icon teal">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-card-title">Disetujui</div>
            </div>
            <div class="stat-card-value"><?= esc($total_disetujui) ?></div>
            <div class="stat-card-desc">Pemohon disetujui</div>
            <a href="<?= site_url('sekretariat/riwayat') ?>" class="stat-card-link teal">
                Lihat Detail <i class="fas fa-chevron-right fa-xs"></i>
            </a>
        </div>
    </div>

    <!-- Sedang Diproses oleh Bidang -->
    <div class="col-xl col-md-6 mb-3">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-icon green">
                    <i class="fas fa-spinner"></i>
                </div>
                <div class="stat-card-title">Sedang Diproses oleh Bidang</div>
            </div>
            <div class="stat-card-value"><?= esc($total_sedang_diproses) ?></div>
            <div class="stat-card-desc">Dalam proses</div>
            <a href="<?= site_url('sekretariat/verifikasi') ?>" class="stat-card-link green">
                Lihat Detail <i class="fas fa-chevron-right fa-xs"></i>
            </a>
        </div>
    </div>

    <!-- Mahasiswa Aktif -->
    <div class="col-xl col-md-6 mb-3">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-icon purple">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="stat-card-title">Mahasiswa Aktif</div>
            </div>
            <div class="stat-card-value"><?= esc($total_mahasiswa_aktif) ?></div>
            <div class="stat-card-desc">Sedang Magang</div>
            <a href="<?= site_url('sekretariat/riwayat') ?>" class="stat-card-link purple">
                Lihat Detail <i class="fas fa-chevron-right fa-xs"></i>
            </a>
        </div>
    </div>
</div>

<!-- Content Row: Pending List + Chart + Summary -->
<div class="row mb-4" style="padding-bottom: 1rem;">

    <!-- Permohonan Menunggu Verifikasi Berkas -->
    <div class="col-lg-7 mb-4">
        <div class="chart-card">
            <div class="card-title mb-3">Permohonan Menunggu Verifikasi berkas</div>

            <?php if (!empty($permohonan_pending)) : ?>
                <?php foreach ($permohonan_pending as $p) : ?>
                    <div class="pending-item">
                        <div class="pending-avatar navy">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="pending-info">
                            <div class="pending-name"><?= esc($p->nama_mahasiswa ?? '-') ?></div>
                            <div class="pending-detail">
                                <?= esc($p->nim ?? '-') ?> · <?= esc($p->jenis_permohonan ?? '-') ?> · <?= !empty($p->tgl_pengajuan) ? date('d M Y', strtotime($p->tgl_pengajuan)) : '-' ?>
                                <?= isset($p->total_berkas) ? $p->total_berkas . '/' . ($p->required_berkas ?? 3) . ' berkas diunggah' : '' ?>
                            </div>
                        </div>
                        <div class="pending-actions">
                            <a href="<?= base_url('sekretariat/verifikasi/detail/' . ($p->id_permohonan_magang ?? $p->id_persetujuan_magang)) ?>" class="status-badge menunggu-verifikasi" style="text-decoration:none;">
                                Menunggu Verifikasi
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

    <!-- Right Column: Chart + Ringkasan -->
    <div class="col-lg-5 mb-4">
        <!-- Ringkasan Permohonan -->
        <div class="chart-card mb-4">
            <div class="card-title">Ringkasan Permohonan</div>
            <div class="chart-container" style="height: 180px;">
                <canvas id="donutChart"></canvas>
            </div>
            <ul class="chart-legend mt-3">
                <?php
                $chartColors = ['#34A853', '#FFC107', '#EA4335'];
                $i = 0;
                foreach ($status_verifikasi as $sv) :
                    $color = $chartColors[$i % count($chartColors)];
                ?>
                    <li>
                        <span>
                            <span class="chart-legend-dot" style="background-color: <?= $color ?>;"></span>
                            <span class="chart-legend-label"><?= esc($sv['label']) ?></span>
                        </span>
                        <span class="chart-legend-value"><?= $sv['total'] ?> (<?= $sv['persen'] ?>%)</span>
                    </li>
                <?php $i++; endforeach; ?>
            </ul>
        </div>

        <!-- Ringkasan Hari Ini -->
        <div class="summary-card mb-4">
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
                <span class="summary-label">Perbaikan Berkas</span>
                <span class="summary-value red"><?= $ringkasan['ditolak'] ?></span>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Donut Chart - Ringkasan Permohonan
(function() {
    const donutCtx = document.getElementById('donutChart');
    if (!donutCtx) return;

    const statusData = <?= json_encode($status_verifikasi) ?>;
    const colors = ['#34A853', '#FFC107', '#EA4335'];
    const totalPermohonan = <?= (int)$total_permohonan_chart ?>;

    new Chart(donutCtx, {
        type: 'doughnut',
        data: {
            labels: statusData.map(d => d.label),
            datasets: [{
                data: statusData.map(d => d.total),
                backgroundColor: colors.slice(0, statusData.length),
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
                }
            }
        },
        plugins: [{
            id: 'centerText',
            beforeDraw: function(chart) {
                const {width, height, ctx} = chart;
                ctx.restore();
                const fontSize = (height / 6).toFixed(2);
                ctx.font = 'bold ' + fontSize + 'px Inter';
                ctx.textBaseline = 'middle';
                ctx.textAlign = 'center';
                ctx.fillStyle = '#1d2939';
                ctx.fillText(totalPermohonan, width / 2, height / 2 - 10);
                ctx.font = '11px Inter';
                ctx.fillStyle = '#98a2b3';
                ctx.fillText('Total Permohonan', width / 2, height / 2 + 14);
                ctx.save();
            }
        }]
    });
})();
</script>
<?= $this->endSection() ?>
