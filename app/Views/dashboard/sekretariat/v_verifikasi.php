<?php
/**
 * ============================================================
 * Kode      : v_verifikasi.php
 * Path      : Views/dashboard/sekretariat/v_verifikasi.php
 * Deskripsi : View halaman daftar permohonan untuk verifikasi
 *             berkas. Menggunakan card-based layout sesuai
 *             desain mockup dengan search dan filter.
 * ============================================================
 */
?>

<?= $this->extend('layout/L_master') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Search & Filter Bar -->
<div class="verifikasi-search-bar">
    <div style="position:relative; flex:1;">
        <i class="fas fa-search" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#98a2b3;"></i>
        <input type="text" id="searchInput" placeholder="Cari nama/ universitas.." style="width:100%;">
    </div>
    <select id="filterStatus">
        <option value="">Semua Status</option>
        <option value="MENUNGGU">Menunggu</option>
        <option value="DISETUJUI">Disetujui</option>
        <option value="DITOLAK">Ditolak</option>
    </select>
</div>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')) : ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle mr-2"></i>
    <?= session()->getFlashdata('success') ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle mr-2"></i>
    <?= session()->getFlashdata('error') ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php endif; ?>

<!-- Verifikasi Cards -->
<div id="verifikasiList">
    <?php if (!empty($permohonan)) : ?>
        <?php foreach ($permohonan as $row) : ?>
            <div class="verifikasi-card" 
                 data-name="<?= esc(strtolower($row->nama_mahasiswa ?? '')) ?>"
                 data-univ="<?= esc(strtolower($row->instansi_pendidikan ?? '')) ?>"
                 data-status="<?= esc($row->status_persetujuan ?? 'MENUNGGU') ?>">
                
                <!-- Status Badge -->
                <div class="verifikasi-card-status">
                    <?php
                        $status = $row->status_persetujuan ?? 'MENUNGGU';
                        $badgeClass = 'menunggu';
                        if ($status == 'DISETUJUI') $badgeClass = 'disetujui';
                        elseif ($status == 'DITOLAK') $badgeClass = 'ditolak';
                    ?>
                    <span class="status-badge <?= $badgeClass ?>"><?= $status ?></span>
                </div>

                <!-- Name & Details -->
                <div class="verifikasi-card-name"><?= esc($row->nama_mahasiswa ?? '-') ?></div>
                <div class="verifikasi-card-detail">
                    <?= esc($row->nim ?? '-') ?> · <?= esc($row->instansi_pendidikan ?? '-') ?>
                </div>
                <div class="verifikasi-card-detail">
                    <?= esc($row->jenis_permohonan ?? '-') ?> · Diajukan <?= !empty($row->tgl_pengajuan) ? date('d M Y', strtotime($row->tgl_pengajuan)) : '-' ?>
                </div>

                <!-- Berkas Badges -->
                <?php if (!empty($row->files)) : ?>
                    <div class="verifikasi-card-berkas-label">Status Kelengkapan Berkas:</div>
                    <div>
                        <?php foreach ($row->files as $file) : ?>
                            <span class="berkas-badge uploaded">
                                <i class="fas fa-check fa-xs"></i> <?= esc($file->nama_file_master ?? 'Dokumen') ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Action Buttons -->
                <div class="verifikasi-card-actions">
                    <a href="<?= base_url('sekretariat/verifikasi/detail/' . $row->id_permohonan_magang) ?>" class="btn-verifikasi">
                        <i class="fas fa-check"></i> Verifikasi Berkas
                    </a>
                    <button type="button" class="btn-kembalikan" data-id="<?= $row->id_permohonan_magang ?>">
                        <i class="fas fa-times"></i> Kembalikan
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <div class="chart-card text-center py-5">
            <div class="placeholder-page-icon mx-auto mb-3">
                <i class="fas fa-check-circle"></i>
            </div>
            <h5>Tidak Ada Permohonan</h5>
            <p class="text-muted">Semua permohonan telah diverifikasi.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Hidden form for kembalikan -->
<form id="formKembalikan" action="<?= base_url('sekretariat/verifikasi/kembalikan') ?>" method="POST" style="display:none;">
    <?= csrf_field() ?>
    <input type="hidden" name="id_permohonan_magang" id="kembalikanId">
</form>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Search filter
    $('#searchInput').on('keyup', function() {
        var val = $(this).val().toLowerCase();
        filterCards();
    });

    // Status filter
    $('#filterStatus').on('change', function() {
        filterCards();
    });

    function filterCards() {
        var search = $('#searchInput').val().toLowerCase();
        var status = $('#filterStatus').val();

        $('#verifikasiList .verifikasi-card').each(function() {
            var name = $(this).data('name');
            var univ = $(this).data('univ');
            var cardStatus = $(this).data('status');

            var matchSearch = !search || name.indexOf(search) > -1 || univ.indexOf(search) > -1;
            var matchStatus = !status || cardStatus === status;

            $(this).toggle(matchSearch && matchStatus);
        });
    }

    // Kembalikan button
    $('.btn-kembalikan').on('click', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Kembalikan Berkas?',
            text: 'Permohonan ini akan dikembalikan kepada pemohon.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DC3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Kembalikan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#kembalikanId').val(id);
                $('#formKembalikan').submit();
            }
        });
    });
});
</script>

<?php if (session()->getFlashdata('success')) : ?>
<script>
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: '<?= session()->getFlashdata('success') ?>', timer: 3000 });
</script>
<?php endif; ?>
<?php if (session()->getFlashdata('error')) : ?>
<script>
    Swal.fire({ icon: 'error', title: 'Gagal!', text: '<?= session()->getFlashdata('error') ?>' });
</script>
<?php endif; ?>
<?= $this->endSection() ?>
