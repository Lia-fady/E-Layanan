<?php

/**
 * Kode    : M_Auth.php
 * Path    : app/Models/Sekretariat/M_Auth.php
 * Deskripsi : Model autentikasi untuk modul Sekretariat.
 *             Mengelola query ke tabel c_user_pegawai untuk proses login.
 *             Method login() memverifikasi username, password, dan status aktif user.
 *             Catatan: Password disimpan dalam plain text sesuai data CSV.
 *             Pada production, sebaiknya gunakan password_hash/password_verify.
 */

namespace App\Models\Sekretariat;

use CodeIgniter\Model;

class M_Auth extends Model
{
    protected $table            = 'c_user_pegawai';
    protected $primaryKey       = 'id_user_pegawai';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nip', 'password', 'nama', 'id_user_group', 'id_bidang', 'status_aktif', 'kode_unor'];

    /**
     * Proses login user.
     * Mencari data user berdasarkan username (NIP) yang cocok,
     * memverifikasi password menggunakan password_verify(),
     * serta status harus aktif (status_aktif = '1').
     *
     * @param string $username Username (NIP) yang diinput
     * @param string $password Password yang diinput (plain text)
     *
     * @return array|null Data user jika ditemukan, null jika tidak valid
     */
    public function login(string $username, string $password)
    {
        // Cari user berdasarkan NIP dan status aktif
        $user = $this->where('nip', $username)
                     ->where('status_aktif', '1')
                     ->first();

        // Verifikasi password menggunakan password_verify
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return null;
    }
}
