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

    public static function isValidText($text) {
        return (strlen($text) > 0 && strlen($text) <= 255 && !preg_match('/[^a-zA-Z0-9\s]/', $text));
    }

    public static function convertBytesToMB($bytes) {
        $megabytes = $bytes / (1024 * 1024);
        return floatval(number_format($megabytes, 2)); 
    }
    
    public static function convertSongURL($url) {
        if (strpos($url, 'dropbox') !== false) {
            return str_replace('www.dropbox.com', 'dl.dropboxusercontent.com', $url);
        }
        return $url;
    }
    
    public static function getFileSizeAndMime($url) {
        $size = 0;
        $mime = '';
    
        $headers = get_headers($url, 1);
        if (isset($headers['Content-Length'])) {
            $size = $headers['Content-Length'];
        }
        if (isset($headers['Content-Type'])) {
            $mime = $headers['Content-Type'];
        }
    
        if (empty($mime) || empty($size)) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, TRUE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
            curl_exec($ch);
            $size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
            $mime = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
            curl_close($ch);
        }
    
        if (empty($mime) && preg_match('/\.(mp3)$/i', $url)) {
            $mime = 'audio/mpeg';
        }
    
        return ['size' => $size, 'mime' => $mime];
    }

    public static function genToken($length = 32, $pattern = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()-_=+[]{}|;:,.<>?') {
        $token = '';
        $maxIndex = strlen($pattern) - 1;
        if ($length < 1 || $maxIndex < 0) {throw new InvalidArgumentException("Invalid Token: The length must be greater than 0 and token pattern cannot be empty.");}
        for ($i = 0; $i < $length; $i++) {$token .= $pattern[random_int(0, $maxIndex)];}
        $token = str_shuffle($token);
        return $token;
    }

    public static function getRewards()
    {
        return [
            ["id" => 0, "name" => "Unknown", "type" => "item", "ignore" => "1"],
            ["id" => 7, "name" => "Orb", "type" => "item"],
            ["id" => 8, "name" => "Diamond", "type" => "item"],
            ["id" => 6, "name" => "Demon Key", "type" => "item"],
            ["id" => 15, "name" => "Gold Key", "type" => "item"],
            ["id" => 1002, "name" => "Color 1", "type" => "color"],
            ["id" => 1003, "name" => "Color 2", "type" => "color"],
            ["id" => 1001, "name" => "Cube", "type" => "icon-cube"],
            ["id" => 1004, "name" => "Ship", "type" => "icon-ship"],
            ["id" => 1005, "name" => "Ball", "type" => "icon-ball"],
            ["id" => 1006, "name" => "UFO", "type" => "icon-ufo"],
            ["id" => 1007, "name" => "Wave", "type" => "icon-wave"],
            ["id" => 1008, "name" => "Robot", "type" => "icon-robot"],
            ["id" => 1009, "name" => "Spider", "type" => "icon-spider"],
            ["id" => 1013, "name" => "Swing", "type" => "icon-swing"],
            ["id" => 1014, "name" => "Jetpack", "type" => "icon-jetpack"],
            ["id" => 1011, "name" => "Death Effect", "type" => "deatheffect"],
            ["id" => 1012, "name" => "Custom Item", "type" => "item-custom"],
            ["id" => 1010, "name" => "Trail", "type" => "trail"],
            ["id" => 1015, "name" => "Ship Trail", "type" => "trail-ship"],
            ["id" => 1, "name" => "Fire Shard", "type" => "item"],
            ["id" => 2, "name" => "Ice Shard", "type" => "item"],
            ["id" => 3, "name" => "Poison Shard", "type" => "item"],
            ["id" => 4, "name" => "Shadow Shard", "type" => "item"],
            ["id" => 5, "name" => "Lava Shard", "type" => "item"],
            ["id" => 10, "name" => "Earth Shard", "type" => "item"],
            ["id" => 11, "name" => "Blood Shard", "type" => "item"],
            ["id" => 12, "name" => "Metal Shard", "type" => "item"],
            ["id" => 13, "name" => "Light Shard", "type" => "item"],
            ["id" => 14, "name" => "Soul Shard", "type" => "item"],
        ];
    }

    public static function sanitizeText($text, $limit = 50000, $force = false) {
        $text = mb_substr($text, 0, $limit, 'UTF-8');
        if ($force) {return preg_replace('/[^\p{L}\p{N}\p{Z}]/u', '', $text);}
        $extPattern = '\x{1F600}-\x{1F64F}'
                      . '\x{1F300}-\x{1F5FF}'
                      . '\x{1F680}-\x{1F6FF}'
                      . '\x{1F1E0}-\x{1F1FF}'
                      . '\x{2600}-\x{26FF}'
                      . '\x{2700}-\x{27BF}'
                      . '\x{1F900}-\x{1F9FF}'
                      . '\x{1FA70}-\x{1FAFF}'
                      . '\x{200D}'
                      . '\x{FE0F}';
        $allowedPattern = '/[^\p{L}\p{N}\p{Z}\{\}\[\]\(\)\$\|\@\%\?\!\/\\\\:;,&\*\+\-\=\<\>\~\.,\'\"\`\^\_\¡\¿\x{00A1}-\x{00FF}\x{2013}-\x{201D}'.$extPattern.']/u';
        return preg_replace($allowedPattern, '', $text);
    }

    // https://github.com/ElfSundae/urlsafe-base64/blob/master/src/helpers.php
    public static function url_base64_decode($data) {
        return base64_decode(strtr($data, '-_', '+/'), false);
    }
    public static function url_base64_encode($data) { 
        return strtr(base64_encode($data), ['+' => '-', '/' => '_']);
    }
}


?>