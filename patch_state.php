<?php
$db = new PDO('mysql:host=localhost;dbname=db_elayanan_akademik_kominfo_final(1);charset=utf8mb4', 'root', '');
$stmt = $db->query("SELECT p.id_persetujuan_magang, p.tgl_mulai_disetujui, p.tgl_selesai_disetujui, m.tgl_mulai, m.tgl_selesai FROM t_persetujuan_magang p JOIN t_permohonan_magang m ON p.id_permohonan_magang = m.id_permohonan_magang WHERE p.status_persetujuan_mahasiswa = 'MENUNGGU'");
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if($row['tgl_mulai_disetujui'] == $row['tgl_mulai'] && $row['tgl_selesai_disetujui'] == $row['tgl_selesai']) {
        $db->exec("UPDATE t_persetujuan_magang SET status_persetujuan_mahasiswa = 'DISETUJUI' WHERE id_persetujuan_magang = " . $row['id_persetujuan_magang']);
        echo "Updated ID: " . $row['id_persetujuan_magang'] . "\n";
    }
}
echo "Done.\n";
