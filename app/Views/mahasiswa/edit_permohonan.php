<?= $this->extend('layout/mahasiswa') ?>

<?= $this->section('extra_css') ?>
<?= $this->include('mahasiswa/_wz_style') ?>
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
E-Kinerja Magang &raquo; <span class="text-uppercase" style="color: var(--primary-royal);">Form Permohonan</span>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h4 class="fw-bold text-dark m-0" style="letter-spacing: -0.3px;">Edit Draft Permohonan</h4>
    <p class="text-muted m-0 mt-1" style="font-size: 0.83rem;">Silakan lanjutkan atau perbarui data permohonan kegiatan akademik Anda.</p>
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
$isFinished = (session()->getFlashdata('permohonan_sent') || $state == 2 || $state >= 4);
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
    <?php if (isset($permohonan_aktif['disposisi']) && $permohonan_aktif['disposisi'] == '0'): ?>
        <h5 class="fw-bold text-dark mb-2">Menunggu Disposisi Sekretariat</h5>
        <p class="text-muted mx-auto mb-4" style="max-width:400px;">Berkas permohonan Anda dinyatakan valid dan saat ini sedang dalam proses penempatan atau disposisi bidang. Silakan pantau halaman status secara berkala.</p>
    <?php else: ?>
        <h5 class="fw-bold text-dark mb-2">Permohonan Sedang Diproses</h5>
        <p class="text-muted mx-auto mb-4" style="max-width:400px;">Permohonan Anda saat ini sedang dalam antrean verifikasi oleh tim Sekretariat Dinas Kominfo. Silakan pantau halaman status secara berkala.</p>
    <?php endif; ?>
    <a href="<?= base_url('mahasiswa/status') ?>" class="wz-btn-secondary"><i class="bi bi-clock-history"></i> Cek Status</a>
</div>

<?php elseif($state == 4 || $state == 5): ?>
<!-- ============ TAMPILAN JIKA PERMOHONAN SUDAH DITERIMA/AKTIF (STATE 4 ATAU 5) ============ -->
<div class="wizard-card text-center py-5">
    <div style="width: 80px; height: 80px; border-radius: 50%; background: #dcfce7; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 20px;">
        <i class="bi bi-check-circle-fill"></i>
    </div>
    <h5 class="fw-bold text-dark mb-2">Permohonan Disetujui & Aktif</h5>
    <p class="text-muted mx-auto mb-4" style="max-width:400px;">Kegiatan magang/akademik Anda sudah disetujui. Anda tidak perlu mengajukan permohonan baru pada saat ini.</p>
    <a href="<?= base_url('mahasiswa/dashboard') ?>" class="wz-btn-primary"><i class="bi bi-house-door"></i> Ke Dashboard</a>
</div>

<?php else: ?>
<!-- ============ TAMPILAN FORM (STATE 1 - BARU, ATAU STATE 3 - DITOLAK/PERLU REVISI) ============ -->
<?php if($state == 3): ?>
<div class="alert alert-warning p-3 mb-4" style="font-size: 0.85rem; border-radius: 10px;">
    <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
    <strong>Permohonan Sebelumnya Ditolak/Direvisi:</strong> Anda dapat mengajukan permohonan ulang dengan memperbaiki data atau berkas dokumen yang diunggah.
</div>
<?php endif; ?>

