<?php
/**
 * ============================================================
 * Kode      : v_penilaian_form.php
 * Path      : Views/dashboard/sekretariat/v_penilaian_form.php
 * Deskripsi : Tampilan form penilaian magang per mahasiswa,
 *             menampilkan informasi mahasiswa dan tabel input
 *             nilai untuk setiap komponen penilaian
 * ============================================================
 */

$title = $title ?? 'Form Penilaian';
$id_penempatan = $id_penempatan ?? '';
$detail = $detail ?? [];
$komponen = $komponen ?? [];
$nilaiIndexed = $nilaiIndexed ?? [];
?>

<?= $this->extend('layout/L_master') ?>

<?= $this->section('title') ?>
<?= esc($title) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= esc($title) ?></h1>
    <a href="<?= base_url('sekretariat/penilaian') ?>" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>
</div>

<!-- Info Mahasiswa Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-user-graduate mr-1"></i> Informasi Mahasiswa
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless table-sm">
                    <tr>
                        <td width="40%"><strong>Nama Mahasiswa</strong></td>
                        <td width="5%">:</td>
                        <td><?= esc($detail['nama_mahasiswa'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td><strong>NIM</strong></td>
                        <td>:</td>
                        <td><?= esc($detail['nim'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td><strong>Bidang Penempatan</strong></td>
                        <td>:</td>
                        <td><?= esc($detail['bidang'] ?? '-') ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless table-sm">
                    <tr>
                        <td width="40%"><strong>Periode Magang</strong></td>
                        <td width="5%">:</td>
                        <td>
                            <?php if (!empty($detail['tgl_mulai']) && !empty($detail['tgl_selesai'])) : ?>
                                <?= date('d-m-Y', strtotime($detail['tgl_mulai'])) ?> s/d <?= date('d-m-Y', strtotime($detail['tgl_selesai'])) ?>
                            <?php else : ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>:</td>
                        <td>
                            <?php if (($detail['status_penempatan'] ?? '') === 'BERJALAN') : ?>
                                <span class="badge badge-info">BERJALAN</span>
                            <?php elseif (($detail['status_penempatan'] ?? '') === 'SELESAI') : ?>
                                <span class="badge badge-success">SELESAI</span>
                            <?php else : ?>
                                <span class="badge badge-secondary"><?= esc($detail['status_penempatan'] ?? '-') ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Form Penilaian Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-clipboard-check mr-1"></i> Form Penilaian
        </h6>
    </div>
    <div class="card-body">
        <form action="<?= base_url('sekretariat/penilaian/simpan') ?>" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="id_penempatan_magang" value="<?= esc($id_penempatan) ?>">

            <div class="table-responsive">
                <table class="table table-bordered" id="tableFormPenilaian">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th>Komponen Penilaian</th>
                            <th width="20%" class="text-center">Nilai (0 - 100)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($komponen)) : ?>
                            <?php $no = 1; foreach ($komponen as $kp) : ?>
                                <?php
                                    $existingNilai = $nilaiIndexed[$kp['id_komponen_penilaian']] ?? '';
                                ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= esc($kp['komponen_penilaian']) ?></td>
                                    <td class="text-center">
                                        <input type="number"
                                               class="form-control text-center"
                                               name="nilai[<?= $kp['id_komponen_penilaian'] ?>]"
                                               value="<?= esc($existingNilai) ?>"
                                               min="0"
                                               max="100"
                                               step="0.01"
                                               placeholder="0.00">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted">
                                    Belum ada komponen penilaian yang tersedia.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if (!empty($komponen)) : ?>
                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Simpan Nilai
                    </button>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Validasi input nilai secara real-time
        $('input[type="number"]').on('input', function() {
            var val = parseFloat($(this).val());
            if (val < 0) $(this).val(0);
            if (val > 100) $(this).val(100);
        });
    });
</script>
<?= $this->endSection() ?>
