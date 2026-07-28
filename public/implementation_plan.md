# Fitur Upload Surat Penerimaan Magang

Menambahkan fitur upload Surat Penerimaan Magang untuk role Sekretariat dan Kepala Bidang. Mahasiswa hanya dapat melihat dan mengunduh file.

## User Review Required

> [!IMPORTANT]
> Tabel `t_file_proses_magang` **belum ada** di database maupun di migration yang sudah ada. Saya akan membuat migration baru untuk tabel ini. Pastikan Anda menjalankan `php spark migrate` setelah implementasi selesai.

> [!WARNING]
> Session saat ini menggunakan `group_id` untuk membedakan role (bukan key `role`):
> - `group_id = 1` → Superadmin/Sekretariat
> - `group_id = 3` → Kepala Bidang
>
> Belum ada role `mahasiswa` di sistem auth yang ada. Fitur ini akan disiapkan untuk Sekretariat dan Kabid terlebih dahulu. Akses mahasiswa perlu route group dan auth filter terpisah yang belum tersedia di proyek ini.

## Open Questions

> [!IMPORTANT]
> 1. **Akses Mahasiswa**: Saat ini tidak ada modul Mahasiswa (route group, auth filter, sidebar, atau layout). Apakah Anda ingin saya juga membuat modul Mahasiswa lengkap, atau cukup fitur upload untuk Sekretariat & Kabid saja dulu?
> 2. **Primary Key `t_file_proses_magang`**: Apakah `id_file_selesai_magang` menggunakan auto-increment, atau format custom?

## Proposed Changes

### Database Migration

#### [NEW] [2026-07-21-020000_CreateFileProsesMagangTable.php](file:///d:/Data/sistem_magang/app/Database/Migrations/2026-07-21-020000_CreateFileProsesMagangTable.php)

Membuat tabel `t_file_proses_magang` dengan kolom:
- `id_file_selesai_magang` (INT, unsigned, auto_increment, PK)
- `id_persetujuan_magang` (INT, unsigned)
- `id_file` (INT, unsigned)
- `nama_file` (VARCHAR 255)
- `path_file` (VARCHAR 500)
- `proses_magang` (VARCHAR 100, default: `SURAT_PENERIMAAN_MAGANG`)
- `created_at` (DATETIME, nullable)
- `created_by` (INT, nullable)
- `updated_at` (DATETIME, nullable)
- `updated_by` (INT, nullable)

---

### Models

#### [NEW] [M_File.php](file:///d:/Data/sistem_magang/app/Models/Sekretariat/M_File.php)

Model untuk tabel `m_file`. Method:
- `getActiveFiles()` → ambil data `WHERE status_aktif = 1`

#### [NEW] [M_FileProsesMagang.php](file:///d:/Data/sistem_magang/app/Models/Sekretariat/M_FileProsesMagang.php)

Model untuk tabel `t_file_proses_magang`. Method:
- `getSuratByPersetujuan($id_persetujuan)` → ambil file surat penerimaan per persetujuan
- `getExistingSurat($id_persetujuan)` → cek file yang sudah ada (untuk update)

---

### Controller Sekretariat

#### [NEW] [C_SuratPenerimaan.php](file:///d:/Data/sistem_magang/app/Controllers/Sekretariat/C_SuratPenerimaan.php)

Controller untuk Sekretariat dengan methods:
- `index($id_persetujuan)` → Tampilkan form upload + daftar file yang sudah diunggah
- `store()` → Simpan file baru (validasi + upload + insert DB)
- `update($id_file_selesai)` → Ganti file (hapus lama + upload baru + update DB)
- `download($id_file_selesai)` → Download file

Validasi file:
```
uploaded[file_surat] | max_size[file_surat,5120] | ext_in[file_surat,pdf,doc,docx]
mime_in[file_surat,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document]
```

File disimpan ke: `writable/uploads/surat_penerimaan_magang/`

### Controller Kabid

#### [NEW] [C_SuratPenerimaanKabid.php](file:///d:/Data/sistem_magang/app/Controllers/Kabid/C_SuratPenerimaanKabid.php)

Controller identik untuk Kepala Bidang (menggunakan layout `L_master_kabid`):
- `index($id_persetujuan)` → Form upload + daftar file
- `store()` → Simpan file baru
- `update($id_file_selesai)` → Ganti file
- `download($id_file_selesai)` → Download file

---

### Views

#### [NEW] [v_surat_penerimaan.php](file:///d:/Data/sistem_magang/app/Views/dashboard/sekretariat/v_surat_penerimaan.php)

View untuk Sekretariat (extends `L_master`):
- Back button ke halaman sebelumnya
- Info mahasiswa header (nama, NIM, universitas, periode magang)
- Form upload: dropdown jenis file (dari `m_file`) + input file + tombol Upload
- Tabel daftar file sudah diunggah:
  - Kolom: No, Jenis File, Nama File, Tanggal Upload, Pengunggah, Aksi
  - Aksi: Download (semua role) + Ganti File (Sekretariat/Kabid)
- Flash messages (success/error) dengan SweetAlert2
- Validasi error display

#### [NEW] [v_surat_penerimaan_kabid.php](file:///d:/Data/sistem_magang/app/Views/dashboard/kabid/v_surat_penerimaan_kabid.php)

View identik untuk Kabid (extends `L_master_kabid`)

---

### Routes

#### [MODIFY] [Routes.php](file:///d:/Data/sistem_magang/app/Config/Routes.php)

Tambahkan routes baru di dalam group `sekretariat`:
```php
// Surat Penerimaan Magang
$routes->get('surat-penerimaan/(:num)', 'C_SuratPenerimaan::index/$1');
$routes->post('surat-penerimaan/store', 'C_SuratPenerimaan::store');
$routes->post('surat-penerimaan/update/(:num)', 'C_SuratPenerimaan::update/$1');
$routes->get('surat-penerimaan/download/(:num)', 'C_SuratPenerimaan::download/$1');
```

Tambahkan routes baru di dalam group `kabid`:
```php
// Surat Penerimaan Magang
$routes->get('surat-penerimaan/(:num)', 'C_SuratPenerimaanKabid::index/$1');
$routes->post('surat-penerimaan/store', 'C_SuratPenerimaanKabid::store');
$routes->post('surat-penerimaan/update/(:num)', 'C_SuratPenerimaanKabid::update/$1');
$routes->get('surat-penerimaan/download/(:num)', 'C_SuratPenerimaanKabid::download/$1');
```

---

### Integrasi dengan Halaman Existing

Fitur ini diakses melalui parameter `id_persetujuan_magang`, sehingga bisa ditautkan dari:
- Halaman Riwayat Sekretariat → tombol aksi "Upload Surat"
- Halaman Penempatan Kabid → tombol aksi "Upload Surat"

Tidak perlu mengubah sidebar atau layout yang sudah ada.

## Verification Plan

### Manual Verification
1. Jalankan `php spark migrate` untuk membuat tabel baru
2. Login sebagai Sekretariat → akses URL `/sekretariat/surat-penerimaan/{id}` 
3. Upload file PDF → pastikan file tersimpan di `writable/uploads/surat_penerimaan_magang/`
4. Verifikasi metadata tersimpan di `t_file_proses_magang`
5. Download file → pastikan file terunduh dengan benar
6. Ganti file → pastikan file lama terhapus dari server dan database terupdate
7. Login sebagai Kabid → ulangi langkah 2-6 dengan URL `/kabid/surat-penerimaan/{id}`
8. Validasi: upload file > 5MB → harus ditolak
9. Validasi: upload file .exe → harus ditolak
