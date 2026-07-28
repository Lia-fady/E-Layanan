<?php
/**
 * Kode    : v_login.php
 * Path    : app/Views/auth/v_login.php
 * Deskripsi : Halaman login standalone untuk sistem E-Layanan Kominfo.
 *             Tidak menggunakan layout master (L_master.php).
 *             Menampilkan form login dengan field username dan password,
 *             pesan error via flash message, dan branding Dinas Kominfo Kota Tangerang.
 */
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Login - E-Layanan Permohonan & Kegiatan Akademik Dinas Kominfo Kota Tangerang">

    <title>Login - E-Layanan Kominfo Kota Tangerang</title>

    <!-- Google Font: Nunito -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="<?= base_url('vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">

    <!-- SB Admin 2 CSS -->
    <link href="<?= base_url('css/sb-admin-2.min.css') ?>" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-5 col-lg-6 col-md-8">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">

                        <div class="p-5">

                            <!-- Branding / Logo -->
                            <div class="text-center mb-4">
                                <img src="<?= base_url('icon/logo-kota.png') ?>" alt="Icon" class="mb-3" style="width: 98px; height: 98px;">
                                <h1 class="h4 text-gray-900 font-weight-bold">E-Layanan Kominfo</h1>
                                <p class="text-muted small">Permohonan &amp; Kegiatan Akademik<br>Dinas Kominfo Kota Tangerang</p>
                            </div>
                            <hr>

                            <!-- Flash Error Message -->
                            <?php if (session()->getFlashdata('error')) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    <?= session()->getFlashdata('error') ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif; ?>

                            <!-- Login Form -->
                            <form class="user" action="<?= base_url('auth/login') ?>" method="POST">
                                <?= csrf_field() ?>

                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user"
                                        id="username" name="username" placeholder="Username"
                                        value="<?= old('username') ?>" required autofocus>
                                </div>

                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user"
                                        id="password" name="password" placeholder="Password" required>
                                </div>

                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    <i class="fas fa-sign-in-alt mr-2"></i> Login
                                </button>
                            </form>

                            <hr>

                            <div class="text-center">
                                <small class="text-muted">
                                    &copy; <?= date('Y') ?> Dinas Kominfo Kota Tangerang
                                </small>
                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('js/sb-admin-2.min.js') ?>"></script>

</body>

</html>
