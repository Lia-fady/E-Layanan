<?php
/**
 * ============================================================
 * Kode      : v_riwayat.php
 * Path      : Views/dashboard/sekretariat/v_riwayat.php
 * Deskripsi : View halaman riwayat semua permohonan.
 *             Menampilkan tabel dengan header navy blue,
 *             search, filter, pagination, serta aksi
 *             detail permohonan dan hapus.
 * ============================================================
 */
?>

<?= $this->extend('layout/L_master') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')) : ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle mr-2"></i>
    <?= session()->getFlashdata('success') ?>
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')) : ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle mr-2"></i>
    <?= session()->getFlashdata('error') ?>
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
<?php endif; ?>

<!-- Page Description -->
<div class="mb-4">
    <h5 style="font-weight:700; color:#1B2559; margin-bottom:4px;">Riwayat</h5>
    <p style="color:#667085; font-size:0.9rem; margin:0;">
        Lihat riwayat permohonan magang yang telah selesai diproses.
    </p>
</div>

<!-- Search & Filter -->
<div class="verifikasi-search-bar">
    <div style="position:relative; flex:1; max-width:450px;">
        <i class="fas fa-search" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#98a2b3;"></i>
        <input type="text" id="searchRiwayat" placeholder="Cari nama/ universitas..." style="width:100%;">
    </div>
    <select id="filterRiwayat">
        <option value="">Filter</option>
        <option value="MENUNGGU_PENEMPATAN">Menunggu Penempatan</option>
        <option value="MENUNGGU_BIDANG">Menunggu Persetujuan Bidang</option>
        <option value="SUDAH_DITEMPATKAN">Sudah Ditempatkan</option>
        <option value="PERBAIKAN_BERKAS">Perbaikan Berkas</option>
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
                <th>Instansi</th>
                <th>Jenis</th>
                <th>Tanggal Pengajuan</th>
                <th class="text-center">Status</th>
                <th width="14%" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($permohonan)) : ?>
                <?php $no = 1; foreach ($permohonan as $row) : ?>
                <?php
                    // Tentukan status berdasarkan persetujuan, disposisi & penempatan
                    $status = $row->status_persetujuan ?? 'MENUNGGU';
                    $disposisi = $row->disposisi ?? '0';
                    $status_penempatan = $row->status_penempatan ?? null;

                    if ($status == 'DISETUJUI') {
                        if ($status_penempatan == 'BERJALAN') {
                            $badgeClass = 'sudah-ditempatkan';
                            $statusText = 'Sudah Ditempatkan';
                            $filterValue = 'SUDAH_DITEMPATKAN';
                        } elseif ($status_penempatan == 'SELESAI') {
                            $badgeClass = 'sudah-ditempatkan';
                            $statusText = 'Selesai';
                            $filterValue = 'SUDAH_DITEMPATKAN';
                        } elseif ($status_penempatan == 'MENUNGGU') {
                            $badgeClass = 'menunggu-penempatan';
                            $statusText = 'Menunggu Bidang';
                            $filterValue = 'MENUNGGU_BIDANG';
                        } else {
                            $badgeClass = 'menunggu-penempatan';
                            $statusText = 'Menunggu Penempatan';
                            $filterValue = 'MENUNGGU_PENEMPATAN';
                        }
                    } elseif ($status == 'PERBAIKAN_BERKAS') {
                        $badgeClass = 'sedang-diproses'; // Orange/kuning
                        $statusText = 'Perbaikan Berkas';
                        $filterValue = 'PERBAIKAN_BERKAS';
                    } elseif ($status == 'DITOLAK') {
                        $badgeClass = 'ditolak';
                        $statusText = 'Ditolak';
                        $filterValue = 'DITOLAK';
                    } else {
                        $badgeClass = 'menunggu-verifikasi';
                        $statusText = 'Menunggu';
                        $filterValue = 'MENUNGGU';
                    }
                ?>
                <tr data-filter-status="<?= $filterValue ?>">
                    <td class="text-center"><?= $no++ ?></td>
                    <td><strong><?= esc($row->nama_mahasiswa ?? '-') ?></strong></td>
                    <td><?= esc($row->instansi_pendidikan ?? '-') ?></td>
                    <td><?= esc($row->jenis_permohonan ?? '-') ?></td>
                    <td><?= tgl_indo($row->tgl_pengajuan) ?></td>
                    <td class="text-center">
                        <span class="status-badge <?= $badgeClass ?>"><?= $statusText ?></span>
                        <?php if (!empty($row->bidang)) : ?>
                            <div style="font-size:0.7rem; color:#667085; margin-top:3px;">
                                <i class="fas fa-building" style="font-size:0.6rem;"></i> <?= esc($row->bidang) ?>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center" style="gap:4px;">
                            <!-- Detail Permohonan (VIEW ONLY) -->
                            <a href="<?= base_url('sekretariat/verifikasi/detail/' . $row->id_permohonan_magang) ?>"
                               class="riwayat-action-btn" title="Detail Permohonan"
                               style="display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px;">
                                <i class="fas fa-eye"></i>
                            </a>

                            <!-- Hapus Data Riwayat Permohonan -->
                            <button type="button"
                                    class="riwayat-action-btn btn-delete-riwayat"
                                    title="Hapus Data Riwayat Permohonan"
                                    style="display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; background:#FEF2F2; color:#DC2626; border-radius:6px; text-decoration:none; border:none; cursor:pointer;"
                                    data-id-permohonan="<?= $row->id_permohonan_magang ?>"
                                    data-nama="<?= esc($row->nama_mahasiswa ?? '-') ?>">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
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
            "decimal": "",
            "emptyTable": "Tidak ada data yang tersedia",
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
            "infoFiltered": "(disaring dari _MAX_ total entri)",
            "lengthMenu": "Tampilkan _MENU_ entri",
            "loadingRecords": "Memuat...",
            "processing": "Memproses...",
            "search": "Cari:",
            "zeroRecords": "Tidak ditemukan data yang cocok",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Selanjutnya",
                "previous": "Sebelumnya"
            },
            "aria": {
                "sortAscending": ": aktifkan untuk mengurutkan kolom secara ascending",
                "sortDescending": ": aktifkan untuk mengurutkan kolom secara descending"
            }
        },
        "order": [[4, "desc"]],
        "pageLength": 10,
        "dom": '<"d-flex justify-content-between align-items-center mb-3"<""l><""f>>rt<"d-flex justify-content-between align-items-center mt-3"<""i><""p>>'
    });

    // Custom search
    $('#searchRiwayat').on('keyup', function() {
        table.search(this.value).draw();
    });

    // Custom filter berdasarkan data-attribute
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        var filterVal = $('#filterRiwayat').val();
        if (!filterVal) return true;
        var row = table.row(dataIndex).node();
        var rowStatus = $(row).data('filter-status');
        return rowStatus === filterVal;
    });

    $('#filterRiwayat').on('change', function() {
        table.draw();
    });

    // Hide default search
    $('#tabelRiwayat_filter').hide();

    // Delete Riwayat Action dengan SweetAlert2
    $(document).on('click', '.btn-delete-riwayat', function() {
        var id = $(this).data('id-permohonan');
        var nama = $(this).data('nama');
        
        Swal.fire({
            title: 'Hapus Data Riwayat Permohonan?',
            html: "Seluruh data riwayat permohonan atas nama <strong>" + nama + "</strong> akan dihapus permanen beserta seluruh data terkait (berkas, log, persetujuan, penempatan).<br><br><strong>Data ini tidak bisa dikembalikan!</strong>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DC2626',
            cancelButtonColor: '#6B7280',
            confirmButtonText: '<i class="fas fa-trash-alt mr-1"></i> Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('sekretariat/riwayat/delete') ?>',
                    type: 'POST',
                    data: {
                        'id_permohonan_magang': id,
                        '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('Gagal!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan sistem saat menghapus data.', 'error');
                    }
                });
            }
        });
    });
});
</script>

<?php if (session()->getFlashdata('success')) : ?>
<script>
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: '<?= session()->getFlashdata('success') ?>', timer: 3000 });
</script>
<?php endif; ?>
<?= $this->endSection() ?>
