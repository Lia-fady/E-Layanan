<?php
/**
 * Kode      : v_placeholder.php
 * Path      : Views/dashboard/sekretariat/v_placeholder.php
 * Deskripsi : View placeholder untuk halaman yang sedang dalam pengembangan.
 *             Digunakan untuk Permohonan Masuk, Laporan, dan Pengaturan.
 */
?>

<?= $this->extend('layout/L_master') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="placeholder-page">
    <div class="placeholder-page-icon">
        <i class="fas fa-chart-line"></i>
    </div>
    <h5><?= esc($title) ?></h5>
    <p>Halaman ini sedang dalam pengembangan.</p>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- Placeholder page scripts (if needed) -->
<?= $this->endSection() ?>
