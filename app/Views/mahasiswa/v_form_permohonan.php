<?= $this->extend('layout/mahasiswa') ?>

<?= $this->section('extra_css') ?>
<?= $this->include('mahasiswa/v_part_wizard_style') ?>
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<a href="<?= base_url('mahasiswa/dashboard') ?>" class="text-decoration-none text-primary">Dashboard</a> <span class="mx-2 text-muted">/</span> <span class="text-dark fw-medium">Ajukan Permohonan</span>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h3 class="fw-semibold mb-1 text-dark">Ajukan Permohonan</h3>
    <p class="text-muted mb-0">Lengkapi data dan unggah berkas yang diperlukan. Pastikan informasi yang Anda masukkan sudah benar sebelum mengirimkan permohonan.</p>
</div>

<?php if(session()->getFlashdata('errors')) : ?>
    <div class="alert alert-danger p-3 mb-4" style="font-size: 0.84rem; border-radius: 10px; border: 1px solid #fca5a5; background: #fef2f2; color: #b91c1c;">
        <div class="fw-bold mb-2"><i class="bi bi-exclamation-triangle-fill me-1"></i>Terdapat Kesalahan Input:</div>
        <ul class="mb-0 ps-3">
            <?php foreach(session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger p-3 mb-4" style="font-size: 0.85rem; border-radius: 10px;">
        <i class="bi bi-x-circle-fill me-1"></i> <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<?php
// Tentukan apakah form sudah di tahap akhir (Step 4) atau belum
$isFinished = (session()->getFlashdata('permohonan_sent') || $state == 2 || $state == 4);
?>

<!-- ============ STEPPER BAR SELALU TAMPIL ============ -->
<div class="wizard-stepper-wrap">
    <ul class="stepper-track">
        <li class="stepper-item-wrap">
            <div class="step-circle <?= $isFinished ? 'is-done' : 'is-active' ?>" id="sc-1"><i class="bi bi-check-lg <?= $isFinished ? '' : 'd-none' ?>" id="si-1"></i><span class="<?= $isFinished ? 'd-none' : '' ?>" id="sn-1">1</span></div>
            <div class="step-info">
                <div class="step-label-num <?= $isFinished ? 'is-done' : 'is-active' ?>" id="sl-num-1">Langkah 1</div>
                <div class="step-label-title <?= $isFinished ? 'is-done' : 'is-active' ?>" id="sl-title-1">Data Permohonan</div>
            </div>
        </li>
        <div class="step-connector"><div class="step-connector-fill" id="sf-1" style="width: <?= $isFinished ? '100%' : '0%' ?>;"></div></div>
        
        <li class="stepper-item-wrap">
            <div class="step-circle <?= $isFinished ? 'is-done' : '' ?>" id="sc-2"><i class="bi bi-check-lg <?= $isFinished ? '' : 'd-none' ?>" id="si-2"></i><span class="<?= $isFinished ? 'd-none' : '' ?>" id="sn-2">2</span></div>
            <div class="step-info">
                <div class="step-label-num <?= $isFinished ? 'is-done' : '' ?>" id="sl-num-2">Langkah 2</div>
                <div class="step-label-title <?= $isFinished ? 'is-done' : '' ?>" id="sl-title-2">Unggah Berkas</div>
            </div>
        </li>
        <div class="step-connector"><div class="step-connector-fill" id="sf-2" style="width: <?= $isFinished ? '100%' : '0%' ?>;"></div></div>
        
        <li class="stepper-item-wrap">
            <div class="step-circle <?= $isFinished ? 'is-done' : '' ?>" id="sc-3"><i class="bi bi-check-lg <?= $isFinished ? '' : 'd-none' ?>" id="si-3"></i><span class="<?= $isFinished ? 'd-none' : '' ?>" id="sn-3">3</span></div>
            <div class="step-info">
                <div class="step-label-num <?= $isFinished ? 'is-done' : '' ?>" id="sl-num-3">Langkah 3</div>
                <div class="step-label-title <?= $isFinished ? 'is-done' : '' ?>" id="sl-title-3">Tinjau Data</div>
            </div>
        </li>
        <div class="step-connector"><div class="step-connector-fill" id="sf-3" style="width: <?= $isFinished ? '100%' : '0%' ?>;"></div></div>
        
        <li class="stepper-item-wrap">
            <div class="step-circle <?= $isFinished ? 'is-done' : '' ?>" id="sc-4"><i class="bi bi-check-lg <?= $isFinished ? '' : 'd-none' ?>" id="si-4"></i><span class="<?= $isFinished ? 'd-none' : '' ?>" id="sn-4">4</span></div>
            <div class="step-info">
                <div class="step-label-num <?= $isFinished ? 'is-done' : '' ?>" id="sl-num-4">Langkah 4</div>
                <div class="step-label-title <?= $isFinished ? 'is-done' : '' ?>" id="sl-title-4">Selesai</div>
            </div>
        </li>
    </ul>
</div>

<?php 
// KONDISI PANEL BERDASARKAN STATE
if(session()->getFlashdata('permohonan_sent')): 
?>
<!-- ============ STEP 4: SELESAI (Flash Session) ============ -->
<div class="wizard-card text-center py-5" id="step-4-panel">
    <div class="success-anim"><i class="bi bi-check-lg text-white" style="font-size:2.2rem;"></i></div>
    <h5 class="fw-bold text-dark mb-2" style="font-size:1.3rem;">Permohonan Berhasil Dikirim!</h5>
    <p class="text-muted mx-auto mb-5" style="max-width:420px;line-height:1.7;font-size:0.87rem;">
        Berkas permohonan Anda telah tercatat di sistem.
        Tim Sekretariat akan melakukan verifikasi dalam <strong>1&ndash;3 hari kerja</strong>.
    </p>
    <a href="<?= base_url('mahasiswa/status') ?>" class="wz-btn-primary"><i class="bi bi-clock-history"></i> Lihat Status Permohonan</a>
</div>

<?php elseif($state == 2): ?>
<!-- ============ TAMPILAN JIKA PERMOHONAN SEDANG DIPROSES (STATE 2) ============ -->
<div class="wizard-card text-center py-5">
    <div style="width: 80px; height: 80px; border-radius: 50%; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 20px;">
        <i class="bi bi-hourglass-split"></i>
    </div>
    <?php if (isset($permohonan_aktif['status_persetujuan']) && $permohonan_aktif['status_persetujuan'] == 'DISETUJUI'): ?>
        <h5 class="fw-bold text-dark mb-2">Menunggu Persetujuan</h5>
        <p class="text-muted mx-auto mb-4" style="max-width:400px;">Berkas permohonan Anda telah dinyatakan sesuai dan kini sedang dalam proses persetujuan. Silakan pantau perkembangan permohonan Anda secara berkala.</p>
    <?php else: ?>
        <h5 class="fw-bold text-dark mb-2">Permohonan Sedang Diproses</h5>
        <p class="text-muted mx-auto mb-4" style="max-width:400px;">Permohonan Anda saat ini sedang dalam antrean verifikasi administrasi. Silakan pantau halaman status secara berkala.</p>
    <?php endif; ?>
    <a href="<?= base_url('mahasiswa/status') ?>" class="wz-btn-secondary"><i class="bi bi-clock-history"></i> Cek Status</a>
</div>

<?php elseif($state == 4): ?>
<!-- ============ TAMPILAN JIKA PERMOHONAN SUDAH DITERIMA/AKTIF (STATE 4) ============ -->
<div class="wizard-card text-center py-5">
    <div style="width: 80px; height: 80px; border-radius: 50%; background: #dcfce7; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 20px;">
        <i class="bi bi-check-circle-fill"></i>
    </div>
    <h5 class="fw-bold text-dark mb-2">Permohonan Disetujui</h5>
    <p class="text-muted mx-auto mb-4" style="max-width:400px;">Kegiatan dapat dilaksanakan sesuai periode yang telah ditentukan.</p>
    <a href="<?= base_url('mahasiswa/dashboard') ?>" class="wz-btn-primary"><i class="bi bi-house-door"></i> Ke Dashboard</a>
</div>



<?php else: ?>
<!-- ============ TAMPILAN FORM (STATE 1 - BARU, ATAU STATE 6 - PERLU REVISI) ============ -->
<?php if(isset($draft['status_persetujuan']) && $draft['status_persetujuan'] == 'PERBAIKAN_BERKAS'): ?>
<div class="card mb-4 border-0 shadow-sm" style="border-left: 4px solid #f59e0b !important; border-radius: 8px;">
    <div class="card-body p-4">
        <div class="d-flex align-items-start">
            <div class="me-3 mt-1">
                <div style="width: 38px; height: 38px; border-radius: 50%; background-color: #fef3c7; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-exclamation-triangle-fill text-warning fs-5"></i>
                </div>
            </div>
            <div class="w-100">
                <h6 class="fw-bold text-dark mb-2" style="font-size: 1rem;">Mohon Perbaiki Berkas Anda</h6>
                <p class="text-muted mb-3" style="font-size: 0.85rem; line-height: 1.6;">
                    Permohonan Anda dikembalikan karena terdapat berkas atau data yang belum sesuai. Silakan lengkapi atau perbaiki bagian yang diminta, lalu kirim ulang permohonan.
                </p>
                
                <?php if(!empty($draft['catatan_sekretariat'])): ?>
                    <div class="p-3" style="background-color: #f8f9fa; border-radius: 6px; border: 1px solid #e9ecef;">
                        <div style="font-size: 0.75rem; font-weight: 700; color: #495057; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                            <i class="bi bi-chat-left-text me-1"></i> Catatan Perbaikan
                        </div>
                        <div style="font-size: 0.85rem; color: #212529; font-weight: 500; line-height: 1.5;">
                            <?php 
                                $catatanSekre = esc($draft['catatan_sekretariat']);
                                if (strpos($catatanSekre, '[DIKEMBALIKAN KABID]') !== false) {
                                    $parts = explode('[DIKEMBALIKAN KABID]', $catatanSekre);
                                    echo nl2br(trim($parts[0]));
                                    echo '<div class="mt-3" style="font-size: 0.75rem; font-weight: 700; color: #495057; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;"><i class="bi bi-chat-left-text me-1"></i> Catatan Tambahan</div>';
                                    echo nl2br(trim($parts[1]));
                                } else {
                                    echo nl2br($catatanSekre);
                                }
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- ============ FORM WRAPPER ============ -->
<form action="<?= base_url(!empty($draft) ? 'mahasiswa/permohonan/update' : 'mahasiswa/permohonan/simpan') ?>" method="POST" enctype="multipart/form-data" id="formPermohonan" novalidate>
    <?= csrf_field() ?>

    <!-- ============ STEP 1: DATA PERMOHONAN ============ -->
    <div class="wizard-card wizard-step is-active" id="step-1">
        <div class="wz-section-title">
            <i class="bi bi-card-list text-primary"></i> Data Permohonan
        </div>

        <?php if (!isset($permohonan_aktif) || $permohonan_aktif['status_persetujuan'] !== 'PERBAIKAN_BERKAS'): ?>
        <!-- FAQ / Panduan Jenis Permohonan -->
        <div class="mb-4" style="background-color: #fef9c3; border-radius: 4px; padding: 16px 20px;">
            <div class="fw-bold mb-2" style="font-size:0.9rem; color: #854d0e;">Informasi Layanan Akademik :</div>
            <ul class="mb-0 ps-3" style="font-size:0.85rem; line-height:1.8; color: #713f12;">
                <li><strong>Skripsi / Tugas Akhir:</strong> Penelitian untuk tugas akhir mahasiswa tingkat akhir.</li>
                <li><strong>Observasi / Pengambilan Data:</strong> Kunjungan lapangan untuk keperluan tugas mata kuliah.</li>
                <li><strong>Magang:</strong> Magang kerja industri bagi Mahasiswa.</li>
                <li><strong>Praktik Kerja Lapangan (PKL):</strong> Praktik kerja bagi Siswa SMK.</li>
                <li><strong>Uji Coba Aplikasi Produk:</strong> Pengujian sistem/aplikasi buatan akademisi di lingkup Dinas Kominfo.</li>
            </ul>
        </div>
        <?php endif; ?>

        <!-- Jenis Permohonan & Tujuan -->
        <div class="row g-3 mb-3">
            <div class="col-md-12">
                <label class="wz-form-label">Jenis Permohonan <span class="text-danger">*</span></label>
                <div style="position:relative;">
                    <select class="wz-form-select" id="sel-jenis" onchange="if(this.value){document.getElementById('jenis_'+this.value).checked=true;}else{document.querySelectorAll('input[name=\'id_jenis_permohonan\']').forEach(r=>r.checked=false);} applyJenisCfg(this.value); document.getElementById('err-jenis').classList.add('d-none');">
                        <?php if (empty($jenis_permohonan)): ?>
                            <option value="">-- Tidak ada jenis permohonan untuk jenjang pendidikan Anda --</option>
                        <?php else: ?>
                            <option value="">-- Pilih Jenis Permohonan --</option>
                            <?php foreach($jenis_permohonan as $jp): ?>
                                <option value="<?= $jp['id_jenis_permohonan'] ?>" <?= old('id_jenis_permohonan', $draft['id_jenis_permohonan'] ?? '') == $jp['id_jenis_permohonan'] ? 'selected' : '' ?>><?= esc($jp['jenis_permohonan']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <!-- Hidden radio inputs for form submission -->
                    <?php if (!empty($jenis_permohonan)): ?>
                        <?php foreach($jenis_permohonan as $jp): ?>
                            <input type="radio" name="id_jenis_permohonan" id="jenis_<?= $jp['id_jenis_permohonan'] ?>" value="<?= $jp['id_jenis_permohonan'] ?>" <?= old('id_jenis_permohonan', $draft['id_jenis_permohonan'] ?? '') == $jp['id_jenis_permohonan'] ? 'checked' : '' ?> style="display:none;">
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="mt-2 d-none" id="err-jenis" style="color:#dc2626;font-size:0.8rem;">
                    <i class="bi bi-exclamation-circle me-1"></i>Jenis permohonan wajib dipilih.
                </div>
            </div>
        </div>
        <!-- Kolom Tujuan Kegiatan dihapus sesuai kesepakatan agar lebih ringkas -->

        <!-- Tanggal Mulai & Selesai -->
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="wz-form-label" for="tgl_mulai">Tanggal Mulai <span class="text-danger">*</span></label>
                <?php $errMulai = session('errors.tgl_mulai'); ?>
                <input type="date" class="wz-form-control <?= $errMulai ? 'is-invalid' : '' ?>" name="tgl_mulai" id="tgl_mulai" value="<?= old('tgl_mulai', $draft['tgl_mulai'] ?? '') ?>" required style="background-color: #fff;">
                <?php if($errMulai): ?>
                    <div class="invalid-feedback d-block" style="font-size:0.75rem; font-weight: 500; margin-top: 4px; color: #dc3545;"><i class="bi bi-exclamation-circle me-1"></i> <?= esc($errMulai) ?></div>
                <?php endif; ?>
                <!-- Pesan error dinamis dari JS -->
                <div class="invalid-feedback d-none" id="err-tgl-mulai-js" style="font-size:0.75rem; font-weight: 500; margin-top: 4px; color: #dc3545;"></div>
            </div>
            <div class="col-md-6">
                <label class="wz-form-label" for="tgl_selesai">Tanggal Selesai <span class="text-danger">*</span></label>
                <?php $errSelesai = session('errors.tgl_selesai'); ?>
                <input type="date" class="wz-form-control <?= $errSelesai ? 'is-invalid' : '' ?>" name="tgl_selesai" id="tgl_selesai" value="<?= old('tgl_selesai', $draft['tgl_selesai'] ?? '') ?>" required style="background-color: #fff;">
                <?php if($errSelesai): ?>
                    <div class="invalid-feedback d-block" style="font-size:0.75rem; font-weight: 500; margin-top: 4px; color: #dc3545;"><i class="bi bi-exclamation-circle me-1"></i> <?= esc($errSelesai) ?></div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Instansi & Program Studi -->
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="wz-form-label">Asal Instansi Pendidikan</label>
                <input type="text" class="wz-form-control" value="<?= esc(session()->get('kampus') ?? '-') ?>" readonly style="background:#f1f5f9;">
            </div>
            <div class="col-md-6">
                <label class="wz-form-label">Lokasi Kegiatan</label>
                <input type="text" class="wz-form-control" value="Dinas Kominfo Kota Tangerang" readonly style="background:#f1f5f9;">
            </div>
        </div>

        <!-- Deskripsi Keahlian -->
        <div class="mb-3">
            <label class="wz-form-label" id="lbl-keahlian">Keahlian Utama <span class="text-danger">*</span></label>
            <textarea class="wz-form-control" name="deskripsi_keahlian" id="deskripsi_keahlian" rows="3" placeholder="Jelaskan keahlian atau kompetensi yang Anda miliki saat ini..." required maxlength="500" oninput="countChars(this,'cc-keahlian')"><?= old('deskripsi_keahlian', $draft['deskripsi_keahlian'] ?? '') ?></textarea>
            <div class="char-counter"><span id="cc-keahlian">0</span>/500 karakter</div>
        </div>

        <!-- Deskripsi Magang -->
        <div class="mb-4">
            <label class="wz-form-label" id="lbl-magang">Apa yang ingin Anda kerjakan? <span class="text-danger">*</span></label>
            <textarea class="wz-form-control" name="deskripsi" id="deskripsi" rows="4" placeholder="Jelaskan maksud, tujuan, atau rencana kegiatan yang ingin Anda ajukan..." required maxlength="1000" oninput="countChars(this,'cc-magang')"><?= old('deskripsi', $draft['rencana_kegiatan'] ?? '') ?></textarea>
            <div class="char-counter"><span id="cc-magang">0</span>/1000 karakter</div>
        </div>

        <!-- NAV -->
        <div class="wz-nav-footer">
            <button type="button" class="wz-btn-secondary" onclick="resetFormCustom()">Batal</button>
            <button type="button" class="wz-btn-primary" onclick="goNext(2)">Selanjutnya</button>
        </div>
    </div>

    <!-- ============ STEP 2: UNGGAH DOKUMEN ============ -->
    <div class="wizard-card wizard-step" id="step-2">
        <div class="wz-section-title">
            <i class="bi bi-file-earmark-arrow-up text-primary"></i> Unggah Berkas
        </div>
        <p class="text-muted mb-4" style="font-size:0.84rem;line-height:1.7;margin-top:-8px;">
            Unggah dokumen dalam format <strong>PDF</strong>, ukuran maksimal <strong>2 MB</strong> per file.
        </p>

        <!-- Upload: Surat Pengantar -->
        <div class="mb-4 position-relative">
            <label class="wz-form-label" id="lbl-surat">Surat Pengantar Resmi <span class="text-danger">*</span></label>
            <div class="position-relative">
                <input class="form-control" type="file" name="surat_pengantar" id="input-surat" accept=".pdf" <?= empty($draft['surat_pengantar']) ? 'required' : '' ?> style="opacity: 0; position: absolute; top: 0; left: 0; z-index: 2; width: 100%; height: 100%; cursor: pointer;" onchange="document.getElementById('text-surat').textContent = this.files[0] ? this.files[0].name : '<?= !empty($draft['surat_pengantar']) ? esc($draft['nama_surat_pengantar'] ?? basename($draft['surat_pengantar'])) : 'No file chosen' ?>';">
                <div class="form-control d-flex align-items-center" style="z-index: 1; overflow: hidden;">
                    <div style="background: #e9ecef; border-right: 1px solid #ced4da; margin: -0.375rem 0.75rem -0.375rem -0.75rem; padding: 0.375rem 0.75rem; color: #212529;">Choose File</div>
                    <div id="text-surat" class="text-truncate" style="color: #212529;">
                        <?= !empty($draft['surat_pengantar']) ? esc($draft['nama_surat_pengantar'] ?? basename($draft['surat_pengantar'])) : 'No file chosen' ?>
                    </div>
                </div>
            </div>
            <div class="form-text mt-1" style="font-size:0.75rem;"><i class="bi bi-info-circle me-1"></i>Format: PDF | Maksimal ukuran: 2 MB</div>
        </div>

        <!-- Upload: CV / Proposal -->
        <div class="mb-4" id="wrapper-cv">
            <label class="wz-form-label" id="lbl-cv">Curriculum Vitae (CV) Terbaru <span class="text-danger">*</span></label>
            <div class="position-relative">
                <input class="form-control" type="file" name="cv" id="input-cv" accept=".pdf" style="opacity: 0; position: absolute; top: 0; left: 0; z-index: 2; width: 100%; height: 100%; cursor: pointer;" onchange="document.getElementById('text-cv').textContent = this.files[0] ? this.files[0].name : '<?= !empty($draft['cv']) ? esc($draft['nama_cv'] ?? basename($draft['cv'])) : 'No file chosen' ?>';">
                <div class="form-control d-flex align-items-center" style="z-index: 1; overflow: hidden;">
                    <div style="background: #e9ecef; border-right: 1px solid #ced4da; margin: -0.375rem 0.75rem -0.375rem -0.75rem; padding: 0.375rem 0.75rem; color: #212529;">Choose File</div>
                    <div id="text-cv" class="text-truncate" style="color: #212529;">
                        <?= !empty($draft['cv']) ? esc($draft['nama_cv'] ?? basename($draft['cv'])) : 'No file chosen' ?>
                    </div>
                </div>
            </div>
            <div class="form-text mt-1" style="font-size:0.75rem;"><i class="bi bi-info-circle me-1"></i>Format: PDF | Maksimal ukuran: 2 MB</div>
            <?php if(session()->getFlashdata('errors') || session()->getFlashdata('error')) : ?>
                <div class="text-danger mt-1" style="font-size: 0.75rem; font-weight: 600;"><i class="bi bi-exclamation-triangle-fill"></i> Pastikan Anda memilih (browse) ulang file ini jika bermaksud merevisinya.</div>
            <?php endif; ?>
        </div>

        <!-- Upload: KTM -->
        <div class="mb-4 position-relative">
            <label class="wz-form-label" id="lbl-ktm">Kartu Identitas (KTM / Kartu Pelajar) <span class="text-danger">*</span></label>
            <div class="position-relative">
                <input class="form-control" type="file" name="ktm" id="input-ktm" accept=".pdf,.jpg,.jpeg,.png" <?= empty($draft['ktm']) ? 'required' : '' ?> style="opacity: 0; position: absolute; top: 0; left: 0; z-index: 2; width: 100%; height: 100%; cursor: pointer;" onchange="document.getElementById('text-ktm').textContent = this.files[0] ? this.files[0].name : '<?= !empty($draft['ktm']) ? esc($draft['nama_ktm'] ?? basename($draft['ktm'])) : 'No file chosen' ?>';">
                <div class="form-control d-flex align-items-center" style="z-index: 1; overflow: hidden;">
                    <div style="background: #e9ecef; border-right: 1px solid #ced4da; margin: -0.375rem 0.75rem -0.375rem -0.75rem; padding: 0.375rem 0.75rem; color: #212529;">Choose File</div>
                    <div id="text-ktm" class="text-truncate" style="color: #212529;">
                        <?= !empty($draft['ktm']) ? esc($draft['nama_ktm'] ?? basename($draft['ktm'])) : 'No file chosen' ?>
                    </div>
                </div>
            </div>
            <div class="form-text mt-1" style="font-size:0.75rem;"><i class="bi bi-info-circle me-1"></i>Format: PDF, JPG, PNG | Maksimal ukuran: 2 MB</div>
        </div>

        <!-- Info Box -->
        <div class="info-box mb-4">
            <div class="fw-semibold text-dark mb-2" style="font-size:0.84rem;"><i class="bi bi-info-circle text-primary me-1"></i> Panduan Dokumen</div>
            <ul id="info-panduan-list" class="mb-0 ps-3 text-muted" style="font-size:0.8rem;line-height:1.9;">
                <li>Surat pengantar menggunakan kop resmi kampus dan ditandatangani pejabat berwenang</li>
                <li>CV mencantumkan data diri, program studi, semester, dan keahlian teknis</li>
                <li>Khusus <strong>Penelitian / TA</strong> — wajib lampirkan Proposal / Sinopsis</li>
                <li>Pastikan file tidak terproteksi kata sandi (password-protected)</li>
            </ul>
        </div>

        <!-- NAV -->
        <div class="wz-nav-footer">
            <button type="button" class="wz-btn-secondary" onclick="goPrev(1)">Kembali</button>
            <button type="button" class="wz-btn-primary" onclick="goNext(3)">Selanjutnya</button>
        </div>
    </div>

    <!-- ============ STEP 3: REVIEW ============ -->
    <div class="wizard-card wizard-step" id="step-3">
        <div class="wz-section-title">
            <i class="bi bi-clipboard2-check text-primary"></i> Periksa Kembali Data
        </div>
        <p class="text-muted mb-4" style="font-size:0.84rem;margin-top:-8px;">
            Pastikan seluruh data yang Anda masukkan sudah benar sebelum mengirimkan permohonan.
        </p>

        <div class="row g-4 mb-4">
            <!-- Review: Identitas Pemohon -->
            <div class="col-lg-6">
                <div class="review-data-card h-100 mb-0">
                    <div class="rv-title">Data Diri</div>
                    <table class="rv-table">
                        <?php 
                            $isSiswa = (isset($instansi['jenjang_pendidikan']) && stripos($instansi['jenjang_pendidikan'], 'SM') !== false) || (isset($instansi['id_jenjang_pendidikan']) && $instansi['id_jenjang_pendidikan'] == 3);
                            $labelNim = $isSiswa ? 'NISN' : 'NIM';
                            $labelKelas = $isSiswa ? 'Kelas' : 'Semester';
                            $valKelas = $isSiswa ? ($instansi['kelas'] ?? '-') : ($instansi['semester'] ?? '-');
                        ?>
                        <tr><td style="width:140px;">Nama Lengkap</td><td class="rv-sep">:</td><td class="text-dark"><?= esc($mhs['nama_mahasiswa'] ?? '-') ?></td></tr>
                        <tr><td>Jenis Kelamin</td><td class="rv-sep">:</td><td><?= esc(isset($mhs['jenis_kelamin']) ? ($mhs['jenis_kelamin'] === 'L' ? 'Laki-laki' : ($mhs['jenis_kelamin'] === 'P' ? 'Perempuan' : '-')) : '-') ?></td></tr>
                        <tr><td>Tanggal Lahir</td><td class="rv-sep">:</td><td><?= esc(!empty($mhs['tgl_lahir']) ? tgl_indo($mhs['tgl_lahir']) : '-') ?></td></tr>
                        <tr><td id="lbl-rv-nim"><?= $labelNim ?></td><td class="rv-sep">:</td><td><?= esc($mhs['nim'] ?? '-') ?></td></tr>
                        <tr><td>NIK</td><td class="rv-sep">:</td><td><?= esc($mhs['nik'] ?? '-') ?></td></tr>
                        <tr><td>Nomor WhatsApp</td><td class="rv-sep">:</td><td><?= esc($mhs['no_telp'] ?? '-') ?></td></tr>
                        <tr><td>Email</td><td class="rv-sep">:</td><td><?= esc($mhs['email'] ?? '-') ?></td></tr>
                        <tr><td>Jenjang Pendidikan</td><td class="rv-sep">:</td><td><?= esc($instansi['jenjang_pendidikan'] ?? '-') ?></td></tr>
                        <tr><td>Asal Instansi Pendidikan</td><td class="rv-sep">:</td><td><?= esc($instansi['instansi_pendidikan'] ?? '-') ?></td></tr>
                        <?php if (!$isSiswa && !empty($instansi['fakultas'])): ?>
                            <tr><td>Fakultas</td><td class="rv-sep">:</td><td><?= esc($instansi['fakultas']) ?></td></tr>
                        <?php endif; ?>
                        <tr><td>Jurusan</td><td class="rv-sep">:</td><td><?= esc(!empty($instansi['prodi']) ? $instansi['prodi'] : ($instansi['jurusan'] ?? '-')) ?></td></tr>
                        <tr><td id="lbl-rv-semester"><?= $labelKelas ?></td><td class="rv-sep">:</td><td><?= esc($valKelas) ?></td></tr>
                    </table>
                </div>
            </div>

            <!-- Review: Data Permohonan -->
            <div class="col-lg-6">
                <div class="review-data-card h-100 mb-0">
                    <div class="rv-title">Data Permohonan</div>
                    <table class="rv-table">
                        <tr><td style="width:140px;">Jenis Permohonan</td><td class="rv-sep">:</td><td id="rv-jenis" class="text-dark">—</td></tr>
                        <tr><td>Tanggal Pelaksanaan</td><td class="rv-sep">:</td><td><span id="rv-tgl-mulai" class="text-dark">—</span> <span class="text-muted mx-1">s.d.</span> <span id="rv-tgl-selesai" class="text-dark">—</span></td></tr>
                        <tr><td>Lokasi Kegiatan</td><td class="rv-sep">:</td><td class="text-dark">Dinas Kominfo Kota Tangerang</td></tr>
                        <tr><td id="rv-keahlian-label" style="vertical-align:top; padding-top:10px;">Keahlian Utama</td><td class="rv-sep" style="vertical-align:top; padding-top:10px;">:</td><td id="rv-keahlian" class="text-dark" style="white-space:pre-wrap; padding-top:10px;">—</td></tr>
                        <tr><td id="rv-magang-label" style="vertical-align:top; padding-top:10px;">Apa yang ingin Anda kerjakan?</td><td class="rv-sep" style="vertical-align:top; padding-top:10px;">:</td><td id="rv-magang" class="text-dark" style="white-space:pre-wrap; padding-top:10px;">—</td></tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Review: Dokumen -->
        <div class="mb-4">
            <div class="fw-bold text-dark mb-3" style="font-size:0.88rem;">
                <i class="bi bi-file-earmark-pdf text-danger me-2"></i>Berkas yang Diunggah
            </div>
            <table class="rv-doc-table">
                <thead>
                    <tr>
                        <th style="width:56px;">No</th>
                        <th>Berkas yang Diunggah</th>
                        <th class="text-end" style="width:230px;">File</th>
                    </tr>
                </thead>
                <tbody id="rv-doc-tbody"></tbody>
            </table>
        </div>



        <!-- NAV -->
        <div class="wz-nav-footer">
            <button type="button" class="wz-btn-secondary" onclick="goPrev(2)">Kembali</button>
            <div class="ms-auto d-flex gap-2">
                <button type="button" class="btn fw-semibold shadow-sm" style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; font-size: 0.85rem; padding: 0 20px; border-radius: 8px;" id="btn-draft" onclick="submitPermohonan('draft')">Simpan Draft</button>
                <button type="button" class="wz-btn-success" id="btn-submit" onclick="submitPermohonan('kirim')">Kirim Permohonan</button>
            </div>
        </div>
    </div>
</form>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<?= $this->include('mahasiswa/v_part_wizard_script') ?>
<script>
// ==========================================
// KONFIGURASI TANGGAL DARI DATABASE
// ==========================================
var BULAN_PENUH = <?= json_encode($bulan_penuh ?? []) ?>;

var JENIS_DATE_CFG = {
<?php foreach ($jenis_permohonan as $jp): ?>
    '<?= $jp['id_jenis_permohonan'] ?>': {
        maksHariPengajuan: <?= (int)($jp['maksimal_hari_pengajuan'] ?? 0) ?>,
        durasiMinimal: <?= (int)($jp['durasi_minimal'] ?? 0) ?>,
        maksimalPermohonan: <?= (int)($jp['maksimal_permohonan'] ?? 0) ?>
    },
<?php endforeach; ?>
};

// ==========================================
// VALIDASI TANGGAL DINAMIS (FRONTEND)
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
    var tglMulai = document.getElementById('tgl_mulai');
    var tglSelesai = document.getElementById('tgl_selesai');

    if (tglMulai && tglSelesai) {
        // Wait a small delay to ensure Flatpickr global init has finished
        setTimeout(function() {
            var fpMulai = tglMulai._flatpickr;
            var fpSelesai = tglSelesai._flatpickr;

            function parseInputDate(value) {
                var p = value.split('-');
                return new Date(parseInt(p[0], 10), parseInt(p[1], 10) - 1, parseInt(p[2], 10));
            }

            function addDays(date, days) {
                var d = new Date(date);
                d.setDate(d.getDate() + days);
                return d;
            }

            function formatInputDate(date) {
                var yyyy2 = date.getFullYear();
                var mm2 = String(date.getMonth() + 1).padStart(2, '0');
                var dd2 = String(date.getDate()).padStart(2, '0');
                return yyyy2 + '-' + mm2 + '-' + dd2;
            }

            function getSelectedJenis() {
                var j = document.querySelector('input[name="id_jenis_permohonan"]:checked');
                return j ? j.value : null;
            }

            function getJenisDateConfig(jenisId) {
                return JENIS_DATE_CFG[jenisId] || { maksHariPengajuan: 0, durasiMinimal: 0, maksimalPermohonan: 0 };
            }

            function applyKalenderConfig(jenisId) {
                var cfg = getJenisDateConfig(jenisId);
                var today = new Date();
                today.setHours(0,0,0,0);

                var minMulai = addDays(today, cfg.maksHariPengajuan);
                
                // Cari bulan terdekat yang belum penuh
                var maxAdvance = 12;
                var b_penuh = BULAN_PENUH.map(Number);
                while (b_penuh.includes(minMulai.getMonth() + 1) && maxAdvance > 0) {
                    minMulai.setMonth(minMulai.getMonth() + 1);
                    minMulai.setDate(1); // Set ke tanggal 1 bulan berikutnya
                    maxAdvance--;
                }

                var minMulaiStr = formatInputDate(minMulai);
                
                var maxMulaiStr = null;
                if (cfg.maksimalPermohonan > 0) {
                    var maxMulai = addDays(today, cfg.maksimalPermohonan);
                    maxMulaiStr = formatInputDate(maxMulai);
                }

                if (fpMulai) {
                    fpMulai.set('minDate', minMulaiStr);
                    if (maxMulaiStr) {
                        fpMulai.set('maxDate', maxMulaiStr);
                    } else {
                        fpMulai.set('maxDate', null);
                    }
                    // Disable full months
                    fpMulai.set('disable', [
                        function(date) {
                            var month = date.getMonth() + 1; // getMonth() returns 0-11
                            var b_penuh = BULAN_PENUH.map(Number);
                            return b_penuh.includes(month);
                        }
                    ]);
                }

                if (fpSelesai) {
                    // Hanya terapkan maxDate dan disable bulan penuh, minDate diatur oleh onchange tglMulai
                    if (maxMulaiStr) {
                        // Tambahkan margin waktu untuk tglSelesai, misalnya batas start + 6 bulan maksimal magang
                        // Tapi karena diminta "disamakan", kita aplikasikan batas maksimum yang masuk akal
                        // Biasanya magang max 6 bulan. Jika tgl_mulai bisa sampai 6 bulan ke depan, 
                        // tgl_selesai logikanya bisa sampai 12 bulan ke depan. Namun kita ikut instruksi disamakan:
                        // Kita set maxDate sama atau ditambahkan buffer 6 bulan. 
                        // Kita samakan persis dengan maxMulaiStr jika itu yang dimaksud "disamakan".
                        // Wait, if I set it EXACTLY to maxMulaiStr, if someone starts at maxMulaiStr, they can't have any duration.
                        // We will set maxDate for tglSelesai to maxMulaiStr + 6 bulan (180 days) as a safe upper bound, 
                        // ATAU kita cukup disable BULAN_PENUH. 
                        // Let's just apply maxMulaiStr. If they want to extend it later, we can.
                        fpSelesai.set('maxDate', maxMulaiStr);
                    } else {
                        fpSelesai.set('maxDate', null);
                    }
                    fpSelesai.set('disable', [
                        function(date) {
                            var month = date.getMonth() + 1;
                            var b_penuh = BULAN_PENUH.map(Number);
                            return b_penuh.includes(month);
                        }
                    ]);
                }

                // Native input fallback
                tglMulai.setAttribute('min', minMulaiStr);
                if (maxMulaiStr) {
                    tglMulai.setAttribute('max', maxMulaiStr);
                    tglSelesai.setAttribute('max', maxMulaiStr);
                } else {
                    tglMulai.removeAttribute('max');
                    tglSelesai.removeAttribute('max');
                }
            }

            // Apply initial config
            var currentJenis = getSelectedJenis();
            if (currentJenis) {
                applyKalenderConfig(currentJenis);
            }

            if (fpMulai) {
                // Mencegah bug bulan hilang saat kosong dengan melompat ke minDate saat dibuka
                var jumpToMin = function(selectedDates, dateStr, instance) {
                    if (!dateStr && instance.config.minDate) {
                        instance.jumpToDate(instance.config.minDate);
                    }
                };
                
                if (Array.isArray(fpMulai.config.onOpen)) {
                    fpMulai.config.onOpen.push(jumpToMin);
                } else {
                    fpMulai.config.onOpen = [jumpToMin];
                }

                // Explicitly trigger auto-save on change
                var triggerSave = function() {
                    if (typeof saveToLocal === 'function') saveToLocal();
                };
                if (Array.isArray(fpMulai.config.onChange)) {
                    fpMulai.config.onChange.push(triggerSave);
                } else {
                    fpMulai.config.onChange = [triggerSave];
                }

                if (fpSelesai) {
                    if (Array.isArray(fpSelesai.config.onOpen)) {
                        fpSelesai.config.onOpen.push(jumpToMin);
                    } else {
                        fpSelesai.config.onOpen = [jumpToMin];
                    }

                    if (Array.isArray(fpSelesai.config.onChange)) {
                        fpSelesai.config.onChange.push(triggerSave);
                    } else {
                        fpSelesai.config.onChange = [triggerSave];
                    }
                }
            }

            // Update kalender jika jenis permohonan diubah
            var selJenisEl = document.getElementById('sel-jenis');
            if (selJenisEl) {
                selJenisEl.addEventListener('change', function() {
                    var jenis = this.value;
                    if (jenis) {
                        applyKalenderConfig(jenis);
                    }
                    // Re-trigger start date validation & end date logic
                    if (tglMulai.value) {
                        tglMulai.dispatchEvent(new Event('change'));
                    }
                });
            }

            function validateDurasi() {
                var errDiv = document.getElementById('err-tgl-mulai-js');
                if (!tglMulai.value || !tglSelesai.value) {
                    return;
                }

                var dateMulai = parseInputDate(tglMulai.value);
                var dateSelesai = parseInputDate(tglSelesai.value);
                var diffTime = dateSelesai - dateMulai;
                var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                
                var jenis = getSelectedJenis();
                var cfg = getJenisDateConfig(jenis);
                var isInvalid = false;
                
                // Validasi durasi minimal dari database
                if (cfg.durasiMinimal > 0 && diffDays < cfg.durasiMinimal) {
                    isInvalid = true;
                    if (errDiv) {
                        errDiv.innerHTML = '<i class="bi bi-exclamation-circle me-1"></i> Durasi kegiatan minimal adalah ' + cfg.durasiMinimal + ' hari.';
                    }
                } else if (dateSelesai < dateMulai) {
                    isInvalid = true;
                    if (errDiv) {
                        errDiv.innerHTML = '<i class="bi bi-exclamation-circle me-1"></i> Tanggal selesai tidak boleh mendahului tanggal mulai.';
                    }
                }

                // Untuk flatpickr, the hidden input doesn't show invalid state visually, we add it to the altInput
                var altMulai = fpMulai ? fpMulai.altInput : tglMulai;
                var altSelesai = fpSelesai ? fpSelesai.altInput : tglSelesai;

                if (isInvalid) {
                    if(altMulai) altMulai.classList.add('is-invalid');
                    if(altSelesai) altSelesai.classList.add('is-invalid');
                    if (errDiv) {
                        errDiv.classList.remove('d-none');
                        errDiv.classList.add('d-block');
                    }
                } else {
                    if(altMulai) altMulai.classList.remove('is-invalid');
                    if(altSelesai) altSelesai.classList.remove('is-invalid');
                    if (errDiv) {
                        errDiv.classList.remove('d-block');
                        errDiv.classList.add('d-none');
                    }
                }
            }

            tglMulai.addEventListener('change', function() {
                if (tglMulai.value) {
                    var jenis = getSelectedJenis();
                    var cfg = getJenisDateConfig(jenis);
                    var minDays = cfg.durasiMinimal;
                    var minSelesai = addDays(parseInputDate(tglMulai.value), minDays);
                    var minSelesaiStr = formatInputDate(minSelesai);
                    
                    if (fpSelesai) {
                        fpSelesai.set('minDate', minSelesaiStr);
                    } else {
                        tglSelesai.setAttribute('min', minSelesaiStr);
                    }

                    if ((minDays > 0 && !tglSelesai.value) || (tglSelesai.value && parseInputDate(tglSelesai.value) < minSelesai)) {
                        if (fpSelesai) {
                            fpSelesai.setDate(minSelesaiStr, true); // true to trigger change
                        } else {
                            tglSelesai.value = minSelesaiStr;
                        }
                    }
                } else {
                    // Jika tglMulai di-clear, kosongkan juga tglSelesai
                    tglSelesai.value = '';
                    if (fpSelesai) fpSelesai.clear();
                }
                toggleSelesai();
                validateDurasi();
            });

            function toggleSelesai() {
                var isDisabled = !tglMulai.value;
                if (fpSelesai && fpSelesai.altInput) {
                    fpSelesai.altInput.disabled = isDisabled;
                } else {
                    tglSelesai.disabled = isDisabled;
                }
            }
            toggleSelesai(); // Jalankan saat pertama kali dimuat

            tglSelesai.addEventListener('change', function() {
                if (tglMulai.value && tglSelesai.value) {
                    var jenis = getSelectedJenis();
                    var cfg = getJenisDateConfig(jenis);
                    var minDays = cfg.durasiMinimal;
                    var minSelesai = addDays(parseInputDate(tglMulai.value), minDays);
                    var minSelesaiStr = formatInputDate(minSelesai);
                    
                    if (fpSelesai) {
                        fpSelesai.set('minDate', minSelesaiStr);
                    } else {
                        tglSelesai.setAttribute('min', minSelesaiStr);
                    }
                    
                    if (parseInputDate(tglSelesai.value) < minSelesai) {
                        if (fpSelesai) {
                            fpSelesai.setDate(minSelesaiStr, true);
                        } else {
                            tglSelesai.value = minSelesaiStr;
                        }
                    }
                }
                validateDurasi();
            });
            
        }, 100); // 100ms delay
    }
});
</script>
<?= $this->endSection()?>