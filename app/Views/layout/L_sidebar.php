<?php
$uri           = service('uri');
$totalSegments = $uri->getTotalSegments();
$segment2      = $totalSegments >= 2 ? $uri->getSegment(2) : '';
$segment3      = $totalSegments >= 3 ? $uri->getSegment(3) : '';

// Tentukan menu yang sedang aktif
$activeMenu = 'dashboard'; // default
if ($segment3 === 'persetujuan')        $activeMenu = 'persetujuan';
elseif ($segment3 === 'kelola-kuota')   $activeMenu = 'kelola-kuota';
elseif ($segment2 === 'upload-sertifikat') $activeMenu = 'upload-sertifikat';
elseif (in_array($segment3, ['sertifikat', 'list-sertifikat', 'list-mahasiswa-sertifikat', 'upload-sertifikat-form']))
    $activeMenu = 'upload-sertifikat';

$isActive = function(string $name) use ($activeMenu): string {
    return $activeMenu === $name ? 'sb-active' : '';
};
?>

<style>
/* ===================== SIDEBAR ===================== */
#sidebar-wrapper {
    width: 220px;
    min-width: 220px;
    min-height: 100vh;
    background-color: #0c3975;
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
}

/* Brand */
.sb-brand {
    display: flex;
    align-items: center;
    padding: 18px 16px;
    text-decoration: none;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    gap: 10px;
    transition: background 0.15s;
}
.sb-brand:hover { background: rgba(255,255,255,0.05); text-decoration: none; }
.sb-brand img   { width: 36px; height: auto; flex-shrink: 0; }
.sb-brand-text  { line-height: 1.3; }
.sb-brand-title {
    display: block;
    font-size: 0.82rem;
    font-weight: 800;
    color: #ffffff;
    letter-spacing: 0.5px;
}
.sb-brand-sub {
    display: block;
    font-size: 0.72rem;
    font-weight: 400;
    color: rgba(255,255,255,0.65);
}

/* User block */
.sb-user {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 16px;
    border-bottom: 1px solid rgba(255,255,255,0.08);
}
.sb-user-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255,255,255,0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 0.95rem;
    color: #fff;
}
.sb-user-name {
    font-size: 0.82rem;
    font-weight: 700;
    color: #ffffff;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.sb-user-role {
    font-size: 0.7rem;
    color: rgba(255,255,255,0.55);
    margin-top: 1px;
}

/* Nav section heading */
.sb-section-label {
    padding: 16px 16px 6px;
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: rgba(255,255,255,0.4);
}

/* Nav item */
.sb-nav {
    padding: 0 8px;
    list-style: none;
    margin: 0;
}
.sb-nav li { margin-bottom: 2px; }
.sb-nav a {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 9px 12px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.83rem;
    font-weight: 500;
    color: rgba(255,255,255,0.65);
    transition: background 0.15s, color 0.15s;
}
.sb-nav a:hover {
    background: rgba(255,255,255,0.1);
    color: #ffffff;
    text-decoration: none;
}
.sb-nav a.sb-active {
    background: #1a5ca8;
    color: #ffffff;
    font-weight: 700;
}
.sb-nav a i {
    font-size: 0.88rem;
    width: 16px;
    text-align: center;
    flex-shrink: 0;
}

/* Dashboard item (has icon, slightly bigger) */
.sb-nav a.sb-dashboard-link {
    font-size: 0.86rem;
    padding: 10px 12px;
}

/* Indent untuk sub-menu */
.sb-nav.sb-submenu a {
    padding-left: 16px;
    font-size: 0.82rem;
}
/* ===================== END SIDEBAR ===================== */
</style>

<div id="sidebar-wrapper">

    <!-- ── Brand ── -->
    <a class="sb-brand" href="<?= base_url('sekretariat/c_kabid') ?>">
        <img src="<?= base_url('icon/OIP.webp') ?>" alt="Logo Pemkot">
        <div class="sb-brand-text">
            <span class="sb-brand-title">DINAS KOMINFO</span>
            <span class="sb-brand-sub">KOTA TANGERANG</span>
        </div>
    </a>

    <!-- ── User Info ── -->
    <div class="sb-user">
        <div class="sb-user-avatar">
            <i class="fas fa-user"></i>
        </div>
        <div style="min-width:0;">
            <div class="sb-user-name"><?= esc($nama_kabid ?? 'Dias Delia') ?></div>
            <div class="sb-user-role">Kepala bidang</div>
        </div>
    </div>

    <!-- ── Dashboard ── -->
    <ul class="sb-nav mt-3">
        <li>
            <a href="<?= base_url('sekretariat/c_kabid') ?>"
               class="sb-dashboard-link <?= $isActive('dashboard') ?>">
                <i class="fas fa-th-large"></i>
                Dashboard
            </a>
        </li>
    </ul>

    <!-- ── Persetujuan Penempatan ── -->
    <div class="sb-section-label">Persetujuan Penempatan</div>
    <ul class="sb-nav sb-submenu">
        <li>
            <a href="<?= base_url('sekretariat/c_kabid/persetujuan') ?>"
               class="<?= $isActive('persetujuan') ?>">
                Penempatan Bidang
            </a>
        </li>
        <li>
            <a href="<?= base_url('sekretariat/c_kabid/kelola-kuota') ?>"
               class="<?= $isActive('kelola-kuota') ?>">
                Kelola Kuota
            </a>
        </li>
    </ul>

    <!-- ── Dokumen Akhir ── -->
    <div class="sb-section-label">Dokumen Akhir</div>
    <ul class="sb-nav sb-submenu">
        <li>
            <a href="<?= base_url('sekretariat/penerbitan-dokumen') ?>"
               class="<?= $isActive('penerbitan-dokumen') ?>">
                Penerbitan Dokumen
            </a>
        </li>
    </ul>

</div>
