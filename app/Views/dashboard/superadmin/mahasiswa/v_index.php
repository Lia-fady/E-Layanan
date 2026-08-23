<?= $this->extend('layout/L_master_superadmin') ?>

<?= $this->section('title') ?><?= esc($title ?? 'mahasiswa index') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Master Data Mahasiswa</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('superadmin/dashboard') ?>">Master Data</a></li>
                    <li class="breadcrumb-item active">Mahasiswa</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        <!-- EDIT VIEW (Full Page) -->
        <div class="card shadow-sm d-none" id="editContainer">
            <div class="card-header bg-warning text-white">
                <h3 class="card-title mb-0"><i class="fas fa-edit me-2"></i> Edit Mahasiswa</h3>
            </div>
            <form id="formEditInline" class="form-confirm-update" action="" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="edit_nik" class="form-label fw-bold">NIK <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_nik" name="nik" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_nim" class="form-label fw-bold">NIM <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_nim" name="nim" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_nama_mahasiswa" class="form-label fw-bold">Nama Mahasiswa <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_nama_mahasiswa" name="nama_mahasiswa" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="edit_jenis_kelamin" class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select class="form-select" id="edit_jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="L">Laki-laki (L)</option>
                                        <option value="P">Perempuan (P)</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_tgl_lahir" class="form-label fw-bold">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="edit_tgl_lahir" name="tgl_lahir" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="edit_alamat" class="form-label fw-bold">Alamat <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="edit_alamat" name="alamat" rows="2" required></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="edit_rt" class="form-label fw-bold">RT</label>
                                    <input type="text" class="form-control" id="edit_rt" name="rt">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="edit_rw" class="form-label fw-bold">RW</label>
                                    <input type="text" class="form-control" id="edit_rw" name="rw">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_kelurahan" class="form-label fw-bold">Kelurahan</label>
                                    <input type="text" class="form-control" id="edit_kelurahan" name="kelurahan">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="edit_kecamatan" class="form-label fw-bold">Kecamatan</label>
                                    <input type="text" class="form-control" id="edit_kecamatan" name="kecamatan">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_provinsi" class="form-label fw-bold">Provinsi</label>
                                    <input type="text" class="form-control" id="edit_provinsi" name="provinsi">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="edit_no_telp" class="form-label fw-bold">No. Telp <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_no_telp" name="no_telp" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="edit_email" name="email" required>
                                </div>
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
                    <button type="button" class="btn btn-outline-secondary btn-cancel-edit">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </button>
                    <button type="submit" class="btn btn-warning text-white ms-auto">
                        <i class="fas fa-save me-1"></i> Update Data
                    </button>
                </div>
            </form>
        </div>

        <!-- LIST VIEW -->
        <div class="card shadow-sm" id="tableContainer">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0"><i class="fas fa-list me-2"></i> Daftar Mahasiswa</h3>
                <div class="card-tools ms-auto d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="location.reload();">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <a href="<?= base_url('superadmin/mahasiswa/create') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Mahasiswa
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>NIM/NIS</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Jurusan</th>
                                <th>Instansi</th>
                                <th>Email</th>
                                <th class="col-aksi">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($mahasiswaList)) : ?>
                                <?php foreach ($mahasiswaList as $row) : ?>
                                    <tr>
                                        <td><?= esc($row['nim']) ?></td>
                                        <td><?= esc($row['nik']) ?></td>
                                        <td><?= esc($row['nama_mahasiswa']) ?></td>
                                        <td><?= esc($row['nama_jurusan'] ?? $row['nama_prodi'] ?? '-') ?></td>
                                        <td><?= esc($row['instansi_pendidikan'] ?? '-') ?></td>
                                        <td><?= esc($row['email']) ?></td>
                                        <td class="col-aksi">
                                            <div class="d-flex gap-1 justify-content-center">
                                                <button type="button" class="btn btn-sm btn-warning text-white btn-edit" 
                                                    data-id="<?= $row['id_mahasiswa'] ?>"
                                                    data-nik="<?= esc($row['nik']) ?>"
                                                    data-nim="<?= esc($row['nim']) ?>"
                                                    data-nama="<?= esc($row['nama_mahasiswa']) ?>"
                                                    data-jk="<?= esc($row['jenis_kelamin'] ?? '') ?>"
                                                    data-tgl="<?= esc($row['tgl_lahir'] ?? '') ?>"
                                                    data-alamat="<?= esc($row['alamat'] ?? '') ?>"
                                                    data-rt="<?= esc($row['rt'] ?? '') ?>"
                                                    data-rw="<?= esc($row['rw'] ?? '') ?>"
                                                    data-kelurahan="<?= esc($row['kelurahan'] ?? '') ?>"
                                                    data-kecamatan="<?= esc($row['kecamatan'] ?? '') ?>"
                                                    data-provinsi="<?= esc($row['provinsi'] ?? '') ?>"
                                                    data-telp="<?= esc($row['no_telp'] ?? '') ?>"
                                                    data-email="<?= esc($row['email']) ?>"
                                                    title="Edit"><i class="fas fa-edit"></i></button>
                                                <button type="button" class="btn btn-sm btn-danger btn-hapus" 
                                                    data-url="<?= base_url('superadmin/mahasiswa/delete/' . $row['id_mahasiswa']) ?>" 
                                                    title="Hapus"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada data mahasiswa.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-edit').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var id = this.getAttribute('data-id');

            document.getElementById('formEditInline').action = '<?= base_url('superadmin/mahasiswa/update') ?>/' + id;
            document.getElementById('edit_nik').value = this.getAttribute('data-nik');
            document.getElementById('edit_nim').value = this.getAttribute('data-nim');
            document.getElementById('edit_nama_mahasiswa').value = this.getAttribute('data-nama');
            document.getElementById('edit_jenis_kelamin').value = this.getAttribute('data-jk');
            document.getElementById('edit_tgl_lahir').value = this.getAttribute('data-tgl');
            document.getElementById('edit_alamat').value = this.getAttribute('data-alamat');
            document.getElementById('edit_rt').value = this.getAttribute('data-rt');
            document.getElementById('edit_rw').value = this.getAttribute('data-rw');
            document.getElementById('edit_kelurahan').value = this.getAttribute('data-kelurahan');
            document.getElementById('edit_kecamatan').value = this.getAttribute('data-kecamatan');
            document.getElementById('edit_provinsi').value = this.getAttribute('data-provinsi');
            document.getElementById('edit_no_telp').value = this.getAttribute('data-telp');
            document.getElementById('edit_email').value = this.getAttribute('data-email');

            showEditState();
        });
    });
});
</script>
<?= $this->endSection() ?>
