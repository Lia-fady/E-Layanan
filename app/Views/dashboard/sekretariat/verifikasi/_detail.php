<?php
/**
 * ============================================================
 * Kode      : _detail.php
 * Path      : Views/dashboard/sekretariat/verifikasi/_detail.php
 * Deskripsi : Partial view untuk detail verifikasi tanpa modal.
 * ============================================================
 */

$jenisPermohonanText = strtolower(trim($permohonan->jenis_permohonan ?? ''));
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

/**
 * LOGIKA LOCKING:
 * - Keputusan yang sudah tersimpan (status != MENUNGGU) akan TERKUNCI sepenuhnya.
 * - Locking berdasarkan DATA DATABASE, bukan hanya frontend.
 * - Status MENUNGGU = belum diverifikasi = masih bisa diedit.
 * - Status DISETUJUI / PERBAIKAN_BERKAS / DITOLAK = sudah final = LOCKED.
 */
$isLocked = false;
$lockMessage = '';
$statusPersetujuan = $permohonan->status_persetujuan ?? 'MENUNGGU';

if ($statusPersetujuan === 'DITOLAK') {
    $isLocked = true;
    $lockMessage = 'Verifikasi sudah final. Permohonan ini telah <strong>Ditolak secara permanen</strong>.';
} elseif ($statusPersetujuan === 'PERBAIKAN_BERKAS') {
    $isLocked = true;
    $lockMessage = 'Verifikasi sudah final. Berkas dikembalikan ke mahasiswa untuk <strong>Perbaikan</strong>.';
} elseif ($statusPersetujuan === 'DISETUJUI') {
    $isLocked = true;
    $statusPenempatanText = $status_penempatan ?? 'MENUNGGU';
    if ($statusPenempatanText === 'BERJALAN') {
        $lockMessage = 'Verifikasi sudah final. Mahasiswa sedang <strong>menjalani magang</strong>.';
    } elseif ($statusPenempatanText === 'SELESAI') {
        $lockMessage = 'Verifikasi sudah final. Magang telah <strong>Selesai</strong>.';
    } else {
        $lockMessage = 'Verifikasi sudah final. Permohonan <strong>Disetujui</strong> dan sedang menunggu persetujuan bidang.';
    }
}
?>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold" style="color: #1B2559;">
            <i class="fas fa-check-circle mr-2"></i> Detail Verifikasi Permohonan
        </h5>
        <button type="button" class="btn btn-outline-secondary btn-sm" id="btnKembali">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </button>
    </div>
    
    <div class="card-body p-4">
        <form id="formVerifikasiDetail" action="<?= base_url('sekretariat/verifikasi/prosesModal') ?>" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="id_permohonan_magang" value="<?= $permohonan->id_permohonan_magang ?>">
            
            <?php if ($isLocked) : ?>
                <div class="alert alert-info mb-4">
                    <i class="fas fa-lock mr-2"></i>
                    <?= $lockMessage ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <!-- Kolom Kiri: Informasi & Disposisi -->
                <div class="col-md-5">
                    <h6 class="mb-3 font-weight-bold" style="color: #1B2559;">Informasi Pemohon</h6>
                    <table class="table table-sm table-borderless mb-4">
                        <tr>
                            <td width="40%" class="text-muted">Nama Mahasiswa</td>
                            <td width="2%">:</td>
                            <td><strong><?= esc($permohonan->nama_mahasiswa ?? '-') ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">NIK</td>
                            <td>:</td>
                            <td><?= esc($permohonan->nik ?? '-') ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">No. Telepon</td>
                            <td>:</td>
                            <td><?= esc($permohonan->no_telp ?? '-') ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Prodi / Fakultas</td>
                            <td>:</td>
                            <td><?= esc($permohonan->nama_prodi ?? '-') ?> / <?= esc($permohonan->nama_fakultas ?? '-') ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Universitas</td>
                            <td>:</td>
                            <td><?= esc($permohonan->instansi_pendidikan ?? '-') ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Tanggal Pengajuan</td>
                            <td>:</td>
                            <td><?= tgl_indo($permohonan->created_at, true) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Jenis Kegiatan</td>
                            <td>:</td>
                            <td><strong><?= esc($permohonan->jenis_permohonan ?? '-') ?></strong></td>
                        </tr>

                        <tr>
                            <td class="text-muted">Periode Magang</td>
                            <td>:</td>
                            <td>
                                <?= tgl_indo($permohonan->tgl_mulai) ?> 
                                s/d 
                                <?= tgl_indo($permohonan->tgl_selesai) ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Status Saat Ini</td>
                            <td>:</td>
                            <td>
                                <?php
                                    $status = $permohonan->status_persetujuan ?? 'MENUNGGU';
                                    $badge = 'badge-secondary';
                                    if ($status == 'DISETUJUI') $badge = 'badge-success';
                                    if ($status == 'PERBAIKAN_BERKAS') $badge = 'badge-danger';
                                    if ($status == 'DITOLAK') $badge = 'badge-dark';
                                    if ($status == 'MENUNGGU_KABID' || $status == 'MENUNGGU_BIDANG') {
                                        $badge = 'badge-warning';
                                        $status = 'MENUNGGU BIDANG';
                                    }
                                ?>
                                <span class="badge <?= $badge ?>"><?= $status ?></span>
                            </td>
                        </tr>
                    </table>

                    <h6 class="mb-3 font-weight-bold" style="color: #1B2559; border-top: 1px solid #eee; padding-top: 15px;">Data Permohonan</h6>
                    <div class="card bg-light border-0 mb-4">
                        <div class="card-body p-3">
                            <div class="mb-3">
                                <span class="text-muted d-block" style="font-size: 0.9rem;"><?= esc($labelKeahlian) ?></span>
                                <strong style="font-size: 0.95rem;">
                                    <?= !empty($permohonan->deskripsi_keahlian) ? esc($permohonan->deskripsi_keahlian) : 'Belum diisi' ?>
                                </strong>
                            </div>
                            <div>
                                <span class="text-muted d-block" style="font-size: 0.9rem;"><?= esc($labelDeskripsi) ?></span>
                                <strong style="font-size: 0.95rem;">
                                    <?= !empty($permohonan->rencana_kegiatan) ? esc($permohonan->rencana_kegiatan) : 'Belum diisi' ?>
                                </strong>
                            </div>
                        </div>
                    </div>

                    <?php if (!$isLocked) : ?>
                    <h6 class="mb-3 font-weight-bold" style="color: #1B2559; border-top: 1px solid #eee; padding-top: 15px;">Disposisi ke Bidang</h6>
                    <div class="form-group mb-4">
                        <label for="id_bidang" class="text-muted" style="font-size: 0.9rem;">Pilih Bidang Tujuan <i>(Hanya diproses jika semua dokumen Sesuai)</i></label>
                        <select name="id_bidang" id="id_bidang" class="form-control">
                            <option value="" data-kuota="">-- Pilih Bidang Tujuan --</option>
                            <?php foreach ($bidang as $b) : ?>
                                <option value="<?= $b->id_bidang ?>" data-kuota="<?= $b->sisa_kuota ?>" <?= (isset($selected_bidang) && $selected_bidang == $b->id_bidang) ? 'selected' : '' ?>>
                                    <?= esc($b->bidang) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div id="info_kuota_bidang" class="mt-2" style="display: none; font-size: 0.85rem; font-weight: 500;">
                            <!-- Info kuota akan muncul di sini -->
                        </div>
                    </div>
                    <?php else : ?>
                    <?php if (!empty($selected_bidang)) : ?>
                    <h6 class="mb-3 font-weight-bold" style="color: #1B2559; border-top: 1px solid #eee; padding-top: 15px;">Disposisi ke Bidang</h6>
                    <div class="form-group mb-4">
                        <label class="text-muted" style="font-size: 0.9rem;">Bidang Tujuan</label>
                        <select class="form-control" disabled>
                            <?php foreach ($bidang as $b) : ?>
                                <?php if ($b->id_bidang == $selected_bidang) : ?>
                                    <option selected><?= esc($b->bidang) ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($isLocked && !empty($permohonan->catatan)) : ?>
                    <h6 class="mb-3 font-weight-bold" style="color: #1B2559; border-top: 1px solid #eee; padding-top: 15px;">Catatan Verifikasi</h6>
                    <div class="card bg-light border-0 mb-4">
                        <div class="card-body p-3">
                            <p class="mb-0" style="font-size: 0.95rem;"><?= esc($permohonan->catatan) ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Kolom Kanan: Dokumen -->
                <div class="col-md-7">
                    <h6 class="mb-3 font-weight-bold" style="color: #1B2559;">Dokumen yang Diajukan</h6>
                    <div class="table-responsive">
                        <table class="table table-borderless table-sm">
                            <thead class="thead-light">
                                <tr style="border-bottom: 2px solid #eee;">
                                    <th width="5%" class="text-center">No</th>
                                    <th>Nama Dokumen</th>
                                    <th class="text-center">File</th>
                                    <th width="40%" class="text-center">Verifikasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($files)) : ?>
                                    <?php $no = 1; foreach ($files as $f) : ?>
                                        <?php $fStatus = $f->status_verifikasi ?? ''; ?>
                                        <tr>
                                            <td class="text-center align-middle"><?= $no++ ?></td>
                                            <td class="align-middle"><?= esc($f->nama_file_master ?? 'Dokumen') ?></td>
                                            <td class="text-center align-middle">
                                                <a href="<?= base_url($f->path_file) ?>" target="_blank" class="btn btn-sm btn-info" title="Lihat Berkas">
                                                    <i class="fas fa-file-pdf"></i> Lihat
                                                </a>
                                            </td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center align-items-center" style="gap: 10px;">
                                                    <input type="hidden" name="file_status[<?= $f->id_file_permohonan_magang ?>]" value="<?= esc($fStatus) ?>" required>
                                                    
                                                    <div class="custom-control custom-checkbox custom-control-inline d-flex align-items-center mb-0">
                                                        <input type="checkbox" class="custom-control-input cb-sesuai" id="cb_sesuai_<?= $f->id_file_permohonan_magang ?>" data-id="<?= $f->id_file_permohonan_magang ?>" <?= $fStatus === 'SESUAI' ? 'checked' : '' ?> <?= $isLocked ? 'disabled' : '' ?>>
                                                        <label class="custom-control-label font-weight-bold" for="cb_sesuai_<?= $f->id_file_permohonan_magang ?>" style="padding-top: 2px; cursor: pointer; color: <?= $fStatus === 'SESUAI' ? '#28a745' : '#6c757d' ?>;">
                                                            Sesuai
                                                        </label>
                                                    </div>

                                                    <div class="custom-control custom-checkbox custom-control-inline d-flex align-items-center mb-0">
                                                        <input type="checkbox" class="custom-control-input cb-tidak-sesuai" id="cb_tdk_sesuai_<?= $f->id_file_permohonan_magang ?>" data-id="<?= $f->id_file_permohonan_magang ?>" <?= $fStatus === 'TIDAK_SESUAI' ? 'checked' : '' ?> <?= $isLocked ? 'disabled' : '' ?>>
                                                        <label class="custom-control-label font-weight-bold" for="cb_tdk_sesuai_<?= $f->id_file_permohonan_magang ?>" style="padding-top: 2px; cursor: pointer; color: <?= $fStatus === 'TIDAK_SESUAI' ? '#dc3545' : '#6c757d' ?>;">
                                                            Tidak Sesuai
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <?php if (!$isLocked) : ?>
                        <small class="text-muted d-block mt-2"><i class="fas fa-info-circle"></i> Jika ada berkas <b>Tidak Sesuai</b>, status permohonan otomatis menjadi <b>Perbaikan Berkas</b> dan disposisi dibatalkan.</small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <hr>
            <?php if (!$isLocked) : ?>
            <div class="form-group mb-4">
                <label for="catatan_manual" class="fw-bold" style="color: #1B2559;"><i class="fas fa-edit mr-1"></i> Catatan Tambahan <i>(Opsional)</i></label>
                <textarea name="catatan_manual" id="catatan_manual" class="form-control" rows="3" placeholder="Tulis alasan jika ada berkas yang tidak sesuai..."></textarea>
                <small class="text-muted">Jika dikosongkan, sistem akan menggunakan catatan standar.</small>
            </div>
            <?php endif; ?>

            <div class="d-flex justify-content-end mt-3">
                <input type="hidden" name="action_type" id="action_type" value="">
                <?php if (!$isLocked) : ?>
                    <button type="submit" class="btn btn-primary mr-2" id="btnSimpanKeputusan">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-danger mr-2" id="btnTolakMutlak">
                        <i class="fas fa-times-circle mr-1"></i> Tolak
                    </button>
                <?php else : ?>
                    <button type="button" class="btn btn-secondary mr-2" disabled>
                        <i class="fas fa-lock mr-1"></i> Verifikasi Terkunci
                    </button>
                <?php endif; ?>
                <button type="button" class="btn btn-secondary" id="btnKembali">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#id_bidang').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var kuota = selectedOption.data('kuota');
            var infoBox = $('#info_kuota_bidang');
            
            if (kuota !== undefined && kuota !== '') {
                infoBox.show();
                if (kuota > 0) {
                    infoBox.html('<i class="bi bi-info-circle text-primary me-1"></i> <span class="text-primary">Sisa Kuota Tersedia: <strong>' + kuota + ' Orang</strong></span>');
                } else {
                    infoBox.html('<i class="bi bi-exclamation-circle text-danger me-1"></i> <span class="text-danger">Sisa Kuota Tersedia: <strong>0 Orang (Penuh)</strong></span>');
                }
            } else {
                infoBox.hide();
            }
        });
    });
</script>
