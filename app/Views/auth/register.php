<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Akun — E-Layanan Akademik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css">
    <style>
        body {
            background: #f7f8fa;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            padding: 40px 16px;
        }

        .form-wrap {
            max-width: 640px;
            margin: 0 auto;
            background: #fff;
            border-radius: 12px;
            padding: 36px 40px 32px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        }

        /* Header */
        .form-header { text-align: center; margin-bottom: 28px; }
        .form-header h1 { font-size: 1.3rem; font-weight: 700; color: #1a1a2e; margin: 0; }
        .form-header p { font-size: 0.84rem; color: #888; margin-top: 6px; }

        /* Stepper — minimal dots */
        .stepper-bar {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            margin-bottom: 32px;
        }
        .s-dot {
            width: 32px; height: 32px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.78rem; font-weight: 700;
            background: #eee; color: #aaa;
            transition: all 0.3s;
            flex-shrink: 0;
        }
        .s-dot.active { background: #1a1a2e; color: #fff; }
        .s-dot.done { background: #1a1a2e; color: #fff; }
        .s-line {
            flex: 1; height: 2px;
            background: #eee; max-width: 60px;
            transition: background 0.3s;
        }
        .s-line.done { background: #1a1a2e; }

        /* Section label */
        .sec-label {
            font-size: 0.82rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 4px;
        }
        .sec-desc {
            font-size: 0.78rem;
            color: #999;
            margin-bottom: 22px;
        }

        /* Form fields */
        .field { margin-bottom: 20px; }
        .field label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 6px;
        }
        .field label .req { color: #e53e3e; margin-left: 2px; }

        .field input[type="text"],
        .field input[type="email"],
        .field input[type="number"],
        .field input[type="password"],
        .field select,
        .field textarea {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 0.88rem;
            color: #222;
            background: #fff;
            transition: border-color 0.2s;
            outline: none;
        }
        .field input:focus, .field select:focus, .field textarea:focus {
            border-color: #1a1a2e;
        }
        .field input.err, .field select.err, .field textarea.err {
            border-color: #e53e3e;
        }
        .field .err-msg {
            font-size: 0.75rem;
            color: #e53e3e;
            margin-top: 4px;
        }
        .field .hint {
            font-size: 0.72rem;
            color: #aaa;
            margin-top: 4px;
        }
        .field textarea { resize: none; }

        /* Radio Buttons */
        .radio-group {
            display: flex; gap: 16px;
            padding: 11px 14px;
        }
        .radio-opt {
            display: flex; align-items: center; gap: 6px;
            font-size: 0.88rem; color: #333; cursor: pointer;
        }
        .radio-opt input {
            accent-color: #1a1a2e;
            width: 16px; height: 16px;
            cursor: pointer; margin: 0;
        }

        /* Password wrapper */
        .pw-wrap { position: relative; }
        .pw-wrap input { padding-right: 42px; }
        .pw-toggle {
            position: absolute;
            right: 12px; top: 50%; transform: translateY(-50%);
            background: none; border: none;
            color: #999; cursor: pointer; font-size: 1rem;
            padding: 0;
        }
        .pw-toggle:hover { color: #555; }

        /* Jenis selector */
        .jenis-row {
            display: flex; gap: 12px;
            margin-bottom: 24px;
        }
        .jenis-opt {
            flex: 1;
            border: 1.5px solid #ddd;
            border-radius: 8px;
            padding: 14px 16px;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
        }
        .jenis-opt:hover { border-color: #999; }
        .jenis-opt.sel {
            border-color: #1a1a2e;
            background: #f5f6fa;
        }
        .jenis-opt .jt { font-size: 0.88rem; font-weight: 600; color: #333; }
        .jenis-opt .jd { font-size: 0.72rem; color: #999; margin-top: 2px; }

        /* Buttons */
        .btn-row {
            display: flex;
            justify-content: space-between;
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid #f0f0f0;
        }
        .btn-back {
            background: none; border: 1px solid #ddd; color: #666;
            padding: 10px 22px; border-radius: 8px;
            font-size: 0.85rem; font-weight: 600; cursor: pointer;
            transition: all 0.2s;
        }
        .btn-back:hover { background: #f5f5f5; }
        .btn-next {
            background: #1a1a2e; color: #fff; border: none;
            padding: 10px 28px; border-radius: 8px;
            font-size: 0.85rem; font-weight: 600; cursor: pointer;
            transition: all 0.2s;
        }
        .btn-next:hover { background: #2d2d4e; }
        .btn-register {
            background: #1a1a2e; color: #fff; border: none;
            padding: 12px 32px; border-radius: 8px;
            font-size: 0.9rem; font-weight: 700; cursor: pointer;
            letter-spacing: 0.5px;
            transition: all 0.2s;
            width: 100%;
        }
        .btn-register:hover { background: #2d2d4e; }

        /* Review */
        .review-box {
            background: #fff;
            border: 1px solid #f0f0f0;
            border-radius: 12px;
            padding: 24px 28px;
            margin-bottom: 28px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        }
        .review-title {
            font-size: 0.8rem; font-weight: 700; color: #94a3b8;
            text-transform: uppercase; letter-spacing: 0.8px;
            margin-bottom: 20px;
        }
        .rv-row { display: flex; padding: 8px 0; font-size: 0.85rem; align-items: flex-start; }
        .rv-row .rv-l { width: 45%; color: #64748b; font-weight: 500; position: relative; padding-right: 15px; }
        .rv-row .rv-l::after { content: ':'; position: absolute; right: 8px; color: #94a3b8; }
        .rv-row .rv-v { flex: 1; color: #1e293b; font-weight: 600; }

        /* Step panels */
        .step-panel { display: none; }
        .step-panel.on { display: block; animation: fadeUp 0.25s ease; }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }

        .login-footer {
            text-align: center; margin-top: 20px;
            font-size: 0.84rem; color: #888;
        }
        .login-footer a { color: #1a1a2e; font-weight: 600; text-decoration: none; }
        .login-footer a:hover { text-decoration: underline; }

        /* Server errors */
        .server-err {
            background: #fef2f2; color: #c53030;
            padding: 12px 16px; border-radius: 8px;
            font-size: 0.82rem; font-weight: 600;
            margin-bottom: 20px;
        }

        @media (max-width: 576px) {
            .form-wrap { padding: 24px 20px 20px; }
            .jenis-row { flex-direction: column; }
        }
    </style>
</head>
<body>

<div class="form-wrap">
    <!-- Header -->
    <div class="form-header">
        <h1>Pendaftaran Akun</h1>
        <p>Lengkapi data berikut untuk mendaftar pada sistem E-Layanan.</p>
    </div>

    <!-- Stepper -->
    <div class="stepper-bar" id="stepperBar">
        <div class="s-dot active" data-s="1">1</div>
        <div class="s-line"></div>
        <div class="s-dot" data-s="2">2</div>
        <div class="s-line"></div>
        <div class="s-dot" data-s="3">3</div>
        <div class="s-line"></div>
        <div class="s-dot" data-s="4">4</div>
    </div>

    <!-- Server errors -->
    <?php $ve = session()->getFlashdata('errors') ?? []; ?>
    <?php if(!empty($ve)): ?>
        <div class="server-err">Pendaftaran gagal. Periksa kembali isian yang ditandai merah.</div>
    <?php endif; ?>

    <form action="<?= base_url('register/process') ?>" method="POST" id="regForm" novalidate>
        <?= csrf_field() ?>

        <!-- =============================== -->
        <!-- STEP 1: IDENTITAS DIRI          -->
        <!-- =============================== -->
        <div class="step-panel on" id="step1">
            <div class="sec-label">Informasi Pribadi / Data Diri</div>
            <div class="sec-desc">Lengkapi data diri Anda untuk membuat akun E-Layanan.</div>



            <div class="field">
                <label>Nomor Induk Kependudukan (NIK) <span class="req">*</span></label>
                <input type="text" name="nik" id="nik" placeholder="Masukkan Nomor Induk Kependudukan Anda" value="<?= old('nik') ?>" required minlength="16" maxlength="16" oninput="this.value=this.value.replace(/\D/g,'')" class="<?= isset($ve['nik']) ? 'err' : '' ?>">
                <?php if(isset($ve['nik'])): ?><div class="err-msg"><?= $ve['nik'] ?></div><?php endif; ?>
            </div>

            <div class="field">
                <label>Nama Lengkap <span class="req">*</span></label>
                <input type="text" name="nama_mahasiswa" id="nama_mahasiswa" placeholder="Masukkan nama lengkap Anda sesuai KTP" value="<?= old('nama_mahasiswa') ?>" required minlength="3" maxlength="100" class="<?= isset($ve['nama_mahasiswa']) ? 'err' : '' ?>">
                <?php if(isset($ve['nama_mahasiswa'])): ?><div class="err-msg"><?= $ve['nama_mahasiswa'] ?></div><?php endif; ?>
            </div>

            <div class="field">
                <label>Jenis Kelamin <span class="req">*</span></label>
                <div class="radio-group <?= isset($ve['jenis_kelamin']) ? 'err' : '' ?>">
                    <label class="radio-opt">
                        <input type="radio" name="jenis_kelamin" value="L" <?= old('jenis_kelamin')=='L'?'checked':'' ?> required> Laki-laki
                    </label>
                    <label class="radio-opt">
                        <input type="radio" name="jenis_kelamin" value="P" <?= old('jenis_kelamin')=='P'?'checked':'' ?> required> Perempuan
                    </label>
                </div>
                <?php if(isset($ve['jenis_kelamin'])): ?><div class="err-msg"><?= $ve['jenis_kelamin'] ?></div><?php endif; ?>
            </div>
            
            <div class="field">
                <label>Tanggal Lahir <span class="req">*</span></label>
                <input type="date" name="tgl_lahir" id="tgl_lahir" class="<?= isset($ve['tgl_lahir']) ? 'err' : '' ?>" value="<?= old('tgl_lahir') ?>" required max="<?= date('Y-m-d') ?>" onkeydown="return false" style="background-color: #fff; width: 100%; border: 1px solid #ddd; border-radius: 8px; padding: 11px 14px; font-family: inherit; color: #222;">
                <?php if(isset($ve['tgl_lahir'])): ?><div class="err-msg"><?= $ve['tgl_lahir'] ?></div><?php endif; ?>
            </div>

            <div class="field">
                <label>Email <span class="req">*</span></label>
                <input type="email" name="email" id="email" placeholder="Masukkan alamat email aktif" value="<?= old('email') ?>" required maxlength="100" class="<?= isset($ve['email']) ? 'err' : '' ?>">
                <?php if(isset($ve['email'])): ?><div class="err-msg"><?= $ve['email'] ?></div><?php endif; ?>
            </div>
            
            <div class="field">
                <label>Nomor WhatsApp <span class="req">*</span></label>
                <input type="text" name="no_telp" id="no_telp" placeholder="Masukkan nomor WhatsApp aktif" value="<?= old('no_telp') ?>" required minlength="10" maxlength="15" oninput="this.value=this.value.replace(/\D/g,'')" class="<?= isset($ve['no_telp']) ? 'err' : '' ?>">
                <?php if(isset($ve['no_telp'])): ?><div class="err-msg"><?= $ve['no_telp'] ?></div><?php endif; ?>
            </div>

            <div class="btn-row">
                <div></div>
                <button type="button" class="btn-next" onclick="go(2)">Selanjutnya</button>
            </div>
        </div>

        <!-- =============================== -->
        <!-- STEP 2: DATA PENDIDIKAN         -->
        <!-- =============================== -->
        <div class="step-panel" id="step2">
            <div class="sec-label">Data Pendidikan</div>
            <div class="sec-desc">Masukkan data pendidikan terakhir atau yang sedang Anda tempuh saat ini.</div>

            <!-- Jenis Pendaftar -->


            <!-- Panel Mahasiswa -->
                        <div id="panelPendidikan">
                <div class="field">
                    <label>Jenjang Pendidikan <span class="req">*</span></label>
                    <select name="id_jenjang_pendidikan" id="jenjang_pendidikan" required class="<?= isset($ve['id_jenjang_pendidikan']) ? 'err' : '' ?>">
                        <option value="">-- Pilih Jenjang --</option>
                        <?php if(!empty($jenjang)): foreach($jenjang as $j): ?>
                            <option value="<?= $j['id_jenjang_pendidikan'] ?>" data-nama="<?= strtolower($j['nama_jenjang']) ?>" <?= old('id_jenjang_pendidikan')==$j['id_jenjang_pendidikan']?'selected':'' ?>><?= esc($j['nama_jenjang']) ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                    <?php if(isset($ve['id_jenjang_pendidikan'])): ?><div class="err-msg"><?= $ve['id_jenjang_pendidikan'] ?></div><?php endif; ?>
                </div>

                <div class="field">
                    <label id="lbl_kampus">Instansi Pendidikan <span class="req">*</span></label>
                    <!-- Input untuk Instansi (Sekolah / Kampus) -->
                    <select name="nama_sekolah" id="nama_sekolah" style="display:none;" disabled class="<?= isset($ve['nama_sekolah']) ? 'err' : '' ?>">
                        <option value="" data-jenjang="">-- Pilih Instansi Pendidikan --</option>
                        <?php if(!empty($kampus)): foreach($kampus as $k): ?>
                            <option value="<?= $k['id_instansi_pendidikan'] ?>" data-jenjang="<?= $k['id_jenjang_pendidikan'] ?>" <?= old('nama_sekolah')==$k['id_instansi_pendidikan']?'selected':'' ?>><?= esc($k['instansi_pendidikan']) ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                    <select name="id_instansi_pendidikan" id="kampus_select" required class="<?= isset($ve['id_instansi_pendidikan']) ? 'err' : '' ?>">
                        <option value="" data-jenjang="">-- Pilih Instansi Pendidikan --</option>
                        <?php if(!empty($kampus)): foreach($kampus as $k): ?>
                            <option value="<?= $k['id_instansi_pendidikan'] ?>" data-jenjang="<?= $k['id_jenjang_pendidikan'] ?>" <?= old('id_instansi_pendidikan')==$k['id_instansi_pendidikan']?'selected':'' ?>><?= esc($k['instansi_pendidikan']) ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                    <?php if(isset($ve['id_instansi_pendidikan'])): ?><div class="err-msg"><?= $ve['id_instansi_pendidikan'] ?></div><?php endif; ?>
                </div>

                <div class="field" id="grp_fakultas">
                    <label>Fakultas <span class="req">*</span></label>
                    <select name="id_fakultas" id="fakultas_select" required disabled data-old="<?= old('id_fakultas') ?>" class="<?= isset($ve['id_fakultas']) ? 'err' : '' ?>">
                        <option value="">-- Pilih Fakultas --</option>
                    </select>
                    <?php if(isset($ve['id_fakultas'])): ?><div class="err-msg"><?= $ve['id_fakultas'] ?></div><?php endif; ?>
                </div>
                
                <div class="field">
                    <label id="lbl_jurusan">Jurusan <span class="req">*</span></label>
                    <select name="id_prodi" id="prodi_select" required disabled data-old="<?= old('id_prodi') ?>" class="<?= isset($ve['id_prodi']) ? 'err' : '' ?>">
                        <option value="">-- Pilih Jurusan --</option>
                    </select>
                    <select name="jurusan_smk" id="jurusan_smk" style="display:none;" disabled class="<?= isset($ve['jurusan_smk']) ? 'err' : '' ?>">
                        <option value="" data-jenjang="">-- Pilih Jurusan --</option>
                        <?php if(!empty($jurusan_smk)): foreach($jurusan_smk as $jsmk): ?>
                            <option value="<?= $jsmk['id_jurusan'] ?>" data-jenjang="<?= $jsmk['id_jenjang_pendidikan'] ?>" <?= old('jurusan_smk')==$jsmk['id_jurusan']?'selected':'' ?>><?= esc($jsmk['nama_jurusan']) ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                    <?php if(isset($ve['id_prodi'])): ?><div class="err-msg"><?= $ve['id_prodi'] ?></div><?php endif; ?>
                </div>

                <div class="field">
                    <label id="lbl_nim">Nomor Induk Mahasiswa (NIM) <span class="req">*</span></label>
                    <input type="text" name="nim" id="nim" required placeholder="Masukkan NIM atau NISN" value="<?= old('nim') ?>" class="<?= isset($ve['nim']) ? 'err' : '' ?>" maxlength="50" oninput="this.value=this.value.replace(/\D/g,'')">
                    <?php if(isset($ve['nim'])): ?><div class="err-msg"><?= $ve['nim'] ?></div><?php endif; ?>
                </div>

                <div class="field" id="grp_angkatan_tahun">
                    <label>Tahun Angkatan <span class="req">*</span></label>
                    <input type="number" name="angkatan_tahun" id="angkatan_tahun" required placeholder="Masukkan tahun angkatan" value="<?= old('angkatan_tahun') ?>" class="<?= isset($ve['angkatan_tahun']) ? 'err' : '' ?>" min="2000" max="2100">
                    <?php if(isset($ve['angkatan_tahun'])): ?><div class="err-msg"><?= $ve['angkatan_tahun'] ?></div><?php endif; ?>
                </div>

                <div class="field">
                    <label id="lbl_semester">Semester Saat Ini <span class="req">*</span></label>
                    <input type="number" name="semester" id="semester" required placeholder="Masukkan semester saat ini" value="<?= old('semester') ?>" class="<?= isset($ve['semester']) ? 'err' : '' ?>" min="1" max="14">
                    <select name="id_kelas" id="id_kelas" style="display:none;" required disabled class="<?= isset($ve['id_kelas']) ? 'err' : '' ?>">
                        <option value="">-- Pilih Kelas --</option>
                        <?php if(!empty($kelas)): foreach($kelas as $kls): ?>
                            <option value="<?= $kls['id_kelas'] ?>" <?= old('id_kelas')==$kls['id_kelas']?'selected':'' ?>><?= esc($kls['nama_kelas']) ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                    <?php if(isset($ve['semester'])): ?><div class="err-msg"><?= $ve['semester'] ?></div><?php endif; ?>
                    <?php if(isset($ve['id_kelas'])): ?><div class="err-msg"><?= $ve['id_kelas'] ?></div><?php endif; ?>
                </div>

                <div class="field" id="grp_tahun_akademik">
                    <label>Tahun Akademik <span class="req">*</span></label>
                    <input type="text" name="tahun_akademik" id="tahun_akademik" required placeholder="Masukkan tahun akademik" value="<?= old('tahun_akademik') ?>" class="<?= isset($ve['tahun_akademik']) ? 'err' : '' ?>" maxlength="20">
                    <?php if(isset($ve['tahun_akademik'])): ?><div class="err-msg"><?= $ve['tahun_akademik'] ?></div><?php endif; ?>
                </div>
            </div>
            
            <!-- Panel Siswa Dihapus karena digabung ke atas -->
            <div class="btn-row">
                <button type="button" class="btn-back" onclick="go(1)">Kembali</button>
                <button type="button" class="btn-next" onclick="go(3)">Selanjutnya</button>
            </div>
        </div>

        <!-- =============================== -->
        <!-- STEP 3: ALAMAT DOMISILI         -->
        <!-- =============================== -->
        <div class="step-panel" id="step3">
            <div class="sec-label">Alamat Domisili</div>
            <div class="sec-desc">Masukkan alamat tempat tinggal Anda saat ini.</div>

            <div class="field">
                <label>Provinsi <span class="req">*</span></label>
                <select name="provinsi" id="provinsi" required class="<?= isset($ve['provinsi']) ? 'err' : '' ?>" onchange="loadKabupaten(this.value)">
                    <option value="">— Pilih Provinsi —</option>
                    <?php if(!empty($provinsi)): foreach($provinsi as $pv): ?>
                        <option value="<?= $pv['id_provinsi'] ?>" <?= old('provinsi') == $pv['id_provinsi'] ? 'selected' : '' ?>><?= ucwords(strtolower(esc($pv['nama_provinsi']))) ?></option>
                    <?php endforeach; endif; ?>
                </select>
                <?php if(isset($ve['provinsi'])): ?><div class="err-msg"><?= $ve['provinsi'] ?></div><?php endif; ?>
            </div>
            
            <div class="field">
                <label>Kabupaten / Kota <span class="req">*</span></label>
                <select name="kab_kota" id="kab_kota" required disabled class="<?= isset($ve['kab_kota']) ? 'err' : '' ?>" data-old="<?= old('kab_kota') ?>" onchange="loadKecamatan(this.value)">
                    <option value="">— Pilih Kabupaten/Kota —</option>
                </select>
                <?php if(isset($ve['kab_kota'])): ?><div class="err-msg"><?= $ve['kab_kota'] ?></div><?php endif; ?>
            </div>

            <div class="field">
                <label>Kecamatan <span class="req">*</span></label>
                <select name="kecamatan" id="kecamatan" required disabled class="<?= isset($ve['kecamatan']) ? 'err' : '' ?>" data-old="<?= old('kecamatan') ?>" onchange="loadKelurahan(this.value)">
                    <option value="">— Pilih Kecamatan —</option>
                </select>
                <?php if(isset($ve['kecamatan'])): ?><div class="err-msg"><?= $ve['kecamatan'] ?></div><?php endif; ?>
            </div>
            
            <div class="field">
                <label>Kelurahan / Desa <span class="req">*</span></label>
                <select name="id_kelurahan" id="kelurahan" required disabled class="<?= isset($ve['id_kelurahan']) ? 'err' : '' ?>" data-old="<?= old('id_kelurahan') ?>">
                    <option value="">— Pilih Kelurahan —</option>
                </select>
                <?php if(isset($ve['id_kelurahan'])): ?><div class="err-msg"><?= $ve['id_kelurahan'] ?></div><?php endif; ?>
            </div>

            <div class="field-row">
                <div class="field" style="max-width:120px;">
                    <label>RT <span class="req">*</span></label>
                    <input type="text" name="rt" id="rt" placeholder="Contoh: 001" value="<?= old('rt') ?>" required maxlength="3" oninput="this.value=this.value.replace(/\D/g,'')" class="<?= isset($ve['rt']) ? 'err' : '' ?>">
                    <?php if(isset($ve['rt'])): ?><div class="err-msg"><?= $ve['rt'] ?></div><?php endif; ?>
                </div>
                <div class="field" style="max-width:120px;">
                    <label>RW <span class="req">*</span></label>
                    <input type="text" name="rw" id="rw" placeholder="Contoh: 002" value="<?= old('rw') ?>" required maxlength="3" oninput="this.value=this.value.replace(/\D/g,'')" class="<?= isset($ve['rw']) ? 'err' : '' ?>">
                    <?php if(isset($ve['rw'])): ?><div class="err-msg"><?= $ve['rw'] ?></div><?php endif; ?>
                </div>
                <div class="field" style="flex:3;">
                    <label>Detail Alamat <span class="req">*</span></label>
                    <input type="text" name="alamat" id="alamat" placeholder="Masukan Detail Alamat" value="<?= old('alamat') ?>" required maxlength="255" class="<?= isset($ve['alamat']) ? 'err' : '' ?>">
                    <?php if(isset($ve['alamat'])): ?><div class="err-msg"><?= $ve['alamat'] ?></div><?php endif; ?>
                </div>
            </div>

            <div class="btn-row">
                <button type="button" class="btn-back" onclick="go(2)">Kembali</button>
                <button type="button" class="btn-next" onclick="go(4)">Selanjutnya</button>
            </div>
        </div>

        <!-- =============================== -->
        <!-- STEP 4: RINGKASAN & AKUN        -->
        <!-- =============================== -->
        <div class="step-panel" id="step4">
            
            <!-- Review -->
            <div class="review-box mb-4">
                <div class="review-title">Ringkasan Data</div>
                <div id="reviewContent"></div>
            </div>

            <div class="sec-label">Informasi Akun</div>
            <div class="sec-desc">Buat username dan kata sandi untuk mengakses akun Anda.</div>

            <div class="field">
                <label>Username <span class="req">*</span></label>
                <input type="text" name="username" id="username" placeholder="Masukkan username" value="<?= old('username') ?>" required minlength="5" maxlength="30" class="<?= isset($ve['username']) ? 'err' : '' ?>">
                <div class="hint">Min. 5 karakter, hanya huruf dan angka tanpa spasi.</div>
                <?php if(isset($ve['username'])): ?><div class="err-msg"><?= $ve['username'] ?></div><?php endif; ?>
            </div>
            
            <div class="field">
                <label>Kata Sandi <span class="req">*</span></label>
                <div class="pw-wrap">
                    <input type="password" name="password" id="password" placeholder="Masukkan kata sandi" value="<?= old('password') ?>" required class="<?= isset($ve['password']) ? 'err' : '' ?>">
                    <button type="button" class="pw-toggle" onclick="togPw('password','eyeIc')"><i class="bi bi-eye" id="eyeIc"></i></button>
                </div>
                <div class="hint">Min. 8 karakter (huruf besar, kecil, angka, simbol).</div>
                <?php if(isset($ve['password'])): ?><div class="err-msg"><?= $ve['password'] ?></div><?php endif; ?>
            </div>
            
            <div class="field">
                <label>Konfirmasi Kata Sandi <span class="req">*</span></label>
                <div class="pw-wrap">
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Masukkan ulang kata sandi" required>
                    <button type="button" class="pw-toggle" onclick="togPw('confirm_password','eyeIcConfirm')"><i class="bi bi-eye" id="eyeIcConfirm"></i></button>
                </div>
            </div>


            <button type="button" class="btn-register" id="btnDaftar" onclick="submitReg()">Daftar Akun</button>

            <div class="btn-row" style="border:none; margin-top:12px; padding-top:0;">
                <button type="button" class="btn-back" onclick="go(3)">Kembali</button>
                <div></div>
            </div>
        </div>

    </form>

    <div class="login-footer">Sudah punya akun? <a href="<?= base_url('login') ?>">Masuk di sini</a></div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
var cur = 1;

document.addEventListener('DOMContentLoaded', function() {
    triggerJenjang();
});

$('#jenjang_pendidikan').on('change', function() {
    triggerJenjang();
});

function triggerJenjang() {
    var siswa = isSiswa();
    var jVal = $('#jenjang_pendidikan').val();
    
    // Filter dropdowns based on jenjang
    $('#kampus_select option, #nama_sekolah option, #jurusan_smk option').each(function() {
        var dj = $(this).attr('data-jenjang');
        if (!dj || dj === jVal) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
    
    if (!jVal) {
        $('#nama_sekolah option:first').text('-- Pilih jenjang pendidikan terlebih dahulu --');
        $('#jurusan_smk option:first').text('-- Pilih jenjang pendidikan terlebih dahulu --');
    } else {
        $('#nama_sekolah option:first').text('-- Pilih Instansi Pendidikan --');
        $('#jurusan_smk option:first').text('-- Pilih Jurusan --');
    }

    // Reset to default if currently selected option is now hidden
    if ($('#kampus_select option:selected').css('display') === 'none') {
        $('#kampus_select').val('');
        $('#fakultas_select').html('<option value="">-- Pilih Fakultas --</option>').val('');
        $('#prodi_select').html('<option value="">-- Pilih Prodi --</option>').val('');
    }
    if ($('#nama_sekolah option:selected').css('display') === 'none') {
        $('#nama_sekolah').val('');
    }
    if ($('#jurusan_smk option:selected').css('display') === 'none') {
        $('#jurusan_smk').val('');
    }
    
    if (siswa) {
        $('#lbl_kampus').html('Instansi Pendidikan <span class="req">*</span>');
        $('#kampus_select').hide().prop('disabled', true).prop('required', false);
        $('#nama_sekolah').show().prop('disabled', false).prop('required', true);
        
        $('#grp_fakultas').hide();
        $('#fakultas_select').prop('required', false);
        
        $('#lbl_jurusan').html('Jurusan <span class="req">*</span>');
        $('#prodi_select').hide().prop('disabled', true).prop('required', false);
        $('#jurusan_smk').show().prop('disabled', false).prop('required', true);
        
        $('#lbl_nim').html('NISN <span class="req">*</span>');
        $('#lbl_semester').html('Kelas <span class="req">*</span>');
        $('#semester').hide().prop('disabled', true).prop('required', false);
        $('#id_kelas').show().prop('disabled', false).prop('required', true);
        $('#nim').attr('maxlength', '8');
        
        $('#grp_tahun_akademik').hide();
        $('#tahun_akademik').prop('required', false);

        $('#grp_angkatan_tahun').hide();
        $('#angkatan_tahun').prop('required', false);
    } else {
        $('#lbl_kampus').html('Instansi Pendidikan <span class="req">*</span>');
        $('#nama_sekolah').hide().prop('disabled', true).prop('required', false);
        $('#kampus_select').show().prop('disabled', false).prop('required', true);
        
        $('#grp_fakultas').show();
        $('#fakultas_select').prop('required', true);
        
        $('#lbl_jurusan').html('Jurusan <span class="req">*</span>');
        $('#jurusan_smk').hide().prop('disabled', true).prop('required', false);
        $('#prodi_select').show().prop('disabled', false).prop('required', true);
        
        $('#lbl_nim').html('NIM <span class="req">*</span>');
        $('#lbl_semester').html('Semester <span class="req">*</span>');
        $('#id_kelas').hide().prop('disabled', true).prop('required', false);
        $('#semester').show().prop('disabled', false).prop('required', true);
        $('#nim').attr('maxlength', '50');
        
        $('#grp_tahun_akademik').show();
        $('#tahun_akademik').prop('required', true);

        $('#grp_angkatan_tahun').show();
        $('#angkatan_tahun').prop('required', true);
    }
}

// Stepper Flow
function go(t) {
    if (t > cur && !vStep(cur)) return;
    document.querySelectorAll('.step-panel').forEach(function(p){ p.classList.remove('on'); });
    document.getElementById('step'+t).classList.add('on');
    // Update dots
    document.querySelectorAll('.s-dot').forEach(function(d){
        var s = parseInt(d.dataset.s);
        d.classList.remove('active','done');
        if (s===t) d.classList.add('active');
        else if (s<t) d.classList.add('done');
    });
    document.querySelectorAll('.s-line').forEach(function(l,i){
        l.classList.toggle('done', (i+1)<t);
    });
    cur = t;
    if (t===4) review_data();
    window.scrollTo({top:0, behavior:'smooth'});
}

// Validation per Step
function vStep(s) {
    var panel = document.getElementById('step'+s);
    var ok = true;
    panel.querySelectorAll('.fe-err').forEach(function(e){ e.remove(); });

    var fields;
    if (s===2) {
        fields = document.getElementById('panelPendidikan').querySelectorAll('input:not([disabled]), select:not([disabled]), textarea:not([disabled])');
    } else if (s===1) {
        // Validate radios too
        var radios = panel.querySelectorAll('input[type="radio"][name="jenis_kelamin"]');
        var rChecked = Array.from(radios).some(r => r.checked);
        if(!rChecked && radios.length > 0) {
            var rWrap = panel.querySelector('.radio-group');
            mErr(rWrap, 'Jenis Kelamin wajib dipilih.');
            ok = false;
        }
        fields = panel.querySelectorAll('input:not([type="radio"])[required], select[required], textarea[required]');
    } else {
        fields = panel.querySelectorAll('input[required], select[required], textarea[required]');
    }

    fields.forEach(function(f){
        f.classList.remove('err');
        if (f.offsetParent===null && f.type!=='hidden') return;
        if (f.disabled) return;
        var v = (f.value||'').trim();
        var lb = getLbl(f);
        if (!v) { mErr(f, lb+' wajib diisi.'); ok=false; return; }
        var n = f.name;
        if (n==='nama_mahasiswa' && !/^[a-zA-Z\s'.]+$/.test(v)) { mErr(f,'Nama hanya boleh huruf dan spasi.'); ok=false; }
        if (n==='nik' && v.length!==16) { mErr(f,'NIK harus tepat 16 digit.'); ok=false; }
        if (n==='nim' && isSiswa() && v.length !== 8) { mErr(f, 'NISN harus persis 8 digit angka.'); ok=false; }
        if (['nik','nim_mhs','nim_siswa','no_telp','rt','rw','angkatan_tahun','angkatan_tahun_smk'].includes(n) && !/^\d+$/.test(v)) { mErr(f,lb+' hanya boleh angka.'); ok=false; }
        if (n==='email' && !/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(v)) { mErr(f,'Format email tidak valid.'); ok=false; }
        if (n==='semester') { var sv=parseInt(v); if(sv<1||sv>14){ mErr(f,'Semester 1-14.'); ok=false; } }
    });
    if (!ok) { var fe=panel.querySelector('.err, .radio-group.err'); if(fe) fe.scrollIntoView({behavior:'smooth',block:'center'}); }
    return ok;
}
function getLbl(f){ var c=f.closest('.field'); if(c){var l=c.querySelector('label'); if(l) return l.textContent.split('<')[0].trim();} return 'Kolom ini'; }
function mErr(f,m){ 
    f.classList.add('err'); 
    var d=document.createElement('div'); d.className='err-msg fe-err'; d.textContent=m; 
    if(f.parentElement.classList.contains('pw-wrap')){ f.parentElement.after(d); }
    else if(f.classList.contains('radio-group')){ f.after(d); }
    else { f.after(d); } 
}

// Clear errors on input
document.addEventListener('input', function(e){ if(e.target.matches('input,select,textarea')){ e.target.classList.remove('err'); var c=e.target.closest('.field'); if(c) c.querySelectorAll('.fe-err').forEach(function(x){x.remove();}); }});
document.addEventListener('change', function(e){ 
    if(e.target.matches('select, input[type="radio"]')){ 
        e.target.classList.remove('err'); 
        if(e.target.type === 'radio') e.target.closest('.radio-group').classList.remove('err');
        var c=e.target.closest('.field'); if(c) c.querySelectorAll('.fe-err').forEach(function(x){x.remove();}); 
    }
});

// Provinsi manual
document.getElementById('provinsi').addEventListener('change', function(){ document.getElementById('wrapProvManual').style.display = this.value==='Lainnya'?'block':'none'; });

// Build Review
function isSiswa() {
    var j = document.getElementById('jenjang_pendidikan');
    if(!j || !j.options || !j.options[j.selectedIndex]) return false;
    var n = j.options[j.selectedIndex].dataset.nama || '';
    return n.indexOf('sma') !== -1 || n.indexOf('smk') !== -1;
}
function review_data() {
    var g=function(id){var e=document.getElementById(id); return e?(e.value||'-'):'-';};
    var gt=function(id){var e=document.getElementById(id); if(!e)return'-'; if(e.tagName==='SELECT'){return e.options[e.selectedIndex]?e.options[e.selectedIndex].text:'-';} return e.value||'-';};
    
    var nimV = g('nim');
    var h = '';
    
    // Helper for table rows
    var tr = function(label, value) {
        return '<tr><td style="width:35%; padding:10px 0; color:#64748b; border-bottom:1px solid #f1f5f9;">'+label+'</td><td style="width:5%; border-bottom:1px solid #f1f5f9;">:</td><td style="padding:10px 0; color:#1e293b; border-bottom:1px solid #f1f5f9;">'+value+'</td></tr>';
    };

    // Title 1
    h += '<div style="font-weight:700; font-size:1.05rem; margin-bottom:12px; color:#1e293b;">Data Diri</div>';
    h += '<table style="width:100%; font-size:0.9rem; margin-bottom:28px; border-collapse:collapse;">';
    h += tr('NIK', g('nik'));
    h += tr('Nama Lengkap', g('nama_mahasiswa'));
    
    var jkr = document.querySelector('input[name="jenis_kelamin"]:checked');
    var jkv = jkr ? (jkr.value==='L'?'Laki-laki':'Perempuan') : '-';
    h += tr('Jenis Kelamin', jkv);
    var rawDate = g('tgl_lahir');
    var formattedDate = rawDate;
    if (rawDate !== '-' && rawDate.indexOf('-') !== -1) {
        var parts = rawDate.split('-');
        if (parts.length === 3) {
            var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            var mIdx = parseInt(parts[1], 10) - 1;
            var mName = (mIdx >= 0 && mIdx < 12) ? months[mIdx] : parts[1];
            formattedDate = parts[2] + ' ' + mName + ' ' + parts[0];
        }
    }
    h += tr('Tanggal Lahir', formattedDate);
    
    var p = gt('provinsi'), kb = gt('kab_kota'), kc = gt('kecamatan'), kl = gt('kelurahan');
    var al = g('alamat') + ' RT '+g('rt')+'/RW '+g('rw')+', Kel. '+kl+', Kec. '+kc+', '+kb+', '+p;
    h += tr('Alamat Lengkap', al);
    h += '</table>';

    // Title 2
    h += '<div style="font-weight:700; font-size:1.05rem; margin-bottom:12px; color:#1e293b;">Data Pendidikan</div>';
    h += '<table style="width:100%; font-size:0.9rem; margin-bottom:20px; border-collapse:collapse;">';
    
    var siswa = isSiswa();
    if (!siswa) {
        h += tr('Jenjang Pendidikan', gt('jenjang_pendidikan'));
        h += tr('Instansi Pendidikan', gt('kampus_select'));
        h += tr('Fakultas', gt('fakultas_select'));
        h += tr('Jurusan', gt('prodi_select'));
        h += tr('NIM', nimV);
        h += tr('Tahun Angkatan', g('angkatan_tahun'));
        h += tr('Semester', g('semester'));
        h += tr('Tahun Akademik', g('tahun_akademik'));
    } else {
        h += tr('Jenjang Pendidikan', gt('jenjang_pendidikan'));
        h += tr('Instansi Pendidikan', gt('nama_sekolah'));
        h += tr('Jurusan', gt('jurusan_smk'));
        h += tr('Kelas', gt('id_kelas'));
        h += tr('NISN', nimV);
    }
    h += '</table>';
    
    document.getElementById('reviewContent').innerHTML = h;
}
// Final Submit
function submitReg() {
    var panel=document.getElementById('step4'); var ok=true;
    panel.querySelectorAll('.fe-err').forEach(function(e){e.remove();});
    
    var pw = document.getElementById('password');
    var cpw = document.getElementById('confirm_password');
    var user = document.getElementById('username');

    // Basic required check
    [user, pw, cpw].forEach(function(f){
        f.classList.remove('err'); var v=(f.value||'').trim(); var lb=getLbl(f);
        if(!v){mErr(f,lb+' wajib diisi.');ok=false;return;}
    });

    if(ok) {
        var v = user.value.trim();
        if(!/^[a-zA-Z0-9]+$/.test(v)){mErr(user,'Hanya huruf dan angka tanpa spasi.');ok=false;}
        if(v.length<5){mErr(user,'Minimal 5 karakter.');ok=false;}
        
        var pv = pw.value.trim();
        if(!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(pv)){mErr(pw,'Min. 8 karakter, huruf besar, kecil, angka & simbol.');ok=false;}
        
        if(pv !== cpw.value.trim()){ mErr(cpw, 'Konfirmasi kata sandi tidak cocok.'); ok = false; }
    }

    if(!ok){var fe=panel.querySelector('.err');if(fe)fe.scrollIntoView({behavior:'smooth',block:'center'});return;}

    Swal.fire({
        title:'Konfirmasi Pendaftaran',
        text:'Apakah data yang Anda masukkan sudah benar?',
        icon:'question',
        showCancelButton:true,
        confirmButtonColor:'#1a1a2e',
        cancelButtonColor:'#999',
        confirmButtonText:'Ya, Daftarkan',
        cancelButtonText:'Cek Kembali',
        reverseButtons:true
    }).then(function(r){
        if(r.isConfirmed){
            var b=document.getElementById('btnDaftar');
            b.textContent='Mendaftarkan...'; b.disabled=true;
            document.getElementById('regForm').submit();
        }
    });
}

// Title case helper
function tc(str) {
    if(!str) return '';
    return str.toLowerCase().replace(/\b\w/g, function(l) { return l.toUpperCase(); });
}

function loadKabupaten(id_prov) {
    let kab = document.getElementById('kab_kota');
    let kec = document.getElementById('kecamatan');
    let kel = document.getElementById('kelurahan');
    kab.innerHTML = '<option value="">— Pilih Kabupaten/Kota —</option>';
    kec.innerHTML = '<option value="">— Pilih Kecamatan —</option>';
    kel.innerHTML = '<option value="">— Pilih Kelurahan —</option>';
    kab.disabled = true; kec.disabled = true; kel.disabled = true;
    if(!id_prov) return;
    
    let old_kab = kab.getAttribute('data-old');
    fetch('<?= base_url("api/kabupaten") ?>/'+id_prov)
    .then(r=>r.json()).then(d=>{
        d.forEach(k => {
            let sel = (k.id_kabupaten == old_kab) ? 'selected' : '';
            kab.innerHTML += `<option value="${k.id_kabupaten}" ${sel}>${tc(k.nama_kabupaten)}</option>`;
        });
        kab.disabled = false;
        if (old_kab) { $(kab).trigger('change'); }
    });
}

function loadKecamatan(id_kab) {
    let kec = document.getElementById('kecamatan');
    let kel = document.getElementById('kelurahan');
    kec.innerHTML = '<option value="">— Pilih Kecamatan —</option>';
    kel.innerHTML = '<option value="">— Pilih Kelurahan —</option>';
    kec.disabled = true; kel.disabled = true;
    if(!id_kab) return;
    
    let old_kec = kec.getAttribute('data-old');
    fetch('<?= base_url("api/kecamatan") ?>/'+id_kab)
    .then(r=>r.json()).then(d=>{
        d.forEach(k => {
            let sel = (k.id_kecamatan == old_kec) ? 'selected' : '';
            kec.innerHTML += `<option value="${k.id_kecamatan}" ${sel}>${tc(k.nama_kecamatan)}</option>`;
        });
        kec.disabled = false;
        if (old_kec) { $(kec).trigger('change'); }
    });
}

function loadKelurahan(id_kec) {
    let kel = document.getElementById('kelurahan');
    kel.innerHTML = '<option value="">— Pilih Kelurahan —</option>';
    kel.disabled = true;
    if(!id_kec) return;
    
    let old_kel = kel.getAttribute('data-old');
    fetch('<?= base_url("api/kelurahan") ?>/'+id_kec)
    .then(r=>r.json()).then(d=>{
        d.forEach(k => {
            let sel = (k.id_kelurahan == old_kel) ? 'selected' : '';
            kel.innerHTML += `<option value="${k.id_kelurahan}" ${sel}>${tc(k.nama_kelurahan)}</option>`;
        });
        kel.disabled = false;
    });
}

// Password toggle
function togPw(inputId, iconId) { 
    var p = document.getElementById(inputId), i = document.getElementById(iconId); 
    if(p.type==='password'){ p.type='text'; i.classList.replace('bi-eye','bi-eye-slash'); }
    else { p.type='password'; i.classList.replace('bi-eye-slash','bi-eye'); } 
}

// AJAX cascading Kampus -> Fakultas -> Prodi
$(document).ready(function(){
    var bu='<?= base_url() ?>';
    $('#kampus_select').on('change',function(){
        var id=$(this).val(), f=$('#fakultas_select'), p=$('#prodi_select');
        f.html('<option value="">— Pilih Fakultas —</option>').prop('disabled',true);
        p.html('<option value="">— Pilih Jurusan —</option>').prop('disabled',true);
        if(id){
            f.html('<option value="">Memuat...</option>');
            $.getJSON(bu+'api/fakultas/'+id,function(d){
                f.html('<option value="">— Pilih Fakultas —</option>').prop('disabled',false);
                $.each(d,function(k,v){var s=v.id_fakultas==f.data('old')?'selected':'';f.append('<option value="'+v.id_fakultas+'" '+s+'>'+v.fakultas+'</option>');});
                if(f.data('old'))f.trigger('change');
            });
        }
    });
    $('#fakultas_select').on('change',function(){
        var id=$(this).val(), p=$('#prodi_select');
        p.html('<option value="">— Pilih Jurusan —</option>').prop('disabled',true);
        if(id){
            p.html('<option value="">Memuat...</option>');
            $.getJSON(bu+'api/prodi/'+id,function(d){
                p.html('<option value="">— Pilih Jurusan —</option>').prop('disabled',false);
                $.each(d,function(k,v){var s=v.id_prodi==p.data('old')?'selected':'';p.append('<option value="'+v.id_prodi+'" '+s+'>'+v.nama_prodi+'</option>');});
            });
        }
    });
    if($('#kampus_select').val())$('#kampus_select').trigger('change');
    if($('#provinsi').val()) $('#provinsi').trigger('change');
});
</script>
</body>
</html>
