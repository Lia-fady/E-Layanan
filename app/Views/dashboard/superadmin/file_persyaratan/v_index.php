<?= $this->extend('layout/L_master_superadmin') ?>

<?= $this->section('title') ?><?= esc($title ?? 'file_persyaratan index') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Master Data File Persyaratan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('superadmin/dashboard') ?>">Master Data</a></li>
                    <li class="breadcrumb-item active">File Persyaratan</li>
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
                <h3 class="card-title mb-0"><i class="fas fa-edit me-2"></i> Edit File Persyaratan</h3>
            </div>
            <form id="formEditInline" class="form-confirm-update" action="" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label for="edit_id_jenis_permohonan" class="form-label fw-bold">Jenis Permohonan <span class="text-danger">*</span></label>
                                <select class="form-select" id="edit_id_jenis_permohonan" name="id_jenis_permohonan" required>
                                    <option value="">-- Pilih Jenis Permohonan --</option>
                                    <?php if (!empty($jenisPermohonanList)) : ?>
                                        <?php foreach ($jenisPermohonanList as $jenis) : ?>
                                            <option value="<?= $jenis['id_jenis_permohonan']; ?>">
                                                <?= esc($jenis['jenis_permohonan']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit_id_file" class="form-label fw-bold">File <span class="text-danger">*</span></label>
                                <select class="form-select" id="edit_id_file" name="id_file" required>
                                    <option value="">-- Pilih File --</option>
                                    <?php if (!empty($fileMasterList)) : ?>
                                        <?php foreach ($fileMasterList as $file) : ?>
                                            <option value="<?= $file['id_file']; ?>">
                                                <?= esc($file['nama_file']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
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
                <h3 class="card-title mb-0"><i class="fas fa-list me-2"></i> Daftar File Persyaratan</h3>
                <div class="card-tools ms-auto d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="location.reload();">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <a href="<?= base_url('superadmin/file-persyaratan/create') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah File Persyaratan
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="col-no text-center" style="width: 50px;">No</th>
                                <th>Nama File</th>
                                <th>Jenis Permohonan</th>
                                <th class="col-status text-center" style="width: 120px;">Status</th>
                                <th class="col-aksi text-center" style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($fileList)) : ?>
                                <?php foreach ($fileList as $key => $row) : ?>
                                    <tr>
                                        <td class="text-center"><?= $key + 1; ?></td>
                                        <td><?= $row['nama_file']; ?></td>
                                        <td><?= $row['jenis_permohonan'] ?? '-'; ?></td>
                                        <td class="text-center">
                                            <?php if (isset($row['status_aktif']) && ($row['status_aktif'] == 'Aktif' || $row['status_aktif'] == '1')) : ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php else : ?>
                                                <span class="badge bg-danger">Nonaktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1 justify-content-center">
                                                <button type="button" class="btn btn-sm btn-warning text-white btn-edit" 
                                                    data-id="<?= $row['id_file_permohonan'] ?? '' ?>" 
                                                    data-id-jenis="<?= esc($row['id_jenis_permohonan'] ?? '') ?>"
                                                    data-id-file="<?= esc($row['id_file'] ?? '') ?>" 
                                                    data-status="<?= $row['status_aktif'] ?>" 
                                                    title="Edit"><i class="fas fa-edit"></i></button>
                                                <button type="button" class="btn btn-sm btn-danger btn-hapus" 
                                                    data-url="<?= base_url('superadmin/file-persyaratan/delete/' . ($row['id_file_permohonan'] ?? '')) ?>" 
                                                    title="Hapus"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada data file persyaratan.</td>
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
            var idJenis = this.getAttribute('data-id-jenis');
            var idFile = this.getAttribute('data-id-file');
            var status = this.getAttribute('data-status');

            document.getElementById('formEditInline').action = '<?= base_url('superadmin/file-persyaratan/update') ?>/' + id;
            document.getElementById('edit_id_jenis_permohonan').value = idJenis;
            document.getElementById('edit_id_file').value = idFile;
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
