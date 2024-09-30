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
    $resultsTotal = [];
    $order = "id ASC";

    $sql = "SELECT songs.* FROM songs ";
    if (isset($params['author'])) {
        if(isset($params['str']) && $params['str'] == ""){
            $paramsSql[] = "songs.authorName LIKE ?";
            $bindings[] = "%".strval($params['author'])."%";
        } else {
            $paramsSql[] = "songs.authorName LIKE ? AND songs.name LIKE ?";
            $bindings[] = "%".strval($params['author'])."%";
            $bindings[] = "%".strval($params['str'])."%";
        }
    }
    else if (isset($params['str']) && !is_numeric($params['str'])){
        $paramsSql[] = "songs.name LIKE ?";
        $bindings[] = "%".strval($params['str'])."%";
    } else if (isset($params['str'])) {
        $paramsSql[] = "songs.id = ?";
        $bindings[] = intval($params['str']);
    }
    else {
        return json_encode(array("error" => "The 'str' or 'id' parameter is required in the GET request."));;
    }

    

    foreach ($params as $key => $value) {
        if ($key == 'filter') {
            if ($value == "recent") $order = "id DESC";
            else if ($value == "mostused") $order = "levelsCount DESC";
            else if ($value == "library") {
                $paramsSql[] = "ID > 10000000";
                $order = "name DESC";
            }
        }
        else if ($key == "nounknown") {
            $paramsSql[] = "songs.download LIKE '%geometrydashcontent.b-cdn.net%'
            OR songs.download LIKE '%geometrydashcontent.com%'
            OR songs.download LIKE '%dl.dropboxusercontent.com%'
            OR songs.download LIKE '%audio.ngfiles%'
            OR songs.download LIKE '%cdn.discordapp.com%'
            OR songs.download LIKE '%library.obeygdbot%'
            OR songs.authorName IN ('ObeyGDMusic', 'ObeyGDBot', 'ObeyGDMusic Library')";
        } else if ($key == "noogdlibrary") {
            $paramsSql[] = "songs.download NOT LIKE '%library.obeygdbot%' AND songs.authorName NOT IN ('ObeyGDMusic', 'ObeyGDBot', 'ObeyGDMusic Library')";
        }
        else if ($key == "nodiscord") $paramsSql[] = "songs.download NOT LIKE '%cdn.discordapp.com%'";
        else if ($key == "nong") {
            if (isset($params['noogdlibrary'])) $paramsSql[] = "songs.download NOT LIKE '%audio.ngfiles%'";
            else if (!isset($params['nodropbox'])) $paramsSql[] = "songs.download NOT LIKE '%audio.ngfiles%'";
            else $paramsSql[] = "songs.download LIKE '%audio.ngfiles%' OR songs.authorName IN ('ObeyGDMusic', 'ObeyGDBot', 'ObeyGDMusic Library')";
        }
        else if ($key == "nodropbox") {
            if (isset($params['noogdlibrary'])) $paramsSql[] = "songs.download NOT LIKE '%dl.dropboxusercontent.com%'";
            else if (!isset($params['nong'])) $paramsSql[] = "songs.download NOT LIKE '%dl.dropboxusercontent.com%'";
            else $paramsSql[] = "songs.download LIKE '%dl.dropboxusercontent.com%' OR songs.authorName IN ('ObeyGDMusic', 'ObeyGDBot', 'ObeyGDMusic Library')";
        }
        else if ($key == "noroblibrary") $paramsSql[] = "songs.download NOT LIKE '%geometrydashcontent.b-cdn.net%' AND songs.download NOT LIKE '%geometrydashcontent.com%'";
        else if ($key == "removeunused") $paramsSql[] = "songs.levelsCount > 0";
        
    }

    
    if(!empty($paramsSql) ) $sql .= " WHERE (" . implode(" ) AND ( ", $paramsSql) . ")";
    

    if ($order) $sql .= " ORDER BY $order";

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

    //--- Results and pages counter ---//
    $sql = "SELECT COUNT(*) FROM songs ";
    if(!empty($paramsSql) ) $sql .= " WHERE (" . implode(" ) AND ( ", $paramsSql) . ")";
    if ($order) $sql .= " ORDER BY $order";
    array_pop($bindings);
    $stmt = $db->prepare($sql);
    foreach ($bindings as $key => $value) { $stmt->bindValue($key + 1, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR); }
    $stmt->execute();
    $resultsTotal[] = $stmt->fetchColumn();
    $resultsTotal[] = intval($resultsTotal[0] / 10) + 1;
    $results[0]["paginator"] = $resultsTotal;
    // --- //



    $json_data = array_map(function ($result) {
        $level = [];

        if(isset($result["paginator"])) {
            $level["results"] = $result["paginator"][0];
            $level["pages"] = $result["paginator"][1];
        } 

        $level = array_merge($level, [
            "id" => intval($result["ID"]),
            "name" => strval($result["name"]),
            "authorID" => strval($result["authorID"]),
            "authorName" => strval($result["authorName"]),    
            "size" => floatval($result["size"]),
            "downloadLink" => strval($result["download"]),
            "levelsCount" => intval($result["levelsCount"]),
        ]);

        return $level;
    }, $results);

    return json_encode($json_data);
}


?>