<!-- ============ FORM WRAPPER ============ -->
<form action="<?= base_url('mahasiswa/permohonan/update/' . $draft['id_permohonan_magang']) ?>" method="POST" enctype="multipart/form-data" id="formPermohonan" novalidate>
    <?= csrf_field() ?>

    <!-- ============ STEP 1: DATA PERMOHONAN ============ -->
    <div class="wizard-card wizard-step is-active" id="step-1">
        <div class="wz-section-title">
            <span style="width:32px;height:32px;border-radius:8px;background:#dbeafe;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi bi-card-list text-primary" style="font-size:0.95rem;"></i>
            </span>
            Data Permohonan
        </div>

        <!-- Jenis Permohonan & Tujuan -->
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="wz-form-label">Jenis Permohonan <span class="text-danger">*</span></label>
                <div style="position:relative;">
                    <select class="wz-form-select" id="sel-jenis" onchange="document.getElementById('jenis_'+this.value).checked=true;applyJenisCfg(this.value);document.getElementById('err-jenis').classList.add('d-none');">
                        <option value="">-- Pilih Jenis Permohonan --</option>
                        <option value="1" <?= old('id_jenis_permohonan', $draft['id_jenis_permohonan'])=='1'?'selected':'' ?>>Penelitian Skripsi / TA</option>
                        <option value="2" <?= old('id_jenis_permohonan', $draft['id_jenis_permohonan'])=='2'?'selected':'' ?>>Observasi / Pengambilan Data</option>
                        <option value="3" <?= old('id_jenis_permohonan', $draft['id_jenis_permohonan'])=='3'?'selected':'' ?>>Magang / PKL</option>
                        <option value="4" <?= old('id_jenis_permohonan', $draft['id_jenis_permohonan'])=='4'?'selected':'' ?>>Uji Coba Produk (Prototype)</option>
                    </select>
                    <!-- Hidden radio inputs for form submission -->
                    <input type="radio" name="id_jenis_permohonan" id="jenis_1" value="1" <?= old('id_jenis_permohonan', $draft['id_jenis_permohonan'])=='1'?'checked':'' ?> style="display:none;">
                    <input type="radio" name="id_jenis_permohonan" id="jenis_2" value="2" <?= old('id_jenis_permohonan', $draft['id_jenis_permohonan'])=='2'?'checked':'' ?> style="display:none;">
                    <input type="radio" name="id_jenis_permohonan" id="jenis_3" value="3" <?= old('id_jenis_permohonan', $draft['id_jenis_permohonan'])=='3'?'checked':'' ?> style="display:none;">
                    <input type="radio" name="id_jenis_permohonan" id="jenis_4" value="4" <?= old('id_jenis_permohonan', $draft['id_jenis_permohonan'])=='4'?'checked':'' ?> style="display:none;">
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
                <input type="date" class="wz-form-control" name="tgl_mulai" id="tgl_mulai" value="<?= old('tgl_mulai', $draft['tgl_mulai']) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="wz-form-label" for="tgl_selesai">Tanggal Selesai <span class="text-danger">*</span></label>
                <input type="date" class="wz-form-control" name="tgl_selesai" id="tgl_selesai" value="<?= old('tgl_selesai', $draft['tgl_selesai']) ?>" required>
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
            <label class="wz-form-label" id="lbl-keahlian">Deskripsi Keahlian / Skill <span class="text-danger">*</span></label>
            <textarea class="wz-form-control" name="deskripsi_keahlian" id="deskripsi_keahlian" rows="3" placeholder="Jelaskan keahlian atau kompetensi yang Anda miliki saat ini..." required maxlength="500" oninput="countChars(this,'cc-keahlian')"><?= old('deskripsi_keahlian', $draft['deskripsi_keahlian']) ?></textarea>
            <div class="char-counter"><span id="cc-keahlian">0</span>/500 karakter</div>
        </div>

        <!-- Deskripsi Magang -->
        <div class="mb-4">
            <label class="wz-form-label" id="lbl-magang">Deskripsi Rencana Magang / Kegiatan <span class="text-danger">*</span></label>
            <textarea class="wz-form-control" name="deskripsi_magang" id="deskripsi_magang" rows="4" placeholder="Jelaskan maksud, tujuan, atau rencana topik yang ingin Anda ajukan..." required maxlength="1000" oninput="countChars(this,'cc-magang')"><?= old('deskripsi_magang', $draft['deskripsi_magang']) ?></textarea>
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
            <span style="width:32px;height:32px;border-radius:8px;background:#dbeafe;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi bi-file-earmark-arrow-up text-primary" style="font-size:0.95rem;"></i>
            </span>
            Unggah Dokumen
        </div>
        <p class="text-muted mb-4" style="font-size:0.84rem;line-height:1.7;margin-top:-8px;">
            Unggah dokumen dalam format <strong>PDF</strong>, ukuran maksimal <strong>2 MB</strong> per file.
        </p>

        <!-- Upload: Surat Pengantar -->
        <div class="mb-4">
            <label class="wz-form-label" id="lbl-surat">Surat Pengantar Resmi Kampus <span class="text-muted fw-normal" style="font-size:0.75rem;">(Opsional)</span></label>
            <div class="upload-zone" id="zone-surat">
                <input type="file" name="surat_pengantar" id="input-surat" accept=".pdf">
                <div id="ph-surat">
                    <div class="upload-icon-wrap" style="background:#d1fae5;color:#059669;"><i class="bi bi-check-circle-fill"></i></div>
                    <div class="fw-semibold text-dark" style="font-size:0.9rem;">File tersimpan: <?= esc($draft['surat_pengantar']) ?></div>
                    <div class="text-muted mt-1" style="font-size:0.78rem;">Klik atau seret file PDF baru ke sini jika ingin mengganti.</div>
                </div>
                <div class="d-none" id="pv-surat">
                    <div class="upload-icon-wrap"><i class="bi bi-file-earmark-pdf"></i></div>
                    <div class="fw-bold text-dark" style="font-size:0.88rem;" id="nm-surat"></div>
                    <div class="mt-1" style="font-size:0.78rem;color:#059669;"><i class="bi bi-check-circle-fill me-1"></i>File siap diunggah</div>
                </div>
            </div>
        </div>

        <!-- Upload: CV / Proposal -->
        <div class="mb-4" id="wrapper-cv">
            <label class="wz-form-label" id="lbl-cv">Curriculum Vitae (CV) / Proposal <span class="text-muted fw-normal" style="font-size:0.75rem;">(Opsional)</span></label>
            <div class="upload-zone" id="zone-cv">
                <input type="file" name="cv" id="input-cv" accept=".pdf">
                <div id="ph-cv">
                    <div class="upload-icon-wrap" style="background:#d1fae5;color:#059669;"><i class="bi bi-check-circle-fill"></i></div>
                    <div class="fw-semibold text-dark" style="font-size:0.9rem;">File tersimpan: <?= esc($draft['cv']) ?></div>
                    <div class="text-muted mt-1" style="font-size:0.78rem;">Klik atau seret file PDF baru ke sini jika ingin mengganti.</div>
                </div>
                <div class="d-none" id="pv-cv">
                    <div class="upload-icon-wrap"><i class="bi bi-file-earmark-pdf"></i></div>
                    <div class="fw-bold text-dark" style="font-size:0.88rem;" id="nm-cv"></div>
                    <div class="mt-1" style="font-size:0.78rem;color:#059669;"><i class="bi bi-check-circle-fill me-1"></i>File siap diunggah</div>
                </div>
            </div>
        </div>

        <!-- Info Box -->
        <div class="info-box mb-4">
            <div class="fw-semibold text-dark mb-2" style="font-size:0.84rem;"><i class="bi bi-info-circle text-primary me-1"></i> Panduan Dokumen</div>
            <ul class="mb-0 ps-3 text-muted" style="font-size:0.8rem;line-height:1.9;">
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
            <span style="width:32px;height:32px;border-radius:8px;background:#dbeafe;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi bi-clipboard2-check text-primary" style="font-size:0.95rem;"></i>
            </span>
            Review
        </div>
        <p class="text-muted mb-4" style="font-size:0.84rem;margin-top:-8px;">
            Periksa kembali seluruh data. Setelah terkirim, data <strong>tidak dapat diubah</strong>.
        </p>

        <!-- Review: Data Permohonan -->
        <div class="review-data-card">
            <div class="rv-title"><i class="bi bi-card-list text-primary"></i> Data Permohonan</div>
            <table class="rv-table">
                <tr><td>Jenis Permohonan</td><td class="rv-sep">:</td><td id="rv-jenis">—</td></tr>
                <tr><td>Tujuan / Kegiatan</td><td class="rv-sep">:</td><td id="rv-tujuan">—</td></tr>
                <tr><td>Tanggal Mulai</td><td class="rv-sep">:</td><td id="rv-tgl-mulai">—</td></tr>
                <tr><td>Tanggal Selesai</td><td class="rv-sep">:</td><td id="rv-tgl-selesai">—</td></tr>
                <tr><td>Instansi / Universitas</td><td class="rv-sep">:</td><td><?= esc(session()->get('kampus') ?? '-') ?></td></tr>
                <tr><td>Lokasi Kegiatan</td><td class="rv-sep">:</td><td>Dinas Kominfo Kota Tangerang</td></tr>
                <tr><td>Deskripsi Keahlian</td><td class="rv-sep">:</td><td id="rv-keahlian" style="white-space:pre-wrap;">—</td></tr>
                <tr><td>Deskripsi Permohonan</td><td class="rv-sep">:</td><td id="rv-magang" style="white-space:pre-wrap;">—</td></tr>
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
<?= $this->include('mahasiswa/_wz_script') ?>
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

