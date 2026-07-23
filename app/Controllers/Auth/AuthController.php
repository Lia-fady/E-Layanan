<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\Mahasiswa\M_Mahasiswa;
use App\Models\Mahasiswa\M_UserMahasiswa;
use App\Models\Mahasiswa\M_InstansiMahasiswa; 
use App\Models\Mahasiswa\M_InstansiPendidikan; 

class AuthController extends BaseController
{
    protected $M_Mahasiswa;
    protected $M_UserMahasiswa;
    protected $M_InstansiMahasiswa;
    protected $M_InstansiPendidikan;

    public function __construct()
    {
        // Inisialisasi model-model penunjang data akademik & auth
        $this->M_Mahasiswa          = new M_Mahasiswa();
        $this->M_UserMahasiswa      = new M_UserMahasiswa();
        $this->M_InstansiMahasiswa  = new M_InstansiMahasiswa();
        $this->M_InstansiPendidikan = new M_InstansiPendidikan();
    }

    // --- TAMPILAN FORM REGISTRASI MAHASISWA ---
    public function register()
    {
        // Mengambil data master kampus aktif untuk dropdown utama sesuai string 'aktif'
        $data['kampus'] = $this->M_InstansiPendidikan->where('status', 'aktif')->findAll();
        $data['title']  = "Registrasi Akun Mahasiswa";

        return view('auth/v_register', $data);
    }

    // ======================================================================
    // LOGIKA API ENDPOINT (UNTUK MEMBUKA KUNCI & MENGISI DROPDOWN VIA AJAX)
    // ======================================================================

    // --- API 1: AMBIL FAKULTAS MURNI AKTIF ---
    // Dipanggil saat kampus dipilih. Membuka gembok dropdown Fakultas
    public function getFakultasByKampus($id_kampus = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('m_fakultas');
        $builder->select('id_fakultas, fakultas');
        $builder->where('status', 'aktif'); // Menggunakan string 'aktif' sesuai database

        $data = $builder->get()->getResultArray();

        return $this->response->setJSON($data);
    }

    // --- API 2: AMBIL PRODI BERDASARKAN FAKULTAS ---
    // Dipanggil saat fakultas dipilih. Membuka gembok dropdown Prodi
    public function getProdiByFakultas($id_fakultas = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('m_prodi');
        $builder->select('id_prodi, prodi');
        $builder->where('id_fakultas', $id_fakultas);
        $builder->where('status', 'aktif'); // Menggunakan string 'aktif' sesuai database

        $data = $builder->get()->getResultArray();

        return $this->response->setJSON($data);
    }

