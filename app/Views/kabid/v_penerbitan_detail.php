<?= $this->extend('layout/L_master') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4" style="background-color: #f8fafc; min-height: 100vh;">
    <!-- Back Button & Header -->
    <div class="mb-4 d-flex align-items-center">
        <a href="<?= base_url('sekretariat/penerbitan-dokumen') ?>" class="btn btn-sm btn-light shadow-sm mr-3" style="border-radius: 8px;">
            <i class="fas fa-arrow-left text-primary"></i>
        </a>
        <h4 class="font-weight-bold mb-0 text-dark" style="font-size: 18px;">Detail Permohonan & Upload Dokumen</h4>
    </div>

    <!-- Top Section: Informasi Pemohon & Keahlian -->
    <div class="row mb-4">
        <div class="col-md-6 mb-3 mb-md-0">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 8px;">
                <div class="card-body p-4">
                    <h6 class="font-weight-bold text-dark mb-4" style="font-size: 15px;">Informasi Pemohon</h6>
                    
                    <div class="d-flex mb-3">
                        <div style="width: 140px; color: #64748b; font-size: 14px;">Nama Mahasiswa</div>
                        <div style="width: 20px; color: #64748b;">:</div>
                        <div class="font-weight-bold text-dark flex-grow-1" style="font-size: 14px;"><?= esc($info['nama_mahasiswa']) ?></div>
                    </div>
                    <div class="d-flex mb-3">
                        <div style="width: 140px; color: #64748b; font-size: 14px;">NIK / NIM</div>
                        <div style="width: 20px; color: #64748b;">:</div>
                        <div class="text-dark flex-grow-1" style="font-size: 14px;"><?= esc($info['nim']) ?></div>
                    </div>
                    <div class="d-flex mb-3">
                        <div style="width: 140px; color: #64748b; font-size: 14px;">Prodi / Fakultas</div>
                        <div style="width: 20px; color: #64748b;">:</div>
                        <div class="text-dark flex-grow-1" style="font-size: 14px;"><?= esc($info['prodi']) ?></div>
                    </div>
                    <div class="d-flex mb-3">
                        <div style="width: 140px; color: #64748b; font-size: 14px;">Universitas</div>
                        <div style="width: 20px; color: #64748b;">:</div>
                        <div class="text-dark flex-grow-1" style="font-size: 14px;"><?= esc($info['universitas']) ?></div>
                    </div>
                    <div class="d-flex mb-3">
                        <div style="width: 140px; color: #64748b; font-size: 14px;">Tanggal Pengajuan</div>
                        <div style="width: 20px; color: #64748b;">:</div>
                        <div class="text-dark flex-grow-1" style="font-size: 14px;"><?= isset($info['tgl_pengajuan']) ? date('d F Y, H:i', strtotime($info['tgl_pengajuan'])) : '-' ?></div>
                    </div>
                    <div class="d-flex mb-0">
                        <div style="width: 140px; color: #64748b; font-size: 14px;">Periode Magang</div>
                        <div style="width: 20px; color: #64748b;">:</div>
                        <div class="text-dark flex-grow-1" style="font-size: 14px;"><?= esc($periode) ?></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 8px;">
                <div class="card-body p-4">
                    <h6 class="font-weight-bold text-dark mb-4" style="font-size: 15px;">Keahlian & Tujuan Magang</h6>
                    
                    <div class="p-3 mb-3" style="background-color: #f8fafc; border-radius: 6px;">
                        <div style="color: #94a3b8; font-size: 13px; margin-bottom: 4px;">Deskripsi / Tujuan Magang</div>
                        <div class="font-weight-bold text-dark" style="font-size: 14px;"><?= esc($info['deskripsi_magang'] ?? '-') ?></div>
                    </div>
                    
                    <div class="p-3" style="background-color: #f8fafc; border-radius: 6px;">
                        <div style="color: #94a3b8; font-size: 13px; margin-bottom: 4px;">Penempatan Bidang</div>
                        <div class="font-weight-bold text-dark" style="font-size: 14px;"><?= esc($info['nama_bidang'] ?? '-') ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Section: Upload & List Dokumen -->
    <div class="row">
        <!-- Upload Form -->
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 8px;">
                <div class="card-body p-4">
                    <h6 class="font-weight-bold text-dark mb-4" style="font-size: 15px;">Upload Dokumen Baru</h6>
                    
                    <div class="form-group mb-4">
                        <label style="color: #64748b; font-size: 14px; margin-bottom: 8px;">Jenis Surat</label>
                        <select id="jenisSurat" class="form-control" style="background-color: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 14px; height: 42px;">
                            <option value="">Pilih Jenis Surat...</option>
                            <option value="surat_keterangan">Surat Keterangan Selesai Magang</option>
                            <option value="sertifikat">Sertifikat Magang</option>
                        </select>
                        <small class="form-text text-muted mt-2" style="font-size: 12px;">Pilih jenis surat yang akan diunggah.</small>
                    </div>

                    <div class="form-group mb-4">
                        <label style="color: #64748b; font-size: 14px; margin-bottom: 8px;">Pilih File Surat <span class="text-danger">*</span></label>
                        <div class="d-flex align-items-center">
                            <button type="button" id="btnPilihFile" class="btn btn-sm btn-light mr-3" style="border: 1px solid #cbd5e1; background: #f8fafc; color: #475569; font-size: 13px; font-weight: 600; padding: 6px 12px;">Pilih File</button>
                            <span id="fileName" style="color: #94a3b8; font-size: 13px;">Tidak ada file yang dipilih</span>
                        </div>
                        <input type="file" id="fileDokumen" accept=".pdf" style="display: none;">
                    </div>

                    <div id="validationError" class="alert alert-danger" style="display: none; font-size: 13px; border-radius: 6px; padding: 10px;">
                        <i class="fas fa-exclamation-triangle mr-1"></i> <span id="validationMessage"></span>
                    </div>

                    <button type="button" id="btnUpload" class="btn btn-primary w-100 mt-2" style="background-color: #4a90e2; border: none; border-radius: 6px; font-size: 14px; font-weight: 600; padding: 10px;" disabled>
                        <i class="fas fa-upload mr-2"></i> Upload File
                    </button>
                </div>
            </div>
        </div>
        
        <!-- List Dokumen -->
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 8px;">
                <div class="card-body p-4">
                    <h6 class="font-weight-bold text-dark mb-4" style="font-size: 15px;">Daftar Surat yang Diunggah</h6>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered w-100" style="border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0; font-size: 13px;">
                            <thead style="background-color: #f8fafc; color: #4a5568;">
                                <tr>
                                    <th class="text-center align-middle" style="width: 40px; padding: 12px; font-weight: 600;">No</th>
                                    <th class="align-middle" style="width: 150px; padding: 12px; font-weight: 600;">Jenis File</th>
                                    <th class="align-middle" style="padding: 12px; font-weight: 600;">Nama File</th>
                                    <th class="align-middle" style="width: 130px; padding: 12px; font-weight: 600;">Tanggal Upload</th>
                                    <th class="text-center align-middle" style="width: 90px; padding: 12px; font-weight: 600;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($files)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada dokumen yang diunggah.</td>
                                </tr>
                                <?php else: ?>
                                    <?php $no = 1; foreach($files as $file): ?>
                                    <tr>
                                        <td class="text-center align-middle" style="color: #64748b;"><?= $no++ ?></td>
                                        <td class="align-middle" style="color: #64748b;">
                                            <?= $file['jenis_dokumen'] === 'surat_keterangan' ? 'Surat Keterangan Selesai Magang' : 'Sertifikat Magang' ?>
                                        </td>
                                        <td class="align-middle">
                                            <a href="<?= base_url('sekretariat/penerbitan-dokumen/lihat/' . $file['id_file_selesai_magang']) ?>" target="_blank" style="color: #4a90e2; font-weight: 500; text-decoration: none;">
                                                <?= esc($file['nama_file']) ?>
                                            </a>
                                        </td>
                                        <td class="align-middle" style="color: #64748b;">
                                            <?= date('d M Y', strtotime($file['updated_at'] ?? $file['created_at'])) ?><br>
                                            <small><?= date('H:i', strtotime($file['updated_at'] ?? $file['created_at'])) ?></small>
                                        </td>
                                        <td class="text-center align-middle">
                                            <button type="button" class="btn btn-sm btn-ganti mb-1" data-id="<?= $file['id_file_selesai_magang'] ?>" style="background-color: #f59e0b; color: white; padding: 4px 8px; border-radius: 4px; border: none;">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-hapus mb-1" data-id="<?= $file['id_file_selesai_magang'] ?>" style="background-color: #ef4444; color: white; padding: 4px 8px; border-radius: 4px; border: none;">
                                                <i class="fas fa-trash-alt"></i>
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
        </div>
    </div>
