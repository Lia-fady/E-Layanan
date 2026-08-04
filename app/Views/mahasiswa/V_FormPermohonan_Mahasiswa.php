<?= $this->extend('layout/V_Mahasiswa') ?>

<?= $this->section('extra_css') ?>
<?= $this->include('mahasiswa/V_PartWizardStyle_Mahasiswa') ?>
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<a href="<?= base_url('mahasiswa/dashboard') ?>" class="text-decoration-none text-primary">Dashboard</a> <span class="mx-2 text-muted">/</span> <span class="text-dark fw-medium">Ajukan Permohonan</span>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h3 class="fw-semibold mb-1 text-dark">Form Permohonan Layanan Akademik</h3>
    <p class="text-muted mb-0">Lengkapi data kegiatan dan dokumen pendukung Anda. Proses pengajuan terdiri dari data, dokumen, review, dan pengiriman.</p>
</div>

<?php if(session()->getFlashdata('errors')) : ?>
    <div class="alert alert-danger p-3 mb-4" style="font-size: 0.84rem; border-radius: 10px; border: 1px solid #fca5a5; background: #fef2f2; color: #b91c1c;">
        <div class="fw-bold mb-2"><i class="bi bi-exclamation-triangle-fill me-1"></i>Pengajuan Gagal:</div>
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
                <div class="step-label-title <?= $isFinished ? 'is-done' : '' ?>" id="sl-title-2">Unggah Dokumen</div>
            </div>
        </li>
        <div class="step-connector"><div class="step-connector-fill" id="sf-2" style="width: <?= $isFinished ? '100%' : '0%' ?>;"></div></div>
        
        <li class="stepper-item-wrap">
            <div class="step-circle <?= $isFinished ? 'is-done' : '' ?>" id="sc-3"><i class="bi bi-check-lg <?= $isFinished ? '' : 'd-none' ?>" id="si-3"></i><span class="<?= $isFinished ? 'd-none' : '' ?>" id="sn-3">3</span></div>
            <div class="step-info">
                <div class="step-label-num <?= $isFinished ? 'is-done' : '' ?>" id="sl-num-3">Langkah 3</div>
                <div class="step-label-title <?= $isFinished ? 'is-done' : '' ?>" id="sl-title-3">Review</div>
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
        <?php if (isset($permohonan_aktif['disposisi']) && $permohonan_aktif['disposisi'] == '1'): ?>
            <h5 class="fw-bold text-dark mb-2">Menunggu Persetujuan Bidang</h5>
            <p class="text-muted mx-auto mb-4" style="max-width:400px;">Berkas permohonan Anda telah diverifikasi oleh Sekretariat dan saat ini sedang <strong>menunggu persetujuan dan penempatan</strong> oleh Bidang. Silakan pantau halaman status secara berkala.</p>
        <?php else: ?>
            <h5 class="fw-bold text-dark mb-2">Menunggu Disposisi Sekretariat</h5>
            <p class="text-muted mx-auto mb-4" style="max-width:400px;">Berkas permohonan Anda telah dinyatakan VALID. Saat ini sedang <strong>menunggu plotting penempatan bidang</strong> oleh Sekretariat. Silakan pantau halaman status secara berkala.</p>
        <?php endif; ?>
    <?php else: ?>
        <h5 class="fw-bold text-dark mb-2">Permohonan Sedang Diproses</h5>
        <p class="text-muted mx-auto mb-4" style="max-width:400px;">Permohonan Anda saat ini sedang dalam antrean verifikasi oleh tim Sekretariat Dinas Kominfo. Silakan pantau halaman status secara berkala.</p>
    <?php endif; ?>
    <a href="<?= base_url('mahasiswa/status') ?>" class="wz-btn-secondary"><i class="bi bi-clock-history"></i> Cek Status</a>
</div>

<?php elseif($state == 4): ?>
<!-- ============ TAMPILAN JIKA PERMOHONAN SUDAH DITERIMA/AKTIF (STATE 4) ============ -->
<div class="wizard-card text-center py-5">
    <div style="width: 80px; height: 80px; border-radius: 50%; background: #dcfce7; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 20px;">
        <i class="bi bi-check-circle-fill"></i>
    </div>
    <h5 class="fw-bold text-dark mb-2">Permohonan Disetujui & Aktif</h5>
    <p class="text-muted mx-auto mb-4" style="max-width:400px;">Kegiatan akademik Anda sudah disetujui. Anda tidak perlu mengajukan permohonan baru pada saat ini.</p>
    <a href="<?= base_url('mahasiswa/dashboard') ?>" class="wz-btn-primary"><i class="bi bi-house-door"></i> Ke Dashboard</a>
