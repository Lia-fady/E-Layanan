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
                <thead style="background: linear-gradient(135deg, #1e3a5f 0%, #2d5a8e 100%); color: #fff;">
                    <tr>
                        <th class="text-uppercase border-0" style="font-size: 0.82rem; font-weight: 700; padding: 12px 14px; vertical-align: middle; letter-spacing: 0.04em;">NAMA PEMOHON</th>
                        <th class="text-uppercase border-0" style="font-size: 0.82rem; font-weight: 700; padding: 12px 14px; vertical-align: middle; letter-spacing: 0.04em;">INSTANSI</th>
                        <th class="text-uppercase border-0" style="font-size: 0.82rem; font-weight: 700; padding: 12px 14px; vertical-align: middle; letter-spacing: 0.04em;">JENIS</th>
                        <th class="text-uppercase border-0" style="font-size: 0.82rem; font-weight: 700; padding: 12px 14px; vertical-align: middle; letter-spacing: 0.04em;">STATUS</th>
                        <th class="text-uppercase text-center border-0" style="font-size: 0.82rem; font-weight: 700; padding: 12px 14px; vertical-align: middle; letter-spacing: 0.04em;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($penempatan)): ?>
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
                                <button type="button" class="btn btn-sm btn-detail" 
                                    style="background: linear-gradient(135deg, #6366f1, #818cf8); color: #fff; border: none; border-radius: 8px; padding: 6px 14px; font-weight: 600; font-size: 0.8rem;"
                                    data-id="<?= $row->id_penempatan_magang ?>"
                                    data-mhs="<?= htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') ?>" title="Lihat Detail Permohonan">
                                    <i class="fas fa-eye mr-1"></i> Detail
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
        <div class="modal-content" style="border: none; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);">
            <div class="modal-header" style="background: linear-gradient(135deg, #1e3a5f 0%, #2d5a8e 100%); color: #fff; border-bottom: none; padding: 1.25rem 1.5rem;">
                <h5 class="modal-title font-weight-bold" id="modalDetailLabel" style="font-size: 1.1rem; letter-spacing: 0.02em;">
                    <i class="fas fa-user-graduate mr-2" style="color: #93c5fd;"></i> Detail Permohonan Magang
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.8; text-shadow: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="background-color: #f8fafc; padding: 1.5rem;">
                
                <!-- Header Profil Eksekutif -->
                <div class="d-flex align-items-center mb-4 p-3 rounded" style="background-color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.02); border: 1px solid #f1f5f9;">
                    <div class="mr-4" id="det_avatar" style="background: linear-gradient(135deg, #6366f1, #818cf8); color: #fff; width: 65px; height: 65px; border-radius: 50%; font-size: 1.8rem; font-weight: 700; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.4); flex-shrink: 0;">A</div>
                    <div>
                        <h4 id="det_nama_header" class="mb-1" style="font-weight: 700; color: #1e3a5f;">Nama Mahasiswa</h4>
                        <div class="text-muted" style="font-size: 0.95rem; font-weight: 500;">
                            <span id="det_nim_header" style="color: #64748b;">NIM</span> &nbsp;|&nbsp; 
                            <i class="fas fa-university mx-1" style="color: #94a3b8;"></i><span id="det_instansi_header" style="color: #64748b;">Instansi</span>
                        </div>
                    </div>
                </div>

                <!-- Highlight Kotak Waktu Magang -->
                <div class="mb-4 p-3 rounded" style="background-color: #fff1f2; border-left: 4px solid #f43f5e; display: flex; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                    <div style="background: #ffe4e6; padding: 12px; border-radius: 8px; margin-right: 15px;">
                        <i class="fas fa-calendar-alt" style="color: #e11d48; font-size: 1.3rem;"></i>
                    </div>
                    <div>
                        <div style="font-size: 0.8rem; color: #9f1239; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 2px;">Periode Pelaksanaan</div>
                        <div id="det_waktu" style="font-size: 1.1rem; font-weight: 700; color: #be123c;">18 Juli 2026 s/d 31 Agustus 2026</div>
                    </div>
                </div>
                
                <div class="row">
                    <!-- Biodata Mahasiswa -->
                    <div class="col-md-6 mb-3">
                        <div class="card h-100 shadow-sm border-0" style="border-radius: 12px;">
                            <div class="card-header bg-white font-weight-bold" style="border-bottom: 2px solid #f1f5f9; border-radius: 12px 12px 0 0; color: #1e3a5f; padding: 1rem 1.25rem;">
                                <i class="fas fa-id-card mr-2" style="color: #6366f1;"></i> Biodata Mahasiswa
                            </div>
                            <div class="card-body p-4">
                                <div class="row">
                                    <div class="col-6 mb-4">
                                        <span class="d-block text-muted mb-1" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">NIK</span>
                                        <span id="det_nik" class="d-block" style="color: #0f172a; font-weight: 600; font-size: 0.95rem;">-</span>
                                    </div>
                                    <div class="col-6 mb-4">
                                        <span class="d-block text-muted mb-1" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Jenis Kelamin</span>
                                        <span id="det_jk" class="badge" style="padding: 6px 10px; border-radius: 6px; font-weight: 600; font-size: 0.85rem;">-</span>
                                    </div>
                                    <div class="col-6 mb-4">
                                        <span class="d-block text-muted mb-1" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">No. Telepon</span>
                                        <span id="det_telp" class="d-block" style="color: #0f172a; font-weight: 600; font-size: 0.95rem;">-</span>
                                    </div>
                                    <div class="col-6 mb-4">
                                        <span class="d-block text-muted mb-1" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Email</span>
                                        <span id="det_email" class="d-block text-truncate" style="color: #0f172a; font-weight: 600; font-size: 0.95rem;" title="-">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Akademik -->
                    <div class="col-md-6 mb-3">
                        <div class="card h-100 shadow-sm border-0" style="border-radius: 12px;">
                            <div class="card-header bg-white font-weight-bold" style="border-bottom: 2px solid #f1f5f9; border-radius: 12px 12px 0 0; color: #1e3a5f; padding: 1rem 1.25rem;">
                                <i class="fas fa-university mr-2" style="color: #6366f1;"></i> Akademik & Magang
                            </div>
                            <div class="card-body p-4">
                                <div class="row">
                                    <div class="col-6 mb-4">
                                        <span class="d-block text-muted mb-1" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Jurusan/Prodi</span>
                                        <span id="det_prodi" class="d-block text-truncate" style="color: #0f172a; font-weight: 600; font-size: 0.95rem;" title="-">-</span>
                                    </div>
                                    <div class="col-6 mb-4">
                                        <span class="d-block text-muted mb-1" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Semester</span>
                                        <span id="det_semester" class="d-block" style="color: #0f172a; font-weight: 600; font-size: 0.95rem;">-</span>
                                    </div>
                                    <div class="col-6 mb-4">
                                        <span class="d-block text-muted mb-1" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Jenis Permohonan</span>
                                        <span id="det_jenis" class="badge" style="background: #fef3c7; color: #d97706; padding: 6px 10px; border-radius: 6px; font-weight: 600; font-size: 0.85rem;">-</span>
                                    </div>
                                    <div class="col-6 mb-4">
                                        <span class="d-block text-muted mb-1" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Bidang Tujuan</span>
                                        <span id="det_bidang" class="d-block" style="color: #0f172a; font-weight: 600; font-size: 0.95rem; line-height: 1.3;">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Keahlian & Deskripsi -->
                <div class="card shadow-sm border-0 mb-3" style="border-radius: 12px;">
                    <div class="card-header bg-white font-weight-bold" style="border-bottom: 2px solid #f1f5f9; border-radius: 12px 12px 0 0; color: #1e3a5f; padding: 1rem 1.25rem;">
                        <i class="fas fa-align-left mr-2" style="color: #6366f1;"></i> Keahlian & Catatan Sekretariat
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <strong class="text-muted d-block mb-2" style="font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">Deskripsi Keahlian:</strong>
                                <div id="det_keahlian" class="p-3 bg-light rounded" style="line-height: 1.6; font-size: 0.95rem; color: #475569; border: 1px solid #e2e8f0; min-height: 80px;"></div>
                            </div>
                            <div class="col-md-6">
                                <strong class="text-muted d-block mb-2" style="font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">Catatan Disposisi (Sekretariat):</strong>
                                <div id="det_catatan" class="p-3 rounded" style="line-height: 1.6; font-size: 0.95rem; background-color: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; min-height: 80px;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dokumen Pendukung -->
                <div class="card shadow-sm border-0 mb-3" style="border-radius: 12px;">
                    <div class="card-header bg-white font-weight-bold" style="border-bottom: 2px solid #f1f5f9; border-radius: 12px 12px 0 0; color: #1e3a5f; padding: 1rem 1.25rem;">
                        <i class="fas fa-folder-open mr-2" style="color: #6366f1;"></i> Dokumen Pendukung
                    </div>
                    <div class="card-body p-4">
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
#dataTableCustom tbody tr:hover {
    background-color: #f0f4ff !important;
}
#dataTableCustom tbody td {
    vertical-align: middle;
}
.dataTables_wrapper .page-item.active .page-link {
    background-color: #6366f1;
    border-color: #6366f1;
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
            "sZeroRecords": "Belum ada data disposisi untuk status ini.",
            "emptyTable": "Belum ada data disposisi untuk status ini.",
            "oPaginate": {
                "sFirst": "Pertama",
                "sLast": "Terakhir",
                "sNext": "Selanjutnya",
                "sPrevious": "Sebelumnya"
            }
        },
        "dom": 't<"d-flex justify-content-between align-items-center px-4 py-3" <"text-muted"i> <"pagination-sm"p> >',
        "ordering": false,
        "columns": [
            null,
            null,
            null,
            null,
            { "orderable": false, "searchable": false }
        ]
    });

    // Custom Search
    $('#searchTable').on('keyup', function() {
        tableCustom.search(this.value).draw();
    });

    // Fungsi menampilkan detail
    $('.btn-detail').on('click', function() {
        var mhs = $(this).data('mhs');
        
        // Populate Data for Header Profile
        $('#det_nama_header').text(mhs.nama_mahasiswa || '-');
        $('#det_nim_header').text(mhs.nim || '-');
        $('#det_instansi_header').text(mhs.instansi_pendidikan || '-');
        
        // Populate Avatar Initial
        if(mhs.nama_mahasiswa) {
            $('#det_avatar').text(mhs.nama_mahasiswa.substring(0, 1).toUpperCase());
        } else {
            $('#det_avatar').text('A');
        }

        // Populate Form Fields
        $('#det_nik').text(mhs.nik || '-');
        
        // Jenis Kelamin Badge
        if(mhs.jenis_kelamin == 'L') {
            $('#det_jk').text('Laki-Laki').css({'background': '#e0e7ff', 'color': '#4338ca'});
        } else if(mhs.jenis_kelamin == 'P') {
            $('#det_jk').text('Perempuan').css({'background': '#fce7f3', 'color': '#be185d'});
        } else {
            $('#det_jk').text('-').css({'background': '#f1f5f9', 'color': '#475569'});
        }
        
        $('#det_telp').text(mhs.no_telp || '-');
        
        // Tooltip fallback for long emails
        $('#det_email').text(mhs.email || '-').attr('title', mhs.email || '-');
        
        // Akademik
        $('#det_prodi').text(mhs.prodi || '-').attr('title', mhs.prodi || '-');
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
