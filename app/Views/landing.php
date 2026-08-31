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

    <button class="lp-mobile-toggle" id="lp-mobile-toggle" aria-label="Toggle navigation">
        <i class="bi bi-list"></i>
    </button>

    <div class="lp-nav-menu" id="lp-nav-menu">
        <div class="lp-nav-links">
            <a href="#beranda">Beranda</a>
            <a href="#program">Program Kami</a>
            <a href="#alur">Panduan</a>
            <a href="#faq">FAQ</a>
        </div>

        <div class="lp-nav-actions">
            <a href="<?= base_url('register') ?>" class="btn-lp-outline">Daftar Akun</a>
            <a href="<?= base_url('login') ?>" class="btn-lp-solid"><i class="bi bi-box-arrow-in-right me-1"></i> Masuk</a>
        </div>
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
                Akses Akademik<br>
                <span>Kota Tangerang</span>
            </h1>
            <p>
                Portal terpadu untuk pengajuan permohonan 
                <strong style="color: white; font-weight: 700;">Magang, PKL, Penelitian, Observasi, dan Uji Coba Produk</strong> 
                di lingkungan Dinas Kominfo Kota Tangerang. Nikmati kemudahan pendaftaran yang cepat, transparan, dan sepenuhnya digital.
            </p>
            <div class="lp-hero-cta">
                <a href="<?= base_url('register') ?>" class="btn-hero-primary">
                    <i class="bi bi-pencil-square me-2"></i>Daftar Sekarang
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ===== TENTANG PLATFORM ===== -->
<section class="lp-about" id="tentang">
    <div class="lp-container">
        <div class="about-grid">
            <div class="about-text">
                <div class="section-badge" style="margin-bottom: 12px;"><i class="bi bi-info-circle-fill"></i> TENTANG PLATFORM</div>
                <h2 class="section-title" style="margin-bottom: 24px; font-size: 2.6rem; line-height: 1.25; letter-spacing: -1px;">
                    <span style="background: linear-gradient(135deg, var(--navy), #3b82f6); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Transformasi Digital</span><br>Layanan Akademik
                </h2>
                <p style="font-size: 1.1rem; line-height: 1.7; color: #4b5563; margin-bottom: 36px; padding-right: 20px;">
                    <strong>E-Layanan Akademik</strong> adalah ekosistem digital resmi dari <strong>Dinas Komunikasi dan Informatika Kota Tangerang</strong>. Kami hadir untuk memfasilitasi mahasiswa dan pelajar dalam mengembangkan kompetensi, mengelola administrasi magang secara transparan, serta berkolaborasi langsung dalam lingkungan kerja pemerintahan.
                </p>
                <div class="about-features-grid">
                    <div class="feature-item">
                        <div class="fi-icon"><i class="bi bi-file-earmark-check-fill"></i></div>
                        <span>Pendaftaran Online</span>
                    </div>
                    <div class="feature-item">
                        <div class="fi-icon"><i class="bi bi-activity"></i></div>
                        <span>Pantau Real-Time</span>
                    </div>
                    <div class="feature-item">
                        <div class="fi-icon"><i class="bi bi-journal-text"></i></div>
                        <span>Logbook Digital</span>
                    </div>
                    <div class="feature-item">
                        <div class="fi-icon"><i class="bi bi-award-fill"></i></div>
                        <span>E-Sertifikat Otomatis</span>
                    </div>
                </div>
                
                <a href="#alur" class="about-cta-link mt-4 d-inline-block" style="margin-top: 1.5rem;">
                    Lihat panduan langkah demi langkah <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="about-visual-image">
                <div class="img-wrapper">
                    <img src="<?= base_url('images/gedung puspem landing page.png') ?>" alt="Gedung Puspem" class="about-img">
                    <div class="img-overlay-card">
                        <div class="overlay-icon"><i class="bi bi-shield-check"></i></div>
                        <div class="overlay-text">
                            <strong>Resmi & Terintegrasi</strong>
                            <span>Dinas Kominfo Tangerang</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== KEUNTUNGAN MAGANG ===== -->
