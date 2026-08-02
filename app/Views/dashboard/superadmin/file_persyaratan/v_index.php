<?= $this->extend('layouts/superadmin/L_main_superadmin') ?>

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
        
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm mb-4 d-none" id="editContainer">
            <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0"><i class="fas fa-edit me-2"></i> Edit File Persyaratan</h3>
                <button type="button" class="btn-close btn-close-white btn-cancel-edit" aria-label="Close"></button>
            </div>
            <form id="formEditInline" action="" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
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
                        <div class="col-md-4 mb-3">
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
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold d-block">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input type="hidden" name="status_aktif" value="nonaktif">
                                <input class="form-check-input" type="checkbox" role="switch" id="edit_status" name="status_aktif" value="aktif">
                                <label class="form-check-label" for="edit_status">Aktif / Nonaktif</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary btn-cancel-edit"><i class="fas fa-times me-1"></i> Batal</button>
                    <button type="submit" class="btn btn-warning text-white"><i class="fas fa-save me-1"></i> Update Data</button>
                </div>
            </form>
        </div>

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
                <div class="row mb-3 align-items-center">
                    <div class="col-md-2">
                        <select class="form-select form-select-sm" id="limitData">
                            <option value="10">10 Baris</option>
                            <option value="25">25 Baris</option>
                            <option value="50">50 Baris</option>
                            <option value="100">100 Baris</option>
                        </select>
                    </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-2 text-end">
                        <select class="form-select form-select-sm" id="filterStatus">
                            <option value="all">Semua Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" placeholder="Cari data..." id="searchBox">
                            <button class="btn btn-outline-secondary" type="button"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>

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
                                        <!-- Kolom Nama File -->
                                        <td><?= $row['nama_file']; ?></td>
                                        <!-- Kolom Jenis Permohonan -->
                                        <td><?= $row['jenis_permohonan'] ?? '-'; ?></td>
                                        <!-- Kolom Status -->
                                        <td class="text-center">
                                            <?php if (isset($row['status_aktif']) && ($row['status_aktif'] == 'Aktif' || $row['status_aktif'] == '1')) : ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php else : ?>
                                                <span class="badge bg-danger">Nonaktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <!-- Kolom Aksi -->
                                        <td>
                                            <div class="d-flex gap-1 justify-content-center">
                                                <a href="<?= base_url('superadmin/file-persyaratan/detail/' . ($row['id_file_permohonan'] ?? '')) ?>" class="btn btn-sm btn-info text-white" title="Lihat"><i class="fas fa-eye"></i></a>
                                                <button type="button" class="btn btn-sm btn-warning text-white btn-edit" 
                                                    data-id="<?= $row['id_file_permohonan'] ?? '' ?>" 
                                                    data-id-jenis="<?= esc($row['id_jenis_permohonan'] ?? '') ?>"
                                                    data-id-file="<?= esc($row['id_file'] ?? '') ?>" 
                                                    data-status="<?= $row['status_aktif'] ?>" 
                                                    title="Edit"><i class="fas fa-edit"></i></button>
                                                <button type="button" class="btn btn-sm btn-danger btn-hapus" 
                                                    data-id="<?= $row['id_file_permohonan'] ?? '' ?>" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal" 
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



<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inline Edit Logic
    const editButtons = document.querySelectorAll('.btn-edit');
    const editContainer = document.getElementById('editContainer');
    const tableContainer = document.getElementById('tableContainer');
    const formEditInline = document.getElementById('formEditInline');
    const cancelEditBtns = document.querySelectorAll('.btn-cancel-edit');
    
    // Inputs
    const editJenis = document.getElementById('edit_id_jenis_permohonan');
    const editIdFile = document.getElementById('edit_id_file');
    const editStatus = document.getElementById('edit_status');

    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const idJenis = this.getAttribute('data-id-jenis');
            const idFile = this.getAttribute('data-id-file');
            const status = this.getAttribute('data-status');

            // Set Form Action
            formEditInline.action = `<?= base_url('superadmin/file-persyaratan/update') ?>/${id}`;

            // Populate Data
            editJenis.value = idJenis;
            editIdFile.value = idFile;
            
            if (status === 'aktif' || status === 'Aktif' || status == '1') {
                editStatus.checked = true;
            } else {
                editStatus.checked = false;
            }

            // Show Edit Container
            editContainer.classList.remove('d-none');
            editContainer.scrollIntoView({ behavior: 'smooth' });
        });
    });

    cancelEditBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            editContainer.classList.add('d-none');
            formEditInline.reset();
        });
    });

    
    });
</script>
<?= $this->endSection() ?>
