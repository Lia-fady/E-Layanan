<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Layanan Akademik - Dinas Kominfo Kota Tangerang</title>
    <meta name="description" content="Platform digital terintegrasi untuk pengajuan dan pengelolaan permohonan Magang, PKL, Penelitian, dan Observasi di Dinas Komunikasi dan Informatika Kota Tangerang.">
    <meta name="keywords" content="magang tangerang, PKL kominfo, penelitian kominfo, e-layanan akademik">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Landing CSS -->
    <link rel="stylesheet" href="<?= base_url('css/landing.css') ?>">
</head>
<body>

<!-- ===== NAVBAR ===== -->
<nav class="lp-navbar" id="lp-navbar">
    <a href="<?= base_url('/') ?>" class="lp-brand">
        <img src="<?= base_url('images/kota tng_nobg.png') ?>" alt="Logo Kota Tangerang" class="lp-brand-logo" onerror="this.style.display='none'">
        <div class="lp-brand-text">
            <div class="lp-brand-name">E-Layanan Akademik</div>
            <div class="lp-brand-sub">Dinas Kominfo Kota Tangerang</div>
        </div>
    </a>

    <div class="lp-nav-links">
        <a href="#tentang">Tentang</a>
        <a href="#program">Program</a>
        <a href="#alur">Alur Pendaftaran</a>
        <a href="#faq">FAQ</a>
        <a href="#kontak">Kontak</a>
    </div>

    <div class="lp-nav-actions">
        <a href="<?= base_url('register') ?>" class="btn-lp-outline">Daftar Akun</a>
        <a href="<?= base_url('login') ?>" class="btn-lp-solid"><i class="bi bi-box-arrow-in-right me-1"></i> Masuk</a>
    </div>
</nav>

<!-- ===== HERO SECTION ===== -->
<section class="lp-hero" id="beranda">
    <div style="width: 100%; display: flex; flex-direction: column; align-items: center;">
        <div class="lp-hero-content">
            <div class="lp-hero-badge">
                <i class="bi bi-stars"></i> Platform E-Layanan Resmi
            </div>
            <h1>
                Gerbang Akademik<br>
                <span>Kota Tangerang</span>
            </h1>
            <p>
                Platform digital terintegrasi untuk pengajuan dan pengelolaan permohonan
                <strong style="color:rgba(255,255,255,0.9);">Magang, PKL, Penelitian, dan Observasi</strong>
                di Dinas Komunikasi dan Informatika Kota Tangerang.
            </p>
            <div class="lp-hero-cta">
                <a href="<?= base_url('register') ?>" class="btn-hero-primary">
                    <i class="bi bi-pencil-square me-2"></i>Daftar Sekarang
                </a>
                <a href="#program" class="btn-hero-secondary">
                    <i class="bi bi-play-circle me-2"></i>Pelajari Program
                </a>
            </div>
        </div>

        <!-- Stats Bar -->
        <div class="lp-hero-stats">
            <div class="stat-item">
                <div class="stat-number">4<span>+</span></div>
                <div class="stat-label">Jenis Program</div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <div class="stat-number">100<span>%</span></div>
                <div class="stat-label">Proses Digital</div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <div class="stat-number">24<span>/7</span></div>
                <div class="stat-label">Pantau Status</div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <div class="stat-number">0<span> biaya</span></div>
                <div class="stat-label">Pendaftaran Gratis</div>
            </div>
        </div>
    </div>
</section>

