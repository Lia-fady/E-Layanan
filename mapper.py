import os
import re

files_list = [
    "app/Controllers/Admin.php",
    "app/Controllers/ApiController.php",
    "app/Controllers/AuthController.php",
    "app/Controllers/BaseController.php",
    "app/Controllers/Home.php",
    "app/Controllers/Api/Log.php",
    "app/Controllers/Kabid/C_DashboardKabid.php",
    "app/Controllers/Kabid/C_DisposisiMasuk.php",
    "app/Controllers/Kabid/C_FileProsesMagangKabid.php",
    "app/Controllers/Kabid/C_KuotaBidang.php",
    "app/Controllers/Kabid/C_LogbookKabid.php",
    "app/Controllers/Kabid/C_UploadDokumen.php",
    "app/Controllers/Mahasiswa/C_BaseMahasiswa.php",
    "app/Controllers/Mahasiswa/C_Dashboard.php",
    "app/Controllers/Mahasiswa/C_Logbook.php",
    "app/Controllers/Mahasiswa/C_Permohonan.php",
    "app/Controllers/Mahasiswa/C_Profil.php",
    "app/Controllers/Mahasiswa/C_Sertifikat.php",
    "app/Controllers/Mahasiswa/C_Status.php",
    "app/Controllers/Sekretariat/C_Auth.php",
    "app/Controllers/Sekretariat/C_Dashboard.php",
    "app/Controllers/Sekretariat/C_FileProsesMagang.php",
    "app/Controllers/Sekretariat/C_MonitoringStatus.php",
    "app/Controllers/Sekretariat/C_Placeholder.php",
    "app/Controllers/Sekretariat/C_Profile.php",
    "app/Controllers/Sekretariat/C_Riwayat.php",
    "app/Controllers/Sekretariat/C_Sertifikat.php",
    "app/Controllers/Sekretariat/C_StatusPermohonan.php",
    "app/Controllers/Sekretariat/C_UploadSuratPenerimaan.php",
    "app/Controllers/Sekretariat/C_Verifikasi.php",
    "app/Models/FakultasModel.php",
    "app/Models/FilePermohonanMagangModel.php",
    "app/Models/FilePermohonanModel.php",
    "app/Models/FileProsesMagangModel.php",
    "app/Models/InstansiMahasiswaModel.php",
    "app/Models/InstansiPendidikanModel.php",
    "app/Models/KuotaBidangModel.php",
    "app/Models/LogbookMagangModel.php",
    "app/Models/LogPermohonanModel.php",
    "app/Models/MahasiswaModel.php",
    "app/Models/MenuModel.php",
    "app/Models/MenuPrivilegeModel.php",
    "app/Models/PenempatanMagangModel.php",
    "app/Models/PermohonanMagangModel.php",
    "app/Models/PersetujuanMagangModel.php",
    "app/Models/ProdiModel.php",
    "app/Models/UserGroupModel.php",
    "app/Models/UserMahasiswaModel.php",
    "app/Models/Kabid/M_LogbookKabid.php",
    "app/Models/Kabid/M_Penempatan.php",
    "app/Models/Mahasiswa/M_Fakultas.php",
    "app/Models/Mahasiswa/M_FilePermohonan.php",
    "app/Models/Mahasiswa/M_FilePermohonanMagang.php",
    "app/Models/Mahasiswa/M_FileProsesMagang.php",
    "app/Models/Mahasiswa/M_InstansiMahasiswa.php",
    "app/Models/Mahasiswa/M_InstansiPendidikan.php",
    "app/Models/Mahasiswa/M_LogbookMagang.php",
    "app/Models/Mahasiswa/M_Mahasiswa.php",
    "app/Models/Mahasiswa/M_PenempatanMagang.php",
    "app/Models/Mahasiswa/M_PermohonanMagang.php",
    "app/Models/Mahasiswa/M_Prodi.php",
    "app/Models/Mahasiswa/M_UserMahasiswa.php",
    "app/Models/Sekretariat/M_Auth.php",
    "app/Models/Sekretariat/M_Disposisi.php",
    "app/Models/Sekretariat/M_File.php",
    "app/Models/Sekretariat/M_FileProsesMagang.php",
    "app/Models/Sekretariat/M_Penilaian.php",
    "app/Models/Sekretariat/M_Sertifikat.php",
    "app/Models/Sekretariat/M_StatusPermohonan.php",
    "app/Models/Sekretariat/M_Verifikasi.php",
    "app/Views/landing.php",
    "app/Views/welcome_message.php",
    "app/Views/admin/daftar_pengajuan.php",
    "app/Views/auth/login.php",
    "app/Views/auth/login_pegawai.php",
    "app/Views/auth/register.php",
    "app/Views/dashboard/kabid/v_dashboard_kabid.php",
    "app/Views/dashboard/kabid/v_disposisi_masuk.php",
    "app/Views/dashboard/kabid/v_kuota_bidang.php",
    "app/Views/dashboard/kabid/v_logbook_detail_approval.php",
    "app/Views/dashboard/kabid/v_logbook_mahasiswa.php",
    "app/Views/dashboard/kabid/v_upload_dokumen.php",
    "app/Views/dashboard/kabid/v_upload_dokumen_index.php",
    "app/Views/dashboard/sekretariat/v_dashboard.php",
    "app/Views/dashboard/sekretariat/v_monitoring_status.php",
    "app/Views/dashboard/sekretariat/v_placeholder.php",
    "app/Views/dashboard/sekretariat/v_profile.php",
    "app/Views/dashboard/sekretariat/v_riwayat.php",
    "app/Views/dashboard/sekretariat/v_sertifikat.php",
    "app/Views/dashboard/sekretariat/v_status_permohonan.php",
    "app/Views/dashboard/sekretariat/upload_surat_penerimaan/index.php",
    "app/Views/dashboard/sekretariat/upload_surat_penerimaan/_detail.php",
    "app/Views/dashboard/sekretariat/upload_surat_penerimaan/_list.php",
    "app/Views/dashboard/sekretariat/verifikasi/index.php",
    "app/Views/dashboard/sekretariat/verifikasi/_detail.php",
    "app/Views/dashboard/sekretariat/verifikasi/_list.php",
    "app/Views/layout/L_master.php",
    "app/Views/layout/L_master_kabid.php",
    "app/Views/layout/L_navbar.php",
    "app/Views/layout/L_sidebar.php",
    "app/Views/layout/L_sidebar_kabid.php",
    "app/Views/layout/mahasiswa.php",
    "app/Views/layout/pagination.php",
    "app/Views/mahasiswa/v_cetak_logbook.php",
    "app/Views/mahasiswa/v_dashboard.php",
    "app/Views/mahasiswa/v_detail_permohonan.php",
    "app/Views/mahasiswa/v_form_edit_permohonan.php",
    "app/Views/mahasiswa/v_form_permohonan.php",
    "app/Views/mahasiswa/v_part_wizard_script.php",
    "app/Views/mahasiswa/v_part_wizard_style.php",
    "app/Views/mahasiswa/v_profil_mahasiswa.php",
    "app/Views/mahasiswa/v_riwayat_logbook.php",
    "app/Views/mahasiswa/v_status_permohonan.php",
    "app/Views/mahasiswa/v_unduh_sertifikat.php"
]

def map_filename(path):
    parts = path.split('/')
    folder = parts[1] # Controllers, Models, Views
    
    actor = None
    if len(parts) > 3:
        if folder == 'Views':
            # e.g. app/Views/dashboard/sekretariat/v_dashboard.php
            if parts[2] == 'dashboard':
                actor = parts[3]
            else:
                actor = parts[2]
        else:
            actor = parts[2]
    elif len(parts) == 3:
        # e.g. app/Views/mahasiswa/v_dashboard.php
        if folder == 'Views':
            actor = parts[2]
            
    # capitalize actor if needed
    actor_map = {
        'kabid': 'Bidang',
        'Kabid': 'Bidang',
        'sekretariat': 'Sekretariat',
        'Sekretariat': 'Sekretariat',
        'mahasiswa': 'Mahasiswa',
        'Mahasiswa': 'Mahasiswa',
        'admin': 'SuperAdmin',
        'SuperAdmin': 'SuperAdmin',
        'auth': 'Auth',
        'Auth': 'Auth'
    }
    
    # We will refine manually, let's just dump list for now
    pass
