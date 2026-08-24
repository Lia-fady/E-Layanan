<?php
/**
 * ============================================================
 * Kode      : v_profile.php
 * Path      : Views/dashboard/kabid/v_profile.php
 * Deskripsi : View halaman profil user Kabid – modern redesign.
 * ============================================================
 */
?>
<?= $this->extend('layout/L_master') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle mr-2"></i>
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle mr-2"></i>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
<?php endif; ?>

<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="card-title mb-0">Profil Saya</h5>
                    <small class="text-muted">Informasi akun dan data profil Anda</small>
                </div>
                <button type="button" class="btn btn-primary btn-sm" id="btnEditProfil">
                    <i class="fas fa-pencil-alt mr-1"></i> Edit Profil
                </button>
            </div>
            <div class="row">
                <!-- Avatar Section -->
                <div class="col-md-4 text-center mb-4 mb-md-0">
                    <div class="position-relative d-inline-block">
                        <?php if (!empty($user->foto)): ?>
                            <img src="<?= base_url('uploads/profile/' . $user->foto) ?>" alt="Avatar" class="rounded-circle shadow" style="width:150px; height:150px; object-fit:cover;">
                        <?php else: ?>
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center shadow" style="width:150px; height:150px;">
                                <i class="fas fa-user fa-3x text-secondary"></i>
                            </div>
                        <?php endif; ?>
                        <button type="button" class="btn btn-outline-secondary btn-sm position-absolute" style="bottom:0; right:0;" id="btnChangePhoto">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>
                </div>
                <!-- Profile Info (View Mode) -->
                <div class="col-md-8" id="profileView">
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <i class="fas fa-id-card mr-2 text-primary"></i><strong>Nama Lengkap:</strong>
                            <p class="mb-0"><?= esc($user->nama ?? '-') ?></p>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <i class="fas fa-envelope mr-2 text-primary"></i><strong>Email:</strong>
                            <p class="mb-0"><?= esc($user->email ?? '-') ?></p>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <i class="fas fa-phone mr-2 text-primary"></i><strong>No. Telepon:</strong>
                            <p class="mb-0"><?= esc($user->no_telp ?? '-') ?></p>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <i class="fas fa-id-badge mr-2 text-primary"></i><strong>NIP:</strong>
                            <p class="mb-0"><?= esc($user->nip ?? '-') ?></p>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <i class="fas fa-briefcase mr-2 text-primary"></i><strong>Jabatan:</strong>
                            <p class="mb-0"><?= esc($user->jabatan ?? 'Kabid') ?></p>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <i class="fas fa-sitemap mr-2 text-primary"></i><strong>Bidang:</strong>
                            <p class="mb-0"><?= esc($user->bidang ?? '-') ?></p>
                        </div>
                    </div>
                </div>
                <!-- Profile Edit Form (Hidden) -->
                <div class="col-md-8" id="profileEdit" style="display:none;">
                    <form action="<?= base_url('kabid/profile/update') ?>" method="POST" enctype="multipart/form-data" id="formProfile">
                        <?= csrf_field() ?>
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label for="nama"><i class="fas fa-id-card mr-1"></i>Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama_user" name="nama" value="<?= esc($user->nama ?? '') ?>" required>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="email"><i class="fas fa-envelope mr-1"></i>Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= esc($user->email ?? '') ?>" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label for="no_telp"><i class="fas fa-phone mr-1"></i>No. Telepon</label>
                                <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?= esc($user->no_telp ?? '') ?>" required>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="nip"><i class="fas fa-id-badge mr-1"></i>NIP</label>
                                <input type="text" class="form-control" id="nip" name="nip" value="<?= esc($user->nip ?? '') ?>" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label for="jabatan"><i class="fas fa-briefcase mr-1"></i>Jabatan</label>
                                <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?= esc($user->jabatan ?? 'Kabid') ?>" readonly>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="bidang"><i class="fas fa-sitemap mr-1"></i>Bidang</label>
                                <input type="text" class="form-control" id="bidang" name="bidang" value="<?= esc($user->bidang ?? '') ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="foto"><i class="fas fa-camera mr-1"></i>Ubah Foto (Opsional)</label>
                            <input type="file" class="form-control-file" id="foto" name="foto" accept="image/*">
                            <img id="previewImg" src="#" alt="Preview" class="mt-2 rounded" style="max-width:150px; display:none;">
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success mr-2"><i class="fas fa-save mr-1"></i>Simpan Perubahan</button>
                            <button type="button" class="btn btn-secondary" id="btnCancelEdit"><i class="fas fa-times mr-1"></i>Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Toggle edit / view
    $('#btnEditProfil').on('click', function() {
        $('#profileView').hide();
        $('#profileEdit').show();
        $(this).hide();
    });
    $('#btnCancelEdit').on('click', function() {
        $('#profileEdit').hide();
        $('#profileView').show();
        $('#btnEditProfil').show();
    });
    // Open file selector when avatar button clicked
    $('#btnChangePhoto').on('click', function() {
        $('#foto').trigger('click');
    });
    // Preview selected image
    $('#foto').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImg').attr('src', e.target.result).show();
            };
            reader.readAsDataURL(file);
        }
    });
    // Hover effect for buttons
    $('.btn').hover(function(){
        $(this).addClass('shadow-sm');
    }, function(){
        $(this).removeClass('shadow-sm');
    });
});
</script>
<?= $this->endSection() ?>
