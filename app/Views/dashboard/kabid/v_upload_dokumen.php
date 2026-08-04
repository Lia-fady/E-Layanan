/**
 * View untuk Upload Dokumen Magang (Kepala Bidang)
 */
?>
<?= $this->extend('layout/L_master_kabid') ?>

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
<?php if (session()->getFlashdata('errors')) : ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle mr-2"></i>
    Terdapat kesalahan pada input Anda:
    <ul class="mb-0">
    <?php foreach (session()->getFlashdata('errors') as $err) : ?>
        <li><?= esc($err) ?></li>
    <?php endforeach; ?>
    </ul>
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
<?php endif; ?>

<style>
/* Table Styling */
.table-premium thead th {
    background: linear-gradient(135deg, #1e3a5f 0%, #2d5a8e 100%);
    color: #fff;
    vertical-align: middle;
    font-size: 0.82rem;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    padding: 12px 14px;
    border: none;
}
.table-premium tbody td {
    vertical-align: middle;
    padding: 12px 14px;
    font-size: 0.88rem;
    color: #374151;
}
.table-premium tbody tr:hover {
    background-color: #f0f4ff;
}
/* Avatar */
.mhs-avatar-lg {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #6366f1, #818cf8);
    color: #fff;
    font-weight: 700;
    font-size: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.4);
}
/* Gradient Button */
.btn-gradient {
    background: linear-gradient(135deg, #6366f1, #818cf8);
    color: #fff;
    border: none;
    font-weight: 600;
    transition: all 0.2s;
}
.btn-gradient:hover {
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.4);
}
</style>

<!-- Back Link -->
<a href="<?= base_url('kabid/upload-dokumen') ?>" class="btn btn-light shadow-sm mb-4" style="border-radius: 8px; font-weight: 600; color: #475569;">
    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
</a>

