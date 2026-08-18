<?= $this->extend('layout/L_master_kabid') ?>

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
<?php if (session()->getFlashdata('error')) : ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle mr-2"></i>
    <?= session()->getFlashdata('error') ?>
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
<?php endif; ?>

<!-- Section Daftar Permohonan -->
<div id="sectionList">
    <!-- Page Description -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 style="font-weight:700; color:#1B2559; margin-bottom:4px;">Disposisi Masuk</h5>
            <p style="color:#667085; font-size:0.85rem; margin:0;">
                Pantau dan kelola seluruh permohonan mahasiswa/siswa yang didisposisikan ke bidang Anda.
            </p>
        </div>
    </div>
    <?= $this->include('dashboard/kabid/disposisi/_list') ?>
</div>

<!-- Section Detail Permohonan -->
<div id="sectionDetail" style="display: none;">
    <div id="detailContainer"></div>
</div>

<!-- Modal Log (Masih diperlukan untuk tombol "Log" di tabel) -->
<div class="modal fade" id="modalLogRiwayat" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header bg-light border-bottom-0" style="border-radius: 12px 12px 0 0;">
                <h5 class="modal-title font-weight-bold" style="color: #1e293b;"><i class="fas fa-history mr-2 text-primary"></i> Lacak Jejak Permohonan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0 bg-light">
                <div id="logRiwayatContainerKabid" style="min-height: 200px;">
                    <!-- Diisi via AJAX -->
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Inisialisasi DataTable (client side)
    var table = $('#dataTableCustom').DataTable({
        "pageLength": 10,
        "lengthChange": false,
        "searching": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "language": {
            "emptyTable": "Belum ada disposisi masuk.",
            "zeroRecords": "Tidak ditemukan data yang sesuai",
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
            "infoFiltered": "(disaring dari _MAX_ total entri)",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Selanjutnya",
                "previous": "Sebelumnya"
            }
        },
        "dom": "<'row'<'col-sm-12'tr>>" +
               "<'row mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        "order": [[ 0, "asc" ]] 
    });

    // Custom Length
    $('#customLength').on('change', function() {
        table.page.len($(this).val()).draw();
    });

    // Custom Search
    $('#searchTable').on('keyup', function() {
        table.search($(this).val()).draw();
    });

    // Custom Status Filter
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            var selectedStatus = $('#filterStatusCustom').val().toLowerCase();
            var rowStatus = data[4].toLowerCase(); 
            if (selectedStatus === "" || rowStatus.includes(selectedStatus)) {
                return true;
            }
            return false;
        }
    );

    $('#filterStatusCustom').on('change', function() {
        table.draw();
    });

    // Buka Detail Standalone
    $(document).on('click', '.btn-detail', function() {
        var id = $(this).data('id');
        
        $('#detailContainer').html('<div class="text-center my-4"><i class="fas fa-spinner fa-spin fa-2x"></i> Memuat detail disposisi...</div>');
        $('#sectionList').hide();
        $('#sectionDetail').show();
        
        $.ajax({
            url: "<?= base_url('kabid/disposisi') ?>",
            type: "POST",
            data: {
                action: 'get_detail',
                id_penempatan: id
            },
            success: function(response) {
                if(response.error) {
                    Swal.fire('Error', response.message, 'error');
                    $('#sectionDetail').hide();
                    $('#sectionList').show();
                } else {
                    $('#detailContainer').html(response);
                }
            },
            error: function() {
                $('#detailContainer').html('');
                $('#sectionDetail').hide();
                $('#sectionList').show();
                Swal.fire('Error!', 'Gagal memuat detail disposisi.', 'error');
            }
        });
    });

    // Kembali ke List
    $(document).on('click', '#btnKembali', function() {
        $('#sectionDetail').hide();
        $('#detailContainer').html('');
        $('#sectionList').show();
    });

});

