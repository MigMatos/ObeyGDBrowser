<?php 

include("../_init_.php");

error_reporting(0);

$file = str_replace("\\", "/", __FILE__);
$scriptFilename = str_replace("\\", "/", $_SERVER['SCRIPT_FILENAME']);

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $file == $scriptFilename) {
    $params = $_GET;

    if (!empty($params)) {
        $results = songsGD($params, $db, $gdps_settings);
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

function songsGD($params, $db, $gdps_settings) {
    $bindings = [];
    $paramsSql = [];

    if (isset($params['str'])){
        $sql = "SELECT songs.* FROM songs WHERE songs.name LIKE ?";

        $bindings[] = "%".strval($params['str'])."%";


    
    
    } else if (isset($params['id'])) {
        $sql = "SELECT songs.* FROM songs WHERE songs.id = ?";

        $bindings[] = strval($params['id']);
    }
    else {
        return json_encode(array("error" => "The 'str' or 'id' parameter is required in the GET request."));;
    }


    $sql .= " LIMIT 10 OFFSET ? ";
    if(!isset($params['page'])) { $params['page'] = intval($params['page']); }
    $bindings[] = ($params['page'] <= 0) ? 0 : $params['page'] * 10;

    $stmt = $db->prepare($sql);

    foreach ($bindings as $key => $value) {
        $stmt->bindValue($key + 1, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }

    $stmt->execute();


    if($stmt->rowCount() == 0) return json_encode([]);
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $json_data = array_map(function ($result) use ($gdps_settings) {

        $level = [
            "id" => intval($result["ID"]),
            "name" => strval($result["name"]),
            "authorID" => strval($result["authorID"]),
            "authorName" => strval($result["authorName"]),    
            "size" => floatval($result["size"]),
            "downloadLink" => strval($result["download"]),
            "levelsCount" => intval($result["levelsCount"]),
        ];

        return $level;
    }, $results);

    return json_encode($json_data);
}


?>