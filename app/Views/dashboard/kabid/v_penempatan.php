<?php
/**
 * ============================================================
 * Kode      : v_penempatan.php
 * Path      : Views/dashboard/kabid/v_penempatan.php
 * Deskripsi : View halaman daftar penempatan yang menunggu
 *             persetujuan Kepala Bidang. Card-based layout
 *             dengan tombol Setujui dan Tolak.
 * ============================================================
 */
?>

<?= $this->extend('layout/L_master_kabid') ?>

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

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 style="font-weight:700; color:#1B2559; margin-bottom:4px;">Persetujuan Penempatan Magang</h5>
        <p style="color:#667085; font-size:0.85rem; margin:0;">
            Daftar penempatan mahasiswa yang menunggu persetujuan Anda.
        </p>
    </div>
</div>

<?php if (!empty($penempatan)) : ?>
    <?php foreach ($penempatan as $row) : ?>
        <div class="disposisi-card">
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

            <!-- Detail Info -->
            <div style="margin: 1rem 0; padding: 0.75rem; background: #F9FAFB; border-radius: 8px; font-size: 0.85rem;">
                <div class="row">
                    <div class="col-md-6">
                        <div style="margin-bottom:0.4rem;">
                            <strong style="color:#344054;">Bidang Tujuan:</strong>
                            <span style="color:#667085;"><?= esc($row->bidang ?? '-') ?></span>
                        </div>
                        <div style="margin-bottom:0.4rem;">
                            <strong style="color:#344054;">Periode:</strong>
                            <span style="color:#667085;">
                                <?= !empty($row->tgl_mulai) ? date('d M Y', strtotime($row->tgl_mulai)) : '-' ?>
                                s/d
                                <?= !empty($row->tgl_selesai) ? date('d M Y', strtotime($row->tgl_selesai)) : '-' ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div style="margin-bottom:0.4rem;">
                            <strong style="color:#344054;">Keahlian:</strong>
                            <span style="color:#667085;"><?= esc($row->deskripsi_keahlian ?? '-') ?></span>
                        </div>
                        <?php if (!empty($row->catatan)) : ?>
                        <div style="margin-bottom:0.4rem;">
                            <strong style="color:#344054;">Catatan Disposisi:</strong>
                            <span style="color:#667085;"><?= esc($row->catatan) ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex" style="gap:0.75rem;">
                <!-- Setujui -->
                <form action="<?= base_url('kabid/penempatan/setujui') ?>" method="POST" class="form-setujui">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_penempatan_magang" value="<?= $row->id_penempatan_magang ?>">
                    <button type="submit" class="btn-kirim-bidang" style="font-size:0.85rem; padding:0.5rem 1.25rem;">
                        <i class="fas fa-check mr-1"></i> Setujui Penempatan
                    </button>
                </form>

                <!-- Tolak -->
                <button type="button" class="btn-batal btn-tolak-penempatan"
                        style="font-size:0.85rem; padding:0.5rem 1.25rem; color:#DC2626; border-color:#DC2626;"
                        data-id="<?= $row->id_penempatan_magang ?>"
                        data-nama="<?= esc($row->nama_mahasiswa) ?>">
                    <i class="fas fa-times mr-1"></i> Tolak
                </button>
                
                <!-- Upload Surat Penerimaan -->
                <a href="<?= base_url('kabid/upload-surat-penerimaan/' . $row->id_persetujuan_magang) ?>"
                   class="btn-kirim-bidang" style="font-size:0.85rem; padding:0.5rem 1.25rem; background:#F0FDF4; color:#16A34A; border:1px solid #16A34A; text-decoration:none;">
                    <i class="fas fa-file-upload mr-1"></i> Surat
                </a>
            </div>
        </div>
    <?php endforeach; ?>
<?php else : ?>
    <div class="chart-card text-center py-5">
        <div class="placeholder-page-icon mx-auto mb-3">
            <i class="fas fa-check-circle"></i>
        </div>
        <h5>Tidak Ada Penempatan Menunggu</h5>
        <p class="text-muted">Semua penempatan telah diproses.</p>
    </div>
<?php endif; ?>

<!-- Modal Tolak -->
<div class="modal fade" id="modalTolak" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('kabid/penempatan/tolak') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id_penempatan_magang" id="tolak_id_penempatan">
                <div class="modal-header">
                    <h5 class="modal-title">Tolak Penempatan</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Anda akan menolak penempatan untuk <strong id="tolak_nama_mahasiswa"></strong>.</p>
                    <p class="text-muted" style="font-size:0.85rem;">
                        Permohonan akan dikembalikan ke Sekretariat untuk didisposisikan ulang ke bidang lain.
                    </p>
                    <div class="form-group">
                        <label for="catatan_tolak"><strong>Alasan Penolakan</strong></label>
                        <textarea class="form-control" name="catatan_tolak" id="catatan_tolak" rows="3"
                                  placeholder="Tulis alasan penolakan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times mr-1"></i> Tolak Penempatan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Konfirmasi setujui
    $('.form-setujui').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        Swal.fire({
            title: 'Konfirmasi Persetujuan',
            text: 'Setujui penempatan mahasiswa ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10B981',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Setujui!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // Modal tolak
    $('.btn-tolak-penempatan').on('click', function() {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        $('#tolak_id_penempatan').val(id);
        $('#tolak_nama_mahasiswa').text(nama);
        $('#catatan_tolak').val('');
        $('#modalTolak').modal('show');
    });
});
</script>

<?php if (session()->getFlashdata('success')) : ?>
<script>
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: '<?= session()->getFlashdata('success') ?>', timer: 3000 });
</script>
<?php endif; ?>
<?= $this->endSection() ?>
