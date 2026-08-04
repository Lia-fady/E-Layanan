<?= $this->extend('layout/V_Master_Bidang') ?>

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

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 style="font-weight:700; color:#1B2559; margin-bottom:4px;">Disposisi Masuk</h5>
        <p style="color:#667085; font-size:0.85rem; margin:0;">
            Pantau dan kelola seluruh permohonan mahasiswa yang didisposisikan ke bidang Anda.
        </p>
    </div>
</div>

<div class="card shadow-sm mb-4 rounded-lg" style="border: 1px solid #E2E8F0;">
    <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between" style="border-bottom: 1px solid #E2E8F0;">
        <h6 class="m-0 font-weight-bold" style="color: #1B2559; font-size: 1.1rem;">Daftar Permohonan Masuk</h6>
        <div class="d-flex align-items-center">
            <div class="input-group input-group-sm mr-2" style="width: 250px;">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white border-right-0"><i class="fas fa-search text-muted"></i></span>
                </div>
                <input type="text" class="form-control border-left-0" placeholder="Cari nama atau instansi..." id="searchTable">
            </div>
            
            <div class="dropdown">
                <button class="btn btn-sm btn-light border dropdown-toggle" type="button" id="filterStatus" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-filter text-muted"></i> 
                    <?php 
                        $sf = $status_filter ?? 'all';
                        if($sf == 'MENUNGGU') echo 'Menunggu';
                        elseif($sf == 'BERJALAN') echo 'Berjalan';
                        elseif($sf == 'SELESAI') echo 'Selesai';
                        elseif($sf == 'DIBATALKAN') echo 'Dibatalkan';
                        else echo 'Semua Status';
                    ?>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="filterStatus">
                    <a class="dropdown-item <?= $sf == 'all' ? 'active' : '' ?>" href="<?= base_url('kabid/disposisi?status=all') ?>">Semua Status</a>
                    <a class="dropdown-item <?= $sf == 'MENUNGGU' ? 'active' : '' ?>" href="<?= base_url('kabid/disposisi?status=MENUNGGU') ?>">Menunggu Persetujuan</a>
                    <a class="dropdown-item <?= $sf == 'BERJALAN' ? 'active' : '' ?>" href="<?= base_url('kabid/disposisi?status=BERJALAN') ?>">Sedang Berjalan</a>
                    <a class="dropdown-item <?= $sf == 'SELESAI' ? 'active' : '' ?>" href="<?= base_url('kabid/disposisi?status=SELESAI') ?>">Selesai</a>
                    <a class="dropdown-item <?= $sf == 'DIBATALKAN' ? 'active' : '' ?>" href="<?= base_url('kabid/disposisi?status=DIBATALKAN') ?>">Dibatalkan</a>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="dataTableCustom" width="100%" cellspacing="0" style="border-collapse: collapse;">
                <thead style="background-color: #F8FAFC; border-top: 1px solid #E2E8F0; border-bottom: 1px solid #E2E8F0;">
                    <tr>
                        <th class="text-uppercase border-0" style="font-size: 0.8rem; font-weight: 700; color: #475569; padding: 1rem 1.5rem;">NAMA PEMOHON</th>
                        <th class="text-uppercase border-0" style="font-size: 0.8rem; font-weight: 700; color: #475569; padding: 1rem;">INSTANSI</th>
                        <th class="text-uppercase border-0" style="font-size: 0.8rem; font-weight: 700; color: #475569; padding: 1rem;">JENIS</th>
                        <th class="text-uppercase border-0" style="font-size: 0.8rem; font-weight: 700; color: #475569; padding: 1rem;">STATUS</th>
                        <th class="text-uppercase text-center border-0" style="font-size: 0.8rem; font-weight: 700; color: #475569; padding: 1rem;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($penempatan)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Belum ada data disposisi.</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($penempatan as $row): 
                            // Extract initials
                            $nameParts = explode(' ', trim($row->nama_mahasiswa));
                            $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
                            
                            // Determine color based on status
                            $statusColor = '';
                            $bgColor = '';
                            if ($row->status_penempatan == 'MENUNGGU') {
                                $statusColor = '#2563EB'; // Blue
                                $bgColor = '#DBEAFE';
                            } elseif ($row->status_penempatan == 'BERJALAN') {
                                $statusColor = '#9333EA'; // Purple
                                $bgColor = '#F3E8FF';
                            } elseif ($row->status_penempatan == 'SELESAI') {
                                $statusColor = '#16A34A'; // Green
                                $bgColor = '#DCFCE7';
                            } elseif ($row->status_penempatan == 'DIBATALKAN') {
                                $statusColor = '#DC2626'; // Red
                                $bgColor = '#FEE2E2';
                            } else {
                                $statusColor = '#475569';
                                $bgColor = '#F1F5F9';
                            }
                        ?>
                        <tr style="border-bottom: 1px solid #E2E8F0;">
                            <td style="padding: 1rem 1.5rem; border-top: none;">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" 
                                         style="width: 38px; height: 38px; background-color: <?= $bgColor ?>; color: <?= $statusColor ?>; font-weight: 600; font-size: 0.9rem;">
                                        <?= $initials ?>
                                    </div>
                                    <span style="font-weight: 500; color: #1E293B; font-size: 0.95rem;"><?= esc($row->nama_mahasiswa) ?></span>
                                </div>
                            </td>
                            <td style="padding: 1rem; color: #475569; font-size: 0.95rem; border-top: none;">
                                <?= esc($row->instansi_pendidikan ?? '-') ?>
                            </td>
                            <td style="padding: 1rem; border-top: none;">
                                <span class="badge" style="background-color: #E2E8F0; color: #475569; font-weight: 500; padding: 0.4rem 0.6rem; border-radius: 4px;">
                                    <?= esc($row->jenis_permohonan ?? '-') ?>
                                </span>
                            </td>
                            <td style="padding: 1rem; font-size: 0.95rem; font-weight: 500; color: #1E293B; border-top: none;">
                                <?= ucfirst(strtolower($row->status_penempatan)) ?>
                            </td>
                            <td class="text-center" style="padding: 1rem; border-top: none;">
                                <div class="d-flex justify-content-center align-items-center" style="gap: 8px;">
                                    <button type="button" class="btn btn-link btn-sm btn-detail" 
                                        style="color: #2563EB; font-weight: 500; text-decoration: none; padding: 0;"
                                        data-id="<?= $row->id_penempatan_magang ?>"
                                        data-mhs="<?= htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') ?>">
                                        <i class="far fa-eye mr-1"></i> Detail
                                    </button>
                                    <button type="button" class="btn btn-link btn-sm"
                                        style="color: #0369A1; font-weight: 500; text-decoration: none; padding: 0;"
                                        onclick="showLogRiwayatKabid(<?= $row->id_permohonan_magang ?>)"
                                        title="Lacak Jejak (Log Riwayat)">
                                        <i class="fas fa-history"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Modal Detail & Aksi -->
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content" style="border: none; border-radius: 14px; overflow: hidden; box-shadow: 0 8px 32px rgba(15,23,42,0.12);">

            <!-- Header -->
            <div class="modal-header" style="background: #fff; border-bottom: 1px solid #e2e8f0; padding: 1.25rem 1.75rem;">
                <h6 class="modal-title font-weight-bold mb-0" id="modalDetailLabel" style="color: #0f172a; font-size: 1.05rem;">Detail Permohonan</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 1.3rem; color: #94a3b8; text-shadow: none; opacity: 1;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body p-0" style="background: #fff;">
                <div style="padding: 1.75rem;">

                    <!-- Profil Mahasiswa -->
                    <div class="d-flex align-items-start mb-4">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 44px; height: 44px; min-width: 44px; background: #eef2ff; color: #4f46e5; font-weight: 700; font-size: 0.95rem;" id="det_avatar">-</div>
                        <div>
                            <h6 class="mb-0 font-weight-bold" id="det_nama" style="color: #1e293b; font-size: 1.05rem;">-</h6>
                            <small class="text-muted" id="det_nim" style="font-size: 0.82rem;">-</small>
                        </div>
                    </div>

                    <!-- Data Pribadi & Akademik -->
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <p class="text-uppercase font-weight-bold mb-2" style="font-size: 0.7rem; color: #94a3b8; letter-spacing: 0.8px;">Data Pribadi</p>
                            <table class="table table-sm table-borderless mb-0" style="font-size: 0.88rem;">
                                <tr><td class="text-muted py-1 pr-2" style="width: 100px;">NIK</td><td class="py-1" id="det_nik">-</td></tr>
                                <tr><td class="text-muted py-1 pr-2">Jenis Kelamin</td><td class="py-1" id="det_jk">-</td></tr>
                                <tr><td class="text-muted py-1 pr-2">Telepon</td><td class="py-1" id="det_telp">-</td></tr>
                                <tr><td class="text-muted py-1 pr-2">Email</td><td class="py-1" id="det_email">-</td></tr>
                            </table>
                        </div>
                        <div class="col-md-6 mb-4">
                            <p class="text-uppercase font-weight-bold mb-2" style="font-size: 0.7rem; color: #94a3b8; letter-spacing: 0.8px;">Informasi Akademik</p>
                            <table class="table table-sm table-borderless mb-0" style="font-size: 0.88rem;">
                                <tr><td class="text-muted py-1 pr-2" style="width: 100px;">Instansi</td><td class="py-1" id="det_instansi">-</td></tr>
                                <tr><td class="text-muted py-1 pr-2">Prodi</td><td class="py-1" id="det_prodi">-</td></tr>
                                <tr><td class="text-muted py-1 pr-2">Semester</td><td class="py-1" id="det_semester">-</td></tr>
                                <tr><td class="text-muted py-1 pr-2">Jenis</td><td class="py-1" id="det_jenis">-</td></tr>
                                <tr><td class="text-muted py-1 pr-2">Bidang</td><td class="py-1" id="det_bidang">-</td></tr>
                                <tr><td class="text-muted py-1 pr-2">Periode</td><td class="py-1" id="det_waktu">-</td></tr>
                            </table>
                        </div>
                    </div>

                    <!-- Keahlian -->
                    <div class="mb-4">
                        <p class="text-uppercase font-weight-bold mb-2" style="font-size: 0.7rem; color: #94a3b8; letter-spacing: 0.8px;" id="det_keahlian_label">Deskripsi Keahlian</p>
                        <p id="det_keahlian" class="mb-0" style="font-size: 0.88rem; color: #334155; line-height: 1.65;">-</p>
                    </div>

                    <!-- Catatan Sekretariat -->
                    <div class="mb-4">
                        <p class="text-uppercase font-weight-bold mb-2" style="font-size: 0.7rem; color: #94a3b8; letter-spacing: 0.8px;">Catatan Sekretariat</p>
                        <div id="det_catatan" style="font-size: 0.88rem; color: #92400e; background: #fffbeb; border-left: 3px solid #f59e0b; padding: 0.6rem 0.85rem; border-radius: 4px; line-height: 1.6;">-</div>
                    </div>

                    <!-- Dokumen -->
                    <div>
                        <p class="text-uppercase font-weight-bold mb-2" style="font-size: 0.7rem; color: #94a3b8; letter-spacing: 0.8px;">Dokumen Terlampir</p>
                        <div id="det_files" class="d-flex flex-wrap" style="gap: 6px;">
                            <!-- injected via JS -->
                        </div>
                    </div>

                </div>

                <!-- ===== Action: Menunggu ===== -->
                <div id="action_container" style="display:none; background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 1.25rem 1.75rem;">
                    <form id="formDisposisiAksi" method="POST" action="">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id_penempatan_magang" id="input_id_penempatan">

                        <div id="logbook_decision_group" class="mb-3">
                            <p class="font-weight-bold mb-2" style="font-size: 0.88rem; color: #1e293b;">Wajibkan pengisian logbook harian?</p>
                            <div class="d-flex" style="gap: 24px;">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="logbook_ya" name="is_log_book" class="custom-control-input" value="Ya" checked>
                                    <label class="custom-control-label" for="logbook_ya" style="cursor: pointer; font-size: 0.88rem; color: #475569;">Ya, wajib</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="logbook_tidak" name="is_log_book" class="custom-control-input" value="Tidak">
                                    <label class="custom-control-label" for="logbook_tidak" style="cursor: pointer; font-size: 0.88rem; color: #475569;">Tidak perlu</label>
                                </div>
                            </div>
                        </div>

                        <div id="setuju_reason_group" class="mb-3">
                            <label class="font-weight-bold" style="color: #1e293b; font-size: 0.88rem;">Catatan Persetujuan (Opsional)</label>
                            <textarea name="catatan_setuju" id="catatan_setuju" class="form-control mt-1" rows="2" placeholder="Tulis catatan untuk mahasiswa..." style="border-radius: 8px; border-color: #e2e8f0; font-size: 0.88rem;"></textarea>
                        </div>

                        <div id="tolak_reason_group" class="mb-3" style="display:none;">
                            <label class="font-weight-bold" style="color: #dc2626; font-size: 0.88rem;">Alasan Penolakan</label>
                            <textarea name="catatan_tolak" id="catatan_tolak" class="form-control mt-1" rows="3" placeholder="Tuliskan alasan penolakan..." style="border-radius: 8px; border-color: #e2e8f0; font-size: 0.88rem;"></textarea>
                        </div>

                        <div class="d-flex justify-content-end" style="gap: 8px;">
                            <button type="button" class="btn btn-sm" data-dismiss="modal" style="border-radius: 6px; font-weight: 500; color: #64748b; background: #fff; border: 1px solid #e2e8f0; padding: 0.4rem 1rem;">Tutup</button>
                            <button type="button" class="btn btn-sm" id="btn-show-tolak" style="border-radius: 6px; font-weight: 500; color: #dc2626; background: #fef2f2; border: 1px solid #fecaca; padding: 0.4rem 1rem;">Tolak</button>
                            <button type="button" class="btn btn-sm" id="btn-submit-tolak" style="display:none; border-radius: 6px; font-weight: 500; color: #fff; background: #dc2626; border: none; padding: 0.4rem 1rem;">Konfirmasi Tolak</button>
                            <button type="button" class="btn btn-sm" id="btn-submit-setuju" style="border-radius: 6px; font-weight: 500; color: #fff; background: #2563eb; border: none; padding: 0.4rem 1rem;">Setujui</button>
                        </div>
                    </form>
                </div>

                <!-- ===== Action: Selesaikan ===== -->
                <div id="selesai_action_container" style="display:none; background: #f0fdf4; border-top: 1px solid #bbf7d0; padding: 1.25rem 1.75rem;">
                    <form id="formSelesaikanAksi" method="POST" action="<?= base_url('kabid/disposisi/selesaikan') ?>" class="d-flex justify-content-between align-items-center">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id_penempatan_magang" id="selesai_id_penempatan">
                        <div>
                            <p class="font-weight-bold mb-0" style="font-size: 0.9rem; color: #166534;">Selesaikan Kegiatan</p>
                            <small class="text-muted">Mahasiswa telah menyelesaikan seluruh kegiatan.</small>
                        </div>
                        <div class="d-flex" style="gap: 8px;">
                            <button type="button" class="btn btn-sm" data-dismiss="modal" style="border-radius: 6px; font-weight: 500; color: #64748b; background: #fff; border: 1px solid #e2e8f0; padding: 0.4rem 1rem;">Batal</button>
                            <button type="submit" class="btn btn-sm" id="btn-submit-selesai" onclick="return confirm('Yakin ingin menyelesaikan kegiatan mahasiswa ini?');" style="border-radius: 6px; font-weight: 500; color: #fff; background: #16a34a; border: none; padding: 0.4rem 1rem;">Tandai Selesai</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<style>
