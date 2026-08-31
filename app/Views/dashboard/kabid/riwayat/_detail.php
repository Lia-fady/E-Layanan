<?php
/**
 * View Partial: Detail Riwayat Penempatan Kabid
 * Ditampilkan via AJAX dalam container #detailContainer
 */

$isSiswa = ($p->id_jenjang_pendidikan == 1 || $p->id_jenis_permohonan == 5);

$jenisPermohonanText = strtolower(trim($p->jenis_permohonan ?? ''));
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
    $labelDeskripsi = 'Rencana Kegiatan';
}

$alamatParts = [];
if (!empty($p->alamat)) $alamatParts[] = $p->alamat;
$rtRw = '';
if (!empty($p->rt)) $rtRw .= 'RT ' . $p->rt;
if (!empty($p->rw)) $rtRw .= (!empty($rtRw) ? ' / RW ' : 'RW ') . $p->rw;
if ($rtRw) $alamatParts[] = $rtRw;
$alamatLengkap = !empty($alamatParts) ? implode(', ', $alamatParts) : '-';

$statusText = $p->status_penempatan ?? '-';
$statusClass = 'alert-secondary'; $statusIcon = 'fa-info-circle';
if ($p->status_penempatan == 'DISETUJUI') { $statusText = 'Disetujui'; $statusClass = 'alert-info'; $statusIcon = 'fa-check-circle'; }
elseif ($p->status_penempatan == 'BERJALAN') { $statusText = 'Sedang Berjalan'; $statusClass = 'alert-primary'; $statusIcon = 'fa-spinner'; }
elseif ($p->status_penempatan == 'SELESAI') { $statusText = 'Kegiatan Selesai'; $statusClass = 'alert-success'; $statusIcon = 'fa-check-circle'; }
elseif ($p->status_penempatan == 'DITOLAK') { $statusText = 'Ditolak'; $statusClass = 'alert-danger'; $statusIcon = 'fa-times-circle'; }
elseif ($p->status_penempatan == 'DIBATALKAN') { $statusText = 'Dibatalkan'; $statusClass = 'alert-warning'; $statusIcon = 'fa-ban'; }

// Helper Format Tanggal Indonesia
function formatTanggalIndo($tanggal, $tampil_jam = false) {
    if (empty($tanggal)) return '-';
    $bulan = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $timestamp = strtotime($tanggal);
    $tgl = date('d', $timestamp);
    $bln = $bulan[(int)date('m', $timestamp)];
    $thn = date('Y', $timestamp);
    $jam = date('H:i', $timestamp);
    
    if ($tampil_jam) {
        return "$tgl $bln $thn, $jam WIB";
    }
    return "$tgl $bln $thn";
}
?>

