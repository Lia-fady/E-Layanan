<?= $this->extend('layout/L_mahasiswa') ?>

<?= $this->section('breadcrumb') ?>
E-Layanan Akademik &raquo; <span class="text-uppercase" style="color: var(--primary-royal);">Dashboard</span>
<?= $this->endSection() ?>

<?= $this->section('extra_css') ?>
<style>
    /* ========================================
       UNIFIED DASHBOARD - MAHASISWA
       ======================================== */

    /* --- WELCOME BANNER --- */
    .welcome-banner {
        background: linear-gradient(135deg, var(--primary-navy) 0%, var(--primary-royal) 100%);
        color: white;
        border-radius: 16px;
        padding: 28px 32px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(10, 29, 55, 0.12);
    }
    .welcome-banner::after {
        content: '';
        position: absolute;
        right: -40px; top: -40px;
        width: 200px; height: 200px;
        background: rgba(255,255,255,0.04);
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
        $statusText  = 'Ditolak / Dikembalikan';
        $statusClass = 'st-ditolak';
        $statusIcon  = 'bi-x-circle-fill';
    } elseif ($state == 4) {
        $statusText  = 'Aktif Berjalan';
        $statusClass = 'st-aktif';
        $statusIcon  = 'bi-play-circle-fill';
    } elseif ($state == 5) {
        $statusText  = 'Selesai';
        $statusClass = 'st-selesai';
        $statusIcon  = 'bi-check-circle-fill';
    }

    // Jenis permohonan label
    $jenisLabel = 'Belum Dipilih';
    if (isset($jenis_permohonan)) {
        if ($jenis_permohonan == 1) $jenisLabel = 'Penelitian Skripsi / TA';
        elseif ($jenis_permohonan == 2) $jenisLabel = 'Observasi / Pengambilan Data';
        elseif ($jenis_permohonan == 3) $jenisLabel = 'Magang / PKL';
        elseif ($jenis_permohonan == 4) $jenisLabel = 'Uji Coba Produk (Prototype)';
    }
?>

<!-- ============================================
     SECTION 1: WELCOME BANNER (SELALU TAMPIL)
     ============================================ -->
