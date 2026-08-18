<script>
const JENIS_LABELS = {
    '1': 'Penelitian Skripsi / TA',
    '2': 'Observasi / Pengambilan Data',
    '3': 'Magang',
    '5': 'Praktik Kerja Lapangan (PKL)',
    '4': 'Uji Coba Produk (Prototype)'
};

const JENIS_CFG = {
    '1': {
        keahlian: 'Judul atau Topik Skripsi/TA',
        phK: 'Tuliskan judul atau gambaran umum topik penelitianmu...',
        magang: 'Fokus Penelitian / Data yang Dicari',
        phM: 'Jelaskan secara spesifik data atau informasi apa yang ingin kamu teliti...',
        surat: 'Surat Izin Penelitian Resmi Kampus',
        cv: 'Proposal / Sinopsis Penelitian Skripsi',
        ktm: 'Kartu Tanda Mahasiswa (KTM)',
        showCv: true,
        panduan: [
            'Siapkan <strong>surat izin penelitian</strong> resmi yang dikeluarkan oleh pihak kampus.',
            'Lampirkan <strong>Proposal atau Sinopsis Penelitian</strong> pada kolom yang disediakan.',
            'Pastikan semua file dapat diakses dengan baik dan tidak terproteksi sandi <em>(password-protected)</em>.'
        ]
    },
    '2': {
        keahlian: 'Tujuan Observasi / Nama Mata Kuliah',
        phK: 'Sebutkan nama mata kuliah dan tujuan tugas observasimu...',
        magang: 'Daftar Kebutuhan Data',
        phM: 'Sebutkan dengan jelas daftar data yang ingin kamu minta dari Dinas Kominfo...',
        surat: 'Surat Pengantar Kebutuhan Data Kampus',
        cv: null,
        ktm: 'Kartu Tanda Mahasiswa (KTM)',
        showCv: false,
        panduan: [
            'Siapkan <strong>surat pengantar observasi atau pengambilan data</strong> resmi dari pihak kampus.',
            'Pastikan semua file dapat diakses dengan baik dan tidak terproteksi sandi <em>(password-protected)</em>.'
        ]
    },
    '3': {
        keahlian: 'Keahlian Utama',
        phK: 'Sebutkan keahlian atau kompetensi teknis yang Anda kuasai (contoh: Pemrograman Web, Desain Grafis, Administrasi)...',
        magang: 'Apa yang ingin Anda kerjakan?',
        phM: 'Ceritakan rencana kegiatan, fokus bidang, atau posisi yang kamu harapkan selama magang...',
        surat: 'Surat Pengantar Resmi',
        cv: 'Curriculum Vitae (CV) Terbaru',
        ktm: 'Kartu Tanda Mahasiswa (KTM)',
        showCv: true,
        panduan: [
            'Siapkan <strong>surat pengantar magang</strong> resmi dari pihak kampus.',
            'Lampirkan <strong>Curriculum Vitae (CV)</strong> terbaru. Silakan gabungkan dengan portofolio karyamu jika ada.',
            'Pastikan semua file dapat diakses dengan baik dan tidak terproteksi sandi <em>(password-protected)</em>.'
        ]
    },
    '5': {
        keahlian: 'Keahlian Utama',
        phK: 'Sebutkan keahlian atau kompetensi teknis yang Anda kuasai (contoh: Jaringan, Desain Grafis, Administrasi)...',
        magang: 'Apa yang ingin Anda kerjakan?',
        phM: 'Ceritakan rencana kegiatan, fokus bidang, atau posisi yang kamu harapkan selama PKL...',
        surat: 'Surat Pengantar Resmi',
        cv: 'Curriculum Vitae (CV) Terbaru',
        ktm: 'Kartu Pelajar',
        showCv: true,
        panduan: [
            'Siapkan <strong>surat pengantar PKL</strong> resmi dari pihak sekolah.',
            'Lampirkan <strong>Curriculum Vitae (CV)</strong> terbaru. Silakan gabungkan dengan portofolio karyamu jika ada.',
            'Pastikan semua file dapat diakses dengan baik dan tidak terproteksi sandi <em>(password-protected)</em>.'
        ]
    },
    '4': {
        keahlian: 'Nama dan Profil Singkat Sistem',
        phK: 'Sebutkan nama aplikasimu dan jelaskan fungsinya secara singkat...',
        magang: 'Skenario Pengujian / Target Pengguna',
        phM: 'Siapa target penggunanya dan bagaimana skenario pengujiannya nanti?',
        surat: 'Surat Pengantar Uji Coba Produk Kampus',
        cv: 'Dokumen Profil / Panduan Singkat Produk',
        ktm: 'Kartu Tanda Mahasiswa (KTM)',
        showCv: true,
        panduan: [
            'Siapkan <strong>surat pengantar uji coba produk</strong> resmi dari pihak kampus.',
            'Lampirkan <strong>Dokumen Profil atau Panduan Singkat</strong> dari produk yang ingin diuji.',
            'Pastikan semua file dapat diakses dengan baik dan tidak terproteksi sandi <em>(password-protected)</em>.'
        ]
    }
};

