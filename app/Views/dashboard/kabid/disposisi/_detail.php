<?php
/**
 * View Partial: Detail Disposisi Kabid
 * Ditampilkan via AJAX dalam container #detailContainer
 */

$isSiswa = ($p->id_jenjang_pendidikan == 1 || $p->id_jenis_permohonan == 5);

$jenisPermohonanText = strtolower(trim($p->jenis_permohonan ?? ''));
if (strpos($jenisPermohonanText, 'penelitian') !== false || strpos($jenisPermohonanText, 'skripsi') !== false || strpos($jenisPermohonanText, 'ta') !== false) {
    $labelKeahlian = 'Deskripsi Judul Skripsi / TA';
} elseif (strpos($jenisPermohonanText, 'observasi') !== false || strpos($jenisPermohonanText, 'pengambilan data') !== false) {
    $labelKeahlian = 'Deskripsi Latar Belakang Observasi';
} elseif (strpos($jenisPermohonanText, 'uji coba') !== false || strpos($jenisPermohonanText, 'prototype') !== false) {
    $labelKeahlian = 'Deskripsi Profil Aplikasi / Sistem';
} else {
    $labelKeahlian = 'Deskripsi Keahlian / Skill';
}

// Format alamat lengkap
$alamatParts = [];
if (!empty($p->alamat)) $alamatParts[] = $p->alamat;
$rtRw = '';
if (!empty($p->rt)) $rtRw .= 'RT ' . $p->rt;
if (!empty($p->rw)) $rtRw .= (!empty($rtRw) ? ' / RW ' : 'RW ') . $p->rw;
if ($rtRw) $alamatParts[] = $rtRw;
$alamatLengkap = !empty($alamatParts) ? implode(', ', $alamatParts) : '-';
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

