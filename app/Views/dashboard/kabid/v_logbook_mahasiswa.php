<?= $this->extend('layout/L_master_kabid') ?>

<?= $this->section('content') ?>

<div id="sectionList">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 style="font-weight:700; color:#1B2559; margin-bottom:4px;">Logbook Mahasiswa</h5>
        <p style="color:#667085; font-size:0.85rem; margin:0;">
            Pantau dan setujui catatan aktivitas harian mahasiswa di bidang Anda.
        </p>
    </div>
</div>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error'); ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="mb-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <span class="mr-2 text-muted" style="font-size: 0.88rem;">Tampilkan</span>
                <select id="customLength" class="form-control form-control-sm custom-select custom-select-sm" style="width: 65px;">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="ml-2 text-muted" style="font-size: 0.88rem;">entri</span>
            </div>
            
            <div class="d-flex align-items-center" style="gap: 10px;">
                <select id="filterJenisPermohonan" class="form-control form-control-sm custom-select custom-select-sm" style="width: 180px;">
                    <option value="">Semua Jenis</option>
                    <?php if (isset($list_jenis)): ?>
                        <?php foreach($list_jenis as $j): ?>
                            <option value="<?= esc($j['jenis_permohonan']) ?>">
                                <?= esc($j['jenis_permohonan']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>

                <select id="filterStatus" class="form-control form-control-sm custom-select custom-select-sm" style="width: 140px;">
                    <option value="">Semua Status</option>
                    <option value="Disetujui">Disetujui</option>
                    <option value="Sedang Berjalan">Sedang Berjalan</option>
                    <option value="Dibatalkan">Dibatalkan</option>
                </select>
                
                <div class="input-group input-group-sm" style="width: 200px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                    </div>
                    <input type="text" id="searchMahasiswa" class="form-control border-left-0 pl-0" placeholder="Cari Nama / NIM...">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-primary text-white">
                    <tr>
                        <th width="5%" class="text-center align-middle">No</th>
                        <th width="15%" class="text-center align-middle">NIM/NIS</th>
<th width="20%" class="text-center align-middle">Nama</th>
                        <th width="20%" class="text-center align-middle">Instansi Pendidikan</th>
                        <th width="15%" class="text-center align-middle">Jenis Permohonan</th>
                        <th width="15%" class="text-center align-middle">Periode</th>
                        <th width="10%" class="text-center align-middle">Status</th>
                        <th width="15%" class="text-center align-middle">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($mahasiswa)): ?>
                    <tr>
                        <td colspan="8" class="text-center">Belum ada data mahasiswa yang sesuai.</td>
                    </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($mahasiswa as $mhs): ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
<td class="text-center align-middle"><?= esc($mhs->nim ?? $mhs->nis ?? '-') ?></td>
                            <td>
                                <strong><?= esc($mhs->nama_mahasiswa) ?></strong>
                            </td>
                            <td>
                                <?= esc($mhs->instansi_pendidikan) ?><br>
                                <small class="text-muted"><?= esc($mhs->prodi) ?></small>
                            </td>
                            <td>
                                <span class="badge badge-info"><?= esc($mhs->jenis_permohonan ?? 'Belum Ditentukan') ?></span>
                            </td>
                            <td>
                                <?= date('d M Y', strtotime($mhs->tgl_mulai)) ?> s.d.<br>
                                <?= date('d M Y', strtotime($mhs->tgl_selesai)) ?>
                            </td>
                            <td>
                                <?php if (($mhs->status_penempatan ?? '') == 'DIBATALKAN'): ?>
                                    <span class="badge badge-danger">Dibatalkan</span>
                                <?php elseif (($mhs->status_penempatan ?? '') == 'SELESAI'): ?>
                                    <span class="badge badge-success">Disetujui</span>
                                <?php elseif (($mhs->status_penempatan ?? '') == 'BERJALAN'): ?>
                                    <span class="badge badge-primary">Sedang Berjalan</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary"><?= esc($mhs->status_penempatan ?? 'Tidak Diketahui') ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-info btn-detail-logbook" data-id="<?= $mhs->id_penempatan_magang ?>" title="Lihat & Approve Logbook">
                                    <i class="fas fa-book-open"></i> Logbook
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div> <!-- End sectionList -->

