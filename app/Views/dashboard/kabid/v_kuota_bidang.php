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
    .form-control-premium {
        border-radius: 8px;
        border: 1px solid #CBD5E1;
        padding: 0.6rem 1rem;
        font-size: 1rem;
        transition: all 0.2s;
    }
    .form-control-premium:focus {
        border-color: #3B82F6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
</style>

<div class="d-flex justify-content-between align-items-end mb-4">
    <div>
        <h5 style="font-weight:700; color:#1B2559; margin-bottom:4px;">Kuota Bidang</h5>
        <p style="color:#667085; font-size:0.85rem; margin:0;">
            Atur dan kelola batas maksimal mahasiswa/siswa yang dapat diterima di bidang Anda.
        </p>
    </div>
</div>



<div class="row">
    <!-- Form Kolom -->
    <div class="col-xl-7 col-lg-8">
        <div class="card shadow-sm quota-card bg-white mb-4">
            <div class="card-header bg-white py-3" style="border-bottom: 1px solid #E2E8F0; border-radius: 12px 12px 0 0;">
                <h6 class="m-0 font-weight-bold" style="color: #1E293B; font-size: 1.1rem;">Pengaturan Kuota Magang/PKL</h6>
            </div>
            <div class="card-body p-4">
                <?php if ($kuota): ?>
                <form action="<?= base_url('kabid/kuota/update') ?>" method="post" id="formUpdateKuota">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_kuota" value="<?= $kuota->id_kuota ?>">
                    
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label style="font-weight: 600; color: #475569; font-size: 0.9rem;">Nama Bidang</label>
                            <input type="text" class="form-control form-control-premium bg-light" value="<?= esc($kuota->bidang) ?>" readonly>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label style="font-weight: 600; color: #475569; font-size: 0.9rem;">Total Kuota</label>
                            <div class="input-group">
                                <input type="number" class="form-control form-control-premium" name="kuota" value="<?= esc($kuota->kuota) ?>" min="<?= $terisi ?>" required style="border-right: 0; border-top-right-radius: 0; border-bottom-right-radius: 0;">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white" style="border-color: #CBD5E1; color: #64748B; border-top-right-radius: 8px; border-bottom-right-radius: 8px;">Orang</span>
                                </div>
                            </div>
                            <small class="text-muted mt-2 d-block">Batas maksimal Mahasiswa/Siswa yang diterima bersamaan.</small>
                        </div>
                        <div class="col-md-6">
                            <label style="font-weight: 600; color: #475569; font-size: 0.9rem;">Mahasiswa/Siswa Aktif Saat Ini</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-premium bg-light" value="<?= $terisi ?>" readonly style="border-right: 0; border-top-right-radius: 0; border-bottom-right-radius: 0; color: #2563EB; font-weight: bold;">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-light" style="border-color: #CBD5E1; color: #64748B; border-top-right-radius: 8px; border-bottom-right-radius: 8px;">Mahasiswa/Siswa</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr style="border-color: #E2E8F0; margin: 2rem 0;">

                    <div class="d-flex justify-content-end">
                        <button type="button" id="btnUpdateKuota" class="btn btn-primary font-weight-bold px-4" style="border-radius: 8px; background-color: #1E40AF; border-color: #1E40AF;">
                            <i class="fas fa-save mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
                <?php else: ?>
                    <div class="text-center py-5">
                        <div class="mb-3"><i class="fas fa-exclamation-triangle fa-3x text-warning"></i></div>
                        <h5 style="color: #1E293B; font-weight: bold;">Data Kuota Belum Tersedia</h5>
                        <p style="color: #64748B;">Admin atau Sekretariat belum mengatur data inisial kuota untuk bidang Anda.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Informasi Kolom -->
    <div class="col-xl-5 col-lg-4">
        <?php if ($kuota): 
            $sisa = $kuota->kuota - $terisi; 
            $sisa = $sisa < 0 ? 0 : $sisa;
            
            $statusColor = $sisa > 0 ? '#16A34A' : '#DC2626';
            $statusBg = $sisa > 0 ? '#DCFCE7' : '#FEE2E2';
            $statusText = $sisa > 0 ? 'Tersedia' : 'Penuh';
            $icon = $sisa > 0 ? 'fa-check-circle' : 'fa-times-circle';
        ?>
        <div class="card shadow-sm quota-card bg-white mb-4">
            <div class="card-body p-4 text-center">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; background-color: <?= $statusBg ?>; color: <?= $statusColor ?>;">
                    <i class="fas <?= $icon ?> fa-3x"></i>
                </div>
                <h4 style="font-weight: 800; color: #1E293B; margin-bottom: 5px;"><?= $sisa ?> Posisi</h4>
                <div class="badge mb-3" style="background-color: <?= $statusBg ?>; color: <?= $statusColor ?>; padding: 0.4rem 0.8rem; font-size: 0.85rem; border-radius: 6px;">
                    Status Kuota: <?= $statusText ?>
                </div>
                <p style="color: #64748B; font-size: 0.9rem; line-height: 1.5; margin-bottom: 0;">
                    Bidang Anda saat ini memiliki sisa ruang untuk <strong><?= $sisa ?> mahasiswa/siswa baru</strong>. Saat ada mahasiswa/siswa yang statusnya berubah menjadi selesai, sisa kuota ini akan otomatis bertambah kembali.
                </p>
            </div>
        </div>
        
        <div class="alert bg-light" style="border: 1px solid #CBD5E1; border-radius: 12px; color: #475569; font-size: 0.85rem;">
            <i class="fas fa-info-circle mr-2 text-primary"></i> <strong>Catatan:</strong> Anda tidak bisa menurunkan total kuota di bawah jumlah mahasiswa yang sedang aktif kegiatan saat ini (<?= $terisi ?> mahasiswa).
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('#btnUpdateKuota').on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Konfirmasi Perubahan',
            text: 'Apakah Anda yakin ingin memperbarui total kuota bidang ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1E40AF',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Perbarui!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#formUpdateKuota').submit();
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
