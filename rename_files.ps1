# ============================================================
# Script Rename File & Folder - Refactor Konvensi Penamaan
# ============================================================
# Script ini melakukan rename folder dan file menggunakan git mv
# untuk memastikan tracking git tetap terjaga.

Set-Location "d:\Data\sistem_magang"

Write-Host "=== PHASE 1: Rename Folder (Kabid -> Bidang) ===" -ForegroundColor Cyan

# Controllers
git mv "app/Controllers/Kabid" "app/Controllers/Bidang"
Write-Host "  [OK] Controllers/Kabid -> Controllers/Bidang"

# Models
git mv "app/Models/Kabid" "app/Models/Bidang"
Write-Host "  [OK] Models/Kabid -> Models/Bidang"

# Views dashboard
git mv "app/Views/dashboard/kabid" "app/Views/dashboard/bidang"
Write-Host "  [OK] Views/dashboard/kabid -> Views/dashboard/bidang"

# Views layouts
git mv "app/Views/layouts/kabid" "app/Views/layouts/bidang"
Write-Host "  [OK] Views/layouts/kabid -> Views/layouts/bidang"

Write-Host ""
Write-Host "=== PHASE 2: Rename Controllers - Root ===" -ForegroundColor Cyan

git mv "app/Controllers/Home.php" "app/Controllers/C_Home.php"
Write-Host "  [OK] Home.php -> C_Home.php"

git mv "app/Controllers/AuthController.php" "app/Controllers/C_Auth.php"
Write-Host "  [OK] AuthController.php -> C_Auth.php"

git mv "app/Controllers/ApiController.php" "app/Controllers/C_Api.php"
Write-Host "  [OK] ApiController.php -> C_Api.php"

git mv "app/Controllers/Admin.php" "app/Controllers/C_Admin.php"
Write-Host "  [OK] Admin.php -> C_Admin.php"

Write-Host ""
Write-Host "=== PHASE 3: Rename Controllers - SuperAdmin ===" -ForegroundColor Cyan

$saControllers = @(
    @("C_Bidang.php", "C_Bidang_SuperAdmin.php"),
    @("C_Fakultas.php", "C_Fakultas_SuperAdmin.php"),
    @("C_FilePersyaratan.php", "C_FilePersyaratan_SuperAdmin.php"),
    @("C_InstansiPendidikan.php", "C_InstansiPendidikan_SuperAdmin.php"),
    @("C_JenisPermohonan.php", "C_JenisPermohonan_SuperAdmin.php"),
    @("C_KomponenPenilaian.php", "C_KomponenPenilaian_SuperAdmin.php"),
    @("C_Kuota.php", "C_Kuota_SuperAdmin.php"),
    @("C_Mahasiswa.php", "C_Mahasiswa_SuperAdmin.php"),
    @("C_ManajemenMenu.php", "C_ManajemenMenu_SuperAdmin.php"),
    @("C_ManajemenPengguna.php", "C_ManajemenPengguna_SuperAdmin.php"),
    @("C_Opd.php", "C_Opd_SuperAdmin.php"),
    @("C_Prodi.php", "C_Prodi_SuperAdmin.php"),
    @("C_UserMahasiswa.php", "C_UserMahasiswa_SuperAdmin.php")
)

foreach ($pair in $saControllers) {
    git mv "app/Controllers/SuperAdmin/$($pair[0])" "app/Controllers/SuperAdmin/$($pair[1])"
    Write-Host "  [OK] $($pair[0]) -> $($pair[1])"
}

Write-Host ""
Write-Host "=== PHASE 4: Rename Controllers - Mahasiswa ===" -ForegroundColor Cyan

$mhsControllers = @(
    @("C_BaseMahasiswa.php", "C_Base_Mahasiswa.php"),
    @("C_Dashboard.php", "C_Dashboard_Mahasiswa.php"),
    @("C_Logbook.php", "C_Logbook_Mahasiswa.php"),
    @("C_Permohonan.php", "C_Permohonan_Mahasiswa.php"),
    @("C_Profil.php", "C_Profil_Mahasiswa.php"),
    @("C_Sertifikat.php", "C_Sertifikat_Mahasiswa.php"),
    @("C_Status.php", "C_Status_Mahasiswa.php")
)

foreach ($pair in $mhsControllers) {
    git mv "app/Controllers/Mahasiswa/$($pair[0])" "app/Controllers/Mahasiswa/$($pair[1])"
    Write-Host "  [OK] $($pair[0]) -> $($pair[1])"
}

Write-Host ""
Write-Host "=== PHASE 5: Rename Controllers - Sekretariat ===" -ForegroundColor Cyan