<style>
.dispo-detail { font-family: 'Inter', sans-serif; color: #334155; }
.dispo-detail .dispo-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06); margin-bottom: 20px; overflow: hidden;
}
.dispo-detail .dispo-card-head {
    background: #f8fafc; border-bottom: 1px solid #e2e8f0;
    padding: 14px 20px; font-weight: 700; font-size: 0.95rem; color: #0f172a;
}
.dispo-detail .dispo-card-head i { color: #3b82f6; margin-right: 8px; }
.info-grid { display: flex; flex-wrap: wrap; }
.info-col { flex: 1; min-width: 320px; }
.info-col + .info-col { border-left: 1px solid #f1f5f9; }
.info-row { display: flex; border-bottom: 1px solid #f1f5f9; }
.info-row:last-child { border-bottom: none; }
.info-row .lbl {
    width: 160px; min-width: 160px; padding: 11px 20px;
    font-weight: 600; font-size: 0.85rem; color: #64748b; background: #fafbfc; border-right: 1px solid #f1f5f9;
}
.info-row .val { flex: 1; padding: 11px 20px; font-size: 0.85rem; color: #1e293b; font-weight: 500; }
.dispo-detail .file-list { display: flex; flex-direction: column; gap: 8px; max-width: 400px; }
.dispo-detail .file-row {
    display: flex; align-items: center; justify-content: space-between; gap: 12px;
    background: #f8fafc; border: 1px solid #e2e8f0;
    padding: 10px 14px; border-radius: 6px;
}
.dispo-detail .file-row-left { display: flex; align-items: center; gap: 10px; }
.dispo-detail .file-row .fname { font-weight: 600; font-size: 0.85rem; color: #334155; }
.info-table-full { width: 100%; border-collapse: collapse; }
.info-table-full th, .info-table-full td { padding: 12px 20px; border-bottom: 1px solid #f1f5f9; font-size: 0.85rem; vertical-align: top; }
.info-table-full th { width: 200px; font-weight: 600; color: #64748b; background: #fafbfc; border-right: 1px solid #f1f5f9; }
.info-table-full td { color: #1e293b; font-weight: 500; }
.info-table-full tr:last-child th, .info-table-full tr:last-child td { border-bottom: none; }
@media (max-width: 768px) {
    .info-col + .info-col { border-left: none; border-top: 1px solid #e2e8f0; }
    .info-col { min-width: 100%; }
}
</style>

<div class="dispo-detail pb-3">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="m-0 font-weight-bold" style="color: #1B2559;">Detail Riwayat Penempatan</h5>
            <p class="m-0 mt-1" style="color: #667085; font-size: 0.85rem;">Detail permohonan yang telah diproses.</p>
        </div>
        <button type="button" class="btn btn-outline-secondary btn-sm bg-white" id="btnKembali">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </button>
    </div>


    <div class="dispo-card">
        <div class="dispo-card-head"><i class="fas fa-user"></i> Informasi Pemohon</div>
        <div class="info-grid">
            <div class="info-col">
                <div class="info-row"><div class="lbl">Nama Lengkap</div><div class="val"><?= esc($p->nama_mahasiswa ?? '-') ?></div></div>
                <div class="info-row"><div class="lbl"><?= $isSiswa ? 'NISN / NIS' : 'NIM' ?></div><div class="val"><?= esc($p->nim ?? '-') ?></div></div>
                <div class="info-row"><div class="lbl">NIK</div><div class="val"><?= esc($p->nik ?? '-') ?></div></div>
                <div class="info-row"><div class="lbl">Tanggal Lahir</div><div class="val"><?= formatTanggalIndo($p->tgl_lahir) ?></div></div>
                <div class="info-row"><div class="lbl">Jenis Kelamin</div><div class="val"><?= ($p->jenis_kelamin == 'L') ? 'Laki-Laki' : (($p->jenis_kelamin == 'P') ? 'Perempuan' : '-') ?></div></div>
                <div class="info-row"><div class="lbl">No. Telepon</div><div class="val"><?= esc($p->no_telp ?? '-') ?></div></div>
                <div class="info-row"><div class="lbl">Email</div><div class="val"><?= esc($p->email ?? '-') ?></div></div>
                <div class="info-row"><div class="lbl">Instansi Pendidikan</div><div class="val"><?= esc($p->instansi_pendidikan ?? '-') ?></div></div>
            </div>
            <div class="info-col">
                <div class="info-row"><div class="lbl">Jurusan</div><div class="val"><?= esc($isSiswa ? ($p->jurusan_siswa ?? $p->jurusan ?? '-') : ($p->prodi ?? $p->jurusan ?? '-')) ?></div></div>
                <div class="info-row"><div class="lbl"><?= $isSiswa ? 'Kelas' : 'Semester' ?></div><div class="val"><?= esc($isSiswa ? ($p->kelas ?? '-') : ($p->semester ?? '-')) ?></div></div>
                <div class="info-row"><div class="lbl">Alamat</div><div class="val"><?= esc($alamatLengkap) ?></div></div>
                <div class="info-row"><div class="lbl">Kelurahan</div><div class="val"><?= esc($p->kelurahan ?? '-') ?></div></div>
                <div class="info-row"><div class="lbl">Kecamatan</div><div class="val"><?= esc($p->kecamatan ?? '-') ?></div></div>
                <div class="info-row"><div class="lbl">Kab / Kota</div><div class="val"><?= esc($p->kabupaten ?? '-') ?></div></div>
                <div class="info-row"><div class="lbl">Provinsi</div><div class="val"><?= esc($p->provinsi ?? '-') ?></div></div>
                <div class="info-row" style="border-bottom:none;"><div class="lbl" style="border-bottom:none;">&nbsp;</div><div class="val" style="border-bottom:none;">&nbsp;</div></div>
            </div>
        </div>
    </div>

    <div class="dispo-card">
        <div class="dispo-card-head"><i class="fas fa-file-alt"></i> Rincian Kegiatan & Dokumen Pendukung</div>
        <table class="info-table-full">
            <tr>
                <th>Jenis Kegiatan</th>
                <td><span class="badge badge-info px-2 py-1" style="font-size:0.85rem;"><?= esc($p->jenis_permohonan ?? '-') ?></span></td>
            </tr>
            <tr>
                <th>Tanggal Pengajuan</th>
                <td><?= formatTanggalIndo($p->tgl_pengajuan ?? null, true) ?></td>
            </tr>
            <tr><th>Bidang Tujuan</th><td class="font-weight-bold" style="color:#2563eb;"><?= esc($p->bidang ?? '-') ?></td></tr>
            <tr>
                <th>Periode Pelaksanaan</th>
                <td>
                    <?php $mulai = formatTanggalIndo($p->tgl_mulai); $selesai = formatTanggalIndo($p->tgl_selesai); ?>
                    <?= $mulai ?> <span class="text-muted mx-1">s/d</span> <?= $selesai ?>
                </td>
            </tr>
            <tr>
                <th>Disetujui Sekretariat</th>
                <td><?= formatTanggalIndo($p->tanggal_persetujuan, true) ?></td>
            </tr>
            <tr>
                <th><?= esc($labelKeahlian) ?></th>
                <td style="white-space:pre-wrap; line-height:1.6; color:#475569;"><?= esc($p->deskripsi_keahlian ?? 'Belum diisi') ?></td>
            </tr>
            <tr>
                <th><?= esc($labelDeskripsi) ?></th>
                <td style="white-space:pre-wrap; line-height:1.6; color:#475569;"><?= !empty($p->rencana_kegiatan) ? esc($p->rencana_kegiatan) : '<em>Belum diisi</em>' ?></td>
            </tr>
            <tr>
                <th>Dokumen Lampiran</th>
                <td>
                    <?php if (!empty($files)): ?>
                        <div class="file-list">
                            <?php foreach($files as $file): ?>
                                <div class="file-row">
                                    <div class="file-row-left">
                                        <i class="fas fa-file-pdf" style="color:#ef4444; font-size: 1.1rem;"></i>
                                        <span class="fname"><?= esc($file->jenis_file ?? 'Dokumen') ?></span>
                                    </div>
                                    <a href="<?= base_url($file->file_path) ?>" target="_blank" class="btn btn-sm btn-outline-primary py-1 px-3" style="font-size:0.75rem; border-radius: 4px;">Lihat</a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <span class="text-muted"><em>Belum ada lampiran</em></span>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>

    <?php if (!empty($p->catatan)): ?>
    <div class="dispo-card">
        <div class="dispo-card-head"><i class="fas fa-comment-dots"></i> Catatan Keputusan</div>
        <div class="p-4" style="line-height:1.7; color:#334155; font-size:0.9rem;"><?= nl2br(esc($p->catatan)) ?></div>
    </div>
    <?php endif; ?>

    <div class="d-flex justify-content-end mt-2 gap-2">
        <button type="button" class="btn btn-light border px-4" onclick="$('#btnKembali').click()" style="border-radius:6px; font-weight:500;">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </button>
        
        <?php if ($p->status_penempatan == 'BERJALAN'): ?>
        <form method="POST" action="<?= base_url('kabid/disposisi/selesaikan') ?>" style="display:inline;" onsubmit="event.preventDefault(); var form = this; Swal.fire({title: 'Selesaikan Kegiatan?', text: 'Kegiatan pemohon ini akan dinyatakan selesai. Lanjutkan?', icon: 'question', showCancelButton: true, confirmButtonColor: '#16a34a', cancelButtonColor: '#64748b', confirmButtonText: 'Ya, Selesai', cancelButtonText: 'Batal', reverseButtons: true}).then((result) => { if (result.isConfirmed) form.submit(); });">
            <?= csrf_field() ?>
            <input type="hidden" name="id_penempatan_magang" value="<?= esc($p->id_penempatan_magang) ?>">
            <button type="submit" class="btn btn-success px-4" style="border-radius:6px; font-weight:500; background-color: #16a34a; border-color: #16a34a;">
                <i class="fas fa-check-circle mr-1"></i> Selesaikan Kegiatan
            </button>
        </form>
        <?php endif; ?>

        <?php if (in_array($p->status_penempatan, ['DISETUJUI', 'BERJALAN'])): ?>
        <form method="POST" action="<?= base_url('kabid/riwayat/batalkan') ?>" style="display:inline;" onsubmit="event.preventDefault(); var form = this; Swal.fire({title: 'Batalkan Kegiatan?', html: 'Mahasiswa akan dinyatakan <b>mengundurkan diri</b>. Aksi ini tidak dapat dibatalkan.<br><br><textarea id=\'swal-catatan\' class=\'swal2-textarea\' placeholder=\'Alasan pembatalan (opsional)...\'></textarea>', icon: 'warning', showCancelButton: true, confirmButtonColor: '#dc3545', cancelButtonColor: '#64748b', confirmButtonText: 'Ya, Batalkan', cancelButtonText: 'Kembali', reverseButtons: true, preConfirm: () => { form.querySelector('[name=catatan_batalkan]').value = document.getElementById('swal-catatan').value || 'Dibatalkan oleh Kepala Bidang'; }}).then((result) => { if (result.isConfirmed) form.submit(); });">
            <?= csrf_field() ?>
            <input type="hidden" name="id_penempatan_magang" value="<?= esc($p->id_penempatan_magang) ?>">
            <input type="hidden" name="catatan_batalkan" value="">
            <button type="submit" class="btn btn-danger px-4" style="border-radius:6px; font-weight:500;">
                <i class="fas fa-ban mr-1"></i> Batalkan Kegiatan
            </button>
        </form>
        <?php endif; ?>
    </div>

</div>
