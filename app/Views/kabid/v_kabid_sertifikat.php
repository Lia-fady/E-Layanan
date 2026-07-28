<?= $this->extend('layout/L_master'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="mb-4">
        <h3 class="text-dark font-weight-bold mb-1">UPLOAD SERTIFIKAT</h3>
        <p class="text-muted mb-0">Unggah file sertifikat magang dalam format PDF yang telah diterbitkan.</p>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success rounded-pill px-4 py-3 border-0 mb-3" style="background-color: #d4edda; color: #155724;">
            <i class="fas fa-check-circle mr-2"></i><?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger rounded-pill px-4 py-3 border-0 mb-3" style="background-color: #f8d7da; color: #721c24;">
            <i class="fas fa-exclamation-circle mr-2"></i><?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('sekretariat/c_kabid/simpan_sertifikat') ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="id_penempatan_magang" value="<?= esc($penempatan_id ?? '1') ?>">

        <!-- Informasi Permohonan -->
        <div class="card shadow-sm border-0 mb-4" style="border-radius: 14px;">
            <div class="card-body p-4">
                <div style="display: flex; align-items: center; margin-bottom: 1.5rem;">
                    <div style="font-size: 24px; color: #4a90e2; margin-right: 0.5rem;">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h5 class="text-dark font-weight-bold mb-0">Informasi Permohonan</h5>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block mb-1" style="font-size: 12px;">Nama Mahasiswa</small>
                        <p class="text-dark font-weight-bold mb-0"><?= esc($nama_mahasiswa ?? 'Budi Santoso'); ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block mb-1" style="font-size: 12px;">NIM</small>
                        <p class="text-dark font-weight-bold mb-0"><?= esc($nim ?? '210101001'); ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block mb-1" style="font-size: 12px;">Kegiatan</small>
                        <p class="text-dark font-weight-bold mb-0"><?= esc($kegiatan ?? 'Magang / PKL'); ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block mb-1" style="font-size: 12px;">Periode</small>
                        <p class="text-dark font-weight-bold mb-0"><?= esc($periode ?? 'Februari 2025 - Mei 2025'); ?></p>
                    </div>
                    <div class="col-md-12 mb-0">
                        <small class="text-muted d-block mb-1" style="font-size: 12px;">Bidang</small>
                        <p class="text-dark font-weight-bold mb-0"><?= esc($bidang ?? 'Bidang Pengembangan E-Government'); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upload Sertifikat -->
        <div class="card shadow-sm border-0 mb-4" style="border-radius: 14px;">
            <div class="card-body p-4">
                <div style="display: flex; align-items: center; margin-bottom: 1.5rem;">
                    <div style="font-size: 24px; color: #4a90e2; margin-right: 0.5rem;">
                        <i class="fas fa-file-upload"></i>
                    </div>
                    <h5 class="text-dark font-weight-bold mb-0">Upload Sertifikat</h5>
                </div>
                
                <label class="font-weight-bold text-dark mb-3 d-block" style="font-size: 14px;">File Sertifikat</label>

                <div class="upload-area" id="uploadArea" style="border: 2px dashed #4a90e2; border-radius: 14px; padding: 60px 40px; text-align: center; background-color: #f0f5ff; cursor: pointer; transition: all 0.3s;">
                    <input type="file" id="fileSertifikat" name="file_sertifikat" accept=".pdf" style="display: none;">
                    
                    <div class="mb-3">
                        <i class="fas fa-cloud-upload-alt" style="font-size: 4rem; color: #4a90e2;"></i>
                    </div>
                    
                    <p class="text-dark font-weight-bold mb-2" style="font-size: 15px;">Klik untuk memilih file atau drag & drop di sini</p>
                    <p class="text-muted small mb-0">Format PDF, Maks. 2MB</p>
                </div>

                <div id="fileInfo" class="mt-3" style="display: none;">
                    <div class="alert rounded-lg px-4 py-3 border-0 mb-0" style="background-color: #d4edda; color: #155724;">
                        <i class="fas fa-check-circle mr-2"></i>
                        <strong>File Terpilih:</strong> <span id="fileName"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Catatan -->
        <div class="card shadow-sm border-0 mb-4" style="border-radius: 14px;">
            <div class="card-body p-4">
                <div style="display: flex; align-items: center; margin-bottom: 1.5rem;">
                    <div style="font-size: 24px; color: #4a90e2; margin-right: 0.5rem;">
                        <i class="fas fa-sticky-note"></i>
                    </div>
                    <h5 class="text-dark font-weight-bold mb-0">Catatan Tambahan</h5>
                </div>
                <label class="font-weight-bold text-dark mb-2 d-block" style="font-size: 14px;">Catatan (opsional)</label>
                <textarea name="catatan" 
                          class="form-control border-0" 
                          rows="4" 
                          placeholder="Tulis catatan atau keterangan tambahan jika diperlukan..."
                          style="border-radius: 10px; background-color: #f8fafc; border: 1px solid #e3e8ef; font-size: 13px;"></textarea>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="d-flex justify-content-end" style="gap: 0.75rem;">
            <a href="<?= base_url('sekretariat/c_kabid') ?>" 
               class="btn font-weight-bold"
               style="background-color: #e9eef5; border: none; border-radius: 999px; padding: 10px 24px; color: #4a90e2; font-size: 14px;">
                <i class="fas fa-times mr-2"></i>Batal
            </a>
            <button type="submit" 
                    class="btn btn-primary font-weight-bold"
                    style="background-color: #4a90e2; border: none; border-radius: 999px; padding: 10px 24px; font-size: 14px;">
                <i class="fas fa-save mr-2"></i>Simpan Sertifikat
            </button>
        </div>
    </form>
</div>

<script>
// Upload area drag & drop
const uploadArea = document.getElementById('uploadArea');
const fileInput = document.getElementById('fileSertifikat');
const fileInfo = document.getElementById('fileInfo');
const fileName = document.getElementById('fileName');

// Click to select file
uploadArea.addEventListener('click', () => {
    fileInput.click();
});

// File selected
fileInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (file) {
        updateFileInfo(file);
    }
});

// Drag over
uploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadArea.style.borderColor = '#4a90e2';
    uploadArea.style.backgroundColor = '#e8f0fe';
});

// Drag leave
uploadArea.addEventListener('dragleave', () => {
    uploadArea.style.borderColor = '#4a90e2';
    uploadArea.style.backgroundColor = '#f0f5ff';
});

// Drop
uploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadArea.style.borderColor = '#4a90e2';
    uploadArea.style.backgroundColor = '#f0f5ff';
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        const file = files[0];
        
        // Validasi tipe file
        if (file.type !== 'application/pdf') {
            alert('Format file harus PDF');
            return;
        }
        
        // Validasi ukuran
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file maksimal 2MB');
            return;
        }
        
        fileInput.files = files;
        updateFileInfo(file);
    }
});

// Update file info display
function updateFileInfo(file) {
    const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
    fileName.textContent = `${file.name} (${sizeMB} MB)`;
    fileInfo.style.display = 'block';
    uploadArea.style.borderColor = '#4a90e2';
    uploadArea.style.backgroundColor = '#d4edda';
}
</script>

<?= $this->endSection(); ?>
