<?php
/**
 * View Partial: Detail Permohonan Mahasiswa
 * Konsep: White Card Timeline (Clean & Modern)
 * Sesuai dengan referensi terbaru
 */
$initials = '';
$namaParts = explode(' ', $p['nama_mahasiswa'] ?? 'M');
$initials = strtoupper(substr($namaParts[0], 0, 1));
if (count($namaParts) > 1) $initials .= strtoupper(substr(end($namaParts), 0, 1));
?>

<style>
/* Reset & Scope untuk Timeline */
.tw-container { max-width: 900px; margin: 0 auto; padding-bottom: 40px; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; }

/* Timeline Item (Simplified without avatar/line) */
.tw-item { position: relative; padding-bottom: 40px; }
.tw-item:last-child { padding-bottom: 0; }

/* Header & Typography */
.tw-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; gap: 12px; }
.tw-header-text { font-size: 0.9rem; line-height: 1.5; color: #6b7280; }
.tw-header-actor { font-weight: 700; color: #111827; }
.tw-header-time { font-size: 0.75rem; color: #9ca3af; margin-top: 4px; display: block; }

/* Badges */
.tw-badge { padding: 4px 12px; border-radius: 9999px; font-size: 0.72rem; font-weight: 600; white-space: nowrap; flex-shrink: 0; }
.tw-badge.pengajuan { background: #eff6ff; color: #3b82f6; }
.tw-badge.disetujui { background: #f0fdf4; color: #22c55e; }
.tw-badge.ditolak { background: #fef2f2; color: #ef4444; }
.tw-badge.perbaikan { background: #fff7ed; color: #f97316; }
.tw-badge.menunggu { background: #fefce8; color: #eab308; }
.tw-badge.netral { background: #f3f4f6; color: #6b7280; }

/* White Card & Tables */
.tw-card { background: #ffffff; border: 1px solid #d1d5db; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05); }
.tw-table { width: 100%; border-collapse: collapse; text-align: left; }
.tw-table th, .tw-table td { padding: 14px 18px; border: 1px solid #e5e7eb; font-size: 0.85rem; vertical-align: top; }
.tw-table th { width: 220px; font-weight: 500; color: #4b5563; background: #f9fafb; border-right: 1px solid #e5e7eb; }
.tw-table td { color: #1f2937; background: #ffffff; }

/* Files inside table */
.tw-file-row { display: flex; align-items: center; padding: 4px 0; }
.tw-file-icon { color: #9ca3af; margin-right: 8px; font-size: 1.1rem; }
.tw-file-name { color: #4b5563; font-size: 0.85rem; flex: 1; word-break: break-all; margin-right: 12px; }
.tw-file-link { color: #6366f1; font-weight: 600; font-size: 0.8rem; text-decoration: none; }
.tw-file-link:hover { text-decoration: underline; color: #4f46e5; }

/* Data Pemohon Section */
.tw-profile-wrapper { margin: 12px 0 18px; }
.tw-section-title { font-size: 0.9rem; font-weight: 700; color: #374151; margin: 0 0 12px; }
.tw-data-wrapper { border: 1px solid #e5e7eb; border-radius: 10px; overflow-x: auto; background: #ffffff; box-shadow: 0 1px 2px rgba(0,0,0,0.03); }
.tw-data-table { width: 100%; border-collapse: collapse; text-align: left; }
.tw-data-table thead th {
    padding: 12px 16px;
    font-size: 0.74rem;
    color: #6b7280;
    font-weight: 700;
    border-bottom: 1px solid #e5e7eb;
    background: #f9fafb;
    white-space: nowrap;
}
.tw-data-table tbody td {
    padding: 14px 16px;
    font-size: 0.85rem;
    color: #111827;
    border-bottom: 1px solid #f3f4f6;
    white-space: nowrap;
    vertical-align: middle;
}
.tw-data-table tbody tr:last-child td { border-bottom: none; }
.tw-data-name {
    font-weight: 700;
    color: #111827;
}

/* Message Boxes inside Card */
.tw-message { padding: 16px 18px; font-size: 0.85rem; color: #374151; line-height: 1.6; }
.tw-message p { margin-bottom: 12px; }
.tw-message p:last-child { margin-bottom: 0; }
.tw-attachment-box { border: 1px solid #e5e7eb; border-radius: 6px; display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; margin: 12px 18px 18px; background: #fafafa; }
.tw-attachment-note { padding: 0 18px 18px; font-size: 0.85rem; color: #374151; }

@media (max-width: 767.98px) {
    .tw-header { flex-direction: column; gap: 8px; }
    .tw-table th { width: 140px; padding: 12px; }
    .tw-table td { padding: 12px; }
}
</style>

<!-- HEADER BACK BUTTON -->
<div class="d-flex align-items-center justify-content-between mb-4 pb-3" style="border-bottom: 1px solid #e5e7eb;">
    <div class="d-flex align-items-center gap-3">
        <button type="button" class="btn btn-light border btn-sm d-flex align-items-center justify-content-center bg-white" style="width:36px; height:36px; border-radius:8px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);" onclick="hideDetail()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="fw-bold text-dark m-0" style="font-size: 1.15rem;">Detail Permohonan</h5>
    </div>
    
    <?php if (empty($p['status_persetujuan']) || !in_array($p['status_persetujuan'], ['DISETUJUI', 'DITOLAK'])): ?>
        <button type="button" class="btn btn-sm btn-outline-danger fw-semibold shadow-sm d-flex align-items-center" style="border-radius: 8px; padding: 6px 16px;" onclick="confirmBatalkan(<?= $p['id_permohonan_magang'] ?>, 'kirim')">
            <i class="bi bi-x-circle me-2"></i> Batalkan Permohonan
        </button>
    <?php endif; ?>
</div>

<div class="tw-container">
    <!-- ================================================================ -->
    <!-- FEED 1: PENGAJUAN (MAHASISWA)                                    -->
    <!-- ================================================================ -->
    <div class="tw-item">
        
        <div class="tw-header">
            <div class="tw-header-text">
                <span class="tw-header-actor"><?= esc($p['nama_mahasiswa'] ?? 'Mahasiswa') ?></span> mengajukan permohonan <?= strtolower(esc($p['jenis_permohonan'] ?? 'magang')) ?>.
                <span class="tw-header-time"><?= !empty($p['created_at']) ? tgl_indo($p['created_at'], true) . ' WIB' : '-' ?></span>
            </div>
            <div class="tw-badge pengajuan">pengajuan</div>
        </div>
        
        <div class="tw-profile-wrapper">
            <?php $isSiswa = (isset($p['jenjang_pendidikan']) && stripos($p['jenjang_pendidikan'], 'SM') !== false) || (isset($p['id_jenis_permohonan']) && $p['id_jenis_permohonan'] == 5); ?>
            <div class="tw-section-title">Data Diri Pemohon</div>
            
            <div class="tw-card">
                <table class="tw-table">
                    <tr>
                        <th>Nama Lengkap</th>
                        <td><?= esc($p['nama_mahasiswa'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <th>NIK</th>
                        <td><?= esc($p['nik'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <th><?= $isSiswa ? 'NISN' : 'NIM' ?></th>
                        <td><?= esc($p['nim'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td><?= ($p['jenis_kelamin'] ?? '') == 'L' ? 'Laki-laki' : (($p['jenis_kelamin'] ?? '') == 'P' ? 'Perempuan' : '-') ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Lahir</th>
                        <td><?= !empty($p['tgl_lahir']) ? tgl_indo($p['tgl_lahir']) : '-' ?></td>
                    </tr>
                    <tr>
                        <th>Alamat Email</th>
                        <td><?= esc($p['email'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <th>No. Telp / WA</th>
                        <td><?= esc($p['no_telp'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <th>Instansi Pendidikan</th>
                        <td><?= esc($p['kampus'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <th>Jenjang</th>
                        <td><?= esc($p['jenjang_pendidikan'] ?? '-') ?></td>
                    </tr>
                    <?php if(!empty($p['fakultas'])): ?>
                    <tr>
                        <th>Fakultas</th>
                        <td><?= esc($p['fakultas']) ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <th>Jurusan</th>
                        <td><?= esc(!empty($p['prodi']) ? $p['prodi'] : ($p['jurusan'] ?? '-')) ?></td>
                    </tr>
                    <tr>
                        <th><?= $isSiswa ? 'Kelas' : 'Semester' ?></th>
                        <td><?= esc(!empty($p['kelas']) ? $p['kelas'] : ($p['semester'] ?? '-')) ?></td>
                    </tr>
                    <?php if(!$isSiswa): ?>
                    <tr>
                        <th>Tahun Angkatan</th>
                        <td><?= esc($p['angkatan_tahun'] ?? '-') ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <th>Alamat Domisili</th>
                        <td>
                            <?php
                                $alamatParts = [];
                                if (!empty($p['alamat']) && $p['alamat'] !== '-') $alamatParts[] = trim($p['alamat']);
                                if (!empty($p['kelurahan']) && $p['kelurahan'] !== '-') $alamatParts[] = 'Kelurahan ' . trim($p['kelurahan']);
                                if (!empty($p['kecamatan']) && $p['kecamatan'] !== '-') $alamatParts[] = 'Kecamatan ' . trim($p['kecamatan']);
                                if (!empty($p['kabupaten_kota']) && $p['kabupaten_kota'] !== '-') $alamatParts[] = trim($p['kabupaten_kota']);
                                if (!empty($p['provinsi']) && $p['provinsi'] !== '-') $alamatParts[] = 'Provinsi ' . trim($p['provinsi']);
                                echo !empty($alamatParts) ? esc(implode(', ', $alamatParts)) : '-';
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="tw-card">
            <table class="tw-table">
                <tr>
                    <th>Jenis Permohonan</th>
                    <td><?= esc($p['jenis_permohonan'] ?? '-') ?></td>
                </tr>
                <?php
                    $tglMulai = !empty($p['tgl_mulai']) ? tgl_indo($p['tgl_mulai']) : '-';
                    $tglSelesai = !empty($p['tgl_selesai']) ? tgl_indo($p['tgl_selesai']) : '-';
                ?>
                <tr>
                    <th>Tanggal Mulai</th>
                    <td><?= $tglMulai ?></td>
                </tr>
                <tr>
                    <th>Tanggal Selesai</th>
                    <td><?= $tglSelesai ?></td>
                </tr>
                <?php
                    $labelKeahlian = 'Keahlian / Kompetensi';
                    $labelDeskripsi = 'Apa yang ingin Anda kerjakan?';
                ?>
                <tr>
                    <th><?= $labelKeahlian ?></th>
                    <td style="white-space: pre-wrap;"><?= esc($p['deskripsi_keahlian'] ?? '-') ?></td>
                </tr>
                <tr>
                    <th><?= $labelDeskripsi ?></th>
                    <td style="white-space: pre-wrap;"><?= esc($p['deskripsi'] ?? ($p['rencana_kegiatan'] ?? '-')) ?></td>
                </tr>
                <?php if (!empty($p['files'])): ?>
                <tr>
                    <th>Berkas Lampiran</th>
                    <td>
                        <?php foreach($p['files'] as $file): ?>
                        <div class="tw-file-row">
                            <i class="bi bi-paperclip tw-file-icon"></i>
                            <span class="tw-file-name"><?= esc($file['nama_file']) ?></span>
                            <a href="<?= base_url('mahasiswa/view-file/' . $file['id_file_permohonan_magang']) ?>" target="_blank" class="tw-file-link">Download</a>
                        </div>
                        <?php endforeach; ?>
                    </td>
                </tr>
                <?php endif; ?>
            </table>
        </div>

    </div>


    <!-- ================================================================ -->
    <!-- FEED 2: VERIFIKASI SEKRETARIAT                                   -->
    <!-- ================================================================ -->
    <?php if ($p['posting_data'] == 'kirim'): ?>
    <?php
        $jenisPermohonanText = strtolower(trim($p['jenis_permohonan'] ?? 'permohonan'));
        $jenisPermohonanText = preg_replace('/\s+/', ' ', $jenisPermohonanText);

        // LOGIC SEKRETARIAT
        $isRevisi = ($p['status_persetujuan'] == 'PERBAIKAN_BERKAS');
        $hasPenempatan = (!empty($p['status_penempatan']) && !$isRevisi);
        if ($p['status_persetujuan'] == 'DITOLAK') {
            $tagClass = 'ditolak'; $tagText = 'ditolak';
            $feedText = 'menolak permohonan ' . $jenisPermohonanText . ' anda.';
        } elseif ($isRevisi) {
            $tagClass = 'menunggu'; $tagText = 'perbaikan';
            $feedText = 'mengembalikan berkas permohonan ' . $jenisPermohonanText . ' anda untuk direvisi.';
        } elseif ($p['status_persetujuan'] == 'DISETUJUI') {
            $tagClass = 'disetujui'; $tagText = 'disetujui';
            $feedText = 'telah menyetujui tahap verifikasi permohonan ' . $jenisPermohonanText . ' anda.';
        } else {
            $tagClass = 'menunggu'; $tagText = 'menunggu';
            $feedText = 'sedang memproses verifikasi berkas permohonan ' . $jenisPermohonanText . ' anda.';
        }
    ?>
    <div class="tw-item">
        
        <div class="tw-header">
            <div class="tw-header-text">
                <span class="tw-header-actor">Sekretariat</span> <?= $feedText ?>
                <span class="tw-header-time">
                    <?php 
                        $waktuSekre = !empty($p['tanggal_persetujuan']) ? $p['tanggal_persetujuan'] : (!empty($p['tanggal_persetujuan_fallback']) ? $p['tanggal_persetujuan_fallback'] : (!empty($p['waktu_persetujuan_created']) ? $p['waktu_persetujuan_created'] : ''));
                        if(!empty($waktuSekre)): 
                    ?>
                        <?= tgl_indo($waktuSekre, true) ?> WIB
                    <?php else: ?>
                        Menunggu Proses
                    <?php endif; ?>
                </span>
            </div>
            <div class="tw-badge <?= $tagClass ?>"><?= $tagText ?></div>
        </div>

        <?php if(!empty($p['catatan_sekretariat']) || $isRevisi || $p['status_persetujuan'] == 'DITOLAK'): ?>
        <div class="tw-card">
            <?php if(!empty($p['catatan_sekretariat']) || $p['status_persetujuan'] == 'DITOLAK'): ?>
            <div class="tw-message">
                <?php if ($p['status_persetujuan'] == 'DITOLAK'): ?>
                    <?php
                        $jenisPermohonanText = strtolower(trim($p['jenis_permohonan'] ?? 'permohonan'));
                        $jenisPermohonanText = preg_replace('/\s+/', ' ', $jenisPermohonanText);
                    ?>
                    <div style="margin-bottom: 12px; font-style: italic; color: #374151;">
                        Mohon maaf, permohonan <?= esc($jenisPermohonanText) ?> Anda tidak dapat kami setujui/proses lebih lanjut saat ini. Terima kasih atas ketertarikan Anda untuk melaksanakan <?= esc($jenisPermohonanText) ?> di instansi kami.
                    </div>
                    <div style="margin-bottom: 2px; color: #4b5563;">Catatan:</div>
                    <div style="font-style: italic; color: #4b5563;">
                        <?php 
                            $catatanSekre = esc($p['catatan_sekretariat']);
                            echo nl2br($catatanSekre);
                        ?>
                    </div>
                <?php else: ?>
                    <div style="font-weight: 600; margin-bottom: 6px; color: #111827;">Catatan verifikasi:</div>
                    <?php 
                        $catatanSekre = esc($p['catatan_sekretariat']);
                        if (strpos($catatanSekre, '[DIKEMBALIKAN KABID]') !== false) {
                            $parts = explode('[DIKEMBALIKAN KABID]', $catatanSekre);
                            echo nl2br(trim($parts[0]));
                        } else {
                            echo nl2br($catatanSekre);
                        }
                    ?>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- Status Validasi File (Jika ditolak/revisi, beri tau mana yang salah) -->
            <?php
                $hasFileStatus = false;
                if (!empty($p['files'])) {
                    foreach ($p['files'] as $f) {
                        if (!empty($f['status_verifikasi'])) { $hasFileStatus = true; break; }
                    }
                }
            ?>
            <?php if ($hasFileStatus && $p['status_persetujuan'] != 'DITOLAK'): ?>
            <div style="border-top: 1px solid #e5e7eb;">
                <table class="tw-table">
                    <?php foreach($p['files'] as $file): ?>
                    <tr>
                        <td style="width:60%;">
                            <div class="tw-file-row">
                                <i class="bi bi-paperclip tw-file-icon"></i>
                                <span class="tw-file-name" style="font-size: 0.9rem; margin-right:0;"><?= esc($file['nama_file']) ?></span>
                            </div>
                        </td>
                        <td style="vertical-align: middle;">
                            <?php if(($file['status_verifikasi'] ?? '') === 'SESUAI' || ($file['status_verifikasi'] ?? '') === 'VALID'): ?>
                                <span style="color:#22c55e; font-weight:600;"><i class="bi bi-check-circle-fill me-1"></i>Sesuai</span>
                            <?php elseif(($file['status_verifikasi'] ?? '') === 'TIDAK_SESUAI' || ($file['status_verifikasi'] ?? '') === 'TIDAK_VALID'): ?>
                                <span style="color:#ef4444; font-weight:600;"><i class="bi bi-x-circle-fill me-1"></i>Tidak Sesuai</span>
                            <?php else: ?>
                                <span style="color:#9ca3af;">Belum dicek</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if ($isRevisi): ?>
        <div style="margin-top: 16px; margin-bottom: 8px;">
            <a href="<?= base_url('mahasiswa/permohonan') ?>" class="btn btn-warning text-dark fw-bold px-4 py-2" style="border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.2); display: inline-block;">
                <i class="bi bi-pencil-square me-2"></i> Perbaiki Berkas Sekarang
            </a>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>


    <!-- ================================================================ -->
    <!-- FEED 3: PENEMPATAN (KEPALA BIDANG)                               -->
    <!-- ================================================================ -->
    <?php 
       $isRevisiSekre = ($p['status_persetujuan'] == 'PERBAIKAN_BERKAS');
    ?>
    <?php if(!empty($p['status_penempatan']) && !$isRevisiSekre): ?>
    <?php 
       $jenisPermohonanKabid = strtolower(trim($p['jenis_permohonan'] ?? 'permohonan'));
       $jenisPermohonanKabid = preg_replace('/\s+/', ' ', $jenisPermohonanKabid);

       $isKabidMenunggu = ($p['status_penempatan'] == 'MENUNGGU' || $p['status_penempatan'] == '0' || $p['status_penempatan'] == 'DIBATALKAN');
       $isKabidJalan = ($p['status_penempatan'] == 'BERJALAN');
       $isKabidSelesai = ($p['status_penempatan'] == 'SELESAI');
       
       if ($isKabidSelesai) {
           $kBadge = 'disetujui'; $kText = 'selesai';
           $kHeader = 'telah menyatakan selesai untuk kegiatan ' . $jenisPermohonanKabid . ' anda.';
       } elseif ($isKabidJalan) {
           $kBadge = 'disetujui'; $kText = 'disetujui';
           $kHeader = 'menyetujui penempatan permohonan ' . $jenisPermohonanKabid . ' anda.';
        } else {
            $kBadge = 'menunggu'; $kText = 'menunggu';
            $kHeader = 'sedang meninjau permohonan penempatan ' . $jenisPermohonanKabid . ' anda.';
        }
    ?>
    <div class="tw-item">
        
        <div class="tw-header">
            <div class="tw-header-text">
                <span class="tw-header-actor">Unit Bidang</span> <?= $kHeader ?>
                <span class="tw-header-time">
                    <?php $waktuKabid = !empty($p['waktu_kabid']) ? $p['waktu_kabid'] : (!empty($p['waktu_kabid_fallback']) ? $p['waktu_kabid_fallback'] : ''); ?>
                    <?php if(!empty($waktuKabid) && !$isKabidMenunggu): ?>
                        <?= tgl_indo($waktuKabid, true) ?> WIB
                    <?php else: ?>
                        Menunggu Proses
                    <?php endif; ?>
                </span>
            </div>
            <div class="tw-badge <?= $kBadge ?>"><?= $kText ?></div>
        </div>

        <?php if(!$isKabidMenunggu): ?>
        <div class="tw-card">
            <?php if($isKabidJalan || $isKabidSelesai): ?>
            <div class="tw-message">
                <?php if ($isKabidSelesai): ?>
                    <p>Kegiatan anda telah dinyatakan <strong>selesai</strong> pada <strong><?= esc($p['bidang'] ?? 'Bidang Terkait') ?></strong>. Terima kasih atas partisipasinya.</p>
                <?php else: ?>
                    <p>Permohonan anda telah disetujui sepenuhnya. Anda telah ditempatkan pada <strong><?= esc($p['bidang'] ?? 'Bidang Terkait') ?></strong>.</p>
                <?php endif; ?>
            </div>

            <?php if (!empty($p['surat_balasan'])): ?>
                <?php foreach($p['surat_balasan'] as $surat): ?>
                <div class="tw-attachment-box">
                    <div style="display: flex; align-items: center; overflow: hidden; margin-right: 16px;">
                        <i class="bi bi-paperclip" style="color: #9ca3af; font-size: 1.2rem; margin-right: 12px;"></i>
                        <span style="color: #374151; font-size: 0.85rem; font-style: italic; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= esc($surat['nama_file']) ?></span>
                    </div>
                    <a href="<?= base_url('mahasiswa/download-surat-penerimaan/' . $surat['id_file_proses_magang']) ?>" target="_blank" style="color: #6366f1; font-weight: 600; font-size: 0.85rem; text-decoration: none; white-space: nowrap;">Download</a>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php endif; ?>

            <?php if(!empty($p['catatan']) && $p['catatan'] != 'Disposisi dari Verifikasi'): ?>
            <div class="tw-attachment-note" <?= $isKabidBatal ? 'style="padding-top: 18px;"' : '' ?>>
                <span style="display: block; color: #6b7280; font-size: 0.8rem; margin-bottom: 2px;">Catatan Unit Bidang:</span>
                <?= nl2br(esc($p['catatan'])) ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>



</div>

