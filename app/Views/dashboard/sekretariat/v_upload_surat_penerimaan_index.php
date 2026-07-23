<?php
/**
 * View untuk Index Upload Surat Penerimaan Magang (Sekretariat)
 */
?>
<?= $this->extend('layout/L_master') ?>

<?= $this->section('title') ?>
<?= esc($title) ?>
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

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Mahasiswa (Persetujuan Magang)</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>Nama Mahasiswa</th>
                        <th>NIM</th>
                        <th>Asal Kampus / Prodi</th>
                        <th>Periode Magang</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($persetujuan)) : ?>
                        <?php $no = 1; foreach ($persetujuan as $p) : ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= esc($p->nama_mahasiswa ?? '-') ?></td>
                            <td><?= esc($p->nim ?? '-') ?></td>
                            <td>
                                <?= esc($p->instansi_pendidikan ?? '-') ?><br>
                                <small class="text-muted"><?= esc($p->prodi ?? '-') ?></small>
                            </td>
                            <td>
                                <?php
                                    $mulai = !empty($p->tgl_mulai) ? date('d M Y', strtotime($p->tgl_mulai)) : '-';
                                    $selesai = !empty($p->tgl_selesai) ? date('d M Y', strtotime($p->tgl_selesai)) : '-';
                                ?>
                                <?= $mulai ?> s/d <?= $selesai ?>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-primary btn-upload-surat" data-id-persetujuan="<?= $p->id_persetujuan_magang ?>" title="Upload Surat">
                                    <i class="fas fa-file-upload mr-1"></i> Upload Surat
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Tidak ada data permohonan yang disetujui.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('#dataTable').DataTable();

    // Handle Upload Surat Button
    $('.btn-upload-surat').on('click', function(e) {
        e.preventDefault();
        var idPersetujuan = $(this).data('id-persetujuan');
        // Load the modal content via AJAX to display upload modal without leaving page
        $.ajax({
            url: "<?= base_url('sekretariat/upload-surat-penerimaan/form') ?>/" + idPersetujuan,
            type: "GET",
            success: function(response) {
                // If there's an existing modal, remove it
                $('#modalUploadSuratContainer').remove();
                $('body').append('<div id="modalUploadSuratContainer">' + response + '</div>');
                $('#modalUploadSurat').modal('show');
            },
            error: function() {
                Swal.fire({icon: 'error', title: 'Oops...', text: 'Gagal memuat form upload surat.'});
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
