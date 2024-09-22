<?php 

include("../_init_.php");
include("./utils.php");

$file = str_replace("\\", "/", __FILE__);
$scriptFilename = str_replace("\\", "/", $_SERVER['SCRIPT_FILENAME']);

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $file == $scriptFilename) {
    $params = $_GET;
    if(isset($params["list"])){
        echo getAvailableGauntlets($params, $gdps_settings);
    } else {
        echo getGauntlets($params, $db, $gdps_settings);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $file == $scriptFilename) {
    $action = $_POST['act'] ?? null;
    if (!in_array('admin', $userPermissions) && !in_array('gauntlets', $userPermissions)) {
        echo json_encode(array("error" => "You do not have permission to access this API."));
        exit(401);
    }
    if (!$action) {
        echo json_encode(array("error" => "Please provide an action parameter in the POST request."));
        exit;
    }

    switch ($action) {
        case 'delete':
            echo deleteMapPack($id, $db);
            break;

        case 'edit':
            echo editMapPack($_POST, $db);
            break;

        case 'create':
            echo createMapPack($_POST, $db);
            break;

        default:
            echo json_encode(array("error" => "Invalid action specified."));
            break;
    }
} else {
    echo json_encode(array("error" => "Invalid request method or script filename mismatch."));
}

// fix incomplete and bugged gdnoxi code

// PARAMS
// 

function getGauntlets($params, $db, $gdps_settings) {
    $bindings = [];
    $paramsSql = [];
    $order = "ID ASC";

    $sql = "SELECT ID,level1, level2, level3, level4, level5 FROM gauntlets ";


    // Final
    if ($order) $sql .= " ORDER BY $order";
    // $sql .= " LIMIT 10 OFFSET ? ";
    // if(!isset($params['page'])) { $params['page'] = intval($params['page']); }
    // $bindings[] = ($params['page'] <= 0) ? 0 : $params['page'] * 10;

    $stmt = $db->prepare($sql);

    foreach ($bindings as $key => $value) {
        $stmt->bindValue($key + 1, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }

    $stmt->execute();

    if($stmt->rowCount() == 0) return json_encode([]);
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    //--- Results and pages counter ---//
    $sql = "SELECT COUNT(*) FROM gauntlets ";
    if(!empty($paramsSql) ) $sql .= " WHERE (" . implode(" ) AND ( ", $paramsSql) . ")";
    if ($order) $sql .= " ORDER BY $order";
    array_pop($bindings);
    $stmt = $db->prepare($sql);
    foreach ($bindings as $key => $value) { $stmt->bindValue($key + 1, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR); }
    $stmt->execute();
    $resultsTotal[] = $stmt->fetchColumn();
    $resultsTotal[] = intval($resultsTotal[0] / 3) + 1;
    $results[0]["paginator"] = $resultsTotal;
    // --- //

    // Result
    
    function getGauntletsInfo($id) {
        global $gdps_settings;
        return $gdps_settings["gauntlets"]["$id"] ?? array("name" => "Unknown", "textColor" => "", "bgColor" => "");
    }

    function returnStringLevels($level1,$level2,$level3,$level4,$level5) {
        return strval($level1).",".strval($level2).",".strval($level3).",".strval($level4).",".strval($level5);
    }

    function countLevels($levels) {return count(array_filter(explode(',', $levels)));}
    
    function getDiffText($textLevel) {
        $textLevel = strtolower($textLevel);
        if(strpos($textLevel, "demon") !== false) $textLevel = "demon-" . str_replace("demon", "", $textLevel);
        return trim($textLevel);
    }

    $json_data = array_map(function ($result) {

        $level = [];
        
        

        if(isset($result["paginator"])) {
            $level["results"] = $result["paginator"][0];
            $level["pages"] = $result["paginator"][1];
        }
        $level = array_merge($level, [
            "id" => intval($result["ID"]),
            "gauntlet" => getGauntletsInfo(intval($result["ID"])),
            "levels" => returnStringLevels($result["level1"],$result["level2"],$result["level3"],$result["level4"],$result["level5"]),
            "levelsCount" => 5,
        ]);


        return $level;
    }, $results);

    return json_encode($json_data);
}

function getAvailableGauntlets($params, $gdps_settings) {
    $gauntlets = [];
    if(isset($gdps_settings["gauntlets"])) {
        $gauntlets = $gdps_settings["gauntlets"];
        unset($gauntlets["-1"]);
        unset($gauntlets["0"]);
    }
    $search = strval($params["search"]);
    $results = [];
    
    if (is_numeric($search)) {
        if (isset($gauntlets[$search])) {
            $item = $gauntlets[$search];

            return json_encode([[
                'id' => $search,
                'name' => $item['name'],
                'textColor' => $item['textColor'],
                'bgColor' => $item['bgColor']
            ]]);
        }
    } else {
        $searchLower = strtolower($search);
        foreach ($gauntlets as $id => $item) {
            if (stripos($item['name'], $searchLower) !== false) {
                $results[] = [
                    'id' => $id,
                    'name' => $item['name'],
                    'textColor' => $item['textColor'],
                    'bgColor' => $item['bgColor']
                ];
                if (count($results) >= 10) {
                    break;
                }
            }
        }
    }

    return json_encode($results);
}

function deleteMapPack($id, $db) {
    $id = intval($id ?? 0);
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
        return json_encode(array("success" => "true", "ID" => $id));
    } else {
        return json_encode(array("success" => "false"));
    }
}


function editMapPack($params, $db) {
    $id = intval($params['id'] ?? 0);
    // print_r($params);
    if ($id <= 0) {
        return json_encode(array("error" => "Invalid ID."));
    }

    $name = strval($params['name'] ?? '');
    $levels = strval($params['levels'] ?? '');

    if (empty($name) || empty($levels)) {
        return json_encode(array("error" => "'name' and 'levels' fields are mandatory."));
    }

    $colors2 = BrowserUtils::hexToRgb($params['colors2'] ?? '');
    $rgbcolors = BrowserUtils::hexToRgb($params['rgbcolors'] ?? '');
    $stars = intval($params['stars'] ?? 0);
    $coins = intval($params['coins'] ?? 0);
    $difficulty = intval($params['difficulty'] ?? 0);

    $sql = "UPDATE gauntlets SET colors2 = ?, rgbcolors = ?, name = ?, levels = ?, stars = ?, coins = ?, difficulty = ? WHERE ID = ?";
    $bindings = [$colors2, $rgbcolors, $name, $levels, $stars, $coins, $difficulty, $id];

    $stmt = $db->prepare($sql);

    foreach ($bindings as $key => $value) {
        $stmt->bindValue($key + 1, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }

    if ($stmt->execute()) {
        return json_encode(array("success" => "true", "ID" => $id));
    } else {
        return json_encode(array("success" => "false"));
    }
}


function createMapPack($params, $db) {
    $name = strval($params['name'] ?? '');
    $levels = strval($params['levels'] ?? '');

    if (empty($name) || empty($levels)) {
        return json_encode(array("error" => "'name' and 'levels' fields are mandatory."));
    }

    $colors2 = BrowserUtils::hexToRgb($params['colors2'] ?? '');
    $rgbcolors = BrowserUtils::hexToRgb($params['rgbcolors'] ?? '');
    $stars = intval($params['stars'] ?? 0);
    $coins = intval($params['coins'] ?? 0);
    $difficulty = intval($params['difficulty'] ?? 0);

    $sql = "INSERT INTO mappacks (colors2, rgbcolors, name, levels, stars, coins, difficulty) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $bindings = [$colors2, $rgbcolors, $name, $levels, $stars, $coins, $difficulty];

    $stmt = $db->prepare($sql);

    foreach ($bindings as $key => $value) {
        $stmt->bindValue($key + 1, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }

    if ($stmt->execute()) {
        $id = $db->lastInsertId();
        return json_encode(array("success" => "true", "ID" => $id));
    } else {
        return json_encode(array("success" => "false"));
    }
}


?>
