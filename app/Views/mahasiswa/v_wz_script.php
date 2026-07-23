<script>
const JENIS_LABELS = {
    '1': 'Penelitian Skripsi / TA',
    '2': 'Observasi / Pengambilan Data',
    '3': 'Magang / PKL',
    '4': 'Uji Coba Produk (Prototype)'
};

const JENIS_CFG = {
    '1': {
        keahlian: 'Deskripsi Judul Skripsi / TA',
        phK: 'Jelaskan draf atau gambaran umum judul penelitian Skripsi/TA Anda...',
        magang: 'Deskripsi Rencana Topik / Rumusan Masalah',
        phM: 'Jelaskan rumusan masalah atau ruang lingkup data akademik...',
        surat: 'Surat Izin Penelitian Resmi Kampus',
        cv: 'Proposal / Sinopsis Penelitian Skripsi',
        tujuan: 'Penelitian / Riset Akademik',
        showCv: true
    },
    '2': {
        keahlian: 'Deskripsi Latar Belakang Observasi',
        phK: 'Jelaskan tujuan atau tugas mata kuliah yang melatarbelakangi observasi...',
        magang: 'Deskripsi Daftar Kebutuhan Data',
        phM: 'Sebutkan jenis data atau informasi yang ingin diambil di Dinas Kominfo...',
        surat: 'Surat Pengantar Kebutuhan Data Kampus',
        cv: null,
        tujuan: 'Observasi Lapangan / Survei',
        showCv: false
    },
    '3': {
        keahlian: 'Deskripsi Keahlian / Skill',
        phK: 'Jelaskan keahlian atau kompetensi teknis yang Anda miliki...',
        magang: 'Deskripsi Rencana Magang / Kegiatan',
        phM: 'Jelaskan maksud, tujuan, atau rencana topik magang...',
        surat: 'Surat Pengantar Resmi Kampus',
        cv: 'Curriculum Vitae (CV) Terbaru',
        tujuan: 'Praktik Kerja Lapangan',
        showCv: true
    },
    '4': {
        keahlian: 'Deskripsi Profil Aplikasi / Sistem',
        phK: 'Jelaskan spesifikasi atau nama sistem prototype yang ingin diuji...',
        magang: 'Deskripsi Skenario Uji Coba / Metode',
        phM: 'Jelaskan rencana target bidang yang akan menggunakan prototype...',
        surat: 'Surat Pengantar Uji Coba Produk Kampus',
        cv: 'Dokumen Profil / Panduan Singkat Produk',
        tujuan: 'Uji Coba / Testing Sistem',
        showCv: true
    }
};

/* ============ Character Counter ============ */
function countChars(el, sid) {
    document.getElementById(sid).textContent = el.value.length;
}
['deskripsi_keahlian', 'deskripsi_magang'].forEach(function(id) {
    var el = document.getElementById(id);
    if (el && el.value) el.dispatchEvent(new Event('input'));
});

/* ============ Jenis Config ============ */
function applyJenisCfg(val) {
    var cfg = JENIS_CFG[val];
    if (!cfg) return;
    document.getElementById('lbl-keahlian').innerHTML = cfg.keahlian + ' <span class="text-danger">*</span>';
    document.getElementById('deskripsi_keahlian').placeholder = cfg.phK;
    document.getElementById('lbl-magang').innerHTML = cfg.magang + ' <span class="text-danger">*</span>';
    document.getElementById('deskripsi_magang').placeholder = cfg.phM;
    document.getElementById('lbl-surat').innerHTML = cfg.surat + ' <span class="text-danger">*</span>';

    var wCv = document.getElementById('wrapper-cv');
    var iCv = document.getElementById('input-cv');
    if (cfg.showCv) {
        wCv.style.display = 'block';
        iCv.required = true;
        document.getElementById('lbl-cv').innerHTML = cfg.cv + ' <span class="text-danger">*</span>';
    } else {
        wCv.style.display = 'none';
        iCv.required = false;
        iCv.value = '';
        resetZone('zone-cv', 'ph-cv', 'pv-cv');
    }
}

