<div class="modal fade" id="modalVerifikasi" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formVerifikasiModal" action="<?= base_url('sekretariat/verifikasi/prosesModal') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id_permohonan_magang" value="<?= $permohonan->id_permohonan_magang ?>">
                
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-check-circle mr-2"></i> Verifikasi Permohonan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <!-- Informasi Pemohon -->
                    <h6 class="mb-3 font-weight-bold" style="color: #1B2559;">Informasi Pemohon</h6>
                    <table class="table table-sm table-borderless mb-4">
                        <tr>
                            <td width="30%" class="text-muted">Nama Mahasiswa</td>
                            <td width="2%">:</td>
                            <td><strong><?= esc($permohonan->nama_mahasiswa ?? '-') ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Program Studi / Fakultas</td>
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
                            <td><?= !empty($permohonan->tgl_pengajuan) ? date('d M Y', strtotime($permohonan->tgl_pengajuan)) : '-' ?></td>
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
                            <td class="text-muted">Status Verifikasi Saat Ini</td>
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

                    <!-- Disposisi ke Bidang -->
                    <h6 class="mb-3 font-weight-bold" style="color: #1B2559;">Disposisi ke Bidang</h6>
                    <div class="form-group mb-4">
                        <label for="id_bidang" class="text-muted" style="font-size: 0.9rem;">Pilih Bidang Tujuan <small>(Hanya diproses jika semua dokumen Valid)</small></label>
                        <select name="id_bidang" id="id_bidang" class="form-control">
                            <option value="">-- Pilih Bidang Tujuan --</option>
                            <?php foreach ($bidang as $b) : ?>
                                <option value="<?= $b->id_bidang ?>"><?= esc($b->bidang) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Dokumen yang Diajukan -->
                    <h6 class="mb-3 font-weight-bold" style="color: #1B2559;">Dokumen yang Diajukan</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%" class="text-center">No</th>
                                    <th>Nama Dokumen</th>
                                    <th class="text-center">File</th>
                                    <th width="35%" class="text-center">Verifikasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($files)) : ?>
                                    <?php $no = 1; foreach ($files as $f) : ?>
                                        <tr>
                                            <td class="text-center align-middle"><?= $no++ ?></td>
                                            <td class="align-middle"><?= esc($f->nama_file_master ?? 'Dokumen') ?></td>
                                            <td class="text-center align-middle">
                                                <a href="<?= base_url('uploads/permohonan/' . $f->path_file) ?>" target="_blank" class="btn btn-sm btn-info" title="Lihat Berkas">
                                                    <i class="fas fa-file-pdf"></i> Lihat
                                                </a>
                                            </td>
                                            <td class="text-center align-middle">
                                                <!-- Default: anggap belum di-set, jadi user harus klik Valid / Tidak Valid -->
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <input type="hidden" name="file_status[<?= $f->id_file_permohonan_magang ?>]" value="" required>
                                                    <button type="button" class="btn btn-outline-secondary btn-validasi-file" data-value="VALID">Valid</button>
                                                    <button type="button" class="btn btn-outline-secondary btn-validasi-file" data-value="TIDAK_VALID">Tidak Valid</button>
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
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Jika salah satu berkas ditandai <b>Tidak Valid</b>, status permohonan otomatis menjadi <b>Perbaikan Berkas</b> (Ditolak) dan disposisi dibatalkan.</small>
                    </div>
                </div>
                
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSimpanKeputusan">
                        <i class="fas fa-save mr-1"></i> Simpan Keputusan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
