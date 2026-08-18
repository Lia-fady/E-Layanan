<div class="card shadow mb-4">
    <div class="card-body">
        <div class="mb-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <span class="mr-2 text-muted" style="font-size: 0.88rem;">Tampilkan</span>
                <select id="customLength" class="form-control form-control-sm custom-select custom-select-sm" style="width: 65px;">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="ml-2 text-muted" style="font-size: 0.88rem;">entri</span>
            </div>
            
            <div class="d-flex align-items-center" style="gap: 10px;">
                <select id="filterStatusCustom" class="form-control form-control-sm custom-select custom-select-sm" style="width: 160px;">
                    <option value="">Semua Status</option>
                    <option value="Menunggu">Menunggu</option>
                    <option value="Berjalan">Berjalan</option>
                    <option value="Selesai">Selesai</option>
                    <option value="Dibatalkan">Dibatalkan</option>
                </select>
                
                <div class="input-group input-group-sm" style="width: 220px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                    </div>
                    <input type="text" id="searchTable" class="form-control border-left-0 pl-0" placeholder="Cari Nama / Instansi...">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTableCustom" width="100%" cellspacing="0">
                <thead class="bg-primary text-white">
                    <tr>
                        <th width="5%" class="text-center align-middle">No</th>
                        <th width="25%" class="text-center align-middle">Nama</th>
                        <th width="25%" class="text-center align-middle">Instansi / Jurusan</th>
                        <th width="15%" class="text-center align-middle">Jenis Permohonan</th>
                        <th width="15%" class="text-center align-middle">Status</th>
                        <th width="15%" class="text-center align-middle">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($penempatan)): ?>
                        <?php $no = 1; foreach ($penempatan as $row): ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td>
                                <strong><?= esc($row->nama_mahasiswa) ?></strong><br>
                                <small class="text-muted"><?= esc($row->nim ?? '-') ?></small>
                            </td>
                            <td>
                                <?= esc($row->instansi_pendidikan ?? '-') ?><br>
                                <small class="text-muted"><?= esc($row->prodi ?? '-') ?></small>
                            </td>
                            <td>
                                <span class="badge badge-info"><?= esc($row->jenis_permohonan ?? '-') ?></span>
                            </td>
                            <td>
                                <?php if ($row->status_penempatan == 'MENUNGGU'): ?>
                                    <span class="badge badge-warning">Menunggu</span>
                                <?php elseif ($row->status_penempatan == 'BERJALAN'): ?>
                                    <span class="badge badge-primary">Berjalan</span>
                                <?php elseif ($row->status_penempatan == 'SELESAI'): ?>
                                    <span class="badge badge-success">Selesai</span>
                                <?php elseif ($row->status_penempatan == 'DIBATALKAN'): ?>
                                    <span class="badge badge-danger">Dibatalkan</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary"><?= esc($row->status_penempatan) ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-info btn-detail" 
                                    data-id="<?= $row->id_penempatan_magang ?>"
                                    title="Detail Permohonan">
                                    <i class="far fa-eye"></i> Detail
                                </button>
                                <button type="button" class="btn btn-sm btn-secondary"
                                    onclick="showLogRiwayatKabid(<?= $row->id_permohonan_magang ?>)"
                                    title="Lacak Jejak (Log Riwayat)">
                                    <i class="fas fa-history"></i> Log
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
