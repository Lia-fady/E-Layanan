<?= $this->extend('layout/L_master_kabid') ?>

<?= $this->section('title') ?>
Profil Bidang
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>
    .dashboard-subtitle { font-weight: 600; color: #64748B; font-size: 0.85rem; letter-spacing: 1px; text-transform: uppercase; }
    .dashboard-header-title { font-weight: 800; color: #0F172A; font-size: 1.8rem; letter-spacing: -0.5px; }

    .profile-card {
        border-radius: 16px;
        border: 1px solid #E2E8F0;
        overflow: hidden;
    }
    .profile-header-banner {
        background: linear-gradient(135deg, #1E3A5F 0%, #1E40AF 60%, #3B82F6 100%);
        height: 110px;
        position: relative;
    }
    .profile-avatar-wrap {
        position: absolute;
        bottom: -36px;
        left: 32px;
    }
    .profile-avatar {
        width: 72px;
        height: 72px;
        border-radius: 18px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid white;
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    }
    .profile-avatar i {
        font-size: 2rem;
        color: #1E40AF;
    }
    .profile-body { padding: 52px 32px 24px 32px; }

    .stat-card {
        border-radius: 12px;
        padding: 18px 20px;
        border: 1px solid #E2E8F0;
        transition: transform 0.18s, box-shadow 0.18s;
    }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.08); }
    .stat-icon {
        width: 44px; height: 44px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
    }
    .stat-val { font-size: 1.6rem; font-weight: 800; color: #0F172A; }
    .stat-lbl { font-size: 0.8rem; font-weight: 600; color: #64748B; text-transform: uppercase; letter-spacing: 0.5px; }

    .form-control-premium {
        border-radius: 8px;
        border: 1px solid #CBD5E1;
        padding: 0.6rem 1rem;
        font-size: 0.95rem;
        transition: all 0.2s;
        color: #1E293B;
    }
    .form-control-premium:focus {
        border-color: #3B82F6;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
        outline: none;
    }
    .form-control-premium:read-only {
        background-color: #F8FAFC;
        color: #64748B;
        cursor: not-allowed;
    }
    .info-label { font-weight: 600; color: #64748B; font-size: 0.82rem; letter-spacing: 0.4px; text-transform: uppercase; margin-bottom: 4px; }
    .section-card { border-radius: 14px; border: 1px solid #E2E8F0; }
    .section-card-header {
        background: #F8FAFC;
        padding: 16px 24px;
        border-bottom: 1px solid #E2E8F0;
        border-radius: 14px 14px 0 0;
    }
    .section-card-title { font-weight: 700; color: #1E293B; font-size: 1rem; margin: 0; }
    .section-card-body { padding: 24px; }
</style>

<!-- Page Header -->
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background:transparent; padding:0; margin-bottom:5px;">
            <li class="breadcrumb-item"><a href="<?= base_url('kabid/dashboard') ?>" style="color:#3B82F6; text-decoration:none;">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page" style="color:#64748B;">Profil Bidang</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-end">
        <div>
            <h1 class="dashboard-header-title mb-0">Profil Bidang</h1>
        </div>
    </div>
</div>

<!-- Flash messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success" style="border-radius:8px; border:none; background:#DCFCE7; color:#166534;">
        <i class="fas fa-check-circle mr-2"></i> <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger" style="border-radius:8px; border:none; background:#FEE2E2; color:#991B1B;">
        <i class="fas fa-exclamation-circle mr-2"></i> <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="row">
    <!-- Kiri: Kartu Identitas Bidang -->
    <div class="col-lg-5 mb-4">

        <!-- Profile Card -->
        <div class="card shadow-sm profile-card bg-white mb-4">
            <div class="profile-header-banner">
                <div class="profile-avatar-wrap">
                    <div class="profile-avatar">
                        <i class="fas fa-building"></i>
                    </div>
                </div>
            </div>
            <div class="profile-body">
                <h5 style="font-weight:800; color:#0F172A; font-size:1.2rem; margin-bottom:2px;">
                    <?= $bidang ? esc($bidang->bidang) : 'Bidang Belum Diatur' ?>
                </h5>
                <div style="font-size:0.88rem; color:#64748B; margin-bottom:12px;">
                    <?= $bidang ? esc($bidang->opd ?? 'Dinas Kominfo Kota Tangerang') : '-' ?>
                </div>
                <span class="badge" style="background:<?= ($bidang && $bidang->status_aktif == '1') ? '#DCFCE7' : '#FEE2E2' ?>; color:<?= ($bidang && $bidang->status_aktif == '1') ? '#166534' : '#991B1B' ?>; border-radius:6px; padding:5px 10px; font-size:0.8rem;">
                    <i class="fas fa-circle mr-1" style="font-size:0.5rem;"></i>
                    <?= ($bidang && $bidang->status_aktif == '1') ? 'Bidang Aktif' : 'Tidak Aktif' ?>
                </span>
            </div>
        </div>

        <!-- Statistik -->
        <?php $total_semua = $total_menunggu + $total_berjalan + $total_selesai; ?>
        <?php if ($total_semua == 0): ?>
            <div class="card shadow-sm bg-white mb-4" style="border-radius:16px; border:1px solid #E2E8F0;">
                <div class="card-body text-center py-5">
                    <div class="mx-auto mb-3" style="width:64px; height:64px; background:#F8FAFC; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-folder-open text-muted" style="font-size:1.8rem;"></i>
                    </div>
                    <h6 style="font-weight:700; color:#1E293B;">Belum Ada Mahasiswa</h6>
                    <p style="color:#64748B; font-size:0.9rem; margin-bottom:0;">Bidang Anda belum memiliki data<br>penempatan mahasiswa magang saat ini.</p>
                </div>
            </div>
        <?php else: ?>
        <div class="row" style="margin: 0 -6px;">
            <div class="col-12 mb-3" style="padding: 0 6px;">
                <div class="stat-card bg-white d-flex align-items-center" style="gap:14px;">
                    <div class="stat-icon" style="background:#DBEAFE;">
                        <i class="fas fa-user-clock" style="color:#1D4ED8; font-size:1.1rem;"></i>
                    </div>
                    <div>
                        <div class="stat-val"><?= $total_menunggu ?></div>
                        <div class="stat-lbl">Menunggu Persetujuan</div>
                    </div>
                </div>
            </div>
            <div class="col-6 mb-3" style="padding: 0 6px;">
                <div class="stat-card bg-white text-center">
                    <div class="stat-icon mx-auto mb-2" style="background:#D1FAE5;">
                        <i class="fas fa-users" style="color:#059669; font-size:1.05rem;"></i>
                    </div>
                    <div class="stat-val"><?= $total_berjalan ?></div>
                    <div class="stat-lbl">Berjalan</div>
                </div>
            </div>
            <div class="col-6 mb-3" style="padding: 0 6px;">
                <div class="stat-card bg-white text-center">
                    <div class="stat-icon mx-auto mb-2" style="background:#E0E7FF;">
                        <i class="fas fa-graduation-cap" style="color:#4338CA; font-size:1.05rem;"></i>
                    </div>
                    <div class="stat-val"><?= $total_selesai ?></div>
                    <div class="stat-lbl">Selesai</div>
                </div>
            </div>
            <?php if ($kuota): ?>
            <div class="col-12" style="padding: 0 6px;">
                <?php
                    $sisa = max(0, $kuota->kuota - $total_berjalan);
                    $pct  = $kuota->kuota > 0 ? round(($total_berjalan / $kuota->kuota) * 100) : 0;
                ?>
                <div class="stat-card bg-white">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="stat-lbl">Kapasitas Bidang</span>
                        <span style="font-size:0.85rem; font-weight:700; color:#1E293B;"><?= $total_berjalan ?> / <?= $kuota->kuota ?></span>
                    </div>
                    <div class="progress" style="height:8px; border-radius:4px; background:#E2E8F0;">
                        <div class="progress-bar" style="width:<?= $pct ?>%; background:<?= $pct >= 100 ? '#DC2626' : '#2563EB' ?>; border-radius:4px;"></div>
                    </div>
                    <div class="d-flex justify-content-between mt-1">
                        <small style="color:#64748B;"><?= $pct ?>% terisi</small>
                        <small style="color:#64748B;">Sisa: <?= $sisa ?> slot</small>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

    </div>

    <!-- Kanan: Form Edit Nama Bidang -->
    <div class="col-lg-7 mb-4">

        <!-- Info Bidang (read-only) -->
        <div class="card shadow-sm section-card bg-white mb-4">
            <div class="section-card-header">
                <h6 class="section-card-title"><i class="fas fa-info-circle mr-2 text-primary"></i>Informasi Bidang</h6>
            </div>
            <div class="section-card-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="info-label">ID Bidang</div>
                        <input type="text" class="form-control form-control-premium" value="<?= $bidang ? esc($bidang->id_bidang) : '-' ?>" readonly>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="info-label">OPD / Dinas</div>
                        <input type="text" class="form-control form-control-premium" value="<?= $bidang ? esc($bidang->opd ?? 'Dinas Kominfo Kota Tangerang') : '-' ?>" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="info-label">Total Mahasiswa Aktif</div>
                        <input type="text" class="form-control form-control-premium" value="<?= $total_berjalan ?> orang" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div class="info-label" style="margin-bottom:0;">Kuota Maksimal</div>
                            <a href="<?= base_url('kabid/kuota') ?>" class="badge" style="background:#EFF6FF; color:#1D4ED8; padding:4px 8px; font-weight:600; text-decoration:none;">Atur Kuota <i class="fas fa-arrow-right ml-1"></i></a>
                        </div>
                        <input type="text" class="form-control form-control-premium" value="<?= $kuota ? $kuota->kuota . ' orang' : 'Belum diatur' ?>" readonly>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Edit Nama Bidang -->
        <div class="card shadow-sm section-card bg-white mb-4">
            <div class="section-card-header">
                <h6 class="section-card-title"><i class="fas fa-edit mr-2 text-warning"></i>Edit Nama Bidang</h6>
            </div>
            <div class="section-card-body">
                <?php if ($bidang): ?>
                <form action="<?= base_url('kabid/profil-bidang/update') ?>" method="post" id="formEditBidang">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <div class="info-label">Nama Bidang</div>
                        <input type="text"
                               class="form-control form-control-premium"
                               name="bidang"
                               id="inputNamaBidang"
                               value="<?= esc($bidang->bidang) ?>"
                               maxlength="150"
                               required>
                        <small class="text-muted mt-1 d-block">Nama bidang akan terlihat di seluruh sistem.</small>
                    </div>
                    <div class="d-flex justify-content-end" style="gap:10px;">
                        <button type="button" class="btn btn-light px-4" id="btnBatalEdit" style="border-radius:8px; border:1px solid #E2E8F0; color:#64748B; font-weight:600;">
                            <i class="fas fa-times mr-1"></i> Batal
                        </button>
                        <button type="button" class="btn btn-primary px-4" id="btnSimpanBidang" style="border-radius:8px; background:#1E40AF; border-color:#1E40AF; font-weight:600;">
                            <i class="fas fa-save mr-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
                <?php else: ?>
                <div class="text-center py-4">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                    <h6 style="color:#1E293B; font-weight:700;">Bidang Belum Terdaftar</h6>
                    <p style="color:#64748B; font-size:0.9rem;">Akun Anda belum terhubung dengan data bidang. Hubungi Administrator.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Info Akun -->
        <div class="card shadow-sm section-card bg-white">
            <div class="section-card-header">
                <h6 class="section-card-title"><i class="fas fa-user-shield mr-2 text-success"></i>Informasi Akun</h6>
            </div>
            <div class="section-card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="info-label">Nama Pengguna</div>
                        <input type="text" class="form-control form-control-premium" value="<?= $user ? esc($user->nama) : '-' ?>" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="info-label">NIP</div>
                        <input type="text" class="form-control form-control-premium" value="<?= $user ? esc($user->nip) : '-' ?>" readonly>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="info-label">Role / Jabatan</div>
                        <input type="text" class="form-control form-control-premium" value="Kepala Bidang" readonly>
                    </div>
                    <div class="col-md-12 mt-2">
                        <hr style="border-color:#E2E8F0; margin: 0 0 16px 0;">
                        <button type="button" class="btn btn-outline-primary font-weight-bold" data-toggle="modal" data-target="#modalUbahPassword" style="border-radius:8px; padding:0.5rem 1rem;">
                            <i class="fas fa-key mr-2"></i> Ubah Kata Sandi
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal Konfirmasi Nama Bidang -->
<div class="modal fade" id="modalKonfirmasiBidang" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:420px;">
        <div class="modal-content" style="border-radius:16px; border:none; box-shadow:0 20px 60px rgba(0,0,0,0.15);">
            <div class="modal-body p-4 text-center">
                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:64px; height:64px; border-radius:16px; background:#EFF6FF;">
                    <i class="fas fa-building" style="font-size:1.8rem; color:#1E40AF;"></i>
                </div>
                <h5 class="font-weight-bold mb-2" style="color:#0F172A;">Simpan Perubahan Bidang?</h5>
                <p class="mb-1" style="color:#64748B; font-size:0.9rem;">Nama bidang akan diubah menjadi:</p>
                <p class="mb-4 font-weight-bold" id="previewNamaBidang" style="color:#1E40AF; font-size:1rem;"></p>
                <div class="d-flex" style="gap:10px;">
                    <button type="button" class="btn btn-light flex-fill font-weight-600" data-dismiss="modal" style="border-radius:10px; border:1px solid #E2E8F0; color:#475569; padding:0.6rem;">
                        Batal
                    </button>
                    <button type="button" class="btn flex-fill font-weight-bold" id="btnKonfirmasiSimpan" style="border-radius:10px; background:#1E40AF; border-color:#1E40AF; color:white; padding:0.6rem;">
                        <i class="fas fa-check mr-1"></i> Ya, Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ubah Password -->
<div class="modal fade" id="modalUbahPassword" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius:16px; border:none; box-shadow:0 20px 60px rgba(0,0,0,0.15);">
            <div class="modal-header" style="border-bottom:1px solid #E2E8F0; padding:16px 24px;">
                <h5 class="modal-title font-weight-bold" style="color:#0F172A;"><i class="fas fa-lock mr-2 text-primary"></i>Ubah Kata Sandi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('kabid/profil-bidang/update-password') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="info-label">Kata Sandi Lama</label>
                        <input type="password" class="form-control form-control-premium" name="password_lama" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="info-label">Kata Sandi Baru</label>
                        <input type="password" class="form-control form-control-premium" name="password_baru" id="pwdBaru" required minlength="6">
                    </div>
                    <div class="form-group mb-0">
                        <label class="info-label">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" class="form-control form-control-premium" name="konfirmasi_password" id="pwdKonfirm" required minlength="6">
                        <small id="pwdError" class="text-danger d-none mt-1">Konfirmasi kata sandi tidak cocok!</small>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid #E2E8F0; padding:16px 24px;">
                    <button type="button" class="btn btn-light px-4" data-dismiss="modal" style="border-radius:8px; border:1px solid #E2E8F0; color:#64748B; font-weight:600;">Batal</button>
                    <button type="submit" class="btn btn-primary px-4" id="btnSimpanPassword" style="border-radius:8px; font-weight:600;">Simpan Sandi Baru</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    var originalVal = $('#inputNamaBidang').val();

    // Tombol batal — kembalikan nilai awal
    $('#btnBatalEdit').on('click', function() {
        $('#inputNamaBidang').val(originalVal);
    });

    // Tombol simpan → tampilkan modal konfirmasi
    $('#btnSimpanBidang').on('click', function() {
        var nama = $('#inputNamaBidang').val().trim();
        if (!nama) {
            $('#inputNamaBidang').addClass('is-invalid');
            return;
        }
        $('#inputNamaBidang').removeClass('is-invalid');
        $('#previewNamaBidang').text('"' + nama + '"');
        $('#modalKonfirmasiBidang').modal('show');
    });

    // Konfirmasi → submit form
    $('#btnKonfirmasiSimpan').on('click', function() {
        $('#modalKonfirmasiBidang').modal('hide');
        $('#formEditBidang').submit();
    });

    // Validasi Ubah Password
    $('#pwdKonfirm, #pwdBaru').on('keyup', function() {
        if ($('#pwdBaru').val() !== $('#pwdKonfirm').val() && $('#pwdKonfirm').val() !== '') {
            $('#pwdError').removeClass('d-none');
            $('#btnSimpanPassword').prop('disabled', true);
        } else {
            $('#pwdError').addClass('d-none');
            $('#btnSimpanPassword').prop('disabled', false);
        }
    });
});
</script>
<?= $this->endSection() ?>
