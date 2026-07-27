<?php
/**
 * ============================================================
 * Kode      : _list.php
 * Path      : Views/dashboard/sekretariat/verifikasi/_list.php
 * Deskripsi : Partial view untuk daftar permohonan.
 * ============================================================
 */
?>

<!-- Search & Filter -->
<div class="verifikasi-search-bar">
    <div style="position:relative; flex:1; max-width:450px;">
        <i class="fas fa-search" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#98a2b3;"></i>
        <input type="text" id="searchVerifikasi" placeholder="Cari nama/ universitas..." style="width:100%;">
    </div>
    <select id="filterStatus">
        <option value="">Semua Status</option>
        <option value="MENUNGGU">Menunggu</option>
        <option value="PERBAIKAN_BERKAS">Perbaikan Berkas</option>
        <option value="DISETUJUI">Disetujui</option>
    </select>
</div>

<!-- Verifikasi Table -->
<div class="table-responsive">
    <table class="riwayat-table" id="tabelVerifikasi" width="100%">
        <thead>
            <tr>
                <th width="5%" class="text-center">NO</th>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
                <th>Instansi</th>
                <th>Tanggal Pengajuan</th>
                <th class="text-center">Status Persetujuan</th>
                <th class="text-center">Status Penempatan dan Bidang</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($permohonan)) : ?>
                <?php $no = 1; foreach ($permohonan as $row) : ?>
                <?php
                    $status = $row->status_persetujuan ?? 'MENUNGGU';
                    
                    if ($status == 'DISETUJUI') {
                        $badgeClass = 'disetujui';
                        $statusText = 'Disetujui';
                    } elseif ($status == 'PERBAIKAN_BERKAS') {
                        $badgeClass = 'ditolak';
                        $statusText = 'Perbaikan Berkas';
                    } else {
                        $badgeClass = 'menunggu-verifikasi';
                        $statusText = 'Menunggu';
                    }
                ?>
                <tr data-filter-status="<?= $status ?>">
                    <td class="text-center"><?= $no++ ?></td>
                    <td><strong><?= esc($row->nama_mahasiswa ?? '-') ?></strong></td>
                    <td><?= esc($row->nim ?? '-') ?></td>
                    <td><?= esc($row->instansi_pendidikan ?? '-') ?></td>
                    <td><?= !empty($row->tgl_pengajuan) ? date('d M Y', strtotime($row->tgl_pengajuan)) : '-' ?></td>
                    <td class="text-center">
                        <span class="status-badge <?= $badgeClass ?>"><?= $statusText ?></span>
                    </td>
                    <td class="text-center align-middle">
                        <span class="<?= esc($row->badge_penempatan) ?> mb-1"><?= esc($row->label_penempatan) ?></span><br>
                        <small class="text-muted"><i class="fas fa-building mr-1"></i> <?= esc($row->bidang_display) ?></small>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center" style="gap:4px;">
                            <!-- Ikon Pensil (Edit/Verifikasi) - CLASS DIUBAH KE btn-verifikasi-detail -->
                            <button type="button" 
                                    class="riwayat-action-btn btn-verifikasi-detail" 
                                    title="Verifikasi Permohonan"
                                    style="display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; border:none; background:#EFF6FF; color:#2563EB; border-radius:6px;"
                                    data-id="<?= $row->id_permohonan_magang ?>">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
