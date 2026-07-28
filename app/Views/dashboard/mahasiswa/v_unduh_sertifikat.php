<?= $this->extend('layout/mahasiswa') ?>

<?= $this->section('breadcrumb') ?>
E-Kinerja Magang &raquo; <strong>Sertifikat & Kelulusan</strong>
<?= $this->endSection() ?>

<?= $this->section('extra_css') ?>
<style>
    .card-flat {
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.03);
        border-radius: 12px;
        padding: 24px;
    }
    .document-hero {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 18px;
        padding: 26px 30px;
        color: #fff;
        background: linear-gradient(118deg, #102a43 0%, #1769aa 70%, #2f8fca 100%);
        border-radius: 14px;
        box-shadow: 0 14px 30px rgba(16,42,67,0.16);
    }
    .document-hero::after {
        content: '';
        position: absolute;
        right: -42px;
        top: -70px;
        width: 190px;
        height: 190px;
        border: 1px solid rgba(255,255,255,0.18);
        border-radius: 50%;
    }
    .document-hero-icon {
        position: relative;
        z-index: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 52px;
        height: 52px;
        margin-bottom: 12px;
        color: #bfe7f7;
        background: rgba(255,255,255,0.13);
        border: 1px solid rgba(255,255,255,0.18);
        border-radius: 12px;
        font-size: 1.5rem;
    }
    .document-hero h4 { position: relative; z-index: 1; color: #fff !important; font-weight: 800; }
    .document-hero p { position: relative; z-index: 1; max-width: 590px; margin: 5px 0 0; color: rgba(255,255,255,0.68); font-size: 0.84rem; }
    .document-hero-count { position: relative; z-index: 1; min-width: 130px; padding: 14px 18px; text-align: center; background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.18); border-radius: 11px; }
    .document-hero-count strong { display: block; font-size: 1.75rem; line-height: 1; }
    .document-hero-count span { display: block; margin-top: 5px; color: rgba(255,255,255,0.68); font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.65px; }
    .document-overview { display: grid; grid-template-columns: repeat(3, minmax(0,1fr)); gap: 12px; margin-bottom: 20px; }
    .document-overview-item { padding: 15px 17px; background: #fff; border: 1px solid #dce5ec; border-radius: 10px; box-shadow: 0 7px 18px rgba(16,42,67,0.045); }
    .document-overview-item i { color: #1769aa; font-size: 1.1rem; }
    .document-overview-item strong { display: block; margin-top: 9px; color: #172b3a; font-size: 0.88rem; }
    .document-overview-item span { color: #718492; font-size: 0.74rem; }
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    .status-badge.available { background-color: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
    .status-badge.waiting { background-color: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }
    
    .btn-download {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 18px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #fff;
        background-color: var(--primary-royal);
        border: none;
        transition: all 0.2s;
    }
    .btn-download:hover { background-color: #274b8c; color: #fff; transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    .btn-download.disabled { background-color: #cbd5e1; cursor: not-allowed; transform: none; box-shadow: none; color: #f8fafc; }
    
    .doc-icon {
        width: 44px; height: 44px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem;
        margin-right: 12px;
    }
    .document-table-card .table tbody tr { transition: background 0.2s ease; }
    .document-table-card .table tbody tr:hover { background: #f7fbfd; }
    .document-table-card .table td, .document-table-card .table th { border-color: #e8eff3; }
    @media (max-width: 767.98px) {
        .document-hero { align-items: flex-start; flex-direction: column; padding: 23px; }
        .document-hero-count { width: 100%; text-align: left; }
        .document-hero-count strong, .document-hero-count span { display: inline; }
        .document-hero-count span { margin-left: 7px; }
        .document-overview { grid-template-columns: 1fr; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
E-Kinerja Magang &raquo; <span class="text-uppercase" style="color: var(--primary-royal);">Unduh Dokumen</span>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <?php $availableDocuments = (!empty($file_penerimaan) ? 1 : 0) + (!empty($file_selesai) ? 1 : 0) + (!empty($file_piagam) ? 1 : 0); ?>
    <div class="document-hero">
        <div>
            <span class="document-hero-icon"><i class="bi bi-folder2-open"></i></span>
            <h4 class="m-0">Pusat Dokumen Akademik</h4>
            <p>Tempat terpusat untuk mengakses surat dan sertifikat resmi yang diterbitkan selama proses kegiatan Anda.</p>
        </div>
        <div class="document-hero-count">
            <strong><?= $availableDocuments ?></strong>
            <span>dokumen tersedia</span>
        </div>
    </div>
</div>

<div class="document-overview">
    <div class="document-overview-item"><i class="bi bi-envelope-paper-fill"></i><strong>Surat Penerimaan</strong><span>Diterbitkan Sekretariat atau Bidang</span></div>
    <div class="document-overview-item"><i class="bi bi-file-earmark-check-fill"></i><strong>Surat Selesai</strong><span>Bukti penyelesaian kegiatan akademik</span></div>
    <div class="document-overview-item"><i class="bi bi-award-fill"></i><strong>Sertifikat</strong><span>Dokumen kelulusan dari Bidang</span></div>
</div>

<div class="card-flat shadow-sm document-table-card">
    <!-- CONTROLS ROW -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-3 border-bottom">
        <!-- KIRI: Ringkasan daftar dokumen -->
        <div class="d-flex align-items-center gap-2 mb-2 mb-md-0">
            <span class="small text-muted fw-semibold"><i class="bi bi-list-ul me-1"></i>Daftar dokumen</span>
            <span class="badge rounded-pill text-bg-light border"><?= $availableDocuments ?> tersedia</span>
        </div>

        <div class="small text-muted"><i class="bi bi-info-circle me-1"></i>Dokumen diterbitkan sesuai tahapan kegiatan</div>
    </div>

    <div class="table-shell table-responsive">
        <table class="table table-hover align-middle m-0" style="table-layout: fixed; width: 100%;">
            <colgroup>
                <col style="width: 35%;">
                <col style="width: 20%;">
                <col style="width: 15%;">
                <col style="width: 15%;">
                <col style="width: 15%;">
            </colgroup>
            <thead class="table-light">
                <tr class="text-muted small text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.4px;">
                    <th class="py-3 ps-4">Nama Dokumen</th>
                    <th class="py-3">Diunggah Oleh</th>
                    <th class="py-3">Tanggal</th>
                    <th class="py-3">Status Terkini</th>
                    <th class="py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($file_penerimaan) && empty($file_selesai) && empty($file_piagam)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 250px;">
                                <div class="position-relative mb-3">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                        <i class="bi bi-folder-x text-secondary opacity-50" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <div class="position-absolute bottom-0 end-0 bg-danger text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 24px; height: 24px; font-size: 0.75rem;">
                                        <i class="bi bi-exclamation-lg fw-bold"></i>
                                    </div>
                                </div>
                                <h6 class="fw-bold text-dark mb-1">Belum Ada Dokumen</h6>
                                <p class="text-muted small mb-0" style="max-width: 350px;">
                                    Belum ada dokumen yang diunggah oleh Sekretariat atau Bidang ke akun Anda.
                                </p>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php if(!empty($file_penerimaan)): ?>
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="doc-icon bg-primary bg-opacity-10 text-primary"><i class="bi bi-envelope-paper-fill"></i></div>
                                <div>
                                    <span class="d-block fw-bold text-dark" style="font-size: 0.92rem;">Surat Penerimaan</span>
                                    <small class="text-muted" style="font-size: 0.8rem;">Bukti penerimaan resmi dari dinas.</small>
                                </div>
                            </div>
                        </td>
                        <td class="py-3"><span class="text-dark fw-medium" style="font-size: 0.85rem;"><?= esc($file_penerimaan['pengunggah'] ?? 'Sekretariat') ?></span></td>
                        <td class="py-3 text-muted fw-medium" style="font-size: 0.85rem;"><?= isset($file_penerimaan['created_at']) ? date('d M Y', strtotime($file_penerimaan['created_at'])) : date('d M Y') ?></td>
                        <td class="py-3">
                            <div class="status-badge available"><i class="bi bi-check-circle-fill"></i> Tersedia</div>
                        </td>
                        <td class="py-3 text-center">
                            <a href="<?= base_url($file_penerimaan['path_file']) ?>" download target="_blank" class="btn-download text-decoration-none w-100">
                                <i class="bi bi-download"></i> Unduh
                            </a>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <?php if(!empty($file_selesai)): ?>
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="doc-icon bg-success bg-opacity-10 text-success"><i class="bi bi-file-earmark-check-fill"></i></div>
                                <div>
                                    <span class="d-block fw-bold text-dark" style="font-size: 0.92rem;">Surat Selesai Kegiatan</span>
                                    <small class="text-muted" style="font-size: 0.8rem;">Pernyataan telah menyelesaikan kegiatan.</small>
                                </div>
                            </div>
                        </td>
                        <td class="py-3"><span class="text-dark fw-medium" style="font-size: 0.85rem;"><?= esc($file_selesai['pengunggah'] ?? 'Bidang') ?></span></td>
                        <td class="py-3 text-muted fw-medium" style="font-size: 0.85rem;"><?= isset($file_selesai['created_at']) ? date('d M Y', strtotime($file_selesai['created_at'])) : date('d M Y') ?></td>
                        <td class="py-3">
                            <div class="status-badge available"><i class="bi bi-check-circle-fill"></i> Tersedia</div>
                        </td>
                        <td class="py-3 text-center">
                            <a href="<?= base_url($file_selesai['path_file']) ?>" download target="_blank" class="btn-download text-decoration-none w-100" style="background-color: #10b981;">
                                <i class="bi bi-download"></i> Unduh
                            </a>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <?php if(!empty($file_piagam)): ?>
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="doc-icon bg-warning bg-opacity-10 text-warning"><i class="bi bi-award-fill"></i></div>
                                <div>
                                    <span class="d-block fw-bold text-dark" style="font-size: 0.92rem;">Sertifikat Piagam Kelulusan</span>
                                    <small class="text-muted" style="font-size: 0.8rem;">Sertifikat resmi nilai dan kelulusan.</small>
                                </div>
                            </div>
                        </td>
                        <td class="py-3"><span class="text-dark fw-medium" style="font-size: 0.85rem;"><?= esc($file_piagam['pengunggah'] ?? 'Bidang') ?></span></td>
                        <td class="py-3 text-muted fw-medium" style="font-size: 0.85rem;"><?= isset($file_piagam['created_at']) ? date('d M Y', strtotime($file_piagam['created_at'])) : date('d M Y') ?></td>
                        <td class="py-3">
                            <div class="status-badge available"><i class="bi bi-check-circle-fill"></i> Tersedia</div>
                        </td>
                        <td class="py-3 text-center">
                            <a href="<?= base_url($file_piagam['path_file']) ?>" download target="_blank" class="btn-download text-decoration-none w-100" style="background-color: #f59e0b;">
                                <i class="bi bi-download"></i> Unduh
                            </a>
                        </td>
                    </tr>
                    <?php endif; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</div>
<?= $this->endSection() ?>