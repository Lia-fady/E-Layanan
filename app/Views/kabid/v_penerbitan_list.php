<?= $this->extend('layout/L_master') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4" style="background-color: #f8fafc; min-height: 100vh;">
    <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
            <h5 class="font-weight-bold" style="color: #4a5568; font-size: 16px;">Daftar Mahasiswa (Persetujuan Magang)</h5>
            <hr style="border-color: #e2e8f0; margin-top: 15px; margin-bottom: 0;">
        </div>
        <div class="card-body px-4 py-4">
            <div class="table-responsive">
                <table id="tabelPenerbitan" class="table table-bordered table-hover w-100" style="border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">
                    <thead style="background-color: #f8fafc; color: #4a5568; font-size: 14px;">
                        <tr>
                            <th class="text-center align-middle" style="width: 50px; padding: 15px; font-weight: 600;">No</th>
                            <th class="align-middle" style="padding: 15px; font-weight: 600;">Nama Mahasiswa</th>
                            <th class="align-middle" style="padding: 15px; font-weight: 600;">NIM</th>
                            <th class="align-middle" style="padding: 15px; font-weight: 600;">Asal Kampus / Prodi</th>
                            <th class="align-middle" style="padding: 15px; font-weight: 600;">Periode Magang</th>
                            <th class="text-center align-middle" style="width: 140px; padding: 15px; font-weight: 600;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($mahasiswa)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data mahasiswa.</td>
                        </tr>
                        <?php else: ?>
                            <?php $no = 1; foreach($mahasiswa as $mhs): ?>
                            <tr>
                                <td class="text-center align-middle" style="color: #64748b; font-size: 14px; padding: 15px;"><?= $no++ ?></td>
                                <td class="align-middle" style="color: #475569; font-size: 14px; padding: 15px;"><?= esc($mhs['nama_mahasiswa']) ?></td>
                                <td class="align-middle" style="color: #64748b; font-size: 14px; padding: 15px;"><?= esc($mhs['nim']) ?></td>
                                <td class="align-middle" style="padding: 15px;">
                                    <div style="color: #475569; font-size: 14px;"><?= esc($mhs['universitas']) ?></div>
                                    <div style="color: #94a3b8; font-size: 12px;"><?= esc($mhs['prodi']) ?></div>
                                </td>
                                <td class="align-middle" style="color: #64748b; font-size: 14px; padding: 15px;">
                                    <?php 
                                        if(!empty($mhs['tgl_mulai']) && !empty($mhs['tgl_selesai'])) {
                                            echo date('d M Y', strtotime($mhs['tgl_mulai'])) . ' s/d ' . date('d M Y', strtotime($mhs['tgl_selesai']));
                                        } else {
                                            echo '-';
                                        }
                                    ?>
                                </td>
                                <td class="text-center align-middle" style="padding: 15px;">
                                    <a href="<?= base_url('sekretariat/penerbitan-dokumen/detail/' . $mhs['id_persetujuan_magang']) ?>" class="btn btn-sm" style="background-color: #4a90e2; color: #fff; font-size: 13px; font-weight: 500; padding: 6px 14px; border-radius: 4px; box-shadow: 0 2px 4px rgba(74,144,226,0.2);">
                                        <i class="fas fa-file-upload mr-1"></i> Upload Surat
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- Jika belum ada datatable diload global, pastikan diload atau asumsikan sudah ada -->
<script>
    $(document).ready(function() {
        if ($.fn.DataTable) {
            $('#tabelPenerbitan').DataTable({
                "language": {
                    "lengthMenu": "Show _MENU_ entries",
                    "search": "Search:",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "Showing 0 to 0 of 0 entries",
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": "Next",
                        "previous": "Previous"
                    }
                },
                "dom": '<"row mb-3"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                       '<"row"<"col-sm-12"tr>>' +
                       '<"row mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                "pageLength": 10,
                "ordering": true,
                "columnDefs": [
                    { "orderable": false, "targets": [5] } // kolom aksi tidak usah diorder
                ]
            });
        }
    });
</script>
<style>
    /* Styling for datatable matching the photo */
    .dataTables_wrapper .dataTables_length select {
        border-radius: 4px;
        border: 1px solid #cbd5e1;
        padding: 4px;
        outline: none;
    }
    .dataTables_wrapper .dataTables_filter input {
        border-radius: 4px;
        border: 1px solid #cbd5e1;
        padding: 4px 8px;
        margin-left: 0.5em;
        outline: none;
    }
    table.dataTable thead th, table.dataTable thead td {
        border-bottom: 1px solid #e2e8f0;
    }
    table.dataTable.no-footer {
        border-bottom: 1px solid #e2e8f0;
    }
    .dataTables_wrapper .dataTables_info {
        color: #94a3b8;
        font-size: 13px;
        padding-top: 0.85em;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.4em 0.8em;
        margin-left: 2px;
        border-radius: 4px;
        border: 1px solid #e2e8f0;
        color: #64748b !important;
        cursor: pointer;
        background: #fff;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current, 
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: #4a90e2 !important;
        color: white !important;
        border: 1px solid #4a90e2;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.current) {
        background: #f1f5f9;
        color: #475569 !important;
    }
</style>
<?= $this->endSection() ?>
