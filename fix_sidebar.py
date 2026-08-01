import re

filepath = 'app/Views/layouts/superadmin/L_sidebar_superadmin.php'

with open(filepath, 'r', encoding='utf-8') as f:
    content = f.read()

# Replace arrays in active_menu checks
content = re.sub(
    r"\['fakultas', 'prodi', 'instansi', 'mahasiswa', 'user_mahasiswa', 'jenis_permohonan', 'file', 'odp', 'bidang', 'kuota', 'komponen_penilaian'\]",
    r"['fakultas', 'program_studi', 'instansi', 'mahasiswa', 'user_mahasiswa', 'jenis_permohonan', 'file_persyaratan', 'opd', 'bidang', 'kuota', 'komponen_penilaian']",
    content
)

# Replace specific collapse items
content = re.sub(
    r"\$active_menu == 'prodi'\) \? 'active' : '' \" href=\"<\?= base_url\('superadmin/prodi'\) \?>",
    r"$active_menu == 'program_studi') ? 'active' : '' \" href=\"<?= base_url('superadmin/program-studi') ?>",
    content
)

content = re.sub(
    r"\$active_menu == 'file'\) \? 'active' : '' \" href=\"<\?= base_url\('superadmin/file'\) \?>",
    r"$active_menu == 'file_persyaratan') ? 'active' : '' \" href=\"<?= base_url('superadmin/file-persyaratan') ?>",
    content
)

content = re.sub(
    r"\$active_menu == 'odp'\) \? 'active' : '' \" href=\"<\?= base_url\('superadmin/odp'\) \?>",
    r"$active_menu == 'opd') ? 'active' : '' \" href=\"<?= base_url('superadmin/opd') ?>",
    content
)

with open(filepath, 'w', encoding='utf-8') as f:
    f.write(content)

print("Sidebar fixed.")
