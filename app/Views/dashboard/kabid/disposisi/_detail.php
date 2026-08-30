<?php
/**
 * View Partial: Detail Disposisi Kabid
 * Ditampilkan via AJAX dalam container #detailContainer
 */

$isSiswa = ($p->id_jenjang_pendidikan == 1 || $p->id_jenis_permohonan == 5);

$idJenis = (int)($p->id_jenis_permohonan ?? 0);
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

// Format alamat lengkap
$alamatParts = [];
if (!empty($p->alamat)) $alamatParts[] = $p->alamat;
$rtRw = '';
if (!empty($p->rt)) $rtRw .= 'RT ' . $p->rt;
if (!empty($p->rw)) $rtRw .= (!empty($rtRw) ? ' / RW ' : 'RW ') . $p->rw;
if ($rtRw) $alamatParts[] = $rtRw;
$alamatLengkap = !empty($alamatParts) ? implode(', ', $alamatParts) : '-';

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
.dispo-detail .file-list { display: flex; flex-direction: column; gap: 8px; max-width: 400px; }
.dispo-detail .file-row {
    display: flex; align-items: center; justify-content: space-between; gap: 12px;
    background: #f8fafc; border: 1px solid #e2e8f0;
    padding: 10px 14px; border-radius: 6px;
}
.dispo-detail .file-row-left { display: flex; align-items: center; gap: 10px; }
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
            <h5 class="m-0 font-weight-bold" style="color: #1B2559;">Detail Permohonan Masuk</h5>
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

    <!-- Rincian Kegiatan & Dokumen Pendukung -->
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
                <th>Pengajuan <?= esc($p->jenis_permohonan ?? 'Magang') ?></th>
                <td>
                    <?php
                        $mulai = formatTanggalIndo($p->tgl_mulai);
                        $selesai = formatTanggalIndo($p->tgl_selesai);
                    ?>
                    <strong>Periode <?= esc($p->jenis_permohonan ?? 'Magang') ?> Pengajuan:</strong> <br>
                    <?= $mulai ?> <span class="text-muted mx-1">s/d</span> <?= $selesai ?>
                    <br><br>

                    <strong>Periode <?= esc($p->jenis_permohonan ?? 'Magang') ?> Persetujuan:</strong> <br>
                    <?php if (!empty($p->tgl_mulai_disetujui)): ?>
                        <?= formatTanggalIndo($p->tgl_mulai_disetujui) ?> <span class="text-muted mx-1">s/d</span> <?= formatTanggalIndo($p->tgl_selesai_disetujui) ?>
                    <?php else: ?>
                        <span class="text-muted"><em>Belum ditentukan</em></span>
                    <?php endif; ?>
                    <br>
                    <strong>Status Persetujuan Periode:</strong> 
                    <?php if (($p->status_persetujuan_mahasiswa ?? '') == 'DISETUJUI'): ?>
                        <span class="badge badge-success">Disetujui</span>
                    <?php elseif (($p->status_persetujuan_mahasiswa ?? '') == 'DITOLAK'): ?>
                        <span class="badge badge-danger">Ditolak</span>
                    <?php else: ?>
                        <span class="badge badge-warning">Menunggu</span>
                    <?php endif; ?>
                    <br><br>

                    <strong>Periode Pelaksanaan:</strong> <br>
                    <?php if (($p->status_persetujuan_mahasiswa ?? '') == 'DISETUJUI'): ?>
                        <span class="text-primary font-weight-bold"><?= formatTanggalIndo($p->tgl_mulai_disetujui) ?> - <?= formatTanggalIndo($p->tgl_selesai_disetujui) ?></span>
                    <?php else: ?>
                        <span class="text-muted"><em>Belum ditetapkan</em></span>
                    <?php endif; ?>
                    <br>
                    <strong>Status Pelaksanaan:</strong>
                    <span class="badge badge-info"><?= esc($p->status_penempatan ?? 'Menunggu') ?></span>
                </td>
            </tr>
            <tr>
                <th>Disetujui Sekretariat</th>
                <td><?= formatTanggalIndo($p->tanggal_persetujuan, true) ?></td>
            </tr>
            <tr>
                <th><?= esc($labelKeahlian) ?></th>
                <td style="white-space:pre-wrap; line-height:1.6; color:#475569;"><?= esc($p->deskripsi_keahlian ?? 'Tidak ada deskripsi.') ?></td>
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
                        <span class="text-muted"><em>Tidak ada lampiran dokumen</em></span>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>

    <!-- Keputusan Persetujuan -->
    <form id="formDisposisiAksi" method="POST" action="<?= base_url('kabid/disposisi/setujui') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="id_penempatan_magang" value="<?= $p->id_penempatan_magang ?>">
        <input type="hidden" name="id_persetujuan_magang" value="<?= $p->id_persetujuan_magang ?>">

        <div class="dispo-card">
            <div class="dispo-card-head"><i class="fas fa-gavel"></i> Keputusan Persetujuan</div>
            <div class="p-4">
                <div class="form-group mb-4">
                    <label class="font-weight-bold" style="color:#475569; font-size:14px;">Tindakan Keputusan</label>
                    <select id="decision_status" name="decision_status" class="form-control" style="max-width:380px; border-radius:6px; font-size:14px; height:42px;">
                        <option value="" disabled selected>-- Pilih Keputusan --</option>
                        <option value="setujui">Terima Permohonan & Tetapkan Periode</option>
                        <option value="tolak">Tolak Permohonan</option>
                    </select>
                </div>

                <div id="acc_fields" style="display:none; background:#f0fdf4; border:1px solid #bbf7d0; padding:20px; border-radius:8px; margin-bottom:16px;">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="font-weight-bold" style="color:#166534; font-size:14px;">Tanggal Mulai (Periode <?= esc($p->jenis_permohonan ?? 'Magang') ?> Persetujuan)</label>
                            <input type="date" name="tgl_mulai_disetujui" id="tgl_mulai_disetujui" class="form-control" value="<?= esc($p->tgl_mulai) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="font-weight-bold" style="color:#166534; font-size:14px;">Tanggal Selesai (Periode <?= esc($p->jenis_permohonan ?? 'Magang') ?> Persetujuan)</label>
                            <input type="date" name="tgl_selesai_disetujui" id="tgl_selesai_disetujui" class="form-control" value="<?= esc($p->tgl_selesai) ?>" required>
                        </div>
                        <div class="col-12 mt-2">
                            <small class="text-danger">* Periode <?= strtolower(esc($p->jenis_permohonan ?? 'magang')) ?> minimal 2 bulan.</small>
                        </div>
                    </div>
                    
                    <input type="hidden" name="is_log_book" value="Ya">
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
                        <i class="fas fa-save mr-1"></i> Simpan
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
            $('#btnSubmitKeputusan').removeClass('btn-danger').addClass('btn-primary').html('<i class="fas fa-save mr-1"></i> Simpan');
        } else if (val === 'tolak') {
            $('#acc_fields').slideUp(); $('#rej_fields').slideDown();
            $('#catatan_keputusan').prop('required', true);
            $('#btnSubmitKeputusan').removeClass('btn-primary').addClass('btn-danger').html('<i class="fas fa-save mr-1"></i> Simpan');
        }
    });

    $('#formDisposisiAksi').on('submit', function(e) {
        e.preventDefault();
        
        var decision = $('#decision_status').val();
        if (decision === 'tolak' && $('#catatan_keputusan').val().trim() === '') {
            Swal.fire('Peringatan', 'Alasan penolakan wajib diisi untuk diinformasikan ke pemohon.', 'warning'); 
            return false;
        }

        if (decision === 'setujui') {
            var tglMulai = new Date($('#tgl_mulai_disetujui').val());
            var tglSelesai = new Date($('#tgl_selesai_disetujui').val());
            
            // Validasi durasi magang minimal 2 bulan (sekitar 60 hari)
            var diffTime = Math.abs(tglSelesai - tglMulai);
            var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
            
            var jenisPermohonanText = '<?= strtolower(esc($p->jenis_permohonan ?? "magang")) ?>';
            
            if (diffDays < 59) {
                Swal.fire('Peringatan', 'Periode ' + jenisPermohonanText + ' minimal harus 2 bulan.', 'warning');
                return false;
            }
            if (tglSelesai <= tglMulai) {
                Swal.fire('Peringatan', 'Tanggal selesai harus lebih besar dari tanggal mulai.', 'warning');
                return false;
            }
        }

        var titleText = decision === 'setujui' ? 'Terima Pemohon?' : 'Tolak Pemohon?';
        var descText = decision === 'setujui' 
            ? 'Pemohon akan resmi diterima dan memulai kegiatannya di bidang Anda. Pastikan keputusan Anda sudah tepat.' 
            : 'Permohonan akan ditolak dan dikembalikan ke Sekretariat. Keputusan ini tidak dapat dibatalkan.';
        var confirmBtnText = decision === 'setujui' ? 'Ya, Terima' : 'Ya, Tolak';
        var confirmBtnColor = decision === 'setujui' ? '#16a34a' : '#dc2626';

        Swal.fire({
            title: titleText,
            text: descText,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: confirmBtnColor,
            cancelButtonColor: '#64748b',
            confirmButtonText: confirmBtnText,
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Gunakan native submit agar tidak trigger event ini lagi
                if (decision === 'tolak') {
                    $('#formDisposisiAksi').attr('action', '<?= base_url('kabid/disposisi/tolak') ?>');
                } else {
                    $('#formDisposisiAksi').attr('action', '<?= base_url('kabid/disposisi/setujui') ?>');
                }
                this.submit();
            }
        });
    });
});
</script>
