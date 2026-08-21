<?= $this->extend('layout/L_master_superadmin') ?>

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
                                <th>Jurusan / Program Studi</th>
                                <th>Instansi</th>
                                <th>Email</th>
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
                                        <td><?= esc($row['nama_jurusan'] ?? $row['nama_prodi'] ?? '-') ?></td>
                                        <td><?= esc($row['instansi_pendidikan'] ?? '-') ?></td>
                                        <td><?= esc($row['email']) ?></td>
                                        <td class="col-aksi">
                                            <div class="d-flex gap-1 justify-content-center">
                                                <a href="<?= base_url('superadmin/mahasiswa/edit/' . $row['id_mahasiswa']) ?>" class="btn btn-sm btn-warning text-white" title="Edit"><i class="fas fa-edit"></i></a>
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





<?= $this->endSection() ?>
