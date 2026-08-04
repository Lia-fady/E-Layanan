import os
import re
import shutil

# Configuration
base_dir = r"c:\Users\Ahmad Hisyam\Downloads\Projectmagang_elayananuhuy"
app_dir = os.path.join(base_dir, "app")

controller_mapping = {
    "app/Controllers/Admin.php": "app/Controllers/SuperAdmin/C_Admin_SuperAdmin.php",
    "app/Controllers/ApiController.php": "app/Controllers/Shared/C_Api.php",
    "app/Controllers/AuthController.php": "app/Controllers/Auth/C_Auth.php",
    "app/Controllers/BaseController.php": "app/Controllers/Shared/C_Base.php",
    "app/Controllers/Home.php": "app/Controllers/Shared/C_Home.php",
    "app/Controllers/Api/Log.php": "app/Controllers/Shared/C_Log.php",
    "app/Controllers/Kabid/C_DashboardKabid.php": "app/Controllers/Bidang/C_Dashboard_Bidang.php",
    "app/Controllers/Kabid/C_DisposisiMasuk.php": "app/Controllers/Bidang/C_DisposisiMasuk_Bidang.php",
    "app/Controllers/Kabid/C_FileProsesMagangKabid.php": "app/Controllers/Bidang/C_FileProsesMagang_Bidang.php",
    "app/Controllers/Kabid/C_KuotaBidang.php": "app/Controllers/Bidang/C_Kuota_Bidang.php",
    "app/Controllers/Kabid/C_LogbookKabid.php": "app/Controllers/Bidang/C_Logbook_Bidang.php",
    "app/Controllers/Kabid/C_UploadDokumen.php": "app/Controllers/Bidang/C_UploadDokumen_Bidang.php",
    "app/Controllers/Mahasiswa/C_BaseMahasiswa.php": "app/Controllers/Mahasiswa/C_Base_Mahasiswa.php",
    "app/Controllers/Mahasiswa/C_Dashboard.php": "app/Controllers/Mahasiswa/C_Dashboard_Mahasiswa.php",
    "app/Controllers/Mahasiswa/C_Logbook.php": "app/Controllers/Mahasiswa/C_Logbook_Mahasiswa.php",
    "app/Controllers/Mahasiswa/C_Permohonan.php": "app/Controllers/Mahasiswa/C_Permohonan_Mahasiswa.php",
    "app/Controllers/Mahasiswa/C_Profil.php": "app/Controllers/Mahasiswa/C_Profil_Mahasiswa.php",
    "app/Controllers/Mahasiswa/C_Sertifikat.php": "app/Controllers/Mahasiswa/C_Sertifikat_Mahasiswa.php",
    "app/Controllers/Mahasiswa/C_Status.php": "app/Controllers/Mahasiswa/C_Status_Mahasiswa.php",
    "app/Controllers/Sekretariat/C_Auth.php": "app/Controllers/Sekretariat/C_Auth_Sekretariat.php",
    "app/Controllers/Sekretariat/C_Dashboard.php": "app/Controllers/Sekretariat/C_Dashboard_Sekretariat.php",
    "app/Controllers/Sekretariat/C_FileProsesMagang.php": "app/Controllers/Sekretariat/C_FileProsesMagang_Sekretariat.php",
    "app/Controllers/Sekretariat/C_MonitoringStatus.php": "app/Controllers/Sekretariat/C_MonitoringStatus_Sekretariat.php",
    "app/Controllers/Sekretariat/C_Placeholder.php": "app/Controllers/Sekretariat/C_Placeholder_Sekretariat.php",
    "app/Controllers/Sekretariat/C_Profile.php": "app/Controllers/Sekretariat/C_Profile_Sekretariat.php",
    "app/Controllers/Sekretariat/C_Riwayat.php": "app/Controllers/Sekretariat/C_Riwayat_Sekretariat.php",
    "app/Controllers/Sekretariat/C_Sertifikat.php": "app/Controllers/Sekretariat/C_Sertifikat_Sekretariat.php",
    "app/Controllers/Sekretariat/C_StatusPermohonan.php": "app/Controllers/Sekretariat/C_StatusPermohonan_Sekretariat.php",
    "app/Controllers/Sekretariat/C_UploadSuratPenerimaan.php": "app/Controllers/Sekretariat/C_UploadSuratPenerimaan_Sekretariat.php",
    "app/Controllers/Sekretariat/C_Verifikasi.php": "app/Controllers/Sekretariat/C_Verifikasi_Sekretariat.php",
}

