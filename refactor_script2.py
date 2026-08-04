import os
import re

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

# 1. Build view replacements:
# old: 'admin/daftar_pengajuan', new: 'superadmin/V_DaftarPengajuan_SuperAdmin'
view_replacements = {}
for old, new in view_mapping.items():
    old_str = old.replace("app/Views/", "").replace(".php", "")
    new_str = new.replace("app/Views/", "").replace(".php", "")
    view_replacements[old_str] = new_str

# 2. Build class/namespace replacements
# namespace App\Models; -> namespace App\Models\Shared;
# use App\Models\MenuModel; -> use App\Models\Shared\M_Menu;
class_replacements = {}
for old, new in list(controller_mapping.items()) + list(model_mapping.items()):
    old_ns = old.replace("app/", "App/").replace(".php", "").replace("/", "\\")
    new_ns = new.replace("app/", "App/").replace(".php", "").replace("/", "\\")
    old_class = old_ns.split("\\")[-1]
    new_class = new_ns.split("\\")[-1]
    class_replacements[old_ns] = new_ns
    class_replacements[f"use {old_ns};"] = f"use {new_ns};"
    class_replacements[f"new {old_class}"] = f"new {new_class}"

# Now we also need to fix Routes.php which has 'Admin::index' -> 'C_Admin_SuperAdmin::index'
# or 'Kabid\C_DashboardKabid::' -> 'Bidang\C_Dashboard_Bidang::'
route_replacements = {}
for old, new in controller_mapping.items():
    old_path = old.replace("app/Controllers/", "").replace(".php", "")
    new_path = new.replace("app/Controllers/", "").replace(".php", "")
    # In Routes, they might do 'Kabid\C_DashboardKabid::'
    old_route_str = old_path.replace("/", "\\")
    new_route_str = new_path.replace("/", "\\")
    route_replacements[old_route_str] = new_route_str

# 3. Update the files themselves (namespaces and class names)
def update_self_class(file_path):
    # figure out new namespace based on path
    rel_path = file_path.replace(base_dir + "\\", "").replace("\\", "/")
    parts = rel_path.split("/")
    if parts[0] != "app" or parts[1] not in ["Controllers", "Models"]:
        return
    
    # Example: app/Controllers/SuperAdmin/C_Admin_SuperAdmin.php
    expected_ns = "\\".join(["App"] + parts[1:-1])
    class_name = parts[-1].replace(".php", "")
    
    with open(file_path, "r", encoding="utf-8") as f:
        content = f.read()
    
    # replace namespace
    expected_ns_escaped = expected_ns.replace("\\", "\\\\")
    content = re.sub(r'namespace App\\[a-zA-Z0-9_\\]+;', f'namespace {expected_ns_escaped};', content)
    
    # replace class name
    content = re.sub(r'class [a-zA-Z0-9_]+ extends', f'class {class_name} extends', content)
    
    with open(file_path, "w", encoding="utf-8") as f:
        f.write(content)

# Update contents of all PHP files
for root, dirs, files in os.walk(app_dir):
    for f in files:
        if f.endswith(".php"):
            full_path = os.path.join(root, f)
            with open(full_path, "r", encoding="utf-8") as file:
                content = file.read()
            
            original_content = content
            
            # 1. Update view(), extend(), include()
            # Careful not to replace 'layout/v_navbar' if it's partly matched, so we sort by length desc
            for old_v, new_v in sorted(view_replacements.items(), key=lambda x: len(x[0]), reverse=True):
                # single quotes
                content = content.replace(f"view('{old_v}')", f"view('{new_v}')")
                content = content.replace(f"view('{old_v}'", f"view('{new_v}'") # with data array
                content = content.replace(f"include('{old_v}')", f"include('{new_v}')")
                content = content.replace(f"extend('{old_v}')", f"extend('{new_v}')")
                # double quotes
                content = content.replace(f'view("{old_v}")', f'view("{new_v}")')
                content = content.replace(f'view("{old_v}"', f'view("{new_v}"')
                content = content.replace(f'include("{old_v}")', f'include("{new_v}")')
                content = content.replace(f'extend("{old_v}")', f'extend("{new_v}")')
            
            # 2. Update use statements and instantiations
            for old_ns, new_ns in sorted(class_replacements.items(), key=lambda x: len(x[0]), reverse=True):
                content = content.replace(old_ns, new_ns)
            
            # 3. Update route strings (only relevant usually for Routes.php or redirect()->to)
            # Actually, let's just do it for Routes.php
            if "Routes.php" in full_path:
                for old_route, new_route in sorted(route_replacements.items(), key=lambda x: len(x[0]), reverse=True):
                    content = content.replace(f"'{old_route}::", f"'{new_route}::")
                    content = content.replace(f"'{old_route}'", f"'{new_route}'")
                    content = content.replace(f'"{old_route}::', f'"{new_route}::')
                    content = content.replace(f'"{old_route}"', f'"{new_route}"')
            
            if content != original_content:
                with open(full_path, "w", encoding="utf-8") as file:
                    file.write(content)
            
            # After replacing dependencies, also update its own namespace and class
            update_self_class(full_path)

print("Content update complete.")