<!-- ===== TENTANG PLATFORM ===== -->
<section class="lp-about" id="tentang">
    <div class="lp-container">
        <div class="about-grid">
            <div class="about-text">
                <div class="section-badge">TENTANG PLATFORM</div>
                <p style="font-size: 1.05rem; line-height: 1.7; color: #4b5563;">
                    <strong>E-Layanan Akademik</strong> adalah ekosistem digital resmi dari <strong>Dinas Komunikasi dan Informatika Kota Tangerang</strong>. Kami hadir untuk memfasilitasi mahasiswa dan pelajar dalam mengembangkan kompetensi, mengelola administrasi magang secara transparan, serta berkolaborasi langsung dalam lingkungan kerja pemerintahan.
                </p>
                <div class="about-features">
                    <div class="feature-pill">
                        <i class="bi bi-check-circle-fill"></i>
                        Pendaftaran &amp; Pengajuan Dokumen Online
                    </div>
                    <div class="feature-pill">
                        <i class="bi bi-check-circle-fill"></i>
                        Pemantauan Status Real-Time
                    </div>
                    <div class="feature-pill">
                        <i class="bi bi-check-circle-fill"></i>
                        Logbook &amp; Penilaian Digital
                    </div>
                    <div class="feature-pill">
                        <i class="bi bi-check-circle-fill"></i>
                        Sertifikat Unduh Otomatis
                    </div>
                </div>
            </div>
            <div class="about-visual">
                <div class="visual-card">
                    <div class="vc-icon blue"><i class="bi bi-file-earmark-check-fill"></i></div>
                    <div class="vc-text">
                        <strong>Ajukan Permohonan</strong>
                        <span>Isi formulir &amp; unggah dokumen secara online</span>
                    </div>
                </div>
                <div class="visual-card">
                    <div class="vc-icon gold"><i class="bi bi-search"></i></div>
                    <div class="vc-text">
                        <strong>Proses Verifikasi</strong>
                        <span>Sekretariat &amp; Kepala Bidang meninjau berkas</span>
                    </div>
                </div>
                <div class="visual-card">
                    <div class="vc-icon accent"><i class="bi bi-journal-richtext"></i></div>
                    <div class="vc-text">
                        <strong>Isi Logbook Harian</strong>
                        <span>Catat aktivitas magang setiap hari secara digital</span>
                    </div>
                </div>
                <div class="visual-card">
                    <div class="vc-icon blue"><i class="bi bi-patch-check-fill"></i></div>
                    <div class="vc-text">
                        <strong>Unduh Sertifikat</strong>
                        <span>Sertifikat tersedia otomatis setelah selesai</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== PROGRAM PILIHAN ===== -->
