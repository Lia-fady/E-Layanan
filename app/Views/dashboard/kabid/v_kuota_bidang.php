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
    
    .row-clickable { cursor: pointer; transition: background-color 0.2s ease; }
    .row-clickable:hover { background-color: #F1F5F9; }
    .row-clickable.active-row { background-color: #E0F2FE; border-left: 4px solid #0284C7; }
    
    .panel-title { font-weight: 700; color: #1E293B; font-size: 1.1rem; }
    .form-label { font-weight: 600; color: #475569; font-size: 0.85rem; margin-bottom: 0.4rem; }
    .form-control-styled { border-radius: 8px; border: 1px solid #CBD5E1; padding: 0.6rem 1rem; font-size: 0.95rem; }
    .form-control-styled:focus { border-color: #3B82F6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
    .form-control-styled[readonly] { background-color: #F8FAFC; color: #64748B; border-color: #E2E8F0; }
</style>

<div class="mb-4">
    <h5 style="font-weight:700; color:#1B2559; margin-bottom:4px;">Kuota Bidang</h5>
    <p style="color:#667085; font-size:0.9rem; margin:0;">
        Atur dan kelola batas maksimal mahasiswa yang dapat diterima di bidang Anda.
    </p>
</div>

<div class="row">
    <!-- Panel Pengaturan Kuota Bulanan (KIRI) -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow-sm quota-card bg-white h-100">
            <div class="card-body p-4">
                <h6 class="panel-title mb-4">Pengaturan Kuota Bulanan</h6>
                
                <form id="formUpdateKuota">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_kuota" id="input_id_kuota">
                    
                    <div class="form-group mb-3">
                        <label class="form-label">Nama Bidang</label>
                        <input type="text" class="form-control form-control-styled" value="<?= esc($nama_bidang ?? 'Bidang Anda') ?>" readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Bulan yang Dipilih</label>
                        <input type="text" class="form-control form-control-styled" id="input_bulan" value="-" readonly style="font-weight: bold; color: #0F172A;">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Batas Maksimal Kuota (Per Bulan)</label>
                        <div class="input-group">
                            <input type="number" class="form-control form-control-styled" name="kuota" id="input_kuota" required min="0">
                            <div class="input-group-append">
                                <span class="input-group-text" style="border-radius: 0 8px 8px 0; background-color: #F8FAFC; border-color: #CBD5E1; color: #64748B; font-size: 0.9rem;">Mahasiswa</span>
                            </div>
                        </div>
                        <small class="form-text text-muted mt-2" style="font-size: 0.75rem;">
                            Jumlah mahasiswa magang maksimal yang diizinkan beraktivitas pada setiap bulan.
                        </small>
                    </div>

                    <div class="row mb-4">
                        <div class="col-6">
                            <label class="form-label">Terpakai</label>
                            <input type="text" class="form-control form-control-styled" id="input_terpakai" value="0" readonly style="color: #3B82F6; font-weight: bold;">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Sisa Kuota</label>
                            <input type="text" class="form-control form-control-styled" id="input_sisa" value="0" readonly style="color: #16A34A; font-weight: bold;">
                        </div>
                    </div>

                    <hr class="mb-4" style="border-color: #E2E8F0;">

                    <button type="submit" class="btn btn-primary w-100 py-2 font-weight-bold" id="btn_simpan" style="border-radius: 8px; background-color: #1E40AF; border-color: #1E40AF;" disabled>
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Rincian Kuota (KANAN) -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow-sm quota-card bg-white h-100">
            <div class="card-header bg-white" style="border-bottom: 1px solid #E2E8F0; padding: 1.25rem 1.5rem;">
                <h6 class="panel-title m-0">Rincian Kuota Tahun <?= esc($tahun) ?></h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-quota mb-0" id="tabel_kuota">
                        <thead>
                            <tr>
                                <th width="20%">Bulan</th>
                                <th width="20%" class="text-center">Batas Kuota</th>
                                <th width="20%" class="text-center">Terpakai</th>
                                <th width="20%" class="text-center">Sisa Kuota</th>
                                <th width="20%" class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($list_kuota)): ?>
                                <?php foreach ($list_kuota as $k): ?>
                                    <tr class="row-clickable" 
                                        data-id="<?= $k['id_kuota'] ?>"
                                        data-bulan="<?= esc($k['bulan_nama']) ?>"
                                        data-bulan-angka="<?= $k['bulan_angka'] ?>"
                                        data-batas="<?= $k['batas_kuota'] ?>"
                                        data-terpakai="<?= $k['terpakai'] ?>"
                                        data-sisa="<?= $k['sisa_kuota'] ?>">
                                        
                                        <td class="font-weight-bold" style="padding-left: 1.5rem;"><?= esc($k['bulan_nama']) ?></td>
                                        <td class="text-center cell-batas">
                                            <span style="font-size: 1.05rem; color: #475569;"><?= esc($k['batas_kuota']) ?></span>
                                        </td>
                                        <td class="text-center cell-terpakai">
                                            <span style="font-size: 1.05rem; font-weight: 700; color: #3B82F6;"><?= esc($k['terpakai']) ?></span>
                                        </td>
                                        <td class="text-center cell-sisa">
                                            <span style="font-size: 1.05rem; font-weight: 700; color: <?= $k['sisa_kuota'] > 0 ? '#16A34A' : '#DC2626' ?>;"><?= esc($k['sisa_kuota']) ?></span>
                                        </td>
                                        <td class="text-center cell-status">
                                            <?php if ($k['status'] === 'Tersedia'): ?>
                                                <span class="badge badge-status badge-tersedia">Tersedia</span>
                                            <?php else: ?>
                                                <span class="badge badge-status badge-penuh">Penuh</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Data kuota belum tersedia.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- Menggunakan SweetAlert2 dari CDN jika belum ada -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    let currentTerpakai = 0;

    // Initialize DataTables for 6 months per page
    let table = $('#tabel_kuota').DataTable({
        "pageLength": 6,
        "lengthChange": false,
        "searching": false,
        "info": true,
        "language": {
            "sInfo":         "Menampilkan _START_ sampai _END_ dari _TOTAL_ Bulan",
            "sInfoEmpty":    "Menampilkan 0 sampai 0 dari 0 Bulan",
            "oPaginate": {
                "sNext":     "<i class='fas fa-chevron-right'></i>",
                "sPrevious": "<i class='fas fa-chevron-left'></i>"
            }
        },
        "ordering": false
    });

    // Fungsi untuk menghitung sisa kuota secara realtime
    function calculateSisa() {
        let batas = parseInt($('#input_kuota').val()) || 0;
        let sisa = Math.max(0, batas - currentTerpakai);
        
        $('#input_sisa').val(sisa);
        
        if (sisa > 0) {
            $('#input_sisa').css('color', '#16A34A');
        } else {
            $('#input_sisa').css('color', '#DC2626');
        }

        // Validasi frontend: disable tombol simpan jika invalid
        if (batas < currentTerpakai) {
            $('#btn_simpan').prop('disabled', true);
            // Opsional: tambahkan styling error
            $('#input_kuota').css('border-color', '#DC2626');
        } else {
            $('#btn_simpan').prop('disabled', false);
            $('#input_kuota').css('border-color', '#CBD5E1');
        }
    }

    // Klik pada baris tabel (gunakan event delegation karena DataTables)
    $('#tabel_kuota tbody').on('click', '.row-clickable', function() {
        // Hapus kelas aktif dari semua baris di semua page (menggunakan API DataTables)
        $(table.rows().nodes()).removeClass('active-row');
        
        // Tambahkan kelas aktif ke baris yang diklik
        $(this).addClass('active-row');

        // Ambil data dari atribut baris
        let id = $(this).data('id');
        let bulan = $(this).data('bulan');
        let batas = parseInt($(this).data('batas'));
        currentTerpakai = parseInt($(this).data('terpakai'));
        let sisa = parseInt($(this).data('sisa'));

        // Isi panel kiri
        $('#input_id_kuota').val(id);
        $('#input_bulan').val(bulan);
        $('#input_kuota').val(batas).attr('min', currentTerpakai);
        $('#input_terpakai').val(currentTerpakai);
        $('#input_sisa').val(sisa);

        // Aktifkan tombol simpan & reset error state
        $('#btn_simpan').prop('disabled', false);
        $('#input_kuota').css('border-color', '#CBD5E1');
        
        calculateSisa();
    });

    // Realtime calculation saat input batas berubah
    $('#input_kuota').on('input', function() {
        calculateSisa();
    });

    // Validasi tambahan saat input kehilangan fokus
    $('#input_kuota').on('blur', function() {
        let batas = parseInt($(this).val()) || 0;
        if (batas < currentTerpakai) {
            Swal.fire({
                title: 'Peringatan',
                text: 'Kuota tidak boleh lebih kecil dari jumlah mahasiswa yang sudah terpakai (' + currentTerpakai + ').',
                icon: 'warning',
                confirmButtonColor: '#1E40AF'
            });
            $(this).val(currentTerpakai);
            calculateSisa();
        }
    });

    // Handle form submit via AJAX
    $('#formUpdateKuota').on('submit', function(e) {
        e.preventDefault();
        
        let batasBaru = parseInt($('#input_kuota').val()) || 0;
        
        if (batasBaru < currentTerpakai) {
            Swal.fire('Error', 'Data tidak valid.', 'error');
            return;
        }

        // Tampilkan loading
        $('#btn_simpan').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...');

        $.ajax({
            url: $(this).attr('action') || '<?= base_url("kabid/kuota/update") ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Temukan row aktif di semua halaman
                    let activeNodes = $(table.rows().nodes()).filter('.active-row');
                    if(activeNodes.length > 0) {
                        let activeRow = $(activeNodes[0]);
                        
                        activeRow.data('batas', response.data.kuota);
                        activeRow.data('sisa', response.data.sisa);

                        // Update UI tabel menggunakan jQuery di node asli (DataTables akan menyimpan HTML ini di cellnya jika tidak menggunakan fitur invalidation, tapi lebih baik menggunakan cell data)
                        // Karena kita tidak menggunakan source array data, mengubah innerHTML node sudah cukup jika tidak sorting ulang.
                        activeRow.find('.cell-batas span').text(response.data.kuota);
                        
                        let sisaColor = response.data.sisa > 0 ? '#16A34A' : '#DC2626';
                        activeRow.find('.cell-sisa span').text(response.data.sisa).css('color', sisaColor);
                        
                        if (response.data.sisa > 0) {
                            activeRow.find('.cell-status').html('<span class="badge badge-status badge-tersedia">Tersedia</span>');
                        } else {
                            activeRow.find('.cell-status').html('<span class="badge badge-status badge-penuh">Penuh</span>');
                        }
                    }

                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonColor: '#1E40AF'
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
                // Kembalikan state tombol
                $('#btn_simpan').prop('disabled', false).html('<i class="fas fa-save mr-2"></i> Simpan Perubahan');
            }
        });
    });

    // Default selection: Pilih bulan berjalan
    let currentMonth = new Date().getMonth() + 1; // 1-12
    let allNodes = $(table.rows().nodes());
    let targetRow = allNodes.filter('[data-bulan-angka="' + currentMonth + '"]');
    
    // Jika tidak ditemukan, pilih baris pertama
    if (targetRow.length === 0) {
        targetRow = allNodes.first();
    }
    
    // Trigger klik pada baris default
    if (targetRow.length > 0) {
        // Cari index row untuk pagination jika diperlukan
        let rowIndex = table.row(targetRow[0]).index();
        let pageInfo = table.page.info();
        let targetPage = Math.floor(rowIndex / pageInfo.length);
        
        // Pindah page jika belum di page yg benar
        if (targetPage !== pageInfo.page) {
            table.page(targetPage).draw('page');
        }
        
        // Menggunakan native click agar tertangkap event delegation DOM jQuery 
        $(targetRow[0]).trigger('click');
    }
});
</script>
<?= $this->endSection() ?>
