<?= $this->extend('layout/L_master'); ?>

<?= $this->section('content'); ?>
<h1 class="h3 mb-4 text-gray-800">Penilaian Mahasiswa</h1>
<div class="mb-3">
    <a href="<?= base_url('sekretariat/c_kabid/komponen') ?>" class="btn btn-sm btn-outline-secondary">Kelola Komponen Penilaian</a>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <?php if (empty($penilaian) || empty($komponen)): ?>
            <p>Belum ada data penilaian. Silakan tambah fitur penilaian jika diperlukan.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Nama Mahasiswa</th>
                            <th>Deskripsi Magang</th>
                            <th>Komponen</th>
                            <th>Nilai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($penilaian as $item): ?>
                                <tr>
                                    <td><?= esc($item['nama_mahasiswa'] ?? '-'); ?></td>
                                    <td><?= esc($item['deskripsi_magang'] ?? '-'); ?></td>
                                    <td><?= esc($item['komponen_penilaian'] ?? '-'); ?></td>
                                    <td><?= esc($item['nilai'] ?? '-'); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalPenilaian"
                                            data-id-penilaian="<?= esc($item['id_penilaian_magang'] ?? '') ?>"
                                            data-id-penempatan="<?= esc($item['id_penempatan_magang'] ?? '') ?>"
                                            data-id-komponen="<?= esc($item['id_komponen_penilaian'] ?? '') ?>"
                                            data-nilai="<?= esc($item['nilai'] ?? '') ?>"
                                            data-komponen="<?= esc($item['komponen_penilaian'] ?? '-') ?>">
                                            Ubah
                                        </button>
                                    </td>
                                </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if (! empty($penilaian) && ! empty($komponen)): ?>
    <!-- Single dynamic modal for penilaian -->
    <div class="modal fade" id="modalPenilaian" tabindex="-1" role="dialog" aria-labelledby="modalPenilaianLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPenilaianLabel">Ubah Penilaian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="<?= base_url('sekretariat/c_kabid/simpan_penilaian') ?>">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_penempatan_magang" id="modal_penempatan_id" value="">
                    <input type="hidden" name="id_komponen_penilaian" id="modal_komponen_id" value="">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Komponen Penilaian</label>
                            <input type="text" id="modal_komponen_name" class="form-control" value="" disabled>
                        </div>
                        <div class="form-group">
                            <label>Nilai</label>
                            <input type="number" name="nilai" id="modal_nilai" class="form-control" min="0" max="100" value="" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>
<?= $this->endSection(); ?>
