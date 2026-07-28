<?= $this->extend('layout/L_master'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
            <h3 class="text-dark font-weight-bold mb-1">KELOLA BIDANG</h3>
            <p class="text-muted mb-0">Kelola dokumen penempatan dan monitoring bidang secara real-time.</p>
        </div>
        <a href="<?= base_url('sekretariat/c_kabid') ?>" onclick="alert('Semua keputusan berhasil disimpan!');" class="btn btn-primary font-weight-bold mt-3 mt-md-0" style="background-color: #4a90e2; border: none; border-radius: 999px; padding: 10px 24px;">
            <i class="fas fa-save mr-2"></i>Simpan Keputusan
        </a>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 14px;">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="text-dark font-weight-bold mb-0">Dokumen yang Diajukan</h5>
                <small class="text-muted">Data terupdate otomatis</small>
            </div>

            <?php if (empty($penempatan)): ?>
                <div class="alert alert-info mb-0 rounded-pill px-4 py-3 border-0">
                    <i class="fas fa-info-circle mr-2"></i>
                    <span>Belum ada data penempatan saat ini.</span>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background-color: #f3f5f8; color: #333;">
                            <tr>
                                <th style="width: 5%; text-align: center; border: none;" class="font-weight-bold py-3">NO</th>
                                <th style="width: 25%; border: none;" class="font-weight-bold py-3">Nama Dokumen</th>
                                <th style="width: 35%; border: none;" class="font-weight-bold py-3">Deskripsi</th>
                                <th style="width: 12%; text-align: center; border: none;" class="font-weight-bold py-3">Jumlah</th>
                                <th style="width: 23%; text-align: center; border: none;" class="font-weight-bold py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($penempatan as $p): ?>
                                <tr style="border-bottom: 1px solid #e3e8ef; transition: background-color 0.2s;">
                                    <td class="text-center py-3 font-weight-bold text-dark"><?= $no++; ?></td>
                                    <td class="py-3">
                                        <div class="font-weight-bold text-dark"><?= esc($p['nama_bidang'] ?? $p['nama_mahasiswa'] ?? '-') ?></div>
                                    </td>
                                    <td class="py-3 text-muted" style="font-size: 13px;">
                                        <?= esc(strlen($p['deskripsi_magang'] ?? $p['deskripsi'] ?? '-') > 50 ? substr($p['deskripsi_magang'] ?? $p['deskripsi'] ?? '-', 0, 50) . '...' : $p['deskripsi_magang'] ?? $p['deskripsi'] ?? '-') ?>
                                    </td>
                                    <td class="text-center py-3">
                                        <span class="badge px-3 py-2 text-white" style="background-color: #4a90e2; border-radius: 999px; font-size: 13px; font-weight: 600;">
                                            <?= esc($p['jumlah_penempatan'] ?? 0) ?>
                                        </span>
                                    </td>
                                    <td class="text-center py-3">
                                        <div class="d-flex justify-content-center" style="gap: 0.5rem;">
                                            <button type="button" class="btn btn-sm" style="background-color: #e8f0fe; border: 1px solid #4a90e2; color: #4a90e2; border-radius: 999px; padding: 6px 14px; font-size: 11px; font-weight: 600;" data-toggle="modal" data-target="#modalEditPenempatan" data-id="<?= esc($p['id_penempatan'] ?? $p['id_penempatan_magang'] ?? '') ?>">
                                                <i class="fas fa-edit mr-1"></i>Ubah
                                            </button>
                                            <button type="button" class="btn btn-sm" style="background-color: #fef2f0; border: 1px solid #f56745; color: #f56745; border-radius: 999px; padding: 6px 14px; font-size: 11px; font-weight: 600;" onclick="if(confirm('Apakah Anda yakin ingin menghapus data penempatan ini?')) window.location.href='<?= base_url('sekretariat/c_kabid/hapus_penempatan/' . esc($p['id_penempatan'] ?? $p['id_penempatan_magang'] ?? '')) ?>'">
                                                <i class="fas fa-trash-alt mr-1"></i>Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditPenempatan" tabindex="-1" role="dialog" aria-labelledby="modalEditPenempatanLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-lg border-0 shadow">
            <div class="modal-header border-0 pb-2" style="background-color: #f8f9fa;">
                <h5 class="modal-title font-weight-bold text-primary" id="modalEditPenempatanLabel">Ubah Status Penempatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?= base_url('sekretariat/c_kabid/simpan_penempatan') ?>">
                <?= csrf_field() ?>
                <input type="hidden" name="id_penempatan" id="edit_penempatan_id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_status_penempatan" class="font-weight-bold">Status Penempatan</label>
                        <select name="status_penempatan" id="edit_status_penempatan" class="form-control" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="BERJALAN">Berjalan</option>
                            <option value="SELESAI">Selesai</option>
                            <option value="DIBATALKAN">Dibatalkan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_catatan" class="font-weight-bold">Catatan</label>
                        <textarea name="catatan" id="edit_catatan" class="form-control" rows="3" placeholder="Masukkan catatan atau instruksi penempatan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0" style="background-color: #f8f9fa;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#modalEditPenempatan').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            $('#edit_penempatan_id').val(id || '');
        });
    });
</script>
<?= $this->endSection(); ?>