<section class="lp-benefit" id="keuntungan">
    <div class="lp-container">
        
        <div class="benefit-header-center">
            <div class="section-badge"><i class="bi bi-stars"></i> KEUNTUNGAN BERGABUNG</div>
            <h2 class="section-title text-navy" style="margin-top: 16px;">
                Apa yang Akan Kamu Dapatkan?
            </h2>
            <p class="section-sub text-muted" style="margin: 16px auto 40px; color: var(--text-muted);">
                Lebih dari sekadar magang — ini adalah <strong style="color:var(--navy);">pengalaman nyata</strong> yang membentuk karier dan karakter kamu di dunia profesional.
            </p>
        </div>

        <div class="benefit-grid-4">
            <div class="benefit-item-flat">
                <div class="benefit-icon-flat"><i class="bi bi-building-fill"></i></div>
                <h3>Pengalaman Kerja Pemerintahan</h3>
                <p>Rasakan langsung dinamika kerja instansi pemerintah dari koordinasi hingga pengelolaan sistem.</p>
            </div>
            <div class="benefit-item-flat">
                <div class="benefit-icon-flat"><i class="bi bi-laptop-fill"></i></div>
                <h3>Kompetensi Teknologi Informasi</h3>
                <p>Terlibat dalam proyek digitalisasi layanan publik Kota Tangerang di bidang infrastruktur digital.</p>
            </div>
            <div class="benefit-item-flat">
                <div class="benefit-icon-flat"><i class="bi bi-patch-check-fill"></i></div>
                <h3>Sertifikat Resmi Pemerintah</h3>
                <p>Sertifikat magang dari Dinas Kominfo yang diakui dan bernilai tinggi di dunia profesional.</p>
            </div>
            <div class="benefit-item-flat">
                <div class="benefit-icon-flat"><i class="bi bi-people-fill"></i></div>
                <h3>Jaringan & Relasi Profesional</h3>
                <p>Bangun koneksi berharga dengan ASN, mitra instansi, dan sesama peserta magang.</p>
            </div>
        </div>



    </div>
</section>

<!-- ===== PROGRAM PILIHAN ===== -->
<section class="lp-program" id="program">
    <div class="lp-container">
        <div class="program-header">
            <div class="section-badge"><i class="bi bi-grid-fill"></i> PROGRAM KAMI</div>
            <h2 class="section-title">Program Pilihan</h2>
            <p class="section-sub" style="margin: 10px auto 0;">Pilih kategori yang sesuai dengan kebutuhan akademik dan kualifikasi Anda</p>
        </div>

        <div class="program-tabs">
            <button class="prog-tab active" onclick="switchTab(this, 'magang')">Magang</button>
            <button class="prog-tab" onclick="switchTab(this, 'pkl')">PKL</button>
            <button class="prog-tab" onclick="switchTab(this, 'penelitian')">Penelitian</button>
            <button class="prog-tab" onclick="switchTab(this, 'observasi')">Observasi</button>
            <button class="prog-tab" onclick="switchTab(this, 'uji')">Uji Coba Produk</button>
        </div>

        <!-- Tab Magang -->
        <div class="program-cards" id="tab-magang">
            <div class="prog-card">
                <div class="prog-card-icon"><i class="bi bi-pencil-square"></i></div>
                <h3>Pendaftaran Magang</h3>
                <p>Isi formulir permohonan magang secara online dan unggah dokumen persyaratan seperti surat pengantar, proposal, dan KTP.</p>
            </div>
            <div class="prog-card">
                <div class="prog-card-icon"><i class="bi bi-briefcase-fill"></i></div>
                <h3>Pelaksanaan Magang</h3>
                <p>Informasi detail penempatan unit kerja, jadwal masuk, tata tertib selama bertugas, dan pembimbing lapangan yang ditunjuk.</p>
            </div>
            <div class="prog-card">
                <div class="prog-card-icon"><i class="bi bi-mortarboard-fill"></i></div>
                <h3>Penyelesaian Magang</h3>
                <p>Prosedur penilaian, pengisian logbook, pengumpulan laporan akhir, dan pengunduhan sertifikat magang secara digital.</p>
            </div>
        </div>
        <!-- Tab PKL -->
        <div class="program-cards d-none" id="tab-pkl">
            <div class="prog-card">
                <div class="prog-card-icon"><i class="bi bi-pencil-square"></i></div>
                <h3>Pendaftaran PKL</h3>
                <p>Isi formulir permohonan PKL (Praktik Kerja Lapangan) secara online dan unggah dokumen persyaratan dari sekolah/kampus.</p>
            </div>
            <div class="prog-card">
                <div class="prog-card-icon"><i class="bi bi-briefcase-fill"></i></div>
                <h3>Pelaksanaan PKL</h3>
                <p>Penempatan unit kerja sesuai penjurusan, dengan bimbingan langsung dari praktisi di lingkungan Dinas Kominfo.</p>
            </div>
            <div class="prog-card">
                <div class="prog-card-icon"><i class="bi bi-mortarboard-fill"></i></div>
                <h3>Penyelesaian PKL</h3>
                <p>Evaluasi kinerja, penyerahan laporan akhir PKL, dan penerbitan sertifikat resmi untuk kebutuhan akademik.</p>
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
            <div class="section-badge"><i class="bi bi-signpost-split-fill"></i> ALUR PENDAFTARAN</div>
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
                    <p>Tim verifikator kami akan melakukan pemeriksaan kelengkapan berkas dan kelayakan permohonan Anda.</p>
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

