<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <title>Buat Password Baru - Portal E-Layanan Akademik</title>
    <meta name="description" content="Atur ulang password akun Portal E-Layanan Akademik">

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

        .panel-form::-webkit-scrollbar { width: 7px; }
        .panel-form::-webkit-scrollbar-track { background: #DDD6CC; border-radius: 10px; }
        .panel-form::-webkit-scrollbar-thumb { background: #888078; border-radius: 10px; }
        .panel-form::-webkit-scrollbar-thumb:hover { background: #6b6360; }
        .panel-form { scrollbar-width: thin; scrollbar-color: #888078 #DDD6CC; }

        .split-wrapper { display: flex; height: 100vh; }

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

        .brand-row { display: flex; align-items: center; gap: 10px; margin-bottom: 1.25rem; }
        .brand-logo { width: 36px; height: 36px; object-fit: contain; }
        .brand-name { font-size: 0.92rem; font-weight: 800; color: var(--navy); letter-spacing: 0.5px; line-height: 1.1; }
        .brand-sub { font-size: 0.62rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; }

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

        .form-title { font-size: 1.5rem; font-weight: 800; color: var(--text-dark); margin-bottom: 0.3rem; letter-spacing: -0.5px; }
        .form-desc { font-size: 0.78rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 1rem; }

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

        .input-pw-wrap { position: relative; }
        .input-pw-wrap .auth-input { padding-right: 38px; }
        .pw-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 1rem;
            transition: color 0.2s;
        }
        .pw-toggle:hover { color: var(--navy); }

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

        .auth-alert.error { background: #fef2f2; color: #dc2626; }

        .form-group { margin-bottom: 0.7rem; }

        /* Ikon dihapus agar lebih bersih dan elegan */

        /* Password Strength Meter */
        .pw-strength-bar {
            height: 4px;
            border-radius: 2px;
            background: #e5e7eb;
            margin-top: 6px;
            overflow: hidden;
        }
        .pw-strength-fill {
            height: 100%;
            border-radius: 2px;
            width: 0%;
            transition: width 0.3s, background 0.3s;
        }
        .pw-strength-text {
            font-size: 0.68rem;
            font-weight: 600;
            margin-top: 3px;
            color: var(--text-muted);
        }

        .pw-requirements {
            margin-top: 8px;
            padding: 10px 12px;
            background: #f8f5f1;
            border-radius: 8px;
            font-size: 0.7rem;
            color: var(--text-muted);
        }
        .pw-requirements ul { list-style: none; padding: 0; margin: 0; }
        .pw-requirements li { padding: 2px 0; display: flex; align-items: center; gap: 6px; }
        .pw-requirements li i { font-size: 0.72rem; }
        .pw-requirements li.valid { color: #15803d; }
        .pw-requirements li.invalid { color: #dc2626; }

        /* PANEL HERO */
        .panel-hero { display: none; flex: 1; position: relative; overflow: hidden; }
        @media (min-width: 992px) { .panel-hero { display: flex; align-items: flex-end; } }
        .panel-hero-bg { position: absolute; inset: 0; background-image: url('<?= base_url("images/gedung puspem landing page.png") ?>'); background-size: cover; background-position: center; filter: grayscale(15%) brightness(0.75); }
        .panel-hero-overlay { position: absolute; inset: 0; background: linear-gradient(170deg, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.25) 50%, rgba(0,0,0,0.5) 100%); }
        .hero-content { position: relative; z-index: 2; padding: 3.5rem 4rem; max-width: 600px; }
        .hero-bar { width: 45px; height: 3.5px; background: var(--white); border-radius: 2px; margin-bottom: 1.5rem; }
        .hero-title { font-size: clamp(1.8rem, 2.8vw, 2.5rem); font-weight: 800; color: var(--white); line-height: 1.2; letter-spacing: -0.5px; margin-bottom: 1rem; }
        .hero-subtitle { font-size: 0.88rem; color: rgba(255,255,255,0.68); line-height: 1.7; max-width: 480px; }

        @media (max-width: 991px) { .split-wrapper { background: var(--bg-form); } }
    </style>
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

            <div class="badge-portal">RESET PASSWORD</div>

            <h1 class="form-title">Buat Password Baru</h1>
            <p class="form-desc">Masukkan password baru yang kuat untuk melindungi akun Anda. Pastikan password memenuhi semua persyaratan keamanan di bawah.</p>

            <!-- Alerts -->
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

            <?php if(session()->getFlashdata('error')): ?>
                <div class="auth-alert error">
                    <i class="bi bi-exclamation-triangle-fill flex-shrink-0" style="margin-top: 2px;"></i>
                    <div><?= session()->getFlashdata('error') ?></div>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('reset-password/process') ?>" method="POST" id="resetForm">
                <?= csrf_field() ?>
                <input type="hidden" name="token" value="<?= esc($token) ?>">

                <div class="form-group">
                    <label class="auth-label">Password Baru</label>
                    <div class="input-pw-wrap">
                        <input type="password" id="password" name="password" class="auth-input" placeholder="Masukkan password baru" required autocomplete="new-password">
                        <button type="button" class="pw-toggle" onclick="togglePassword('password', 'eyeIcon1')" aria-label="Toggle password">
                            <i class="bi bi-eye" id="eyeIcon1"></i>
                        </button>
                    </div>
                    <!-- Strength meter -->
                    <div class="pw-strength-bar"><div class="pw-strength-fill" id="strengthFill"></div></div>
                    <div class="pw-strength-text" id="strengthText"></div>
                </div>

                <div class="form-group">
                    <label class="auth-label">Konfirmasi Password Baru</label>
                    <div class="input-pw-wrap">
                        <input type="password" id="password_confirm" name="password_confirm" class="auth-input" placeholder="Ulangi password baru" required autocomplete="new-password">
                        <button type="button" class="pw-toggle" onclick="togglePassword('password_confirm', 'eyeIcon2')" aria-label="Toggle password">
                            <i class="bi bi-eye" id="eyeIcon2"></i>
                        </button>
                    </div>
                </div>

                <!-- Password Requirements -->
                <div class="pw-requirements">
                    <div style="font-weight: 700; margin-bottom: 4px; font-size: 0.72rem; color: var(--text-dark);">Persyaratan Password:</div>
                    <ul>
                        <li id="req-length"><i class="bi bi-circle"></i> Minimal 8 karakter</li>
                        <li id="req-upper"><i class="bi bi-circle"></i> Minimal satu huruf besar (A-Z)</li>
                        <li id="req-lower"><i class="bi bi-circle"></i> Minimal satu huruf kecil (a-z)</li>
                        <li id="req-number"><i class="bi bi-circle"></i> Minimal satu angka (0-9)</li>
                        <li id="req-symbol"><i class="bi bi-circle"></i> Minimal satu simbol (@$!%*?&)</li>
                        <li id="req-match"><i class="bi bi-circle"></i> Konfirmasi password cocok</li>
                    </ul>
                </div>

                <button type="submit" class="btn-submit" id="btnSubmit" disabled style="opacity: 0.5; cursor: not-allowed;">
                    <i class="bi bi-check-circle me-1"></i> Simpan Password Baru
                </button>
            </form>
        </div>
    </div>

    <!-- KANAN: HERO -->
    <div class="panel-hero">
        <div class="panel-hero-bg"></div>
        <div class="panel-hero-overlay"></div>
        <div class="hero-content">
            <div class="hero-bar"></div>
            <h2 class="hero-title">Keamanan Akun<br>Adalah Prioritas.</h2>
            <p class="hero-subtitle">Buat password baru yang kuat untuk melindungi data dan aktivitas akademik Anda di Portal E-Layanan. Kombinasikan huruf besar, kecil, angka, dan simbol.</p>
        </div>
    </div>

</div>

<script>
function togglePassword(inputId, iconId) {
    const p = document.getElementById(inputId);
    const i = document.getElementById(iconId);
    if (p.type === 'password') { p.type = 'text'; i.classList.replace('bi-eye', 'bi-eye-slash'); }
    else { p.type = 'password'; i.classList.replace('bi-eye-slash', 'bi-eye'); }
}

// Password strength checker & requirement validation
const pwInput = document.getElementById('password');
const confirmInput = document.getElementById('password_confirm');
const strengthFill = document.getElementById('strengthFill');
const strengthText = document.getElementById('strengthText');
const btnSubmit = document.getElementById('btnSubmit');

const requirements = {
    length: { el: document.getElementById('req-length'), test: pw => pw.length >= 8 },
    upper:  { el: document.getElementById('req-upper'),  test: pw => /[A-Z]/.test(pw) },
    lower:  { el: document.getElementById('req-lower'),  test: pw => /[a-z]/.test(pw) },
    number: { el: document.getElementById('req-number'), test: pw => /\d/.test(pw) },
    symbol: { el: document.getElementById('req-symbol'), test: pw => /[@$!%*?&]/.test(pw) },
};

function checkRequirements() {
    const pw = pwInput.value;
    const confirm = confirmInput.value;
    let passed = 0;
    const total = 6; // 5 requirements + match

    Object.keys(requirements).forEach(key => {
        const req = requirements[key];
        const valid = req.test(pw);
        req.el.className = valid ? 'valid' : 'invalid';
        req.el.querySelector('i').className = valid ? 'bi bi-check-circle-fill' : 'bi bi-x-circle';
        if (valid) passed++;
    });

    // Check match
    const matchEl = document.getElementById('req-match');
    const isMatch = pw.length > 0 && confirm.length > 0 && pw === confirm;
    matchEl.className = isMatch ? 'valid' : 'invalid';
    matchEl.querySelector('i').className = isMatch ? 'bi bi-check-circle-fill' : 'bi bi-x-circle';
    if (isMatch) passed++;

    // Strength bar
    const percent = (passed / total) * 100;
    strengthFill.style.width = percent + '%';

    if (percent <= 33) {
        strengthFill.style.background = '#dc2626';
        strengthText.textContent = 'Lemah';
        strengthText.style.color = '#dc2626';
    } else if (percent <= 66) {
        strengthFill.style.background = '#f59e0b';
        strengthText.textContent = 'Sedang';
        strengthText.style.color = '#f59e0b';
    } else if (percent < 100) {
        strengthFill.style.background = '#22c55e';
        strengthText.textContent = 'Kuat';
        strengthText.style.color = '#22c55e';
    } else {
        strengthFill.style.background = '#15803d';
        strengthText.textContent = 'Sangat Kuat ✓';
        strengthText.style.color = '#15803d';
    }

    // Enable/disable submit
    if (passed === total) {
        btnSubmit.disabled = false;
        btnSubmit.style.opacity = '1';
        btnSubmit.style.cursor = 'pointer';
    } else {
        btnSubmit.disabled = true;
        btnSubmit.style.opacity = '0.5';
        btnSubmit.style.cursor = 'not-allowed';
    }
}

pwInput.addEventListener('input', checkRequirements);
confirmInput.addEventListener('input', checkRequirements);
</script>

</body>
</html>
