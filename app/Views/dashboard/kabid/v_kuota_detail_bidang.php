<?= $this->extend('layout/L_master_kabid') ?>

<?= $this->section('title') ?>
Detail Kuota <?= esc($kuota_detail['bulan_nama']) ?> <?= esc($tahun) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Custom Styles for Detail Kuota -->
<style>
    .quota-card { border-radius: 12px; border: 1px solid #E2E8F0; }
    .panel-title { font-weight: 700; color: #1E293B; font-size: 1.1rem; }
    .form-label { font-weight: 600; color: #475569; font-size: 0.85rem; margin-bottom: 0.4rem; }
    .form-control-styled { border-radius: 8px; border: 1px solid #CBD5E1; padding: 0.6rem 1rem; font-size: 0.95rem; }
    .form-control-styled:focus { border-color: #3B82F6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
    .form-control-styled[readonly] { background-color: #F8FAFC; color: #64748B; border-color: #E2E8F0; }
    .badge-status { padding: 0.4rem 0.8rem; border-radius: 6px; font-weight: 600; font-size: 0.85rem; }
    .badge-tersedia { background-color: #DCFCE7; color: #16A34A; }
    .badge-penuh { background-color: #FEE2E2; color: #DC2626; }
    .badge-belum { background-color: #F1F5F9; color: #94A3B8; }

    .btn-back {
        background-color: #fff;
        color: #475569;
        border: 1px solid #CBD5E1;
        border-radius: 8px;
        font-weight: 600;
        padding: 0.5rem 1rem;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .btn-back:hover {
        background-color: #F1F5F9;
        color: #0F172A;
        text-decoration: none;
    }

    .info-card {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 1.2rem;
        text-align: center;
    }
    .info-card .label {
        font-size: 0.8rem;
        color: #64748B;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.4rem;
    }
    .info-card .value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0F172A;
    }
</style>

<!-- Header -->
<div class="mb-4">
    <a href="<?= base_url('kabid/kuota?tahun=' . $tahun) ?>" class="btn-back mb-3">
        <i class="fas fa-arrow-left"></i> Kembali ke Kuota Bidang
    </a>
    <h5 style="font-weight:700; color:#1B2559; margin-bottom:4px; margin-top:1rem;">
        Detail Kuota <?= esc($kuota_detail['bulan_nama']) ?> <?= esc($tahun) ?>
    </h5>
    <p style="color:#667085; font-size:0.9rem; margin:0;">
        <?= esc($nama_bidang) ?> — Kelola batas kuota untuk bulan <?= esc($kuota_detail['bulan_nama']) ?> tahun <?= esc($tahun) ?>.
    </p>
</div>

<div class="row">
    <!-- Info Kuota -->
    <div class="col-lg-4 mb-4">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="info-card">
                    <div class="label">Batas Kuota</div>
                    <div class="value" id="display-batas"><?= $kuota_detail['batas_kuota'] !== null ? esc($kuota_detail['batas_kuota']) : '-' ?></div>
                </div>
            </div>
            <div class="col-6 mb-3">
                <div class="info-card">
                    <div class="label">Terpakai</div>
                    <div class="value" style="color: #3B82F6;"><?= esc($kuota_detail['terpakai']) ?></div>
                </div>
            </div>
            <div class="col-6 mb-3">
                <div class="info-card">
                    <div class="label">Sisa Kuota</div>
                    <div class="value" id="display-sisa" style="color: <?= ($kuota_detail['sisa_kuota'] !== null && $kuota_detail['sisa_kuota'] > 0) ? '#16A34A' : '#DC2626' ?>;">
                        <?= $kuota_detail['sisa_kuota'] !== null ? esc($kuota_detail['sisa_kuota']) : '-' ?>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="info-card">
                    <div class="label">Status</div>
                    <div class="mt-1">
                        <?php if ($kuota_detail['status'] === 'Tersedia'): ?>
                            <span class="badge badge-status badge-tersedia">Tersedia</span>
                        <?php elseif ($kuota_detail['status'] === 'Penuh'): ?>
                            <span class="badge badge-status badge-penuh">Penuh</span>
                        <?php else: ?>
                            <span class="badge badge-status badge-belum">Belum Diatur</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Edit / Atur Kuota -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow-sm quota-card bg-white h-100">
            <div class="card-body p-4">
                <h6 class="panel-title mb-4">
                    <?= $kuota_detail['has_data'] ? 'Edit Kuota' : 'Atur Kuota Baru' ?>
                </h6>
                
                <form id="formKuota">
                    <?= csrf_field() ?>
                    <input type="hidden" name="tahun" value="<?= esc($tahun) ?>">
                    <input type="hidden" name="bulan" value="<?= esc($bulan) ?>">
                    
                    <div class="form-group mb-3">
                        <label class="form-label">Nama Bidang</label>
                        <input type="text" class="form-control form-control-styled" value="<?= esc($nama_bidang) ?>" readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Periode</label>
                        <input type="text" class="form-control form-control-styled" value="<?= esc($kuota_detail['bulan_nama']) ?> <?= esc($tahun) ?>" readonly style="font-weight: bold; color: #0F172A;">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Batas Kuota</label>
                        <div class="input-group">
                            <input type="number" class="form-control form-control-styled" name="kuota" id="input_kuota" required min="0" 
                                value="<?= $kuota_detail['batas_kuota'] !== null ? esc($kuota_detail['batas_kuota']) : '' ?>"
                                placeholder="Masukkan batas kuota">
                            <div class="input-group-append">
                                <span class="input-group-text" style="border-radius: 0 8px 8px 0; background-color: #F8FAFC; border-color: #CBD5E1; color: #64748B; font-size: 0.9rem;">Mahasiswa</span>
                            </div>
                        </div>
                        <small class="form-text text-muted mt-2" style="font-size: 0.75rem;">
                            Jumlah mahasiswa magang maksimal yang diizinkan beraktivitas pada bulan ini.
                            <?php if ($kuota_detail['terpakai'] > 0): ?>
                                <br><strong style="color: #DC2626;">Minimal: <?= $kuota_detail['terpakai'] ?> (sudah terpakai)</strong>
                            <?php endif; ?>
                        </small>
                    </div>

                    <div class="row mb-4">
                        <div class="col-6">
                            <label class="form-label">Terpakai</label>
                            <input type="text" class="form-control form-control-styled" value="<?= esc($kuota_detail['terpakai']) ?>" readonly style="color: #3B82F6; font-weight: bold;">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Sisa Kuota</label>
                            <input type="text" class="form-control form-control-styled" id="input_sisa_form" 
                                value="<?= $kuota_detail['sisa_kuota'] !== null ? esc($kuota_detail['sisa_kuota']) : '-' ?>" 
                                readonly style="color: #16A34A; font-weight: bold;">
                        </div>
                    </div>

                    <hr class="mb-4" style="border-color: #E2E8F0;">

                    <button type="submit" class="btn btn-primary w-100 py-2 font-weight-bold" id="btn_simpan" style="border-radius: 8px; background-color: #1E40AF; border-color: #1E40AF;">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    const terpakai = <?= (int)$kuota_detail['terpakai'] ?>;

    // Hitung sisa kuota secara realtime
    function calculateSisa() {
        let batas = parseInt($('#input_kuota').val()) || 0;
        let sisa = Math.max(0, batas - terpakai);
        
        $('#input_sisa_form').val(sisa);
        $('#display-sisa').text(sisa);
        $('#display-batas').text(batas || '-');
        
        if (sisa > 0) {
            $('#input_sisa_form').css('color', '#16A34A');
            $('#display-sisa').css('color', '#16A34A');
        } else {
            $('#input_sisa_form').css('color', '#DC2626');
            $('#display-sisa').css('color', '#DC2626');
        }

        // Validasi: disable tombol jika kuota < terpakai
        if (batas < terpakai && $('#input_kuota').val() !== '') {
            $('#btn_simpan').prop('disabled', true);
            $('#input_kuota').css('border-color', '#DC2626');
        } else {
            $('#btn_simpan').prop('disabled', false);
            $('#input_kuota').css('border-color', '#CBD5E1');
        }
    }

    $('#input_kuota').on('input', calculateSisa);

    // Validasi saat kehilangan fokus
    $('#input_kuota').on('blur', function() {
        let batas = parseInt($(this).val()) || 0;
        if ($(this).val() !== '' && batas < terpakai) {
            Swal.fire({
                title: 'Peringatan',
                text: 'Kuota tidak dapat lebih kecil dari jumlah yang sudah terpakai (' + terpakai + ').',
                icon: 'warning',
                confirmButtonColor: '#1E40AF'
            });
            $(this).val(terpakai);
            calculateSisa();
        }
    });

    // Submit form via AJAX
    $('#formKuota').on('submit', function(e) {
        e.preventDefault();
        
        let batasBaru = parseInt($('#input_kuota').val()) || 0;
        
        if ($('#input_kuota').val() === '' || batasBaru < 0) {
            Swal.fire('Error', 'Masukkan batas kuota yang valid.', 'error');
            return;
        }

        if (batasBaru < terpakai) {
            Swal.fire('Error', 'Kuota tidak dapat lebih kecil dari jumlah yang sudah terpakai (' + terpakai + ').', 'error');
            return;
        }

        // Konfirmasi sebelum simpan
        Swal.fire({
            title: 'Simpan Kuota?',
            text: 'Batas kuota akan diatur menjadi ' + batasBaru + ' mahasiswa.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1E40AF',
            cancelButtonColor: '#64748B',
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan loading
                $('#btn_simpan').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...');

                $.ajax({
                    url: '<?= base_url("kabid/kuota/update") ?>',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    context: this,
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonColor: '#1E40AF'
                            }).then(() => {
                                // Reload halaman untuk update data
                                location.reload();
                            });
                        } else {
                            Swal.fire('Gagal!', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        let msg = 'Terjadi kesalahan sistem.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        Swal.fire('Gagal!', msg, 'error');
                    },
                    complete: function() {
                        $('#btn_simpan').prop('disabled', false).html('<i class="fas fa-save mr-2"></i> Simpan Perubahan');
                    }
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
