<?= $this->extend('layout/L_master_superadmin') ?>

<?= $this->section('title') ?><?= esc($title ?? 'Tambah Mahasiswa') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Mahasiswa</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('superadmin/dashboard') ?>">Master Data</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('superadmin/mahasiswa') ?>">Mahasiswa</a></li>
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
                <h3 class="card-title">Form Tambah Mahasiswa</h3>
            </div>
            <form id="formTambah" action="<?= base_url('superadmin/mahasiswa/store') ?>" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nik" class="form-label fw-bold">NIK <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nik" name="nik" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="nim" class="form-label fw-bold">NIM <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nim" name="nim" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="nama_mahasiswa" class="form-label fw-bold">Nama Mahasiswa <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_mahasiswa" name="nama_mahasiswa" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="jenis_kelamin" class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="L">Laki-laki (L)</option>
                                        <option value="P">Perempuan (P)</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tgl_lahir" class="form-label fw-bold">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label fw-bold">Alamat <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="2" required></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="rt" class="form-label fw-bold">RT</label>
                                    <input type="text" class="form-control" id="rt" name="rt">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="rw" class="form-label fw-bold">RW</label>
                                    <input type="text" class="form-control" id="rw" name="rw">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kelurahan" class="form-label fw-bold">Kelurahan</label>
                                    <input type="text" class="form-control" id="kelurahan" name="kelurahan">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kecamatan" class="form-label fw-bold">Kecamatan</label>
                                    <input type="text" class="form-control" id="kecamatan" name="kecamatan">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="provinsi" class="form-label fw-bold">Provinsi</label>
                                    <input type="text" class="form-control" id="provinsi" name="provinsi">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="no_telp" class="form-label fw-bold">No. Telp <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="no_telp" name="no_telp" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="id_instansi_mahasiswa" class="form-label fw-bold">ID Instansi Mahasiswa <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="id_instansi_mahasiswa" name="id_instansi_mahasiswa" required>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function () {
    $('#formTambah').on('submit', function(e) {
        e.preventDefault();
        
        let form = $(this);
        let url = form.attr('action');
        let formData = new FormData(this);
        
        // Basic frontend validation for required fields
        let isValid = true;
        form.find('[required]').each(function() {
            if($(this).val().trim() === '') {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if(!isValid) return;

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = "<?= base_url('superadmin/mahasiswa') ?>";
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response.message
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan!',
                    text: 'Tidak dapat terhubung ke server.'
                });
            }
        });
    });

    $('#formTambah input, #formTambah select, #formTambah textarea').on('input change', function() {
        if($(this).val().trim() !== '') {
            $(this).removeClass('is-invalid');
        }
    });
});
</script>
<?= $this->endSection() ?>
