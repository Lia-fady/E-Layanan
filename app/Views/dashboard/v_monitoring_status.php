<?php
/**
 * ============================================================
 * Kode      : v_monitoring_status.php
 * Path      : Views/dashboard/sekretariat/v_monitoring_status.php
 * Deskripsi : View halaman Monitoring Status sesuai desain Figma.
 *             Menampilkan tabel monitoring dengan kolom ID, NAMA,
 *             NIM, JENIS, TANGGAL, BERKAS, STATUS, AKSI.
 * ============================================================
 */
?>

<?= $this->extend('layout/L_master') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Search & Filter -->
<div class="chart-card mb-4">
    <div class="row align-items-center">
        <div class="col-md-8 mb-2 mb-md-0">
            <div class="position-relative">
                <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #98a2b3;"></i>
                <input type="text" id="searchInput" class="form-control" placeholder="Cari nama atau ID..." style="padding-left: 2.2rem; border: 1px solid #d0d5dd; border-radius: 8px;">
            </div>
        </div>
        <div class="col-md-4">
            <select id="filterStatus" class="form-control" style="border: 1px solid #d0d5dd; border-radius: 8px;">
                <option value="">Semua Status</option>
                <option value="Menunggu">Menunggu</option>
                <option value="Menunggu Penempatan">Menunggu Penempatan</option>
                <option value="Sudah Ditempatkan">Sudah Ditempatkan</option>
                <option value="Ditolak">Ditolak</option>
            </select>
        </div>
    </div>
</div>

<!-- Info Banner -->
<?php if (!empty($info_count)) : ?>
<div class="disposisi-info-banner mb-3">
    <i class="fas fa-info-circle"></i>
    <p><strong><?= $info_count ?> berkas</strong> sedang dalam proses monitoring.</p>
</div>
<?php endif; ?>

<!-- Monitoring Table -->
<div class="chart-card">
    <div class="table-responsive">
        <table class="table table-modern" id="tabelMonitoring" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NAMA</th>
                    <th>NIM</th>
                    <th>JENIS</th>
                    <th>TANGGAL</th>
                    <th class="text-center">BERKAS</th>
                    <th class="text-center">STATUS</th>
                    <th class="text-center">AKSI</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($permohonan)) : ?>
                    <?php foreach ($permohonan as $row) : ?>
                        <tr>
                            <td>
                                <span class="disposisi-id">PMH-<?= date('Y', strtotime($row['created_at'] ?? 'now')) ?>-<?= str_pad($row['id_persetujuan_magang'] ?? $row['id_permohonan_magang'], 3, '0', STR_PAD_LEFT) ?></span>
                            </td>
                            <td><strong><?= esc($row['nama_mahasiswa']) ?></strong></td>
                            <td><?= esc($row['nim']) ?></td>
                            <td><?= esc($row['jenis_permohonan']) ?></td>
                            <td><?= !empty($row['created_at']) ? date('d M Y', strtotime($row['created_at'])) : '-' ?></td>
                            <td class="text-center">
                                <?php
                                    $totalBerkas = isset($row['total_berkas']) ? (int)$row['total_berkas'] : 0;
                                    $requiredBerkas = isset($row['required_berkas']) ? (int)$row['required_berkas'] : 3;
                                    $isComplete = $totalBerkas >= $requiredBerkas;
                                ?>
                                <div class="berkas-badge <?= $isComplete ? 'complete' : 'incomplete' ?>">
                                    <span class="count"><?= $totalBerkas ?>/<?= $requiredBerkas ?></span>
                                </div>
                            </td>
                            <td class="text-center">
                                <?php
                                    $status = $row['status_persetujuan'] ?? 'MENUNGGU';
                                    $disposisi = $row['disposisi'] ?? '0';

                                    if ($status === 'DISETUJUI' && $disposisi == '1') {
                                        $badgeClass = 'sudah-ditempatkan';
                                        $badgeText = 'Sudah Ditempatkan';
                                    } elseif ($status === 'DISETUJUI' && $disposisi != '1') {
                                        $badgeClass = 'menunggu-penempatan';
                                        $badgeText = 'Menunggu Penempatan';
                                    } elseif ($status === 'DITOLAK') {
                                        $badgeClass = 'ditolak';
                                        $badgeText = 'Ditolak';
                                    } else {
                                        $badgeClass = 'menunggu';
                                        $badgeText = 'Menunggu';
                                    }
                                ?>
                                <span class="status-badge <?= $badgeClass ?>"><?= $badgeText ?></span>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('sekretariat/verifikasi/detail/' . ($row['id_persetujuan_magang'] ?? '')) ?>" class="action-icon view" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    var table = $('#tabelMonitoring').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
        },
        "order": [],
        "responsive": true,
        "dom": 'rtip', // hide default search since we have custom one
        "pageLength": 10
    });

    // Custom search
    $('#searchInput').on('keyup', function() {
        table.search(this.value).draw();
    });

    // Custom status filter
    $('#filterStatus').on('change', function() {
        table.column(6).search(this.value).draw();
    });
});
</script>
<?= $this->endSection() ?>
