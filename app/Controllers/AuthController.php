<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MahasiswaModel;
use App\Models\UserMahasiswaModel;
use App\Models\InstansiMahasiswaModel; 
use App\Models\InstansiPendidikanModel; 
use App\Models\MasterKelasModel;

use App\Models\PasswordResetModel;

class AuthController extends BaseController
{
    protected $mahasiswaModel;
    protected $userMahasiswaModel;
    protected $instansiMahasiswaModel;
    protected $instansiPendidikanModel;
    protected $masterKelasModel;
    protected $passwordResetModel;

    public function __construct()
    {
        // Inisialisasi model-model penunjang data akademik & auth
        $this->mahasiswaModel          = new MahasiswaModel();
        $this->userMahasiswaModel      = new UserMahasiswaModel();
        $this->instansiMahasiswaModel  = new InstansiMahasiswaModel();
        $this->instansiPendidikanModel = new InstansiPendidikanModel();
        $this->masterKelasModel        = new MasterKelasModel();
        $this->passwordResetModel      = new PasswordResetModel();
    }

    // --- TAMPILAN FORM REGISTRASI MAHASISWA ---
    public function register()
    {
        $db = \Config\Database::connect();
        // Mengambil data master kampus aktif untuk dropdown utama
        $data['kampus'] = $this->instansiPendidikanModel->where('status', 'AKTIF')->findAll();
        
        // Mengambil data master jenjang pendidikan
        $data['jenjang'] = $db->table('m_jenjang_pendidikan')->where('status', 'AKTIF')->get()->getResultArray();
        
        // Mengambil data jurusan
        $data['jurusan_smk'] = $db->table('m_jurusan')->where('status', 'AKTIF')->get()->getResultArray();

        // Mengambil data master provinsi untuk dropdown alamat
        $data['provinsi'] = $db->table('m_provinsi')->get()->getResultArray();
        
        $data['kelas'] = $this->masterKelasModel->where('status', 'AKTIF')->findAll();

        $data['title']  = "Registrasi Akun Mahasiswa";

        return view('auth/register', $data);
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
        $builder->select('id_prodi, nama_prodi');
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
            'id_jenjang_pendidikan' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Jenjang pendidikan wajib dipilih.']
            ],
            'tgl_lahir' => [
                'rules'  => 'required|valid_date',
                'errors' => [
                    'required' => 'Tanggal lahir wajib diisi.',
                    'valid_date' => 'Format tanggal lahir tidak valid.'
                ]
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
                    'required'      => 'Nomor Induk (NIM/NISN) wajib diisi.',
                    'numeric'       => 'Nomor Induk hanya boleh berisi angka tanpa spasi atau karakter lainnya.',
                    'min_length'    => 'Nomor Induk minimal harus memiliki 5 digit angka.',
                    'max_length'    => 'Nomor Induk maksimal 25 karakter.',
                    'is_unique'     => 'Nomor Induk ini sudah terdaftar di sistem E-Layanan.'
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
                    'valid_email' => 'Format email tidak valid (harus mengandung @, contoh: @gmail.com).',
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
            'id_kelurahan' => [
                'rules'  => 'required',
                'errors' => [
                    'required'            => 'Kelurahan/Desa wajib dipilih.'
                ]
            ]
        ];

        // Conditional rules for SMA vs Mahasiswa
        $isSiswa = !empty($this->request->getPost('nama_sekolah'));
        
        if (!$isSiswa) {
            $rules['id_instansi_pendidikan'] = [
                'rules'  => 'required',
                'errors' => ['required' => 'Instansi Pendidikan wajib dipilih.']
            ];
            $rules['id_fakultas'] = [
                'rules'  => 'required',
                'errors' => ['required' => 'Fakultas wajib dipilih.']
            ];
            $rules['id_prodi'] = [
                'rules'  => 'required',
                'errors' => ['required' => 'Jurusan wajib dipilih.']
            ];
            $rules['tahun_akademik'] = [
                'rules'  => 'required',
                'errors' => ['required' => 'Tahun akademik berjalan wajib diisi.']
            ];
            $rules['angkatan_tahun'] = [
                'rules'  => 'required|numeric|exact_length[4]',
                'errors' => [
                    'required'     => 'Tahun angkatan wajib diisi.',
                    'numeric'      => 'Tahun angkatan harus berupa angka.',
                    'exact_length' => 'Tahun angkatan harus 4 digit.'
                ]
            ];
        } else {
            $rules['nama_sekolah'] = [
                'rules' => 'required|is_not_unique[m_instansi_pendidikan.id_instansi_pendidikan]', 
                'errors' => [
                    'required' => 'Instansi Pendidikan wajib dipilih.',
                    'is_not_unique' => 'Instansi Pendidikan tidak valid.'
                ]
            ];
            $rules['jurusan_smk'] = [
                'rules' => 'required|is_not_unique[m_jurusan.id_jurusan]', 
                'errors' => [
                    'required' => 'Jurusan wajib dipilih.',
                    'is_not_unique' => 'Jurusan tidak valid.'
                ]
            ];
        }

