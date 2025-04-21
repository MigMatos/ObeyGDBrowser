<?php
    // Rewrite for PHP 7.0+ (better code! :D)
    $gdps_settings_path = "gdps_settings.json";
    global $json_content_settings;
    $json_content_settings = @file_get_contents("./$gdps_settings_path") ?:  
    (@file_get_contents("../$gdps_settings_path") ?: 
    (@file_get_contents("../../$gdps_settings_path") ?: 
    (@file_get_contents("../../../$gdps_settings_path") ?: 
    (@file_get_contents("../../../../$gdps_settings_path") ?: 
    @file_get_contents("./browser/$gdps_settings_path" //Sorry custom installs from legacy
    )))));
    global $gdps_settings;
    $gdps_settings = json_decode($json_content_settings, true);
    define('BROWSER_PATH', isset($gdps_settings["browser_path"]) ? $gdps_settings["browser_path"] : 'browser/');
    function getRelativePath($pathFile=null) {
        $url = $_SERVER['SCRIPT_NAME'];
        if(!isset($pathFile)) $base = BROWSER_PATH;
        else $base = $pathFile;
        if(strpos($url, $base) === false) {
            if (!isset($pathFile)) { $base = BROWSER_PATH; }
        }
        $path = substr($url, strpos($url, $base) + strlen($base));
        $count = substr_count($path, '/');
        return $count === 0 ? './' : str_repeat('../', $count);
    }
    define('BASE_PATH', getRelativePath());

    function parseVersionText($t) { return [strval(($p=explode('|',$t,3))[0]!==""?$p[0]:(isset($p[1])?time()."-DEV":($t!==""?$t:time()."-DEV"))),intval(isset($p[1])?($p[1]!==""?$p[1]:0):0)]; }
    list($_OBEYGDBROWSER_VERSION, $_OBEYGDBROWSER_BINARYVERSION) = parseVersionText(@file_get_contents(BASE_PATH."update/version.txt",true) ?: "");
    $_OBEYGDBROWSER_FILEVERSION = intval($_OBEYGDBROWSER_BINARYVERSION) + max(0, intval($gdps_settings["cache_counter"] ?? 0));
    // global $_OBEYGDBROWSER_VERSION, $_OBEYGDBROWSER_BINARYVERSION, $_OBEYGDBROWSER_FILEVERSION;

    $failed_conn = false;

    $includePath   = $gdps_settings["path_connection"]  ?? "../../incl/lib/connection.php";
    $includeFolder = $gdps_settings["path_lib_folder"]  ?? "../../incl/lib/";
    
    global $gdpsVersion;
    $gdpsVersion = intval($gdps_settings["gdps_version"] ?? 30);

    ($included = @include_once($includePath)) ||
    ($included = @include_once("../$includePath")) ||
    ($included = @include_once("../../$includePath")) ||
    ($included = @include_once("./incl/lib/connection.php")) ||
    ($failed_conn = true) && print('<script>alert("Failed including connection, please configure in browser/gdpsettings");</script>');

    global $serverType;
    $serverType = strval($gdps_settings["server_software"] ?? "automatic");
    $iconsJSON  = json_encode($gdps_settings["icons"] ?? "");
    $colorsJSON = json_encode($gdps_settings["colors"] ?? "");

    if (isset($_SERVER['SERVER_SOFTWARE']) && $serverType == "automatic") {
        $server_software = $_SERVER['SERVER_SOFTWARE'];
        if (strpos($server_software, 'Apache') !== false) { $serverType = "apache";
        } else { $serverType = "legacy"; }
    }  else if (!isset($_SERVER['SERVER_SOFTWARE']) && $serverType == "automatic") {$serverType = "legacy";}

    $sessionLifetime = 15 * 24 * 60 * 60;
    session_set_cookie_params($sessionLifetime);

    session_start();

    
    $logged = false;
    $userName  = $_SESSION['userName']  ?? "None";
    $userID    = $_SESSION['userID']    ?? 0;
    $accountID = $_SESSION['accountID'] ?? 0;
    $isAdmin   = $_SESSION['isAdmin']   ?? 0;
    if (isset($_SESSION['userName']) && isset($_SESSION['accountID']) && isset($_SESSION['userID'])) { $logged = true; }
    if($logged == true) {
        session_regenerate_id(true);
        $_SESSION['LAST_ACTIVITY'] = time();
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $sessionLifetime)) {
            session_unset();
            session_destroy();
        }
    }

    $_CUSTOM_HEADERS = getallheaders();
    
    if (isset($_CUSTOM_HEADERS['OGDW_APPNAME']) && strlen($_CUSTOM_HEADERS['OGDW_APPNAME']) > 0) {

        $includePath = file_exists("./api/tokenApps.php") ? "./api/tokenApps.php" :(file_exists("../api/tokenApps.php") ? "../api/tokenApps.php" :(file_exists("../../api/tokenApps.php") ? "../../api/tokenApps.php" :(file_exists("./browser/api/tokenApps.php") ? "./browser/api/tokenApps.php" : null)));
        if ($includePath) {
            include_once($includePath);
            checkOGDWDevApp($db);
        }
        else {printf("Fatal Error searching library file: 'api/tokenApps.php'.");}
    }

    


    // Permissions
    function updateUserPerms($newPerms){
        global $userPermissions;
        // Rename perms for easy access :3
        if (in_array('toolPackcreate', $newPerms) || in_array('dashboardModTools', $newPerms) || in_array('dashboardGauntletCreate', $newPerms)) $newPerms[] = 'gauntlets';
        if (in_array('toolPackcreate', $newPerms) || in_array('dashboardModTools', $newPerms) || in_array('dashboardLevelPackCreate', $newPerms)) $newPerms[] = 'mappacks';
        if (in_array('commandRate', $newPerms) || in_array('actionRateStars', $newPerms)) $newPerms[] = 'rates';
        if (in_array('commandFeature', $newPerms)) $newPerms[] = 'featured';
        if (in_array('commandEpic', $newPerms)) $newPerms[] = 'epic';
        if (in_array('commandUnepic', $newPerms)) $newPerms[] = 'unepic';
        if (in_array('actionRateDifficulty', $newPerms)) $newPerms[] = 'ratedifficulty';
        if (in_array('actionRateDemon', $newPerms)) $newPerms[] = 'ratedemons';
        if (in_array('commandVerifycoins', $newPerms)) $newPerms[] = 'coins';
        if (in_array('toolSuggestlist', $newPerms) || in_array('dashboardModTools', $newPerms)) $newPerms[] = 'suggest';
        if (in_array('dashboardVaultCodesManage', $newPerms) || in_array('ogdwManageVaultCodes', $newPerms)) $newPerms[] = 'vaultcodes';
        // added in 1.1
        if (in_array('commandDescriptionOwn', $newPerms) || in_array('ogdwDescriptionOwn', $newPerms)) $newPerms[] = 'lvldescriptionown';
        if (in_array('commandDescriptionAll', $newPerms) || in_array('ogdwDescriptionAll', $newPerms)) $newPerms[] = 'lvldescriptionall';
        if (in_array('commandRenameOwn', $newPerms) || in_array('ogdwRenameOwn', $newPerms)) $newPerms[] = 'lvlrenameown';
        if (in_array('commandRenameAll', $newPerms) || in_array('ogdwRenameAll', $newPerms)) $newPerms[] = 'lvlrenameall';
        if (in_array('commandPublicOwn', $newPerms) || in_array('ogdwPublicOwn', $newPerms)) $newPerms[] = 'lvlpublicown';
        if (in_array('commandPublicAll', $newPerms) || in_array('ogdwPublicAll', $newPerms)) $newPerms[] = 'lvlpublicall';
        if (in_array('commandUnlistOwn', $newPerms) || in_array('ogdwUnlistOwn', $newPerms)) $newPerms[] = 'lvlunlistown';
        if (in_array('commandUnlistAll', $newPerms) || in_array('ogdwUnlistAll', $newPerms)) $newPerms[] = 'lvlunlistall';
        // ext
        if (in_array('commandDelete', $newPerms) || in_array('ogdwDeleteLevels', $newPerms)) $newPerms[] = 'lvldelete';
        
        


        $keysToRemove = [
            'toolSuggestlist', 'toolPackcreate', 'dashboardGauntletCreate', 'dashboardLevelPackCreate', 
            'commandRate', 'actionRateStars', 'commandFeature', 'commandEpic', 
            'commandUnepic', 'actionRateDifficulty', 'actionRateDemon', 'commandVerifycoins',
            'dashboardVaultCodesManage', 'ogdwManageVaultCodes'
        ];
        // Final perms
        $newPerms = array_diff($newPerms, $keysToRemove);

        $_SESSION['userPermissions'] = array_merge($userPermissions, $newPerms);
    }

    $userPermissions = $_SESSION['userPermissions'] ?? [];
    $userPermissionsJSON = json_encode($userPermissions);

?>