/* Two-column grid inside single card */
.info-grid { display: flex; flex-wrap: wrap; }
.info-col { flex: 1; min-width: 320px; }
.info-col + .info-col { border-left: 1px solid #f1f5f9; }
.info-row { display: flex; border-bottom: 1px solid #f1f5f9; }
.info-row:last-child { border-bottom: none; }
.info-row .lbl {
    width: 160px; min-width: 160px; padding: 11px 20px;
    font-weight: 600; font-size: 0.85rem; color: #64748b; background: #fafbfc; border-right: 1px solid #f1f5f9;
}
.info-row .val {
    flex: 1; padding: 11px 20px; font-size: 0.85rem; color: #1e293b; font-weight: 500;
}

/* File list */
.dispo-detail .file-list { display: flex; flex-direction: column; gap: 8px; }
.dispo-detail .file-row {
    display: inline-flex; align-items: center; gap: 10px;
    background: #f1f5f9; border: 1px solid #e2e8f0;
    padding: 8px 14px; border-radius: 6px; max-width: 420px;
}
.dispo-detail .file-row .fname { font-weight: 600; font-size: 0.85rem; color: #334155; }

/* Full-width table */
.info-table-full { width: 100%; border-collapse: collapse; }
.info-table-full th, .info-table-full td {
    padding: 12px 20px; border-bottom: 1px solid #f1f5f9; font-size: 0.85rem; vertical-align: top;
}
.info-table-full th { width: 200px; font-weight: 600; color: #64748b; background: #fafbfc; border-right: 1px solid #f1f5f9; }
.info-table-full td { color: #1e293b; font-weight: 500; }
.info-table-full tr:last-child th, .info-table-full tr:last-child td { border-bottom: none; }

@media (max-width: 768px) {
    .info-col + .info-col { border-left: none; border-top: 1px solid #e2e8f0; }
    .info-col { min-width: 100%; }
}
</style>

<div class="dispo-detail pb-3">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="m-0 font-weight-bold" style="color: #1B2559;">Detail Disposisi Masuk</h5>
            <p class="m-0 mt-1" style="color: #667085; font-size: 0.85rem;">Periksa data pemohon sebelum memberikan keputusan.</p>
        </div>
        <button type="button" class="btn btn-outline-secondary btn-sm bg-white" id="btnKembali">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </button>
    </div>

    <!-- Informasi Pemohon (Two Column, No Sub-headers) -->
    <div class="dispo-card">
        <div class="dispo-card-head"><i class="fas fa-user"></i> Informasi Pemohon</div>
        <div class="info-grid">
            <div class="info-col">
                <div class="info-row"><div class="lbl">Nama Lengkap</div><div class="val"><?= esc($p->nama_mahasiswa ?? '-') ?></div></div>
                <div class="info-row"><div class="lbl"><?= $isSiswa ? 'NISN / NIS' : 'NIM' ?></div><div class="val"><?= esc($p->nim ?? '-') ?></div></div>
                <div class="info-row"><div class="lbl">NIK</div><div class="val"><?= esc($p->nik ?? '-') ?></div></div>
                <div class="info-row"><div class="lbl">Tanggal Lahir</div><div class="val"><?= !empty($p->tgl_lahir) ? date('d F Y', strtotime($p->tgl_lahir)) : '-' ?></div></div>
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

    <!-- Detail Pengajuan & Lampiran Dokumen -->
    <div class="dispo-card">
        <div class="dispo-card-head"><i class="fas fa-file-alt"></i> Detail Pengajuan & Lampiran Dokumen</div>
        <table class="info-table-full">
            <tr>
                <th>Jenis Kegiatan</th>
                <td><span class="badge badge-info px-2 py-1" style="font-size:0.85rem;"><?= esc($p->jenis_permohonan ?? '-') ?></span></td>
            </tr>
            <tr><th>Bidang Tujuan</th><td class="font-weight-bold" style="color:#2563eb;"><?= esc($p->bidang ?? '-') ?></td></tr>
            <tr>
                <th>Periode Pelaksanaan</th>
                <td>
                    <?php
                        $mulai = !empty($p->tgl_mulai) ? date('d F Y', strtotime($p->tgl_mulai)) : '-';
                        $selesai = !empty($p->tgl_selesai) ? date('d F Y', strtotime($p->tgl_selesai)) : '-';
                    ?>
                    <?= $mulai ?> <span class="text-muted mx-1">s/d</span> <?= $selesai ?>
                </td>
            </tr>
            <tr>
                <th>Disetujui Sekretariat</th>
                <td><?= !empty($p->tanggal_persetujuan) ? date('d F Y, H:i', strtotime($p->tanggal_persetujuan)) . ' WIB' : '-' ?></td>
            </tr>
            <tr>
                <th><?= esc($labelKeahlian) ?></th>
                <td style="white-space:pre-wrap; line-height:1.6; color:#475569;"><?= esc($p->deskripsi_keahlian ?? 'Tidak ada deskripsi.') ?></td>
            </tr>
            <tr>
                <th>Dokumen Lampiran</th>
                <td>
                    <?php if (!empty($files)): ?>
                        <div class="file-list">
                            <?php foreach($files as $file): ?>
                                <div class="file-row">
                                    <i class="fas fa-file-pdf" style="color:#ef4444;"></i>
                                    <span class="fname"><?= esc($file->nama_file) ?></span>
                                    <a href="<?= base_url('uploads/persyaratan/' . $file->file_path) ?>" target="_blank" class="btn btn-sm btn-outline-primary py-0 px-2" style="font-size:0.8rem;">Lihat</a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <span class="text-muted"><em>Tidak ada lampiran dokumen</em></span>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>

    <!-- Keputusan Disposisi -->
    <form id="formDisposisiAksi" method="POST" action="<?= base_url('kabid/disposisi/setujui') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="id_penempatan_magang" value="<?= $p->id_penempatan_magang ?>">

        <div class="dispo-card">
            <div class="dispo-card-head"><i class="fas fa-gavel"></i> Keputusan Disposisi</div>
            <div class="p-4">
                <div class="form-group mb-4">
                    <label class="font-weight-bold" style="color:#475569; font-size:14px;">Tindakan Keputusan</label>
                    <select id="decision_status" name="decision_status" class="form-control" style="max-width:380px; border-radius:6px; font-size:14px; height:42px;">
                        <option value="" disabled selected>-- Pilih Keputusan --</option>
                        <option value="setujui">Terima Permohonan</option>
                        <option value="tolak">Tolak Permohonan</option>
                    </select>
                </div>

                <div id="acc_fields" style="display:none; background:#f0fdf4; border:1px solid #bbf7d0; padding:20px; border-radius:8px; margin-bottom:16px;">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold" style="color:#166534; font-size:14px;">Pemohon Wajib Mengisi Logbook Harian?</label>
                        <select name="is_log_book" class="form-control" style="max-width:380px; border-radius:6px; font-size:14px; height:42px;">
                            <option value="Ya" selected>Ya, Wajib</option>
                            <option value="Tidak">Tidak Wajib</option>
                        </select>
                        <small class="text-success d-block mt-2">Umumnya pemohon diwajibkan untuk mengisi logbook selama masa magang.</small>
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold" style="color:#166534; font-size:14px;">Catatan Persetujuan (Opsional)</label>
                        <textarea name="catatan_setuju" class="form-control" rows="3" placeholder="Contoh: Ditempatkan di tim analis data..." style="border-radius:6px; font-size:14px;"></textarea>
                    </div>
                </div>

                <div id="rej_fields" style="display:none; background:#fef2f2; border:1px solid #fecdd3; padding:20px; border-radius:8px; margin-bottom:16px;">
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-danger" style="font-size:14px;">Alasan Penolakan (Wajib Diisi)</label>
                        <textarea name="catatan_keputusan" id="catatan_keputusan" class="form-control" rows="4" placeholder="Sebutkan alasan spesifik mengapa permohonan ini ditolak..." style="border-radius:6px; font-size:14px;"></textarea>
                    </div>
                </div>

                <hr class="mt-4 mb-3">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-4 mr-2" id="btnSubmitKeputusan" disabled style="border-radius:6px; font-weight:600;">
                        <i class="fas fa-save mr-1"></i> Simpan Keputusan
                    </button>
                    <button type="button" class="btn btn-light border px-4" onclick="$('#btnKembali').click()" style="border-radius:6px; font-weight:500;">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </form>

</div>

<script>
$(document).ready(function() {
    $('#decision_status').on('change', function() {
        var val = $(this).val();
        $('#btnSubmitKeputusan').prop('disabled', false);
        if (val === 'setujui') {
            $('#acc_fields').slideDown(); $('#rej_fields').slideUp();
            $('#catatan_keputusan').prop('required', false);
            $('#btnSubmitKeputusan').removeClass('btn-danger').addClass('btn-primary').html('<i class="fas fa-check mr-1"></i> Terima Pemohon');
        } else if (val === 'tolak') {
            $('#acc_fields').slideUp(); $('#rej_fields').slideDown();
            $('#catatan_keputusan').prop('required', true);
            $('#btnSubmitKeputusan').removeClass('btn-primary').addClass('btn-danger').html('<i class="fas fa-times mr-1"></i> Tolak Pemohon');
        }
    });
    $('#formDisposisiAksi').on('submit', function(e) {
        if ($('#decision_status').val() === 'tolak' && $('#catatan_keputusan').val().trim() === '') {
            e.preventDefault(); Swal.fire('Peringatan', 'Alasan penolakan wajib diisi.', 'warning'); return false;
        }
    });
});
</script>
