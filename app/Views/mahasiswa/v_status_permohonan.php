<?= $this->extend('layout/mahasiswa') ?>

<?= $this->section('extra_css') ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<style>
    /* === OVERRIDE DATATABLES === */
    /* Sembunyikan elemen bawaan DataTables */
    .dataTables_filter, .dataTables_length, .dataTables_info { display: none !important; }

    /* MATIKAN SEMUA ANIMASI & TRANSISI DataTables */
    table.dataTable, table.dataTable *, 
    .dataTables_wrapper, .dataTables_wrapper *,
    .dataTables_paginate, .dataTables_paginate * {
        transition: none !important;
        animation: none !important;
    }

    /* Tabel */
    table.dataTable { border-collapse: collapse !important; }
    table.dataTable thead th { border-bottom: 2px solid #e2e8f0 !important; }

    /* Sembunyikan pagination & info bawaan DataTables sepenuhnya */
    .dataTables_paginate, .dataTables_info { display: none !important; }

    /* Custom Pagination Footer */
    .custom-dt-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 4px 0;
        margin-top: 8px;
        border-top: 1px solid #f1f5f9;
    }
    .custom-dt-footer .dt-info-text {
        font-size: 0.8rem;
        color: #94a3b8;
        font-weight: 500;
    }
    .custom-dt-footer .dt-page-buttons {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .custom-dt-footer .dt-page-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 30px;
        height: 30px;
        padding: 0 8px;
        font-size: 0.78rem;
        font-weight: 600;
        color: #64748b;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        cursor: pointer;
        text-decoration: none;
    }
    .custom-dt-footer .dt-page-btn:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #334155;
    }
    .custom-dt-footer .dt-page-btn.active {
        background: #13325B;
        border-color: #13325B;
        color: #fff;
    }
    .custom-dt-footer .dt-page-btn.disabled {
        opacity: 0.35;
        cursor: default;
        pointer-events: none;
    }

    .card-minimalist {
        background: #ffffff;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        border: 1px solid #f1f5f9;
    }
    .table-minimalist {
        border-collapse: separate !important;
        border-spacing: 0 8px !important;
        width: 100%;
    }
    .table-minimalist thead th {
        border-bottom: 2px solid #e2e8f0 !important;
        border-top: none !important;
        color: #475569;
        background-color: #f8fafc;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 16px;
    }
    .table-minimalist thead th:first-child {
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
    }
    .table-minimalist thead th:last-child {
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
    }
    .table-minimalist tbody tr {
        background: #ffffff;
        transition: all 0.2s ease;
    }
    .table-minimalist tbody tr:hover {
        background: #fcfcfc;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }
    .table-minimalist tbody td {
        border-top: 1px solid #f1f5f9;
        border-bottom: 1px solid #f1f5f9;
        padding: 12px 16px;
        vertical-align: middle;
        font-size: 0.85rem;
        color: #475569;
    }
    .table-minimalist tbody td:first-child {
        border-left: 1px solid #f1f5f9;
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
    }
    .table-minimalist tbody td:last-child {
        border-right: 1px solid #f1f5f9;
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
    }

    /* Solid Badges */
    .badge-solid {
        display: inline-block; padding: 5px 12px;
        font-size: 0.72rem; font-weight: 700; border-radius: 6px;
        text-transform: uppercase; letter-spacing: 0.3px; color: #fff;
    }
    .badge-solid.draft { background: #94a3b8; }
    .badge-solid.pending { background: #f59e0b; }
    .badge-solid.approved { background: #3b82f6; }
    .badge-solid.success { background: #10b981; }
    .badge-solid.rejected { background: #ef4444; }

    /* Action Buttons */
    .action-btn {
        width: 34px; height: 34px;
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: 6px; border: none; color: #fff;
        transition: opacity 0.2s; text-decoration: none;
    }
    .action-btn:hover { opacity: 0.85; color: #fff; }
    .action-btn.edit { background: #f59e0b; }
    .action-btn.delete { background: #ef4444; }
    .action-btn.detail { background: #3b82f6; }
    .action-btn.history { background: #10b981; }

    /* Custom Pagination Footer */
    .custom-dt-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
        margin-top: 12px;
    }
    .dt-info-text {
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 500;
    }
    .dt-page-buttons {
        display: flex;
        gap: 6px;
    }
    .dt-page-btn {
        padding: 6px 14px;
        font-size: 0.85rem;
        font-weight: 500;
        color: #475569;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .dt-page-btn:hover:not(.disabled) {
        background: #f8fafc;
        border-color: #cbd5e1;
    }
    .dt-page-btn.active {
        background: #e0e7ff;
        color: #4f46e5;
        border-color: #e0e7ff;
    }
    .dt-page-btn.disabled {
        opacity: 0.5;
        cursor: not-allowed;
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
        <div class="mb-4">
            <h3 class="fw-semibold mb-1 text-dark">Riwayat Permohonan</h3>
            <p class="text-muted mb-0">Lihat status dan perkembangan setiap permohonan yang telah Anda ajukan.</p>
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
        <div class="card-minimalist mb-4">
            
            <!-- CONTROLS ROW -->
            <div class="status-filter-bar mb-3">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <!-- KIRI: Show Entries -->
                    <div class="d-flex align-items-center gap-2">
                        <span class="small text-muted fw-medium">Tampilkan</span>
                        <select id="dt-length" class="form-select form-select-sm shadow-none border-secondary-subtle" style="width: 70px; border-radius: 6px;">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        <span class="small text-muted fw-medium">baris</span>
                    </div>

                    <!-- KANAN: Filters & Search -->
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <select id="filter-jenis" class="form-select form-select-sm text-secondary shadow-none" style="width: auto; min-width: 170px; border-radius: 6px;">
                            <option value="">Semua Jenis Layanan</option>
                            <option value="Penelitian / Skripsi">Penelitian / Skripsi</option>
                            <option value="Observasi / Ambil Data">Observasi / Ambil Data</option>
                            <option value="Magang">Magang</option>
                            <option value="Praktik Kerja Lapangan (PKL)">Praktik Kerja Lapangan (PKL)</option>
                            <option value="Uji Coba Produk">Uji Coba Produk</option>
                        </select>
                        <select id="filter-status" class="form-select form-select-sm text-secondary shadow-none" style="width: auto; min-width: 140px; border-radius: 6px;">
                            <option value="">Semua Status</option>
                            <option value="Draft">Draft</option>
                            <option value="Menunggu">Menunggu</option>
                            <option value="Perlu Perbaikan">Perlu Perbaikan</option>
                            <option value="Disetujui">Disetujui</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                        <div class="d-flex align-items-center gap-2 ms-md-2 mt-2 mt-md-0">
                            <span class="small text-muted fw-medium">Cari:</span>
                            <div style="position: relative;">
                                <input type="text" id="dt-search" class="form-control form-control-sm shadow-none" style="border-radius: 6px; width: 180px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive mt-3">
                <table id="tabelRiwayat" class="table-minimalist">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%;">NO</th>
                            <th>JENIS PERMOHONAN</th>
                            <th>NAMA</th>
                            <th class="text-center">TANGGAL DIAJUKAN</th>
                            <th class="text-center">PERIODE</th>
                            <th class="text-center">STATUS</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($permohonan)): ?>
                            <?php 
                                $bln = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                                $no = 1; 
                                foreach($permohonan as $p): 
                                    $tglAju = date('j', strtotime($p['created_at'])) . ' ' . $bln[(int)date('m', strtotime($p['created_at']))] . ' ' . date('Y', strtotime($p['created_at']));
                                    $tglMulai = date('j', strtotime($p['tgl_mulai'])) . ' ' . $bln[(int)date('m', strtotime($p['tgl_mulai']))] . ' ' . date('Y', strtotime($p['tgl_mulai']));
                                    $tglSelesai = date('j', strtotime($p['tgl_selesai'])) . ' ' . $bln[(int)date('m', strtotime($p['tgl_selesai']))] . ' ' . date('Y', strtotime($p['tgl_selesai']));
                                    
                                    $layanan = '';
                                    if($p['id_jenis_permohonan'] == 1)      $layanan = 'Penelitian Skripsi / TA';
                                    elseif($p['id_jenis_permohonan'] == 2)  $layanan = 'Observasi / Ambil Data';
                                    elseif($p['id_jenis_permohonan'] == 3)  $layanan = 'Magang';
                                    elseif($p['id_jenis_permohonan'] == 5)  $layanan = 'Praktik Kerja Lapangan';
                                    elseif($p['id_jenis_permohonan'] == 4)  $layanan = 'Uji Coba Produk';
                                    
                                    // Tentukan nama mahasiswa/ketua
                                    $namaPemohon = $p['nama_ketua'] ?? session()->get('nama') ?? session()->get('nama_lengkap') ?? '-';
                                    
                                    // Tentukan badge status
                                    $badgeClass = 'pending';
                                    $statusText = 'Menunggu';
                                    if ($p['posting_data'] == 'draft') {
                                        $badgeClass = 'draft'; $statusText = 'Draft';
                                    } elseif ($p['status_persetujuan'] == 'DITOLAK') {
                                        $badgeClass = 'rejected'; $statusText = 'Ditolak';
                                    } elseif ($p['status_persetujuan'] == 'PERBAIKAN_BERKAS') {
                                        $badgeClass = 'pending'; $statusText = 'Perbaikan';
                                    } elseif (!empty($p['status_penempatan']) && $p['status_penempatan'] == 'SELESAI') {
                                        $badgeClass = 'success'; $statusText = 'Selesai';
                                    } elseif (!empty($p['status_penempatan']) && $p['status_penempatan'] != 'MENUNGGU' && $p['status_penempatan'] != 'DIBATALKAN' && $p['status_penempatan'] != '0') {
                                        $badgeClass = 'approved'; $statusText = 'Disetujui';
                                    }
                            ?>
                            <tr>
                                <td class="text-center fw-medium"><?= $no++ ?></td>
                                <td>
                                    <span class="fw-semibold text-dark"><?= $layanan ?></span>
                                </td>
                                <td>
                                    <span class="text-dark"><?= $namaPemohon ?></span>
                                </td>
                                <td class="text-center"><?= $tglAju ?></td>
                                <td class="text-center"><?= $tglMulai ?> s.d <?= $tglSelesai ?></td>
                                <td class="text-center">
                                    <span class="badge-solid <?= $badgeClass ?>"><?= $statusText ?></span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <?php if ($p['posting_data'] == 'draft' || $p['status_persetujuan'] == 'PERBAIKAN_BERKAS'): ?>
                                            <a href="<?= base_url('mahasiswa/permohonan') ?>" class="action-btn edit" title="Edit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($p['posting_data'] != 'draft'): ?>
                                            <button type="button" class="action-btn detail" onclick="showDetail(<?= $p['id_permohonan_magang'] ?>, this)" title="Detail">
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                        <?php endif; ?>
                                        <button type="button" class="action-btn history" onclick="showLogRiwayat(<?= $p['id_permohonan_magang'] ?>)" title="Riwayat">
                                            <i class="bi bi-clock-history"></i>
                                        </button>
                                        <?php if ($p['posting_data'] == 'draft'): ?>
                                            <button type="button" class="action-btn delete" onclick="confirmBatalkan(<?= $p['id_permohonan_magang'] ?>, '<?= $p['posting_data'] ?>')" title="Hapus">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div> <!-- /.table-responsive -->

            <!-- Custom Pagination Footer -->
            <div class="custom-dt-footer" id="customPagination">
                <span class="dt-info-text" id="dtInfoText">Menampilkan 0 data</span>
                <div class="dt-page-buttons" id="dtPageButtons"></div>
            </div>

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
                <h6 class="modal-title fw-bold text-dark m-0"><i class="bi bi-clock-history me-2 text-info"></i> Riwayat Proses</h6>
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
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- DataTables Core + Bootstrap 5 -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#tabelRiwayat').DataTable({
            paging:       true,
            lengthChange: false,
            searching:    true,
            ordering:     true,
            info:         false,
            autoWidth:    false,
            pageLength:   10,
            order:        [[0, 'asc']],
            dom:          'rt',   // Hanya render tabel, pagination kita handle sendiri
            language: {
                emptyTable:  '<div class="py-4 text-muted"><i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>Belum ada pengajuan permohonan.</div>',
                zeroRecords: '<div class="py-4 text-muted"><i class="bi bi-search fs-2 d-block mb-2 text-secondary"></i>Tidak ditemukan data yang sesuai.</div>'
            },
            columnDefs: [
                { orderable: false, targets: 6 }
            ]
        });

        // === Custom Pagination ===
        function renderPagination() {
            var info = table.page.info();
            var start = info.start + 1;
            var end   = info.end;
            var total = info.recordsDisplay;
            var page  = info.page;
            var pages = info.pages;

            // Info text
            if (total === 0) {
                $('#dtInfoText').text('Showing 0 to 0 of 0 entries');
            } else {
                $('#dtInfoText').text('Showing ' + start + ' to ' + end + ' of ' + total + ' entries');
            }

            // Page buttons
            var html = '';
            // Prev
            html += '<span class="dt-page-btn ' + (page === 0 ? 'disabled' : '') + '" data-page="prev">Previous</span>';
            // Page numbers
            for (var i = 0; i < pages; i++) {
                html += '<span class="dt-page-btn ' + (i === page ? 'active' : '') + '" data-page="' + i + '">' + (i + 1) + '</span>';
            }
            // Next
            html += '<span class="dt-page-btn ' + (page >= pages - 1 ? 'disabled' : '') + '" data-page="next">Next</span>';
            $('#dtPageButtons').html(html);
        }

        // Event: klik tombol halaman
        $('#dtPageButtons').on('click', '.dt-page-btn:not(.disabled)', function() {
            var p = $(this).data('page');
            if (p === 'prev') table.page('previous').draw('page');
            else if (p === 'next') table.page('next').draw('page');
            else table.page(parseInt(p)).draw('page');
        });

        // Render pagination setiap tabel berubah
        table.on('draw', function() { renderPagination(); });
        renderPagination(); // initial

        // Show entries
        $('#dt-length').on('change', function() {
            table.page.len(parseInt(this.value)).draw();
        });

        // Search
        $('#dt-search').on('keyup', function() {
            table.search(this.value).draw();
        });

        // Filter Jenis (kolom 1)
        $('#filter-jenis').on('change', function() {
            var val = this.value;
            table.column(1).search(val ? $.fn.dataTable.util.escapeRegex(val) : '', true, false).draw();
        });

        // Filter Status (kolom 5)
        $('#filter-status').on('change', function() {
            var val = this.value;
            table.column(5).search(val ? $.fn.dataTable.util.escapeRegex(val) : '', true, false).draw();
        });
    });

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
                                <span class="v-timeline-date">${log.tanggal_format}</span>
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
            text: "Anda akan " + actionText + "? Data yang dibatalkan tidak dapat dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Simpan',
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