        if ($isSiswa) {
            $rules['nim'] = [
                'rules'  => 'required|numeric|exact_length[8]|is_unique[m_mahasiswa.nim]',
                'errors' => [
                    'required'      => 'NISN wajib diisi.',
                    'numeric'       => 'NISN hanya boleh berisi angka.',
                    'exact_length'  => 'NISN harus persis 8 digit angka.',
                    'is_unique'     => 'NISN ini sudah terdaftar.'
                ]
            ];
            $rules['id_kelas'] = [
                'rules'  => 'required',
                'errors' => ['required' => 'Kelas wajib dipilih.']
            ];
        } else {
            $rules['semester'] = [
                'rules'  => 'required|numeric|greater_than[0]|less_than_equal_to[14]',
                'errors' => [
                    'required' => 'Semester wajib diisi.',
                    'numeric'  => 'Semester harus berupa angka bulat.',
                    'greater_than' => 'Tidak valid.',
                    'less_than_equal_to' => 'Tidak valid.'
                ]
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Validasi tambahan: Tanggal lahir tidak boleh di masa depan
        $tgl_lahir = $this->request->getPost('tgl_lahir');
        if (!empty($tgl_lahir) && strtotime($tgl_lahir) > time()) {
            return redirect()->back()->withInput()->with('errors', ['tgl_lahir' => 'Tanggal lahir tidak logis (tidak boleh lebih dari hari ini).']);
        }

        // 2. Mulai Database Transaction agar data aman berantai (LOGIKA UTUH PUNYA KELOMPOKMU)
        $db = \Config\Database::connect();
        $db->transStart();

        // Cek Jenjang (Siswa vs Mahasiswa logic based on UI)
        $id_instansi = $this->request->getPost('id_instansi_pendidikan');
        $nama_sekolah = $this->request->getPost('nama_sekolah'); // Untuk SMA/SMK ini sekarang berisi id_instansi_pendidikan
        $id_jurusan_smk = $this->request->getPost('jurusan_smk'); // Untuk SMA/SMK ini sekarang berisi id_jurusan
        $nama_jurusan_str = null;
        
        if (empty($id_instansi) && !empty($nama_sekolah)) {
            $id_instansi = $nama_sekolah;
        }

        if (!empty($id_jurusan_smk) && is_numeric($id_jurusan_smk)) {
            $jurusanRow = $db->table('m_jurusan')->where('id_jurusan', $id_jurusan_smk)->get()->getRow();
            if ($jurusanRow) {
                $nama_jurusan_str = $jurusanRow->nama_jurusan;
            }
        }

        // STEP 1: Buat data akademik di t_instansi_mahasiswa terlebih dahulu
        $dataAkademik = [
            'id_instansi_pendidikan' => $id_instansi,
            'id_fakultas'            => $this->request->getPost('id_fakultas') ?: null,
            'id_prodi'               => $this->request->getPost('id_prodi') ?: null,
            'id_jenjang_pendidikan'  => $this->request->getPost('id_jenjang_pendidikan'),
            'id_jurusan'             => $id_jurusan_smk ?: null,
            'jurusan'                => $nama_jurusan_str ?: null,
            'angkatan_tahun'         => $this->request->getPost('angkatan_tahun'),
            'semester'               => $this->request->getPost('semester') ?: null,
            'id_kelas'               => $this->request->getPost('id_kelas') ?: null,
            'tahun_akademik'         => $this->request->getPost('tahun_akademik') ?: null,
            'created_by'             => 'SYSTEM_REGISTRATION'
        ];
        
        if (!$this->instansiMahasiswaModel->insert($dataAkademik)) {
            $dbError = $this->instansiMahasiswaModel->errors();
            $db->transRollback();
            throw new \RuntimeException('Gagal insert instansi: ' . print_r($dbError, true) . ' | DB Error: ' . print_r($db->error(), true));
        }
        $idInstansiMahasiswaBaru = $this->instansiMahasiswaModel->getInsertID();

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
            'id_kelurahan'           => $this->request->getPost('id_kelurahan'),
            'no_telp'                => $this->request->getPost('no_telp'),
            'email'                  => $this->request->getPost('email'),
            'id_instansi_mahasiswa'  => $idInstansiMahasiswaBaru
        ];
        
        if (!$this->mahasiswaModel->insert($dataMahasiswa)) {
            $dbError = $this->mahasiswaModel->errors();
            $db->transRollback();
            throw new \RuntimeException('Gagal insert mahasiswa: ' . print_r($dbError, true) . ' | DB Error: ' . print_r($db->error(), true));
        }
        $idMahasiswaBaru = $this->mahasiswaModel->getInsertID();

        // STEP 3: Update tabel t_instansi_mahasiswa untuk memasukkan id_mahasiswa yang baru didapat
        if (!$this->instansiMahasiswaModel->update($idInstansiMahasiswaBaru, ['id_mahasiswa' => $idMahasiswaBaru])) {
            $db->transRollback();
            throw new \RuntimeException('Gagal update instansi dengan id_mahasiswa. DB Error: ' . print_r($db->error(), true));
        }

        // STEP 4: Simpan data akun log masuk mahasiswa (m_user_mahasiswa)
        $dataUser = [
            'id_mahasiswa' => $idMahasiswaBaru,
            'username'     => $this->request->getPost('username'),
            'password'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'status'       => 'AKTIF',
        ];

        $this->userMahasiswaModel->insert($dataUser);

        // Selesaikan transaksi database
        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Gagal memproses pendaftaran. Silakan coba lagi atau hubungi admin.');
        }

