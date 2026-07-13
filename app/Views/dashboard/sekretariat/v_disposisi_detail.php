<?php
/**
 * ============================================================
 * Kode      : v_disposisi_detail.php
 * Path      : Views/dashboard/sekretariat/v_disposisi_detail.php
 * Deskripsi : View halaman pilih bidang tujuan disposisi.
 *             Form pemilihan bidang sesuai desain mockup.
 * ============================================================
 */
?>

<?= $this->extend('layout/L_master') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (!empty($permohonan)) : ?>

<!-- Back Link -->
<a href="<?= base_url('sekretariat/verifikasi') ?>" class="disposisi-back-link">
    <i class="fas fa-arrow-left"></i> Kembali Verifikasi Berkas
</a>

<!-- Disposition Form Card -->
<div class="disposisi-form-card">
    <div class="section-heading">Pilih Bidang Tujuan</div>
    <div class="section-subtext">Tentukan bidang tujuan dan kirim permohonan ke Kepala Bidang.</div>

    <!-- Informasi Permohonan -->
    <h6 style="font-weight:700; color:#344054; margin-bottom:0.8rem;">Informasi Permohonan</h6>
    <div class="disposisi-info-row">
        <span class="disposisi-info-label">Nama Mahasiswa</span>
        <span class="disposisi-info-value">: <?= esc($permohonan->nama_mahasiswa ?? '-') ?></span>
    </div>
    <div class="disposisi-info-row">
        <span class="disposisi-info-label">Universitas</span>
        <span class="disposisi-info-value">: <?= esc($permohonan->instansi_pendidikan ?? '-') ?></span>
    </div>
    <div class="disposisi-info-row">
        <span class="disposisi-info-label">Jenis Permohonan</span>
        <span class="disposisi-info-value">: <?= esc($permohonan->jenis_permohonan ?? '-') ?></span>
    </div>
    <div class="disposisi-info-row">
        <span class="disposisi-info-label">Tanggal Pengajuan</span>
        <span class="disposisi-info-value">: <?= !empty($permohonan->tgl_pengajuan) ? date('d F Y', strtotime($permohonan->tgl_pengajuan)) : '-' ?></span>
    </div>

    <hr style="margin: 1.5rem 0;">

    <!-- Form -->
    <form action="<?= base_url('sekretariat/disposisi/proses') ?>" method="POST" id="formDisposisi">
        <?= csrf_field() ?>
        <input type="hidden" name="id_persetujuan_magang" value="<?= $permohonan->id_persetujuan_magang ?>">

        <h6 style="font-weight:700; color:#344054; margin-bottom:0.8rem;">Pilih Bidang</h6>
        <div class="mb-4">
            <div class="disposisi-info-row">
                <span class="disposisi-info-label">Bidang</span>
                <span class="disposisi-info-value">:
                    <select class="disposisi-select" name="id_bidang" required style="display:inline-block; margin-left:8px;">
                        <option value="">Pilih Bidang</option>
                        <?php if (!empty($bidang)) : ?>
                            <?php foreach ($bidang as $b) : ?>
                                <option value="<?= $b->id_bidang ?>"><?= esc($b->bidang) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </span>
            </div>
        </div>

        <h6 style="font-weight:700; color:#344054; margin-bottom:0.8rem;">Catatan (opsional)</h6>
        <textarea class="disposisi-textarea" name="catatan_disposisi" placeholder="Tulis catatan jika diperlukan...." rows="4"></textarea>

        <div class="d-flex justify-content-end mt-4" style="gap:1rem;">
            <a href="<?= base_url('sekretariat/disposisi') ?>" class="btn-batal">Batal</a>
            <button type="submit" class="btn-kirim-bidang">Kirim Ke Kepala Bidang</button>
        </div>
    </form>
</div>

<?php else : ?>
<div class="alert alert-warning">
    <i class="fas fa-exclamation-triangle mr-2"></i>
    Data permohonan tidak ditemukan.
</div>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('#formDisposisi').on('submit', function(e) {
        var bidang = $('select[name="id_bidang"]').val();
        if (!bidang) {
            e.preventDefault();
            Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Silakan pilih bidang tujuan disposisi.' });
            return false;
        }
        e.preventDefault();
        var bidangText = $('select[name="id_bidang"] option:selected').text();
        Swal.fire({
            title: 'Konfirmasi Disposisi',
            html: 'Kirim permohonan ini ke bidang:<br><strong>' + bidangText + '</strong>?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2563EB',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Kirim!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
