import os

routes_path = r"c:\Users\Ahmad Hisyam\Downloads\Projectmagang_elayananuhuy\app\Config\Routes.php"

with open(routes_path, "r", encoding="utf-8") as f:
    content = f.read()

# Mahasiswa Group
replacements = {
    "'C_Dashboard::": "'C_Dashboard_Mahasiswa::",
    "'C_Profil::": "'C_Profil_Mahasiswa::",
    "'C_Permohonan::": "'C_Permohonan_Mahasiswa::",
    "'C_Status::": "'C_Status_Mahasiswa::",
    "'C_Logbook::": "'C_Logbook_Mahasiswa::",
    "'C_Sertifikat::": "'C_Sertifikat_Mahasiswa::",
    
    # Also I notice in Sekretariat group, it became C_Auth_Sekretariat_Sekretariat !!
    # Because original was C_Auth maybe, and we appended _Sekretariat twice?
    # Let's check why C_Auth_Sekretariat_Sekretariat happened.
    # Because old file was C_Auth ? No, old file was C_Auth.php inside Sekretariat.
    # Ah! The script did C_Auth_Sekretariat and then another replacement maybe matched it?
    # No, let's fix Sekretariat routes.
    "'\\App\\Controllers\\Sekretariat\\C_Auth_Sekretariat_Sekretariat::": "'\\App\\Controllers\\Sekretariat\\C_Auth_Sekretariat::",
    "'\\App\\Controllers\\Sekretariat\\C_Dashboard_Sekretariat_Sekretariat::": "'\\App\\Controllers\\Sekretariat\\C_Dashboard_Sekretariat::",
    "'\\App\\Controllers\\Sekretariat\\C_Verifikasi_Sekretariat_Sekretariat::": "'\\App\\Controllers\\Sekretariat\\C_Verifikasi_Sekretariat::",
    "'\\App\\Controllers\\Sekretariat\\C_Riwayat_Sekretariat_Sekretariat::": "'\\App\\Controllers\\Sekretariat\\C_Riwayat_Sekretariat::",
    "'\\App\\Controllers\\Sekretariat\\C_Profile_Sekretariat_Sekretariat::": "'\\App\\Controllers\\Sekretariat\\C_Profile_Sekretariat::",
    "'\\App\\Controllers\\Sekretariat\\C_StatusPermohonan_Sekretariat_Sekretariat::": "'\\App\\Controllers\\Sekretariat\\C_StatusPermohonan_Sekretariat::",
    "'\\App\\Controllers\\Sekretariat\\C_MonitoringStatus_Sekretariat_Sekretariat::": "'\\App\\Controllers\\Sekretariat\\C_MonitoringStatus_Sekretariat::",
    "'\\App\\Controllers\\Sekretariat\\C_Placeholder_Sekretariat_Sekretariat::": "'\\App\\Controllers\\Sekretariat\\C_Placeholder_Sekretariat::",
    "'\\App\\Controllers\\Sekretariat\\C_Sertifikat_Sekretariat_Sekretariat::": "'\\App\\Controllers\\Sekretariat\\C_Sertifikat_Sekretariat::",
    "'\\App\\Controllers\\Sekretariat\\C_UploadSuratPenerimaan_Sekretariat_Sekretariat::": "'\\App\\Controllers\\Sekretariat\\C_UploadSuratPenerimaan_Sekretariat::",
    "'\\App\\Controllers\\Sekretariat\\C_Penilaian::": "'\\App\\Controllers\\Sekretariat\\C_Penilaian_Sekretariat::",
    # I should check if there are other double suffixes in the files themselves.
}

for old, new in replacements.items():
    content = content.replace(old, new)

with open(routes_path, "w", encoding="utf-8") as f:
    f.write(content)

print("Routes.php updated")
