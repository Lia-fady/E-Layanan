<?= $this->extend('layout/mahasiswa') ?>

<?= $this->section('breadcrumb') ?>
<a href="<?= base_url('mahasiswa/dashboard') ?>" class="text-decoration-none text-primary">Dashboard</a> <span class="mx-2 text-muted">/</span> <span class="text-dark fw-medium">Profil Saya</span>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
    // Fallback data jika kosong
    $nama = !empty($m['nama_mahasiswa']) ? esc($m['nama_mahasiswa']) : session()->get('nama');
    $nim = !empty($m['nim']) ? esc($m['nim']) : (session()->get('nim') ?? '-');
    $kampus = !empty($i['nama_instansi']) ? esc($i['nama_instansi']) : (session()->get('kampus') ?? '-');
    
    // Inisial untuk avatar besar
    $words = explode(" ", $nama);
    $inisial = "";
    foreach ($words as $w) {
        if(!empty($w)) $inisial .= mb_substr($w, 0, 1);
    }
    $inisial = strtoupper(mb_substr($inisial, 0, 2));
    
    // Deteksi apakah siswa SMA/SMK
    $isSiswa = false;
    if (!empty($i['nama_jenjang'])) {
        $jenjangStr = strtoupper($i['nama_jenjang']);
        if (strpos($jenjangStr, 'SMA') !== false || strpos($jenjangStr, 'SMK') !== false || strpos($jenjangStr, 'SLTA') !== false) {
            $isSiswa = true;
        }
    }
    // Foto Profil
    $foto_profil = !empty($m['foto_profil']) ? base_url('uploads/profil/' . $m['foto_profil']) : '';
?>

<div class="profile-hero">
    <?php if ($foto_profil): ?>
        <img src="<?= $foto_profil ?>" alt="Foto Profil" class="profile-hero-avatar" style="object-fit: cover; border: 2px solid #fff;">
    <?php else: ?>
        <div class="profile-hero-avatar" style="border: 2px solid #fff;"><?= $inisial ?></div>
    <?php endif; ?>
    <div class="profile-hero-copy">
        <span class="profile-eyebrow"><i class="bi bi-shield-check me-1"></i> Identitas Peserta</span>
        <h4><?= $nama ?></h4>
        <p><?= $nim ?> - <?= $kampus ?></p>
    </div>
    <button class="btn btn-light btn-sm profile-hero-action" data-bs-toggle="modal" data-bs-target="#modalEditProfil"><i class="bi bi-pencil-square me-1"></i> Edit Profil</button>
</div>

