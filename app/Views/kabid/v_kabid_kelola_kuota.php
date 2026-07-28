<?= $this->extend('layout/L_master'); ?>

<?= $this->section('content'); ?>

<style>
/* ===== KELOLA KUOTA STYLES ===== */
.kk-page-header {
    margin-bottom: 24px;
}
.kk-page-header h4 {
    font-size: 1.15rem;
    font-weight: 800;
    color: #0c3975;
    margin-bottom: 3px;
}
.kk-page-header p {
    font-size: 0.82rem;
    color: #8898aa;
    margin: 0;
}

/* Summary bar */
.kk-summary {
    display: flex;
    gap: 16px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}
.kk-summary-item {
    flex: 1;
    min-width: 140px;
    background: #fff;
    border: 1px solid #e8ecf4;
    border-radius: 10px;
    padding: 16px 20px;
    box-shadow: 0 1px 5px rgba(12,57,117,0.05);
}
.kk-summary-item .s-label {
    font-size: 0.75rem;
    color: #8898aa;
    font-weight: 500;
    margin-bottom: 4px;
}
.kk-summary-item .s-val {
    font-size: 1.7rem;
    font-weight: 800;
    line-height: 1;
}
.s-val.blue   { color: #0c3975; }
.s-val.green  { color: #1dab6a; }
.s-val.orange { color: #f08030; }

/* Bidang card grid */
.kk-grid {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    gap: 20px;
    align-items: start;
}
@media (min-width: 768px) {
    .kk-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (min-width: 1200px) {
    .kk-grid { grid-template-columns: repeat(2, 1fr); } /* 2x2 grid is perfect for 4 items */
}

.kk-card {
    background: #fff;
    border: 1px solid #e8ecf4;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 1px 6px rgba(12,57,117,0.06);
    transition: box-shadow 0.2s, transform 0.2s;
    display: flex;
    flex-direction: column;
}
.kk-card:hover {
    box-shadow: 0 5px 20px rgba(12,57,117,0.13);
    transform: translateY(-2px);
}
.kk-card-header {
    padding: 16px 20px 14px;
    border-bottom: 1px solid #f0f3f8;
    display: flex;
    align-items: flex-start;
    gap: 12px;
}
.kk-card-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}
.icon-blue   { background: #e8f0fe; color: #1a5ca8; }
.icon-teal   { background: #e0f7f4; color: #0d9488; }
.icon-purple { background: #f3e8ff; color: #7c3aed; }
.icon-green  { background: #e6f7ef; color: #1dab6a; }
.icon-orange { background: #fff3e6; color: #f08030; }

.kk-card-title {
    font-size: 0.85rem;
    font-weight: 700;
    color: #1c2d4a;
    line-height: 1.35;
    margin-bottom: 2px;
}
.kk-card-sub {
    font-size: 0.72rem;
    color: #8898aa;
}

/* Kuota progress bar */
.kk-card-body { 
    padding: 16px 20px 18px; 
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}
.kk-quota-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}
.kk-quota-label { font-size: 0.78rem; color: #6b7a9a; }
.kk-quota-nums  { font-size: 0.82rem; font-weight: 700; color: #1c2d4a; }
.kk-progress {
    height: 7px;
    background: #f0f3f8;
    border-radius: 99px;
    overflow: hidden;
    margin-bottom: 14px;
}
.kk-progress-bar {
    height: 100%;
    border-radius: 99px;
    transition: width 0.5s ease;
}
.bar-blue   { background: linear-gradient(90deg, #1a5ca8, #4a90e2); }
.bar-teal   { background: linear-gradient(90deg, #0d9488, #2dd4bf); }
.bar-purple { background: linear-gradient(90deg, #7c3aed, #a78bfa); }
.bar-green  { background: linear-gradient(90deg, #1dab6a, #34d399); }
.bar-orange { background: linear-gradient(90deg, #f08030, #fbbf24); }

/* Stat row */
.kk-stats {
    display: flex;
    gap: 12px;
    margin-bottom: 14px;
    flex-grow: 1; /* Supaya mengisi sisa ruang jika diperlukan */
}
.kk-stat {
    flex: 1;
    text-align: center;
    background: #f7f9ff;
    border-radius: 8px;
    padding: 8px 4px;
}
.kk-stat .kk-stat-num {
    font-size: 1.2rem;
    font-weight: 800;
    color: #0c3975;
    line-height: 1;
}
.kk-stat .kk-stat-lbl {
    font-size: 0.68rem;
    color: #8898aa;
    margin-top: 2px;
}

/* Badge status */
.kk-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 0.7rem;
    font-weight: 600;
    padding: 3px 9px;
    border-radius: 99px;
}
.badge-full    { background: #fde8e8; color: #e05050; }
.badge-almost  { background: #fff3e6; color: #f08030; }
.badge-ok      { background: #e6f7ef; color: #1dab6a; }
.badge-empty   { background: #f0f3f8; color: #8898aa; }

/* Edit kuota inline form */
.kk-edit-form {
    display: none;
    border-top: 1px solid #f0f3f8;
    padding: 14px 20px;
    background: #f7f9ff;
}
.kk-edit-form.show { display: block; }
.kk-edit-form .form-control {
    font-size: 0.83rem;
    border-radius: 7px;
    border: 1px solid #d0d9ec;
    padding: 7px 12px;
    height: auto;
}
.kk-edit-form .form-control:focus {
    border-color: #1a5ca8;
    box-shadow: 0 0 0 3px rgba(26,92,168,0.12);
}
.kk-btn {
    font-size: 0.78rem;
    font-weight: 600;
    padding: 7px 16px;
    border-radius: 7px;
    border: none;
    cursor: pointer;
    transition: opacity 0.15s;
}
.kk-btn:hover { opacity: 0.85; }
.kk-btn-save   { background: #1a5ca8; color: #fff; }
.kk-btn-cancel { background: #e8ecf4; color: #4a5568; }
.kk-btn-edit {
    font-size: 0.75rem;
    font-weight: 600;
    color: #1a5ca8;
    background: #e8f0fe;
    border: none;
    padding: 5px 12px;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.15s;
    margin-top: auto;
}
.kk-btn-edit:hover { background: #d0e2fd; }
</style>

<!-- Page Header -->
<div class="kk-page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="fas fa-sliders-h mr-2" style="color:#1a5ca8;"></i>Kelola Kuota Bidang</h4>
        <p>Atur dan pantau kuota penerimaan mahasiswa magang untuk setiap bidang.</p>
    </div>
</div>

<!-- Summary Bar -->
<?php
// Data bidang dengan kuota (statis + dari DB jika tersedia)
$bidang_list = [
    [
        'id'          => 2,
        'nama'        => 'Bidang Diseminasi Informasi Dan Komunikasi Publik',
        'kode'        => 'BDIKP',
        'icon_class'  => 'icon-teal',
        'bar_class'   => 'bar-teal',
        'kuota_total' => $kuota_bidang[2]['kuota_total']  ?? 8,
        'kuota_terisi'=> $kuota_bidang[2]['kuota_terisi'] ?? 3,
        'aktif'       => $kuota_bidang[2]['aktif']        ?? 3,
        'selesai'     => $kuota_bidang[2]['selesai']      ?? 0,
    ],
    [
        'id'          => 3,
        'nama'        => 'Bidang Sarana, Prasarana TIK dan Persandian',
        'kode'        => 'BSPTIK',
        'icon_class'  => 'icon-purple',
        'bar_class'   => 'bar-purple',
        'kuota_total' => $kuota_bidang[3]['kuota_total']  ?? 10,
        'kuota_terisi'=> $kuota_bidang[3]['kuota_terisi'] ?? 5,
        'aktif'       => $kuota_bidang[3]['aktif']        ?? 5,
        'selesai'     => $kuota_bidang[3]['selesai']      ?? 1,
    ],
    [
        'id'          => 4,
        'nama'        => 'Bidang Statistik dan Pemberdayaan TIK',
        'kode'        => 'BSPTIK2',
        'icon_class'  => 'icon-green',
        'bar_class'   => 'bar-green',
        'kuota_total' => $kuota_bidang[4]['kuota_total']  ?? 6,
        'kuota_terisi'=> $kuota_bidang[4]['kuota_terisi'] ?? 2,
        'aktif'       => $kuota_bidang[4]['aktif']        ?? 2,
        'selesai'     => $kuota_bidang[4]['selesai']      ?? 0,
    ],
    [
        'id'          => 5,
        'nama'        => 'Bidang Pengembangan E-Government',
        'kode'        => 'BPEG',
        'icon_class'  => 'icon-orange',
        'bar_class'   => 'bar-orange',
        'kuota_total' => $kuota_bidang[5]['kuota_total']  ?? 8,
        'kuota_terisi'=> $kuota_bidang[5]['kuota_terisi'] ?? 4,
        'aktif'       => $kuota_bidang[5]['aktif']        ?? 4,
        'selesai'     => $kuota_bidang[5]['selesai']      ?? 1,
    ],
];

$total_kuota  = array_sum(array_column($bidang_list, 'kuota_total'));
$total_terisi = array_sum(array_column($bidang_list, 'kuota_terisi'));
$total_sisa   = $total_kuota - $total_terisi;
?>

<div class="kk-summary">
    <div class="kk-summary-item">
        <div class="s-label">Total Kuota</div>
        <div class="s-val blue"><?= $total_kuota ?></div>
    </div>
    <div class="kk-summary-item">
        <div class="s-label">Terisi</div>
        <div class="s-val green"><?= $total_terisi ?></div>
    </div>
    <div class="kk-summary-item">
        <div class="s-label">Sisa Kuota</div>
        <div class="s-val orange"><?= $total_sisa ?></div>
    </div>
    <div class="kk-summary-item">
        <div class="s-label">Jumlah Bidang</div>
        <div class="s-val blue"><?= count($bidang_list) ?></div>
    </div>
</div>

<!-- Bidang Cards Grid -->
<div class="kk-grid">
<?php foreach ($bidang_list as $b):
    $pct      = $b['kuota_total'] > 0 ? round(($b['kuota_terisi'] / $b['kuota_total']) * 100) : 0;
    $sisa     = $b['kuota_total'] - $b['kuota_terisi'];
    if ($pct >= 100)    { $badge = 'badge-full';   $badge_text = 'Penuh'; $badge_icon = 'fa-times-circle'; }
    elseif ($pct >= 80) { $badge = 'badge-almost'; $badge_text = 'Hampir Penuh'; $badge_icon = 'fa-exclamation-circle'; }
    elseif ($pct > 0)   { $badge = 'badge-ok';     $badge_text = 'Tersedia'; $badge_icon = 'fa-check-circle'; }
    else                { $badge = 'badge-empty';   $badge_text = 'Kosong'; $badge_icon = 'fa-circle'; }
?>
    <div class="kk-card">
        <!-- Header -->
        <div class="kk-card-header">
            <div class="kk-card-icon <?= $b['icon_class'] ?>">
                <i class="fas fa-building"></i>
            </div>
            <div style="flex:1; min-width:0;">
                <div class="kk-card-title"><?= esc($b['nama']) ?></div>
                <div class="kk-card-sub"><?= esc($b['kode']) ?></div>
            </div>
            <span class="kk-badge <?= $badge ?>">
                <i class="fas <?= $badge_icon ?>"></i>
                <?= $badge_text ?>
            </span>
        </div>

        <!-- Body -->
        <div class="kk-card-body">
            <!-- Progress -->
            <div class="kk-quota-row">
                <span class="kk-quota-label">Pengisian Kuota</span>
                <span class="kk-quota-nums"><?= $b['kuota_terisi'] ?> / <?= $b['kuota_total'] ?> slot</span>
            </div>
            <div class="kk-progress">
                <div class="kk-progress-bar <?= $b['bar_class'] ?>"
                     style="width: <?= min($pct, 100) ?>%;"></div>
            </div>

            <!-- Stats -->
            <div class="kk-stats">
                <div class="kk-stat">
                    <div class="kk-stat-num" style="color:#1dab6a;"><?= $b['aktif'] ?></div>
                    <div class="kk-stat-lbl">Aktif</div>
                </div>
                <div class="kk-stat">
                    <div class="kk-stat-num" style="color:#8898aa;"><?= $b['selesai'] ?></div>
                    <div class="kk-stat-lbl">Selesai</div>
                </div>
                <div class="kk-stat">
                    <div class="kk-stat-num" style="color:#f08030;"><?= $sisa ?></div>
                    <div class="kk-stat-lbl">Sisa</div>
                </div>
                <div class="kk-stat">
                    <div class="kk-stat-num"><?= $pct ?>%</div>
                    <div class="kk-stat-lbl">Terisi</div>
                </div>
            </div>

            <!-- Edit Button -->
            <button class="kk-btn-edit w-100"
                    onclick="toggleEditForm(<?= $b['id'] ?>)">
                <i class="fas fa-pen mr-1"></i> Ubah Kuota
            </button>
        </div>

        <!-- Edit Form (hidden by default) -->
        <div class="kk-edit-form" id="edit-form-<?= $b['id'] ?>">
            <form method="post" action="<?= base_url('sekretariat/c_kabid/simpan-kuota') ?>">
                <?= csrf_field() ?>
                <input type="hidden" name="id_bidang" value="<?= $b['id'] ?>">
                <div class="mb-2">
                    <label class="d-block mb-1"
                           style="font-size:0.78rem; font-weight:600; color:#4a5568;">
                        Kuota Total
                    </label>
                    <input type="number" name="kuota_total"
                           class="form-control"
                           value="<?= $b['kuota_total'] ?>"
                           min="0" max="100" required>
                </div>
                <div class="d-flex gap-2" style="gap:8px;">
                    <button type="submit" class="kk-btn kk-btn-save">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>
                    <button type="button" class="kk-btn kk-btn-cancel"
                            onclick="toggleEditForm(<?= $b['id'] ?>)">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php endforeach; ?>
</div>

<?= $this->section('scripts'); ?>
<script>
function toggleEditForm(id) {
    var form = document.getElementById('edit-form-' + id);
    if (form) form.classList.toggle('show');
}
</script>
<?= $this->endSection(); ?>

<?= $this->endSection(); ?>
