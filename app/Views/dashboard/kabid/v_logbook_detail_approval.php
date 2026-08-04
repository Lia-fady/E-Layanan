<?= $this->extend('layout/L_master_kabid') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail & Approval Logbook</h1>
    <a href="<?= base_url('kabid/logbook') ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Kembali
    </a>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php
    $pendingCount = 0;
    $approvedCount = 0;
    if (!empty($logbooks)) {
        foreach ($logbooks as $log) {
            if (!$log['disetujui_oleh']) $pendingCount++;
            else $approvedCount++;
        }
    }
    $totalCount = $pendingCount + $approvedCount;
    $progressPercent = $totalCount > 0 ? round(($approvedCount / $totalCount) * 100) : 0;
    $nameParts = explode(' ', trim($mahasiswa->nama_mahasiswa));
    $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
?>

<!-- Profil Mahasiswa -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Profil Mahasiswa</h6>
    </div>
    <div class="card-body">
        <div class="row align-items-center">
            <!-- Avatar -->
            <div class="col-md-2 text-center mb-3 mb-md-0">
                <div style="width:100px;height:100px;border-radius:50%;background:#4e73df;color:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:2.5rem;font-weight:bold;">
                    <?php if(!empty($mahasiswa->foto_profil)): ?>
                        <img src="<?= base_url('uploads/profil/' . $mahasiswa->foto_profil) ?>" style="width:100%;height:100%;border-radius:50%;object-fit:cover;">
                    <?php else: ?>
                        <?= $initials ?>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Info Akademik -->
            <div class="col-md-5 mb-3 mb-md-0">
                <h5 class="font-weight-bold text-gray-900 mb-1"><?= esc($mahasiswa->nama_mahasiswa) ?></h5>
                <p class="text-muted mb-2"><i class="fas fa-id-card fa-fw mr-1"></i> <?= esc($mahasiswa->nim) ?></p>
                <div class="mb-1"><i class="fas fa-university fa-fw mr-1 text-gray-500"></i> <?= esc($mahasiswa->instansi_pendidikan) ?></div>
                <div class="mb-1"><i class="fas fa-graduation-cap fa-fw mr-1 text-gray-500"></i> <?= esc($mahasiswa->prodi) ?></div>
                <div class="mb-1"><i class="fas fa-map-marker-alt fa-fw mr-1 text-gray-500"></i> <?= esc($mahasiswa->bidang ?? '-') ?></div>
            </div>
            
            <!-- Info Kontak & Status -->
            <div class="col-md-5">
                <div class="mb-1"><i class="fas fa-venus-mars fa-fw mr-1 text-gray-500"></i> <?= $mahasiswa->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' ?></div>
                <div class="mb-1"><i class="fas fa-phone fa-fw mr-1 text-gray-500"></i> <?= esc($mahasiswa->no_telp ?? '-') ?></div>
                <div class="mb-2"><i class="fas fa-envelope fa-fw mr-1 text-gray-500"></i> <?= esc($mahasiswa->email ?? '-') ?></div>
                <hr>
                <div class="d-flex justify-content-between text-sm">
                    <span class="font-weight-bold text-gray-700">Periode Magang:</span>
                    <span class="text-primary font-weight-bold">
                        <?= date('d M Y', strtotime($mahasiswa->tgl_mulai)) ?> - <?= date('d M Y', strtotime($mahasiswa->tgl_selesai)) ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistik & Timeline -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Riwayat Aktivitas Harian</h6>
                <div>
                    <span class="badge badge-success px-2 py-1 mr-2"><i class="fas fa-check mr-1"></i><?= $approvedCount ?> Disetujui</span>
                    <span class="badge badge-warning px-2 py-1 mr-3"><i class="fas fa-clock mr-1"></i><?= $pendingCount ?> Menunggu</span>
                    <?php if($pendingCount > 0): ?>
                        <form action="<?= base_url('kabid/logbook/bulkApprove') ?>" method="POST" class="d-inline">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id_penempatan_magang" value="<?= $mahasiswa->id_penempatan_magang ?>">
                            <button type="submit" class="btn btn-sm btn-success shadow-sm" onclick="return confirm('Setujui semua <?= $pendingCount ?> catatan tertunda?')">
                                <i class="fas fa-check-double mr-1"></i> Setujui Semua
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="card-body">
                <?php if (empty($logbooks)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-book-open fa-3x text-gray-300 mb-3"></i>
                        <p class="text-gray-500 mb-0">Belum ada catatan aktivitas harian.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead class="bg-light">
                                <tr>
                                    <th width="15%">Tanggal</th>
                                    <th>Aktivitas</th>
                                    <th width="15%" class="text-center">Status</th>
                                    <th width="10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($logbooks as $log): 
                                    $isApproved = $log['disetujui_oleh'] ? true : false;
                                ?>
                                    <tr>
                                        <td class="align-middle">
                                            <strong><?= date('d M Y', strtotime($log['tgl_logbook'])) ?></strong><br>
                                            <small class="text-muted"><?= date('l', strtotime($log['tgl_logbook'])) ?></small>
                                        </td>
                                        <td class="align-middle">
                                            <?= nl2br(esc($log['logbook_magang'])) ?>
                                        </td>
                                        <td class="align-middle text-center">
                                            <?php if ($isApproved): ?>
                                                <span class="badge badge-success"><i class="fas fa-check mr-1"></i> Disetujui</span>
                                                <br>
                                                <small class="text-muted"><?= date('d/m/Y H:i', strtotime($log['tgl_disetujui'])) ?></small>
                                            <?php else: ?>
                                                <span class="badge badge-warning"><i class="fas fa-clock mr-1"></i> Menunggu</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="align-middle text-center">
                                            <?php if (!$isApproved): ?>
                                                <form action="<?= base_url('kabid/logbook/approve') ?>" method="post">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="id_logbook_magang" value="<?= $log['id_logbook_magang'] ?>">
                                                    <input type="hidden" name="id_penempatan_magang" value="<?= $mahasiswa->id_penempatan_magang ?>">
                                                    <button type="submit" class="btn btn-sm btn-success" title="Approve" onclick="return confirm('Setujui aktivitas ini?')">
                                                        <i class="fas fa-check"></i> Approve
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

