<?= $this->extend('layout/V_Master_Bidang') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 style="font-weight:700; color:#1B2559; margin-bottom:4px;">Logbook Mahasiswa</h5>
        <p style="color:#667085; font-size:0.85rem; margin:0;">
            Pantau dan setujui catatan aktivitas harian mahasiswa di bidang Anda.
        </p>
    </div>
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
    </div>
    <div class="card-body">
        <form method="get" action="<?= base_url('kabid/logbook') ?>" class="mb-4">
            <div class="row">
                <div class="col-md-3 mb-2">
                    <input type="text" name="search" class="form-control" placeholder="Cari Nama / NIM..." value="<?= esc($search ?? '') ?>">
                </div>
                <div class="col-md-3 mb-2">
                    <select name="jenis_permohonan" class="form-control">
                        <option value="">-- Semua Jenis Permohonan --</option>
                        <?php if (isset($list_jenis)): ?>
                            <?php foreach($list_jenis as $j): ?>
                                <option value="<?= $j['id_jenis_permohonan'] ?>" <?= (isset($jenis_permohonan) && $jenis_permohonan == $j['id_jenis_permohonan']) ? 'selected' : '' ?>>
                                    <?= esc($j['jenis_permohonan']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <select name="status_filter" class="form-control">
                        <option value="">-- Semua Status --</option>
                        <option value="BERJALAN" <?= (isset($status_filter) && $status_filter == 'BERJALAN') ? 'selected' : '' ?>>Berjalan</option>
                        <option value="SELESAI" <?= (isset($status_filter) && $status_filter == 'SELESAI') ? 'selected' : '' ?>>Selesai</option>
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Terapkan</button>
                    <a href="<?= base_url('kabid/logbook') ?>" class="btn btn-secondary"><i class="fas fa-sync"></i> Reset</a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-primary text-white">
                    <tr>
                        <th width="5%" class="text-center align-middle">No</th>
                        <th class="text-center align-middle">Nama / NIM</th>
                        <th class="text-center align-middle">Instansi / Prodi</th>
                        <th class="text-center align-middle">Jenis Permohonan</th>
                        <th class="text-center align-middle">Periode</th>
                        <th class="text-center align-middle">Status</th>
                        <th width="15%" class="text-center align-middle">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($mahasiswa)): ?>
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data mahasiswa yang sesuai.</td>
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
                                <span class="badge badge-info"><?= esc($mhs->jenis_permohonan ?? 'Belum Ditentukan') ?></span>
                            </td>
                            <td>
                                <?= date('d M Y', strtotime($mhs->tgl_mulai)) ?> s.d.<br>
                                <?= date('d M Y', strtotime($mhs->tgl_selesai)) ?>
                            </td>
                            <td>
                                <?php if (($mhs->status_penempatan ?? '') == 'SELESAI'): ?>
                                    <span class="badge badge-success">Selesai</span>
                                <?php else: ?>
                                    <span class="badge badge-primary">Berjalan</span>
                                <?php endif; ?>
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

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        searching: false,
        paging: true,
        info: true
    });
});
</script>
<?= $this->endSection() ?>
