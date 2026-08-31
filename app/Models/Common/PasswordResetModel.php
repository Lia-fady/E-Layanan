<?php

namespace App\Models\Common;

use CodeIgniter\Model;

/**
 * Model: PasswordResetModel
 * Mengelola tabel password_resets untuk fitur Lupa Password.
 * Menyimpan dan memvalidasi token reset password yang aman.
 */
class PasswordResetModel extends Model
{
    protected $table            = 'password_resets';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['email', 'token', 'created_at', 'expires_at', 'used_at'];

    // Tidak menggunakan timestamps otomatis CI4 karena kita kelola sendiri
    protected $useTimestamps = false;

    /**
     * Membuat token reset password yang aman.
     * Menghapus token lama yang belum terpakai untuk email yang sama,
     * lalu membuat token baru dengan masa berlaku 1 jam.
     *
     * @param string $email Email pemohon
     * @return string Token yang di-generate (plain text, untuk dikirim via email)
     */
    public function createToken(string $email): string
    {
        // Hapus token lama yang belum dipakai untuk email ini
        $this->where('email', $email)
             ->where('used_at', null)
             ->delete();

        // Generate secure random token (64 karakter hex)
        $token = bin2hex(random_bytes(32));

        $this->insert([
            'email'      => $email,
            'token'      => hash('sha256', $token), // Simpan hash-nya di DB
            'created_at' => date('Y-m-d H:i:s'),
            'expires_at' => date('Y-m-d H:i:s', strtotime('+1 hour')),
            'used_at'    => null,
        ]);

        return $token; // Kembalikan plain text token untuk dikirim lewat email
    }

    /**
     * Memvalidasi token reset password.
     * Token harus cocok (hash), belum digunakan (used_at NULL),
     * dan belum melampaui waktu kadaluarsa (expires_at).
     *
     * @param string $token Token plain text dari URL
     * @return array|null Data reset jika valid, null jika tidak valid
     */
    public function validateToken(string $token): ?array
    {
        $hashedToken = hash('sha256', $token);

        return $this->where('token', $hashedToken)
                    ->where('used_at', null)
                    ->where('expires_at >=', date('Y-m-d H:i:s'))
                    ->first();
    }

    /**
     * Menandai token sebagai sudah digunakan.
     * Mengisi kolom used_at dengan waktu saat ini.
     *
     * @param int $id ID record password_resets
     * @return bool
     */
    public function markAsUsed(int $id): bool
    {
        return $this->update($id, [
            'used_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Membersihkan token-token yang sudah kadaluarsa.
     * Bisa digunakan untuk cron job pembersihan rutin.
     *
     * @return void
     */
    public function cleanExpiredTokens(): void
    {
        $this->where('expires_at <', date('Y-m-d H:i:s'))
             ->delete();
    }
}
