<?= $this->extend('layout/L_master_superadmin') ?>

<?= $this->section('title') ?><?= esc($title ?? 'Manajemen Pengguna') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Manajemen Pengguna</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('superadmin/dashboard') ?>">Master Data</a></li>
                    <li class="breadcrumb-item active">Pengguna Pegawai</li>
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
                <h3 class="card-title mb-0"><i class="fas fa-edit me-2"></i> Edit Pengguna</h3>
            </div>
            <form id="formEditInline" class="form-confirm-update" action="" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label for="edit_nama" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_nama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_username" class="form-label fw-bold">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_username" name="nip" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_password" class="form-label fw-bold">Password</label>
                                <input type="password" class="form-control" id="edit_password" name="password" placeholder="Kosongkan jika tidak diubah">
                            </div>
                            <div class="mb-3">
                                <label for="edit_role" class="form-label fw-bold">Role <span class="text-danger">*</span></label>
                                <select class="form-select form-control" id="edit_role" name="id_user_group" required>
                                    <option value="">-- Role --</option>
                                    <?php if(isset($userGroups)): foreach($userGroups as $group): ?>
                                        <option value="<?= $group['id'] ?>"><?= esc($group['group']) ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold d-block">Status</label>
                                <select class="form-select" id="edit_status" name="status_aktif" required>
    <option value="AKTIF">AKTIF</option>
    <option value="NONAKTIF">Tidak Aktif</option>
</select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="alert alert-info">
                                <h5><i class="icon fas fa-info"></i> Informasi</h5>
                                Kosongkan field password jika tidak ingin mengubah password pengguna.
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
                <h3 class="card-title mb-0"><i class="fas fa-users me-2"></i> Daftar Pengguna Pegawai</h3>
                <div class="card-tools ms-auto d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="location.reload();">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPengguna">
                        <i class="fas fa-plus"></i> Tambah Pengguna
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle" id="userTable">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($users)): ?>
                                <?php $no = 1; foreach ($users as $u): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($u['nama']) ?></td>
                                    <td><?= esc($u['nip']) ?></td>
                                    <td>
                                        <span class="badge bg-secondary"><?= esc($u['nama_group'] ?? 'No Group') ?></span>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($u['status_aktif'] == 'aktif' || $u['status_aktif'] == '1' || $u['status_aktif'] == 'AKTIF'): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1 justify-content-center">
                                            <button class="btn btn-sm btn-warning text-white btn-edit" 
                                                data-id="<?= $u['id_user_pegawai'] ?>"
                                                data-nama="<?= esc($u['nama']) ?>"
                                                data-username="<?= esc($u['nip']) ?>"
                                                data-role="<?= esc($u['id_user_group']) ?>"
                                                data-status="<?= esc($u['status_aktif']) ?>"
                                                title="Edit"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-sm btn-danger btn-hapus" 
                                                data-id="<?= $u['id_user_pegawai'] ?>" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal" 
                                                title="Hapus"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data pengguna.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Tambah Pengguna -->
<div class="modal fade" id="modalTambahPengguna" tabindex="-1" aria-labelledby="modalTambahPenggunaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formTambahPengguna" action="<?= base_url('superadmin/manajemen-pengguna/store') ?>" method="post">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalTambahPenggunaLabel">Tambah Pengguna</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label for="nama" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nama" name="nama" required>
                <div class="invalid-feedback d-none text-danger">Nama Lengkap wajib diisi.</div>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label fw-bold">Username <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="username" name="nip" required>
                <div class="invalid-feedback d-none text-danger">Username wajib diisi.</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="password" name="password" required>
                <div class="invalid-feedback d-none text-danger">Password wajib diisi.</div>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label fw-bold">Role <span class="text-danger">*</span></label>
                <select class="form-select form-control" id="role" name="id_user_group" required>
                    <option value="">-- Pilih Role --</option>
                    <?php if(isset($userGroups)): foreach($userGroups as $group): ?>
                        <option value="<?= $group['id'] ?>"><?= esc($group['group']) ?></option>
                    <?php endforeach; endif; ?>
                </select>
                <div class="invalid-feedback d-none text-danger">Role wajib diisi.</div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold d-block">Status Aktif</label>
                <div class="form-check form-switch">
                    <input type="hidden" name="status_aktif" value="nonaktif">
                    <input class="form-check-input" type="checkbox" role="switch" id="statusAktifUser" name="status_aktif" value="aktif" checked>
                </div>
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
    // Edit button handler
    $('.btn-edit').on('click', function() {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        var username = $(this).data('username');
        var role = $(this).data('role');
        var status = $(this).data('status');

        $('#formEditInline').attr('action', '<?= base_url('superadmin/manajemen-pengguna/update') ?>/' + id);
        
        $('#edit_nama').val(nama);
        $('#edit_username').val(username);
        $('#edit_role').val(role);
        $('#edit_password').val('');
        
        if (status === 'AKTIF' || status == '1') {
    $('#edit_status').val = 'AKTIF';
} else {
    $('#edit_status').val = 'NONAKTIF';
}

        showEditState();
    });
});
</script>
<?= $this->endSection() ?>
