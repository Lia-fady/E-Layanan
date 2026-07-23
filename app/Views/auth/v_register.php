<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun Mahasiswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        /* --- TEMA CORPORATE ENTERPRISE & CLEAN BACKGROUND --- */
        :root {
            --primary-navy: #0A1D37;       /* Midnight Navy Super Gelap & Solid */
            --primary-royal: #13325B;      /* Royal Navy Sekunder */
            --bg-auth: #F3F4F6;            /* Off-White Soft Premium */
            --accent-gold: #EAB308;        /* Kuning Emas Tua */
            --accent-blue-soft: #0EA5E9;   /* Biru Soft / Cyan Premium */
            --text-dark: #0A1D37;          /* Warna teks utama */
            --text-muted: #6B7280;         /* Warna teks sekunder */
            --card-white: #FFFFFF;         /* Putih bersih container */
        }

        body {
            background-color: var(--bg-auth) !important;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
        }

        .register-card {
            background: var(--card-white);
            border: 1px solid rgba(0, 0, 0, 0.04);
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(10, 29, 55, 0.04);
        }

        .logo-box {
            width: 65px;
            height: 65px;
            border-radius: 14px;
            background-color: var(--primary-navy);
            color: var(--accent-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 20px auto;
            box-shadow: 0 8px 16px rgba(10, 29, 55, 0.15);
        }

        .title {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--text-dark);
            letter-spacing: -0.3px;
        }

        .subtitle {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .section-title {
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--primary-royal);
            border-bottom: 1px solid #edf2f7;
            padding-bottom: 6px;
            margin-top: 25px;
            margin-bottom: 18px;
        }

        .form-label {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 6px;
        }

        .input-group-text {
            background-color: #fbfbfb;
            border: 1px solid #e2e8f0;
            color: var(--text-muted);
            border-radius: 8px 0 0 8px;
        }

        .form-control, .form-select {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.88rem;
            color: var(--text-dark);
            background-color: #fbfbfb;
            transition: all 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
            background-color: #ffffff;
            border-color: var(--accent-blue-soft);
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
        }

        textarea.form-control { resize: none; }

        .btn-outline-secondary {
            border: 1px solid #e2e8f0;
            background-color: #fbfbfb;
            color: var(--text-muted);
            border-radius: 0 8px 8px 0;
        }

        .btn-register {
            background-color: var(--primary-navy) !important;
            border-color: var(--primary-navy) !important;
            color: #ffffff !important;
            font-weight: 500;
            font-size: 0.9rem;
            border-radius: 8px;
            padding: 12px 24px;
            transition: all 0.2s ease;
        }

        .btn-register:hover {
            background-color: var(--primary-royal) !important;
            border-color: var(--primary-royal) !important;
            transform: translateY(-1px);
        }

        .login-link {
            color: var(--accent-blue-soft);
            text-decoration: none;
            font-weight: 500;
        }

        .alert-danger {
            font-size: 0.82rem;
            border-radius: 8px;
            border: none;
            background-color: #fef2f2;
            color: #dc2626;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-11 col-lg-9">
            
            <div class="card register-card">
                <div class="card-body p-0">
                    
                    <div class="text-center mb-4">
                        <div class="logo-box">
                            <i class="bi bi-person-plus-fill"></i>
                        </div>
                        <h2 class="title">Registrasi Akun Mahasiswa</h2>
                        <p class="subtitle m-0">Silakan lengkapi identitas akademik & personal Anda untuk membuat akun pendaftaran.</p>
                    </div>

                    <?php $validationErrors = session()->getFlashdata('errors') ?? []; ?>
                    <?php if(!empty($validationErrors)) : ?>
                        <div class="alert alert-danger p-3 mb-4" role="alert">
                            <div class="fw-bold"><i class="bi bi-exclamation-triangle-fill me-1"></i> Pendaftaran gagal, silakan periksa isian yang berwarna merah di bawah.</div>
                        </div>
                    <?php endif; ?>


                    <form action="<?= base_url('register/process') ?>" method="POST" id="registerForm" novalidate>
                        <?= csrf_field() ?>

                        <div class="section-title" style="margin-top: 0;"><i class="bi bi-shield-lock me-1"></i> Kredensial Akun (Data Login)</div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Username Akun <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control <?= isset($validationErrors['username']) ? 'is-invalid' : '' ?>" name="username" placeholder="Buat username" value="<?= old('username') ?>" required minlength="5" maxlength="30">
                                </div>
                                    <?php if(isset($validationErrors['username'])): ?>
                                        <div class="invalid-feedback d-block mt-1"><?= $validationErrors['username'] ?></div>
                                    <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kata Sandi <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" id="password" class="form-control <?= isset($validationErrors['password']) ? 'is-invalid' : '' ?>" name="password" placeholder="Buat kata sandi akun" required>
                                    <button class="btn btn-outline-secondary border-start-0" type="button" onclick="togglePassword()">
                                        <i class="bi bi-eye" id="eyeIcon"></i>
                                    </button>
                                </div>
                                    <?php if(isset($validationErrors['password'])): ?>
                                        <div class="invalid-feedback d-block mt-1"><?= $validationErrors['password'] ?></div>
                                    <?php endif; ?>
                                    <div class="form-text mt-1" style="font-size: 0.72rem; color: #8e9bb0;"><i class="bi bi-info-circle"></i> Min. 8 karakter, wajib mengandung huruf besar, kecil, angka & simbol (@$!%*?&).</div>
                            </div>
                        </div>

                        <div class="section-title"><i class="bi bi-mortarboard me-1"></i> Data Pendidikan </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Nama Instansi Pendidikan <span class="text-danger">*</span></label>
                                <select class="form-select <?= isset($validationErrors['id_instansi_pendidikan']) ? 'is-invalid' : '' ?>" name="id_instansi_pendidikan" id="kampus_select" required>
                                    <option value="">-- Pilih Instansi Pendidikan  --</option>
                                    <?php if(!empty($kampus)): ?>
                                        <?php foreach($kampus as $k): ?>
                                            <option value="<?= $k['id_instansi_pendidikan'] ?>" <?= old('id_instansi_pendidikan') == $k['id_instansi_pendidikan'] ? 'selected' : '' ?>>
                                                <?= esc($k['instansi_pendidikan']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                    <?php if(isset($validationErrors['id_instansi_pendidikan'])): ?>
                                        <div class="invalid-feedback d-block mt-1"><?= $validationErrors['id_instansi_pendidikan'] ?></div>
                                    <?php endif; ?>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Fakultas <span class="text-danger">*</span></label>
                                <select class="form-select <?= isset($validationErrors['id_fakultas']) ? 'is-invalid' : '' ?>" name="id_fakultas" id="fakultas_select" required disabled data-old="<?= old('id_fakultas') ?>">
                                    <option value="">-- Pilih Kampus Dulu --</option>
                                </select>
                                    <?php if(isset($validationErrors['id_fakultas'])): ?>
                                        <div class="invalid-feedback d-block mt-1"><?= $validationErrors['id_fakultas'] ?></div>
                                    <?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Program Studi <span class="text-danger">*</span></label>
                                <select class="form-select <?= isset($validationErrors['id_prodi']) ? 'is-invalid' : '' ?>" name="id_prodi" id="prodi_select" required disabled data-old="<?= old('id_prodi') ?>">
                                    <option value="">-- Pilih Fakultas Dulu --</option>
                                </select>
                                    <?php if(isset($validationErrors['id_prodi'])): ?>
                                        <div class="invalid-feedback d-block mt-1"><?= $validationErrors['id_prodi'] ?></div>
                                    <?php endif; ?>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Semester Saat Ini <span class="text-danger">*</span></label>
                                <input type="number" class="form-control <?= isset($validationErrors['semester']) ? 'is-invalid' : '' ?>" name="semester" placeholder="Contoh: 7" value="<?= old('semester') ?>" required min="1" max="14">
                                    <?php if(isset($validationErrors['semester'])): ?>
                                        <div class="invalid-feedback d-block mt-1"><?= $validationErrors['semester'] ?></div>
                                    <?php endif; ?>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Angkatan Tahun <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= isset($validationErrors['angkatan_tahun']) ? 'is-invalid' : '' ?>" name="angkatan_tahun" placeholder="Contoh: 2021" value="<?= old('angkatan_tahun') ?>" required minlength="4" maxlength="4">
                                    <?php if(isset($validationErrors['angkatan_tahun'])): ?>
                                        <div class="invalid-feedback d-block mt-1"><?= $validationErrors['angkatan_tahun'] ?></div>
                                    <?php endif; ?>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tahun Akademik berjalan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= isset($validationErrors['tahun_akademik']) ? 'is-invalid' : '' ?>" name="tahun_akademik" placeholder="Contoh: 2023/2024" value="<?= old('tahun_akademik') ?>" required>
                                    <?php if(isset($validationErrors['tahun_akademik'])): ?>
                                        <div class="invalid-feedback d-block mt-1"><?= $validationErrors['tahun_akademik'] ?></div>
                                    <?php endif; ?>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Jenjang Studi <span class="text-danger">*</span></label>
                                <select class="form-select <?= isset($validationErrors['jenjang_pendidikan']) ? 'is-invalid' : '' ?>" name="jenjang_pendidikan" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="D3" <?= old('jenjang_pendidikan') == 'D3' ? 'selected' : '' ?>>D3</option>
                                    <option value="D4" <?= old('jenjang_pendidikan') == 'D4' ? 'selected' : '' ?>>D4</option>
                                    <option value="S1" <?= old('jenjang_pendidikan') == 'S1' ? 'selected' : '' ?>>S1</option>
                                </select>
                                    <?php if(isset($validationErrors['jenjang_pendidikan'])): ?>
                                        <div class="invalid-feedback d-block mt-1"><?= $validationErrors['jenjang_pendidikan'] ?></div>
                                    <?php endif; ?>
                            </div>
                        </div>

                        <div class="section-title"><i class="bi bi-file-earmark-person me-1"></i> Profil Pribadi (Sesuai KTM/KTP)</div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Nomor Induk Kependudukan (NIK) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= isset($validationErrors['nik']) ? 'is-invalid' : '' ?>" name="nik" placeholder="Masukkan NIK 16 digit" value="<?= old('nik') ?>" required minlength="16" maxlength="16">
                                    <?php if(isset($validationErrors['nik'])): ?>
                                        <div class="invalid-feedback d-block mt-1"><?= $validationErrors['nik'] ?></div>
                                    <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nomor Induk Mahasiswa (NIM) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= isset($validationErrors['nim']) ? 'is-invalid' : '' ?>" name="nim" placeholder="Masukkan NIM Anda" value="<?= old('nim') ?>" required minlength="5" maxlength="25">
                                    <?php if(isset($validationErrors['nim'])): ?>
                                        <div class="invalid-feedback d-block mt-1"><?= $validationErrors['nim'] ?></div>
                                    <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap Mahasiswa <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= isset($validationErrors['nama_mahasiswa']) ? 'is-invalid' : '' ?>" name="nama_mahasiswa" placeholder="Masukkan nama lengkap" value="<?= old('nama_mahasiswa') ?>" required minlength="3" maxlength="100">
                                    <?php if(isset($validationErrors['nama_mahasiswa'])): ?>
                                        <div class="invalid-feedback d-block mt-1"><?= $validationErrors['nama_mahasiswa'] ?></div>
                                    <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Alamat Email Aktif <span class="text-danger">*</span></label>
                                <input type="email" class="form-control <?= isset($validationErrors['email']) ? 'is-invalid' : '' ?>" name="email" placeholder="contohnama@gmail.com" value="<?= old('email') ?>" required maxlength="100">
                                    <?php if(isset($validationErrors['email'])): ?>
                                        <div class="invalid-feedback d-block mt-1"><?= $validationErrors['email'] ?></div>
                                    <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nomor Telepon Aktif <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= isset($validationErrors['no_telp']) ? 'is-invalid' : '' ?>" name="no_telp" placeholder="Contoh: 0812..." value="<?= old('no_telp') ?>" required minlength="10" maxlength="15">
                                    <?php if(isset($validationErrors['no_telp'])): ?>
                                        <div class="invalid-feedback d-block mt-1"><?= $validationErrors['no_telp'] ?></div>
                                    <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-select <?= isset($validationErrors['jenis_kelamin']) ? 'is-invalid' : '' ?>" name="jenis_kelamin" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="L" <?= old('jenis_kelamin') == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="P" <?= old('jenis_kelamin') == 'P' ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                                    <?php if(isset($validationErrors['jenis_kelamin'])): ?>
                                        <div class="invalid-feedback d-block mt-1"><?= $validationErrors['jenis_kelamin'] ?></div>
                                    <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" class="form-control <?= isset($validationErrors['tgl_lahir']) ? 'is-invalid' : '' ?>" name="tgl_lahir" value="<?= old('tgl_lahir') ?>" required>
                                    <?php if(isset($validationErrors['tgl_lahir'])): ?>
                                        <div class="invalid-feedback d-block mt-1"><?= $validationErrors['tgl_lahir'] ?></div>
                                    <?php endif; ?>
                            </div>
                        </div>

                      <!-- SEKSI 4: ALAMAT -->
<div class="section-title"><i class="bi bi-geo-alt me-1"></i> Alamat Rumah / Domisili</div>
<div class="mb-3">
    <label class="form-label">Alamat Jalan & Nomor Rumah <span class="text-danger">*</span></label>
    <textarea class="form-control <?= isset($validationErrors['alamat']) ? 'is-invalid' : '' ?>" rows="2" name="alamat" placeholder="Nama jalan, nomor rumah, Dusun..." required maxlength="255"><?= old('alamat') ?></textarea>
                                    <?php if(isset($validationErrors['alamat'])): ?>
                                        <div class="invalid-feedback d-block mt-1"><?= $validationErrors['alamat'] ?></div>
                                    <?php endif; ?>
                                    <?php if(isset($validationErrors['alamat'])): ?>
                                        <div class="invalid-feedback d-block mt-1"><?= $validationErrors['alamat'] ?></div>
                                    <?php endif; ?>
</div>
<div class="row g-3">
    <!-- INPUT RT & RW YANG SEMPAT HILANG -->
    <div class="col-md-2">
        <label class="form-label">RT <span class="text-danger">*</span></label>
        <input type="text" class="form-control <?= isset($validationErrors['rt']) ? 'is-invalid' : '' ?>" name="rt" placeholder="001" value="<?= old('rt') ?>" required maxlength="3">
                                    <?php if(isset($validationErrors['rt'])): ?>
                                        <div class="invalid-feedback d-block mt-1"><?= $validationErrors['rt'] ?></div>
                                    <?php endif; ?>
    </div>
    <div class="col-md-2">
        <label class="form-label">RW <span class="text-danger">*</span></label>
        <input type="text" class="form-control <?= isset($validationErrors['rw']) ? 'is-invalid' : '' ?>" name="rw" placeholder="002" value="<?= old('rw') ?>" required maxlength="3">
                                    <?php if(isset($validationErrors['rw'])): ?>
                                        <div class="invalid-feedback d-block mt-1"><?= $validationErrors['rw'] ?></div>
                                    <?php endif; ?>
    </div>
    <div class="col-md-4">
        <label class="form-label">Kelurahan / Desa <span class="text-danger">*</span></label>
        <input type="text" class="form-control <?= isset($validationErrors['kelurahan']) ? 'is-invalid' : '' ?>" name="kelurahan" placeholder="Masukkan kelurahan" value="<?= old('kelurahan') ?>" required minlength="3" maxlength="100">
                                    <?php if(isset($validationErrors['kelurahan'])): ?>
                                        <div class="invalid-feedback d-block mt-1"><?= $validationErrors['kelurahan'] ?></div>
                                    <?php endif; ?>
    </div>
    <div class="col-md-4">
        <label class="form-label">Kecamatan <span class="text-danger">*</span></label>
        <input type="text" class="form-control <?= isset($validationErrors['kecamatan']) ? 'is-invalid' : '' ?>" name="kecamatan" placeholder="Masukkan kecamatan" value="<?= old('kecamatan') ?>" required minlength="3" maxlength="100">
                                    <?php if(isset($validationErrors['kecamatan'])): ?>
                                        <div class="invalid-feedback d-block mt-1"><?= $validationErrors['kecamatan'] ?></div>
                                    <?php endif; ?>
    </div>
    <div class="col-md-12 mb-4">
        <label class="form-label">Provinsi <span class="text-danger">*</span></label>
        <input type="text" class="form-control <?= isset($validationErrors['provinsi']) ? 'is-invalid' : '' ?>" name="provinsi" placeholder="Masukkan nama provinsi" value="<?= old('provinsi') ?>" required minlength="3" maxlength="100">
                                    <?php if(isset($validationErrors['provinsi'])): ?>
                                        <div class="invalid-feedback d-block mt-1"><?= $validationErrors['provinsi'] ?></div>
                                    <?php endif; ?>
    </div>
</div>

                        <div class="d-grid mt-4 mb-4">
                            <button type="submit" class="btn btn-register shadow-sm">
                                <i class="bi bi-person-check-fill me-2"></i>Daftarkan Akun Baru
                            </button>
                        </div>

                        <div class="text-center small text-muted" style="font-size: 0.85rem;">
                            Sudah melengkapi pendaftaran? <a href="<?= base_url('login') ?>" class="login-link">Login di sini</a>
                        </div>
                    </form>

                </div>
            </div>
            
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
$(document).ready(function() {
    // Membaca basis URL dari CodeIgniter
    var baseUrl = '<?= base_url() ?>';

    // 1. EVENT KAMPUS DIUBAH
    $('#kampus_select').on('change', function() {
        var idKampus = $(this).val(); // PERBAIKAN: Menggunakan .val() milik jQuery
        var fakultasSelect = $('#fakultas_select');
        var prodiSelect = $('#prodi_select');

        // Kembalikan ke posisi semula & kunci gemboknya
        fakultasSelect.html('<option value="">-- Pilih Fakultas --</option>').prop('disabled', true);
        prodiSelect.html('<option value="">-- Pilih Fakultas Dulu --</option>').prop('disabled', true);

        if (idKampus) {
            fakultasSelect.html('<option value="">Sedang memuat...</option>');
            
            // Tembak AJAX ke AuthController
            $.ajax({
                url: baseUrl + 'api/fakultas/' + idKampus,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    fakultasSelect.html('<option value="">-- Pilih Fakultas --</option>').prop('disabled', false); // Gembok dibuka
                    if (data.length > 0) {
                        $.each(data, function(key, value) {
                            var isSelected = (value.id_fakultas == fakultasSelect.data('old')) ? 'selected' : '';
                            fakultasSelect.append('<option value="' + value.id_fakultas + '" ' + isSelected + '>' + value.fakultas + '</option>');
                        });

                        // Jika ada old value, trigger change otomatis untuk muat Prodi
                        if (fakultasSelect.data('old')) {
                            fakultasSelect.trigger('change');
                        }
                    } else {
                        fakultasSelect.append('<option value="">Tidak ada fakultas aktif</option>');
                    }
                },
                error: function() {
                    fakultasSelect.html('<option value="">Gagal memuat data</option>');
                }
            });
        }
    });

    // 2. EVENT FAKULTAS DIUBAH
    $('#fakultas_select').on('change', function() {
        var idFakultas = $(this).val(); // PERBAIKAN: Menggunakan .val() milik jQuery
        var prodiSelect = $('#prodi_select');

        prodiSelect.html('<option value="">-- Pilih Program Studi --</option>').prop('disabled', true);

        if (idFakultas) {
            prodiSelect.html('<option value="">Sedang memuat...</option>');

            $.ajax({
                url: baseUrl + 'api/prodi/' + idFakultas,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    prodiSelect.html('<option value="">-- Pilih Program Studi --</option>').prop('disabled', false); // Gembok dibuka
                    if (data.length > 0) {
                        $.each(data, function(key, value) {
                            var isSelected = (value.id_prodi == prodiSelect.data('old')) ? 'selected' : '';
                            prodiSelect.append('<option value="' + value.id_prodi + '" ' + isSelected + '>' + value.prodi + '</option>');
                        });
                    } else {
                        prodiSelect.append('<option value="">Tidak ada prodi aktif</option>');
                    }
                },
                error: function() {
                    prodiSelect.html('<option value="">Gagal memuat data</option>');
                }
            });
        }
    });

    // 3. AUTO-TRIGGER JIKA KAMPUS SUDAH TERPILIH (Akibat kembali dari Validasi Error)
    if ($('#kampus_select').val()) {
        $('#kampus_select').trigger('change');
    }
});