    // --- PROSES SUBMIT REGISTRASI MAHASISWA ---
   // --- PROSES SUBMIT REGISTRASI MAHASISWA ---
  // --- PROSES SUBMIT REGISTRASI MAHASISWA DENGAN VALIDASI CI4 CUSTOM ---
    public function processRegister()
    {
        // 1. BENTENG VALIDASI FORM CI4 + PESAN ERROR KUSTOM BAHASA INDONESIA
        $rules = [
            'username' => [
                'rules'  => 'required|alpha_numeric|min_length[5]|max_length[30]|is_unique[m_user_mahasiswa.username]',
                'errors' => [
                    'required'      => 'Username akun wajib diisi.',
                    'alpha_numeric' => 'Username hanya boleh berisi huruf dan angka tanpa spasi/simbol.',
                    'min_length'    => 'Username minimal harus memiliki 5 karakter.',
                    'max_length'    => 'Username maksimal 30 karakter.',
                    'is_unique'     => 'Username ini sudah digunakan oleh orang lain.'
                ]
            ],
            'password' => [
                'rules'  => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/]',
                'errors' => [
                    'required'    => 'Kata sandi / Password wajib diisi.',
                    'min_length'  => 'Password minimal harus memiliki 8 karakter demi keamanan.',
                    'regex_match' => 'Password harus mengandung minimal satu huruf besar, huruf kecil, angka, dan simbol khusus (@$!%*?&).'
                ]
            ],
            'id_instansi_pendidikan' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Asal Universitas / Kampus wajib dipilih.']
            ],
            'id_fakultas' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Fakultas wajib dipilih.']
            ],
            'id_prodi' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Program Studi (Prodi) wajib dipilih.']
            ],
            'semester' => [
                'rules'  => 'required|numeric|greater_than[0]|less_than_equal_to[14]',
                'errors' => [
                    'required' => 'Semester aktif wajib diisi.',
                    'numeric'  => 'Semester harus diisi dengan angka bulat.',
                    'greater_than' => 'Semester tidak boleh kurang dari 1.',
                    'less_than_equal_to' => 'Semester maksimal adalah 14 (batas DO).'
                ]
            ],
            'angkatan_tahun' => [
                'rules'  => 'required|numeric|exact_length[4]',
                'errors' => [
                    'required'     => 'Tahun angkatan masuk kuliah wajib diisi.',
                    'numeric'      => 'Tahun angkatan harus berupa angka.',
                    'exact_length' => 'Tahun angkatan harus 4 digit (misal: 2021).'
                ]
            ],
            'tahun_akademik' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Tahun akademik berjalan wajib diisi.']
            ],
            'jenjang_pendidikan' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Jenjang pendidikan (D3/S1) wajib dipilih.']
            ],
            'nik' => [
                'rules'  => 'required|numeric|exact_length[16]|is_unique[m_mahasiswa.nik]',
                'errors' => [
                    'required'     => 'NIK KTP wajib diisi.',
                    'numeric'      => 'NIK harus berupa angka tanpa spasi/simbol.',
                    'exact_length' => 'NIK wajib berjumlah 16 digit angka.',
                    'is_unique'    => 'NIK ini sudah terdaftar di sistem.'
                ]
            ],
            'nim' => [
                'rules'  => 'required|numeric|min_length[5]|max_length[25]|is_unique[m_mahasiswa.nim]',
                'errors' => [
                    'required'      => 'Nomor Induk Mahasiswa (NIM) wajib diisi.',
                    'numeric'       => 'NIM hanya boleh berisi angka tanpa spasi atau karakter lainnya.',
                    'min_length'    => 'NIM minimal harus memiliki 5 digit angka.',
                    'max_length'    => 'NIM maksimal 25 karakter.',
                    'is_unique'     => 'NIM ini sudah terdaftar di sistem E-Layanan.'
                ]
            ],
            'nama_mahasiswa' => [
                'rules'  => 'required|alpha_space|min_length[3]|max_length[100]',
                'errors' => [
                    'required'    => 'Nama lengkap mahasiswa wajib diisi.',
                    'alpha_space' => 'Nama lengkap hanya boleh berisi huruf alfabet dan spasi.',
                    'min_length'  => 'Nama lengkap minimal harus 3 karakter.',
                    'max_length'  => 'Nama lengkap maksimal 100 karakter.'
                ]
            ],
            'email' => [
                'rules'  => 'required|valid_email|is_unique[m_mahasiswa.email]',
                'errors' => [
                    'required'    => 'Alamat email aktif wajib diisi.',
                    'valid_email' => 'Format penulisan alamat email tidak valid.',
                    'is_unique'   => 'Alamat email ini sudah terdaftar di sistem.'
                ]
            ],
            'no_telp' => [
                'rules'  => 'required|numeric|min_length[10]|max_length[15]',
                'errors' => [
                    'required'   => 'Nomor WhatsApp / Telepon wajib diisi.',
                    'numeric'    => 'Nomor Telepon harus berupa angka tanpa spasi/simbol.',
                    'min_length' => 'Nomor Telepon minimal 10 digit angka.',
                    'max_length' => 'Nomor Telepon maksimal 15 digit angka.'
                ]
            ],
            'jenis_kelamin' => [
                'rules'  => 'required|in_list[L,P,Laki-laki,Perempuan]',
                'errors' => [
                    'required' => 'Jenis kelamin wajib dipilih.',
                    'in_list'  => 'Pilihan jenis kelamin tidak valid.'
                ]
            ],
            'tgl_lahir' => [
                'rules'  => 'required|valid_date',
                'errors' => [
                    'required'   => 'Tanggal lahir sesuai KTP/KTM wajib diisi.',
                    'valid_date' => 'Format tanggal lahir yang dimasukkan tidak valid.'
                ]
            ],
            'alamat' => [
                'rules'  => 'required|max_length[255]',
                'errors' => [
                    'required'   => 'Alamat tempat tinggal saat ini wajib diisi.',
                    'max_length' => 'Alamat maksimal 255 karakter.'
                ]
            ],
            'rt' => [
                'rules'  => 'required|numeric|max_length[3]',
                'errors' => [
                    'required'   => 'RT wajib diisi.',
                    'numeric'    => 'RT harus berupa angka.',
                    'max_length' => 'RT maksimal 3 digit angka.'
                ]
            ],
            'rw' => [
                'rules'  => 'required|numeric|max_length[3]',
                'errors' => [
                    'required'   => 'RW wajib diisi.',
                    'numeric'    => 'RW harus berupa angka.',
                    'max_length' => 'RW maksimal 3 digit angka.'
                ]
            ],
            'kelurahan' => [
                'rules'  => 'required|alpha_numeric_space|min_length[3]|max_length[100]',
                'errors' => [
                    'required'            => 'Kelurahan/Desa wajib diisi.',
                    'alpha_numeric_space' => 'Kelurahan hanya boleh berisi huruf, angka, dan spasi.',
                    'min_length'          => 'Kelurahan minimal 3 karakter.',
                    'max_length'          => 'Kelurahan maksimal 100 karakter.'
                ]
            ],
            'kecamatan' => [
                'rules'  => 'required|alpha_numeric_space|min_length[3]|max_length[100]',
                'errors' => [
                    'required'            => 'Kecamatan wajib diisi.',
                    'alpha_numeric_space' => 'Kecamatan hanya boleh berisi huruf, angka, dan spasi.',
                    'min_length'          => 'Kecamatan minimal 3 karakter.',
                    'max_length'          => 'Kecamatan maksimal 100 karakter.'
                ]
            ],
            'provinsi' => [
                'rules'  => 'required|alpha_numeric_space|min_length[3]|max_length[100]',
                'errors' => [
                    'required'            => 'Provinsi wajib diisi.',
                    'alpha_numeric_space' => 'Provinsi hanya boleh berisi huruf, angka, dan spasi.',
                    'min_length'          => 'Provinsi minimal 3 karakter.',
                    'max_length'          => 'Provinsi maksimal 100 karakter.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Mulai Database Transaction agar data aman berantai (LOGIKA UTUH PUNYA KELOMPOKMU)
        $db = \Config\Database::connect();
        $db->transStart();

        // STEP 1: Buat data akademik di t_instansi_mahasiswa terlebih dahulu
        $dataAkademik = [
            'id_instansi_pendidikan' => $this->request->getPost('id_instansi_pendidikan'),
            'id_fakultas'            => $this->request->getPost('id_fakultas'),
            'id_prodi'               => $this->request->getPost('id_prodi'),
            'jenjang_pendidikan'     => $this->request->getPost('jenjang_pendidikan'),
            'angkatan_tahun'         => $this->request->getPost('angkatan_tahun'),
            'semester'               => $this->request->getPost('semester'),
            'tahun_akademik'         => $this->request->getPost('tahun_akademik'),
            'created_by'             => 'SYSTEM_REGISTRATION'
        ];
        
        $this->M_InstansiMahasiswa->insert($dataAkademik);
        $idInstansiMahasiswaBaru = $this->M_InstansiMahasiswa->getInsertID();

        // STEP 2: Masukkan biodata ke m_mahasiswa LANGSUNG bersama ID akademiknya
        $dataMahasiswa = [
            'nik'                    => $this->request->getPost('nik'),
            'nim'                    => $this->request->getPost('nim'),
            'nama_mahasiswa'         => $this->request->getPost('nama_mahasiswa'),
            'jenis_kelamin'          => $this->request->getPost('jenis_kelamin'),
            'tgl_lahir'              => $this->request->getPost('tgl_lahir'),
            'alamat'                 => $this->request->getPost('alamat'),
            'rt'                     => $this->request->getPost('rt'),
            'rw'                     => $this->request->getPost('rw'),
            'kelurahan'              => $this->request->getPost('kelurahan'),
            'kecamatan'              => $this->request->getPost('kecamatan'),
            'provinsi'               => $this->request->getPost('provinsi'),
            'no_telp'                => $this->request->getPost('no_telp'),
            'email'                  => $this->request->getPost('email'),
            'id_instansi_mahasiswa'  => $idInstansiMahasiswaBaru
        ];
        
        $this->M_Mahasiswa->insert($dataMahasiswa);
        $idMahasiswaBaru = $this->M_Mahasiswa->getInsertID();

        // STEP 3: Update tabel t_instansi_mahasiswa untuk memasukkan id_mahasiswa yang baru didapat
        $this->M_InstansiMahasiswa->update($idInstansiMahasiswaBaru, [
            'id_mahasiswa' => $idMahasiswaBaru
        ]);

        // STEP 4: Simpan data akun log masuk mahasiswa (m_user_mahasiswa)
        $dataUser = [
            'id_mahasiswa' => $idMahasiswaBaru,
            'username'     => $this->request->getPost('username'),
            'password'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'status'       => 'AKTIF',
        ];

        $this->M_UserMahasiswa->insert($dataUser);

        // Selesaikan transaksi database
        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Gagal memproses pendaftaran data akademik Anda.');
        }

        return redirect()->to(base_url('login'))->with('success', 'Registrasi berhasil! Data akademik Anda telah disinkronkan. Silakan login.');
    }
    // --- TAMPILAN FORM LOGIN (SINGLE SCREEN) ---
    public function login()
    {
        $data['title'] = "Login Portal E-Layanan Magang";
        return view('auth/v_login', $data);
    }

    // --- VERIFIKASI LOGIN OTOMATIS (DETEKSI MULTI-ACTOR KEDINASAN) ---
   // --- VERIFIKASI LOGIN OTOMATIS (DETEKSI MULTI-ACTOR KEDINASAN + VALIDASI CI4) ---
    public function processLogin()
    {
        // 1. BENTENG VALIDASI FORM LOGIN DENGAN PESAN KUSTOM BAHASA INDONESIA
        $rules = [
            'username' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Username wajib diisi untuk masuk ke sistem.']
            ],
            'password' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Kata sandi / Password wajib diisi.']
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 1.5 VERIFIKASI GOOGLE RECAPTCHA v2 (Bypass if local/no key)
        $recaptchaResponse = trim((string)$this->request->getPost('g-recaptcha-response'));
        $recaptchaSecret   = getenv('RECAPTCHA_SECRET_KEY');

        if (!empty($recaptchaSecret)) {
            if (empty($recaptchaResponse)) {
                return redirect()->back()->withInput()->with('error', 'Peringatan Keamanan: Silakan centang kotak "I\'m not a robot" (reCAPTCHA) terlebih dahulu.');
            }

            // Gunakan file_get_contents atau cURL untuk validasi ke server Google
            $verifyUrl      = "https://www.google.com/recaptcha/api/siteverify?secret={$recaptchaSecret}&response={$recaptchaResponse}";
            $verifyResponse = @file_get_contents($verifyUrl);
            if ($verifyResponse) {
                $responseData   = json_decode($verifyResponse);
                if (!$responseData->success) {
                    return redirect()->back()->withInput()->with('error', 'Verifikasi reCAPTCHA gagal (Sistem mendeteksi aktivitas mencurigakan). Silakan coba lagi.');
                }
            }
        }

        // 2. JIKA LOLOS VALIDASI, PROSES COCOKAN DATA KE DATABASE DIMULAI
        $inputData = $this->request->getPost('username');
        $password  = $this->request->getPost('password');
        $db        = \Config\Database::connect();

        // --- VALIDASI MAHASISWA ---
        $userMahasiswa = $this->M_UserMahasiswa->where('username', $inputData)->first();

        if ($userMahasiswa) {
            if ($userMahasiswa['status'] !== 'AKTIF') {
                return redirect()->back()->withInput()->with('error', 'Akun Mahasiswa Anda berstatus nonaktif.');
            }

            if (password_verify($password, $userMahasiswa['password'])) {
                
                // Mengambil biodata langsung dan melakukan join ke tabel induk pendidikan
                $mahasiswa = $this->M_Mahasiswa->find($userMahasiswa['id_mahasiswa']);

                // Ambil data kampus pasangannya dari tabel jembatan t_instansi_mahasiswa
                $akademik = $db->table('t_instansi_mahasiswa im')
                    ->select('ip.instansi_pendidikan')
                    ->join('m_instansi_pendidikan ip', 'ip.id_instansi_pendidikan = im.id_instansi_pendidikan', 'left')
                    ->where('im.id_mahasiswa', $userMahasiswa['id_mahasiswa'])
                    ->get()
                    ->getRowArray();

                // Set data ke Session secara lengkap tanpa ada yang tertinggal
                $sessionData = [
                    'id_user_mahasiswa' => $userMahasiswa['id_user_mahasiswa'],
                    'id_mahasiswa'      => $userMahasiswa['id_mahasiswa'],
                    'username'          => $userMahasiswa['username'],
                    'nama'              => $mahasiswa['nama_mahasiswa'],
                    'nim'               => $mahasiswa['nim'], 
                    'kampus'            => (!empty($akademik)) ? $akademik['instansi_pendidikan'] : 'Belum Memilih Kampus',
                    'role'              => 'mahasiswa',
                    'isLoggedIn'        => true
                ];
                session()->set($sessionData);

                return redirect()->to(base_url('mahasiswa/dashboard'))->with('success', 'Selamat datang kembali, ' . $mahasiswa['nama_mahasiswa']);
            }
        }

        // Jika data lolos validasi form tapi tidak cocok dengan data akun manapun di DB
        return redirect()->back()->withInput()->with('error', 'Username atau Kata Sandi Anda salah!');
    }

    // --- MENAMPILKAN HALAMAN LOGIN PEGAWAI ---
    public function loginPegawai()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url(session()->get('role') . '/dashboard'));
        }
        
        $data = [
            'title' => 'Portal Login Pegawai | E-Layanan',
        ];

        return view('auth/v_login_pegawai', $data);
    }

    // --- PROSES LOGIN KHUSUS PEGAWAI ---
    public function processLoginPegawai()
    {
        $rules = [
            'nip' => [
                'rules'  => 'required',
                'errors' => ['required' => 'NIP Pegawai wajib diisi untuk masuk ke sistem.']
            ],
            'password' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Kata sandi / Password wajib diisi.']
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }



        $inputData = $this->request->getPost('nip');
        $password  = $this->request->getPost('password');
        $db        = \Config\Database::connect();

        $userPegawai = $db->table('c_user_pegawai')->where('nip', $inputData)->get()->getRowArray();

        if ($userPegawai) {
            if (isset($userPegawai['status_aktif']) && $userPegawai['status_aktif'] == 0) {
                return redirect()->back()->withInput()->with('error', 'Akun kedinasan Anda dinonaktifkan sistem.');
            }

            if (password_verify($password, $userPegawai['password'])) {
                $sessionData = [
                    'id_user_pegawai' => $userPegawai['id_user_pegawai'],
                    'nip'             => $userPegawai['nip'],
                    'nama'            => $userPegawai['nama'],
                    'id_bidang'       => $userPegawai['id_bidang'],
                    'id_user_group'   => $userPegawai['id_user_group'],
                    'group_id'        => $userPegawai['id_user_group'],
                    'isLoggedIn'      => true,
                    'logged_in'       => true
                ];

                $group = $db->table('c_user_group')->where('id', $userPegawai['id_user_group'])->get()->getRowArray();
                $sessionData['role'] = $group ? strtolower($group['group']) : 'pegawai';

                session()->set($sessionData);

                if ($sessionData['id_user_group'] == 1) {
                    return redirect()->to(base_url('admin/dashboard'))->with('success', 'Selamat datang Super Admin, ' . $userPegawai['nama']);
                } elseif ($sessionData['id_user_group'] == 2) {
                    return redirect()->to(base_url('sekretariat/dashboard'))->with('success', 'Selamat bertugas di Ruang Sekretariat, ' . $userPegawai['nama']);
                } else {
                    return redirect()->to(base_url('kabid/dashboard'))->with('success', 'Selamat bekerja kembali Kepala Bidang, ' . $userPegawai['nama']);
                }
            }
        }

        return redirect()->back()->withInput()->with('error', 'NIP atau Kata Sandi Anda salah!');
    }

    // --- LOGOUT AKUN ---
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'))->with('success', 'Anda berhasil keluar dari sistem.');
    }
}