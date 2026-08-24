# PROJECT CONTEXT

Saya sedang mengembangkan aplikasi web **Sistem Informasi E-Layanan Permohonan & Kegiatan Akademik** pada Dinas Komunikasi dan Informatika Kota Tangerang.

Framework yang digunakan adalah **CodeIgniter 4 (CI4)** 

Mohon pahami keseluruhan proyek ini terlebih dahulu sebelum memberikan solusi.

**Jangan langsung menghasilkan kode apabila saya belum memintanya.**

Selalu analisis dahulu alur bisnis, database, relasi tabel, dan struktur project sebelum memberikan implementasi.

---


Seluruh implementasi harus mengikuti standar CodeIgniter 4.



---

# Aktor Sistem

Sistem memiliki empat aktor utama.

## 1. Mahasiswa

Mahasiswa dapat:

- Registrasi akun
- Login
- Mengelola profil
- Mengajukan permohonan
- Menyimpan Draft
- Mengedit Draft
- Membatalkan permohonan sebelum diproses
- Mengunggah dokumen persyaratan
- Melihat status permohonan
- Melihat catatan Sekretariat
- Melakukan revisi apabila file permohonan yg dikirim ada yg salah dan disuru Sekretariat
- Mengisi Logbook bila membuthkan
- Mengunduh Surat Penerimaan Magang
- Mengunduh Surat Selesai Magang
- Mengunduh Sertifikat

---

## 2. Sekretariat

Sekretariat merupakan pintu masuk seluruh permohonan.

Tugas Sekretariat:

- Verifikasi administrasi
- Memeriksa seluruh dokumen
- Memberikan catatan revisi bila dokumen permohonan mhs ada yg salah
- Menolak permohonan
- Menentukan bidang tujuan berdasarkan kompetensi mahasiswa
- Mengirim disposisi ke Bidang
- hanya bisa Upload Surat Penerimaan Magang
- Mengelola seluruh permohonan


---

## 3. Bidang

Bidang menerima permohonan yang telah didisposisikan oleh Sekretariat.

Bidang dapat:

- Melihat detail mahasiswa
- Melihat dokumen permohonan
- Menyetujui disposisi dari sekretariat
- Memberikan catatan
- kuota bidang
- Menambah kuota untuk bidangnya masing2
- Melihat mahasiswa aktif
- Melihat riwayat magang
- Menyetujui logbook
- Upload Surat Selesai Magang
- Upload Surat Penerimaan Magang
- Upload Sertifikat
- Menyelesaikan magang mahasiswa
- Membatalkan magang apabila diperlukan

---

## 4. Super Admin

Super Admin hanya mengelola master data.

Menu:

- Dashboard
- Manajemen User
- Manajemen Menu
- Hak Akses
- bertangunggung jawab semua tabel master pokonya
- Konfigurasi Sistem

Super Admin tidak ikut memproses permohonan mahasiswa.

---

# Jenis Permohonan

Sistem memiliki beberapa jenis permohonan.

- Magang / PKL
- Penelitian Skripsi / TA
- Observasi
- Uji Coba Produk

Setiap jenis permohonan memiliki:

- Form berbeda
- Dokumen berbeda
- tergantung kebutuhannya seperti apa kira2
---


# Status Mahasiswa

Status yang terlihat oleh Mahasiswa hanya:

- Menunggu
- Disetujui
- Ditolak

Mahasiswa tidak mengetahui proses internal seperti disposisi.

Catatan revisi tetap ditampilkan pada detail permohonan.

---

# Logika Revisi

Sekretariat dapat memberikan status revisi.

Mahasiswa tidak membuat permohonan baru.

Mahasiswa hanya memperbaiki dokumen pada permohonan yang sama.

---

# Draft

Mahasiswa dapat:

- Simpan Draft
- Edit Draft
- Kirim Draft menjadi permohonan

Draft belum diproses Sekretariat.

---

# Logbook

Logbook hanya aktif apabila:

Permohonan telah disetujui.

dan apabila memang mahasiswa dalah kegiatannya memerlukan isi logbook, ya/tidak nya nanti bidang yg ngautur

---

# Upload Dokumen


Sekretariat

- Upload Surat Penerimaan Magang

Kepala Bidang

- Upload Surat Penerimaan Magang
- Upload Surat Selesai Magang
- Upload Sertifikat

(bisa semua)

---

---


---

---

# Ketika Memberikan Solusi

Sebelum memberikan kode:

1. Analisis dahulu struktur project.
2. Analisis Controller terkait.
3. Analisis Model.
4. Analisis Database.
5. Analisis Relasi.
6. Analisis Alur Bisnis.

Jangan membuat file baru apabila file lama masih bisa digunakan.

Gunakan struktur project yang sudah ada.

Jangan mengubah nama tabel, relasi, atau alur bisnis tanpa persetujuan saya

Jika terdapat ambiguitas pada alur, tanyakan terlebih dahulu sebelum mengimplementasikan solusi.

Apabila saya meminta implementasi fitur, berikan solusi yang mengikuti standar CodeIgniter 4, mudah dipelihara, dan konsisten dengan arsitektur proyek.