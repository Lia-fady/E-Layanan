<?php
/**
 * View untuk Index Upload Surat Penerimaan Magang (Kabid)
 */
?>
<?= $this->extend('layout/L_master_kabid') ?>

<?= $this->section('title') ?>
<?= esc($title) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div id="sectionList">

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')) : ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle mr-2"></i>
    <?= session()->getFlashdata('success') ?>
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')) : ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle mr-2"></i>
    <?= session()->getFlashdata('error') ?>
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 style="font-weight:700; color:#1B2559; margin-bottom:4px;">Daftar Dokumen Kegiatan</h5>
        <p style="color:#667085; font-size:0.85rem; margin:0;">
            Kelola dokumen pendukung seperti surat keterangan diterima dan sertifikat selesai kegiatan.
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
                    <option value="Berjalan">Berjalan</option>
                    <option value="Selesai">Selesai</option>
                </select>
                
                <div class="input-group input-group-sm" style="width: 200px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                    </div>
                    <input type="text" id="searchDokumen" class="form-control border-left-0 pl-0" placeholder="Cari Nama / NIM...">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-primary text-white">
                    <tr>
                        <th width="5%" class="text-center align-middle">No</th>
                        <th width="15%" class="text-center align-middle">Nama</th>
                        <th width="10%" class="text-center align-middle">NIM</th>
                        <th width="20%" class="text-center align-middle">Asal Instansi</th>
                        <th width="15%" class="text-center align-middle">Jenis Permohonan</th>
                        <th width="15%" class="text-center align-middle">Periode</th>
                        <th width="5%" class="text-center align-middle">Status</th>
                        <th width="15%" class="text-center align-middle">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($persetujuan)) : ?>
                        <?php $no = 1; foreach ($persetujuan as $p) : ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= esc($p->nama_mahasiswa ?? '-') ?></td>
                            <td><?= esc($p->nim ?? '-') ?></td>
                            <td>
                                <?= esc($p->instansi_pendidikan ?? '-') ?><br>
                                <small class="text-muted"><?= esc($p->prodi ?? '-') ?></small>
                            </td>
                            <td>
                                <span class="badge badge-info"><?= esc($p->jenis_permohonan ?? 'Belum Ditentukan') ?></span>
                            </td>
                            <td>
                                <?php
                                    $mulai = !empty($p->tgl_mulai) ? date('d M Y', strtotime($p->tgl_mulai)) : '-';
                                    $selesai = !empty($p->tgl_selesai) ? date('d M Y', strtotime($p->tgl_selesai)) : '-';
                                ?>
                                <?= $mulai ?> s/d <?= $selesai ?>
                            </td>
                            <td>
                                <?php if($p->status_penempatan == 'SELESAI'): ?>
                                    <span class="badge badge-success">Selesai</span>
                                <?php else: ?>
                                    <span class="badge badge-primary">Aktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-primary btn-kelola-dokumen" data-id="<?= $p->id_persetujuan_magang ?>" title="Kelola Dokumen">
                                    <i class="fas fa-upload mr-1"></i> Kelola Dokumen
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
    $('#searchDokumen').on('keyup', function() {
        table.column(1).search(this.value).draw();
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

    $(document).on('click', '.btn-kelola-dokumen', function(e) {
        e.preventDefault();
        var btn = $(this);
        var idPersetujuan = btn.data('id');
        var originalHtml = btn.html();
        
        // Ubah tombol menjadi loading state
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Memuat...');
        
        $.ajax({
            url: "<?= base_url('kabid/upload-dokumen') ?>",
            type: "POST",
            data: {
                action: 'get_detail',
                id: idPersetujuan
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
                Swal.fire('Error!', 'Gagal memuat form dokumen.', 'error');
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
