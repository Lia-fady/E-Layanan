<?= $this->extend('layout/L_master_superadmin') ?>

<?= $this->section('title') ?><?= esc($title ?? 'jenis_permohonan index') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Master Data Jenis Permohonan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('superadmin/dashboard') ?>">Master Data</a></li>
                    <li class="breadcrumb-item active">Jenis Permohonan</li>
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
                <h3 class="card-title mb-0"><i class="fas fa-edit me-2"></i> Edit Jenis Permohonan</h3>
            </div>
            <form id="formEditInline" class="form-confirm-update" action="" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label for="edit_jenis_permohonan" class="form-label fw-bold">Jenis Permohonan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_jenis_permohonan" name="jenis_permohonan" required>
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

        <!-- LIST VIEW -->
        <div class="card shadow-sm" id="tableContainer">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0"><i class="fas fa-list me-2"></i> Daftar Jenis Permohonan</h3>
                <div class="card-tools ms-auto d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="location.reload();">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <a href="<?= base_url('superadmin/jenis-permohonan/create') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Jenis Permohonan
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="col-no">No</th>
                                <th>Nama Jenis Permohonan</th>
                                <th class="col-status">Status</th>
                                <th class="col-aksi">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($jenisPermohonanList)) : ?>
                                <?php foreach ($jenisPermohonanList as $key => $row) : ?>
                                    <tr>
                                        <td class="col-no"><?= $key + 1 ?></td>
                                        <td><?= esc($row['jenis_permohonan']) ?></td>
                                        <td class="col-status">
                                            <?php if($row['status'] == 'AKTIF'): ?>
    <span class="badge bg-success">Aktif</span>
<?php else: ?>
    <span class="badge bg-danger">Tidak Aktif</span>
<?php endif; ?>
                                        </td>
                                        <td class="col-aksi">
                                            <div class="d-flex gap-1 justify-content-center">
                                                <button type="button" class="btn btn-sm btn-warning text-white btn-edit" 
                                                    data-id="<?= $row['id_jenis_permohonan'] ?>" 
                                                    data-jenis="<?= esc($row['jenis_permohonan']) ?>" 
                                                    data-status="<?= $row['status'] ?>" 
                                                    title="Edit"><i class="fas fa-edit"></i></button>
                                                <button type="button" class="btn btn-sm btn-danger btn-hapus" 
                                                    data-url="<?= base_url('superadmin/jenis-permohonan/delete/' . $row['id_jenis_permohonan']) ?>" 
                                                    title="Hapus"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada data jenis permohonan.</td>
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
            var jenis = this.getAttribute('data-jenis');
            var status = this.getAttribute('data-status');

            document.getElementById('formEditInline').action = '<?= base_url('superadmin/jenis-permohonan/update') ?>/' + id;
            document.getElementById('edit_jenis_permohonan').value = jenis;
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
