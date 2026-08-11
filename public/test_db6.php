<?php
$conn = new mysqli('localhost', 'root', '', 'db_elayanan_akademik_kominfo_final');
$conn->query("UPDATE m_file SET nama_file = 'Surat Pengantar Resmi Kampus / Sekolah' WHERE nama_file = 'Surat Pengantar Resmi Kampus'");
$conn->query("UPDATE m_file SET nama_file = 'Kartu Tanda Mahasiswa (KTM) / Kartu Pelajar' WHERE nama_file = 'Kartu Tanda Mahasiswa (KTM)'");
echo "Update done!";
