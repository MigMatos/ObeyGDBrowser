<?php
    // function getRelativePath($to, $from) { return str_repeat("../", max(0, substr_count($to, '/') - substr_count($from, '/'))); }
    // global $baseURL;
    // $baseURL = getRelativePath(dirname($_SERVER['SCRIPT_NAME']), 'assets/');

    function getPath() {
        $url = $_SERVER['SCRIPT_NAME'];
        $base = 'browser/';
        
        if (strpos($url, $base) === false) {
            global $gdps_settings;
            $base = isset($gdps_settings["browser_path"]) ? $gdps_settings["browser_path"] : 'browser/';
            echo '<p style="display:none" id="browser_path">'.$base.'</p>';
        }
        
        $path = substr($url, strpos($url, $base) + strlen($base));
        $count = substr_count($path, '/');
        
        return $count === 0 ? './' : str_repeat('../', $count);
    }

    global $baseURL;

    

    $baseURL = getPath();

?>