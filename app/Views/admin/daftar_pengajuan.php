<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Pengajuan Magang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        /* Custom style agar tampilan lebih premium dan compact */
        .table th {
            font-weight: 600;
            letter-spacing: 0.5px;
            font-size: 0.85rem;
        }
        .table td {
            font-size: 0.9rem;
            padding: 12px 8px !important;
        }
        .badge {
            font-weight: 500;
            padding: 6px 10px;
        }
        .btn-link {
            text-decoration: none;
            font-size: 0.85rem;
        }
        .btn-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="#"><i class="bi bi-shield-lock-fill text-primary me-2"></i>PANEL ADMIN KOMINFO</a>
            <div class="navbar-nav ms-auto align-items-center">
                <span class="nav-link text-white-50 me-3">Login Sebagai: <strong class="text-white">Super Admin</strong></span>
                <a class="btn btn-outline-danger btn-sm px-3" href="<?= base_url('logout') ?>"><i class="bi bi-box-arrow-right me-1"></i> Logout</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4 mb-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                <h5 class="card-title mb-0 text-dark fw-bold">
                    <i class="bi bi-folder2-open text-primary me-2"></i> Kelola Pengajuan Magang Mahasiswa
                </h5>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2">
                    <i class="bi bi-database-check me-1"></i> Mode Dinamis Aktif
                </span>
            </div>
            <div class="card-body p-0">
                
                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light border-bottom">
                            <tr>
                                <th scope="col" class="ps-4" style="width: 5%">#</th>
                                <th scope="col" style="width: 15%">Nama / Universitas</th>
                                <th scope="col" style="width: 25%">Keahlian (Skills) & Rencana</th>
                                <th scope="col" style="width: 18%">Periode Magang</th>
                                <th scope="col" style="width: 15%">Berkas PDF</th>
                                <th scope="col" style="width: 12%">Status Saat Ini</th>
                                <th scope="col" style="width: 10%" class="text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($pengajuan) && is_array($pengajuan)): ?>
                                <?php $no = 1; foreach ($pengajuan as $p): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-secondary"><?= $no++; ?></td>
                                        <td>
                                            <div class="fw-bold text-dark">ID Mahasiswa: <?= esc($p['id_mahasiswa']); ?></div>
                                            <small class="text-muted"><i class="bi bi-building me-1"></i> Telkom University Jakarta</small>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-primary mb-1">
                                                <i class="bi bi-lightbulb me-1"></i> <?= esc($p['deskripsi_keahlian']); ?>
                                            </div>
                                            <?php if(!empty($p['deskripsi_magang'])): ?>
                                                <div class="text-muted small" style="line-height: 1.3;">
                                                    <strong>Rencana:</strong> <?= esc($p['deskripsi_magang']); ?>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="text-dark"><i class="bi bi-calendar-event me-1 text-secondary"></i> <?= date('d M Y', strtotime($p['tgl_mulai'])); ?></div>
                                            <div class="text-muted small ps-3">s/d <?= date('d M Y', strtotime($p['tgl_selesai'])); ?></div>
                                        </td>
                                        <td>
                                            <div class="mb-1">
                                                <a href="#" class="btn-link text-danger p-0"><i class="bi bi-file-earmark-pdf text-danger me-1"></i>Lihat CV</a>
                                            </div>
                                            <div>
                                                <a href="#" class="btn-link text-danger p-0"><i class="bi bi-file-earmark-text text-danger me-1"></i>Surat Pengantar</a>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if ($p['posting_data'] == '1') : ?>
                                                <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i> Perlu Review</span>
                                            <?php elseif ($p['posting_data'] == '2') : ?>
                                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Diterima</span>
                                            <?php else : ?>
                                                <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i> Ditolak</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center pe-4">
                                            <div class="d-flex gap-1 justify-content-center">
                                                <a href="<?= base_url('admin/updateStatus/' . $p['id_permohonan_magang'] . '/diterima') ?>" 
                                                   class="btn btn-success btn-sm px-2 py-1" 
                                                   title="Terima Pengajuan"
                                                   onclick="return confirm('Apakah Anda yakin ingin MENERIMA pengajuan magang ini?')">
                                                    <i class="bi bi-check-lg"></i>
                                                </a>
                                                <a href="<?= base_url('admin/updateStatus/' . $p['id_permohonan_magang'] . '/ditolak') ?>" 
                                                   class="btn btn-danger btn-sm px-2 py-1" 
                                                   title="Tolak Pengajuan"
                                                   onclick="return confirm('Apakah Anda yakin ingin MENOLAK pengajuan magang ini?')">
                                                    <i class="bi bi-x-lg"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-5">
                                        <i class="bi bi-inbox display-6 d-block mb-2 text-secondary"></i>
                                        Belum ada dokumen pengajuan magang yang masuk.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>