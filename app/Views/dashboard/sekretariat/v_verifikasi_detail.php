<?php
/**
 * ============================================================
 * Kode      : v_verifikasi_detail.php
 * Path      : Views/dashboard/sekretariat/v_verifikasi_detail.php
 * Deskripsi : View halaman detail permohonan untuk verifikasi.
 *             Menampilkan data mahasiswa, data permohonan,
 *             dokumen yang diupload, dan form verifikasi
 *             (setujui / tolak).
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
    <a href="<?= base_url('sekretariat/verifikasi') ?>" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>
</div>

<?php if (!empty($permohonan)) : ?>

<!-- Row: Data Mahasiswa & Data Permohonan -->
<div class="row">

    <!-- Card: Data Mahasiswa -->
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user-graduate mr-2"></i>Data Mahasiswa
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td width="40%"><strong>NIM</strong></td>
                        <td width="5%">:</td>
                        <td><?= esc($permohonan->nim) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Nama</strong></td>
                        <td>:</td>
                        <td><?= esc($permohonan->nama_mahasiswa) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Jenis Kelamin</strong></td>
                        <td>:</td>
                        <td><?= esc($permohonan->jenis_kelamin) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Email</strong></td>
                        <td>:</td>
                        <td><?= esc($permohonan->email) ?></td>
                    </tr>
                    <tr>
                        <td><strong>No. Telp</strong></td>
                        <td>:</td>
                        <td><?= esc($permohonan->no_telp) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Instansi Pendidikan</strong></td>
                        <td>:</td>
                        <td><?= esc($permohonan->instansi_pendidikan ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td><strong>Fakultas</strong></td>
                        <td>:</td>
                        <td><?= esc($permohonan->fakultas ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td><strong>Program Studi</strong></td>
                        <td>:</td>
                        <td><?= esc($permohonan->prodi ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td><strong>Jenjang</strong></td>
                        <td>:</td>
                        <td><?= esc($permohonan->jenjang_pendidikan ?? '-') ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Card: Data Permohonan -->
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-file-alt mr-2"></i>Data Permohonan
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td width="40%"><strong>Jenis Permohonan</strong></td>
                        <td width="5%">:</td>
                        <td><?= esc($permohonan->jenis_permohonan) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Deskripsi Keahlian</strong></td>
                        <td>:</td>
                        <td><?= esc($permohonan->deskripsi_keahlian ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td><strong>Deskripsi Magang</strong></td>
                        <td>:</td>
                        <td><?= esc($permohonan->deskripsi_magang ?? '-') ?></td>
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
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>:</td>
                        <td>
                            <?php
                                $status = $permohonan->status_persetujuan ?? 'MENUNGGU';
                                $badge  = 'warning';
                                if ($status == 'DISETUJUI') $badge = 'success';
                                elseif ($status == 'DITOLAK') $badge = 'danger';
                            ?>
                            <span class="badge badge-<?= $badge ?>"><?= $status ?></span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Card: Dokumen yang Diupload -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-paperclip mr-2"></i>Dokumen yang Diupload
        </h6>
    </div>
    <div class="card-body">
        <?php if (!empty($files)) : ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%">
                <thead class="thead-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>Jenis Dokumen</th>
                        <th>Nama File</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($files as $file) : ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= esc($file->nama_file_master ?? '-') ?></td>
                        <td><?= esc($file->nama_file_upload ?? '-') ?></td>
                        <td class="text-center">
                            <?php if (!empty($file->path_file)) : ?>
                                <a href="<?= base_url($file->path_file) ?>" target="_blank"
                                   class="btn btn-success btn-sm" title="Download / Lihat">
                                    <i class="fas fa-download"></i> Unduh
                                </a>
                            <?php else : ?>
                                <span class="text-muted">Tidak tersedia</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else : ?>
            <div class="text-center text-muted py-3">
                <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>
                Tidak ada dokumen yang diupload.
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Card: Form Verifikasi -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-check-double mr-2"></i>Form Verifikasi
        </h6>
    </div>
    <div class="card-body">
        <form action="<?= base_url('sekretariat/verifikasi/proses') ?>" method="POST" id="formVerifikasi">
            <?= csrf_field() ?>
            <input type="hidden" name="id_permohonan_magang" value="<?= $permohonan->id_permohonan_magang ?>">

            <div class="form-group">
                <label for="catatan"><strong>Catatan</strong></label>
                <textarea class="form-control" id="catatan" name="catatan" rows="4"
                          placeholder="Tuliskan catatan verifikasi..."><?= esc($permohonan->catatan ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label><strong>Keputusan Verifikasi</strong> <span class="text-danger">*</span></label>
                <div class="mt-2">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="statusSetuju" name="status_persetujuan"
                               value="DISETUJUI" class="custom-control-input" required>
                        <label class="custom-control-label text-success font-weight-bold" for="statusSetuju">
                            <i class="fas fa-check-circle mr-1"></i> DISETUJUI
                        </label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="statusTolak" name="status_persetujuan"
                               value="DITOLAK" class="custom-control-input" required>
                        <label class="custom-control-label text-danger font-weight-bold" for="statusTolak">
                            <i class="fas fa-times-circle mr-1"></i> DITOLAK
                        </label>
                    </div>
                </div>
            </div>

            <hr>
            <div class="text-right">
                <a href="<?= base_url('sekretariat/verifikasi') ?>" class="btn btn-secondary mr-2">
                    <i class="fas fa-arrow-left mr-1"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary" id="btnSubmitVerifikasi">
                    <i class="fas fa-save mr-1"></i> Simpan Verifikasi
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
    $('#formVerifikasi').on('submit', function(e) {
        var status = $('input[name="status_persetujuan"]:checked').val();
        if (!status) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Silakan pilih keputusan verifikasi terlebih dahulu.'
            });
            return false;
        }

        e.preventDefault();
        var statusText = (status === 'DISETUJUI') ? 'menyetujui' : 'menolak';
        var statusIcon = (status === 'DISETUJUI') ? 'success' : 'warning';

        Swal.fire({
            title: 'Konfirmasi Verifikasi',
            text: 'Apakah Anda yakin ingin ' + statusText + ' permohonan ini?',
            icon: statusIcon,
            showCancelButton: true,
            confirmButtonColor: '#4e73df',
            cancelButtonColor: '#858796',
            confirmButtonText: 'Ya, Simpan!',
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
