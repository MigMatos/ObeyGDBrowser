<?php
    function getRelativePath($to, $from) { return str_repeat("../", max(0, substr_count($to, '/') - substr_count($from, '/'))); }
    global $baseURL;
    $baseURL = getRelativePath(dirname($_SERVER['SCRIPT_NAME']), '/');



?>