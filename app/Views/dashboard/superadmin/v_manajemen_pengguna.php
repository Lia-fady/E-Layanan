<?= $this->extend('layouts/superadmin/L_main_superadmin') ?>

<?= $this->section('title') ?><?= esc($title ?? 'manajemen_pengguna') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card card-primary card-outline">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Data Pengguna</h3>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPengguna"><i class="fas fa-plus"></i> Tambah Pengguna</button>
    </div>
    <div class="card-body">
        <!-- Edit Container -->
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
                            <input type="text" class="form-control" id="edit_nama" name="nama" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="edit_nip" class="form-label fw-bold">Username/NIP <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_nip" name="nip" required>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="edit_password" class="form-label fw-bold">Password Baru</label>
                            <input type="password" class="form-control" id="edit_password" name="password" placeholder="(Kosongkan jika tidak ubah)">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="edit_group" class="form-label fw-bold">Role <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_group" name="id_user_group" required>
                                <option value="">-- Pilih Role --</option>
                                <?php foreach ($roles as $r): ?>
                                    <option value="<?= $r['id'] ?>"><?= esc($r['group']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold d-block">Status Aktif</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="edit_status" name="status_aktif" value="1">
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

        <div class="table-responsive" id="tableContainer">
            <table id="userTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username/NIP</th>
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
                            <td><?= esc($u['nip'] ?? '') ?></td>
                            <td><?= esc($u['role_name'] ?? '-') ?></td>
                            <td>
                                <?php if ($u['status_aktif'] == 1 || $u['status_aktif'] == '1'): ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td><?= !empty($u['terakhir_login']) ? esc($u['terakhir_login']) : '-' ?></td>
                            <td>
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-warning text-white btn-edit" 
                                        data-id="<?= $u['id_user_pegawai'] ?>"
                                        data-nama="<?= esc($u['nama']) ?>"
                                        data-nip="<?= esc($u['nip']) ?>"
                                        data-group="<?= esc($u['id_user_group']) ?>"
                                        data-status="<?= $u['status_aktif'] ?>"
                                        title="Edit"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger btn-hapus" 
                                        data-id="<?= $u['id_user_pegawai'] ?>" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal" 
                                        title="Hapus"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center">Belum ada data</td></tr>
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
                <label for="nama" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nama" name="nama" required>
                <div class="invalid-feedback d-none text-danger">Nama wajib diisi.</div>
            </div>
            <div class="mb-3">
                <label for="nip" class="form-label fw-bold">Username/NIP <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nip" name="nip" required>
                <div class="invalid-feedback d-none text-danger">Username wajib diisi.</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="password" name="password" required>
                <div class="invalid-feedback d-none text-danger">Password wajib diisi.</div>
            </div>
            <div class="mb-3">
                <label for="group_id" class="form-label fw-bold">Role <span class="text-danger">*</span></label>
                <select class="form-select form-control" id="group_id" name="id_user_group" required>
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
                    <input class="form-check-input" type="checkbox" role="switch" id="statusAktifUser" name="status_aktif" value="1" checked>
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

        form[0].submit();
    });

    $('#formTambahPengguna input').on('input change', function() {
        if($(this).val().trim() !== '') {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').addClass('d-none');
        }
    });

    // Inline Edit Logic
    $('.btn-edit').on('click', function() {
        let id = $(this).data('id');
        let nama = $(this).data('nama');
        let nip = $(this).data('nip');
        let group = $(this).data('group');
        let status = $(this).data('status');

        $('#formEditInline').attr('action', '<?= base_url('superadmin/manajemen-pengguna/update') ?>/' + id);
        
        $('#edit_nama').val(nama);
        $('#edit_nip').val(nip);
        $('#edit_group').val(group);
        $('#edit_password').val(''); // blank for no change
        
        if (status == '1' || status == 1) {
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

    // Delete Logic
    
});
</script>
<?= $this->endSection() ?>
