<?= $this->extend('layout/L_master_kabid') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Custom Styles for Dashboard -->
<style>
    .dashboard-header-title { font-weight: 800; color: #0F172A; font-size: 1.8rem; letter-spacing: -0.5px; }
    .dashboard-subtitle { font-weight: 600; color: #64748B; font-size: 0.85rem; letter-spacing: 1px; text-transform: uppercase; }
    .stat-card { border-radius: 12px; border: 1px solid #E2E8F0; transition: transform 0.2s; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
    .stat-card:hover { transform: translateY(-3px); }
    .stat-title { color: #64748B; font-size: 0.9rem; font-weight: 600; }
    .stat-number { color: #0F172A; font-size: 2rem; font-weight: 800; line-height: 1.2; }
    .stat-desc { color: #94A3B8; font-size: 0.8rem; }
    .card-title-custom { font-weight: 700; color: #1E293B; font-size: 1rem; }
    .table-custom th { text-transform: uppercase; font-size: 0.75rem; font-weight: 700; color: #64748B; letter-spacing: 0.5px; border-bottom: 1px solid #E2E8F0; padding: 1rem; }
    .table-custom td { padding: 1rem; vertical-align: middle; border-bottom: 1px solid #F1F5F9; color: #334155; font-size: 0.9rem; font-weight: 500; }
</style>

<!-- Header Area -->
<div class="d-flex justify-content-between align-items-end mb-4">
    <div>
        <div class="dashboard-subtitle mb-1">Akses Kepala Bidang</div>
        <h1 class="dashboard-header-title mb-0">Selamat Datang, <?= esc($bidang_info->bidang ?? 'TIK') ?></h1>
    </div>
    <div class="d-flex" style="gap: 10px;">
        <button class="btn btn-outline-secondary bg-white font-weight-bold" style="border-radius: 8px; border-color: #CBD5E1;">
            <i class="far fa-calendar-alt mr-2"></i> <?= $tanggal_formatted ?>
        </button>
        <a href="<?= base_url('kabid/disposisi') ?>" class="btn btn-primary font-weight-bold" style="border-radius: 8px; background-color: #1E40AF; border-color: #1E40AF;">
            <i class="fas fa-arrow-right mr-2"></i> Buka Disposisi
        </a>
    </div>
</div>

<!-- 4 Stat Cards -->
<div class="row mb-4">
    <!-- Menunggu Persetujuan -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card h-100 bg-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="rounded p-2" style="background-color: #FEF3C7; color: #D97706;">
                        <i class="fas fa-clipboard-list fa-lg"></i>
                    </div>
                    <?php if($total_menunggu > 0): ?>
                    <span class="badge badge-warning text-dark" style="background-color: #FDE68A; padding: 0.4rem 0.6rem;">+<?= $total_menunggu ?> Baru</span>
                    <?php endif; ?>
                </div>
                <div class="stat-title mt-3">Menunggu Persetujuan</div>
                <div class="d-flex align-items-baseline" style="gap: 8px;">
                    <div class="stat-number"><?= $total_menunggu ?></div>
                    <div class="stat-desc">Disposisi masuk</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mahasiswa Aktif -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card h-100 bg-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="rounded p-2" style="background-color: #DBEAFE; color: #2563EB;">
                        <i class="fas fa-user-graduate fa-lg"></i>
                    </div>
                    <span class="badge badge-primary bg-light text-primary border border-primary" style="padding: 0.4rem 0.6rem;">Total Aktif</span>
                </div>
                <div class="stat-title mt-3">Mahasiswa Aktif</div>
                <div class="d-flex align-items-baseline" style="gap: 8px;">
                    <div class="stat-number"><?= $total_berjalan ?></div>
                    <div class="stat-desc">Sedang berjalan</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sisa Kuota -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card h-100 bg-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="rounded p-2" style="background-color: #DCFCE7; color: #16A34A;">
                        <i class="fas fa-chair fa-lg"></i>
                    </div>
                </div>
                <div class="stat-title mt-3">Sisa Kuota Bidang</div>
                <div class="d-flex align-items-baseline" style="gap: 8px;">
                    <div class="stat-number"><?= $sisa_kuota ?></div>
                    <div class="stat-desc">Posisi tersisa</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Selesai Magang -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card h-100 text-white" style="background: linear-gradient(135deg, #1E3A8A 0%, #3B82F6 100%); border: none;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="rounded p-2" style="background-color: rgba(255,255,255,0.2);">
                        <i class="fas fa-check-circle fa-lg text-white"></i>
                    </div>
                    <span class="badge" style="background-color: rgba(255,255,255,0.2); color: white; padding: 0.4rem 0.6rem;">Total Historis</span>
                </div>
                <div class="stat-title mt-3 text-white" style="opacity: 0.9;">Telah Selesai Magang</div>
                <div class="d-flex align-items-baseline" style="gap: 8px;">
                    <div class="stat-number text-white"><?= $total_selesai ?></div>
                    <div class="stat-desc text-white" style="opacity: 0.8;">Alumni bidang</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="row">
    <!-- Left Column (Permohonan Terbaru) -->
    <div class="col-xl-8 col-lg-7 mb-4">
        <div class="card shadow-sm border-0 h-100" style="border-radius: 12px;">
            <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between" style="border-bottom: 1px solid #F1F5F9; border-radius: 12px 12px 0 0;">
                <h6 class="m-0 card-title-custom">Permohonan Terbaru Masuk</h6>
                <a href="<?= base_url('kabid/disposisi') ?>" class="text-primary font-weight-bold" style="font-size: 0.85rem; text-decoration: none;">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom table-hover mb-0" width="100%" cellspacing="0">
                        <thead style="background-color: #F8FAFC;">
                            <tr>
                                <th>PEMOHON</th>
                                <th>INSTITUSI</th>
                                <th>LAYANAN</th>
                                <th>STATUS</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($penempatan_menunggu)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">Belum ada permohonan baru yang masuk.</td>
                            </tr>
                            <?php else: ?>
                                <?php foreach ($penempatan_menunggu as $row): 
                                    $nameParts = explode(' ', trim($row->nama_mahasiswa));
                                    $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
                                ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" 
                                                 style="width: 36px; height: 36px; background-color: #F1F5F9; color: #475569; font-weight: 600; font-size: 0.85rem;">
                                                <?= $initials ?>
                                            </div>
                                            <div>
                                                <div style="font-weight: 600; color: #0F172A;"><?= esc($row->nama_mahasiswa) ?></div>
                                                <div style="font-size: 0.75rem; color: #94A3B8;"><?= esc($row->nim) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= esc($row->instansi_pendidikan ?? '-') ?></td>
                                    <td><?= esc($row->jenis_permohonan ?? '-') ?></td>
                                    <td>
                                        <span class="badge" style="background-color: #FEF3C7; color: #D97706; padding: 0.4rem 0.6rem; border-radius: 4px;">
                                            MENUNGGU
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('kabid/disposisi') ?>" class="btn btn-link btn-sm" style="color: #0F172A;">
                                            <i class="far fa-eye"></i>
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
    </div>

    <!-- Right Column (Logbook & Aktivitas) -->
    <div class="col-xl-4 col-lg-5 mb-4">
        <!-- Logbook Menunggu Approval -->
        <div class="card shadow-sm border-0 h-100" style="border-radius: 12px;">
            <div class="card-header bg-white py-3" style="border-bottom: 1px solid #F1F5F9; border-radius: 12px 12px 0 0;">
                <h6 class="m-0 card-title-custom">Persetujuan Logbook</h6>
            </div>
            <div class="card-body p-0">
                <?php if(empty($logbook_list)): ?>
                    <div class="text-center p-5">
                        <div class="text-muted mb-2"><i class="fas fa-check-circle fa-3x text-success" style="opacity: 0.2;"></i></div>
                        <div style="color: #0F172A; font-weight: 600; margin-top: 15px;">Semua Bersih!</div>
                        <span class="text-muted" style="font-size: 0.85rem;">Tidak ada logbook harian yang menunggu persetujuan Anda.</span>
                    </div>
                <?php else: ?>
                    <ul class="list-group list-group-flush" style="border-radius: 0 0 12px 12px;">
                        <?php foreach($logbook_list as $log): ?>
                        <li class="list-group-item px-3 py-3 border-bottom-0" style="border-bottom: 1px solid #F1F5F9 !important;">
                            <div class="d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span style="font-weight: 600; font-size: 0.9rem; color: #0F172A;"><?= esc($log->nama_mahasiswa) ?></span>
                                    <span style="font-size: 0.75rem; font-weight: 600; color: #1E40AF; background-color: #DBEAFE; padding: 2px 6px; border-radius: 4px;">
                                        <?= date('d M Y', strtotime($log->tgl_logbook)) ?>
                                    </span>
                                </div>
                                <div class="text-truncate mb-2" style="font-size: 0.85rem; color: #64748B; max-width: 250px;">
                                    <?= esc(strip_tags($log->logbook_magang)) ?>
                                </div>
                                <div>
                                    <a href="<?= base_url('kabid/logbook') ?>" class="btn btn-sm" style="font-size: 0.75rem; padding: 0.3rem 0.6rem; border-radius: 4px; background-color: #F1F5F9; color: #0F172A; font-weight: 600;">
                                        Tinjau Logbook
                                    </a>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            <?php if(!empty($logbook_list)): ?>
            <div class="card-footer bg-white text-center py-3" style="border-top: 1px solid #F1F5F9; border-radius: 0 0 12px 12px;">
                <a href="<?= base_url('kabid/logbook') ?>" class="text-primary font-weight-bold" style="font-size: 0.85rem; text-decoration: none;">Kelola Semua Logbook</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