# C_Auth.php stays as shared (no rename)
$sekControllers = @(
    @("C_Dashboard.php", "C_Dashboard_Sekretariat.php"),
    @("C_FileProsesMagang.php", "C_FileProsesMagang_Sekretariat.php"),
    @("C_MonitoringStatus.php", "C_MonitoringStatus_Sekretariat.php"),
    @("C_Penilaian.php", "C_Penilaian_Sekretariat.php"),
    @("C_Placeholder.php", "C_Placeholder_Sekretariat.php"),
    @("C_Profile.php", "C_Profile_Sekretariat.php"),
    @("C_Riwayat.php", "C_Riwayat_Sekretariat.php"),
    @("C_Sertifikat.php", "C_Sertifikat_Sekretariat.php"),
    @("C_StatusPermohonan.php", "C_StatusPermohonan_Sekretariat.php"),
    @("C_UploadSuratPenerimaan.php", "C_UploadSuratPenerimaan_Sekretariat.php"),
    @("C_Verifikasi.php", "C_Verifikasi_Sekretariat.php")
)

foreach ($pair in $sekControllers) {
    git mv "app/Controllers/Sekretariat/$($pair[0])" "app/Controllers/Sekretariat/$($pair[1])"
    Write-Host "  [OK] $($pair[0]) -> $($pair[1])"
}

Write-Host ""
Write-Host "=== PHASE 6: Rename Controllers - Bidang (ex-Kabid) ===" -ForegroundColor Cyan

$bidangControllers = @(
    @("C_DashboardKabid.php", "C_Dashboard_Bidang.php"),
    @("C_DisposisiMasuk.php", "C_DisposisiMasuk_Bidang.php"),
    @("C_FileProsesMagangKabid.php", "C_FileProsesMagang_Bidang.php"),
    @("C_KuotaBidang.php", "C_Kuota_Bidang.php"),
    @("C_LogbookKabid.php", "C_Logbook_Bidang.php"),
    @("C_UploadDokumen.php", "C_UploadDokumen_Bidang.php")
)

foreach ($pair in $bidangControllers) {
    git mv "app/Controllers/Bidang/$($pair[0])" "app/Controllers/Bidang/$($pair[1])"
    Write-Host "  [OK] $($pair[0]) -> $($pair[1])"
}

Write-Host ""
Write-Host "=== PHASE 7: Rename Models - SuperAdmin ===" -ForegroundColor Cyan

$saModels = @(
    @("M_BidangSuperAdmin.php", "M_Bidang_SuperAdmin.php"),
    @("M_DashboardSuperAdmin.php", "M_Dashboard_SuperAdmin.php"),
    @("M_FakultasSuperAdmin.php", "M_Fakultas_SuperAdmin.php"),
    @("M_FilePermohonanSuperAdmin.php", "M_FilePermohonan_SuperAdmin.php"),
    @("M_FileSuperAdmin.php", "M_File_SuperAdmin.php"),
    @("M_InstansiPendidikanSuperAdmin.php", "M_InstansiPendidikan_SuperAdmin.php"),
    @("M_JenisPermohonanSuperAdmin.php", "M_JenisPermohonan_SuperAdmin.php"),
    @("M_KomponenPenilaianSuperAdmin.php", "M_KomponenPenilaian_SuperAdmin.php"),
    @("M_KuotaSuperAdmin.php", "M_Kuota_SuperAdmin.php"),
    @("M_MahasiswaSuperAdmin.php", "M_Mahasiswa_SuperAdmin.php"),
    @("M_MenuSuperAdmin.php", "M_Menu_SuperAdmin.php"),
    @("M_OpdSuperAdmin.php", "M_Opd_SuperAdmin.php"),
    @("M_PenggunaSuperAdmin.php", "M_Pengguna_SuperAdmin.php"),
    @("M_ProdiSuperAdmin.php", "M_Prodi_SuperAdmin.php"),
    @("M_UserMahasiswaSuperAdmin.php", "M_UserMahasiswa_SuperAdmin.php")
)

foreach ($pair in $saModels) {
    git mv "app/Models/SuperAdmin/$($pair[0])" "app/Models/SuperAdmin/$($pair[1])"
    Write-Host "  [OK] $($pair[0]) -> $($pair[1])"
}

Write-Host ""
Write-Host "=== PHASE 8: Rename Models - Mahasiswa ===" -ForegroundColor Cyan

