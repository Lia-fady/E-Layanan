<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Logbook - <?= esc($mhs['nama_mahasiswa']) ?></title>
    <style>
        /* CSS KHUSUS UNTUK CETAK KERTAS A4 */
        @page {
            size: A4;
            margin: 20mm;
        }
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            color: #000;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
        
        /* KOP SURAT */
        .kop-surat {
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
            text-align: center;
            position: relative;
        }
        .kop-logo {
            position: absolute;
            left: 0;
            top: 0;
            width: 80px;
        }
        .kop-text h3 { margin: 0; font-size: 14pt; text-transform: uppercase; }
        .kop-text h2 { margin: 3px 0; font-size: 16pt; text-transform: uppercase; font-weight: bold; }
        .kop-text p { margin: 0; font-size: 10pt; line-height: 1.4; }
        
        /* JUDUL & BIODATA */
        .judul-dokumen {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        .biodata-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .biodata-table td {
            padding: 4px 0;
            vertical-align: top;
        }
        .biodata-label { width: 180px; font-weight: bold; }
        .biodata-colon { width: 15px; }

        /* TABEL LOGBOOK */
        .logbook-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .logbook-table th, .logbook-table td {
            border: 1px solid #000;
            padding: 8px 10px;
            text-align: left;
            vertical-align: top;
        }
        .logbook-table th {
            text-align: center;
            font-weight: bold;
            background-color: #f2f2f2;
        }
        
        /* BAGIAN TANDA TANGAN */
        .ttd-section {
            width: 100%;
            display: table;
            margin-top: 40px;
        }
        .ttd-box {
            display: table-cell;
            width: 50%;
            text-align: center;
            vertical-align: bottom;
        }
        .ttd-space {
            height: 80px;
        }
        .ttd-name {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 0;
        }

        /* PRINT MEDIA QUERIES */
        @media print {
            .btn-print { display: none !important; }
            body { -webkit-print-color-adjust: exact; }
        }
        
        /* BUTTON ONLY FOR SCREEN */
        .btn-print {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #0a1d37;
            color: #fff;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-family: sans-serif;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }
        .btn-print:hover { background-color: #1a365d; }
    </style>
</head>
<body>

    <button class="btn-print" onclick="window.print()">🖨️ Cetak Dokumen / Simpan PDF</button>

    <div class="container">
        
        <!-- KOP SURAT (Dapat disesuaikan logo dan teksnya) -->
        <div class="kop-surat">
            <div class="kop-text">
                <h3>Pemerintah Kota Tangerang</h3>
                <h2>Dinas Komunikasi dan Informatika</h2>
                <p>Gedung Pusat Pemerintahan Kota Tangerang Lt. 4<br>
                Jl. Satria Sudirman No. 1, Kota Tangerang, Banten 15123<br>
                Website: kominfo.tangerangkota.go.id</p>
            </div>
        </div>

        <div class="judul-dokumen">
            Laporan Harian (Logbook) Kegiatan Magang
        </div>

        <table class="biodata-table">
            <tr>
                <td class="biodata-label">Nama Lengkap</td>
                <td class="biodata-colon">:</td>
                <td><?= esc($mhs['nama_mahasiswa']) ?></td>
            </tr>
            <tr>
                <td class="biodata-label">Nomor Induk / NIM</td>
                <td class="biodata-colon">:</td>
                <td><?= esc($mhs['nim']) ?></td>
            </tr>
            <tr>
                <td class="biodata-label">Instansi Pendidikan</td>
                <td class="biodata-colon">:</td>
                <td><?= esc($mhs['instansi_pendidikan']) ?></td>
            </tr>
            <tr>
                <td class="biodata-label">Penempatan Bidang</td>
                <td class="biodata-colon">:</td>
                <td><?= !empty($bidang) ? esc($bidang['bidang']) : 'Belum Ditentukan' ?></td>
            </tr>
        </table>

        <table class="logbook-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 20%;">Tanggal</th>
                    <th style="width: 60%;">Uraian Kegiatan / Tugas Utama</th>
                    <th style="width: 15%;">Paraf Kabid</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($logbook)): ?>
                    <?php $no = 1; foreach ($logbook as $row): ?>
                        <tr>
                            <td style="text-align: center;"><?= $no++ ?></td>
                            <td><?= date('d/m/Y', strtotime($row['tgl_logbook'])) ?></td>
                            <td style="line-height: 1.5;"><?= nl2br(esc($row['logbook_magang'])) ?></td>
                            <td style="text-align: center; vertical-align: middle;">
                                <small style="color: #666; font-style: italic;">Disetujui</small>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 20px;">
                            <i>Belum ada catatan logbook yang disetujui.</i>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- BAGIAN TANDA TANGAN -->
        <div class="ttd-section">
            <div class="ttd-box">
                <p>Mahasiswa Bersangkutan,</p>
                <div class="ttd-space"></div>
                <p class="ttd-name"><?= esc($mhs['nama_mahasiswa']) ?></p>
                <p style="margin:0;">NIM. <?= esc($mhs['nim']) ?></p>
            </div>
            <div class="ttd-box">
                <p>Kota Tangerang, <?= tgl_indo(date('Y-m-d')) ?><br>Pembimbing Bidang,</p>
                <div class="ttd-space"></div>
                <p class="ttd-name">....................................................</p>
                <p style="margin:0;">NIP. ........................................</p>
            </div>
        </div>

    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>
</body>
</html>
