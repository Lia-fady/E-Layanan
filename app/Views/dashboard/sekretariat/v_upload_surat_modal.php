<div class="modal fade" id="modalUploadSurat" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-file-upload mr-2"></i> Upload Surat Penerimaan Magang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <!-- Info Pemohon -->
                <div class="alert alert-info">
                    <strong>Informasi Pemohon:</strong><br>
                    Nama: <?= esc($persetujuan->nama_mahasiswa ?? '-') ?> (<?= esc($persetujuan->nim ?? '-') ?>)<br>
                    Instansi: <?= esc($persetujuan->instansi_pendidikan ?? '-') ?>
                </div>

                <!-- Form Upload -->
                <form id="formUploadSuratPenerimaan" action="<?= base_url('sekretariat/upload-surat-penerimaan/store') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_persetujuan_magang" value="<?= $persetujuan->id_persetujuan_magang ?>">
                    
                    <div class="form-group">
                        <label for="id_file">Jenis Surat</label>
                        <select name="id_file" id="id_file" class="form-control" required style="pointer-events: none; background-color: #e9ecef;">
                            <!-- Hanya menampilkan Surat Penerimaan Magang (asumsi id_file = 4 atau nama_file = 'Surat Penerimaan Magang') -->
                            <?php foreach ($jenis_file as $jf) : ?>
                                <?php if (stripos($jf->nama_file, 'Penerimaan') !== false) : ?>
                                    <option value="<?= $jf->id_file ?>" selected><?= esc($jf->nama_file) ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Terkunci untuk jenis Surat Penerimaan Magang.</small>
                    </div>

                    <div class="form-group">
                        <label for="file_surat">Pilih File Surat <span class="text-danger">*</span></label>
                        <input type="file" name="file_surat" id="file_surat" class="form-control-file" accept=".pdf,.doc,.docx" required>
                        <small class="form-text text-muted">Format yang diizinkan: PDF, DOC, DOCX. Maksimal 5MB.</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" id="btnUploadSubmit">
                        <i class="fas fa-upload mr-1"></i> Upload Surat
                    </button>
                </form>

                <hr class="mt-4 mb-4">
                
                <!-- Daftar File -->
                <h6 class="font-weight-bold mb-3">Daftar Surat Penerimaan yang Diunggah</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th>Nama File</th>
                                <th width="20%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($files)) : ?>
                                <?php $no = 1; foreach ($files as $f) : ?>
                                    <tr>
                                        <td class="text-center align-middle"><?= $no++ ?></td>
                                        <td class="align-middle">
                                            <a href="<?= base_url('sekretariat/upload-surat-penerimaan/download/' . $f['id_file_proses_magang']) ?>" target="_blank">
                                                <?= esc($f['nama_file']) ?>
                                            </a>
                                        </td>
                                        <td class="text-center align-middle">
                                            <button type="button" class="btn btn-sm btn-danger btn-delete-surat" data-id="<?= $f['id_file_proses_magang'] ?>" title="Hapus File">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada surat penerimaan yang diunggah.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Form upload AJAX
    $('#formUploadSuratPenerimaan').on('submit', function(e) {
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
                        // Reload modal via ajax or just reload page
                        $('#modalUploadSurat').modal('hide');
                        window.location.reload();
                    });
                } else {
                    btn.prop('disabled', false).html('<i class="fas fa-upload mr-1"></i> Upload Surat');
                    Swal.fire('Gagal!', response.message, 'error');
                }
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="fas fa-upload mr-1"></i> Upload Surat');
                Swal.fire('Error!', 'Terjadi kesalahan sistem.', 'error');
            }
        });
    });

    // Hapus surat AJAX
    $('.btn-delete-surat').on('click', function() {
        var id = $(this).data('id');
        
        Swal.fire({
            title: 'Hapus Surat?',
            text: "File surat akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DC3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('sekretariat/upload-surat-penerimaan/delete') ?>/' + id,
                    type: 'POST',
                    data: { '<?= csrf_token() ?>': '<?= csrf_hash() ?>' },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Berhasil!', response.message, 'success').then(() => {
                                $('#modalUploadSurat').modal('hide');
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('Gagal!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan sistem.', 'error');
                    }
                });
            }
        });
    });
});
</script>