<div class="welcome-banner mb-4">
    <div class="position-relative" style="z-index:1;">
        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
            <div>
                <div class="welcome-greeting">Halo, Selamat Datang</div>
                <div class="welcome-name"><?= esc($nama) ?></div>
                <div class="welcome-meta">
                     <?= esc($nim ?? '-') ?> &bull; <?= esc($kampus ?? '-') ?>
                </div>
            </div>
            <div class="text-end">
                <div class="status-badge <?= $statusClass ?>">
                    <i class="bi <?= $statusIcon ?>"></i> <?= $statusText ?>
                </div>
                <?php if ($state >= 2 && isset($jenis_permohonan)): ?>
                    <div class="mt-2" style="font-size:0.76rem; color:rgba(255,255,255,0.45);"><?= $jenisLabel ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

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
        <li class="step-item <?= ($state >= 4 || $state == 3 || (isset($permohonan_aktif['disposisi']) && $permohonan_aktif['disposisi'] == '1')) ? (($state == 3) ? 'rejected' : 'completed') : (($state == 2 && (!isset($permohonan_aktif['disposisi']) || in_array($permohonan_aktif['disposisi'], [null, '0']))) ? 'current' : '') ?>">
            <div class="step-circle">
                <?php if ($state == 3): ?><i class="bi bi-x-lg"></i>
                <?php elseif ($state >= 4 || (isset($permohonan_aktif['disposisi']) && $permohonan_aktif['disposisi'] == '1')): ?><i class="bi bi-check-lg"></i>
                <?php else: ?>2<?php endif; ?>
            </div>
            <span class="step-label">Verifikasi<br>Sekretariat</span>
        </li>
        <!-- Step 3: Persetujuan Kabid -->
        <li class="step-item <?= ($state >= 4) ? 'completed' : (($state == 2 && isset($permohonan_aktif['disposisi']) && $permohonan_aktif['disposisi'] == '1') ? 'current' : '') ?>">
            <div class="step-circle"><?= ($state >= 4) ? '<i class="bi bi-check-lg"></i>' : (($state == 2 && isset($permohonan_aktif['disposisi']) && $permohonan_aktif['disposisi'] == '1') ? '<i class="bi bi-diagram-3-fill"></i>' : '3') ?></div>
            <span class="step-label">Persetujuan<br>Kepala Bidang</span>
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
<!-- ===================== STATE 1: BELUM MENGAJUKAN ===================== -->
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
                    <span class="info-label">Tanggal Mulai</span>
                    <span class="info-value"><?= date('d M Y', strtotime($permohonan_aktif['tgl_mulai'])) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Selesai</span>
                    <span class="info-value"><?= date('d M Y', strtotime($permohonan_aktif['tgl_selesai'])) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Pengajuan</span>
                    <span class="info-value"><?= date('d M Y, H:i', strtotime($permohonan_aktif['created_at'])) ?></span>
                </div>
                <div class="mt-3">
                    <div class="text-muted small mb-1" style="font-size:0.76rem;">Maksud & Tujuan:</div>
                    <p class="mb-0" style="font-size:0.86rem; line-height:1.6;"><?= esc($permohonan_aktif['deskripsi_magang'] ?? '-') ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-12 col-lg-5">
        <div class="card-flat h-100 d-flex flex-column">
            <div class="card-label"><i class="bi bi-hourglass-split me-1"></i> Status</div>
            
            <?php if (isset($permohonan_aktif['disposisi']) && $permohonan_aktif['disposisi'] == '1'): ?>
                <div class="alert-card alert-info mb-3">
                    <i class="bi bi-diagram-3-fill alert-icon"></i>
                    <div>Berkas permohonan Anda telah diverifikasi oleh Sekretariat dan saat ini sedang <strong>menunggu persetujuan dan penempatan</strong> oleh Kepala Bidang.</div>
                </div>
            <?php elseif (isset($permohonan_aktif['disposisi']) && $permohonan_aktif['disposisi'] == '0'): ?>
                <div class="alert-card alert-warning mb-3">
                    <i class="bi bi-building alert-icon"></i>
                    <div>Berkas permohonan Anda telah dinyatakan VALID. Saat ini sedang <strong>menunggu plotting penempatan bidang</strong> oleh Sekretariat.</div>
                </div>
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


<?php elseif ($state == 3): ?>
<!-- ===================== STATE 3: DITOLAK / DIKEMBALIKAN ===================== -->
<div class="row g-4">
    <div class="col-12">
        <div class="alert-card alert-danger">
            <i class="bi bi-exclamation-triangle-fill alert-icon"></i>
            <div>
                <strong>Permohonan Anda Dikembalikan</strong><br>
                Terdapat kekurangan atau kesalahan pada dokumen yang Anda kirimkan. Silakan perbaiki sesuai catatan di bawah ini dan ajukan kembali.
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-7">
        <div class="card-flat h-100">
            <div class="card-label"><i class="bi bi-chat-square-text me-1"></i> Catatan Evaluasi dari Verifikator</div>
            <div style="background:#fef2f2; border-radius:10px; padding:16px 20px; font-size:0.9rem; line-height:1.7; color:#991b1b;">
                <i class="bi bi-quote" style="font-size:1.2rem; opacity:0.3;"></i><br>
                <?= esc($catatan_tolak ?? 'Tidak ada catatan spesifik. Harap periksa kembali kelengkapan dan kebenaran seluruh dokumen.') ?>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-5">
        <div class="card-flat h-100 d-flex flex-column">
            <div class="card-label"><i class="bi bi-arrow-repeat me-1"></i> Langkah Selanjutnya</div>
            <div class="alert-card alert-info mb-3">
                <i class="bi bi-info-circle alert-icon"></i>
                <div>Perbaiki dokumen sesuai catatan, kemudian ajukan ulang permohonan Anda melalui tombol di bawah.</div>
            </div>
            <div class="mt-auto d-flex flex-column gap-2">
                <a href="<?= base_url('mahasiswa/permohonan') ?>" class="btn-action warning w-100 justify-content-center">
                    <i class="bi bi-pencil-square"></i> Ajukan Ulang Permohonan
                </a>
                <a href="<?= base_url('mahasiswa/status') ?>" class="btn-action outline w-100 justify-content-center">
                    <i class="bi bi-clock-history"></i> Lihat Riwayat Status
                </a>
            </div>
        </div>
    </div>
