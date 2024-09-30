<?php 



$file = str_replace("\\", "/", __FILE__);
$scriptFilename = str_replace("\\", "/", $_SERVER['SCRIPT_FILENAME']);

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $file == $scriptFilename) {
    include("../_init_.php");

    $params = $_GET;

    if (!empty($params)) {
        $results = profileUsers($params, $db, $gdps_settings);
        echo $results;
    } else {
        echo json_encode(array("error" => "Please provide at least one search parameter in the GET request."));
    }
} 

// PARAMS
// username = userName
// page = page
// accountID = extID
// userID = userID

function profileUsers($params, $db, $gdps_settings) {
    $bindings = [];
    $paramsSql = [];

    if (isset($params['accountID'])){
        $sql = "SELECT users.*, users.userName as originalUserName, accounts.* FROM users LEFT JOIN accounts ON users.extID = accounts.accountID WHERE extID = :extid";
        $sql = $db->prepare($sql);
        $sql->execute([':extid' => intval($params['accountID']) ]);
    } else if (isset($params['username'])) {
        $sql = "SELECT users.*, users.userName as originalUserName, accounts.* FROM users LEFT JOIN accounts ON users.extID = accounts.accountID WHERE users.userName = :user";
        $sql = $db->prepare($sql);
        $sql->execute([':user' => strval($params['username']) ]);
    }
    else {
        return json_encode(array("error" => "The 'accountID' or 'username' parameter is required in the GET request."));;
    }


    if($sql->rowCount() == 0) return json_encode([]);
    
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);


    function checkisme($userID, $accID) {
        if(isset($_SESSION['userID']) && isset($_SESSION['accountID'])) {
            if(strval($_SESSION['userID']) == $userID && strval($_SESSION['accountID']) == $accID) return 1;
            else return 0;
        } else return 0;
    }

    $json_data = array_map(function ($result) use ($gdps_settings) {

        $level = [
            "username" => strval($result["originalUserName"]),
            "playerID" => strval($result["userID"]),
            "accountID" => strval($result["extID"]),
            "rank" => "0", // 
            "stars" => intval($result["stars"]),
            "diamonds" => intval($result["diamonds"]),
            "coins" => intval($result["coins"]),
            "userCoins" => intval($result["userCoins"]),
            "demons" => intval($result["demons"]),
            "moons" => intval($result["moons"]),
            "cp" => doubleval($result["creatorPoints"]),
            "cube" => intval($result["accIcon"]),
            "friendRequests" => false, // Upcoming
            "messages" => "off", // Upcoming
            "commentHistory" => "off", //  Upcoming
            "moderator" => 0, // Suponiendo un valor por defecto ya que no está en la estructura SQL
            "youtube" => !empty($result["youtubeurl"]) ? strval($result["youtubeurl"]) : "null", // Suponiendo un valor por defecto ya que no está en la estructura SQL
            "twitter" => !empty($result["twitter"]) ? strval($result["twitter"]) : "null", // Suponiendo un valor por defecto ya que no está en la estructura SQL
            "twitch" => !empty($result["twitch"]) ? strval($result["twitch"]) : "null", // Suponiendo un valor por defecto ya que no está en la estructura SQL
            "ship" => intval($result["accShip"]),
            "ball" => intval($result["accBall"]),
            "ufo" => intval($result["accBird"]),
            "wave" => intval($result["accDart"]),
            "robot" => intval($result["accRobot"]),
            "spider" => intval($result["accSpider"]),
            "swing" => intval($result["accSwing"]),
            "jetpack" => intval($result["accJetpack"]),
            "col1" => intval($result["color1"]),
            "col2" => intval($result["color2"]),
            "colG" => intval($result["color3"]),
            "deathEffect" => intval($result["accExplosion"]),
            "glow" => boolval($result["accGlow"]),
            "lastPlayed" => strval(date('Y-m-d H:i:s', intval($result["lastPlayed"]))),
            "me" => checkisme(strval($result["userID"]),strval($result["extID"])),
            "admin" => intval($result["isAdmin"]),
        ];

        return $level;
    }, $results);

    return json_encode($json_data);
}


?>