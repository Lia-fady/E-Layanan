/**
 * Custom JavaScript for Super Admin Module
 * Contains common initializations for DataTables, SweetAlert2 CRUD handlers,
 * and standard UI interactions.
 */

$(document).ready(function() {
    // 1. Inisialisasi DataTable default dengan bahasa Indonesia
    if ($.fn.DataTable) {
        $('.table:not(.no-dt)').each(function() {
            if (!$.fn.DataTable.isDataTable(this)) {
                $(this).DataTable({
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
        });
    }

    // 2. Global Delete Handler with SweetAlert2
    $(document).on('click', '.btn-hapus', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        let deleteUrl = $(this).data('url');
        if (!deleteUrl) return;

        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus data ini? Data yang sudah dihapus tidak dapat dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-trash me-1"></i> Hapus',
            cancelButtonText: '<i class="fas fa-times me-1"></i> Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Create and submit hidden form
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = deleteUrl;
                form.style.display = 'none';
                document.body.appendChild(form);
                form.submit();
            }
        });
    });

    // 3. Global Form Submit Confirmation - CREATE
    $(document).on('submit', '.form-confirm-create', function(e) {
        e.preventDefault();
        let form = this;
        
        Swal.fire({
            title: 'Konfirmasi Simpan',
            text: 'Apakah data ingin disimpan?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-save me-1"></i> Ya, Simpan',
            cancelButtonText: '<i class="fas fa-times me-1"></i> Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Remove class to prevent re-interception, then submit
                $(form).removeClass('form-confirm-create');
                form.submit();
            }
        });
    });

    // 4. Global Form Submit Confirmation - UPDATE
    $(document).on('submit', '.form-confirm-update', function(e) {
        e.preventDefault();
        let form = this;
        
        Swal.fire({
            title: 'Konfirmasi Update',
            text: 'Apakah perubahan data ingin disimpan?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-save me-1"></i> Ya, Simpan',
            cancelButtonText: '<i class="fas fa-times me-1"></i> Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $(form).removeClass('form-confirm-update');
                form.submit();
            }
        });
    });

    // 5. Global Edit State Management - Cancel Edit
    $(document).on('click', '.btn-cancel-edit', function() {
        var editContainer = document.getElementById('editContainer');
        var tableContainer = document.getElementById('tableContainer');
        var formEditInline = document.getElementById('formEditInline');
        
        if (editContainer) editContainer.classList.add('d-none');
        if (tableContainer) tableContainer.classList.remove('d-none');
        if (formEditInline) formEditInline.reset();
        
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // 6. Tooltip initialization
    $('[data-toggle="tooltip"]').tooltip();
});

/**
 * Helper function: Show full-page edit state
 * Hides the table container and shows the edit container
 */
function showEditState() {
    var editContainer = document.getElementById('editContainer');
    var tableContainer = document.getElementById('tableContainer');
    
    if (tableContainer) tableContainer.classList.add('d-none');
    if (editContainer) editContainer.classList.remove('d-none');
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
