<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <title>Masuk - Portal E-Layanan Akademik</title>
    <meta name="description" content="Login Portal E-Layanan Permohonan Akademik Dinas Kominfo Kota Tangerang">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <style>
        :root {
            --navy:       #10367D;
            --navy-dark:  #0a2456;
            --gold:       #B58E4A;
            --gold-hover: #9a7a3e;
            --gold-light: #d4aa6a;
            --accent:     #A5CEE0;
            --bg-form:    #F5F0EB;
            --text-dark:  #1A1A2E;
            --text-muted: #6B7280;
            --white:      #FFFFFF;
            --border:     #DDD6CC;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
            overflow: hidden;
        }

        /* === CUSTOM SCROLLBAR (referensi Smart DPR) === */
        .panel-form::-webkit-scrollbar {
            width: 7px;
        }
        .panel-form::-webkit-scrollbar-track {
            background: #DDD6CC;
            border-radius: 10px;
        }
        .panel-form::-webkit-scrollbar-thumb {
            background: #888078;
            border-radius: 10px;
        }
        .panel-form::-webkit-scrollbar-thumb:hover {
            background: #6b6360;
        }
        /* Firefox */
        .panel-form {
            scrollbar-width: thin;
            scrollbar-color: #888078 #DDD6CC;
        }

        /* === SPLIT WRAPPER === */
        .split-wrapper {
            display: flex;
            height: 100vh;
        }

        /* === PANEL KIRI: FORM === */
        .panel-form {
            width: 100%;
            background: var(--bg-form);
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 1.5rem 2rem;
            overflow-y: auto;
        }

        @media (min-width: 992px) {
            .panel-form {
                width: 40%;
                min-width: 400px;
                max-width: 480px;
                padding: 1.5rem 2.5rem;
                align-items: center;
            }
        }

        .form-container {
            width: 100%;
            max-width: 340px;
        }

        /* Brand */
        .brand-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 1.25rem;
        }

        .brand-logo {
            width: 36px;
            height: 36px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .brand-name {
            font-size: 0.85rem;
            font-weight: 800;
            color: var(--navy);
            line-height: 1.15;
        }

        .brand-sub {
            font-size: 0.6rem;
            color: var(--text-muted);
            font-weight: 600;
            letter-spacing: 0.2px;
            text-transform: uppercase;
        }

        /* Badge */
        .badge-portal {
            display: inline-block;
            background: #059669;
            color: var(--white);
            font-size: 0.58rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 3px 10px;
            border-radius: 4px;
            margin-bottom: 0.6rem;
        }

        /* Heading */
        .form-title {
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--text-dark);
            letter-spacing: -0.4px;
            margin-bottom: 3px;
        }

        .form-desc {
            font-size: 0.74rem;
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 0.75rem;
        }

        /* Action Buttons (Beranda & Pegawai) */
        .action-links {
            margin-top: 1.5rem;
            padding-top: 1.25rem;
            border-top: 1px solid var(--border);
        }
        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 16px;
            font-size: 0.8rem;
            font-weight: 700;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.25s ease;
            width: 100%;
        }
        .btn-action-beranda {
            background-color: var(--bg-form);
            color: var(--text-dark);
            border: 1.5px solid var(--border);
        }
        .btn-action-beranda:hover {
            background-color: var(--white);
            border-color: #cbd5e1;
            color: var(--text-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.04);
        }
        .btn-action-pegawai {
            background-color: rgba(16, 54, 125, 0.05);
            color: var(--navy);
            border: 1.5px solid rgba(16, 54, 125, 0.15);
        }
        .btn-action-pegawai:hover {
            background-color: var(--navy);
            color: var(--white);
            border-color: var(--navy);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(16, 54, 125, 0.2);
        }

        /* Labels */
        .auth-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        /* Input */
        .auth-input {
            width: 100%;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: 9px 12px;
            font-size: 0.82rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-dark);
            background: var(--white);
            transition: all 0.2s;
            outline: none;
        }

        .auth-input::placeholder { color: #b5afa6; }

        .auth-input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(181, 142, 74, 0.1);
        }

        /* Password wrap */
        .input-pw-wrap { position: relative; }
        .input-pw-wrap .auth-input { padding-right: 40px; }

        .pw-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: none;
            color: var(--text-muted);
            font-size: 0.95rem;
            cursor: pointer;
            padding: 0;
        }

        .pw-toggle:hover { color: var(--navy); }

        /* Options row */
        .options-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .check-label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.75rem;
            color: var(--text-muted);
            cursor: pointer;
        }

        .check-label input[type="checkbox"] {
            width: 14px;
            height: 14px;
            accent-color: var(--navy);
        }

        .forgot-link {
            font-size: 0.75rem;
            color: var(--gold);
            font-weight: 700;
            text-decoration: none;
        }

        .forgot-link:hover { text-decoration: underline; }

        /* reCAPTCHA */
        .recaptcha-box { margin-bottom: 1rem; overflow: hidden; }
        .recaptcha-box .g-recaptcha {
            transform: scale(0.82);
            transform-origin: left top;
        }

        /* Button Masuk */
        .btn-masuk {
            width: 100%;
            padding: 10px;
            background: var(--gold);
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(181, 142, 74, 0.3);
        }

        .btn-masuk:hover {
            background: var(--gold-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(181, 142, 74, 0.4);
        }

        /* Footer */
        .auth-footer {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .auth-footer a {
            color: var(--navy);
            font-weight: 700;
            text-decoration: none;
        }

        .auth-footer a:hover { text-decoration: underline; }



        /* Alerts */
        .auth-alert {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 0.78rem;
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .auth-alert.success { background: #f0fdf4; color: #15803d; }
        .auth-alert.error { background: #fef2f2; color: #dc2626; }

        .form-group { margin-bottom: 0.7rem; }

        /* === PANEL KANAN: HERO === */
        .panel-hero {
            display: none;
            flex: 1;
            position: relative;
            overflow: hidden;
        }

        @media (min-width: 992px) {
            .panel-hero {
                display: flex;
                align-items: flex-end;
            }
        }

        /* Foto Gedung Puspem Kota Tangerang */
        .panel-hero-bg {
            position: absolute;
            inset: 0;
            background-image: url('<?= base_url("images/gedung puspem landing page.png") ?>');
            background-size: cover;
            background-position: center;
            filter: grayscale(30%) brightness(0.4);
        }

        /* Dark shadow overlay (tanpa biru) */
        .panel-hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                170deg,
                rgba(0, 0, 0, 0.55) 0%,
                rgba(0, 0, 0, 0.4) 50%,
                rgba(0, 0, 0, 0.65) 100%
            );
        }

        .hero-content {
            position: relative;
            z-index: 2;
            padding: 3.5rem 4rem;
            max-width: 600px;
        }

        .hero-bar {
            width: 45px;
            height: 3.5px;
            background: var(--white);
            border-radius: 2px;
            margin-bottom: 1.5rem;
        }

        .hero-title {
            font-size: clamp(1.8rem, 2.8vw, 2.5rem);
            font-weight: 800;
            color: var(--white);
            line-height: 1.2;
            letter-spacing: -0.5px;
            margin-bottom: 1rem;
        }

        .hero-subtitle {
            font-size: 0.88rem;
            color: rgba(255, 255, 255, 0.68);
            line-height: 1.7;
            max-width: 480px;
        }

        /* Mobile */
        @media (max-width: 991px) {
            .split-wrapper { background: var(--bg-form); }
        }
    </style>
</head>
<body>

<div class="split-wrapper">

    <!-- KIRI: FORM -->
    <div class="panel-form">
        <div class="form-container">

            <!-- Brand: Logo Kota Tangerang -->
            <div class="brand-row">
                <img src="<?= base_url('images/kota tng_nobg.png') ?>" alt="Logo Kota Tangerang" class="brand-logo" onerror="this.style.display='none'">
                <div>
                    <div class="brand-name">E-LAYANAN</div>
                    <div class="brand-sub">Dinkominfo Kota Tangerang</div>
                </div>
            </div>

            <div class="badge-portal">PORTAL PESERTA</div>

            <h1 class="form-title">Masuk Akun</h1>
            <p class="form-desc">Silakan gunakan Username dan password terdaftar Anda untuk mengakses portal.</p>

            <?php if(session()->getFlashdata('success')): ?>
                <div class="auth-alert success">
                    <i class="bi bi-check-circle-fill flex-shrink-0"></i>
                    <div><?= session()->getFlashdata('success') ?></div>
                </div>
            <?php endif; ?>

            <?php if(session()->getFlashdata('error')): ?>
                <div class="auth-alert error">
                    <i class="bi bi-exclamation-triangle-fill flex-shrink-0"></i>
                    <div><?= session()->getFlashdata('error') ?></div>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('login/process') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label class="auth-label">Username</label>
                    <input type="text" name="username" class="auth-input" placeholder="Masukkan Username terdaftar" required autocomplete="username">
                </div>

                <div class="form-group">
                    <label class="auth-label">Password</label>
                    <div class="input-pw-wrap">
                        <input type="password" id="password" name="password" class="auth-input" placeholder="Masukkan kata sandi" required autocomplete="current-password">
                        <button type="button" class="pw-toggle" onclick="togglePassword()" aria-label="Toggle password">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="options-row">
                    <label class="check-label">
                        <input type="checkbox" id="rememberMe"> Ingat Saya
                    </label>
                    <a href="#" class="forgot-link">Lupa password?</a>
                </div>

                <div class="recaptcha-box">
                    <div class="g-recaptcha" data-sitekey="<?= getenv('RECAPTCHA_SITE_KEY') ?>"></div>
                </div>

                <button type="submit" class="btn-masuk">Masuk Sekarang</button>
            </form>

            <div class="auth-footer">
                Belum punya akun? <a href="<?= base_url('register') ?>">Daftar Sekarang</a>
            </div>

            <div class="action-links d-flex flex-column flex-sm-row gap-2">
                <a href="<?= base_url('landing') ?>" class="btn-action btn-action-beranda">
                    <i class="bi bi-house-door-fill me-2 fs-6"></i> Kembali ke Beranda
                </a>
                <a href="<?= base_url('pegawai/login') ?>" class="btn-action btn-action-pegawai">
                    <i class="bi bi-person-badge-fill me-2 fs-6"></i> Portal Pegawai
                </a>
            </div>

        </div>
    </div>

    <!-- KANAN: HERO -->
    <div class="panel-hero">
        <div class="panel-hero-bg"></div>
        <div class="panel-hero-overlay"></div>
        <div class="hero-content">
            <div class="hero-bar"></div>
            <h2 class="hero-title">Membangun Kompetensi<br>Untuk Negeri.</h2>
            <p class="hero-subtitle">Jadilah bagian dari perjalanan kemajuan tata kelola teknologi informasi Indonesia melalui program magang yang berintegritas dan profesional di Dinas Kominfo Kota Tangerang.</p>
        </div>
    </div>

</div>

<script>
function togglePassword() {
    const p = document.getElementById('password');
    const i = document.getElementById('eyeIcon');
    if (p.type === 'password') { p.type = 'text'; i.classList.replace('bi-eye', 'bi-eye-slash'); }
    else { p.type = 'password'; i.classList.replace('bi-eye-slash', 'bi-eye'); }
}
</script>

</body>
</html>