<?php
/**
 * ============================================================
 * Kode      : v_disposisi.php
 * Path      : Views/dashboard/sekretariat/v_disposisi.php
 * Deskripsi : View halaman daftar permohonan yang siap
 *             didisposisikan ke bidang.
 * ============================================================
 */
?>

<?= $this->extend('layout/L_master') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')) : ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle mr-2"></i>
    <?= session()->getFlashdata('success') ?>
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')) : ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle mr-2"></i>
    <?= session()->getFlashdata('error') ?>
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
<?php endif; ?>

<?php if (!empty($permohonan)) : ?>
    <?php foreach ($permohonan as $row) : ?>
        <div class="disposisi-card">
            <div class="disposisi-card-header">
                <span class="disposisi-id">PMH-<?= date('Y', strtotime($row->tgl_pengajuan ?? 'now')) ?>-<?= str_pad($row->id_persetujuan_magang, 3, '0', STR_PAD_LEFT) ?></span>
                <span class="disposisi-status">
                    <i class="fas fa-check-circle"></i> Berkas Terverifikasi
                </span>
            </div>
            <div class="disposisi-card-name"><?= esc($row->nama_mahasiswa) ?></div>
            <div class="disposisi-card-detail">
                <?= esc($row->nim) ?> · <?= esc($row->jenis_permohonan) ?> · <?= !empty($row->tgl_pengajuan) ? date('d M Y', strtotime($row->tgl_pengajuan)) : '-' ?>
            </div>
            <a href="<?= base_url('sekretariat/disposisi/detail/' . $row->id_persetujuan_magang) ?>" class="btn-verifikasi">
                <i class="fas fa-share-square"></i> Pilih Bidang Tujuan
            </a>
        </div>
    <?php endforeach; ?>
<?php else : ?>
    <div class="chart-card text-center py-5">
        <div class="placeholder-page-icon mx-auto mb-3">
            <i class="fas fa-check-circle"></i>
        </div>
        <h5>Tidak Ada Permohonan</h5>
        <p class="text-muted">Semua permohonan telah didisposisikan ke bidang.</p>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?php if (session()->getFlashdata('success')) : ?>
<script>
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: '<?= session()->getFlashdata('success') ?>', timer: 3000 });
</script>
<?php endif; ?>
<?= $this->endSection() ?>
