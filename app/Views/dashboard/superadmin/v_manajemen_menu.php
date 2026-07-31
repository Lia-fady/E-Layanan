<?= $this->extend('layouts/superadmin/L_main_superadmin') ?>

<?= $this->section('title') ?><?= esc($title ?? 'manajemen_menu') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card card-primary card-outline">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Daftar Menu</h3>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahMenu"><i class="fas fa-plus"></i> Tambah Menu</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="menuTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Menu</th>
                        <th>Icon</th>
                        <th>URL/Route</th>
                        <th>Parent Menu</th>
                        <th>Urutan</th>
                        <th>Status Aktif</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Dashboard</td>
                        <td><i class="fas fa-tachometer-alt"></i></td>
                        <td>/admin/dashboard</td>
                        <td>-</td>
                        <td>1</td>
                        <td><span class="badge bg-success">Aktif</span></td>
                        <td>
                            <button class="btn btn-sm btn-info"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(function () {
    $('#menuTable').DataTable();
});
</script>

<!-- Modal Tambah Menu -->
<div class="modal fade" id="modalTambahMenu" tabindex="-1" aria-labelledby="modalTambahMenuLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formTambahMenu" action="<?= base_url('superadmin/manajemen-menu/store') ?>" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahMenuLabel">Tambah Menu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label for="nama_menu" class="form-label fw-bold">Nama Menu <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nama_menu" name="nama_menu" required>
                <div class="invalid-feedback d-none text-danger">Nama Menu wajib diisi.</div>
            </div>
            <div class="mb-3">
                <label for="icon" class="form-label fw-bold">Icon</label>
                <input type="text" class="form-control" id="icon" name="icon">
            </div>
            <div class="mb-3">
                <label for="url" class="form-label fw-bold">URL/Route <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="url" name="url" required>
                <div class="invalid-feedback d-none text-danger">URL/Route wajib diisi.</div>
            </div>
            <div class="mb-3">
                <label for="urutan" class="form-label fw-bold">Urutan</label>
                <input type="number" class="form-control" id="urutan" name="urutan">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold d-block">Status Aktif</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="statusAktifMenu" name="status" checked>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function() {
    $('#formTambahMenu').on('submit', function(e) {
        e.preventDefault();
        
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
        
        if(!isValid) return;

        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.success) {
                    Swal.fire({
                        icon: 'success', title: 'Berhasil!', text: response.message, showConfirmButton: false, timer: 1500
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal!', text: response.message });
                }
            },
            error: function() {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal terhubung ke server.' });
            }
        });
    });

    $('#formTambahMenu input').on('input change', function() {
        if($(this).val().trim() !== '') {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').addClass('d-none');
        }
    });
});
</script>
<?= $this->endSection() ?>