<!-- ===== FAQ ===== -->
<section class="lp-faq" id="faq">
    <div class="lp-container">

        <!-- Header tengah -->
        <div class="faq-top-header">
            <div class="faq-top-badge">
                <i class="bi bi-patch-question-fill"></i>
                <span>FAQ</span>
            </div>
            <h2 class="faq-top-title">Pertanyaan yang <span>Sering Ditanyakan</span></h2>
            <p class="faq-top-sub">Temukan jawaban atas pertanyaan umum seputar program magang di Dinas Kominfo Kota Tangerang</p>
        </div>

        <div class="faq-split">

            <!-- Kiri: Gambar Ilustrasi Besar -->
            <div class="faq-split-left">
                <img src="<?= base_url('images/faq_illustration.png') ?>" alt="FAQ Illustration" class="faq-split-img">
            </div>

            <!-- Kanan: Judul + Accordion -->
            <div class="faq-split-right">
                <div class="faq-accordion" id="faqList">
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>Bagaimana cara mendaftar dan mengajukan permohonan?</span>
                            <div class="faq-arrow"><i class="bi bi-chevron-down"></i></div>
                        </div>
                        <div class="faq-answer">
                            <p>Buat akun di menu Pendaftaran dengan mengisi data diri. Setelah akun aktif, masuk ke menu "Permohonan", isi formulir, lalu unggah dokumen persyaratan pendukung. Permohonan Anda akan segera diproses oleh tim kami.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>Program apa saja yang tersedia di platform ini?</span>
                            <div class="faq-arrow"><i class="bi bi-chevron-down"></i></div>
                        </div>
                        <div class="faq-answer">
                            <p>Tersedia 5 program: <strong>Magang</strong>, <strong>PKL</strong>, <strong>Penelitian</strong>, <strong>Observasi</strong>, dan <strong>Uji Coba Produk</strong>.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>Dokumen apa saja yang diperlukan saat mendaftar?</span>
                            <div class="faq-arrow"><i class="bi bi-chevron-down"></i></div>
                        </div>
                        <div class="faq-answer">
                            <p>Dokumen utama yang diperlukan adalah Surat Pengantar Resmi dari Sekolah atau Perguruan Tinggi Anda. Khusus untuk permohonan Penelitian, Anda juga diwajibkan untuk menyertakan Proposal Penelitian.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>Berapa lama proses verifikasi permohonan berlangsung?</span>
                            <div class="faq-arrow"><i class="bi bi-chevron-down"></i></div>
                        </div>
                        <div class="faq-answer">
                            <p>Proses verifikasi berkas umumnya membutuhkan waktu 3-5 hari kerja. Anda dapat memantau status perkembangan permohonan secara <em>real-time</em> melalui dashboard akun Anda.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>Bagaimana jika dokumen permohonan saya terdapat kesalahan?</span>
                            <div class="faq-arrow"><i class="bi bi-chevron-down"></i></div>
                        </div>
                        <div class="faq-answer">
                            <p>Sistem akan memperbarui status Anda menjadi <strong>Revisi</strong> dan tim kami akan memberikan catatan perbaikan. Anda dapat memperbaiki dokumen secara langsung pada permohonan tersebut tanpa perlu mendaftar ulang.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>



