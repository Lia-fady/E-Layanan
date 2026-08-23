<?= $this->extend('layout/L_master_superadmin') ?>

<?= $this->section('title') ?><?= esc($title ?? 'user_mahasiswa index') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Master Data User Mahasiswa</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('superadmin/dashboard') ?>">Master Data</a></li>
                    <li class="breadcrumb-item active">User Mahasiswa</li>
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
                <h3 class="card-title mb-0"><i class="fas fa-edit me-2"></i> Edit User Mahasiswa</h3>
            </div>
            <form id="formEditInline" class="form-confirm-update" action="" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label for="edit_mahasiswa" class="form-label fw-bold">Mahasiswa</label>
                                <input type="text" class="form-control" id="edit_mahasiswa" name="mahasiswa" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="edit_username" class="form-label fw-bold">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_password" class="form-label fw-bold">Password</label>
                                <input type="password" class="form-control" id="edit_password" name="password" placeholder="Kosongkan jika tidak diubah">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold d-block">Status</label>
                                <select class="form-select" id="edit_status" name="status" required>
    <option value="AKTIF">AKTIF</option>
    <option value="NONAKTIF">Tidak Aktif</option>
</select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="alert alert-info">
                                <h5><i class="icon fas fa-info"></i> Informasi</h5>
                                Kosongkan field password jika tidak ingin mengubah password user.
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
                <h3 class="card-title mb-0"><i class="fas fa-list me-2"></i> Daftar User Mahasiswa</h3>
                <div class="card-tools ms-auto d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="location.reload();">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <a href="<?= base_url('superadmin/user-mahasiswa/create') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah User Mahasiswa
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Mahasiswa</th>
                                <th>Username</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($userMahasiswaList)) : ?>
                                <?php foreach ($userMahasiswaList as $key => $row) : ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= esc($row['nama_mahasiswa'] ?? '-') ?></td>
                                        <td><?= esc($row['username']) ?></td>
                                        <td>
                                            <?php if($row['status'] == 'AKTIF' || $row['status'] == '1'): ?>
    <span class="badge bg-success">Aktif</span>
<?php else: ?>
    <span class="badge bg-danger">Tidak Aktif</span>
<?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1 justify-content-center">
                                                <button type="button" class="btn btn-sm btn-warning text-white btn-edit" 
                                                    data-id="<?= $row['id_user_mahasiswa'] ?>" 
                                                    data-nama="<?= esc($row['nama_mahasiswa'] ?? '-') ?>" 
                                                    data-username="<?= esc($row['username']) ?>" 
                                                    data-status="<?= $row['status'] ?>" 
                                                    title="Edit"><i class="fas fa-edit"></i></button>
                                                <button type="button" class="btn btn-sm btn-danger btn-hapus" 
                                                    data-url="<?= base_url('superadmin/user-mahasiswa/delete/' . $row['id_user_mahasiswa']) ?>" 
                                                    title="Hapus"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data user mahasiswa.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-edit').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            var nama = this.getAttribute('data-nama');
            var username = this.getAttribute('data-username');
            var status = this.getAttribute('data-status');

            document.getElementById('formEditInline').action = '<?= base_url('superadmin/user-mahasiswa/update') ?>/' + id;
            document.getElementById('edit_mahasiswa').value = nama;
            document.getElementById('edit_username').value = username;
            document.getElementById('edit_password').value = '';
            document.getElementById('edit_status').checked = (status === 'AKTIF' || status == '1');

            showEditState();
        });
    });
});
</script>
<?= $this->endSection() ?>
