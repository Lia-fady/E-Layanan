<?= $this->extend('layout/L_master_superadmin') ?>

<?= $this->section('title') ?><?= esc($title ?? 'bidang create') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Bidang</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('superadmin/dashboard') ?>">Master Data</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('superadmin/bidang') ?>">Bidang</a></li>
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
                <h3 class="card-title">Form Tambah Bidang</h3>
            </div>
            <form id="formTambah" class="form-confirm-create" action="<?= base_url('superadmin/bidang/store') ?>" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label for="id_opd" class="form-label fw-bold">OPD <span class="text-danger">*</span></label>
                                <select class="form-select" id="id_opd" name="id_opd" required>
                                    <option value="">-- Pilih OPD --</option>
                                    <?php if (isset($opdList)): foreach ($opdList as $opd): ?>
                                            <option value="<?= $opd['id_opd'] ?>"><?= $opd['opd'] ?></option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                                <div class="invalid-feedback d-block text-danger d-none">
                                    OPD wajib dipilih.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="bidang" class="form-label fw-bold">Nama Bidang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="bidang" name="bidang" placeholder="Masukkan Nama Bidang" required>
                                <!-- Contoh validasi error -->
                                <div class="invalid-feedback d-block text-danger d-none">
                                    Nama Bidang wajib diisi.
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold d-block">Status</label>
                                <select class="form-select" id="statusAktif" name="status_aktif" required>
    <option value="1" selected>Aktif</option>
    <option value="0">Tidak Aktif</option>
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
