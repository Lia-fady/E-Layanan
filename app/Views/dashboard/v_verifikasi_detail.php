<?php
/**
 * ============================================================
 * Kode      : v_verifikasi_detail.php
 * Path      : Views/dashboard/sekretariat/v_verifikasi_detail.php
 * Deskripsi : View halaman detail verifikasi berkas per dokumen.
 *             Menampilkan info mahasiswa, tabel dokumen dengan
 *             tombol Valid/Tidak Valid per file.
 * ============================================================
 */
?>

<?= $this->extend('layout/L_master') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (!empty($permohonan)) : ?>

<!-- Detail Header -->
<div class="detail-header">
    <div class="detail-header-avatar">
        <i class="fas fa-user"></i>
    </div>
    <div class="detail-header-info">
        <div class="detail-header-name"><?= esc($permohonan->nama_mahasiswa ?? '-') ?></div>
        <div class="detail-header-meta">
            <?= esc($permohonan->prodi ?? '-') ?> - <?= esc($permohonan->instansi_pendidikan ?? '-') ?>
        </div>
        <div class="detail-header-meta">
            Tanggal Pengajuan: <?= !empty($permohonan->created_at) ? date('d F Y', strtotime($permohonan->created_at)) : '-' ?>
        </div>
    </div>
    <div class="detail-header-box">
        <div class="detail-header-box-label">Periode Magang</div>
        <div class="detail-header-box-value">
            <?php
                $mulai = !empty($permohonan->tgl_mulai) ? date('d F Y', strtotime($permohonan->tgl_mulai)) : '-';
                $selesai = !empty($permohonan->tgl_selesai) ? date('d F Y', strtotime($permohonan->tgl_selesai)) : '-';
            ?>
            <?= $mulai ?> s/d <?= $selesai ?>
        </div>
    </div>
    <div class="detail-header-box">
        <div class="detail-header-box-label">Status Verifikasi</div>
        <div class="detail-header-box-value">
            <?php
                $status = $permohonan->status_persetujuan ?? 'MENUNGGU';
                $badgeClass = 'menunggu-verifikasi';
                if ($status == 'DISETUJUI') $badgeClass = 'disetujui';
                elseif ($status == 'DITOLAK') $badgeClass = 'ditolak';
            ?>
            <span class="status-badge <?= $badgeClass ?>">
                <?= $status == 'MENUNGGU' ? 'Menunggu Verifikasi' : $status ?>
            </span>
        </div>
    </div>
</div>

<!-- Back Link -->
<a href="<?= base_url('sekretariat/verifikasi') ?>" class="detail-back-link">
    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Permohonan
</a>

<!-- Dokumen Table -->
<div class="mb-4">
    <h5 style="font-weight:700; color:#1d2939; margin-bottom:1rem;">Dokumen yang Diajukan</h5>
    
    <form action="<?= base_url('sekretariat/verifikasi/proses') ?>" method="POST" id="formVerifikasi">
        <?= csrf_field() ?>
        <input type="hidden" name="id_permohonan_magang" value="<?= $permohonan->id_permohonan_magang ?>">
        
        <table class="dokumen-table">
            <thead>
                <tr>
                    <th width="5%" class="text-center">NO</th>
                    <th width="25%">Nama Dokumen</th>
                    <th width="25%">File</th>
                    <th width="15%" class="text-center">Status</th>
                    <th width="30%" class="text-center">Verifikasi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($files)) : ?>
                    <?php $no = 1; foreach ($files as $file) : ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= esc($file->nama_file_master ?? 'Dokumen') ?></td>
                        <td>
                            <?php if (!empty($file->path_file)) : ?>
                                <a href="<?= base_url($file->path_file) ?>" target="_blank" class="file-link">
                                    <i class="fas fa-file-pdf"></i> <?= esc($file->nama_file_upload ?? 'File') ?>
                                </a>
                            <?php else : ?>
                                <span class="text-muted">Tidak tersedia</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <span class="status-badge-display status-badge <?= ($file->status_verifikasi ?? '') == 'VALID' ? 'disetujui' : (($file->status_verifikasi ?? '') == 'TIDAK_VALID' ? 'ditolak' : 'menunggu') ?>" 
                                  id="statusBadge_<?= $file->id_file_permohonan_magang ?>">
                                <?= ($file->status_verifikasi ?? '') == 'VALID' ? 'Valid' : (($file->status_verifikasi ?? '') == 'TIDAK_VALID' ? 'Tidak Valid' : 'Menunggu') ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <input type="hidden" name="file_status[<?= $file->id_file_permohonan_magang ?>]" 
                                   id="fileStatus_<?= $file->id_file_permohonan_magang ?>" 
                                   value="<?= esc($file->status_verifikasi ?? '') ?>">
                            <button type="button" class="btn-valid <?= ($file->status_verifikasi ?? '') == 'VALID' ? 'active' : '' ?>" 
                                    onclick="setFileStatus(<?= $file->id_file_permohonan_magang ?>, 'VALID')">
                                <i class="fas fa-check"></i> Valid
                            </button>
                            <button type="button" class="btn-tidak-valid <?= ($file->status_verifikasi ?? '') == 'TIDAK_VALID' ? 'active' : '' ?>" 
                                    onclick="setFileStatus(<?= $file->id_file_permohonan_magang ?>, 'TIDAK_VALID')">
                                <i class="fas fa-times"></i> Tidak Valid
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>
                            Tidak ada dokumen yang diupload.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-end gap-3 mt-4" style="gap:1rem;">
            <a href="<?= base_url('sekretariat/verifikasi') ?>" class="btn-batal">Batal</a>
            <button type="submit" class="btn-simpan-keputusan">Simpan Keputusan</button>
        </div>
    </form>
</div>

<?php else : ?>
<div class="alert alert-warning">
    <i class="fas fa-exclamation-triangle mr-2"></i>
    Data permohonan tidak ditemukan.
</div>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function setFileStatus(fileId, status) {
    var input = document.getElementById('fileStatus_' + fileId);
    var badge = document.getElementById('statusBadge_' + fileId);
    var row = input.closest('td').parentElement;
    var btnValid = row.querySelector('.btn-valid');
    var btnTidakValid = row.querySelector('.btn-tidak-valid');

    // Toggle: if same status clicked again, reset
    if (input.value === status) {
        input.value = '';
        btnValid.classList.remove('active');
        btnTidakValid.classList.remove('active');
        badge.className = 'status-badge-display status-badge menunggu';
        badge.textContent = 'Menunggu';
        return;
    }

    input.value = status;

    // Update button states
    btnValid.classList.toggle('active', status === 'VALID');
    btnTidakValid.classList.toggle('active', status === 'TIDAK_VALID');

    // Update badge
    if (status === 'VALID') {
        badge.className = 'status-badge-display status-badge disetujui';
        badge.textContent = 'Valid';
    } else {
        badge.className = 'status-badge-display status-badge ditolak';
        badge.textContent = 'Tidak Valid';
    }
}

// Form submit confirmation
$('#formVerifikasi').on('submit', function(e) {
    e.preventDefault();
    var form = this;
    
    Swal.fire({
        title: 'Simpan Keputusan?',
        text: 'Pastikan Anda sudah memverifikasi semua dokumen.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#2563EB',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Simpan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});
</script>
<?= $this->endSection() ?>