<div class="container-fluid p-0">
    <div class="row g-4">
    <!-- KOLOM KIRI: KARTU IDENTITAS -->
    <div class="col-md-4 col-lg-3">
        <div class="card-flat text-center shadow-sm">
            <div style="position: relative; display: inline-block;" class="mt-3 mb-3">
                <?php if ($foto_profil): ?>
                    <img src="<?= $foto_profil ?>" alt="Foto Profil" class="mx-auto d-flex align-items-center justify-content-center shadow-sm" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 4px solid #eff6ff; cursor: pointer;" onclick="document.getElementById('uploadFotoAjax').click();" id="cardAvatarImg">
                <?php else: ?>
                    <div class="mx-auto d-flex align-items-center justify-content-center fw-bold text-white shadow-sm" 
                         style="width: 100px; height: 100px; border-radius: 50%; background: linear-gradient(135deg, #0ea5e9, #3b82f6); font-size: 2.5rem; border: 4px solid #eff6ff; cursor: pointer;" onclick="document.getElementById('uploadFotoAjax').click();" id="cardAvatarDiv">
                        <?= $inisial ?>
                    </div>
                <?php endif; ?>
                <div class="position-absolute bottom-0 end-0 bg-white rounded-circle shadow d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; cursor: pointer; transform: translate(-10%, -10%);" onclick="document.getElementById('uploadFotoAjax').click();">
                    <i class="bi bi-camera-fill text-primary" style="font-size: 1rem;"></i>
                </div>
            </div>
            
            <input type="file" id="uploadFotoAjax" accept="image/png, image/jpeg, image/jpg" style="display: none;" onchange="handleFotoAjaxUpload(this)">
            <h5 class="fw-bold text-dark mb-1"><?= $nama ?></h5>
            <p class="text-secondary small fw-semibold mb-3"><?= $isSiswa ? 'NISN' : 'NIM' ?>: <?= $nim ?></p>
            
            <span class="badge bg-success-subtle text-success px-3 py-1.5 rounded-pill fw-semibold mb-2 border border-success-subtle d-block mx-auto" style="width: fit-content;">
                <i class="bi bi-person-check-fill me-1"></i> Akun Aktif
            </span>
            
        </div>
    </div>

    <!-- KOLOM KANAN: DATA DETAIL -->
    <div class="col-md-8 col-lg-9">
        
        <!-- CARD: DATA PRIBADI & KONTAK -->
        <div class="card-flat shadow-sm mb-4">
            <h6 class="fw-bold text-dark mb-4 border-bottom pb-3"><i class="bi bi-person-lines-fill me-2 text-primary"></i> Data Pribadi & Kontak</h6>
            <div class="row g-0">
                <div class="col-12 border-bottom py-3 d-flex flex-column flex-sm-row align-items-sm-center">
                    <div class="text-muted fw-bold mb-1 mb-sm-0 col-sm-4" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Nama Lengkap</div>
                    <div class="fw-semibold text-dark col-sm-8" style="font-size: 0.95rem;">
                        <?= !empty($m['nama_mahasiswa']) ? esc($m['nama_mahasiswa']) : '<span class="text-muted fst-italic">Belum diatur</span>' ?>
                    </div>
                </div>
                <div class="col-12 border-bottom py-3 d-flex flex-column flex-sm-row align-items-sm-center">
                    <div class="text-muted fw-bold mb-1 mb-sm-0 col-sm-4" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;"><?= $isSiswa ? 'NISN' : 'NIM' ?></div>
                    <div class="fw-semibold text-dark col-sm-8" style="font-size: 0.95rem;">
                        <?= !empty($m['nim']) ? esc($m['nim']) : '<span class="text-muted fst-italic">Belum diatur</span>' ?>
                    </div>
                </div>
                <div class="col-12 border-bottom py-3 d-flex flex-column flex-sm-row align-items-sm-center">
                    <div class="text-muted fw-bold mb-1 mb-sm-0 col-sm-4" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">NIK (Nomor Induk Kependudukan)</div>
                    <div class="fw-semibold text-dark col-sm-8" style="font-size: 0.95rem;">
                        <?= !empty($m['nik']) ? esc($m['nik']) : '<span class="text-muted fst-italic">Belum diatur</span>' ?>
                    </div>
                </div>
                <div class="col-12 border-bottom py-3 d-flex flex-column flex-sm-row align-items-sm-center">
                    <div class="text-muted fw-bold mb-1 mb-sm-0 col-sm-4" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Jenis Kelamin</div>
                    <div class="fw-semibold text-dark col-sm-8" style="font-size: 0.95rem;">
                        <?php 
                            $jk = $m['jenis_kelamin'] ?? '';
                            if($jk == 'L' || $jk == 'Laki-Laki') echo 'Laki-Laki';
                            elseif($jk == 'P' || $jk == 'Perempuan') echo 'Perempuan';
                            else echo '<span class="text-muted fst-italic">Belum diatur</span>';
                        ?>
                    </div>
                </div>
                <div class="col-12 border-bottom py-3 d-flex flex-column flex-sm-row align-items-sm-center">
                    <div class="text-muted fw-bold mb-1 mb-sm-0 col-sm-4" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Tanggal Lahir</div>
                    <div class="fw-semibold text-dark col-sm-8" style="font-size: 0.95rem;">
                        <?= (!empty($m['tgl_lahir']) && $m['tgl_lahir'] != '0000-00-00') ? tgl_indo($m['tgl_lahir']) : '<span class="text-muted fst-italic">Belum diatur</span>' ?>
                    </div>
                </div>
                <div class="col-12 border-bottom py-3 d-flex flex-column flex-sm-row align-items-sm-center">
                    <div class="text-muted fw-bold mb-1 mb-sm-0 col-sm-4" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Alamat Email</div>
                    <div class="fw-semibold text-dark col-sm-8" style="font-size: 0.95rem;">
                        <?= !empty($m['email']) ? esc($m['email']) : '<span class="text-muted fst-italic">Belum diatur</span>' ?>
                    </div>
                </div>
                <div class="col-12 border-bottom py-3 d-flex flex-column flex-sm-row align-items-sm-center">
                    <div class="text-muted fw-bold mb-1 mb-sm-0 col-sm-4" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">No. Telepon / WhatsApp</div>
                    <div class="fw-semibold text-dark col-sm-8" style="font-size: 0.95rem;">
                        <?= !empty($m['no_telp']) ? esc($m['no_telp']) : '<span class="text-muted fst-italic">Belum diatur</span>' ?>
                    </div>
                </div>
                <div class="col-12 py-3 d-flex flex-column flex-sm-row align-items-sm-center">
                    <div class="text-muted fw-bold mb-1 mb-sm-0 col-sm-4" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Instansi Pendidikan</div>
                    <div class="fw-semibold text-dark col-sm-8" style="font-size: 0.95rem;">
                        <i class="bi bi-building me-1 text-primary"></i> <?= $kampus ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD: DATA DOMISILI -->
        <div class="card-flat shadow-sm mb-4">
            <h6 class="fw-bold text-dark mb-4 border-bottom pb-3"><i class="bi bi-geo-alt-fill me-2 text-danger"></i> Data Domisili Tempat Tinggal</h6>
            <div class="row g-0">
                <div class="col-12 border-bottom py-3 d-flex flex-column flex-sm-row align-items-sm-start">
                    <div class="text-muted fw-bold mb-1 mb-sm-0 col-sm-4 mt-sm-1" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Alamat Jalan Lengkap</div>
                    <div class="fw-semibold text-dark col-sm-8" style="font-size: 0.95rem; line-height: 1.6;">
                        <?= !empty($m['alamat']) ? esc($m['alamat']) : '<span class="text-muted fst-italic">Belum diatur</span>' ?>
                    </div>
                </div>
                <div class="col-12 border-bottom py-3 d-flex flex-column flex-sm-row align-items-sm-center">
                    <div class="text-muted fw-bold mb-1 mb-sm-0 col-sm-4" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">RT / RW</div>
                    <div class="fw-semibold text-dark col-sm-8" style="font-size: 0.95rem;">
                        <?= !empty($m['rt']) ? esc($m['rt']) : '-' ?> / <?= !empty($m['rw']) ? esc($m['rw']) : '-' ?>
                    </div>
                </div>
                <div class="col-12 border-bottom py-3 d-flex flex-column flex-sm-row align-items-sm-center">
                    <div class="text-muted fw-bold mb-1 mb-sm-0 col-sm-4" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Kelurahan / Desa</div>
                    <div class="fw-semibold text-dark col-sm-8" style="font-size: 0.95rem;">
                        <?= !empty($m['nama_kelurahan']) ? esc($m['nama_kelurahan']) : '<span class="text-muted fst-italic">Belum diatur</span>' ?>
                    </div>
                </div>
                <div class="col-12 border-bottom py-3 d-flex flex-column flex-sm-row align-items-sm-center">
                    <div class="text-muted fw-bold mb-1 mb-sm-0 col-sm-4" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Kecamatan</div>
                    <div class="fw-semibold text-dark col-sm-8" style="font-size: 0.95rem;">
                        <?= !empty($m['nama_kecamatan']) ? esc($m['nama_kecamatan']) : '<span class="text-muted fst-italic">Belum diatur</span>' ?>
                    </div>
                </div>
                <div class="col-12 border-bottom py-3 d-flex flex-column flex-sm-row align-items-sm-center">
                    <div class="text-muted fw-bold mb-1 mb-sm-0 col-sm-4" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Kabupaten / Kota</div>
                    <div class="fw-semibold text-dark col-sm-8" style="font-size: 0.95rem;">
                        <?= !empty($m['nama_kabupaten']) ? esc($m['nama_kabupaten']) : '<span class="text-muted fst-italic">Belum diatur</span>' ?>
                    </div>
                </div>
                <div class="col-12 py-3 d-flex flex-column flex-sm-row align-items-sm-center">
                    <div class="text-muted fw-bold mb-1 mb-sm-0 col-sm-4" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Provinsi</div>
                    <div class="fw-semibold text-dark col-sm-8" style="font-size: 0.95rem;">
                        <?= !empty($m['nama_provinsi']) ? esc($m['nama_provinsi']) : '<span class="text-muted fst-italic">Belum diatur</span>' ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD: DATA AKADEMIK -->
        <div class="card-flat shadow-sm mb-4">
            <h6 class="fw-bold text-dark mb-4 border-bottom pb-3"><i class="bi bi-mortarboard-fill me-2 text-warning"></i> Data Akademik</h6>
            <div class="row g-0">
                <div class="col-12 border-bottom py-3 d-flex flex-column flex-sm-row align-items-sm-center">
                    <div class="text-muted fw-bold mb-1 mb-sm-0 col-sm-4" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Jenjang Pendidikan</div>
                    <div class="fw-semibold text-dark col-sm-8" style="font-size: 0.95rem;">
                        <?= !empty($i['nama_jenjang']) ? esc($i['nama_jenjang']) : '<span class="text-muted fst-italic">Belum diatur</span>' ?>
                    </div>
                </div>
                <div class="col-12 border-bottom py-3 d-flex flex-column flex-sm-row align-items-sm-center">
                    <div class="text-muted fw-bold mb-1 mb-sm-0 col-sm-4" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Instansi Pendidikan</div>
                    <div class="fw-semibold text-dark col-sm-8" style="font-size: 0.95rem;">
                        <?= !empty($i['nama_instansi']) ? esc($i['nama_instansi']) : '<span class="text-muted fst-italic">Belum diatur</span>' ?>
                    </div>
                </div>
                <?php if (!$isSiswa): ?>
                <div class="col-12 border-bottom py-3 d-flex flex-column flex-sm-row align-items-sm-center">
                    <div class="text-muted fw-bold mb-1 mb-sm-0 col-sm-4" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Fakultas</div>
                    <div class="fw-semibold text-dark col-sm-8" style="font-size: 0.95rem;">
                        <?= !empty($i['fakultas']) ? esc($i['fakultas']) : '<span class="text-muted fst-italic">-</span>' ?>
                    </div>
                </div>
                <?php endif; ?>
                <div class="col-12 border-bottom py-3 d-flex flex-column flex-sm-row align-items-sm-center">
                    <div class="text-muted fw-bold mb-1 mb-sm-0 col-sm-4" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Jurusan</div>
                    <div class="fw-semibold text-dark col-sm-8" style="font-size: 0.95rem;">
                        <?php
                            if ($isSiswa) {
                                $valJurusan = !empty($i['jurusan_sekolah']) ? $i['jurusan_sekolah'] : (!empty($i['jurusan']) ? $i['jurusan'] : '');
                                echo !empty($valJurusan) ? esc($valJurusan) : '<span class="text-muted fst-italic">Belum diatur</span>';
                            } else {
                                echo !empty($i['prodi']) ? esc($i['prodi']) : '<span class="text-muted fst-italic">Belum diatur</span>';
                            }
                        ?>
                    </div>
                </div>
                <div class="col-12 border-bottom py-3 d-flex flex-column flex-sm-row align-items-sm-center">
                    <div class="text-muted fw-bold mb-1 mb-sm-0 col-sm-4" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;"><?= $isSiswa ? 'Kelas' : 'Semester' ?></div>
                    <div class="fw-semibold text-dark col-sm-8" style="font-size: 0.95rem;">
                        <?php 
                            if ($isSiswa && !empty($i['kelas'])) {
                                echo esc($i['kelas']);
                            } elseif (!$isSiswa && !empty($i['semester'])) {
                                echo 'Semester ' . esc($i['semester']);
                            } else {
                                echo '<span class="text-muted fst-italic">-</span>';
                            }
                        ?>
                    </div>
                </div>
                <?php if (!$isSiswa): ?>
                <div class="col-12 border-bottom py-3 d-flex flex-column flex-sm-row align-items-sm-center">
                    <div class="text-muted fw-bold mb-1 mb-sm-0 col-sm-4" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Tahun Angkatan</div>
                    <div class="fw-semibold text-dark col-sm-8" style="font-size: 0.95rem;">
                        <?= !empty($i['angkatan_tahun']) ? esc($i['angkatan_tahun']) : '<span class="text-muted fst-italic">-</span>' ?>
                    </div>
                </div>
                <div class="col-12 py-3 d-flex flex-column flex-sm-row align-items-sm-center">
                    <div class="text-muted fw-bold mb-1 mb-sm-0 col-sm-4" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Tahun Akademik</div>
                    <div class="fw-semibold text-dark col-sm-8" style="font-size: 0.95rem;">
                        <?= !empty($i['tahun_akademik']) ? esc($i['tahun_akademik']) : '<span class="text-muted fst-italic">-</span>' ?>
                    </div>
                </div>
                <?php else: ?>
                <div class="col-12 py-3 d-flex flex-column flex-sm-row align-items-sm-center">
                    <div class="text-muted fw-bold mb-1 mb-sm-0 col-sm-4" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Tahun Angkatan</div>
                    <div class="fw-semibold text-dark col-sm-8" style="font-size: 0.95rem;">
                        <?= !empty($i['angkatan_tahun']) ? esc($i['angkatan_tahun']) : '<span class="text-muted fst-italic">-</span>' ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
    </div>
    </div>
