<?php

/**
 * ============================================================
 * Kode      : _list.php
 * Path      : Views/dashboard/sekretariat/upload_surat_penerimaan/_list.php
 * Deskripsi : Partial view untuk daftar mahasiswa (Persetujuan Magang).
 * ============================================================
 */
?>

<!-- Search & Filter -->
<div class="verifikasi-search-bar">
    <div style="position:relative; flex:1; max-width:450px;">
        <i class="fas fa-search" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#98a2b3;"></i>
        <input type="text" id="searchUploadSurat" placeholder="Cari nama..." style="width:100%;">
    </div>
    <select id="filterJenisPermohonan">
        <option value="">-- Semua Jenis --</option>
        <option value="Penelitian">Penelitian Skripsi / TA</option>
        <option value="Observasi">Observasi / Pengambilan Data</option>
        <option value="Magang">Magang / PKL</option>
        <option value="Uji Coba">Uji Coba Produk (Prototype)</option>
    </select>
    <select id="filterStatusPermohonan">
        <option value="">-- Semua Status --</option>
        <option value="MENUNGGU">Menunggu</option>
        <option value="BERJALAN">Diterima / Berjalan</option>
        <option value="SELESAI">Selesai</option>
        <option value="DIBATALKAN">Dibatalkan</option>
    </select>
    <select id="filterStatusSurat">
        <option value="">-- Semua Surat --</option>
        <option value="Sudah Di-upload">Sudah Di-upload</option>
        <option value="Belum Di-upload">Belum Di-upload</option>
    </select>
</div>

        <div class="table-responsive">
            <table class="riwayat-table" id="dataTable" width="100%">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Asal Instansi</th>
                        <th>Jenis Permohonan</th>
                        <th>Periode</th>
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
                                <td><?= esc($p->nim ?? '-') ?></td>
                                <td>
                                    <?= esc($p->instansi_pendidikan ?? '-') ?><br>
                                    <small class="text-muted"><?= esc($p->nama_prodi ?? '-') ?></small>
                                </td>
                                <td>
                                    <span class="badge badge-info"><?= esc($p->jenis_permohonan ?? '-') ?></span>
                                </td>
                                <td>
                                    <?php
                                        $mulai = !empty($p->tgl_mulai) ? date('d M Y', strtotime($p->tgl_mulai)) : '-';
                                        $selesai = !empty($p->tgl_selesai) ? date('d M Y', strtotime($p->tgl_selesai)) : '-';
                                    ?>
                                    <?= $mulai ?> s/d <?= $selesai ?>
                                </td>
                                <td class="text-center">
                                    <?php if (($p->status_penempatan ?? 'MENUNGGU') === 'DISETUJUI') : ?>
                                        <span class="badge badge-primary">DISETUJUI</span>
                                    <?php elseif (($p->status_penempatan ?? 'MENUNGGU') === 'BERJALAN') : ?>
                                        <span class="badge badge-success">BERJALAN</span>
                                    <?php elseif (($p->status_penempatan ?? 'MENUNGGU') === 'MENUNGGU') : ?>
                                        <span class="badge badge-warning">MENUNGGU</span>
                                    <?php elseif (($p->status_penempatan ?? 'MENUNGGU') === 'SELESAI') : ?>
                                        <span class="badge badge-info">SELESAI</span>
                                    <?php elseif (($p->status_penempatan ?? 'MENUNGGU') === 'DITOLAK') : ?>
                                        <span class="badge badge-danger">DITOLAK</span>
                                    <?php else : ?>
                                        <span class="badge badge-secondary"><?= esc($p->status_penempatan ?? 'DIBATALKAN') ?></span>
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
                                    <?php if (!in_array(($p->status_penempatan ?? ''), ['DIBATALKAN', 'DITOLAK'])) : ?>
                                        <button type="button" class="btn btn-sm btn-primary btn-upload-surat" data-id-persetujuan="<?= $p->id_persetujuan_magang ?>" title="Upload Surat">
                                            <i class="fas fa-file-upload mr-1"></i> Upload Surat
                                        </button>
                                    <?php else : ?>
                                        <span class="text-muted" title="Tidak dapat diupload karena status <?= esc(strtolower($p->status_penempatan)) ?>"><i class="fas fa-ban"></i></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>