/* ============ Character Counter ============ */
function countChars(el, sid) {
    document.getElementById(sid).textContent = el.value.length;
}
['deskripsi_keahlian', 'deskripsi'].forEach(function(id) {
    var el = document.getElementById(id);
    if (el && el.value) el.dispatchEvent(new Event('input'));
});

/* ============ Jenis Config ============ */
function applyJenisCfg(val) {
    var cfg = JENIS_CFG[val];
    
    // Default fallback jika tidak ada yang dipilih (opsi default)
    if (!cfg) {
        cfg = {
            keahlian: 'Keahlian Utama',
            phK: 'Sebutkan keahlian atau kompetensi teknis yang Anda kuasai...',
            magang: 'Apa yang ingin Anda kerjakan?',
            phM: 'Jelaskan maksud, tujuan, atau rencana kegiatan yang ingin Anda ajukan...',
            surat: 'Surat Pengantar Resmi',
            cv: '',
            showCv: false
        };
    }

    var lblKeahlian = document.getElementById('lbl-keahlian');
    if(lblKeahlian) lblKeahlian.innerHTML = cfg.keahlian + ' <span class="text-danger">*</span>';
    
    var rvLblKeahlian = document.getElementById('rv-keahlian-label');
    if(rvLblKeahlian) rvLblKeahlian.innerHTML = cfg.keahlian;
    
    var txtKeahlian = document.getElementById('deskripsi_keahlian');
    if(txtKeahlian) txtKeahlian.placeholder = cfg.phK;
    
    var lblMagang = document.getElementById('lbl-magang');
    if(lblMagang) lblMagang.innerHTML = cfg.magang + ' <span class="text-danger">*</span>';
    
    var rvLblMagang = document.getElementById('rv-magang-label');
    if(rvLblMagang) rvLblMagang.innerHTML = cfg.magang;
    
    var txtMagang = document.getElementById('deskripsi');
    if(txtMagang) txtMagang.placeholder = cfg.phM;

    // Update Identitas Pribadi Review labels dynamically
    var isSiswa = (val === '5');
    var lblNim = document.getElementById('lbl-rv-nim');
    if (lblNim) lblNim.textContent = isSiswa ? 'NISN' : 'NIM';
    var lblSemester = document.getElementById('lbl-rv-semester');
    if (lblSemester) lblSemester.textContent = isSiswa ? 'Kelas' : 'Semester';
    
    var lblSurat = document.getElementById('lbl-surat');
    if(lblSurat) lblSurat.innerHTML = cfg.surat + ' <span class="text-danger">*</span>';

    var lblKtm = document.getElementById('lbl-ktm');
    if(lblKtm) lblKtm.innerHTML = (cfg.ktm || 'Kartu Identitas') + ' <span class="text-danger">*</span>';

    var wCv = document.getElementById('wrapper-cv');
    var iCv = document.getElementById('input-cv');
    var lblCv = document.getElementById('lbl-cv');
    
    if (wCv && iCv) {
        if (cfg.showCv) {
            wCv.style.display = 'block';
            iCv.required = true;
            if (lblCv) lblCv.innerHTML = cfg.cv + ' <span class="text-danger">*</span>';
        } else {
            wCv.style.display = 'none';
            iCv.required = false;
            iCv.value = '';
            // Reset zone UI if function exists
            if (typeof resetZone === 'function') resetZone('zone-cv', 'ph-cv', 'pv-cv');
        }
    }

    var infoBoxList = document.getElementById('info-panduan-list');
    if (infoBoxList && cfg.panduan) {
        infoBoxList.innerHTML = '';
        cfg.panduan.forEach(function(item) {
            var li = document.createElement('li');
            li.innerHTML = item;
            infoBoxList.appendChild(li);
        });
    }

    // Disable/Enable tanggal berdasarkan jenis permohonan
    var isTglDisabled = !val;
    var tM = document.getElementById('tgl_mulai');
    var tS = document.getElementById('tgl_selesai');
    
    function toggleDateInput(el, forceDisable, placeholderTxt) {
        if (!el) return;
        el.disabled = forceDisable;
        if (el._flatpickr && el._flatpickr.altInput) {
            el._flatpickr.altInput.disabled = forceDisable;
            if (forceDisable) {
                el._flatpickr.altInput.style.backgroundColor = '#e9ecef';
                el._flatpickr.altInput.placeholder = placeholderTxt || 'Pilih jenis permohonan dulu...';
            } else {
                el._flatpickr.altInput.style.backgroundColor = '#fff';
                el._flatpickr.altInput.placeholder = '';
            }
        } else {
            if (forceDisable) {
                el.style.backgroundColor = '#e9ecef';
            } else {
                el.style.backgroundColor = '#fff';
            }
        }
    }

    // tgl_mulai hanya butuh jenis permohonan dipilih
    toggleDateInput(tM, isTglDisabled, 'Pilih jenis permohonan dulu...');
    
    // tgl_selesai butuh tgl_mulai dipilih juga
    var hasTglMulai = tM && tM.value.trim() !== '';
    var disableSelesai = isTglDisabled || !hasTglMulai;
    var phSelesai = isTglDisabled ? 'Pilih jenis permohonan dulu...' : 'Pilih tanggal mulai dulu...';
    toggleDateInput(tS, disableSelesai, phSelesai);

    // Event listener untuk update tgl_selesai saat tgl_mulai berubah
    if (tM && !tM.dataset.listenerAdded) {
        tM.dataset.listenerAdded = 'true';
        tM.addEventListener('change', function() {
            var j = document.querySelector('input[name="id_jenis_permohonan"]:checked');
            var dis = !j || !j.value;
            var hasVal = this.value.trim() !== '';
            toggleDateInput(tS, dis || !hasVal, dis ? 'Pilih jenis permohonan dulu...' : 'Pilih tanggal mulai dulu...');
        });
    }
}

