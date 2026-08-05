<?= $this->extend('layout/mahasiswa') ?>

<?= $this->section('extra_css') ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<style>
    /* Paksa scrollbar selalu tampil agar tidak goyang */
    html { overflow-y: scroll; }
    /* Sembunyikan elemen bawaan DataTables */
    .dataTables_filter, .dataTables_length, .dataTables_info, .dataTables_paginate { display: none !important; }
    table.dataTable, table.dataTable *, .dataTables_wrapper, .dataTables_wrapper * { transition: none !important; animation: none !important; }
    table.dataTable { border-collapse: collapse !important; }
    /* Custom Pagination Footer */
    .custom-dt-footer { display: flex; align-items: center; justify-content: space-between; padding: 14px 4px 0; margin-top: 8px; border-top: 1px solid #f1f5f9; }
    .custom-dt-footer .dt-info-text { font-size: 0.8rem; color: #94a3b8; font-weight: 500; }
    .custom-dt-footer .dt-page-buttons { display: flex; align-items: center; gap: 4px; }
    .custom-dt-footer .dt-page-btn { display: inline-flex; align-items: center; justify-content: center; min-width: 30px; height: 30px; padding: 0 8px; font-size: 0.78rem; font-weight: 600; color: #64748b; background: #fff; border: 1px solid #e2e8f0; border-radius: 6px; cursor: pointer; }
    .custom-dt-footer .dt-page-btn:hover { background: #f8fafc; border-color: #cbd5e1; color: #334155; }
    .custom-dt-footer .dt-page-btn.active { background: #13325B; border-color: #13325B; color: #fff; }
    .custom-dt-footer .dt-page-btn.disabled { opacity: 0.35; cursor: default; pointer-events: none; }
    .status-filter-bar { padding: 15px 17px; background: #f7fbfd; border: 1px solid #e1ebf0; border-radius: 10px; }
    /* --- CARD FLAT FORM & TIMELINE --- */
    .card-flat {
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.03);
        border-radius: 12px;
        padding: 28px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.01);
    }

    .section-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--primary-navy);
        padding-bottom: 10px;
        border-bottom: 1px solid #edf2f7;
        margin-bottom: 20px;
    }

    /* --- INPUT COMPONENT STYLING --- */
    .form-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        color: var(--text-muted);
        margin-bottom: 6px;
    }

    .form-control {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.88rem;
        color: var(--text-dark);
        background-color: #fbfbfb;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        background-color: #ffffff;
        border-color: var(--accent-blue-soft);
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
    }

    textarea.form-control { resize: none; }

    .btn-primary {
        background-color: var(--primary-navy) !important;
        border-color: var(--primary-navy) !important;
        font-weight: 500;
        font-size: 0.88rem;
        border-radius: 6px;
        padding: 11px 24px;
        transition: all 0.2s ease;
    }

    .btn-primary:hover {
        background-color: var(--primary-royal) !important;
        border-color: var(--primary-royal) !important;
    }

    /* --- TABLE STYLE FOR HISTORY --- */
    .table-custom th {
        background-color: #f8fafc !important;
        color: var(--text-muted);
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 14px;
        border-bottom: 2px solid #edf2f7;
    }

    .table-custom td {
        padding: 14px;
        vertical-align: middle;
        font-size: 0.88rem;
        color: var(--text-dark);
        border-bottom: 1px solid #edf2f7;
    }

    /* --- BADGE NETRAL PREMIUM (BUKAN WARNA STABILO) --- */
    .badge-status-pending {
        background-color: #fffbeb;
        color: #b45309;
        font-weight: 500;
        font-size: 0.75rem;
        padding: 5px 12px;
        border-radius: 6px;
        border: 1px solid #fef3c7;
    }

    .badge-status-approved {
        background-color: #f0fdf4;
        color: #15803d;
        font-weight: 500;
        font-size: 0.75rem;
        padding: 5px 12px;
        border-radius: 6px;
        border: 1px solid #dcfce7;
    }

    .badge-status-rejected {
        background-color: #fef2f2;
        color: #b91c1c;
        font-weight: 500;
        font-size: 0.75rem;
        padding: 5px 12px;
        border-radius: 6px;
        border: 1px solid #fee2e2;
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
    .ph-stat:hover { border-color: #cbd5e1; }
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
    @media (max-width: 575.98px) {
        .page-header-stats { flex-direction: column; }
        .page-header-top { flex-direction: column; align-items: flex-start; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<a href="<?= base_url('mahasiswa/dashboard') ?>" class="text-decoration-none text-primary">Dashboard</a> <span class="mx-2 text-muted">/</span> <span class="text-dark fw-medium">Logbook Kegiatan</span>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
        
        
        <?php
            $totalActivity = count($logbook ?? []);
            $approvedActivity = 0;
            foreach (($logbook ?? []) as $activityItem) {
                if (($activityItem['status_logbook'] ?? '') === 'disetujui' || !empty($activityItem['disetujui_oleh'])) $approvedActivity++;
            }
        ?>
        <div class="mb-4">
            <h3 class="fw-semibold mb-1 text-dark">Logbook Kegiatan</h3>
            <p class="text-muted mb-0">Catat pekerjaan harian dengan ringkas dan pantau hasil review dari Bidang terkait.</p>
        </div>
        
        <div class="page-header-card">
            <div class="page-header-stats">
                <div class="ph-stat">
                    <div class="ph-stat-icon blue"><i class="bi bi-journal-text"></i></div>
                    <div>
                        <div class="ph-stat-value"><?= $totalActivity ?></div>
                        <div class="ph-stat-label">Total Catatan</div>
                    </div>
                </div>
                <div class="ph-stat">
                    <div class="ph-stat-icon green"><i class="bi bi-check2-circle"></i></div>
                    <div>
                        <div class="ph-stat-value"><?= $approvedActivity ?></div>
                        <div class="ph-stat-label">Disetujui</div>
                    </div>
                </div>
                <div class="ph-stat">
                    <div class="ph-stat-icon amber"><i class="bi bi-clock-history"></i></div>
                    <div>
                        <div class="ph-stat-value"><?= $totalActivity - $approvedActivity ?></div>
                        <div class="ph-stat-label">Pending</div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success border-0 small py-2.5 mb-4 shadow-sm" role="alert" style="background-color: #f0fdf4; color: #15803d; border-left: 4px solid #16a34a !important;">
                <i class="bi bi-check-circle-fill me-1"></i> <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger border-0 small py-2.5 mb-4 shadow-sm" role="alert" style="background-color: #fef2f2; color: #dc2626; border-left: 4px solid #dc2626 !important;">
                <i class="bi bi-exclamation-triangle-fill me-1"></i> <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- INFORMASI KEGIATAN & CONTEXT SWITCHER -->
        <?php if (!empty($penempatan)): ?>
        <div class="card-flat mb-4" style="padding: 20px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px;">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <h6 class="fw-bold text-dark mb-1" style="font-size: 1.1rem;"><?= esc($penempatan['nama_jenis'] ?? 'Kegiatan Magang') ?></h6>
                    <div class="text-muted" style="font-size: 0.88rem; margin-top: 4px;">
                        Periode: <?= date('d M Y', strtotime($penempatan['tgl_mulai'])) ?> &ndash; <?= date('d M Y', strtotime($penempatan['tgl_selesai'])) ?>
                        <span class="mx-2 text-black-50">|</span>
                        Status: <strong class="<?= $penempatan['status_penempatan'] == 'BERJALAN' ? 'text-success' : 'text-secondary' ?>"><?= esc($penempatan['status_penempatan']) ?></strong>
                    </div>
                </div>
                <?php if (count($semuaPenempatan) > 1): ?>
                <div class="col-md-5 mt-3 mt-md-0">
                    <label class="form-label mb-1 fw-bold text-dark" style="font-size: 0.75rem;">Pilih Riwayat Kegiatan:</label>
                    <form id="formGantiPenempatan" method="POST" action="<?= base_url('mahasiswa/logbook') ?>">
                        <?= csrf_field() ?>
                        <select name="id_penempatan" class="form-select shadow-none border-primary" style="background-color: #fff;" onchange="document.getElementById('formGantiPenempatan').submit()">
                            <?php foreach($semuaPenempatan as $p): ?>
                                <option value="<?= $p['id_penempatan_magang'] ?>" <?= ($penempatan['id_penempatan_magang'] == $p['id_penempatan_magang']) ? 'selected' : '' ?>>
                                    <?= esc($p['nama_jenis']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if (empty($penempatan)): ?>
            <div class="alert alert-warning border-0 p-3 mb-4 shadow-sm" style="border-radius: 8px;">
                <div class="d-flex gap-2">
                    <i class="bi bi-lock-fill fs-5 mt-1"></i>
                    <div>
                        <span class="fw-bold d-block mb-1" style="font-size: 0.85rem;">Akses Logbook Terkunci</span>
                        <p class="small m-0" style="line-height: 1.5; font-size: 0.8rem;">
                            Anda belum dialokasikan ke unit bidang kerja. Formulir pelaporan harian baru akan aktif setelah penempatan bidang disahkan.
                        </p>
                    </div>
                </div>
            </div>
        <?php elseif (isset($is_log_book) && strtolower($is_log_book) == 'tidak'): ?>
            <div class="alert alert-secondary border-0 p-3 mb-4 shadow-sm" style="border-radius: 8px;">
                <div class="d-flex gap-2">
                    <i class="bi bi-info-circle-fill fs-5 mt-1"></i>
                    <div>
                        <span class="fw-bold d-block mb-1" style="font-size: 0.85rem;">Logbook Tidak Diwajibkan</span>
                        <p class="small m-0" style="line-height: 1.5; font-size: 0.8rem;">
                            Berdasarkan pengaturan dari Bidang, kegiatan magang Anda tidak mewajibkan pengisian logbook harian.
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <div class="col-12">
                <div class="card-flat h-100">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 border-bottom pb-3" style="border-color: #edf2f7 !important;">
                        <div class="section-title border-0 pb-0 mb-0 m-0"><i class="bi bi-clock-history me-1 text-primary"></i> Riwayat Aktivitas</div>
                        
                        <div class="d-flex flex-wrap gap-2 align-items-center mt-3 mt-md-0">
                            <!-- Tombol Tambah Logbook (muncul jika BERJALAN) -->
                            <?php if(!empty($penempatan) && $penempatan['status_penempatan'] == 'BERJALAN' && (!isset($is_log_book) || strtolower($is_log_book) != 'tidak')): ?>
                                <button type="button" class="btn btn-sm btn-primary shadow-sm px-3" data-bs-toggle="modal" data-bs-target="#modalTambahLogbook" style="font-size: 0.78rem;">
                                    <i class="bi bi-plus-lg me-1"></i> Tambah Catatan Harian
                                </button>
                            <?php endif; ?>

                            <?php if(!empty($penempatan)): ?>
                                <a href="<?= base_url('mahasiswa/logbook/cetak') ?>" target="_blank" class="btn btn-sm btn-danger shadow-sm px-3" style="font-size: 0.78rem;">
                                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> Cetak PDF
                                </a>
                            <?php endif; ?>

                            <!-- Filter Client-Side -->
                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                <select id="filter-status-lb" class="form-select form-select-sm shadow-none" style="width: 130px; font-size: 0.78rem; border-color: #e2e8f0; color: #64748b; background-color: #f8fafc;">
                                    <option value="">Semua Status</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Disetujui">Disetujui</option>
                                    <option value="Dikembalikan">Dikembalikan</option>
                                </select>
                                <div style="position: relative;">
                                    <i class="bi bi-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 0.75rem;"></i>
                                    <input type="text" id="dt-search-lb" class="form-control form-control-sm shadow-none" placeholder="Cari..." style="padding-left: 28px; border-radius: 8px; width: 160px; font-size: 0.78rem;">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table id="tabelLogbook" class="table table-borderless table-custom align-middle m-0">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th style="width: 120px;">Tanggal</th>
                                    <th>Deskripsi Kegiatan</th>
                                    <th style="width: 120px;" class="text-center">Bukti</th>
                                    <th style="width: 120px;" class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($logbook)): ?>
                                    <?php $no = 1; foreach($logbook as $l): ?>
                                    <tr>
                                        <td class="text-muted" style="font-size: 0.82rem;"><?= $no++ ?></td>
                                        <td class="fw-semibold text-secondary" style="font-size: 0.82rem;">
                                            <?= date('d M Y', strtotime($l['tgl_logbook'])) ?>
                                        </td>
                                        <td style="line-height: 1.5;">
                                            <?= esc($l['logbook_magang']) ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if(!empty($l['bukti_kegiatan'])): ?>
                                                <a href="<?= base_url($l['bukti_kegiatan']) ?>" target="_blank" class="btn btn-sm btn-outline-primary py-1 px-2 shadow-none" style="font-size: 0.75rem; border-radius: 6px;"><i class="bi bi-image me-1"></i> Lihat</a>
                                            <?php else: ?>
                                                <span class="text-muted" style="font-size: 0.75rem;">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if($l['status_logbook'] == 'disetujui' || !empty($l['disetujui_oleh'])): ?>
                                                <span class="badge-status-approved mb-2 d-inline-block">
                                                    Disetujui
                                                </span>
                                            <?php elseif($l['status_logbook'] == 'ditolak'): ?>
                                                <span class="badge-status-rejected mb-2 d-inline-block">
                                                    <i class="bi bi-x-circle-fill me-1"></i> Dikembalikan
                                                </span>
                                            <?php else: ?>
                                                <span class="badge-status-pending mb-2 d-inline-block">
                                                    <i class="bi bi-hourglass-split me-1"></i> Pending
                                                </span>
                                            <?php endif; ?>

                                            <?php if($l['status_logbook'] == 'ditolak' && !empty($l['catatan_revisi'])): ?>
                                                <div class="mt-2 text-start p-2 bg-light rounded border text-danger" style="font-size: 0.75rem; line-height: 1.4;">
                                                    <i class="bi bi-exclamation-triangle-fill me-1"></i> <b>Catatan Kabid:</b><br>
                                                    <span class="text-muted"><?= esc($l['catatan_revisi']) ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Custom Pagination -->
                    <div class="custom-dt-footer" id="lbPagination">
                        <span class="dt-info-text" id="lbInfoText">Menampilkan 0 data</span>
                        <div class="dt-page-buttons" id="lbPageButtons"></div>
                    </div>

                </div>
            </div>
        </div>

<!-- MODAL TAMBAH LOGBOOK -->
<?php if(!empty($penempatan)): ?>
<div class="modal fade" id="modalTambahLogbook" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 12px;">
            <div class="modal-header bg-white border-bottom py-3">
                <h6 class="modal-title fw-bold text-dark m-0"><i class="bi bi-pencil-square me-2 text-primary"></i>Isi Laporan Harian</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-white">
                <form action="<?= base_url('mahasiswa/simpanLogbook') ?>" method="POST" enctype="multipart/form-data" onsubmit="event.preventDefault(); var form = this; Swal.fire({title: 'Simpan Laporan Hari Ini?', text: 'Pastikan uraian aktivitas yang Anda tulis sudah lengkap dan sesuai.', icon: 'question', showCancelButton: true, confirmButtonColor: '#0a1d37', cancelButtonColor: '#6c757d', confirmButtonText: 'Ya, Simpan', cancelButtonText: 'Periksa Lagi'}).then((res) => { if(res.isConfirmed) { form.submit(); } });">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_penempatan_magang" value="<?= $penempatan['id_penempatan_magang'] ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">Tanggal Kegiatan <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tgl_logbook" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rincian Kegiatan / Tugas <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="logbook_magang" rows="5" placeholder="Contoh: Membantu memvalidasi dokumen administrasi pengajuan dinas dan merapikan struktur file template..." required></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Bukti Kegiatan (Opsional)</label>
                        <input type="file" class="form-control" name="bukti_kegiatan" accept=".png,.jpg,.jpeg,.pdf">
                        <small class="text-muted d-block mt-1">Bisa berupa foto (JPG/PNG) atau dokumen (PDF). Maksimal 2MB.</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 shadow-sm py-2" style="font-weight: 600;">Simpan Laporan Hari Ini</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    var table = $('#tabelLogbook').DataTable({
        paging: true, lengthChange: false, searching: true, ordering: true,
        info: false, autoWidth: false, pageLength: 10,
        order: [[1, 'desc']],
        dom: 'rt',
        language: { 
            emptyTable: `<div class="text-center py-5">
                <div class="mx-auto mb-4" style="width: 120px; height: 120px; background-color: #f0f9ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; position: relative; border: 4px solid #ffffff; box-shadow: 0 10px 25px rgba(14, 165, 233, 0.1);">
                    <div style="position: absolute; top: -5px; right: 10px; width: 25px; height: 25px; background-color: #e0f2fe; border-radius: 50%;"></div>
                    <div style="position: absolute; bottom: 10px; left: -10px; width: 15px; height: 15px; background-color: #dbeafe; border-radius: 50%;"></div>
                    <i class="bi bi-journal-text" style="font-size: 3.5rem; color: #bae6fd; position: absolute; transform: rotate(-10deg) translateX(-8px);"></i>
                    <i class="bi bi-pencil-fill text-primary" style="font-size: 2.2rem; position: absolute; transform: rotate(15deg) translate(15px, 15px); filter: drop-shadow(2px 4px 6px rgba(0,0,0,0.1));"></i>
                </div>
                <h6 class="fw-bold text-dark mb-2" style="font-size: 1rem;">Logbook Masih Kosong</h6>
                <p class="text-muted small mx-auto" style="max-width: 280px; line-height: 1.6; font-size: 0.85rem;">
                    Anda belum mencatat kegiatan apapun. Ayo mulai laporkan rutinitas harian Anda dengan menekan tombol Tambah Catatan Harian!
                </p>
            </div>`, 
            zeroRecords: 'Tidak ditemukan data yang sesuai.' 
        },
        columnDefs: [{ orderable: false, targets: [3] }]
    });

    // Custom pagination
    function renderPagination() {
        var info = table.page.info();
        var start = info.start + 1, end = info.end, total = info.recordsDisplay, page = info.page, pages = info.pages;
        $('#lbInfoText').text(total === 0 ? 'Tidak ada data' : 'Menampilkan ' + start + ' - ' + end + ' dari ' + total + ' data');
        var html = '<span class="dt-page-btn ' + (page === 0 ? 'disabled' : '') + '" data-page="prev">&lsaquo;</span>';
        for (var i = 0; i < pages; i++) { html += '<span class="dt-page-btn ' + (i === page ? 'active' : '') + '" data-page="' + i + '">' + (i+1) + '</span>'; }
        html += '<span class="dt-page-btn ' + (page >= pages-1 ? 'disabled' : '') + '" data-page="next">&rsaquo;</span>';
        $('#lbPageButtons').html(html);
    }
    $('#lbPageButtons').on('click', '.dt-page-btn:not(.disabled)', function() {
        var p = $(this).data('page');
        if (p === 'prev') table.page('previous').draw('page');
        else if (p === 'next') table.page('next').draw('page');
        else table.page(parseInt(p)).draw('page');
    });
    table.on('draw', function() { renderPagination(); });
    renderPagination();

    // Search
    $('#dt-search-lb').on('keyup', function() { table.search(this.value).draw(); });

    // Filter Status (kolom 4)
    $('#filter-status-lb').on('change', function() {
        var val = this.value;
        table.column(4).search(val ? $.fn.dataTable.util.escapeRegex(val) : '', true, false).draw();
    });
});
</script>
<?= $this->endSection() ?>