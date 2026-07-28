<?= $this->extend('layout/L_master'); ?>

<?= $this->section('content'); ?>
<style>
    .perm-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e8eef7;
        box-shadow: 0 2px 12px rgba(74,144,226,0.06);
        transition: box-shadow 0.2s, transform 0.2s;
        overflow: hidden;
    }
    .perm-card:hover {
        box-shadow: 0 8px 28px rgba(74,144,226,0.14);
        transform: translateY(-2px);
    }
    .perm-card .card-header-bar {
        height: 5px;
    }
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 13px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
    }
    .badge-menunggu  { background: #fff8e1; color: #b7900a; }
    .badge-disetujui { background: #e6f9ed; color: #1a7a41; }
    .badge-ditolak   { background: #fdecea; color: #b71c1c; }
    .avatar-circle {
        width: 46px; height: 46px;
        border-radius: 50%;
        background: linear-gradient(135deg,#4a90e2,#6fb1f7);
        color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px; font-weight: 700;
        flex-shrink: 0;
    }
    .info-row { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #6c757d; }
    .info-row i { width: 16px; color: #4a90e2; }
    .btn-detail {
        background: linear-gradient(135deg,#4a90e2,#6fb1f7);
        color: #fff;
        border: none;
        border-radius: 999px;
        padding: 7px 20px;
        font-size: 12px;
        font-weight: 600;
        transition: opacity 0.2s;
    }
    .btn-detail:hover { opacity: 0.85; color: #fff; }
    .page-header-card {
        background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
        border-radius: 16px;
        color: #fff;
        padding: 24px 28px;
        margin-bottom: 24px;
        box-shadow: 0 4px 18px rgba(74,144,226,0.22);
    }
    .stat-pill {
        background: rgba(255,255,255,0.2);
        border-radius: 999px;
        padding: 6px 18px;
        font-size: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }
</style>

<div class="container-fluid">

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert border-0 mb-3" style="background:#e6f9ed; color:#1a7a41; border-radius:12px; padding:14px 20px;">
            <i class="fas fa-check-circle mr-2"></i><?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert border-0 mb-3" style="background:#fdecea; color:#b71c1c; border-radius:12px; padding:14px 20px;">
            <i class="fas fa-exclamation-circle mr-2"></i><?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="page-header-card d-flex flex-column flex-md-row justify-content-between align-items-md-center">
        <div>
            <h4 class="font-weight-bold mb-1" style="letter-spacing:.5px;">Penempatan Bidang</h4>
            <p class="mb-0" style="opacity:.85; font-size:14px;">Tinjau dan kelola penempatan magang mahasiswa pada bidang Anda.</p>
        </div>
        <div class="mt-3 mt-md-0">
            <span class="stat-pill">
                <i class="fas fa-users"></i>
                <?= !empty($permohonan) ? count($permohonan) : '0' ?> Permohonan
            </span>
        </div>
    </div>

    <!-- Content -->
    <?php if (empty($permohonan)): ?>
        <div class="text-center py-5">
            <div style="font-size: 80px; color: #e8f0fe; margin-bottom: 1.5rem;">
                <i class="fas fa-clipboard-list" style="color: #4a90e2; opacity: 0.8;"></i>
            </div>
            <h5 class="font-weight-bold" style="color: #1c2d4a;">Belum Ada Permohonan Masuk</h5>
            <p class="text-muted mb-4" style="font-size:14px;">Saat ini tidak ada permohonan penempatan magang yang perlu ditinjau.</p>
            <a href="<?= base_url('sekretariat/c_kabid') ?>" class="btn-detail" style="text-decoration: none;">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Dashboard
            </a>
        </div>
    <?php else: ?>
        <div class="row">
            <?php $no = 1; foreach ($permohonan as $item): ?>
            <?php
                $status = strtolower($item['status_persetujuan'] ?? 'menunggu');
                if ($status === 'disetujui') {
                    $badgeClass = 'badge-disetujui';
                    $statusIcon = 'check-circle';
                    $barColor   = '#28a745';
                } elseif ($status === 'ditolak') {
                    $badgeClass = 'badge-ditolak';
                    $statusIcon = 'times-circle';
                    $barColor   = '#dc3545';
                } else {
                    $badgeClass = 'badge-menunggu';
                    $statusIcon = 'clock';
                    $barColor   = '#ffc107';
                }
                $initial = strtoupper(substr($item['nama_mahasiswa'] ?? 'M', 0, 1));
            ?>
            <div class="col-md-6 col-xl-4 mb-4">
                <div class="perm-card h-100">
                    <div class="card-header-bar" style="background: <?= $barColor ?>;"></div>
                    <div class="p-4">
                        <!-- Top: Avatar + Name + Status -->
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar-circle mr-3"><?= $initial ?></div>
                            <div class="flex-grow-1 min-width-0">
                                <div class="font-weight-bold text-dark" style="font-size:15px; line-height:1.3; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                    <?= esc($item['nama_mahasiswa'] ?? '-') ?>
                                </div>
                                <div class="text-muted" style="font-size:12px;"><?= esc($item['universitas'] ?? '-') ?></div>
                            </div>
                            <span class="badge-status <?= $badgeClass ?> ml-2">
                                <i class="fas fa-<?= $statusIcon ?>"></i>
                                <?= ucfirst($status) ?>
                            </span>
                        </div>

                        <hr style="border-color:#f0f3f8; margin: 12px 0;">

                        <!-- Info rows -->
                        <div class="d-flex flex-column" style="gap:7px;">
                            <div class="info-row">
                                <i class="fas fa-tag"></i>
                                <span><?= esc($item['jenis_permohonan'] ?? '-') ?></span>
                            </div>
                            <div class="info-row">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Diajukan: <?= $item['tgl_pengajuan'] ? esc(date('d M Y', strtotime($item['tgl_pengajuan']))) : '-' ?></span>
                            </div>
                            <?php if (!empty($item['tgl_mulai']) && !empty($item['tgl_selesai'])): ?>
                            <div class="info-row">
                                <i class="fas fa-hourglass-half"></i>
                                <span><?= esc(date('d M Y', strtotime($item['tgl_mulai']))) ?> &rarr; <?= esc(date('d M Y', strtotime($item['tgl_selesai']))) ?></span>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Action -->
                        <div class="mt-4 d-flex justify-content-between align-items-center">
                            <span class="text-muted font-weight-bold" style="font-size:12px;">#<?= $no++ ?></span>
                            <a href="<?= base_url('sekretariat/c_kabid/detail_disposisi/' . ($item['id_persetujuan_magang'] ?? $item['id_persetujuan'] ?? '')) ?>" class="btn-detail">
                                <i class="fas fa-arrow-right mr-1"></i> Tinjau & Putuskan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
<?= $this->endSection(); ?>