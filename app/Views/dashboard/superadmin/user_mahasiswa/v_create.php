<?= $this->extend('layout/L_master_superadmin') ?>

<?= $this->section('title') ?><?= esc($title ?? 'user_mahasiswa create') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah User Mahasiswa</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('superadmin/dashboard') ?>">Master Data</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('superadmin/user-mahasiswa') ?>">User Mahasiswa</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Form Tambah User Mahasiswa</h3>
            </div>
            <?php if (empty($mahasiswaList)): ?>
    <div class="alert alert-warning">Tidak ada mahasiswa yang tersedia untuk ditambahkan sebagai user.</div>
    <a href="<?= base_url('superadmin/user-mahasiswa') ?>" class="btn btn-secondary">Kembali</a>
<?php else: ?>
<form id="formTambah" class="form-confirm-create" action="<?= base_url('superadmin/user-mahasiswa/store') ?>" method="post">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-8">
                <div class="mb-3">
                    <label for="mahasiswa" class="form-label fw-bold">Mahasiswa <span class="text-danger">*</span></label>
                    <select class="form-select" id="mahasiswa" name="id_mahasiswa" required>
                        <option value="" disabled selected>-- Pilih Mahasiswa --</option>
                        <?php foreach ($mahasiswaList as $m): ?>
                            <option value="<?= $m['id_mahasiswa'] ?>"><?= esc($m['nama_mahasiswa']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback d-block text-danger d-none">
                        Mahasiswa wajib dipilih.
                    </div>
                </div>
                            <div class="mb-3">
                                <label for="username" class="form-label fw-bold">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username"  required>
                                <!-- Contoh validasi error -->
                                <div class="invalid-feedback d-block text-danger d-none">
                                    Username wajib diisi.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="password" name="password" placeholder="Masukkan Password"  required>
                                <!-- Contoh validasi error -->
                                <div class="invalid-feedback d-block text-danger d-none">
                                    Password wajib diisi.
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold d-block">Status</label>
                                <select class="form-select" id="statusAktif" name="status" required>
    <option value="AKTIF" selected>AKTIF</option>
    <option value="NONAKTIF">Tidak Aktif</option>
</select>
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
                    <a href="<?= base_url('superadmin/user-mahasiswa') ?>" class="btn btn-outline-secondary">
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
<?php endif; ?>

        </div>
    </div>
</section>


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(function () {
    $('#formTambah').on('submit', function(e) {
        let form = $(this);
        let isValid = true;
        form.find('[required]').each(function() {
            if($(this).val().trim() === '') {
                isValid = false;
                $(this).addClass('is-invalid');
                $(this).siblings('.invalid-feedback').removeClass('d-none');
            } else {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').addClass('d-none');
            }
        });
        
        if(!isValid) {
            e.preventDefault(); // Prevent SweetAlert confirmation if invalid
            return false;
        }
    });

    // Remove validation warning on input
    $('#formTambah input, #formTambah select, #formTambah textarea').on('input change', function() {
        if($(this).val().trim() !== '') {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').addClass('d-none');
        }
    });
});
</script>
<?= $this->endSection() ?>
