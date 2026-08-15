<?php
/**
 * ============================================================
 * Kode      : index.php
 * Path      : Views/dashboard/sekretariat/upload_surat_penerimaan/index.php
 * Deskripsi : Layout utama halaman Upload Surat Penerimaan (Single Page).
 * ============================================================
 */
?>
<?= $this->extend('layout/L_master') ?>

<?= $this->section('title') ?>
<?= esc($title) ?>
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
<?php if (session()->getFlashdata('error')) : ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle mr-2"></i>
    <?= session()->getFlashdata('error') ?>
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
<?php endif; ?>

<!-- Page Description -->
<div class="mb-4">
    <h5 style="font-weight:700; color:#1B2559; margin-bottom:4px;">Upload Surat Penerimaan</h5>
    <p style="color:#667085; font-size:0.9rem; margin:0;">
        Kelola dan unggah surat penerimaan untuk permohonan magang yang telah diproses.
    </p>
</div>

<!-- Section Daftar Upload Surat -->
<div id="sectionList">
    <?= $this->include('dashboard/sekretariat/upload_surat_penerimaan/_list') ?>
</div>

<!-- Section Detail Upload Surat -->
<div id="sectionDetail" style="display: none;">
    <div id="detailContainer"></div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    var table = $('#dataTable').DataTable({
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
    $('#searchUploadSurat').on('keyup', function() {
        table.search(this.value).draw();
    });
    
    // Hide default search
    $('#dataTable_filter').hide();

    // Filter Jenis Permohonan
    $('#filterJenisPermohonan').on('change', function() {
        table.column(2).search(this.value).draw();
    });

    // Filter Status Penempatan
    $('#filterStatusPermohonan').on('change', function() {
        var val = $(this).val();
        if (val === 'BERJALAN') {
            table.column(3).search('DITERIMA').draw();
        } else {
            table.column(3).search(val).draw();
        }
    });

    // Filter Status Surat
    $('#filterStatusSurat').on('change', function() {
        table.column(4).search(this.value).draw();
    });

    // Transisi Buka Detail
    $(document).on('click', '.btn-upload-surat', function(e) {
        e.preventDefault();
        var idPersetujuan = $(this).data('id-persetujuan');
        
        $('#detailContainer').html('<div class="text-center my-4"><i class="fas fa-spinner fa-spin fa-2x"></i> Memuat detail permohonan...</div>');
        $('#sectionList').hide();
        $('#sectionDetail').show();
        
        $.ajax({
            url: "<?= base_url('sekretariat/upload-surat-penerimaan') ?>",
            type: "POST",
            data: {
                <?= csrf_token() ?>: "<?= csrf_hash() ?>",
                action: 'get_detail',
                id: idPersetujuan
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

    // Form upload AJAX
    $(document).on('submit', '#formUploadSuratPenerimaan', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var formData = new FormData(this);
        var btn = $('#btnUploadSubmit');
        
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Mengunggah...');
        
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    Swal.fire('Berhasil!', response.message, 'success').then(() => {
                        window.location.reload();
                    });
                } else {
                    btn.prop('disabled', false).html('<i class="fas fa-upload mr-1"></i> Upload Surat');
                    Swal.fire('Gagal!', response.message, 'error');
                }
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="fas fa-upload mr-1"></i> Upload Surat');
                Swal.fire('Error!', 'Terjadi kesalahan sistem saat mengunggah surat.', 'error');
            }
        });
    });

    // Hapus surat AJAX
    $(document).on('click', '.btn-delete-surat', function() {
        var id = $(this).data('id');
        
        Swal.fire({
            title: 'Hapus Surat?',
            text: "File surat akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= base_url('sekretariat/upload-surat-penerimaan/delete') ?>/" + id,
                    type: "POST",
                    data: {
                        "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Terhapus!', response.message, 'success').then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('Gagal!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Gagal menghapus file.', 'error');
                    }
                });
            }
        });
    });

    // Ganti surat AJAX (Trigger hidden file input)
    $(document).on('click', '.btn-ganti-surat', function() {
        var id = $(this).data('id');
        $('#hiddenFileInput').data('id', id).click();
    });

    $(document).on('change', '#hiddenFileInput', function() {
        var file = this.files[0];
        if (!file) return;

        var id = $(this).data('id');
        var formData = new FormData();
        formData.append('file_surat', file);
        formData.append('id_file_selesai_magang', id);
        formData.append("<?= csrf_token() ?>", "<?= csrf_hash() ?>");

        Swal.fire({
            title: 'Mengganti File...',
            html: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: "<?= base_url('sekretariat/upload-surat-penerimaan/update-file') ?>/" + id,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    Swal.fire('Berhasil!', response.message, 'success').then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire('Gagal!', response.message, 'error');
                }
                // Reset file input
                $('#hiddenFileInput').val('');
            },
            error: function() {
                Swal.fire('Error!', 'Gagal mengganti file.', 'error');
                $('#hiddenFileInput').val('');
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
