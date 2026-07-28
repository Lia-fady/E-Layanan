<?= $this->extend('layout/L_master'); ?>

<?= $this->section('content'); ?>
<style>
    .detail-header {
        background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
        border-radius: 16px;
        color: #fff;
        padding: 22px 28px;
        margin-bottom: 24px;
        box-shadow: 0 4px 18px rgba(74,144,226,0.22);
    }
    .info-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e8eef7;
        box-shadow: 0 2px 10px rgba(74,144,226,0.06);
        overflow: hidden;
    }
    .info-card .ic-header {
        padding: 16px 20px;
        border-bottom: 1px solid #f0f4fb;
        display: flex;
        align-items: center;
        gap: 10px;
        background: #f8faff;
    }
    .info-card .ic-header .icon-wrap {
        width: 36px; height: 36px;
        border-radius: 10px;
        background: linear-gradient(135deg,#4a90e2,#6fb1f7);
        color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px; flex-shrink: 0;
    }
    .info-card .ic-body { padding: 20px; }
    .field-row { display: flex; align-items: flex-start; padding: 10px 0; border-bottom: 1px solid #f5f7fb; }
    .field-row:last-child { border-bottom: none; }
    .field-label { color: #8898aa; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: .4px; width: 140px; flex-shrink: 0; padding-top: 2px; }
    .field-value { color: #2d3748; font-size: 14px; font-weight: 500; flex: 1; }
    .status-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 14px; border-radius: 999px; font-size: 13px; font-weight: 600;
    }
    .keputusan-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e8eef7;
        box-shadow: 0 2px 10px rgba(74,144,226,0.06);
        padding: 24px;
        margin-bottom: 24px;
    }
    .btn-setujui {
        background: linear-gradient(135deg, #28a745, #20c374);
        color: #fff; border: none; border-radius: 999px;
        padding: 11px 28px; font-size: 14px; font-weight: 600;
        transition: opacity 0.2s; box-shadow: 0 4px 14px rgba(40,167,69,0.25);
    }
    .btn-setujui:hover { opacity: 0.88; color:#fff; }
    .btn-batal {
        background: #f1f4f9; color: #4a90e2; border: none;
        border-radius: 999px; padding: 11px 28px; font-size: 14px; font-weight: 600;
        transition: background 0.2s;
    }
    .btn-batal:hover { background: #e2ebf9; color: #357abd; }
    .timeline-dot {
        width: 10px; height: 10px; border-radius: 50%;
        background: #4a90e2; flex-shrink: 0; margin-top: 5px;
    }
</style>

<div class="container-fluid">

    <!-- Header -->
    <div class="detail-header d-flex align-items-center justify-content-between flex-wrap">
        <div>
            <a href="<?= base_url('sekretariat/c_kabid/persetujuan') ?>" class="text-white mb-2 d-inline-flex align-items-center" style="font-size:13px; opacity:.85; text-decoration:none;">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
            </a>
            <h4 class="font-weight-bold mb-1">Detail Persetujuan Penempatan</h4>
            <p class="mb-0" style="opacity:.85; font-size:13px;">Tinjau data mahasiswa dan berikan keputusan penempatan.</p>
        </div>
        <?php
            $statusNow = strtolower($detail['status_persetujuan'] ?? 'menunggu');
            if ($statusNow === 'disetujui') {
                $sbg = '#e6f9ed'; $stc = '#1a7a41'; $si = 'check-circle'; $sl = 'Disetujui';
            } elseif ($statusNow === 'ditolak') {
                $sbg = '#fdecea'; $stc = '#b71c1c'; $si = 'times-circle'; $sl = 'Ditolak';
            } else {
                $sbg = '#fff8e1'; $stc = '#b7900a'; $si = 'clock'; $sl = 'Menunggu';
            }
        ?>
        <div class="mt-3 mt-md-0">
            <span class="status-badge" style="background:<?= $sbg ?>; color:<?= $stc ?>;">
                <i class="fas fa-<?= $si ?>"></i> <?= $sl ?>
            </span>
        </div>
    </div>

    <div class="row">
        <!-- Left: Info Mahasiswa -->
        <div class="col-lg-6 mb-4">
            <div class="info-card h-100">
                <div class="ic-header">
                    <div class="icon-wrap"><i class="fas fa-user-graduate"></i></div>
                    <div>
                        <div class="font-weight-bold text-dark" style="font-size:15px;">Data Mahasiswa</div>
                        <div class="text-muted" style="font-size:12px;">Informasi pemohon magang</div>
                    </div>
                </div>
                <div class="ic-body">
                    <div class="field-row">
                        <span class="field-label">Nama</span>
                        <span class="field-value font-weight-bold"><?= esc($detail['nama_mahasiswa'] ?? '-') ?></span>
                    </div>
                    <div class="field-row">
                        <span class="field-label">Universitas</span>
                        <span class="field-value"><?= esc($detail['universitas'] ?? '-') ?></span>
                    </div>
                    <div class="field-row">
                        <span class="field-label">Jenis</span>
                        <span class="field-value"><?= esc($detail['jenis_permohonan'] ?? '-') ?></span>
                    </div>
                    <div class="field-row">
                        <span class="field-label">Tgl Pengajuan</span>
                        <span class="field-value"><?= $detail['tgl_pengajuan'] ? esc(date('d M Y', strtotime($detail['tgl_pengajuan']))) : '-' ?></span>
                    </div>
                    <div class="field-row">
                        <span class="field-label">Mulai Magang</span>
                        <span class="field-value"><?= $detail['tgl_mulai'] ? esc(date('d M Y', strtotime($detail['tgl_mulai']))) : '-' ?></span>
                    </div>
                    <div class="field-row">
                        <span class="field-label">Selesai Magang</span>
                        <span class="field-value"><?= $detail['tgl_selesai'] ? esc(date('d M Y', strtotime($detail['tgl_selesai']))) : '-' ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Info Penempatan -->
        <div class="col-lg-6 mb-4">
            <div class="info-card h-100">
                <div class="ic-header">
                    <div class="icon-wrap"><i class="fas fa-map-marker-alt"></i></div>
                    <div>
                        <div class="font-weight-bold text-dark" style="font-size:15px;">Data Penempatan</div>
                        <div class="text-muted" style="font-size:12px;">Penempatan yang diusulkan Sekretariat</div>
                    </div>
                </div>
                <div class="ic-body">
                    <div class="field-row">
                        <span class="field-label">OPD</span>
                        <span class="field-value">Dinas Komunikasi dan Informatika</span>
                    </div>
                    <div class="field-row">
                        <span class="field-label">Bidang</span>
                        <span class="field-value font-weight-bold"><?= esc($detail['nama_bidang'] ?? '-') ?></span>
                    </div>
                    <div class="field-row">
                        <span class="field-label">Tgl Persetujuan</span>
                        <span class="field-value"><?= $detail['tgl_disposisi'] ? esc(date('d M Y', strtotime($detail['tgl_disposisi']))) : '<span class="text-muted font-italic" style="font-size:13px;">Belum ditentukan</span>' ?></span>
                    </div>
                    <div class="field-row">
                        <span class="field-label">Catatan Sekretariat</span>
                        <span class="field-value"><?= !empty($detail['catatan_sekretariat']) ? esc($detail['catatan_sekretariat']) : '<span class="text-muted font-italic" style="font-size:13px;">-</span>' ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Keputusan -->
    <div class="keputusan-card">
        <form method="post" action="<?= base_url('sekretariat/c_kabid/simpan_persetujuan') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="id_persetujuan" value="<?= esc($detail['id_persetujuan_magang'] ?? $detail['id_persetujuan'] ?? '') ?>">

            <div class="d-flex align-items-center mb-4">
                <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#4a90e2,#6fb1f7);color:#fff;display:flex;align-items:center;justify-content:center;font-size:16px;margin-right:12px;">
                    <i class="fas fa-stamp"></i>
                </div>
                <div>
                    <div class="font-weight-bold text-dark" style="font-size:15px;">Keputusan Kepala Bidang</div>
                    <div class="text-muted" style="font-size:12px;">Berikan keputusan dan catatan jika diperlukan</div>
                </div>
            </div>

            <div class="form-group mb-4">
                <label class="font-weight-bold text-dark mb-2" style="font-size:13px;">
                    <i class="fas fa-comment-alt mr-1 text-primary"></i> Catatan (opsional)
                </label>
                <textarea name="catatan" class="form-control" rows="4"
                    placeholder="Tulis catatan atau instruksi untuk mahasiswa..."
                    style="border-radius:10px; font-size:13px; border-color:#e0e8f5; resize:none;"></textarea>
            </div>

            <div class="d-flex flex-column flex-sm-row justify-content-end" style="gap: 0.75rem;">
                <a href="<?= base_url('sekretariat/c_kabid/persetujuan') ?>" class="btn-batal d-inline-flex align-items-center justify-content-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
                <button type="submit" name="status" value="Disetujui" class="btn-setujui d-inline-flex align-items-center justify-content-center">
                    <i class="fas fa-check-circle mr-2"></i> Setujui Penempatan
                </button>
            </div>
        </form>
    </div>

</div>
<?= $this->endSection(); ?>