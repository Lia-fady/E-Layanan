<?php

namespace App\Controllers\Sekretariat;



use App\Controllers\BaseController;

use App\Models\Sekretariat\m_kabid;

use Config\Database;



class c_kabid extends BaseController

{

    protected $m_kabid;



    public function __construct()

    {

        $this->m_kabid = new m_kabid();

    }



    public function index()

    {

        $data = [

            'title' => 'Dashboard Kepala Bidang',

            'total_permohonan' => $this->m_kabid->countPermohonan(),

            'pending_persetujuan' => $this->m_kabid->countPendingPersetujuan(),

            'penempatan_aktif' => $this->m_kabid->countPenempatanAktif(),

            'recent_pending' => $this->m_kabid->getRecentPendingPersetujuan(5),

            'permohonan' => $this->m_kabid->getPermohonanByBidang(1),

        ];



        return view('kabid/v_kabid_persetujuan', $data);

    }



    public function persetujuan()

    {

        $id_bidang = 1;

        $data = [

            'title' => 'Persetujuan Permohonan',

            'permohonan' => $this->m_kabid->getPermohonanByBidang($id_bidang),

        ];

        return view('kabid/v_kabid_persetujuan', $data);

    }



    public function simpan_persetujuan()

    {

        $id = $this->request->getPost('id_persetujuan');

        $data = [

            'status_persetujuan' => $this->request->getPost('status'),

            'catatan' => $this->request->getPost('catatan'),

            'tgl_persetujuan' => date('Y-m-d'),

        ];



        $this->m_kabid->updatePersetujuan($id, $data);

        return redirect()->to(base_url('sekretariat/c_kabid/persetujuan'));

    }



    public function penempatan()

    {

        // Debug: set to null to list all penempatan regardless of bidang

        $id_bidang = null;

        $data = [

            'title' => 'Penempatan Magang',

            'penempatan' => $this->m_kabid->getPenempatan($id_bidang),

        ];

        return view('kabid/v_kabid_penempatan', $data);

    }



    public function getPenempatan()

    {

        return $this->penempatan();

    }



    public function simpan_penempatan()

    {

        $id = $this->request->getPost('id_penempatan');

        if (! $id) {

            return redirect()->to(base_url('sekretariat/c_kabid/penempatan'));

        }



        $status = $this->request->getPost('status_penempatan');

        $catatan = $this->request->getPost('catatan');



        // Validate input

        $allowed = [

            m_kabid::PENEMPATAN_BERJALAN,

            m_kabid::PENEMPATAN_SELESAI,

            m_kabid::PENEMPATAN_DIBATALKAN,

        ];

        if (! in_array($status, $allowed, true)) {

            session()->setFlashdata('error', 'Status penempatan tidak valid.');

            return redirect()->to(base_url('sekretariat/c_kabid/penempatan'));

        }



        $data = [

            'status_penempatan' => $status,

            'catatan' => $catatan,

        ];



        // Use transaction to ensure atomic update

        $db = Database::connect();

        $db->transStart();

        $ok = $this->m_kabid->updatePenempatan($id, $data);

        $db->transComplete();



        if ($db->transStatus() && $ok) {

            session()->setFlashdata('success', 'Penempatan berhasil diperbarui.');

        } else {

            session()->setFlashdata('error', 'Gagal memperbarui penempatan.');

        }



        return redirect()->to(base_url('sekretariat/c_kabid/penempatan'));

    }



    public function penilaian()

    {

        $id_bidang = null;

        $data = [

            'title' => 'Penilaian Mahasiswa',

            'penilaian' => $this->m_kabid->getPenilaian($id_bidang),

            'komponen' => $this->m_kabid->getKomponenPenilaian(),

        ];



        return view('kabid/v_kabid_penilaian', $data);

    }



    public function komponen()

    {

        $data = [

            'title' => 'Kelola Komponen Penilaian',

            'komponen' => $this->m_kabid->getAllKomponen(),

        ];

        return view('kabid/v_kabid_komponen', $data);

    }



    public function simpan_komponen()

    {

        $id = $this->request->getPost('id_komponen_penilaian');

        $nama = $this->request->getPost('komponen_penilaian');

        $status = $this->request->getPost('status_aktif') ?? '1';



        if (empty($nama)) {

            session()->setFlashdata('error', 'Nama komponen tidak boleh kosong.');

            return redirect()->back();

        }



        $ok = $this->m_kabid->saveKomponen([

            'id_komponen_penilaian' => $id,

            'komponen_penilaian' => $nama,

            'status_aktif' => $status,

        ]);



        if ($ok) {

            session()->setFlashdata('success', 'Komponen berhasil disimpan.');

        } else {

            session()->setFlashdata('error', 'Gagal menyimpan komponen.');

        }



        return redirect()->to(base_url('sekretariat/c_kabid/komponen'));

    }



    public function hapus_komponen()

    {

        $id = $this->request->getPost('id_komponen_penilaian');

        if (! $id) {

            session()->setFlashdata('error', 'ID komponen tidak ditemukan.');

            return redirect()->to(base_url('sekretariat/c_kabid/komponen'));

        }



        $ok = $this->m_kabid->deleteKomponen((int) $id);

        if ($ok) {

            session()->setFlashdata('success', 'Komponen dihapus.');

        } else {

            session()->setFlashdata('error', 'Gagal menghapus komponen.');

        }



        return redirect()->to(base_url('sekretariat/c_kabid/komponen'));

    }



    public function simpan_penilaian()

    {

        $id_penempatan = $this->request->getPost('id_penempatan_magang');

        $id_komponen = $this->request->getPost('id_komponen_penilaian');

        $nilai = $this->request->getPost('nilai');



        if (! $id_penempatan || ! $id_komponen || $nilai === null) {

            return redirect()->to(base_url('sekretariat/c_kabid/penilaian'));

        }

        // Validate

        if (! is_numeric($id_penempatan) || ! is_numeric($id_komponen)) {

            session()->setFlashdata('error', 'Data penilaian tidak valid.');

            return redirect()->to(base_url('sekretariat/c_kabid/penilaian'));

        }



        if (! is_numeric($nilai) || $nilai < 0 || $nilai > 100) {

            session()->setFlashdata('error', 'Nilai harus antara 0 dan 100.');

            return redirect()->to(base_url('sekretariat/c_kabid/penilaian'));

        }



        $db = Database::connect();

        $db->transStart();

        $ok = $this->m_kabid->savePenilaian([

            'id_penempatan_magang' => $id_penempatan,

            'id_komponen_penilaian' => $id_komponen,

            'nilai' => $nilai,

            'created_by' => session()->get('id_user') ?? null,

        ]);

        $db->transComplete();



        if ($db->transStatus() && $ok) {

            session()->setFlashdata('success', 'Penilaian tersimpan.');

        } else {

            session()->setFlashdata('error', 'Gagal menyimpan penilaian.');

        }



        return redirect()->to(base_url('sekretariat/c_kabid/penilaian'));

    }

}