</div>

<?php elseif($state == 6): ?>
<!-- ============ TAMPILAN JIKA PERMOHONAN SEDANG REVISI (STATE 6) ============ -->
<div class="wizard-card text-center py-5">
    <div style="width: 80px; height: 80px; border-radius: 50%; background: #fef08a; color: #ca8a04; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 20px;">
        <i class="bi bi-pencil-square"></i>
    </div>
    <h5 class="fw-bold text-dark mb-2">Permohonan Perlu Revisi Berkas</h5>
    <p class="text-muted mx-auto mb-4" style="max-width:450px;">Berkas permohonan Anda sebelumnya dikembalikan oleh Sekretariat karena ada berkas yang tidak valid.<br><br>Anda <strong>tidak perlu membuat permohonan baru</strong>. Silakan kembali ke halaman <strong>Status Permohonan</strong> dan klik tombol Edit (Revisi) untuk mengunggah ulang berkas yang salah.</p>
    <a href="<?= base_url('mahasiswa/status') ?>" class="wz-btn-primary" style="background: #eab308; border-color: #ca8a04;"><i class="bi bi-card-checklist"></i> Pergi ke Halaman Status</a>
</div>

<?php else: ?>
<!-- ============ TAMPILAN FORM (STATE 1 - BARU, ATAU STATE 3 - DITOLAK/PERLU REVISI) ============ -->
<?php if($state == 3): ?>
<div class="alert alert-warning p-3 mb-4" style="font-size: 0.85rem; border-radius: 10px;">
    <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
    <strong>Permohonan Sebelumnya Ditolak:</strong> Anda dapat membuat pengajuan permohonan baru dengan mengisi kembali form di bawah ini.
</div>
<?php endif; ?>