document.querySelectorAll('input[name="id_jenis_permohonan"]').forEach(function(r) {
    r.addEventListener('change', function() {
        applyJenisCfg(this.value);
        document.getElementById('err-jenis').classList.add('d-none');
    });
});

var oldJenis = document.querySelector('input[name="id_jenis_permohonan"]:checked');
if (oldJenis) applyJenisCfg(oldJenis.value);

/* ============ Upload Zone ============ */
function setupZone(inputId, zoneId, phId, pvId, nmId) {
    var inp = document.getElementById(inputId);
    var z = document.getElementById(zoneId);
    function showFile(f) {
        document.getElementById(nmId).textContent = f.name;
        document.getElementById(phId).classList.add('d-none');
        document.getElementById(pvId).classList.remove('d-none');
        z.classList.add('is-filled');
    }
    inp.addEventListener('change', function() {
        if (this.files && this.files[0]) showFile(this.files[0]);
    });
    z.addEventListener('dragover', function(e) { e.preventDefault(); z.classList.add('is-dragging'); });
    z.addEventListener('dragleave', function() { z.classList.remove('is-dragging'); });
    z.addEventListener('drop', function(e) {
        e.preventDefault();
        z.classList.remove('is-dragging');
        if (e.dataTransfer.files[0]) {
            inp.files = e.dataTransfer.files;
            showFile(e.dataTransfer.files[0]);
        }
    });
}

function resetZone(zId, phId, pvId) {
    document.getElementById(zId).classList.remove('is-filled');
    document.getElementById(phId).classList.remove('d-none');
    document.getElementById(pvId).classList.add('d-none');
}

setupZone('input-surat', 'zone-surat', 'ph-surat', 'pv-surat', 'nm-surat');
setupZone('input-cv', 'zone-cv', 'ph-cv', 'pv-cv', 'nm-cv');

/* ============ Stepper State ============ */
var currentStep = 1;

function updateStepper(step) {
    for (var i = 1; i <= 4; i++) {
        var sc = document.getElementById('sc-' + i);
        var ic = document.getElementById('si-' + i);
        var nm = document.getElementById('sn-' + i);
        var ln = document.getElementById('sl-num-' + i);
        var lt = document.getElementById('sl-title-' + i);
        var fl = document.getElementById('sf-' + i);

        sc.classList.remove('is-active', 'is-done');
        ln.classList.remove('is-active', 'is-done');
        lt.classList.remove('is-active', 'is-done');

        if (i < step || (step === 3 && i === 3)) {
            sc.classList.add('is-done'); ln.classList.add('is-done'); lt.classList.add('is-done');
            ic.classList.remove('d-none'); nm.classList.add('d-none');
        } else if (i === step) {
            sc.classList.add('is-active'); ln.classList.add('is-active'); lt.classList.add('is-active');
            ic.classList.add('d-none'); nm.classList.remove('d-none');
        } else {
            ic.classList.add('d-none'); nm.classList.remove('d-none');
        }
        if (fl) fl.style.width = (i < step) ? '100%' : '0%';
    }
}

