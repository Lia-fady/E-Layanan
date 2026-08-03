# ============================================================
# Script Update Konten - Refactor Konvensi Penamaan
# Phase 2: Update namespace, class name, dan semua referensi
# ============================================================

Set-Location "d:\Data\sistem_magang"

$appDir = "d:\Data\sistem_magang\app"
$phpFiles = Get-ChildItem -Path $appDir -Filter "*.php" -Recurse -File
$totalUpdated = 0

Write-Host "=== UPDATING CONTENT IN $($phpFiles.Count) PHP FILES ===" -ForegroundColor Cyan
Write-Host ""

foreach ($file in $phpFiles) {
    $content = [System.IO.File]::ReadAllText($file.FullName)
    $original = $content

    # ================================================================
    # PART A: Namespace literal replacements (Kabid -> Bidang)
    # ================================================================
    $content = $content.Replace('App\Controllers\Kabid', 'App\Controllers\Bidang')
    $content = $content.Replace('App\Models\Kabid', 'App\Models\Bidang')
    # Double-backslash variants (in route string literals)
    $content = $content.Replace('Controllers\\Kabid\\', 'Controllers\\Bidang\\')
    $content = $content.Replace('Models\\Kabid\\', 'Models\\Bidang\\')

    # ================================================================
    # PART B: View path replacements (kabid -> bidang)
    # ================================================================
    $content = $content.Replace('dashboard/kabid/', 'dashboard/bidang/')
    $content = $content.Replace('layouts/kabid/', 'layouts/bidang/')

    # ================================================================
    # PART C: Routes FQCN patterns for non-unique controllers
    # (C_Dashboard, C_Sertifikat appear in both Mahasiswa & Sekretariat)
    # ================================================================
    # Sekretariat FQCN in routes
    $content = $content.Replace('Controllers\Sekretariat\C_Dashboard::', 'Controllers\Sekretariat\C_Dashboard_Sekretariat::')
    $content = $content.Replace('Controllers\\Sekretariat\\C_Dashboard::', 'Controllers\\Sekretariat\\C_Dashboard_Sekretariat::')
    $content = $content.Replace('Controllers\Sekretariat\C_Sertifikat::', 'Controllers\Sekretariat\C_Sertifikat_Sekretariat::')
    $content = $content.Replace('Controllers\\Sekretariat\\C_Sertifikat::', 'Controllers\\Sekretariat\\C_Sertifikat_Sekretariat::')
    # Mahasiswa short names in route group (these patterns only appear in Routes.php Mahasiswa group)
    $content = $content.Replace("'C_Dashboard::", "'C_Dashboard_Mahasiswa::")
    $content = $content.Replace("'C_Sertifikat::", "'C_Sertifikat_Mahasiswa::")
    # Home:: and Admin:: for root controllers
    $content = $content.Replace('Home::', 'C_Home::')

    # ================================================================
    # PART D: Model class name replacements (regex with \b)
    # Sorted longest first to avoid partial matches
    # ================================================================
    # SuperAdmin Models
    $content = $content -replace '\bM_UserMahasiswaSuperAdmin\b', 'M_UserMahasiswa_SuperAdmin'
    $content = $content -replace '\bM_InstansiPendidikanSuperAdmin\b', 'M_InstansiPendidikan_SuperAdmin'
    $content = $content -replace '\bM_KomponenPenilaianSuperAdmin\b', 'M_KomponenPenilaian_SuperAdmin'
    $content = $content -replace '\bM_JenisPermohonanSuperAdmin\b', 'M_JenisPermohonan_SuperAdmin'
    $content = $content -replace '\bM_FilePermohonanSuperAdmin\b', 'M_FilePermohonan_SuperAdmin'
    $content = $content -replace '\bM_DashboardSuperAdmin\b', 'M_Dashboard_SuperAdmin'
    $content = $content -replace '\bM_MahasiswaSuperAdmin\b', 'M_Mahasiswa_SuperAdmin'
    $content = $content -replace '\bM_PenggunaSuperAdmin\b', 'M_Pengguna_SuperAdmin'
    $content = $content -replace '\bM_FakultasSuperAdmin\b', 'M_Fakultas_SuperAdmin'
    $content = $content -replace '\bM_BidangSuperAdmin\b', 'M_Bidang_SuperAdmin'
    $content = $content -replace '\bM_KuotaSuperAdmin\b', 'M_Kuota_SuperAdmin'
    $content = $content -replace '\bM_ProdiSuperAdmin\b', 'M_Prodi_SuperAdmin'
    $content = $content -replace '\bM_FileSuperAdmin\b', 'M_File_SuperAdmin'
    $content = $content -replace '\bM_MenuSuperAdmin\b', 'M_Menu_SuperAdmin'
    $content = $content -replace '\bM_OpdSuperAdmin\b', 'M_Opd_SuperAdmin'

    # Mahasiswa Models (longest first)
    $content = $content -replace '\bM_FilePermohonanMagangMahasiswa\b', 'M_FilePermohonanMagang_Mahasiswa'
    $content = $content -replace '\bM_InstansiPendidikanMahasiswa\b', 'M_InstansiPendidikan_Mahasiswa'
    $content = $content -replace '\bM_PenempatanMagangMahasiswa\b', 'M_PenempatanMagang_Mahasiswa'
    $content = $content -replace '\bM_PermohonanMagangMahasiswa\b', 'M_PermohonanMagang_Mahasiswa'
    $content = $content -replace '\bM_FileProsesMagangMahasiswa\b', 'M_FileProsesMagang_Mahasiswa'
    $content = $content -replace '\bM_FilePermohonanMahasiswa\b', 'M_FilePermohonan_Mahasiswa'
    $content = $content -replace '\bM_LogbookMagangMahasiswa\b', 'M_LogbookMagang_Mahasiswa'
    $content = $content -replace '\bM_FakultasMahasiswa\b', 'M_Fakultas_Mahasiswa'
    $content = $content -replace '\bM_InstansiMahasiswa\b', 'M_Instansi_Mahasiswa'
    $content = $content -replace '\bM_ProdiMahasiswa\b', 'M_Prodi_Mahasiswa'
    $content = $content -replace '\bM_UserMahasiswa\b', 'M_User_Mahasiswa'
    $content = $content -replace '\bM_Mahasiswa\b', 'M_Mahasiswa_Mahasiswa'

    # Sekretariat Models
    $content = $content -replace '\bM_StatusPermohonanSekretariat\b', 'M_StatusPermohonan_Sekretariat'
    $content = $content -replace '\bM_FileProsesMagangSekretariat\b', 'M_FileProsesMagang_Sekretariat'
    $content = $content -replace '\bM_SertifikatSekretariat\b', 'M_Sertifikat_Sekretariat'
    $content = $content -replace '\bM_VerifikasiSekretariat\b', 'M_Verifikasi_Sekretariat'
    $content = $content -replace '\bM_PenilaianSekretariat\b', 'M_Penilaian_Sekretariat'
    $content = $content -replace '\bM_DisposisiSekretariat\b', 'M_Disposisi_Sekretariat'
    $content = $content -replace '\bM_AuthSekretariat\b', 'M_Auth_Sekretariat'
    $content = $content -replace '\bM_FileSekretariat\b', 'M_File_Sekretariat'

    # Bidang (ex-Kabid) Models
    $content = $content -replace '\bM_PenempatanKabid\b', 'M_Penempatan_Bidang'
    $content = $content -replace '\bM_LogbookKabid\b', 'M_Logbook_Bidang'

    # Admin Model
    $content = $content -replace '\bM_PermohonanMagangAdmin\b', 'M_PermohonanMagang_Admin'

    # Auth Models
    $content = $content -replace '\bM_InstansiPendidikanAuth\b', 'M_InstansiPendidikan_Auth'
    $content = $content -replace '\bM_InstansiMahasiswaAuth\b', 'M_InstansiMahasiswa_Auth'
    $content = $content -replace '\bM_UserMahasiswaAuth\b', 'M_UserMahasiswa_Auth'
    $content = $content -replace '\bM_MahasiswaAuth\b', 'M_Mahasiswa_Auth'

    # Api Models
    $content = $content -replace '\bM_FakultasApi\b', 'M_Fakultas_Api'
    $content = $content -replace '\bM_ProdiApi\b', 'M_Prodi_Api'

    # ================================================================
    # PART E: Controller class name replacements (regex with \b)
    # Only for UNIQUE controller names (safe for global replacement)
    # Sorted longest first
    # ================================================================
    # Bidang (ex-Kabid) controllers - replace Kabid-suffixed names first
    $content = $content -replace '\bC_FileProsesMagangKabid\b', 'C_FileProsesMagang_Bidang'
    $content = $content -replace '\bC_DashboardKabid\b', 'C_Dashboard_Bidang'
    $content = $content -replace '\bC_LogbookKabid\b', 'C_Logbook_Bidang'
    $content = $content -replace '\bC_KuotaBidang\b', 'C_Kuota_Bidang'
    $content = $content -replace '\bC_DisposisiMasuk\b', 'C_DisposisiMasuk_Bidang'
    $content = $content -replace '\bC_UploadDokumen\b', 'C_UploadDokumen_Bidang'

    # Sekretariat controllers (unique names)
    $content = $content -replace '\bC_UploadSuratPenerimaan\b', 'C_UploadSuratPenerimaan_Sekretariat'
    $content = $content -replace '\bC_FileProsesMagang\b', 'C_FileProsesMagang_Sekretariat'
    $content = $content -replace '\bC_StatusPermohonan\b', 'C_StatusPermohonan_Sekretariat'
    $content = $content -replace '\bC_MonitoringStatus\b', 'C_MonitoringStatus_Sekretariat'
    $content = $content -replace '\bC_Placeholder\b', 'C_Placeholder_Sekretariat'
    $content = $content -replace '\bC_Verifikasi\b', 'C_Verifikasi_Sekretariat'
    $content = $content -replace '\bC_Penilaian\b', 'C_Penilaian_Sekretariat'
    $content = $content -replace '\bC_Riwayat\b', 'C_Riwayat_Sekretariat'
    $content = $content -replace '\bC_Profile\b', 'C_Profile_Sekretariat'

    # SuperAdmin controllers (unique names)
    $content = $content -replace '\bC_InstansiPendidikan\b', 'C_InstansiPendidikan_SuperAdmin'
    $content = $content -replace '\bC_ManajemenPengguna\b', 'C_ManajemenPengguna_SuperAdmin'
    $content = $content -replace '\bC_KomponenPenilaian\b', 'C_KomponenPenilaian_SuperAdmin'
    $content = $content -replace '\bC_JenisPermohonan\b', 'C_JenisPermohonan_SuperAdmin'
    $content = $content -replace '\bC_FilePersyaratan\b', 'C_FilePersyaratan_SuperAdmin'
    $content = $content -replace '\bC_UserMahasiswa\b', 'C_UserMahasiswa_SuperAdmin'
    $content = $content -replace '\bC_ManajemenMenu\b', 'C_ManajemenMenu_SuperAdmin'
    $content = $content -replace '\bC_Mahasiswa\b', 'C_Mahasiswa_SuperAdmin'
    $content = $content -replace '\bC_Fakultas\b', 'C_Fakultas_SuperAdmin'
    $content = $content -replace '\bC_Bidang\b', 'C_Bidang_SuperAdmin'
    $content = $content -replace '\bC_Kuota\b', 'C_Kuota_SuperAdmin'
    $content = $content -replace '\bC_Prodi\b', 'C_Prodi_SuperAdmin'
    $content = $content -replace '\bC_Opd\b', 'C_Opd_SuperAdmin'

    # Mahasiswa controllers (unique names)
    $content = $content -replace '\bC_BaseMahasiswa\b', 'C_Base_Mahasiswa'
    $content = $content -replace '\bC_Permohonan\b', 'C_Permohonan_Mahasiswa'
    $content = $content -replace '\bC_Logbook\b', 'C_Logbook_Mahasiswa'
    $content = $content -replace '\bC_Profil\b', 'C_Profil_Mahasiswa'
    $content = $content -replace '\bC_Status\b', 'C_Status_Mahasiswa'

    # Root controllers
    $content = $content -replace '\bAuthController\b', 'C_Auth'
    $content = $content -replace '\bApiController\b', 'C_Api'

    # ================================================================
    # PART F: Per-file class declaration updates
    # (for generic/non-unique names that can't be globally replaced)
    # ================================================================
    $relativePath = $file.FullName.Replace($appDir + '\', '')

    switch ($relativePath) {
        'Controllers\C_Home.php' {
            $content = $content -replace 'class Home\b', 'class C_Home'
        }
        'Controllers\C_Admin.php' {
            $content = $content -replace 'class Admin\b', 'class C_Admin'
        }
        'Controllers\Mahasiswa\C_Dashboard_Mahasiswa.php' {
            $content = $content -replace 'class C_Dashboard\b', 'class C_Dashboard_Mahasiswa'
        }
        'Controllers\Sekretariat\C_Dashboard_Sekretariat.php' {
            $content = $content -replace 'class C_Dashboard\b', 'class C_Dashboard_Sekretariat'
        }
        'Controllers\Mahasiswa\C_Sertifikat_Mahasiswa.php' {
            $content = $content -replace 'class C_Sertifikat\b', 'class C_Sertifikat_Mahasiswa'
        }
        'Controllers\Sekretariat\C_Sertifikat_Sekretariat.php' {
            $content = $content -replace 'class C_Sertifikat\b', 'class C_Sertifikat_Sekretariat'
        }
    }

    # ================================================================
    # Write back if changed
    # ================================================================
    if ($content -ne $original) {
        [System.IO.File]::WriteAllText($file.FullName, $content)
        $totalUpdated++
        Write-Host "  [UPDATED] $relativePath" -ForegroundColor Green
    }
}

Write-Host ""
Write-Host "=== CONTENT UPDATE COMPLETE ===" -ForegroundColor Green
Write-Host "Total files updated: $totalUpdated" -ForegroundColor Yellow
