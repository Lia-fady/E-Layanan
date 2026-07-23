<?php
/**
 * ============================================================
 * Kode      : C_Sertifikat.php
 * Path      : Controllers/Sekretariat/C_Sertifikat.php
 * Deskripsi : Controller untuk mengelola sertifikat magang,
 *             termasuk daftar magang selesai dan generate
 *             sertifikat dalam format HTML untuk dicetak
 * ============================================================
 */

namespace App\Controllers\Sekretariat;

use App\Controllers\BaseController;
use App\Models\Sekretariat\M_Sertifikat;

class C_Sertifikat extends BaseController
{
    protected $sertifikatModel;

    public function __construct()
    {
        $this->sertifikatModel = new M_Sertifikat();
    }

    /**
     * Halaman utama sertifikat magang.
     * Menampilkan daftar mahasiswa yang sudah selesai magang.
     *
     * @return string
     */
    public function index()
    {
        $data = [
            'title'       => 'Sertifikat Magang',
            'active_menu' => 'sertifikat',
            'magang'      => $this->sertifikatModel->getMagangSelesai(),
        ];

        return view('dashboard/sekretariat/v_sertifikat', $data);
    }

    /**
     * Generate dan tampilkan sertifikat magang dalam format HTML.
     * Halaman ini dirancang untuk print-friendly.
     *
     * @param int $id_penempatan
     * @return \CodeIgniter\HTTP\Response
     */
    public function download($id_penempatan)
    {
        $data = $this->sertifikatModel->getDataSertifikat($id_penempatan);

        if (!$data) {
            session()->setFlashdata('error', 'Data sertifikat tidak ditemukan.');
            return redirect()->to(base_url('sekretariat/sertifikat'));
        }

        // Ambil data penilaian magang
        $nilai = $this->sertifikatModel->getNilaiByPenempatan($id_penempatan);

        // Hitung rata-rata nilai
        $totalNilai = 0;
        $jumlahKomponen = count($nilai);
        foreach ($nilai as $n) {
            $totalNilai += (float)$n['nilai'];
        }
        $rataRata = $jumlahKomponen > 0 ? round($totalNilai / $jumlahKomponen, 2) : 0;

        // Tentukan predikat berdasarkan rata-rata
        if ($rataRata >= 90) {
            $predikat = 'Sangat Baik';
        } elseif ($rataRata >= 80) {
            $predikat = 'Baik';
        } elseif ($rataRata >= 70) {
            $predikat = 'Cukup';
        } elseif ($rataRata >= 60) {
            $predikat = 'Kurang';
        } else {
            $predikat = 'Sangat Kurang';
        }

        // Format tanggal
        $tgl_mulai   = date('d F Y', strtotime($data['tgl_mulai']));
        $tgl_selesai = date('d F Y', strtotime($data['tgl_selesai']));

        // Build HTML tabel nilai
        $nilaiHtml = '';
        if (!empty($nilai)) {
            $nilaiHtml .= '
            <div style="margin-top: 25px;">
                <p style="font-weight: bold; margin-bottom: 10px;">Hasil Penilaian Magang:</p>
                <table class="nilai-table">
                    <thead>
                        <tr>
                            <th style="width: 40px;">No</th>
                            <th>Komponen Penilaian</th>
                            <th style="width: 80px;">Nilai</th>
                            <th style="width: 120px;">Predikat</th>
                        </tr>
                    </thead>
                    <tbody>';

            $no = 1;
            foreach ($nilai as $n) {
                $nilaiNum = (float)$n['nilai'];
                // Predikat per komponen
                if ($nilaiNum >= 90) {
                    $pred = 'Sangat Baik';
                } elseif ($nilaiNum >= 80) {
                    $pred = 'Baik';
                } elseif ($nilaiNum >= 70) {
                    $pred = 'Cukup';
                } elseif ($nilaiNum >= 60) {
                    $pred = 'Kurang';
                } else {
                    $pred = 'Sangat Kurang';
                }

                $nilaiHtml .= '
                        <tr>
                            <td style="text-align: center;">' . $no++ . '</td>
                            <td>' . esc($n['komponen_penilaian']) . '</td>
                            <td style="text-align: center;">' . number_format($nilaiNum, 2) . '</td>
                            <td style="text-align: center;">' . $pred . '</td>
                        </tr>';
            }

            $nilaiHtml .= '
                    </tbody>
                    <tfoot>
                        <tr style="font-weight: bold; background-color: #e8eaf6;">
                            <td colspan="2" style="text-align: right; padding-right: 15px;">Rata-rata</td>
                            <td style="text-align: center;">' . number_format($rataRata, 2) . '</td>
                            <td style="text-align: center;">' . $predikat . '</td>
                        </tr>
                    </tfoot>
                </table>
            </div>';
        }

        $html = '<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Magang - ' . esc($data['nama_mahasiswa']) . '</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Times+New+Roman&family=Roboto:wght@400;700&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding: 20px;
        }

        .certificate-container {
            width: 210mm;
            min-height: 297mm;
            background: #fff;
            border: 3px solid #1a237e;
            padding: 40px 50px;
            position: relative;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }

        .certificate-container::before {
            content: "";
            position: absolute;
            top: 8px;
            left: 8px;
            right: 8px;
            bottom: 8px;
            border: 1px solid #1a237e;
            pointer-events: none;
        }

