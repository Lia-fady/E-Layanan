<?php
/**
 * View untuk Upload Surat Penerimaan Magang (Sekretariat)
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
        <div class="detail-header-box-label">Periode Magang</div>
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
<a href="<?= base_url('sekretariat/upload-surat-penerimaan') ?>" class="detail-back-link mb-4 d-inline-block">
    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
</a>

<div class="row">
    <!-- Form Upload -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Upload Surat Penerimaan</h6>
            </div>
            <div class="card-body">
                <form action="<?= base_url('sekretariat/upload-surat-penerimaan/store') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_persetujuan_magang" value="<?= esc($persetujuan->id_persetujuan_magang) ?>">
                    
                    <div class="form-group">
                        <label for="id_file">Jenis Surat <span class="text-danger">*</span></label>
                        <select class="form-control" name="id_file" id="id_file" required>
                            <option value="">-- Pilih Jenis Surat --</option>
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
                        <i class="fas fa-upload mr-1"></i> Upload Surat
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel File -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Surat Penerimaan Magang</h6>
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
                                            <a href="<?= base_url('sekretariat/upload-surat-penerimaan/download/' . $f->id_file_selesai_magang) ?>" class="btn btn-sm btn-success" title="Download">
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
                    <h5 class="modal-title"><i class="fas fa-edit mr-2"></i>Ganti Surat Penerimaan</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>File saat ini: <strong id="nama_file_lama"></strong></p>
                    <div class="form-group">
                        <label for="edit_id_file">Jenis Surat <span class="text-danger">*</span></label>
                        <select class="form-control" name="id_file" id="edit_id_file" required>
                            <option value="">-- Pilih Jenis Surat --</option>
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
    $('.btn-ganti-file').on('click', function() {
        var idSelesai = $(this).data('id');
        var idFile = $(this).data('idfile');
        var namaFile = $(this).data('namafile');

        $('#formGantiFile').attr('action', '<?= base_url('sekretariat/upload-surat-penerimaan/update/') ?>' + idSelesai);
        $('#edit_id_file').val(idFile);
        $('#nama_file_lama').text(namaFile);
        
        $('#modalGantiFile').modal('show');
    });
});
</script>
<?= $this->endSection() ?>
