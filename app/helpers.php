<?php

if (!function_exists('showPercent')) {
    function showPercent($numb1, $numb2)
    {
        if ($numb2 > 0) {
            $percent = ($numb1 / $numb2) * 100;
            return round($percent) . ' %';
        } else {
            return 0;
        }
    }
}

if (!function_exists('formatRupiah')) {
    function formatRupiah($number)
    {
        if (!empty($number)) {
            $result = 'Rp. ' . number_format($number, 0, ',', '.');
        } else if ($number == null) {
            $result = 0;
        } else {
            $result = '-';
        }

        return $result;
    }
}
