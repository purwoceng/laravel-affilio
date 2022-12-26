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
