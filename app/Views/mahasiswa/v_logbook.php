<?= $this->extend('layout/L_mahasiswa') ?>

<?= $this->section('extra_css') ?>
<style>
    /* --- CARD FLAT FORM & TIMELINE --- */
    .card-flat {
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.03);
        border-radius: 12px;
        padding: 28px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.01);
    }

    .section-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--primary-navy);
        padding-bottom: 10px;
        border-bottom: 1px solid #edf2f7;
        margin-bottom: 20px;
    }

    /* --- INPUT COMPONENT STYLING --- */
    .form-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        color: var(--text-muted);
        margin-bottom: 6px;
    }

    .form-control {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.88rem;
        color: var(--text-dark);
        background-color: #fbfbfb;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        background-color: #ffffff;
        border-color: var(--accent-blue-soft);
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
    }

    textarea.form-control { resize: none; }

    .btn-primary {
        background-color: var(--primary-navy) !important;
        border-color: var(--primary-navy) !important;
        font-weight: 500;
        font-size: 0.88rem;
        border-radius: 6px;
        padding: 11px 24px;
        transition: all 0.2s ease;
    }

    .btn-primary:hover {
        background-color: var(--primary-royal) !important;
        border-color: var(--primary-royal) !important;
    }

    /* --- TABLE STYLE FOR HISTORY --- */
    .table-custom th {
        background-color: #f8fafc !important;
        color: var(--text-muted);
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 14px;
        border-bottom: 2px solid #edf2f7;
    }

    .table-custom td {
        padding: 14px;
        vertical-align: middle;
        font-size: 0.88rem;
        color: var(--text-dark);
        border-bottom: 1px solid #edf2f7;
    }

    /* --- BADGE NETRAL PREMIUM (BUKAN WARNA STABILO) --- */
    .badge-status-pending {
        background-color: #fffbeb;
        color: #b45309;
        font-weight: 500;
        font-size: 0.75rem;
        padding: 5px 12px;
        border-radius: 6px;
        border: 1px solid #fef3c7;
    }

    .badge-status-approved {
        background-color: #f0fdf4;
        color: #15803d;
        font-weight: 500;
        font-size: 0.75rem;
        padding: 5px 12px;
        border-radius: 6px;
        border: 1px solid #dcfce7;
    }

    .badge-status-rejected {
        background-color: #fef2f2;
        color: #b91c1c;
        font-weight: 500;
        font-size: 0.75rem;
        padding: 5px 12px;
        border-radius: 6px;
        border: 1px solid #fee2e2;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
E-Kinerja Magang &raquo; <span class="text-uppercase" style="color: var(--primary-royal);">Logbook Kegiatan</span>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
        
        
        <div class="mb-4">
            <h4 class="fw-bold text-dark m-0" style="letter-spacing: -0.3px;">Pencatatan Logbook Harian</h4>
            <p class="text-muted small m-0 mt-1" style="font-size: 0.82rem;">Laporkan rincian tugas harian Anda selama melaksanakan kegiatan akademik di dinas.</p>
        </div>

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success border-0 small py-2.5 mb-4 shadow-sm" role="alert" style="background-color: #f0fdf4; color: #15803d; border-left: 4px solid #16a34a !important;">
                <i class="bi bi-check-circle-fill me-1"></i> <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger border-0 small py-2.5 mb-4 shadow-sm" role="alert" style="background-color: #fef2f2; color: #dc2626; border-left: 4px solid #dc2626 !important;">
                <i class="bi bi-exclamation-triangle-fill me-1"></i> <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <div class="col-12 col-lg-5">
                <div class="card-flat">
                    <div class="section-title"><i class="bi bi-pencil-square me-1 text-primary"></i> Isi Laporan Baru</div>
                    
                    <?php if (!empty($penempatan)): ?>
                        <form action="<?= base_url('mahasiswa/simpanLogbook') ?>" method="POST" onsubmit="event.preventDefault(); var form = this; Swal.fire({title: 'Simpan Laporan Hari Ini?', text: 'Pastikan uraian aktivitas yang Anda tulis sudah lengkap dan sesuai.', icon: 'question', showCancelButton: true, confirmButtonColor: '#0a1d37', cancelButtonColor: '#6c757d', confirmButtonText: 'Ya, Simpan', cancelButtonText: 'Periksa Lagi'}).then((res) => { if(res.isConfirmed) { form.submit(); } });">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Kegiatan</label>
                                <input type="date" class="form-control" name="tgl_logbook" value="<?= date('Y-m-d') ?>" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Rincian Kegiatan / Tugas</label>
                                <textarea class="form-control" name="logbook_magang" rows="6" placeholder="Contoh: Membantu memvalidasi dokumen administrasi pengajuan dinas dan merapikan struktur file template..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 shadow-sm">Simpan Laporan Hari Ini</button>
                        </form>
                    <?php else: ?>
                        <div class="alert border-0 p-3 mb-0" style="background-color: #fffbef; border-left: 4px solid #f59e0b !important; border-radius: 8px;">
                            <div class="d-flex gap-2">
                                <i class="bi bi-lock-fill text-warning fs-5"></i>
                                <div>
                                    <span class="fw-bold text-dark d-block mb-1" style="font-size: 0.85rem;">Akses Logbook Terkunci</span>
                                    <p class="small text-muted m-0" style="line-height: 1.5; font-size: 0.8rem;">
                                        Anda belum dialokasikan ke unit bidang kerja. Formulir pelaporan harian baru akan aktif setelah penempatan bidang disahkan.
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-12 col-lg-7">
                <div class="card-flat h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3" style="border-color: #edf2f7 !important;">
                        <div class="section-title border-0 pb-0 mb-0 m-0"><i class="bi bi-clock-history me-1 text-primary"></i> Riwayat Aktivitas</div>
                        
                        <!-- Filter UI Fungsional -->
                        <form method="GET" action="<?= base_url('mahasiswa/logbook') ?>" class="d-flex gap-2">
                            <select name="filter_periode" class="form-select form-select-sm shadow-none" style="width: 140px; font-size: 0.78rem; border-color: #e2e8f0; color: #64748b; background-color: #f8fafc;" onchange="this.form.submit()">
                                <option value="">Semua Periode</option>
                                <option value="bulan_ini" <?= (request()->getGet('filter_periode') == 'bulan_ini') ? 'selected' : '' ?>>Bulan Ini</option>
                                <option value="minggu_ini" <?= (request()->getGet('filter_periode') == 'minggu_ini') ? 'selected' : '' ?>>Minggu Ini</option>
                            </select>
                            <select name="filter_status" class="form-select form-select-sm shadow-none" style="width: 130px; font-size: 0.78rem; border-color: #e2e8f0; color: #64748b; background-color: #f8fafc;" onchange="this.form.submit()">
                                <option value="">Semua Status</option>
                                <option value="pending" <?= (request()->getGet('filter_status') == 'pending') ? 'selected' : '' ?>>Pending</option>
                                <option value="disetujui" <?= (request()->getGet('filter_status') == 'disetujui') ? 'selected' : '' ?>>Disetujui</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-light border shadow-none" style="color: #64748b; background-color: #ffffff;" title="Terapkan Filter"><i class="bi bi-search"></i></button>
                            <?php if(request()->getGet('filter_periode') || request()->getGet('filter_status')): ?>
                                <a href="<?= base_url('mahasiswa/logbook') ?>" class="btn btn-sm btn-light border shadow-none" style="color: #dc2626; background-color: #fff5f5;" title="Reset Filter"><i class="bi bi-x-lg"></i></a>
                            <?php endif; ?>
                        </form>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-borderless table-custom align-middle m-0">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th style="width: 120px;">Tanggal</th>
                                    <th>Deskripsi Kegiatan</th>
                                    <th style="width: 120px;" class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($logbook)): ?>
                                    <?php $no = 1; foreach($logbook as $l): ?>
                                    <tr>
                                        <td class="text-muted" style="font-size: 0.82rem;"><?= $no++ ?></td>
                                        <td class="fw-semibold text-secondary" style="font-size: 0.82rem;">
                                            <?= date('d M Y', strtotime($l['tgl_logbook'])) ?>
                                        </td>
                                        <td style="line-height: 1.5;">
                                            <?= esc($l['logbook_magang']) ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if($l['status_logbook'] == 'menunggu'): ?>
                                                <span class="badge-status-pending mb-2 d-inline-block">
                                                    <i class="bi bi-hourglass-split me-1"></i> Pending
                                                </span>
                                            <?php elseif($l['status_logbook'] == 'disetujui'): ?>
                                                <span class="badge-status-approved mb-2 d-inline-block">
                                                    <i class="bi bi-check-circle-fill me-1"></i> Disetujui
                                                </span>
                                            <?php elseif($l['status_logbook'] == 'ditolak'): ?>
                                                <span class="badge-status-rejected mb-2 d-inline-block">
                                                    <i class="bi bi-x-circle-fill me-1"></i> Dikembalikan
                                                </span>
                                            <?php endif; ?>

                                            <?php if($l['status_logbook'] == 'ditolak' && !empty($l['catatan_revisi'])): ?>
                                                <div class="mt-2 text-start p-2 bg-light rounded border text-danger" style="font-size: 0.75rem; line-height: 1.4;">
                                                    <i class="bi bi-exclamation-triangle-fill me-1"></i> <b>Catatan Kabid:</b><br>
                                                    <span class="text-muted"><?= esc($l['catatan_revisi']) ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <!-- PREMIUM EMPTY STATE ILLUSTRATION -->
                                            <div class="mx-auto mb-4" style="width: 120px; height: 120px; background-color: #f0f9ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; position: relative; border: 4px solid #ffffff; box-shadow: 0 10px 25px rgba(14, 165, 233, 0.1);">
                                                <div style="position: absolute; top: -5px; right: 10px; width: 25px; height: 25px; background-color: #e0f2fe; border-radius: 50%;"></div>
                                                <div style="position: absolute; bottom: 10px; left: -10px; width: 15px; height: 15px; background-color: #dbeafe; border-radius: 50%;"></div>
                                                <i class="bi bi-journal-text" style="font-size: 3.5rem; color: #bae6fd; position: absolute; transform: rotate(-10deg) translateX(-8px);"></i>
                                                <i class="bi bi-pencil-fill text-primary" style="font-size: 2.2rem; position: absolute; transform: rotate(15deg) translate(15px, 15px); filter: drop-shadow(2px 4px 6px rgba(0,0,0,0.1));"></i>
                                            </div>
                                            <h6 class="fw-bold text-dark mb-2" style="font-size: 1rem;">Logbook Masih Kosong</h6>
                                            <p class="text-muted small mx-auto" style="max-width: 280px; line-height: 1.6; font-size: 0.85rem;">
                                                Anda belum mencatat kegiatan apapun. Ayo mulai laporkan rutinitas harian Anda di form sebelah kiri!
                                            </p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

<?= $this->endSection() ?>