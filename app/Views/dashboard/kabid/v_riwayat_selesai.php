<?= $this->extend('layout/L_master_kabid') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 style="font-weight:700; color:#1B2559; margin-bottom:4px;">Riwayat Permohonan Selesai</h5>
        <p style="color:#667085; font-size:0.85rem; margin:0;">
            Daftar arsip permohonan yang telah selesai diproses.
        </p>
    </div>
</div>

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

            <div class="d-flex align-items-center" style="gap: 10px; flex-wrap: wrap;">
                <div class="input-group input-group-sm" style="width: 240px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                    </div>
                    <input type="text" id="searchMahasiswa" class="form-control border-left-0 pl-0" placeholder="Cari Nama / NIM...">
                </div>

                <select id="filterJenisPermohonan" class="form-control form-control-sm custom-select custom-select-sm" style="width: 180px;">
                    <option value="">Semua Jenis</option>
                    <?php if (isset($list_jenis)): ?>
                        <?php foreach($list_jenis as $j): ?>
                            <option value="<?= esc($j['jenis_permohonan']) ?>"><?= esc($j['jenis_permohonan']) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>

                <select id="filterStatus" class="form-control form-control-sm custom-select custom-select-sm" style="width: 140px;">
                    <option value="">Semua Status</option>
                    <option value="Selesai">Selesai</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="riwayatTable" width="100%" cellspacing="0">
                <thead class="bg-primary text-white">
                    <tr>
                        <th width="5%" class="text-center align-middle">No</th>
                        <th width="22%" class="text-center align-middle">Nama & NIM</th>
                        <th width="24%" class="text-center align-middle">Instansi / Prodi</th>
                        <th style="display:none;">Jenis</th>
                        <th width="16%" class="text-center align-middle">Periode</th>
                        <th width="14%" class="text-center align-middle">Status Akhir</th>
                        <th width="19%" class="text-center align-middle">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($mahasiswa)): ?>
                        <?php $no = 1; foreach ($mahasiswa as $mhs): ?>
                            <tr>
                                <td class="text-center align-middle"><?= $no++ ?></td>
                                <td class="align-middle">
                                    <strong><?= esc($mhs->nama_mahasiswa) ?></strong><br>
                                    <small class="text-muted"><?= esc($mhs->nim ?? '-') ?></small>
                                </td>
                                <td class="align-middle">
                                    <?= esc($mhs->instansi_pendidikan ?? '-') ?><br>
                                    <small class="text-muted"><?= esc($mhs->prodi ?? '-') ?></small>
                                </td>
                                <td style="display:none;"><?= esc($mhs->jenis_permohonan ?? '') ?></td>
                                <td class="align-middle">
                                    <?= isset($mhs->tgl_mulai) ? date('j M Y', strtotime($mhs->tgl_mulai)) : '-' ?>
                                    <br>
                                    <?= isset($mhs->tgl_selesai) ? date('j M Y', strtotime($mhs->tgl_selesai)) : '-' ?>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="badge badge-success">Selesai</span>
                                </td>
                                <td class="align-middle text-center">
                                    <button type="button" class="btn btn-sm btn-outline-primary p-0" style="width:34px; height:34px; border-radius:12px;" onclick="showDetailRiwayat(<?= $mhs->id_penempatan_magang ?>)" title="Detail Riwayat Permohonan">
                                        <i class="fas fa-search"></i>
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