<!-- Detail Header Profile Card -->
<div class="card shadow-sm mb-4" style="border: none; border-radius: 12px; overflow: hidden; background: #fff;">
    <div class="card-body p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div class="d-flex align-items-center">
            <div class="mhs-avatar-lg mr-4">
                <?= mb_strtoupper(mb_substr($persetujuan->nama_mahasiswa ?? 'A', 0, 1)) ?>
            </div>
            <div>
                <h5 class="mb-1" style="font-weight: 700; color: #1e3a5f;"><?= esc($persetujuan->nama_mahasiswa ?? '-') ?></h5>
                <div class="text-muted" style="font-size: 0.95rem;">
                    NIM: <?= esc($persetujuan->nim ?? '-') ?> &nbsp;|&nbsp; 
                    <i class="fas fa-graduation-cap mx-1"></i><?= esc($persetujuan->prodi ?? '-') ?> - <?= esc($persetujuan->instansi_pendidikan ?? '-') ?>
                </div>
            </div>
        </div>
        <div class="text-right" style="border-left: 2px solid #e5e7eb; padding-left: 20px;">
            <div style="font-size: 0.85rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px;">Periode Magang</div>
            <div style="font-weight: 600; color: #1e293b;">
                <?php
                    $mulai = !empty($persetujuan->tgl_mulai) ? date('d M Y', strtotime($persetujuan->tgl_mulai)) : '-';
                    $selesai = !empty($persetujuan->tgl_selesai) ? date('d M Y', strtotime($persetujuan->tgl_selesai)) : '-';
                ?>
                <i class="fas fa-calendar-alt mr-2 text-primary"></i><?= $mulai ?> <span class="text-muted mx-1">s/d</span> <?= $selesai ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Form Upload -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow" style="border: none; border-radius: 12px; overflow: hidden;">
            <div class="card-header py-3" style="background: #fff; border-bottom: 2px solid #e5e7eb;">
                <h6 class="m-0 font-weight-bold" style="color: #1e3a5f;">
                    <i class="fas fa-cloud-upload-alt mr-2" style="color: #6366f1;"></i>Upload Dokumen
                </h6>
            </div>
            <div class="card-body">
                <form id="formUploadSurat" action="<?= base_url('kabid/upload-dokumen/store') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_persetujuan_magang" value="<?= esc($persetujuan->id_persetujuan_magang) ?>">
                    
                    <div class="form-group">
                        <label for="id_file" style="font-weight: 600; color: #475569;">Jenis Dokumen <span class="text-danger">*</span></label>
                        <select class="form-control" name="id_file" id="id_file" required style="border-radius: 8px;">
                            <option value="">-- Pilih Jenis Dokumen --</option>
                            <?php foreach ($jenis_file as $jf) : ?>
                                <option value="<?= esc($jf->id_file) ?>" <?= old('id_file') == $jf->id_file ? 'selected' : '' ?>>
                                    <?= esc($jf->nama_file) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="file_surat" style="font-weight: 600; color: #475569;">Pilih File <span class="text-danger">*</span></label>
                        <div class="custom-file mb-2">
                            <input type="file" class="custom-file-input" name="file_surat" id="file_surat" required accept=".pdf,.doc,.docx">
                            <label class="custom-file-label" for="file_surat" style="border-radius: 8px;">Pilih file...</label>
                        </div>
                        <small class="form-text text-muted"><i class="fas fa-info-circle mr-1"></i>Format: PDF, DOC, DOCX. Maks: 5MB.</small>
                    </div>

                    <button type="submit" class="btn btn-gradient btn-block" style="border-radius: 8px; padding: 10px;">
                        <i class="fas fa-upload mr-1"></i> Upload Dokumen
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel File -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow" style="border: none; border-radius: 12px; overflow: hidden;">
            <div class="card-header py-3" style="background: #fff; border-bottom: 2px solid #e5e7eb;">
                <h6 class="m-0 font-weight-bold" style="color: #1e3a5f;">
                    <i class="fas fa-file-alt mr-2" style="color: #6366f1;"></i>Daftar Dokumen Magang
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-premium mb-0">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th>Jenis File</th>
                                <th>Nama File</th>
                                <th>Tanggal Upload</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($files)) : ?>
                                <?php $no = 1; foreach ($files as $f) : ?>
                                <tr>
                                    <td class="text-center text-muted" style="font-weight: 600;"><?= $no++ ?></td>
                                    <td><span class="badge" style="background: #ede9fe; color: #5b21b6; padding: 6px 10px; border-radius: 6px;"><?= esc($f->nama_file_master) ?></span></td>
                                    <td>
                                        <div style="font-weight: 600; color: #1e3a5f;"><?= esc($f->nama_file) ?></div>
                                        <small class="text-muted"><i class="fas fa-user-edit mr-1"></i><?= esc($f->pengunggah ?? '-') ?></small>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.85rem;"><i class="fas fa-clock mr-1 text-muted"></i><?= date('d M Y', strtotime($f->created_at)) ?></div>
                                        <div class="text-muted" style="font-size: 0.75rem;"><?= date('H:i', strtotime($f->created_at)) ?> WIB</div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center" style="gap: 5px;">
                                            <a href="<?= base_url('kabid/upload-dokumen/download/' . $f->id_file_selesai_magang) ?>" class="btn btn-sm" style="background: #e0e7ff; color: #4338ca; border-radius: 6px;" title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-ganti-file" 
                                                    style="background: #fef3c7; color: #d97706; border-radius: 6px;"
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
                                    <td colspan="5" class="text-center p-0 border-0">
                                        <div style="padding: 60px 20px;">
                                            <div style="
                                                width: 80px; height: 80px;
                                                background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
                                                border-radius: 50%;
                                                display: flex; align-items: center; justify-content: center;
                                                margin: 0 auto 15px auto;">
                                                <i class="fas fa-folder-open" style="font-size: 2rem; color: #94a3b8;"></i>
                                            </div>
                                            <h6 style="color: #475569; font-weight: 700; margin-bottom: 4px;">Belum Ada Dokumen</h6>
                                            <p style="color: #94a3b8; font-size: 0.85rem; margin: 0;">
                                                Silakan unggah dokumen pada form di samping.
                                            </p>
                                        </div>
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
                    <h5 class="modal-title" id="modalGantiFileLabel"><i class="fas fa-edit mr-2"></i>Ganti Dokumen Magang</h5>
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

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
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

    // SweetAlert untuk Konfirmasi Upload Baru
    $('#formUploadSurat').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        
        Swal.fire({
            title: 'Upload Dokumen?',
            text: 'Pastikan file dokumen magang yang Anda unggah sudah benar dan sesuai dengan data mahasiswa bersangkutan.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4e73df',
            cancelButtonColor: '#858796',
            confirmButtonText: 'Ya, Upload',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'shadow-sm rounded'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // SweetAlert untuk Konfirmasi Ganti/Edit File
    $('#formGantiFile').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        
        Swal.fire({
            title: 'Ganti Dokumen?',
            text: 'Dokumen lama akan tertimpa dan diganti dengan file baru. Pastikan file yang dipilih sudah benar sebelum melanjutkan.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4e73df',
            cancelButtonColor: '#858796',
            confirmButtonText: 'Ya, Ganti',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'shadow-sm rounded'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