</div>

<!-- Modal Ganti File -->
<div class="modal fade" id="modalGantiFile" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title font-weight-bold">Ganti Dokumen</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-muted" style="font-size: 13px;">Pilih file PDF baru untuk mengganti dokumen ini.</p>
                
                <input type="hidden" id="gantiIdFile">
                
                <div class="form-group mb-0">
                    <div class="d-flex align-items-center">
                        <button type="button" id="btnPilihGantiFile" class="btn btn-sm btn-light mr-3" style="border: 1px solid #cbd5e1; background: #f8fafc; color: #475569; font-size: 13px; font-weight: 600; padding: 6px 12px;">Pilih File Baru</button>
                        <span id="gantiFileName" style="color: #94a3b8; font-size: 13px;">Tidak ada file</span>
                    </div>
                    <input type="file" id="gantiFileDokumen" accept=".pdf" style="display: none;">
                </div>
                
                <div id="gantiValidationError" class="alert alert-danger mt-3 mb-0" style="display: none; font-size: 13px; border-radius: 6px; padding: 8px;">
                    <i class="fas fa-exclamation-triangle mr-1"></i> <span id="gantiValidationMessage"></span>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light" data-dismiss="modal" style="border-radius: 6px; font-size: 13px; font-weight: 600;">Batal</button>
                <button type="button" id="btnSimpanGanti" class="btn btn-warning text-white" style="border-radius: 6px; font-size: 13px; font-weight: 600;" disabled>Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    const ID_PERSETUJUAN = '<?= esc($id_persetujuan_magang) ?>';
    const ID_FILE_PERMOHONAN = '<?= esc($info['id_file_permohonan']) ?>';
    const UPLOAD_URL = '<?= base_url("sekretariat/penerbitan-dokumen/upload") ?>';
    const GANTI_URL = '<?= base_url("sekretariat/penerbitan-dokumen/ganti-file") ?>';
    const HAPUS_URL = '<?= base_url("sekretariat/penerbitan-dokumen/hapus_file") ?>';
    const CSRF_TOKEN_NAME = '<?= csrf_token() ?>';
    const CSRF_HASH = '<?= csrf_hash() ?>';
    
    // Upload Baru
    $('#btnPilihFile').click(function() {
        $('#fileDokumen').click();
    });
    
    $('#fileDokumen').change(function(e) {
        let file = e.target.files[0];
        if (file) {
            $('#fileName').text(file.name).css('color', '#334155');
            checkUploadReady();
        } else {
            $('#fileName').text('Tidak ada file yang dipilih').css('color', '#94a3b8');
            $('#btnUpload').prop('disabled', true);
        }
    });
    
    $('#jenisSurat').change(function() {
        checkUploadReady();
    });
    
    function checkUploadReady() {
        let jenis = $('#jenisSurat').val();
        let file = $('#fileDokumen')[0].files[0];
        $('#validationError').hide();
        
        if (jenis && file) {
            if (file.type !== 'application/pdf') {
                showError('Format file harus PDF.');
                $('#btnUpload').prop('disabled', true);
            } else if (file.size > 2 * 1024 * 1024) {
                showError('Ukuran file maksimal 2MB.');
                $('#btnUpload').prop('disabled', true);
            } else {
                $('#btnUpload').prop('disabled', false);
            }
        } else {
            $('#btnUpload').prop('disabled', true);
        }
    }
    
    function showError(msg) {
        $('#validationMessage').text(msg);
        $('#validationError').show();
    }
    
    $('#btnUpload').click(function() {
        let jenis = $('#jenisSurat').val();
        let file = $('#fileDokumen')[0].files[0];
        
        let formData = new FormData();
        formData.append('id_persetujuan_magang', ID_PERSETUJUAN);
        formData.append('id_file_permohonan', ID_FILE_PERMOHONAN);
        formData.append('jenis_dokumen', jenis);
        formData.append('file_dokumen', file);
        formData.append(CSRF_TOKEN_NAME, CSRF_HASH);
        
        Swal.fire({
            title: 'Mengunggah...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            url: UPLOAD_URL,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                if (res.status === 'success') {
                    Swal.fire('Berhasil!', res.message, 'success').then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire('Gagal!', res.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error!', 'Terjadi kesalahan pada server.', 'error');
            }
        });
    });
    
    // Ganti File
    $('.btn-ganti').click(function() {
        let idFile = $(this).data('id');
        $('#gantiIdFile').val(idFile);
        $('#gantiFileDokumen').val('');
        $('#gantiFileName').text('Tidak ada file').css('color', '#94a3b8');
        $('#btnSimpanGanti').prop('disabled', true);
        $('#gantiValidationError').hide();
        $('#modalGantiFile').modal('show');
    });
    
    $('#btnPilihGantiFile').click(function() {
        $('#gantiFileDokumen').click();
    });
    
    $('#gantiFileDokumen').change(function(e) {
        let file = e.target.files[0];
        $('#gantiValidationError').hide();
        if (file) {
            $('#gantiFileName').text(file.name).css('color', '#334155');
            if (file.type !== 'application/pdf') {
                $('#gantiValidationMessage').text('Format file harus PDF.');
                $('#gantiValidationError').show();
                $('#btnSimpanGanti').prop('disabled', true);
            } else if (file.size > 2 * 1024 * 1024) {
                $('#gantiValidationMessage').text('Ukuran file maksimal 2MB.');
                $('#gantiValidationError').show();
                $('#btnSimpanGanti').prop('disabled', true);
            } else {
                $('#btnSimpanGanti').prop('disabled', false);
            }
        } else {
            $('#gantiFileName').text('Tidak ada file').css('color', '#94a3b8');
            $('#btnSimpanGanti').prop('disabled', true);
        }
    });
    
    $('#btnSimpanGanti').click(function() {
        let idFile = $('#gantiIdFile').val();
        let file = $('#gantiFileDokumen')[0].files[0];
        
        let formData = new FormData();
        formData.append('id_file_selesai_magang', idFile);
        formData.append('file_dokumen', file);
        formData.append(CSRF_TOKEN_NAME, CSRF_HASH);
        
        $('#modalGantiFile').modal('hide');
        Swal.fire({
            title: 'Mengganti Dokumen...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            url: GANTI_URL,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                if (res.status === 'success') {
                    Swal.fire('Berhasil!', res.message, 'success').then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire('Gagal!', res.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error!', 'Terjadi kesalahan pada server.', 'error');
            }
        });
    });
    
    // Hapus File
    $('.btn-hapus').click(function() {
        let idFile = $(this).data('id');
        Swal.fire({
            title: 'Hapus Dokumen?',
            text: "Dokumen ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Menghapus...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });
                
                $.ajax({
                    url: HAPUS_URL + '/' + idFile,
                    type: 'GET',
                    success: function(res) {
                        if (res.status === 'success') {
                            Swal.fire('Terhapus!', res.message, 'success').then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('Gagal!', res.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan pada server.', 'error');
                    }
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
