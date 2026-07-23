<?= $this->extend('layout/mahasiswa') ?>

<?= $this->section('breadcrumb') ?>
E-Kinerja Magang &raquo; <strong>Sertifikat & Kelulusan</strong>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4 pt-4">
    <div class="mb-4">
        <h4 class="fw-bold text-dark mb-1">Sertifikat Kelulusan Magang</h4>
        <p class="text-muted">Unduh Surat Penerimaan dan Sertifikat resmi penyelesaian kegiatan akademik di Dinas Kominfo Kota Tangerang.</p>
    </div>

    <?php if (!empty($penempatan)): ?>
        <div class="row g-4">
            <!-- KARTU SURAT PENERIMAAN -->
            <div class="col-12 col-lg-6">
                <div class="card border shadow-sm h-100">
                    <div class="card-body text-center p-5 d-flex flex-column align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-envelope-paper-fill text-primary fs-1"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Surat Penerimaan Magang</h5>
                        <p class="text-muted small mb-4">
                            Dokumen resmi penerimaan dan penempatan Anda di Bidang <strong><?= esc($penempatan['bidang']) ?></strong>.
                        </p>
                        
                        <div class="mt-auto w-100">
                            <?php if(!empty($file_penerimaan)): ?>
                                <a href="<?= base_url($file_penerimaan['path_file']) ?>" download target="_blank" class="btn btn-primary w-100">
                                    <i class="bi bi-download me-2"></i> Unduh Dokumen
                                </a>
                            <?php else: ?>
                                <button class="btn btn-outline-secondary w-100" disabled>
                                    <i class="bi bi-clock-history me-2"></i> Belum Diunggah
                                </button>
                                <small class="text-muted d-block mt-2">Kepala Bidang belum mengunggah dokumen penerimaan.</small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KARTU SERTIFIKAT SELESAI -->
            <div class="col-12 col-lg-6">
                <div class="card border shadow-sm h-100">
                    <div class="card-body text-center p-5 d-flex flex-column align-items-center">
                        <?php if($penempatan['status_penempatan'] == 'SELESAI'): ?>
                            <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="bi bi-award-fill text-success fs-1"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">Sertifikat Kelulusan</h5>
                            <p class="text-muted small mb-4">
                                Dokumen bukti kelulusan program magang di Dinas Kominfo Kota Tangerang.
                            </p>
                            
                            <div class="mt-auto w-100">
                                <?php if(!empty($file_selesai)): ?>
                                    <a href="<?= base_url($file_selesai['path_file']) ?>" download target="_blank" class="btn btn-outline-success w-100 mb-2">
                                        <i class="bi bi-file-text me-2"></i> Surat Selesai Magang
                                    </a>
                                <?php endif; ?>
                                
                                <?php if(!empty($file_piagam)): ?>
                                    <a href="<?= base_url($file_piagam['path_file']) ?>" download target="_blank" class="btn btn-success w-100">
                                        <i class="bi bi-award me-2"></i> Unduh Sertifikat Magang
                                    </a>
                                <?php endif; ?>
                                
                                <?php if(empty($file_selesai) && empty($file_piagam)): ?>
                                    <button class="btn btn-outline-secondary w-100" disabled>
                                        <i class="bi bi-hourglass-split me-2"></i> Proses Cetak
                                    </button>
                                    <small class="text-muted d-block mt-2">Sertifikat dan Surat Selesai sedang disiapkan oleh Kepala Bidang.</small>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="bi bi-lock-fill text-warning fs-1"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">Sertifikat Terkunci</h5>
                            <p class="text-muted small mb-4">
                                Sertifikat baru dapat diunduh jika status magang Anda telah dinyatakan Selesai.
                            </p>
                            
                            <div class="mt-auto w-100">
                                <button class="btn btn-light border w-100 text-muted" disabled>
                                    <i class="bi bi-info-circle me-2"></i> Magang Masih Berjalan
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="card border shadow-sm">
            <div class="card-body text-center p-5">
                <i class="bi bi-folder-x text-muted mb-3" style="font-size: 3rem;"></i>
                <h5 class="text-dark">Data Tidak Ditemukan</h5>
                <p class="text-muted mb-0">Anda belum memiliki data penempatan magang aktif.</p>
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>