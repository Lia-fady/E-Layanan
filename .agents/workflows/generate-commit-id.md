---
description: Generate git commit message dalam Bahasa Indonesia
---

# Generate Commit Indonesia

Tugas Anda adalah menganalisis perubahan Git yang sudah di-stage menggunakan:

git diff --cached

Kemudian buat commit message dalam Bahasa Indonesia dengan format Conventional Commits:

<type>(<scope>): <deskripsi singkat dalam Bahasa Indonesia>

Aturan:
- Gunakan Bahasa Indonesia yang jelas dan profesional.
- Subject maksimal 50 karakter.
- Gunakan type yang sesuai: feat, fix, refactor, docs, style, test, chore.
- Fokus pada perubahan yang benar-benar ada di git diff.
- Jangan gunakan bahasa Inggris kecuali nama file, fungsi, atau istilah teknis yang memang harus dipertahankan.

Contoh:
- feat(sekretariat): tambahkan modal verifikasi
- fix(upload): perbaiki redirect upload surat
- refactor(sidebar): gabungkan menu bidang