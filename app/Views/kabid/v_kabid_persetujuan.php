<?= $this->extend('layout/L_master'); ?>

<?php $permohonan = isset($permohonan) ? $permohonan : []; ?>

<?= $this->section('content'); ?>
<div class="row mb-3">
    <div class="col-12">
        <h1 class="h4 mb-1 font-weight-bold text-dark text-uppercase">Disposisi Bidang</h1>
        <p class="text-muted small mb-0">Permohonan mahasiswa yang telah didisposisikan oleh Sekretariat untuk bidang Anda.</p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card shadow-sm border-0" style="background-color: #d6e6f7; border-radius: 8px;">
            <div class="card-body py-3 px-4 d-flex align-items-center">
                <div class="rounded-circle bg-white text-primary p-3 mr-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 45px;">
                    <i class="fas fa-file-alt fa-lg" style="color: #4a90e2;"></i>
                </div>
                <div>
                    <div class="text-dark font-weight-bold mb-0" style="font-size: 0.85rem;">Total Pemohon Masuk</div>
                    <h2 class="font-weight-bold text-primary mb-0" style="line-height: 1; font-size: 2rem;"><?= esc($total_permohonan ?? count($permohonan)) ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 mb-4" style="border-radius: 8px;">
    <div class="card-header bg-white border-bottom-0 pt-4 pb-2">
        <h6 class="m-0 font-weight-bold text-dark" style="font-size: 1.1rem;">Dokumen yang Diajukan</h6>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr style="background-color: #ebdcd7; color: #495057;">
                        <th class="font-weight-bold text-center py-3" style="border: none; width: 6%;">NO</th>
                        <th class="font-weight-bold py-3" style="border: none; width: 22%;">Nama Mahasiswa</th>
                        <th class="font-weight-bold py-3" style="border: none; width: 22%;">Universitas</th>
                        <th class="font-weight-bold py-3" style="border: none; width: 20%;">Jenis Permohonan</th>
                        <th class="font-weight-bold py-3" style="border: none; width: 14%;">Status</th>
                        <th class="font-weight-bold py-3" style="border: none; width: 10%;">Status</th>
                        <th class="font-weight-bold text-center py-3" style="border: none; width: 6%;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-dark" style="font-size: 0.9rem;">
                    <?php if (empty($permohonan)): ?>
                        <tr>
                            <td class="text-center py-3 font-weight-bold">1</td>
                            <td class="py-3 font-weight-bold">Budi Santoso</td>
                            <td class="py-3 text-muted">Universitas Budi Luhur</td>
                            <td class="py-3 font-weight-bold">Magang / PKL</td>
                            <td class="py-3 small font-weight-bold">21 Mei 2026<br><span class="text-muted font-weight-normal" style="font-size: 0.75rem;">oleh Sekretariat</span></td>
                            <td class="py-3"><span class="badge text-white px-3 py-2 text-center" style="background-color: #ffb822; font-size: 0.75rem; border-radius: 4px; display: block; width: 85px;">Menunggu</span></td>
                            <td class="text-center py-3">
                                <button class="btn btn-xs btn-outline-primary px-2 py-1" style="font-size: 0.7rem; border-radius: 3px;" data-toggle="modal" data-target="#modalDummy">Lihat</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center py-3 font-weight-bold">2</td>
                            <td class="py-3 font-weight-bold">Siti Rahmawati</td>
                            <td class="py-3 text-muted">Universitas Indonesia</td>
                            <td class="py-3 font-weight-bold">Penelitian Skripsi / TA</td>
                            <td class="py-3 small font-weight-bold">20 Mei 2026<br><span class="text-muted font-weight-normal" style="font-size: 0.75rem;">oleh Sekretariat</span></td>
                            <td class="py-3"><span class="badge text-white px-3 py-2 text-center" style="background-color: #ffb822; font-size: 0.75rem; border-radius: 4px; display: block; width: 85px;">Menunggu</span></td>
                            <td class="text-center py-3">
                                <button class="btn btn-xs btn-outline-primary px-2 py-1" style="font-size: 0.7rem; border-radius: 3px;" data-toggle="modal" data-target="#modalDummy">Lihat</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center py-3 font-weight-bold">3</td>
                            <td class="py-3 font-weight-bold">Rizky Pratama</td>
                            <td class="py-3 text-muted">Telkom University</td>
                            <td class="py-3 font-weight-bold">Magang / PKL</td>
                            <td class="py-3 small font-weight-bold">17 Mei 2026<br><span class="text-muted font-weight-normal" style="font-size: 0.75rem;">oleh Sekretariat</span></td>
                            <td class="py-3"><span class="badge text-white px-3 py-2 text-center" style="background-color: #ffb822; font-size: 0.75rem; border-radius: 4px; display: block; width: 85px;">Menunggu</span></td>
                            <td class="text-center py-3">
                                <button class="btn btn-xs btn-outline-primary px-2 py-1" style="font-size: 0.7rem; border-radius: 3px;" data-toggle="modal" data-target="#modalDummy">Lihat</button>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach($permohonan as $p): ?>
                        <tr>
                            <td class="text-center py-3 font-weight-bold"><?= $no++; ?></td>
                            <td class="py-3 font-weight-bold"><?= esc($p['nama_mahasiswa'] ?? '-'); ?></td>
                            <td class="py-3 text-muted"><?= esc($p['universitas'] ?? '-'); ?></td>
                            <td class="py-3 font-weight-bold"><?= esc($p['deskripsi_magang'] ?? '-'); ?></td>
                            <td class="py-3 small font-weight-bold">
                                <?= isset($p['tanggal_disposisi']) ? date('d M Y', strtotime($p['tanggal_disposisi'])) : date('d M Y'); ?><br>
                                <span class="text-muted font-weight-normal" style="font-size: 0.75rem;">oleh Sekretariat</span>
                            </td>
                            <td class="py-3">
                                <span class="badge text-white px-3 py-2 text-center" style="background-color: #ffb822; font-size: 0.75rem; border-radius: 4px; display: block; width: 85px;">
                                    <?= esc($p['status_persetujuan'] ?? 'Menunggu'); ?>
                                </span>
                            </td>
                            <td class="text-center py-3">
                                <button class="btn btn-xs btn-outline-primary px-2 py-1" style="font-size: 0.7rem; border-radius: 3px;" data-toggle="modal" data-target="#modalApprove<?= esc($p['id_persetujuan_magang']); ?>">
                                    Lihat
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="modal fade" id="modalDummy" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold text-dark">Persetujuan Kepala Bidang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <p>Ini adalah tampilan pop-up persetujuan untuk data simulasi.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <?php foreach($permohonan as $p): ?>
            <div class="modal fade" id="modalApprove<?= esc($p['id_persetujuan_magang']); ?>" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="<?= base_url('sekretariat/c_kabid/simpan_persetujuan'); ?>" method="post">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title font-weight-bold text-dark">Persetujuan & Penempatan Kepala Bidang</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id_persetujuan" value="<?= esc($p['id_persetujuan_magang']); ?>">
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark">Keputusan Aksi</label>
                                    <select name="status" class="form-control">
                                        <option value="DISETUJUI">Setujui & Tempatkan Magang</option>
                                        <option value="DITOLAK">Tolak Berkas Permohonan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark">Catatan Tambahan</label>
                                    <textarea name="catatan" class="form-control" rows="3" placeholder="Masukkan instruksi penempatan bidang..."></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                                <button type="submit" class="btn btn-primary px-4">Simpan Keputusan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection(); ?>