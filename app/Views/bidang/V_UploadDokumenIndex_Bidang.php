<?php
/**
 * View untuk Index Upload Surat Penerimaan Magang (Kabid)
 */
?>
<?= $this->extend('layout/V_Master_Bidang') ?>

<?= $this->section('title') ?>
<?= esc($title) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')) : ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle mr-2"></i>
    <?= session()->getFlashdata('success') ?>
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')) : ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle mr-2"></i>
    <?= session()->getFlashdata('error') ?>
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 style="font-weight:700; color:#1B2559; margin-bottom:4px;">Daftar Dokumen Kegiatan</h5>
        <p style="color:#667085; font-size:0.85rem; margin:0;">
            Kelola dokumen pendukung seperti surat keterangan diterima dan sertifikat selesai kegiatan.
        </p>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Dokumen Kegiatan</h6>
    </div>
    <div class="card-body">
        <form method="get" action="<?= base_url('kabid/upload-dokumen') ?>" class="mb-4">
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
                    <select name="status_penempatan" class="form-control">
                        <option value="">-- Semua Status --</option>
                        <option value="BERJALAN" <?= (isset($status_penempatan) && $status_penempatan == 'BERJALAN') ? 'selected' : '' ?>>Aktif (Berjalan)</option>
                        <option value="SELESAI" <?= (isset($status_penempatan) && $status_penempatan == 'SELESAI') ? 'selected' : '' ?>>Selesai</option>
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Terapkan</button>
                    <a href="<?= base_url('kabid/upload-dokumen') ?>" class="btn btn-secondary"><i class="fas fa-sync"></i> Reset</a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-primary text-white">
                    <tr>
                        <th width="5%" class="text-center align-middle">No</th>
                        <th class="text-center align-middle">Nama</th>
                        <th class="text-center align-middle">NIM</th>
                        <th class="text-center align-middle">Asal Instansi</th>
                        <th class="text-center align-middle">Jenis Permohonan</th>
                        <th class="text-center align-middle">Periode</th>
                        <th class="text-center align-middle">Status</th>
                        <th width="15%" class="text-center align-middle">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($persetujuan)) : ?>
                        <?php $no = 1; foreach ($persetujuan as $p) : ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= esc($p->nama_mahasiswa ?? '-') ?></td>
                            <td><?= esc($p->nim ?? '-') ?></td>
                            <td>
                                <?= esc($p->instansi_pendidikan ?? '-') ?><br>
                                <small class="text-muted"><?= esc($p->prodi ?? '-') ?></small>
                            </td>
                            <td>
                                <span class="badge badge-info"><?= esc($p->jenis_permohonan ?? 'Belum Ditentukan') ?></span>
                            </td>
                            <td>
                                <?php
                                    $mulai = !empty($p->tgl_mulai) ? date('d M Y', strtotime($p->tgl_mulai)) : '-';
                                    $selesai = !empty($p->tgl_selesai) ? date('d M Y', strtotime($p->tgl_selesai)) : '-';
                                ?>
                                <?= $mulai ?> s/d <?= $selesai ?>
                            </td>
                            <td>
                                <?php if($p->status_penempatan == 'SELESAI'): ?>
                                    <span class="badge badge-success">Selesai</span>
                                <?php else: ?>
                                    <span class="badge badge-primary">Aktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('kabid/upload-dokumen/form/' . $p->id_persetujuan_magang) ?>" class="btn btn-sm btn-primary" title="Kelola Dokumen">
                                    <i class="fas fa-upload mr-1"></i> Kelola Dokumen
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                Tidak ada data permohonan yang sesuai.
                            </td>
                        </tr>
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
