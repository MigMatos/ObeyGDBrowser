<?php

// error_reporting(-1);

include("../../incl/lib/connection.php");

function searchLevels($params, $db) {

    $time_left_daily = 0;
    $feaID = 0;
    $type_lvl = "none";

    if (isset($params['levelName']) && $params['levelName'] === "*") {
        $sql = "SELECT * FROM levels ";
        $bindings = array();
    } 
    elseif (isset($params['levelName']) && ($params['levelName'] === "!daily" || $params['levelName'] === "!weekly")) {


        $type = (strpos($params['levelName'], "!daily") !== false) ? 0 : 1;
        $midnight = ($type == 1) ? strtotime("next monday") : strtotime("tomorrow 00:00:00");
        $current_time = time();
        $query = $db->prepare("SELECT feaID, levelID FROM dailyfeatures WHERE timestamp < :current_time AND type = :type ORDER BY timestamp DESC LIMIT 1");
        $query->execute([':current_time' => $current_time, ':type' => $type]);

        
        if ($query->rowCount() == 0) {
            return json_encode(array("error" => "No daily/weekly"));
        }
        $results = $query->fetchAll(PDO::FETCH_ASSOC)[0];

        $feaID = $results["feaID"];
        $lvlID = $results["levelID"];

        if ($type == 1) {$feaID += 100001;}
        $type_lvl = str_replace('!', '', $params['levelName']);
        // // Calculate the time left until midnight
        $time_left_daily = $midnight - $current_time;

        $sql = "SELECT * FROM levels WHERE levelID = ? ";
        $bindings = array($lvlID);
    } 
    elseif (isset($params['levelName']) && is_numeric($params['levelName'])) {
        $sql = "SELECT * FROM levels WHERE levelID = ? ";
        $bindings = array($params['levelName']);
    } elseif (isset($params['levelName'])) {
        $sql = "SELECT * FROM levels WHERE levelName LIKE ? ";
        $bindings = array('%' . $params['levelName'] . '%');
    } else {
        return json_encode(array("error" => "The 'levelName' parameter is required in the GET request."));
    }

    $numericParams = array('diff', 'demonFilter', 'gauntlet', 'songID');

    foreach ($params as $key => $value) {
        if ($key !== 'levelName') {
            if (in_array($key, $numericParams) && is_numeric($value)) {
                $sql .= "AND $key = ? ";
                $bindings[] = $value;
            } elseif ($key == 'type' || $key == 'creators') {
                // $sql .= "AND $key = ? ";
                // $bindings[] = $value;
            } elseif ($key == 'list' && $value == 'yes') {
                $sql .= "AND levelID IN (" . implode(',', $params['list']) . ") ";
            } elseif ($key == 'featured' && $value == 'yes') {
                $sql .= "AND starFeatured = 1 ";
            } elseif ($key == 'original' && $value == 'yes') {
                $sql .= "AND original = 1 ";
            } elseif ($key == 'twoPlayer' && $value == 'yes') {
                $sql .= "AND twoPlayer = 1 ";
            } elseif ($key == 'coins' && $value == 'yes') {
                $sql .= "AND coins > 0 ";
            } elseif ($key == 'epic' && $value == 'yes') {
                $sql .= "AND starEpic > 0 ";
            } elseif ($key == 'starred' && $value == 'yes') {
                $sql .= "AND starStars > 0 ";
            } elseif ($key == 'noStar' && $value == 'yes') {
                $sql .= "AND starStars = 0 ";
            } elseif ($key == 'customSong') {
                $sql .= "AND songIDs = ? ";
                $bindings[] = $value;
            } elseif ($key == 'user') {
                $sql .= "AND userID = ? ";
                $bindings[] = $value;
            } elseif ($key == 'filter' && $value == 'recent') {
                $sql = rtrim($sql, "AND ");
                $sql .= " ORDER BY uploadDate DESC ";
            }
        }
    }

    $sql = rtrim($sql, "AND ");
    $sql .= " LIMIT 10 OFFSET ? ";
    $bindings[] = isset($params['page']) ? ($params['page'] == 0 ? 0 : max(0, ($params['page'] + 10) - 1)) : 0;

    $stmt = $db->prepare($sql);

    foreach ($bindings as $key => $value) {
        $stmt->bindValue($key + 1, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }

    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


    $orbs_get = [0 => 0, 1 => 0,2 => 50,3 => 75,4 => 125,5 => 175,6 => 225,7 => 275,8 => 350,9 => 425,10 => 500];

    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
    $url_parts = parse_url($_SERVER['REQUEST_URI']);
    $path = dirname($url_parts['path']);
    $gdps_settings_path = "gdps_settings.json";

    if (strpos($path, "api") === false) {$path =  $path . "/api/";}
    

    $path_url = "$protocol://$_SERVER[HTTP_HOST]$path/$gdps_settings_path";

    $json_content_settings = file_get_contents($path_url);
    $gdps_settings = json_decode($json_content_settings, true);

    function getDiffString($isDemon, $demonType, $diffType)
    {
        global $gdps_settings;
        $diff = ucfirst($gdps_settings["states_diff_num"][$diffType] ?? "unrated");
        if ($isDemon) {
            $demon = $gdps_settings["states_demon"][$demonType] ?? "";
            $diff = ucfirst($demon) . " " . $diff;
        }
        return trim($diff);
    }


    function partialDiff($isDemon, $demonType, $diffType) {
        global $gdps_settings;

        $default_diff_num = "unrated";
        $default_demon = "";

        $diff = $gdps_settings["states_diff_num"][$diffType] ?? $default_diff_num;

        if ($isDemon) {
            $demon = $gdps_settings["states_demon"][$demonType] ?? $default_demon;
            $diff = $diff . "-" . $demon;
        }
    
        return trim($diff);
    }

    function diffFace($partialDiff, $featuredType, $epicType) {
        global $gdps_settings;
    

        $default_featured = "";
        $default_epic = "";
        $featured = "";

        if ($featuredType != "0") {
            $featured = $gdps_settings["featured"][$featuredType] ?? $default_featured;
        }

        $epic = $epicType >= 1 ? $gdps_settings["epic"][$epicType] ?? $default_epic : "";

        $diff = $epic ? $epic : $featured;

        return trim($partialDiff . ($diff ? "-" . $diff : ""));
    }

    function calcCP($featuredType, $epicType) {
        return intval($featuredType + $epicType);
    }

    function calcDiamonds($stars) {
        if ($stars < 2) {return 0;} else {return $stars + 2;}
    }

    $json_data = array_map(function ($result) use ($orbs_get, $gdps_settings, $time_left_daily, $feaID, $type_lvl) {

        $level = [];

        $partialDiff = partialDiff(($result["starDemon"] >= 1), $result["starDemonDiff"], $result["starDifficulty"]);
        $fullDiff = diffFace($partialDiff, $result["starFeatured"], $result["starEpic"]);
        $creatorPoints = calcCP($result["starFeatured"], $result["starEpic"]);
        $diffString = getDiffString(($result["starDemon"] >= 1), $result["starDemonDiff"], $result["starDifficulty"]);
        $description = isset($result["levelDesc"]) && trim($result["levelDesc"]) !== '' ? $result["levelDesc"] : "(No description provided)";
        $stars = max(0, intval($result["starStars"]));
        $diamonds = calcDiamonds($stars);
        $objs = intval($result["objects"]);
        $songID = intval($result["songID"]);
        $levelLengthint = intval($result["levelLength"]);
        $likes = intval($result["likes"]);

        if ($time_left_daily !== 0 && $feaID !== 0 && $type_lvl !== "none") {

            $level = [
                "dailynumber" => $feaID,
                "$type_lvl" => 1,
                "nextdaily" => $time_left_daily
            ];
        }

       

        $level = array_merge($level, [
            "name" => $result["levelName"],
            "id" => $result["levelID"],
            "description" => $description,
            "author" => $result["userName"],
            "playerID" => intval($result["extID"]),
            "accountID" => intval($result["userID"]),
            "difficulty" => $diffString,
            "downloads" => intval($result["downloads"]),
            "likes" => $likes,
            "disliked" => ($likes < 0), 
            "length" => $gdps_settings['length'][intval($levelLengthint)],
            "platformer" => ($levelLengthint >= 5), 
            "stars" => $stars,
            "orbs" => isset($orbs_get[$stars]) ? intval($orbs_get[$stars]) : (intval($result[$stars]) > 10 ? 500 : 0),
            "diamonds" => $diamonds,
            "featured" => ($result["starFeatured"] >= 1),
            "featuredValue" => intval($result["starFeatured"]),
            "epic" => ($result["starEpic"] == 1),
            "epicValue" => intval($result["starEpic"]),
            "legendary" => ($result["starEpic"] == 2), 
            "mythic" => ($result["starEpic"] == 3), 
            "gameVersion" => intval($result["gameVersion"]),
            "editorTime" => 0,
            "totalEditorTime" => 0,
            "version" => intval($result["levelVersion"]),
            "copiedID" => intval($result["originalReup"]),
            "twoPlayer" => ($result["twoPlayer"] == 1),
            "officialSong" => intval($result["audioTrack"]),
            "customSong" => $songID,
            "coins" => intval($result["coins"]),
            "verifiedCoins" => ($result["starCoins"] == 1),
            "starsRequested" => intval($result["requestedStars"]),
            "ldm" => ($result["isLDM"] == 1),
            "objects" => $objs,
            "large" => ($objs > 40000),
            "cp" => $creatorPoints,
            "partialDiff" => $partialDiff,
            "difficultyFace" => $fullDiff, 
            "password" => "",
            "uploaded" => "",
            "updated" => "",
            "songName" => "", // Placeholder value
            "songAuthor" => "", // Placeholder value
            "songSize" => "", // Placeholder value
            "songID" => $songID,
            "songLink" => "", // Placeholder value
            "results" => 9999, // Placeholder value
            "pages" => 1000 // Placeholder value
        ]);


        return $level;
    }, $results);



    return json_encode($json_data);
}

$file = str_replace("\\", "/", __FILE__);
$scriptFilename = str_replace("\\", "/", $_SERVER['SCRIPT_FILENAME']);

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $file == $scriptFilename) {
    $params = $_GET;

    if (!empty($params)) {
        $results = searchLevels($params, $db);
        echo $results;
    } else {
        echo json_encode(array("error" => "Please provide at least one search parameter in the GET request."));
    }
} 


?>
