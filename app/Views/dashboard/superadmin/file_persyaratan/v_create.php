<?= $this->extend('layout/L_master_superadmin') ?>

<?= $this->section('title') ?><?= esc($title ?? 'file_persyaratan create') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah File Persyaratan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('superadmin/dashboard') ?>">Master Data</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('superadmin/file-persyaratan') ?>">File Persyaratan</a></li>
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
                <h3 class="card-title">Form Tambah File Persyaratan</h3>
            </div>
            <form id="formTambah" action="<?= base_url('superadmin/file-persyaratan/store') ?>" method="post">
                <?= csrf_field(); ?>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            
                            <!-- DROPDOWN JENIS PERMOHONAN -->
                            <div class="mb-3">
                                <label for="id_jenis_permohonan" class="form-label fw-bold">Jenis Permohonan <span class="text-danger">*</span></label>
                                <select class="form-select" id="id_jenis_permohonan" name="id_jenis_permohonan" required>
                                    <option value="">-- Pilih Jenis Permohonan --</option>
                                    <?php if (!empty($jenisPermohonanList)) : ?>
                                        <?php foreach ($jenisPermohonanList as $jenis) : ?>
                                            <option value="<?= $jenis['id_jenis_permohonan']; ?>">
                                                <?= $jenis['jenis_permohonan']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="invalid-feedback d-block text-danger d-none">
                                    Jenis Permohonan wajib dipilih.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="id_file" class="form-label fw-bold">Pilih File <span class="text-danger">*</span></label>
                                <select class="form-select" id="id_file" name="id_file" required>
                                    <option value="">-- Pilih File --</option>
                                    <?php if (!empty($fileList)) : ?>
                                        <?php foreach ($fileList as $file) : ?>
                                            <option value="<?= $file['id_file']; ?>">
                                                <?= esc($file['nama_file']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="invalid-feedback d-block text-danger d-none">
                                    File wajib dipilih.
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold d-block">Status</label>
                                <div class="form-check form-switch">
                                    <input type="hidden" name="status_aktif" value="nonaktif">
                                <input class="form-check-input" type="checkbox" role="switch" id="statusAktif" name="status_aktif" checked value="aktif">
                                    <label class="form-check-label" for="statusAktif">Aktif / Nonaktif</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="alert alert-info">
                                <h5><i class="icon fas fa-info"></i> Informasi</h5>
                                Pastikan Anda memilih Jenis Permohonan yang sesuai sebelum menginput nama file persyaratan.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex gap-2">
                    <a href="<?= base_url('superadmin/file-persyaratan') ?>" class="btn btn-outline-secondary">
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
                        window.location.href = "<?= base_url('superadmin/file-persyaratan') ?>";
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
            $(this).siblings('.invalid-feedback').addClass('d-none');
        }
    });
});
</script>
<?= $this->endSection() ?>
