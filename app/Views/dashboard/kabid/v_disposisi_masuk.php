<?= $this->extend('layout/L_master_kabid') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>



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
                    <?php if (!empty($penempatan)): ?>
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
                    <div class="mb-4">
                        <div class="card border-0 shadow-sm" style="border-radius: 16px; background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);">
                            <div class="card-body p-4">
                                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start gap-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div id="det_avatar" class="rounded-circle d-flex align-items-center justify-content-center" style="width: 54px; height: 54px; background: #dbeafe; color: #1d4ed8; font-weight: 700; font-size: 1rem;">
                                            -
                                        </div>
                                        <div>
                                            <h6 class="mb-1 font-weight-bold" style="color: #0f172a;">Informasi Pemohon</h6>
                                            <p class="mb-0 text-muted" style="font-size: 0.85rem;">Data identitas serta latar belakang pemohon magang.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-6 mb-3">
                                        <div class="text-muted small mb-1"><i class="fas fa-user mr-2"></i> Nama Pemohon</div>
                                        <div class="font-weight-bold text-dark" id="det_nama">-</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="text-muted small mb-1"><i class="fas fa-id-card mr-2"></i> NIM / NIS</div>
                                        <div class="text-dark" id="det_nim">-</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="text-muted small mb-1"><i class="fas fa-passport mr-2"></i> NIK</div>
                                        <div class="text-dark" id="det_nik">-</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="text-muted small mb-1"><i class="fas fa-venus-mars mr-2"></i> Jenis Kelamin</div>
                                        <div class="text-dark" id="det_jk">-</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="text-muted small mb-1"><i class="fas fa-phone mr-2"></i> No. Telepon</div>
                                        <div class="text-dark" id="det_telp">-</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="text-muted small mb-1"><i class="fas fa-envelope mr-2"></i> Email</div>
                                        <div class="text-dark" id="det_email">-</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="text-muted small mb-1"><i class="fas fa-university mr-2"></i> Universitas / Instansi</div>
                                        <div class="text-dark" id="det_instansi">-</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="text-muted small mb-1"><i class="fas fa-graduation-cap mr-2"></i> Prodi / Fakultas</div>
                                        <div class="text-dark" id="det_prodi">-</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="text-muted small mb-1"><i class="fas fa-calendar-alt mr-2"></i> Semester</div>
                                        <div class="text-dark" id="det_semester">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="card border-0 shadow-sm" style="border-radius: 16px; background: #fff;">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0 font-weight-bold" style="color: #1B2559;">Dokumen Terlampir</h6>
                                    <span class="badge badge-light text-muted">Lampiran pemohon</span>
                                </div>
                                <div id="det_files" class="d-flex flex-wrap" style="gap: 10px;">
                                    <!-- injected via JS -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="card border-0 shadow-sm" style="border-radius: 16px; background: #fff;">
                            <div class="card-body p-4">
                                <h6 class="mb-3 font-weight-bold" style="color: #1B2559;">Data Permohonan</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="text-muted small mb-1">Jenis Kegiatan</div>
                                        <div class="font-weight-bold text-dark" id="det_jenis">-</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="text-muted small mb-1">Bidang Tujuan</div>
                                        <div class="font-weight-bold text-dark" id="det_bidang">-</div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="text-muted small mb-1">Periode Pelaksanaan</div>
                                        <div class="font-weight-bold text-dark" id="det_waktu">-</div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="text-muted small mb-1" id="det_keahlian_label">Deskripsi Keahlian</div>
                                        <div class="font-weight-bold text-dark" id="det_keahlian">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- ===== Action: Menunggu ===== -->
                <div id="action_container" style="display:none; background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 1.25rem 1.75rem;">
                    <form id="formDisposisiAksi" method="POST" action="">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id_penempatan_magang" id="input_id_penempatan">

                        <div class="card border-0 shadow-sm mb-3" style="border-radius: 14px;">
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <label class="font-weight-bold" style="color: #1e293b; font-size: 0.88rem;">Status Keputusan</label>
                                    <select id="decision_status" name="decision_status" class="form-control mt-1" style="border-radius: 8px; border-color: #e2e8f0; font-size: 0.88rem;">
                                        <option value="">Pilih Keputusan</option>
                                        <option value="setujui">Setujui</option>
                                        <option value="perbaikan">Perbaikan</option>
                                        <option value="tolak">Tolak</option>
                                    </select>
                                </div>

                                <div id="decision_note_group" class="mb-3" style="display:none;">
                                    <label id="decision_note_label" class="font-weight-bold" style="color: #1e293b; font-size: 0.88rem;">Catatan Keputusan (Opsional)</label>
                                    <textarea name="catatan_keputusan" id="catatan_keputusan" class="form-control mt-1" rows="3" placeholder="Tambahkan catatan jika diperlukan..." style="border-radius: 8px; border-color: #e2e8f0; font-size: 0.88rem;"></textarea>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="is_log_book" value="Ya">

                        <div class="d-flex justify-content-end" style="gap: 8px;">
                            <button type="button" class="btn btn-sm" data-dismiss="modal" style="border-radius: 6px; font-weight: 500; color: #64748b; background: #fff; border: 1px solid #e2e8f0; padding: 0.4rem 1rem;">Tutup</button>
                            <button type="button" class="btn btn-sm" id="btn-submit-keputusan" style="border-radius: 6px; font-weight: 500; color: #fff; background: #2563eb; border: none; padding: 0.4rem 1rem;">Simpan Keputusan</button>
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
                            <button type="button" class="btn btn-sm" id="btn-submit-selesai" style="border-radius: 6px; font-weight: 500; color: #fff; background: #16a34a; border: none; padding: 0.4rem 1rem;">Tandai Selesai</button>
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

    // Jalankan filter otomatis saat pertama dimuat agar halaman hanya menampilkan status Menunggu
    $('#filterStatusCustom').val('Menunggu').trigger('change');

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
                fileHtml += '<a href="<?= base_url() ?>/' + f.file_path + '" target="_blank" class="d-flex align-items-center gap-2 text-decoration-none" style="padding: 10px 12px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; min-width: 180px; color: #334155;">' +
                    '<span class="rounded-circle d-flex align-items-center justify-content-center" style="width: 34px; height: 34px; background: #dbeafe; color: #1d4ed8;"><i class="fas fa-file-alt"></i></span>' +
                    '<span class="font-weight-bold text-truncate" style="font-size: 0.85rem; max-width: 180px;">' + (f.jenis_file || 'Dokumen') + '</span>' +
                    '</a>';
            });
        } else {
            fileHtml = '<span class="text-muted" style="font-size:0.85rem;">Tidak ada dokumen.</span>';
        }
        $('#det_files').html(fileHtml);

        // Reset UI form
        $('#decision_status').val('');
        $('#decision_note_group').hide();
        $('#catatan_keputusan').val('');
        $('#decision_note_label').text('Catatan Keputusan (Opsional)').attr('style', 'color: #1e293b; font-size: 0.88rem;');
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

    $('#decision_status').on('change', function() {
        var val = $(this).val();
        $('#decision_note_group').hide();

        if (val === 'perbaikan') {
            $('#decision_note_label').text('Catatan Perbaikan (Opsional)').attr('style', 'color: #1e293b; font-size: 0.88rem;');
            $('#catatan_keputusan').attr('placeholder', 'Jelaskan bagian yang perlu diperbaiki...');
            $('#decision_note_group').slideDown();
        } else if (val === 'tolak') {
            $('#decision_note_label').text('Alasan Penolakan (Opsional)').attr('style', 'color: #dc2626; font-size: 0.88rem;');
            $('#catatan_keputusan').attr('placeholder', 'Berikan alasan penolakan jika diperlukan...');
            $('#decision_note_group').slideDown();
        } else if (val === 'setujui') {
            $('#decision_note_label').text('Catatan Keputusan (Opsional)').attr('style', 'color: #1e293b; font-size: 0.88rem;');
            $('#catatan_keputusan').attr('placeholder', 'Tambahkan catatan jika diperlukan...');
            $('#decision_note_group').slideDown();
        }
    });

    $('#btn-submit-keputusan').on('click', function() {
        var decision = $('#decision_status').val();
        var form = $('#formDisposisiAksi');

        if (!decision) {
            alert('Silakan pilih keputusan terlebih dahulu.');
            $('#decision_status').focus();
            return false;
        }

        if (decision === 'tolak') {
            form.attr('action', '<?= base_url('kabid/disposisi/tolak') ?>');
            form.submit();
            return;
        }

        form.attr('action', '<?= base_url('kabid/disposisi/setujui') ?>');
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
