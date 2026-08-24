<?php
/**
 * View: Kelola Dokumen (Partial – diinjeksikan via AJAX)
 * Path: app/Views/dashboard/kabid/v_upload_dokumen.php
 *
 * Menampilkan tabel 3 jenis dokumen dengan dropzone per baris.
 * Disubmit ke endpoint storeMulti() via AJAX FormData.
 */

// Map id_file berdasarkan nama_file dari $jenis_file
$fileMap = [];
foreach ($jenis_file as $jf) {
    $fileMap[$jf->nama_file] = $jf->id_file;
}

// Map dokumen yang sudah ada berdasarkan id_file
$existingMap = [];
foreach ($files as $f) {
    $existingMap[$f->id_file] = $f;
}

// Definisi 3 baris tabel (urutan tetap)
$dokumenList = [
    ['nama' => 'File Surat Keterangan Diterima Magang', 'slot' => 0],
    ['nama' => 'File Sertifikat',                        'slot' => 1],
    ['nama' => 'File Surat Keterangan Selesai Magang',   'slot' => 2],
];
?>

<style>
/* ===== Kelola Dokumen - Partial View Styles ===== */
.kd-header {
    border-bottom: 2px solid #E2E8F0;
    padding-bottom: 16px;
    margin-bottom: 20px;
}
.kd-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1B2559;
    margin: 0 0 4px 0;
}
.kd-subtitle {
    font-size: 0.85rem;
    color: #667085;
    margin: 0;
}
.kd-info-card {
    background: linear-gradient(135deg, #EFF6FF 0%, #F0F9FF 100%);
    border: 1px solid #BFDBFE;
    border-radius: 10px;
    padding: 14px 18px;
    margin-bottom: 22px;
}
.kd-info-card .info-label {
    font-size: 0.72rem;
    font-weight: 600;
    color: #3B82F6;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 2px;
}
.kd-info-card .info-value {
    font-size: 0.88rem;
    font-weight: 600;
    color: #1E3A5F;
}
.kd-section-title {
    font-size: 0.9rem;
    font-weight: 700;
    color: #334155;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.kd-section-title::before {
    content: '';
    width: 4px;
    height: 18px;
    background: linear-gradient(180deg, #3B82F6, #1D4ED8);
    border-radius: 3px;
    display: inline-block;
}

/* Table */
.kd-table thead th {
    background-color: #F8FAFC;
    color: #475569;
    font-size: 0.78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    border-top: none;
    border-bottom: 2px solid #E2E8F0;
    padding: 12px 14px;
}
.kd-table tbody td {
    vertical-align: middle;
    padding: 14px 14px;
    border-color: #F1F5F9;
    font-size: 0.875rem;
    color: #334155;
}
.kd-table tbody tr:hover {
    background-color: #FAFBFF;
}
.td-no {
    width: 50px;
    text-align: center;
    font-weight: 700;
    color: #64748B;
}
.td-nama {
    min-width: 220px;
    font-weight: 500;
}

/* Dropzone */
.kd-dropzone {
    border: 2px dashed #CBD5E1;
    border-radius: 10px;
    padding: 16px 14px;
    text-align: center;
    cursor: pointer;
    transition: all 0.25s ease;
    background: #FAFCFF;
    position: relative;
    min-height: 100px;
}
.kd-dropzone:hover,
.kd-dropzone.drag-over {
    border-color: #3B82F6;
    background-color: #EFF6FF;
}
.kd-dropzone .dz-icon {
    font-size: 1.6rem;
    color: #94A3B8;
    margin-bottom: 6px;
    display: block;
    transition: color 0.2s;
}
.kd-dropzone:hover .dz-icon {
    color: #3B82F6;
}
.kd-dropzone .dz-text {
    font-size: 0.78rem;
    color: #64748B;
    margin-bottom: 3px;
}
.kd-dropzone .dz-hint {
    font-size: 0.7rem;
    color: #94A3B8;
    margin-bottom: 8px;
}
.kd-dropzone .btn-pilih-file {
    font-size: 0.75rem;
    padding: 5px 14px;
    border-radius: 6px;
    border: 1.5px solid #3B82F6;
    color: #3B82F6;
    background: white;
    font-weight: 600;
    transition: all 0.2s;
    cursor: pointer;
}
.kd-dropzone .btn-pilih-file:hover {
    background: #3B82F6;
    color: white;
}

/* File selected state */
.kd-file-selected {
    border: 2px solid #22C55E;
    background: #F0FDF4;
    border-radius: 10px;
    padding: 12px 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    min-height: 100px;
}
.kd-file-selected .file-icon {
    color: #16A34A;
    font-size: 1.3rem;
    flex-shrink: 0;
}
.kd-file-selected .file-info {
    flex: 1;
    min-width: 0;
}
.kd-file-selected .file-name {
    font-size: 0.8rem;
    font-weight: 600;
    color: #15803D;
    word-break: break-all;
    margin-bottom: 2px;
}
.kd-file-selected .file-size {
    font-size: 0.7rem;
    color: #4ADE80;
}
.kd-file-selected .btn-remove-file {
    border: none;
    background: none;
    color: #94A3B8;
    font-size: 1rem;
    cursor: pointer;
    padding: 2px 6px;
    border-radius: 4px;
    flex-shrink: 0;
    transition: all 0.2s;
}
.kd-file-selected .btn-remove-file:hover {
    background: #FEE2E2;
    color: #EF4444;
}

/* Existing file state */
.kd-file-existing {
    border: 2px solid #BFDBFE;
    background: #EFF6FF;
    border-radius: 10px;
    padding: 12px 14px;
    min-height: 100px;
}
.kd-file-existing .exist-label {
    font-size: 0.68rem;
    font-weight: 700;
    color: #3B82F6;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 4px;
}
.kd-file-existing .exist-name {
    font-size: 0.8rem;
    font-weight: 600;
    color: #1E40AF;
    word-break: break-all;
    margin-bottom: 8px;
}
.kd-file-existing .exist-actions {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
}
.btn-ganti-existing {
    font-size: 0.72rem;
    padding: 4px 10px;
    border-radius: 6px;
    border: 1.5px solid #F59E0B;
    color: #D97706;
    background: white;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-ganti-existing:hover {
    background: #FEF3C7;
}
.btn-download-existing {
    font-size: 0.72rem;
    padding: 4px 10px;
    border-radius: 6px;
    border: 1.5px solid #CBD5E1;
    color: #64748B;
    background: white;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.btn-download-existing:hover {
    background: #F8FAFC;
    color: #334155;
    text-decoration: none;
}

/* Validation error */
.kd-error-msg {
    font-size: 0.72rem;
    color: #EF4444;
    margin-top: 4px;
    display: flex;
    align-items: center;
    gap: 4px;
}

/* Catatan */
.kd-catatan textarea {
    border-radius: 8px;
    border: 1.5px solid #E2E8F0;
    font-size: 0.875rem;
    color: #334155;
    padding: 10px 14px;
    transition: border-color 0.2s;
    resize: vertical;
}
.kd-catatan textarea:focus {
    border-color: #3B82F6;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    outline: none;
}

/* Action Buttons */
.kd-actions {
    padding-top: 16px;
    border-top: 1px solid #F1F5F9;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}
.btn-kd-batal {
    padding: 9px 22px;
    border-radius: 8px;
    border: 1.5px solid #CBD5E1;
    background: white;
    color: #64748B;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-kd-batal:hover {
    background: #F8FAFC;
    border-color: #94A3B8;
    color: #334155;
}
.btn-kd-simpan {
    padding: 9px 24px;
    border-radius: 8px;
    border: none;
    background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
    color: white;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 2px 8px rgba(59,130,246,0.35);
}
.btn-kd-simpan:hover:not(:disabled) {
    background: linear-gradient(135deg, #2563EB 0%, #1E3A8A 100%);
    box-shadow: 0 4px 12px rgba(59,130,246,0.45);
    transform: translateY(-1px);
}
.btn-kd-simpan:disabled {
    opacity: 0.65;
    cursor: not-allowed;
    transform: none;
}
</style>

<div class="kd-header d-flex justify-content-between align-items-start">
    <div>
        <h5 class="kd-title"><i class="fas fa-folder-open mr-2" style="color:#3B82F6;"></i>Kelola Dokumen</h5>
        <p class="kd-subtitle">Kelola dan unggah dokumen yang diperlukan untuk kegiatan magang.</p>
    </div>
    <button type="button" class="btn btn-sm btn-outline-secondary" id="btnKembaliList" style="border-radius:7px; font-size:0.8rem;">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
    </button>
</div>

<!-- Info Mahasiswa -->
<div class="kd-info-card">
    <div class="row">
        <div class="col-md-3 col-6 mb-2 mb-md-0">
            <div class="info-label">Nama Mahasiswa</div>
            <div class="info-value"><?= esc($persetujuan->nama_mahasiswa ?? '-') ?></div>
        </div>
        <div class="col-md-2 col-6 mb-2 mb-md-0">
            <div class="info-label">NIM</div>
            <div class="info-value"><?= esc($persetujuan->nim ?? '-') ?></div>
        </div>
        <div class="col-md-4 col-12 mb-2 mb-md-0">
            <div class="info-label">Asal Instansi</div>
            <div class="info-value"><?= esc($persetujuan->instansi_pendidikan ?? '-') ?></div>
        </div>
        <div class="col-md-3 col-12">
            <div class="info-label">Status</div>
            <div class="info-value">
                <?php if (($persetujuan->status_penempatan ?? '') === 'SELESAI'): ?>
                    <span class="badge badge-success">Selesai</span>
                <?php else: ?>
                    <span class="badge badge-primary">Aktif / Berjalan</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Form Kelola Dokumen -->
<form id="formKelolaMulti" enctype="multipart/form-data" novalidate>
    <?= csrf_field() ?>
    <input type="hidden" name="id_persetujuan_magang" value="<?= esc($persetujuan->id_persetujuan_magang) ?>">

    <!-- Tabel Dokumen -->
    <div class="kd-section-title">Tabel Dokumen</div>

    <div class="table-responsive mb-4">
        <table class="table table-bordered kd-table" style="min-width: 560px;">
            <thead>
                <tr>
                    <th class="td-no">NO</th>
                    <th>Nama Dokumen</th>
                    <th style="width: 320px; text-align: center;">Upload</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dokumenList as $dok):
                    $slot    = $dok['slot'];
                    $nama    = $dok['nama'];
                    $id_file = $fileMap[$nama] ?? null;
                    $exists  = $id_file ? ($existingMap[$id_file] ?? null) : null;
                ?>
                <tr>
                    <td class="td-no"><?= $slot + 1 ?></td>
                    <td class="td-nama">
                        <?= esc($nama) ?>
                        <?php if ($id_file): ?>
                            <input type="hidden" name="id_file_<?= $slot ?>" value="<?= esc($id_file) ?>">
                        <?php endif; ?>
                    </td>
                    <td>
                        <!-- Hidden file input -->
                        <input type="file"
                               name="file_<?= $slot ?>"
                               id="fileInput_<?= $slot ?>"
                               accept=".pdf,.doc,.docx"
                               style="display: none;">

                        <?php if ($exists): ?>
                        <!-- === Status: File Sudah Ada === -->
                        <div class="kd-file-existing" id="existingArea_<?= $slot ?>">
                            <div class="exist-label">
                                <i class="fas fa-check-circle"></i> File Tersedia
                            </div>
                            <div class="exist-name" title="<?= esc($exists->nama_file) ?>">
                                <i class="fas fa-file-alt mr-1" style="color:#3B82F6;"></i>
                                <?= esc($exists->nama_file) ?>
                            </div>
                            <div class="exist-actions">
                                <button type="button" class="btn-ganti-existing"
                                        onclick="triggerGantiFile(<?= $slot ?>)"
                                        id="btnGanti_<?= $slot ?>">
                                    <i class="fas fa-sync-alt mr-1"></i>Ganti File
                                </button>
                                <a href="<?= base_url('kabid/upload-dokumen/download/' . $exists->id_file_selesai_magang) ?>"
                                   class="btn-download-existing" target="_blank">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </div>
                        </div>
                        <!-- Dropzone Ganti (tersembunyi, muncul saat klik Ganti File) -->
                        <div id="dropzone_<?= $slot ?>" class="kd-dropzone" style="display: none;" onclick="document.getElementById('fileInput_<?= $slot ?>').click()">
                            <i class="fas fa-cloud-upload-alt dz-icon"></i>
                            <div class="dz-text">Pilih file pengganti atau tarik ke sini</div>
                            <div class="dz-hint">PDF, DOC, DOCX &bull; Maks. 5 MB</div>
                            <button type="button" class="btn-pilih-file" onclick="event.stopPropagation(); document.getElementById('fileInput_<?= $slot ?>').click()">
                                <i class="fas fa-folder-open mr-1"></i> Pilih File
                            </button>
                        </div>

                        <?php else: ?>
                        <!-- === Status: Belum Ada File === -->
                        <div id="dropzone_<?= $slot ?>" class="kd-dropzone"
                             ondragover="handleDragOver(event, <?= $slot ?>)"
                             ondragleave="handleDragLeave(event, <?= $slot ?>)"
                             ondrop="handleDrop(event, <?= $slot ?>)"
                             onclick="document.getElementById('fileInput_<?= $slot ?>').click()">
                            <i class="fas fa-cloud-upload-alt dz-icon"></i>
                            <div class="dz-text">Klik atau tarik file ke sini</div>
                            <div class="dz-hint">PDF, DOC, DOCX &bull; Maks. 5 MB</div>
                            <button type="button" class="btn-pilih-file" onclick="event.stopPropagation(); document.getElementById('fileInput_<?= $slot ?>').click()">
                                <i class="fas fa-folder-open mr-1"></i> Pilih File
                            </button>
                        </div>
                        <?php endif; ?>

                        <!-- Preview setelah file dipilih -->
                        <div id="selectedArea_<?= $slot ?>" class="kd-file-selected" style="display: none;">
                            <i class="fas fa-file-check file-icon"></i>
                            <div class="file-info">
                                <div class="file-name" id="selectedName_<?= $slot ?>"></div>
                                <div class="file-size" id="selectedSize_<?= $slot ?>"></div>
                            </div>
                            <button type="button" class="btn-remove-file"
                                    onclick="removeFile(<?= $slot ?>, <?= $exists ? 'true' : 'false' ?>)"
                                    title="Hapus pilihan">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <!-- Pesan validasi error -->
                        <div id="errorMsg_<?= $slot ?>" class="kd-error-msg" style="display: none;">
                            <i class="fas fa-exclamation-circle"></i>
                            <span></span>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Catatan Opsional -->
    <div class="kd-catatan mb-4">
        <div class="kd-section-title">Catatan <span style="font-size:0.75rem; font-weight:400; color:#94A3B8; text-transform:none; letter-spacing:0;">(opsional)</span></div>
        <textarea name="catatan"
                  id="catatanDokumen"
                  class="form-control"
                  rows="3"
                  placeholder="Tulis catatan jika diperlukan...."></textarea>
    </div>

    <!-- Tombol Aksi -->
    <div class="kd-actions">
        <button type="button" class="btn-kd-batal" id="btnKembaliListBawah">
            <i class="fas fa-times mr-1"></i> Batal
        </button>
        <button type="submit" class="btn-kd-simpan" id="btnSimpanDokumen">
            <i class="fas fa-save"></i> Simpan
        </button>
    </div>
</form>

<script>
(function () {
    'use strict';

    var ALLOWED_EXT  = ['pdf', 'doc', 'docx'];
    var MAX_SIZE_MB  = 5;
    var MAX_SIZE_B   = MAX_SIZE_MB * 1024 * 1024;

    // --- File Input Change ---
    [0, 1, 2].forEach(function (slot) {
        var input = document.getElementById('fileInput_' + slot);
        if (input) {
            input.addEventListener('change', function () {
                if (this.files && this.files[0]) {
                    handleFileSelected(slot, this.files[0]);
                }
            });
        }
    });

    // --- Drag & Drop ---
    window.handleDragOver = function (e, slot) {
        e.preventDefault();
        e.stopPropagation();
        var dz = document.getElementById('dropzone_' + slot);
        if (dz) dz.classList.add('drag-over');
    };

    window.handleDragLeave = function (e, slot) {
        e.preventDefault();
        e.stopPropagation();
        var dz = document.getElementById('dropzone_' + slot);
        if (dz) dz.classList.remove('drag-over');
    };

    window.handleDrop = function (e, slot) {
        e.preventDefault();
        e.stopPropagation();
        var dz = document.getElementById('dropzone_' + slot);
        if (dz) dz.classList.remove('drag-over');
        var files = e.dataTransfer.files;
        if (files && files[0]) {
            // Assign ke input agar ikut form
            var input = document.getElementById('fileInput_' + slot);
            var dt = new DataTransfer();
            dt.items.add(files[0]);
            input.files = dt.files;
            handleFileSelected(slot, files[0]);
        }
    };

    // --- Trigger Ganti File (untuk baris yang sudah ada file) ---
    window.triggerGantiFile = function (slot) {
        var existingArea = document.getElementById('existingArea_' + slot);
        var dropzone     = document.getElementById('dropzone_' + slot);
        if (existingArea) existingArea.style.display = 'none';
        if (dropzone) {
            dropzone.style.display = '';
            // Tambah drag & drop listener
            dropzone.setAttribute('ondragover', 'handleDragOver(event,' + slot + ')');
            dropzone.setAttribute('ondragleave', 'handleDragLeave(event,' + slot + ')');
            dropzone.setAttribute('ondrop', 'handleDrop(event,' + slot + ')');
            dropzone.onclick = function () {
                document.getElementById('fileInput_' + slot).click();
            };
        }
    };

    // --- Handle File Selected ---
    function handleFileSelected(slot, file) {
        clearError(slot);

        // Validasi ekstensi
        var ext = file.name.split('.').pop().toLowerCase();
        if (ALLOWED_EXT.indexOf(ext) === -1) {
            showError(slot, 'Format file tidak didukung. Gunakan PDF, DOC, atau DOCX.');
            clearInput(slot);
            return;
        }

        // Validasi ukuran
        if (file.size > MAX_SIZE_B) {
            showError(slot, 'Ukuran file melebihi 5 MB (' + formatFileSize(file.size) + ').');
            clearInput(slot);
            return;
        }

        // Sembunyikan dropzone & existing, tampilkan preview
        hideDropzoneAndExisting(slot);
        showSelectedArea(slot, file);
    }

    function hideDropzoneAndExisting(slot) {
        var dz = document.getElementById('dropzone_' + slot);
        var ea = document.getElementById('existingArea_' + slot);
        if (dz) dz.style.display = 'none';
        if (ea) ea.style.display = 'none';
    }

    function showSelectedArea(slot, file) {
        var area = document.getElementById('selectedArea_' + slot);
        var nameEl = document.getElementById('selectedName_' + slot);
        var sizeEl = document.getElementById('selectedSize_' + slot);
        if (area) area.style.display = 'flex';
        if (nameEl) nameEl.textContent = file.name;
        if (sizeEl) sizeEl.textContent = formatFileSize(file.size);
    }

    // --- Remove File ---
    window.removeFile = function (slot, hasExisting) {
        clearInput(slot);
        clearError(slot);

        var area = document.getElementById('selectedArea_' + slot);
        if (area) area.style.display = 'none';

        if (hasExisting === true || hasExisting === 'true') {
            // Tampilkan kembali existing area
            var ea = document.getElementById('existingArea_' + slot);
            if (ea) ea.style.display = '';
        } else {
            // Tampilkan kembali dropzone kosong
            var dz = document.getElementById('dropzone_' + slot);
            if (dz) dz.style.display = '';
        }
    };

    function clearInput(slot) {
        var input = document.getElementById('fileInput_' + slot);
        if (input) {
            input.value = '';
        }
    }

    function showError(slot, msg) {
        var el = document.getElementById('errorMsg_' + slot);
        if (el) {
            el.querySelector('span').textContent = msg;
            el.style.display = 'flex';
        }
    }

    function clearError(slot) {
        var el = document.getElementById('errorMsg_' + slot);
        if (el) el.style.display = 'none';
    }

    function formatFileSize(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
    }

    // --- Submit Form via AJAX ---
    document.getElementById('formKelolaMulti').addEventListener('submit', function (e) {
        e.preventDefault();

        var hasFile = false;
        for (var i = 0; i <= 2; i++) {
            var input = document.getElementById('fileInput_' + i);
            if (input && input.files && input.files[0]) {
                hasFile = true;
                break;
            }
        }

        Swal.fire({
            title: hasFile ? 'Simpan Dokumen?' : 'Simpan Tanpa Perubahan File?',
            text: hasFile
                ? 'Pastikan dokumen yang diunggah sudah benar sebelum disimpan.'
                : 'Tidak ada file baru yang dipilih. Lanjutkan menyimpan catatan saja?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3B82F6',
            cancelButtonColor: '#94A3B8',
            confirmButtonText: '<i class="fas fa-save mr-1"></i> Ya, Simpan',
            cancelButtonText: 'Batal'
        }).then(function (result) {
            if (!result.isConfirmed) return;

            var btn = document.getElementById('btnSimpanDokumen');
            var originalHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';

            var formData = new FormData(document.getElementById('formKelolaMulti'));

            $.ajax({
                url: '<?= base_url('kabid/upload-dokumen/store-multi') ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    if (res.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: res.message,
                            icon: 'success',
                            confirmButtonColor: '#3B82F6'
                        }).then(function () {
                            // Reload bagian detail untuk tampilkan status terbaru
                            var idPersetujuan = $('input[name="id_persetujuan_magang"]').val();
                            var targetBtn = $('.btn-kelola-dokumen[data-id="' + idPersetujuan + '"]');
                            if (targetBtn.length) {
                                targetBtn.click();
                            } else {
                                $('#btnKembaliList').click();
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            html: res.message,
                            icon: 'error',
                            confirmButtonColor: '#EF4444'
                        });
                        btn.disabled = false;
                        btn.innerHTML = originalHtml;
                    }
                },
                error: function () {
                    Swal.fire('Gagal!', 'Terjadi kesalahan jaringan. Silakan coba lagi.', 'error');
                    btn.disabled = false;
                    btn.innerHTML = originalHtml;
                }
            });
        });
    });

    // Kembali (tombol bawah)
    document.getElementById('btnKembaliListBawah').addEventListener('click', function () {
        document.getElementById('btnKembaliList').click();
    });

})();
</script>