<!-- ===== FOOTER ===== -->
<footer class="lp-footer" id="kontak">
    <div class="lp-container">
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="lp-brand" style="text-decoration:none; display:flex; align-items:center; gap:10px; margin-bottom:16px;">
                    <img src="<?= base_url('images/kota tng_nobg.png') ?>" alt="Logo Kota Tangerang" style="height: 45px; width: auto;" onerror="this.style.display='none'">
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
                <h4>Tautan Cepat</h4>
                <ul>
                    <li><a href="#tentang">Profil Layanan</a></li>
                    <li><a href="#program">Program Kami</a></li>
                    <li><a href="#alur">Panduan</a></li>
                    <li><a href="#faq">FAQ</a></li>
                </ul>
            </div>

            <div class="footer-col footer-contact">
                <h4>Kontak</h4>
                <div class="fc-item">
                    <i class="bi bi-geo-alt-fill"></i>
                    <div>Jl. Satria Sudirman No.1, Kota Tangerang, Banten 15111</div>
                </div>
                <div class="fc-item">
                    <i class="bi bi-envelope-fill"></i>
                    <div>kominfo@tangerangkota.go.id</div>
                </div>
                <div class="fc-item">
                    <i class="bi bi-telephone-fill"></i>
                    <div>(021) 5588 - 3555</div>
                </div>
                <div class="fc-item">
                    <i class="bi bi-clock-fill"></i>
                    <div>Senin – Jumat, 08.00 – 16.00 WIB</div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> Dinas Komunikasi dan Informatika Kota Tangerang. Hak Cipta Dilindungi.</p>
            <p>Dikembangkan dengan <i class="bi bi-heart-fill" style="color:var(--gold);"></i> untuk pelayanan publik yang lebih baik.</p>
        </div>
    </div>
</footer>

<!-- Scroll to Top -->
<a href="#" class="scroll-top d-flex align-items-center justify-content-center" id="scrollTop">
    <i class="bi bi-arrow-up-short"></i>
</a>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ===== Mobile Navbar Toggle =====
const mobileToggle = document.getElementById('lp-mobile-toggle');
const navMenu = document.getElementById('lp-nav-menu');

mobileToggle.addEventListener('click', function() {
    navMenu.classList.toggle('active');
    const icon = this.querySelector('i');
    if (navMenu.classList.contains('active')) {
        icon.classList.remove('bi-list');
        icon.classList.add('bi-x-lg');
    } else {
        icon.classList.remove('bi-x-lg');
        icon.classList.add('bi-list');
    }
});

// Close menu when link is clicked
document.querySelectorAll('.lp-nav-links a').forEach(link => {
    link.addEventListener('click', () => {
        navMenu.classList.remove('active');
        const icon = mobileToggle.querySelector('i');
        icon.classList.remove('bi-x-lg');
        icon.classList.add('bi-list');
    });
});

// (Navbar scroll effect is handled below in the unified handler)

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
let isTabAnimating = false;

