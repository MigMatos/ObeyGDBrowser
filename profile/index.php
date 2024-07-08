<?php

include("../api/profile.php");

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
$url = $_SERVER['REQUEST_URI'];
$url_parts = parse_url($url);
$path = dirname($url_parts['path'],$levels = 2);

$id = 0;
$returnmsg = "";

if (isset($_GET["u"])) {
    $profile = $_GET["u"];
    
    if(is_numeric($profile)) $params = array('accountID' => $profile);
    else $params = array('username' => $profile);

}
$html = file_get_contents('./t.html');


// $params = array('levelName' => $id);


$response = profileUsers($params, $db, $gdps_settings);


$data = json_decode($response, true);

if(is_array($data) && (count($data) == 0 || isset($data["error"])) ){
    $redirect_url = "$protocol://$_SERVER[HTTP_HOST]$path/search/$profile";
    header("Location: $redirect_url");
    exit();
}
$data = $data[0];



foreach ($data as $key => $value) {
    $regex = '/\[\[' . strtoupper($key) . '\]\]/';
    $value = is_numeric($value) ? intval($value) : $value;
    if ($value === false) {$value = 0;} else if ($value === true) {$value = 1;} 
    $html = preg_replace($regex, $value, $html);
}

echo $html;
?>