<?php
/**
 * ============================================================
 * Kode      : v_dashboard_kabid.php
 * Path      : Views/dashboard/kabid/v_dashboard_kabid.php
 * Deskripsi : View halaman dashboard Kepala Bidang.
 *             Menampilkan stat cards penempatan dan daftar
 *             penempatan menunggu persetujuan.
 * ============================================================
 */
?>

<?= $this->extend('layout/L_master_kabid') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Welcome Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 style="font-weight:700; color:#1B2559; margin-bottom:4px;">Dashboard Kepala Bidang</h4>
        <p style="color:#667085; font-size:0.9rem; margin:0;">
            <?= $tanggalFormatted ?? '' ?>
            <?php if (!empty($bidang_info)) : ?>
                &mdash; <strong><?= esc($bidang_info->bidang) ?></strong>
            <?php endif; ?>
        </p>
    </div>
</div>

<!-- Stat Cards -->
<div class="row mb-4">
    <!-- Menunggu Persetujuan -->
    <div class="col-xl-4 col-md-6 mb-3">
        <div class="stat-card" style="border-left: 4px solid #F59E0B;">
            <div class="stat-card-body">
                <div class="stat-card-title" style="color:#F59E0B;">MENUNGGU PERSETUJUAN</div>
                <div class="stat-card-value"><?= $total_menunggu ?></div>
            </div>
            <div class="stat-card-icon" style="color:#F59E0B;">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>

    <!-- Sedang Berjalan -->
    <div class="col-xl-4 col-md-6 mb-3">
        <div class="stat-card" style="border-left: 4px solid #2563EB;">
            <div class="stat-card-body">
                <div class="stat-card-title" style="color:#2563EB;">SEDANG BERJALAN</div>
                <div class="stat-card-value"><?= $total_berjalan ?></div>
            </div>
            <div class="stat-card-icon" style="color:#2563EB;">
                <i class="fas fa-user-graduate"></i>
            </div>
        </div>
    </div>

    <!-- Selesai -->
    <div class="col-xl-4 col-md-6 mb-3">
        <div class="stat-card" style="border-left: 4px solid #10B981;">
            <div class="stat-card-body">
                <div class="stat-card-title" style="color:#10B981;">SELESAI</div>
                <div class="stat-card-value"><?= $total_selesai ?></div>
            </div>
            <div class="stat-card-icon" style="color:#10B981;">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>
</div>

<!-- Penempatan Menunggu Persetujuan -->
<div class="chart-card">
    <div class="chart-card-header">
        <h6 class="chart-card-title">Penempatan Menunggu Persetujuan</h6>
        <a href="<?= base_url('kabid/penempatan') ?>" style="color:#2563EB; font-size:0.85rem; text-decoration:none;">
            Lihat Semua <i class="fas fa-arrow-right" style="font-size:0.7rem;"></i>
        </a>
    </div>

    <?php if (!empty($penempatan_menunggu)) : ?>
        <?php foreach ($penempatan_menunggu as $row) : ?>
            <div class="disposisi-card" style="margin-bottom:0.75rem;">
                <div class="disposisi-card-header">
                    <span class="disposisi-id">PNM-<?= str_pad($row->id_penempatan_magang, 3, '0', STR_PAD_LEFT) ?></span>
                    <span class="disposisi-status" style="color:#F59E0B;">
                        <i class="fas fa-clock"></i> Menunggu Persetujuan
                    </span>
                </div>
                <div class="disposisi-card-name"><?= esc($row->nama_mahasiswa) ?></div>
                <div class="disposisi-card-detail">
                    <?= esc($row->nim) ?> · <?= esc($row->jenis_permohonan ?? '-') ?> · <?= esc($row->instansi_pendidikan ?? '-') ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <div class="text-center py-4">
            <i class="fas fa-check-circle" style="font-size:2rem; color:#10B981; margin-bottom:0.5rem;"></i>
            <p class="text-muted">Tidak ada penempatan yang menunggu persetujuan.</p>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
