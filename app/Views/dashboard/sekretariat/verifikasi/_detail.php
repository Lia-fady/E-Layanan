<?php 
/**
 * ============================================================
 * Kode      : _detail.php
 * Path      : Views/dashboard/sekretariat/verifikasi/_detail.php
 * Deskripsi : Partial view untuk detail verifikasi tanpa modal.
 * ============================================================
 */

$isLocked = false;
if (($permohonan->status_persetujuan ?? '') === 'DISETUJUI') {
    if (($status_penempatan ?? 'MENUNGGU') !== 'MENUNGGU') {
        $isLocked = true;
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
                    Verifikasi sudah final. Status penempatan saat ini adalah <strong><?= esc($status_penempatan ?? 'MENUNGGU') ?></strong>.
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
                            <td><?= esc($permohonan->prodi ?? '-') ?> / <?= esc($permohonan->fakultas ?? '-') ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Universitas</td>
                            <td>:</td>
                            <td><?= esc($permohonan->instansi_pendidikan ?? '-') ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Tanggal Pengajuan</td>
                            <td>:</td>
                            <td><?= !empty($permohonan->created_at) ? date('d F Y, H:i', strtotime($permohonan->created_at)) : '-' ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Periode Magang</td>
                            <td>:</td>
                            <td>
                                <?= !empty($permohonan->tgl_mulai) ? date('d M Y', strtotime($permohonan->tgl_mulai)) : '-' ?> 
                                s/d 
                                <?= !empty($permohonan->tgl_selesai) ? date('d M Y', strtotime($permohonan->tgl_selesai)) : '-' ?>
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
                                    if ($status == 'MENUNGGU_KABID' || $status == 'MENUNGGU_BIDANG') {
                                        $badge = 'badge-warning';
                                        $status = 'MENUNGGU BIDANG';
                                    }
                                ?>
                                <span class="badge <?= $badge ?>"><?= $status ?></span>
                            </td>
                        </tr>
                    </table>

                    <h6 class="mb-3 font-weight-bold" style="color: #1B2559; border-top: 1px solid #eee; padding-top: 15px;">Keahlian & Tujuan Magang</h6>
                    <div class="card bg-light border-0 mb-4">
                        <div class="card-body p-3">
                            <div class="mb-3">
                                <span class="text-muted d-block" style="font-size: 0.9rem;">Deskripsi Keahlian</span>
                                <strong style="font-size: 0.95rem;">
                                    <?= !empty($permohonan->deskripsi_keahlian) ? esc($permohonan->deskripsi_keahlian) : 'Belum diisi' ?>
                                </strong>
                            </div>
                            <div>
                                <span class="text-muted d-block" style="font-size: 0.9rem;">Deskripsi / Tujuan Magang</span>
                                <strong style="font-size: 0.95rem;">
                                    <?= !empty($permohonan->deskripsi_magang) ? esc($permohonan->deskripsi_magang) : 'Belum diisi' ?>
                                </strong>
                            </div>
                        </div>
                    </div>

                    <h6 class="mb-3 font-weight-bold" style="color: #1B2559; border-top: 1px solid #eee; padding-top: 15px;">Disposisi ke Bidang</h6>
                    <div class="form-group mb-4">
                        <label for="id_bidang" class="text-muted" style="font-size: 0.9rem;">Pilih Bidang Tujuan <small>(Hanya diproses jika semua dokumen Valid)</small></label>
                        <select name="id_bidang" id="id_bidang" class="form-control" <?= $isLocked ? 'disabled' : '' ?>>
                            <option value="" data-kuota="">-- Pilih Bidang Tujuan --</option>
                            <?php foreach ($bidang as $b) : ?>
                                <option value="<?= $b->id_bidang ?>" data-kuota="<?= $b->sisa_kuota ?>" <?= (isset($selected_bidang) && $selected_bidang == $b->id_bidang) ? 'selected' : '' ?>><?= esc($b->bidang) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div id="info_kuota_bidang" class="mt-2" style="display: none; font-size: 0.85rem; font-weight: 500;">
                            <!-- Info kuota akan muncul di sini -->
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Dokumen -->
                <div class="col-md-7">
                    <h6 class="mb-3 font-weight-bold" style="color: #1B2559;">Dokumen yang Diajukan</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
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
                                                <div class="btn-group btn-group-sm w-100" role="group">
                                                    <input type="hidden" name="file_status[<?= $f->id_file_permohonan_magang ?>]" value="<?= esc($fStatus) ?>" required>
                                                    <button type="button" class="btn <?= $fStatus === 'VALID' ? 'btn-success' : 'btn-outline-secondary' ?> btn-validasi-file w-50" data-value="VALID" <?= $isLocked ? 'disabled' : '' ?>>Valid</button>
                                                    <button type="button" class="btn <?= $fStatus === 'TIDAK_VALID' ? 'btn-danger' : 'btn-outline-secondary' ?> btn-validasi-file w-50" data-value="TIDAK_VALID" <?= $isLocked ? 'disabled' : '' ?>>Tidak Valid</button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada dokumen yang diunggah.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <small class="text-muted d-block mt-2"><i class="fas fa-info-circle"></i> Jika salah satu berkas ditandai <b>Tidak Valid</b>, status permohonan otomatis menjadi <b>Perbaikan Berkas</b> (Ditolak) dan disposisi dibatalkan.</small>
                    </div>
                </div>
            </div>
            
            <hr>
            <div class="d-flex justify-content-end mt-3">
                <button type="button" class="btn btn-secondary mr-2" id="btnKembali" onclick="$('#btnKembali').click()">Batal</button>
                <?php if (!$isLocked) : ?>
                    <button type="submit" class="btn btn-primary" id="btnSimpanKeputusan">
                        <i class="fas fa-save mr-1"></i> Simpan Keputusan
                    </button>
                <?php else : ?>
                    <button type="button" class="btn btn-secondary" disabled>
                        <i class="fas fa-lock mr-1"></i> Verifikasi Terkunci
                    </button>
                <?php endif; ?>
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
                    infoBox.html('<i class="bi bi-exclamation-circle text-danger me-1"></i> <span class="text-danger">Bidang ini sudah penuh!</span>');
                }
            } else {
                infoBox.hide();
            }
        });
    });
</script>
