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

<!-- Page Description -->
<div class="mb-4">
    <h5 style="font-weight:700; color:#1B2559; margin-bottom:4px;">Verifikasi Permohonan</h5>
    <p style="color:#667085; font-size:0.9rem; margin:0;">
        Periksa dan verifikasi kelengkapan serta status permohonan magang yang diajukan mahasiswa.
    </p>
</div>

<!-- Section Daftar Permohonan -->
<div id="sectionList">
    <?= $this->include('dashboard/sekretariat/verifikasi/_list') ?>
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

    // Fungsi untuk mengecek apakah semua berkas Valid
    function checkValidasiBerkas() {
        var allValid = true;
        // Cari semua input hidden yang menyimpan status file
        $('input[name^="file_status"]').each(function() {
            if ($(this).val() !== 'SESUAI') {
                allValid = false;
            }
        });

        var bidangDropdown = $('#id_bidang');
        // Jangan enable jika dropdown sudah di-disabled dari server (isLocked)
        if (!bidangDropdown.data('locked')) {
            if (allValid && $('input[name^="file_status"]').length > 0) {
                bidangDropdown.prop('disabled', false);
            } else {
                bidangDropdown.prop('disabled', true);
                bidangDropdown.val(''); // Reset pilihan
                $('#info_kuota_bidang').hide();
            }
        }
    }

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
                // Set flag locked di element select jika ada attribute disabled bawaan dari server
                if ($('#id_bidang').is(':disabled')) {
                    $('#id_bidang').data('locked', true);
                } else {
                    $('#id_bidang').data('locked', false);
                }
                checkValidasiBerkas(); // Cek saat pertama kali diload
            },
            error: function() {
                $('#detailContainer').html('');
                $('#sectionDetail').hide();
                $('#sectionList').show();
                Swal.fire('Error!', 'Gagal memuat detail permohonan.', 'error');
            }
        });
    });

    <?php if (session()->getFlashdata('auto_open_detail_id')): ?>
        // Trigger klik otomatis untuk memuat detail yang diinginkan
        setTimeout(function() {
            var detailId = '<?= session()->getFlashdata('auto_open_detail_id') ?>';
            
            $('#detailContainer').html('<div class="text-center my-4"><i class="fas fa-spinner fa-spin fa-2x"></i> Memuat detail permohonan...</div>');
            $('#sectionList').hide();
            $('#sectionDetail').show();
            
            $.ajax({
                url: "<?= base_url('sekretariat/verifikasi') ?>",
                type: "POST",
                data: {
                    action: 'get_detail',
                    id: detailId
                },
                success: function(response) {
                    $('#detailContainer').html(response);
                    if ($('#id_bidang').is(':disabled')) {
                        $('#id_bidang').data('locked', true);
                    } else {
                        $('#id_bidang').data('locked', false);
                    }
                    checkValidasiBerkas();
                },
                error: function() {
                    $('#detailContainer').html('');
                    $('#sectionDetail').hide();
                    $('#sectionList').show();
                    Swal.fire('Error!', 'Gagal memuat detail permohonan.', 'error');
                }
            });
        }, 500); // Sedikit delay agar DOM siap dan animasi transisi smooth
    <?php endif; ?>

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
        
        // Reset action_type if submitting via default button
        if ($('#action_type').val() !== 'TOLAK') {
            $('#action_type').val('');
        }

        Swal.fire({
            title: $('#action_type').val() === 'TOLAK' ? 'Tolak Permohonan?' : 'Simpan Hasil Verifikasi?',
            text: $('#action_type').val() === 'TOLAK' ? "Permohonan ini akan ditolak secara permanen dan tindakan ini tidak dapat dibatalkan." : "Pastikan seluruh data verifikasi sudah sesuai sebelum disimpan.",
            icon: $('#action_type').val() === 'TOLAK' ? 'warning' : 'question',
            showCancelButton: true,
            confirmButtonColor: $('#action_type').val() === 'TOLAK' ? '#d33' : '#3085d6',
            cancelButtonColor: '#aaa',
            confirmButtonText: $('#action_type').val() === 'TOLAK' ? 'Tolak Permohonan' : 'Simpan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Berhasil!', response.message, 'success').then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('Gagal!', response.message, 'error');
                        }
                        $('#action_type').val(''); // Reset
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan sistem saat menyimpan keputusan.', 'error');
                        $('#action_type').val(''); // Reset
                    }
                });
            } else {
                $('#action_type').val(''); // Reset if cancelled
            }
        });
    });

    // Handle button Tolak Permohonan
    $(document).on('click', '#btnTolakMutlak', function() {
        var catatan = $('#catatan_manual').val().trim();
        if (catatan === '') {
            Swal.fire('Perhatian!', 'Catatan Tambahan wajib diisi jika Anda ingin menolak permohonan secara permanen.', 'warning');
            return;
        }
        $('#action_type').val('TOLAK');
        $('#formVerifikasiDetail').submit();
    });

    // Set file validitas toggle checkbox classes in detail
    $(document).on('change', '.cb-sesuai, .cb-tidak-sesuai', function() {
        var checkbox = $(this);
        var id = checkbox.data('id');
        var isSesuai = checkbox.hasClass('cb-sesuai');
        var isChecked = checkbox.is(':checked');
        
        var hiddenInput = $('input[name="file_status[' + id + ']"]');
        var cbSesuai = $('#cb_sesuai_' + id);
        var cbTidakSesuai = $('#cb_tdk_sesuai_' + id);
        var labelSesuai = $('label[for="cb_sesuai_' + id + '"]');
        var labelTidakSesuai = $('label[for="cb_tdk_sesuai_' + id + '"]');

        if (!isChecked) {
            // Prevent unchecking if the other is not checked (must pick one)
            // Or allow unchecking to reset? Let's allow reset to empty string
            hiddenInput.val('');
            labelSesuai.css('color', '#6c757d');
            labelTidakSesuai.css('color', '#6c757d');
        } else {
            if (isSesuai) {
                hiddenInput.val('SESUAI');
                cbTidakSesuai.prop('checked', false);
                labelSesuai.css('color', '#28a745');
                labelTidakSesuai.css('color', '#6c757d');
            } else {
                hiddenInput.val('TIDAK_SESUAI');
                cbSesuai.prop('checked', false);
                labelTidakSesuai.css('color', '#dc3545');
                labelSesuai.css('color', '#6c757d');
            }
        }
        
        checkValidasiBerkas();
    });

    // Handle Tolak Cepat dari tabel
    $(document).on('click', '.btn-tolak-cepat', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        
        Swal.fire({
            title: 'Tolak Permohonan?',
            text: 'Berikan alasan penolakan yang akan dikirimkan kepada mahasiswa:',
            input: 'textarea',
            inputPlaceholder: 'Contoh: Kuota Penuh...',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Kirim & Tolak',
            cancelButtonText: 'Batal',
            inputValidator: (value) => {
                if (!value || value.trim() === '') {
                    return 'Alasan penolakan wajib diisi!'
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= base_url('sekretariat/verifikasi/tolakCepat') ?>",
                    type: "POST",
                    data: {
                        id_permohonan_magang: id,
                        catatan: result.value,
                        '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Berhasil!', response.message, 'success').then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('Gagal!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan saat memproses data.', 'error');
                    }
                });
            }
        });
    });
});