<div id="sectionDetail" style="display: none;">
    <div id="detailContainer"></div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    var table = $('#dataTable').DataTable({
        searching: true,
        paging: true,
        info: true,
        dom: 'rt<"row mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
    });

    // Custom Search Nama (index 2)
    $('#searchMahasiswa').on('keyup', function() {
        table.column(2).search(this.value).draw();
    });

    // Custom Length Menu
    $('#customLength').on('change', function() {
        table.page.len(this.value).draw();
    });

    // Custom Filter Jenis Permohonan
    $('#filterJenisPermohonan').on('change', function() {
        table.column(4).search(this.value).draw();
    });

    // Custom Filter Status
    $('#filterStatus').on('change', function() {
        table.column(6).search(this.value).draw();
    });

    $(document).on('click', '.btn-detail-logbook', function(e) {
        e.preventDefault();
        var btn = $(this);
        var idPenempatan = btn.data('id');
        var originalHtml = btn.html();
        
        // Ubah tombol menjadi loading state
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Memuat...');
        
        $.ajax({
            url: "<?= base_url('kabid/logbook') ?>",
            type: "POST",
            data: {
                action: 'get_detail',
                id: idPenempatan
            },
            success: function(response) {
                // Tampilkan hasil dan lakukan transisi
                $('#detailContainer').html(response);
                $('#sectionList').hide();
                $('#sectionDetail').fadeIn(300); // Transisi halus
                
                // Kembalikan tombol ke keadaan semula
                btn.prop('disabled', false).html(originalHtml);
            },
            error: function() {
                btn.prop('disabled', false).html(originalHtml);
                Swal.fire('Error!', 'Gagal memuat detail logbook.', 'error');
            }
        });
    });

    $(document).on('click', '#btnKembaliList', function() {
        $('#sectionDetail').hide();
        $('#detailContainer').html('');
        $('#sectionList').fadeIn(300);
    });
});
</script>
<style>
/* Compact table styling */
.table.dataTable tbody td,
.table.dataTable thead th {
    vertical-align: middle !important;
    padding: 0.45rem 0.65rem !important;
    text-align: center;
    font-size: 0.85rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
/* Left align Nama column */
.table.dataTable thead th:nth-child(3),
.table.dataTable tbody td:nth-child(3) {
    text-align: left;
    white-space: normal;
}
/* Column widths */
.table.dataTable thead th:nth-child(2),
.table.dataTable tbody td:nth-child(2) { width: 130px; }
.table.dataTable thead th:nth-child(3),
.table.dataTable tbody td:nth-child(3) { width: 200px; }
.table.dataTable thead th:last-child,
.table.dataTable tbody td:last-child { width: 150px; }
/* Ensure rows not tall */
.table.dataTable tbody tr { height: auto; }
/* Buttons inline */
.table.dataTable td:last-child .btn { margin-right: 0.3rem; }
.table.dataTable td:last-child { display: flex; justify-content: center; gap: 0.3rem; flex-wrap: nowrap; }
/* Existing pagination styles */
.dataTables_wrapper .pagination { margin: 0; }
.dataTables_wrapper .page-item.active .page-link { background-color: #0F172A; border-color: #0F172A; color: white; }
.dataTables_wrapper .page-link { color: #475569; border-radius: 4px; margin: 0 3px; border: 1px solid #E2E8F0; padding: 0.4rem 0.8rem; font-size: 0.85rem; }
.dataTables_wrapper .page-item.disabled .page-link { color: #94A3B8; background-color: #F8FAFC; }
.dataTables_wrapper .dataTables_info { color: #64748B !important; font-size: 0.9rem; padding-top: 0; }
.dataTables_wrapper > .d-flex { border-top: 1px solid #E2E8F0 !important; background-color: #F8FAFC; border-bottom-left-radius: 0.5rem; border-bottom-right-radius: 0.5rem; }
</style>
<?= $this->endSection() ?>