model_mapping = {
    "app/Models/FakultasModel.php": "app/Models/Shared/M_Fakultas.php",
    "app/Models/FilePermohonanMagangModel.php": "app/Models/Shared/M_FilePermohonanMagang.php",
    "app/Models/FilePermohonanModel.php": "app/Models/Shared/M_FilePermohonan.php",
    "app/Models/FileProsesMagangModel.php": "app/Models/Shared/M_FileProsesMagang.php",
    "app/Models/InstansiMahasiswaModel.php": "app/Models/Shared/M_InstansiMahasiswa.php",
    "app/Models/InstansiPendidikanModel.php": "app/Models/Shared/M_InstansiPendidikan.php",
    "app/Models/KuotaBidangModel.php": "app/Models/Shared/M_KuotaBidang.php",
    "app/Models/LogbookMagangModel.php": "app/Models/Shared/M_LogbookMagang.php",
    "app/Models/LogPermohonanModel.php": "app/Models/Shared/M_LogPermohonan.php",
    "app/Models/MahasiswaModel.php": "app/Models/Shared/M_Mahasiswa.php",
    "app/Models/MenuModel.php": "app/Models/Shared/M_Menu.php",
    "app/Models/MenuPrivilegeModel.php": "app/Models/Shared/M_MenuPrivilege.php",
    "app/Models/PenempatanMagangModel.php": "app/Models/Shared/M_PenempatanMagang.php",
    "app/Models/PermohonanMagangModel.php": "app/Models/Shared/M_PermohonanMagang.php",
    "app/Models/PersetujuanMagangModel.php": "app/Models/Shared/M_PersetujuanMagang.php",
    "app/Models/ProdiModel.php": "app/Models/Shared/M_Prodi.php",
    "app/Models/UserGroupModel.php": "app/Models/Shared/M_UserGroup.php",
    "app/Models/UserMahasiswaModel.php": "app/Models/Mahasiswa/M_User_Mahasiswa.php",
    "app/Models/Kabid/M_LogbookKabid.php": "app/Models/Bidang/M_Logbook_Bidang.php",
    "app/Models/Kabid/M_Penempatan.php": "app/Models/Bidang/M_Penempatan_Bidang.php",
    "app/Models/Mahasiswa/M_Fakultas.php": "app/Models/Mahasiswa/M_Fakultas_Mahasiswa.php",
    "app/Models/Mahasiswa/M_FilePermohonan.php": "app/Models/Mahasiswa/M_FilePermohonan_Mahasiswa.php",
    "app/Models/Mahasiswa/M_FilePermohonanMagang.php": "app/Models/Mahasiswa/M_FilePermohonanMagang_Mahasiswa.php",
    "app/Models/Mahasiswa/M_FileProsesMagang.php": "app/Models/Mahasiswa/M_FileProsesMagang_Mahasiswa.php",
    "app/Models/Mahasiswa/M_InstansiMahasiswa.php": "app/Models/Mahasiswa/M_InstansiMahasiswa_Mahasiswa.php",
    "app/Models/Mahasiswa/M_InstansiPendidikan.php": "app/Models/Mahasiswa/M_InstansiPendidikan_Mahasiswa.php",
    "app/Models/Mahasiswa/M_LogbookMagang.php": "app/Models/Mahasiswa/M_LogbookMagang_Mahasiswa.php",
    "app/Models/Mahasiswa/M_Mahasiswa.php": "app/Models/Mahasiswa/M_Mahasiswa_Mahasiswa.php",
    "app/Models/Mahasiswa/M_PenempatanMagang.php": "app/Models/Mahasiswa/M_PenempatanMagang_Mahasiswa.php",
    "app/Models/Mahasiswa/M_PermohonanMagang.php": "app/Models/Mahasiswa/M_PermohonanMagang_Mahasiswa.php",
    "app/Models/Mahasiswa/M_Prodi.php": "app/Models/Mahasiswa/M_Prodi_Mahasiswa.php",
    "app/Models/Mahasiswa/M_UserMahasiswa.php": "app/Models/Mahasiswa/M_User_Mahasiswa.php",
    "app/Models/Sekretariat/M_Auth.php": "app/Models/Sekretariat/M_Auth_Sekretariat.php",
    "app/Models/Sekretariat/M_Disposisi.php": "app/Models/Sekretariat/M_Disposisi_Sekretariat.php",
    "app/Models/Sekretariat/M_File.php": "app/Models/Sekretariat/M_File_Sekretariat.php",
    "app/Models/Sekretariat/M_FileProsesMagang.php": "app/Models/Sekretariat/M_FileProsesMagang_Sekretariat.php",
    "app/Models/Sekretariat/M_Penilaian.php": "app/Models/Sekretariat/M_Penilaian_Sekretariat.php",
    "app/Models/Sekretariat/M_Sertifikat.php": "app/Models/Sekretariat/M_Sertifikat_Sekretariat.php",
    "app/Models/Sekretariat/M_StatusPermohonan.php": "app/Models/Sekretariat/M_StatusPermohonan_Sekretariat.php",
    "app/Models/Sekretariat/M_Verifikasi.php": "app/Models/Sekretariat/M_Verifikasi_Sekretariat.php",
}

