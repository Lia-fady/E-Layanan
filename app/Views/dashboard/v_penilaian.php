<?php
/**
 * ============================================================
 * Kode      : v_penilaian.php
 * Path      : Views/dashboard/sekretariat/v_penilaian.php
 * Deskripsi : Tampilan halaman daftar mahasiswa magang yang
 *             aktif atau selesai untuk dilakukan penilaian
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
            <i class="fas fa-star mr-1"></i> Daftar Penilaian Magang
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover dataTable" id="tablePenilaian" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Bidang</th>
                        <th class="text-center">Status</th>
                        <th width="10%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($mahasiswa)) : ?>
                        <?php $no = 1; foreach ($mahasiswa as $row) : ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= esc($row['nim']) ?></td>
                                <td><?= esc($row['nama_mahasiswa']) ?></td>
                                <td><?= esc($row['bidang']) ?></td>
                                <td class="text-center">
                                    <?php if ($row['status_penempatan'] === 'BERJALAN') : ?>
                                        <span class="badge badge-info">BERJALAN</span>
                                    <?php elseif ($row['status_penempatan'] === 'SELESAI') : ?>
                                        <span class="badge badge-success">SELESAI</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('sekretariat/penilaian/form/' . $row['id_penempatan_magang']) ?>"
                                       class="btn btn-primary btn-sm"
                                       title="Beri Nilai">
                                        <i class="fas fa-edit mr-1"></i> Nilai
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
        $('#tablePenilaian').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
            },
            "order": [],
            "responsive": true
        });
    });
</script>
<?= $this->endSection() ?>
