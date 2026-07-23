<?= $this->extend('layout/mahasiswa') ?>

<?= $this->section('breadcrumb') ?>
    <i class="bi bi-person-bounding-box me-1 text-primary"></i> Profil Mahasiswa
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
?>

<div class="container-fluid p-0">
    <div class="row g-4">
    <!-- KOLOM KIRI: KARTU IDENTITAS -->
    <div class="col-md-4 col-lg-3">
        <div class="card-flat text-center shadow-sm">
            <div class="mx-auto mt-3 mb-3 d-flex align-items-center justify-content-center fw-bold text-white shadow-sm" 
                 style="width: 100px; height: 100px; border-radius: 50%; background: linear-gradient(135deg, #0ea5e9, #3b82f6); font-size: 2.5rem; border: 4px solid #eff6ff;">
                <?= $inisial ?>
            </div>
            <h5 class="fw-bold text-dark mb-1"><?= $nama ?></h5>
            <p class="text-secondary small fw-semibold mb-3"><?= $nim ?></p>
            
            <span class="badge bg-success-subtle text-success px-3 py-1.5 rounded-pill fw-semibold mb-3 border border-success-subtle">
                <i class="bi bi-check-circle-fill me-1"></i> Akun Aktif
            </span>
            
            <hr class="text-black-50 opacity-10">
            
            <div class="text-start px-2 mb-3">
                <label class="small text-muted fw-bold d-block mb-1" style="font-size: 0.7rem;">ASAL KAMPUS / SEKOLAH</label>
                <div class="fw-semibold text-dark small"><i class="bi bi-building me-2 text-primary"></i> <?= $kampus ?></div>
            </div>
            
            <button class="btn btn-outline-primary btn-sm w-100 fw-bold rounded-3 mt-2 py-2" data-bs-toggle="modal" data-bs-target="#modalEditProfil">
                <i class="bi bi-pencil-square me-1"></i> Edit Profil
            </button>
        </div>
    </div>

    <!-- KOLOM KANAN: DATA DETAIL -->
    <div class="col-md-8 col-lg-9">
        
        <!-- CARD: DATA PRIBADI -->
        <div class="card-flat shadow-sm mb-4">
            <h6 class="fw-bold text-dark mb-4 border-bottom pb-3"><i class="bi bi-person-lines-fill me-2 text-primary"></i> Data Pribadi & Kontak</h6>
            <div class="row g-4">
                <div class="col-sm-6">
                    <div class="text-muted fw-bold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px; text-transform: uppercase;">NIK (NOMOR INDUK KEPENDUDUKAN)</div>
                    <div class="fw-semibold text-dark bg-light px-3 py-2 rounded-3 border border-light-subtle" style="font-size: 0.9rem;">
                        <?= !empty($m['nik']) ? esc($m['nik']) : '<span class="text-muted fst-italic">Belum diatur</span>' ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="text-muted fw-bold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px; text-transform: uppercase;">JENIS KELAMIN</div>
                    <div class="fw-semibold text-dark bg-light px-3 py-2 rounded-3 border border-light-subtle" style="font-size: 0.9rem;">
                        <?php 
                            $jk = $m['jenis_kelamin'] ?? '';
                            if($jk == 'L' || $jk == 'Laki-Laki') echo 'Laki-Laki';
                            elseif($jk == 'P' || $jk == 'Perempuan') echo 'Perempuan';
                            else echo '<span class="text-muted fst-italic">Belum diatur</span>';
                        ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="text-muted fw-bold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px; text-transform: uppercase;">TANGGAL LAHIR</div>
                    <div class="fw-semibold text-dark bg-light px-3 py-2 rounded-3 border border-light-subtle" style="font-size: 0.9rem;">
                        <?= (!empty($m['tgl_lahir']) && $m['tgl_lahir'] != '0000-00-00') ? date('d F Y', strtotime($m['tgl_lahir'])) : '<span class="text-muted fst-italic">Belum diatur</span>' ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="text-muted fw-bold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px; text-transform: uppercase;">ALAMAT EMAIL</div>
                    <div class="fw-semibold text-dark bg-light px-3 py-2 rounded-3 border border-light-subtle" style="font-size: 0.9rem;">
                        <?= !empty($m['email']) ? esc($m['email']) : '<span class="text-muted fst-italic">Belum diatur</span>' ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="text-muted fw-bold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px; text-transform: uppercase;">NO. TELEPON / WHATSAPP</div>
                    <div class="fw-semibold text-dark bg-light px-3 py-2 rounded-3 border border-light-subtle" style="font-size: 0.9rem;">
                        <?= !empty($m['no_telp']) ? esc($m['no_telp']) : '<span class="text-muted fst-italic">Belum diatur</span>' ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD: DATA DOMISILI -->
        <div class="card-flat shadow-sm mb-4">
            <h6 class="fw-bold text-dark mb-4 border-bottom pb-3"><i class="bi bi-geo-alt-fill me-2 text-danger"></i> Data Domisili Tempat Tinggal</h6>
            <div class="mb-4">
                <div class="text-muted fw-bold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px; text-transform: uppercase;">ALAMAT JALAN LENGKAP</div>
                <div class="fw-semibold text-dark bg-light px-3 py-2 rounded-3 border border-light-subtle" style="font-size: 0.9rem;">
                    <?= !empty($m['alamat']) ? esc($m['alamat']) : '<span class="text-muted fst-italic">Belum diatur</span>' ?>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-sm-3">
                    <div class="text-muted fw-bold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px; text-transform: uppercase;">RT</div>
                    <div class="fw-semibold text-dark bg-light px-3 py-2 rounded-3 border border-light-subtle" style="font-size: 0.9rem;">
                        <?= !empty($m['rt']) ? esc($m['rt']) : '-' ?>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="text-muted fw-bold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px; text-transform: uppercase;">RW</div>
                    <div class="fw-semibold text-dark bg-light px-3 py-2 rounded-3 border border-light-subtle" style="font-size: 0.9rem;">
                        <?= !empty($m['rw']) ? esc($m['rw']) : '-' ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="text-muted fw-bold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px; text-transform: uppercase;">KELURAHAN / DESA</div>
                    <div class="fw-semibold text-dark bg-light px-3 py-2 rounded-3 border border-light-subtle" style="font-size: 0.9rem;">
                        <?= !empty($m['kelurahan']) ? esc($m['kelurahan']) : '<span class="text-muted fst-italic">Belum diatur</span>' ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="text-muted fw-bold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px; text-transform: uppercase;">KECAMATAN</div>
                    <div class="fw-semibold text-dark bg-light px-3 py-2 rounded-3 border border-light-subtle" style="font-size: 0.9rem;">
                        <?= !empty($m['kecamatan']) ? esc($m['kecamatan']) : '<span class="text-muted fst-italic">Belum diatur</span>' ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="text-muted fw-bold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px; text-transform: uppercase;">PROVINSI</div>
                    <div class="fw-semibold text-dark bg-light px-3 py-2 rounded-3 border border-light-subtle" style="font-size: 0.9rem;">
                        <?= !empty($m['provinsi']) ? esc($m['provinsi']) : '<span class="text-muted fst-italic">Belum diatur</span>' ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD: DATA AKADEMIK -->
        <div class="card-flat shadow-sm mb-4">
            <h6 class="fw-bold text-dark mb-4 border-bottom pb-3"><i class="bi bi-mortarboard-fill me-2 text-warning"></i> Data Institusi Akademik</h6>
            <div class="row g-4">
                <div class="col-sm-6">
                    <div class="text-muted fw-bold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px; text-transform: uppercase;">JENJANG PENDIDIKAN</div>
                    <div class="fw-semibold text-dark bg-light px-3 py-2 rounded-3 border border-light-subtle" style="font-size: 0.9rem;">
                        <?= !empty($i['jenjang_pendidikan']) ? esc($i['jenjang_pendidikan']) : '<span class="text-muted fst-italic">Belum diatur</span>' ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="text-muted fw-bold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px; text-transform: uppercase;">PROGRAM STUDI / JURUSAN</div>
                    <div class="fw-semibold text-dark bg-light px-3 py-2 rounded-3 border border-light-subtle" style="font-size: 0.9rem;">
                        <?= !empty($i['prodi']) ? esc($i['prodi']) : '<span class="text-muted fst-italic">Belum diatur</span>' ?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="text-muted fw-bold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px; text-transform: uppercase;">TAHUN ANGKATAN</div>
                    <div class="fw-semibold text-dark bg-light px-3 py-2 rounded-3 border border-light-subtle" style="font-size: 0.9rem;">
                        <?= !empty($i['angkatan_tahun']) ? esc($i['angkatan_tahun']) : '<span class="text-muted fst-italic">-</span>' ?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="text-muted fw-bold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px; text-transform: uppercase;">SEMESTER</div>
                    <div class="fw-semibold text-dark bg-light px-3 py-2 rounded-3 border border-light-subtle" style="font-size: 0.9rem;">
                        <?= !empty($i['semester']) ? esc($i['semester']) : '<span class="text-muted fst-italic">-</span>' ?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="text-muted fw-bold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px; text-transform: uppercase;">TAHUN AKADEMIK</div>
                    <div class="fw-semibold text-dark bg-light px-3 py-2 rounded-3 border border-light-subtle" style="font-size: 0.9rem;">
                        <?= !empty($i['tahun_akademik']) ? esc($i['tahun_akademik']) : '<span class="text-muted fst-italic">-</span>' ?>
                    </div>
                </div>
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
            
            <form action="<?= base_url('mahasiswa/profil/update') ?>" method="POST" onsubmit="event.preventDefault(); var form = this; Swal.fire({title: 'Simpan Perubahan?', text: 'Data profil Anda akan diperbarui di sistem.', icon: 'question', showCancelButton: true, confirmButtonColor: '#0a1d37', cancelButtonColor: '#6c757d', confirmButtonText: 'Ya, Simpan', cancelButtonText: 'Periksa Lagi'}).then((res) => { if(res.isConfirmed) { form.submit(); } });">
                <div class="modal-body p-0 bg-white">
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
                                    <input type="date" name="tgl_lahir" class="form-control form-control-lg" style="font-size:0.95rem; border-radius:10px; border-color:#e2e8f0;" value="<?= $m['tgl_lahir'] ?? '' ?>">
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
                                    <label class="form-label small fw-bold text-muted mb-2">KELURAHAN / DESA</label>
                                    <input type="text" name="kelurahan" class="form-control form-control-lg" style="font-size:0.95rem; border-radius:10px; border-color:#e2e8f0;" value="<?= esc($m['kelurahan'] ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted mb-2">KECAMATAN</label>
                                    <input type="text" name="kecamatan" class="form-control form-control-lg" style="font-size:0.95rem; border-radius:10px; border-color:#e2e8f0;" value="<?= esc($m['kecamatan'] ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted mb-2">PROVINSI</label>
                                    <input type="text" name="provinsi" class="form-control form-control-lg" style="font-size:0.95rem; border-radius:10px; border-color:#e2e8f0;" value="<?= esc($m['provinsi'] ?? '') ?>">
                                </div>
                            </div>
                        </div>

                        <!-- TAB AKADEMIK -->
                        <div class="tab-pane fade" id="akademik" role="tabpanel">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted mb-2">JENJANG PENDIDIKAN</label>
                                    <select name="jenjang_pendidikan" class="form-select form-select-lg" style="font-size:0.95rem; border-radius:10px; border-color:#e2e8f0;">
                                        <option value="">-- Pilih --</option>
                                        <option value="SMA/SMK" <?= ($i['jenjang_pendidikan'] ?? '') == 'SMA/SMK' ? 'selected' : '' ?>>SMA/SMK</option>
                                        <option value="D3" <?= ($i['jenjang_pendidikan'] ?? '') == 'D3' ? 'selected' : '' ?>>D3</option>
                                        <option value="D4" <?= ($i['jenjang_pendidikan'] ?? '') == 'D4' ? 'selected' : '' ?>>D4</option>
                                        <option value="S1" <?= ($i['jenjang_pendidikan'] ?? '') == 'S1' ? 'selected' : '' ?>>S1</option>
                                        <option value="S2" <?= ($i['jenjang_pendidikan'] ?? '') == 'S2' ? 'selected' : '' ?>>S2</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted mb-2">TAHUN ANGKATAN</label>
                                    <input type="text" name="angkatan_tahun" class="form-control form-control-lg" style="font-size:0.95rem; border-radius:10px; border-color:#e2e8f0;" value="<?= esc($i['angkatan_tahun'] ?? '') ?>" placeholder="Misal: 2021">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted mb-2">SEMESTER SAAT INI</label>
                                    <input type="text" name="semester" class="form-control form-control-lg" style="font-size:0.95rem; border-radius:10px; border-color:#e2e8f0;" value="<?= esc($i['semester'] ?? '') ?>" placeholder="Misal: 6">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted mb-2">TAHUN AKADEMIK</label>
                                    <input type="text" name="tahun_akademik" class="form-control form-control-lg" style="font-size:0.95rem; border-radius:10px; border-color:#e2e8f0;" value="<?= esc($i['tahun_akademik'] ?? '') ?>" placeholder="Misal: 2023/2024">
                                </div>
                                
                                <div class="col-12 mt-4">
                                    <hr class="text-black-50 opacity-10">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label small fw-bold text-muted mb-2">INSTANSI PENDIDIKAN / ASAL KAMPUS</label>
                                    <div class="px-3 py-2 bg-light border border-light-subtle rounded-3 text-dark fw-medium" style="font-size:0.95rem; cursor:not-allowed;">
                                        <i class="bi bi-building text-secondary me-2"></i><?= esc($i['nama_instansi'] ?? $kampus) ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted mb-2">FAKULTAS</label>
                                    <div class="px-3 py-2 bg-light border border-light-subtle rounded-3 text-dark fw-medium" style="font-size:0.95rem; cursor:not-allowed;">
                                        <?= esc($i['fakultas'] ?? '-') ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted mb-2">PROGRAM STUDI</label>
                                    <div class="px-3 py-2 bg-light border border-light-subtle rounded-3 text-dark fw-medium" style="font-size:0.95rem; cursor:not-allowed;">
                                        <?= esc($i['prodi'] ?? '-') ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-12 mt-3">
                                    <div class="d-flex align-items-start p-3 bg-primary-subtle rounded-3 border border-primary-subtle">
                                        <i class="bi bi-info-circle-fill text-primary fs-5 me-3 mt-1"></i>
                                        <div class="text-primary-emphasis" style="font-size:0.85rem; line-height:1.6;">
                                            <strong>Pemberitahuan:</strong> Data Asal Kampus, Fakultas, dan Program Studi tidak dapat diubah secara mandiri untuk menjaga validitas data magang. Hubungi Administrator jika terdapat kesalahan penulisan.
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

<?= $this->endSection() ?>
