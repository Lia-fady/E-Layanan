<?= $this->extend('layout/L_master'); ?>

<?php $penempatan = isset($penempatan) ? $penempatan : []; ?>

<?= $this->section('content'); ?>
<h1 class="h3 mb-4 text-gray-800">Daftar Penempatan Magang</h1>

<div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive">
      <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Nama Mahasiswa</th>
                    <th>Deskripsi Magang</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Status / Catatan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($penempatan as $p): ?>
                <tr>
                    <td><?= esc($p['nama_mahasiswa'] ?? ($p['nama_mahasiswa'] ?? '')); ?></td>
                    <td><?= esc($p['deskripsi_magang'] ?? $p['deskripsi_magang'] ?? ''); ?></td>
                    <td><?= esc($p['tgl_mulai'] ?? ''); ?></td>
                    <td><?= esc($p['tgl_selesai'] ?? ''); ?></td>
                    <td>
                        <div class="mb-1"><strong><?= esc($p['status_penempatan'] ?? '-'); ?></strong></div>
                        <div class="small text-muted mb-2"><?= esc($p['catatan'] ?? ''); ?></div>

                        <div class="d-flex justify-content-end">
                          <?php $idpen = esc($p['id_penempatan_magang'] ?? $p['id_penempatan'] ?? ''); ?>

                          <div class="btn-group btn-group-sm" role="group" aria-label="Aksi penempatan">
                            <!-- Edit (modal) -->
                            <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#modalEditPenempatan" data-id="<?= $idpen ?>" data-status="<?= esc($p['status_penempatan'] ?? '') ?>" data-catatan="<?= esc($p['catatan'] ?? '') ?>" title="Ubah">
                                <i class="fas fa-edit"></i>
                              </button>

                            <!-- Set BERJALAN -->
                                <form method="post" action="<?= base_url('sekretariat/c_kabid/simpan_penempatan') ?>" class="m-0" onsubmit="return confirm('Yakin set BERJALAN untuk penempatan ini?')">
                              <?= csrf_field() ?>
                              <input type="hidden" name="id_penempatan" value="<?= $idpen ?>">
                              <input type="hidden" name="status_penempatan" value="BERJALAN">
                              <button class="btn btn-outline-success" type="submit" title="Set BERJALAN">
                                <i class="fas fa-play"></i>
                              </button>
                            </form>

                            <!-- Set SELESAI -->
                                <form method="post" action="<?= base_url('sekretariat/c_kabid/simpan_penempatan') ?>" class="m-0" onsubmit="return confirm('Yakin set SELESAI untuk penempatan ini?')">
                              <?= csrf_field() ?>
                              <input type="hidden" name="id_penempatan" value="<?= $idpen ?>">
                              <input type="hidden" name="status_penempatan" value="SELESAI">
                              <button class="btn btn-outline-primary" type="submit" title="Set SELESAI">
                                <i class="fas fa-flag-checkered"></i>
                              </button>
                            </form>

                            <!-- Set DIBATALKAN -->
                                <form method="post" action="<?= base_url('sekretariat/c_kabid/simpan_penempatan') ?>" class="m-0" onsubmit="return confirm('Yakin batalkan penempatan ini?')">
                              <?= csrf_field() ?>
                              <input type="hidden" name="id_penempatan" value="<?= $idpen ?>">
                              <input type="hidden" name="status_penempatan" value="DIBATALKAN">
                              <button class="btn btn-outline-danger" type="submit" title="Set Dibatalkan">
                                <i class="fas fa-times"></i>
                              </button>
                            </form>
                          </div>
                        </div>

                        <!-- Single dynamic modal (populated via JS) -->
                        <?php /* modal placeholder will be rendered once below the table */ ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>

    <!-- Single Edit Modal -->
    <div class="modal fade" id="modalEditPenempatan" tabindex="-1" role="dialog" aria-labelledby="modalEditPenempatanLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalEditPenempatanLabel">Edit Penempatan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="post" action="<?= base_url('sekretariat/c_kabid/simpan_penempatan') ?>">
            <div class="modal-body">
                <?= csrf_field() ?>
                <input type="hidden" name="id_penempatan" id="modal_id_penempatan" value="">

                <div class="form-group">
                    <label>Status</label>
                    <select name="status_penempatan" id="modal_status_penempatan" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="BERJALAN">BERJALAN</option>
                        <option value="SELESAI">SELESAI</option>
                        <option value="DIBATALKAN">DIBATALKAN</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Catatan</label>
                    <textarea name="catatan" id="modal_catatan" class="form-control" rows="3"></textarea>
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
</div>
</div>
<?= $this->endSection(); ?>

<?php // Modal handler moved to public/js/kabid.js ?>
