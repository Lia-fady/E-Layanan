<?php

/**
 * ============================================================
 * Kode      : _list.php
 * Path      : Views/dashboard/sekretariat/upload_surat_penerimaan/_list.php
 * Deskripsi : Partial view untuk daftar mahasiswa (Persetujuan Magang).
 * ============================================================
 */
?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Peserta</h6>
    </div>
    <div class="card-body">
        <!-- Filter Row -->
        <div class="row mb-3">
            <div class="col-md-3">
                <label>Jenis Permohonan</label>
                <select id="filterJenisPermohonan" class="form-control form-control-sm">
                    <option value="">-- Semua Jenis --</option>
                    <option value="Penelitian">Penelitian Skripsi / TA</option>
                    <option value="Observasi">Observasi / Pengambilan Data</option>
                    <option value="Magang">Magang / PKL</option>
                    <option value="Uji Coba">Uji Coba Produk (Prototype)</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>Status</label>
                <select id="filterStatusPermohonan" class="form-control form-control-sm">
                    <option value="">-- Semua Status --</option>
                    <option value="MENUNGGU">Menunggu</option>
                    <option value="BERJALAN">Diterima / Berjalan</option>
                    <option value="SELESAI">Selesai</option>
                    <option value="DIBATALKAN">Dibatalkan</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>Status Surat</label>
                <select id="filterStatusSurat" class="form-control form-control-sm">
                    <option value="">-- Semua --</option>
                    <option value="Sudah Di-upload">Sudah Di-upload</option>
                    <option value="Belum Di-upload">Belum Di-upload</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>Nama</th>
                        <th>Jenis Permohonan</th>
                        <th>Status Penempatan</th>
                        <th class="text-center">Status Surat</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($persetujuan)) : ?>
                        <?php $no = 1;
                        foreach ($persetujuan as $p) : ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= esc($p->nama_mahasiswa ?? '-') ?></td>
                                <td><?= esc($p->jenis_permohonan ?? '-') ?></td>
                                <td class="text-center">
                                    <?php if (($p->status_penempatan ?? 'MENUNGGU') === 'BERJALAN') : ?>
                                        <span class="badge badge-success">BERJALAN</span>
                                    <?php elseif (($p->status_penempatan ?? 'MENUNGGU') === 'MENUNGGU') : ?>
                                        <span class="badge badge-warning">MENUNGGU</span>
                                    <?php elseif (($p->status_penempatan ?? 'MENUNGGU') === 'SELESAI') : ?>
                                        <span class="badge badge-info">SELESAI</span>
                                    <?php else : ?>
                                        <span class="badge badge-danger"><?= esc($p->status_penempatan ?? 'DIBATALKAN') ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if (isset($p->is_uploaded) && $p->is_uploaded > 0) : ?>
                                        <span class="badge badge-success"><i class="fas fa-circle mr-1" style="font-size: 0.7em;"></i> Sudah Di-upload</span>
                                    <?php else : ?>
                                        <span class="badge badge-danger"><i class="fas fa-circle mr-1" style="font-size: 0.7em;"></i> Belum Di-upload</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-primary btn-upload-surat" data-id-persetujuan="<?= $p->id_persetujuan_magang ?>" title="Upload Surat">
                                        <i class="fas fa-file-upload mr-1"></i> Upload Surat
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Tidak ada data permohonan yang disetujui.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>