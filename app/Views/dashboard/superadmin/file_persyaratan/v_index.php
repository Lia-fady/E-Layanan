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

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0"><i class="fas fa-list me-2"></i> Daftar File Persyaratan</h3>
                <div class="card-tools ms-auto d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="location.reload();">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <a href="<?= base_url('superadmin/file_persyaratan/create') ?>" class="btn btn-primary btn-sm">
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
                                        <td><?= $row['nama_jenis_permohonan'] ?? '-'; ?></td>
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
                                                <a href="<?= base_url('superadmin/file_persyaratan/detail/' . $row['id_file_persyaratan']) ?>" class="btn btn-sm btn-info text-white" title="Lihat"><i class="fas fa-eye"></i></a>
                                                <a href="<?= base_url('superadmin/file_persyaratan/edit/' . $row['id_file_persyaratan']) ?>" class="btn btn-sm btn-warning text-white" title="Edit"><i class="fas fa-edit"></i></a>
                                                <button type="button" class="btn btn-sm btn-danger btn-hapus" data-id="<?= $row['id_file_persyaratan'] ?>" data-bs-toggle="modal" data-bs-target="#deleteModal" title="Hapus"><i class="fas fa-trash"></i></button>
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
                
                <div class="row align-items-center mt-3">
                    <div class="col-md-6">
                        <p class="mb-0 text-muted small">Menampilkan <?= count($fileList ?? []) ?> entri</p>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#">Sebelumnya</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item disabled"><a class="page-link" href="#">Selanjutnya</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center pt-4 pb-4">
        <i class="fas fa-exclamation-triangle fa-4x text-warning mb-3"></i>
        <h4>Apakah Anda yakin?</h4>
        <p class="text-muted mb-0">Data yang dihapus tidak dapat dikembalikan.</p>
      </div>
      <div class="modal-footer justify-content-center border-0 pt-0 pb-4">
        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
        <a href="#" id="btnConfirmDelete" class="btn btn-danger px-4">Ya, Hapus Data</a>
      </div>
    </div>
  </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.btn-hapus');
        const confirmDeleteBtn = document.getElementById('btnConfirmDelete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                confirmDeleteBtn.setAttribute('href', '<?= base_url('superadmin/file_persyaratan/delete/') ?>/' + id);
            });
        });
    });
</script>
<?= $this->endSection() ?>
