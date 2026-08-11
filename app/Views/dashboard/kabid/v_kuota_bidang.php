<?= $this->extend('layout/L_master_kabid') ?>

<?= $this->section('title') ?>
Manajemen Kuota Bidang
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Custom Styles for Kuota -->
<style>
    .dashboard-header-title { font-weight: 800; color: #0F172A; font-size: 1.8rem; letter-spacing: -0.5px; }
    .dashboard-subtitle { font-weight: 600; color: #64748B; font-size: 0.85rem; letter-spacing: 1px; text-transform: uppercase; }
    .quota-card { border-radius: 12px; border: 1px solid #E2E8F0; }
    .form-control-premium {
        border-radius: 8px;
        border: 1px solid #CBD5E1;
        padding: 0.6rem 1rem;
        font-size: 1rem;
        transition: all 0.2s;
    }
    .form-control-premium:focus {
        border-color: #3B82F6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
</style>

<div class="d-flex justify-content-between align-items-end mb-4">
    <div>
        <h5 style="font-weight:700; color:#1B2559; margin-bottom:4px;">Kuota Bidang</h5>
        <p style="color:#667085; font-size:0.85rem; margin:0;">
            Atur dan kelola batas maksimal mahasiswa yang dapat diterima di bidang Anda.
        </p>
    </div>
</div>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger" style="border-radius: 8px;">
        <i class="fas fa-exclamation-circle mr-2"></i> <?= session()->getFlashdata('error'); ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success" style="border-radius: 8px;">
        <i class="fas fa-check-circle mr-2"></i> <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>

<div class="row">
    <!-- Form Kolom -->
    <div class="col-xl-4 col-lg-5 mb-4">
        <div class="card shadow-sm quota-card bg-white h-100">
            <div class="card-header bg-white py-3" style="border-bottom: 1px solid #E2E8F0; border-radius: 12px 12px 0 0;">
                <h6 class="m-0 font-weight-bold" style="color: #1E293B; font-size: 1.1rem;">Pengaturan Kuota Bulanan</h6>
            </div>
            <div class="card-body p-4">
                <?php if ($kuota): ?>
                <form action="<?= base_url('kabid/kuota/update') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_kuota" value="<?= $kuota->id_kuota ?>">
                    
                    <div class="form-group mb-4">
                        <label style="font-weight: 600; color: #475569; font-size: 0.9rem;">Nama Bidang</label>
                        <input type="text" class="form-control form-control-premium bg-light" value="<?= esc($kuota->bidang) ?>" readonly>
                    </div>

                    <div class="form-group mb-4">
                        <label style="font-weight: 600; color: #475569; font-size: 0.9rem;">Batas Maksimal Kuota (Per Bulan)</label>
                        <div class="input-group">
                            <input type="number" class="form-control form-control-premium" name="kuota" value="<?= esc($kuota->kuota) ?>" min="0" required style="border-right: 0; border-top-right-radius: 0; border-bottom-right-radius: 0;">
                            <div class="input-group-append">
                                <span class="input-group-text bg-white" style="border-color: #CBD5E1; color: #64748B; border-top-right-radius: 8px; border-bottom-right-radius: 8px;">Mahasiswa</span>
                            </div>
                        </div>
                        <small class="text-muted mt-2 d-block">Jumlah mahasiswa magang maksimal yang diizinkan beraktivitas pada setiap bulan.</small>
                    </div>

                    <hr style="border-color: #E2E8F0; margin: 2rem 0;">

                    <button type="submit" class="btn btn-primary font-weight-bold btn-block" style="border-radius: 8px; background-color: #1E40AF; border-color: #1E40AF;" onclick="return confirm('Apakah Anda yakin ingin memperbarui total kuota bulanan ini?')">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
                </form>
                <?php else: ?>
                    <div class="text-center py-5">
                        <div class="mb-3"><i class="fas fa-exclamation-triangle fa-3x text-warning"></i></div>
                        <h5 style="color: #1E293B; font-weight: bold;">Data Kuota Belum Tersedia</h5>
                        <p style="color: #64748B;">Admin atau Sekretariat belum mengatur data inisial kuota untuk bidang Anda.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Tabel Bulanan -->
    <div class="col-xl-8 col-lg-7 mb-4">
        <div class="card shadow-sm quota-card bg-white h-100">
            <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between" style="border-bottom: 1px solid #E2E8F0; border-radius: 12px 12px 0 0;">
                <h6 class="m-0 font-weight-bold" style="color: #1E293B; font-size: 1.1rem;">Rincian Kuota Tahun <?= esc($tahun) ?></h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="font-size: 0.95rem;">
                        <thead class="bg-light text-center">
                            <tr>
                                <th style="border-top: none; color: #475569; font-weight: 600;">Bulan</th>
                                <th style="border-top: none; color: #475569; font-weight: 600;">Batas Kuota</th>
                                <th style="border-top: none; color: #475569; font-weight: 600;">Terpakai</th>
                                <th style="border-top: none; color: #475569; font-weight: 600;">Sisa Kuota</th>
                                <th style="border-top: none; color: #475569; font-weight: 600;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($rekap_bulanan)): ?>
                                <?php foreach($rekap_bulanan as $rek): ?>
                                <?php 
                                    $isFull = $rek['sisa'] <= 0;
                                    $statusColor = $isFull ? '#DC2626' : '#16A34A';
                                    $statusBg = $isFull ? '#FEE2E2' : '#DCFCE7';
                                    $statusText = $isFull ? 'Penuh' : 'Tersedia';
                                ?>
                                <tr class="text-center align-middle">
                                    <td class="text-left font-weight-bold" style="color: #334155; padding-left: 1.5rem;"><?= esc($rek['bulan_nama']) ?></td>
                                    <td><?= esc($rek['kuota']) ?></td>
                                    <td><span style="color: #2563EB; font-weight: bold;"><?= esc($rek['terpakai']) ?></span></td>
                                    <td><span style="font-weight: 800; color: <?= $statusColor ?>;"><?= esc($rek['sisa']) ?></span></td>
                                    <td>
                                        <div class="badge" style="background-color: <?= $statusBg ?>; color: <?= $statusColor ?>; padding: 0.4rem 0.8rem; font-size: 0.8rem; border-radius: 6px;">
                                            <?= $statusText ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Data rekap bulanan tidak tersedia.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
