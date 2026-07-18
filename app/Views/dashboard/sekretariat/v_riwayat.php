<?php
/**
 * ============================================================
 * Kode      : v_riwayat.php
 * Path      : Views/dashboard/sekretariat/v_riwayat.php
 * Deskripsi : View halaman riwayat semua permohonan.
 *             Menampilkan tabel dengan header navy blue,
 *             search, filter, dan pagination.
 * ============================================================
 */
?>

<?= $this->extend('layout/L_master') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

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
                <th width="8%" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($permohonan)) : ?>
                <?php $no = 1; foreach ($permohonan as $row) : ?>
                <?php
                    // Tentukan status berdasarkan persetujuan & disposisi
                    $status = $row->status_persetujuan ?? 'MENUNGGU';
                    $disposisi = $row->disposisi ?? '0';

                    if ($status == 'DISETUJUI' && $disposisi == '1') {
                        $badgeClass = 'sudah-ditempatkan';
                        $statusText = 'Sudah Ditempatkan';
                        $filterValue = 'SUDAH_DITEMPATKAN';
                    } elseif ($status == 'DISETUJUI' && $disposisi != '1') {
                        $badgeClass = 'menunggu-penempatan';
                        $statusText = 'Menunggu Penempatan';
                        $filterValue = 'MENUNGGU_PENEMPATAN';
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
                        <?php if ($status == 'DISETUJUI' && $disposisi == '1' && !empty($row->bidang)) : ?>
                            <div style="font-size:0.7rem; color:#667085; margin-top:3px;">
                                <i class="fas fa-building" style="font-size:0.6rem;"></i> <?= esc($row->bidang) ?>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <a href="<?= base_url('sekretariat/verifikasi/detail/' . $row->id_permohonan_magang) ?>" class="riwayat-action-btn" title="Detail">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
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
});
</script>
<?= $this->endSection() ?>
