<?= $this->extend('layout/V_Mahasiswa') ?>

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
    /* === PAGE HEADER === */
    .page-header-top {
        display: flex;
        align-items: center;
        gap: 18px;
        margin-bottom: 20px;
        margin-top: 5px;
    }
    .page-header-top h4 {
        font-weight: 800;
        color: #1a2b3c;
        margin: 0;
        font-size: 1.4rem;
        letter-spacing: -0.3px;
    }
    .page-header-top .sub-text {
        color: #64748b;
        font-size: 0.9rem;
        margin: 4px 0 0;
        line-height: 1.5;
    }
    .page-header-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }
    .page-header-stats {
        display: flex;
        gap: 12px;
    }
    .ph-stat {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 18px;
        background: #f8fafc;
        border: 1px solid #edf2f7;
        border-radius: 10px;
        transition: border-color 0.2s;
    }
    .ph-stat:hover {
        border-color: #cbd5e1;
    }
    .ph-stat-icon {
        width: 38px;
        height: 38px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }
    .ph-stat-icon.blue { background: #dbeafe; color: #2563eb; }
    .ph-stat-icon.green { background: #dcfce7; color: #16a34a; }
    .ph-stat-icon.amber { background: #fef3c7; color: #d97706; }
    .ph-stat-icon.slate { background: #e2e8f0; color: #475569; }
    .ph-stat-value {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1e293b;
        line-height: 1;
    }
    .ph-stat-label {
        font-size: 0.72rem;
        color: #94a3b8;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-top: 2px;
    }
    .status-filter-bar { padding: 15px 17px; background: #f7fbfd; border: 1px solid #e1ebf0; border-radius: 10px; }
    @media (max-width: 575.98px) {
        .page-header-stats { flex-direction: column; }
        .page-header-top { flex-direction: column; align-items: flex-start; }
    }

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
<a href="<?= base_url('mahasiswa/dashboard') ?>" class="text-decoration-none text-primary">Dashboard</a> <span class="mx-2 text-muted">/</span> <span class="text-dark fw-medium">Riwayat Permohonan</span>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
        
        <div id="sectionList">
        <?php
            $totalPermohonan = 0;
            $totalSelesai = 0;
            $totalDraft = 0;
            foreach (($permohonan ?? []) as $statusItem) {
                // Jangan hitung draft sebagai "Pengajuan" karena belum dikirim
                if (strtolower($statusItem['posting_data'] ?? '') === 'draft') {
                    $totalDraft++;
                } else {
                    $totalPermohonan++;
                    if (!empty($statusItem['status_penempatan']) && $statusItem['status_penempatan'] !== 'MENUNGGU') {
                        $totalSelesai++;
                    }
                }
            }
            $totalMenunggu = $totalPermohonan - $totalSelesai;
        ?>
        <div class="mb-4">
            <h3 class="fw-semibold mb-1 text-dark">Lihat Riwayat Permohonan</h3>
            <p class="text-muted mb-0">Pantau perjalanan dokumen Anda dari pengajuan, verifikasi, hingga keputusan penempatan.</p>
        </div>
        
        <div class="page-header-card">
            <div class="page-header-stats">
                <div class="ph-stat">
                    <div class="ph-stat-icon blue"><i class="bi bi-file-earmark-text"></i></div>
                    <div>
                        <div class="ph-stat-value"><?= $totalPermohonan ?></div>
                        <div class="ph-stat-label">Total Pengajuan</div>
                    </div>
                </div>
                <div class="ph-stat">
                    <div class="ph-stat-icon green"><i class="bi bi-check-circle"></i></div>
                    <div>
                        <div class="ph-stat-value"><?= $totalSelesai ?></div>
                        <div class="ph-stat-label">Diproses</div>
                    </div>
                </div>
                <div class="ph-stat">
                    <div class="ph-stat-icon amber"><i class="bi bi-hourglass-split"></i></div>
                    <div>
                        <div class="ph-stat-value"><?= $totalMenunggu ?></div>
                        <div class="ph-stat-label">Menunggu</div>
                    </div>
                </div>
            </div>
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
                        <option value="DRAFT" <?= (request()->getGet('filter_status') == 'DRAFT') ? 'selected' : '' ?>>Draft</option>
                        <option value="MENUNGGU" <?= (request()->getGet('filter_status') == 'MENUNGGU') ? 'selected' : '' ?>>Menunggu Verifikasi</option>
                        <option value="PERBAIKAN_BERKAS" <?= (request()->getGet('filter_status') == 'PERBAIKAN_BERKAS') ? 'selected' : '' ?>>Perlu Perbaikan</option>
                        <option value="DISETUJUI" <?= (request()->getGet('filter_status') == 'DISETUJUI') ? 'selected' : '' ?>>Disetujui</option>
                        <option value="SELESAI" <?= (request()->getGet('filter_status') == 'SELESAI') ? 'selected' : '' ?>>Selesai</option>
                        <option value="DITOLAK" <?= (request()->getGet('filter_status') == 'DITOLAK') ? 'selected' : '' ?>>Ditolak</option>
                    </select>
                </div>
            </form>

            <div class="table-shell table-responsive">
                <table class="table table-hover align-middle m-0" style="table-layout: fixed; width: 100%;">
                    <colgroup>
                        <col style="width: 5%;">          <!-- No -->
                        <col style="width: 15%;">         <!-- Tanggal Diajukan -->
                        <col style="width: 23%;">         <!-- Jenis Permohonan -->
                        <col style="width: 15%;">         <!-- Tanggal Mulai -->
                        <col style="width: 15%;">         <!-- Tanggal Selesai -->
                        <col style="width: 15%;">         <!-- Status -->
                        <col style="width: 12%;">         <!-- Aksi -->
                    </colgroup>
                    <thead class="table-light">
                        <tr class="text-muted small text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.4px;">
                            <th class="py-3 text-center">No</th>
                            <th class="py-3 text-center" style="white-space: nowrap;">Tanggal Diajukan</th>
                            <th class="py-3 text-center">Jenis Permohonan</th>
                            <th class="py-3 text-center">Tanggal Mulai</th>
                            <th class="py-3 text-center">Tanggal Selesai</th>
                            <th class="py-3 text-center">Status Terkini</th>
                            <th class="py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($permohonan)): ?>
                            <?php $no = 1; foreach($permohonan as $p): ?>
                            <tr>
                                <td class="text-muted text-center" style="font-size: 0.82rem;"><?= $no++ ?></td>
                                <td class="text-center" style="white-space: nowrap;">
                                    <span class="fw-semibold text-dark" style="font-size: 0.82rem;"><?= date('d M Y', strtotime($p['created_at'])) ?></span>
                                </td>
                                <td class="text-center">
                                    <div class="fw-semibold text-dark" style="font-size: 0.82rem; line-height: 1.4;">
                                        <?php
                                            if($p['id_jenis_permohonan'] == 1)      echo 'Penelitian / Skripsi';
                                            elseif($p['id_jenis_permohonan'] == 2)  echo 'Observasi / Ambil Data';
                                            elseif($p['id_jenis_permohonan'] == 3)  echo 'Magang / PKL';
                                            else                                    echo 'Uji Coba Produk';
                                        ?>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="fw-semibold text-dark" style="font-size: 0.8rem;"><?= date('d M Y', strtotime($p['tgl_mulai'])) ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="fw-semibold text-dark" style="font-size: 0.8rem;"><?= date('d M Y', strtotime($p['tgl_selesai'])) ?></span>
                                </td>
                                <td class="align-middle text-center">
                                    <?php if ($p['posting_data'] == 'draft'): ?>
                                        <span class="status-pill neutral"><i class="bi bi-file-earmark"></i> Draft</span>
                                    <?php elseif ($p['status_persetujuan'] == 'DITOLAK'): ?>
                                        <span class="status-pill rejected"><i class="bi bi-x-circle"></i> Ditolak</span>

                                    <?php elseif ($p['status_persetujuan'] == 'PERBAIKAN_BERKAS'): ?>
                                        <span class="status-pill pending"><i class="bi bi-pencil-square"></i> Perlu Perbaikan</span>
                                    <?php elseif (!empty($p['status_penempatan']) && $p['status_penempatan'] == 'SELESAI'): ?>
                                        <span class="status-pill approved" style="background-color: #059669; color: #fff;"><i class="bi bi-check-all"></i> Selesai</span>
                                    <?php elseif (!empty($p['status_penempatan']) && $p['status_penempatan'] != 'MENUNGGU'): ?>
                                        <span class="status-pill approved"><i class="bi bi-check-circle"></i> Disetujui</span>
                                    <?php else: ?>
                                        <span class="status-pill pending"><i class="bi bi-hourglass-split"></i> Menunggu</span>
                                    <?php endif; ?>
                                </td>
                                
                                <td class="align-middle text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <!-- ACTION BUTTON 1: EDIT FORM (Draft / Revisi) -->
                                        <?php if ($p['posting_data'] == 'draft' || $p['status_persetujuan'] == 'PERBAIKAN_BERKAS'): ?>
                                            <a href="<?= base_url('mahasiswa/permohonan/edit/'.$p['id_permohonan_magang']) ?>" class="btn btn-sm <?= ($p['status_persetujuan'] == 'PERBAIKAN_BERKAS') ? 'btn-outline-warning' : 'btn-outline-primary' ?> p-0 shadow-sm" 
                                                    style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 8px;" 
                                                    title="<?= ($p['status_persetujuan'] == 'PERBAIKAN_BERKAS') ? 'Revisi Permohonan' : 'Edit Draft' ?>">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                        <?php endif; ?>

                                        <!-- ACTION BUTTON 2: DETAIL FORM -->
                                        <?php if ($p['posting_data'] != 'draft'): ?>
                                            <button type="button" class="btn btn-sm btn-outline-secondary p-0 shadow-sm" 
                                                    style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 8px;" 
                                                    onclick="showDetail(<?= $p['id_permohonan_magang'] ?>, this)"
                                                    title="Lihat Detail Form">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        <?php endif; ?>

                                        <!-- ACTION BUTTON: RIWAYAT / LOG -->
                                        <button type="button" class="btn btn-sm btn-outline-info p-0 shadow-sm" 
                                                style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 8px;" 
                                                onclick="showLogRiwayat(<?= $p['id_permohonan_magang'] ?>)"
                                                title="Lacak Jejak (Log Riwayat)">
                                            <i class="bi bi-clock-history"></i>
                                        </button>

                                        <!-- ACTION BUTTON: BATALKAN / HAPUS (Hanya Draft di tabel) -->
                                        <?php if ($p['posting_data'] == 'draft'): ?>
                                            <button type="button" class="btn btn-sm btn-outline-danger p-0 shadow-sm"
                                                    style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 8px;"
                                                    onclick="confirmBatalkan(<?= $p['id_permohonan_magang'] ?>, '<?= $p['posting_data'] ?>')"
                                                    title="Hapus Draft">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        <?php endif; ?>

                                    </div>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
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
            <!-- Paginasi -->
            <?php if (!empty($pager)) : ?>
                <div class="d-flex justify-content-center mt-4 mb-2 custom-pagination">
                    <?= $pager ?>
                </div>
            <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        </div>

        <div id="sectionDetail" style="display: none;">
            <div id="detailContainer"></div>
        </div> <!-- /.card-flat -->

<!-- MODAL B: LOG RIWAYAT -->
<div class="modal fade" id="modalLogRiwayat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow" style="border-radius: 8px;">
            <div class="modal-header bg-white border-bottom py-3">
                <h6 class="modal-title fw-bold text-dark m-0"><i class="bi bi-clock-history me-2 text-info"></i> Lacak Jejak (Log Riwayat)</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-white" id="logRiwayatContainer">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-muted mt-2 small">Memuat riwayat aktivitas...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
    function showLogRiwayat(idPermohonan) {
        // Tampilkan modal
        var myModal = new bootstrap.Modal(document.getElementById('modalLogRiwayat'));
        myModal.show();
        
        // Kosongkan dan beri loading state
        const container = document.getElementById('logRiwayatContainer');
        container.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="text-muted mt-2 small">Memuat riwayat aktivitas...</p>
            </div>`;
            
        // Fetch data
        fetch(`<?= base_url('api/log/riwayat/') ?>${idPermohonan}`)
            .then(response => response.json())
            .then(res => {
                if(res.status === 'success') {
                    if(res.data.length === 0) {
                        container.innerHTML = `<div class="text-center text-muted small py-4">Belum ada riwayat aktivitas yang tercatat.</div>`;
                        return;
                    }
                    
                    let html = '<div class="v-timeline">';
                    res.data.forEach(log => {
                        html += `
                            <div class="v-timeline-item ${log.color_class}">
                                <div class="v-timeline-icon" style="display:flex; justify-content:center; align-items:center;">
                                    <i class="bi ${log.icon} text-white" style="font-size:0.75rem;"></i>
                                </div>
                                <span class="v-timeline-date">${log.tanggal_format} <span class="text-muted ms-1">Oleh: ${log.aktor}</span></span>
                                <div class="v-timeline-title">${log.aksi}</div>
                                ${log.catatan ? `<div class="v-timeline-content mt-1 py-2 px-3 border-0 bg-light text-dark small rounded" style="font-size:0.8rem;">${log.catatan}</div>` : ''}
                            </div>
                        `;
                    });
                    html += '</div>';
                    container.innerHTML = html;
                } else {
                    container.innerHTML = `<div class="alert alert-danger p-2 small">Gagal memuat log riwayat.</div>`;
                }
            })
            .catch(error => {
                console.error(error);
                container.innerHTML = `<div class="alert alert-danger p-2 small">Terjadi kesalahan jaringan.</div>`;
            });
    }

    function showDetail(id_permohonan, btnElem) {
        // Simpan icon asli dan tambahkan animasi kecil di tombol kaca pembesar (agar tidak terasa nge-blank)
        let originalContent = btnElem.innerHTML;
        btnElem.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        btnElem.disabled = true;

        fetch(`<?= base_url('mahasiswa/status/detail/') ?>${id_permohonan}`)
            .then(response => response.text())
            .then(html => {
                // Begitu HTML siap, barulah kita ganti halamannya (Instan 0 detik nge-blank)
                document.getElementById('detailContainer').innerHTML = html;
                document.getElementById('sectionList').style.display = 'none';
                document.getElementById('sectionDetail').style.display = 'block';
                
                // Kembalikan tombol ke semula
                btnElem.innerHTML = originalContent;
                btnElem.disabled = false;
            })
            .catch(err => {
                alert('Gagal memuat detail permohonan.');
                btnElem.innerHTML = originalContent;
                btnElem.disabled = false;
            });
    }

    function hideDetail() {
        document.getElementById('sectionDetail').style.display = 'none';
        document.getElementById('sectionList').style.display = 'block';
        document.getElementById('detailContainer').innerHTML = '';
    }

    function confirmBatalkan(id_permohonan, posting_data) {
        let actionText = (posting_data === 'draft') ? 'menghapus draft ini' : 'membatalkan permohonan ini';
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda akan " + actionText + ". Data tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Lanjutkan!',
            cancelButtonText: 'Batal',
            border_radius: '15px'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `<?= base_url('mahasiswa/batalkan-permohonan/') ?>${id_permohonan}`;
            }
        });
    }
</script>
<?= $this->endSection() ?>