view_mapping = {
    "app/Views/landing.php": "app/Views/V_Landing.php",
    "app/Views/welcome_message.php": "app/Views/V_WelcomeMessage.php",
    "app/Views/admin/daftar_pengajuan.php": "app/Views/superadmin/V_DaftarPengajuan_SuperAdmin.php",
    "app/Views/auth/login.php": "app/Views/auth/V_Login_Auth.php",
    "app/Views/auth/login_pegawai.php": "app/Views/auth/V_LoginPegawai_Auth.php",
    "app/Views/auth/register.php": "app/Views/auth/V_Register_Auth.php",
    "app/Views/dashboard/kabid/v_dashboard_kabid.php": "app/Views/bidang/V_Dashboard_Bidang.php",
    "app/Views/dashboard/kabid/v_disposisi_masuk.php": "app/Views/bidang/V_DisposisiMasuk_Bidang.php",
    "app/Views/dashboard/kabid/v_kuota_bidang.php": "app/Views/bidang/V_KuotaBidang_Bidang.php",
    "app/Views/dashboard/kabid/v_logbook_detail_approval.php": "app/Views/bidang/V_LogbookDetailApproval_Bidang.php",
    "app/Views/dashboard/kabid/v_logbook_mahasiswa.php": "app/Views/bidang/V_LogbookMahasiswa_Bidang.php",
    "app/Views/dashboard/kabid/v_upload_dokumen.php": "app/Views/bidang/V_UploadDokumen_Bidang.php",
    "app/Views/dashboard/kabid/v_upload_dokumen_index.php": "app/Views/bidang/V_UploadDokumenIndex_Bidang.php",
    "app/Views/dashboard/sekretariat/v_dashboard.php": "app/Views/sekretariat/V_Dashboard_Sekretariat.php",
    "app/Views/dashboard/sekretariat/v_monitoring_status.php": "app/Views/sekretariat/V_MonitoringStatus_Sekretariat.php",
    "app/Views/dashboard/sekretariat/v_placeholder.php": "app/Views/sekretariat/V_Placeholder_Sekretariat.php",
    "app/Views/dashboard/sekretariat/v_profile.php": "app/Views/sekretariat/V_Profile_Sekretariat.php",
    "app/Views/dashboard/sekretariat/v_riwayat.php": "app/Views/sekretariat/V_Riwayat_Sekretariat.php",
    "app/Views/dashboard/sekretariat/v_sertifikat.php": "app/Views/sekretariat/V_Sertifikat_Sekretariat.php",
    "app/Views/dashboard/sekretariat/v_status_permohonan.php": "app/Views/sekretariat/V_StatusPermohonan_Sekretariat.php",
    "app/Views/dashboard/sekretariat/upload_surat_penerimaan/index.php": "app/Views/sekretariat/V_UploadSuratPenerimaanIndex_Sekretariat.php",
    "app/Views/dashboard/sekretariat/upload_surat_penerimaan/_detail.php": "app/Views/sekretariat/V_UploadSuratPenerimaanDetail_Sekretariat.php",
    "app/Views/dashboard/sekretariat/upload_surat_penerimaan/_list.php": "app/Views/sekretariat/V_UploadSuratPenerimaanList_Sekretariat.php",
    "app/Views/dashboard/sekretariat/verifikasi/index.php": "app/Views/sekretariat/V_VerifikasiIndex_Sekretariat.php",
    "app/Views/dashboard/sekretariat/verifikasi/_detail.php": "app/Views/sekretariat/V_VerifikasiDetail_Sekretariat.php",
    "app/Views/dashboard/sekretariat/verifikasi/_list.php": "app/Views/sekretariat/V_VerifikasiList_Sekretariat.php",
    "app/Views/layout/L_master.php": "app/Views/layout/V_Master.php",
    "app/Views/layout/L_master_kabid.php": "app/Views/layout/V_Master_Bidang.php",
    "app/Views/layout/L_navbar.php": "app/Views/layout/V_Navbar.php",
    "app/Views/layout/L_sidebar.php": "app/Views/layout/V_Sidebar.php",
    "app/Views/layout/L_sidebar_kabid.php": "app/Views/layout/V_Sidebar_Bidang.php",
    "app/Views/layout/mahasiswa.php": "app/Views/layout/V_Mahasiswa.php",
    "app/Views/layout/pagination.php": "app/Views/layout/V_Pagination.php",
    "app/Views/mahasiswa/v_cetak_logbook.php": "app/Views/mahasiswa/V_CetakLogbook_Mahasiswa.php",
    "app/Views/mahasiswa/v_dashboard.php": "app/Views/mahasiswa/V_Dashboard_Mahasiswa.php",
    "app/Views/mahasiswa/v_detail_permohonan.php": "app/Views/mahasiswa/V_DetailPermohonan_Mahasiswa.php",
    "app/Views/mahasiswa/v_form_edit_permohonan.php": "app/Views/mahasiswa/V_FormEditPermohonan_Mahasiswa.php",
    "app/Views/mahasiswa/v_form_permohonan.php": "app/Views/mahasiswa/V_FormPermohonan_Mahasiswa.php",
    "app/Views/mahasiswa/v_part_wizard_script.php": "app/Views/mahasiswa/V_PartWizardScript_Mahasiswa.php",
    "app/Views/mahasiswa/v_part_wizard_style.php": "app/Views/mahasiswa/V_PartWizardStyle_Mahasiswa.php",
    "app/Views/mahasiswa/v_profil_mahasiswa.php": "app/Views/mahasiswa/V_ProfilMahasiswa_Mahasiswa.php",
    "app/Views/mahasiswa/v_riwayat_logbook.php": "app/Views/mahasiswa/V_RiwayatLogbook_Mahasiswa.php",
    "app/Views/mahasiswa/v_status_permohonan.php": "app/Views/mahasiswa/V_StatusPermohonan_Mahasiswa.php",
    "app/Views/mahasiswa/v_unduh_sertifikat.php": "app/Views/mahasiswa/V_UnduhSertifikat_Mahasiswa.php",
}