// Fungsi untuk mengosongkan isian saat jenis permohonan diganti
function clearInputsOnChange() {
    var tM = document.getElementById('tgl_mulai');
    var tS = document.getElementById('tgl_selesai');
    var k = document.getElementById('deskripsi_keahlian');
    var mg = document.getElementById('deskripsi');
    var errTgl = document.getElementById('err-tgl-mulai-js');
    
    if (tM) { 
        tM.value = ''; 
        tM.classList.remove('is-invalid'); 
        if (tM._flatpickr) {
            tM._flatpickr.clear();
            tM._flatpickr.redraw();
        }
    }
    if (tS) { 
        tS.value = ''; 
        tS.classList.remove('is-invalid'); 
        if (tS._flatpickr) {
            tS._flatpickr.clear();
            tS._flatpickr.redraw();
        }
    }
    if (k) { k.value = ''; countChars(k, 'cc-keahlian'); }
    if (mg) { mg.value = ''; countChars(mg, 'cc-magang'); }
    if (errTgl) { errTgl.classList.add('d-none'); errTgl.classList.remove('d-block'); }
    
    if (typeof saveToLocal === 'function') saveToLocal(); // Timpa localstorage langsung
}

document.querySelectorAll('input[name="id_jenis_permohonan"]').forEach(function(r) {
    r.addEventListener('change', function(e) {
        applyJenisCfg(this.value);
        document.getElementById('err-jenis').classList.add('d-none');
        // Hanya kosongkan form jika perubahan dilakukan manual oleh user (bukan script)
        if (e.isTrusted) {
            clearInputsOnChange();
        }
    });
});

