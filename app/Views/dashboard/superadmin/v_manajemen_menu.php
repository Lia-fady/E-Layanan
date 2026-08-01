<?= $this->extend('layouts/superadmin/L_main_superadmin') ?>

<?= $this->section('title') ?><?= esc($title ?? 'manajemen_menu') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card card-primary card-outline">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Daftar Menu</h3>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahMenu"><i class="fas fa-plus"></i> Tambah Menu</button>
    </div>
    <div class="card-body">
        <!-- Edit Container -->
        <div class="card shadow-sm mb-4 d-none" id="editContainer">
            <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0"><i class="fas fa-edit me-2"></i> Edit Menu</h3>
                <button type="button" class="btn-close btn-close-white btn-cancel-edit" aria-label="Close"></button>
            </div>
            <form id="formEditInline" action="" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="edit_name" class="form-label fw-bold">Nama Menu <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="edit_icon" class="form-label fw-bold">Icon</label>
                            <input type="text" class="form-control" id="edit_icon" name="icon">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="edit_url" class="form-label fw-bold">URL/Route <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_url" name="url" required>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="edit_position" class="form-label fw-bold">Urutan</label>
                            <input type="number" class="form-control" id="edit_position" name="position">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label fw-bold d-block">Status Aktif</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="edit_status" name="status">
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
                    <?php if (!empty($menuList)) : ?>
                        <?php foreach ($menuList as $key => $row) : ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= esc($row['name']) ?></td>
                                <td><i class="<?= esc($row['icon']) ?>"></i> <?= esc($row['icon']) ?></td>
                                <td><?= esc($row['url']) ?></td>
                                <td><?= esc($row['id_parent'] ?? '-') ?></td>
                                <td><?= esc($row['position']) ?></td>
                                <td>
                                    <?php if ($row['status'] == 1 || $row['status'] == '1') : ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else : ?>
                                        <span class="badge bg-danger">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex gap-1 justify-content-center">
                                        <button class="btn btn-sm btn-warning text-white btn-edit" 
                                            data-id="<?= $row['id'] ?>"
                                            data-name="<?= esc($row['name']) ?>"
                                            data-icon="<?= esc($row['icon']) ?>"
                                            data-url="<?= esc($row['url']) ?>"
                                            data-position="<?= esc($row['position']) ?>"
                                            data-status="<?= $row['status'] ?>"
                                            title="Edit"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger btn-hapus" 
                                            data-id="<?= $row['id'] ?>" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal" 
                                            title="Hapus"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="8" class="text-center">Belum ada data menu.</td>
                        </tr>
                    <?php endif; ?>
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
                <input type="text" class="form-control" id="nama_menu" name="name" required>
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
                <input type="number" class="form-control" id="urutan" name="position">
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

        form[0].submit();
    });

    $('#formTambahMenu input').on('input change', function() {
        if($(this).val().trim() !== '') {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').addClass('d-none');
        }
    });
    
    // Inline Edit Logic
    $('.btn-edit').on('click', function() {
        let id = $(this).data('id');
        let name = $(this).data('name');
        let icon = $(this).data('icon');
        let url = $(this).data('url');
        let position = $(this).data('position');
        let status = $(this).data('status');

        $('#formEditInline').attr('action', '<?= base_url('superadmin/manajemen-menu/update') ?>/' + id);
        
        $('#edit_name').val(name);
        $('#edit_icon').val(icon);
        $('#edit_url').val(url);
        $('#edit_position').val(position);
        
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
