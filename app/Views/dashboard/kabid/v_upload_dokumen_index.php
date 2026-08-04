<?php
/**
 * View untuk Index Upload Surat Penerimaan Magang (Kabid)
 */
?>
<?= $this->extend('layout/L_master_kabid') ?>

<?= $this->section('title') ?>
<?= esc($title) ?>
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

<style>
#dataTable thead th {
    vertical-align: middle;
    font-size: 0.82rem;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    padding: 12px 14px;
    border: none;
}
#dataTable tbody td {
    vertical-align: middle;
    padding: 12px 14px;
    font-size: 0.88rem;
    color: #374151;
}
#dataTable tbody tr:hover {
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
    <div class="card-header py-3 d-flex align-items-center justify-content-between" style="background: #fff; border-bottom: 2px solid #e5e7eb;">
        <div>
            <h6 class="m-0 font-weight-bold" style="color: #1e3a5f;">
                <i class="fas fa-file-upload mr-2" style="color: #6366f1;"></i>Daftar Dokumen Magang
            </h6>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="dataTable" width="100%" cellspacing="0">
                <thead style="background: linear-gradient(135deg, #1e3a5f 0%, #2d5a8e 100%); color: #fff;">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>Nama Mahasiswa</th>
                        <th>Asal Kampus / Prodi</th>
                        <th>Periode Magang</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($persetujuan)) : ?>
                        <?php $no = 1; foreach ($persetujuan as $p) : ?>
                        <tr>
                            <td class="text-center text-muted" style="font-weight: 600;"><?= $no++ ?></td>
                            
                            <!-- Kolom Nama / NIM -->
                            <td>
                                <div class="d-flex align-items-center" style="gap: 10px;">
                                    <div class="mhs-avatar">
                                        <?= mb_strtoupper(mb_substr($p->nama_mahasiswa ?? 'A', 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: #1e3a5f;"><?= esc($p->nama_mahasiswa ?? '-') ?></div>
                                        <small class="text-muted"><?= esc($p->nim ?? '-') ?></small>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Kolom Instansi / Prodi -->
                            <td>
                                <div style="font-weight: 500;"><?= esc($p->instansi_pendidikan ?? '-') ?></div>
                                <small class="text-muted"><i class="fas fa-graduation-cap mr-1"></i><?= esc($p->prodi ?? '-') ?></small>
                            </td>
                            
                            <!-- Kolom Periode -->
                            <td>
                                <?php
                                    $mulai = !empty($p->tgl_mulai) ? date('d M Y', strtotime($p->tgl_mulai)) : '-';
                                    $selesai = !empty($p->tgl_selesai) ? date('d M Y', strtotime($p->tgl_selesai)) : '-';
                                ?>
                                <div style="font-size: 0.85rem;">
                                    <i class="fas fa-calendar-alt mr-1 text-muted"></i>
                                    <span><?= $mulai ?></span>
                                    <span class="text-muted mx-1">s.d.</span>
                                    <span><?= $selesai ?></span>
                                </div>
                            </td>
                            
                            <!-- Kolom Aksi -->
                            <td class="text-center">
                                <a href="<?= base_url('kabid/upload-dokumen/form/' . $p->id_persetujuan_magang) ?>" 
                                   class="btn btn-sm"
                                   style="background: linear-gradient(135deg, #6366f1, #818cf8); color: #fff; border: none; border-radius: 8px; padding: 6px 14px; font-weight: 600; font-size: 0.8rem;"
                                   title="Kelola Dokumen">
                                    <i class="fas fa-upload mr-1"></i> Kelola
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center p-0 border-0">
                                <div style="padding: 60px 20px;">
                                    <div style="
                                        width: 90px; height: 90px;
                                        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
                                        border-radius: 50%;
                                        display: flex; align-items: center; justify-content: center;
                                        margin: 0 auto 20px auto;">
                                        <i class="fas fa-folder-open" style="font-size: 2.2rem; color: #6366f1;"></i>
                                    </div>
                                    <h5 style="color: #374151; font-weight: 700; margin-bottom: 8px;">Tidak Ada Data Permohonan</h5>
                                    <p style="color: #9ca3af; font-size: 0.9rem; margin: 0;">
                                        Belum ada permohonan magang yang disetujui<br>untuk dikelola dokumennya.
                                    </p>
                                </div>
                            </td>
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
    var haData = $('#dataTable tbody tr td[colspan]').length === 0 
                 && $('#dataTable tbody tr').length > 0;

    if (haData) {
        $('#dataTable').DataTable({
            language: {
                search:            '',
                searchPlaceholder: 'Cari mahasiswa, instansi...',
                lengthMenu:        'Tampilkan _MENU_ data',
                info:              'Menampilkan _START_–_END_ dari _TOTAL_ data',
                infoEmpty:         'Tidak ada data',
                infoFiltered:      '(dari _MAX_ total)',
                zeroRecords:       'Tidak ada data yang cocok.',
                paginate: {
                    first:    '&laquo;',
                    last:     '&raquo;',
                    next:     '&rsaquo;',
                    previous: '&lsaquo;'
                }
            },
            columnDefs: [
                { orderable: false, targets: [0, 4] }
            ],
            order:      [[1, 'asc']],
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
        });
    }
});
</script>
<?= $this->endSection() ?>
