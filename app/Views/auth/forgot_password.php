<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <title>Lupa Password - Portal E-Layanan Akademik</title>
    <meta name="description" content="Reset password akun Portal E-Layanan Permohonan Akademik Dinas Kominfo Kota Tangerang">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

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

        /* === CUSTOM SCROLLBAR === */
        .panel-form::-webkit-scrollbar { width: 7px; }
        .panel-form::-webkit-scrollbar-track { background: #DDD6CC; border-radius: 10px; }
        .panel-form::-webkit-scrollbar-thumb { background: #888078; border-radius: 10px; }
        .panel-form::-webkit-scrollbar-thumb:hover { background: #6b6360; }
        .panel-form { scrollbar-width: thin; scrollbar-color: #888078 #DDD6CC; }

        /* === SPLIT WRAPPER === */
        .split-wrapper { display: flex; height: 100vh; }

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

        .form-container { width: 100%; max-width: 340px; }

        /* Brand */
        .brand-row { display: flex; align-items: center; gap: 10px; margin-bottom: 1.25rem; }
        .brand-logo { width: 36px; height: 36px; object-fit: contain; }
        .brand-name { font-size: 0.92rem; font-weight: 800; color: var(--navy); letter-spacing: 0.5px; line-height: 1.1; }
        .brand-sub { font-size: 0.62rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; }

        /* Badge */
        .badge-portal {
            display: inline-block;
            background: var(--navy);
            color: var(--white);
            font-size: 0.58rem;
            font-weight: 700;
            padding: 3.5px 9px;
            border-radius: 4px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 0.85rem;
        }

        /* Title */
        .form-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 0.3rem;
            letter-spacing: -0.5px;
        }

        .form-desc {
            font-size: 0.78rem;
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 1rem;
        }

        /* Back Button */
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.72rem;
            color: var(--navy);
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 1rem;
            transition: color 0.2s;
        }
        .btn-back:hover { color: var(--gold); }

        /* Label + Input */
        .auth-label {
            display: block;
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 4px;
            letter-spacing: 0.3px;
        }

        .auth-input {
            width: 100%;
            padding: 10px 12px;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            font-size: 0.82rem;
            font-family: inherit;
            background: var(--white);
            color: var(--text-dark);
            transition: border-color 0.2s;
            outline: none;
        }

        .auth-input:focus { border-color: var(--navy); }
        .auth-input::placeholder { color: #b0a89d; }

        /* Buttons */
        .btn-submit {
            width: 100%;
            padding: 11px 0;
            background: var(--gold);
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            letter-spacing: 0.3px;
            transition: background 0.2s, transform 0.15s;
            margin-top: 0.5rem;
        }

        .btn-submit:hover { background: var(--gold-hover); transform: translateY(-1px); }
        .btn-submit:active { transform: translateY(0); }

        .btn-back-login {
            display: block;
            text-align: center;
            margin-top: 1rem;
            font-size: 0.78rem;
            color: var(--text-muted);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }
        .btn-back-login:hover { color: var(--navy); }

        /* Alerts */
        .auth-alert {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 0.78rem;
            font-weight: 500;
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .auth-alert.success { background: #f0fdf4; color: #15803d; }
        .auth-alert.error { background: #fef2f2; color: #dc2626; }
        .auth-alert.info { background: #eff6ff; color: #1d4ed8; }

        .form-group { margin-bottom: 0.7rem; }

        /* Ikon Email (Dihapus karena diganti dengan desain card) */

        /* === METODE RESET CARD === */
        .method-label {
            display: block;
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
            margin-top: 1.25rem;
        }

        .method-card {
            border: 1.5px solid var(--gold);
            background: #FCFAf5; /* Subtle gold tint */
            border-radius: 8px;
            padding: 14px 16px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 1rem;
        }

        .method-icon {
            font-size: 1.25rem;
            color: var(--gold);
            margin-top: 2px;
        }

        .method-text .title {
            font-weight: 700;
            font-size: 0.82rem;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .method-text .desc {
            font-size: 0.72rem;
            color: var(--text-muted);
            line-height: 1.45;
        }

        /* reCAPTCHA */
        .recaptcha-box { margin-bottom: 1rem; margin-top: 1.25rem; overflow: hidden; }
        .recaptcha-box .g-recaptcha {
            transform: scale(0.85);
            transform-origin: left top;
        }

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

        .panel-hero-bg {
            position: absolute;
            inset: 0;
            background-image: url('<?= base_url("images/gedung puspem landing page.png") ?>');
            background-size: cover;
            background-position: center;
            filter: grayscale(15%) brightness(0.75);
        }

        .panel-hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(170deg, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.25) 50%, rgba(0,0,0,0.5) 100%);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            padding: 3.5rem 4rem;
            max-width: 600px;
        }

        .hero-bar { width: 45px; height: 3.5px; background: var(--white); border-radius: 2px; margin-bottom: 1.5rem; }
        .hero-title { font-size: clamp(1.8rem, 2.8vw, 2.5rem); font-weight: 800; color: var(--white); line-height: 1.2; letter-spacing: -0.5px; margin-bottom: 1rem; }
        .hero-subtitle { font-size: 0.88rem; color: rgba(255,255,255,0.68); line-height: 1.7; max-width: 480px; }

        @media (max-width: 991px) {
            .split-wrapper { background: var(--bg-form); }
        }
    </style>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>

<div class="split-wrapper">

    <!-- KIRI: FORM -->
    <div class="panel-form">
        <div class="form-container">

            <!-- Brand -->
            <div class="brand-row">
                <img src="<?= base_url('images/kota tng_nobg.png') ?>" alt="Logo Kota Tangerang" class="brand-logo" onerror="this.style.display='none'">
                <div>
                    <div class="brand-name">E-LAYANAN</div>
                    <div class="brand-sub">Dinkominfo Kota Tangerang</div>
                </div>
            </div>

            <div class="badge-portal">PORTAL PESERTA</div>

            <h1 class="form-title">Lupa Password</h1>
            <p class="form-desc">Masukkan email yang terdaftar. Kami akan mengirimkan tautan untuk membuat password baru akun Anda.</p>

            <!-- Alerts -->
            <?php if(session()->getFlashdata('info')): ?>
                <div class="auth-alert info">
                    <i class="bi bi-info-circle-fill flex-shrink-0" style="margin-top: 2px;"></i>
                    <div><?= session()->getFlashdata('info') ?></div>
                </div>
            <?php endif; ?>

            <?php if(session()->getFlashdata('error')): ?>
                <div class="auth-alert error">
                    <i class="bi bi-exclamation-triangle-fill flex-shrink-0" style="margin-top: 2px;"></i>
                    <div><?= session()->getFlashdata('error') ?></div>
                </div>
            <?php endif; ?>

            <?php if(session()->getFlashdata('errors')): ?>
                <div class="auth-alert error">
                    <i class="bi bi-exclamation-triangle-fill flex-shrink-0" style="margin-top: 2px;"></i>
                    <div>
                        <?php foreach(session()->getFlashdata('errors') as $err): ?>
                            <?= esc($err) ?><br>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('forgot-password/process') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label class="auth-label">Email terdaftar</label>
                    <input type="email" name="email" class="auth-input" placeholder="Masukkan alamat email Anda" required autocomplete="email" value="<?= old('email') ?>">
                </div>

                <!-- Metode Reset Card -->
                <div class="method-label">Metode Atur Ulang Password</div>
                <div class="method-card">
                    <div class="method-icon"><i class="bi bi-envelope-check"></i></div>
                    <div class="method-text">
                        <div class="title">Kirim link ke email</div>
                        <div class="desc">Kami akan mengirimkan link aman ke kotak masuk Anda. Tautan ini hanya berlaku selama 1 jam.</div>
                    </div>
                </div>

                <!-- reCAPTCHA -->
                <div class="recaptcha-box">
                    <div class="g-recaptcha" data-sitekey="<?= getenv('RECAPTCHA_SITE_KEY') ?>"></div>
                </div>

                <button type="submit" class="btn-submit">
                    Kirim link ke email
                </button>
            </form>

            <a href="<?= base_url('login') ?>" class="btn-back-login">
                Kembali ke halaman login
            </a>
        </div>
    </div>

    <!-- KANAN: HERO -->
    <div class="panel-hero">
        <div class="panel-hero-bg"></div>
        <div class="panel-hero-overlay"></div>
        <div class="hero-content">
            <div class="hero-bar"></div>
            <h2 class="hero-title">Jangan Khawatir,<br>Kami Bantu Anda.</h2>
            <p class="hero-subtitle">Lupa password adalah hal yang wajar. Cukup masukkan alamat email Anda dan kami akan mengirimkan panduan untuk membuat password baru dalam hitungan menit.</p>
        </div>
    </div>

</div>

</body>
</html>
