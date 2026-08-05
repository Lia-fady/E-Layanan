<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 style="font-weight:700; color:#1B2559; margin-bottom:4px;">Upload Dokumen Kegiatan</h5>
        <p style="color:#667085; font-size:0.85rem; margin:0;">
            Unggah dan kelola dokumen resmi untuk mahasiswa terkait.
        </p>
    </div>
    <button type="button" id="btnKembaliList" class="btn btn-sm btn-secondary shadow-sm" style="border-radius: 8px;">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </button>
</div>

<!-- Detail Header -->
<div class="detail-header mb-4">
    <div class="detail-header-avatar">
        <i class="fas fa-user"></i>
    </div>
    <div class="detail-header-info">
        <div class="detail-header-name"><?= esc($persetujuan->nama_mahasiswa ?? '-') ?></div>
        <div class="detail-header-meta">
            NIM: <?= esc($persetujuan->nim ?? '-') ?> | <?= esc($persetujuan->prodi ?? '-') ?> - <?= esc($persetujuan->instansi_pendidikan ?? '-') ?>
        </div>
    </div>
    <div class="detail-header-box">
        <div class="detail-header-box-label">Periode Kegiatan</div>
        <div class="detail-header-box-value">
            <?php
                $mulai = !empty($persetujuan->tgl_mulai) ? date('d F Y', strtotime($persetujuan->tgl_mulai)) : '-';
                $selesai = !empty($persetujuan->tgl_selesai) ? date('d F Y', strtotime($persetujuan->tgl_selesai)) : '-';
            ?>
            <?= $mulai ?> s/d <?= $selesai ?>
        </div>
    </div>
</div>

<!-- Back Link -->
<button type="button" id="btnKembaliListBawah" class="btn btn-link text-secondary detail-back-link mb-4 d-inline-block p-0">
    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
</button>

<div class="row">
    <!-- Form Upload -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Upload Dokumen</h6>
            </div>
            <div class="card-body">
                <form id="formUploadSurat" action="<?= base_url('kabid/upload-dokumen/store') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_persetujuan_magang" value="<?= esc($persetujuan->id_persetujuan_magang) ?>">
                    
                    <div class="form-group">
                        <label for="id_file">Jenis Dokumen <span class="text-danger">*</span></label>
                        <select class="form-control" name="id_file" id="id_file" required>
                            <option value="">-- Pilih Jenis Dokumen --</option>
                            <?php foreach ($jenis_file as $jf) : ?>
                                <option value="<?= esc($jf->id_file) ?>" <?= old('id_file') == $jf->id_file ? 'selected' : '' ?>>
                                    <?= esc($jf->nama_file) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="file_surat">Pilih File <span class="text-danger">*</span></label>
                        <input type="file" class="form-control-file" name="file_surat" id="file_surat" required accept=".pdf,.doc,.docx">
                        <small class="form-text text-muted">Format: PDF, DOC, DOCX. Maks: 5MB.</small>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-upload mr-1"></i> Upload Dokumen
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel File -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Dokumen</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th>Jenis File</th>
                                <th>Nama File</th>
                                <th>Tanggal Upload</th>
                                <th>Pengunggah</th>
                                <th width="20%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($files)) : ?>
                                <?php $no = 1; foreach ($files as $f) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= esc($f->nama_file_master) ?></td>
                                    <td><?= esc($f->nama_file) ?></td>
                                    <td><?= date('d M Y H:i', strtotime($f->created_at)) ?></td>
                                    <td><?= esc($f->pengunggah ?? '-') ?></td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center" style="gap: 5px;">
                                            <a href="<?= base_url('kabid/upload-dokumen/download/' . $f->id_file_selesai_magang) ?>" class="btn btn-sm btn-success" title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-warning btn-ganti-file" 
                                                    title="Ganti File"
                                                    data-id="<?= $f->id_file_selesai_magang ?>"
                                                    data-idfile="<?= $f->id_file ?>"
                                                    data-namafile="<?= esc($f->nama_file) ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>
                                        Belum ada surat yang diunggah.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ganti File -->
