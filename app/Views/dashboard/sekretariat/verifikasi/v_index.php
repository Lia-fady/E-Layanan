<?php
/**
 * ============================================================
 * Kode      : index.php
 * Path      : Views/dashboard/sekretariat/verifikasi/index.php
 * Deskripsi : Layout utama halaman Verifikasi (Single Page).
 * ============================================================
 */
?>

<?= $this->extend('layout/L_master') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')) : ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle mr-2"></i>
    <?= session()->getFlashdata('success') ?>
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
<?php endif; ?>

<!-- Section Daftar Permohonan -->
<div id="sectionList">
    <?= $this->include('dashboard/sekretariat/verifikasi/v_list') ?>
</div>

<!-- Section Detail Permohonan -->
<div id="sectionDetail" style="display: none;">
    <!-- Container untuk menampung HTML hasil AJAX -->
    <div id="detailContainer"></div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Inisialisasi DataTables
    var table = $('#tabelVerifikasi').DataTable({
        "language": {
            "decimal": "",
            "emptyTable": "Tidak ada data yang tersedia",
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
            "infoFiltered": "(disaring dari _MAX_ total entri)",
            "lengthMenu": "Tampilkan _MENU_ entri",
            "loadingRecords": "Memuat...",
            "processing": "Memproses...",
            "search": "Cari:",
            "zeroRecords": "Tidak ditemukan data yang cocok",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Selanjutnya",
                "previous": "Sebelumnya"
            },
            "aria": {
                "sortAscending": ": aktifkan untuk mengurutkan kolom secara ascending",
                "sortDescending": ": aktifkan untuk mengurutkan kolom secara descending"
            }
        },
        "order": [[4, "asc"]],
        "pageLength": 10,
        "dom": '<"d-flex justify-content-between align-items-center mb-3"<""l><""f>>rt<"d-flex justify-content-between align-items-center mt-3"<""i><""p>>'
    });

    // Custom search
    $('#searchVerifikasi').on('keyup', function() {
        table.search(this.value).draw();
    });

    $('#filterStatus').val('');

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

    table.draw();
    $('#tabelVerifikasi_filter').hide();

    // Transisi Buka Detail
    $(document).on('click', '.btn-verifikasi-detail', function() {
        var id = $(this).data('id');
        
        $('#detailContainer').html('<div class="text-center my-4"><i class="fas fa-spinner fa-spin fa-2x"></i> Memuat detail permohonan...</div>');
        $('#sectionList').hide();
        $('#sectionDetail').show();
        
        $.ajax({
            url: "<?= base_url('sekretariat/verifikasi') ?>",
            type: "POST",
            data: {
                action: 'get_detail',
                id: id
            },
            success: function(response) {
                $('#detailContainer').html(response);
            },
            error: function() {
                $('#detailContainer').html('');
                $('#sectionDetail').hide();
                $('#sectionList').show();
                Swal.fire('Error!', 'Gagal memuat detail permohonan.', 'error');
            }
        });
    });

    // Transisi Kembali ke Daftar
    $(document).on('click', '#btnKembali', function() {
        $('#sectionDetail').hide();
        $('#detailContainer').html('');
        $('#sectionList').show();
    });

    // Submit form verifikasi via AJAX
    $(document).on('submit', '#formVerifikasiDetail', function(e) {
        e.preventDefault();
        
        var form = $(this);
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    Swal.fire('Berhasil!', response.message, 'success').then(() => {
                        window.location.reload(); // Reload halaman untuk update data tabel secara menyeluruh
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

    // Set file validitas toggle button classes in detail
    $(document).on('click', '.btn-validasi-file', function() {
        var inputHidden = $(this).siblings('input[type="hidden"]');
        var value = $(this).data('value');
        
        inputHidden.val(value);
        
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
