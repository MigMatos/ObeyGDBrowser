<?php
    
    $gdps_settings_path = "gdps_settings.json";
    global $json_content_settings;
    $json_content_settings = @file_get_contents("./$gdps_settings_path") ?:  
    (@file_get_contents("../$gdps_settings_path") ?: 
    (@file_get_contents("../../$gdps_settings_path") ?: 
    @file_get_contents("./browser/$gdps_settings_path")));

    global $gdps_settings;
    $gdps_settings = json_decode($json_content_settings, true);

    $failed_conn = false;

    $includePath = isset($gdps_settings["path_connection"]) ? $gdps_settings["path_connection"] : "../../incl/lib/connection.php";
    $includeFolder = isset($gdps_settings["path_lib_folder"]) ? $gdps_settings["path_lib_folder"] : "../../incl/lib/";

    global $gdpsVersion;
    $gdpsVersion = isset($gdps_settings["gdps_version"]) ? intval($gdps_settings["gdps_version"]) : 30;

    if (file_exists($includePath) && is_readable($includePath)) {
        require_once($includePath);
    } else {
        if (file_exists("../" . $includePath) && is_readable("../" . $includePath)) {
            require_once("../" . $includePath);
            
        } elseif (file_exists("../../" . $includePath) && is_readable("../../" . $includePath)) {
            require_once("../../" . $includePath);
        } else {
            
            if (file_exists("./incl/lib/connection.php") && is_readable("./incl/lib/connection.php")){
                require_once("./incl/lib/connection.php");
            } else {
                $failed_conn = true;
                echo '<script>alert("Failed including connection, please configure in browser/gdpsettings");</script>';
            }
            
        }
    }

    global $serverType;
    $serverType = isset($gdps_settings["server_software"]) ? strval($gdps_settings["server_software"]) : "automatic";
    if (isset($_SERVER['SERVER_SOFTWARE']) && $serverType == "automatic") {
        $server_software = $_SERVER['SERVER_SOFTWARE'];
        if (strpos($server_software, 'Apache') !== false) {
            $serverType = "apache";
        } else {
            $serverType = "legacy";
        }
    }  else if (!isset($_SERVER['SERVER_SOFTWARE']) && $serverType == "automatic") {$serverType = "legacy";}

    $sessionLifetime = 15 * 24 * 60 * 60;
    session_set_cookie_params($sessionLifetime);

    session_start();

    
    $logged = false;
    $userName = isset($_SESSION['userName']) ? $_SESSION['userName'] : "None";
    $userID = isset($_SESSION['userID']) ? $_SESSION['userID'] : 0;
    $accountID = isset($_SESSION['accountID']) ? $_SESSION['accountID'] : 0;
    $isAdmin = isset($_SESSION['isAdmin']) ? $_SESSION['isAdmin'] : 0;
    if (isset($_SESSION['userName']) && isset($_SESSION['accountID']) && isset($_SESSION['userID'])) { $logged = true; }
    if($logged == true) {
        session_regenerate_id(true);
        $_SESSION['LAST_ACTIVITY'] = time();
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $sessionLifetime)) {
            session_unset();
            session_destroy();
        }
    }




    // Permissions
    $userPermissions = [];
    if($isAdmin == "1" || $isAdmin == 1) $userPermissions[] = "admin";
    function updateUserPerms($newPerms){
        global $userPermissions;
        $userPermissions = array_merge($userPermissions, $newPerms);
    }

    $userPermissionsJSON = json_encode($userPermissions);

?>