function showStep(step) {
    document.querySelectorAll('.wizard-step').forEach(function(s) { s.classList.remove('is-active'); });
    document.getElementById('step-' + step).classList.add('is-active');
    currentStep = step;
    updateStepper(step);
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

/* ============ Validation ============ */
function sAlert(msg) {
    Swal.fire({ icon: 'warning', title: 'Perhatian', text: msg, confirmButtonColor: '#0a1d37', confirmButtonText: 'Mengerti' });
}

function vStep1() {
    var j = document.querySelector('input[name="id_jenis_permohonan"]:checked');
    if (!j) { document.getElementById('err-jenis').classList.remove('d-none'); return false; }
    document.getElementById('err-jenis').classList.add('d-none');
    var tM = document.getElementById('tgl_mulai').value;
    var tS = document.getElementById('tgl_selesai').value;
    var k = document.getElementById('deskripsi_keahlian').value.trim();
    var mg = document.getElementById('deskripsi_magang').value.trim();
    if (!tM) { sAlert('Tanggal mulai wajib diisi.'); return false; }
    if (!tS) { sAlert('Tanggal selesai wajib diisi.'); return false; }
    if (new Date(tS) <= new Date(tM)) { sAlert('Tanggal selesai harus setelah tanggal mulai.'); return false; }
    if (k.length < 10) { sAlert('Deskripsi keahlian minimal 10 karakter.'); return false; }
    if (mg.length < 20) { sAlert('Deskripsi rencana kegiatan minimal 20 karakter.'); return false; }
    return true;
}

function vStep2() {
    var sr = document.getElementById('input-surat');
    if (!sr.files || !sr.files[0]) { sAlert('Surat pengantar wajib diunggah.'); return false; }
    if (sr.files[0].size > 2 * 1024 * 1024) { sAlert('Ukuran surat pengantar maksimal 2 MB.'); return false; }
    if (!sr.files[0].name.toLowerCase().endsWith('.pdf')) { sAlert('Surat pengantar harus berformat PDF.'); return false; }

    var wCv = document.getElementById('wrapper-cv');
    if (wCv.style.display !== 'none') {
        var cv = document.getElementById('input-cv');
        if (!cv.files || !cv.files[0]) { sAlert('Berkas CV / Proposal wajib diunggah.'); return false; }
        if (cv.files[0].size > 2 * 1024 * 1024) { sAlert('Ukuran CV / Proposal maksimal 2 MB.'); return false; }
        if (!cv.files[0].name.toLowerCase().endsWith('.pdf')) { sAlert('CV / Proposal harus berformat PDF.'); return false; }
    }
    return true;
}

/* ============ Populate Review ============ */
function fmtDate(v) {
    if (!v) return '—';
    return new Date(v).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
}

function fillReview() {
    var j = document.querySelector('input[name="id_jenis_permohonan"]:checked');
    var jVal = j ? j.value : null;
    document.getElementById('rv-jenis').textContent = j ? JENIS_LABELS[jVal] : '—';
    document.getElementById('rv-tujuan').textContent = j ? JENIS_CFG[jVal].tujuan : '—';
    document.getElementById('rv-tgl-mulai').textContent = fmtDate(document.getElementById('tgl_mulai').value);
    document.getElementById('rv-tgl-selesai').textContent = fmtDate(document.getElementById('tgl_selesai').value);
    document.getElementById('rv-keahlian').textContent = document.getElementById('deskripsi_keahlian').value || '—';
    document.getElementById('rv-magang').textContent = document.getElementById('deskripsi_magang').value || '—';

    var tb = document.getElementById('rv-doc-tbody');
    tb.innerHTML = '';
    var no = 1;
    var sf = document.getElementById('input-surat').files[0];
    var ls = document.getElementById('lbl-surat').textContent.replace('*', '').trim();
    if (sf) {
        var sfUrl = URL.createObjectURL(sf);
        tb.innerHTML += '<tr><td class="text-muted" style="font-size:0.82rem;">' + (no++) + '</td><td class="fw-semibold">' + ls + '</td><td class="text-end"><a href="' + sfUrl + '" target="_blank" class="file-chip text-decoration-none" title="Klik untuk melihat dokumen (Preview)" style="cursor: pointer; display: inline-block; transition: all 0.2s;"><i class="bi bi-file-earmark-pdf"></i> ' + sf.name + ' <i class="bi bi-box-arrow-up-right ms-1" style="font-size: 0.75rem;"></i></a></td></tr>';
    }
    var wCv = document.getElementById('wrapper-cv');
    var cf = document.getElementById('input-cv').files[0];
    if (cf && wCv.style.display !== 'none') {
        var cfUrl = URL.createObjectURL(cf);
        var lc = document.getElementById('lbl-cv').textContent.replace('*', '').trim();
        tb.innerHTML += '<tr><td class="text-muted" style="font-size:0.82rem;">' + (no++) + '</td><td class="fw-semibold">' + lc + '</td><td class="text-end"><a href="' + cfUrl + '" target="_blank" class="file-chip text-decoration-none" title="Klik untuk melihat dokumen (Preview)" style="cursor: pointer; display: inline-block; transition: all 0.2s;"><i class="bi bi-file-earmark-pdf"></i> ' + cf.name + ' <i class="bi bi-box-arrow-up-right ms-1" style="font-size: 0.75rem;"></i></a></td></tr>';
    }
    if (!tb.innerHTML) {
        tb.innerHTML = '<tr><td colspan="3" class="text-center text-muted py-3" style="font-size:0.83rem;">Tidak ada dokumen terlampir.</td></tr>';
    }
}

/* ============ Step Navigation ============ */
function goNext(t) {
    if (t === 2 && !vStep1()) return;
    if (t === 3) { if (!vStep2()) return; fillReview(); }
    showStep(t);
}
function goPrev(t) { showStep(t); }

/* ============ Submit Handler ============ */
var formEl = document.getElementById('formPermohonan');
// Custom submission function for Draft and Kirim
function submitPermohonan(type) {
    var formEl = document.getElementById('formPermohonan') || document.getElementById('form-permohonan');
    if (!formEl) return;

    // Create or update hidden input for action_type
    var actionInput = document.getElementById('hidden_action_type');
    if (!actionInput) {
        actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'action_type';
        actionInput.id = 'hidden_action_type';
        formEl.appendChild(actionInput);
    }
    actionInput.value = type;

    if (type === 'draft') {
        Swal.fire({
            title: 'Simpan sebagai Draft?',
            text: 'Data Anda akan disimpan dan dapat Anda edit kembali nanti melalui halaman Status.',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#0a1d37',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Simpan Draft',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                var btn = document.getElementById('btn-draft');
                if (btn) { btn.innerHTML = 'Menyimpan...'; btn.disabled = true; }
                clearLocal();
                formEl.submit();
            }
        });
    } else {
        Swal.fire({
            title: 'Kirim Permohonan?',
            text: 'Pastikan semua data dan dokumen yang Anda unggah sudah benar.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0a1d37',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-send-fill"></i> Ya, Kirim Sekarang',
            cancelButtonText: 'Cek Kembali'
        }).then((result) => {
            if (result.isConfirmed) {
                var btn = document.getElementById('btn-submit');
                if (btn) {
                    btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Mengirim...';
                    btn.style.opacity = '0.75';
                    btn.disabled = true;
                }
                clearLocal();
                formEl.submit();
            }
        });
    }
}

