<?php
$conn = new mysqli('localhost', 'root', '', 'db_elayanan_akademik_kominfo_final');

// 1. Rename Surat Pengantar
$conn->query("UPDATE m_file SET nama_file = 'Surat Pengantar' WHERE nama_file LIKE '%Surat Pengantar%'");

// 2. Revert KTM
$conn->query("UPDATE m_file SET nama_file = 'Kartu Tanda Mahasiswa (KTM)' WHERE id_file = 11");

// 3. Insert Kartu Pelajar if not exists
$res = $conn->query("SELECT id_file FROM m_file WHERE nama_file = 'Kartu Pelajar'");
if ($res->num_rows == 0) {
    $conn->query("INSERT INTO m_file (nama_file, wajib_upload, status) VALUES ('Kartu Pelajar', 'YA', 'AKTIF')");
    $id_kartu_pelajar = $conn->insert_id;
} else {
    $id_kartu_pelajar = $res->fetch_assoc()['id_file'];
}

// 4. Map files for PKL (id_jenis_permohonan = 5)
// Check if they already exist
$res_pkl = $conn->query("SELECT * FROM m_file_permohonan WHERE id_jenis_permohonan = 5");
if ($res_pkl->num_rows == 0) {
    // 1 is one of the Surat Pengantar ids. 
    // Let's just use id 1.
    $conn->query("INSERT INTO m_file_permohonan (id_jenis_permohonan, id_file, urutan, wajib) VALUES (5, 1, 1, 'YA')");
    $conn->query("INSERT INTO m_file_permohonan (id_jenis_permohonan, id_file, urutan, wajib) VALUES (5, $id_kartu_pelajar, 2, 'YA')");
    echo "Mapped files to PKL.\n";
} else {
    echo "PKL already has files mapped.\n";
    // If it has files, maybe it mapped to KTM? Let's check
    while ($row = $res_pkl->fetch_assoc()) {
        if ($row['id_file'] == 11) {
            $conn->query("UPDATE m_file_permohonan SET id_file = $id_kartu_pelajar WHERE id_file_permohonan = " . $row['id_file_permohonan']);
            echo "Replaced KTM with Kartu Pelajar for PKL.\n";
        }
    }
}

echo "Database successfully updated for user request!\n";
