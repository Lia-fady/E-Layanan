<?= $this->extend('layout/mahasiswa') ?>

<?= $this->section('extra_css') ?>
<style>
    .card-flat {
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.03);
        border-radius: 12px;
        padding: 24px;
    }

    /* --- CUSTOM OVERRIDE PAGINATION CI4 AGAR RAPI SEPERTI GAMBAR --- */
    .custom-pagination ul {
        display: flex;
        padding-left: 0;
        list-style: none;
        margin: 0;
        gap: 6px;
    }
    .custom-pagination li a, .custom-pagination li span {
        position: relative;
        display: block;
        padding: 6px 14px;
        font-size: 0.88rem;
        font-weight: 600;
        color: var(--primary-royal);
        text-decoration: none;
        background-color: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px !important;
        transition: all 0.2s ease;
    }
    .custom-pagination li.active span, .custom-pagination li.active a {
        z-index: 3;
        color: #fff !important;
        background-color: var(--primary-royal) !important;
        border-color: var(--primary-royal) !important;
    }
    .custom-pagination li a:hover {
        background-color: #f3f4f6;
        border-color: #d1d5db;
    }
    .status-hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 24px 28px;
        margin-bottom: 16px;
        color: #fff;
        background: linear-gradient(115deg, #102a43, #1769aa);
        border-radius: 13px;
        box-shadow: 0 13px 28px rgba(16,42,67,0.14);
    }
    .status-hero h4 { color: #fff !important; font-weight: 800; }
    .status-hero p { max-width: 640px; margin: 5px 0 0; color: rgba(255,255,255,0.67); font-size: 0.82rem; }
    .status-hero-mark { display: inline-flex; align-items: center; justify-content: center; width: 45px; height: 45px; margin-bottom: 11px; border-radius: 11px; color: #bfe7f7; background: rgba(255,255,255,0.13); font-size: 1.25rem; }
    .status-count { min-width: 110px; padding: 12px 16px; text-align: center; background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.18); border-radius: 10px; }
    .status-count strong { display: block; font-size: 1.5rem; line-height: 1; }
    .status-count span { color: rgba(255,255,255,0.68); font-size: 0.68rem; font-weight: 700; text-transform: uppercase; }
    .status-filter-bar { padding: 15px 17px; background: #f7fbfd; border: 1px solid #e1ebf0; border-radius: 10px; }
    @media (max-width: 575.98px) { .status-hero { align-items: flex-start; flex-direction: column; padding: 22px; } .status-count { width: 100%; text-align: left; } .status-count strong, .status-count span { display: inline; } .status-count span { margin-left: 6px; } }

    /* --- VERTICAL TIMELINE --- */
    .v-timeline {
        position: relative;
        padding-left: 20px;
        margin: 10px 0;
    }
    .v-timeline::before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 5px;
        width: 2px;
        background: #e2e8f0;
    }
    .v-timeline-item {
        position: relative;
        margin-bottom: 20px;
        padding-left: 20px;
    }
    .v-timeline-item:last-child {
        margin-bottom: 0;
    }
    .v-timeline-icon {
        position: absolute;
        top: 0;
        left: -21px;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid #cbd5e1;
        box-shadow: 0 0 0 4px #fff;
    }
    .v-timeline-item.success .v-timeline-icon { border-color: #10b981; background: #10b981; }
    .v-timeline-item.warning .v-timeline-icon { border-color: #f59e0b; background: #f59e0b; }
    .v-timeline-item.danger .v-timeline-icon { border-color: #ef4444; background: #ef4444; }
    .v-timeline-item.primary .v-timeline-icon { border-color: #3b82f6; background: #3b82f6; }
    .v-timeline-date {
        font-size: 0.75rem;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 4px;
        display: block;
    }
    .v-timeline-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 6px;
    }
    .v-timeline-content {
        font-size: 0.85rem;
        color: #475569;
        line-height: 1.5;
        background: #f8fafc;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }
    .file-card-modern {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px;
        display: flex;
        align-items: center;
        transition: all 0.2s;
    }
    .file-card-modern:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }
    .file-icon-box {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-right: 12px;
        background: #f1f5f9;
        color: #64748b;
    }
    .file-icon-box.pdf { background: #fee2e2; color: #ef4444; }
    .file-icon-box.doc { background: #e0f2fe; color: #0ea5e9; }
</style>
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
E-Kinerja Magang &raquo; <span class="text-uppercase" style="color: var(--primary-royal);">Tracking Status</span>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
        
        <?php
            $totalPermohonan = count($permohonan ?? []);
            $totalSelesai = 0;
            foreach (($permohonan ?? []) as $statusItem) {
                if (!empty($statusItem['status_penempatan']) && $statusItem['status_penempatan'] !== 'MENUNGGU') $totalSelesai++;
            }
        ?>
        <div class="status-hero">
            <div>
                <span class="status-hero-mark"><i class="bi bi-diagram-3"></i></span>
                <h4 class="m-0">Tracking Permohonan</h4>
                <p>Pantau perjalanan dokumen Anda dari pengajuan, verifikasi, hingga keputusan penempatan.</p>
            </div>
            <div class="status-count"><strong><?= $totalPermohonan ?></strong><span>ditampilkan</span></div>
        </div>

        <!-- Alert Flashdata Feedback Notifikasi -->
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success py-2.5 small mb-3" role="alert">
                <i class="bi bi-check-circle-fill me-1"></i> <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger py-2.5 small mb-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-1"></i> <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- DATA DATA RIWAYAT TABLE -->
        <div class="card-flat shadow-sm">
            
            <!-- CONTROLS ROW -->
            <form method="GET" action="<?= base_url('mahasiswa/status') ?>" class="d-flex flex-wrap justify-content-between align-items-center mb-3 status-filter-bar">
                
                <!-- KIRI: Show Data Dropdown -->
                <div class="d-flex align-items-center gap-2 mb-2 mb-md-0">
                    <span class="small text-muted fw-medium">Show</span>
                    <select name="per_page" class="form-select form-select-sm shadow-none border-secondary-subtle" style="width: 70px;" onchange="this.form.submit()">
                        <option value="10" <?= (request()->getGet('per_page') == '10' || empty(request()->getGet('per_page'))) ? 'selected' : '' ?>>10</option>
                        <option value="25" <?= (request()->getGet('per_page') == '25') ? 'selected' : '' ?>>25</option>
                        <option value="50" <?= (request()->getGet('per_page') == '50') ? 'selected' : '' ?>>50</option>
                    </select>
                    <span class="small text-muted fw-medium">data</span>
                </div>

                <!-- KANAN: Filter Dropdowns -->
                <div class="d-flex flex-wrap gap-2">
                    <select name="filter_jenis" class="form-select form-select-sm fw-semibold text-secondary shadow-none" style="width: 170px;" onchange="this.form.submit()">
                        <option value="">-- Semua Jenis --</option>
                        <option value="1" <?= (request()->getGet('filter_jenis') == '1') ? 'selected' : '' ?>>Penelitian / Skripsi</option>
                        <option value="2" <?= (request()->getGet('filter_jenis') == '2') ? 'selected' : '' ?>>Observasi / Ambil Data</option>
                        <option value="3" <?= (request()->getGet('filter_jenis') == '3') ? 'selected' : '' ?>>Magang / PKL</option>
                        <option value="4" <?= (request()->getGet('filter_jenis') == '4') ? 'selected' : '' ?>>Uji Coba Produk</option>
                    </select>
                    <select name="filter_status" class="form-select form-select-sm fw-semibold text-secondary shadow-none" style="width: 170px;" onchange="this.form.submit()">
                        <option value="">-- Semua Status --</option>
                        <option value="MENUNGGU" <?= (request()->getGet('filter_status') == 'MENUNGGU') ? 'selected' : '' ?>>Menunggu Verifikasi</option>
                        <option value="DISETUJUI" <?= (request()->getGet('filter_status') == 'DISETUJUI') ? 'selected' : '' ?>>Disetujui</option>
                        <option value="DITOLAK" <?= (request()->getGet('filter_status') == 'DITOLAK') ? 'selected' : '' ?>>Ditolak</option>
                    </select>
                </div>
            </form>

            <div class="table-shell table-responsive">
                <table class="table table-hover align-middle m-0" style="table-layout: fixed; width: 100%;">
                    <colgroup>
                        <col style="width: 5%;">          <!-- No -->
                        <col style="width: 15%;">         <!-- Tanggal Diajukan -->
                        <col style="width: 27%;">         <!-- Jenis Permohonan -->
                        <col style="width: 23%;">         <!-- Jadwal Pelaksanaan -->
                        <col style="width: 18%;">         <!-- Status -->
                        <col style="width: 12%;">         <!-- Aksi -->
                    </colgroup>
                    <thead class="table-light">
                        <tr class="text-muted small text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.4px;">
                            <th class="py-3">No</th>
                            <th class="py-3" style="white-space: nowrap;">Tanggal Diajukan</th>
                            <th class="py-3 ps-4">Jenis Permohonan</th>
                            <th class="py-3">Jadwal Pelaksanaan</th>
                            <th class="py-3">Status Terkini</th>
                            <th class="py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($permohonan)): ?>
                            <?php $no = 1; foreach($permohonan as $p): ?>
                            <tr>
                                <td class="text-muted" style="font-size: 0.82rem;"><?= $no++ ?></td>
                                <td style="white-space: nowrap;">
                                    <span class="fw-semibold text-dark" style="font-size: 0.82rem;"><?= date('d M Y', strtotime($p['created_at'])) ?></span>
                                </td>
                                <td class="ps-4">
                                    <div class="fw-semibold text-dark" style="font-size: 0.82rem; line-height: 1.4;">
                                        <?php
                                            if($p['id_jenis_permohonan'] == 1)      echo 'Penelitian / Skripsi';
                                            elseif($p['id_jenis_permohonan'] == 2)  echo 'Observasi / Ambil Data';
                                            elseif($p['id_jenis_permohonan'] == 3)  echo 'Magang / PKL';
                                            else                                    echo 'Uji Coba Produk';
                                        ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-dark" style="font-size: 0.8rem;">
                                        <span class="d-block fw-semibold"><?= date('d M Y', strtotime($p['tgl_mulai'])) ?></span>
                                        <span class="d-block text-muted">s/d <?= date('d M Y', strtotime($p['tgl_selesai'])) ?></span>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <?php if ($p['posting_data'] == 'draft'): ?>
                                        <span class="status-pill neutral"><i class="bi bi-file-earmark"></i> Draft</span>
                                    <?php elseif ($p['status_persetujuan'] == 'DITOLAK'): ?>
                                        <span class="status-pill rejected"><i class="bi bi-x-circle"></i> Ditolak</span>
                                    <?php elseif ($p['status_persetujuan'] == 'PERBAIKAN_BERKAS'): ?>
                                        <span class="status-pill pending"><i class="bi bi-pencil-square"></i> Perlu Perbaikan</span>
                                    <?php elseif (!empty($p['status_penempatan']) && $p['status_penempatan'] != 'MENUNGGU'): ?>
                                        <span class="status-pill approved"><i class="bi bi-check-circle"></i> Disetujui</span>
                                    <?php else: ?>
                                        <span class="status-pill pending"><i class="bi bi-hourglass-split"></i> Menunggu</span>
                                    <?php endif; ?>
                                </td>
                                
                                <td class="align-middle text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <!-- ACTION BUTTON 1: DETAIL FORM OR EDIT -->
                                        <?php if ($p['posting_data'] == 'draft' || $p['status_persetujuan'] == 'PERBAIKAN_BERKAS'): ?>
                                            <a href="<?= base_url('mahasiswa/permohonan/edit/'.$p['id_permohonan_magang']) ?>" class="btn btn-sm <?= ($p['status_persetujuan'] == 'PERBAIKAN_BERKAS') ? 'btn-outline-warning' : 'btn-outline-primary' ?> p-0 shadow-sm" 
                                                    style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 8px;" 
                                                    title="<?= ($p['status_persetujuan'] == 'PERBAIKAN_BERKAS') ? 'Revisi Permohonan' : 'Edit Draft' ?>">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-sm btn-outline-secondary p-0 shadow-sm" 
                                                    style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 8px;" 
                                                    data-bs-toggle="modal" data-bs-target="#modalDetailForm<?= $p['id_permohonan_magang'] ?>"
                                                    title="Lihat Detail Form">
                                                <i class="bi bi-file-earmark-text"></i>
                                            </button>
                                        <?php endif; ?>

                                        <!-- ACTION BUTTON 2: INFO PENEMPATAN -->
                                        <?php if (!empty($p['status_penempatan']) && $p['status_penempatan'] != 'MENUNGGU'): ?>
                                            <button type="button" class="btn btn-sm btn-primary p-0 text-white shadow-sm" 
                                                    style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 8px;" 
                                                    data-bs-toggle="modal" data-bs-target="#modalInfoPenempatan<?= $p['id_permohonan_magang'] ?>"
                                                    title="Surat Info Penempatan">
                                                <i class="bi bi-building-fill"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>

                                    <!-- MODAL A: DETAIL ISI FORM PERMOHONAN -->
                                    <div class="modal fade" id="modalDetailForm<?= $p['id_permohonan_magang'] ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                            <div class="modal-content border-0 shadow" style="border-radius: 8px;">
                                                <div class="modal-header bg-white border-bottom py-3">
                                                    <h6 class="modal-title fw-bold text-dark m-0">Detail Permohonan</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-0 text-start bg-white">
                                                    
                                                    <div class="row g-0">
                                                        <!-- LEFT COLUMN: ACTIVITY LOG (TIMELINE) -->
                                                        <div class="col-lg-5 p-4 border-end" style="background-color: #fcfdfe;">
                                                            <h6 class="fw-bold mb-4 text-dark" style="font-size: 0.95rem;"><i class="bi bi-clock-history me-2 text-primary"></i>Riwayat Aktivitas</h6>
                                                            
                                                            <div class="v-timeline">
                                                                <!-- Node 1: Pengajuan -->
                                                                <div class="v-timeline-item primary">
                                                                    <div class="v-timeline-icon"></div>
                                                                    <span class="v-timeline-date"><?= date('d F Y, H:i', strtotime($p['created_at'])) ?></span>
                                                                    <div class="v-timeline-title">Permohonan Diajukan</div>
                                                                    <?php if($p['posting_data'] == 'draft'): ?>
                                                                        <div class="v-timeline-content mt-1 py-1 px-2 border-0 bg-transparent text-muted small"><i class="bi bi-info-circle me-1"></i> Disimpan sebagai draft (belum dikirim).</div>
                                                                    <?php endif; ?>
                                                                </div>

                                                                <!-- Node 2: Verifikasi Sekretariat -->
                                                                <?php if(!empty($p['status_persetujuan']) || !empty($p['catatan_sekretariat'])): ?>
                                                                    <?php
                                                                        $isReject = ($p['status_persetujuan'] == 'DITOLAK');
                                                                        $isRevise = ($p['status_persetujuan'] == 'PERBAIKAN_BERKAS');
                                                                        $isApproved = ($p['status_persetujuan'] == 'DISETUJUI');
                                                                        $isWaiting = ($p['status_persetujuan'] == 'MENUNGGU');
                                                                        
                                                                        $sekreClass = $isReject ? 'danger' : ($isRevise ? 'warning' : ($isWaiting ? 'primary' : 'success'));
                                                                        $sekreTitle = $isReject ? 'Permohonan Ditolak' : ($isRevise ? 'Perlu Perbaikan Berkas' : ($isWaiting ? 'Sedang Diverifikasi' : 'Verifikasi Selesai'));
                                                                    ?>
                                                                    <div class="v-timeline-item <?= $sekreClass ?>">
                                                                        <div class="v-timeline-icon"></div>
                                                                        <span class="v-timeline-date">Verifikasi Sekretariat</span>
                                                                        <div class="v-timeline-title"><?= $sekreTitle ?></div>
                                                                        <?php if(!empty($p['catatan_sekretariat'])): ?>
                                                                            <div class="v-timeline-content mt-2">
                                                                                <?php 
                                                                                    $catatanSekre = esc($p['catatan_sekretariat']);
                                                                                    if (strpos($catatanSekre, '[DIKEMBALIKAN KABID]') !== false) {
                                                                                        $parts = explode('[DIKEMBALIKAN KABID]', $catatanSekre);
                                                                                        echo nl2br(trim($parts[0]));
                                                                                    } else {
                                                                                        echo nl2br($catatanSekre);
                                                                                    }
                                                                                ?>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                <?php endif; ?>

                                                                <!-- Node 3: Disposisi Kabid (If any) -->
                                                                <?php if(!empty($p['status_penempatan']) && $p['status_penempatan'] != 'MENUNGGU'): ?>
                                                                    <div class="v-timeline-item success">
                                                                        <div class="v-timeline-icon"></div>
                                                                        <span class="v-timeline-date">Keputusan Bidang</span>
                                                                        <div class="v-timeline-title">Penempatan Disetujui</div>
                                                                        <?php if(!empty($p['catatan'])): ?>
                                                                            <div class="v-timeline-content mt-2">
                                                                                <?= nl2br(esc($p['catatan'])) ?>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>

                                                        <!-- RIGHT COLUMN: DETAILS & FILES -->
                                                        <div class="col-lg-7 p-4">
                                                            <h6 class="fw-bold mb-4 text-dark" style="font-size: 0.95rem;"><i class="bi bi-card-text me-2 text-primary"></i>Informasi Kegiatan</h6>
                                                            
                                                            <div class="bg-light p-3 rounded mb-4 border" style="font-size: 0.85rem;">
                                                                <div class="row mb-3">
                                                                    <div class="col-sm-5 text-muted fw-medium">Jenis Kegiatan</div>
                                                                    <div class="col-sm-7 fw-bold text-dark">
                                                                        <?php
                                                                            if($p['id_jenis_permohonan'] == 1) echo 'Penelitian Skripsi / Tugas Akhir';
                                                                            elseif($p['id_jenis_permohonan'] == 2) echo 'Observasi / Pengambilan Data';
                                                                            elseif($p['id_jenis_permohonan'] == 3) echo 'Praktik Kerja Lapangan (Magang)';
                                                                            else echo 'Uji Coba Produk (Prototype)';
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-sm-5 text-muted fw-medium">Jadwal Pelaksanaan</div>
                                                                    <div class="col-sm-7 fw-bold text-dark">
                                                                        <?= date('d M Y', strtotime($p['tgl_mulai'])) ?> <span class="fw-normal text-muted mx-1">s/d</span> <?= date('d M Y', strtotime($p['tgl_selesai'])) ?>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-sm-5 text-muted fw-medium">Keahlian/Fokus Utama</div>
                                                                    <div class="col-sm-7 text-dark" style="line-height: 1.5;">
                                                                        <?= !empty($p['deskripsi_keahlian']) ? nl2br(esc($p['deskripsi_keahlian'])) : '-' ?>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-5 text-muted fw-medium">Tujuan Detail</div>
                                                                    <div class="col-sm-7 text-dark" style="line-height: 1.5;">
                                                                        <?= !empty($p['deskripsi_magang']) ? nl2br(esc($p['deskripsi_magang'])) : '-' ?>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <h6 class="fw-bold mb-3 text-dark mt-4" style="font-size: 0.95rem;"><i class="bi bi-folder2-open me-2 text-primary"></i>Dokumen Lampiran</h6>
                                                            <div class="row g-2">
                                                                <?php if (!empty($p['files'])): ?>
                                                                    <?php foreach($p['files'] as $file): ?>
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="file-card-modern position-relative">
                                                                            <div class="file-icon-box <?= strpos(strtolower($file['nama_file']), '.pdf') !== false ? 'pdf' : 'doc' ?>">
                                                                                <i class="bi bi-file-earmark-<?= strpos(strtolower($file['nama_file']), '.pdf') !== false ? 'pdf' : 'text' ?>-fill"></i>
                                                                            </div>
                                                                            <div class="overflow-hidden w-100">
                                                                                <div class="small text-dark text-truncate fw-bold mb-1" title="<?= esc($file['nama_file']) ?>"><?= esc($file['nama_file']) ?></div>
                                                                                <div class="d-flex justify-content-between align-items-center">
                                                                                    <a href="<?= base_url('mahasiswa/view-file/' . $file['id_file_permohonan_magang']) ?>" target="_blank" class="text-decoration-none small text-primary fw-medium">Lihat File &rarr;</a>
                                                                                    <?php if(isset($file['status_verifikasi']) && $file['status_verifikasi'] === 'TIDAK_VALID'): ?>
                                                                                        <span class="badge bg-danger" style="font-size: 0.65rem;">Tidak Valid</span>
                                                                                    <?php elseif(isset($file['status_verifikasi']) && $file['status_verifikasi'] === 'VALID'): ?>
                                                                                        <span class="badge bg-success" style="font-size: 0.65rem;">Valid</span>
                                                                                    <?php endif; ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php endforeach; ?>
                                                                <?php else: ?>
                                                                    <div class="col-12"><div class="alert alert-light border text-center small text-muted py-3"><i class="bi bi-inbox fs-4 d-block mb-2"></i>Belum ada file terlampir.</div></div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer bg-white border-top py-2 d-flex justify-content-between">
                                                    <div>
                                                        <?php if ($p['posting_data'] == 'kirim' && (empty($p['status_persetujuan']) || $p['status_persetujuan'] == 'MENUNGGU') && empty($p['disposisi'])): ?>
                                                            <a href="<?= base_url('mahasiswa/batalkan-permohonan/' . $p['id_permohonan_magang']) ?>"
                                                               class="btn btn-sm btn-outline-danger px-3"
                                                               onclick="event.preventDefault(); var url = this.href; Swal.fire({title: 'Batalkan Permohonan?', text: 'Permohonan yang dibatalkan tidak bisa dikembalikan dan dokumen akan dihapus dari sistem.', icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#0a1d37', confirmButtonText: 'Ya, Batalkan', cancelButtonText: 'Tutup'}).then((res) => { if(res.isConfirmed) window.location.href = url; });">Batalkan Pengajuan</a>
                                                        <?php endif; ?>
                                                    </div>
                                                    <button type="button" class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- MODAL B: INFO PENEMPATAN (DISETUJUI) -->
                                    <?php if ($p['status_persetujuan'] == 'DISETUJUI'): ?>
                                    <div class="modal fade" id="modalInfoPenempatan<?= $p['id_permohonan_magang'] ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow" style="border-radius: 8px;">
                                                <div class="modal-header bg-white border-bottom py-3">
                                                    <h6 class="modal-title fw-bold text-dark m-0">Keputusan Penempatan</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-4 text-start bg-white">
                                                    
                                                    <div class="mb-4">
                                                        <div class="row mb-2">
                                                            <div class="col-sm-5 text-muted small fw-medium">Nama Mahasiswa</div>
                                                            <div class="col-sm-7 fw-semibold text-dark small"><?= session()->get('nama') ?></div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-sm-5 text-muted small fw-medium">Nomor Induk / NIM</div>
                                                            <div class="col-sm-7 fw-semibold text-dark small"><?= esc($p['nim']) ?></div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-sm-5 text-muted small fw-medium">Jenis Kegiatan</div>
                                                            <div class="col-sm-7 fw-semibold text-dark small">
                                                                <?php
                                                                    if($p['id_jenis_permohonan'] == 1) echo 'Penelitian / TA';
                                                                    elseif($p['id_jenis_permohonan'] == 2) echo 'Observasi';
                                                                    elseif($p['id_jenis_permohonan'] == 3) echo 'Magang / PKL';
                                                                    else echo 'Uji Coba Produk';
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-4">
                                                        <h6 class="fw-bold mb-3 border-bottom pb-2" style="font-size: 0.95rem;">Detail Penempatan</h6>
                                                        <div class="row mb-2">
                                                            <div class="col-sm-5 text-muted small fw-medium">Bidang Penempatan</div>
                                                            <div class="col-sm-7 fw-bold text-primary small">
                                                                <?= !empty($p['bidang']) ? esc($p['bidang']) : '<span class="text-muted fw-normal fst-italic">Menunggu Alokasi</span>' ?>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-sm-5 text-muted small fw-medium">Mulai Pelaksanaan</div>
                                                            <div class="col-sm-7 fw-semibold text-dark small"><?= date('d F Y', strtotime($p['tgl_mulai'])) ?></div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-sm-5 text-muted small fw-medium">Akhir Pelaksanaan</div>
                                                            <div class="col-sm-7 fw-semibold text-dark small"><?= date('d F Y', strtotime($p['tgl_selesai'])) ?></div>
                                                        </div>
                                                    </div>

                                                    <?php if (!empty($p['surat_balasan'])): ?>
                                                    <div class="mb-4">
                                                        <h6 class="fw-bold mb-3 border-bottom pb-2" style="font-size: 0.95rem;">Surat Balasan / Penerimaan</h6>
                                                        <div class="row g-2">
                                                            <?php foreach($p['surat_balasan'] as $surat): ?>
                                                            <div class="col-12">
                                                                <div class="p-2 border rounded d-flex align-items-center justify-content-between" style="background-color: #f0fdf4;">
                                                                    <div class="d-flex align-items-center gap-2 overflow-hidden px-1">
                                                                        <i class="bi bi-file-earmark-pdf-fill text-success fs-5"></i>
                                                                        <span class="small text-dark text-truncate fw-bold" title="<?= esc($surat['nama_file']) ?>"><?= esc($surat['nama_file']) ?></span>
                                                                    </div>
                                                                    <a href="<?= base_url('mahasiswa/download-surat-penerimaan/' . $surat['id_file_selesai_magang']) ?>" target="_blank" class="btn btn-sm btn-success py-1 px-3 small text-white" style="border-radius: 6px;">Download</a>
                                                                </div>
                                                            </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                    <?php endif; ?>

                                                    <div>
                                                        <h6 class="fw-bold mb-2 text-dark" style="font-size: 0.95rem;">Instruksi / Catatan</h6>
                                                        <div class="p-3 bg-light border rounded small text-dark fst-italic" style="line-height: 1.5;">
                                                            "<?= !empty($p['catatan']) ? esc($p['catatan']) : 'Mahasiswa resmi diterima dan ditempatkan oleh Bidang.' ?>"
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer bg-white border-top py-2">
                                                    <button type="button" class="btn btn-secondary btn-sm px-4 w-100" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>

                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="mx-auto mb-4" style="width: 110px; height: 110px; background-color: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; position: relative; border: 4px solid #ffffff; box-shadow: 0 10px 25px rgba(100, 116, 139, 0.1);">
                                        <i class="bi bi-folder-x" style="font-size: 3.2rem; color: #cbd5e1;"></i>
                                        <div style="position: absolute; bottom: -5px; right: -5px; background-color: #ef4444; color: white; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; border: 3px solid white;"><i class="bi bi-exclamation"></i></div>
                                    </div>
                                    <?php if(!empty(request()->getGet('filter_status')) || !empty(request()->getGet('filter_jenis'))): ?>
                                        <h6 class="fw-bold text-dark mb-1">Hasil Tidak Ditemukan</h6>
                                        <p class="text-muted small mx-auto" style="max-width: 320px; line-height: 1.6;">Data permohonan dengan kriteria filter Anda saat ini tidak ditemukan.</p>
                                    <?php else: ?>
                                        <h6 class="fw-bold text-dark mb-1">Belum Ada Pengajuan</h6>
                                        <p class="text-muted small mx-auto" style="max-width: 320px; line-height: 1.6;">Anda belum memiliki riwayat pengajuan permohonan di sistem. Silakan ajukan melalui menu Permohonan.</p>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div> <!-- /.table-responsive -->

            <!-- SEKSI TOMBOL HALAMAN (PAGINATION) - SEKARANG SUDAH RAPI TERBUNGKUS CLASS -->
            <?php if (!empty($permohonan)): ?>
                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                    <div class="small text-muted fw-semibold">
                        Menampilkan <?= count($permohonan) ?> data permohonan aktif.
                    </div>
                    <div class="custom-pagination">
                        <?= $pager ?> 
                    </div>
                </div>
            <?php endif; ?>

        </div> <!-- /.card-flat -->
<?= $this->endSection() ?>