<section class="lp-program" id="program">
    <div class="lp-container">
        <div class="program-header">
            <div class="section-badge">PROGRAM KAMI</div>
            <h2 class="section-title">Program Pilihan</h2>
            <p class="section-sub" style="margin: 10px auto 0;">Pilih kategori yang sesuai dengan kebutuhan akademik dan kualifikasi Anda</p>
        </div>

        <div class="program-tabs">
            <button class="prog-tab active" onclick="switchTab(this, 'magang')">Magang / PKL</button>
            <button class="prog-tab" onclick="switchTab(this, 'penelitian')">Penelitian</button>
            <button class="prog-tab" onclick="switchTab(this, 'observasi')">Observasi</button>
            <button class="prog-tab" onclick="switchTab(this, 'uji')">Uji Coba Produk</button>
        </div>

        <!-- Tab Magang -->
        <div class="program-cards" id="tab-magang">
            <div class="prog-card">
                <div class="prog-card-icon"><i class="bi bi-pencil-square"></i></div>
                <h3>Pendaftaran</h3>
                <p>Isi formulir permohonan magang secara online dan unggah dokumen persyaratan seperti surat pengantar, proposal, dan KTP.</p>
            </div>
            <div class="prog-card">
                <div class="prog-card-icon"><i class="bi bi-briefcase-fill"></i></div>
                <h3>Pelaksanaan</h3>
                <p>Informasi detail penempatan unit kerja, jadwal masuk, tata tertib selama bertugas, dan pembimbing lapangan yang ditunjuk.</p>
            </div>
            <div class="prog-card">
                <div class="prog-card-icon"><i class="bi bi-mortarboard-fill"></i></div>
                <h3>Penyelesaian</h3>
                <p>Prosedur penilaian, pengisian logbook, pengumpulan laporan akhir, dan pengunduhan sertifikat magang secara digital.</p>
            </div>
        </div>
        <!-- Tab Penelitian -->
        <div class="program-cards d-none" id="tab-penelitian">
            <div class="prog-card">
                <div class="prog-card-icon"><i class="bi bi-book-fill"></i></div>
                <h3>Pengajuan Penelitian</h3>
                <p>Ajukan izin penelitian dengan menyertakan proposal, surat dari institusi asal, dan rencana kegiatan penelitian yang akan dilaksanakan.</p>
            </div>
            <div class="prog-card">
                <div class="prog-card-icon"><i class="bi bi-clipboard-data-fill"></i></div>
                <h3>Pengumpulan Data</h3>
                <p>Lakukan penelitian dan pengumpulan data di lingkungan Dinas Kominfo Kota Tangerang sesuai dengan izin yang telah diterbitkan.</p>
            </div>
            <div class="prog-card">
                <div class="prog-card-icon"><i class="bi bi-file-earmark-text-fill"></i></div>
                <h3>Pelaporan</h3>
                <p>Serahkan laporan akhir hasil penelitian dan terima surat keterangan selesai penelitian yang dapat diunduh melalui sistem.</p>
            </div>
        </div>
        <!-- Tab Observasi -->
        <div class="program-cards d-none" id="tab-observasi">
            <div class="prog-card">
                <div class="prog-card-icon"><i class="bi bi-eye-fill"></i></div>
                <h3>Permohonan Observasi</h3>
                <p>Ajukan permohonan kunjungan atau observasi lapangan ke Dinas Kominfo beserta tujuan dan jadwal pelaksanaan yang direncanakan.</p>
            </div>
            <div class="prog-card">
                <div class="prog-card-icon"><i class="bi bi-people-fill"></i></div>
                <h3>Koordinasi</h3>
                <p>Tim Dinas Kominfo akan menghubungi Anda untuk menjadwalkan sesi observasi dan menentukan narasumber serta lokasi yang relevan.</p>
            </div>
            <div class="prog-card">
                <div class="prog-card-icon"><i class="bi bi-check2-all"></i></div>
                <h3>Dokumentasi</h3>
                <p>Dapatkan surat keterangan telah melakukan observasi yang dapat diunduh langsung melalui platform setelah kegiatan selesai.</p>
            </div>
        </div>
        <!-- Tab Uji Coba -->
        <div class="program-cards d-none" id="tab-uji">
            <div class="prog-card">
                <div class="prog-card-icon"><i class="bi bi-cpu-fill"></i></div>
                <h3>Pengajuan Uji Coba</h3>
                <p>Ajukan permohonan uji coba produk teknologi atau perangkat lunak beserta dokumentasi teknis dan tujuan pengujian yang jelas.</p>
            </div>
            <div class="prog-card">
                <div class="prog-card-icon"><i class="bi bi-gear-fill"></i></div>
                <h3>Proses Pengujian</h3>
                <p>Lakukan uji coba produk di bawah pengawasan tim teknis Dinas Kominfo sesuai dengan rencana dan ruang lingkup yang disepakati.</p>
            </div>
            <div class="prog-card">
                <div class="prog-card-icon"><i class="bi bi-bar-chart-fill"></i></div>
                <h3>Hasil &amp; Feedback</h3>
                <p>Terima laporan hasil uji coba beserta masukan dari tim teknis dan surat keterangan penyelesaian yang tercatat di sistem.</p>
            </div>
        </div>
    </div>
</section>

