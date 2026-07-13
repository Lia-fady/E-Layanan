<?php
/**
 * ============================================================
 * Kode      : v_disposisi_detail.php
 * Path      : Views/dashboard/sekretariat/v_disposisi_detail.php
 * Deskripsi : View halaman detail disposisi ke bidang.
 *             Menampilkan data permohonan yang sudah disetujui
 *             dan form pemilihan bidang untuk disposisi.
 * ============================================================
 */
?>

<?= $this->extend('layout/L_master') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
    <a href="<?= base_url('sekretariat/disposisi') ?>" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>
</div>

<?php if (!empty($permohonan)) : ?>

<!-- Card: Data Permohonan -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-file-alt mr-2"></i>Data Permohonan
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td width="40%"><strong>NIM</strong></td>
                        <td width="5%">:</td>
                        <td><?= esc($permohonan->nim) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Nama Mahasiswa</strong></td>
                        <td>:</td>
                        <td><?= esc($permohonan->nama_mahasiswa) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Jenis Kelamin</strong></td>
                        <td>:</td>
                        <td><?= esc($permohonan->jenis_kelamin ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td><strong>Email</strong></td>
                        <td>:</td>
                        <td><?= esc($permohonan->email ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td><strong>No. Telp</strong></td>
                        <td>:</td>
                        <td><?= esc($permohonan->no_telp ?? '-') ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td width="40%"><strong>Jenis Permohonan</strong></td>
                        <td width="5%">:</td>
                        <td><?= esc($permohonan->jenis_permohonan) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Instansi Pendidikan</strong></td>
                        <td>:</td>
                        <td><?= esc($permohonan->instansi_pendidikan ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td><strong>Deskripsi Keahlian</strong></td>
                        <td>:</td>
                        <td><?= esc($permohonan->deskripsi_keahlian ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Mulai</strong></td>
                        <td>:</td>
                        <td><?= !empty($permohonan->tgl_mulai) ? date('d-m-Y', strtotime($permohonan->tgl_mulai)) : '-' ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Selesai</strong></td>
                        <td>:</td>
                        <td><?= !empty($permohonan->tgl_selesai) ? date('d-m-Y', strtotime($permohonan->tgl_selesai)) : '-' ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <?php if (!empty($permohonan->deskripsi_magang)) : ?>
        <div class="mt-2 p-3 bg-light rounded">
            <strong>Deskripsi Magang:</strong><br>
            <?= esc($permohonan->deskripsi_magang) ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Card: Form Disposisi -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-share-square mr-2"></i>Form Disposisi ke Bidang
        </h6>
    </div>
    <div class="card-body">
        <form action="<?= base_url('sekretariat/disposisi/proses') ?>" method="POST" id="formDisposisi">
            <?= csrf_field() ?>
            <input type="hidden" name="id_persetujuan_magang" value="<?= $permohonan->id_persetujuan_magang ?>">

            <div class="form-group">
                <label for="id_bidang"><strong>Pilih Bidang</strong> <span class="text-danger">*</span></label>
                <select class="form-control" id="id_bidang" name="id_bidang" required>
                    <option value="">-- Pilih Bidang --</option>
                    <?php if (!empty($bidang)) : ?>
                        <?php foreach ($bidang as $b) : ?>
                            <option value="<?= $b->id_bidang ?>"
                                <?= (isset($permohonan->id_bidang) && $permohonan->id_bidang == $b->id_bidang) ? 'selected' : '' ?>>
                                <?= esc($b->bidang) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <hr>
            <div class="text-right">
                <a href="<?= base_url('sekretariat/disposisi') ?>" class="btn btn-secondary mr-2">
                    <i class="fas fa-arrow-left mr-1"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary" id="btnSubmitDisposisi">
                    <i class="fas fa-save mr-1"></i> Simpan Disposisi
                </button>
            </div>
        </form>
    </div>
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
    // Konfirmasi sebelum submit
    $('#formDisposisi').on('submit', function(e) {
        var bidang = $('#id_bidang').val();
        if (!bidang) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Silakan pilih bidang tujuan disposisi.'
            });
            return false;
        }

        e.preventDefault();
        var bidangText = $('#id_bidang option:selected').text();

        Swal.fire({
            title: 'Konfirmasi Disposisi',
            html: 'Disposisi permohonan ini ke bidang:<br><strong>' + bidangText + '</strong>?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4e73df',
            cancelButtonColor: '#858796',
            confirmButtonText: 'Ya, Disposisi!',
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
