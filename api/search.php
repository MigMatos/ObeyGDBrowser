<?php

error_reporting(0);

include("../_init_.php");

function searchLevels($params, $db, $gdps_settings) {
    $time_left_daily = 0;
    $feaID = 0;
    $type_lvl = "none";
    $bindings = [];
    $paramsSql = [];
    $downloadLevelData = false;

    if (isset($params['levelName']) && $params['levelName'] === "*") {
        $sql = "SELECT levels.*, songs.ID, songs.name, songs.authorID, songs.authorName, songs.size, songs.isDisabled, songs.download ";

    } elseif (isset($params['levelName']) && ($params['levelName'] === "!daily" || $params['levelName'] === "!weekly")) {
    
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
    
        // if ($type == 1) {
        //     $feaID += 100001;
        // }
        $type_lvl = str_replace('!', '', $params['levelName']);
        

        $time_left_daily = $midnight - $current_time;
    
        $sql = "SELECT levels.*, songs.ID, songs.name, songs.authorID, songs.authorName, songs.size, songs.isDisabled, songs.download ";
        $paramsSql[] = "levelID = ?";
        $bindings[] = $lvlID;
    } elseif (isset($params['levelName']) && is_numeric($params['levelName'])) {
        $sql = "SELECT levels.*, songs.ID, songs.name, songs.authorID, songs.authorName, songs.size, songs.isDisabled, songs.download ";
        $paramsSql[] = "levelID = ?";
        $bindings[] = $params['levelName'];

        if(isset($params['downloadData']) && intval($params['downloadData']) == 1) {
            $downloadLevelData = true;
        }

    } elseif (isset($params['levelName'])) {
        $sql = "SELECT levels.*, songs.ID, songs.name, songs.authorID, songs.authorName, songs.size, songs.isDisabled, songs.download ";
        $paramsSql[] = "levelName LIKE ?";
        $bindings[] = '%' . $params['levelName'] . '%';
    } else {
        return json_encode(array("error" => "The 'levelName' parameter is required in the GET request."));
    }

    // Default settings
    $paramsSql[] = "unlisted = 0";
    $order = "likes";

    //Another configs
    $sql = $sql . " FROM levels LEFT JOIN songs ON levels.songID = songs.ID ";
    
    $lvlDiffs = ["-1" => "starDifficulty = 0", "-2" => "starDemon = 1 AND starDifficulty = 50", "-3" => "starAuto = 1 AND starDifficulty = 50", "1" => "starDemon = 0  AND starDifficulty = 10", "2" => "starDifficulty = 20", "3" => "starDifficulty = 30", "4" => "starDifficulty = 40", "5" => "starDemon = 0 AND starAuto = 0 AND starDifficulty = 50"];
    
    $demonDiffs = ["1" => "3", "2" => "4", "3" => "0", "4" => "5", "5" => "6"];
    

    
    foreach ($params as $key => $value) {
        if ($key !== 'levelName') {
            if ($key == "diff" && is_numeric($value)) {
                $paramsSql[] = (isset($lvlDiffs[$value]) ? $lvlDiffs[$value] : $lvlDiffs["-1"]);
            } elseif ($key == "demonFilter" && is_numeric($value)) {
                $paramsSql[] = "starDemonDiff = " . (isset($demonDiffs[$value]) ? $demonDiffs[$value] : $demonDiffs["3"]);
            } elseif ($key == "length" && is_numeric($value)) {
                $paramsSql[] = "levelLength = " . intval($value);
            } elseif ($key == 'type' && $value == 'featured') {
                if(intval($gdps_settings['gdps_version']) > 21) $paramsSql[] = "NOT starFeatured = 0 OR NOT starEpic = 0";
                else $paramsSql[] = "NOT starFeatured = 0";
                $order = "rateDate DESC,uploadDate";
            } elseif ($key == 'type' && $value == 'hof') {
                $paramsSql[] = "NOT starEpic = 0 AND starHall > 0";
                $order = "rateDate DESC,uploadDate";
            // } elseif ($key == 'type' || $key == 'creators') {
                // $paramsSql[] = "$key = ?";
                // $paramsSql[] = $value;
            // } elseif ($key == 'list' && $value == 'yes') {
            //     $sql .= " AND levelID IN (" . implode(',', $params['list']) . ") ";
            } elseif ($key == 'featured' && is_numeric($value) ) {
                $paramsSql[] = "starFeatured = " . intval($value);
            } elseif ($key == 'original' && $value == '1') {
                $paramsSql[] = "original = 0";
            } elseif ($key == 'twoPlayer' && $value == '1') {
                $paramsSql[] = "twoPlayer = 1";
            } elseif ($key == 'coins' && $value == '1') {
                $paramsSql[] = "starCoins > 0";
            } elseif ($key == 'epic' && is_numeric($value)) {
                $paramsSql[] = "starEpic = " . intval($value);
            } elseif ($key == 'starred' && $value == '1') {
                $paramsSql[] = "starStars > 0";
            } elseif ($key == 'noStar') {
                if ($value == '1') {$paramsSql[] = "starStars = 0";}
                else if ($value == '0') {$paramsSql[] = "NOT starStars = 0";}
            } elseif ($key == 'customSong' && is_numeric($value)) {
                $paramsSql[] = "songIDs = ?";
                $bindings[] = $value;
            } elseif ($key == 'user' && is_numeric($value)) {
                $paramsSql[] = "userID = ?";
                $bindings[] = $value;
            } elseif ($key == 'filter' && $value == 'recent') {
                $order = "uploadDate";
            } elseif ($key == 'filter' && $value == 'trending') {
                $paramsSql[] = "uploadDate > " . time() - (7 * 24 * 60 * 60);
                $order = "likes";
            } elseif ($key == 'filter' && $value == 'mostliked') {
                $order = "likes";
            } elseif ($key == 'filter' && $value == 'magic') {
                $paramsSql[] = "objects > 9999";
                $order = "uploadDate";
            } elseif ($key == 'filter' && $value == 'mostdownloaded') {
                $order = "downloads";
            } elseif ($key == 'filter' && $value == 'awarded') {
                $paramsSql[] = "NOT starStars = 0";
                $order = "rateDate DESC, uploadDate";
            }
            
        }
    }
    
    

    if(!empty($paramsSql) ){
        $sql .= " WHERE (" . implode(" ) AND ( ", $paramsSql) . ")";
    }

    if ($order) {
        $sql .= " ORDER BY $order DESC ";
    }

    $sql .= " LIMIT 10 OFFSET ? ";
    if(!isset($params['page'])) { $params['page'] = intval($params['page']); }
    $bindings[] = ($params['page'] <= 0) ? 0 : $params['page'] * 10;


    $stmt = $db->prepare($sql);
 


    foreach ($bindings as $key => $value) {
        $stmt->bindValue($key + 1, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }
    
    

    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


    // print_r($results);

    $orbs_get = [0 => 0, 1 => 0,2 => 50,3 => 75,4 => 125,5 => 175,6 => 225,7 => 275,8 => 350,9 => 425,10 => 500];

    //$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
    $url_parts = parse_url($_SERVER['REQUEST_URI']);
    $path = dirname($url_parts['path']);
    //$gdps_settings_path = "gdps_settings.json";

    if (strpos($path, "api") === false) {$path =  $path . "/api/";}
    

    //$path_url = "$protocol://$_SERVER[HTTP_HOST]$path/$gdps_settings_path";

    

    function getDiffString($isAuto, $isDemon, $diffType, $gdps_settings)
    {
        $diff = ucfirst($gdps_settings["states_diff_num"][$diffType] ?? "unrated");

        if ($isDemon) {
            $diff = "Demon";
        }
        else if ($isAuto) {
            $diff = "Auto";
        }

        return trim($diff);
    }


    function partialDiff($isAuto, $isDemon, $demonType, $diffType, $gdps_settings) {

        $default_diff_num = "unrated";
        $default_demon = "hard";

        $diff = $gdps_settings["states_diff_num"][$diffType] ?? $default_diff_num;

        if ($isDemon) {
            $demon = $gdps_settings["states_demon"][$demonType] ?? $default_demon;
            $diff = "demon" . "-" . $demon;
        }
        else if ($isAuto) {
            $diff = "auto";
        }
    
        return trim($diff);
    }


    function getfeatureType($featuredType, $epicType, $gdps_settings) {

        $default_featured = "";
        $default_epic = "";
        $featured = "";

        if ($featuredType != "0") {
            $featured = $gdps_settings["featured"][$featuredType] ?? $default_featured;
        }

        $epic = $epicType >= 1 ? $gdps_settings["epic"][$epicType] ?? $default_epic : "";

        $diff = $epic ? $epic : $featured;

        return trim($diff);
    }

    function calcCP($featuredType, $epicType) {
        return intval($featuredType + $epicType);
    }

    function calcDiamonds($stars) {
        if ($stars < 2) {return 0;} else {return $stars + 2;}
    }

    $json_data = array_map(function ($result) use ($orbs_get, $gdps_settings, $time_left_daily, $feaID, $type_lvl, $downloadLevelData) {

        $level = [];

        $partialDiff = partialDiff(($result["starAuto"] >= 1), ($result["starDemon"] >= 1), $result["starDemonDiff"], $result["starDifficulty"], $gdps_settings);
        $featDiff = getfeatureType($result["starFeatured"], $result["starEpic"], $gdps_settings);
        $fullDiff = trim($partialDiff . ($featDiff ? "-" . $featDiff : ""));

        $creatorPoints = calcCP($result["starFeatured"], $result["starEpic"]);
        $diffString = getDiffString(($result["starAuto"] >= 1), ($result["starDemon"] >= 1), $result["starDifficulty"], $gdps_settings);
        $description = isset($result["levelDesc"]) && trim($result["levelDesc"]) !== '' ? base64_decode(strtr($result["levelDesc"], '-_', '+/')) : "(No description provided)";
        $stars = max(0, intval($result["starStars"]));
        $diamonds = calcDiamonds($stars);
        $objs = intval($result["objects"]);
        $songID = intval($result["songID"]);
        $levelLengthint = intval($result["levelLength"]);
        $likes = intval($result["likes"]);
        
        // $starFeaturedValue = intval($result["starFeatured"]);
        // $starEpicValue = intval($result["starEpic"]);
        
        $gameVersion = intval($result["gameVersion"]);

        if ($time_left_daily !== 0 && $feaID !== 0 && $type_lvl !== "none") {
            $level["dailynumber"] = $feaID;
            $level["$type_lvl"] = 1;
            $level["nextdaily"] = $time_left_daily;
        }
        if($downloadLevelData){

            if(isset($gdps_settings["path_folder_levels"]) && file_exists($gdps_settings["path_folder_levels"] . $result["levelID"])){
                $levelstring = file_get_contents($gdps_settings["path_folder_levels"] . $result["levelID"]);
            }else if (isset($result["levelString"])){
                $levelstring = $result["levelString"];
            } else {
                $levelstring = "";
            }

            
            if(substr($levelstring,0,3) == 'kS1'){

            } else {
                $levelstring = str_replace("-","+",$levelstring);
                $levelstring = str_replace("_","/",$levelstring);
                $levelstring = base64_decode($levelstring);
                $levelstring = zlib_decode($levelstring);
            }
            

            $level["data"] = "$levelstring";
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
            "length" => isset($gdps_settings['length'][$levelLengthint]) ? $gdps_settings['length'][$levelLengthint] : "None",
            "platformer" => ($levelLengthint >= 5), 
            "stars" => $stars,
            "orbs" => isset($orbs_get[$stars]) ? intval($orbs_get[$stars]) : (intval($result[$stars]) > 10 ? 500 : 0),
            "diamonds" => $diamonds,
            "featFace" => (trim($featDiff) !== "") ? $featDiff : "none",
            "featured" => ($result["starFeatured"] >= 1),
            "featuredValue" => intval($result["starFeatured"]),
            "epic" => ($result["starEpic"] == 1),
            "epicValue" => intval($result["starEpic"]),
            "legendary" => ($result["starEpic"] == 2), 
            "mythic" => ($result["starEpic"] == 3), 
            "gameVersion" => $gameVersion,
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
            "songName" => isset($result["name"]) ? $result["name"] : "",
            "songAuthor" => isset($result["authorName"]) ? $result["authorName"] : "",
            "songSize" => isset($result["size"]) ? $result["size"]."MB" : "0.00MB",
            "songID" => $songID,
            "songLink" => isset($result["download"]) ? $result["download"] : "",
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
        $results = searchLevels($params, $db, $gdps_settings);
        echo $results;
    } else {
        echo json_encode(array("error" => "Please provide at least one search parameter in the GET request."));
    }
} 


?>