<!-- ===== ALUR PENDAFTARAN ===== -->
<section class="lp-alur" id="alur">
    <div class="lp-container">
        <div class="alur-header">
            <div class="section-badge">ALUR PENDAFTARAN</div>
            <h2 class="section-title">Tahapan Pelaksanaan Program</h2>
            <p class="section-sub" style="margin: 10px auto 0;">Proses yang transparan dan dapat dipantau di setiap tahap</p>
        </div>

        <div class="alur-timeline">
            <div class="alur-item">
                <div class="alur-circle"><i class="bi bi-pencil-square"></i></div>
                <div class="alur-content">
                    <div class="alur-num">Langkah 01</div>
                    <h3>Pendaftaran Akun</h3>
                    <p>Buat akun baru dengan data diri lengkap, data akademik, dan verifikasi email Anda.</p>
                </div>
            </div>
            <div class="alur-item">
                <div class="alur-circle"><i class="bi bi-file-earmark-arrow-up-fill"></i></div>
                <div class="alur-content">
                    <div class="alur-num">Langkah 02</div>
                    <h3>Pengajuan Permohonan</h3>
                    <p>Isi formulir permohonan dan unggah seluruh dokumen persyaratan yang dibutuhkan.</p>
                </div>
            </div>
            <div class="alur-item">
                <div class="alur-circle"><i class="bi bi-shield-check"></i></div>
                <div class="alur-content">
                    <div class="alur-num">Langkah 03</div>
                    <h3>Verifikasi &amp; Seleksi</h3>
                    <p>Sekretariat dan Kepala Bidang melakukan pemeriksaan kelengkapan dan verifikasi berkas.</p>
                </div>
            </div>
            <div class="alur-item">
                <div class="alur-circle"><i class="bi bi-briefcase-fill"></i></div>
                <div class="alur-content">
                    <div class="alur-num">Langkah 04</div>
                    <h3>Penetapan &amp; Pelaksanaan</h3>
                    <p>Peserta yang lolos menerima informasi penempatan dan memulai program sesuai jadwal.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== KEUNGGULAN ===== -->
<section class="lp-keunggulan">
    <div class="lp-container">
        <div class="keung-header">
            <div class="section-badge">KEUNGGULAN</div>
            <h2 class="section-title">Mengapa Menggunakan Platform Ini?</h2>
            <p class="section-sub">Solusi digital yang dirancang untuk mempermudah setiap proses administrasi akademik Anda</p>
        </div>
        <div class="keung-grid">
            <div class="keung-card">
                <div class="keung-icon"><i class="bi bi-lightning-charge-fill"></i></div>
                <h3>Proses Cepat &amp; Efisien</h3>
                <p>Pengajuan dilakukan secara online tanpa perlu datang langsung. Hemat waktu dan tenaga.</p>
            </div>
            <div class="keung-card">
                <div class="keung-icon"><i class="bi bi-eye-fill"></i></div>
                <h3>Transparansi Status</h3>
                <p>Pantau posisi permohonan Anda secara real-time dari mana saja dan kapan saja.</p>
            </div>
            <div class="keung-card">
                <div class="keung-icon"><i class="bi bi-shield-lock-fill"></i></div>
                <h3>Data Aman &amp; Terenkripsi</h3>
                <p>Seluruh data dan dokumen Anda disimpan dengan sistem keamanan berlapis.</p>
            </div>
            <div class="keung-card">
                <div class="keung-icon"><i class="bi bi-journal-text"></i></div>
                <h3>Logbook Digital</h3>
                <p>Catat kegiatan harian magang Anda secara digital dan terstruktur tanpa dokumen fisik.</p>
            </div>
            <div class="keung-card">
                <div class="keung-icon"><i class="bi bi-chat-square-text-fill"></i></div>
                <h3>Notifikasi &amp; Catatan</h3>
                <p>Terima catatan dan umpan balik langsung dari Sekretariat dan Kepala Bidang melalui sistem.</p>
            </div>
            <div class="keung-card">
                <div class="keung-icon"><i class="bi bi-award-fill"></i></div>
                <h3>Sertifikat Digital</h3>
                <p>Unduh sertifikat penyelesaian program kapan saja langsung dari dashboard Anda.</p>
            </div>
        </div>
    </div>
</section>

