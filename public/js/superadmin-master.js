$(document).ready(function() {
    // 1. Initialize DataTables if #tableContainer table exists
    var $table = $('#tableContainer table');
    var dtInstance = null;

    if ($table.length > 0) {
        dtInstance = $table.DataTable({
            "dom": 'rt<"row align-items-center mt-3"<"col-md-6"i><"col-md-6 d-flex justify-content-end"p>>',
            "pageLength": parseInt($('#limitData').val()) || 10,
            "language": {
                "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                "infoEmpty": "Menampilkan 0 hingga 0 dari 0 entri",
                "infoFiltered": "(disaring dari total _MAX_ entri)",
                "zeroRecords": "Tidak ada data yang cocok ditemukan",
                "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Selanjutnya"
                }
            },
            "ordering": false // Keep the original server-side ordering for now
        });

        // Custom Search Box
        $('#searchBox').on('keyup', function() {
            dtInstance.search(this.value).draw();
        });

        // Custom Limit Dropdown
        $('#limitData').on('change', function() {
            var val = $(this).val();
            dtInstance.page.len(parseInt(val)).draw();
        });

        // Custom Status Filter via DataTables Extension
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            var filterVal = $('#filterStatus').val();
            if (!filterVal || filterVal === 'all') {
                return true;
            }

            var rowNode = dtInstance.row(dataIndex).node();
            var $statusSwitch = $(rowNode).find('.col-status input[type="checkbox"]');
            
            if ($statusSwitch.length > 0) {
                var isChecked = $statusSwitch.is(':checked');
                if (filterVal === 'aktif' && isChecked) return true;
                if (filterVal === 'nonaktif' && !isChecked) return true;
                return false;
            }
            
            // Fallback for v_manajemen_pengguna etc which might have text
            var statusText = $(rowNode).find('.col-status').text().toLowerCase().trim();
            if (filterVal === 'aktif' && (statusText === 'aktif' || statusText === 'active' || statusText === '1')) return true;
            if (filterVal === 'nonaktif' && (statusText === 'nonaktif' || statusText === 'inactive' || statusText === '0')) return true;

            return true; // Default allow if we can't determine
        });

        $('#filterStatus').on('change', function() {
            dtInstance.draw();
        });

        // Refresh Button overrides local refresh
        var refreshBtn = $('.btn-outline-secondary').filter(function() { return $(this).text().toLowerCase().indexOf('refresh') > -1; });
        if (refreshBtn.length > 0) {
            refreshBtn.removeAttr('onclick').on('click', function(e) {
                e.preventDefault();
                $('#searchBox').val('');
                $('#limitData').val('10');
                $('#filterStatus').val('all');
                
                // Clear DataTables filters but we actually want to refresh from DB as user requested
                // "mengembalikan jumlah baris ke default; memuat ulang seluruh data dari database."
                window.location.reload(); 
            });
        }
    }

    // 2. Edit Mode Toggle (Only UI, keeps the data population logic of inline script)
    $('#tableContainer').on('click', '.btn-edit', function() {
        $('#tableContainer').addClass('d-none');
    });

    // We also need to listen for clicks on cancel buttons which might be nested in EditContainer
    $('#editContainer').on('click', '.btn-cancel-edit, .btn-secondary:contains("Batal")', function() {
        $('#tableContainer').removeClass('d-none');
    });

    // 3. Delete Mode with SweetAlert
    // Prevent Bootstrap modal toggle via data-bs-toggle on the button
    $('#tableContainer').on('click', '.btn-hapus', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var btn = $(this);
        var id = btn.attr('data-id');
        
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: "Apakah Anda yakin ingin menghapus data ini?\n\nData yang dihapus tidak dapat dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                var currentPath = window.location.pathname.replace(/\/$/, '');
                
                var form = $('<form>', {
                    'method': 'POST',
                    'action': currentPath + '/delete/' + id
                });
                $('body').append(form);
                form.submit();
            }
        });
    });
});
