<?= $this->extend('layouts/superadmin/L_main_superadmin') ?>

<?= $this->section('title') ?><?= esc($title ?? 'mahasiswa index') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>


<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Master Data Mahasiswa</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('superadmin/dashboard') ?>">Master Data</a></li>
                    <li class="breadcrumb-item active">Mahasiswa</li>
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
                <h3 class="card-title mb-0"><i class="fas fa-edit me-2"></i> Edit Mahasiswa</h3>
                <button type="button" class="btn-close btn-close-white btn-cancel-edit" aria-label="Close"></button>
            </div>
            <form id="formEditInline" action="" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="edit_nim" class="form-label fw-bold">NIM <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_nim" name="nim" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="edit_nik" class="form-label fw-bold">NIK <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_nik" name="nik" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="edit_nama" class="form-label fw-bold">Nama Mahasiswa <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_nama" name="nama_mahasiswa" required>
                        </div>
                        <!-- Note: in original v_create program_studi and instansi_pendidikan were text inputs, 
                             but the DB uses relation t_instansi_mahasiswa. Kept as text to match original UI -->
                        <div class="col-md-4 mb-3">
                            <label for="edit_prodi" class="form-label fw-bold">Program Studi</label>
                            <input type="text" class="form-control" id="edit_prodi" name="program_studi">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="edit_instansi" class="form-label fw-bold">Instansi Pendidikan</label>
                            <input type="text" class="form-control" id="edit_instansi" name="instansi_pendidikan">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="edit_email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
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
                <h3 class="card-title mb-0"><i class="fas fa-list me-2"></i> Daftar Mahasiswa</h3>
                <div class="card-tools ms-auto d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="location.reload();">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <a href="<?= base_url('superadmin/mahasiswa/create') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Mahasiswa
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
                                <th>NIM</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Program Studi</th>
                                <th>Instansi</th>
                                <th>Email</th>
                                <th class="col-status">Status</th>
                                <th class="col-aksi">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($mahasiswaList)) : ?>
                                <?php foreach ($mahasiswaList as $row) : ?>
                                    <tr>
                                        <td><?= esc($row['nim']) ?></td>
                                        <td><?= esc($row['nik']) ?></td>
                                        <td><?= esc($row['nama_mahasiswa']) ?></td>
                                        <td><?= esc($row['nama_prodi'] ?? '-') ?></td>
                                        <td><?= esc($row['instansi_pendidikan'] ?? '-') ?></td>
                                        <td><?= esc($row['email']) ?></td>
                                        <td class="col-status">
                                            <div class="form-check form-switch status-switch">
                                                <!-- Karena m_mahasiswa tidak memiliki field status, biarkan switch ini atau nonaktifkan -->
                                                <input class="form-check-input" type="checkbox" role="switch" checked disabled>
                                            </div>
                                        </td>
                                        <td class="col-aksi">
                                            <div class="d-flex gap-1 justify-content-center">
                                                <button type="button" class="btn btn-sm btn-warning text-white btn-edit" 
                                                    data-id="<?= $row['id_mahasiswa'] ?>" 
                                                    data-nim="<?= esc($row['nim']) ?>" 
                                                    data-nik="<?= esc($row['nik']) ?>" 
                                                    data-nama="<?= esc($row['nama_mahasiswa']) ?>" 
                                                    data-prodi="<?= esc($row['nama_prodi'] ?? '') ?>" 
                                                    data-instansi="<?= esc($row['instansi_pendidikan'] ?? '') ?>" 
                                                    data-email="<?= esc($row['email']) ?>" 
                                                    title="Edit"><i class="fas fa-edit"></i></button>
                                                <button type="button" class="btn btn-sm btn-danger btn-hapus" 
                                                    data-id="<?= $row['id_mahasiswa'] ?>" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal" 
                                                    title="Hapus"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="8" class="text-center">Belum ada data mahasiswa.</td>
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
    const editNim = document.getElementById('edit_nim');
    const editNik = document.getElementById('edit_nik');
    const editNama = document.getElementById('edit_nama');
    const editProdi = document.getElementById('edit_prodi');
    const editInstansi = document.getElementById('edit_instansi');
    const editEmail = document.getElementById('edit_email');

    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nim = this.getAttribute('data-nim');
            const nik = this.getAttribute('data-nik');
            const nama = this.getAttribute('data-nama');
            const prodi = this.getAttribute('data-prodi');
            const instansi = this.getAttribute('data-instansi');
            const email = this.getAttribute('data-email');

            // Set Form Action
            formEditInline.action = `<?= base_url('superadmin/mahasiswa/update') ?>/${id}`;

            // Populate Data
            editNim.value = nim;
            editNik.value = nik;
            editNama.value = nama;
            editProdi.value = prodi;
            editInstansi.value = instansi;
            editEmail.value = email;

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
