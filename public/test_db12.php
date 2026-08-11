<?php
$conn = new mysqli('localhost', 'root', '', 'db_elayanan_akademik_kominfo_final');

// Check if PKL has CV (id_file = 3) mapped
$res = $conn->query("SELECT * FROM m_file_permohonan WHERE id_jenis_permohonan = 5 AND id_file = 3");
if ($res->num_rows == 0) {
    // Determine the max urutan
    $maxRes = $conn->query("SELECT MAX(urutan) as max_urutan FROM m_file_permohonan WHERE id_jenis_permohonan = 5");
    $max = $maxRes->fetch_assoc()['max_urutan'] ?? 2;
    $urutan = $max + 1;
    $conn->query("INSERT INTO m_file_permohonan (id_jenis_permohonan, id_file, urutan, wajib) VALUES (5, 3, $urutan, 'YA')");
    echo "Added CV to PKL required files.\n";
} else {
    echo "CV already exists for PKL.\n";
}
