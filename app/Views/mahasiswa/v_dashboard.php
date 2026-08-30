<?= $this->extend('layout/mahasiswa') ?>

<?= $this->section('breadcrumb') ?>
<span class="text-dark fw-medium">Dashboard</span>
<?= $this->endSection() ?>

<?= $this->section('extra_css') ?>
<style>
    /* ========================================
       UNIFIED DASHBOARD - MAHASISWA
       ======================================== */

    /* --- WELCOME BANNER --- */
    .welcome-banner {
        background: linear-gradient(120deg, #102a43 0%, #1769aa 62%, #2f8fca 100%);
        color: white;
        border-radius: 16px;
        padding: 34px 36px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 16px 34px rgba(16, 42, 67, 0.18);
    }
    .welcome-banner::after {
        content: '';
        position: absolute;
        right: -40px; top: -40px;
        width: 200px; height: 200px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
    }
    .welcome-banner::before {
        content: '';
        position: absolute;
        right: 125px;
        bottom: -100px;
        width: 230px;
        height: 230px;
        border: 1px solid rgba(255,255,255,0.14);
        border-radius: 50%;
    }
    .welcome-banner .welcome-greeting {
        font-size: 0.82rem;
        color: rgba(255,255,255,0.55);
        margin-bottom: 4px;
    }
    .welcome-banner .welcome-name {
        font-size: 1.6rem;
        font-weight: 800;
        letter-spacing: -0.5px;
        margin-bottom: 2px;
    }
    .welcome-banner .welcome-meta {
        font-size: 0.82rem;
        color: rgba(255,255,255,0.5);
    }
    .welcome-kicker {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 12px;
        color: #bfe7f7;
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 1.1px;
        text-transform: uppercase;
    }
    .welcome-side-note {
        max-width: 190px;
        margin-top: 12px;
        color: rgba(255,255,255,0.62);
        font-size: 0.76rem;
        line-height: 1.5;
    }

    .dashboard-summary {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 24px;
    }
    .summary-tile {
        position: relative;
        min-height: 112px;
        overflow: hidden;
        padding: 18px 19px;
        background: #ffffff;
        border: 1px solid #dce5ec;
        border-radius: 12px;
        box-shadow: 0 9px 22px rgba(16,42,67,0.055);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .summary-tile:hover { transform: translateY(-3px); box-shadow: 0 14px 28px rgba(16,42,67,0.11); }
    .summary-tile::after {
        content: '';
        position: absolute;
        width: 76px;
        height: 76px;
        right: -30px;
        bottom: -34px;
        border-radius: 50%;
        background: rgba(47,143,202,0.08);
    }
    .summary-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 35px;
        height: 35px;
        margin-bottom: 13px;
        border-radius: 9px;
        color: #1769aa;
        background: #eaf5fb;
        font-size: 1rem;
    }
    .summary-label { color: #718492; font-size: 0.7rem; font-weight: 800; letter-spacing: 0.65px; text-transform: uppercase; }
    .summary-value { margin-top: 4px; color: var(--text-dark); font-size: 0.96rem; font-weight: 800; line-height: 1.25; }
    .summary-value.compact { font-size: 0.84rem; }
    .section-kicker { color: #718492; font-size: 0.7rem; font-weight: 800; letter-spacing: 0.8px; text-transform: uppercase; }
    .next-action-card { display: flex; align-items: center; justify-content: space-between; gap: 18px; margin-bottom: 24px; padding: 18px 21px; background: #fff; border: 1px solid #cfe3ed; border-left: 4px solid #2f8fca; border-radius: 11px; box-shadow: 0 8px 20px rgba(16,42,67,0.055); }
    .next-action-card.warning { border-color: #f1dfab; border-left-color: #e7a91a; background: #fffdf7; }
    .next-action-card.success { border-color: #c9ead6; border-left-color: #2c9a63; background: #fbfffc; }
    .next-action-icon { display: inline-flex; align-items: center; justify-content: center; flex: 0 0 38px; width: 38px; height: 38px; color: #1769aa; background: #eaf5fb; border-radius: 9px; font-size: 1rem; }
    .next-action-card.warning .next-action-icon { color: #9a6700; background: #fff1c7; }
    .next-action-card.success .next-action-icon { color: #177245; background: #eaf8f0; }
    .next-action-title { color: var(--text-dark); font-size: 0.84rem; font-weight: 800; }
    .next-action-copy { margin-top: 2px; color: var(--text-muted); font-size: 0.76rem; line-height: 1.45; }
    .next-action-card .btn-action { flex: 0 0 auto; padding: 9px 14px; font-size: 0.78rem; }

    /* --- STATUS BADGE --- */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 0.74rem;
        font-weight: 700;
        letter-spacing: 0.3px;
    }
    .status-badge.st-belum     { background: rgba(255,255,255,0.12); color: rgba(255,255,255,0.7); }
    .status-badge.st-menunggu  { background: rgba(234,179,8,0.2); color: #fde047; }
    .status-badge.st-info      { background: rgba(14,165,233,0.2); color: #7dd3fc; }
    .status-badge.st-revision  { background: rgba(167,139,250,0.2); color: #c4b5fd; }
    .status-badge.st-ditolak   { background: rgba(239,68,68,0.2); color: #fca5a5; }
    .status-badge.st-aktif     { background: rgba(16,185,129,0.2); color: #6ee7b7; }
    .status-badge.st-selesai   { background: rgba(14,165,233,0.2); color: #7dd3fc; }

    /* --- CARD FLAT --- */
    .card-flat {
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.04);
        border-radius: 14px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }
    .card-flat .card-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #94a3b8;
        margin-bottom: 14px;
    }

    /* --- STEPPER HORIZONTAL --- */
    .stepper-h {
        display: flex;
        align-items: flex-start;
        position: relative;
        padding: 0;
        margin: 0;
        list-style: none;
    }
    .stepper-h .step-item {
        flex: 1;
        text-align: center;
        position: relative;
    }
    .stepper-h .step-item::before {
        content: '';
        position: absolute;
        top: 16px;
        left: -50%;
        width: 100%;
        height: 2px;
        background: #e2e8f0;
        z-index: 0;
    }
    .stepper-h .step-item:first-child::before {
        display: none;
    }
    .stepper-h .step-item.completed::before { background: #10b981; }
    .stepper-h .step-item.current::before   { background: #0ea5e9; }

    .step-circle {
        width: 34px; height: 34px;
        border-radius: 50%;
        background: #f1f5f9;
        border: 2px solid #e2e8f0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.78rem;
        font-weight: 700;
        color: #94a3b8;
        position: relative;
        z-index: 2;
        transition: all 0.3s ease;
    }
    .step-item.completed .step-circle {
        background: #10b981; border-color: #10b981; color: #fff;
    }
    .step-item.current .step-circle {
        background: #0ea5e9; border-color: #0ea5e9; color: #fff;
        box-shadow: 0 0 0 4px rgba(14,165,233,0.18);
    }
    .step-item.rejected .step-circle {
        background: #ef4444; border-color: #ef4444; color: #fff;
        box-shadow: 0 0 0 4px rgba(239,68,68,0.15);
    }
    .step-label {
        display: block;
        font-size: 0.72rem;
        font-weight: 600;
        color: #94a3b8;
        margin-top: 8px;
        line-height: 1.3;
    }
    .stepper-h .step-item:not(:last-child)::after {
        content: '';
        display: block;
        width: 72%;
        height: 1px;
        margin: 14px auto 0;
        background: #edf2f5;
    }
    .step-item.completed .step-label,
    .step-item.current .step-label { color: var(--text-dark); }
    .step-item.rejected .step-label { color: #ef4444; }

    /* --- ALERT CARDS --- */
    .alert-card {
        border-radius: 12px;
        padding: 18px 22px;
        display: flex;
        align-items: flex-start;
        gap: 14px;
        font-size: 0.88rem;
        line-height: 1.6;
    }
    .alert-card.alert-info     { background: #f0f9ff; border-left: 4px solid #0ea5e9; color: #0c4a6e; }
    .alert-card.alert-warning  { background: #fffbeb; border-left: 4px solid #f59e0b; color: #78350f; }
    .alert-card.alert-danger   { background: #fef2f2; border-left: 4px solid #ef4444; color: #7f1d1d; }
    .alert-card.alert-success  { background: #f0fdf4; border-left: 4px solid #10b981; color: #064e3b; }
    .alert-card .alert-icon    { font-size: 1.2rem; flex-shrink: 0; margin-top: 2px; }

    /* --- INFO ROW --- */
    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.86rem;
    }
    .info-row:last-child { border-bottom: none; }
    .info-row .info-label { color: #64748b; font-weight: 500; }
    .info-row .info-value { color: var(--text-dark); font-weight: 600; text-align: right; }

    /* --- QUICK ACTION BTN --- */
    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 22px;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
    }
    .btn-action.primary   { background: #0ea5e9; color: #fff; }
    .btn-action.primary:hover { background: #0284c7; color: #fff; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(14,165,233,0.3); }
    .btn-action.warning   { background: #f59e0b; color: #fff; }
    .btn-action.warning:hover { background: #d97706; color: #fff; transform: translateY(-1px); }
    .btn-action.outline   { background: transparent; color: var(--text-dark); border: 1.5px solid #e2e8f0; }
    .btn-action.outline:hover { border-color: #0ea5e9; color: #0ea5e9; }

    /* --- PROGRESS BAR --- */
    .progress-slim {
        height: 6px; background: #e2e8f0; border-radius: 10px; overflow: hidden;
    }
    .progress-slim .bar {
        height: 100%; border-radius: 10px; background: #0ea5e9; transition: width 0.6s ease;
    }

    /* --- DOC ITEM --- */
    .doc-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 16px;
        background: #f8fafc;
        border-radius: 10px;
        margin-bottom: 8px;
        transition: background 0.2s;
    }
    .doc-item:hover { background: #f1f5f9; }
    .doc-item .doc-icon {
        width: 38px; height: 38px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    .doc-item .doc-name { font-size: 0.85rem; font-weight: 600; color: var(--text-dark); }
    .doc-item .doc-desc { font-size: 0.75rem; color: #94a3b8; margin-top: 2px; }

    @media (max-width: 991.98px) {
        .dashboard-summary { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 575.98px) {
        .welcome-banner { padding: 26px 22px; }
        .welcome-banner .welcome-name { font-size: 1.35rem; }
        .welcome-side-note { display: none; }
        .dashboard-summary { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px; }
        .summary-tile { min-height: 104px; padding: 15px; }
        .summary-value { font-size: 0.82rem; }
        .summary-value.compact { font-size: 0.75rem; }
        .next-action-card { align-items: flex-start; flex-wrap: wrap; padding: 16px; }
        .next-action-card .next-action-icon { flex-basis: 34px; width: 34px; height: 34px; }
        .next-action-card .btn-action { width: 100%; justify-content: center; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
    // --- Pre-compute data ---
    $statusText  = 'Belum Mengajukan';
    $statusClass = 'st-belum';
    $statusIcon  = 'bi-dash-circle';

    if ($state == 1) {
        $statusText  = 'Belum Mengajukan';
        $statusClass = 'st-belum';
        $statusIcon  = 'bi-dash-circle';
    } elseif ($state == 2) {
        $statusText  = 'Menunggu';
        $statusClass = 'st-menunggu';
        $statusIcon  = 'bi-hourglass-split';
    } elseif ($state == 3) {
        $statusText  = 'Disetujui';
        $statusClass = 'st-info';
        $statusIcon  = 'bi-check2-square';
    } elseif ($state == 4) {
        $statusText  = 'Aktif Berjalan';
        $statusClass = 'st-aktif';
        $statusIcon  = 'bi-play-circle-fill';
    } elseif ($state == 5) {
        $statusText  = 'Selesai';
        $statusClass = 'st-selesai';
        $statusIcon  = 'bi-check-circle-fill';
    } elseif ($state == 6) {
        $statusText  = 'Perbaikan Berkas';
        $statusClass = 'st-revision';
        $statusIcon  = 'bi-pencil-square';
    } elseif ($state == 7) {
        $statusText  = 'Ditolak';
        $statusClass = 'st-ditolak';
        $statusIcon  = 'bi-x-circle-fill';
    }

    // Jenis permohonan label
    $jenisLabel = 'Belum Dipilih';
    if (isset($jenis_permohonan) && $state != 1) {
        if ($jenis_permohonan == 1) $jenisLabel = 'Penelitian Skripsi / Tugas Akhir';
        elseif ($jenis_permohonan == 2) $jenisLabel = 'Observasi / Pengambilan Data';
        elseif ($jenis_permohonan == 3) $jenisLabel = 'Magang';
        elseif ($jenis_permohonan == 5) $jenisLabel = 'Praktik Kerja Lapangan (PKL)';
        elseif ($jenis_permohonan == 4) $jenisLabel = 'Uji Coba Produk (Prototype)';
    }

    $is_selesai_banner = false;
    if ($state == 5) {
        $is_selesai_banner = true;
        $state = 1; // Reset tampilan ke State 1
        $statusText  = 'Belum Mengajukan';
        $statusClass = 'st-belum';
        $statusIcon  = 'bi-dash-circle';
        $jenisLabel  = 'Belum Dipilih';
        $file_penerimaan = null; // Hide current cycle docs
        $permohonan_aktif = null; // Reset aktif permohonan agar tidak bocor ke stepper
    }
?>

<!-- ============================================
     SECTION 1: WELCOME BANNER (SELALU TAMPIL)
     ============================================ -->
<div class="mb-4">
    <h3 class="fw-semibold mb-1 text-dark">Halo, <?= esc($nama) ?>!</h3>
    <p class="text-muted mb-0">Selamat datang di Portal Peserta Akademik. Pantau tahapan layanan Anda dari sini.</p>
</div>

<?php
    $documentCount = (!empty($file_penerimaan) ? 1 : 0) + (!empty($file_sertifikat) ? 1 : 0) + (!empty($file_piagam) ? 1 : 0);
    // Jika reset state, dokumen anggap 0 (atau hide sertifikat)
    if ($is_selesai_banner) $documentCount = 0;
    
    $summaryLogbook = (in_array($state, [4, 5])) ? ($total_logbook . ' catatan') : 'Belum dimulai';
?>
<div class="dashboard-summary" aria-label="Ringkasan aktivitas mahasiswa">
    <div class="summary-tile">
        <span class="summary-icon"><i class="bi bi-activity"></i></span>
        <div class="summary-label">Status</div>
        <div class="summary-value"><span class="status-badge <?= $statusClass ?>"><i class="<?= $statusIcon ?>"></i> <?= esc($statusText) ?></span></div>
    </div>
    <div class="summary-tile">
        <span class="summary-icon"><i class="bi bi-file-earmark-text"></i></span>
        <div class="summary-label">Jenis permohonan</div>
        <div class="summary-value compact"><?= esc($jenisLabel) ?></div>
    </div>
    <div class="summary-tile">
        <span class="summary-icon"><i class="bi bi-journal-check"></i></span>
        <div class="summary-label">Logbook</div>
        <div class="summary-value"><?= esc($summaryLogbook) ?></div>
    </div>
    <div class="summary-tile">
        <span class="summary-icon"><i class="bi bi-folder2-open"></i></span>
        <div class="summary-label">Dokumen tersedia</div>
        <div class="summary-value"><?= $documentCount ?> dokumen</div>
    </div>
</div>

<?php if ($state == 1): ?>
    <div class="next-action-card">
        <span class="next-action-icon"><i class="bi bi-arrow-right-circle"></i></span>
        <div class="flex-grow-1"><div class="next-action-title">Mulai layanan akademik Anda</div><div class="next-action-copy">Siapkan dokumen persyaratan dan buat permohonan baru untuk memulai proses.</div></div>
        <a href="<?= base_url('mahasiswa/permohonan') ?>" class="btn-action primary"><i class="bi bi-file-earmark-plus"></i> Mulai Pengajuan</a>
    </div>

<?php elseif ($state == 4 && in_array($jenis_permohonan, [3, 5]) && $is_log_book == 'ya'): ?>
    <div class="next-action-card success">
        <span class="next-action-icon"><i class="bi bi-journal-check"></i></span>
        <div class="flex-grow-1"><div class="next-action-title">Catat aktivitas hari ini</div><div class="next-action-copy">Logbook kegiatan Anda aktif. Pastikan aktivitas harian dicatat secara berkala.</div></div>
        <a href="<?= base_url('mahasiswa/logbook') ?>" class="btn-action primary"><i class="bi bi-pencil-square"></i> Isi Logbook</a>
    </div>
<?php elseif ($state == 2): ?>
    <div class="next-action-card">
        <span class="next-action-icon"><i class="bi bi-hourglass-split"></i></span>
        <div class="flex-grow-1"><div class="next-action-title">Tidak ada tindakan yang diperlukan</div><div class="next-action-copy">Permohonan Anda sedang diproses. Pantau pembaruan melalui halaman status permohonan.</div></div>
        <a href="<?= base_url('mahasiswa/status') ?>" class="btn-action outline"><i class="bi bi-clock-history"></i> Pantau Status</a>
    </div>
<?php elseif ($state == 3): ?>
    <div class="next-action-card success">
        <span class="next-action-icon"><i class="bi bi-check2-square"></i></span>
        <div class="flex-grow-1"><div class="next-action-title">Permohonan Disetujui</div><div class="next-action-copy">Permohonan Anda telah disetujui. Silakan cek menu Status Permohonan atau Dokumen untuk mengunduh Surat Keterangan Diterima. Status akan berubah menjadi "Berjalan" saat periode pelaksanaan tiba.</div></div>
        <a href="<?= base_url('mahasiswa/status') ?>" class="btn-action outline"><i class="bi bi-clock-history"></i> Lihat Detail</a>
    </div>
<?php endif; ?>

<!-- ============================================
     SECTION 2: STEPPER HORIZONTAL (SELALU TAMPIL)
     ============================================ -->
<div class="card-flat mb-4">
    <div class="card-label"><i class="bi bi-signpost-split me-1"></i> Tahapan Alur Permohonan</div>
    <ul class="stepper-h">
        <!-- Step 1: Pengajuan -->
        <li class="step-item <?= ($state >= 2) ? 'completed' : (($state == 1) ? 'current' : '') ?>">
            <div class="step-circle"><?= ($state >= 2) ? '<i class="bi bi-check-lg"></i>' : '1' ?></div>
            <span class="step-label">Pengajuan<br>Permohonan</span>
        </li>
        
        <!-- Step 2: Verifikasi Sekretariat -->
        <?php
            $step2_class = ''; $step2_icon = '2';
            if ($state == 6) { 
                $step2_class = 'rejected'; $step2_icon = '<i class="bi bi-pencil-square"></i>'; 
            } elseif (isset($permohonan_aktif['status_persetujuan']) && $permohonan_aktif['status_persetujuan'] == 'DISETUJUI') {
                $step2_class = 'completed'; $step2_icon = '<i class="bi bi-check-lg"></i>';
            } elseif ($state == 2) {
                $step2_class = 'current';
            } elseif ($state >= 4) {
                $step2_class = 'completed'; $step2_icon = '<i class="bi bi-check-lg"></i>';
            }
        ?>
        <li class="step-item <?= $step2_class ?>">
            <div class="step-circle"><?= $step2_icon ?></div>
            <span class="step-label">Verifikasi<br>Berkas</span>
        </li>
        
        <!-- Step 3: Persetujuan Kabid -->
        <?php
            $step3_class = ''; $step3_icon = '3';
            if ($state >= 3 && $state != 6) {
                $step3_class = 'completed'; $step3_icon = '<i class="bi bi-check-lg"></i>';
            } elseif ($state == 2 && isset($permohonan_aktif['status_persetujuan']) && $permohonan_aktif['status_persetujuan'] == 'DISETUJUI') {
                $step3_class = 'current'; $step3_icon = '<i class="bi bi-diagram-3-fill"></i>';
            }
        ?>
        <li class="step-item <?= $step3_class ?>">
            <div class="step-circle"><?= $step3_icon ?></div>
            <span class="step-label">Persetujuan</span>
        </li>
        
        <!-- Step 4: Pelaksanaan -->
        <li class="step-item <?= ($state == 5) ? 'completed' : (($state == 4) ? 'current' : '') ?>">
            <div class="step-circle"><?= ($state == 5) ? '<i class="bi bi-check-lg"></i>' : (($state == 4) ? '<i class="bi bi-play-fill"></i>' : '4') ?></div>
            <span class="step-label">Pelaksanaan<br>Kegiatan</span>
        </li>
        
        <!-- Step 5: Selesai -->
        <li class="step-item <?= ($state == 5) ? 'completed' : '' ?>">
            <div class="step-circle"><?= ($state == 5) ? '<i class="bi bi-check-lg"></i>' : '5' ?></div>
            <span class="step-label">Selesai</span>
        </li>
    </ul>
</div>

<!-- ============================================
     SECTION 3: KONTEN DINAMIS PER STATE
     ============================================ -->

<?php if ($state == 1): ?>
<!-- ===================== STATE 1 & 5: BELUM MENGAJUKAN / RESET ===================== -->
<div class="row g-4">
    <div class="col-12 col-lg-7">
        <div class="card-flat h-100">
            <div class="card-label"><i class="bi bi-file-earmark-check me-1"></i> Persyaratan Dokumen</div>
            <p class="text-muted mb-3" style="font-size:0.84rem;">Pastikan dokumen berikut sudah siap dalam format <strong>PDF</strong> (maks. 2MB) sebelum mengajukan permohonan:</p>

            <div class="doc-item">
                <div class="doc-icon bg-primary bg-opacity-10 text-primary"><i class="bi bi-envelope-paper-fill"></i></div>
                <div>
                    <div class="doc-name">Surat Pengantar Resmi Kampus</div>
                    <div class="doc-desc">Surat resmi dari kampus yang ditujukan kepada Dinas Kominfo Kota Tangerang.</div>
                </div>
            </div>

            <div class="doc-item">
                <div class="doc-icon bg-info bg-opacity-10 text-info"><i class="bi bi-person-lines-fill"></i></div>
                <div>
                    <div class="doc-name">Curriculum Vitae (CV)</div>
                    <div class="doc-desc">CV terbaru berisi data diri, pendidikan, dan keahlian teknis Anda.</div>
                </div>
            </div>

            <div class="doc-item">
                <div class="doc-icon bg-secondary bg-opacity-10 text-secondary"><i class="bi bi-journal-text"></i></div>
                <div>
                    <div class="doc-name">Proposal Penelitian <span class="badge bg-light text-secondary border ms-1" style="font-size:0.65rem;">Khusus Skripsi/TA</span></div>
                    <div class="doc-desc">Diwajibkan hanya untuk permohonan jenis "Penelitian Skripsi/TA".</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-5">
        <div class="card-flat h-100 d-flex flex-column">
            <div class="card-label"><i class="bi bi-info-circle me-1"></i> Informasi</div>
            <div class="alert-card alert-info mb-3">
                <i class="bi bi-lightbulb alert-icon"></i>
                <div>Anda belum memiliki permohonan aktif. Silakan siapkan dokumen persyaratan lalu klik tombol di bawah untuk mulai mengajukan.</div>
            </div>
            <div class="mt-auto">
                <a href="<?= base_url('mahasiswa/permohonan') ?>" class="btn-action primary w-100 justify-content-center">
                    <i class="bi bi-file-earmark-plus-fill"></i> Ajukan Permohonan Baru
                </a>
            </div>
        </div>
    </div>
</div>


<?php elseif ($state == 2): ?>
<!-- ===================== STATE 2: MENUNGGU VERIFIKASI ===================== -->
<div class="row g-4">
    <div class="col-12 col-lg-7">
        <div class="card-flat h-100">
            <div class="card-label"><i class="bi bi-clipboard-data me-1"></i> Detail Permohonan Terkirim</div>
            <?php if (isset($permohonan_aktif) && $permohonan_aktif): ?>
                <div class="info-row">
                    <span class="info-label">Jenis Permohonan</span>
                    <span class="info-value"><?= $jenisLabel ?></span>
                </div>

                <div class="info-row">
                    <span class="info-label">Periode Pelaksanaan</span>
                    <span class="info-value"><?= tgl_indo($permohonan_aktif['tgl_mulai']) ?> s/d <?= tgl_indo($permohonan_aktif['tgl_selesai']) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Pengajuan</span>
                    <span class="info-value"><?= tgl_indo($permohonan_aktif['created_at'], true) ?></span>
                </div>
                <div class="mt-3">
                    <?php
                        $idJenis = (int)($permohonan_aktif['id_jenis_permohonan'] ?? ($jenis_permohonan ?? 0));
                        if ($idJenis === 1) {
                            $label1 = 'Judul / Topik Skripsi:';
                            $label2 = 'Fokus Penelitian / Data yang Dicari:';
                        } elseif ($idJenis === 2) {
                            $label1 = 'Tujuan Observasi / Mata Kuliah:';
                            $label2 = 'Daftar Kebutuhan Data:';
                        } elseif ($idJenis === 4) {
                            $label1 = 'Nama Sistem / Prototype:';
                            $label2 = 'Skenario Uji Coba:';
                        } else {
                            $label1 = 'Keahlian Utama:';
                            $label2 = 'Apa yang ingin Anda kerjakan?:';
                        }
                    ?>
                    <div class="text-muted small mb-1" style="font-size:0.76rem;"><?= $label1 ?></div>
                    <p class="mb-2" style="font-size:0.86rem; line-height:1.6;"><?= esc($permohonan_aktif['deskripsi_keahlian'] ?? '-') ?></p>

                    <div class="text-muted small mb-1" style="font-size:0.76rem;"><?= $label2 ?></div>
                    <p class="mb-0" style="font-size:0.86rem; line-height:1.6;"><?= esc($permohonan_aktif['deskripsi'] ?? ($permohonan_aktif['rencana_kegiatan'] ?? '-')) ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-12 col-lg-5">
        <div class="card-flat h-100 d-flex flex-column">
            <div class="card-label"><i class="bi bi-hourglass-split me-1"></i> Status</div>
            
            <?php if (isset($permohonan_aktif['status_persetujuan']) && $permohonan_aktif['status_persetujuan'] == 'DISETUJUI'): ?>
                <?php if (isset($permohonan_aktif['disposisi']) && $permohonan_aktif['disposisi'] == '1'): ?>
                    <div class="alert-card alert-info mb-3">
                        <i class="bi bi-diagram-3-fill alert-icon"></i>
                        <div>Berkas permohonan Anda telah diverifikasi oleh Sekretariat dan saat ini sedang <strong>menunggu persetujuan dan penempatan</strong> oleh Bidang.</div>
                    </div>
                <?php else: ?>
                    <div class="alert-card alert-warning mb-3">
                        <i class="bi bi-building alert-icon"></i>
                        <div>Berkas permohonan Anda telah dinyatakan VALID. Saat ini sedang <strong>menunggu plotting penempatan bidang</strong> oleh Sekretariat.</div>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="alert-card alert-warning mb-3">
                    <i class="bi bi-clock-history alert-icon"></i>
                    <div>Berkas permohonan Anda sedang dalam <strong>proses verifikasi</strong> oleh Sekretariat. Estimasi waktu peninjauan: <strong>1–3 hari kerja</strong>.</div>
                </div>
            <?php endif; ?>

            <div class="mt-auto">
                <a href="<?= base_url('mahasiswa/status') ?>" class="btn-action outline w-100 justify-content-center">
                    <i class="bi bi-eye"></i> Lihat Status Permohonan
                </a>
            </div>
        </div>
    </div>
</div>


<?php elseif ($state == 7): ?>
<!-- ===================== STATE 7: DITOLAK / DIKEMBALIKAN ===================== -->
<div class="row g-4">
    <div class="col-12">
        <div class="alert-card alert-danger">
            <i class="bi bi-exclamation-triangle-fill alert-icon"></i>
            <div>
                <strong>Permohonan Anda Ditolak</strong><br>
                <?php
                    $jenisLabel = 'permohonan';
                    if (isset($jenis_permohonan) && $jenis_permohonan == 1) {
                        $jenisLabel = 'penelitian / skripsi';
                    } elseif (isset($jenis_permohonan) && $jenis_permohonan == 2) {
                        $jenisLabel = 'observasi / pengambilan data';
                    } elseif (isset($jenis_permohonan) && in_array($jenis_permohonan, [3, 5])) {
                        $jenisLabel = 'magang / PKL';
                    }
                ?>
                Mohon maaf, permohonan <?= esc($jenisLabel) ?> Anda tidak dapat disetujui saat ini. Silakan lihat catatan evaluasi dari Sekretariat di bawah ini.
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-7">
        <div class="card-flat h-100">
            <div class="card-label"><i class="bi bi-chat-square-text me-1"></i> Catatan Evaluasi dari Sekretariat</div>
            <div style="background:#fef2f2; border-radius:10px; padding:16px 20px; font-size:0.9rem; line-height:1.7; color:#991b1b;">
                <i class="bi bi-quote" style="font-size:1.2rem; opacity:0.3;"></i><br>
                <?= esc($catatan_tolak ?? 'Tidak ada catatan spesifik. Harap periksa kembali persyaratan untuk pengajuan magang.') ?>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-5">
        <div class="card-flat h-100 d-flex flex-column">
            <div class="card-label"><i class="bi bi-arrow-repeat me-1"></i> Langkah Selanjutnya</div>
            <div class="alert-card alert-info mb-3">
                <i class="bi bi-info-circle alert-icon"></i>
                <div>Siklus permohonan ini telah ditutup. Anda dapat membuat pengajuan permohonan baru dari awal jika ingin mencoba kembali.</div>
            </div>
            <div class="mt-auto d-flex flex-column gap-2">
                <a href="<?= base_url('mahasiswa/permohonan') ?>" class="btn-action warning w-100 justify-content-center">
                    <i class="bi bi-plus-circle"></i> Buat Permohonan Baru
                </a>
                <a href="<?= base_url('mahasiswa/status') ?>" class="btn-action outline w-100 justify-content-center">
                    <i class="bi bi-clock-history"></i> Lihat Riwayat Status
                </a>
            </div>
        </div>
    </div>
</div>


<?php elseif ($state == 6): ?>
<!-- ===================== STATE 6: PERBAIKAN BERKAS ===================== -->
<div class="row g-4">
    <div class="col-12">
        <div class="alert-card alert-warning">
            <i class="bi bi-pencil-square alert-icon"></i>
            <div>
                <strong>Perbaikan Berkas (Revisi)</strong><br>
                Terdapat kekurangan atau kesalahan pada dokumen yang Anda kirimkan. Silakan perbaiki dokumen sesuai catatan di bawah ini tanpa perlu membuat permohonan baru.
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-7">
        <div class="card-flat h-100">
            <div class="card-label"><i class="bi bi-chat-square-text me-1"></i> Catatan Revisi dari Sekretariat</div>
            <div style="background:#fffbeb; border-radius:10px; padding:16px 20px; font-size:0.9rem; line-height:1.7; color:#78350f;">
                <i class="bi bi-quote" style="font-size:1.2rem; opacity:0.3;"></i><br>
                <?= esc($catatan_tolak ?? 'Tidak ada catatan spesifik. Harap periksa kembali kelengkapan seluruh dokumen.') ?>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-5">
        <div class="card-flat h-100 d-flex flex-column">
            <div class="card-label"><i class="bi bi-arrow-repeat me-1"></i> Langkah Selanjutnya</div>
            <div class="alert-card alert-info mb-3">
                <i class="bi bi-info-circle alert-icon"></i>
                <div>Perbaiki dokumen sesuai catatan melalui form perbaikan.</div>
            </div>
            <div class="mt-auto d-flex flex-column gap-2">
                <a href="<?= base_url('mahasiswa/permohonan') ?>" class="btn-action warning w-100 justify-content-center">
                    <i class="bi bi-pencil-square"></i> Revisi Dokumen Sekarang
                </a>
            </div>
        </div>
    </div>
</div>

<?php elseif ($state == 4 || $state == 3): ?>
<!-- ===================== STATE 3 & 4: DISETUJUI / AKTIF BERJALAN ===================== -->
<?php
    $total_logbook  = $total_logbook ?? 0;
    $target_logbook = $target_logbook ?? 0;
    $pct_logbook    = ($target_logbook > 0) ? round(($total_logbook / $target_logbook) * 100) : 0;
    if ($pct_logbook > 100) $pct_logbook = 100;
?>
<div class="row g-4">
    <!-- Info Penempatan -->
    <div class="col-12 col-lg-7">
        <div class="card-flat h-100">
            <div class="card-label"><i class="bi bi-building me-1"></i> Informasi Penempatan</div>
            <?php if (isset($permohonan_aktif) && $permohonan_aktif): ?>
                <div class="info-row">
                    <span class="info-label">Jenis Kegiatan</span>
                    <span class="info-value"><?= $jenisLabel ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Periode Kegiatan</span>
                    <span class="info-value"><?= tgl_indo($permohonan_aktif['tgl_mulai']) ?> — <?= tgl_indo($permohonan_aktif['tgl_selesai']) ?></span>
                </div>
                <div class="mt-3">
                    <?php
                        $idJenis = (int)($permohonan_aktif['id_jenis_permohonan'] ?? ($jenis_permohonan ?? 0));
                        if ($idJenis === 1) {
                            $label1 = 'Judul / Topik Skripsi:';
                            $label2 = 'Fokus Penelitian / Data yang Dicari:';
                        } elseif ($idJenis === 2) {
                            $label1 = 'Tujuan Observasi / Mata Kuliah:';
                            $label2 = 'Daftar Kebutuhan Data:';
                        } elseif ($idJenis === 4) {
                            $label1 = 'Nama Sistem / Prototype:';
                            $label2 = 'Skenario Uji Coba:';
                        } else {
                            $label1 = 'Keahlian Utama:';
                            $label2 = 'Apa yang ingin Anda kerjakan?:';
                        }
                    ?>
                    <div class="text-muted small mb-1" style="font-size:0.76rem;"><?= $label1 ?></div>
                    <p class="mb-2" style="font-size:0.86rem; line-height:1.6;"><?= esc($permohonan_aktif['deskripsi_keahlian'] ?? '-') ?></p>

                    <div class="text-muted small mb-1" style="font-size:0.76rem;"><?= $label2 ?></div>
                    <p class="mb-0" style="font-size:0.86rem; line-height:1.6;"><?= esc($permohonan_aktif['deskripsi'] ?? ($permohonan_aktif['rencana_kegiatan'] ?? '-')) ?></p>
                </div>
            <?php endif; ?>

            <?php if (in_array($jenis_permohonan, [3, 5]) && $is_log_book == 'ya'): ?>
                <!-- Progress Logbook (Khusus Magang) -->
                <hr class="my-3" style="border-color:#f1f5f9;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span style="font-size:0.82rem; font-weight:600; color:var(--text-dark);">Progress Logbook</span>
                    <span style="font-size:0.82rem; font-weight:700; color:#0ea5e9;"><?= $total_logbook ?> / <?= $target_logbook ?> hari</span>
                </div>
                <div class="progress-slim mb-2">
                    <div class="bar" style="width:<?= $pct_logbook ?>%;"></div>
                </div>
                <div class="text-muted" style="font-size:0.74rem;"><?= $pct_logbook ?>% target logbook tercapai</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-12 col-lg-5">
        <div class="card-flat h-100 d-flex flex-column">
            <div class="card-label"><i class="bi bi-lightning me-1"></i> Aksi Cepat</div>

            <div class="alert-card alert-success mb-3">
                <i class="bi bi-check-circle alert-icon"></i>
                <div>Permohonan Anda telah <strong>disetujui</strong>. Silakan laksanakan kegiatan sesuai ketentuan yang berlaku.</div>
            </div>

            <div class="mt-auto d-flex flex-column gap-2">
                <?php if (in_array($jenis_permohonan, [3, 5]) && $is_log_book == 'ya'): ?>
                    <a href="<?= base_url('mahasiswa/logbook') ?>" class="btn-action primary w-100 justify-content-center">
                        <i class="bi bi-pencil-square"></i> Isi Logbook Hari Ini
                    </a>
                <?php endif; ?>
                <?php if (!empty($file_penerimaan)): ?>
                    <a href="<?= base_url($file_penerimaan) ?>" target="_blank" class="btn-action w-100 justify-content-center" style="background:#f0fdf4; color:#166534; border:1px solid #bbf7d0;">
                        <i class="bi bi-download"></i> Download Surat Penerimaan
                    </a>
                <?php endif; ?>
                <a href="<?= base_url('mahasiswa/status') ?>" class="btn-action outline w-100 justify-content-center">
                    <i class="bi bi-clock-history"></i> Lihat Riwayat Status
                </a>
                <a href="<?= base_url('mahasiswa/profil') ?>" class="btn-action outline w-100 justify-content-center">
                    <i class="bi bi-person"></i> Lihat Profil Saya
                </a>
            </div>
        </div>
    </div>
</div>


<?php endif; ?>

<?= $this->endSection() ?>