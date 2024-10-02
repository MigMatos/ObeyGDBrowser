<?php

include("../_init_.php");
include("../api/profile.php");
include("../api/roles.php");

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
$url = $_SERVER['REQUEST_URI'];
$url_parts = parse_url($url);
$path = dirname($url_parts['path'],$levels = 2);

$id = 0;
$returnmsg = "";


function extractUser($url) {
    if (empty($url)) return 0;
    $url = parse_url($url, PHP_URL_PATH);
    $username = basename($url);
    return $username;
}

if (isset($_GET["u"])) {
    $profile = extractUser($_GET["u"]);
    
    if(is_numeric($profile)) $params = array('accountID' => $profile);
    else $params = array('username' => $profile);
}


$html = file_get_contents('./t.html');


$response = profileUsers($params, $db, $gdps_settings);

$data = json_decode($response, true);

if(is_array($data) && (count($data) == 0 || isset($data["error"])) ){
    $redirect_url = "$protocol://$_SERVER[HTTP_HOST]$path/search/$profile";
    header("Location: $redirect_url");
    exit();
}

$data = $data[0];

if(isset($_GET["gdframe"])) {
    $data["GDFRAME"] = "TRUE"; 
} else { $data["GDFRAME"] = "FALSE"; }


$data["USERPERMISSIONS"] = $userPermissionsJSON;

// $data["GDPSVERSION"] = strval($gdps_settings["gdps_version"]);
include("../assets/htmlext/flayeralert.php");
foreach ($data as $key => $value) {
    $regex = '/\[\[' . strtoupper($key) . '\]\]/';
    $value = is_numeric($value) ? intval($value) : $value;
    if ($value === false) {$value = 0;} else if ($value === true) {$value = 1;} 
    $html = preg_replace($regex, $value, $html);
}

echo $html;
?>
