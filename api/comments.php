<?php 

include("../_init_.php");
include("./utils.php");


error_reporting(0);

$file = str_replace("\\", "/", __FILE__);
$scriptFilename = str_replace("\\", "/", $_SERVER['SCRIPT_FILENAME']);

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $file == $scriptFilename) {
    $params = $_GET;

    if (!empty($params)) {
        $results = commentsGD($params, $db, $gdps_settings);
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

function commentsGD($params, $db, $gdps_settings) {
    $bindings = [];
    $paramsSql = [];
    $order = "timestamp ASC";

    if (isset($params['userID']) && $params['type'] == "profile"){
        $sql = "SELECT * FROM acccomments WHERE (userID = ?)";

        $bindings[] = intval($params['userID']);
       
    } else if (isset($params['levelID']) && $params['type'] == "level"){
        $sql = "SELECT comments.*,users.* FROM comments LEFT JOIN users ON users.userID = comments.userID WHERE (levelID = ?)";

        $bindings[] = intval($params['levelID']);
       
    } else if (!isset($params['userID']) && isset($params['type'])) {
        return json_encode(array("error" => "The 'userID' parameter is required in the GET request."));
    } else {
        $typeval = strval($params['type']);
        return json_encode(array("error" => "The '$typeval' type parameter is not valid in the GET request."));
    }

    if (isset($params['mode']) && $params['mode'] == "top") {
        $order = "likes DESC";
    }

    $sql .= " ORDER BY $order ";

    $sql .= " LIMIT 10 OFFSET ? ";
    if(!isset($params['page'])) { $params['page'] = intval($params['page']); }
    $bindings[] = ($params['page'] <= 0) ? 0 : $params['page'] * 10;

    $stmt = $db->prepare($sql);

    foreach ($bindings as $key => $value) {
        $stmt->bindValue($key + 1, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }

    $stmt->execute();

    

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    

    $json_data = array_map(function ($result) use ($gdps_settings) {

        $timeElapsed = BrowserUtils::calculateElapsedTime(intval($result["timestamp"]));

        $iconTypes = ["cube", "ship", "ball", "ufo", "wave", "robot", "spider", "swing", "jetpack"];    

        $content = strval(base64_decode(strval($result["comment"])));
        $content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');
        $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');

        $acc = [
            "content" => $content,
            "ID" => intval($result["commentID"]),
            "likes" => intval($result["likes"]),
            "date" => strval($timeElapsed),
            "percent" => intval($result["percent"]),
            "username" => strval($result["userName"]),
            "playerID" => intval($result["userID"]),
            "accountID" => intval($result["extID"]),
            "icon" => [
                "form" => strval($iconTypes[intval($result["iconType"])]),
                "icon" => intval($result["accIcon"]),
                "col1" => intval($result["color1"]),
                "col2" => intval($result["color2"]),
                "colG" => intval($result["color3"]),
                "glow" => intval($result["accGlow"])
            ],
            "levelID" =>  intval($result["levelID"]),
        ];  

        return $acc;
    }, $results);

    return json_encode($json_data, JSON_UNESCAPED_UNICODE);

}

?>