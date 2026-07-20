<?php
/**
 * ============================================================
 * Kode      : v_riwayat.php
 * Path      : Views/dashboard/sekretariat/v_riwayat.php
 * Deskripsi : View halaman riwayat semua permohonan.
 *             Menampilkan tabel dengan header navy blue,
 *             search, filter, pagination, serta aksi
 *             edit verifikasi dan edit disposisi.
 * ============================================================
 */
?>

<?= $this->extend('layout/L_master') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')) : ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle mr-2"></i>
    <?= session()->getFlashdata('success') ?>
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')) : ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle mr-2"></i>
    <?= session()->getFlashdata('error') ?>
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
<?php endif; ?>

<!-- Search & Filter -->
<div class="verifikasi-search-bar">
    <div style="position:relative; flex:1; max-width:450px;">
        <i class="fas fa-search" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#98a2b3;"></i>
        <input type="text" id="searchRiwayat" placeholder="Cari nama/ universitas..." style="width:100%;">
    </div>
    <select id="filterRiwayat">
        <option value="">Filter</option>
        <option value="MENUNGGU">Menunggu Verifikasi</option>
        <option value="MENUNGGU_PENEMPATAN">Menunggu Penempatan</option>
        <option value="MENUNGGU_KABID">Menunggu Persetujuan Kabid</option>
        <option value="SUDAH_DITEMPATKAN">Sudah Ditempatkan</option>
        <option value="DITOLAK">Ditolak</option>
    </select>
</div>

<!-- Riwayat Table -->
<div class="table-responsive">
    <table class="riwayat-table" id="tabelRiwayat" width="100%">
        <thead>
            <tr>
                <th width="5%" class="text-center">NO</th>
                <th>Nama</th>
                <th>Universitas</th>
                <th>Jenis</th>
                <th>Tanggal Pengajuan</th>
                <th class="text-center">Status</th>
                <th width="14%" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($permohonan)) : ?>
                <?php $no = 1; foreach ($permohonan as $row) : ?>
                <?php
                    // Tentukan status berdasarkan persetujuan, disposisi & penempatan
                    $status = $row->status_persetujuan ?? 'MENUNGGU';
                    $disposisi = $row->disposisi ?? '0';
                    $status_penempatan = $row->status_penempatan ?? null;

                    if ($status == 'DISETUJUI') {
                        if ($status_penempatan == 'BERJALAN') {
                            $badgeClass = 'sudah-ditempatkan';
                            $statusText = 'Sudah Ditempatkan';
                            $filterValue = 'SUDAH_DITEMPATKAN';
                        } elseif ($status_penempatan == 'SELESAI') {
                            $badgeClass = 'sudah-ditempatkan';
                            $statusText = 'Selesai';
                            $filterValue = 'SUDAH_DITEMPATKAN';
                        } elseif ($status_penempatan == 'MENUNGGU') {
                            $badgeClass = 'menunggu-penempatan';
                            $statusText = 'Menunggu Kabid';
                            $filterValue = 'MENUNGGU_KABID';
                        } else {
                            $badgeClass = 'menunggu-penempatan';
                            $statusText = 'Menunggu Penempatan';
                            $filterValue = 'MENUNGGU_PENEMPATAN';
                        }
                    } elseif ($status == 'DITOLAK') {
                        $badgeClass = 'ditolak';
                        $statusText = 'Ditolak';
                        $filterValue = 'DITOLAK';
                    } else {
                        $badgeClass = 'menunggu-verifikasi';
                        $statusText = 'Menunggu Verifikasi';
                        $filterValue = 'MENUNGGU';
                    }
                ?>
                <tr data-filter-status="<?= $filterValue ?>">
                    <td class="text-center"><?= $no++ ?></td>
                    <td><strong><?= esc($row->nama_mahasiswa ?? '-') ?></strong></td>
                    <td><?= esc($row->instansi_pendidikan ?? '-') ?></td>
                    <td><?= esc($row->jenis_permohonan ?? '-') ?></td>
                    <td><?= !empty($row->tgl_pengajuan) ? date('d M Y', strtotime($row->tgl_pengajuan)) : '-' ?></td>
                    <td class="text-center">
                        <span class="status-badge <?= $badgeClass ?>"><?= $statusText ?></span>
                        <?php if (!empty($row->bidang)) : ?>
                            <div style="font-size:0.7rem; color:#667085; margin-top:3px;">
                                <i class="fas fa-building" style="font-size:0.6rem;"></i> <?= esc($row->bidang) ?>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center" style="gap:4px;">
                            <!-- Edit Verifikasi -->
                            <a href="<?= base_url('sekretariat/verifikasi/detail/' . $row->id_permohonan_magang) ?>"
                               class="riwayat-action-btn" title="Edit Verifikasi"
                               style="display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px;">
                                <i class="fas fa-edit"></i>
                            </a>

                            <!-- Edit Disposisi (hanya jika menunggu penempatan atau menunggu kabid) -->
                            <?php if ($status == 'DISETUJUI' && in_array($filterValue, ['MENUNGGU_PENEMPATAN', 'MENUNGGU_KABID']) && !empty($row->id_persetujuan_magang)) : ?>
                                <button type="button"
                                        class="riwayat-action-btn btn-edit-disposisi"
                                        title="Ubah Penempatan Bidang"
                                        style="display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; border:none; cursor:pointer; background:#EFF6FF; color:#2563EB; border-radius:6px;"
                                        data-id-persetujuan="<?= $row->id_persetujuan_magang ?>"
                                        data-nama="<?= esc($row->nama_mahasiswa ?? '-') ?>"
                                        data-bidang-id="<?= $row->id_bidang ?? '' ?>">
                                    <i class="fas fa-exchange-alt"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal Edit Disposisi -->
