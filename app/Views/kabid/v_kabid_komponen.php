<?= $this->extend('layout/L_master'); ?>

<?= $this->section('content'); ?>
<h1 class="h3 mb-4 text-gray-800">Kelola Komponen Penilaian</h1>

<div class="card shadow mb-4">
  <div class="card-body">
    <div class="d-flex justify-content-between mb-3">
      <div></div>
      <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalKomponen" data-id="" data-nama="" data-status="1">Tambah Komponen</button>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Komponen</th>
            <th>Aktif</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach(($komponen ?? []) as $k): ?>
            <tr>
              <td><?= esc($k['id_komponen_penilaian'] ?? ''); ?></td>
              <td><?= esc($k['komponen_penilaian'] ?? ''); ?></td>
              <td><?= esc($k['status_aktif'] ?? ''); ?></td>
              <td>
                <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modalKomponen" data-id="<?= esc($k['id_komponen_penilaian']) ?>" data-nama="<?= esc($k['komponen_penilaian']) ?>" data-status="<?= esc($k['status_aktif']) ?>">Edit</button>
                <form method="post" action="<?= base_url('sekretariat/c_kabid/hapus_komponen') ?>" class="d-inline" onsubmit="return confirm('Hapus komponen ini?')">
                  <?= csrf_field() ?>
                  <input type="hidden" name="id_komponen_penilaian" value="<?= esc($k['id_komponen_penilaian']) ?>">
                  <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalKomponen" tabindex="-1" role="dialog" aria-labelledby="modalKomponenLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalKomponenLabel">Tambah / Edit Komponen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form method="post" action="<?= base_url('sekretariat/c_kabid/simpan_komponen') ?>">
        <?= csrf_field() ?>
        <div class="modal-body">
          <input type="hidden" name="id_komponen_penilaian" id="modal_komponen_id" value="">
          <div class="form-group">
            <label>Nama Komponen</label>
            <input type="text" name="komponen_penilaian" id="modal_komponen_nama" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Status Aktif</label>
            <select name="status_aktif" id="modal_komponen_status" class="form-control">
              <option value="1">Aktif</option>
              <option value="0">Tidak Aktif</option>
            </select>
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

<?= $this->endSection(); ?>

<?php $this->section('scripts') ?>
<script>
$(document).on('show.bs.modal', '#modalKomponen', function (event) {
  var button = $(event.relatedTarget);
  $('#modal_komponen_id').val(button.data('id') || '');
  $('#modal_komponen_nama').val(button.data('nama') || '');
  $('#modal_komponen_status').val(button.data('status') || '1');
});
</script>
<?php $this->endSection(); ?>
