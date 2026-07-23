<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Portal Kedinasan | E-Layanan' ?></title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: #f8fbff;
            /* Simple grid background pattern */
            background-image: 
                linear-gradient(rgba(0, 74, 173, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 74, 173, 0.03) 1px, transparent 1px);
            background-size: 40px 40px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Dekorasi Lingkaran Latar Belakang Blur */
        .blob-1 {
            position: absolute;
            top: -150px;
            left: -150px;
            width: 400px;
            height: 400px;
            background: rgba(0, 74, 173, 0.1);
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
        }
        .blob-2 {
            position: absolute;
            bottom: -150px;
            right: -150px;
            width: 500px;
            height: 500px;
            background: rgba(13, 110, 253, 0.08);
            border-radius: 50%;
            filter: blur(100px);
            z-index: 0;
        }

        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 420px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Brand / Logo */
        .brand-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 35px;
        }
        .brand-logo {
            width: 45px;
            height: 45px;
            object-fit: contain;
        }
        .brand-text {
            display: flex;
            flex-direction: column;
        }
        .brand-title {
            font-size: 24px;
            font-weight: 700;
            color: #004aad;
            line-height: 1.1;
            letter-spacing: 0.5px;
        }
        .brand-subtitle {
            font-size: 11px;
            color: #6c757d;
            font-weight: 500;
        }

        /* Form Area */
        .form-container {
            width: 100%;
            padding: 10px;
        }

        /* Alerts */
        .auth-alert {
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown 0.3s ease;
        }
        .auth-alert.error {
            background: #fff2f2;
            color: #dc3545;
            border: 1px solid #ffcdd2;
        }
        .auth-alert.success {
            background: #f0fdf4;
            color: #198754;
            border: 1px solid #bbf7d0;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Input Groups */
        .input-group {
            position: relative;
            margin-bottom: 20px;
            width: 100%;
        }
        .input-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            font-size: 18px;
            transition: 0.3s ease;
            pointer-events: none;
        }
        .form-control {
            width: 100%;
            padding: 15px 45px 15px 50px;
            border: 2px solid #e2e8f0;
            border-radius: 50px;
            font-size: 14px;
            color: #2d3748;
            background: #ffffff;
            transition: all 0.3s ease;
            outline: none;
        }
        .form-control:focus {
            border-color: #004aad;
            box-shadow: 0 0 0 4px rgba(0, 74, 173, 0.1);
        }
        .form-control:focus + .input-icon {
            color: #004aad;
        }
        .form-control::placeholder {
            color: #a0aec0;
            font-weight: 400;
        }

        .toggle-pw {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            cursor: pointer;
            font-size: 18px;
            transition: 0.2s ease;
            background: none;
            border: none;
        }
        .toggle-pw:hover {
            color: #4a5568;
        }

        /* Button */
        .btn-submit {
            position: relative;
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #002868 0%, #004aad 100%);
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            margin-top: 10px;
            box-shadow: 0 4px 15px rgba(0, 74, 173, 0.2);
        }
        .btn-submit i {
            position: absolute;
            left: 20px;
            font-size: 16px;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 74, 173, 0.3);
        }

        /* Footer Links */
        .auth-footer {
            margin-top: 30px;
            text-align: center;
            font-size: 13px;
            color: #718096;
        }
        .auth-footer a {
            color: #004aad;
            text-decoration: none;
            font-weight: 600;
            transition: 0.2s;
        }
        .auth-footer a:hover {
            text-decoration: underline;
        }

        .copyright {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #a0aec0;
            font-weight: 500;
        }

        /* Action Buttons (Beranda & Pegawai) */
        .action-links {
            margin-top: 1.5rem;
            padding-top: 1.25rem;
            border-top: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        @media (min-width: 576px) {
            .action-links {
                flex-direction: row;
                gap: 15px;
            }
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 700;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.25s ease;
            width: 100%;
        }
        .btn-action-beranda {
            background-color: #ffffff;
            color: #2d3748;
            border: 1.5px solid #e2e8f0;
        }
        .btn-action-beranda:hover {
            background-color: #f8fbff;
            border-color: #cbd5e1;
            color: #2d3748;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.04);
        }
        .btn-action-pegawai {
            background-color: rgba(0, 74, 173, 0.05);
            color: #004aad;
            border: 1.5px solid rgba(0, 74, 173, 0.15);
        }
        .btn-action-pegawai:hover {
            background-color: #004aad;
            color: #ffffff;
            border-color: #004aad;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 74, 173, 0.2);
        }
    </style>
</head>
<body>

    <!-- Background Elements -->
    <div class="blob-1"></div>
    <div class="blob-2"></div>

    <div class="login-wrapper">
        
        <!-- Brand / Logo -->
        <div class="brand-container">
            <img src="<?= base_url('images/kota tng_nobg.png') ?>" alt="Logo Kota Tangerang" class="brand-logo" onerror="this.style.display='none'">
            <div class="brand-text">
                <span class="brand-title">E-LAYANAN</span>
                <span class="brand-subtitle">Dinkominfo Kota Tangerang</span>
            </div>
        </div>

        <!-- Form Card -->
        <div class="form-container">
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



                <button type="submit" class="btn-submit">
                    <i class="bi bi-lock-fill"></i> Masuk Sistem
                </button>
            </form>

            <div class="auth-footer">
                Mahasiswa Magang? <a href="<?= base_url('login') ?>">Masuk di sini</a>
            </div>

            <div class="action-links d-flex flex-column flex-sm-row gap-2 mt-4">
                <a href="<?= base_url('landing') ?>" class="btn-action btn-action-beranda">
                    <i class="bi bi-house-door-fill me-2 fs-6"></i> Kembali ke Beranda
                </a>
                <a href="<?= base_url('auth/login') ?>" class="btn-action btn-action-pegawai">
                    <i class="bi bi-person-badge-fill me-2 fs-6"></i> Portal Mahasiswa
                </a>
            </div>
        </div>

        <div class="copyright">
            2024 - <?= date('Y') ?> &copy; Pemerintah Kota Tangerang.
        </div>

    </div>

    <!-- Scripts -->
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