// Fungsi Log Riwayat
function showLogRiwayatKabid(id_permohonan) {
    $('#logRiwayatContainerKabid').html('<div class="text-center my-5"><i class="fas fa-spinner fa-spin fa-2x text-primary"></i><p class="mt-2 text-muted">Memuat data log...</p></div>');
    $('#modalLogRiwayat').modal('show');

    $.ajax({
        url: "<?= base_url('sekretariat/get-log-riwayat') ?>",
        type: "POST",
        data: { id_permohonan: id_permohonan },
        dataType: "json",
        success: function(response) {
            if(response.success) {
                renderLogTimelineKabid(response.data);
            } else {
                $('#logRiwayatContainerKabid').html('<div class="text-center my-5 text-danger"><i class="fas fa-exclamation-triangle fa-2x mb-2"></i><p>' + response.message + '</p></div>');
            }
        },
        error: function() {
            $('#logRiwayatContainerKabid').html('<div class="text-center my-5 text-danger"><i class="fas fa-times-circle fa-2x mb-2"></i><p>Terjadi kesalahan saat memuat data log.</p></div>');
        }
    });
}

function renderLogTimelineKabid(logs) {
    if(!logs || logs.length === 0) {
        $('#logRiwayatContainerKabid').html('<div class="text-center my-5 text-muted"><i class="fas fa-inbox fa-2x mb-2"></i><p>Belum ada log permohonan.</p></div>');
        return;
    }

    var html = '<div style="position:relative; padding: 20px 30px;">';
    html += '<div style="position:absolute; left: 45px; top: 30px; bottom: 30px; width: 2px; background: #e2e8f0;"></div>';

    logs.forEach(function(log, index) {
        var isFirst = (index === 0);
        var isLast = (index === logs.length - 1);
        
        var iconStr = '<i class="fas fa-check"></i>';
        var bgClass = 'bg-primary';
        var textClass = 'text-white';
        
        var action = log.action ? log.action.toUpperCase() : '';
        if(action.includes('TOLAK') || action.includes('BATAL')) { bgClass = 'bg-danger'; iconStr = '<i class="fas fa-times"></i>'; }
        else if(action.includes('SETUJU') || action.includes('SELESAI')) { bgClass = 'bg-success'; }
        else if(action.includes('PERBAIKAN')) { bgClass = 'bg-warning'; textClass = 'text-dark'; iconStr = '<i class="fas fa-exclamation"></i>'; }
        else if(action.includes('KIRIM') || action.includes('PENGAJUAN')) { bgClass = 'bg-info'; iconStr = '<i class="fas fa-paper-plane"></i>'; }
        else if(action.includes('DISPOSISI')) { bgClass = 'bg-purple'; iconStr = '<i class="fas fa-share"></i>'; }

        if(bgClass === 'bg-purple') bgClass = 'bg-secondary'; // fallback

        var dateObj = new Date(log.created_at);
        var dateStr = dateObj.toLocaleDateString('id-ID', {day:'2-digit', month:'short', year:'numeric'});
        var timeStr = dateObj.toLocaleTimeString('id-ID', {hour:'2-digit', minute:'2-digit'});

        html += '<div class="d-flex mb-4" style="position:relative; z-index:2;">';
        
        html += '<div class="flex-shrink-0 mr-3" style="width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; box-shadow: 0 0 0 4px #f8f9fa; z-index: 2;" class="' + bgClass + ' ' + textClass + '">';
        html += iconStr;
        html += '</div>';
        
        html += '<div class="flex-grow-1 bg-white p-3 shadow-sm border" style="border-radius: 10px;">';
        html += '<div class="d-flex justify-content-between align-items-center mb-1">';
        html += '<h6 class="mb-0 font-weight-bold" style="color:#1e293b; font-size:0.95rem;">' + (log.action || 'Sistem Update') + '</h6>';
        html += '<small class="text-muted"><i class="far fa-clock mr-1"></i>' + dateStr + ' ' + timeStr + '</small>';
        html += '</div>';
        html += '<p class="mb-1 text-muted" style="font-size:0.88rem;">' + (log.catatan || 'Tidak ada catatan') + '</p>';
        html += '<div class="mt-2" style="font-size:0.75rem; color:#94a3b8;"><i class="far fa-user mr-1"></i>Oleh: ' + (log.nama_aktor || 'Sistem') + ' (' + (log.role_aktor || 'System') + ')</div>';
        html += '</div>';
        
        html += '</div>';
    });
    
    html += '</div>';
    $('#logRiwayatContainerKabid').html(html);
}
</script>
<?= $this->endSection() ?>
