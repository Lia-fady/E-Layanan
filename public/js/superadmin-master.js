/**
 * Custom JavaScript for Super Admin Module
 * Contains common initializations for DataTables, Modals, and standard UI interactions.
 */

$(document).ready(function() {
    // 1. Inisialisasi DataTable default dengan bahasa Indonesia
    if ($.fn.DataTable) {
        $('.table:not(.no-dt)').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
            },
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true
        });
    }

    // 2. Global Delete Modal Handler
    // View hanya perlu menambahkan class "btn-hapus", data-id, dan atribut data-bs-target / data-target="#deleteModal"
    $(document).on('click', '.btn-hapus', function(e) {
        let id = $(this).data('id');
        let deleteUrl = $(this).data('url'); 
        
        // Coba cari form konfirmasi hapus
        let $form = $('#formDelete');
        if ($form.length) {
            if(deleteUrl) {
                $form.attr('action', deleteUrl);
            } else {
                // Asumsi standard URL, replace the last part
                let action = $form.attr('action');
                let newAction = action.substring(0, action.lastIndexOf('/') + 1) + id;
                $form.attr('action', newAction);
            }
        }
    });

    // 3. Tooltip initialization
    $('[data-toggle="tooltip"]').tooltip();
});
