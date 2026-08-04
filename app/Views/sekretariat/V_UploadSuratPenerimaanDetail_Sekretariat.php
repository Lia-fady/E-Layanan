<?php
/**
 * ============================================================
 * Kode      : _detail.php
 * Path      : Views/dashboard/sekretariat/upload_surat_penerimaan/_detail.php
 * Deskripsi : Partial view untuk form Upload Surat Penerimaan.
 * ============================================================
 */

$jenisPermohonanText = strtolower(trim($persetujuan->jenis_permohonan ?? ''));
if (strpos($jenisPermohonanText, 'penelitian') !== false || strpos($jenisPermohonanText, 'skripsi') !== false || strpos($jenisPermohonanText, 'ta') !== false) {
    $labelKeahlian = 'Deskripsi Judul Skripsi / TA';
    $labelDeskripsi = 'Deskripsi Rencana Topik / Rumusan Masalah';
} elseif (strpos($jenisPermohonanText, 'observasi') !== false || strpos($jenisPermohonanText, 'pengambilan data') !== false) {
    $labelKeahlian = 'Deskripsi Latar Belakang Observasi';
    $labelDeskripsi = 'Deskripsi Daftar Kebutuhan Data';
} elseif (strpos($jenisPermohonanText, 'uji coba') !== false || strpos($jenisPermohonanText, 'prototype') !== false) {
    $labelKeahlian = 'Deskripsi Profil Aplikasi / Sistem';
    $labelDeskripsi = 'Deskripsi Skenario Uji Coba / Metode';
} else {
    $labelKeahlian = 'Deskripsi Keahlian / Skill';
    $labelDeskripsi = 'Deskripsi Rencana Magang / Kegiatan';
}
?>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold" style="color: #1B2559;">
            <i class="fas fa-file-upload mr-2"></i> Detail & Upload Surat Penerimaan Magang
        </h5>
        <button type="button" class="btn btn-outline-secondary btn-sm" id="btnKembali">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </button>
    </div>
    
    <div class="card-body p-4">
        <!-- SEKSI 1: INFORMASI PEMOHON DAN KEAHLIAN -->
        <div class="row">
            <div class="col-md-5">
                <h6 class="mb-3 font-weight-bold" style="color: #1B2559;">Informasi Pemohon</h6>
                <table class="table table-sm table-borderless mb-4">
                    <tr>
                        <td width="40%" class="text-muted">Nama Mahasiswa</td>
                        <td width="2%">:</td>
                        <td><strong><?= esc($persetujuan->nama_mahasiswa ?? '-') ?></strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">NIK</td>
                        <td>:</td>
                        <td><?= esc($persetujuan->nik ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">No. Telepon</td>
                        <td>:</td>
                        <td><?= esc($persetujuan->no_telp ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Prodi / Fakultas</td>
                        <td>:</td>
                        <td><?= esc($persetujuan->prodi ?? '-') ?> / <?= esc($persetujuan->fakultas ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Universitas</td>
                        <td>:</td>
                        <td><?= esc($persetujuan->instansi_pendidikan ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tanggal Pengajuan</td>
                        <td>:</td>
                        <td><?= !empty($persetujuan->created_at) ? date('d F Y, H:i', strtotime($persetujuan->created_at)) : '-' ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Periode Magang</td>
                        <td>:</td>
                        <td>
                            <?= !empty($persetujuan->tgl_mulai) ? date('d M Y', strtotime($persetujuan->tgl_mulai)) : '-' ?> 
                            s/d 
                            <?= !empty($persetujuan->tgl_selesai) ? date('d M Y', strtotime($persetujuan->tgl_selesai)) : '-' ?>
                        </td>
                    </tr>
                </table>
            </div>
            
            <div class="col-md-7">
                <h6 class="mb-3 font-weight-bold" style="color: #1B2559;">Data Permohonan</h6>
                <div class="card bg-light border-0 mb-4">
                    <div class="card-body p-3">
                        <div class="mb-3">
                            <span class="text-muted d-block" style="font-size: 0.9rem;"><?= esc($labelKeahlian) ?></span>
                            <strong style="font-size: 0.95rem;">
                                <?= !empty($persetujuan->deskripsi_keahlian) ? esc($persetujuan->deskripsi_keahlian) : 'Belum diisi' ?>
                            </strong>
                        </div>
                        <div>
                            <span class="text-muted d-block" style="font-size: 0.9rem;"><?= esc($labelDeskripsi) ?></span>
                            <strong style="font-size: 0.95rem;">
                                <?= !empty($persetujuan->deskripsi) ? esc($persetujuan->deskripsi) : 'Belum diisi' ?>
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="mt-2 mb-4">

        <!-- SEKSI 2: FORM UPLOAD & DAFTAR SURAT -->
        <div class="row">
            <div class="col-md-5">
                <h6 class="mb-3 font-weight-bold" style="color: #1B2559;">Upload Dokumen Baru</h6>
                <form id="formUploadSuratPenerimaan" action="<?= base_url('sekretariat/upload-surat-penerimaan/store') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_persetujuan_magang" value="<?= $persetujuan->id_persetujuan_magang ?>">
                    
                    <div class="form-group">
                        <label for="id_file">Jenis Surat</label>
                        <select name="id_file" id="id_file" class="form-control" required style="pointer-events: none; background-color: #e9ecef;">
                            <!-- Hanya menampilkan Surat Penerimaan Magang (asumsi nama_file = 'Surat Penerimaan Magang') -->
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
                        <input type="file" name="file_surat[]" id="file_surat" class="form-control-file" accept=".pdf,.doc,.docx" required>
                        <small class="form-text text-muted">Format yang diizinkan: PDF, DOC, DOCX. Maksimal 5MB.</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mt-2" id="btnUploadSubmit">
                        <i class="fas fa-upload mr-1"></i> Upload Surat
                    </button>
                </form>
            </div>
            
            <div class="col-md-7">
                <h6 class="mb-3 font-weight-bold" style="color: #1B2559;">Daftar Surat yang Diunggah</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="20%">Jenis File</th>
                                <th>Nama File</th>
                                <th width="15%">Diunggah Oleh</th>
                                <th width="15%">Tanggal Upload</th>
                                <th width="10%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($files)) : ?>
                                <?php $no = 1; foreach ($files as $f) : ?>
                                    <tr>
                                        <td class="text-center align-middle"><?= $no++ ?></td>
                                        <td class="align-middle"><?= esc($f->nama_file_master ?? 'Surat Penerimaan') ?></td>
                                        <td class="align-middle">
                                            <a href="<?= base_url('sekretariat/upload-surat-penerimaan/download/' . $f->id_file_selesai_magang) ?>" target="_blank">
                                                <?= esc($f->nama_file) ?>
                                            </a>
                                        </td>
                                        <td class="align-middle">
                                            <small class="text-muted"><?= esc($f->pengunggah ?? 'Sistem') ?></small>
                                        </td>
                                        <td class="align-middle">
                                            <small><?= !empty($f->created_at) ? date('d M Y H:i', strtotime($f->created_at)) : '-' ?></small>
                                        </td>
                                        <td class="text-center align-middle">
                                            <button type="button" class="btn btn-sm btn-warning btn-ganti-surat mb-1" data-id="<?= $f->id_file_selesai_magang ?>" title="Ganti File">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger btn-delete-surat mb-1" data-id="<?= $f->id_file_selesai_magang ?>" title="Hapus File">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Belum ada surat penerimaan yang diunggah.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Input file tersembunyi untuk Ganti File -->
                <input type="file" id="hiddenFileInput" class="d-none" accept=".pdf,.doc,.docx">
            </div>
        </div>
    </div>
</div>
