<?= $this->extend('layouts/superadmin/L_main_superadmin') ?>

<?= $this->section('title') ?><?= esc($title ?? 'mahasiswa edit') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Mahasiswa</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('superadmin/dashboard') ?>">Master Data</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('superadmin/mahasiswa') ?>">Mahasiswa</a></li>
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
                <h3 class="card-title">Form Edit Mahasiswa</h3>
            </div>
            <form action="#" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label for="nim" class="form-label fw-bold">NIM <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nim" name="nim" placeholder="Masukkan NIM" value="Contoh Data NIM" required>
                                <!-- Contoh validasi error -->
                                <div class="invalid-feedback d-block text-danger d-none">
                                    NIM wajib diisi.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="nik" class="form-label fw-bold">NIK <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK" value="Contoh Data NIK" required>
                                <!-- Contoh validasi error -->
                                <div class="invalid-feedback d-block text-danger d-none">
                                    NIK wajib diisi.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="nama_mahasiswa" class="form-label fw-bold">Nama Mahasiswa <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_mahasiswa" name="nama_mahasiswa" placeholder="Masukkan Nama Mahasiswa" value="Contoh Data Nama Mahasiswa" required>
                                <!-- Contoh validasi error -->
                                <div class="invalid-feedback d-block text-danger d-none">
                                    Nama Mahasiswa wajib diisi.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="program_studi" class="form-label fw-bold">Program Studi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="program_studi" name="program_studi" placeholder="Masukkan Program Studi" value="Contoh Data Program Studi" required>
                                <!-- Contoh validasi error -->
                                <div class="invalid-feedback d-block text-danger d-none">
                                    Program Studi wajib diisi.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="instansi_pendidikan" class="form-label fw-bold">Instansi Pendidikan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="instansi_pendidikan" name="instansi_pendidikan" placeholder="Masukkan Instansi Pendidikan" value="Contoh Data Instansi Pendidikan" required>
                                <!-- Contoh validasi error -->
                                <div class="invalid-feedback d-block text-danger d-none">
                                    Instansi Pendidikan wajib diisi.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email" value="Contoh Data Email" required>
                                <!-- Contoh validasi error -->
                                <div class="invalid-feedback d-block text-danger d-none">
                                    Email wajib diisi.
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
                    <a href="<?= base_url('superadmin/mahasiswa') ?>" class="btn btn-outline-secondary">
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
