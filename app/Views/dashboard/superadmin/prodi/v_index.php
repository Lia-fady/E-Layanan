<?= $this->extend('layout/L_master_superadmin') ?>

<?= $this->section('title') ?><?= esc($title ?? 'prodi index') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Master Data Program Studi & Jurusan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('superadmin/dashboard') ?>">Master Data</a></li>
                    <li class="breadcrumb-item active">Prodi & Jurusan</li>
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

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active fw-bold" id="prodi-tab" data-toggle="tab" data-bs-toggle="tab" href="#prodi" role="tab" aria-controls="prodi" aria-selected="true">
                    <i class="fas fa-graduation-cap me-1"></i> Program Studi (Universitas)
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link fw-bold" id="jurusan-tab" data-toggle="tab" data-bs-toggle="tab" href="#jurusan" role="tab" aria-controls="jurusan" aria-selected="false">
                    <i class="fas fa-tools me-1"></i> Jurusan (SMK/Sederajat)
                </a>
            </li>
        </ul>

        <div class="tab-content mt-3" id="myTabContent">
            
            <!-- ============================== -->
            <!-- TAB PROGRAM STUDI -->
            <!-- ============================== -->
            <div class="tab-pane fade show active" id="prodi" role="tabpanel" aria-labelledby="prodi-tab">
                
                <div class="card shadow-sm mb-4 d-none" id="editContainer">
                    <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0"><i class="fas fa-edit me-2"></i> Edit Program Studi</h3>
                        <button type="button" class="btn-close btn-close-white btn-cancel-edit" aria-label="Close"></button>
                    </div>
                    <form id="formEditInline" action="" method="post">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="edit_id_fakultas" class="form-label fw-bold">Fakultas <span class="text-danger">*</span></label>
                                    <select class="form-select" id="edit_id_fakultas" name="id_fakultas" required>
                                        <option value="">-- Pilih Fakultas --</option>
                                        <?php if(isset($fakultasList)): foreach($fakultasList as $fak): ?>
                                        <option value="<?= $fak['id_fakultas'] ?>"><?= esc($fak['fakultas']) ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="edit_prodi" class="form-label fw-bold">Program Studi <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_prodi" name="nama_prodi" required>
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
                        <h3 class="card-title mb-0"><i class="fas fa-list me-2"></i> Daftar Program Studi</h3>
                        <div class="card-tools ms-auto d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="location.reload();">
                                <i class="fas fa-sync-alt"></i> Refresh
                            </button>
                            <a href="<?= base_url('superadmin/program-studi/create') ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tambah Program Studi
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="col-no">No</th>
                                        <th>Fakultas</th>
                                        <th>Program Studi</th>
                                        <th class="col-status">Status</th>
                                        <th class="col-aksi">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($prodiList)) : ?>
                                        <?php foreach ($prodiList as $key => $row) : ?>
                                            <tr>
                                                <td class="col-no"><?= $key + 1 ?></td>
                                                <td><?= esc($row['fakultas'] ?? '-') ?></td>
                                                <td><?= esc($row['nama_prodi']) ?></td>
                                                <td class="col-status">
                                                    <div class="form-check form-switch status-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" <?= ($row['status'] == 'aktif' || $row['status'] == '1') ? 'checked' : '' ?> disabled>
                                                    </div>
                                                </td>
                                                <td class="col-aksi">
                                                    <div class="d-flex gap-1 justify-content-center">
                                                        <button type="button" class="btn btn-sm btn-warning text-white btn-edit" 
                                                            data-id="<?= $row['id_prodi'] ?>" 
                                                            data-idfakultas="<?= $row['id_fakultas'] ?>" 
                                                            data-prodi="<?= esc($row['nama_prodi']) ?>" 
                                                            data-status="<?= $row['status'] ?>" 
                                                            title="Edit"><i class="fas fa-edit"></i></button>
                                                        <button type="button" class="btn btn-sm btn-danger btn-hapus" 
                                                            data-id="<?= $row['id_prodi'] ?>" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#deleteModal" 
                                                            title="Hapus"><i class="fas fa-trash"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada data program studi.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ============================== -->
            <!-- TAB JURUSAN -->
            <!-- ============================== -->
            <div class="tab-pane fade" id="jurusan" role="tabpanel" aria-labelledby="jurusan-tab">
                
                <!-- Form Tambah Jurusan (Inline) -->
                <div class="card shadow-sm mb-4 d-none" id="createContainerJurusan">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0"><i class="fas fa-plus me-2"></i> Tambah Jurusan Baru</h3>
                        <button type="button" class="btn-close btn-close-white btn-cancel-create-jurusan" aria-label="Close"></button>
                    </div>
                    <form id="formCreateJurusan" action="<?= base_url('superadmin/program-studi/storeJurusan') ?>" method="post">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="create_id_instansi_jurusan" class="form-label fw-bold">Sekolah (SMK) <span class="text-danger">*</span></label>
                                    <select class="form-select" id="create_id_instansi_jurusan" name="id_instansi_pendidikan" required>
                                        <option value="">-- Pilih Sekolah --</option>
                                        <?php if(isset($smkList)): foreach($smkList as $smk): ?>
                                        <option value="<?= $smk['id_instansi_pendidikan'] ?>"><?= esc($smk['instansi_pendidikan']) ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="create_nama_jurusan" class="form-label fw-bold">Nama Jurusan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="create_nama_jurusan" name="nama_jurusan" required placeholder="Contoh: Rekayasa Perangkat Lunak">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold d-block">Status</label>
                                    <div class="form-check form-switch mt-2">
                                        <input type="hidden" name="status" value="0">
                                        <input class="form-check-input" type="checkbox" role="switch" id="create_status_jurusan" name="status" value="1" checked>
                                        <label class="form-check-label" for="create_status_jurusan">Aktif / Nonaktif</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary btn-cancel-create-jurusan"><i class="fas fa-times me-1"></i> Batal</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Jurusan</button>
                        </div>
                    </form>
                </div>

                <!-- Form Edit Jurusan (Inline) -->
                <div class="card shadow-sm mb-4 d-none" id="editContainerJurusan">
                    <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0"><i class="fas fa-edit me-2"></i> Edit Jurusan</h3>
                        <button type="button" class="btn-close btn-close-white btn-cancel-edit-jurusan" aria-label="Close"></button>
                    </div>
                    <form id="formEditInlineJurusan" action="" method="post">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="edit_id_instansi_jurusan" class="form-label fw-bold">Sekolah (SMK) <span class="text-danger">*</span></label>
                                    <select class="form-select" id="edit_id_instansi_jurusan" name="id_instansi_pendidikan" required>
                                        <option value="">-- Pilih Sekolah --</option>
                                        <?php if(isset($smkList)): foreach($smkList as $smk): ?>
                                        <option value="<?= $smk['id_instansi_pendidikan'] ?>"><?= esc($smk['instansi_pendidikan']) ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="edit_nama_jurusan" class="form-label fw-bold">Nama Jurusan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_nama_jurusan" name="nama_jurusan" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold d-block">Status</label>
                                    <div class="form-check form-switch mt-2">
                                        <input type="hidden" name="status" value="0">
                                        <input class="form-check-input" type="checkbox" role="switch" id="edit_status_jurusan" name="status" value="1">
                                        <label class="form-check-label" for="edit_status_jurusan">Aktif / Nonaktif</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary btn-cancel-edit-jurusan"><i class="fas fa-times me-1"></i> Batal</button>
                            <button type="submit" class="btn btn-warning text-white"><i class="fas fa-save me-1"></i> Update Data</button>
                        </div>
                    </form>
                </div>

                <div class="card shadow-sm" id="tableContainerJurusan">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0"><i class="fas fa-list me-2"></i> Daftar Jurusan (SMK/Sederajat)</h3>
                        <div class="card-tools ms-auto d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="location.reload();">
                                <i class="fas fa-sync-alt"></i> Refresh
                            </button>
                            <button type="button" id="btnShowCreateJurusan" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tambah Jurusan
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="col-no">No</th>
                                        <th>Sekolah</th>
                                        <th>Nama Jurusan</th>
                                        <th class="col-status">Status</th>
                                        <th class="col-aksi">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($jurusanList)) : ?>
                                        <?php foreach ($jurusanList as $key => $row) : ?>
                                            <tr>
                                                <td class="col-no"><?= $key + 1 ?></td>
                                                <td><?= esc($row['instansi_pendidikan'] ?? '-') ?></td>
                                                <td><?= esc($row['nama_jurusan']) ?></td>
                                                <td class="col-status">
                                                    <div class="form-check form-switch status-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" <?= ($row['status'] == 'aktif' || $row['status'] == '1') ? 'checked' : '' ?> disabled>
                                                    </div>
                                                </td>
                                                <td class="col-aksi">
                                                    <div class="d-flex gap-1 justify-content-center">
                                                        <button type="button" class="btn btn-sm btn-warning text-white btn-edit-jurusan" 
                                                            data-id="<?= $row['id_jurusan'] ?>" 
                                                            data-idinstansi="<?= $row['id_instansi_pendidikan'] ?>"
                                                            data-jurusan="<?= esc($row['nama_jurusan']) ?>" 
                                                            data-status="<?= $row['status'] ?>" 
                                                            title="Edit"><i class="fas fa-edit"></i></button>
                                                        <button type="button" class="btn btn-sm btn-danger btn-hapus" 
                                                            data-id="<?= $row['id_jurusan'] ?>" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#deleteModalJurusan" 
                                                            title="Hapus"><i class="fas fa-trash"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="4" class="text-center">Belum ada data jurusan.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div> <!-- End Tab Content -->
    </div>
