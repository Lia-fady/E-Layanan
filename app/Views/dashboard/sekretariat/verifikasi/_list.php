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
                        $badgeClass = 'ditolak'; // we use orange/warning usually, but keeping current
                        $statusText = 'Perbaikan Berkas';
                    } elseif ($status == 'DITOLAK') {
                        $badgeClass = 'ditolak'; // Assuming ditolak class gives red styling
                        $statusText = 'Ditolak';
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
                    <td><?= tgl_indo($row->tgl_pengajuan) ?></td>
                    <td class="text-center">
                        <span class="status-badge <?= $badgeClass ?>"><?= $statusText ?></span>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center" style="gap:4px;">
                            <button type="button" 
                                    class="riwayat-action-btn btn-verifikasi-detail" 
                                    title="Verifikasi Permohonan"
                                    style="display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; border:none; background:#EFF6FF; color:#2563EB; border-radius:6px;"
                                    data-id="<?= $row->id_permohonan_magang ?>">
                                <i class="fas fa-edit"></i>
                            </button>
                            <!-- Ikon Tolak Cepat -->
                            <button type="button" 
                                    class="riwayat-action-btn btn-tolak-cepat" 
                                    title="Tolak Permohonan"
                                    style="display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; border:none; background:#FEF2F2; color:#DC2626; border-radius:6px;"
                                    data-id="<?= $row->id_permohonan_magang ?>">
                                <i class="fas fa-times"></i>
                            </button>
                            <!-- Ikon History/Log -->
                            <button type="button" 
                                    class="riwayat-action-btn" 
                                    title="Lacak Jejak (Log Riwayat)"
                                    style="display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; border:none; background:#E0F2FE; color:#0369A1; border-radius:6px;"
                                    onclick="showLogRiwayatSekre(<?= $row->id_permohonan_magang ?>)">
                                <i class="fas fa-history"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
