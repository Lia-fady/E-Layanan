<?php
/**
 * ============================================================
 * Kode      : v_profile.php
 * Path      : Views/dashboard/sekretariat/v_profile.php
 * Deskripsi : View halaman profil user Sekretariat.
 *             Menampilkan info profil dan form edit.
 * ============================================================
 */
?>

<?= $this->extend('layout/L_master') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')) : ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle mr-2"></i>
    <?= session()->getFlashdata('success') ?>
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
<?php endif; ?>

<div class="profile-card">
    <!-- Edit Profil Button -->
    <button type="button" class="btn-edit-profil" id="btnEditProfil">
        <i class="fas fa-pencil-alt"></i> Edit Profil
    </button>

    <div class="row">
        <!-- Avatar Section -->
        <div class="col-md-3">
            <div class="profile-avatar-section">
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <button type="button" class="btn-ubah-foto">
                    <i class="fas fa-camera"></i> Ubah Foto
                </button>
            </div>
        </div>

        <!-- Info Section (View Mode) -->
        <div class="col-md-9" id="profileView">
            <table class="profile-info-table">
                <tr>
                    <td>Nama Lengkap</td>
                    <td>:</td>
                    <td><?= esc($user->nama_user ?? '-') ?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>:</td>
                    <td><?= esc($user->email ?? '-') ?></td>
                </tr>
                <tr>
                    <td>No. Telepon</td>
                    <td>:</td>
                    <td><?= esc($user->no_telp ?? '-') ?></td>
                </tr>
                <tr>
                    <td>NIP</td>
                    <td>:</td>
                    <td><?= esc($user->nip ?? '-') ?></td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td><?= esc($user->jabatan ?? 'Sekretariat') ?></td>
                </tr>
                <tr>
                    <td>BidangBidang</td>
                    <td>:</td>
                    <td><?= esc($user->bidang ?? '-') ?></td>
                </tr>
            </table>
        </div>

        <!-- Info Section (Edit Mode) -->
        <div class="col-md-9" id="profileEdit" style="display:none;">
            <form action="<?= base_url('sekretariat/profile/update') ?>" method="POST" id="formProfile">
                <?= csrf_field() ?>
                <table class="profile-info-table">
                    <tr>
                        <td>Nama Lengkap</td>
                        <td>:</td>
                        <td><input type="text" name="nama_user" class="profile-edit-input" value="<?= esc($user->nama_user ?? '') ?>"></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td><input type="email" name="email" class="profile-edit-input" value="<?= esc($user->email ?? '') ?>"></td>
                    </tr>
                    <tr>
                        <td>No. Telepon</td>
                        <td>:</td>
                        <td><input type="text" name="no_telp" class="profile-edit-input" value="<?= esc($user->no_telp ?? '') ?>"></td>
                    </tr>
                    <tr>
                        <td>NIP</td>
                        <td>:</td>
                        <td><input type="text" name="nip" class="profile-edit-input" value="<?= esc($user->nip ?? '') ?>"></td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td>:</td>
                        <td><?= esc($user->jabatan ?? 'Sekretariat') ?></td>
                    </tr>
                    <tr>
                        <td>BidangBidang</td>
                        <td>:</td>
                        <td><?= esc($user->bidang ?? '-') ?></td>
                    </tr>
                </table>
                <div class="mt-3">
                    <button type="submit" class="btn-simpan-keputusan">Simpan</button>
                    <button type="button" class="btn-batal ml-2" id="btnCancelEdit">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
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
});
</script>
<?php if (session()->getFlashdata('success')) : ?>
<script>
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: '<?= session()->getFlashdata('success') ?>', timer: 3000 });
</script>
<?php endif; ?>
<?= $this->endSection() ?>
