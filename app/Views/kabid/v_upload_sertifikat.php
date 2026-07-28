<?= $this->extend('layout/L_master'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="mb-4">
        <div class="d-flex align-items-center mb-1">
            <a href="<?= base_url('sekretariat/c_kabid/sertifikat') ?>" class="mr-3" style="color: #4a90e2; font-size: 1.2rem;">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h3 class="text-dark font-weight-bold mb-0">UPLOAD SERTIFIKAT MAGANG</h3>
        </div>
        <p class="text-muted mb-0 ml-4 pl-2">Unggah file sertifikat magang dalam format PDF yang telah diterbitkan.</p>
    </div>

    <!-- Card: Informasi Permohonan -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 14px;">
        <div class="card-body p-4">
            <div style="display: flex; align-items: center; margin-bottom: 1.5rem;">
                <div style="width: 42px; height: 42px; border-radius: 10px; background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%); display: flex; align-items: center; justify-content: center; margin-right: 0.75rem;">
                    <i class="fas fa-user-graduate" style="color: #fff; font-size: 1.1rem;"></i>
                </div>
                <div>
                    <h5 class="text-dark font-weight-bold mb-0" style="font-size: 1.05rem;">Informasi Permohonan</h5>
                    <small class="text-muted">Data permohonan magang yang telah disetujui</small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <small class="text-muted d-block mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Nama Mahasiswa</small>
                    <p class="text-dark font-weight-bold mb-0" style="font-size: 14px;"><?= esc($nama_mahasiswa); ?></p>
                </div>
                <div class="col-md-6 mb-3">
                    <small class="text-muted d-block mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">NIM</small>
                    <p class="text-dark font-weight-bold mb-0" style="font-size: 14px;"><?= esc($nim); ?></p>
                </div>
                <div class="col-md-6 mb-3">
                    <small class="text-muted d-block mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Kegiatan</small>
                    <p class="text-dark font-weight-bold mb-0" style="font-size: 14px;">
                        <span class="badge" style="background-color: #e8f4fd; color: #1a73e8; padding: 5px 12px; border-radius: 6px; font-weight: 600; font-size: 12px;">
                            <?= esc($kegiatan); ?>
                        </span>
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <small class="text-muted d-block mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Periode</small>
                    <p class="text-dark font-weight-bold mb-0" style="font-size: 14px;">
                        <i class="fas fa-calendar-alt mr-1" style="color: #4a90e2; font-size: 12px;"></i>
                        <?= esc($periode); ?>
                    </p>
                </div>
                <div class="col-md-12 mb-0">
                    <small class="text-muted d-block mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Bidang</small>
                    <p class="text-dark font-weight-bold mb-0" style="font-size: 14px;">
                        <i class="fas fa-building mr-1" style="color: #4a90e2; font-size: 12px;"></i>
                        <?= esc($bidang); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Card: Upload Sertifikat -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 14px;">
        <div class="card-body p-4">
            <div style="display: flex; align-items: center; margin-bottom: 1.5rem;">
                <div style="width: 42px; height: 42px; border-radius: 10px; background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%); display: flex; align-items: center; justify-content: center; margin-right: 0.75rem;">
                    <i class="fas fa-file-upload" style="color: #fff; font-size: 1.1rem;"></i>
                </div>
                <div>
                    <h5 class="text-dark font-weight-bold mb-0" style="font-size: 1.05rem;">Upload Sertifikat</h5>
                    <small class="text-muted">Unggah file sertifikat magang Anda</small>
                </div>
            </div>

            <?php if (empty($sertifikat)): ?>
            <!-- ============================================= -->
            <!-- BELUM ADA SERTIFIKAT — Tampilkan area upload   -->
            <!-- ============================================= -->
            <div id="uploadSection">
                
                <div class="table-responsive mt-3">
                    <table class="table table-borderless" style="border: 0; border-radius: 8px; overflow: hidden;">
                        <thead style="background-color: #dfd8d8; color: #495057; font-size: 14px;">
                            <tr>
                                <th class="text-center align-middle" style="width: 70px; padding: 15px; font-weight: 700;">NO</th>
                                <th class="align-middle" style="padding: 15px; font-weight: 700;">Nama Dokumen</th>
                                <th class="text-center align-middle" style="width: 250px; padding: 15px; font-weight: 700;">Upload</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Baris 1: Surat Keterangan -->
                            <tr style="background-color: #ffffff; border-bottom: 2px solid #fdf8f8;">
                                <td class="text-center align-middle font-weight-bold" style="color: #6c757d; font-size: 14px; padding: 15px;">1</td>
                                <td class="align-middle font-weight-bold" style="color: #7b8595; font-size: 14px; padding: 15px;">Surat Keterangan Selesai Magang</td>
                                <td class="text-center align-middle" style="padding: 15px;">
                                    <div class="upload-area upload-area-sm mx-auto" id="uploadAreaSurat" style="border: 1px dashed #4a90e2; border-radius: 4px; padding: 8px 15px; cursor: pointer; background-color: #fcfdfe; width: fit-content; min-width: 200px;">
                                        <input type="file" id="fileSurat" accept=".pdf" style="display: none;">
                                        <div class="d-flex align-items-center justify-content-center" style="color: #4a90e2; font-size: 11px; font-weight: 700;">
                                            <i class="fas fa-file-upload mr-2" style="font-size: 13px;"></i> Pilih File atau tarik ke sini
                                        </div>
                                    </div>
                                    <div id="fileInfoSurat" class="mt-2 text-left" style="display: none; background-color: #d4edda; padding: 5px 10px; border-radius: 4px;">
                                        <small class="font-weight-bold text-success d-block text-truncate" id="fileNameSurat" style="max-width: 200px;">-</small>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Baris 2: Sertifikat Magang -->
                            <tr style="background-color: #fefafa;">
                                <td class="text-center align-middle font-weight-bold" style="color: #6c757d; font-size: 14px; padding: 15px;">2</td>
                                <td class="align-middle font-weight-bold" style="color: #7b8595; font-size: 14px; padding: 15px;">Sertifikat Magang</td>
                                <td class="text-center align-middle" style="padding: 15px;">
                                    <div class="upload-area upload-area-sm mx-auto" id="uploadArea" style="border: 1px dashed #4a90e2; border-radius: 4px; padding: 8px 15px; cursor: pointer; background-color: #fcfdfe; width: fit-content; min-width: 200px;">
                                        <input type="file" id="fileSertifikat" name="file_sertifikat" accept=".pdf" style="display: none;">
                                        <div class="d-flex align-items-center justify-content-center" style="color: #4a90e2; font-size: 11px; font-weight: 700;">
                                            <i class="fas fa-file-upload mr-2" style="font-size: 13px;"></i> Pilih File atau tarik ke sini
                                        </div>
                                    </div>
                                    <div id="fileInfo" class="mt-2 text-left" style="display: none; background-color: #d4edda; padding: 5px 10px; border-radius: 4px;">
                                        <small class="font-weight-bold text-success d-block text-truncate" id="fileName" style="max-width: 200px;">-</small>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Error validasi client-side -->
                <div id="validationError" class="mt-3" style="display: none;">
                    <div class="alert alert-danger rounded-lg px-4 py-3 border-0 mb-0 d-flex align-items-center" style="border-radius: 10px !important;">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <span id="validationMessage"></span>
                    </div>
                </div>

                <!-- Tombol Upload -->
                <div class="mt-4 text-right">
                    <button type="button" class="btn font-weight-bold px-4 py-2" id="btnUpload"
                            style="background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%); color: #fff; border: none; border-radius: 8px; font-size: 14px; transition: all 0.3s; box-shadow: 0 4px 15px rgba(74,144,226,0.3);"
                            disabled>
                        <i class="fas fa-upload mr-2"></i>Upload File
                    </button>
                </div>
            </div>

            <?php else: ?>
            <!-- ============================================= -->
            <!-- SUDAH ADA SERTIFIKAT — Tampilkan informasi     -->
            <!-- ============================================= -->
            <div id="existingSection">
                <div class="p-4" style="background-color: #f0f7ff; border-radius: 12px; border: 1px solid #d0e3f7;">
                    <div class="d-flex align-items-center mb-3">
                        <div class="mr-3" style="width: 52px; height: 52px; border-radius: 12px; background: linear-gradient(135deg, #e74c3c, #c0392b); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-file-pdf" style="color: #fff; font-size: 1.5rem;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="font-weight-bold text-dark mb-0" style="font-size: 14px;">
                                <?= esc($sertifikat['nama_file']); ?>
                            </p>
                            <small class="text-muted">
                                <i class="fas fa-clock mr-1"></i>
                                Diupload pada <?= date('d M Y, H:i', strtotime($sertifikat['updated_at'] ?? $sertifikat['created_at'])); ?> WIB
                            </small>
                        </div>
                        <span class="badge" style="background-color: #d4edda; color: #155724; padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 600;">
                            <i class="fas fa-check-circle mr-1"></i>Terunggah
                        </span>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-flex flex-wrap" style="gap: 0.5rem;">
                        <a href="<?= base_url('sekretariat/upload-sertifikat/lihat/' . $sertifikat['id_file_selesai_magang']) ?>"
                           target="_blank"
                           class="btn btn-sm font-weight-bold"
                           style="background-color: #4a90e2; color: #fff; border: none; border-radius: 8px; padding: 8px 16px; font-size: 13px;">
                            <i class="fas fa-eye mr-1"></i>Lihat Sertifikat
                        </a>
                        <a href="<?= base_url('sekretariat/upload-sertifikat/download/' . $sertifikat['id_file_selesai_magang']) ?>"
                           class="btn btn-sm font-weight-bold"
                           style="background-color: #27ae60; color: #fff; border: none; border-radius: 8px; padding: 8px 16px; font-size: 13px;">
                            <i class="fas fa-download mr-1"></i>Download
                        </a>
                        <button type="button" class="btn btn-sm font-weight-bold" id="btnShowGanti"
                                style="background-color: #f39c12; color: #fff; border: none; border-radius: 8px; padding: 8px 16px; font-size: 13px;">
                            <i class="fas fa-sync-alt mr-1"></i>Ganti File
                        </button>
                    </div>
                </div>

                <!-- Form Ganti File (hidden by default) -->
                <div id="gantiSection" class="mt-4" style="display: none;">
                    <div class="p-4" style="background-color: #fff8e1; border-radius: 12px; border: 1px solid #ffe082;">
                        <h6 class="font-weight-bold text-dark mb-3">
                            <i class="fas fa-exchange-alt mr-2" style="color: #f39c12;"></i>Ganti File Sertifikat
                        </h6>

                        <div class="upload-area upload-area-sm" id="gantiUploadArea">
                            <input type="file" id="gantiFileSertifikat" name="file_sertifikat" accept=".pdf" style="display: none;">
                            <div class="mb-2">
                                <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: #f39c12;"></i>
                            </div>
                            <p class="text-dark font-weight-bold mb-1" style="font-size: 13px;">Klik untuk memilih file baru</p>
                            <p class="text-muted small mb-0">Format PDF, Maks. 2MB</p>
                        </div>

                        <div id="gantiFileInfo" class="mt-3" style="display: none;">
                            <div class="d-flex align-items-center p-3" style="background-color: #fff; border-radius: 10px; border: 1px solid #ffe082;">
                                <div class="mr-3" style="width: 40px; height: 40px; border-radius: 8px; background: linear-gradient(135deg, #e74c3c, #c0392b); display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-file-pdf" style="color: #fff; font-size: 1rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="font-weight-bold text-dark mb-0" id="gantiFileName" style="font-size: 12px;">-</p>
                                    <small class="text-muted" id="gantiFileSize">-</small>
                                </div>
                            </div>
                        </div>

                        <div id="gantiValidationError" class="mt-3" style="display: none;">
                            <div class="alert alert-danger rounded-lg px-3 py-2 border-0 mb-0" style="border-radius: 10px !important; font-size: 13px;">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                <span id="gantiValidationMessage"></span>
                            </div>
                        </div>

                        <div class="mt-3 d-flex" style="gap: 0.5rem;">
                            <button type="button" class="btn btn-sm font-weight-bold" id="btnGantiUpload"
                                    style="background-color: #f39c12; color: #fff; border: none; border-radius: 8px; padding: 8px 16px; font-size: 13px;"
                                    disabled>
                                <i class="fas fa-upload mr-1"></i>Upload File Baru
                            </button>
                            <button type="button" class="btn btn-sm font-weight-bold" id="btnCancelGanti"
                                    style="background-color: #e9eef5; color: #6c757d; border: none; border-radius: 8px; padding: 8px 16px; font-size: 13px;">
                                <i class="fas fa-times mr-1"></i>Batal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    /* Upload Area */
    .upload-area {
        border: 2px dashed #4a90e2;
        border-radius: 14px;
        padding: 50px 40px;
        text-align: center;
        background-color: #f0f5ff;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .upload-area:hover {
        background-color: #e3effd;
        border-color: #357abd;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(74, 144, 226, 0.15);
    }

    .upload-area.drag-over {
        background-color: #d4e6fc;
        border-color: #2b6cb0;
        box-shadow: 0 0 0 4px rgba(74, 144, 226, 0.15);
        transform: scale(1.01);
    }

    .upload-area.upload-area-sm {
        padding: 30px 20px;
    }

    .upload-area.upload-area-sm:hover {
        border-color: #f39c12;
    }

    /* Upload Icon */
    .upload-icon-wrapper {
        display: inline-block;
    }

    .upload-icon-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #e8f4fd 0%, #cde5f9 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        transition: all 0.3s ease;
    }

    .upload-icon-circle i {
        font-size: 2.2rem;
        color: #4a90e2;
        transition: all 0.3s ease;
    }

    .upload-area:hover .upload-icon-circle {
        background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
        box-shadow: 0 8px 20px rgba(74, 144, 226, 0.3);
    }

    .upload-area:hover .upload-icon-circle i {
        color: #fff;
        transform: translateY(-2px);
    }

    /* Button hover effects */
    #btnUpload:hover:not(:disabled) {
        box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
        transform: translateY(-1px);
    }

    #btnUpload:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Loading overlay */
    .upload-loading {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.85);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        z-index: 10;
    }

    .spinner-grow-sm {
        width: 1rem;
        height: 1rem;
    }

    /* Responsive */
    @media (max-width: 576px) {
        .upload-area {
            padding: 30px 20px;
        }

        .upload-icon-circle {
            width: 60px;
            height: 60px;
        }

        .upload-icon-circle i {
            font-size: 1.6rem;
        }
    }
