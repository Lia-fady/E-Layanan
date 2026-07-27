<?= $this->extend('layout/L_master_kabid') ?>

<?= $this->section('content') ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Logbook Mahasiswa</h1>
</div>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error'); ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Mahasiswa Aktif</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <thead class="bg-primary text-white">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama / NIM</th>
                        <th>Instansi / Prodi</th>
                        <th>Periode Magang</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($mahasiswa)): ?>
                    <tr>
                        <td colspan="5" class="text-center">Belum ada mahasiswa aktif di bidang Anda.</td>
                    </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($mahasiswa as $mhs): ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td>
                                <strong><?= esc($mhs->nama_mahasiswa) ?></strong><br>
                                <small class="text-muted"><?= esc($mhs->nim) ?></small>
                            </td>
                            <td>
                                <?= esc($mhs->instansi_pendidikan) ?><br>
                                <small class="text-muted"><?= esc($mhs->prodi) ?></small>
                            </td>
                            <td>
                                <?= date('d M Y', strtotime($mhs->tgl_mulai)) ?> s.d.<br>
                                <?= date('d M Y', strtotime($mhs->tgl_selesai)) ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('kabid/logbook/detail/' . $mhs->id_penempatan_magang) ?>" class="btn btn-sm btn-info" title="Lihat & Approve Logbook">
                                    <i class="fas fa-book-open"></i> Logbook
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
