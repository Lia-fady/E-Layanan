<?= $this->extend('layout/L_master_kabid') ?>

<?= $this->section('title') ?>
Manajemen Kuota Bidang
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Custom Styles for Kuota -->
<style>
    .dashboard-header-title { font-weight: 800; color: #0F172A; font-size: 1.8rem; letter-spacing: -0.5px; }
    .dashboard-subtitle { font-weight: 600; color: #64748B; font-size: 0.85rem; letter-spacing: 1px; text-transform: uppercase; }
    .quota-card { border-radius: 12px; border: 1px solid #E2E8F0; }
    .table-quota th { background-color: #F8FAFC; color: #475569; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #E2E8F0; padding: 1rem; }
    .table-quota td { padding: 1rem; vertical-align: middle; color: #1E293B; border-bottom: 1px solid #E2E8F0; }
    .badge-status { padding: 0.4rem 0.8rem; border-radius: 6px; font-weight: 600; font-size: 0.8rem; }
    .badge-tersedia { background-color: #DCFCE7; color: #16A34A; }
    .badge-penuh { background-color: #FEE2E2; color: #DC2626; }
    .btn-edit-kuota { border-radius: 6px; padding: 0.3rem 0.8rem; font-size: 0.85rem; }
</style>

<div class="d-flex justify-content-between align-items-end mb-4">
    <div>
        <h5 style="font-weight:700; color:#1B2559; margin-bottom:4px;">Pengaturan Kuota Bulanan</h5>
        <p style="color:#667085; font-size:0.85rem; margin:0;">
            Rincian Kuota Tahun <?= esc($tahun) ?>
        </p>
    </div>
</div>

<div class="card shadow-sm quota-card bg-white mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-quota mb-0">
                <thead>
                    <tr>
                        <th width="15%">Bulan</th>
                        <th width="15%" class="text-center">Batas Kuota</th>
                        <th width="15%" class="text-center">Terpakai</th>
                        <th width="15%" class="text-center">Sisa Kuota</th>
                        <th width="15%" class="text-center">Status</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($list_kuota)): ?>
                        <?php foreach ($list_kuota as $k): ?>
                            <tr>
                                <td class="font-weight-bold"><?= esc($k['bulan_nama']) ?></td>
                                <td class="text-center">
                                    <span style="font-size: 1.1rem; font-weight: 700; color: #0F172A;"><?= esc($k['batas_kuota']) ?></span>
                                </td>
                                <td class="text-center">
                                    <span style="font-size: 1.1rem; font-weight: 700; color: #3B82F6;"><?= esc($k['terpakai']) ?></span>
                                </td>
                                <td class="text-center">
                                    <span style="font-size: 1.1rem; font-weight: 700; color: <?= $k['sisa_kuota'] > 0 ? '#16A34A' : '#DC2626' ?>;"><?= esc($k['sisa_kuota']) ?></span>
                                </td>
                                <td class="text-center">
                                    <?php if ($k['status'] === 'Tersedia'): ?>
                                        <span class="badge badge-status badge-tersedia"><i class="fas fa-check-circle mr-1"></i> Tersedia</span>
                                    <?php else: ?>
                                        <span class="badge badge-status badge-penuh"><i class="fas fa-times-circle mr-1"></i> Penuh</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-primary btn-edit-kuota" 
                                            onclick="editKuota(<?= $k['id_kuota'] ?>, '<?= $k['bulan_nama'] ?>', <?= $k['batas_kuota'] ?>, <?= $k['terpakai'] ?>)">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </button>
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

<!-- Modal Edit Kuota -->
<div class="modal fade" id="modalEditKuota" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header bg-light" style="border-bottom: 1px solid #E2E8F0; border-radius: 12px 12px 0 0;">
                <h5 class="modal-title" style="font-weight: 700; color: #1E293B;">Edit Kuota <span id="modalBulan"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('kabid/kuota/update') ?>" method="post" id="formUpdateKuota">
                <?= csrf_field() ?>
                <input type="hidden" name="id_kuota" id="editIdKuota">
                <div class="modal-body p-4">
                    <div class="alert alert-info" style="font-size: 0.85rem; border-radius: 8px;">
                        <i class="fas fa-info-circle mr-1"></i> Pastikan batas kuota tidak lebih kecil dari jumlah mahasiswa yang sudah terlanjur aktif (terpakai).
                    </div>
                    
                    <div class="form-group mb-4">
                        <label style="font-weight: 600; color: #475569; font-size: 0.9rem;">Terpakai Saat Ini</label>
                        <input type="text" class="form-control bg-light" id="editTerpakai" readonly style="font-weight: bold; color: #3B82F6; border-radius: 8px;">
                    </div>

                    <div class="form-group mb-0">
                        <label style="font-weight: 600; color: #475569; font-size: 0.9rem;">Batas Kuota Baru</label>
                        <input type="number" class="form-control" name="kuota" id="editBatasKuota" required min="0" style="border-radius: 8px; border: 1px solid #CBD5E1; padding: 0.6rem 1rem;">
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-top: 1px solid #E2E8F0; border-radius: 0 0 12px 12px;">
                    <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal" style="border-radius: 8px;">Batal</button>
                    <button type="submit" class="btn btn-primary font-weight-bold" style="border-radius: 8px; background-color: #1E40AF; border-color: #1E40AF;">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function editKuota(id, bulan, batas, terpakai) {
    $('#modalBulan').text(bulan);
    $('#editIdKuota').val(id);
    $('#editTerpakai').val(terpakai + ' Mahasiswa');
    $('#editBatasKuota').val(batas).attr('min', 0); // Bebas ubah batas kuota, namun bisa diberi alert
    $('#modalEditKuota').modal('show');
}

$(document).ready(function() {
    $('#formUpdateKuota').on('submit', function(e) {
        e.preventDefault();
        
        let batasBaru = parseInt($('#editBatasKuota').val());
        let terpakai = parseInt($('#editTerpakai').val().split(' ')[0]);
        
        if (batasBaru < terpakai) {
            Swal.fire({
                title: 'Peringatan',
                text: 'Batas kuota baru lebih kecil dari jumlah mahasiswa yang sudah terpakai ('+terpakai+'). Jika dilanjutkan, sisa kuota akan menjadi 0 dan status penuh.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1E40AF',
                cancelButtonColor: '#64748B',
                confirmButtonText: 'Tetap Simpan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        } else {
            this.submit();
        }
    });
});
</script>
<?= $this->endSection() ?>
