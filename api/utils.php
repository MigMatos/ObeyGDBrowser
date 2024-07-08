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

}


?>