function showLogRiwayatSekre(idPermohonan) {
    var myModal = new bootstrap.Modal(document.getElementById('modalLogRiwayatSekre'));
    myModal.show();
    
    const container = document.getElementById('logRiwayatContainerSekre');
    container.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="text-muted mt-2 small">Memuat riwayat aktivitas...</p>
        </div>`;
        
    fetch(`<?= base_url('api/log/riwayat/') ?>${idPermohonan}`)
        .then(response => response.json())
        .then(res => {
            if(res.status === 'success') {
                if(res.data.length === 0) {
                    container.innerHTML = `<div class="text-center text-muted small py-4">Belum ada riwayat aktivitas yang tercatat.</div>`;
                    return;
                }
                
                let html = '<div class="v-timeline" style="position:relative; padding-left:20px;">';
                res.data.forEach(log => {
                    let iconBg = log.color_class === 'danger' ? '#ef4444' : (log.color_class === 'success' ? '#10b981' : '#3b82f6');
                    html += `
                        <div style="position:relative; margin-bottom:20px; padding-left:15px; border-left:2px solid #e2e8f0;">
                            <div style="position:absolute; top:0; left:-11px; width:20px; height:20px; border-radius:50%; background:${iconBg}; display:flex; align-items:center; justify-content:center;">
                                <i class="fas fa-check text-white" style="font-size:0.6rem;"></i>
                            </div>
                            <span class="d-block text-muted" style="font-size:0.8rem;">${log.tanggal_format} <span class="ms-1">Oleh: ${log.aktor}</span></span>
                            <div class="fw-bold text-dark" style="font-size:0.9rem;">${log.aksi}</div>
                            ${log.catatan ? `<div class="mt-1 p-2 bg-light text-dark rounded" style="font-size:0.85rem;">${log.catatan}</div>` : ''}
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
</script>

<!-- MODAL LOG RIWAYAT SEKRETARIAT -->
<div class="modal fade" id="modalLogRiwayatSekre" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow" style="border-radius: 8px;">
            <div class="modal-header bg-white border-bottom py-3">
                <h6 class="modal-title fw-bold text-dark m-0"><i class="fas fa-history mr-2 text-info"></i> Lacak Jejak (Log Riwayat)</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 bg-white" id="logRiwayatContainerSekre">
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
