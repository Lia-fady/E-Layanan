<?= $this->extend('layout/L_master') ?>

<?= $this->section('title') ?>
Monitoring Kuota Bidang
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>
    .quota-card { border-radius: 12px; border: 1px solid #E2E8F0; }
    .table-quota th { background-color: #F8FAFC; color: #475569; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #E2E8F0; padding: 1rem; }
    .table-quota td { padding: 1rem; vertical-align: middle; color: #1E293B; border-bottom: 1px solid #E2E8F0; }
    
    .btn-detail {
        background-color: #F8FAFC;
        color: #0F172A;
        border: 1px solid #CBD5E1;
        border-radius: 6px;
        padding: 0.4rem 0.8rem;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s;
    }
    .btn-detail:hover {
        background-color: #1B2559;
        color: white;
        border-color: #1B2559;
    }

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

    /* Summary Card Styling */
    .summary-box {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 1.2rem;
        text-align: center;
    }
    .summary-box .title {
        font-size: 0.85rem;
        color: #64748B;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
    }
    .summary-box .value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0F172A;
    }
</style>

<!-- STATE 1: DAFTAR BIDANG -->
<div id="state-daftar">
    <div class="mb-4">
        <h5 style="font-weight:700; color:#1B2559; margin-bottom:4px;">Kuota Bidang</h5>
        <p style="color:#667085; font-size:0.9rem; margin:0;">
            Pilih bidang untuk melihat rincian kapasitas dan penggunaan kuota sepanjang tahun.
        </p>
    </div>

    <!-- Menampilkan pesan error jika ada -->
    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 8px;">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm quota-card bg-white mb-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-quota mb-0" id="tabel_bidang" width="100%">
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th width="75%">Nama Bidang</th>
                            <th width="20%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($list_bidang)): ?>
                            <?php $no=1; foreach($list_bidang as $bidang): ?>
                                <tr>
                                    <td class="text-center text-muted"><?= $no++ ?></td>
                                    <td class="font-weight-bold" style="padding-left: 1rem; color: #1E293B;"><?= esc($bidang['bidang']) ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-detail" onclick="loadDetail(<?= $bidang['id_bidang'] ?>)">
                                            <i class="fas fa-eye mr-1"></i> Detail Kuota
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted">Belum ada data bidang.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- STATE 2: DETAIL KUOTA -->
<div id="state-detail" class="d-none">
    <div class="mb-4">
        <button class="btn-back mb-3" onclick="showDaftar()">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Bidang
        </button>
        <h5 style="font-weight:700; color:#1B2559; margin-bottom:4px;" id="detail-title">Rincian Kuota Tahun - Bidang -</h5>
        <p style="color:#667085; font-size:0.9rem; margin:0;">
            Pantau kapasitas dan penggunaan kuota untuk bidang ini sepanjang tahun.
        </p>
    </div>

    <!-- Ringkasan -->
    <!-- <div class="row mb-4">
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="summary-box">
                <div class="title">Total Kuota</div>
                <div class="value" id="val-total-kuota">0</div>
            </div>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="summary-box">
                <div class="title">Total Terpakai</div>
                <div class="value text-primary" id="val-total-terpakai">0</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="summary-box">
                <div class="title">Total Sisa</div>
                <div class="value" id="val-total-sisa" style="color: #16A34A;">0</div>
            </div>
        </div>
    </div> -->
    
    <div class="card shadow-sm quota-card bg-white mb-4">
        <div class="card-body p-4">
            <div class="mb-4" style="background:#F8FAFC; padding:1.5rem; border-radius:12px; border:1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <h5 style="font-weight:700; color:#1E293B; margin-bottom:0.8rem; font-size:1.1rem; display: flex; align-items: center;">
                    <i class="fas fa-calendar-check text-primary mr-2" style="font-size: 1.2rem;"></i> Bulan Terpakai
                </h5>
                <div style="font-size:1rem; color:#334155; line-height: 1.6; font-weight: 500;" id="val-bulan-terpakai">Memuat...</div>
            </div>

            <div class="table-responsive">
                <table class="table table-quota mb-0" id="tabel_detail" width="100%">
                    <thead>
                        <tr>
                            <th width="35%">Bulan</th>
                            <th width="15%" class="text-center">Batas Kuota</th>
                            <th width="15%" class="text-center">Terpakai</th>
                            <th width="15%" class="text-center">Sisa Kuota</th>
                            <th width="20%" class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody id="body-detail">
                        <!-- Data will be populated here by JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
let dtBidang;
let dtDetail;

$(document).ready(function() {
    dtBidang = $('#tabel_bidang').DataTable({
        "pageLength": 10,
        "language": {
            "sEmptyTable":   "Tidak ada data bidang yang tersedia",
            "sInfo":         "Menampilkan _START_ sampai _END_ dari _TOTAL_ Bidang",
            "sInfoEmpty":    "Menampilkan 0 sampai 0 dari 0 Bidang",
            "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
            "sLengthMenu":   "Tampilkan _MENU_ Bidang",
            "sSearch":       "Cari Bidang:",
            "sZeroRecords":  "Tidak ditemukan data yang sesuai",
            "oPaginate": {
                "sFirst":    "Pertama",
                "sLast":     "Terakhir",
                "sNext":     ">",
                "sPrevious": "<"
            }
        },
        "ordering": false
    });
});

function loadDetail(id_bidang) {
    const btn = event.currentTarget;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Memuat...';
    btn.disabled = true;

    $.ajax({
        url: '<?= base_url('sekretariat/kuota/detail') ?>/' + id_bidang,
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            btn.innerHTML = originalText;
            btn.disabled = false;

            if (res.status === 'success') {
                // Update Title
                $('#detail-title').text('Rincian Kuota Tahun ' + res.tahun + ' Bidang ' + res.bidang.bidang);
                
                // Update Ringkasan
                $('#val-total-kuota').text(res.data.ringkasan.total_kuota);
                $('#val-total-terpakai').text(res.data.ringkasan.total_terpakai);
                $('#val-total-sisa').text(res.data.ringkasan.total_sisa);
                if (res.data.ringkasan.total_sisa > 0) {
                    $('#val-total-sisa').css('color', '#16A34A');
                } else {
                    $('#val-total-sisa').css('color', '#DC2626');
                }
                $('#val-bulan-terpakai').html(res.data.ringkasan.bulan_terpakai);

                // Destroy old datatable if exists
                if ($.fn.DataTable.isDataTable('#tabel_detail')) {
                    $('#tabel_detail').DataTable().destroy();
                }

                // Populate Table
                let html = '';
                if (res.data.kuota_bulan && res.data.kuota_bulan.length > 0) {
                    res.data.kuota_bulan.forEach(function(item) {
                        let colorSisa = item.sisa_kuota > 0 ? '#16A34A' : '#DC2626';
                        let badgeHtml = item.status === 'Tersedia' 
                            ? '<span class="badge badge-status badge-tersedia">Tersedia</span>'
                            : '<span class="badge badge-status badge-penuh">Penuh</span>';

                        html += `<tr>
                            <td class="font-weight-bold" style="padding-left: 1rem; color: #1E293B;">${item.bulan_nama}</td>
                            <td class="text-center text-muted">${item.batas_kuota}</td>
                            <td class="text-center font-weight-bold text-primary">${item.terpakai}</td>
                            <td class="text-center font-weight-bold" style="color: ${colorSisa};">${item.sisa_kuota}</td>
                            <td class="text-center">${badgeHtml}</td>
                        </tr>`;
                    });
                } else {
                    html = '<tr><td colspan="5" class="text-center text-muted">Data bulan tidak tersedia.</td></tr>';
                }
                
                $('#body-detail').html(html);

                // Initialize DataTable for Detail
                dtDetail = $('#tabel_detail').DataTable({
                    "pageLength": 6, // 6 items per page exactly divides 12 months into 2 pages
                    "lengthChange": false, 
                    "searching": false, 
                    "ordering": false, 
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

                // Switch State
                $('#state-daftar').addClass('d-none');
                $('#state-detail').removeClass('d-none');
            } else {
                alert('Gagal mengambil data detail: ' + (res.message || 'Unknown error'));
            }
        },
        error: function() {
            btn.innerHTML = originalText;
            btn.disabled = false;
            alert('Terjadi kesalahan jaringan atau server.');
        }
    });
}

function showDaftar() {
    $('#state-detail').addClass('d-none');
    $('#state-daftar').removeClass('d-none');
}
</script>
<?= $this->endSection() ?>
