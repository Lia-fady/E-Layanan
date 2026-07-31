<?= $this->extend('layouts/superadmin/L_main_superadmin') ?>

<?= $this->section('title') ?><?= esc($title ?? 'bidang edit') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Bidang</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('superadmin/dashboard') ?>">Master Data</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('superadmin/bidang') ?>">Bidang</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Form Edit Bidang</h3>
            </div>
            <form action="#" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label for="opd" class="form-label fw-bold">OPD <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="opd" name="opd" placeholder="Masukkan OPD" value="Contoh Data OPD" required>
                                <!-- Contoh validasi error -->
                                <div class="invalid-feedback d-block text-danger d-none">
                                    OPD wajib diisi.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="nama_bidang" class="form-label fw-bold">Nama Bidang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_bidang" name="nama_bidang" placeholder="Masukkan Nama Bidang" value="Contoh Data Nama Bidang" required>
                                <!-- Contoh validasi error -->
                                <div class="invalid-feedback d-block text-danger d-none">
                                    Nama Bidang wajib diisi.
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold d-block">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="statusAktif" name="status" checked>
                                    <label class="form-check-label" for="statusAktif">Aktif / Nonaktif</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="alert alert-info">
                                <h5><i class="icon fas fa-info"></i> Informasi</h5>
                                Pastikan Anda mengisi semua field yang bertanda bintang merah (*). Periksa kembali data sebelum menyimpan.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex gap-2">
                    <a href="<?= base_url('superadmin/bidang') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="reset" class="btn btn-warning text-white ms-auto">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
