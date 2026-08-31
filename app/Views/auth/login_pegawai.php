<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Login Pegawai | E-Layanan' ?></title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        :root {
            --navy:       #10367D;
            --navy-dark:  #0a2456;
            --gold:       #B58E4A;
            --gold-hover: #9a7a3e;
            --primary:    #10367D;
            --primary-hover: #0a2456;
            --primary-light: #A5CEE0;
            --bg-form:    #F8F9FA;
            --text-dark:  #1A1A2E;
            --text-muted: #6B7280;
            --white:      #FFFFFF;
            --border:     #E5E7EB;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-form);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
        }

        .auth-wrapper {
            width: 100%;
            padding: 2rem 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex-grow: 1;
            justify-content: center;
        }

        .auth-card {
            background: var(--white);
            border-radius: 12px;
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            border: 1px solid rgba(0,0,0,0.04);
            margin-bottom: 1.5rem;
        }

        /* Brand / Logo */
        .brand-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 2rem;
        }
        .brand-logo {
            width: 38px;
            height: 38px;
            object-fit: contain;
        }
        .brand-text {
            display: flex;
            flex-direction: column;
        }
        .brand-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--navy);
            line-height: 1.1;
            letter-spacing: 0.3px;
        }
        .brand-subtitle {
            font-size: 0.65rem;
            color: var(--text-muted);
            font-weight: 600;
            letter-spacing: 0.2px;
        }

        .form-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 0.4rem;
            text-align: center;
        }

        .form-desc {
            font-size: 0.8rem;
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        /* Alerts */
        .auth-alert {
            padding: 12px 14px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .auth-alert.error {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }
        .auth-alert.success {
            background: #f0fdf4;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        /* Input Groups */
        .input-group {
            position: relative;
            margin-bottom: 1rem;
            width: 100%;
        }
        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 1.05rem;
            pointer-events: none;
            transition: color 0.2s;
        }
        .form-control {
            width: 100%;
            padding: 10px 36px 10px 38px;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            font-size: 0.82rem;
            color: var(--text-dark);
            background: var(--white);
            transition: all 0.2s;
            outline: none;
        }
        .form-control:focus {
            border-color: var(--navy);
            box-shadow: 0 0 0 3px rgba(16, 54, 125, 0.1);
        }
        .form-control:focus + .input-icon {
            color: var(--navy);
        }
        .form-control::placeholder {
            color: #9ca3af;
        }

        .toggle-pw {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            cursor: pointer;
            font-size: 1.05rem;
            background: none;
            border: none;
            transition: color 0.2s;
        }
        .toggle-pw:hover { color: var(--navy); }

        /* Button */
        .btn-submit {
            width: 100%;
            padding: 10px 0;
            background: var(--gold);
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 0.5rem;
            box-shadow: 0 4px 12px rgba(181, 142, 74, 0.3);
        }
        .btn-submit:hover {
            background: var(--gold-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(181, 142, 74, 0.4);
        }

        /* reCAPTCHA */
        .recaptcha-box { margin-bottom: 1.25rem; display: flex; justify-content: center; }
        .recaptcha-box .g-recaptcha { transform: scale(0.95); transform-origin: center center; }

        .copyright {
            text-align: center;
            font-size: 0.8rem;
            color: #9ca3af;
            font-weight: 500;
            padding-bottom: 2rem;
        }
        
        @media (max-width: 480px) {
            .auth-card { padding: 2rem 1.5rem; }
            .recaptcha-box .g-recaptcha { transform: scale(0.85); }
        }
    </style>
</head>
<body>

    <div class="auth-wrapper">
        <div class="auth-card">
            
            <!-- Brand / Logo -->
            <div class="brand-container">
                <img src="<?= base_url('images/kota tng_nobg.png') ?>" alt="Logo Kota Tangerang" class="brand-logo" onerror="this.style.display='none'">
                <div class="brand-text">
                    <span class="brand-title">E-LAYANAN</span>
                    <span class="brand-subtitle">Dinkominfo Kota Tangerang</span>
                </div>
            </div>

            <h1 class="form-title">Login Pegawai</h1>
            <p class="form-desc">Silakan masukkan NIP dan Password Anda.</p>

            <?php if(session()->getFlashdata('success')): ?>
                <div class="auth-alert success">
                    <i class="bi bi-check-circle-fill"></i>
                    <div><?= session()->getFlashdata('success') ?></div>
                </div>
            <?php endif; ?>

            <?php if(session()->getFlashdata('error')): ?>
                <div class="auth-alert error">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <div><?= session()->getFlashdata('error') ?></div>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('pegawai/login/process') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="input-group">
                    <input type="text" name="nip" class="form-control" placeholder="Masukkan NIP Pegawai" required autocomplete="username">
                    <i class="bi bi-person input-icon"></i>
                </div>

                <div class="input-group">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan Password" required autocomplete="current-password">
                    <i class="bi bi-key input-icon"></i>
                    <button type="button" class="toggle-pw" onclick="togglePassword()" aria-label="Toggle password">
                        <i class="bi bi-eye-slash" id="toggleIcon"></i>
                    </button>
                </div>

                <div class="recaptcha-box">
                    <div class="g-recaptcha" data-sitekey="<?= getenv('RECAPTCHA_SITE_KEY') ?>"></div>
                </div>

                <button type="submit" class="btn-submit">
                    Masuk
                </button>
            </form>

        </div>
    </div>
    
    <div class="copyright">
        2024 - <?= date('Y') ?> &copy; Pemerintah Kota Tangerang.
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const icon = document.getElementById("toggleIcon");
            
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.replace("bi-eye-slash", "bi-eye");
            } else {
                passwordInput.type = "password";
                icon.classList.replace("bi-eye", "bi-eye-slash");
            }
        }
    </script>
</body>
</html>