// Override vStep2 for Edit mode so files are optional
function vStep2() {
    return true; // Bypass strict file checking since files are already uploaded in draft
}

// Ensure the form starts at Step 1 and bypasses some strict JS checks on files
window.addEventListener('load', function() {
    // We start at step 1 as normal for reviewing the draft
    // But we override updateReviewData to show "Sudah diunggah (Draft)" instead of empty
    var oldUpdate = window.fillReview || window.updateReviewData;
    if (typeof fillReview === 'function') {
        window.fillReview = function() {
            var j = document.querySelector('input[name="id_jenis_permohonan"]:checked');
            var jVal = j ? j.value : null;
            document.getElementById('rv-jenis').textContent = j ? JENIS_LABELS[jVal] : '—';
            document.getElementById('rv-tujuan').textContent = j ? JENIS_CFG[jVal].tujuan : '—';
            document.getElementById('rv-tgl-mulai').textContent = fmtDate(document.getElementById('tgl_mulai').value);
            document.getElementById('rv-tgl-selesai').textContent = fmtDate(document.getElementById('tgl_selesai').value);
            document.getElementById('rv-keahlian').textContent = document.getElementById('deskripsi_keahlian').value || '—';
            document.getElementById('rv-magang').textContent = document.getElementById('deskripsi_magang').value || '—';

            var tb = document.getElementById('rv-doc-tbody');
            tb.innerHTML = '';
            
            var n = 1;
            var sr = document.getElementById('input-surat');
            var txtSurat = (sr.files && sr.files[0]) ? sr.files[0].name : '<?= esc($draft['surat_pengantar']) ?>';
            tb.innerHTML += '<tr><td class="text-muted">'+(n++)+'</td><td class="fw-semibold text-dark">Surat Pengantar</td><td class="text-end text-primary" style="font-size:0.8rem;">'+txtSurat+'</td></tr>';

            var wCv = document.getElementById('wrapper-cv');
            if (wCv.style.display !== 'none') {
                var cv = document.getElementById('input-cv');
                var txtCv = (cv.files && cv.files[0]) ? cv.files[0].name : '<?= esc($draft['cv']) ?>';
                var nm = jVal == '1' || jVal == '4' ? 'Proposal' : 'Curriculum Vitae (CV)';
                tb.innerHTML += '<tr><td class="text-muted">'+(n++)+'</td><td class="fw-semibold text-dark">'+nm+'</td><td class="text-end text-primary" style="font-size:0.8rem;">'+txtCv+'</td></tr>';
            }
        };
    }
});
</script>
<?= $this->endSection() ?>