<!-- ============ FORM WRAPPER ============ -->
<form action="<?= base_url('mahasiswa/permohonan/simpan') ?>" method="POST" enctype="multipart/form-data" id="formPermohonan" novalidate>
    <?= csrf_field() ?>

    <!-- ============ STEP 1: DATA PERMOHONAN ============ -->
    <div class="wizard-card wizard-step is-active" id="step-1">
        <div class="wz-section-title">
            <i class="bi bi-card-list text-primary"></i> Data Permohonan
        </div>

        <!-- Jenis Permohonan & Tujuan -->
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="wz-form-label">Jenis Permohonan <span class="text-danger">*</span></label>
                <div style="position:relative;">
                    <select class="wz-form-select" id="sel-jenis" onchange="if(this.value){document.getElementById('jenis_'+this.value).checked=true;}else{document.querySelectorAll('input[name=\'id_jenis_permohonan\']').forEach(r=>r.checked=false);} applyJenisCfg(this.value); document.getElementById('err-jenis').classList.add('d-none');">
                        <option value="">-- Pilih Jenis Permohonan --</option>
                        <option value="1" <?= old('id_jenis_permohonan')=='1'?'selected':'' ?>>Penelitian Skripsi / TA</option>
                        <option value="2" <?= old('id_jenis_permohonan')=='2'?'selected':'' ?>>Observasi / Pengambilan Data</option>
                        <option value="3" <?= old('id_jenis_permohonan')=='3'?'selected':'' ?>>Magang / PKL</option>
                        <option value="4" <?= old('id_jenis_permohonan')=='4'?'selected':'' ?>>Uji Coba Produk (Prototype)</option>
                    </select>
                    <!-- Hidden radio inputs for form submission -->
                    <input type="radio" name="id_jenis_permohonan" id="jenis_1" value="1" <?= old('id_jenis_permohonan')=='1'?'checked':'' ?> style="display:none;">
                    <input type="radio" name="id_jenis_permohonan" id="jenis_2" value="2" <?= old('id_jenis_permohonan')=='2'?'checked':'' ?> style="display:none;">
                    <input type="radio" name="id_jenis_permohonan" id="jenis_3" value="3" <?= old('id_jenis_permohonan')=='3'?'checked':'' ?> style="display:none;">
                    <input type="radio" name="id_jenis_permohonan" id="jenis_4" value="4" <?= old('id_jenis_permohonan')=='4'?'checked':'' ?> style="display:none;">
                </div>
                <div class="mt-2 d-none" id="err-jenis" style="color:#dc2626;font-size:0.8rem;">
                    <i class="bi bi-exclamation-circle me-1"></i>Jenis permohonan wajib dipilih.
                </div>
            </div>
            <div class="col-md-6">
                <label class="wz-form-label">Tujuan / Kegiatan</label>
                <input type="text" class="wz-form-control" id="tujuan-display" value="Pilih jenis permohonan terlebih dahulu" readonly style="background:#f1f5f9;color:#94a3b8;">
            </div>
        </div>

        <!-- Tanggal Mulai & Selesai -->
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="wz-form-label" for="tgl_mulai">Tanggal Mulai <span class="text-danger">*</span></label>
                <?php $errMulai = session('errors.tgl_mulai'); ?>
                <input type="date" class="wz-form-control <?= $errMulai ? 'is-invalid' : '' ?>" name="tgl_mulai" id="tgl_mulai" value="<?= old('tgl_mulai') ?>" onkeydown="return false" required>
                <?php if($errMulai): ?>
                    <div class="invalid-feedback d-block" style="font-size:0.75rem; font-weight: 500; margin-top: 4px; color: #dc3545;"><i class="bi bi-exclamation-circle me-1"></i> <?= esc($errMulai) ?></div>
                <?php endif; ?>
                <!-- Pesan error dinamis dari JS -->
                <div class="invalid-feedback d-none" id="err-tgl-mulai-js" style="font-size:0.75rem; font-weight: 500; margin-top: 4px; color: #dc3545;"></div>
            </div>
            <div class="col-md-6">
                <label class="wz-form-label" for="tgl_selesai">Tanggal Selesai <span class="text-danger">*</span></label>
                <?php $errSelesai = session('errors.tgl_selesai'); ?>
                <input type="date" class="wz-form-control <?= $errSelesai ? 'is-invalid' : '' ?>" name="tgl_selesai" id="tgl_selesai" value="<?= old('tgl_selesai') ?>" onkeydown="return false" required>
                <?php if($errSelesai): ?>
                    <div class="invalid-feedback d-block" style="font-size:0.75rem; font-weight: 500; margin-top: 4px; color: #dc3545;"><i class="bi bi-exclamation-circle me-1"></i> <?= esc($errSelesai) ?></div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Instansi & Program Studi -->
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="wz-form-label">Instansi / Universitas</label>
                <input type="text" class="wz-form-control" value="<?= esc(session()->get('kampus') ?? '-') ?>" readonly style="background:#f1f5f9;">
            </div>
            <div class="col-md-6">
                <label class="wz-form-label">Lokasi Kegiatan</label>
                <input type="text" class="wz-form-control" value="Dinas Kominfo Kota Tangerang" readonly style="background:#f1f5f9;">
            </div>
        </div>

        <!-- Deskripsi Keahlian -->
        <div class="mb-3">
            <label class="wz-form-label" id="lbl-keahlian">Keahlian / Skill <span class="text-danger">*</span></label>
            <textarea class="wz-form-control" name="deskripsi_keahlian" id="deskripsi_keahlian" rows="3" placeholder="Jelaskan keahlian atau kompetensi yang Anda miliki saat ini..." required maxlength="500" oninput="countChars(this,'cc-keahlian')"><?= old('deskripsi_keahlian') ?></textarea>
            <div class="char-counter"><span id="cc-keahlian">0</span>/500 karakter</div>
        </div>

        <!-- Deskripsi Magang -->
        <div class="mb-4">
            <label class="wz-form-label" id="lbl-magang">Deskripsi Rencana Magang <span class="text-danger">*</span></label>
            <textarea class="wz-form-control" name="deskripsi" id="deskripsi" rows="4" placeholder="Jelaskan maksud, tujuan, atau rencana topik yang ingin Anda ajukan..." required maxlength="1000" oninput="countChars(this,'cc-magang')"><?= old('deskripsi') ?></textarea>
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
            <i class="bi bi-file-earmark-arrow-up text-primary"></i> Unggah Dokumen
        </div>
        <p class="text-muted mb-4" style="font-size:0.84rem;line-height:1.7;margin-top:-8px;">
            Unggah dokumen dalam format <strong>PDF</strong>, ukuran maksimal <strong>2 MB</strong> per file.
        </p>

        <!-- Upload: Surat Pengantar -->
        <div class="mb-4">
            <label class="wz-form-label" id="lbl-surat">Surat Pengantar Resmi Kampus <span class="text-danger">*</span></label>
            <input class="form-control" type="file" name="surat_pengantar" id="input-surat" accept=".pdf" required>
            <div class="form-text mt-1" style="font-size:0.75rem;"><i class="bi bi-info-circle me-1"></i>Format: PDF | Maksimal ukuran: 2 MB</div>
        </div>

        <!-- Upload: CV / Proposal -->
        <div class="mb-4" id="wrapper-cv">
            <label class="wz-form-label" id="lbl-cv">Curriculum Vitae (CV) Terbaru <span class="text-danger">*</span></label>
            <input class="form-control" type="file" name="cv" id="input-cv" accept=".pdf">
            <div class="form-text mt-1" style="font-size:0.75rem;"><i class="bi bi-info-circle me-1"></i>Format: PDF | Maksimal ukuran: 2 MB</div>
        </div>

        <!-- Upload: KTM -->
        <div class="mb-4">
            <label class="wz-form-label" id="lbl-ktm">Kartu Tanda Mahasiswa (KTM) <span class="text-danger">*</span></label>
            <input class="form-control" type="file" name="ktm" id="input-ktm" accept=".pdf,.jpg,.jpeg,.png" required>
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
            <i class="bi bi-clipboard2-check text-primary"></i> Review
        </div>
        <p class="text-muted mb-4" style="font-size:0.84rem;margin-top:-8px;">
            Periksa kembali seluruh data. Setelah terkirim, data <strong>tidak dapat diubah</strong>.
        </p>

        <!-- Review: Identitas Pemohon -->
        <div class="review-data-card mb-3">
            <div class="rv-title"><i class="bi bi-person-badge text-primary"></i> Identitas Pemohon</div>
            <table class="rv-table">
                <tr><td style="width:140px;">Nama Lengkap</td><td class="rv-sep">:</td><td class="text-dark"><?= esc($mhs['nama_mahasiswa'] ?? '-') ?></td></tr>
                <tr><td>Nomor Induk (NIM)</td><td class="rv-sep">:</td><td><?= esc($mhs['nim'] ?? '-') ?></td></tr>
                <tr><td>NIK KTP</td><td class="rv-sep">:</td><td><?= esc($mhs['nik'] ?? '-') ?></td></tr>
                <tr><td>Nomor Telepon</td><td class="rv-sep">:</td><td><?= esc($mhs['no_telp'] ?? '-') ?></td></tr>
                <tr><td>Email</td><td class="rv-sep">:</td><td><?= esc($mhs['email'] ?? '-') ?></td></tr>
                <tr><td>Asal Kampus</td><td class="rv-sep">:</td><td><?= esc($instansi['instansi_pendidikan'] ?? '-') ?></td></tr>
                <tr><td>Program Studi</td><td class="rv-sep">:</td><td><?= esc($instansi['prodi'] ?? '-') ?></td></tr>
                <tr><td>Semester</td><td class="rv-sep">:</td><td><?= esc($instansi['semester'] ?? '-') ?></td></tr>
            </table>
        </div>

        <!-- Review: Data Permohonan -->
        <div class="review-data-card mb-4">
            <div class="rv-title"><i class="bi bi-card-list text-primary"></i> Data Permohonan</div>
            <table class="rv-table">
                <tr><td style="width:140px;">Jenis Permohonan</td><td class="rv-sep">:</td><td id="rv-jenis" class="text-dark">—</td></tr>
                <tr><td>Tujuan / Kegiatan</td><td class="rv-sep">:</td><td id="rv-tujuan" class="text-dark">—</td></tr>
                <tr><td>Tanggal Pelaksanaan</td><td class="rv-sep">:</td><td><span id="rv-tgl-mulai" class="text-dark">—</span> <span class="text-muted mx-1">s.d.</span> <span id="rv-tgl-selesai" class="text-dark">—</span></td></tr>
                <tr><td>Lokasi Kegiatan</td><td class="rv-sep">:</td><td class="text-dark">Dinas Kominfo Kota Tangerang</td></tr>
                <tr><td style="vertical-align:top; padding-top:10px;">Deskripsi Keahlian</td><td class="rv-sep" style="vertical-align:top; padding-top:10px;">:</td><td id="rv-keahlian" class="text-dark" style="white-space:pre-wrap; padding-top:10px;">—</td></tr>
                <tr><td id="rv-magang-label" style="vertical-align:top; padding-top:10px;">Deskripsi Rencana Kegiatan</td><td class="rv-sep" style="vertical-align:top; padding-top:10px;">:</td><td id="rv-magang" class="text-dark" style="white-space:pre-wrap; padding-top:10px;">—</td></tr>
            </table>
        </div>

        <!-- Review: Dokumen -->
        <div class="mb-4">
            <div class="fw-bold text-dark mb-3" style="font-size:0.88rem;">
                <i class="bi bi-file-earmark-pdf text-danger me-2"></i>Dokumen yang Diunggah
            </div>
            <table class="rv-doc-table">
                <thead>
                    <tr>
                        <th style="width:56px;">No</th>
                        <th>Dokumen yang Diunggah</th>
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
<?= $this->include('mahasiswa/V_PartWizardScript_Mahasiswa') ?>
<script>
// Sync select with tujuan display
var selJenis = document.getElementById('sel-jenis');
if(selJenis) {
    selJenis.addEventListener('change', function() {
        var cfg = JENIS_CFG[this.value];
        var td = document.getElementById('tujuan-display');
        if (cfg) {
            td.value = cfg.tujuan;
            td.style.color = 'var(--text-dark)';
            td.style.background = '#f1f5f9';
        } else {
            td.value = 'Pilih jenis permohonan terlebih dahulu';
            td.style.color = '#94a3b8';
        }
    });
    if (selJenis.value) selJenis.dispatchEvent(new Event('change'));
}