</div>


<?php elseif ($state == 4): ?>
<!-- ===================== STATE 4: AKTIF BERJALAN ===================== -->
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
                    <span class="info-value"><?= date('d M Y', strtotime($permohonan_aktif['tgl_mulai'])) ?> — <?= date('d M Y', strtotime($permohonan_aktif['tgl_selesai'])) ?></span>
                </div>
                <div class="mt-3">
                    <div class="text-muted small mb-1" style="font-size:0.76rem;">Maksud & Tujuan:</div>
                    <p class="mb-0" style="font-size:0.86rem; line-height:1.6;"><?= esc($permohonan_aktif['deskripsi_magang'] ?? '-') ?></p>
                </div>
            <?php endif; ?>

            <?php if ($jenis_permohonan == 3 && $is_log_book == 'ya'): ?>
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
                <?php if ($jenis_permohonan == 3 && $is_log_book == 'ya'): ?>
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


<?php elseif ($state == 5): ?>
<!-- ===================== STATE 5: SELESAI ===================== -->
<div class="row g-4">
    <div class="col-12">
        <div class="alert-card alert-success">
            <i class="bi bi-trophy-fill alert-icon"></i>
            <div>
                <strong>Selamat!</strong> Kegiatan Anda telah dinyatakan <strong>selesai</strong>. Terima kasih atas partisipasi dan kontribusi Anda selama berkegiatan di Dinas Kominfo Kota Tangerang.
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-7">
        <div class="card-flat h-100">
            <div class="card-label"><i class="bi bi-clipboard-check me-1"></i> Ringkasan Kegiatan</div>
            <?php if (isset($permohonan_aktif) && $permohonan_aktif): ?>
                <div class="info-row">
                    <span class="info-label">Jenis Kegiatan</span>
                    <span class="info-value"><?= $jenisLabel ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Periode</span>
                    <span class="info-value"><?= date('d M Y', strtotime($permohonan_aktif['tgl_mulai'])) ?> — <?= date('d M Y', strtotime($permohonan_aktif['tgl_selesai'])) ?></span>
                </div>
                <?php if ($jenis_permohonan == 3): ?>
                <div class="info-row">
                    <span class="info-label">Total Logbook</span>
                    <span class="info-value"><?= $total_logbook ?? 0 ?> entri</span>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-12 col-lg-5">
        <div class="card-flat h-100 d-flex flex-column">
            <div class="card-label"><i class="bi bi-download me-1"></i> Dokumen Akhir</div>
            <p class="text-muted mb-3" style="font-size:0.84rem;">Anda dapat mengunduh dokumen sertifikat yang telah diterbitkan oleh Bidang terkait.</p>
            <div class="mt-auto d-flex flex-column gap-2">
                <?php if (!empty($file_sertifikat)): ?>
                <a href="<?= base_url($file_sertifikat) ?>" target="_blank" class="btn-action primary w-100 justify-content-center">
                    <i class="bi bi-award-fill"></i> Unduh Sertifikat
                </a>
                <?php else: ?>
                <button class="btn-action primary w-100 justify-content-center" disabled style="opacity:0.6">
                    <i class="bi bi-award-fill"></i> Sertifikat Belum Tersedia
                </button>
                <?php endif; ?>
                <?php if ($jenis_permohonan == 3): ?>
                <a href="<?= base_url('mahasiswa/logbook') ?>" class="btn-action outline w-100 justify-content-center">
                    <i class="bi bi-journal-check"></i> Lihat Riwayat Logbook
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>

<?= $this->endSection() ?>