<?= $this->extend('layouts/superadmin/L_main_superadmin') ?>

<?= $this->section('title') ?><?= esc($title ?? 'Edit Mahasiswa') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Mahasiswa</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('superadmin/dashboard') ?>">Master Data</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('superadmin/mahasiswa') ?>">Mahasiswa</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-white">
                <h3 class="card-title">Form Edit Mahasiswa</h3>
            </div>
            <form id="formEdit" action="<?= base_url('superadmin/mahasiswa/update/' . $mahasiswa['id_mahasiswa']) ?>" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nik" class="form-label fw-bold">NIK <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nik" name="nik" value="<?= esc($mahasiswa['nik']) ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="nim" class="form-label fw-bold">NIM <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nim" name="nim" value="<?= esc($mahasiswa['nim']) ?>" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="nama_mahasiswa" class="form-label fw-bold">Nama Mahasiswa <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_mahasiswa" name="nama_mahasiswa" value="<?= esc($mahasiswa['nama_mahasiswa']) ?>" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="jenis_kelamin" class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="L" <?= ($mahasiswa['jenis_kelamin'] == 'L') ? 'selected' : '' ?>>Laki-laki (L)</option>
                                        <option value="P" <?= ($mahasiswa['jenis_kelamin'] == 'P') ? 'selected' : '' ?>>Perempuan (P)</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tgl_lahir" class="form-label fw-bold">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="<?= esc($mahasiswa['tgl_lahir']) ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label fw-bold">Alamat <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="2" required><?= esc($mahasiswa['alamat']) ?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="rt" class="form-label fw-bold">RT</label>
                                    <input type="text" class="form-control" id="rt" name="rt" value="<?= esc($mahasiswa['rt']) ?>">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="rw" class="form-label fw-bold">RW</label>
                                    <input type="text" class="form-control" id="rw" name="rw" value="<?= esc($mahasiswa['rw']) ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kelurahan" class="form-label fw-bold">Kelurahan</label>
                                    <input type="text" class="form-control" id="kelurahan" name="kelurahan" value="<?= esc($mahasiswa['kelurahan']) ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kecamatan" class="form-label fw-bold">Kecamatan</label>
                                    <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="<?= esc($mahasiswa['kecamatan']) ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="provinsi" class="form-label fw-bold">Provinsi</label>
                                    <input type="text" class="form-control" id="provinsi" name="provinsi" value="<?= esc($mahasiswa['provinsi']) ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="no_telp" class="form-label fw-bold">No. Telp <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?= esc($mahasiswa['no_telp']) ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= esc($mahasiswa['email']) ?>" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="id_instansi_mahasiswa" class="form-label fw-bold">ID Instansi Mahasiswa <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="id_instansi_mahasiswa" name="id_instansi_mahasiswa" value="<?= esc($mahasiswa['id_instansi_mahasiswa']) ?>" required>
                            </div>

                        </div>
                        <div class="col-lg-4">
                            <div class="alert alert-info">
                                <h5><i class="icon fas fa-info"></i> Informasi</h5>
                                Pastikan Anda mengisi semua field yang bertanda bintang merah (*). Periksa kembali data sebelum menyimpan.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex gap-2">
                    <a href="<?= base_url('superadmin/mahasiswa') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-warning text-white ms-auto">
                        <i class="fas fa-save"></i> Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