// ==========================================
// VALIDASI TANGGAL DINAMIS (FRONTEND)
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
    var tglMulai = document.getElementById('tgl_mulai');
    var tglSelesai = document.getElementById('tgl_selesai');

    if (tglMulai && tglSelesai) {
        var today = new Date();
        var yyyy = today.getFullYear();
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var dd = String(today.getDate()).padStart(2, '0');
        var todayStr = yyyy + '-' + mm + '-' + dd;
        tglMulai.setAttribute('min', todayStr);

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
            var isInvalid = false;
            
            if (jenis === '3') {
                if (diffDays < 60 || dateSelesai < dateMulai) {
                    isInvalid = true;
                    if (errDiv) {
                        errDiv.innerHTML = '<i class="bi bi-exclamation-circle me-1"></i> Durasi permohonan magang minimal adalah 2 bulan (60 hari).';
                    }
                }
            } else {
                if (diffDays <= 0 || dateSelesai < dateMulai) {
                    isInvalid = true;
                    if (errDiv) {
                        errDiv.innerHTML = '<i class="bi bi-exclamation-circle me-1"></i> Tanggal selesai harus setelah tanggal mulai.';
                    }
                }
            }

            if (isInvalid) {
                tglMulai.classList.add('is-invalid');
                tglSelesai.classList.add('is-invalid');
                if (errDiv) {
                    errDiv.classList.remove('d-none');
                    errDiv.classList.add('d-block');
                }
            } else {
                tglMulai.classList.remove('is-invalid');
                tglSelesai.classList.remove('is-invalid');
                if (errDiv) {
                    errDiv.classList.remove('d-block');
                    errDiv.classList.add('d-none');
                }
            }
        }

        tglMulai.addEventListener('change', function() {
            if (tglMulai.value) {
                var jenis = getSelectedJenis();
                var minDays = (jenis === '3') ? 60 : 1;
                var minSelesai = addDays(parseInputDate(tglMulai.value), minDays);
                var minSelesaiStr = formatInputDate(minSelesai);
                tglSelesai.setAttribute('min', minSelesaiStr);

                if (!tglSelesai.value || parseInputDate(tglSelesai.value) < minSelesai) {
                    tglSelesai.value = minSelesaiStr;
                }
            }
            validateDurasi();
        });

        tglSelesai.addEventListener('change', function() {
            if (tglMulai.value && tglSelesai.value) {
                var jenis = getSelectedJenis();
                var minDays = (jenis === '3') ? 60 : 1;
                var minSelesai = addDays(parseInputDate(tglMulai.value), minDays);
                var minSelesaiStr = formatInputDate(minSelesai);
                tglSelesai.setAttribute('min', minSelesaiStr);
                
                if (parseInputDate(tglSelesai.value) < minSelesai) {
                    tglSelesai.value = minSelesaiStr;
                }
            }
            validateDurasi();
        });
        
        // Re-validate when jenis permohonan changes
        document.querySelectorAll('input[name="id_jenis_permohonan"]').forEach(function(r) {
            r.addEventListener('change', function() {
                if (tglMulai.value) {
                    tglMulai.dispatchEvent(new Event('change'));
                }
            });
        });
    }
});
</script>
<?= $this->endSection() ?>