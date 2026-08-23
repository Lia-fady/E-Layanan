<?= $this->extend('layout/L_master_superadmin') ?>

<?= $this->section('title') ?><?= esc($title ?? 'manajemen_menu') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Manajemen Menu</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('superadmin/dashboard') ?>">Master Data</a></li>
                    <li class="breadcrumb-item active">Manajemen Menu</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        <!-- EDIT VIEW (Full Page) -->
        <div class="card shadow-sm d-none" id="editContainer">
            <div class="card-header bg-warning text-white">
                <h3 class="card-title mb-0"><i class="fas fa-edit me-2"></i> Edit Menu</h3>
            </div>
            <form id="formEditInline" class="form-confirm-update" action="" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label for="edit_name" class="form-label fw-bold">Nama Menu <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_icon" class="form-label fw-bold">Icon</label>
                                <input type="text" class="form-control" id="edit_icon" name="icon" placeholder="Contoh: fas fa-home">
                            </div>
                            <div class="mb-3">
                                <label for="edit_url" class="form-label fw-bold">URL/Route <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_url" name="url" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="edit_position" class="form-label fw-bold">Urutan</label>
                                    <input type="number" class="form-control" id="edit_position" name="position">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold d-block">Status Aktif</label>
                                    <select class="form-select" id="edit_status" name="status" required>
    <option value="1">Aktif</option>
    <option value="0">Tidak Aktif</option>
</select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="alert alert-info">
                                <h5><i class="icon fas fa-info"></i> Informasi</h5>
                                Pastikan data yang diubah sudah benar sebelum menyimpan perubahan.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-cancel-edit">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </button>
                    <button type="submit" class="btn btn-warning text-white ms-auto">
                        <i class="fas fa-save me-1"></i> Update Data
                    </button>
                </div>
            </form>
        </div>

        <!-- LIST VIEW -->
        <div class="card shadow-sm" id="tableContainer">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0"><i class="fas fa-list me-2"></i> Daftar Menu</h3>
                <div class="card-tools ms-auto d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="location.reload();">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahMenu">
                        <i class="fas fa-plus"></i> Tambah Menu
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Menu</th>
                                <th>Icon</th>
                                <th>URL/Route</th>
                                <th>Urutan</th>
                                <th>Status Aktif</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($menuList)) : ?>
                                <?php foreach ($menuList as $key => $row) : ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= esc($row['name']) ?></td>
                                        <td><i class="<?= esc($row['icon']) ?>"></i> <?= esc($row['icon']) ?></td>
                                        <td><?= esc($row['url']) ?></td>
                                        <td><?= esc($row['position']) ?></td>
                                        <td>
                                            <select class="form-select" id="<?= $row['id'] ?>" name="<?= esc($row['name']) ?>" required>
    <option value="1" selected>Aktif</option>
    <option value="0">Tidak Aktif</option>
</select>
            </div>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(function() {
    $('.btn-edit').on('click', function() {
        let id = $(this).data('id');
        let name = $(this).data('name');
        let icon = $(this).data('icon');
        let url = $(this).data('url');
        let position = $(this).data('position');
        let status = $(this).data('status');

        $('#formEditInline').attr('action', '<?= base_url('superadmin/manajemen-menu/update') ?>/' + id);
        
        $('#edit_name').val(name);
        $('#edit_icon').val(icon);
        $('#edit_url').val(url);
        $('#edit_position').val(position);
        
        if (status == '1' || status == 1) {
            $('#edit_status').prop('checked', true);
        } else {
            $('#edit_status').prop('checked', false);
        }

        showEditState();
    });
});
</script>
<?= $this->endSection() ?>
