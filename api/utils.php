<?php

class BrowserUtils {
    public static function calculateElapsedTimeFull($timestamp) {

        $now = time();

        $difference = $now - $timestamp;

        $time_intervals = [
            31536000 => 'year',
            2592000 => 'month',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        ];

        $timeElapsed = '';

        $timeElapsed = implode(' ', array_map(function ($interval, $label) use (&$difference) {
            if ($difference >= $interval) {
                $count = floor($difference / $interval);
                $difference %= $interval;
                return $count . ' ' . $label . ($count > 1 ? 's' : '');
            }
        }, array_keys($time_intervals), $time_intervals));

        return $timeElapsed;
    }

    public static function calculateElapsedTime($timestamp) {

        $now = time();
        $difference = $now - $timestamp;
        $time_intervals = [
            31536000 => 'year',
            2592000 => 'month',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        ];
        $timeElapsed = '';
        foreach ($time_intervals as $interval => $label) {
            if ($difference >= $interval) {
                $count = floor($difference / $interval);
                $timeElapsed = $count . ' ' . $label . ($count > 1 ? 's' : '');
                break; 
            }
        }

        return $timeElapsed;
    }

    public static function rgbToHex($rgb) {
        $components = array_map('intval', explode(',', $rgb));
        return (count($components) === 3 && min($components) >= 0 && max($components) <= 255) 
            ? sprintf("#%02X%02X%02X", $components[0], $components[1], $components[2]) 
            : '#FFFFFF';
    }

}


?>