function switchTab(btn, tabId) {
    if (isTabAnimating || btn.classList.contains('active')) return;
    isTabAnimating = true;

    // deactivate all tabs & buttons
    document.querySelectorAll('.prog-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
    
    const activeTab = document.querySelector('.program-cards:not(.d-none)');
    const targetTab = document.getElementById('tab-' + tabId);
    
    // 1. Animasi menghilang (fade out) untuk tab yang sedang aktif
    if (activeTab) {
        const activeCards = activeTab.querySelectorAll('.prog-card');
        activeCards.forEach((el, index) => {
            el.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            el.style.opacity = '0';
            el.style.transform = 'translateY(-15px)'; 
        });

        // Tunggu animasi fade out selesai, lalu sembunyikan dan munculkan tab target
        setTimeout(() => {
            activeTab.classList.add('d-none');
            showNewTab(targetTab);
        }, 300);
    } else {
        showNewTab(targetTab);
    }
}

function showNewTab(targetTab) {
    targetTab.classList.remove('d-none');
    const newCards = targetTab.querySelectorAll('.prog-card');
    
    // Reset state posisi elemen tab baru agar siap dianimasikan
    newCards.forEach(el => {
        el.style.transition = 'none';
        el.style.opacity = '0';
        el.style.transform = 'translateY(25px)';
    });
    
    // Paksa browser membaca DOM ulang (reflow) 
    void targetTab.offsetWidth;
    
    // 2. Animasi muncul berurutan (stagger) untuk tab target
    newCards.forEach((el, index) => {
        setTimeout(() => {
            el.style.transition = 'opacity 0.5s ease, transform 0.5s cubic-bezier(0.25, 0.8, 0.25, 1)';
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        }, index * 120); // Jeda 120ms untuk tiap kartu
    });

    // Buka kunci animasi setelah semua animasi selesai
    setTimeout(() => {
        isTabAnimating = false;
    }, (newCards.length * 120) + 500);
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

// Navbar scroll + active link handled by onPageScroll (see below)

// ===== SCROLL REVEAL ANIMATION SYSTEM =====

const observerOptions = {
    threshold: 0.08,
    rootMargin: '0px 0px -40px 0px'
};

// Helper: apply initial hidden state
function prepareEl(el, translateY = 32, scale = 1, delay = 0) {
    el.style.opacity = '0';
    el.style.transform = `translateY(${translateY}px) scale(${scale})`;
    el.style.transition = `opacity 0.6s ease ${delay}ms, transform 0.6s cubic-bezier(0.215, 0.61, 0.355, 1) ${delay}ms`;
}
function revealEl(el) {
    el.style.opacity = '1';
    el.style.transform = 'translateY(0) scale(1)';
}

const revealObserver = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            revealEl(entry.target);
            revealObserver.unobserve(entry.target);
        }
    });
}, observerOptions);

// 1. Section badges — scale-in from slightly smaller
document.querySelectorAll('.section-badge, .faq-top-badge').forEach(el => {
    prepareEl(el, 10, 0.9, 0);
    revealObserver.observe(el);
});

// 2. Section titles — fade up
document.querySelectorAll('.section-title, .faq-top-title, .alur-header h2').forEach(el => {
    prepareEl(el, 24, 1, 80);
    revealObserver.observe(el);
});

// 3. Section subtitles — fade up slightly later
document.querySelectorAll('.section-sub, .faq-top-sub').forEach(el => {
    prepareEl(el, 20, 1, 160);
    revealObserver.observe(el);
});

// 4. Benefit cards — staggered fade-up
document.querySelectorAll('.benefit-item-flat').forEach((el, i) => {
    prepareEl(el, 40, 1, i * 100);
    revealObserver.observe(el);
});

// 5. Program cards — staggered fade-up
document.querySelectorAll('.prog-card').forEach((el, i) => {
    prepareEl(el, 40, 1, i * 120);
    revealObserver.observe(el);
});

