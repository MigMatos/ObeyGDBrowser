<?php

include("../api/search.php");

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
$url = $_SERVER['REQUEST_URI'];
$url_parts = parse_url($url);
$path = dirname($url_parts['path']);

$id = 0;
$returnmsg = "";

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    if ($id == "!daily") $returnmsg = "?daily=1";
    elseif ($id == "!weekly") $returnmsg = "?daily=2";
}
$html = file_get_contents('./t.html');


$params = array('levelName' => $id, 'page' => 0);


$response = searchLevels($params, $db, $gdps_settings);



$data = json_decode($response, true);

if(is_array($data) && (count($data) == 0 || isset($data["error"])) ){
    $redirect_url = "$protocol://$_SERVER[HTTP_HOST]$path/$returnmsg";
    header("Location: $redirect_url");
    exit();
}
$data = $data[0];

include("../api/suggests.php");
include("../api/utils.php");
$suggestAvg = getAverageSuggestions(["levelID" => $data["id"], "type" => "avg"], $db);


$data = array_merge($data, json_decode($suggestAvg,true));

include("../assets/htmlext/loadingalert.php");
include("../assets/htmlext/flayeralert.php");
$data["serverType"] = $serverType;
$data["userpermissions"] = $userPermissionsJSON;
$data["gdpsVersion"] = intval($gdps_settings["gdps_version"]);
foreach ($data as $key => $value) {
    $regex = '/\[\[' . strtoupper($key) . '\]\]/';
    $value = is_numeric($value) ? intval($value) : $value;
    if ($value === false) {$value = 0;} else if ($value === true) {$value = 1;} 
    $html = preg_replace($regex, $value, $html);
}

echo $html;
?>
