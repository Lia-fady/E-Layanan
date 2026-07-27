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
        <h6 class="m-0 font-weight-bold text-primary">Daftar Mahasiswa (Persetujuan Magang)</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>Nama Mahasiswa</th>
                        <th>NIM</th>
                        <th>Asal Kampus / Prodi</th>
                        <th>Periode Magang</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($persetujuan)) : ?>
                        <?php $no = 1; foreach ($persetujuan as $p) : ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= esc($p->nama_mahasiswa ?? '-') ?></td>
                            <td><?= esc($p->nim ?? '-') ?></td>
                            <td>
                                <?= esc($p->instansi_pendidikan ?? '-') ?><br>
                                <small class="text-muted"><?= esc($p->prodi ?? '-') ?></small>
                            </td>
                            <td>
                                <?php
                                    $mulai = !empty($p->tgl_mulai) ? date('d M Y', strtotime($p->tgl_mulai)) : '-';
                                    $selesai = !empty($p->tgl_selesai) ? date('d M Y', strtotime($p->tgl_selesai)) : '-';
                                ?>
                                <?= $mulai ?> s/d <?= $selesai ?>
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