<!-- MODAL DETAIL RIWAYAT PERMOHONAN -->
<div class="modal fade" id="modalDetailRiwayat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow" style="border-radius: 12px;">
            <div class="modal-header bg-white border-bottom py-3">
                <h5 class="modal-title fw-bold text-dark m-0">Detail Riwayat Permohonan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-white" id="detailRiwayatBody"></div>
            <div class="modal-footer bg-white border-top py-3">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    var table = $('#riwayatTable').DataTable({
        searching: true,
        paging: true,
        info: true,
        dom: 'rt<"row mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        order: []
    });

    $('#searchMahasiswa').on('keyup', function() {
        table.search(this.value).draw();
    });

    $('#customLength').on('change', function() {
        table.page.len(this.value).draw();
    });

    $('#filterJenisPermohonan').on('change', function() {
        table.column(3).search(this.value).draw();
    });

    $('#filterStatus').on('change', function() {
        table.column(5).search(this.value).draw();
    });

    window.showDetailRiwayat = function(id) {
        var modalEl = document.getElementById('modalDetailRiwayat');
        var modal = new bootstrap.Modal(modalEl);
        var container = document.getElementById('detailRiwayatBody');
        container.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="text-muted mt-3 small">Memuat detail riwayat...</p>
            </div>`;
        modal.show();

        fetch('<?= base_url('kabid/riwayat-selesai') ?>?action=detail&id=' + id, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(function(response) {
                return response.json();
            })
            .then(function(result) {
                if (result.status !== 'success') {
                    container.innerHTML = `<div class="alert alert-danger small">${result.message || 'Detail tidak dapat dimuat.'}</div>`;
                    return;
                }

                var d = result.data;
                var suratRow = d.surat_selesai ? `
                    <div class="d-flex align-items-center justify-content-between py-3 border-bottom">
                        <div>
                            <div class="fw-semibold text-dark">${d.surat_selesai.label}</div>
                            <small class="text-muted">${d.surat_selesai.nama_file}</small>
                        </div>
                        <a href="${d.surat_selesai.url}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat / Unduh</a>
                    </div>` : `
                    <div class="d-flex align-items-center justify-content-between py-3 border-bottom">
                        <div>
                            <div class="fw-semibold text-dark">Surat Keterangan Selesai Kegiatan</div>
                            <small class="text-muted">Tidak tersedia</small>
                        </div>
                    </div>`;

                var cvRow = d.cv ? `
                    <div class="d-flex align-items-center justify-content-between py-3 border-bottom">
                        <div>
                            <div class="fw-semibold text-dark">${d.cv.label}</div>
                            <small class="text-muted">${d.cv.nama_file}</small>
                        </div>
                        <a href="${d.cv.url}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat / Unduh</a>
                    </div>` : `
                    <div class="d-flex align-items-center justify-content-between py-3 border-bottom">
                        <div>
                            <div class="fw-semibold text-dark">Curriculum Vitae (CV)</div>
                            <small class="text-muted">Tidak tersedia</small>
                        </div>
                    </div>`;

                var ktmRow = d.ktm ? `
                    <div class="d-flex align-items-center justify-content-between py-3">
                        <div>
                            <div class="fw-semibold text-dark">${d.ktm.label}</div>
                            <small class="text-muted">${d.ktm.nama_file}</small>
                        </div>
                        <a href="${d.ktm.url}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat / Unduh</a>
                    </div>` : `
                    <div class="d-flex align-items-center justify-content-between py-3">
                        <div>
                            <div class="fw-semibold text-dark">Kartu Tanda Mahasiswa (KTM)</div>
                            <small class="text-muted">Tidak tersedia</small>
                        </div>
                    </div>`;

                container.innerHTML = `
                    <div class="mb-4">
                        <div class="text-uppercase fw-bold text-primary" style="font-size:0.72rem; letter-spacing:0.12em;">Data Diri Mahasiswa</div>
                        <div class="row mt-3 g-3">
                            <div class="col-12 col-md-6">
                                <div class="text-muted" style="font-size:0.82rem;">Nama Lengkap</div>
                                <div class="fw-semibold text-dark">${d.nama_mahasiswa}</div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="text-muted" style="font-size:0.82rem;">NIM</div>
                                <div class="fw-semibold text-dark">${d.nim}</div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="text-muted" style="font-size:0.82rem;">Instansi Pendidikan</div>
                                <div class="fw-semibold text-dark">${d.instansi_pendidikan}</div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="text-muted" style="font-size:0.82rem;">Program Studi</div>
                                <div class="fw-semibold text-dark">${d.prodi}</div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="text-uppercase fw-bold text-primary" style="font-size:0.72rem; letter-spacing:0.12em;">Detail Kegiatan</div>
                        <div class="row mt-3 g-3">
                            <div class="col-12 col-md-6">
                                <div class="text-muted" style="font-size:0.82rem;">Jenis Permohonan</div>
                                <div class="fw-semibold text-dark">${d.jenis_permohonan}</div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="text-muted" style="font-size:0.82rem;">Periode Kegiatan</div>
                                <div class="fw-semibold text-dark">${d.tgl_mulai ? new Date(d.tgl_mulai).toLocaleDateString('id-ID', { day:'numeric', month:'short', year:'numeric' }) : '-'} &ndash; ${d.tgl_selesai ? new Date(d.tgl_selesai).toLocaleDateString('id-ID', { day:'numeric', month:'short', year:'numeric' }) : '-'}</div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="text-muted" style="font-size:0.82rem;">Status Akhir</div>
                                <span class="badge bg-success text-white">${d.status_akhir}</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="text-uppercase fw-bold text-primary" style="font-size:0.72rem; letter-spacing:0.12em;">File Dokumen</div>
                        <div class="mt-3 border rounded-3 bg-light p-3">
                            ${suratRow}
                            ${cvRow}
                            ${ktmRow}
                        </div>
                    </div>`;
            })
            .catch(function() {
                container.innerHTML = `<div class="alert alert-danger small">Terjadi kesalahan saat memuat detail.</div>`;
            });
    }
});
</script>
<?= $this->endSection() ?>