/* ============ Reset Form ============ */
function resetFormCustom() {
    var form = document.getElementById('formPermohonan');
    if(!form) return;
    
    Swal.fire({
        title: 'Batalkan Pengisian?',
        text: 'Semua data yang sudah Anda ketik akan dihapus dan formulir akan dikosongkan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#0a1d37',
        confirmButtonText: 'Ya, Kosongkan',
        cancelButtonText: 'Kembali Mengisi',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Native reset for radios, selects, checkboxes
            form.reset();
            clearLocal();
            
            // Force clear text/date inputs (overrides PHP old() values)
            var inputs = form.querySelectorAll('input:not([readonly]):not([type="radio"]):not([type="hidden"]), textarea');
            inputs.forEach(function(el) {
                el.value = '';
                el.classList.remove('is-invalid');
            });
            
            // Reset select dropdown
            var selJenis = document.getElementById('sel-jenis');
            if(selJenis) selJenis.selectedIndex = 0;
            
            // Reset tujuan display
            var td = document.getElementById('tujuan-display');
            if(td) { td.value = 'Pilih jenis permohonan terlebih dahulu'; td.style.color = '#94a3b8'; }
            
            // Reset upload zones
            resetZone('zone-surat', 'ph-surat', 'pv-surat');
            resetZone('zone-cv', 'ph-cv', 'pv-cv');
            
            // Reset char counters
            var ccKeahlian = document.getElementById('cc-keahlian');
            if(ccKeahlian) ccKeahlian.innerText = '0';
            var ccMagang = document.getElementById('cc-magang');
            if(ccMagang) ccMagang.innerText = '0';
            
            // Hide any error texts
            var errs = form.querySelectorAll('[id^="err-"]');
            errs.forEach(function(el) { el.classList.add('d-none'); });
            
            // Reset CV wrapper visibility
            var wCv = document.getElementById('wrapper-cv');
            if(wCv) wCv.style.display = 'block';
            
            // Return to step 1
            showStep(1);
            
            // Toast Notification
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Formulir berhasil dikosongkan',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        }
    });
}
/* ============ LocalStorage Auto-Save ============ */
var LS_KEY = 'form_permohonan_<?= session()->get("id_mahasiswa") ?? "guest" ?>';
var LS_FIELDS = ['id_jenis_permohonan', 'tgl_mulai', 'tgl_selesai', 'deskripsi_keahlian', 'deskripsi_magang'];

