<?= $this->extend('layout/L_master_superadmin') ?>

<?= $this->section('title') ?><?= esc($title ?? 'instansi_pendidikan index') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    .status-switch .form-check-input {
        width: 44px;
        height: 22px;
        background-color: #ced4da;
        border-color: #ced4da;
        cursor: pointer;
        transition: background-color 0.2s ease, border-color 0.2s ease, background-position 0.15s ease-in-out;
    }
    .status-switch .form-check-input:checked {
        background-color: #28a745;
        border-color: #28a745;
    }
    .status-switch .form-check-input:focus {
        box-shadow: none;
    }
</style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Master Data Instansi Pendidikan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('superadmin/dashboard') ?>">Master Data</a></li>
                    <li class="breadcrumb-item active">Instansi Pendidikan</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        <!-- ============================================ -->
        <!-- EDIT VIEW (Full Page - Hidden by default) -->
        <!-- ============================================ -->
        <div class="card shadow-sm d-none" id="editContainer">
            <div class="card-header bg-warning text-white">
                <h3 class="card-title mb-0"><i class="fas fa-edit me-2"></i> Edit Instansi Pendidikan</h3>
            </div>
            <form id="formEditInline" class="form-confirm-update" action="" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label for="edit_instansi_pendidikan" class="form-label fw-bold">Nama Instansi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_instansi_pendidikan" name="instansi_pendidikan" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_jenis_instansi" class="form-label fw-bold">Jenis Instansi <span class="text-danger">*</span></label>
                                <select class="form-select" id="edit_jenis_instansi" name="jenis_instansi" required>
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="negeri">Negeri</option>
                                    <option value="swasta">Swasta</option>
                                </select>
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

        <!-- ============================================ -->
        <!-- LIST VIEW (Table) -->
        <!-- ============================================ -->
        <div class="card shadow-sm" id="tableContainer">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0"><i class="fas fa-list me-2"></i> Daftar Instansi Pendidikan</h3>
                <div class="card-tools ms-auto d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="location.reload();">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <a href="<?= base_url('superadmin/instansi-pendidikan/create') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Instansi Pendidikan
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Instansi</th>
                                <th>Jenis</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($instansiList)) : ?>
                                <?php foreach ($instansiList as $key => $row) : ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= esc($row['instansi_pendidikan']) ?></td>
                                        <td><?= esc($row['jenis_instansi']) ?></td>
                                        <td>
                                            <?php if($row['status'] == 'AKTIF'): ?>
    <span class="badge bg-success">Aktif</span>
<?php else: ?>
    <span class="badge bg-danger">Tidak Aktif</span>
<?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1 justify-content-center">
                                                <button type="button" class="btn btn-sm btn-warning text-white btn-edit" 
                                                    data-id="<?= $row['id_instansi_pendidikan'] ?>" 
                                                    data-instansi="<?= esc($row['instansi_pendidikan']) ?>" 
                                                    data-jenis="<?= esc($row['jenis_instansi']) ?>" 
                                                    data-status="<?= $row['status'] ?>" 
                                                    title="Edit"><i class="fas fa-edit"></i></button>
                                                <button type="button" class="btn btn-sm btn-danger btn-hapus" 
                                                    data-url="<?= base_url('superadmin/instansi-pendidikan/delete/' . $row['id_instansi_pendidikan']) ?>" 
                                                    title="Hapus"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data instansi pendidikan.</td>
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
    // Edit button handler - populate form and show full-page edit
    document.querySelectorAll('.btn-edit').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            var instansi = this.getAttribute('data-instansi');
            var jenis = this.getAttribute('data-jenis');
            var status = this.getAttribute('data-status');

            document.getElementById('formEditInline').action = '<?= base_url('superadmin/instansi-pendidikan/update') ?>/' + id;
            document.getElementById('edit_instansi_pendidikan').value = instansi;
            document.getElementById('edit_jenis_instansi').value = jenis;
            if (status === 'AKTIF' || status == '1') {
                document.getElementById('edit_status').value = 'AKTIF';
            } else {
                document.getElementById('edit_status').value = 'NONAKTIF';
            }

            showEditState();
        });
    });
});
</script>
<?= $this->endSection() ?>
