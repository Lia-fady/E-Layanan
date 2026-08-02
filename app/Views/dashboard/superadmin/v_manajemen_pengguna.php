<?= $this->extend('layouts/superadmin/L_main_superadmin') ?>

<?= $this->section('title') ?><?= esc($title ?? 'Manajemen Pengguna') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Manajemen Pengguna</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('superadmin/dashboard') ?>">Master Data</a></li>
                    <li class="breadcrumb-item active">Pengguna Pegawai</li>
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

        <!-- Form Edit Inline Container -->
        <div class="card shadow-sm mb-4 d-none" id="editContainer">
            <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0"><i class="fas fa-edit me-2"></i> Edit Pengguna</h3>
                <button type="button" class="btn-close btn-close-white btn-cancel-edit" aria-label="Close"></button>
            </div>
            <form id="formEditInline" action="" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="edit_nama" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_nama" name="nama_lengkap" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="edit_username" class="form-label fw-bold">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_username" name="username" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="edit_password" class="form-label fw-bold">Password Baru</label>
                            <input type="password" class="form-control" id="edit_password" name="password" placeholder="Kosongkan jika tidak diubah">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="edit_role" class="form-label fw-bold">Role <span class="text-danger">*</span></label>
                            <select class="form-select form-control" id="edit_role" name="role" required>
                                <option value="">-- Role --</option>
                                <option value="superadmin">Superadmin</option>
                                <option value="admin">Admin</option>
                                <option value="validator">Validator</option>
                                <option value="fasilitator">Fasilitator</option>
                            </select>
                        </div>
                        <div class="col-md-1 mb-3">
                            <label class="form-label fw-bold d-block">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input type="hidden" name="status_aktif" value="nonaktif">
                                <input class="form-check-input" type="checkbox" role="switch" id="edit_status" name="status_aktif" value="aktif">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary btn-cancel-edit"><i class="fas fa-times me-1"></i> Batal</button>
                    <button type="submit" class="btn btn-warning text-white"><i class="fas fa-save me-1"></i> Update Data</button>
                </div>
            </form>
        </div>

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0"><i class="fas fa-users me-2"></i> Daftar Pengguna Pegawai</h3>
                <div class="card-tools ms-auto d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="location.reload();">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPengguna">
                        <i class="fas fa-plus"></i> Tambah Pengguna
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle" id="userTable">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($users)): ?>
                                <?php $no = 1; foreach ($users as $u): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($u['nama_lengkap']) ?></td>
                                    <td><?= esc($u['username']) ?></td>
                                    <td>
                                        <span class="badge bg-secondary"><?= esc(ucfirst($u['role'])) ?></span>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" <?= ($u['status_aktif'] == 'aktif' || $u['status_aktif'] == '1') ? 'checked' : '' ?> disabled>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1 justify-content-center">
                                            <button class="btn btn-sm btn-warning text-white btn-edit" 
                                                data-id="<?= $u['id_pengguna'] ?>"
                                                data-nama="<?= esc($u['nama_lengkap']) ?>"
                                                data-username="<?= esc($u['username']) ?>"
                                                data-role="<?= esc($u['role']) ?>"
                                                data-status="<?= esc($u['status_aktif']) ?>"
                                                title="Edit"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-sm btn-danger btn-hapus" 
                                                data-id="<?= $u['id_pengguna'] ?>" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal" 
                                                title="Hapus"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6" class="text-center">Belum ada data</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Tambah Pengguna -->
<div class="modal fade" id="modalTambahPengguna" tabindex="-1" aria-labelledby="modalTambahPenggunaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formTambahPengguna" action="<?= base_url('superadmin/manajemen-pengguna/store') ?>" method="post">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalTambahPenggunaLabel">Tambah Pengguna</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label for="nama" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nama" name="nama_lengkap" required>
                <div class="invalid-feedback d-none text-danger">Nama Lengkap wajib diisi.</div>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label fw-bold">Username <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="username" name="username" required>
                <div class="invalid-feedback d-none text-danger">Username wajib diisi.</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="password" name="password" required>
                <div class="invalid-feedback d-none text-danger">Password wajib diisi.</div>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label fw-bold">Role <span class="text-danger">*</span></label>
                <select class="form-select form-control" id="role" name="role" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="superadmin">Superadmin</option>
                    <option value="admin">Admin</option>
                    <option value="validator">Validator</option>
                    <option value="fasilitator">Fasilitator</option>
                </select>
                <div class="invalid-feedback d-none text-danger">Role wajib diisi.</div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold d-block">Status Aktif</label>
                <div class="form-check form-switch">
                    <input type="hidden" name="status_aktif" value="nonaktif">
                    <input class="form-check-input" type="checkbox" role="switch" id="statusAktifUser" name="status_aktif" value="aktif" checked>
                </div>
            </div>
        </div>
        <div class="modal-footer bg-light">
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
    $('#userTable').DataTable();

    $('#formTambahPengguna').on('submit', function(e) {
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

        form[0].submit();
    });

    $('#formTambahPengguna input, #formTambahPengguna select').on('input change', function() {
        if($(this).val().trim() !== '') {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').addClass('d-none');
        }
    });

    // Inline Edit Logic
    $('.btn-edit').on('click', function() {
        let id = $(this).data('id');
        let nama = $(this).data('nama');
        let username = $(this).data('username');
        let role = $(this).data('role');
        let status = $(this).data('status');

        $('#formEditInline').attr('action', '<?= base_url('superadmin/manajemen-pengguna/update') ?>/' + id);
        
        $('#edit_nama').val(nama);
        $('#edit_username').val(username);
        $('#edit_role').val(role);
        $('#edit_password').val(''); // blank for no change
        
        if (status === 'aktif' || status == '1') {
            $('#edit_status').prop('checked', true);
        } else {
            $('#edit_status').prop('checked', false);
        }

        $('#editContainer').removeClass('d-none');
        $('#editContainer')[0].scrollIntoView({ behavior: 'smooth' });
    });

    $('.btn-cancel-edit').on('click', function() {
        $('#editContainer').addClass('d-none');
        $('#formEditInline')[0].reset();
    });
});
</script>
<?= $this->endSection() ?>