function saveToLocal() {
    try {
        var data = {};
        // Ambil value jenis permohonan dari radio yang tercentang
        var jRadio = document.querySelector('input[name="id_jenis_permohonan"]:checked');
        data['id_jenis_permohonan'] = jRadio ? jRadio.value : '';
        // Ambil value field lainnya
        ['tgl_mulai', 'tgl_selesai', 'deskripsi_keahlian', 'deskripsi_magang'].forEach(function(id) {
            var el = document.getElementById(id);
            data[id] = el ? el.value : '';
        });
        localStorage.setItem(LS_KEY, JSON.stringify(data));
    } catch(e) { /* localStorage tidak tersedia, abaikan */ }
}

function loadFromLocal() {
    try {
        var raw = localStorage.getItem(LS_KEY);
        if (!raw) return;
        var data = JSON.parse(raw);
        var hasData = false;

        // Isi jenis permohonan
        if (data['id_jenis_permohonan']) {
            var radio = document.getElementById('jenis_' + data['id_jenis_permohonan']);
            if (radio) { radio.checked = true; applyJenisCfg(data['id_jenis_permohonan']); }
            var sel = document.getElementById('sel-jenis');
            if (sel) { sel.value = data['id_jenis_permohonan']; sel.dispatchEvent(new Event('change')); }
            hasData = true;
        }

        // Isi field teks lainnya
        ['tgl_mulai', 'tgl_selesai', 'deskripsi_keahlian', 'deskripsi_magang'].forEach(function(id) {
            var el = document.getElementById(id);
            if (el && data[id]) { el.value = data[id]; hasData = true; }
        });

        // Update character counters
        ['deskripsi_keahlian', 'deskripsi_magang'].forEach(function(id) {
            var el = document.getElementById(id);
            if (el && el.value) el.dispatchEvent(new Event('input'));
        });

        // Tampilkan toast notifikasi jika ada data yang dimuat
        if (hasData) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'info',
                title: 'Isian sebelumnya berhasil dimuat',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        }
    } catch(e) { /* abaikan jika parse gagal */ }
}

function clearLocal() {
    try { localStorage.removeItem(LS_KEY); } catch(e) {}
}

// --- Hook: auto-save setiap kali user mengubah isian ---
var formAutoSave = document.getElementById('formPermohonan');
if (formAutoSave) {
    formAutoSave.addEventListener('input', saveToLocal);
    formAutoSave.addEventListener('change', saveToLocal);
}

// --- Hook: muat data tersimpan saat halaman dibuka ---
document.addEventListener('DOMContentLoaded', function() {
    // Hanya muat jika form tersedia dan belum ada old() data dari server
    var formEl = document.getElementById('formPermohonan');
    var hasOldData = document.querySelector('input[name="id_jenis_permohonan"]:checked');
    if (formEl && !hasOldData) {
        loadFromLocal();
    }
});
</script>
