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

    public static function hexToRgb($hex) {
        $hex = ltrim($hex, '#');
        if (strlen($hex) == 6) {
            list($r, $g, $b) = sscanf($hex, "%02x%02x%02x");
        } elseif (strlen($hex) == 3) {
            list($r, $g, $b) = sscanf(str_repeat($hex, 2), "%02x%02x%02x");
        } else {
            return '255,255,255';
        }
        return "$r,$g,$b";
    }

    public static function validateRgb($rgb) {
        if (preg_match('/^\d{1,3},\d{1,3},\d{1,3}$/', $rgb)) {
            $parts = explode(',', $rgb);
            foreach ($parts as $part) {
                if ($part < 0 || $part > 255) {
                    return "255,255,255";
                }
            }
            return $rgb;
        } else {
            return "255,255,255";
        }
    }

    public static function getDifficultyLabel($difficulty, $auto, $demon) {
        if ($difficulty == 50) {
            if ($auto == 1) {
                return $demon == 1 ? 'Demon' : 'Auto';
            } else if ($demon == 1) {
                return 'Demon';
            } else {
                return 'Insane';
            }
        }
    
        switch ($difficulty) {
            case 0: return 'NA';
            case 10: return 'Easy';
            case 20: return 'Normal';
            case 30: return 'Hard';
            case 40: return 'Harder';
            default: return 'Unknown';
        }
    }

}


?>