// 6. Alur timeline items — staggered fade-up
document.querySelectorAll('.alur-item').forEach((el, i) => {
    prepareEl(el, 50, 1, i * 120);
    revealObserver.observe(el);
});

// 7. FAQ items — staggered fade-up
document.querySelectorAll('.faq-item').forEach((el, i) => {
    prepareEl(el, 30, 1, i * 80);
    revealObserver.observe(el);
});

// 8. Feature items in "Tentang" — staggered
document.querySelectorAll('.feature-item').forEach((el, i) => {
    prepareEl(el, 20, 1, i * 80);
    revealObserver.observe(el);
});

// 9. About section text block — slide from left
const aboutText = document.querySelector('.about-text');
if (aboutText) {
    aboutText.style.opacity = '0';
    aboutText.style.transform = 'translateX(-30px)';
    aboutText.style.transition = 'opacity 0.7s ease 0ms, transform 0.7s ease 0ms';
    revealObserver.observe(aboutText);
}

// 10. About image — slide from right
const aboutImg = document.querySelector('.about-visual-image');
if (aboutImg) {
    aboutImg.style.opacity = '0';
    aboutImg.style.transform = 'translateX(30px)';
    aboutImg.style.transition = 'opacity 0.7s ease 150ms, transform 0.7s ease 150ms';
    revealObserver.observe(aboutImg);
}

// 11. FAQ illustration — animate the full split row to avoid breaking mix-blend-mode on image
const faqSplit = document.querySelector('.faq-split');
if (faqSplit) {
    faqSplit.style.opacity = '0';
    faqSplit.style.transform = 'translateY(24px)';
    faqSplit.style.transition = 'opacity 0.7s ease, transform 0.7s ease';
    revealObserver.observe(faqSplit);
}

// 12. Footer columns — staggered fade-up
document.querySelectorAll('.footer-brand, .footer-col').forEach((el, i) => {
    prepareEl(el, 30, 1, i * 100);
    revealObserver.observe(el);
});

// 13. Footer contact items — staggered fade-up
document.querySelectorAll('.fc-item').forEach((el, i) => {
    prepareEl(el, 20, 1, i * 80);
    revealObserver.observe(el);
});

// 14. Footer social buttons — staggered scale-in
document.querySelectorAll('.social-btn').forEach((el, i) => {
    prepareEl(el, 10, 0.8, i * 60);
    revealObserver.observe(el);
});


const scrollTop = document.getElementById('scrollTop');
if (scrollTop) {
    const toggleScrollTop = function() {
        window.scrollY > 100 ? scrollTop.classList.add('active') : scrollTop.classList.remove('active');
    }
    window.addEventListener('load', toggleScrollTop);
    document.addEventListener('scroll', toggleScrollTop);
    scrollTop.addEventListener('click', function(e) {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// ===== Unified Scroll Handler: Navbar state + Active link =====
const navlinksAll = document.querySelectorAll('.lp-nav-links a');
const navbarEl = document.getElementById('lp-navbar');

function onPageScroll() {
    const scrollY = window.scrollY;

    // 1. Toggle scrolled class
    if (scrollY > 50) {
        navbarEl.classList.add('scrolled');
    } else {
        navbarEl.classList.remove('scrolled');
    }

    // 2. Active nav link — scan sections from bottom to top
    const navHeight = navbarEl.offsetHeight + 10;
    let activeSectionId = null;

    navlinksAll.forEach(link => {
        if (!link.hash) return;
        const section = document.querySelector(link.hash);
        if (!section) return;
        if (scrollY + navHeight >= section.offsetTop) {
            activeSectionId = link.hash;
        }
    });

    // Default to first link if at very top
    if (scrollY < 80) {
        activeSectionId = navlinksAll[0]?.hash || null;
    }

    navlinksAll.forEach(link => {
        link.classList.toggle('active', link.hash === activeSectionId);
    });
}

window.addEventListener('scroll', onPageScroll, { passive: true });
window.addEventListener('load', onPageScroll);
onPageScroll();

</script>
</body>
</html>