function togglePassword() {
    const password = document.getElementById("password");
    const icon = document.getElementById("eyeIcon");

    if (password.type === "password") {
        password.type = "text";
        icon.classList.replace("bi-eye", "bi-eye-slash");
    } else {
        password.type = "password";
        icon.classList.replace("bi-eye-slash", "bi-eye");
    }
}

// === REAL-TIME FRONTEND VALIDATION (ON BLUR & INPUT) ===
$(document).ready(function() {
    var requiredFields = $('#registerForm input[required], #registerForm select[required], #registerForm textarea[required]');

    // Saat user mengetik atau mengubah pilihan, hilangkan error
    requiredFields.on('input change', function() {
        $(this).removeClass('is-invalid');
        var formGroup = $(this).closest('.col-md-12, .col-md-6, .col-md-4, .col-md-3, .col-md-2, .mb-3, .mb-4');
        formGroup.find('.invalid-feedback.frontend-error').remove();
    });

    // Saat user meninggalkan kolom (blur), lakukan validasi
    requiredFields.on('blur', function() {
        validateField($(this));
    });

    // Validasi massal sebelum submit form
    $('#registerForm').on('submit', function(e) {
        var isValid = true;
        requiredFields.each(function() {
            if (!validateField($(this))) {
                isValid = false;
            }
        });
        
        if (!isValid) {
            e.preventDefault(); // Cegah submit jika ada yang kosong/salah
            
            // Scroll otomatis ke kolom error pertama
            $('html, body').animate({
                scrollTop: $('.is-invalid:first').offset().top - 100
            }, 300);
        }
    });

    function validateField(element) {
        var val = element.val();
        if(val) val = val.trim();
        else val = '';
        
        // Ambil nama label dengan mencari ke parent teratas (grid column)
        var formGroup = element.closest('.col-md-12, .col-md-6, .col-md-4, .col-md-3, .col-md-2, .mb-3, .mb-4');
        var label = formGroup.find('.form-label').first();
        var fieldName = label.length ? label.text().replace('*', '').trim() : "Kolom ini";
        
        // Bersihkan error lama buatan JS
        element.removeClass('is-invalid');
        formGroup.find('.invalid-feedback.frontend-error').remove();

        // 1. Cek Kosong
        if (val === '') {
            showError(element, fieldName + ' wajib diisi.');
            return false;
        }

        // 2. Cek Minimal Karakter (jika ada minlength)
        var minlength = element.attr('minlength');
        if (minlength && val.length < parseInt(minlength)) {
            showError(element, fieldName + ' minimal ' + minlength + ' karakter.');
            return false;
        }
        
        // 3. Cek Tepat Karakter (jika maxlength sama dengan minlength, contoh NIK 16 digit)
        var maxlength = element.attr('maxlength');
        if (minlength && maxlength && minlength === maxlength && val.length !== parseInt(minlength)) {
            showError(element, fieldName + ' harus tepat ' + minlength + ' karakter.');
            return false;
        }

        // 4. Validasi Format Spesifik (Regex)
        var inputName = element.attr('name');
        if (val !== '') {
            if (inputName === 'nama_mahasiswa' && !/^[a-zA-Z\s]+$/.test(val)) {
                showError(element, fieldName + ' hanya boleh berisi huruf dan spasi.');
                return false;
            }
            if ((inputName === 'nik' || inputName === 'nim' || inputName === 'no_telp' || inputName === 'rt' || inputName === 'rw' || inputName === 'angkatan_tahun' || inputName === 'semester') && !/^[0-9]+$/.test(val)) {
                showError(element, fieldName + ' hanya boleh berisi angka.');
                return false;
            }
            if (inputName === 'semester') {
                var semVal = parseInt(val, 10);
                if (semVal < 1 || semVal > 14) {
                    showError(element, 'Semester maksimal adalah 14 (Batas DO).');
                    return false;
                }
            }
            if (inputName === 'username' && !/^[a-zA-Z0-9]+$/.test(val)) {
                showError(element, fieldName + ' hanya boleh berisi huruf dan angka tanpa spasi/simbol.');
                return false;
            }
            if ((inputName === 'kelurahan' || inputName === 'kecamatan' || inputName === 'provinsi') && !/^[a-zA-Z0-9\s]+$/.test(val)) {
                showError(element, fieldName + ' hanya boleh berisi huruf, angka, dan spasi.');
                return false;
            }
            if (inputName === 'email' && !/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(val)) {
                showError(element, 'Format ' + fieldName + ' tidak valid.');
                return false;
            }
            if (inputName === 'password' && !/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(val)) {
                showError(element, fieldName + ' tidak memenuhi syarat (Wajib ada huruf besar, kecil, angka, dan simbol).');
                return false;
            }
        }

        return true;
    }

    function showError(element, message) {
        element.addClass('is-invalid');
        // Jika form-group pakai input-group (seperti username/password dengan ikon), taruh error setelah input-group
        if (element.parent('.input-group').length || element.parent('.input-pw-wrap').length) {
            element.parent().after('<div class="invalid-feedback frontend-error d-block mt-1">' + message + '</div>');
        } else {
            element.after('<div class="invalid-feedback frontend-error d-block mt-1">' + message + '</div>');
        }
    }
});
</script>

</body>
</html>
