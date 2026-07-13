<?php
/**
 * ============================================================
 * Kode      : v_disposisi.php
 * Path      : Views/dashboard/sekretariat/v_disposisi.php
 * Deskripsi : View halaman disposisi ke bidang sesuai desain Figma.
 *             Menampilkan card-based layout dengan dropdown bidang
 *             dari tabel m_bidang dan catatan disposisi.
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
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle mr-2"></i>
    <?= session()->getFlashdata('error') ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php endif; ?>

<!-- Info Banner -->
<div class="disposisi-info-banner">
    <i class="fas fa-paper-plane"></i>
    <p>Permohonan yang telah diverifikasi dapat didisposisikan ke Kepala Bidang yang sesuai untuk penempatan mahasiswa.</p>
</div>

<!-- Disposisi Cards -->
<?php if (!empty($permohonan)) : ?>
    <?php foreach ($permohonan as $row) : ?>
        <div class="disposisi-card">
            <!-- Header: ID + Status -->
            <div class="disposisi-card-header">
                <span class="disposisi-id">PMH-<?= date('Y', strtotime($row->tgl_pengajuan ?? 'now')) ?>-<?= str_pad($row->id_persetujuan_magang, 3, '0', STR_PAD_LEFT) ?></span>
                <span class="disposisi-status">
                    <i class="fas fa-check-circle"></i> Berkas Terverifikasi
                </span>
            </div>

            <!-- Name & Details -->
            <div class="disposisi-card-name"><?= esc($row->nama_mahasiswa) ?></div>
            <div class="disposisi-card-detail">
                <?= esc($row->nim) ?> · <?= esc($row->jenis_permohonan) ?> · <?= !empty($row->tgl_pengajuan) ? date('d M Y', strtotime($row->tgl_pengajuan)) : '-' ?>
            </div>

            <!-- Form Disposisi -->
            <form action="<?= base_url('sekretariat/disposisi/proses') ?>" method="POST" class="formDisposisiInline">
                <?= csrf_field() ?>
                <input type="hidden" name="id_persetujuan_magang" value="<?= $row->id_persetujuan_magang ?>">

                <!-- Tujuan Disposisi -->
                <div class="mb-3">
                    <label class="disposisi-form-label">Tujuan Disposisi — Kepala Bidang</label>
                    <select class="disposisi-select" name="id_bidang" required>
                        <option value="">Pilih Kepala Bidang...</option>
                        <?php if (!empty($bidang)) : ?>
                            <?php foreach ($bidang as $b) : ?>
                                <option value="<?= $b->id_bidang ?>"><?= esc($b->bidang) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Catatan Disposisi -->
                <div class="mb-3">
                    <label class="disposisi-form-label">Catatan Disposisi</label>
                    <textarea class="disposisi-textarea" name="catatan_disposisi" placeholder="Catatan untuk kepala bidang..." rows="3"></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-disposisi">
                    <i class="fas fa-paper-plane"></i> Kirim Disposisi ke Kepala Bidang
                </button>
            </form>
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
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '<?= session()->getFlashdata('success') ?>',
        showConfirmButton: true,
        timer: 3000
    });
</script>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '<?= session()->getFlashdata('error') ?>',
        showConfirmButton: true
    });
</script>
<?php endif; ?>

<script>
$(document).ready(function() {
    // Konfirmasi sebelum submit disposisi
    $('.formDisposisiInline').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var bidangText = $(form).find('select[name="id_bidang"] option:selected').text();
        var bidangVal = $(form).find('select[name="id_bidang"]').val();

        if (!bidangVal) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Silakan pilih bidang tujuan disposisi.'
            });
            return false;
        }

        Swal.fire({
            title: 'Konfirmasi Disposisi',
            html: 'Disposisi permohonan ini ke bidang:<br><strong>' + bidangText + '</strong>?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1a8a6a',
            cancelButtonColor: '#858796',
            confirmButtonText: 'Ya, Disposisi!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