</div>




<!-- MODAL EDIT PROFIL -->
<div class="modal fade" id="modalEditProfil" tabindex="-1" aria-labelledby="modalEditProfilLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-xl" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header border-bottom-0 px-4 pt-4 pb-3" style="background: linear-gradient(to right, #f8fafc, #ffffff);">
                <h5 class="modal-title fw-bold text-dark" id="modalEditProfilLabel">
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:36px; height:36px; border-radius:10px; background:#e0f2fe; color:#0284c7; margin-right:10px;">
                        <i class="bi bi-pencil-square"></i>
                    </span> 
                    Lengkapi Profil Anda
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="<?= base_url('mahasiswa/profil/update') ?>" method="POST" enctype="multipart/form-data" onsubmit="event.preventDefault(); var form = this; Swal.fire({title: 'Simpan Perubahan?', text: 'Data profil Anda akan diperbarui di sistem.', icon: 'question', showCancelButton: true, confirmButtonColor: '#0a1d37', cancelButtonColor: '#6c757d', confirmButtonText: 'Ya, Simpan', cancelButtonText: 'Periksa Lagi', reverseButtons: true}).then((res) => { if(res.isConfirmed) { form.submit(); } });">
                <div class="modal-body p-0 bg-white">
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger mx-4 mt-3 mb-0" style="font-size: 0.85rem; border-radius: 10px;">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> <strong>Peringatan!</strong> <?= session()->getFlashdata('error') ?>
                            <?php if(session()->getFlashdata('errors')): ?>
                                <ul class="mt-2 mb-0 ps-3">
                                    <?php foreach(session()->getFlashdata('errors') as $err): ?>
                                        <li><?= esc($err) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Nav tabs (Custom Pills) -->
                    <div class="px-4 pb-3 border-bottom" style="background: #ffffff;">
                        <ul class="nav nav-pills gap-2" id="profilTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active rounded-pill px-4 fw-semibold" style="transition: 0.3s;" id="pribadi-tab" data-bs-toggle="tab" data-bs-target="#pribadi" type="button" role="tab">Data Pribadi</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill px-4 fw-semibold" style="transition: 0.3s;" id="domisili-tab" data-bs-toggle="tab" data-bs-target="#domisili" type="button" role="tab">Domisili</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill px-4 fw-semibold" style="transition: 0.3s;" id="akademik-tab" data-bs-toggle="tab" data-bs-target="#akademik" type="button" role="tab">Akademik</button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab panes -->
                    <div class="tab-content p-4" id="profilTabsContent">
                        
                        <!-- TAB PRIBADI -->
                        <div class="tab-pane fade show active" id="pribadi" role="tabpanel">
                            <div class="row g-4">

                                <div class="col-md-12">
                                    <label class="form-label small fw-bold text-muted mb-2">NAMA LENGKAP</label>
                                    <input type="text" name="nama_mahasiswa" class="form-control form-control-lg" style="font-size:0.95rem; border-radius:10px; border-color:#e2e8f0;" value="<?= esc($m['nama_mahasiswa'] ?? '') ?>" placeholder="Nama Lengkap Sesuai KTP">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted mb-2"><?= $isSiswa ? 'NISN' : 'NIM' ?></label>
                                    <input type="text" name="nim" class="form-control form-control-lg" style="font-size:0.95rem; border-radius:10px; border-color:#e2e8f0;" value="<?= esc($m['nim'] ?? '') ?>" placeholder="Nomor Induk Siswa/Mahasiswa">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted mb-2">NIK KTP (16 DIGIT)</label>
                                    <input type="text" name="nik" class="form-control form-control-lg" style="font-size:0.95rem; border-radius:10px; border-color:#e2e8f0;" value="<?= esc($m['nik'] ?? '') ?>" placeholder="Masukkan 16 digit NIK">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted mb-2">JENIS KELAMIN</label>
                                    <select name="jenis_kelamin" class="form-select form-select-lg" style="font-size:0.95rem; border-radius:10px; border-color:#e2e8f0; box-shadow:none;">
                                        <option value="">-- Pilih --</option>
                                        <option value="L" <?= ($m['jenis_kelamin'] ?? '') == 'L' ? 'selected' : '' ?>>Laki-Laki</option>
                                        <option value="P" <?= ($m['jenis_kelamin'] ?? '') == 'P' ? 'selected' : '' ?>>Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted mb-2">TANGGAL LAHIR</label>
                                    <input type="text" name="tgl_lahir" class="form-control form-control-lg flatpickr-id" style="font-size:0.95rem; border-radius:10px; border-color:#e2e8f0; background-color: #fff;" value="<?= $m['tgl_lahir'] ?? '' ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted mb-2">ALAMAT EMAIL</label>
                                    <input type="email" name="email" class="form-control form-control-lg" style="font-size:0.95rem; border-radius:10px; border-color:#e2e8f0;" value="<?= esc($m['email'] ?? '') ?>" placeholder="contoh@email.com">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted mb-2">NO. TELEPON / WHATSAPP</label>
                                    <input type="text" name="no_telp" class="form-control form-control-lg" style="font-size:0.95rem; border-radius:10px; border-color:#e2e8f0;" value="<?= esc($m['no_telp'] ?? '') ?>" placeholder="08xxx">
                                </div>
                            </div>
                        </div>

                        <!-- TAB DOMISILI -->
                        <div class="tab-pane fade" id="domisili" role="tabpanel">
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-muted mb-2">ALAMAT JALAN LENGKAP</label>
                                <textarea name="alamat" class="form-control form-control-lg" style="font-size:0.95rem; border-radius:10px; border-color:#e2e8f0;" rows="2" placeholder="Nama Jalan, Gedung, No. Rumah..."><?= esc($m['alamat'] ?? '') ?></textarea>
                            </div>
                            <div class="row g-4">
                                <div class="col-md-3">
                                    <label class="form-label small fw-bold text-muted mb-2">RT</label>
                                    <input type="text" name="rt" class="form-control form-control-lg" style="font-size:0.95rem; border-radius:10px; border-color:#e2e8f0;" value="<?= esc($m['rt'] ?? '') ?>" placeholder="001">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small fw-bold text-muted mb-2">RW</label>
                                    <input type="text" name="rw" class="form-control form-control-lg" style="font-size:0.95rem; border-radius:10px; border-color:#e2e8f0;" value="<?= esc($m['rw'] ?? '') ?>" placeholder="002">
                                </div>
                                <div class="col-md-6">
                                      <label class="form-label small fw-bold text-muted mb-2">PROVINSI</label>
                                      <select name="provinsi" id="edit_prov" class="form-select form-select-lg" style="font-size:0.95rem; border-radius:10px; border-color:#e2e8f0;" onchange="loadKabupaten(this.value)">
                                          <option value="">-- Pilih Provinsi --</option>
                                          <?php if(!empty($provinsi)): foreach($provinsi as $pv): ?>
                                              <option value="<?= $pv['id_provinsi'] ?>" <?= ($m['id_provinsi'] ?? '') == $pv['id_provinsi'] ? 'selected' : '' ?>><?= esc($pv['nama_provinsi']) ?></option>
                                          <?php endforeach; endif; ?>
                                      </select>
                                  </div>
                                  <div class="col-md-6">
                                      <label class="form-label small fw-bold text-muted mb-2">KABUPATEN / KOTA</label>
                                      <select name="kab_kota" id="edit_kab" class="form-select form-select-lg" style="font-size:0.95rem; border-radius:10px; border-color:#e2e8f0;" onchange="loadKecamatan(this.value)">
                                          <?php if(!empty($m['id_kabupaten'])): ?>
                                              <option value="<?= $m['id_kabupaten'] ?>" selected><?= esc($m['nama_kabupaten']) ?></option>
                                          <?php else: ?>
                                              <option value="">-- Pilih Kabupaten --</option>
                                          <?php endif; ?>
                                      </select>
                                  </div>
                                  <div class="col-md-6">
                                      <label class="form-label small fw-bold text-muted mb-2">KECAMATAN</label>
                                      <select name="kecamatan" id="edit_kec" class="form-select form-select-lg" style="font-size:0.95rem; border-radius:10px; border-color:#e2e8f0;" onchange="loadKelurahan(this.value)">
                                          <?php if(!empty($m['id_kecamatan'])): ?>
                                              <option value="<?= $m['id_kecamatan'] ?>" selected><?= esc($m['nama_kecamatan']) ?></option>
                                          <?php else: ?>
                                              <option value="">-- Pilih Kecamatan --</option>
                                          <?php endif; ?>
                                      </select>
                                  </div>
                                  <div class="col-md-6">
                                      <label class="form-label small fw-bold text-muted mb-2">KELURAHAN / DESA</label>
                                      <select name="id_kelurahan" id="edit_kel" class="form-select form-select-lg" style="font-size:0.95rem; border-radius:10px; border-color:#e2e8f0;">
                                          <?php if(!empty($m['id_kelurahan'])): ?>
                                              <option value="<?= $m['id_kelurahan'] ?>" selected><?= esc($m['nama_kelurahan']) ?></option>
                                          <?php else: ?>
                                              <option value="">-- Pilih Kelurahan --</option>
                                          <?php endif; ?>
                                      </select>
                                  </div>
                            </div>
                        </div>

                        <!-- TAB AKADEMIK -->
                        <div class="tab-pane fade" id="akademik" role="tabpanel">
                            <div class="row g-4">
                                <div class="col-md-6">
                                      <label class="form-label small fw-bold text-muted mb-2">JENJANG PENDIDIKAN</label>
                                      <select name="id_jenjang_pendidikan" id="edit_jenjang_pendidikan" class="form-select form-select-lg" style="font-size:0.95rem; border-radius:10px; border-color:#e2e8f0;" onchange="toggleAkademik()">
                                          <option value="">-- Pilih --</option>
                                          <?php if(!empty($jenjang)): foreach($jenjang as $j): ?>
                                              <option value="<?= $j['id_jenjang_pendidikan'] ?>" data-name="<?= esc(strtoupper($j['nama_jenjang'])) ?>" <?= ($i['id_jenjang_pendidikan'] ?? '') == $j['id_jenjang_pendidikan'] ? 'selected' : '' ?>><?= esc($j['nama_jenjang']) ?></option>
                                          <?php endforeach; endif; ?>
                                      </select>
                                  </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted mb-2">TAHUN ANGKATAN / MASUK</label>
                                    <input type="text" name="angkatan_tahun" class="form-control form-control-lg" style="font-size:0.95rem; border-radius:10px; border-color:#e2e8f0;" value="<?= esc($i['angkatan_tahun'] ?? '') ?>" placeholder="Misal: 2021">
                                </div>
                                <div class="col-md-6" id="wrap_semester" style="display: <?= $isSiswa ? 'none' : 'block' ?>;">
                                    <label class="form-label small fw-bold text-muted mb-2">SEMESTER SAAT INI</label>
                                    <input type="text" name="semester" class="form-control form-control-lg" style="font-size:0.95rem; border-radius:10px; border-color:#e2e8f0;" value="<?= esc($i['semester'] ?? '') ?>" placeholder="Misal: 6">
                                </div>
                                <div class="col-md-6" id="wrap_kelas" style="display: <?= $isSiswa ? 'block' : 'none' ?>;">
                                    <label class="form-label small fw-bold text-muted mb-2">KELAS SAAT INI</label>
                                    <select name="id_kelas" class="form-select form-select-lg" style="font-size:0.95rem; border-radius:10px; border-color:#e2e8f0;">
                                        <option value="">-- Pilih Kelas --</option>
                                        <?php if(!empty($kelas)): foreach($kelas as $k): ?>
                                            <option value="<?= $k['id_kelas'] ?>" <?= ($i['id_kelas'] ?? '') == $k['id_kelas'] ? 'selected' : '' ?>><?= esc($k['nama_kelas']) ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-6" id="wrap_jurusan" style="display: <?= $isSiswa ? 'block' : 'none' ?>;">
                                    <label class="form-label small fw-bold text-muted mb-2">JURUSAN SEKOLAH</label>
                                    <select name="id_jurusan" class="form-select form-select-lg" style="font-size:0.95rem; border-radius:10px; border-color:#e2e8f0;">
                                        <option value="">-- Pilih Jurusan --</option>
                                        <?php if(!empty($jurusan)): foreach($jurusan as $jrs): ?>
                                            <option value="<?= $jrs['id_jurusan'] ?>" <?= ($i['id_jurusan'] ?? '') == $jrs['id_jurusan'] ? 'selected' : '' ?>><?= esc($jrs['nama_jurusan']) ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted mb-2">TAHUN AKADEMIK</label>
                                    <input type="text" name="tahun_akademik" class="form-control form-control-lg" style="font-size:0.95rem; border-radius:10px; border-color:#e2e8f0;" value="<?= esc($i['tahun_akademik'] ?? '') ?>" placeholder="Misal: 2023/2024">
                                </div>
                                
                                <div class="col-12 mt-4">
                                    <hr class="text-black-50 opacity-10">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label small fw-bold text-muted mb-2">INSTITUSI PENDIDIKAN</label>
                                    <div class="px-3 py-2 bg-light border border-light-subtle rounded-3 text-dark fw-medium" style="font-size:0.95rem; cursor:not-allowed;">
                                        <i class="bi bi-building text-secondary me-2"></i><?= esc($i['nama_instansi'] ?? $kampus) ?>
                                    </div>
                                </div>
                                <div class="col-md-6" id="info_fakultas" style="display: <?= $isSiswa ? 'none' : 'block' ?>;">
                                    <label class="form-label small fw-bold text-muted mb-2">FAKULTAS</label>
                                    <div class="px-3 py-2 bg-light border border-light-subtle rounded-3 text-dark fw-medium" style="font-size:0.95rem; cursor:not-allowed;">
                                        <?= esc($i['fakultas'] ?? '-') ?>
                                    </div>
                                </div>
                                <div class="<?= $isSiswa ? 'col-md-12' : 'col-md-6' ?>" id="info_prodi">
                                    <label class="form-label small fw-bold text-muted mb-2">JURUSAN / PROGRAM STUDI</label>
                                    <div class="px-3 py-2 bg-light border border-light-subtle rounded-3 text-dark fw-medium" style="font-size:0.95rem; cursor:not-allowed;">
                                        <?php
                                            if ($isSiswa) {
                                                $valJurusan = !empty($i['jurusan_sekolah']) ? $i['jurusan_sekolah'] : (!empty($i['jurusan']) ? $i['jurusan'] : '');
                                                echo !empty($valJurusan) ? esc($valJurusan) : '<span class="text-muted fst-italic">Belum diatur</span>';
                                            } else {
                                                echo !empty($i['prodi']) ? esc($i['prodi']) : '<span class="text-muted fst-italic">Belum diatur</span>';
                                            }
                                        ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-12 mt-3">
                                    <div class="d-flex align-items-start p-3 bg-primary-subtle rounded-3 border border-primary-subtle">
                                        <i class="bi bi-info-circle-fill text-primary fs-5 me-3 mt-1"></i>
                                        <div class="text-primary-emphasis" style="font-size:0.85rem; line-height:1.6;">
                                            <strong>Pemberitahuan:</strong> Data Institusi Pendidikan, Fakultas, dan Program Studi tidak dapat diubah secara mandiri untuk menjaga validitas data magang. Hubungi Administrator jika terdapat kesalahan penulisan.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer bg-light border-top p-3" style="border-radius: 0 0 16px 16px;">
                    <button type="button" class="btn btn-light px-4 py-2 fw-semibold" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary px-4 py-2 fw-bold shadow-sm" style="border-radius: 8px;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Auto Open Modal on Validation Error -->
<script>
function toggleAkademik() {
    let select = document.getElementById('edit_jenjang_pendidikan');
    if(!select) return;
    
    let option = select.options[select.selectedIndex];
    if(!option) return;
    
    let jenjang = option.getAttribute('data-name') || '';
    let isSekolah = (jenjang.includes('SMA') || jenjang.includes('SMK') || jenjang.includes('SLTA'));
    
    let wrapSemester = document.getElementById('wrap_semester');
    let wrapKelas = document.getElementById('wrap_kelas');
    let wrapJurusan = document.getElementById('wrap_jurusan');
    let infoFakultas = document.getElementById('info_fakultas');
    let infoProdi = document.getElementById('info_prodi');
    
    if(wrapSemester) wrapSemester.style.display = isSekolah ? 'none' : 'block';
    if(wrapKelas) wrapKelas.style.display = isSekolah ? 'block' : 'none';
    if(wrapJurusan) wrapJurusan.style.display = isSekolah ? 'block' : 'none';
    
    if(infoFakultas) infoFakultas.style.display = isSekolah ? 'none' : 'block';
    if(infoProdi) {
        infoProdi.className = isSekolah ? 'col-md-12' : 'col-md-6';
    }
}

document.addEventListener("DOMContentLoaded", function() {
    toggleAkademik();
    
    <?php if (session()->getFlashdata('error')) : ?>
    var myModal = new bootstrap.Modal(document.getElementById('modalEditProfil'));
    myModal.show();
    <?php endif; ?>
});

function loadKabupaten(id_prov) {
    let kab = document.getElementById('edit_kab');
    let kec = document.getElementById('edit_kec');
    let kel = document.getElementById('edit_kel');
    kab.innerHTML = '<option value="">-- Pilih Kabupaten --</option>';
    kec.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
    kel.innerHTML = '<option value="">-- Pilih Kelurahan --</option>';
    if(!id_prov) return;
    
    fetch('<?= base_url("api/kabupaten") ?>/'+id_prov)
    .then(r=>r.json()).then(d=>{
        d.forEach(k => kab.innerHTML += `<option value="${k.id_kabupaten}">${k.nama_kabupaten}</option>`);
    });
}

function loadKecamatan(id_kab) {
    let kec = document.getElementById('edit_kec');
    let kel = document.getElementById('edit_kel');
    kec.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
    kel.innerHTML = '<option value="">-- Pilih Kelurahan --</option>';
    if(!id_kab) return;
    
    fetch('<?= base_url("api/kecamatan") ?>/'+id_kab)
    .then(r=>r.json()).then(d=>{
        d.forEach(k => kec.innerHTML += `<option value="${k.id_kecamatan}">${k.nama_kecamatan}</option>`);
    });
}

function loadKelurahan(id_kec) {
    let kel = document.getElementById('edit_kel');
    kel.innerHTML = '<option value="">-- Pilih Kelurahan --</option>';
    if(!id_kec) return;
    
    fetch('<?= base_url("api/kelurahan") ?>/'+id_kec)
    .then(r=>r.json()).then(d=>{
        d.forEach(k => kel.innerHTML += `<option value="${k.id_kelurahan}">${k.nama_kelurahan}</option>`);
    });
}
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function handleFotoAjaxUpload(input) {
        if (!input.files || input.files.length === 0) return;
        
        let file = input.files[0];
        
        if (file.size > 5 * 1024 * 1024) {
            Swal.fire('Error', 'Ukuran foto maksimal 5MB.', 'error');
            input.value = '';
            return;
        }
        
        let formData = new FormData();
        formData.append('foto_profil_ajax', file);
        
        Swal.fire({
            title: 'Mengunggah...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        fetch('<?= base_url('mahasiswa/profil/upload-foto') ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire('Berhasil!', data.message, 'success').then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire('Gagal', data.message || 'Terjadi kesalahan saat mengunggah foto', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Gagal', 'Terjadi kesalahan sistem.', 'error');
        });
        
        input.value = '';
    }
</script>
<?= $this->endSection() ?>