</style>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>

<script>
(function() {
    'use strict';

    // === Config ===
    const BASE_URL         = '<?= base_url() ?>';
    const UPLOAD_URL       = '<?= base_url("sekretariat/upload-sertifikat/upload") ?>';
    const GANTI_URL        = '<?= base_url("sekretariat/upload-sertifikat/ganti") ?>';
    const CSRF_TOKEN_NAME  = '<?= csrf_token() ?>';
    const CSRF_HASH        = '<?= csrf_hash() ?>';
    const ID_PERSETUJUAN   = '<?= esc($id_persetujuan_magang) ?>';
    const ID_FILE_PERMOHONAN = '<?= esc($id_file_permohonan ?? '') ?>';
    const MAX_SIZE         = 2 * 1024 * 1024; // 2MB

    // === Upload Baru (belum ada sertifikat) ===
    const uploadArea      = document.getElementById('uploadArea');
    const fileInput       = document.getElementById('fileSertifikat');
    const fileInfo        = document.getElementById('fileInfo');
    const fileName        = document.getElementById('fileName');
    
    // Surat Keterangan
    const uploadAreaSurat = document.getElementById('uploadAreaSurat');
    const fileSurat       = document.getElementById('fileSurat');
    const fileInfoSurat   = document.getElementById('fileInfoSurat');
    const fileNameSurat   = document.getElementById('fileNameSurat');

    const btnUpload       = document.getElementById('btnUpload');
    const validationError = document.getElementById('validationError');
    const validationMsg   = document.getElementById('validationMessage');

    // Helper setup
    function setupUploadArea(area, input, info, nameLabel) {
        if (!area || !input) return;

        area.addEventListener('click', function() { input.click(); });
        
        input.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                handleFileSelect(e.target.files[0], info, nameLabel, area);
            }
        });

        area.addEventListener('dragover', function(e) {
            e.preventDefault(); e.stopPropagation();
            area.style.backgroundColor = '#eafaf1';
            area.style.borderColor = '#27ae60';
        });

        area.addEventListener('dragleave', function(e) {
            e.preventDefault(); e.stopPropagation();
            area.style.backgroundColor = '#f8fbff';
            area.style.borderColor = '#4a90e2';
        });

        area.addEventListener('drop', function(e) {
            e.preventDefault(); e.stopPropagation();
            area.style.backgroundColor = '#f8fbff';
            area.style.borderColor = '#4a90e2';
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const dt = new DataTransfer();
                dt.items.add(files[0]);
                input.files = dt.files;
                handleFileSelect(files[0], info, nameLabel, area);
            }
        });
    }

    setupUploadArea(uploadArea, fileInput, fileInfo, fileName);
    setupUploadArea(uploadAreaSurat, fileSurat, fileInfoSurat, fileNameSurat);

    if (btnUpload) {
        btnUpload.addEventListener('click', function() {
            if (!fileInput.files || fileInput.files.length === 0) {
                showValidationError('Silakan pilih file Sertifikat Magang terlebih dahulu.');
                return;
            }
            // HANYA MENGUPLOAD SERTIFIKAT SESUAI LOGIKA AWAL
            doUpload(fileInput.files[0], UPLOAD_URL);
        });
    }

    // === Ganti File (sudah ada sertifikat) ===
    const btnShowGanti     = document.getElementById('btnShowGanti');
    const gantiSection     = document.getElementById('gantiSection');
    const btnCancelGanti   = document.getElementById('btnCancelGanti');
    const gantiUploadArea  = document.getElementById('gantiUploadArea');
    const gantiFileInput   = document.getElementById('gantiFileSertifikat');
    const gantiFileInfo    = document.getElementById('gantiFileInfo');
    const gantiFileName    = document.getElementById('gantiFileName');
    const gantiFileSize    = document.getElementById('gantiFileSize');
    const btnGantiUpload   = document.getElementById('btnGantiUpload');
    const gantiValError    = document.getElementById('gantiValidationError');
    const gantiValMsg      = document.getElementById('gantiValidationMessage');

    if (btnShowGanti && gantiSection) {
        btnShowGanti.addEventListener('click', function() {
            gantiSection.style.display = 'block';
            gantiSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });
    }

    if (btnCancelGanti && gantiSection) {
        btnCancelGanti.addEventListener('click', function() {
            gantiSection.style.display = 'none';
            if (gantiFileInput) gantiFileInput.value = '';
            if (gantiFileInfo) gantiFileInfo.style.display = 'none';
            if (gantiValError) gantiValError.style.display = 'none';
            if (btnGantiUpload) btnGantiUpload.disabled = true;
        });
    }

    if (gantiUploadArea && gantiFileInput) {
        gantiUploadArea.addEventListener('click', function() {
            gantiFileInput.click();
        });

        gantiFileInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                handleGantiFileSelect(e.target.files[0]);
            }
        });

        gantiUploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            gantiUploadArea.classList.add('drag-over');
        });

        gantiUploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            gantiUploadArea.classList.remove('drag-over');
        });

        gantiUploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            gantiUploadArea.classList.remove('drag-over');

            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleGantiFileSelect(files[0]);
                const dt = new DataTransfer();
                dt.items.add(files[0]);
                gantiFileInput.files = dt.files;
            }
        });
    }

    if (btnGantiUpload) {
        btnGantiUpload.addEventListener('click', function() {
            if (!gantiFileInput.files || gantiFileInput.files.length === 0) {
                showGantiValidationError('Silakan pilih file sertifikat terlebih dahulu.');
                return;
            }

            Swal.fire({
                title: 'Konfirmasi Ganti File',
                text: 'File sertifikat lama akan dihapus dan diganti dengan file baru. Lanjutkan?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f39c12',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-check mr-1"></i> Ya, Ganti File',
                cancelButtonText: 'Batal',
                reverseButtons: true,
            }).then(function(result) {
                if (result.isConfirmed) {
                    doUpload(gantiFileInput.files[0], GANTI_URL, true);
                }
            });
        });
    }

    // === Functions ===

    function handleFileSelect(file, infoEl, nameEl, areaEl) {
        hideValidationError();

        // Validasi tipe
        if (file.type !== 'application/pdf') {
            showValidationError('Format file harus PDF. File yang Anda pilih: ' + (file.type || 'tidak dikenali'));
            resetUploadArea(infoEl, areaEl);
            return;
        }

        // Validasi ukuran
        if (file.size > MAX_SIZE) {
            var sizeMB = (file.size / (1024 * 1024)).toFixed(2);
            showValidationError('Ukuran file melebihi batas 2MB. File Anda: ' + sizeMB + ' MB');
            resetUploadArea(infoEl, areaEl);
            return;
        }

        // Tampilkan info file
        if (nameEl) nameEl.textContent = file.name;
        if (infoEl) infoEl.style.display = 'block';
        if (btnUpload) btnUpload.disabled = false;

        // Ubah tampilan area upload
        if (areaEl) {
            areaEl.style.borderColor = '#27ae60';
            areaEl.style.backgroundColor = '#eafaf1';
        }
    }

    function resetUploadArea(infoEl, areaEl) {
        if (fileInput) fileInput.value = '';
        if (fileSurat) fileSurat.value = '';
        if (infoEl) infoEl.style.display = 'none';
        if (btnUpload) btnUpload.disabled = true;
        if (areaEl) {
            areaEl.style.borderColor = '#4a90e2';
            areaEl.style.backgroundColor = '#f8fbff';
        }
    }

    function handleGantiFileSelect(file) {
        hideGantiValidationError();

        if (file.type !== 'application/pdf') {
            showGantiValidationError('Format file harus PDF.');
            return;
        }

        if (file.size > MAX_SIZE) {
            var sizeMB = (file.size / (1024 * 1024)).toFixed(2);
            showGantiValidationError('Ukuran file melebihi batas 2MB. File Anda: ' + sizeMB + ' MB');
            return;
        }

        var sizeMB = (file.size / (1024 * 1024)).toFixed(2);
        if (gantiFileName) gantiFileName.textContent = file.name;
        if (gantiFileSize) gantiFileSize.textContent = sizeMB + ' MB';
        if (gantiFileInfo) gantiFileInfo.style.display = 'block';
        if (btnGantiUpload) btnGantiUpload.disabled = false;
    }

    function resetUploadArea() {
        if (fileInput) fileInput.value = '';
        if (fileInfo) fileInfo.style.display = 'none';
        if (btnUpload) btnUpload.disabled = true;
        if (uploadArea) {
            uploadArea.style.borderColor = '#4a90e2';
            uploadArea.style.backgroundColor = '#f0f5ff';
        }
    }

    function showValidationError(msg) {
        if (validationMsg) validationMsg.textContent = msg;
        if (validationError) validationError.style.display = 'block';
    }

    function hideValidationError() {
        if (validationError) validationError.style.display = 'none';
    }

    function showGantiValidationError(msg) {
        if (gantiValMsg) gantiValMsg.textContent = msg;
        if (gantiValError) gantiValError.style.display = 'block';
    }

    function hideGantiValidationError() {
        if (gantiValError) gantiValError.style.display = 'none';
    }

    function doUpload(file, url, isGanti) {
        // Tampilkan loading
        Swal.fire({
            title: 'Mengunggah...',
            html: '<div class="d-flex align-items-center justify-content-center"><div class="spinner-border text-primary mr-3" role="status"></div><span>Sedang mengupload file sertifikat...</span></div>',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: function() {
                Swal.showLoading();
            }
        });

        var formData = new FormData();
        formData.append('file_sertifikat', file);
        formData.append('id_persetujuan_magang', ID_PERSETUJUAN);
        formData.append('id_file_permohonan', ID_FILE_PERMOHONAN);
        formData.append(CSRF_TOKEN_NAME, CSRF_HASH);

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            Swal.close();

            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    confirmButtonColor: '#4a90e2',
                    confirmButtonText: 'OK',
                    timer: 2000,
                    timerProgressBar: true,
                }).then(function() {
                    // Reload halaman untuk update tampilan
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    html: data.message,
                    confirmButtonColor: '#e74c3c',
                    confirmButtonText: 'OK',
                });
            }
        })
        .catch(function(error) {
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan koneksi. Silakan coba lagi.',
                confirmButtonColor: '#e74c3c',
                confirmButtonText: 'OK',
            });
            console.error('Upload error:', error);
        });
    }

})();
</script>

<?= $this->endSection(); ?>