        return redirect()->to(base_url('login'))->with('success', 'Pendaftaran berhasil! Akun Anda telah dibuat. Silakan login.');
    }
    // --- TAMPILAN FORM LOGIN (SINGLE SCREEN) ---
    public function login()
    {
        $data['title'] = "Login Portal E-Layanan Magang";
        return view('auth/login', $data);
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
        $userMahasiswa = $this->userMahasiswaModel->where('username', $inputData)->first();

        if ($userMahasiswa) {
            if ($userMahasiswa['status'] !== 'AKTIF') {
                return redirect()->back()->withInput()->with('error', 'Akun Mahasiswa Anda berstatus nonaktif.');
            }

            if (password_verify($password, $userMahasiswa['password'])) {
                
                // Mengambil biodata langsung dan melakukan join ke tabel induk pendidikan
                $mahasiswa = $this->mahasiswaModel->find($userMahasiswa['id_mahasiswa']);

                // Ambil data kampus pasangannya dari tabel jembatan t_instansi_mahasiswa beserta jenjang pendidikannya
                $akademik = $db->table('t_instansi_mahasiswa im')
                    ->select('ip.instansi_pendidikan, jp.nama_jenjang')
                    ->join('m_instansi_pendidikan ip', 'ip.id_instansi_pendidikan = im.id_instansi_pendidikan', 'left')
                    ->join('m_jenjang_pendidikan jp', 'jp.id_jenjang_pendidikan = im.id_jenjang_pendidikan', 'left')
                    ->where('im.id_mahasiswa', $userMahasiswa['id_mahasiswa'])
                    ->get()
                    ->getRowArray();

                // Deteksi kategori pelajar berdasarkan jenjang pendidikan
                $kategori_pelajar = 'Mahasiswa'; // Default
                if (!empty($akademik) && !empty($akademik['nama_jenjang'])) {
                    $jenjang = strtoupper($akademik['nama_jenjang']);
                    if (strpos($jenjang, 'SMA') !== false || strpos($jenjang, 'SMK') !== false || strpos($jenjang, 'SLTA') !== false) {
                        $kategori_pelajar = 'Siswa';
                    }
                }

                // Set data ke Session secara lengkap tanpa ada yang tertinggal
                $sessionData = [
                    'id_user_mahasiswa' => $userMahasiswa['id_user_mahasiswa'],
                    'id_mahasiswa'      => $userMahasiswa['id_mahasiswa'],
                    'username'          => $userMahasiswa['username'],
                    'nama'              => $mahasiswa['nama_mahasiswa'],
                    'nim'               => $mahasiswa['nim'], 
                    'kampus'            => (!empty($akademik)) ? $akademik['instansi_pendidikan'] : 'Belum Memilih Kampus',
                    'role'              => 'mahasiswa',
                    'kategori_pelajar'  => $kategori_pelajar,
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

        return view('auth/login_pegawai', $data);
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
                    'isLoggedIn'      => true
                ];

                $group = $db->table('c_user_group')->where('id', $userPegawai['id_user_group'])->get()->getRowArray();
                $sessionData['role'] = $group ? strtolower($group['group']) : 'pegawai';

                session()->set($sessionData);

                if ($sessionData['id_user_group'] == 1) {
                    return redirect()->to(base_url('superadmin/dashboard'))->with('success', 'Selamat datang Super Admin, ' . $userPegawai['nama']);
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

    // =========================================================================
    // FITUR LUPA PASSWORD (RESET PASSWORD VIA EMAIL)
    // =========================================================================

    /**
     * Menampilkan halaman form Lupa Password.
     * Pengguna diminta memasukkan email yang terdaftar.
     */
    public function forgotPassword()
    {
        $data['title'] = 'Lupa Password - E-Layanan Akademik';
        return view('auth/forgot_password', $data);
    }

    /**
     * Memproses permintaan lupa password.
     * Menggunakan teknik Anti-Enumeration: pesan yang ditampilkan
     * selalu sama, terlepas email ditemukan atau tidak.
     */
    public function processForgotPassword()
    {
        // Validasi input email
        $rules = [
            'email' => [
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required'    => 'Alamat email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Validasi Google reCAPTCHA v2
        $recaptchaResponse = trim((string)$this->request->getPost('g-recaptcha-response'));
        $recaptchaSecret   = getenv('RECAPTCHA_SECRET_KEY');

        if (!empty($recaptchaSecret)) {
            if (empty($recaptchaResponse)) {
                return redirect()->back()->withInput()->with('error', 'Peringatan Keamanan: Silakan centang kotak "I\'m not a robot" (reCAPTCHA) terlebih dahulu.');
            }

            $verifyUrl      = "https://www.google.com/recaptcha/api/siteverify?secret={$recaptchaSecret}&response={$recaptchaResponse}";
            $verifyResponse = @file_get_contents($verifyUrl);
            if ($verifyResponse) {
                $responseData   = json_decode($verifyResponse);
                if (!$responseData->success) {
                    return redirect()->back()->withInput()->with('error', 'Verifikasi reCAPTCHA gagal. Silakan coba lagi.');
                }
            }
        }

        $email = $this->request->getPost('email');

        // Pesan umum (Anti-Enumeration) - selalu ditampilkan
        $genericMessage = 'Jika email terdaftar di sistem kami, kami akan mengirimkan tautan untuk mengatur ulang password Anda. Silakan cek kotak masuk dan folder spam email Anda.';

        // Cari email di tabel m_mahasiswa
        $mahasiswa = $this->mahasiswaModel->where('email', $email)->first();

        if ($mahasiswa) {
            // Email ditemukan — buat token dan kirim email
            $token = $this->passwordResetModel->createToken($email);
            $resetLink = base_url("reset-password/{$token}");

            // Kirim email menggunakan CodeIgniter Email Service
            $this->_sendResetEmail($email, $mahasiswa['nama_mahasiswa'], $resetLink);
        }

        // Selalu tampilkan pesan yang sama (keamanan anti-enumeration)
        return redirect()->to(base_url('forgot-password'))->with('info', $genericMessage);
    }

    /**
     * Menampilkan halaman form Reset Password.
     * Memvalidasi token dari URL sebelum menampilkan form.
     *
     * @param string $token Token reset dari URL
     */
    public function resetPassword($token = null)
    {
        if (empty($token)) {
            return redirect()->to(base_url('login'))->with('error', 'Token reset password tidak valid.');
        }

        // Validasi token
        $resetData = $this->passwordResetModel->validateToken($token);

        if (!$resetData) {
            return redirect()->to(base_url('login'))->with('error', 'Tautan reset password tidak valid atau sudah kadaluarsa. Silakan ajukan permintaan baru.');
        }

        $data = [
            'title' => 'Buat Password Baru - E-Layanan Akademik',
            'token' => $token,
        ];

        return view('auth/reset_password', $data);
    }

    /**
     * Memproses penyimpanan password baru.
     * Memvalidasi token sekali lagi, lalu update password di database.
     */
    public function processResetPassword()
    {
        // Validasi input
        $rules = [
            'token' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Token reset tidak ditemukan.']
            ],
            'password' => [
                'rules'  => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/]',
                'errors' => [
                    'required'    => 'Password baru wajib diisi.',
                    'min_length'  => 'Password minimal 8 karakter.',
                    'regex_match' => 'Password harus mengandung minimal satu huruf besar, huruf kecil, angka, dan simbol khusus (@$!%*?&).'
                ]
            ],
            'password_confirm' => [
                'rules'  => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi password wajib diisi.',
                    'matches'  => 'Konfirmasi password tidak cocok dengan password baru.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            $token = $this->request->getPost('token');
            return redirect()->to(base_url("reset-password/{$token}"))->withInput()->with('errors', $this->validator->getErrors());
        }

        $token    = $this->request->getPost('token');
        $password = $this->request->getPost('password');

        // Validasi token sekali lagi (anti-tampering)
        $resetData = $this->passwordResetModel->validateToken($token);

        if (!$resetData) {
            return redirect()->to(base_url('login'))->with('error', 'Tautan reset password sudah tidak valid. Silakan ajukan permintaan baru.');
        }

        // Cari mahasiswa berdasarkan email
        $mahasiswa = $this->mahasiswaModel->where('email', $resetData['email'])->first();

        if (!$mahasiswa) {
            return redirect()->to(base_url('login'))->with('error', 'Terjadi kesalahan internal. Silakan coba lagi.');
        }

        // Update password di tabel m_user_mahasiswa
        $userMahasiswa = $this->userMahasiswaModel->where('id_mahasiswa', $mahasiswa['id_mahasiswa'])->first();

        if ($userMahasiswa) {
            $this->userMahasiswaModel->update($userMahasiswa['id_user_mahasiswa'], [
                'password' => password_hash($password, PASSWORD_DEFAULT),
            ]);
        }

        // Tandai token sebagai sudah digunakan
        $this->passwordResetModel->markAsUsed($resetData['id']);

        return redirect()->to(base_url('login'))->with('success', 'Password Anda berhasil diubah! Silakan masuk dengan password baru Anda.');
    }

    /**
     * Endpoint API untuk mengecek keunikan field via AJAX di form registrasi.
     * Mengembalikan Response JSON: {"status": "available" | "taken"}
     */
    public function checkUniqueField()
    {
        $field = $this->request->getPost('field');
        $value = $this->request->getPost('value');

        if (empty($field) || empty($value)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid parameters']);
        }

        $isTaken = false;

        switch ($field) {
            case 'nik':
                $cek = $this->mahasiswaModel->where('nik', $value)->first();
                if ($cek) $isTaken = true;
                break;
            case 'nim':
                $cek = $this->mahasiswaModel->where('nim', $value)->first();
                if ($cek) $isTaken = true;
                break;
            case 'email':
                $cek = $this->mahasiswaModel->where('email', $value)->first();
                if ($cek) $isTaken = true;
                break;
            case 'username':
                $cek = $this->userMahasiswaModel->where('username', $value)->first();
                if ($cek) $isTaken = true;
                break;
            default:
                return $this->response->setJSON(['status' => 'error', 'message' => 'Unknown field']);
        }

        if ($isTaken) {
            return $this->response->setJSON(['status' => 'taken']);
        } else {
            return $this->response->setJSON(['status' => 'available']);
        }
    }

    /**
     * Mengirimkan email reset password menggunakan layanan email CI4.
     * Method private, hanya dipanggil dari processForgotPassword().
     *
     * @param string $toEmail Email tujuan
     * @param string $nama Nama penerima
     * @param string $resetLink Link reset password
     * @return bool
     */
    private function _sendResetEmail(string $toEmail, string $nama, string $resetLink): bool
    {
        $config = new \Config\Email();
        $email = \Config\Services::email();

        // Ambil konfigurasi atau berikan fallback dummy jika .env belum diisi (untuk cegah error no From header)
        $fromEmail = !empty($config->fromEmail) ? $config->fromEmail : 'no-reply@tangerangkota.go.id';
        $fromName  = !empty($config->fromName) ? $config->fromName : 'E-Layanan Akademik';
        
        $email->setFrom($fromEmail, $fromName);
        $email->setTo($toEmail);
        $email->setSubject('Reset Password - E-Layanan Akademik Kominfo Kota Tangerang');

        // Render email template view
        $message = view('auth/email_reset_password', [
            'nama'      => $nama,
            'resetLink' => $resetLink,
        ]);

        $email->setMessage($message);

        if ($email->send(false)) {
            return true;
        }

        // Log error jika gagal kirim (tidak di-expose ke user)
        log_message('error', 'Gagal mengirim email reset password ke: ' . $toEmail);
        log_message('error', $email->printDebugger(['headers']));

        return false;
    }
}