<div class="modal fade" id="modalGantiFile" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="POST" enctype="multipart/form-data" id="formGantiFile">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalGantiFileLabel"><i class="fas fa-edit mr-2"></i>Ganti Dokumen</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Anda akan mengganti file <strong id="nama_file_lama" class="text-primary"></strong>.</p>
                    <div class="form-group">
                        <label for="edit_id_file">Jenis Dokumen <span class="text-danger">*</span></label>
                        <select class="form-control" name="id_file" id="edit_id_file" required>
                            <option value="">-- Pilih Jenis Dokumen --</option>
                            <?php foreach ($jenis_file as $jf) : ?>
                                <option value="<?= esc($jf->id_file) ?>">
                                    <?= esc($jf->nama_file) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_file_surat">Pilih File Baru <span class="text-danger">*</span></label>
                        <input type="file" class="form-control-file" name="file_surat" id="edit_file_surat" required accept=".pdf,.doc,.docx">
                        <small class="form-text text-muted">Format: PDF, DOC, DOCX. Maks: 5MB.</small>
                    </div>
                    <div class="alert alert-warning" style="font-size:0.85rem;">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        File lama akan dihapus dan diganti dengan file baru.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Populate Modal Ganti File
    $('.btn-ganti-file').on('click', function() {
        var idSelesai = $(this).data('id');
        var idFile = $(this).data('idfile');
        var namaFile = $(this).data('namafile');

        $('#formGantiFile').attr('action', '<?= base_url('kabid/upload-dokumen/update/') ?>' + idSelesai);
        $('#edit_id_file').val(idFile);
        $('#nama_file_lama').text(namaFile);
        
        $('#modalGantiFile').modal('show');
    });

    // AJAX Form Upload
    $('#formUploadSurat').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);
        
        Swal.fire({
            title: 'Upload Dokumen?',
            text: 'Pastikan file dokumen yang Anda unggah sudah benar dan sesuai dengan data mahasiswa bersangkutan.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Upload!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                var btn = $(form).find('button[type="submit"]');
                var originalHtml = btn.html();
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Mengupload...');
                
                $.ajax({
                    url: $(form).attr('action'),
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.success) {
                            Swal.fire('Berhasil!', res.message, 'success').then(() => {
                                $('.btn-kelola-dokumen[data-id="<?= $persetujuan->id_persetujuan_magang ?>"]').click();
                            });
                        } else {
                            Swal.fire('Gagal!', res.message, 'error');
                            btn.prop('disabled', false).html(originalHtml);
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan sistem', 'error');
                        btn.prop('disabled', false).html(originalHtml);
                    }
                });
            }
        });
    });

    // AJAX Form Ganti File
    $('#formGantiFile').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);
        
        var btn = $(form).find('button[type="submit"]');
        var originalHtml = btn.html();
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...');
        
        $.ajax({
            url: $(form).attr('action'),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                if (res.success) {
                    $('#modalGantiFile').modal('hide');
                    $('.modal-backdrop').remove(); // Bersihkan backdrop
                    Swal.fire('Berhasil!', res.message, 'success').then(() => {
                        $('.btn-kelola-dokumen[data-id="<?= $persetujuan->id_persetujuan_magang ?>"]').click();
                    });
                } else {
                    Swal.fire('Gagal!', res.message, 'error');
                    btn.prop('disabled', false).html(originalHtml);
                }
            },
            error: function() {
                Swal.fire('Error!', 'Terjadi kesalahan sistem', 'error');
                btn.prop('disabled', false).html(originalHtml);
            }
        });
    });

    // Hapus File via AJAX
    $('.btn-hapus-file').on('click', function(e) {
        e.preventDefault();
        var deleteUrl = $(this).attr('href');
        
        Swal.fire({
            title: 'Hapus Dokumen?',
            text: "Dokumen yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: deleteUrl,
                    type: "POST",
                    data: {
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                    },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire('Terhapus!', res.message, 'success').then(() => {
                                $('.btn-kelola-dokumen[data-id="<?= $persetujuan->id_persetujuan_magang ?>"]').click();
                            });
                        } else {
                            Swal.fire('Gagal!', res.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan saat menghapus', 'error');
                    }
                });
            }
        });
    });

    // Handle Kembali Bawah
    $('#btnKembaliListBawah').on('click', function() {
        $('#btnKembaliList').click();
    });
});
</script>
