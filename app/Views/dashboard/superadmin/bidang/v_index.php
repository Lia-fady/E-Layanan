<?= $this->extend('layouts/superadmin/L_main_superadmin') ?>

<?= $this->section('title') ?><?= esc($title ?? 'bidang index') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>


<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Master Data Bidang</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('superadmin/dashboard') ?>">Master Data</a></li>
                    <li class="breadcrumb-item active">Bidang</li>
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

        <!-- Container Tabel -->
        <div class="card shadow-sm" id="tableContainer">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0"><i class="fas fa-list me-2"></i> Daftar Bidang</h3>
                <div class="card-tools ms-auto d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="location.reload();">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <a href="<?= base_url('superadmin/bidang/create') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Bidang
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
                                <th class="col-no">No</th>
                                <th>OPD</th>
                                <th>Nama Bidang</th>
                                <th class="col-status">Status</th>
                                <th class="col-aksi">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($bidangList)) : ?>
                                <?php foreach ($bidangList as $key => $row) : ?>
                                    <tr>
                                        <td class="col-no"><?= $key + 1 ?></td>
                                        <td><?= esc($row['nama_opd']) ?></td>
                                        <td><?= esc($row['nama_bidang']) ?></td>
                                        <td class="col-status">
                                            <div class="form-check form-switch status-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" <?= ($row['status'] == 'aktif' || $row['status'] == '1') ? 'checked' : '' ?> disabled>
                                            </div>
                                        </td>
                                        <td class="col-aksi">
                                            <div class="d-flex gap-1 justify-content-center">
                                                <button type="button" class="btn btn-sm btn-warning text-white btn-edit-inline" 
                                                    data-id="<?= $row['id_bidang'] ?>" 
                                                    data-opd="<?= $row['id_opd'] ?>"
                                                    data-nama="<?= esc($row['nama_bidang']) ?>"
                                                    data-status="<?= $row['status'] ?>"
                                                    title="Edit"><i class="fas fa-edit"></i></button>
                                                <button type="button" class="btn btn-sm btn-danger btn-hapus" data-id="<?= $row['id_bidang'] ?>" data-bs-toggle="modal" data-bs-target="#deleteModal" title="Hapus"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data bidang.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                
            </div>
        </div>

        <!-- Container Edit Form (Disembunyikan secara default) -->
        <div class="card shadow-sm d-none" id="editContainer">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-edit me-2"></i> Edit Bidang</h3>
            </div>
            <form id="formEditInline" action="" method="post">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="edit_id_opd" class="form-label fw-bold">OPD <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_id_opd" name="id_opd" required>
                            <option value="">-- Pilih OPD --</option>
                            <?php foreach ($opdList as $opd) : ?>
                                <option value="<?= $opd['id_opd'] ?>"><?= esc($opd['nama_opd']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nama_bidang" class="form-label fw-bold">Nama Bidang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_nama_bidang" name="nama_bidang" required>
                    </div>
                    <div class="mb-3 form-check form-switch">
                        <input type="hidden" name="status" value="nonaktif">
                        <input type="checkbox" class="form-check-input" id="edit_status" name="status" value="aktif">
                        <label class="form-check-label" for="edit_status">Aktif / Nonaktif</label>
                    </div>
                </div>
                <div class="card-footer bg-white border-top border-light">
                    <button type="button" class="btn btn-secondary btn-batal-edit"><i class="fas fa-arrow-left me-2"></i> Kembali</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i> Simpan</button>
                </div>
            </form>
        </div>

    </div>
</section>



<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('.btn-edit-inline').on('click', function() {
        // Ambil data dari atribut tombol
        let id = $(this).data('id');
        let opd = $(this).data('opd');
        let nama = $(this).data('nama');
        let status = $(this).data('status');
        
        // Isi form
        $('#edit_id_opd').val(opd);
        $('#edit_nama_bidang').val(nama);
        if(status === 'aktif' || status === 'Aktif' || status == '1') {
            $('#edit_status').prop('checked', true);
        } else {
            $('#edit_status').prop('checked', false);
        }
        
        // Update form action
        $('#formEditInline').attr('action', '<?= base_url('superadmin/bidang/update/') ?>' + id);
        
        // Toggle visibility
        $('#tableContainer').addClass('d-none');
        $('#editContainer').removeClass('d-none');
    });

    $('.btn-batal-edit').on('click', function() {
        $('#editContainer').addClass('d-none');
        $('#tableContainer').removeClass('d-none');
    });

    // Delete Modal Logic
    
});
</script>
<?= $this->endSection() ?>
