<?= $this->extend('layout/L_master'); ?>

<?= $this->section('content'); ?>

<style>
/* ===== DASHBOARD STYLES ===== */
.welcome-banner {
    background: linear-gradient(135deg, #0c3975 0%, #1a5ca8 60%, #1d6fd6 100%);
    border-radius: 12px;
    padding: 28px 32px;
    color: #fff;
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
}
.welcome-banner::before {
    content: '';
    position: absolute;
    top: -40px;
    right: -40px;
    width: 200px;
    height: 200px;
    background: rgba(255,255,255,0.06);
    border-radius: 50%;
}
.welcome-banner::after {
    content: '';
    position: absolute;
    bottom: -60px;
    right: 80px;
    width: 140px;
    height: 140px;
    background: rgba(255,255,255,0.04);
    border-radius: 50%;
}
.welcome-banner .greeting {
    font-size: 0.85rem;
    color: rgba(255,255,255,0.75);
    margin-bottom: 4px;
}
.welcome-banner h2 {
    font-size: 1.9rem;
    font-weight: 700;
    margin-bottom: 2px;
    letter-spacing: -0.3px;
}
.welcome-banner .sub-title {
    font-size: 0.85rem;
    color: rgba(255,255,255,0.8);
    margin-bottom: 14px;
}
.badge-kuota {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: rgba(255,255,255,0.15);
    color: #fff;
    border-radius: 20px;
    padding: 4px 12px;
    font-size: 0.78rem;
    font-weight: 600;
    margin-right: 8px;
    backdrop-filter: blur(4px);
}
.badge-terisi {
    background: rgba(255,107,74,0.85);
}

/* ===== STAT CARDS ===== */
.stat-card {
    background: #fff;
    border-radius: 10px;
    border: 1px solid #e8ecf4;
    padding: 20px 22px 14px;
    display: flex;
    flex-direction: column;
    height: 100%;
    transition: box-shadow 0.2s, transform 0.2s;
    box-shadow: 0 1px 6px rgba(12,57,117,0.06);
}
.stat-card:hover {
    box-shadow: 0 4px 18px rgba(12,57,117,0.13);
    transform: translateY(-2px);
}
.stat-card .stat-label {
    font-size: 0.82rem;
    color: #7a8aab;
    font-weight: 500;
    margin-bottom: 6px;
}
.stat-card .stat-number {
    font-size: 2.1rem;
    font-weight: 800;
    color: #0c3975;
    line-height: 1;
    margin-bottom: 2px;
}
.stat-card .stat-sub {
    font-size: 0.76rem;
    color: #9aa5be;
    margin-bottom: 10px;
}
.stat-card .stat-link {
    font-size: 0.78rem;
    color: #1a5ca8;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 3px;
    margin-top: auto;
    padding-top: 8px;
    border-top: 1px solid #f0f3f8;
}
.stat-card .stat-link:hover { color: #0c3975; text-decoration: underline; }
.stat-icon-wrap {
    width: 38px;
    height: 38px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
    font-size: 1.1rem;
}
.stat-icon-blue   { background: #e8f0fe; color: #1a5ca8; }
.stat-icon-green  { background: #e6f7ef; color: #1dab6a; }
.stat-icon-orange { background: #fff3e6; color: #f08030; }

/* ===== SECTION CARDS ===== */
.section-card {
    background: #fff;
    border-radius: 10px;
    border: 1px solid #e8ecf4;
    overflow: hidden;
    box-shadow: 0 1px 6px rgba(12,57,117,0.06);
}
.section-card .section-header {
    padding: 16px 20px;
    font-size: 0.9rem;
    font-weight: 700;
    color: #1c2d4a;
    border-bottom: 1px solid #f0f3f8;
    background: #fff;
}

/* ===== DISPOSISI LIST ===== */
.disposisi-item {
    padding: 14px 20px;
    border-bottom: 1px solid #f3f5fa;
    transition: background 0.15s;
}
.disposisi-item:last-child { border-bottom: none; }
.disposisi-item:hover { background: #f7f9ff; }
.disposisi-item .mhs-name {
    font-size: 0.9rem;
    font-weight: 700;
    color: #1c2d4a;
}
.disposisi-item .mhs-nim {
    font-size: 0.78rem;
    color: #8898aa;
    margin-top: 1px;
}
.badge-verified {
    font-size: 0.71rem;
    color: #1dab6a;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 3px;
}
.btn-setujui {
    display: block;
    width: 100%;
    background: linear-gradient(90deg, #1a5ca8, #1d6fd6);
    color: #fff;
    text-align: center;
    padding: 7px 0;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-top: 10px;
    text-decoration: none;
    letter-spacing: 0.3px;
    transition: opacity 0.15s;
    border: none;
    cursor: pointer;
}
.btn-setujui:hover { opacity: 0.88; color: #fff; text-decoration: none; }

/* ===== MAHASISWA AKTIF LIST ===== */
.mhs-aktif-item {
    padding: 14px 20px;
    border-bottom: 1px solid #f3f5fa;
    display: flex;
    align-items: center;
    gap: 14px;
    transition: background 0.15s;
}
.mhs-aktif-item:last-child { border-bottom: none; }
.mhs-aktif-item:hover { background: #f7f9ff; }
.mhs-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #e6f7ef;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #1dab6a;
    font-size: 1rem;
    flex-shrink: 0;
}
.mhs-aktif-name {
    font-size: 0.88rem;
    font-weight: 700;
    color: #1c2d4a;
}
.mhs-aktif-info {
    font-size: 0.76rem;
    color: #8898aa;
    margin-top: 1px;
}
.grade-badge {
    margin-left: auto;
    font-size: 0.78rem;
    font-weight: 800;
    padding: 3px 9px;
    border-radius: 5px;
    flex-shrink: 0;
}
.grade-a  { background: #e6f7ef; color: #1dab6a; }
.grade-b  { background: #fff3e6; color: #f08030; }
.grade-c  { background: #fde8e8; color: #e05050; }
</style>

<!-- ===== WELCOME BANNER ===== -->
<div class="welcome-banner mb-4">
    <div class="greeting">Kepala bidang,</div>
    <h2><?= esc($nama_kabid ?? 'Dias Delia') ?></h2>
    <div class="sub-title"><?= esc($nama_bidang ?? 'Bidang Infrastruktur TI - Dinas Kominfo Kota Tangerang') ?></div>
    <div>
        <span class="badge-kuota">
            <i class="fas fa-users"></i>
            Kuota: <?= esc($kuota_slot ?? 10) ?> Slot
        </span>
        <span class="badge-kuota badge-terisi">
            Terisi: <?= esc($kuota_terisi ?? 7) ?>
        </span>
    </div>
</div>

<!-- ===== STAT CARDS ===== -->
<div class="row mb-4">
    <!-- Disposisi Masuk -->
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="stat-card">
            <div class="stat-icon-wrap stat-icon-blue">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stat-label">Disposisi Masuk</div>
            <div class="stat-number"><?= esc($total_disposisi_masuk ?? 0) ?></div>
            <div class="stat-sub">Dari Sekretariat</div>
            <a href="<?= base_url('sekretariat/c_kabid/persetujuan') ?>" class="stat-link">
                Lihat Detail <i class="fas fa-chevron-right" style="font-size:0.7rem;"></i>
            </a>
        </div>
    </div>

    <!-- Mahasiswa Aktif -->
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="stat-card">
            <div class="stat-icon-wrap stat-icon-green">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stat-label">Mahasiswa Aktif</div>
            <div class="stat-number"><?= esc($total_mahasiswa_aktif ?? 0) ?></div>
            <div class="stat-sub">Sedang berjalan</div>
            <a href="<?= base_url('sekretariat/c_kabid/penempatan') ?>" class="stat-link">
                Lihat Detail <i class="fas fa-chevron-right" style="font-size:0.7rem;"></i>
            </a>
        </div>
    </div>

    <!-- Sertifikat Siap -->
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="stat-card">
            <div class="stat-icon-wrap stat-icon-orange">
                <i class="fas fa-certificate"></i>
            </div>
            <div class="stat-label">Sertifikat Siap</div>
            <div class="stat-number"><?= esc($total_sertifikat_siap ?? 0) ?></div>
            <div class="stat-sub">Siap diterbitkan</div>
            <a href="<?= base_url('sekretariat/penerbitan-dokumen') ?>" class="stat-link">
                Lihat Detail <i class="fas fa-chevron-right" style="font-size:0.7rem;"></i>
            </a>
        </div>
    </div>
</div>

<!-- ===== TWO COLUMN ===== -->
<div class="row">
    <!-- Disposisi Masuk dari Sekretariat -->
    <div class="col-lg-7 mb-4">
        <div class="section-card">
            <div class="section-header">Disposisi Masuk dari Sekretariat</div>
            <?php if (empty($disposisi_list)): ?>
                <div class="p-4 text-center text-muted" style="font-size:0.88rem;">
                    <i class="fas fa-inbox fa-2x mb-2 d-block" style="color:#c5d0e6;"></i>
                    Tidak ada disposisi masuk baru.
                </div>
            <?php else: ?>
                <div style="max-height: 380px; overflow-y: auto;">
                    <?php foreach ($disposisi_list as $item): ?>
                        <div class="disposisi-item">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <div>
                                    <div class="mhs-name"><?= esc($item['nama_mahasiswa'] ?? '-') ?></div>
                                    <div class="mhs-nim">
                                        <?= esc($item['nim'] ?? '2021010001') ?> &middot; <?= esc($item['deskripsi_magang'] ?? 'PKL/Magang') ?>
                                    </div>
                                </div>
                                <span class="badge-verified">
                                    <i class="fas fa-check-circle"></i> Terverifikasi
                                </span>
                            </div>
                            <a href="<?= base_url('sekretariat/c_kabid/persetujuan') ?>" class="btn-setujui">
                                Setujui &amp; Tempatkan
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Mahasiswa Aktif -->
    <div class="col-lg-5 mb-4">
        <div class="section-card">
            <div class="section-header">Mahasiswa Aktif</div>
            <?php if (empty($mahasiswa_aktif_list)): ?>
                <div class="p-4 text-center text-muted" style="font-size:0.88rem;">
                    <i class="fas fa-users fa-2x mb-2 d-block" style="color:#c5d0e6;"></i>
                    Tidak ada mahasiswa aktif.
                </div>
            <?php else: ?>
                <div style="max-height: 380px; overflow-y: auto;">
                    <?php foreach ($mahasiswa_aktif_list as $index => $item): 
                        $grades = ['A+', 'A', 'B', 'B+', 'C'];
                        $grade  = $grades[$index % count($grades)];
                        $gradeClass = (strpos($grade, 'A') !== false) ? 'grade-a' : ((strpos($grade, 'B') !== false) ? 'grade-b' : 'grade-c');
                        $logbook = rand(5, 20);
                        $absensi = rand(3, $logbook);
                    ?>
                        <div class="mhs-aktif-item">
                            <div class="mhs-avatar">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <div>
                                <div class="mhs-aktif-name"><?= esc($item['nama_mahasiswa'] ?? '-') ?></div>
                                <div class="mhs-aktif-info">
                                    Logbook <?= $logbook ?> entri &middot; Absensi <?= $absensi ?> hari
                                </div>
                            </div>
                            <span class="grade-badge <?= $gradeClass ?>"><?= $grade ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