/* Custom Pagination Styles */
.dataTables_wrapper .pagination {
    margin: 0;
}
.dataTables_wrapper .page-item.active .page-link {
    background-color: #0F172A;
    border-color: #0F172A;
    color: white;
}
.dataTables_wrapper .page-link {
    color: #475569;
    border-radius: 4px;
    margin: 0 3px;
    border: 1px solid #E2E8F0;
    padding: 0.4rem 0.8rem;
    font-size: 0.85rem;
}
.dataTables_wrapper .page-item.disabled .page-link {
    color: #94A3B8;
    background-color: #F8FAFC;
}
.dataTables_wrapper .dataTables_info {
    color: #64748B !important;
    font-size: 0.9rem;
    padding-top: 0;
}
.dataTables_wrapper > .d-flex {
    border-top: 1px solid #E2E8F0 !important;
    background-color: #F8FAFC;
    border-bottom-left-radius: 0.5rem;
    border-bottom-right-radius: 0.5rem;
}
</style>
<script>
$(document).ready(function() {
    // Initialize DataTable Custom
    var tableCustom = $('#dataTableCustom').DataTable({
        "pageLength": 10,
        "language": {
            "sInfo": "Menampilkan _START_ dari _TOTAL_ entri",
            "sInfoEmpty": "Menampilkan 0 dari 0 entri",
            "sInfoFiltered": "(disaring dari _MAX_ entri)",
            "sLengthMenu": "Tampilkan _MENU_ entri",
            "sZeroRecords": "Belum ada data disposisi.",
            "oPaginate": {
                "sFirst": "Pertama",
                "sLast": "Terakhir",
                "sNext": "Selanjutnya",
                "sPrevious": "Sebelumnya"
            }
        },
        "dom": 't<"d-flex justify-content-between align-items-center px-4 py-3" <"text-muted"i> <"pagination-sm"p> >',
        "ordering": false
    });

    // Custom Search
    $('#searchTable').on('keyup', function() {
        tableCustom.search(this.value).draw();
    });

    // Fungsi menampilkan detail
    $('.btn-detail').on('click', function() {
        var mhs = $(this).data('mhs');
        
        // Avatar initials
        var parts = (mhs.nama_mahasiswa || '-').split(' ');
        var initials = (parts[0] ? parts[0][0] : '') + (parts[1] ? parts[1][0] : '');
        $('#det_avatar').text(initials.toUpperCase());

        // Populate Data
        $('#det_nama').text(mhs.nama_mahasiswa || '-');
        $('#det_nik').text(mhs.nik || '-');
        $('#det_nim').text(mhs.nim || '-');
        $('#det_jk').text(mhs.jenis_kelamin == 'L' ? 'Laki-Laki' : (mhs.jenis_kelamin == 'P' ? 'Perempuan' : '-'));
        $('#det_telp').text(mhs.no_telp || '-');
        $('#det_email').text(mhs.email || '-');
        
        $('#det_instansi').text(mhs.instansi_pendidikan || '-');
        $('#det_prodi').text(mhs.prodi || '-');
        $('#det_semester').text(mhs.semester || '-');
        $('#det_jenis').text(mhs.jenis_permohonan || '-');
        $('#det_bidang').text(mhs.bidang || '-');

        var jenisText = (mhs.jenis_permohonan || '').toLowerCase();
        if (jenisText.indexOf('penelitian') !== -1 || jenisText.indexOf('skripsi') !== -1 || jenisText.indexOf('ta') !== -1) {
            $('#det_keahlian_label').text('Deskripsi Judul Skripsi / TA');
        } else if (jenisText.indexOf('observasi') !== -1 || jenisText.indexOf('pengambilan data') !== -1) {
            $('#det_keahlian_label').text('Deskripsi Latar Belakang Observasi');
        } else if (jenisText.indexOf('uji coba') !== -1 || jenisText.indexOf('prototype') !== -1) {
            $('#det_keahlian_label').text('Deskripsi Profil Aplikasi / Sistem');
        } else {
            $('#det_keahlian_label').text('Deskripsi Keahlian / Skill');
        }
        
        // Format date helper
        function formatDate(dateStr) {
            if(!dateStr) return '-';
            var d = new Date(dateStr);
            return d.toLocaleDateString('id-ID', {day: '2-digit', month: 'short', year: 'numeric'});
        }
        $('#det_waktu').text(formatDate(mhs.tgl_mulai) + ' – ' + formatDate(mhs.tgl_selesai));
        
        $('#det_keahlian').text(mhs.deskripsi_keahlian || 'Tidak ada deskripsi keahlian.');
        $('#det_catatan').text(mhs.catatan_sekretariat || 'Tidak ada catatan khusus dari Sekretariat.');

        // Populate Files
        var fileHtml = '';
        if (mhs.files && mhs.files.length > 0) {
            mhs.files.forEach(function(f) {
                fileHtml += '<a href="<?= base_url() ?>/' + f.file_path + '" target="_blank" style="display:inline-flex;align-items:center;gap:4px;padding:4px 10px;background:#f1f5f9;border:1px solid #e2e8f0;border-radius:5px;color:#334155;font-size:0.82rem;font-weight:500;text-decoration:none;"><i class="fas fa-file-alt" style="color:#94a3b8;font-size:0.75rem;"></i>' + f.jenis_file + '</a>';
            });
        } else {
            fileHtml = '<span class="text-muted" style="font-size:0.85rem;">Tidak ada dokumen.</span>';
        }
        $('#det_files').html(fileHtml);

        // Reset UI form
        $('#tolak_reason_group').hide();
        $('#setuju_reason_group').show();
        $('#btn-submit-tolak').hide();
        $('#btn-show-tolak').show();
        $('#btn-submit-setuju').show();
        $('#logbook_decision_group').show();
        $('#input_id_penempatan').val(mhs.id_penempatan_magang);
        $('#selesai_id_penempatan').val(mhs.id_penempatan_magang);

        // Tampilkan form aksi HANYA jika status MENUNGGU
        if (mhs.status_penempatan == 'MENUNGGU' || mhs.status_penempatan == '0') {
            $('#action_container').show();
        } else {
            $('#action_container').hide();
        }

        // Tampilkan form selesai HANYA jika status BERJALAN
        if (mhs.status_penempatan == 'BERJALAN') {
            $('#selesai_action_container').show();
        } else {
            $('#selesai_action_container').hide();
        }

        $('#modalDetail').modal('show');
    });

    // Tombol Show Tolak Form
    $('#btn-show-tolak').on('click', function() {
        $(this).hide();
        $('#btn-submit-setuju').hide();
        $('#logbook_decision_group').hide();
        $('#setuju_reason_group').hide();
        $('#tolak_reason_group').slideDown();
        $('#btn-submit-tolak').fadeIn();
    });

    // Konfirmasi Setuju
    $('#btn-submit-setuju').on('click', function() {
        var form = $('#formDisposisiAksi');
        form.attr('action', '<?= base_url('kabid/disposisi/setujui') ?>');
        form.submit();
    });

    // Konfirmasi Tolak
    $('#btn-submit-tolak').on('click', function() {
        var form = $('#formDisposisiAksi');
        var alasan = $('#catatan_tolak').val();
        if(alasan.trim() === '') {
            alert('Mohon isi alasan penolakan.');
            $('#catatan_tolak').focus();
            return false;
        }
        form.attr('action', '<?= base_url('kabid/disposisi/tolak') ?>');
        form.submit();
    });
});