</section>

<!-- Modal Hapus Prodi (Original) -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-danger text-white border-0">
                <h5 class="modal-title" id="deleteModalLabel"><i class="fas fa-exclamation-triangle me-2"></i> Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                <i class="fas fa-trash-alt fa-4x text-danger mb-3"></i>
                <h5 class="mb-2">Apakah Anda yakin?</h5>
                <p class="text-muted mb-0">Data program studi yang dihapus tidak dapat dikembalikan.</p>
            </div>
            <div class="modal-footer border-0 justify-content-center bg-light">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                <form id="formDelete" action="" method="post" class="m-0">
                    <button type="submit" class="btn btn-danger px-4">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hapus Jurusan -->
<div class="modal fade" id="deleteModalJurusan" tabindex="-1" aria-labelledby="deleteModalJurusanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-danger text-white border-0">
                <h5 class="modal-title" id="deleteModalJurusanLabel"><i class="fas fa-exclamation-triangle me-2"></i> Konfirmasi Hapus Jurusan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                <i class="fas fa-trash-alt fa-4x text-danger mb-3"></i>
                <h5 class="mb-2">Apakah Anda yakin?</h5>
                <p class="text-muted mb-0">Data jurusan yang dihapus tidak dapat dikembalikan.</p>
            </div>
            <div class="modal-footer border-0 justify-content-center bg-light">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                <form id="formDeleteJurusan" action="" method="post" class="m-0">
                    <button type="submit" class="btn btn-danger px-4">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // ============================================
    // LOGIC TAB PROGRAM STUDI
    // ============================================
    const editButtons = document.querySelectorAll('.btn-edit');
    const editContainer = document.getElementById('editContainer');
    const formEditInline = document.getElementById('formEditInline');
    const cancelEditBtns = document.querySelectorAll('.btn-cancel-edit');
    
    const editIdFakultas = document.getElementById('edit_id_fakultas');
    const editProdi = document.getElementById('edit_prodi');
    const editStatus = document.getElementById('edit_status');

    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const idFakultas = this.getAttribute('data-idfakultas');
            const prodi = this.getAttribute('data-prodi');
            const status = this.getAttribute('data-status');

            formEditInline.action = `<?= base_url('superadmin/program-studi/update') ?>/${id}`;

            editIdFakultas.value = idFakultas;
            editProdi.value = prodi;
            
            if (status === 'aktif' || status == '1') {
                editStatus.checked = true;
            } else {
                editStatus.checked = false;
            }

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

    const deleteBtns = document.querySelectorAll('#prodi .btn-hapus');
    const formDelete = document.getElementById('formDelete');
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            formDelete.action = `<?= base_url('superadmin/program-studi/delete') ?>/${id}`;
        });
    });

    // ============================================
    // LOGIC TAB JURUSAN
    // ============================================
    const btnShowCreateJurusan = document.getElementById('btnShowCreateJurusan');
    const createContainerJurusan = document.getElementById('createContainerJurusan');
    const cancelCreateJurusanBtns = document.querySelectorAll('.btn-cancel-create-jurusan');
    const formCreateJurusan = document.getElementById('formCreateJurusan');

    btnShowCreateJurusan.addEventListener('click', function() {
        createContainerJurusan.classList.remove('d-none');
        editContainerJurusan.classList.add('d-none'); // Hide edit if open
        createContainerJurusan.scrollIntoView({ behavior: 'smooth' });
    });

    cancelCreateJurusanBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            createContainerJurusan.classList.add('d-none');
            formCreateJurusan.reset();
        });
    });

    const editBtnsJurusan = document.querySelectorAll('.btn-edit-jurusan');
    const editContainerJurusan = document.getElementById('editContainerJurusan');
    const formEditInlineJurusan = document.getElementById('formEditInlineJurusan');
    const cancelEditBtnsJurusan = document.querySelectorAll('.btn-cancel-edit-jurusan');
    
    const editIdInstansiJurusan = document.getElementById('edit_id_instansi_jurusan');
    const editNamaJurusan = document.getElementById('edit_nama_jurusan');
    const editStatusJurusan = document.getElementById('edit_status_jurusan');

    editBtnsJurusan.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const idInstansi = this.getAttribute('data-idinstansi');
            const jurusan = this.getAttribute('data-jurusan');
            const status = this.getAttribute('data-status');

            formEditInlineJurusan.action = `<?= base_url('superadmin/program-studi/updateJurusan') ?>/${id}`;

            editIdInstansiJurusan.value = idInstansi;
            editNamaJurusan.value = jurusan;
            
            if (status === 'aktif' || status == '1') {
                editStatusJurusan.checked = true;
            } else {
                editStatusJurusan.checked = false;
            }

            createContainerJurusan.classList.add('d-none'); // Hide create if open
            editContainerJurusan.classList.remove('d-none');
            editContainerJurusan.scrollIntoView({ behavior: 'smooth' });
        });
    });

    cancelEditBtnsJurusan.forEach(btn => {
        btn.addEventListener('click', function() {
            editContainerJurusan.classList.add('d-none');
            formEditInlineJurusan.reset();
        });
    });

    const deleteBtnsJurusan = document.querySelectorAll('#jurusan .btn-hapus');
    const formDeleteJurusan = document.getElementById('formDeleteJurusan');
    deleteBtnsJurusan.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            formDeleteJurusan.action = `<?= base_url('superadmin/program-studi/deleteJurusan') ?>/${id}`;
        });
    });

});
</script>

<?= $this->endSection() ?>