        .kop-surat {
            text-align: center;
            border-bottom: 3px double #1a237e;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .kop-surat .instansi {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .kop-surat .dinas {
            font-size: 22px;
            font-weight: bold;
            color: #1a237e;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 5px 0;
        }

        .kop-surat .alamat {
            font-size: 11px;
            color: #555;
            margin-top: 5px;
        }

        .title-section {
            text-align: center;
            margin: 30px 0 20px;
        }

        .title-section h1 {
            font-size: 28px;
            font-weight: bold;
            color: #1a237e;
            text-transform: uppercase;
            letter-spacing: 4px;
            text-decoration: underline;
            text-underline-offset: 8px;
        }

        .title-section .nomor {
            font-size: 12px;
            color: #555;
            margin-top: 8px;
        }

        .content-section {
            margin: 20px 20px;
            line-height: 1.8;
            font-size: 14px;
            color: #333;
        }

        .content-section p {
            margin-bottom: 12px;
            text-align: justify;
        }

        .data-table {
            margin: 15px 0 15px 40px;
        }

        .data-table tr td {
            padding: 3px 10px;
            font-size: 14px;
            vertical-align: top;
        }

        .data-table tr td:first-child {
            width: 180px;
            font-weight: bold;
        }

        .data-table tr td:nth-child(2) {
            width: 15px;
            text-align: center;
        }

        /* Tabel Nilai Penilaian */
        .nilai-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin-top: 10px;
        }

        .nilai-table th,
        .nilai-table td {
            border: 1px solid #333;
            padding: 6px 10px;
        }

        .nilai-table th {
            background-color: #1a237e;
            color: #fff;
            font-weight: bold;
            text-align: center;
        }

        .nilai-table tbody tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: flex-end;
            padding-right: 40px;
        }

        .signature-block {
            text-align: center;
            width: 250px;
        }

        .signature-block .city-date {
            font-size: 13px;
            margin-bottom: 5px;
        }

        .signature-block .position {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 70px;
        }

        .signature-block .name {
            font-size: 14px;
            font-weight: bold;
            text-decoration: underline;
        }

        .signature-block .nip {
            font-size: 12px;
            color: #555;
        }

        .print-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #1a237e;
            color: #fff;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .print-btn:hover {
            background: #283593;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.4);
        }

        @media print {
            body {
                background: none;
                padding: 0;
            }

            .certificate-container {
                box-shadow: none;
                width: 100%;
                min-height: auto;
                border: 3px solid #1a237e;
            }

            .print-btn {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <!-- Kop Surat -->
        <div class="kop-surat">
            <div class="instansi">Pemerintah Kota Tangerang</div>
            <div class="dinas">Dinas Komunikasi dan Informatika</div>
            <div class="alamat">
                Jl. Satria Sudirman No.1, RT.002/RW.001, Sukaasih, Kec. Tangerang, Kota Tangerang, Indonesia 15111<br>
                Telp. 0811-1500-152 | Email: diskominfo@tangerangkota.go.id
            </div>
        </div>

        <!-- Judul Sertifikat -->
        <div class="title-section">
            <h1>Sertifikat Magang</h1>
            <div class="nomor">Nomor: ____/KOMINFO/SERT/' . date('Y') . '</div>
        </div>

        <!-- Isi Sertifikat -->
        <div class="content-section">
            <p>Yang bertanda tangan di bawah ini, Kepala Dinas Komunikasi dan Informatika Kota Tangerang, dengan ini menerangkan bahwa:</p>

            <table class="data-table">
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><strong>' . esc($data['nama_mahasiswa']) . '</strong></td>
                </tr>
                <tr>
                    <td>NIM</td>
                    <td>:</td>
                    <td>' . esc($data['nim']) . '</td>
                </tr>
                <tr>
                    <td>Instansi Pendidikan</td>
                    <td>:</td>
                    <td>' . esc($data['instansi_pendidikan'] ?? '-') . '</td>
                </tr>
                <tr>
                    <td>Program Studi</td>
                    <td>:</td>
                    <td>' . esc($data['prodi'] ?? '-') . '</td>
                </tr>
                <tr>
                    <td>Bidang Penempatan</td>
                    <td>:</td>
                    <td>' . esc($data['bidang'] ?? '-') . '</td>
                </tr>
                <tr>
                    <td>Periode Magang</td>
                    <td>:</td>
                    <td>' . $tgl_mulai . ' s/d ' . $tgl_selesai . '</td>
                </tr>
            </table>

            <p>Telah melaksanakan kegiatan Magang/Praktik Kerja Lapangan (PKL) di Dinas Komunikasi dan Informatika Kota Tangerang dan telah menyelesaikan seluruh tugas dengan baik.</p>

            ' . $nilaiHtml . '

            <p style="margin-top: 20px;">Demikian sertifikat ini diberikan untuk dapat digunakan sebagaimana mestinya.</p>
        </div>

        <!-- Tanda Tangan -->
        <div class="signature-section">
            <div class="signature-block">
                <div class="city-date">Tangerang, ' . date('d F Y') . '</div>
                <div class="position">Kepala Dinas Komunikasi<br>dan Informatika</div>
                <div class="name">_________________________</div>
                <div class="nip">NIP. _________________________</div>
            </div>
        </div>
    </div>

    <button class="print-btn" onclick="window.print()">
        🖨️ Cetak Sertifikat
    </button>
</body>
</html>';

        return $this->response
            ->setHeader('Content-Type', 'text/html')
            ->setBody($html);
    }
}
