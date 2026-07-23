<?php
/**
 * Kode    : L_master_kabid.php
 * Path    : app/Views/layout/L_master_kabid.php
 * Deskripsi : Template layout utama (master) untuk modul Kepala Bidang.
 *             Menggunakan sidebar Kabid terpisah dari Sekretariat.
 *             Struktur sama dengan L_master.php tetapi include L_sidebar_kabid.
 */
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="E-Layanan Permohonan & Kegiatan Akademik - Dinas Kominfo Kota Tangerang">
    <meta name="author" content="Dinas Kominfo Kota Tangerang">

    <title><?= $this->renderSection('title') ?> - E-Layanan Kominfo</title>

    <!-- Google Font: Inter + Nunito -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="<?= base_url('vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">

    <!-- SB Admin 2 CSS -->
    <link href="<?= base_url('css/sb-admin-2.min.css') ?>" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="<?= base_url('vendor/datatables/dataTables.bootstrap4.min.css') ?>" rel="stylesheet">

    <!-- Custom Sekretariat CSS (shared styles) -->
    <link href="<?= base_url('css/sekretariat-custom.css') ?>" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar Kabid -->
        <?= $this->include('layout/L_sidebar_kabid') ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar / Navbar -->
                <?= $this->include('layout/L_navbar') ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <?= $this->renderSection('content') ?>
                </div>
                <!-- /.container-fluid -->

                <!-- Footer -->


            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade modal-logout" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                <div class="modal-body text-center p-4 p-sm-5">
                    <div class="mb-3">
                        <div class="mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background-color: #DBEAFE; border-radius: 50%;">
                            <i class="fas fa-sign-out-alt fa-2x" style="color: #2563EB;"></i>
                        </div>
                    </div>
                    <h5 class="modal-title mb-2 font-weight-bold" id="logoutModalLabel" style="color: #1F2937; font-size: 1.25rem;">Yakin ingin keluar?</h5>
                    <p class="mb-4" style="color: #6B7280; font-size: 0.95rem;">Pilih "Logout" di bawah ini jika Anda ingin mengakhiri sesi Anda saat ini.</p>
                    <div class="d-flex justify-content-center" style="gap: 12px;">
                        <button class="btn btn-light btn-logout-cancel px-4 py-2" type="button" data-dismiss="modal" style="border-radius: 8px; font-weight: 500; color: #4B5563; background: #F3F4F6; border: none; min-width: 100px; transition: all 0.2s;">Batal</button>
                        <a class="btn btn-primary btn-logout-confirm px-4 py-2" href="<?= base_url('auth/logout') ?>" style="border-radius: 8px; font-weight: 500; background: #2563EB; border: none; min-width: 100px; transition: all 0.2s;">Logout</a>
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

    <!-- DataTables JavaScript -->
    <script src="<?= base_url('vendor/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('vendor/datatables/dataTables.bootstrap4.min.js') ?>"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

    <!-- Page-specific scripts -->
    <?= $this->renderSection('scripts') ?>

</body>

</html>
