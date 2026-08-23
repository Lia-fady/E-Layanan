<?= $this->extend('layout/L_master_superadmin') ?>

<?= $this->section('title') ?><?= esc($title ?? 'Master Data Wilayah') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Master Data Wilayah</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('superadmin/dashboard') ?>">Master Data</a></li>
                    <li class="breadcrumb-item active">Wilayah</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        
        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <!-- ============================================== -->
        <!-- ================= FORMS (HIDDEN) ============= -->
        <!-- ============================================== -->

        <!-- FORM PROVINSI -->
        <div class="card shadow-sm d-none form-container" id="formProvinsi">
            <div class="card-header bg-primary text-white" id="headerFormProvinsi">
                <h3 class="card-title mb-0"><i class="fas fa-edit me-2"></i> Tambah Provinsi</h3>
            </div>
            <form id="realFormProvinsi" action="<?= base_url('superadmin/wilayah/store-provinsi') ?>" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Kode Provinsi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="kode_provinsi" id="provinsi_kode" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Provinsi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_provinsi" id="provinsi_nama" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                                <select class="form-control" name="status" id="provinsi_status" required>
                                    <option value="AKTIF">Aktif</option>
                                    <option value="NONAKTIF">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-cancel-form">
                        <i class="fas fa-arrow-left me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary text-white ms-auto">
                        <i class="fas fa-save me-1"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>

        <!-- FORM KABUPATEN -->
        <div class="card shadow-sm d-none form-container" id="formKabupaten">
            <div class="card-header bg-primary text-white" id="headerFormKabupaten">
                <h3 class="card-title mb-0"><i class="fas fa-edit me-2"></i> Tambah Kabupaten/Kota</h3>
            </div>
            <form id="realFormKabupaten" action="<?= base_url('superadmin/wilayah/store-kabupaten') ?>" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Provinsi <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="id_provinsi" id="kabupaten_provinsi" required>
                                    <option value="">-- Pilih Provinsi --</option>
                                    <?php foreach($provinsiList as $p): ?>
                                        <option value="<?= $p['id_provinsi'] ?>"><?= esc($p['nama_provinsi']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Kabupaten/Kota <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_kabupaten" id="kabupaten_nama" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                                <select class="form-control" name="status" id="kabupaten_status" required>
                                    <option value="AKTIF">Aktif</option>
                                    <option value="NONAKTIF">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-cancel-form">
                        <i class="fas fa-arrow-left me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary text-white ms-auto">
                        <i class="fas fa-save me-1"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>

        <!-- FORM KECAMATAN -->
        <div class="card shadow-sm d-none form-container" id="formKecamatan">
            <div class="card-header bg-primary text-white" id="headerFormKecamatan">
                <h3 class="card-title mb-0"><i class="fas fa-edit me-2"></i> Tambah Kecamatan</h3>
            </div>
            <form id="realFormKecamatan" action="<?= base_url('superadmin/wilayah/store-kecamatan') ?>" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Provinsi <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="kecamatan_provinsi" required>
                                    <option value="">-- Pilih Provinsi --</option>
                                    <?php foreach($provinsiList as $p): ?>
                                        <option value="<?= $p['id_provinsi'] ?>"><?= esc($p['nama_provinsi']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Kabupaten/Kota <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="id_kabupaten" id="kecamatan_kabupaten" required>
                                    <option value="">-- Pilih Kabupaten/Kota --</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Kecamatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_kecamatan" id="kecamatan_nama" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                                <select class="form-control" name="status" id="kecamatan_status" required>
                                    <option value="AKTIF">Aktif</option>
                                    <option value="NONAKTIF">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-cancel-form">
                        <i class="fas fa-arrow-left me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary text-white ms-auto">
                        <i class="fas fa-save me-1"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>

        <!-- FORM KELURAHAN -->
        <div class="card shadow-sm d-none form-container" id="formKelurahan">
            <div class="card-header bg-primary text-white" id="headerFormKelurahan">
                <h3 class="card-title mb-0"><i class="fas fa-edit me-2"></i> Tambah Kelurahan/Desa</h3>
            </div>
            <form id="realFormKelurahan" action="<?= base_url('superadmin/wilayah/store-kelurahan') ?>" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Provinsi <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="kelurahan_provinsi" required>
                                    <option value="">-- Pilih Provinsi --</option>
                                    <?php foreach($provinsiList as $p): ?>
                                        <option value="<?= $p['id_provinsi'] ?>"><?= esc($p['nama_provinsi']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Kabupaten/Kota <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="kelurahan_kabupaten" required>
                                    <option value="">-- Pilih Kabupaten/Kota --</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Kecamatan <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="id_kecamatan" id="kelurahan_kecamatan" required>
                                    <option value="">-- Pilih Kecamatan --</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Kelurahan/Desa <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_kelurahan" id="kelurahan_nama" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Kode Pos</label>
                                <input type="text" class="form-control" name="kode_pos" id="kelurahan_kode_pos">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                                <select class="form-control" name="status" id="kelurahan_status" required>
                                    <option value="AKTIF">Aktif</option>
                                    <option value="NONAKTIF">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-cancel-form">
                        <i class="fas fa-arrow-left me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary text-white ms-auto">
                        <i class="fas fa-save me-1"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>

        <!-- ============================================== -->
        <!-- ================= DATA TABEL ================= -->
        <!-- ============================================== -->
        <div class="card shadow-sm" id="tableContainer">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="wilayah-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="tab-provinsi" data-toggle="pill" href="#content-provinsi" role="tab">Provinsi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-kabupaten" data-toggle="pill" href="#content-kabupaten" role="tab">Kabupaten/Kota</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-kecamatan" data-toggle="pill" href="#content-kecamatan" role="tab">Kecamatan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-kelurahan" data-toggle="pill" href="#content-kelurahan" role="tab">Kelurahan/Desa</a>
                    </li>
                </ul>
            </div>
            
            <div class="card-body">
                <div class="tab-content" id="wilayah-tabContent">
                    
                    <!-- TAB PROVINSI -->
                    <div class="tab-pane fade show active" id="content-provinsi" role="tabpanel">
                        <div class="d-flex justify-content-between mb-3">
                            <h4 class="m-0">Master Data Provinsi</h4>
                            <button class="btn btn-primary btn-sm btn-tambah" data-target="formProvinsi">
                                <i class="fas fa-plus"></i> Tambah Provinsi
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped datatable">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Kode Provinsi</th>
                                        <th>Nama Provinsi</th>
                                        <th>Status</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($provinsiList as $k => $v): ?>
                                    <tr>
                                        <td><?= $k + 1 ?></td>
                                        <td><?= esc($v['kode_provinsi']) ?></td>
                                        <td><?= esc($v['nama_provinsi']) ?></td>
                                        <td>
                                            <?php if($v['status'] == 'AKTIF'): ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1 justify-content-center">
                                                <button type="button" class="btn btn-sm btn-warning text-white btn-edit-provinsi"
                                                    data-id="<?= $v['id_provinsi'] ?>"
                                                    data-kode="<?= esc($v['kode_provinsi']) ?>"
                                                    data-nama="<?= esc($v['nama_provinsi']) ?>"
                                                    data-status="<?= $v['status'] ?>"
                                                ><i class="fas fa-edit"></i></button>
                                                <button type="button" class="btn btn-sm btn-danger btn-hapus"
                                                    data-url="<?= base_url('superadmin/wilayah/delete-provinsi/'.$v['id_provinsi']) ?>"
                                                ><i class="fas fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- TAB KABUPATEN -->
                    <div class="tab-pane fade" id="content-kabupaten" role="tabpanel">
                        <div class="d-flex justify-content-between mb-3">
                            <h4 class="m-0">Master Data Kabupaten/Kota</h4>
                            <button class="btn btn-primary btn-sm btn-tambah" data-target="formKabupaten">
                                <i class="fas fa-plus"></i> Tambah Kabupaten/Kota
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped datatable">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Kode (ID)</th>
                                        <th>Provinsi</th>
                                        <th>Nama Kabupaten/Kota</th>
                                        <th>Status</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($kabupatenList as $k => $v): ?>
                                    <tr>
                                        <td><?= $k + 1 ?></td>
                                        <td><?= $v['id_kabupaten'] ?></td>
                                        <td><?= esc($v['nama_provinsi']) ?></td>
                                        <td><?= esc($v['nama_kabupaten']) ?></td>
                                        <td>
                                            <?php if($v['status'] == 'AKTIF'): ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1 justify-content-center">
                                                <button type="button" class="btn btn-sm btn-warning text-white btn-edit-kabupaten"
                                                    data-id="<?= $v['id_kabupaten'] ?>"
                                                    data-idprov="<?= $v['id_provinsi'] ?>"
                                                    data-nama="<?= esc($v['nama_kabupaten']) ?>"
                                                    data-status="<?= $v['status'] ?>"
                                                ><i class="fas fa-edit"></i></button>
                                                <button type="button" class="btn btn-sm btn-danger btn-hapus"
                                                    data-url="<?= base_url('superadmin/wilayah/delete-kabupaten/'.$v['id_kabupaten']) ?>"
                                                ><i class="fas fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- TAB KECAMATAN -->
                    <div class="tab-pane fade" id="content-kecamatan" role="tabpanel">
                        <div class="d-flex justify-content-between mb-3">
                            <h4 class="m-0">Master Data Kecamatan</h4>
                            <button class="btn btn-primary btn-sm btn-tambah" data-target="formKecamatan">
                                <i class="fas fa-plus"></i> Tambah Kecamatan
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped datatable">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Kode (ID)</th>
                                        <th>Provinsi</th>
                                        <th>Kabupaten/Kota</th>
                                        <th>Nama Kecamatan</th>
                                        <th>Status</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($kecamatanList as $k => $v): ?>
                                    <tr>
                                        <td><?= $k + 1 ?></td>
                                        <td><?= $v['id_kecamatan'] ?></td>
                                        <td><?= esc($v['nama_provinsi']) ?></td>
                                        <td><?= esc($v['nama_kabupaten']) ?></td>
                                        <td><?= esc($v['nama_kecamatan']) ?></td>
                                        <td>
                                            <?php if($v['status'] == 'AKTIF'): ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1 justify-content-center">
                                                <button type="button" class="btn btn-sm btn-warning text-white btn-edit-kecamatan"
                                                    data-id="<?= $v['id_kecamatan'] ?>"
                                                    data-idprov="<?= $v['id_provinsi'] ?>"
                                                    data-idkab="<?= $v['id_kabupaten'] ?>"
                                                    data-nama="<?= esc($v['nama_kecamatan']) ?>"
                                                    data-status="<?= $v['status'] ?>"
                                                ><i class="fas fa-edit"></i></button>
                                                <button type="button" class="btn btn-sm btn-danger btn-hapus"
                                                    data-url="<?= base_url('superadmin/wilayah/delete-kecamatan/'.$v['id_kecamatan']) ?>"
                                                ><i class="fas fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- TAB KELURAHAN -->
                    <div class="tab-pane fade" id="content-kelurahan" role="tabpanel">
                        <div class="d-flex justify-content-between mb-3">
                            <h4 class="m-0">Master Data Kelurahan/Desa</h4>
                            <button class="btn btn-primary btn-sm btn-tambah" data-target="formKelurahan">
                                <i class="fas fa-plus"></i> Tambah Kelurahan/Desa
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped datatable">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Kode Pos</th>
                                        <th>Provinsi</th>
                                        <th>Kabupaten/Kota</th>
                                        <th>Kecamatan</th>
                                        <th>Nama Kelurahan/Desa</th>
                                        <th>Status</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($kelurahanList as $k => $v): ?>
                                    <tr>
                                        <td><?= $k + 1 ?></td>
                                        <td><?= esc($v['kode_pos'] ?? '-') ?></td>
                                        <td><?= esc($v['nama_provinsi']) ?></td>
                                        <td><?= esc($v['nama_kabupaten']) ?></td>
                                        <td><?= esc($v['nama_kecamatan']) ?></td>
                                        <td><?= esc($v['nama_kelurahan']) ?></td>
                                        <td>
                                            <?php if($v['status'] == 'AKTIF'): ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1 justify-content-center">
                                                <button type="button" class="btn btn-sm btn-warning text-white btn-edit-kelurahan"
                                                    data-id="<?= $v['id_kelurahan'] ?>"
                                                    data-idprov="<?= $v['id_provinsi'] ?>"
                                                    data-idkab="<?= $v['id_kabupaten'] ?>"
                                                    data-idkec="<?= $v['id_kecamatan'] ?>"
                                                    data-nama="<?= esc($v['nama_kelurahan']) ?>"
                                                    data-kodepos="<?= esc($v['kode_pos']) ?>"
                                                    data-status="<?= $v['status'] ?>"
                                                ><i class="fas fa-edit"></i></button>
                                                <button type="button" class="btn btn-sm btn-danger btn-hapus"
                                                    data-url="<?= base_url('superadmin/wilayah/delete-kelurahan/'.$v['id_kelurahan']) ?>"
                                                ><i class="fas fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Initialize Datatables
    $('.datatable').DataTable();
    
    // Switch between List and Form
    $('.btn-tambah').on('click', function() {
        let target = $(this).data('target');
        $('#tableContainer').addClass('d-none');
        $('.form-container').addClass('d-none');
        $('#' + target).removeClass('d-none');
        
        // Reset Form
        $('#realForm' + target.replace('form',''))[0].reset();
        $('#realForm' + target.replace('form','')).attr('action', '<?= base_url('superadmin/wilayah/store-') ?>' + target.replace('form','').toLowerCase());
        $('#headerForm' + target.replace('form','')).removeClass('bg-warning').addClass('bg-primary');
        $('#headerForm' + target.replace('form','') + ' h3').html('<i class="fas fa-plus me-2"></i> Tambah ' + target.replace('form',''));
    });

    $('.btn-cancel-form').on('click', function() {
        $('.form-container').addClass('d-none');
        $('#tableContainer').removeClass('d-none');
    });

    // -------------------------------------------------------------
    // Edit Buttons
    // -------------------------------------------------------------
    $('.btn-edit-provinsi').on('click', function() {
        $('#tableContainer').addClass('d-none');
        $('#formProvinsi').removeClass('d-none');
        $('#headerFormProvinsi').removeClass('bg-primary').addClass('bg-warning');
        $('#headerFormProvinsi h3').html('<i class="fas fa-edit me-2"></i> Edit Provinsi');
        
        $('#realFormProvinsi').attr('action', '<?= base_url('superadmin/wilayah/update-provinsi/') ?>' + $(this).data('id'));
        $('#provinsi_kode').val($(this).data('kode'));
        $('#provinsi_nama').val($(this).data('nama'));
        $('#provinsi_status').val($(this).data('status'));
    });

    $('.btn-edit-kabupaten').on('click', function() {
        $('#tableContainer').addClass('d-none');
        $('#formKabupaten').removeClass('d-none');
        $('#headerFormKabupaten').removeClass('bg-primary').addClass('bg-warning');
        $('#headerFormKabupaten h3').html('<i class="fas fa-edit me-2"></i> Edit Kabupaten/Kota');
        
        $('#realFormKabupaten').attr('action', '<?= base_url('superadmin/wilayah/update-kabupaten/') ?>' + $(this).data('id'));
        $('#kabupaten_provinsi').val($(this).data('idprov')).trigger('change');
        $('#kabupaten_nama').val($(this).data('nama'));
        $('#kabupaten_status').val($(this).data('status'));
    });

    $('.btn-edit-kecamatan').on('click', function() {
        $('#tableContainer').addClass('d-none');
        $('#formKecamatan').removeClass('d-none');
        $('#headerFormKecamatan').removeClass('bg-primary').addClass('bg-warning');
        $('#headerFormKecamatan h3').html('<i class="fas fa-edit me-2"></i> Edit Kecamatan');
        
        $('#realFormKecamatan').attr('action', '<?= base_url('superadmin/wilayah/update-kecamatan/') ?>' + $(this).data('id'));
        $('#kecamatan_provinsi').val($(this).data('idprov')).trigger('change');
        
        // Wait a bit for ajax to populate kabupaten, then select it
        setTimeout(() => {
            $('#kecamatan_kabupaten').val($(this).data('idkab')).trigger('change');
        }, 500);

        $('#kecamatan_nama').val($(this).data('nama'));
        $('#kecamatan_status').val($(this).data('status'));
    });

    $('.btn-edit-kelurahan').on('click', function() {
        $('#tableContainer').addClass('d-none');
        $('#formKelurahan').removeClass('d-none');
        $('#headerFormKelurahan').removeClass('bg-primary').addClass('bg-warning');
        $('#headerFormKelurahan h3').html('<i class="fas fa-edit me-2"></i> Edit Kelurahan/Desa');
        
        $('#realFormKelurahan').attr('action', '<?= base_url('superadmin/wilayah/update-kelurahan/') ?>' + $(this).data('id'));
        $('#kelurahan_provinsi').val($(this).data('idprov')).trigger('change');
        
        // Cascade loading
        let idkab = $(this).data('idkab');
        let idkec = $(this).data('idkec');
        setTimeout(() => {
            $('#kelurahan_kabupaten').val(idkab).trigger('change');
            setTimeout(() => {
                $('#kelurahan_kecamatan').val(idkec).trigger('change');
            }, 500);
        }, 500);

        $('#kelurahan_nama').val($(this).data('nama'));
        $('#kelurahan_kode_pos').val($(this).data('kodepos'));
        $('#kelurahan_status').val($(this).data('status'));
    });

    // -------------------------------------------------------------
    // SweetAlert Confirmations
    // -------------------------------------------------------------
    $('form').on('submit', function(e) {
        e.preventDefault();
        let form = this;
        let isEdit = $(form).attr('action').includes('update');
        let title = isEdit ? 'Simpan Perubahan?' : 'Simpan Data?';
        let text = isEdit ? 'Apakah perubahan data ingin disimpan?' : 'Apakah data ingin disimpan?';
        
        Swal.fire({
            title: title,
            text: text,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    $('.btn-hapus').on('click', function() {
        let url = $(this).data('url');
        Swal.fire({
            title: 'Hapus Data?',
            text: 'Apakah Anda yakin ingin menghapus data ini? Data yang sudah dihapus tidak dapat dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit via fake form for POST request
                let form = $('<form action="' + url + '" method="POST"></form>');
                $('body').append(form);
                form.submit();
            }
        });
    });

    // -------------------------------------------------------------
    // Dependent Dropdowns AJAX
    // -------------------------------------------------------------
    
    // Form Kecamatan: Load Kabupaten
    $('#kecamatan_provinsi').change(function() {
        let idProv = $(this).val();
        $('#kecamatan_kabupaten').html('<option value="">Loading...</option>');
        if(idProv) {
            $.ajax({
                url: '<?= base_url('superadmin/wilayah/get-kabupaten/') ?>' + idProv,
                type: 'GET',
                success: function(res) {
                    let opts = '<option value="">-- Pilih Kabupaten/Kota --</option>';
                    if(res.status && res.data.length > 0) {
                        res.data.forEach(item => {
                            opts += `<option value="${item.id_kabupaten}">${item.nama_kabupaten}</option>`;
                        });
                    }
                    $('#kecamatan_kabupaten').html(opts);
                }
            });
        } else {
            $('#kecamatan_kabupaten').html('<option value="">-- Pilih Kabupaten/Kota --</option>');
        }
    });

    // Form Kelurahan: Load Kabupaten -> Load Kecamatan
    $('#kelurahan_provinsi').change(function() {
        let idProv = $(this).val();
        $('#kelurahan_kabupaten').html('<option value="">Loading...</option>');
        $('#kelurahan_kecamatan').html('<option value="">-- Pilih Kecamatan --</option>');
        if(idProv) {
            $.ajax({
                url: '<?= base_url('superadmin/wilayah/get-kabupaten/') ?>' + idProv,
                type: 'GET',
                success: function(res) {
                    let opts = '<option value="">-- Pilih Kabupaten/Kota --</option>';
                    if(res.status && res.data.length > 0) {
                        res.data.forEach(item => {
                            opts += `<option value="${item.id_kabupaten}">${item.nama_kabupaten}</option>`;
                        });
                    }
                    $('#kelurahan_kabupaten').html(opts);
                }
            });
        } else {
            $('#kelurahan_kabupaten').html('<option value="">-- Pilih Kabupaten/Kota --</option>');
        }
    });

    $('#kelurahan_kabupaten').change(function() {
        let idKab = $(this).val();
        $('#kelurahan_kecamatan').html('<option value="">Loading...</option>');
        if(idKab) {
            $.ajax({
                url: '<?= base_url('superadmin/wilayah/get-kecamatan/') ?>' + idKab,
                type: 'GET',
                success: function(res) {
                    let opts = '<option value="">-- Pilih Kecamatan --</option>';
                    if(res.status && res.data.length > 0) {
                        res.data.forEach(item => {
                            opts += `<option value="${item.id_kecamatan}">${item.nama_kecamatan}</option>`;
                        });
                    }
                    $('#kelurahan_kecamatan').html(opts);
                }
            });
        } else {
            $('#kelurahan_kecamatan').html('<option value="">-- Pilih Kecamatan --</option>');
        }
    });

});
</script>
<?= $this->endSection() ?>
