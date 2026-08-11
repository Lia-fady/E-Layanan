<?= $this->extend('layout/L_master') ?>

<?= $this->section('title') ?>
Daftar Bidang
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
</style>

<div class="mb-4">
    <h5 style="font-weight:700; color:#1B2559; margin-bottom:4px;">Kuota refa hama</h5>
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
                                    <a href="<?= base_url('sekretariat/kuota/detail/'.$bidang['id_bidang']) ?>" class="btn btn-detail">
                                        <i class="fas fa-eye mr-1"></i> Detail Kuota
                                    </a>
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

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('#tabel_bidang').DataTable({
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
</script>
<?= $this->endSection() ?>
