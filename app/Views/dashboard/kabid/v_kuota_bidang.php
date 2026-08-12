<?= $this->extend('layout/L_master_kabid') ?>

<?= $this->section('title') ?>
Manajemen Kuota Bidang
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Custom Styles for Kuota -->
<style>
    .quota-card { border-radius: 12px; border: 1px solid #E2E8F0; }
    .table-quota th { background-color: #F8FAFC; color: #475569; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #E2E8F0; padding: 1rem; }
    .table-quota td { padding: 1rem; vertical-align: middle; color: #1E293B; border-bottom: 1px solid #E2E8F0; }
    .badge-status { padding: 0.4rem 0.8rem; border-radius: 6px; font-weight: 600; font-size: 0.8rem; }
    .badge-tersedia { background-color: #DCFCE7; color: #16A34A; }
    .badge-penuh { background-color: #FEE2E2; color: #DC2626; }
    .badge-belum { background-color: #F1F5F9; color: #94A3B8; }

    .btn-aksi {
        border-radius: 6px;
        padding: 0.4rem 0.8rem;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        white-space: nowrap;
    }
    .btn-aksi-detail {
        background-color: #EFF6FF;
        color: #1D4ED8;
        border: 1px solid #BFDBFE;
    }
    .btn-aksi-detail:hover {
        background-color: #1D4ED8;
        color: #fff;
        border-color: #1D4ED8;
        text-decoration: none;
    }
    .btn-aksi-atur {
        background-color: #F0FDF4;
        color: #15803D;
        border: 1px solid #BBF7D0;
    }
    .btn-aksi-atur:hover {
        background-color: #15803D;
        color: #fff;
        border-color: #15803D;
        text-decoration: none;
    }

    .filter-tahun-select {
        border-radius: 8px;
        border: 1px solid #CBD5E1;
        padding: 0.5rem 2rem 0.5rem 0.8rem;
        font-size: 0.95rem;
        font-weight: 600;
        color: #1E293B;
        background-color: #fff;
        min-width: 120px;
        cursor: pointer;
    }
    .filter-tahun-select:focus {
        border-color: #3B82F6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        outline: none;
    }
</style>

<div class="mb-4">
    <h5 style="font-weight:700; color:#1B2559; margin-bottom:4px;">Kuota Bidang</h5>
    <p style="color:#667085; font-size:0.9rem; margin:0;">
        Atur dan kelola batas maksimal mahasiswa yang dapat diterima di bidang Anda.
    </p>
</div>

<!-- Filter Tahun -->
<div class="d-flex align-items-center mb-4">
    <label for="filterTahun" class="mr-2 mb-0" style="font-weight:600; color:#475569; font-size:0.9rem;">Tahun</label>
    <select id="filterTahun" class="filter-tahun-select">
        <?php foreach ($available_years as $y): ?>
            <option value="<?= $y ?>" <?= ($y == $tahun) ? 'selected' : '' ?>><?= $y ?></option>
        <?php endforeach; ?>
    </select>
</div>

<!-- Rincian Kuota -->
<div class="card shadow-sm quota-card bg-white mb-4">
    <div class="card-body p-4">
        <!-- Bulan Terpakai -->
        <div class="mb-4" style="background:#F8FAFC; padding:1.5rem; border-radius:12px; border:1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <h5 style="font-weight:700; color:#1E293B; margin-bottom:0.8rem; font-size:1.1rem; display: flex; align-items: center;">
                <i class="fas fa-calendar-check text-primary mr-2" style="font-size: 1.2rem;"></i> Bulan Terpakai
            </h5>
            <div style="font-size:1rem; color:#334155; line-height: 1.6; font-weight: 500;" id="val-bulan-terpakai">
                <?= $bulan_terpakai ?>
            </div>
        </div>

        <!-- Tabel Kuota -->
        <div class="table-responsive">
            <table class="table table-quota mb-0" id="tabel_kuota" width="100%">
                <thead>
                    <tr>
                        <th width="20%">Bulan</th>
                        <th width="15%" class="text-center">Batas Kuota</th>
                        <th width="12%" class="text-center">Terpakai</th>
                        <th width="15%" class="text-center">Sisa Kuota</th>
                        <th width="15%" class="text-center">Status</th>
                        <th width="23%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($list_kuota)): ?>
                        <?php foreach ($list_kuota as $k): ?>
                            <tr>
                                <td class="font-weight-bold" style="padding-left: 1.5rem;"><?= esc($k['bulan_nama']) ?></td>
                                <td class="text-center">
                                    <?php if ($k['batas_kuota'] !== null): ?>
                                        <span style="font-size: 1.05rem; color: #475569;"><?= esc($k['batas_kuota']) ?></span>
                                    <?php else: ?>
                                        <span style="font-size: 1.05rem; color: #94A3B8;">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <span style="font-size: 1.05rem; font-weight: 700; color: #3B82F6;"><?= esc($k['terpakai']) ?></span>
                                </td>
                                <td class="text-center">
                                    <?php if ($k['sisa_kuota'] !== null): ?>
                                        <span style="font-size: 1.05rem; font-weight: 700; color: <?= $k['sisa_kuota'] > 0 ? '#16A34A' : '#DC2626' ?>;">
                                            <?= esc($k['sisa_kuota']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span style="font-size: 1.05rem; color: #94A3B8;">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($k['status'] === 'Tersedia'): ?>
                                        <span class="badge badge-status badge-tersedia">Tersedia</span>
                                    <?php elseif ($k['status'] === 'Penuh'): ?>
                                        <span class="badge badge-status badge-penuh">Penuh</span>
                                    <?php else: ?>
                                        <span class="badge badge-status badge-belum">Belum Diatur</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($k['id_kuota'] !== null): ?>
                                        <a href="<?= base_url('kabid/kuota/' . $tahun . '/' . $k['bulan_angka']) ?>" class="btn-aksi btn-aksi-detail">
                                            <i class="fas fa-eye"></i> Lihat Detail
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= base_url('kabid/kuota/' . $tahun . '/' . $k['bulan_angka']) ?>" class="btn-aksi btn-aksi-atur">
                                            <i class="fas fa-plus"></i> Atur Kuota
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Data kuota belum tersedia.</td>
                        </tr>
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
    // Initialize DataTables for 6 months per page
    $('#tabel_kuota').DataTable({
        "pageLength": 6,
        "lengthChange": false,
        "searching": false,
        "info": true,
        "language": {
            "sInfo": "Menampilkan bulan _START_ sampai _END_ (Total _TOTAL_ Bulan)",
            "sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 Bulan",
            "oPaginate": {
                "sNext": ">",
                "sPrevious": "<"
            }
        },
        "ordering": false
    });

    // Filter Tahun — redirect saat berubah
    $('#filterTahun').on('change', function() {
        var tahun = $(this).val();
        window.location.href = '<?= base_url("kabid/kuota") ?>?tahun=' + tahun;
    });
});
</script>
<?= $this->endSection() ?>
