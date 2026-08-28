<?php
/**
 * ============================================================
 * Kode      : _detail.php
 * Path      : Views/dashboard/sekretariat/verifikasi/_detail.php
 * Deskripsi : Partial view untuk detail verifikasi tanpa modal.
 * ============================================================
 */

$idJenis = (int)($permohonan->id_jenis_permohonan ?? 0);
if ($idJenis === 1) {
    $labelKeahlian = 'Judul atau Topik Skripsi/Tugas Akhir';
    $labelDeskripsi = 'Fokus Penelitian / Data yang Dicari';
} elseif ($idJenis === 2) {
    $labelKeahlian = 'Tujuan Observasi / Nama Mata Kuliah';
    $labelDeskripsi = 'Daftar Kebutuhan Data';
} elseif ($idJenis === 4) {
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
$statusPersetujuan = $permohonan->status_persetujuan ?? 'MENUNGGU';

if (in_array($statusPersetujuan, ['DITOLAK', 'PERBAIKAN_BERKAS', 'DISETUJUI'])) {
    $isLocked = true;
}

// Mapping status ke label tampilan
$statusLabels = [
    'DISETUJUI'        => 'Disetujui',
    'PERBAIKAN_BERKAS' => 'Perbaikan Berkas',
    'DITOLAK'          => 'Ditolak',
    'MENUNGGU'         => 'Menunggu',
];
$statusLabel = $statusLabels[$statusPersetujuan] ?? $statusPersetujuan;

// Badge class mapping
$statusBadgeClass = [
    'DISETUJUI'        => 'background-color: #dcfce7; color: #166534;',
    'PERBAIKAN_BERKAS' => 'background-color: #fef3c7; color: #92400e;',
    'DITOLAK'          => 'background-color: #fee2e2; color: #991b1b;',
    'MENUNGGU'         => 'background-color: #e0e7ff; color: #3730a3;',
];
$badgeStyle = $statusBadgeClass[$statusPersetujuan] ?? 'background-color: #f1f5f9; color: #64748b;';
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
            <div class="alert mb-4" style="border-radius: 8px; border: 1px solid #e2e8f0; background-color: #f8fafc; color: #334155; font-size: 13px; display: flex; align-items: center; gap: 12px;">
                <span class="px-3 py-1 rounded-pill font-weight-bold" style="<?= $badgeStyle ?> font-size: 12px; white-space: nowrap;">
                    <?= $statusLabel ?>
                </span>
                <?php if ($statusPersetujuan === 'DITOLAK') : ?>
                    Permohonan ini telah <strong>Ditolak</strong>.
                <?php elseif ($statusPersetujuan === 'PERBAIKAN_BERKAS') : ?>
                    Berkas dikembalikan ke mahasiswa untuk <strong>Perbaikan</strong>.
                <?php elseif ($statusPersetujuan === 'DISETUJUI') : ?>
                    <?php
                        $statusPenempatanText = $status_penempatan ?? 'MENUNGGU';
                        if ($statusPenempatanText === 'BERJALAN') {
                            echo 'Mahasiswa sedang<strong>menjalani magang</strong>.';
                        } elseif ($statusPenempatanText === 'SELESAI') {
                            echo 'Magang telah <strong>Selesai</strong>.';
                        } else {
                            echo 'Permohonan<strong>Disetujui</strong>dan sedang menunggu persetujuan bidang.';
                        }
                    ?>
                <?php endif; ?>
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

        <!-- Card 2: Dokumen yang Diajukan (tanpa kolom Aksi/Verifikasi) -->
        <div class="card bg-white mb-4 border-0 shadow-sm" style="border-radius: 8px; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06) !important; overflow: hidden;">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4">
                <h6 class="m-0 font-weight-bold" style="color: #0f172a; font-size: 16px;">Dokumen yang Diajukan</h6>
            </div>
            <div class="card-body p-0">
                <hr class="m-0" style="border-top: 1px solid #f1f5f9;">
                <div class="table-responsive">
                    <table class="table table-borderless m-0" style="font-size: 12px;">
                        <thead>
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <th width="8%" class="text-center py-3 text-uppercase" style="font-size: 12px; font-weight: 600; color: #64748b;">NO.</th>
                                <th class="py-3 text-uppercase" style="font-size: 12px; font-weight: 600; color: #64748b;">NAMA DOKUMEN</th>
                                <th width="15%" class="text-center py-3 text-uppercase" style="font-size: 12px; font-weight: 600; color: #64748b;">FILE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($files)) : ?>
                                <?php $no = 1; foreach ($files as $f) : ?>
                                    <tr style="border-bottom: 1px solid #f8fafc;">
                                        <td class="text-center align-middle py-3" style="color: #64748b; font-size: 14px;"><?= $no++ ?></td>
                                        <td class="align-middle py-3 font-weight-500" style="color: #1e293b; font-size: 14px;"><?= esc($f->nama_file_master ?? 'Dokumen') ?></td>
                                        <td class="text-center align-middle py-3">
                                            <a href="<?= base_url($f->path_file) ?>" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-3 py-1" style="font-size: 11px; font-weight: 500;" title="Lihat Berkas">
                                                Lihat
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted" style="font-size: 13px;">Tidak ada dokumen yang diajukan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php if (!$isLocked) : ?>
        <!-- Card 3: Keputusan Verifikasi (hanya tampil saat belum locked) -->
        <div class="card bg-white mb-4 border-0 shadow-sm" style="border-radius: 8px; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06) !important;">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4">
                <h6 class="m-0 font-weight-bold" style="color: #0f172a; font-size: 16px;">Keputusan Verifikasi</h6>
            </div>
            <div class="card-body p-4 pt-2">
                <!-- Dropdown Keputusan -->
                <div class="form-group mb-3">
                    <label for="keputusan_verifikasi" class="d-block font-weight-bold mb-2" style="font-size: 14px; color: #0f172a;">Keputusan <span class="text-danger">*</span></label>
                    <select name="keputusan_verifikasi" id="keputusan_verifikasi" class="form-control form-control-sm border" style="font-size: 14px; border-radius: 4px; border-color: #e2e8f0 !important; height: 38px; max-width: 400px;">
                        <option value="">Pilih Keputusan</option>
                        <option value="DISETUJUI">Disetujui</option>
                        <option value="PERBAIKAN_BERKAS">Perbaikan Berkas</option>
                        <option value="DITOLAK">Ditolak</option>
                    </select>
                </div>

                <!-- Bidang Tujuan (hanya muncul saat Disetujui) -->
                <div id="section_bidang_tujuan" style="display: none;">
                    <div class="form-group mb-3">
                        <label for="id_bidang" class="d-block font-weight-bold mb-2" style="font-size: 14px; color: #0f172a;">Bidang Tujuan <span class="text-danger">*</span></label>
                        <select name="id_bidang" id="id_bidang" class="form-control form-control-sm border" style="font-size: 14px; border-radius: 4px; border-color: #e2e8f0 !important; height: 38px; max-width: 400px;">
                            <option value="" data-kuota="">Pilih bidang yang sesuai...</option>
                            <?php foreach ($bidang as $b) : ?>
                                <option value="<?= $b->id_bidang ?>" data-kuota="<?= $b->sisa_kuota ?>" data-bulan-penuh="<?= esc($b->kuota_penuh_di_bulan ?? '') ?>" data-detail-kuota="<?= htmlspecialchars(json_encode($b->detail_kuota ?? []), ENT_QUOTES, 'UTF-8') ?>" <?= (isset($selected_bidang) && $selected_bidang == $b->id_bidang) ? 'selected' : '' ?>>
                                    <?= esc($b->bidang) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div id="info_kuota_bidang" class="mt-2" style="display: none; font-size: 12px;"></div>
                    </div>
                </div>

                <!-- Catatan (hanya muncul saat Perbaikan Berkas atau Ditolak) -->
                <div id="section_catatan" style="display: none;">
                    <div class="form-group mb-0">
                        <label for="catatan_manual" class="d-block font-weight-bold mb-2" style="font-size: 14px; color: #0f172a;">Catatan <span class="text-danger" id="catatan_required_mark">*</span></label>
                        <textarea name="catatan_manual" id="catatan_manual" class="form-control form-control-sm border" rows="3" style="font-size: 14px; border-radius: 4px; border-color: #e2e8f0 !important; padding: 10px;" placeholder="Tuliskan catatan untuk pemohon..."></textarea>
                    </div>
                </div>
            </div>
        </div>
        <?php else : ?>
        <!-- Card 3 Locked: Status dan Catatan (read-only) -->
        <div class="card bg-white mb-4 border-0 shadow-sm" style="border-radius: 8px; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06) !important;">
            <div class="card-body p-4">
                <!-- Status -->
                <div class="form-group mb-3">
                    <label class="d-block font-weight-bold mb-2" style="font-size: 14px; color: #0f172a;">Status</label>
                    <span class="px-3 py-1 rounded-pill font-weight-bold" style="<?= $badgeStyle ?> font-size: 13px;">
                        <?= $statusLabel ?>
                    </span>
                </div>

                <?php if (!empty($selected_bidang)) : ?>
                <!-- Bidang Tujuan (read-only) -->
                <div class="form-group mb-3">
                    <label class="d-block font-weight-bold mb-2" style="font-size: 14px; color: #0f172a;">Bidang Tujuan</label>
                    <div class="border rounded px-3 py-2 bg-light" style="font-size: 14px; color: #334155; border-color: #e2e8f0 !important;">
                        <?php foreach ($bidang as $b) : ?>
                            <?php if ($b->id_bidang == $selected_bidang) : ?>
                                <?= esc($b->bidang) ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ($statusPersetujuan !== 'DISETUJUI' && !empty($permohonan->catatan)) : ?>
                <!-- Catatan (read-only, hanya tampil jika ada catatan dan bukan Disetujui) -->
                <div class="form-group mb-0">
                    <label class="d-block font-weight-bold mb-2" style="font-size: 14px; color: #0f172a;">Catatan</label>
                    <div class="border rounded px-3 py-2 bg-light" style="font-size: 14px; color: #334155; min-height: 40px; border-color: #e2e8f0 !important;">
                        <?= nl2br(esc($permohonan->catatan)) ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-end mt-4 mb-2">
            <input type="hidden" name="action_type" id="action_type" value="">
            
            <?php if (!$isLocked) : ?>
                <!-- Tombol aksi kontekstual (hidden by default, muncul setelah dropdown dipilih) -->
                <button type="button" class="btn mr-2" id="btnAksiKeputusan" style="display: none;">
                    <!-- Label dan warna diubah oleh JavaScript -->
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
        // Handler kuota bidang
        $('#id_bidang').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var sisa_kuota = selectedOption.data('kuota');
            var bulan_penuh = selectedOption.data('bulan-penuh');
            var detail_kuota = selectedOption.data('detail-kuota');
            var infoBox = $('#info_kuota_bidang');
            
            if (sisa_kuota !== undefined && sisa_kuota !== '') {
                infoBox.show();
                var html = '';
                if (sisa_kuota == 1) {
                    html += '<div class="mb-1"><i class="fas fa-check-circle text-success mr-1"></i> <span class="text-success">Seluruh bulan pada periode kegiatan <strong>Tersedia</strong></span></div>';
                } else {
                    html += '<div class="mb-1"><i class="fas fa-exclamation-circle text-danger mr-1"></i> <span class="text-danger">Kuota tidak tersedia pada <strong>' + (bulan_penuh || 'bulan tertentu') + '</strong>.</span></div>';
                }

                if (detail_kuota && Array.isArray(detail_kuota) && detail_kuota.length > 0) {
                    html += '<div class="mt-2 border rounded p-2" style="background-color: #f8fafc;">';
                    html += '<div class="font-weight-bold mb-1" style="color: #475569; font-size: 11px;">Ketersediaan Kuota Per Bulan:</div>';
                    html += '<ul class="pl-3 mb-0" style="color: #475569; margin-bottom: 0;">';
                    detail_kuota.forEach(function(item) {
                        var isAvailable = item.sisa > 0;
                        var colorClass = isAvailable ? 'text-success' : 'text-danger';
                        var iconClass = isAvailable ? 'fa-check' : 'fa-times';
                        html += '<li><i class="fas ' + iconClass + ' ' + colorClass + ' mr-1" style="font-size: 10px;"></i> ' + item.bulan + ': <strong>' + item.sisa + '</strong> orang</li>';
                    });
                    html += '</ul></div>';
                }
                
                infoBox.html(html);
            } else {
                infoBox.hide();
            }
        });

        // Handler dropdown keputusan
        $('#keputusan_verifikasi').on('change', function() {
            var keputusan = $(this).val();
            var btnAksi = $('#btnAksiKeputusan');
            var sectionBidang = $('#section_bidang_tujuan');
            var sectionCatatan = $('#section_catatan');

            // Reset semua
            btnAksi.hide();
            sectionBidang.hide();
            sectionCatatan.hide();
            $('#action_type').val('');

            if (keputusan === 'DISETUJUI') {
                // Tampilkan Bidang Tujuan, sembunyikan Catatan
                sectionBidang.show();
                sectionCatatan.hide();
                btnAksi.show()
                    .removeClass('btn-primary btn-warning btn-danger')
                    .addClass('btn-primary')
                    .html('<i class="fas fa-check-circle mr-1"></i> Setujui');
                $('#action_type').val('SETUJUI');
            } else if (keputusan === 'PERBAIKAN_BERKAS') {
                // Tampilkan Catatan, sembunyikan Bidang Tujuan
                sectionBidang.hide();
                sectionCatatan.show();
                $('#catatan_required_mark').show();
                btnAksi.show()
                    .removeClass('btn-primary btn-warning btn-danger')
                    .addClass('btn-warning')
                    .html('<i class="fas fa-paper-plane mr-1"></i> Kirim Perbaikan');
                $('#action_type').val('PERBAIKAN');
            } else if (keputusan === 'DITOLAK') {
                // Tampilkan Catatan, sembunyikan Bidang Tujuan
                sectionBidang.hide();
                sectionCatatan.show();
                $('#catatan_required_mark').show();
                btnAksi.show()
                    .removeClass('btn-primary btn-warning btn-danger')
                    .addClass('btn-danger')
                    .html('<i class="fas fa-times-circle mr-1"></i> Tolak');
                $('#action_type').val('TOLAK');
            }
        });
    });
</script>
