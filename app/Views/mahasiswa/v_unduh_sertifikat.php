<?= $this->extend('layout/mahasiswa') ?>


<?= $this->section('extra_css') ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<style>
    /* Paksa scrollbar selalu tampil agar tidak goyang */
    html { overflow-y: scroll; }
    /* Cegah halaman loncat saat modal terbuka */
    body.modal-open { padding-right: 0 !important; overflow: auto !important; }

    /* Sembunyikan elemen bawaan DataTables */
    .dataTables_filter, .dataTables_length, .dataTables_info, .dataTables_paginate { display: none !important; }
    table.dataTable, table.dataTable *, .dataTables_wrapper, .dataTables_wrapper * { transition: none !important; animation: none !important; }
    table.dataTable { border-collapse: collapse !important; }
    /* Custom Pagination Footer */
    .custom-dt-footer { display: flex; align-items: center; justify-content: space-between; padding: 14px 4px 0; margin-top: 8px; border-top: 1px solid #f1f5f9; }
    .custom-dt-footer .dt-info-text { font-size: 0.8rem; color: #94a3b8; font-weight: 500; }
    .custom-dt-footer .dt-page-buttons { display: flex; align-items: center; gap: 4px; }
    .custom-dt-footer .dt-page-btn { display: inline-flex; align-items: center; justify-content: center; min-width: 30px; height: 30px; padding: 0 8px; font-size: 0.78rem; font-weight: 600; color: #64748b; background: #fff; border: 1px solid #e2e8f0; border-radius: 6px; cursor: pointer; text-decoration: none; }
    .custom-dt-footer .dt-page-btn:hover { background: #f8fafc; border-color: #cbd5e1; color: #334155; }
    .custom-dt-footer .dt-page-btn.active { background: #13325B; border-color: #13325B; color: #fff; }
    .custom-dt-footer .dt-page-btn.disabled { opacity: 0.35; cursor: default; pointer-events: none; }

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
    .table-minimalist thead th:first-child { border-top-left-radius: 8px; border-bottom-left-radius: 8px; }
    .table-minimalist thead th:last-child { border-top-right-radius: 8px; border-bottom-right-radius: 8px; }
    .table-minimalist tbody tr { background: #ffffff; transition: all 0.2s ease; }
    .table-minimalist tbody tr:hover { background: #fcfcfc; transform: translateY(-1px); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
    .table-minimalist tbody td { border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; padding: 12px 16px; vertical-align: middle; font-size: 0.85rem; color: #475569; }
    .table-minimalist tbody td:first-child { border-left: 1px solid #f1f5f9; border-top-left-radius: 8px; border-bottom-left-radius: 8px; }
    .table-minimalist tbody td:last-child { border-right: 1px solid #f1f5f9; border-top-right-radius: 8px; border-bottom-right-radius: 8px; }

    /* Solid Badges */
    .badge-solid {
        display: inline-block; padding: 5px 12px;
        font-size: 0.72rem; font-weight: 700; border-radius: 6px;
        text-transform: uppercase; letter-spacing: 0.3px; color: #fff;
    }
    .badge-solid.success { background: #10b981; }
    .badge-solid.pending { background: #f59e0b; }
    
    /* Action Buttons */
    .action-btn {
        width: 34px; height: 34px;
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: 6px; border: none; color: #fff; background: #3b82f6;
        transition: opacity 0.2s; text-decoration: none;
    }
    .action-btn:hover { opacity: 0.85; color: #fff; }
    .action-btn.disabled { background: #cbd5e1; cursor: not-allowed; }
    .action-btn.disabled:hover { opacity: 1; }
    
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
    @media (max-width: 767.98px) {
        .page-header-stats { flex-direction: column; }
        .page-header-top { flex-direction: column; align-items: flex-start; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<a href="<?= base_url('mahasiswa/dashboard') ?>" class="text-decoration-none text-primary">Dashboard</a> <span class="mx-2 text-muted">/</span> <span class="text-dark fw-medium">Unduh Dokumen</span>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php $documentGroups = $documentGroups ?? []; ?>
<?php $listJenis = $list_jenis ?? []; ?>
<div class="mb-4">
    <?php $availableDocuments = 0; ?>
    <?php foreach ($documentGroups as $group): ?>
        <?php foreach ($group['docs'] as $doc): ?>
            <?php if (!empty($doc)): ?>
                <?php $availableDocuments++; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>

    <div class="mb-4">
        <h3 class="fw-semibold mb-1 text-dark">Unduh Dokumen</h3>
        <p class="text-muted mb-0">Akses surat dan sertifikat resmi yang diterbitkan selama proses kegiatan akademik Anda.</p>
    </div>
</div>

<div class="card-minimalist shadow-sm">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-3 border-bottom gap-3">
        <div class="d-flex align-items-center gap-2">
            <span class="small text-muted fw-semibold"><i class="bi bi-list-ul me-1"></i>Daftar kegiatan</span>
            <span class="badge rounded-pill text-bg-light border" id="count-docs"><?= count($documentGroups) ?> kegiatan</span>
        </div>

        <div class="d-flex flex-wrap gap-2 flex-grow-1 flex-md-grow-0">
            <div class="input-group input-group-sm" style="width: 220px;">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" id="search-doc" class="form-control border-start-0 ps-0 shadow-none" placeholder="Cari kegiatan...">
            </div>
            <select id="filter-jenis" class="form-select form-select-sm fw-semibold text-secondary shadow-none" style="width: 190px;">
                <option value="">-- Semua Jenis --</option>
                <?php foreach ($listJenis as $jenis): ?>
                    <option value="<?= esc($jenis['jenis_permohonan']) ?>"><?= esc($jenis['jenis_permohonan']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="table-responsive mt-3" id="tabelDokumenContainer" style="opacity: 0; transition: opacity 0.4s ease;">
        <table id="tabelDokumen" class="table-minimalist">
            <thead>
                <tr>
                    <th class="text-center" style="width: 5%;">No</th>
                    <th style="width: 20%;">Jenis Permohonan</th>
                    <th class="text-center" style="width: 25%;">Periode</th>
                    <th class="text-center" style="width: 25%;">Bidang</th>
                    <th class="text-center" style="width: 15%;">Ketersediaan</th>
                    <th class="text-center" style="width: 10%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($documentGroups)): ?>
                    <?php foreach ($documentGroups as $idx => $group): ?>
                        <?php $hasDocs = !empty(array_filter($group['docs'], fn($doc) => !empty($doc))); ?>
                        <tr class="doc-row">
                            <td class="text-center fw-medium"><?= $idx + 1 ?></td>
                            <td>
                                <span class="fw-semibold text-dark d-block"><?= esc($group['jenis_permohonan']) ?></span>
                            </td>
                            <td class="text-center text-muted fw-medium" style="white-space: nowrap;">
                                <?= !empty($group['tgl_mulai']) ? tgl_indo($group['tgl_mulai']) : '-' ?> s.d <?= !empty($group['tgl_selesai']) ? tgl_indo($group['tgl_selesai']) : '-' ?>
                            </td>
                            <td class="text-center text-muted fw-medium" style="white-space: nowrap;"><?= esc($group['bidang'] ?? '-') ?></td>
                            <td class="text-center">
                                <?php 
                                    $jmlDocs = count(array_filter($group['docs'], fn($doc) => !empty($doc)));
                                ?>
                                <?php if ($jmlDocs === 0): ?>
                                    <span class="badge-solid pending" style="background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0;">Belum Ada</span>
                                <?php elseif ($jmlDocs === 3): ?>
                                    <span class="badge-solid success">Lengkap</span>
                                <?php else: ?>
                                    <span class="badge-solid" style="background: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd;"><?= $jmlDocs ?> Dokumen</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <button type="button"
                                        class="action-btn detail"
                                        data-bs-toggle="modal"
                                        data-bs-target="#docModal"
                                        data-group-id="<?= esc($group['id_persetujuan_magang']) ?>"
                                        data-docs='<?= json_encode($group['docs']) ?>'
                                        title="Lihat Dokumen Kegiatan">
                                        <i class="bi <?= $hasDocs ? 'bi-folder2-open' : 'bi-folder' ?>"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Custom Pagination Footer -->
    <div class="custom-dt-footer" id="docPagination">
        <span class="dt-info-text" id="docInfoText">Menampilkan 0 data</span>
        <div class="dt-page-buttons" id="docPageButtons"></div>
    </div>
</div>

<div class="modal fade" id="docModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-sm">
            <div class="modal-header border-0 pb-2">
                <h5 class="modal-title fw-bold text-dark" id="docModalLabel">Dokumen Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-1" id="docModalBody"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    var table = $('#tabelDokumen').DataTable({
        paging: true, lengthChange: false, searching: true, ordering: true,
        info: false, autoWidth: false, pageLength: 10,
        order: [[0, 'asc']],
        dom: 'rt',
        language: { 
            emptyTable: `
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
                        Belum ada dokumen resmi yang diterbitkan untuk akun Anda.
                    </p>
                </div>
            `,
            zeroRecords: 'Tidak ditemukan data yang sesuai.' 
        },
        initComplete: function(settings, json) {
            $('#tabelDokumenContainer').css('opacity', '1');
        },
        columnDefs: [{ orderable: false, targets: [5] }]
    });

    // Custom pagination
    function renderPagination() {
        var info = table.page.info();
        var start = info.start + 1, end = info.end, total = info.recordsDisplay, page = info.page, pages = info.pages;
        $('#docInfoText').text(total === 0 ? 'Tidak ada data' : 'Menampilkan ' + start + ' - ' + end + ' dari ' + total + ' data');
        var html = '<span class="dt-page-btn ' + (page === 0 ? 'disabled' : '') + '" data-page="prev">&lsaquo;</span>';
        for (var i = 0; i < pages; i++) { html += '<span class="dt-page-btn ' + (i === page ? 'active' : '') + '" data-page="' + i + '">' + (i+1) + '</span>'; }
        html += '<span class="dt-page-btn ' + (page >= pages-1 ? 'disabled' : '') + '" data-page="next">&rsaquo;</span>';
        $('#docPageButtons').html(html);
        $('#count-docs').text(total + ' kegiatan');
    }
    $('#docPageButtons').on('click', '.dt-page-btn:not(.disabled)', function() {
        var p = $(this).data('page');
        if (p === 'prev') table.page('previous').draw('page');
        else if (p === 'next') table.page('next').draw('page');
        else table.page(parseInt(p)).draw('page');
    });
    table.on('draw', function() { renderPagination(); });
    renderPagination();

    // Search
    $('#search-doc').on('keyup', function() { table.search(this.value).draw(); });

    // Filter Jenis (kolom index 1, pencarian standar akan otomatis membuang tag HTML)
    $('#filter-jenis').on('change', function() {
        table.column(1).search(this.value).draw();
    });

    // Modal Handle
    const modalTitle = document.getElementById('docModalLabel');
    const modalBody = document.getElementById('docModalBody');

    document.querySelectorAll('[data-bs-target="#docModal"]').forEach(button => {
        button.addEventListener('click', function () {
            const docs = JSON.parse(this.getAttribute('data-docs') || '{}');
            const baseUrl = '<?= base_url() ?>';
            let html = '';

            const renderDoc = (label, doc, iconClass) => {
                if (!doc) return '';

                const urlPreview = baseUrl + 'mahasiswa/sertifikat/file/' + doc.id_file_proses_magang;
                const urlDownload = urlPreview + '?action=download';

                return `
                    <div class="border rounded-3 p-3 mb-3">
                        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
                            <div class="d-flex align-items-center gap-3">
                                <div class="doc-icon ${iconClass}"><i class="bi ${doc.id_file == 10 ? 'bi-award-fill' : (doc.id_file == 9 ? 'bi-file-earmark-check-fill' : 'bi-envelope-paper-fill')}"></i></div>
                                <div>
                                    <div class="fw-bold text-dark">${label}</div>
                                    <small class="text-muted">${doc.nama_file || doc.nama_file_master || 'Dokumen'}</small>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="${urlPreview}" target="_blank" class="btn btn-sm btn-outline-primary px-3"><i class="bi bi-eye"></i></a>
                                <a href="${urlDownload}" class="btn btn-sm btn-primary px-3"><i class="bi bi-download"></i></a>
                            </div>
                        </div>
                    </div>
                `;
            };

            html += renderDoc('Surat Penerimaan', docs.surat_penerimaan, 'bg-primary bg-opacity-10 text-primary');
            html += renderDoc('Surat Selesai Kegiatan', docs.surat_selesai, 'bg-success bg-opacity-10 text-success');
            html += renderDoc('Sertifikat Piagam Kelulusan', docs.piagam, 'bg-warning bg-opacity-10 text-warning');

            modalTitle.textContent = 'Dokumen Kegiatan';
            modalBody.innerHTML = html || '<div class="text-center text-muted py-4">Belum ada dokumen yang diterbitkan untuk kegiatan ini.</div>';
        });
    });

});
</script>
<?= $this->endSection() ?>
