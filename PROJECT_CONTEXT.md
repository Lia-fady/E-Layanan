# PROJECT CONTEXT

Saya sedang mengembangkan aplikasi web **Sistem Informasi E-Layanan Permohonan & Kegiatan Akademik** pada Dinas Komunikasi dan Informatika Kota Tangerang.

Framework yang digunakan adalah **CodeIgniter 4 (CI4)**.

Sebelum memberikan solusi, pahami terlebih dahulu keseluruhan alur bisnis, struktur database, relasi tabel, serta arsitektur project.

Jangan langsung menghasilkan kode apabila saya belum memintanya.

Selalu lakukan analisis terhadap:

- Alur bisnis
- Struktur database
- Relasi tabel
- Controller
- Model
- View yang sudah ada

Gunakan struktur project yang sudah tersedia dan jangan membuat file baru apabila fitur masih dapat dikembangkan pada file yang sudah ada.

Jangan mengubah nama tabel, relasi database, maupun alur bisnis tanpa persetujuan saya.

Apabila terdapat alur yang ambigu, tanyakan terlebih dahulu sebelum memberikan implementasi.

Seluruh implementasi harus mengikuti standar CodeIgniter 4 dan mudah dipelihara.

---

# ALUR BISNIS

Aplikasi memiliki tiga aktor utama.

1. Mahasiswa/siswa
2. Sekretariat
3. Bidang

Sistem menggunakan konsep satu alur permohonan dari awal hingga selesai. Mahasiswa tidak mengetahui proses internal seperti disposisi antar pegawai.

---

# AKTOR

## peserta mahasiswa/siswa smk

Mahasiswa dapat:

- Registrasi akun
- Login
- Mengelola profil
- Membuat permohonan
- Menyimpan Draft
- Melanjutkan Draft
- Mengunggah dokumen persyaratan
- Melihat status permohonan
- Melihat catatan Sekretariat
- Melakukan perbaikan dokumen apabila diminta Sekretariat
- Membatalkan permohonan 
- Mengisi Logbook apabila diaktifkan oleh Bidang
- Mengunduh Surat Penerimaan Magang
- Mengunduh Surat Selesai Magang
- Mengunduh Sertifikat


Mahasiswa tidak mengetahui proses disposisi internal.

---

## Sekretariat

Sekretariat merupakan pintu masuk seluruh permohonan.

Sekretariat bertugas:

- Memverifikasi administrasi
- Memeriksa dokumen persyaratan
- Menentukan apakah dokumen sesuai atau tidak sesuai
- Memberikan catatan apabila terdapat kesalahan
- Meminta perbaikan dokumen
- Menolak permohonan
- Menentukan bidang tujuan sesuai kompetensi mahasiswa
- Mengirim disposisi ke Bidang
- Mengunggah Surat Penerimaan Magang
- Mengelola seluruh permohonan

---

## Bidang

Bidang menerima permohonan yang telah didisposisikan oleh Sekretariat.

Bidang dapat:

- Melihat detail peserta mahasiswa/siswa
- Melihat dokumen permohonan
- Menyetujui atau menolak disposisi
- Memberikan catatan
- Mengatur kuota bidang
- Menentukan apakah peserta wajib mengisi logbook (Ya/Tidak)
- Melihat daftar peserta aktif
- Melihat riwayat magang yang telah selesai
- Memverifikasi logbook
- Mengunggah Surat Penerimaan 
- Mengunggah Surat Selesai
- Mengunggah Sertifikat
- Menyelesaikan kegiatan 
- Membatalkan kegiatan apabila diperlukan

---

# JENIS PERMOHONAN

Sistem memiliki empat jenis permohonan.

- Magang
- Praktik Kerja Lapangan
- Penelitian Skripsi / Tugas Akhir
- Observasi / Pengambilan Data
- Uji Coba Produk (Prototype)

Setiap jenis permohonan memiliki:

- Form yang berbeda
- Dokumen persyaratan yang berbeda
- Validasi yang berbeda
- Alur yang dapat berbeda sesuai kebutuhan

---

# DRAFT

Peserta dapat menyimpan permohonan sebagai Draft.

Draft belum diproses oleh Sekretariat.

Saat peserta membuka kembali Draft, sistem harus menampilkan form **Ajukan Permohonan** yang sama dengan seluruh data yang sebelumnya telah diisi.

Jangan membuat halaman edit draft yang berbeda.

Draft hanya merupakan kondisi data, bukan halaman baru.

---

# REVISI PERMOHONAN

Apabila Sekretariat meminta perbaikan dokumen:

Peserta tidak membuat permohonan baru.

Peserta hanya memperbaiki data atau dokumen pada permohonan yang sama.

File lama tetap dapat ditampilkan sebagai referensi hingga diganti oleh file baru.

Catatan Sekretariat harus tetap terlihat pada halaman detail permohonan.

Riwayat revisi harus dapat diketahui.

---

# LOGBOOK

Logbook hanya dapat digunakan apabila:

- Permohonan telah disetujui.
- Bidang mengaktifkan kebutuhan logbook.

Apabila Bidang memilih "Tidak", maka menu logbook tidak digunakan pada permohonan tersebut.

---

# KUOTA

Kuota hanya berlaku untuk:

- Magang
- Praktik Kerja Lapangan (PKL)

Jenis permohonan lain tidak menggunakan kuota.

Kuota dihitung berdasarkan periode pelaksanaan.

---

# VALIDASI TANGGAL

Validasi tanggal hanya diterapkan pada:

- Magang
- Praktik Kerja Lapangan (PKL)

Ketentuan:

- Pengajuan minimal H-30 sebelum tanggal mulai.
- Tanggal mulai maksimal 6 bulan ke depan.
- Durasi minimal mengikuti ketentuan sistem.

Jenis permohonan lain tidak menggunakan validasi tersebut.

---

# UX WRITING

Seluruh teks antarmuka harus menggunakan Bahasa Indonesia yang jelas, konsisten, dan mudah dipahami.

Hindari penggunaan istilah yang ambigu, singkatan yang tidak umum, maupun campuran Bahasa Indonesia dan Bahasa Inggris.

Gunakan istilah yang konsisten pada seluruh sistem.

Contoh:

- Tahun Angkatan (bukan Thn Angkatan)
- Nomor WhatsApp (bukan Nomor Telepon apabila yang digunakan adalah WhatsApp)
- Perguruan Tinggi
- Ringkasan Data
- Data Pemohon
- Data Pendidikan
- Data Permohonan
- Catatan Perbaikan
- Disetujui
- Ditolak
- Menunggu

Judul halaman, label form, tombol, notifikasi, dialog konfirmasi, placeholder, helper text, dan pesan validasi harus mengikuti prinsip UX Writing yang baik.

---

# IMPLEMENTASI

Sebelum memberikan implementasi:

1. Analisis Controller terkait.
2. Analisis Model.
3. Analisis Database.
4. Analisis Relasi.
5. Analisis View yang sudah ada.
6. Analisis Alur Bisnis.

Berikan solusi yang konsisten dengan arsitektur project, mudah dipelihara, dan mengikuti standar CodeIgniter 4.