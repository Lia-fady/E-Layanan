<style>
    /* Custom Styling for Logbook Approval */
    .profile-card {
        border-radius: 16px;
        border: 1px solid #E2E8F0;
        background: linear-gradient(145deg, #ffffff, #f8fafc);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    }
    .profile-avatar-wrapper {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background-color: #DBEAFE;
        color: #2563EB;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0 auto;
        border: 4px solid #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }
    .info-label {
        font-size: 0.8rem;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        margin-bottom: 2px;
    }
    .info-value {
        font-size: 0.95rem;
        color: #1E293B;
        font-weight: 500;
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        padding: 4px 10px;
        font-size: 0.74rem;
        font-weight: 700;
        letter-spacing: 0.2px;
    }
    .status-badge.running {
        background: #e0f2fe;
        color: #0369a1;
    }
    .status-badge.done {
        background: #dcfce7;
        color: #15803d;
    }
    .logbook-card {
        border-radius: 16px;
        border: 1px solid #E2E8F0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    .log-item {
        border-left: 3px solid #E2E8F0;
        padding-left: 20px;
        position: relative;
        margin-bottom: 25px;
    }
    .log-item::before {
        content: '';
        position: absolute;
        left: -8px;
        top: 0;
        width: 13px;
        height: 13px;
        border-radius: 50%;
        background-color: #CBD5E1;
        border: 2px solid #fff;
    }
    .log-item.approved {
        border-left-color: #10B981;
    }
    .log-item.approved::before {
        background-color: #10B981;
    }
    .log-item.pending {
        border-left-color: #F59E0B;
    }
    .log-item.pending::before {
        background-color: #F59E0B;
    }
    .log-date {
        font-size: 0.85rem;
        color: #64748B;
        font-weight: 600;
    }
    .log-content {
        background-color: #F8FAFC;
        border-radius: 12px;
        padding: 15px;
        margin-top: 8px;
        border: 1px solid #F1F5F9;
        font-size: 0.95rem;
        color: #334155;
        line-height: 1.6;
    }
</style>

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 style="font-weight:700; color:#1B2559; margin-bottom:4px;">Detail & Approval Logbook</h5>
        <p style="color:#64748B; font-size:0.9rem; margin:0;">
            Review aktivitas harian dan berikan persetujuan untuk mahasiswa.
        </p>
    </div>
    <button type="button" id="btnKembaliList" class="btn btn-light border shadow-sm" style="border-radius: 8px; font-weight: 500; color: #475569;">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </button>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px;">
        <i class="fas fa-check-circle mr-2"></i> <?= session()->getFlashdata('success'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px;">
        <i class="fas fa-exclamation-triangle mr-2"></i> <?= session()->getFlashdata('error'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<div class="row">
    <!-- Profil Mahasiswa Kiri -->
    <div class="col-xl-4 col-lg-5 mb-4">
        <div class="card profile-card h-100 p-4">
            <div class="text-center mb-4">
                <?php 
                    // Generate Initials
                    $nameParts = explode(' ', trim($mahasiswa->nama_mahasiswa));
                    $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
                ?>
                <div class="profile-avatar-wrapper mb-3">
                    <?php if(!empty($mahasiswa->foto_profil)): ?>
                        <img src="<?= base_url('uploads/profil/' . $mahasiswa->foto_profil) ?>" style="width:100px;height:100px;border-radius:50%;object-fit:cover;">
                    <?php else: ?>
                        <?= $initials ?>
                    <?php endif; ?>
                </div>
                <h5 class="font-weight-bold text-dark mb-1"><?= esc($mahasiswa->nama_mahasiswa) ?></h5>
                <span class="badge" style="background-color: #E2E8F0; color: #475569; padding: 5px 10px; border-radius: 6px;">
                    <i class="fas fa-id-card mr-1"></i> <?= esc($mahasiswa->nim) ?>
                </span>
            </div>

            <hr style="border-color: #E2E8F0;">

            <div class="row mb-3">
                <div class="col-12 mb-3">
                    <div class="info-label"><i class="fas fa-university mr-1"></i> Instansi Pendidikan</div>
                    <div class="info-value"><?= esc($mahasiswa->instansi_pendidikan) ?></div>
                </div>
                <div class="col-12 mb-3">
                    <div class="info-label"><i class="fas fa-graduation-cap mr-1"></i> Program Studi</div>
                    <div class="info-value"><?= esc($mahasiswa->prodi) ?></div>
                </div>
            </div>

            <hr style="border-color: #E2E8F0;">

            <div class="row">
                <div class="col-6 mb-3">
                    <div class="info-label"><i class="fas fa-venus-mars mr-1"></i> Kelamin</div>
                    <div class="info-value"><?= $mahasiswa->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' ?></div>
                </div>
                <div class="col-6 mb-3">
                    <div class="info-label"><i class="fas fa-phone mr-1"></i> Telepon</div>
                    <div class="info-value"><?= esc($mahasiswa->no_telp ?? '-') ?></div>
                </div>
                <div class="col-12 mb-3">
                    <div class="info-label"><i class="fas fa-envelope mr-1"></i> Email</div>
                    <div class="info-value"><?= esc($mahasiswa->email ?? '-') ?></div>
                </div>
                <div class="col-12 mb-3">
                    <div class="info-label"><i class="fas fa-calendar-alt mr-1"></i> Periode Kegiatan</div>
                    <div class="info-value text-primary font-weight-bold">
                        <?= date('d M Y', strtotime($mahasiswa->tgl_mulai)) ?> <i class="fas fa-arrow-right mx-1" style="font-size:0.8rem;"></i> <?= date('d M Y', strtotime($mahasiswa->tgl_selesai)) ?>
                    </div>
                </div>
                <div class="col-12">
                    <div class="info-label"><i class="fas fa-flag mr-1"></i> Status Penempatan</div>
                    <div class="mt-1">
                        <?php if (($mahasiswa->status_penempatan ?? '') == 'SELESAI'): ?>
                            <span class="status-badge done"><i class="fas fa-check-circle"></i> Selesai</span>
                        <?php else: ?>
                            <span class="status-badge running"><i class="fas fa-play-circle"></i> Berjalan</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline Logbook Kanan -->
    <div class="col-xl-8 col-lg-7 mb-4">
        <div class="card logbook-card h-100 p-0">
            <?php 
                $pendingCount = 0;
                $approvedCount = 0;
                if (!empty($logbooks)) {
                    foreach ($logbooks as $log) {
                        if (!$log['disetujui_oleh']) $pendingCount++;
                        else $approvedCount++;
                    }
                }
            ?>
            <div class="card-header bg-white py-4 px-4 d-flex flex-row align-items-center justify-content-between" style="border-bottom: 1px solid #E2E8F0; border-radius: 16px 16px 0 0;">
                <div>
                    <h6 class="m-0 font-weight-bold" style="color: #1E293B; font-size: 1.1rem;">Riwayat Aktivitas Harian</h6>
                    <div class="mt-1" style="font-size: 0.85rem;">
                        <span class="text-success font-weight-bold"><i class="fas fa-check-circle mr-1"></i> <?= $approvedCount ?> Disetujui</span>
                        <span class="mx-2 text-muted">|</span>
                        <span class="text-warning font-weight-bold"><i class="fas fa-clock mr-1"></i> <?= $pendingCount ?> Menunggu</span>
                    </div>
                </div>
                
                <?php if($pendingCount > 0): ?>
                <form id="formBulkApproveLogbook" action="<?= base_url('kabid/logbook/bulkApprove') ?>" method="POST" class="m-0 p-0">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_penempatan_magang" value="<?= $mahasiswa->id_penempatan_magang ?>">
                    <button type="submit" class="btn btn-success shadow-sm" style="border-radius: 8px; font-weight: 500;">
                        <i class="fas fa-check-double mr-1"></i> Setujui Semua
                    </button>
                </form>
                <?php endif; ?>
            </div>
            <div class="card-body p-4" style="max-height: 700px; overflow-y: auto;">
                
                <?php if (empty($logbooks)): ?>
                    <div class="text-center py-5">
                        <img src="<?= base_url('img/undraw_empty.svg') ?>" alt="Empty" style="width: 150px; opacity: 0.5;" class="mb-3">
                        <h6 class="text-muted font-weight-bold">Belum ada catatan aktivitas harian.</h6>
                        <p class="text-muted small">Mahasiswa belum mengisi logbook.</p>
                    </div>
                <?php else: ?>
                    <div class="timeline-container pl-2 mt-2">
                        <?php foreach ($logbooks as $log): 
                            $isApproved = $log['disetujui_oleh'] ? true : false;
                        ?>
                            <div class="log-item <?= $isApproved ? 'approved' : 'pending' ?>">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="log-date">
                                        <i class="far fa-calendar-alt mr-1"></i> <?= date('l, d F Y', strtotime($log['tgl_logbook'])) ?>
                                    </div>
                                    <div>
                                        <?php if ($isApproved): ?>
                                            <span class="badge" style="background-color: #ECFDF5; color: #10B981; border: 1px solid #A7F3D0; border-radius: 6px; padding: 4px 8px;">
                                                <i class="fas fa-check mr-1"></i> Disetujui
                                            </span>
                                        <?php else: ?>
                                            <form action="<?= base_url('kabid/logbook/approve') ?>" method="post" class="d-inline formApproveLogbook">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="id_logbook_magang" value="<?= $log['id_logbook_magang'] ?>">
                                                <input type="hidden" name="id_penempatan_magang" value="<?= $mahasiswa->id_penempatan_magang ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-warning" style="border-radius: 6px; font-weight: 500; font-size: 0.8rem;" title="Setujui Logbook ini saja">
                                                    <i class="fas fa-check mr-1"></i> Approve
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="log-content">
                                    <?= nl2br(esc($log['logbook_magang'])) ?>
                                </div>
                                
                                <?php if (!empty($log['bukti_kegiatan'])): ?>
                                <div class="mt-3">
                                    <a href="<?= base_url($log['bukti_kegiatan']) ?>" target="_blank" class="btn btn-sm btn-light border shadow-sm" style="border-radius: 6px; font-weight: 500; font-size: 0.8rem; color: #475569;">
                                        <i class="fas fa-paperclip mr-1 text-primary"></i> Lihat Bukti Kegiatan
                                    </a>
                                </div>
                                <?php endif; ?>
                                
                                <?php if ($isApproved): ?>
                                    <div class="mt-2 text-muted" style="font-size: 0.75rem;">
                                        <i class="fas fa-signature mr-1"></i> Disetujui pada: <?= date('d M Y, H:i', strtotime($log['tgl_disetujui'])) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Tangani Submit Form Approve via AJAX
    $('.formApproveLogbook').on('submit', function(e) {
        e.preventDefault();
        if(!confirm('Anda yakin ingin menyetujui aktivitas ini?')) return;
        
        var form = $(this);
        var btn = form.find('button[type="submit"]');
        var originalBtnHtml = btn.html();
        
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            success: function(res) {
                if(res.success) {
                    Swal.fire('Berhasil!', res.message, 'success').then(() => {
                        // Refresh detail view
                        $('.btn-detail-logbook[data-id="<?= $mahasiswa->id_penempatan_magang ?>"]').click();
                    });
                } else {
                    Swal.fire('Gagal!', res.message || 'Terjadi kesalahan', 'error');
                    btn.prop('disabled', false).html(originalBtnHtml);
                }
            },
            error: function() {
                Swal.fire('Error!', 'Terjadi kesalahan sistem.', 'error');
                btn.prop('disabled', false).html(originalBtnHtml);
            }
        });
    });

    // Tangani Submit Form Bulk Approve via AJAX
    $('#formBulkApproveLogbook').on('submit', function(e) {
        e.preventDefault();
        if(!confirm('Anda yakin ingin menyetujui semua catatan yang tertunda sekaligus?')) return;
        
        var form = $(this);
        var btn = form.find('button[type="submit"]');
        var originalBtnHtml = btn.html();
        
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Memproses...');
        
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            success: function(res) {
                if(res.success) {
                    Swal.fire('Berhasil!', res.message, 'success').then(() => {
                        // Refresh detail view
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
</script>
