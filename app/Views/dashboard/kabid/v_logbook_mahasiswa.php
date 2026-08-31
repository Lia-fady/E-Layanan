<?= $this->extend('layout/L_master_kabid') ?>

<?= $this->section('content') ?>

<div id="sectionList">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 style="font-weight:700; color:#1B2559; margin-bottom:4px;">Logbook Kegiatan</h5>
        <p style="color:#667085; font-size:0.85rem; margin:0;">
            Tinjau dan setujui logbook kegiatan harian.
        </p>
    </div>
</div>



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
                <!-- Filter Jenis Permohonan dihapus -->                <select id="filterStatus" class="form-control form-control-sm custom-select custom-select-sm" style="width: 140px;">
                    <option value="">Semua Status</option>
                    <option value="Disetujui">Disetujui</option>
                    <option value="Berjalan">Berjalan</option>
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
                        <th width="20%" class="text-center align-middle">Nama</th>
                        <th width="25%" class="text-center align-middle">Instansi Pendidikan</th>
                        <th width="20%" class="text-center align-middle">Periode Kegiatan</th>
                        <th width="15%" class="text-center align-middle">Status</th>
                        <th width="15%" class="text-center align-middle">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($mahasiswa)): ?>
                        <?php $no = 1; foreach ($mahasiswa as $mhs): ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td>
                                <strong><?= esc($mhs->nama_mahasiswa) ?></strong>
                            </td>
                            <td>
                                <?= esc($mhs->instansi_pendidikan) ?>
                            </td>
                            <td class="text-center">
                                <?php 
                                    $bln = [1=>'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
                                    $tglM = date('j', strtotime($mhs->tgl_mulai)) . ' ' . $bln[(int)date('m', strtotime($mhs->tgl_mulai))] . ' ' . date('y', strtotime($mhs->tgl_mulai));
                                    $tglS = date('j', strtotime($mhs->tgl_selesai)) . ' ' . $bln[(int)date('m', strtotime($mhs->tgl_selesai))] . ' ' . date('y', strtotime($mhs->tgl_selesai));
                                    echo $tglM . ' -<br>' . $tglS;
                                ?>
                            </td>
                            <td>
                                <?php if (($mhs->status_penempatan ?? '') == 'DIBATALKAN'): ?>
                                    <span class="badge badge-danger">Dibatalkan</span>
                                <?php elseif (($mhs->status_penempatan ?? '') == 'SELESAI'): ?>
                                    <span class="badge badge-success">Selesai</span>
                                <?php elseif (($mhs->status_penempatan ?? '') == 'BERJALAN'): ?>
                                    <span class="badge badge-primary">Berjalan</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary"><?= esc($mhs->status_penempatan ?? '-') ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-info btn-detail-logbook" data-id="<?= $mhs->id_penempatan_magang ?>" title="Lihat Logbook">
                                    <i class="fas fa-book-open"></i> Lihat Logbook
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
        searching: true, // Diaktifkan agar custom search berfungsi
        paging: true,
        info: true,
        dom: 'rt<"row mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>' // Custom DOM for aligned pagination
    });

    // Custom Search Nama / NIM
    $('#searchMahasiswa').on('keyup', function() {
        table.column(1).search(this.value).draw();
    });

    // Custom Length Menu
    $('#customLength').on('change', function() {
        table.page.len(this.value).draw();
    });

    // Custom Filter Status
    $('#filterStatus').on('change', function() {
        table.column(4).search(this.value).draw();
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
                Swal.fire('Error!', 'Gagal memuat logbook.', 'error');
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
<?= $this->endSection() ?>
