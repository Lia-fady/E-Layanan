<?= $this->extend('layout/L_master_kabid') ?>

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

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="mb-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <span class="mr-2 text-muted" style="font-size: 0.88rem;">Tampilkan</span>
                <select id="customLength" class="form-control form-control-sm custom-select custom-select-sm" style="width: 65px;">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="ml-2 text-muted" style="font-size: 0.88rem;">entri</span>
            </div>
            
            <div class="d-flex align-items-center" style="gap: 10px;">
                <select id="filterStatusCustom" class="form-control form-control-sm custom-select custom-select-sm" style="width: 160px;">
                    <option value="">Semua Status</option>
                    <option value="Menunggu">Menunggu</option>
                    <option value="Berjalan">Berjalan</option>
                    <option value="Selesai">Selesai</option>
                    <option value="Dibatalkan">Dibatalkan</option>
                </select>
                
                <div class="input-group input-group-sm" style="width: 220px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                    </div>
                    <input type="text" id="searchTable" class="form-control border-left-0 pl-0" placeholder="Cari Nama / Instansi...">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTableCustom" width="100%" cellspacing="0">
                <thead class="bg-primary text-white">
                    <tr>
                        <th width="5%" class="text-center align-middle">No</th>
                        <th width="25%" class="text-center align-middle">Nama / NIM</th>
                        <th width="25%" class="text-center align-middle">Instansi / Prodi</th>
                        <th width="15%" class="text-center align-middle">Jenis Permohonan</th>
                        <th width="15%" class="text-center align-middle">Status</th>
                        <th width="15%" class="text-center align-middle">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($penempatan)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada data disposisi.</td>
                    </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($penempatan as $row): ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td>
                                <strong><?= esc($row->nama_mahasiswa) ?></strong><br>
                                <small class="text-muted"><?= esc($row->nim ?? '-') ?></small>
                            </td>
                            <td>
                                <?= esc($row->instansi_pendidikan ?? '-') ?><br>
                                <small class="text-muted"><?= esc($row->prodi ?? '-') ?></small>
                            </td>
                            <td>
                                <span class="badge badge-info"><?= esc($row->jenis_permohonan ?? '-') ?></span>
                            </td>
                            <td>
                                <?php if ($row->status_penempatan == 'MENUNGGU'): ?>
                                    <span class="badge badge-warning">Menunggu</span>
                                <?php elseif ($row->status_penempatan == 'BERJALAN'): ?>
                                    <span class="badge badge-primary">Berjalan</span>
                                <?php elseif ($row->status_penempatan == 'SELESAI'): ?>
                                    <span class="badge badge-success">Selesai</span>
                                <?php elseif ($row->status_penempatan == 'DIBATALKAN'): ?>
                                    <span class="badge badge-danger">Dibatalkan</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary"><?= esc($row->status_penempatan) ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-info btn-detail" 
                                    data-id="<?= $row->id_penempatan_magang ?>"
                                    data-mhs="<?= htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') ?>"
                                    title="Detail Permohonan">
                                    <i class="far fa-eye"></i> Detail
                                </button>
                                <button type="button" class="btn btn-sm btn-secondary"
                                    onclick="showLogRiwayatKabid(<?= $row->id_permohonan_magang ?>)"
                                    title="Lacak Jejak (Log Riwayat)">
                                    <i class="fas fa-history"></i> Log
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
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
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

                    <div class="row">
                        <!-- Kolom Kiri: Informasi Pemohon & Permohonan -->
                        <div class="col-md-6">
                            <h6 class="mb-3 font-weight-bold" style="color: #1B2559;">Informasi Pemohon</h6>
                            <table class="table table-sm table-borderless mb-4">
                                <tr>
                                    <td width="35%" class="text-muted">Nama Pemohon</td>
                                    <td width="2%">:</td>
                                    <td><strong id="det_nama">-</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">NIM / NIS</td>
                                    <td>:</td>
                                    <td id="det_nim">-</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">NIK</td>
                                    <td>:</td>
                                    <td id="det_nik">-</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Jenis Kelamin</td>
                                    <td>:</td>
                                    <td id="det_jk">-</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">No. Telepon</td>
                                    <td>:</td>
                                    <td id="det_telp">-</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Email</td>
                                    <td>:</td>
                                    <td id="det_email">-</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Universitas / Instansi</td>
                                    <td>:</td>
                                    <td id="det_instansi">-</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Prodi / Fakultas</td>
                                    <td>:</td>
                                    <td id="det_prodi">-</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Semester</td>
                                    <td>:</td>
                                    <td id="det_semester">-</td>
                                </tr>
                            </table>

                            <h6 class="mb-3 font-weight-bold" style="color: #1B2559; border-top: 1px solid #eee; padding-top: 15px;">Data Permohonan</h6>
                            <div class="card bg-light border-0 mb-4">
                                <div class="card-body p-3">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <span class="text-muted d-block" style="font-size: 0.9rem;">Jenis Kegiatan</span>
                                            <strong style="font-size: 0.95rem;" id="det_jenis">-</strong>
                                        </div>
                                        <div class="col-md-6">
                                            <span class="text-muted d-block" style="font-size: 0.9rem;">Bidang Tujuan</span>
                                            <strong style="font-size: 0.95rem;" id="det_bidang">-</strong>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <span class="text-muted d-block" style="font-size: 0.9rem;">Periode Pelaksanaan</span>
                                        <strong style="font-size: 0.95rem;" id="det_waktu">-</strong>
                                    </div>
                                    <div class="mb-3">
                                        <span class="text-muted d-block" style="font-size: 0.9rem;" id="det_keahlian_label">Deskripsi Keahlian</span>
                                        <strong style="font-size: 0.95rem;" id="det_keahlian">-</strong>
                                    </div>
                                    <div>
                                        <span class="text-muted d-block" style="font-size: 0.9rem;">Catatan dari Sekretariat</span>
                                        <div id="det_catatan" class="mt-1" style="font-size: 0.9rem; color: #92400e; background: #fffbeb; border-left: 3px solid #f59e0b; padding: 0.5rem 0.75rem; border-radius: 4px;">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan: Dokumen Terlampir -->
                        <div class="col-md-6">
                            <h6 class="mb-3 font-weight-bold" style="color: #1B2559;">Dokumen Terlampir</h6>
                            <div id="det_files" class="d-flex flex-wrap" style="gap: 8px;">
                                <!-- injected via JS -->
                            </div>
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
        "dom": 'rt<"row mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>', // Custom DOM for aligned pagination
        "searching": true,
        "ordering": false
    });

    // Custom Search
    $('#searchTable').on('keyup', function() {
        tableCustom.search(this.value).draw();
    });

    // Custom Length Menu
    $('#customLength').on('change', function() {
        tableCustom.page.len(this.value).draw();
    });

    // Custom Status Filter
    $('#filterStatusCustom').on('change', function() {
        tableCustom.column(4).search(this.value).draw();
    });

    // Jalankan filter otomatis saat pertama dimuat (jika ada param status)
    if ($('#filterStatusCustom').val() !== '') {
        tableCustom.column(4).search($('#filterStatusCustom').val()).draw();
    }

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
