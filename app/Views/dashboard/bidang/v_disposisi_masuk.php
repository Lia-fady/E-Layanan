<?= $this->extend('layouts/bidang/L_main_kabid') ?>

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
            Pantau dan kelola seluruh mahasiswa magang yang didisposisikan ke bidang Anda.
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
                                <button type="button" class="btn btn-link btn-sm btn-detail" 
                                    style="color: #2563EB; font-weight: 500; text-decoration: none;"
                                    data-id="<?= $row->id_penempatan_magang ?>"
                                    data-mhs="<?= htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') ?>">
                                    <i class="far fa-eye mr-1"></i> Detail
                                </button>
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalDetailLabel"><i class="fas fa-user-graduate mr-2"></i> Detail Permohonan Magang</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                
                <div class="row">
                    <!-- Biodata Mahasiswa -->
                    <div class="col-md-6 mb-3">
                        <div class="card h-100 shadow-sm border-0" style="border-radius: 12px; border: 1px solid #E2E8F0 !important;">
                            <div class="card-header bg-white font-weight-bold text-primary" style="border-bottom: 1px solid #E2E8F0; border-radius: 12px 12px 0 0;"><i class="fas fa-id-card mr-2"></i> Biodata Mahasiswa</div>
                            <div class="card-body p-3">
                                <table class="table table-sm table-borderless mb-0">
                                    <tr><th width="40%" class="text-muted">Nama Lengkap</th><td id="det_nama" class="font-weight-bold text-dark"></td></tr>
                                    <tr><th class="text-muted">NIK</th><td id="det_nik"></td></tr>
                                    <tr><th class="text-muted">NIM / NIS</th><td id="det_nim"></td></tr>
                                    <tr><th class="text-muted">Jenis Kelamin</th><td id="det_jk"></td></tr>
                                    <tr><th class="text-muted">No. Telepon</th><td id="det_telp"></td></tr>
                                    <tr><th class="text-muted">Email</th><td id="det_email"></td></tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Akademik -->
                    <div class="col-md-6 mb-3">
                        <div class="card h-100 shadow-sm border-0" style="border-radius: 12px; border: 1px solid #E2E8F0 !important;">
                            <div class="card-header bg-white font-weight-bold text-primary" style="border-bottom: 1px solid #E2E8F0; border-radius: 12px 12px 0 0;"><i class="fas fa-university mr-2"></i> Informasi Akademik & Magang</div>
                            <div class="card-body p-3">
                                <table class="table table-sm table-borderless mb-0">
                                    <tr><th width="40%" class="text-muted">Instansi</th><td id="det_instansi" class="font-weight-bold text-dark"></td></tr>
                                    <tr><th class="text-muted">Jurusan/Prodi</th><td id="det_prodi"></td></tr>
                                    <tr><th class="text-muted">Semester</th><td id="det_semester"></td></tr>
                                    <tr><th class="text-muted">Jenis Permohonan</th><td id="det_jenis"></td></tr>
                                    <tr><th class="text-muted">Bidang Tujuan</th><td id="det_bidang"></td></tr>
                                    <tr><th class="text-muted">Waktu Magang</th><td id="det_waktu" class="text-danger font-weight-bold"></td></tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Keahlian & Deskripsi -->
                <div class="card shadow-sm border-0 mb-3" style="border-radius: 12px; border: 1px solid #E2E8F0 !important;">
                    <div class="card-header bg-white font-weight-bold text-primary" style="border-bottom: 1px solid #E2E8F0; border-radius: 12px 12px 0 0;"><i class="fas fa-align-left mr-2"></i> Keahlian & Catatan Sekretariat</div>
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <strong class="text-muted d-block mb-1">Deskripsi Keahlian:</strong>
                                <div id="det_keahlian" class="p-3 bg-light rounded border" style="line-height: 1.5; font-size: 0.9rem;"></div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong class="text-muted d-block mb-1">Catatan Disposisi (Sekretariat):</strong>
                                <div id="det_catatan" class="p-3 bg-light rounded border text-danger" style="line-height: 1.5; font-size: 0.9rem;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dokumen Pendukung -->
                <div class="card shadow-sm border-0 mb-3" style="border-radius: 12px; border: 1px solid #E2E8F0 !important;">
                    <div class="card-header bg-white font-weight-bold text-primary" style="border-bottom: 1px solid #E2E8F0; border-radius: 12px 12px 0 0;"><i class="fas fa-folder-open mr-2"></i> Dokumen Pendukung</div>
                    <div class="card-body p-3">
                        <div id="det_files" class="d-flex flex-wrap" style="gap:10px;">
                            <!-- File links will be injected here -->
                        </div>
                    </div>
                </div>

                <!-- Form Aksi (Hanya muncul jika status MENUNGGU) -->
                <div id="action_container" style="display:none;">
                    <hr class="mt-4 mb-4">
                    <div class="alert alert-info border-info" style="border-radius: 12px; border-left: 5px solid #3B82F6 !important;">
                        <h6 class="font-weight-bold text-primary mb-3">Tindak Lanjut Kepala Bidang (Disposisi Baru)</h6>
                        <form id="formDisposisiAksi" method="POST" action="">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id_penempatan_magang" id="input_id_penempatan">
                            
                            <!-- Keputusan Logbook -->
                            <div class="form-group mb-4" id="logbook_decision_group">
                                <label class="font-weight-bold">Apakah Mahasiswa ini diwajibkan mengisi Logbook harian?</label>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="logbook_ya" name="is_log_book" class="custom-control-input" value="Ya" checked>
                                    <label class="custom-control-label" for="logbook_ya">Ya, Wajib</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="logbook_tidak" name="is_log_book" class="custom-control-input" value="Tidak">
                                    <label class="custom-control-label" for="logbook_tidak">Tidak Perlu</label>
                                </div>
                            </div>

                            <!-- Alasan Penolakan (Hidden initially) -->
                            <div class="form-group mb-3" id="tolak_reason_group" style="display:none;">
                                <label class="font-weight-bold text-danger">Alasan Penolakan / Pembatalan</label>
                                <textarea name="catatan_tolak" id="catatan_tolak" class="form-control" rows="3" placeholder="Sebutkan alasan penolakan agar Sekretariat bisa menginformasikan mahasiswa..."></textarea>
                            </div>

                            <div class="d-flex justify-content-end" style="gap:10px;">
                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
                                
                                <button type="button" class="btn btn-danger" id="btn-show-tolak">
                                    <i class="fas fa-times"></i> Batalkan / Tolak
                                </button>
                                
                                <button type="button" class="btn btn-danger" id="btn-submit-tolak" style="display:none;">
                                    <i class="fas fa-check-circle"></i> Konfirmasi Tolak
                                </button>

                                <button type="button" class="btn btn-success" id="btn-submit-setuju">
                                    <i class="fas fa-check"></i> Setujui Penempatan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Form Selesaikan Magang (Hanya muncul jika status BERJALAN) -->
                <div id="selesai_action_container" style="display:none;">
                    <hr class="mt-4 mb-4">
                    <div class="alert alert-success" style="border-radius: 12px; border-left: 5px solid #10B981 !important; background-color: #ECFDF5;">
                        <h6 class="font-weight-bold text-success mb-2"><i class="fas fa-flag-checkered mr-2"></i>Selesaikan Masa Magang</h6>
                        <p class="small text-dark mb-3">Tekan tombol di bawah ini jika mahasiswa telah menyelesaikan seluruh rangkaian kegiatan magangnya. Kuota bidang akan kembali kosong.</p>
                        
                        <form id="formSelesaikanAksi" method="POST" action="<?= base_url('kabid/disposisi/selesaikan') ?>">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id_penempatan_magang" id="selesai_id_penempatan">
                            
                            <div class="d-flex justify-content-end" style="gap:10px;">
                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-success" id="btn-submit-selesai" onclick="return confirm('Apakah Anda yakin ingin menyelesaikan masa magang mahasiswa ini?');">
                                    <i class="fas fa-check-double"></i> Tandai Selesai
                                </button>
                            </div>
                        </form>
                    </div>
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
        
        // Format date helper
        function formatDate(dateStr) {
            if(!dateStr) return '-';
            var d = new Date(dateStr);
            return d.toLocaleDateString('id-ID', {day: '2-digit', month: 'long', year: 'numeric'});
        }
        $('#det_waktu').text(formatDate(mhs.tgl_mulai) + ' s/d ' + formatDate(mhs.tgl_selesai));
        
        $('#det_keahlian').text(mhs.deskripsi_keahlian || 'Tidak ada deskripsi keahlian yang diisi mahasiswa.');
        $('#det_catatan').text(mhs.catatan || 'Tidak ada catatan khusus dari Sekretariat.');

        // Populate Files
        var fileHtml = '';
        if (mhs.files && mhs.files.length > 0) {
            mhs.files.forEach(function(f) {
                fileHtml += `<a href="<?= base_url() ?>/${f.file_path}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-file-pdf"></i> ${f.jenis_file}</a>`;
            });
        } else {
            fileHtml = '<span class="text-muted">Tidak ada dokumen pendukung.</span>';
        }
        $('#det_files').html(fileHtml);

        // Reset UI form
        $('#tolak_reason_group').hide();
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
</script>
<?= $this->endSection() ?>
