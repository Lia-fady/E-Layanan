<style>
    .info-label { font-size: 0.75rem; color: #64748B; text-transform: uppercase; font-weight: 700; margin-bottom: 4px; }
    .info-value { font-size: 0.95rem; color: #0f172a; font-weight: 600; line-height: 1.5; }
    .status-badge { display: inline-flex; align-items: center; gap: 6px; border-radius: 999px; padding: 6px 12px; font-size: 0.76rem; font-weight: 700; }
    .status-badge.running { background: #e0f2fe; color: #0369a1; }
    .status-badge.done { background: #dcfce7; color: #15803d; }
    .activity-text { white-space: pre-line; line-height: 1.6; font-size: 0.9rem; }
    .doc-thumb { width: 60px; height: 60px; object-fit: cover; border-radius: 6px; border: 1px solid #e2e8f0; }
    .custom-control-label::before, .custom-control-label::after { top: 0.15rem; width: 1.25rem; height: 1.25rem; }
    #tblLogbookDetail th, #tblLogbookDetail td { vertical-align: middle; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 style="font-weight:700; color:#1B2559; margin-bottom:4px;">Detail & Approval Logbook</h5>
        <p style="color:#64748B; font-size:0.9rem; margin:0;">
            Review aktivitas harian dan berikan persetujuan untuk pemohon.
        </p>
    </div>
    <button type="button" id="btnKembaliList" class="btn btn-light border shadow-sm" style="border-radius: 8px; font-weight: 600; color: #475569;">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </button>
</div>

<!-- Identitas -->
<div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center" style="border-radius: 12px 12px 0 0;">
        <h6 class="m-0 font-weight-bold text-dark">Profil Pemohon</h6>
        <?php if (($mahasiswa->status_penempatan ?? '') == 'SELESAI') : ?>
            <span class="status-badge done"><i class="fas fa-check-circle"></i> Selesai</span>
        <?php else : ?>
            <span class="status-badge running"><i class="fas fa-play-circle"></i> Berjalan</span>
        <?php endif; ?>
    </div>
    <div class="card-body p-4">
        <div class="row align-items-center">
            <div class="col-md-3 text-center mb-3 mb-md-0">
                <?php
                    $nameParts = explode(' ', trim($mahasiswa->nama_mahasiswa));
                    $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
                ?>
                <div class="mb-3 d-flex justify-content-center">
                    <?php if (!empty($mahasiswa->foto_profil)) : ?>
                        <img src="<?= base_url('uploads/profil/' . $mahasiswa->foto_profil) ?>" class="rounded-circle shadow-sm" style="width:90px;height:90px;object-fit:cover; border:3px solid #fff;">
                    <?php else : ?>
                        <div class="rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width:90px;height:90px; background:#dbeafe; color:#1d4ed8; font-size:2rem; font-weight:bold; border:3px solid #fff;">
                            <?= $initials ?>
                        </div>
                    <?php endif; ?>
                </div>
                <h5 class="font-weight-bold text-dark mb-1"><?= esc($mahasiswa->nama_mahasiswa) ?></h5>
                <span class="badge badge-light border text-muted px-2 py-1"><i class="fas fa-id-card mr-1"></i> <?= esc($mahasiswa->nim) ?></span>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <div class="info-label"><i class="fas fa-university mr-1"></i> Instansi Pendidikan</div>
                        <div class="info-value"><?= esc($mahasiswa->instansi_pendidikan) ?></div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="info-label"><i class="fas fa-graduation-cap mr-1"></i> Jurusan</div>
                        <div class="info-value"><?= esc($mahasiswa->prodi) ?></div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="info-label"><i class="fas fa-venus-mars mr-1"></i> Jenis Kelamin</div>
                        <div class="info-value"><?= $mahasiswa->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' ?></div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="info-label"><i class="fas fa-phone mr-1"></i> Telepon</div>
                        <div class="info-value"><?= esc($mahasiswa->no_telp ?? '-') ?></div>
                    </div>
                    <div class="col-sm-12">
                        <div class="info-label"><i class="fas fa-calendar-alt mr-1"></i> Periode Kegiatan</div>
                        <div class="info-value text-primary">
                            <?= date('d M Y', strtotime($mahasiswa->tgl_mulai)) ?> <span class="text-muted mx-1">s/d</span> <?= date('d M Y', strtotime($mahasiswa->tgl_selesai)) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Logbook -->
<div class="card shadow-sm border-0" style="border-radius: 12px;">
    <?php
        $pendingCount = 0; $approvedCount = 0; $rejectedCount = 0;
        if (!empty($logbooks)) {
            foreach ($logbooks as $log) {
                $status = strtolower((string) ($log['status_logbook'] ?? ''));
                if ($status === 'ditolak') $rejectedCount++;
                elseif (!empty($log['disetujui_oleh']) || $status === 'disetujui') $approvedCount++;
                else $pendingCount++;
            }
        }
    ?>
    
    <div class="card-header bg-white border-bottom py-3 d-flex flex-wrap align-items-center justify-content-between" style="border-radius: 12px 12px 0 0;">
        <h6 class="m-0 font-weight-bold text-dark">Daftar Logbook Kegiatan</h6>
        <div class="d-flex align-items-center gap-3">
            <button type="submit" id="btnEApprove" form="formBulkApproveLogbook" class="btn btn-success btn-sm shadow-sm font-weight-bold px-3" style="display: none; border-radius: 6px;">
                <i class="fas fa-check-double mr-1"></i> Setujui <span id="selectedCountLabel">0</span> Terpilih
            </button>
        </div>
    </div>

    <div class="card-body p-0">
        <form id="formBulkApproveLogbook" action="<?= base_url('kabid/logbook/bulkApprove') ?>" method="POST" class="m-0 p-0">
            <?= csrf_field() ?>
            <input type="hidden" name="id_penempatan_magang" id="id_penempatan_magang" value="<?= $mahasiswa->id_penempatan_magang ?>">
            
            <div class="table-responsive">
                <table id="tblLogbookDetail" class="table table-bordered table-hover w-100 m-0" style="font-size: 0.9rem;">
                    <thead class="bg-light">
                        <tr>
                            <th width="5%" class="text-center align-middle">No</th>
                            <th width="15%" class="align-middle">Tanggal</th>
                            <th width="35%" class="align-middle">Kegiatan</th>
                            <th width="15%" class="text-center align-middle">Dokumentasi</th>
                            <th width="15%" class="text-center align-middle">Status</th>
                            <th width="10%" class="text-center align-middle">Aksi</th>
                            <th width="5%" class="text-center align-middle">
                                <?php if ($pendingCount > 0) : ?>
                                    <div class="custom-control custom-checkbox" title="Pilih Semua">
                                        <input type="checkbox" class="custom-control-input select-all-pending" id="selectAllTop">
                                        <label class="custom-control-label" for="selectAllTop" style="cursor:pointer;"></label>
                                    </div>
                                <?php else: ?>
                                    Pilih
                                <?php endif; ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $idx = 1; foreach ($logbooks as $log) :
                            $status = strtolower((string) ($log['status_logbook'] ?? ''));
                        ?>
                            <tr>
                                <td class="text-center font-weight-bold text-muted align-middle"><?= $idx++ ?></td>
                                <td class="align-middle">
                                    <div class="font-weight-bold text-dark"><?= date('Y-m-d', strtotime($log['tgl_logbook'])) ?></div>
                                    <div class="small text-muted mt-1"><?= date('H:i', strtotime($log['tgl_logbook'])) ?></div>
                                </td>
                                <td class="align-middle">
                                    <div class="activity-text text-dark"><?= nl2br(esc($log['logbook_magang'])) ?></div>
                                </td>
                                <td class="text-center align-middle">
                                    <?php if (!empty($log['bukti_kegiatan'])) : ?>
                                        <?php 
                                            $ext = pathinfo($log['bukti_kegiatan'], PATHINFO_EXTENSION);
                                            if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif'])):
                                        ?>
                                            <a href="<?= base_url($log['bukti_kegiatan']) ?>" target="_blank">
                                                <img src="<?= base_url($log['bukti_kegiatan']) ?>" class="doc-thumb shadow-sm" alt="Dokumentasi">
                                            </a>
                                        <?php else: ?>
                                            <a href="<?= base_url($log['bukti_kegiatan']) ?>" target="_blank" class="btn btn-light border p-2" style="border-radius:6px;" title="Lihat Dokumen">
                                                <i class="fas fa-file-alt fa-2x text-primary"></i>
                                            </a>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center align-middle">
                                    <?php if ($status === 'menunggu' || $status === 'belum_disetujui') : ?>
                                        <span class="badge badge-warning text-dark p-2"><i class="fas fa-clock mr-1"></i> Menunggu</span>
                                    <?php elseif ($status === 'ditolak') : ?>
                                        <span class="badge badge-danger p-2"><i class="fas fa-times mr-1"></i> Ditolak</span>
                                        <?php if(!empty($log['catatan_revisi'])): ?>
                                            <div class="small text-danger mt-2 text-left" style="line-height:1.3; font-size:0.8rem; font-weight:600;"><i class="fas fa-info-circle mr-1"></i> Catatan: <?= esc($log['catatan_revisi']) ?></div>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <span class="badge badge-success p-2"><i class="fas fa-check mr-1"></i> Disetujui</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center align-middle">
                                    <?php if ($status === 'menunggu' || $status === 'belum_disetujui') : ?>
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <button type="button" class="btn btn-success btn-setuju-logbook shadow-sm" data-id="<?= $log['id_logbook_magang'] ?>" style="border-radius:6px; width: 34px; height: 34px; padding: 0;" title="Setujui">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-tolak-logbook shadow-sm" data-id="<?= $log['id_logbook_magang'] ?>" style="border-radius:6px; width: 34px; height: 34px; padding: 0;" title="Tolak">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    <?php else : ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center align-middle">
                                    <?php if ($status === 'menunggu' || $status === 'belum_disetujui') : ?>
                                        <div class="custom-control custom-checkbox" title="Pilih Logbook">
                                            <input type="checkbox" class="custom-control-input pending-logbook-checkbox" id="chk_<?= $log['id_logbook_magang'] ?>" name="selected_ids[]" value="<?= $log['id_logbook_magang'] ?>">
                                            <label class="custom-control-label" for="chk_<?= $log['id_logbook_magang'] ?>" style="cursor:pointer;"></label>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('#tblLogbookDetail').DataTable({
        "language": { "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json" },
        "pageLength": 10,
        "ordering": false,
        "dom": 'tr<"p-3 border-top d-flex flex-wrap align-items-center justify-content-between"<"small text-muted"i><"m-0"p>>',
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Semua"]]
    });

    // Checkbox UI Logic
    function updateSelectionUi() {
        var pendingCheckboxes = table.$('.pending-logbook-checkbox');
        var selected = pendingCheckboxes.filter(':checked').length;
        
        if(selected > 0) {
            $('#selectedCountLabel').text(selected);
            $('#btnEApprove').fadeIn(200);
        } else {
            $('#btnEApprove').fadeOut(200);
        }
        
        // Update top select all state
        if (pendingCheckboxes.length > 0) {
            $('#selectAllTop').prop('checked', selected === pendingCheckboxes.length);
        }
    }

    // Handle individual check
    $('#tblLogbookDetail tbody').on('change', '.pending-logbook-checkbox', function() {
        updateSelectionUi();
    });

    // Handle select all
    $('#selectAllTop').on('change', function() {
        var isChecked = $(this).is(':checked');
        table.$('.pending-logbook-checkbox').prop('checked', isChecked);
        updateSelectionUi();
    });

    // Form Bulk Submit
    $('#formBulkApproveLogbook').on('submit', function(e) {
        e.preventDefault();
        
        var form = this;
        var selectedIds = [];
        table.$('.pending-logbook-checkbox:checked').each(function(){
            selectedIds.push($(this).val());
            if(!$.contains(document, this)){
                $(form).append($('<input>').attr('type', 'hidden').attr('name', this.name).val(this.value));
            } 
        });

        if (selectedIds.length === 0) {
            Swal.fire('Perhatian!', 'Pilih minimal satu logbook sebelum melakukan persetujuan massal.', 'warning');
            return;
        }

        Swal.fire({
            title: 'Konfirmasi Persetujuan',
            text: 'Apakah Anda yakin ingin menyetujui ' + selectedIds.length + ' logbook sekaligus?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Setujui',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#10b981',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: $(form).attr('action'),
                    type: 'POST',
                    data: $(form).serialize(),
                    dataType: 'json',
                    success: function(res) {
                        if (res.success) {
                            Swal.fire('Berhasil!', res.message, 'success').then(() => {
                                $('#btnKembaliList').click();
                                setTimeout(() => { $('.btn-lihat-logbook[data-id="'+$('#id_penempatan_magang').val()+'"]').click(); }, 500);
                            });
                        } else {
                            Swal.fire('Gagal!', res.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan sistem.', 'error');
                    }
                });
            }
        });
    });

    // Setuju Logbook Individual
    $('#tblLogbookDetail tbody').on('click', '.btn-setuju-logbook', function() {
        var id_logbook = $(this).data('id');
        var id_penempatan = $('#id_penempatan_magang').val();

        Swal.fire({
            title: 'Konfirmasi Persetujuan',
            text: 'Apakah Anda yakin ingin menyetujui logbook ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Setujui',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#10b981',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('kabid/logbook/approve') ?>',
                    type: 'POST',
                    data: {
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>',
                        id_logbook_magang: id_logbook,
                        id_penempatan_magang: id_penempatan
                    },
                    dataType: 'json',
                    success: function(res) {
                        if (res.success) {
                            Swal.fire('Berhasil!', res.message, 'success').then(() => {
                                $('#btnKembaliList').click();
                                setTimeout(() => { $('.btn-lihat-logbook[data-id="'+id_penempatan+'"]').click(); }, 500);
                            });
                        } else {
                            Swal.fire('Gagal!', res.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan sistem.', 'error');
                    }
                });
            }
        });
    });

    // Tolak Logbook Individual
    $('#tblLogbookDetail tbody').on('click', '.btn-tolak-logbook', function() {
        var id_logbook = $(this).data('id');
        var id_penempatan = $('#id_penempatan_magang').val();

        Swal.fire({
            title: 'Tolak Logbook',
            text: 'Silakan masukkan alasan penolakan / catatan revisi untuk pemohon:',
            input: 'textarea',
            inputPlaceholder: 'Contoh: Bukti kegiatan kurang jelas atau tidak relevan...',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Tolak Logbook',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc2626',
            reverseButtons: true,
            inputValidator: (value) => {
                if (!value || value.trim() === '') {
                    return 'Catatan revisi wajib diisi!'
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                var catatan = result.value;
                $.ajax({
                    url: '<?= base_url('kabid/logbook/reject') ?>',
                    type: 'POST',
                    data: {
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>',
                        id_logbook_magang: id_logbook,
                        id_penempatan_magang: id_penempatan,
                        catatan_revisi: catatan
                    },
                    dataType: 'json',
                    success: function(res) {
                        if (res.success) {
                            Swal.fire('Ditolak!', res.message, 'success').then(() => {
                                $('#btnKembaliList').click();
                                setTimeout(() => { $('.btn-lihat-logbook[data-id="'+id_penempatan+'"]').click(); }, 500);
                            });
                        } else {
                            Swal.fire('Gagal!', res.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan sistem.', 'error');
                    }
                });
            }
        });
    });
});
</script>
