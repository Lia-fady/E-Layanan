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

<!-- Page Description -->
<div class="mb-4">
    <h5 style="font-weight:700; color:#1B2559; margin-bottom:4px;">Status Permohonan</h5>
    <p style="color:#667085; font-size:0.9rem; margin:0;">
        Pantau status verifikasi dan penempatan permohonan magang secara detail.
    </p>
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
                        <th class="text-center">Tujuan Bidang</th>
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
                                    <?php elseif ($row['status_penempatan'] === 'DISETUJUI') : ?>
                                        <span class="badge badge-primary">DISETUJUI</span>
                                    <?php elseif ($row['status_penempatan'] === 'BERJALAN') : ?>
                                        <span class="badge badge-info">BERJALAN</span>
                                    <?php elseif ($row['status_penempatan'] === 'SELESAI') : ?>
                                        <span class="badge badge-success">SELESAI</span>
                                    <?php elseif ($row['status_penempatan'] === 'DITOLAK') : ?>
                                        <span class="badge badge-danger">DITOLAK</span>
                                    <?php elseif ($row['status_penempatan'] === 'DIBATALKAN') : ?>
                                        <span class="badge badge-warning">DIBATALKAN</span>
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
            "decimal": "",
            "emptyTable": "Tidak ada data yang tersedia",
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
            "infoFiltered": "(disaring dari _MAX_ total entri)",
            "lengthMenu": "Tampilkan _MENU_ entri",
            "loadingRecords": "Memuat...",
            "processing": "Memproses...",
            "search": "Cari:",
            "zeroRecords": "Tidak ditemukan data yang cocok",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Selanjutnya",
                "previous": "Sebelumnya"
            },
            "aria": {
                "sortAscending": ": aktifkan untuk mengurutkan kolom secara ascending",
                "sortDescending": ": aktifkan untuk mengurutkan kolom secara descending"
            }
        },
            "order": [],
            "responsive": true
        });
    });
</script>
<?= $this->endSection() ?>
