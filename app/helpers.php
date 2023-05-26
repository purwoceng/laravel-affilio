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
            $result = 'Rp. ' . number_format((float)$number, 0, ',', '.');
        } else if ($number == null) {
            $result = 0;
        } else {
            $result = '-';
        }

        return $result;
    }
}

if (!function_exists('timeLine')) {
    function timeLine($dateTime = '1970-01-01 00:00:01')
    {
        $timestamp = strtotime($dateTime);
        $current_timestamp = time();
        $time_diff_labels = [
            'ago' => __('product::messages.ago'),
            'togo' => __('product::messages.togo'),
        ];
        $time_units = [
            'month' => 2592000,
            'week' => 604800,
            'day' => 86400,
            'hour' => 3600,
            'minute' => 60,
            'second' => 1,
        ];
        $time_labels = [
            'second' => __('product::messages.second'),
            'minute' => __('product::messages.minute'),
            'hour' => __('product::messages.hour'),
            'day' => __('product::messages.day'),
            'week' => __('product::messages.week'),
            'month' => __('product::messages.month'),
        ];

        $time_diff = $current_timestamp - $timestamp;
        $label = $time_diff < 0 ? $time_diff_labels['togo'] : $time_diff_labels['ago'];
        $time_diff = abs($time_diff);
        $result = [];

        foreach ($time_units as $key => $unit) {
            if ($time_diff < $unit) continue;

            $number_unit = floor($time_diff / $unit);
            $result = [
                'elapsed' => "{$number_unit} {$time_labels[$key]} {$label}",
                'timestamp' => $time_diff,
            ];
            break;
        }

        return $result;
    }
}
