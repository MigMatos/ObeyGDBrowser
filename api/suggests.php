<?php 


error_reporting(0);

$file = str_replace("\\", "/", __FILE__);
$scriptFilename = str_replace("\\", "/", $_SERVER['SCRIPT_FILENAME']);

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $file == $scriptFilename) {
    include("../_init_.php");
    include('./utils.php');
    $params = $_GET;

    if (isset($params["levelID"]) && isset($params["type"])) {
        if($params["type"] == "all") $results = getAllSuggestions($params, $db);
        else if (in_array('admin', $userPermissions) || in_array('suggest', $userPermissions) ) $results = getAverageSuggestions($params, $db);
        echo $results;
    } else {
        echo json_encode(array("error" => "Please provide 'levelID' or 'type' parameter in the GET request."));
    }
}



// PARAMS
// username = userName
// page = page
// accountID = extID
// userID = userID

function getAllSuggestions($params, $db) {
    try {
        $sql = "SELECT suggestLevelId, suggestDifficulty, suggestStars, suggestFeatured, suggestAuto, suggestDemon
                FROM suggest
                WHERE suggestLevelId = :levelID";
        
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':levelID', $params['levelID'], PDO::PARAM_INT);
        $stmt->execute();
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($results as &$result) {
            $result['suggestDifficulty'] = BrowserUtils::getDifficultyLabel(
                intval($result['suggestDifficulty']), 
                intval($result['suggestAuto']), 
                intval($result['suggestDemon'])
            );
        }

        return json_encode($results ? $results : []);
        
    } catch (Exception $e) {
        return json_encode([]);
    }
}


function getAverageSuggestions($params, $db) {
    
    try {
        $sql = "SELECT 
                    AVG(suggestDifficulty) AS avgDifficulty,
                    AVG(suggestStars) AS avgStars,
                    AVG(suggestFeatured) AS avgFeatured,
                    AVG(suggestAuto) AS avgAuto,
                    AVG(suggestDemon) AS avgDemon
                FROM suggest
                WHERE suggestLevelId = :levelID";
        
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':levelID', $params['levelID'], PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $result['avgDifficulty'] = BrowserUtils::getDifficultyLabel(
                intval(round($result['avgDifficulty'])), 
                intval(round($result['avgAuto'])), 
                intval(round($result['avgDemon']))
            );
        }

        return json_encode($result ? $result : []);
        
    } catch (Exception $e) {
        return json_encode([]);
    }
}


?>