var selJenis = document.getElementById('sel-jenis');
if (selJenis) {
    selJenis.addEventListener('change', function(e) {
        // onchange inline di HTML sudah menangani checked dan applyJenisCfg
        if (this.value && e.isTrusted) {
            clearInputsOnChange();
        }
    });
}

var oldJenis = document.querySelector('input[name="id_jenis_permohonan"]:checked');
if (oldJenis) {
    applyJenisCfg(oldJenis.value);
} else {
    applyJenisCfg('');
}
/* ============ Upload Zone ============ */
// Upload elements are now standard inputs, so custom drag-and-drop logic is no longer needed.

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
    var mg = document.getElementById('deskripsi').value.trim();
    if (!tM) { sAlert('Tanggal mulai wajib diisi.'); return false; }
    if (!tS) { sAlert('Tanggal selesai wajib diisi.'); return false; }
    
    var diffTime = new Date(tS) - new Date(tM);
    var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    
    var jVal = j.value;
    var dateCfg = (typeof JENIS_DATE_CFG !== 'undefined' && JENIS_DATE_CFG[jVal]) ? JENIS_DATE_CFG[jVal] : { durasiMinimal: 0 };
    
    if (dateCfg.durasiMinimal > 0 && diffDays < dateCfg.durasiMinimal) {
        document.getElementById('tgl_mulai').classList.add('is-invalid');
        var errDiv = document.getElementById('err-tgl-mulai-js');
        if(errDiv){
            errDiv.classList.remove('d-none');
            errDiv.classList.add('d-block');
            errDiv.innerHTML = '<i class="bi bi-exclamation-circle me-1"></i> Durasi kegiatan minimal adalah ' + dateCfg.durasiMinimal + ' hari.';
        }
        document.getElementById('tgl_mulai').focus();
        sAlert('Durasi kegiatan minimal adalah ' + dateCfg.durasiMinimal + ' hari.');
        return false; 
    } else if (diffDays < 0) {
        document.getElementById('tgl_mulai').classList.add('is-invalid');
        sAlert('Tanggal selesai tidak boleh mendahului tanggal mulai.');
        return false;
    }
    var jVal = j.value;
    var cfg = JENIS_CFG[jVal];
    var labelKeahlian = cfg ? cfg.keahlian : 'Keahlian/Topik';
    var labelMagang = cfg ? cfg.magang : 'Rencana/Fokus';

    if (k.length === 0) { sAlert('Kolom "' + labelKeahlian + '" wajib diisi.'); return false; }
    if (k.length < 10) { sAlert('Kolom "' + labelKeahlian + '" minimal 10 karakter.'); return false; }
    
    if (mg.length === 0) { sAlert('Kolom "' + labelMagang + '" wajib diisi.'); return false; }
    if (mg.length < 20) { sAlert('Kolom "' + labelMagang + '" minimal 20 karakter.'); return false; }
    
    return true;
}