$mhsModels = @(
    @("M_FakultasMahasiswa.php", "M_Fakultas_Mahasiswa.php"),
    @("M_FilePermohonanMagangMahasiswa.php", "M_FilePermohonanMagang_Mahasiswa.php"),
    @("M_FilePermohonanMahasiswa.php", "M_FilePermohonan_Mahasiswa.php"),
    @("M_FileProsesMagangMahasiswa.php", "M_FileProsesMagang_Mahasiswa.php"),
    @("M_InstansiMahasiswa.php", "M_Instansi_Mahasiswa.php"),
    @("M_InstansiPendidikanMahasiswa.php", "M_InstansiPendidikan_Mahasiswa.php"),
    @("M_LogbookMagangMahasiswa.php", "M_LogbookMagang_Mahasiswa.php"),
    @("M_Mahasiswa.php", "M_Mahasiswa_Mahasiswa.php"),
    @("M_PenempatanMagangMahasiswa.php", "M_PenempatanMagang_Mahasiswa.php"),
    @("M_PermohonanMagangMahasiswa.php", "M_PermohonanMagang_Mahasiswa.php"),
    @("M_ProdiMahasiswa.php", "M_Prodi_Mahasiswa.php"),
    @("M_UserMahasiswa.php", "M_User_Mahasiswa.php")
)

foreach ($pair in $mhsModels) {
    git mv "app/Models/Mahasiswa/$($pair[0])" "app/Models/Mahasiswa/$($pair[1])"
    Write-Host "  [OK] $($pair[0]) -> $($pair[1])"
}

Write-Host ""
Write-Host "=== PHASE 9: Rename Models - Sekretariat ===" -ForegroundColor Cyan

$sekModels = @(
    @("M_AuthSekretariat.php", "M_Auth_Sekretariat.php"),
    @("M_DisposisiSekretariat.php", "M_Disposisi_Sekretariat.php"),
    @("M_FileProsesMagangSekretariat.php", "M_FileProsesMagang_Sekretariat.php"),
    @("M_FileSekretariat.php", "M_File_Sekretariat.php"),
    @("M_PenilaianSekretariat.php", "M_Penilaian_Sekretariat.php"),
    @("M_SertifikatSekretariat.php", "M_Sertifikat_Sekretariat.php"),
    @("M_StatusPermohonanSekretariat.php", "M_StatusPermohonan_Sekretariat.php"),
    @("M_VerifikasiSekretariat.php", "M_Verifikasi_Sekretariat.php")
)

foreach ($pair in $sekModels) {
    git mv "app/Models/Sekretariat/$($pair[0])" "app/Models/Sekretariat/$($pair[1])"
    Write-Host "  [OK] $($pair[0]) -> $($pair[1])"
}

Write-Host ""
Write-Host "=== PHASE 10: Rename Models - Bidang (ex-Kabid) ===" -ForegroundColor Cyan

$bidangModels = @(
    @("M_LogbookKabid.php", "M_Logbook_Bidang.php"),
    @("M_PenempatanKabid.php", "M_Penempatan_Bidang.php")
)

foreach ($pair in $bidangModels) {
    git mv "app/Models/Bidang/$($pair[0])" "app/Models/Bidang/$($pair[1])"
    Write-Host "  [OK] $($pair[0]) -> $($pair[1])"
}

Write-Host ""
Write-Host "=== PHASE 11: Rename Models - Admin ===" -ForegroundColor Cyan

git mv "app/Models/Admin/M_PermohonanMagangAdmin.php" "app/Models/Admin/M_PermohonanMagang_Admin.php"
Write-Host "  [OK] M_PermohonanMagangAdmin.php -> M_PermohonanMagang_Admin.php"

Write-Host ""
Write-Host "=== PHASE 12: Rename Models - Auth ===" -ForegroundColor Cyan

$authModels = @(
    @("M_InstansiMahasiswaAuth.php", "M_InstansiMahasiswa_Auth.php"),
    @("M_InstansiPendidikanAuth.php", "M_InstansiPendidikan_Auth.php"),
    @("M_MahasiswaAuth.php", "M_Mahasiswa_Auth.php"),
    @("M_UserMahasiswaAuth.php", "M_UserMahasiswa_Auth.php")
)

foreach ($pair in $authModels) {
    git mv "app/Models/Auth/$($pair[0])" "app/Models/Auth/$($pair[1])"
    Write-Host "  [OK] $($pair[0]) -> $($pair[1])"
}

Write-Host ""
Write-Host "=== PHASE 13: Rename Models - Api ===" -ForegroundColor Cyan

$apiModels = @(
    @("M_FakultasApi.php", "M_Fakultas_Api.php"),
    @("M_ProdiApi.php", "M_Prodi_Api.php")
)

foreach ($pair in $apiModels) {
    git mv "app/Models/Api/$($pair[0])" "app/Models/Api/$($pair[1])"
    Write-Host "  [OK] $($pair[0]) -> $($pair[1])"
}

Write-Host ""
Write-Host "=== ALL RENAMES COMPLETE ===" -ForegroundColor Green
Write-Host ""

# Show status
git status --short | Select-Object -First 30
