<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('format_rupiah')) {
    function format_rupiah($number) {
        $result = "Rp. " . number_format($number, 0, '', '.');
	    
        return $result;
    }
}

if (!function_exists('discount_price')) {
    function discount_price($price, $discount) {
        $result = $price - ($price * $discount / 100);
        
        return $result;
    }
}

if (!function_exists('format_tanggal')) {
    function format_tanggal($date) {
        $bulan = [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember"
        ];

        $split_tanggal = explode('-', $date);

        $result = $split_tanggal[2] . ' ' . $bulan[(int)$split_tanggal[1] - 1] . ' ' . $split_tanggal[0];
        
        return $result;
    }
}