<!-- ===== FAQ ===== -->
<section class="lp-faq" id="faq">
    <div class="lp-container">
        <div class="faq-header">
            <div class="section-badge">FAQ</div>
            <h2 class="section-title">Pertanyaan yang Sering Diajukan</h2>
            <div class="faq-separator"></div>
            <p class="section-sub" style="margin: 16px auto 0;">Jawaban atas pertanyaan umum seputar program di Dinas Kominfo Kota Tangerang</p>
        </div>
        <div class="faq-list" id="faqList">
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <span>Apa itu E-Layanan Akademik Dinas Kominfo Tangerang?</span>
                    <div class="faq-arrow"><i class="bi bi-chevron-down"></i></div>
                </div>
                <div class="faq-answer">
                    <p>E-Layanan Akademik adalah platform digital resmi Dinas Komunikasi dan Informatika Kota Tangerang yang memfasilitasi proses pengajuan dan pengelolaan permohonan akademik seperti Magang, PKL, Penelitian, Observasi, dan Uji Coba Produk secara online dan terintegrasi.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <span>Bagaimana cara mendaftar dan mengajukan permohonan?</span>
                    <div class="faq-arrow"><i class="bi bi-chevron-down"></i></div>
                </div>
                <div class="faq-answer">
                    <p>Pertama, buat akun di halaman Daftar dengan mengisi data diri dan akademik Anda. Setelah akun aktif, login ke sistem dan navigasi ke menu "Permohonan". Isi formulir yang tersedia, pilih jenis program, dan unggah dokumen persyaratan yang diminta. Setelah dikirim, permohonan akan diproses oleh tim Sekretariat.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <span>Program apa saja yang tersedia di platform ini?</span>
                    <div class="faq-arrow"><i class="bi bi-chevron-down"></i></div>
                </div>
                <div class="faq-answer">
                    <p>Saat ini tersedia 4 jenis program: <strong>Magang/PKL</strong> (untuk mahasiswa dan siswa SMK), <strong>Penelitian</strong> (untuk skripsi, tesis, atau karya ilmiah), <strong>Observasi</strong> (kunjungan lapangan), dan <strong>Uji Coba Produk</strong> (pengujian teknologi atau perangkat lunak).</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <span>Dokumen apa saja yang diperlukan saat mendaftar?</span>
                    <div class="faq-arrow"><i class="bi bi-chevron-down"></i></div>
                </div>
                <div class="faq-answer">
                    <p>Dokumen yang umumnya dibutuhkan meliputi: Surat Pengantar dari Institusi, Proposal Kegiatan (untuk penelitian), KTP/Kartu Pelajar/KTM, dan CV. Persyaratan detail dapat berbeda tergantung jenis program yang dipilih dan akan ditampilkan secara lengkap di formulir pengajuan.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <span>Berapa lama proses verifikasi permohonan berlangsung?</span>
                    <div class="faq-arrow"><i class="bi bi-chevron-down"></i></div>
                </div>
                <div class="faq-answer">
                    <p>Proses verifikasi berkas oleh Sekretariat umumnya berlangsung dalam 3-5 hari kerja. Anda dapat memantau status permohonan secara real-time melalui menu "Status Permohonan" di dashboard akun Anda. Notifikasi perubahan status juga akan ditampilkan di sistem.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <span>Bagaimana cara mendapatkan sertifikat setelah selesai?</span>
                    <div class="faq-arrow"><i class="bi bi-chevron-down"></i></div>
                </div>
                <div class="faq-answer">
                    <p>Setelah program selesai dan penilaian telah dilakukan oleh Kepala Bidang, sertifikat akan otomatis tersedia di dashboard Anda. Anda cukup mengakses menu "Sertifikat" dan mengklik tombol unduh. Tidak perlu datang ke kantor secara langsung.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== CTA ===== -->