function vStep2() {
    // Helper: check if a file text span shows an existing file name (not default text)
    function hasExistingFile(textId) {
        var el = document.getElementById(textId);
        if (!el) return false;
        var txt = el.textContent.trim();
        return txt !== '' && txt !== 'No file chosen' && txt !== 'Belum ada file';
    }

    var sr = document.getElementById('input-surat');
    var hasNewSurat = sr && sr.files && sr.files[0];
    var hasDraftSurat = hasExistingFile('text-surat');

    if (!hasNewSurat && !hasDraftSurat) {
        sAlert('Surat pengantar wajib diunggah.'); return false;
    }
    if (hasNewSurat) {
        if (sr.files[0].size > 2 * 1024 * 1024) { sAlert('Ukuran surat pengantar maksimal 2 MB.'); return false; }
        if (!sr.files[0].name.toLowerCase().endsWith('.pdf')) { sAlert('Surat pengantar harus berformat PDF.'); return false; }
    }

    var wCv = document.getElementById('wrapper-cv');
    if (wCv && wCv.style.display !== 'none') {
        var cv = document.getElementById('input-cv');
        var hasNewCv = cv && cv.files && cv.files[0];
        var hasDraftCv = hasExistingFile('text-cv');

        if (!hasNewCv && !hasDraftCv) {
            sAlert('Berkas CV wajib diunggah.'); return false;
        }
        if (hasNewCv) {
            if (cv.files[0].size > 2 * 1024 * 1024) { sAlert('Ukuran CV maksimal 2 MB.'); return false; }
            if (!cv.files[0].name.toLowerCase().endsWith('.pdf')) { sAlert('CV harus berformat PDF.'); return false; }
        }
    }
    
    var kt = document.getElementById('input-ktm');
    if (kt) {
        var hasNewKtm = kt.files && kt.files[0];
        var hasDraftKtm = hasExistingFile('text-ktm');

        if (!hasNewKtm && !hasDraftKtm) {
            sAlert('Kartu Tanda Mahasiswa (KTM) wajib diunggah.'); return false;
        }
        if (hasNewKtm) {
            if (kt.files[0].size > 2 * 1024 * 1024) { sAlert('Ukuran KTM maksimal 2 MB.'); return false; }
            var n = kt.files[0].name.toLowerCase();
            if (!n.endsWith('.pdf') && !n.endsWith('.jpg') && !n.endsWith('.jpeg') && !n.endsWith('.png')) {
                sAlert('KTM harus berupa gambar (JPG/PNG) atau PDF.'); return false;
            }
        }
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
    var cfg = jVal ? JENIS_CFG[jVal] : null;
    var isSiswa = (jVal === '5');

    var lblNim = document.getElementById('lbl-rv-nim');
    if (lblNim) lblNim.textContent = isSiswa ? 'NISN' : 'NIM';
    var lblSemester = document.getElementById('lbl-rv-semester');
    if (lblSemester) lblSemester.textContent = isSiswa ? 'Kelas' : 'Semester';

    document.getElementById('rv-jenis').textContent = j ? JENIS_LABELS[jVal] : '—';
    document.getElementById('rv-tgl-mulai').textContent = fmtDate(document.getElementById('tgl_mulai').value);
    document.getElementById('rv-tgl-selesai').textContent = fmtDate(document.getElementById('tgl_selesai').value);
    document.getElementById('rv-keahlian-label').textContent = cfg ? cfg.keahlian : 'Keahlian Utama';
    document.getElementById('rv-keahlian').textContent = document.getElementById('deskripsi_keahlian').value || '—';
    document.getElementById('rv-magang-label').textContent = cfg ? cfg.magang : 'Apa yang ingin dikerjakan';
    document.getElementById('rv-magang').textContent = document.getElementById('deskripsi').value || '—';

    var tb = document.getElementById('rv-doc-tbody');
    tb.innerHTML = '';
    var no = 1;

    // Helper: check if a file text span shows an existing file name
    function _hasFile(textId) {
        var el = document.getElementById(textId);
        if (!el) return false;
        var txt = el.textContent.trim();
        return txt !== '' && txt !== 'No file chosen' && txt !== 'Belum ada file';
    }

    // Surat Pengantar
    var sr = document.getElementById('input-surat');
    var ls = document.getElementById('lbl-surat').textContent.replace('*', '').trim();
    if (sr.files && sr.files[0]) {
        var sfUrl = URL.createObjectURL(sr.files[0]);
        tb.innerHTML += '<tr><td class="text-muted" style="font-size:0.82rem;">' + (no++) + '</td><td class="fw-semibold">' + ls + '</td><td class="text-end"><a href="' + sfUrl + '" target="_blank" class="text-primary text-decoration-none" title="Klik untuk melihat dokumen (Preview)"><i class="bi bi-file-earmark-pdf fs-4"></i></a></td></tr>';
    } else if (_hasFile('text-surat')) {
        tb.innerHTML += '<tr><td class="text-muted" style="font-size:0.82rem;">' + (no++) + '</td><td class="fw-semibold">' + ls + '</td><td class="text-end"><i class="bi bi-file-earmark-pdf fs-4 text-primary" title="Dokumen tersimpan"></i></td></tr>';
    }

    // CV / Proposal
    var wCv = document.getElementById('wrapper-cv');
    if (wCv && wCv.style.display !== 'none') {
        var cv = document.getElementById('input-cv');
        var lc = document.getElementById('lbl-cv') ? document.getElementById('lbl-cv').textContent.replace('*', '').trim() : 'CV';
        if (cv.files && cv.files[0]) {
            var cfUrl = URL.createObjectURL(cv.files[0]);
            tb.innerHTML += '<tr><td class="text-muted" style="font-size:0.82rem;">' + (no++) + '</td><td class="fw-semibold">' + lc + '</td><td class="text-end"><a href="' + cfUrl + '" target="_blank" class="text-primary text-decoration-none" title="Klik untuk melihat dokumen (Preview)"><i class="bi bi-file-earmark-pdf fs-4"></i></a></td></tr>';
        } else if (_hasFile('text-cv')) {
            tb.innerHTML += '<tr><td class="text-muted" style="font-size:0.82rem;">' + (no++) + '</td><td class="fw-semibold">' + lc + '</td><td class="text-end"><i class="bi bi-file-earmark-pdf fs-4 text-primary" title="Dokumen tersimpan"></i></td></tr>';
        }
    }

    // KTM / Kartu Pelajar
    var kt = document.getElementById('input-ktm');
    if (kt) {
        var lk = cfg && cfg.ktm ? cfg.ktm : 'Kartu Identitas';
        if (kt.files && kt.files[0]) {
            var ktfUrl = URL.createObjectURL(kt.files[0]);
            tb.innerHTML += '<tr><td class="text-muted" style="font-size:0.82rem;">' + (no++) + '</td><td class="fw-semibold">' + lk + '</td><td class="text-end"><a href="' + ktfUrl + '" target="_blank" class="text-primary text-decoration-none" title="Klik untuk melihat dokumen (Preview)"><i class="bi bi-file-earmark-check fs-4"></i></a></td></tr>';
        } else if (_hasFile('text-ktm')) {
            tb.innerHTML += '<tr><td class="text-muted" style="font-size:0.82rem;">' + (no++) + '</td><td class="fw-semibold">' + lk + '</td><td class="text-end"><i class="bi bi-file-earmark-check fs-4 text-primary" title="Dokumen tersimpan"></i></td></tr>';
        }
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
            text: 'Perubahan akan disimpan dan dapat dilanjutkan kapan saja.',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#0a1d37',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Simpan',
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
            text: 'Pastikan semua data dan dokumen yang Anda isi sudah sesuai.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0a1d37',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '</i>Kirim',
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
            
            // Upload zones are standard inputs, form.reset() clears them automatically.

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
var LS_FIELDS = ['id_jenis_permohonan', 'tgl_mulai', 'tgl_selesai', 'deskripsi_keahlian', 'deskripsi'];

function saveToLocal() {
    try {
        var data = {};
        // Ambil value jenis permohonan dari radio yang tercentang
        var jRadio = document.querySelector('input[name="id_jenis_permohonan"]:checked');
        data['id_jenis_permohonan'] = jRadio ? jRadio.value : '';
        // Ambil value field lainnya
        ['tgl_mulai', 'tgl_selesai', 'deskripsi_keahlian', 'deskripsi'].forEach(function(id) {
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
        }

        // Isi field teks lainnya
        ['tgl_mulai', 'tgl_selesai', 'deskripsi_keahlian', 'deskripsi'].forEach(function(id) {
            var el = document.getElementById(id);
            if (el && data[id] && data[id].trim() !== '') { 
                el.value = data[id]; 
                hasData = true; // Hanya anggap ada data jika text/date terisi
            }
        });

        // Update character counters
        ['deskripsi_keahlian', 'deskripsi'].forEach(function(id) {
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
