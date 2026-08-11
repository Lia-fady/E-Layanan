<?= $this->extend('layout/L_master') ?>

<?= $this->section('title') ?>
Pemantauan Kuota Bidang
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-end mb-4">
    <div>
        <h5 style="font-weight:700; color:#1B2559; margin-bottom:4px;">Pemantauan Kuota Bidang</h5>
        <p style="color:#667085; font-size:0.85rem; margin:0;">
            Pantau status ketersediaan kuota mahasiswa untuk setiap bidang di tahun <?= esc($tahun) ?>.
        </p>
    </div>
</div>

<div class="row">
    <?php foreach($bidangs as $b): ?>
    <div class="col-12 mb-4">
        <div class="card shadow-sm bg-white" style="border-radius: 12px; border: 1px solid #E2E8F0;">
            <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between" style="border-bottom: 1px solid #E2E8F0; border-radius: 12px 12px 0 0;">
                <h6 class="m-0 font-weight-bold" style="color: #1E293B; font-size: 1.1rem;"><?= esc($b->bidang) ?></h6>
                <span class="badge badge-primary" style="font-size: 0.85rem; padding: 0.4rem 0.8rem; border-radius: 6px;">Limit Bulanan: <?= esc($b->kuota_limit) ?> Mahasiswa</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="font-size: 0.9rem;">
                        <thead class="bg-light text-center">
                            <tr>
                                <th style="border-top: none; color: #475569; font-weight: 600;" width="20%">Bulan</th>
                                <th style="border-top: none; color: #475569; font-weight: 600;" width="20%">Batas Kuota</th>
                                <th style="border-top: none; color: #475569; font-weight: 600;" width="20%">Terpakai</th>
                                <th style="border-top: none; color: #475569; font-weight: 600;" width="20%">Sisa Kuota</th>
                                <th style="border-top: none; color: #475569; font-weight: 600;" width="20%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($b->rekap_bulanan)): ?>
                                <?php foreach($b->rekap_bulanan as $rek): ?>
                                <?php 
                                    $isFull = $rek['sisa'] <= 0;
                                    $statusColor = $isFull ? '#DC2626' : '#16A34A';
                                    $statusBg = $isFull ? '#FEE2E2' : '#DCFCE7';
                                    $statusText = $isFull ? 'Penuh' : 'Tersedia';
                                ?>
                                <tr class="text-center align-middle">
                                    <td class="text-left font-weight-bold" style="color: #334155; padding-left: 1.5rem;"><?= esc($rek['bulan_nama']) ?></td>
                                    <td><?= esc($rek['kuota']) ?></td>
                                    <td><span style="color: #2563EB; font-weight: bold;"><?= esc($rek['terpakai']) ?></span></td>
                                    <td><span style="font-weight: 800; color: <?= $statusColor ?>;"><?= esc($rek['sisa']) ?></span></td>
                                    <td>
                                        <div class="badge" style="background-color: <?= $statusBg ?>; color: <?= $statusColor ?>; padding: 0.4rem 0.8rem; font-size: 0.8rem; border-radius: 6px;">
                                            <?= $statusText ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Data rekap bulanan tidak tersedia (kemungkinan limit belum diatur Kabid).</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>