# 1. First, create a list of class name changes and namespace changes.
# For Controllers and Models
class_changes = {} # old_full_class -> new_full_class e.g. App\Controllers\Admin -> App\Controllers\SuperAdmin\C_Admin_SuperAdmin

for mapping in [controller_mapping, model_mapping]:
    for old, new in mapping.items():
        old_part = old.replace("app/", "").replace(".php", "").replace("/", "\\")
        new_part = new.replace("app/", "").replace(".php", "").replace("/", "\\")
        class_changes["App\\" + old_part] = "App\\" + new_part
        # Also map without App\ just in case
        class_changes[old_part] = new_part

# Map view paths for replacement in code
view_replace_map = {}
for old, new in view_mapping.items():
    old_v = old.replace("app/Views/", "").replace(".php", "")
    new_v = new.replace("app/Views/", "").replace(".php", "")
    view_replace_map[old_v] = new_v

# 2. File Mover function
def move_file(old_path, new_path):
    old_full = os.path.join(base_dir, old_path)
    new_full = os.path.join(base_dir, new_path)
    
    if os.path.exists(old_full):
        os.makedirs(os.path.dirname(new_full), exist_ok=True)
        shutil.move(old_full, new_full)
        print(f"Moved {old_path} -> {new_path}")
    else:
        print(f"Warning: {old_path} not found.")

print("Moving Controllers...")
for old, new in controller_mapping.items():
    move_file(old, new)

print("Moving Models...")
for old, new in model_mapping.items():
    move_file(old, new)

print("Moving Views...")
for old, new in view_mapping.items():
    move_file(old, new)

# Cleanup empty directories
for root, dirs, files in os.walk(app_dir, topdown=False):
    for d in dirs:
        dir_path = os.path.join(root, d)
        try:
            if not os.listdir(dir_path):
                os.rmdir(dir_path)
        except Exception:
            pass
