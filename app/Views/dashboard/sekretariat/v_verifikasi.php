<?php
/**
 * ============================================================
 * Kode      : v_verifikasi.php
 * Path      : Views/dashboard/sekretariat/v_verifikasi.php
 * Deskripsi : View halaman daftar permohonan untuk verifikasi
 *             berkas dalam bentuk tabel. Terintegrasi dengan 
 *             modal verifikasi + disposisi.
 * ============================================================
 */
?>

<?= $this->extend('layout/L_master') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Flash Messages (dipertahankan untuk fallback) -->
<?php if (session()->getFlashdata('success')) : ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle mr-2"></i>
    <?= session()->getFlashdata('success') ?>
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
<?php endif; ?>

<!-- Search & Filter -->
<div class="verifikasi-search-bar">
    <div style="position:relative; flex:1; max-width:450px;">
        <i class="fas fa-search" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#98a2b3;"></i>
        <input type="text" id="searchVerifikasi" placeholder="Cari nama/ universitas..." style="width:100%;">
    </div>
    <select id="filterStatus">
        <option value="">Semua Status</option>
        <option value="MENUNGGU">Menunggu</option>
        <option value="PERBAIKAN_BERKAS">Perbaikan Berkas</option>
        <option value="DISETUJUI">Disetujui</option>
    </select>
</div>

<!-- Verifikasi Table -->
<div class="table-responsive">
    <table class="riwayat-table" id="tabelVerifikasi" width="100%">
        <thead>
            <tr>
                <th width="5%" class="text-center">NO</th>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
                <th>Instansi</th>
                <th>Tanggal Pengajuan</th>
                <th class="text-center">Status Persetujuan</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($permohonan)) : ?>
                <?php $no = 1; foreach ($permohonan as $row) : ?>
                <?php
                    $status = $row->status_persetujuan ?? 'MENUNGGU';
                    
                    if ($status == 'DISETUJUI') {
                        $badgeClass = 'disetujui';
                        $statusText = 'Disetujui';
                    } elseif ($status == 'PERBAIKAN_BERKAS') {
                        $badgeClass = 'ditolak';
                        $statusText = 'Perbaikan Berkas';
                    } else {
                        $badgeClass = 'menunggu-verifikasi';
                        $statusText = 'Menunggu';
                    }
                ?>
                <tr data-filter-status="<?= $status ?>">
                    <td class="text-center"><?= $no++ ?></td>
                    <td><strong><?= esc($row->nama_mahasiswa ?? '-') ?></strong></td>
                    <td><?= esc($row->nim ?? '-') ?></td>
                    <td><?= esc($row->instansi_pendidikan ?? '-') ?></td>
                    <td><?= !empty($row->tgl_pengajuan) ? date('d M Y', strtotime($row->tgl_pengajuan)) : '-' ?></td>
                    <td class="text-center">
                        <span class="status-badge <?= $badgeClass ?>"><?= $statusText ?></span>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center" style="gap:4px;">
                            <!-- Ikon Pensil (Edit/Verifikasi) -->
                            <button type="button" 
                                    class="riwayat-action-btn btn-verifikasi-modal" 
                                    title="Verifikasi Permohonan"
                                    style="display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; border:none; background:#EFF6FF; color:#2563EB; border-radius:6px;"
                                    data-id="<?= $row->id_permohonan_magang ?>">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Tempat memuat Modal Verifikasi -->
<div id="modalContainer"></div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    var table = $('#tabelVerifikasi').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
        },
        "order": [[4, "asc"]], // Urutkan berdasarkan tanggal pengajuan ASC
        "pageLength": 10,
        "dom": '<"d-flex justify-content-between align-items-center mb-3"<""l><""f>>rt<"d-flex justify-content-between align-items-center mt-3"<""i><""p>>'
    });

    // Custom search
    $('#searchVerifikasi').on('keyup', function() {
        table.search(this.value).draw();
    });

    // Default Filter ke "Menunggu" jika tidak ada yang dipilih dari sesi dll
    $('#filterStatus').val('MENUNGGU');

    // Custom filter berdasarkan data-attribute
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        var filterVal = $('#filterStatus').val();
        if (!filterVal) return true;
        var row = table.row(dataIndex).node();
        var rowStatus = $(row).data('filter-status');
        return rowStatus === filterVal;
    });

    $('#filterStatus').on('change', function() {
        table.draw();
    });

    // Trigger awal untuk default filter
    table.draw();

    // Hide default search
    $('#tabelVerifikasi_filter').hide();

    // Handle klik tombol pensil (Buka Modal Verifikasi)
    $(document).on('click', '.btn-verifikasi-modal', function() {
        var id = $(this).data('id');
        
        // Tampilkan loading jika perlu
        $('#modalContainer').html('<div class="text-center my-4"><i class="fas fa-spinner fa-spin fa-2x"></i> Memuat data...</div>');
        
        $.ajax({
            url: "<?= base_url('sekretariat/verifikasi/detailModal') ?>/" + id,
            type: "GET",
            success: function(response) {
                $('#modalContainer').html(response);
                $('#modalVerifikasi').modal('show');
            },
            error: function() {
                $('#modalContainer').html('');
                Swal.fire('Error!', 'Gagal memuat detail permohonan.', 'error');
            }
        });
    });

    // Submit form verifikasi dalam modal via AJAX
    $(document).on('submit', '#formVerifikasiModal', function(e) {
        e.preventDefault();
        
        var form = $(this);
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            success: function(response) {
                $('#modalVerifikasi').modal('hide');
                if (response.success) {
                    Swal.fire('Berhasil!', response.message, 'success').then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire('Gagal!', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error!', 'Terjadi kesalahan sistem saat menyimpan keputusan.', 'error');
            }
        });
    });

    // Set file validitas toggle button classes in modal
    $(document).on('click', '.btn-validasi-file', function() {
        var inputHidden = $(this).siblings('input[type="hidden"]');
        var value = $(this).data('value');
        
        inputHidden.val(value);
        
        // reset button classes in this group
        $(this).siblings().removeClass('btn-success btn-danger').addClass('btn-outline-secondary');
        $(this).removeClass('btn-outline-secondary');
        
        if(value === 'VALID') {
            $(this).addClass('btn-success');
        } else {
            $(this).addClass('btn-danger');
        }
    });
});
</script>
<?= $this->endSection() ?>
