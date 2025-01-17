<?php 
header('Access-Control-Allow-Methods: GET, POST');

include("../_init_.php");
include("./utils.php");


error_reporting(0);

$file = basename(__FILE__);
$scriptFilename = basename($_SERVER['SCRIPT_NAME']);

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $file == $scriptFilename) {
    $params = $_GET;
    echo getMapPacks($params, $db, $gdps_settings);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $file == $scriptFilename) {
    $action = $_POST['act'] ?? null;
    if (!in_array('admin', $userPermissions) && !in_array('mappacks', $userPermissions)) {
        echo json_encode(array("error" => "You do not have permission to access this API."));
        exit(401);
    }
    if (!$action) {
        echo json_encode(array("error" => "Please provide an action parameter in the POST request."));
        exit;
    }

    include('actions.php');

    switch ($action) {
        case 'delete':
            echo deleteMapPack($_POST, $db, $accountID);
            break;

        case 'edit':
            echo editMapPack($_POST, $db, $accountID);
            break;

        case 'create':
            echo createMapPack($_POST, $db, $accountID);
            break;

        default:
            echo json_encode(array("error" => "Invalid action specified."));
            break;
    }
} else {
    echo json_encode(array("error" => "Invalid request method or script filename mismatch."));
}



// PARAMS
// page = page

function getMapPacks($params, $db, $gdps_settings) {
    $bindings = [];
    $paramsSql = [];
    $order = "ID ASC";

    $sql = "SELECT colors2,rgbcolors,ID,name,levels,stars,coins,difficulty FROM mappacks ";


    // Final
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
    $sql = "SELECT COUNT(*) FROM mappacks ";
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

    // Result
    $difficulty_levels = [0 => 'auto', 1 => 'easy', 2 => 'normal', 3 => 'hard', 4 => 'harder', 5 => 'insane', 6 => 'hard demon', 7 => 'easy demon', 8 => 'medium demon', 9 => 'insane demon', 10 => 'extreme demon'];
    function countLevels($levels) {return count(array_filter(explode(',', $levels)));}
    
    function getDiffText($textLevel) {
        $textLevel = strtolower($textLevel);
        if(strpos($textLevel, "demon") !== false) $textLevel = "demon-" . str_replace("demon", "", $textLevel);
        return trim($textLevel);
    }

    $json_data = array_map(function ($result) use ($difficulty_levels) {

        $level = [];
        
        

        if(isset($result["paginator"])) {
            $level["results"] = $result["paginator"][0];
            $level["pages"] = $result["paginator"][1];
        }

        $level = array_merge($level, [
            "packID" => intval($result["ID"]),
            "packName" => strval($result["name"]),
            "levels" => strval($result["levels"]),
            "levelsCount" => countLevels(strval($result["levels"])),
            "stars" => intval($result["stars"]),
            "coins" => intval($result["coins"]),
            "difficulty" => intval($result["difficulty"]),
            "difficultyFace" => getDiffText($difficulty_levels[intval($result["difficulty"])]),
            "difficultyText" => $difficulty_levels[intval($result["difficulty"])],
            "textColor" => BrowserUtils::rgbToHex($result["rgbcolors"]),
            "barColor" => BrowserUtils::rgbToHex($result["colors2"])
        ]);

        return $level;
    }, $results);

    return json_encode($json_data);
}

function deleteMapPack($params, $db, $accountID) {
    $id = intval($params['id'] ?? 0);
    if ($id <= 0) {
        return json_encode(array("error" => "Invalid ID."));
    }

    $sql = "DELETE FROM mappacks WHERE ID = ?";
    $bindings = [$id];

    $stmt = $db->prepare($sql);

    foreach ($bindings as $key => $value) {
        $stmt->bindValue($key + 1, $value, PDO::PARAM_INT);
    }

    if ($stmt->execute()) {

        setModAction(DELETE_MAP_PACK, ['value' => $id], $db, $accountID);

        return json_encode(array("success" => "true", "ID" => $id));
    } else {
        return json_encode(array("success" => "false"));
    }
}


function editMapPack($params, $db, $accountID) {
    $id = intval($params['id'] ?? 0);
    // print_r($params);
    if ($id <= 0) {
        return json_encode(array("error" => "Invalid ID."));
    }

    $name = strval($params['name'] ?? '');
    $levels = $params['levels'];

    if (empty($name) || empty($levels)) {
        return json_encode(array("error" => "'name' and 'levels' fields are required."));
    }

    $levels = implode(',', $levels);
    $colors2 = BrowserUtils::hexToRgb($params['colors2'] ?? '');
    $rgbcolors = BrowserUtils::hexToRgb($params['rgbcolors'] ?? '');
    $stars = intval($params['stars'] ?? 0);
    $coins = intval($params['coins'] ?? 0);
    $difficulty = intval($params['difficulty'] ?? 0);

    $sql = "UPDATE mappacks SET colors2 = ?, rgbcolors = ?, name = ?, levels = ?, stars = ?, coins = ?, difficulty = ? WHERE ID = ?";
    $bindings = [$colors2, $rgbcolors, $name, $levels, $stars, $coins, $difficulty, $id];

    $stmt = $db->prepare($sql);

    foreach ($bindings as $key => $value) {
        $stmt->bindValue($key + 1, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }

    if ($stmt->execute()) {

        setModAction(CHANGE_MAP_PACK, ['value' => $id, 'value2' => $levels, 'value3' => $difficulty, 'value5' => $stars, 'value6' => $coins], $db, $accountID);

        return json_encode(array("success" => "true", "ID" => $id));
    } else {
        return json_encode(array("success" => "false"));
    }
}


function createMapPack($params, $db, $accountID) {
    $name = strval($params['name'] ?? '');
    $levels = $params['levels'];

    if (empty($name) || empty($levels)) {
        return json_encode(array("error" => "'name' and 'levels' fields are required."));
    }

    $levels = implode(',', $levels);
    $colors2 = BrowserUtils::hexToRgb($params['colors2'] ?? '');
    $rgbcolors = BrowserUtils::hexToRgb($params['rgbcolors'] ?? '');
    $stars = intval($params['stars'] ?? 0);
    $coins = intval($params['coins'] ?? 0);
    $difficulty = intval($params['difficulty'] ?? 0);

    $sql = "INSERT INTO mappacks (colors2, rgbcolors, name, levels, stars, coins, difficulty) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $bindings = [$colors2, $rgbcolors, $name, $levels, $stars, $coins, $difficulty];

    $stmt = $db->prepare($sql);

    foreach ($bindings as $key => $value) {
        $stmt->bindValue($key + 1, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }

    if ($stmt->execute()) {
        $id = $db->lastInsertId();

        setModAction(CREATE_MAP_PACK, ['value' => $id, 'value2' => $levels, 'value3' => $difficulty, 'value5' => $stars, 'value6' => $coins], $db, $accountID);

        return json_encode(array("success" => "true", "ID" => $id));
    } else {
        return json_encode(array("success" => "false"));
    }
}


?>