function showLogRiwayatKabid(idPermohonan) {
    var myModal = new bootstrap.Modal(document.getElementById('modalLogRiwayatKabid'));
    myModal.show();
    
    const container = document.getElementById('logRiwayatContainerKabid');
    container.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="text-muted mt-2 small">Memuat riwayat aktivitas...</p>
        </div>`;
        
    fetch(`<?= base_url('api/log/riwayat/') ?>${idPermohonan}`)
        .then(response => response.json())
        .then(res => {
            if(res.status === 'success') {
                if(res.data.length === 0) {
                    container.innerHTML = `<div class="text-center text-muted small py-4">Belum ada riwayat aktivitas yang tercatat.</div>`;
                    return;
                }
                
                let html = '<div class="v-timeline" style="position:relative; padding-left:20px;">';
                res.data.forEach(log => {
                    let iconBg = log.color_class === 'danger' ? '#ef4444' : (log.color_class === 'success' ? '#10b981' : '#3b82f6');
                    html += `
                        <div style="position:relative; margin-bottom:20px; padding-left:15px; border-left:2px solid #e2e8f0;">
                            <div style="position:absolute; top:0; left:-11px; width:20px; height:20px; border-radius:50%; background:${iconBg}; display:flex; align-items:center; justify-content:center;">
                                <i class="fas fa-check text-white" style="font-size:0.6rem;"></i>
                            </div>
                            <span class="d-block text-muted" style="font-size:0.8rem;">${log.tanggal_format} <span class="ms-1">Oleh: ${log.aktor}</span></span>
                            <div class="fw-bold text-dark" style="font-size:0.9rem;">${log.aksi}</div>
                            ${log.catatan ? `<div class="mt-1 p-2 bg-light text-dark rounded" style="font-size:0.85rem;">${log.catatan}</div>` : ''}
                        </div>
                    `;
                });
                html += '</div>';
                container.innerHTML = html;
            } else {
                container.innerHTML = `<div class="alert alert-danger p-2 small">Gagal memuat log riwayat.</div>`;
            }
        })
        .catch(error => {
            console.error(error);
            container.innerHTML = `<div class="alert alert-danger p-2 small">Terjadi kesalahan jaringan.</div>`;
        });
}
</script>

<!-- MODAL LOG RIWAYAT KABID -->
<div class="modal fade" id="modalLogRiwayatKabid" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow" style="border-radius: 8px;">
            <div class="modal-header bg-white border-bottom py-3">
                <h6 class="modal-title fw-bold text-dark m-0"><i class="fas fa-history mr-2 text-info"></i> Lacak Jejak (Log Riwayat)</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 bg-white" id="logRiwayatContainerKabid">
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
