<?= $this->extend('layouts/superadmin/L_main_superadmin') ?>

<?= $this->section('title') ?><?= esc($title ?? 'manajemen_pengguna') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card card-primary card-outline">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Data Pengguna</h3>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPengguna"><i class="fas fa-plus"></i> Tambah Pengguna</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="userTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Terakhir Login</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php $no = 1; foreach ($users as $u): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= esc($u['nama']) ?></td>
                            <td><?= esc($u['email'] ?? '-') ?></td>
                            <td><?= esc($u['username']) ?></td>
                            <td><?= esc($u['role_name'] ?? '-') ?></td>
                            <td>
                                <?php if ($u['status_aktif'] == 1): ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td><?= !empty($u['terakhir_login']) ? esc($u['terakhir_login']) : '-' ?></td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick='editUser(<?= json_encode($u) ?>)'><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger" onclick="deleteUser(<?= $u['id_user_pegawai'] ?>)"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8" class="text-center">Belum ada data</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(function () {
    $('#userTable').DataTable();
});
</script>

<!-- Modal Tambah Pengguna -->
<div class="modal fade" id="modalTambahPengguna" tabindex="-1" aria-labelledby="modalTambahPenggunaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formTambahPengguna" action="<?= base_url('superadmin/manajemen-pengguna/store') ?>" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahPenggunaLabel">Tambah Pengguna</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label for="nama_user" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nama_user" name="nama_user" required>
                <div class="invalid-feedback d-none text-danger">Nama wajib diisi.</div>
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
                <label for="group_id" class="form-label fw-bold">Role (Group ID) <span class="text-danger">*</span></label>
                <select class="form-select form-control" id="group_id" name="group_id" required>
                    <option value="">-- Pilih Role --</option>
                    <?php foreach ($roles as $r): ?>
                        <option value="<?= $r['id'] ?>"><?= esc($r['group']) ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback d-none text-danger">Role wajib diisi.</div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold d-block">Status Aktif</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="statusAktifUser" name="status_aktif" checked>
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

    $('#formTambahPengguna input').on('input change', function() {
        if($(this).val().trim() !== '') {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').addClass('d-none');
        }
    });
});
</script>
<?= $this->endSection() ?>
