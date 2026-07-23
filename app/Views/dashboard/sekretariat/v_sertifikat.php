<?php
/**
 * ============================================================
 * Kode      : v_sertifikat.php
 * Path      : Views/dashboard/sekretariat/v_sertifikat.php
 * Deskripsi : Tampilan halaman daftar sertifikat magang untuk
 *             mahasiswa yang sudah menyelesaikan magang,
 *             dengan opsi download/cetak sertifikat
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
</div>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle mr-1"></i>
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle mr-1"></i>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<!-- DataTable Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-certificate mr-1"></i> Daftar Sertifikat Magang
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover dataTable" id="tableSertifikat" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Bidang</th>
                        <th>Periode Magang</th>
                        <th width="12%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($magang)) : ?>
                        <?php $no = 1; foreach ($magang as $row) : ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= esc($row['nim']) ?></td>
                                <td><?= esc($row['nama_mahasiswa']) ?></td>
                                <td><?= esc($row['bidang']) ?></td>
                                <td>
                                    <?php if (!empty($row['tgl_mulai']) && !empty($row['tgl_selesai'])) : ?>
                                        <?= date('d-m-Y', strtotime($row['tgl_mulai'])) ?> s/d <?= date('d-m-Y', strtotime($row['tgl_selesai'])) ?>
                                    <?php else : ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('sekretariat/sertifikat/download/' . $row['id_penempatan_magang']) ?>"
                                       class="btn btn-success btn-sm"
                                       target="_blank"
                                       title="Download Sertifikat">
                                        <i class="fas fa-download mr-1"></i> Download
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
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
        $('#tableSertifikat').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
            },
            "order": [],
            "responsive": true
        });
    });
</script>
<?= $this->endSection() ?>