<section class="lp-cta" id="kontak">
    <div class="lp-container">
        <div class="cta-box">
            <h2>Siap Memulai Program Anda?</h2>
            <p>Daftarkan diri Anda sekarang dan mulai perjalanan akademik bersama Dinas Kominfo Kota Tangerang. Gratis, mudah, dan 100% online.</p>
            <div class="cta-btns">
                <a href="<?= base_url('register') ?>" class="btn-hero-primary" style="font-size: 1rem; padding: 14px 36px;">
                    <i class="bi bi-person-plus-fill me-2"></i>Buat Akun Gratis
                </a>
                <a href="<?= base_url('login') ?>" class="btn-hero-secondary" style="font-size: 1rem; padding: 14px 36px;">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke Sistem
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ===== FOOTER ===== -->
<footer class="lp-footer">
    <div class="lp-container">
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="lp-brand" style="text-decoration:none; display:flex; align-items:center; gap:10px; margin-bottom:16px;">
                    <div class="lp-brand-icon"><i class="bi bi-building-fill-gear"></i></div>
                    <div>
                        <div class="lp-brand-name">E-Layanan Akademik</div>
                        <div class="lp-brand-sub">Dinas Kominfo Kota Tangerang</div>
                    </div>
                </div>
                <p class="footer-desc">
                    Platform digital resmi untuk pengelolaan permohonan akademik di Dinas Komunikasi dan Informatika Kota Tangerang. Transparan, cepat, dan terintegrasi.
                </p>
                <div class="footer-social">
                    <a href="#" class="social-btn"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="social-btn"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="social-btn"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-btn"><i class="bi bi-youtube"></i></a>
                </div>
            </div>

            <div class="footer-col">
                <h4>Navigasi</h4>
                <ul>
                    <li><a href="#tentang">Tentang Platform</a></li>
                    <li><a href="#program">Program Pilihan</a></li>
                    <li><a href="#alur">Alur Pendaftaran</a></li>
                    <li><a href="#faq">FAQ</a></li>
                </ul>
            </div>



            <div class="footer-col footer-contact">
                <h4>Kontak</h4>
                <p><i class="bi bi-geo-alt-fill"></i> Jl. Satria Sudirman No.1, Kota Tangerang, Banten 15111</p>
                <p><i class="bi bi-envelope-fill"></i> kominfo@tangerangkota.go.id</p>
                <p><i class="bi bi-telephone-fill"></i> (021) 5588 - 3555</p>
                <p><i class="bi bi-clock-fill"></i> Senin – Jumat, 08.00 – 16.00 WIB</p>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> Dinas Komunikasi dan Informatika Kota Tangerang. Hak Cipta Dilindungi.</p>
            <p>Dikembangkan dengan <i class="bi bi-heart-fill" style="color:var(--gold);"></i> untuk pelayanan publik yang lebih baik.</p>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ===== Navbar Scroll Effect =====
window.addEventListener('scroll', function() {
    const navbar = document.getElementById('lp-navbar');
    if (window.scrollY > 30) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// ===== Smooth Anchor Scrolling =====
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            const offset = 80;
            const top = target.getBoundingClientRect().top + window.pageYOffset - offset;
            window.scrollTo({ top, behavior: 'smooth' });
        }
    });
});

// ===== Program Tabs =====
function switchTab(btn, tabId) {
    // deactivate all tabs & buttons
    document.querySelectorAll('.prog-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.program-cards').forEach(c => c.classList.add('d-none'));
    // activate selected
    btn.classList.add('active');
    
    const targetTab = document.getElementById('tab-' + tabId);
    targetTab.classList.remove('d-none');
    
    // Fix untuk animasi scroll reveal agar elemen yang baru muncul langsung terlihat
    targetTab.querySelectorAll('.prog-card').forEach(el => {
        el.style.opacity = '1';
        el.style.transform = 'translateY(0)';
    });
}

// ===== FAQ Accordion =====
function toggleFaq(questionEl) {
    const item = questionEl.closest('.faq-item');
    const isOpen = item.classList.contains('open');
    // close all
    document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
    // open clicked (if wasn't open)
    if (!isOpen) {
        item.classList.add('open');
    }
}

// ===== Scroll Reveal Animation =====
const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
const revealObserver = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Apply to cards and alur items
document.querySelectorAll('.prog-card, .keung-card, .alur-item, .visual-card, .faq-item').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
    revealObserver.observe(el);
});
</script>
</body>
</html>
