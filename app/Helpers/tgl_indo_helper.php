<?php

if (!function_exists('tgl_indo')) {
    function tgl_indo($date)
    {
        if (empty($date) || $date == '0000-00-00' || $date == '0000-00-00 00:00:00') {
            return '-';
        }

        $BulanIndo = [
            1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        $time = strtotime($date);
        $tgl = date('d', $time);
        $bulan = $BulanIndo[(int)date('m', $time)];
        $tahun = date('Y', $time);

        return $tgl . ' ' . $bulan . ' ' . $tahun;
    }
}
