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
        <option value="MENUNGGU">Menunggu</option>
        <option value="DISETUJUI">Disetujui</option>
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
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><strong><?= esc($row->nama_mahasiswa ?? '-') ?></strong></td>
                    <td><?= esc($row->instansi_pendidikan ?? '-') ?></td>
                    <td><?= esc($row->jenis_permohonan ?? '-') ?></td>
                    <td><?= !empty($row->tgl_pengajuan) ? date('d M Y', strtotime($row->tgl_pengajuan)) : '-' ?></td>
                    <td class="text-center">
                        <?php
                            $status = $row->status_persetujuan ?? 'MENUNGGU';
                            $badgeClass = 'menunggu-verifikasi';
                            $statusText = 'Menunggu Verifikasi';
                            if ($status == 'DISETUJUI') {
                                $badgeClass = 'sedang-diproses';
                                $statusText = 'Sedang Diproses';
                            } elseif ($status == 'DITOLAK') {
                                $badgeClass = 'ditolak';
                                $statusText = 'Ditolak';
                            }
                        ?>
                        <span class="status-badge <?= $badgeClass ?>"><?= $statusText ?></span>
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

    // Custom filter
    $('#filterRiwayat').on('change', function() {
        table.column(5).search(this.value).draw();
    });

    // Hide default search
    $('#tabelRiwayat_filter').hide();
});
</script>
<?= $this->endSection() ?>
