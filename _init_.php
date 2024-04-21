<?php
    
    $gdps_settings_path = "gdps_settings.json";
    global $json_content_settings;
    $json_content_settings = @file_get_contents("./config/$gdps_settings_path") ?: (@file_get_contents("../config/$gdps_settings_path") ?: file_get_contents("../../config/$gdps_settings_path"));
    global $gdps_settings;
    $gdps_settings = json_decode($json_content_settings, true);

    $includePath = isset($gdps_settings["path_connection"]) ? $gdps_settings["path_connection"] : "../../incl/lib/connection.php";
    global $gdpsVersion;
    $gdpsVersion = isset($gdps_settings["gdps_version"]) ? intval($gdps_settings["gdps_version"]) : 30;

    if (file_exists($includePath) && is_readable($includePath)) {
        require_once($includePath);
    } else {
        $includePath = "../" . $includePath;
        if (file_exists($includePath) && is_readable($includePath)) {require_once($includePath);} else {require_once("../".$includePath);}
    }
    


    session_start();
    $logged = false;
    $userName = isset($_SESSION['userName']) ? $_SESSION['userName'] : "None";
    $accountID = isset($_SESSION['accountID']) ? $_SESSION['accountID'] : 0;
    $isAdmin = isset($_SESSION['isAdmin']) ? $_SESSION['isAdmin'] : 0;
    if (isset($_SESSION['userName']) && isset($_SESSION['accountID']) && isset($_SESSION['isAdmin'])) {
        $logged = true;
    }
    
?>