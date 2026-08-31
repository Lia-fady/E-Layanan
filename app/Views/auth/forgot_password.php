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
            --primary:    #10367D;
            --primary-hover: #0a2456;
            --primary-light: #A5CEE0;
            --accent:     #A5CEE0;
            --bg-form:    #F8F9FA;
            --text-dark:  #1A1A2E;
            --text-muted: #6B7280;
            --white:      #FFFFFF;
            --border:     #E5E7EB;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
            background: var(--bg-form);
        }

        /* === CENTERED WRAPPER === */
        .auth-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem 1rem;
        }

        .auth-card {
            background: var(--white);
            border-radius: 12px;
            padding: 2.5rem 2.5rem;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            border: 1px solid rgba(0,0,0,0.04);
        }

        .form-container { width: 100%; }

        /* Brand (Optional, bisa disembunyikan atau ditampilkan di atas) */
        .brand-row { display: flex; align-items: center; gap: 10px; margin-bottom: 1.5rem; justify-content: center; }
        .brand-logo { width: 40px; height: 40px; object-fit: contain; }
        .brand-name { font-size: 1rem; font-weight: 800; color: var(--navy); letter-spacing: 0.5px; line-height: 1.1; }
        .brand-sub { font-size: 0.65rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; }

        /* Title */
        .form-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 0.3rem;
            letter-spacing: -0.5px;
        }

        .form-desc {
            font-size: 0.8rem;
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 1.5rem;
        }

        /* Label + Input */
        .auth-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 6px;
            letter-spacing: 0.2px;
        }

        .auth-input {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            font-size: 0.85rem;
            font-family: inherit;
            background: var(--white);
            color: var(--text-dark);
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }

        .auth-input:focus { 
            border-color: var(--primary); 
            box-shadow: 0 0 0 3px rgba(16, 54, 125, 0.15);
        }
        .auth-input::placeholder { color: #9ca3af; }

        /* Buttons */
        .btn-submit {
            width: 100%;
            padding: 12px 0;
            background: var(--gold);
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-size: 0.85rem;
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
            margin-top: 1.5rem;
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 500;
            text-decoration: none;
            transition: color 0.2s;
        }
        .btn-back-login:hover { color: var(--navy); text-decoration: underline; }

        /* Alerts */
        .auth-alert {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 1.25rem;
            line-height: 1.5;
        }

        .auth-alert.success { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
        .auth-alert.error { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .auth-alert.info { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }

        .form-group { margin-bottom: 1rem; }

        /* === METODE RESET CARD === */
        .method-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 8px;
            margin-top: 1.5rem;
        }

        .method-card {
            border: 1.5px solid var(--primary);
            background: #f4f7fc; /* Subtle navy tint */
            border-radius: 8px;
            padding: 14px 16px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 1.25rem;
        }

        .method-icon {
            font-size: 1.25rem;
            color: var(--gold);
            margin-top: 2px;
        }

        .method-text .title {
            font-weight: 700;
            font-size: 0.85rem;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .method-text .desc {
            font-size: 0.75rem;
            color: var(--text-muted);
            line-height: 1.45;
        }

        /* Aplikasi Authenticator Card (Inactive example) */
        .method-card.inactive {
            border: 1px solid var(--border);
            background: var(--white);
            margin-bottom: 1.25rem;
            opacity: 0.7;
        }
        .method-card.inactive .method-icon {
            color: var(--text-muted);
        }

        /* reCAPTCHA */
        .recaptcha-box { margin-bottom: 1.5rem; display: flex; }
        
        @media (max-width: 480px) {
            .auth-card { padding: 2rem 1.5rem; }
            .recaptcha-box .g-recaptcha {
                transform: scale(0.85);
                transform-origin: left top;
            }
        }
    </style>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="form-container">

            <!-- <div class="brand-row">
                <img src="<?= base_url('images/kota tng_nobg.png') ?>" alt="Logo Kota Tangerang" class="brand-logo" onerror="this.style.display='none'">
                <div>
                    <div class="brand-name">E-LAYANAN</div>
                    <div class="brand-sub">Dinkominfo Kota Tangerang</div>
                </div>
            </div> -->

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
</div>

</body>
</html>