<div class="modal fade" id="modalEditDisposisi" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('sekretariat/riwayat/edit-disposisi') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id_persetujuan_magang" id="edit_id_persetujuan">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-exchange-alt mr-2"></i>Edit Disposisi Bidang</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Ubah bidang tujuan untuk <strong id="edit_nama_mahasiswa"></strong>:</p>
                    <div class="form-group">
                        <label for="edit_id_bidang"><strong>Bidang Tujuan Baru</strong></label>
                        <select class="form-control" name="id_bidang" id="edit_id_bidang" required>
                            <option value="">Pilih Bidang</option>
                            <?php if (!empty($bidang)) : ?>
                                <?php foreach ($bidang as $b) : ?>
                                    <option value="<?= $b->id_bidang ?>"><?= esc($b->bidang) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="alert alert-info" style="font-size:0.85rem;">
                        <i class="fas fa-info-circle mr-1"></i>
                        Mengubah bidang disposisi akan memperbarui data di tabel persetujuan dan penempatan (jika ada).
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    var table = $('#tabelRiwayat').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
        },
        "order": [[4, "desc"]],
        "pageLength": 10,
        "dom": '<"d-flex justify-content-between align-items-center mb-3"<""l><""f>>rt<"d-flex justify-content-between align-items-center mt-3"<""i><""p>>'
    });

    // Custom search
    $('#searchRiwayat').on('keyup', function() {
        table.search(this.value).draw();
    });

    // Custom filter berdasarkan data-attribute
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        var filterVal = $('#filterRiwayat').val();
        if (!filterVal) return true;
        var row = table.row(dataIndex).node();
        var rowStatus = $(row).data('filter-status');
        return rowStatus === filterVal;
    });

    $('#filterRiwayat').on('change', function() {
        table.draw();
    });

    // Hide default search
    $('#tabelRiwayat_filter').hide();

    // Modal Edit Disposisi
    $('.btn-edit-disposisi').on('click', function() {
        var idPersetujuan = $(this).data('id-persetujuan');
        var nama = $(this).data('nama');
        var bidangId = $(this).data('bidang-id');

        $('#edit_id_persetujuan').val(idPersetujuan);
        $('#edit_nama_mahasiswa').text(nama);
        $('#edit_id_bidang').val(bidangId);
        $('#modalEditDisposisi').modal('show');
    });
});
</script>

<?php if (session()->getFlashdata('success')) : ?>
<script>
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: '<?= session()->getFlashdata('success') ?>', timer: 3000 });
</script>
<?php endif; ?>
<?= $this->endSection() ?>
