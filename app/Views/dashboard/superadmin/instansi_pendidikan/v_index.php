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
                <h3 class="card-title mb-0"><i class="fas fa-edit me-2"></i> Edit Instansi Pendidikan</h3>
                <button type="button" class="btn-close btn-close-white btn-cancel-edit" aria-label="Close"></button>
            </div>
            <form id="formEditInline" action="" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="edit_instansi_pendidikan" class="form-label fw-bold">Nama Instansi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_instansi_pendidikan" name="instansi_pendidikan" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="edit_jenis_instansi" class="form-label fw-bold">Jenis Instansi <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_jenis_instansi" name="jenis_instansi" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="negeri">Negeri</option>
                                <option value="swasta">Swasta</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold d-block">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input type="hidden" name="status" value="0">
                                <input class="form-check-input" type="checkbox" role="switch" id="edit_status" name="status" value="1">
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
                                            <div class="form-check form-switch status-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" <?= ($row['status'] == 'aktif' || $row['status'] == '1') ? 'checked' : '' ?> disabled>
                                            </div>
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
                                                    data-id="<?= $row['id_instansi_pendidikan'] ?>" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal" 
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



<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inline Edit Logic
    const editButtons = document.querySelectorAll('.btn-edit');
    const editContainer = document.getElementById('editContainer');
    const tableContainer = document.getElementById('tableContainer');
    const formEditInline = document.getElementById('formEditInline');
    const cancelEditBtns = document.querySelectorAll('.btn-cancel-edit');
    
    // Inputs
    const editInstansi = document.getElementById('edit_instansi_pendidikan');
    const editJenis = document.getElementById('edit_jenis_instansi');
    const editStatus = document.getElementById('edit_status');

    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const instansi = this.getAttribute('data-instansi');
            const jenis = this.getAttribute('data-jenis');
            const status = this.getAttribute('data-status');

            // Set Form Action
            formEditInline.action = `<?= base_url('superadmin/instansi-pendidikan/update') ?>/${id}`;

            // Populate Data
            editInstansi.value = instansi;
            editJenis.value = jenis;
            
            if (status === 'aktif' || status == '1') {
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
