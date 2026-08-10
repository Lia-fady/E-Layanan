<style>
    .profile-card {
        border-radius: 18px;
        border: 1px solid #E2E8F0;
        background: linear-gradient(145deg, #ffffff, #f8fafc);
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
    }
    .profile-avatar-wrapper {
        width: 104px;
        height: 104px;
        border-radius: 50%;
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1d4ed8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.4rem;
        font-weight: 700;
        margin: 0 auto;
        border: 4px solid #fff;
        box-shadow: 0 12px 24px rgba(37, 99, 235, 0.15);
        overflow: hidden;
    }
    .info-label {
        font-size: 0.75rem;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        font-weight: 700;
        margin-bottom: 4px;
    }
    .info-value {
        font-size: 0.95rem;
        color: #0f172a;
        font-weight: 600;
        line-height: 1.5;
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        padding: 6px 10px;
        font-size: 0.76rem;
        font-weight: 700;
        letter-spacing: 0.02em;
    }
    .status-badge.running {
        background: #e0f2fe;
        color: #0369a1;
    }
    .status-badge.done {
        background: #dcfce7;
        color: #15803d;
    }
    .timeline-shell {
        border-radius: 18px;
        border: 1px solid #E2E8F0;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }
    .approval-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .approval-table thead th {
        background: #f8fafc;
        color: #334155;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        border-bottom: 1px solid #e2e8f0;
        padding: 12px 14px;
    }
    .approval-table tbody td {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: top;
        font-size: 0.92rem;
        color: #334155;
    }
    .approval-table tbody tr:hover {
        background: #f8fafc;
    }
    .table-status-approved {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 10px;
        border-radius: 999px;
        background: #ecfdf5;
        color: #15803d;
        font-size: 0.76rem;
        font-weight: 700;
    }
    .table-status-pending {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 10px;
        border-radius: 999px;
        background: #fff7ed;
        color: #c2410c;
        font-size: 0.76rem;
        font-weight: 700;
    }
    .table-status-rejected {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 10px;
        border-radius: 999px;
        background: #fef2f2;
        color: #dc2626;
        font-size: 0.76rem;
        font-weight: 700;
    }
    .activity-text {
        white-space: pre-line;
        line-height: 1.65;
    }
    .approval-checkbox-cell {
        min-width: 90px;
        width: 90px;
        text-align: center;
        vertical-align: middle;
    }
    .approval-checkbox-cell input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #2563eb;
        margin: 0;
    }
    .approval-checkbox-cell .text-muted.small {
        display: inline-block;
        min-width: 18px;
    }
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 10px;
        border-radius: 999px;
        font-size: 0.76rem;
        font-weight: 700;
    }
    .status-pill.approved {
        background: #ecfdf5;
        color: #15803d;
    }
    .status-pill.pending {
        background: #fff7ed;
        color: #c2410c;
    }
    .status-pill.rejected {
        background: #fef2f2;
        color: #dc2626;
    }
    .approval-checkbox {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8rem;
        color: #475569;
        font-weight: 600;
    }
    .selection-toolbar {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 14px;
        background: #f8fafc;
        margin-bottom: 16px;
    }
    .selection-count {
        font-size: 0.9rem;
        color: #334155;
        font-weight: 700;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 style="font-weight:700; color:#1B2559; margin-bottom:4px;">Detail & Approval Logbook</h5>
        <p style="color:#64748B; font-size:0.9rem; margin:0;">
            Review aktivitas harian dan berikan persetujuan untuk mahasiswa.
        </p>
    </div>
    <button type="button" id="btnKembaliList" class="btn btn-light border shadow-sm" style="border-radius: 8px; font-weight: 600; color: #475569;">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </button>
</div>



<div class="mb-4">
    <div class="card profile-card p-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
            <div>
                <h6 class="m-0 font-weight-bold" style="color: #1E293B; font-size: 1.08rem;">Data Mahasiswa</h6>
                <p class="text-muted mb-0" style="font-size: 0.85rem;">Informasi lengkap mahasiswa yang sedang ditinjau.</p>
            </div>
            <div class="mt-2 mt-md-0">
                <?php if (($mahasiswa->status_penempatan ?? '') == 'SELESAI') : ?>
                    <span class="status-badge done"><i class="fas fa-check-circle"></i> Selesai</span>
                <?php else : ?>
                    <span class="status-badge running"><i class="fas fa-play-circle"></i> Berjalan</span>
                <?php endif; ?>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 text-center mb-4 mb-lg-0">
                <?php
                    $nameParts = explode(' ', trim($mahasiswa->nama_mahasiswa));
                    $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
                ?>
                <div class="profile-avatar-wrapper mb-3">
                    <?php if (!empty($mahasiswa->foto_profil)) : ?>
                        <img src="<?= base_url('uploads/profil/' . $mahasiswa->foto_profil) ?>" style="width:104px;height:104px;object-fit:cover;">
                    <?php else : ?>
                        <?= $initials ?>
                    <?php endif; ?>
                </div>
                <h5 class="font-weight-bold text-dark mb-1"><?= esc($mahasiswa->nama_mahasiswa) ?></h5>
                <span class="badge" style="background-color: #E2E8F0; color: #475569; padding: 6px 10px; border-radius: 8px;">
                    <i class="fas fa-id-card mr-1"></i> <?= esc($mahasiswa->nim) ?>
                </span>
            </div>

            <div class="col-lg-9 col-md-8">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="info-label"><i class="fas fa-university mr-1"></i> Perguruan Tinggi</div>
                        <div class="info-value"><?= esc($mahasiswa->instansi_pendidikan) ?></div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="info-label"><i class="fas fa-graduation-cap mr-1"></i> Program Studi</div>
                        <div class="info-value"><?= esc($mahasiswa->prodi) ?></div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="info-label"><i class="fas fa-venus-mars mr-1"></i> Jenis Kelamin</div>
                        <div class="info-value"><?= $mahasiswa->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' ?></div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="info-label"><i class="fas fa-phone mr-1"></i> Nomor Telepon</div>
                        <div class="info-value"><?= esc($mahasiswa->no_telp ?? '-') ?></div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="info-label"><i class="fas fa-envelope mr-1"></i> Email</div>
                        <div class="info-value"><?= esc($mahasiswa->email ?? '-') ?></div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="info-label"><i class="fas fa-calendar-alt mr-1"></i> Periode Magang</div>
                        <div class="info-value text-primary">
                            <?= date('d M Y', strtotime($mahasiswa->tgl_mulai)) ?> <i class="fas fa-arrow-right mx-1" style="font-size:0.8rem;"></i> <?= date('d M Y', strtotime($mahasiswa->tgl_selesai)) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mb-4">
    <div class="card timeline-shell h-100">
        <?php
            $pendingCount = 0;
            $approvedCount = 0;
            $rejectedCount = 0;
            if (!empty($logbooks)) {
                foreach ($logbooks as $log) {
                    $status = strtolower((string) ($log['status_logbook'] ?? ''));
                    if ($status === 'ditolak') {
                        $rejectedCount++;
                    } elseif (!empty($log['disetujui_oleh']) || $status === 'disetujui') {
                        $approvedCount++;
                    } else {
                        $pendingCount++;
                    }
                }
            }
        ?>
        <div class="card-header bg-white py-4 px-4 d-flex flex-wrap align-items-center justify-content-between" style="border-bottom: 1px solid #E2E8F0;">
            <div>
                <h6 class="m-0 font-weight-bold" style="color: #1E293B; font-size: 1.08rem;">Riwayat Aktivitas Harian</h6>
                <div class="mt-1" style="font-size: 0.84rem;">
                    <span class="status-pill approved"><i class="fas fa-check-circle"></i> <?= $approvedCount ?> Disetujui</span>
                    <span class="status-pill pending ml-2"><i class="fas fa-clock"></i> <?= $pendingCount ?> Menunggu</span>
                    <span class="status-pill rejected ml-2"><i class="fas fa-times-circle"></i> <?= $rejectedCount ?> Ditolak</span>
                </div>
            </div>

        </div>
        <div class="card-body p-4" style="max-height: 700px; overflow-y: auto;">
            <form id="formBulkApproveLogbook" action="<?= base_url('kabid/logbook/bulkApprove') ?>" method="POST" class="m-0 p-0">
                <?= csrf_field() ?>
                <input type="hidden" name="id_penempatan_magang" value="<?= $mahasiswa->id_penempatan_magang ?>">
                <div class="selection-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <?php if ($pendingCount > 0) : ?>
                            <label class="approval-checkbox mb-0">
                                <input type="checkbox" class="select-all-pending" id="selectAllPending">
                                <span>Pilih Semua</span>
                            </label>
                        <?php endif; ?>
                        <span id="selectedCountLabel" class="selection-count">0 Logbook Dipilih</span>
                    </div>
                    <button type="submit" id="btnEApprove" class="btn btn-success shadow-sm" style="border-radius: 8px; font-weight: 600; display: none;">
                        <i class="fas fa-check-double mr-1"></i> setujui
                    </button>
                </div>

                <?php if (empty($logbooks)) : ?>
                    <div class="text-center py-5">
                        <img src="<?= base_url('img/undraw_empty.svg') ?>" alt="Empty" style="width: 150px; opacity: 0.5;" class="mb-3">
                        <h6 class="text-muted font-weight-bold">Belum ada catatan aktivitas harian.</h6>
                        <p class="text-muted small">Mahasiswa belum mengisi logbook.</p>
                    </div>
                <?php else : ?>
                    <div class="table-responsive mt-2">
                        <table class="approval-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Aktivitas/Kegiatan</th>
                                    <th>Status</th>
                                    <th>
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <span>Pilih</span>
                                            <?php if ($pendingCount > 0) : ?>
                                                <input type="checkbox" class="select-all-pending" id="selectAllPendingHeader" title="Pilih Semua">
                                            <?php endif; ?>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $idx = 1; foreach ($logbooks as $log) :
                                    $status = strtolower((string) ($log['status_logbook'] ?? ''));
                                    if ($status === 'ditolak') {
                                        $variant = 'rejected';
                                        $statusLabel = 'Ditolak';
                                        $statusClass = 'table-status-rejected';
                                        $icon = 'times-circle';
                                    } elseif (!empty($log['disetujui_oleh']) || $status === 'disetujui') {
                                        $variant = 'approved';
                                        $statusLabel = 'Disetujui';
                                        $statusClass = 'table-status-approved';
                                        $icon = 'check-circle';
                                    } else {
                                        $variant = 'pending';
                                        $statusLabel = 'Menunggu';
                                        $statusClass = 'table-status-pending';
                                        $icon = 'clock';
                                    }
                                ?>
                                    <tr>
                                        <td class="font-weight-bold text-muted"><?= $idx++ ?></td>
                                        <td>
                                            <div class="font-weight-bold text-dark">
                                                <i class="far fa-calendar-alt mr-1"></i> <?= date('d M Y', strtotime($log['tgl_logbook'])) ?>
                                            </div>
                                            <div class="small text-muted mt-1">
                                                <?= date('H:i', strtotime($log['tgl_logbook'])) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="activity-text"><?= nl2br(esc($log['logbook_magang'])) ?></div>
                                            <?php if (!empty($log['bukti_kegiatan'])) : ?>
                                                <div class="mt-2">
                                                    <a href="<?= base_url($log['bukti_kegiatan']) ?>" target="_blank" class="btn btn-sm btn-light border shadow-sm" style="border-radius: 8px; font-weight: 600; font-size: 0.8rem; color: #475569;">
                                                        <i class="fas fa-paperclip mr-1 text-primary"></i> Bukti Kegiatan
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="<?= $statusClass ?>">
                                                <i class="fas fa-<?= $icon ?>"></i> <?= $statusLabel ?>
                                            </span>
                                            <?php if ($variant === 'approved' && !empty($log['tgl_disetujui'])) : ?>
                                                <div class="mt-2 text-muted" style="font-size: 0.75rem;">
                                                    <i class="fas fa-signature mr-1"></i> <?= date('d M Y, H:i', strtotime($log['tgl_disetujui'])) ?>
                                                </div>
                                            <?php elseif ($variant === 'rejected' && !empty($log['catatan_revisi'])) : ?>
                                                <div class="mt-2 text-muted" style="font-size: 0.75rem;">
                                                    <i class="fas fa-comment-dots mr-1"></i> <?= esc($log['catatan_revisi']) ?>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="approval-checkbox-cell">
                                            <?php if ($variant === 'pending') : ?>
                                                <div class="d-flex justify-content-center align-items-center" style="min-height: 28px;">
                                                    <input type="checkbox" class="pending-logbook-checkbox" name="selected_ids[]" value="<?= $log['id_logbook_magang'] ?>">
                                                </div>
                                            <?php else : ?>
                                                <div class="d-flex justify-content-center align-items-center" style="min-height: 28px;">
                                                    <span class="text-muted small">—</span>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    function updateSelectionUi() {
        var pendingCheckboxes = $('.pending-logbook-checkbox');
        var selected = pendingCheckboxes.filter(':checked').length;
        $('#selectedCountLabel').text(selected + ' Logbook Dipilih');
        $('#btnEApprove').toggle(selected > 0);
        $('.select-all-pending').prop('checked', pendingCheckboxes.length > 0 && selected > 0 && selected === pendingCheckboxes.length);
    }

    $('.pending-logbook-checkbox').on('change', updateSelectionUi);
    $('.select-all-pending').on('change', function() {
        $('.pending-logbook-checkbox').prop('checked', $(this).is(':checked'));
        updateSelectionUi();
    });

    $('#formBulkApproveLogbook').on('submit', function(e) {
        e.preventDefault();
        var selectedIds = $('.pending-logbook-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) {
            Swal.fire('Perhatian!', 'Pilih minimal satu logbook sebelum melakukan e-Approve.', 'warning');
            return;
        }

        Swal.fire({
            title: 'Konfirmasi e-Approve',
            text: 'Apakah Anda yakin ingin menyetujui ' + selectedIds.length + ' logbook yang dipilih?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'e-Approve',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#10B981'
        }).then(function(result) {
            if (!result.isConfirmed) {
                return;
            }

            var form = $('#formBulkApproveLogbook');
            var btn = form.find('button[type="submit"]');
            var originalBtnHtml = btn.html();

            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Memproses...');

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: $.param({
                    id_penempatan_magang: form.find('input[name="id_penempatan_magang"]').val(),
                    selected_ids: selectedIds
                }),
                success: function(res) {
                    if (res.success) {
                        Swal.fire('Berhasil!', res.message, 'success').then(() => {
                            $('.btn-detail-logbook[data-id="<?= $mahasiswa->id_penempatan_magang ?>"]').click();
                        });
                    } else {
                        Swal.fire('Info!', res.message || 'Tidak ada logbook pending', 'info');
                        btn.prop('disabled', false).html(originalBtnHtml);
                    }
                },
                error: function() {
                    Swal.fire('Error!', 'Terjadi kesalahan sistem.', 'error');
                    btn.prop('disabled', false).html(originalBtnHtml);
                }
            });
        });
    });

    updateSelectionUi();
});
</script>
