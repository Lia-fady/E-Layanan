<?= $this->extend('layouts/superadmin/L_main_superadmin') ?>

<?= $this->section('title') ?><?= esc($title ?? 'jenis_permohonan detail') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detail Jenis Permohonan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('superadmin/dashboard') ?>">Master Data</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('superadmin/jenis-permohonan') ?>">Jenis Permohonan</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0"><i class="fas fa-info-circle me-2 text-info"></i> Informasi Lengkap Jenis Permohonan</h3>
                <div class="card-tools ms-auto">
                    <a href="<?= base_url('superadmin/jenis-permohonan/edit/1') ?>" class="btn btn-success btn-sm">
                        <i class="fas fa-edit"></i> Edit Data
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <table class="table table-borderless table-sm">
                            <tbody>
                                <tr>
                                    <th width="30%" class="text-muted">Nama Jenis Permohonan</th>
                                    <td width="5%">:</td>
                                    <td class="fw-bold">Contoh Data Nama Jenis Permohonan</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Status</th>
                                    <td>:</td>
                                    <td><span class="badge bg-success">Aktif</span></td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Dibuat Pada</th>
                                    <td>:</td>
                                    <td>14 Juli 2026 10:00:00</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Terakhir Diubah</th>
                                    <td>:</td>
                                    <td>14 Juli 2026 11:30:00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="p-3 border rounded bg-light">
                            <i class="fas fa-database fa-4x text-secondary mb-3"></i>
                            <h5 class="fw-bold">Data Master</h5>
                            <p class="text-muted small">ID Record: #10293</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white">
                <a href="<?= base_url('superadmin/jenis-permohonan') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
