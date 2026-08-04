<?= $this->extend('layout/L_master_kabid') ?>

<?= $this->section('content') ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Logbook Mahasiswa</h1>
    <div class="d-flex align-items-center mt-3 mt-sm-0">
        <label for="filterJenis" class="mr-2 mb-0 font-weight-bold text-gray-600" style="font-size:0.9rem;">Filter:</label>
        <select id="filterJenis" class="form-control form-control-sm" style="width: 220px; border-radius: 8px; border-color: #cbd5e1; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <option value="">Semua Kategori</option>
            <?php if (!empty($jenis_permohonan)): ?>
                <?php foreach ($jenis_permohonan as $jp): ?>
                    <option value="<?= esc($jp->jenis_permohonan) ?>"><?= esc($jp->jenis_permohonan) ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>
</div>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error'); ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>

<style>
#tabelLogbook thead th {
    vertical-align: middle;
    font-size: 0.82rem;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    padding: 12px 14px;
    border: none;
}
#tabelLogbook tbody td {
    vertical-align: middle;
    padding: 12px 14px;
    font-size: 0.88rem;
    color: #374151;
}
#tabelLogbook tbody tr:hover {
    background-color: #f0f4ff;
}
.mhs-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: linear-gradient(135deg, #6366f1, #818cf8);
    color: #fff;
    font-weight: 700;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
/* Padding untuk kontrol DataTables (Search & Pagination) agar tidak mepet */
.dataTables_wrapper .row:first-child {
    padding: 1.25rem 1.25rem 0.5rem 1.25rem;
}
.dataTables_wrapper .row:last-child {
    padding: 0.5rem 1.25rem 1.25rem 1.25rem;
}
</style>

<div class="card shadow mb-4" style="border: none; border-radius: 12px; overflow: hidden;">

    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="tabelLogbook" class="table table-hover mb-0" width="100%" cellspacing="0">
                <thead style="background: linear-gradient(135deg, #1e3a5f 0%, #2d5a8e 100%); color: #fff;">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>Nama Mahasiswa</th>
                        <th>Instansi / Prodi</th>
                        <th>Periode Magang</th>
                        <th width="12%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($mahasiswa)): ?>
                    <tr>
                        <td colspan="5" class="text-center p-0 border-0">
                            <div style="padding: 60px 20px;">
                                <div style="
                                    width: 90px; height: 90px;
                                    background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
                                    border-radius: 50%;
                                    display: flex; align-items: center; justify-content: center;
                                    margin: 0 auto 20px auto;">
                                    <i class="fas fa-book-open" style="font-size: 2.2rem; color: #6366f1;"></i>
                                </div>
                                <h5 style="color: #374151; font-weight: 700; margin-bottom: 8px;">Belum Ada Mahasiswa Aktif</h5>
                                <p style="color: #9ca3af; font-size: 0.9rem; margin: 0;">
                                    Saat ini belum ada mahasiswa yang sedang aktif magang<br>di bidang Anda.
                                </p>
                            </div>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($mahasiswa as $mhs): ?>
                        <tr data-jenis="<?= esc($mhs->jenis_permohonan) ?>">
                            <td class="text-center text-muted" style="font-weight: 600;"><?= $no++ ?></td>

                            <!-- Kolom Nama / NIM -->
                            <td>
                                <div class="d-flex align-items-center" style="gap: 10px;">
                                    <div class="mhs-avatar">
                                        <?= mb_strtoupper(mb_substr($mhs->nama_mahasiswa, 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: #1e3a5f;"><?= esc($mhs->nama_mahasiswa) ?></div>
                                        <small class="text-muted"><?= esc($mhs->nim) ?></small>
                                    </div>
                                </div>
                            </td>

                            <!-- Kolom Instansi / Prodi -->
                            <td>
                                <div style="font-weight: 500;"><?= esc($mhs->instansi_pendidikan) ?></div>
                                <small class="text-muted"><i class="fas fa-graduation-cap mr-1"></i><?= esc($mhs->prodi) ?></small>
                                <br>
                                <span class="badge" style="background:#e0e7ff;color:#4338ca;font-size: 0.7rem; padding: 3px 8px; border-radius:6px; margin-top:4px;">
                                    <?= esc($mhs->jenis_permohonan ?? 'Magang') ?>
                                </span>
                            </td>

                            <!-- Kolom Periode + Badge Sisa Hari -->
                            <td>
                                <?php
                                    $today      = new DateTime();
                                    $tglSelesai = new DateTime($mhs->tgl_selesai);
                                    $sisaHari   = (int) $today->diff($tglSelesai)->format('%r%a');

                                    if ($sisaHari < 0) {
                                        $badgeClass = 'badge-secondary';
                                        $badgeIcon  = 'fa-check-circle';
                                        $badgeText  = 'Selesai';
                                    } elseif ($sisaHari === 0) {
                                        $badgeClass = 'badge-danger';
                                        $badgeIcon  = 'fa-exclamation-circle';
                                        $badgeText  = 'Berakhir Hari Ini';
                                    } elseif ($sisaHari <= 7) {
                                        $badgeClass = 'badge-danger';
                                        $badgeIcon  = 'fa-fire';
                                        $badgeText  = $sisaHari . ' hari lagi';
                                    } elseif ($sisaHari <= 14) {
                                        $badgeClass = 'badge-warning';
                                        $badgeIcon  = 'fa-clock';
                                        $badgeText  = $sisaHari . ' hari lagi';
                                    } else {
                                        $badgeClass = 'badge-success';
                                        $badgeIcon  = 'fa-calendar-check';
                                        $badgeText  = $sisaHari . ' hari lagi';
                                    }
                                ?>
                                <div style="font-size: 0.85rem;">
                                    <i class="fas fa-calendar-alt mr-1 text-muted"></i>
                                    <span><?= date('d M Y', strtotime($mhs->tgl_mulai)) ?></span>
                                    <span class="text-muted mx-1">s.d.</span>
                                    <span><?= date('d M Y', strtotime($mhs->tgl_selesai)) ?></span>
                                </div>
                                <span class="badge <?= $badgeClass ?> mt-1" style="font-size: 0.73rem; padding: 4px 8px; <?= $badgeClass === 'badge-warning' ? 'color:#fff;' : '' ?>">
                                    <i class="fas <?= $badgeIcon ?> mr-1"></i><?= $badgeText ?>
                                </span>
                            </td>

                            <!-- Kolom Aksi -->
                            <td class="text-center">
                                <a href="<?= base_url('kabid/logbook/detail/' . $mhs->id_penempatan_magang) ?>"
                                   class="btn btn-sm"
                                   style="background: linear-gradient(135deg, #6366f1, #818cf8); color: #fff; border: none; border-radius: 8px; padding: 6px 14px; font-weight: 600; font-size: 0.8rem;"
                                   title="Lihat & Approve Logbook">
                                    <i class="fas fa-book-open mr-1"></i> Logbook
                                </a>
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
    // Cek apakah tabel punya data (bukan empty state)
    var haData = $('#tabelLogbook tbody tr td[colspan]').length === 0 
                 && $('#tabelLogbook tbody tr').length > 0;

    if (haData) {
        // Custom DataTables filter for Kategori
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex, rowData, counter) {
                var selectedFilter = $('#filterJenis').val();
                var rowJenis = $(settings.aoData[dataIndex].nTr).attr('data-jenis');
                
                if (selectedFilter === "" || rowJenis === selectedFilter) {
                    return true;
                }
                return false;
            }
        );

        var table = $('#tabelLogbook').DataTable({
            language: {
                search:            '',
                searchPlaceholder: 'Cari mahasiswa, instansi...',
                lengthMenu:        'Tampilkan _MENU_ data',
                info:              'Menampilkan _START_–_END_ dari _TOTAL_ mahasiswa',
                infoEmpty:         'Tidak ada data',
                infoFiltered:      '(dari _MAX_ total)',
                zeroRecords:       'Tidak ada mahasiswa yang cocok dengan pencarian.',
                paginate: {
                    first:    '&laquo;',
                    last:     '&raquo;',
                    next:     '&rsaquo;',
                    previous: '&lsaquo;'
                }
            },
            columnDefs: [
                { orderable: false, targets: [0, 4] } // Kolom No & Aksi tidak sortable
            ],
            order:      [[1, 'asc']], // Default sort: Nama A–Z
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
        });

        // Event listener for filter dropdown
        $('#filterJenis').on('change', function() {
            table.draw();
        });
    }
});
</script>
<?= $this->endSection() ?>
