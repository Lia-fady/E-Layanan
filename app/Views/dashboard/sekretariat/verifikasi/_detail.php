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
    $labelKeahlian = 'Judul atau Topik Skripsi/TA';
    $labelDeskripsi = 'Fokus Penelitian / Data yang Dicari';
} elseif (strpos($jenisPermohonanText, 'observasi') !== false || strpos($jenisPermohonanText, 'pengambilan data') !== false) {
    $labelKeahlian = 'Tujuan Observasi / Nama Mata Kuliah';
    $labelDeskripsi = 'Daftar Kebutuhan Data';
} elseif (strpos($jenisPermohonanText, 'uji coba') !== false || strpos($jenisPermohonanText, 'prototype') !== false) {
    $labelKeahlian = 'Nama dan Profil Singkat Sistem';
    $labelDeskripsi = 'Skenario Pengujian / Target Pengguna';
} else {
    $labelKeahlian = 'Keahlian Utama';
    $labelDeskripsi = 'Apa yang ingin Anda kerjakan?';
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

<div class="verifikasi-detail-container pb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="m-0 font-weight-bold" style="color: #111827;">
            Detail Verifikasi Permohonan
        </h5>
        <!-- The button functionality matches existing ones -->
        <button type="button" class="btn btn-outline-secondary btn-sm bg-white" id="btnKembaliTop" onclick="$('#btnKembali').click()">
            Kembali
        </button>
    </div>
    
    <form id="formVerifikasiDetail" action="<?= base_url('sekretariat/verifikasi/prosesModal') ?>" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="id_permohonan_magang" value="<?= $permohonan->id_permohonan_magang ?>">
        
        <?php if ($isLocked) : ?>
            <div class="alert alert-info mb-4" style="border-radius: 8px; border: 1px solid #bae6fd; background-color: #f0f9ff; color: #0369a1; font-size: 13px;">
                <i class="fas fa-lock mr-2"></i>
                <?= $lockMessage ?>
            </div>
        <?php endif; ?>

        <!-- Card 1: Data Lengkap Pemohon - Layout Profile Kiri + Detail Kanan -->
        <div class="card bg-white mb-4 border-0 shadow-sm" style="border-radius: 8px; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06) !important; overflow: hidden;">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4">
                <h6 class="m-0 font-weight-bold" style="color: #0f172a; font-size: 16px;">Data Lengkap Pemohon</h6>
            </div>
            <div class="card-body p-0">
                <hr class="m-0" style="border-top: 1px solid #f1f5f9;">

                <div class="detail-pemohon">
                    <!-- Panel Kiri - Profile Pemohon -->
                    <div class="detail-pemohon__profile" style="width: 25%; min-width: 200px; max-width: 280px;">
                        <div class="detail-pemohon__avatar">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div class="detail-pemohon__name"><?= esc($permohonan->nama_mahasiswa ?? '-') ?></div>
                        <span class="detail-pemohon__badge">
                            <i class="fas fa-briefcase mr-1" style="font-size: 0.65rem;"></i>
                            <?= esc($permohonan->jenis_permohonan ?? 'Permohonan') ?>
                        </span>
                        <div class="detail-pemohon__meta mt-2">
                            <?= esc($permohonan->instansi_pendidikan ?? '-') ?>
                        </div>
                    </div>

                    <!-- Panel Kanan - Detail Informasi -->
                    <div class="detail-pemohon__content">

                        <!-- Section 1: Informasi Pribadi -->
                        <div class="detail-pemohon__section">
                            <div class="detail-pemohon__section-title">
                                <i class="fas fa-user"></i> Informasi Pribadi
                            </div>
                            <div class="row">
                                <div class="col-sm-4 detail-pemohon__field">
                                    <span class="detail-pemohon__label">Nama Lengkap</span>
                                    <span class="detail-pemohon__value"><?= esc($permohonan->nama_mahasiswa ?? '-') ?></span>
                                </div>
                                <div class="col-sm-4 detail-pemohon__field">
                                    <span class="detail-pemohon__label">NIK</span>
                                    <span class="detail-pemohon__value"><?= esc($permohonan->nik ?? '-') ?></span>
                                </div>
                                <div class="col-sm-4 detail-pemohon__field">
                                    <span class="detail-pemohon__label">No. Telepon</span>
                                    <span class="detail-pemohon__value"><?= esc($permohonan->no_telp ?? '-') ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Informasi Pendidikan -->
                        <div class="detail-pemohon__section">
                            <div class="detail-pemohon__section-title">
                                <i class="fas fa-graduation-cap"></i> Informasi Pendidikan
                            </div>
                            <div class="row">
                                <div class="col-sm-6 detail-pemohon__field">
                                    <span class="detail-pemohon__label">Universitas / Institusi / Sekolah</span>
                                    <span class="detail-pemohon__value"><?= esc($permohonan->instansi_pendidikan ?? '-') ?></span>
                                </div>
                                <div class="col-sm-6 detail-pemohon__field">
                                    <span class="detail-pemohon__label">Jenjang Pendidikan</span>
                                    <span class="detail-pemohon__value"><?= esc($permohonan->jenjang_pendidikan ?? '-') ?></span>
                                </div>
                                <?php if (!empty($permohonan->nama_fakultas)) : ?>
                                <div class="col-sm-6 detail-pemohon__field mt-2">
                                    <span class="detail-pemohon__label">Fakultas</span>
                                    <span class="detail-pemohon__value"><?= esc($permohonan->nama_fakultas) ?></span>
                                </div>
                                <?php endif; ?>
                                <div class="col-sm-6 detail-pemohon__field mt-2">
                                    <span class="detail-pemohon__label">Jurusan / Program Studi</span>
                                    <span class="detail-pemohon__value"><?= esc($permohonan->nama_prodi ?? '-') ?></span>
                                </div>
                                <?php if (!empty($permohonan->angkatan_tahun)) : ?>
                                <div class="col-sm-6 detail-pemohon__field mt-2">
                                    <span class="detail-pemohon__label">Tahun Angkatan</span>
                                    <span class="detail-pemohon__value"><?= esc($permohonan->angkatan_tahun) ?></span>
                                </div>
                                <?php endif; ?>
                                <div class="col-sm-6 detail-pemohon__field mt-2">
                                    <span class="detail-pemohon__label"><?= (!empty($permohonan->kelas)) ? 'Kelas' : 'Semester' ?></span>
                                    <span class="detail-pemohon__value"><?= esc(!empty($permohonan->kelas) ? $permohonan->kelas : ($permohonan->semester ?? '-')) ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Alamat -->
                        <div class="detail-pemohon__section">
                            <div class="detail-pemohon__section-title">
                                <i class="fas fa-map-marker-alt"></i> Alamat
                            </div>
                            <div class="row">
                                <div class="col-sm-4 detail-pemohon__field">
                                    <span class="detail-pemohon__label">Provinsi</span>
                                    <span class="detail-pemohon__value"><?= esc($permohonan->provinsi ?? '-') ?></span>
                                </div>
                                <div class="col-sm-4 detail-pemohon__field">
                                    <span class="detail-pemohon__label">Kabupaten / Kota</span>
                                    <span class="detail-pemohon__value"><?= esc($permohonan->kabupaten_kota ?? '-') ?></span>
                                </div>
                                <div class="col-sm-4 detail-pemohon__field">
                                    <span class="detail-pemohon__label">Kecamatan</span>
                                    <span class="detail-pemohon__value"><?= esc($permohonan->kecamatan ?? '-') ?></span>
                                </div>
                                <div class="col-sm-4 detail-pemohon__field">
                                    <span class="detail-pemohon__label">Kelurahan</span>
                                    <span class="detail-pemohon__value"><?= esc($permohonan->kelurahan ?? '-') ?></span>
                                </div>
                                <div class="col-sm-4 detail-pemohon__field">
                                    <span class="detail-pemohon__label">RT / RW</span>
                                    <span class="detail-pemohon__value"><?= esc($permohonan->rt ?? '-') ?> / <?= esc($permohonan->rw ?? '-') ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Section 4: Informasi Pengajuan -->
                        <div class="detail-pemohon__section">
                            <div class="detail-pemohon__section-title">
                                <i class="fas fa-file-alt"></i> Informasi Pengajuan
                            </div>
                            <div class="row">
                                <div class="col-sm-4 detail-pemohon__field">
                                    <span class="detail-pemohon__label">Jenis Kegiatan</span>
                                    <span class="detail-pemohon__value"><?= esc($permohonan->jenis_permohonan ?? '-') ?></span>
                                </div>
                                <div class="col-sm-4 detail-pemohon__field">
                                    <span class="detail-pemohon__label">Tanggal Pengajuan</span>
                                    <span class="detail-pemohon__value"><?= tgl_indo($permohonan->created_at, true) ?></span>
                                </div>
                                <div class="col-sm-4 detail-pemohon__field">
                                    <span class="detail-pemohon__label">Periode Kegiatan</span>
                                    <span class="detail-pemohon__value">
                                        <?= tgl_indo($permohonan->tgl_mulai) ?> <span class="text-muted">s/d</span> <?= tgl_indo($permohonan->tgl_selesai) ?>
                                    </span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12 detail-pemohon__field">
                                    <span class="detail-pemohon__label"><?= esc($labelKeahlian) ?></span>
                                    <div class="detail-pemohon__desc-box mt-1">
                                        <?= !empty($permohonan->deskripsi_keahlian) ? nl2br(esc($permohonan->deskripsi_keahlian)) : '<em>Belum diisi</em>' ?>
                                    </div>
                                </div>
                                <div class="col-12 detail-pemohon__field mb-0">
                                    <span class="detail-pemohon__label"><?= esc($labelDeskripsi) ?></span>
                                    <div class="detail-pemohon__desc-box mt-1">
                                        <?= !empty($permohonan->rencana_kegiatan) ? nl2br(esc($permohonan->rencana_kegiatan)) : '<em>Belum diisi</em>' ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- End Panel Kanan -->
                </div>

            </div>
        </div>

        <!-- Card 2: Dokumen yang Diajukan (full-width) -->
        <div class="card bg-white mb-4 border-0 shadow-sm" style="border-radius: 8px; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06) !important; overflow: hidden;">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4">
                <h6 class="m-0 font-weight-bold" style="color: #0f172a; font-size: 16px;">Dokumen yang Diajukan</h6>
            </div>
            <div class="card-body p-0 d-flex flex-column justify-content-between">
                <div>
                    <hr class="m-0" style="border-top: 1px solid #f1f5f9;">
                    <div class="table-responsive">
                        <table class="table table-borderless m-0" style="font-size: 12px;">
                            <thead>
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <th width="5%" class="text-center py-3 text-uppercase" style="font-size: 12px; font-weight: 600; color: #64748b;">NO.</th>
                                    <th class="py-3 text-uppercase" style="font-size: 12px; font-weight: 600; color: #64748b;">NAMA DOKUMEN</th>
                                    <th width="15%" class="text-center py-3 text-uppercase" style="font-size: 12px; font-weight: 600; color: #64748b;">FILE</th>
                                    <th width="40%" class="py-3 text-uppercase" style="font-size: 12px; font-weight: 600; color: #64748b;">VERIFIKASI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($files)) : ?>
                                    <?php $no = 1; foreach ($files as $f) : ?>
                                        <?php $fStatus = $f->status_verifikasi ?? ''; ?>
                                        <tr style="border-bottom: 1px solid #f8fafc;">
                                            <td class="text-center align-middle py-3" style="color: #64748b; font-size: 14px;"><?= $no++ ?></td>
                                            <td class="align-middle py-3 font-weight-500" style="color: #1e293b; font-size: 14px;"><?= esc($f->nama_file_master ?? 'Dokumen') ?></td>
                                            <td class="text-center align-middle py-3">
                                                <a href="<?= base_url($f->path_file) ?>" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-3 py-1" style="font-size: 11px; font-weight: 500;" title="Lihat Berkas">
                                                    Lihat
                                                </a>
                                            </td>
                                            <td class="align-middle py-3">
                                                <div class="d-flex align-items-center" style="gap: 16px;">
                                                    <input type="hidden" name="file_status[<?= $f->id_file_permohonan_magang ?>]" value="<?= esc($fStatus) ?>" required>
                                                    
                                                    <!-- Using checkbox to preserve existing javascript mechanism -->
                                                    <div class="custom-control custom-checkbox custom-control-inline d-flex align-items-center mb-0">
                                                        <input type="checkbox" class="custom-control-input cb-sesuai" id="cb_sesuai_<?= $f->id_file_permohonan_magang ?>" data-id="<?= $f->id_file_permohonan_magang ?>" <?= $fStatus === 'SESUAI' ? 'checked' : '' ?> <?= $isLocked ? 'disabled' : '' ?>>
                                                        <label class="custom-control-label" for="cb_sesuai_<?= $f->id_file_permohonan_magang ?>" style="padding-top: 2px; cursor: pointer; color: #334155; font-size: 13px;">
                                                            Sesuai
                                                        </label>
                                                    </div>

                                                    <div class="custom-control custom-checkbox custom-control-inline d-flex align-items-center mb-0 mr-0">
                                                        <input type="checkbox" class="custom-control-input cb-tidak-sesuai" id="cb_tdk_sesuai_<?= $f->id_file_permohonan_magang ?>" data-id="<?= $f->id_file_permohonan_magang ?>" <?= $fStatus === 'TIDAK_SESUAI' ? 'checked' : '' ?> <?= $isLocked ? 'disabled' : '' ?>>
                                                        <label class="custom-control-label" for="cb_tdk_sesuai_<?= $f->id_file_permohonan_magang ?>" style="padding-top: 2px; cursor: pointer; color: #334155; font-size: 13px;">
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
                    </div>
                </div>
                <?php if (!$isLocked) : ?>
                <div class="px-4 py-3" style="background-color: #f8fafc; border-top: 1px solid #f1f5f9; font-size: 11px; color: #64748b;">
                    <i class="fas fa-info-circle mr-1" style="color: #64748b;"></i> Jika berkas Tidak Sesuai, status menjadi Perbaikan Berkas dan disposisi batal.
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Card 4: Disposisi dan Catatan -->
        <div class="card bg-white mb-4 border-0 shadow-sm" style="border-radius: 8px; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06) !important;">
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <?php if (!$isLocked) : ?>
                            <div class="form-group mb-0 pr-md-3">
                                <label for="id_bidang" class="d-block font-weight-bold mb-2" style="font-size: 14px; color: #0f172a;">Pilih Bidang Tujuan <span class="text-danger">*</span></label>
                                <select name="id_bidang" id="id_bidang" class="form-control form-control-sm border" style="font-size: 14px; border-radius: 4px; border-color: #e2e8f0 !important; height: 38px;">
                                    <option value="" data-kuota="">Pilih bidang yang sesuai...</option>
                                    <?php foreach ($bidang as $b) : ?>
                                        <option value="<?= $b->id_bidang ?>" data-kuota="<?= $b->sisa_kuota ?>" data-bulan-penuh="<?= esc($b->kuota_penuh_di_bulan ?? '') ?>" <?= (isset($selected_bidang) && $selected_bidang == $b->id_bidang) ? 'selected' : '' ?>>
                                            <?= esc($b->bidang) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="info_kuota_bidang" class="mt-2" style="display: none; font-size: 12px;"></div>
                            </div>
                        <?php else : ?>
                            <?php if (!empty($selected_bidang)) : ?>
                                <div class="form-group mb-0 pr-md-3">
                                    <label class="d-block font-weight-bold mb-2" style="font-size: 14px; color: #0f172a;">Bidang Tujuan</label>
                                    <select class="form-control form-control-sm border bg-light" style="font-size: 14px; border-radius: 4px; border-color: #e2e8f0 !important; height: 38px;" disabled>
                                        <?php foreach ($bidang as $b) : ?>
                                            <?php if ($b->id_bidang == $selected_bidang) : ?>
                                                <option selected><?= esc($b->bidang) ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-md-6">
                        <?php if (!$isLocked) : ?>
                            <div class="form-group mb-0 pl-md-3">
                                <label for="catatan_manual" class="d-block font-weight-bold mb-2" style="font-size: 14px; color: #0f172a;">Catatan Verifikasi <span class="font-weight-normal text-muted" style="font-size: 13px;">(Opsional)</span></label>
                                <textarea name="catatan_manual" id="catatan_manual" class="form-control form-control-sm border" rows="3" style="font-size: 14px; border-radius: 4px; border-color: #e2e8f0 !important; padding: 10px;" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                            </div>
                        <?php endif; ?>

                        <?php if ($isLocked && !empty($permohonan->catatan)) : ?>
                            <div class="form-group mb-0 pl-md-3">
                                <label class="d-block font-weight-bold mb-2" style="font-size: 14px; color: #0f172a;">Catatan Verifikasi</label>
                                <div class="border rounded px-3 py-2 bg-light" style="font-size: 14px; color: #334155; min-height: 40px; border-color: #e2e8f0 !important;">
                                    <?= nl2br(esc($permohonan->catatan)) ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons - KEPT EXACTLY SAME CLASSES AND IDS -->
        <div class="d-flex justify-content-end mt-4 mb-2">
            <input type="hidden" name="action_type" id="action_type" value="">
            
            <?php if (!$isLocked) : ?>
                <!-- Order updated: Simpan (kiri), Tolak (tengah), Kembali (kanan) -->
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

<script>
    $(document).ready(function() {
        $('#id_bidang').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var sisa_kuota = selectedOption.data('kuota');
            var bulan_penuh = selectedOption.data('bulan-penuh');
            var infoBox = $('#info_kuota_bidang');
            
            if (sisa_kuota !== undefined && sisa_kuota !== '') {
                infoBox.show();
                if (sisa_kuota == 1) {
                    infoBox.html('<i class="fas fa-check-circle text-success mr-1"></i> <span class="text-success">Seluruh bulan pada periode kegiatan <strong>Tersedia</strong></span>');
                } else {
                    infoBox.html('<i class="fas fa-exclamation-circle text-danger mr-1"></i> <span class="text-danger">Kuota tidak tersedia pada <strong>' + (bulan_penuh || 'bulan tertentu') + '</strong>.</span>');
                }
            } else {
                infoBox.hide();
            }
        });
    });
</script>
