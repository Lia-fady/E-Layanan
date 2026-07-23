<?php
/**
 * ============================================================
 * Kode      : v_status_permohonan.php
 * Path      : Views/dashboard/sekretariat/v_status_permohonan.php
 * Deskripsi : Tampilan halaman status permohonan magang yang
 *             menampilkan tracking status verifikasi, disposisi,
 *             dan penempatan dalam bentuk DataTable
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

<!-- DataTable Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-clipboard-list mr-1"></i> Daftar Status Permohonan Magang
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover dataTable" id="tableStatusPermohonan" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Jenis Permohonan</th>
                        <th>Tgl Pengajuan</th>
                        <th class="text-center">Status Verifikasi</th>
                        <th class="text-center">Disposisi Bidang</th>
                        <th class="text-center">Status Penempatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($permohonan)) : ?>
                        <?php $no = 1; foreach ($permohonan as $row) : ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= esc($row['nim']) ?></td>
                                <td><?= esc($row['nama_mahasiswa']) ?></td>
                                <td><?= esc($row['jenis_permohonan']) ?></td>
                                <td><?= date('d-m-Y', strtotime($row['created_at'])) ?></td>
                                <td class="text-center">
                                    <?php if ($row['status_persetujuan'] === null) : ?>
                                        <span class="badge badge-secondary">Belum Diproses</span>
                                    <?php elseif ($row['status_persetujuan'] === 'MENUNGGU') : ?>
                                        <span class="badge badge-warning">MENUNGGU</span>
                                    <?php elseif ($row['status_persetujuan'] === 'DISETUJUI') : ?>
                                        <span class="badge badge-success">DISETUJUI</span>
                                    <?php elseif ($row['status_persetujuan'] === 'DITOLAK') : ?>
                                        <span class="badge badge-danger">DITOLAK</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($row['disposisi'] == '1' && !empty($row['bidang'])) : ?>
                                        <span class="badge badge-info"><?= esc($row['bidang']) ?></span>
                                    <?php else : ?>
                                        <span class="badge badge-secondary">Belum</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($row['status_penempatan'] === null) : ?>
                                        <span>-</span>
                                    <?php elseif ($row['status_penempatan'] === 'BERJALAN') : ?>
                                        <span class="badge badge-info">BERJALAN</span>
                                    <?php elseif ($row['status_penempatan'] === 'SELESAI') : ?>
                                        <span class="badge badge-success">SELESAI</span>
                                    <?php elseif ($row['status_penempatan'] === 'DIBATALKAN') : ?>
                                        <span class="badge badge-danger">DIBATALKAN</span>
                                    <?php endif; ?>
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
        $('#tableStatusPermohonan').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
            },
            "order": [],
            "responsive": true
        });
    });
</script>
<?= $this->endSection() ?>
