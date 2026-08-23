<?= $this->extend('layout/L_master_superadmin') ?>

<?= $this->section('title') ?><?= esc($title ?? 'bidang index') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Master Data Bidang</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('superadmin/dashboard') ?>">Master Data</a></li>
                    <li class="breadcrumb-item active">Bidang</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        <!-- EDIT VIEW (Full Page) -->
        <div class="card shadow-sm d-none" id="editContainer">
            <div class="card-header bg-warning text-white">
                <h3 class="card-title mb-0"><i class="fas fa-edit me-2"></i> Edit Bidang</h3>
            </div>
            <form id="formEditInline" class="form-confirm-update" action="" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label for="edit_id_opd" class="form-label fw-bold">OPD <span class="text-danger">*</span></label>
                                <select class="form-select" id="edit_id_opd" name="id_opd" required>
                                    <option value="">-- Pilih OPD --</option>
                                    <?php foreach ($opdList as $opd) : ?>
                                        <option value="<?= $opd['id_opd'] ?>"><?= esc($opd['opd']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit_nama_bidang" class="form-label fw-bold">Nama Bidang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_nama_bidang" name="bidang" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold d-block">Status</label>
                                <select class="form-select" id="edit_status" name="status_aktif" required>
    <option value="1">Aktif</option>
    <option value="0">Tidak Aktif</option>
</select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="alert alert-info">
                                <h5><i class="icon fas fa-info"></i> Informasi</h5>
                                Pastikan data yang diubah sudah benar sebelum menyimpan perubahan.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-cancel-edit">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </button>
                    <button type="submit" class="btn btn-warning text-white ms-auto">
                        <i class="fas fa-save me-1"></i> Update Data
                    </button>
                </div>
            </form>
        </div>

        <!-- LIST VIEW -->
        <div class="card shadow-sm" id="tableContainer">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0"><i class="fas fa-list me-2"></i> Daftar Bidang</h3>
                <div class="card-tools ms-auto d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="location.reload();">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <a href="<?= base_url('superadmin/bidang/create') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Bidang
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="col-no">No</th>
                                <th>OPD</th>
                                <th>Nama Bidang</th>
                                <th class="col-status">Status</th>
                                <th class="col-aksi">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($bidangList)) : ?>
                                <?php foreach ($bidangList as $key => $row) : ?>
                                    <tr>
                                        <td class="col-no"><?= $key + 1 ?></td>
                                        <td><?= esc($row['opd']) ?></td>
                                        <td><?= esc($row['bidang']) ?></td>
                                        <td class="col-status">
                                            <?php if($row['status_aktif'] == '1'): ?>
    <span class="badge bg-success">Aktif</span>
<?php else: ?>
    <span class="badge bg-danger">Tidak Aktif</span>
<?php endif; ?>
                                        </td>
                                        <td class="col-aksi">
                                            <div class="d-flex gap-1 justify-content-center">
                                                <button type="button" class="btn btn-sm btn-warning text-white btn-edit" 
                                                    data-id="<?= $row['id_bidang'] ?>" 
                                                    data-opd="<?= $row['id_opd'] ?>"
                                                    data-nama="<?= esc($row['bidang']) ?>"
                                                    data-status="<?= $row['status_aktif'] ?>"
                                                    title="Edit"><i class="fas fa-edit"></i></button>
                                                <button type="button" class="btn btn-sm btn-danger btn-hapus" 
                                                    data-url="<?= base_url('superadmin/bidang/delete/' . $row['id_bidang']) ?>" 
                                                    title="Hapus"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data bidang.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('.btn-edit').on('click', function() {
        var id = $(this).data('id');
        var opd = $(this).data('opd');
        var nama = $(this).data('nama');
        var status = $(this).data('status');
        
        $('#edit_id_opd').val(opd);
        $('#edit_nama_bidang').val(nama);
        if (status === 'AKTIF' || status == '1') {
                $('#edit_status').val('1');
            } else {
                $('#edit_status').val('0');
            }
        
        $('#formEditInline').attr('action', '<?= base_url('superadmin/bidang/update/') ?>' + id);
        
        showEditState();
    });
});
</script>
<?= $this->endSection() ?>
