<?php
/**
 * ============================================================
 * Kode      : v_verifikasi.php
 * Path      : Views/dashboard/sekretariat/v_verifikasi.php
 * Deskripsi : View halaman daftar permohonan masuk untuk
 *             modul Verifikasi Administrasi. Menampilkan
 *             tabel data permohonan dengan DataTables.
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
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-0">
            <li class="breadcrumb-item"><a href="<?= base_url('sekretariat/dashboard') ?>">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Verifikasi Administrasi</li>
        </ol>
    </nav>
</div>

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

<!-- DataTable Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-clipboard-check mr-2"></i>Daftar Permohonan Masuk
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover dataTable" id="tabelVerifikasi" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Jenis Permohonan</th>
                        <th>Tanggal Pengajuan</th>
                        <th width="12%" class="text-center">Status</th>
                        <th width="10%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($permohonan)) : ?>
                        <?php $no = 1; foreach ($permohonan as $row) : ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= esc($row->nim) ?></td>
                            <td><?= esc($row->nama_mahasiswa) ?></td>
                            <td><?= esc($row->jenis_permohonan) ?></td>
                            <td><?= date('d-m-Y', strtotime($row->tgl_pengajuan)) ?></td>
                            <td class="text-center">
                                <?php
                                    $status = $row->status_persetujuan ?? 'MENUNGGU';
                                    $badge  = 'warning';
                                    if ($status == 'DISETUJUI') $badge = 'success';
                                    elseif ($status == 'DITOLAK') $badge = 'danger';
                                ?>
                                <span class="badge badge-<?= $badge ?>"><?= $status ?></span>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('sekretariat/verifikasi/detail/' . $row->id_permohonan_magang) ?>"
                                   class="btn btn-info btn-sm" title="Lihat Detail">
                                    <i class="fas fa-eye"></i> Detail
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
    $('#tabelVerifikasi').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
        },
        "order": [[4, "desc"]]
    });
});
</script>

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
<?= $this->endSection() ?>
