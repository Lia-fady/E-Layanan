<?= $this->extend('layout/L_master') ?>

<?= $this->section('title') ?>
Detail Kuota Bidang
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>
    .quota-card { border-radius: 12px; border: 1px solid #E2E8F0; }
    .table-quota th { background-color: #F8FAFC; color: #475569; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #E2E8F0; padding: 1rem; }
    .table-quota td { padding: 1rem; vertical-align: middle; color: #1E293B; border-bottom: 1px solid #E2E8F0; }
    
    .badge-status { padding: 0.4rem 0.8rem; border-radius: 6px; font-weight: 600; font-size: 0.8rem; }
    .badge-tersedia { background-color: #DCFCE7; color: #16A34A; }
    .badge-penuh { background-color: #FEE2E2; color: #DC2626; }
    
    .btn-back {
        background-color: #fff;
        color: #475569;
        border: 1px solid #CBD5E1;
        border-radius: 8px;
        font-weight: 600;
        padding: 0.5rem 1rem;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
    }
    .btn-back:hover {
        background-color: #F1F5F9;
        color: #0F172A;
        text-decoration: none;
    }
</style>

<div class="mb-4">
    <a href="<?= base_url('sekretariat/kuota') ?>" class="btn-back mb-3">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Bidang
    </a>
    <h5 style="font-weight:700; color:#1B2559; margin-bottom:4px;">Rincian Kuota Tahun <?= esc($tahun) ?> Bidang <?= esc($bidang['bidang']) ?></h5>
    <p style="color:#667085; font-size:0.9rem; margin:0;">
        Pantau kapasitas dan penggunaan kuota untuk bidang ini sepanjang tahun.
    </p>
</div>

<div class="card shadow-sm quota-card bg-white mb-4">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-quota mb-0 dt-kuota" width="100%">
                <thead>
                    <tr>
                        <th width="35%">Bulan</th>
                        <th width="15%" class="text-center">Batas Kuota</th>
                        <th width="15%" class="text-center">Terpakai</th>
                        <th width="15%" class="text-center">Sisa Kuota</th>
                        <th width="20%" class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($kuota_bulan)): ?>
                        <?php foreach($kuota_bulan as $k): ?>
                            <tr>
                                <td class="font-weight-bold" style="padding-left: 1rem; color: #1E293B;"><?= esc($k['bulan_nama']) ?></td>
                                <td class="text-center text-muted"><?= esc($k['batas_kuota']) ?></td>
                                <td class="text-center font-weight-bold text-primary"><?= esc($k['terpakai']) ?></td>
                                <td class="text-center font-weight-bold" style="color: <?= $k['sisa_kuota'] > 0 ? '#16A34A' : '#DC2626' ?>;"><?= esc($k['sisa_kuota']) ?></td>
                                <td class="text-center">
                                    <?php if ($k['status'] === 'Tersedia'): ?>
                                        <span class="badge badge-status badge-tersedia">Tersedia</span>
                                    <?php else: ?>
                                        <span class="badge badge-status badge-penuh">Penuh</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('.dt-kuota').DataTable({
        "pageLength": 6, // 6 items per page exactly divides 12 months into 2 pages
        "lengthChange": false, // Hide the "show X entries" dropdown
        "searching": false, // Hide search box for cleaner look since it's just months
        "ordering": false, // Keep chronological order (Jan-Dec)
        "language": {
            "sEmptyTable":   "Tidak ada data bulan yang tersedia",
            "sInfo":         "Menampilkan bulan _START_ sampai _END_ (Total 12 Bulan)",
            "sInfoEmpty":    "",
            "sInfoFiltered": "",
            "oPaginate": {
                "sFirst":    "Pertama",
                "sLast":     "Terakhir",
                "sNext":     ">",
                "sPrevious": "<"
            }
        }
    });
});
</script>
<?= $this->endSection() ?>
