<?php
header('Access-Control-Allow-Methods: POST');

// error_reporting(0);

$file = basename(__FILE__);
$scriptFilename = basename($_SERVER['SCRIPT_NAME']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $file == $scriptFilename) {
    include("../_init_.php");
    include("./utils.php");
    $action = $_POST['act'] ?? null;
    if (!$action) {
        echo json_encode(array("error" => "Please provide an action parameter in the POST request."));
        exit;
    }
    switch ($action) {
        case 'edit':
            echo editLevel($_POST, $db, $userPermissions, $accountID, $userID);
            break;
        default:
            echo json_encode(array("error" => "Invalid action specified."));
            break;
    }
}
function editLevel($params, $db, $userPermissions, $accountID, $userID) {

    if (!isset($params['id'])) {
        return json_encode([
            "error" => true,
            "message" => "id is required"
        ]);
    }

    $isAdmin = in_array('admin', $userPermissions);

    $missingPermissions = [];
    $query = "UPDATE levels SET ";
    $fields = [];
    $bindings = [];
    $modActions = [];
    $isLvlOwner = false;

    // Fix: add updated
    $fields[] = "rateDate = ?";
    $bindings[] = intval(time());

    // ------------- //
    if (isset($params['stars'])) {
        if ($isAdmin || in_array('rates', $userPermissions)) {
            $fields[] = "starStars = ?";
            $bindings[] = max(-99999999, min( intval($params['stars']) , 99999999));
            $modActions[] = 'rate';
        } else {
            $missingPermissions[] = 'rates';
        }
    }

    if (isset($params['diff']) || isset($params['diffauto']) || isset($params['diffdemon'])) {
        if($isAdmin || in_array('ratedifficulty', $userPermissions)) {
            if(isset($params['diff'])) {
                $fields[] = "starDifficulty = ?";
                $bindings[] = max(-999999, min( intval($params['diff']) , 999999));
            }
            if(isset($params['diffauto'])) {
                $fields[] = "starAuto = ?";
                $bindings[] = max(-999999, min( intval($params['diffauto']) , 999999));
            }
            if(isset($params['diffdemon'])) {
                $fields[] = "starDemon = ?";
                $bindings[] = (intval($params['diffdemon']) > 0) ? 1 : 0;
            }
            $modActions[] = 'diff';
        } else{$missingPermissions[] = 'ratedifficulty';}
    }

    if(isset($params['diffdemon'])) {
        if ($isAdmin || in_array('ratedemons', $userPermissions)) {
            $fields[] = "starDemonDiff = ?";
            $bindings[] = max(-999999, min( intval($params['diffauto']) , 999999));
            $modActions[] = 'demon';
        } else{$missingPermissions[] = 'ratedemons';}
    }

    if (isset($params['coins'])) {
        if ($isAdmin || in_array('coins', $userPermissions)) {
            $fields[] = "starCoins = ?";
            $bindings[] = max(0, min( intval($params['coins']) , 1));
            $modActions[] = 'coin';
        } else {$missingPermissions[] = 'coins';}
    }
    

    if(isset($params['feat'])) {
        $feat = max(-999999, min(intval($params['feat']), 999999));
        if ($isAdmin || in_array('featured', $userPermissions)) {
            $fields[] = "starFeatured = ?";
            $bindings[] = $feat;
            $modActions[] = 'featured';
        } else {$missingPermissions[] = 'featured';}
    }

    if(isset($params['epic'])) {
        $epicValue = max(-999999, min(intval($params['epic']), 999999));
        $isUnepic = ($epicValue < 0);
        $permissionNeeded = $isUnepic ? 'unepic' : 'epic';
        if (in_array($permissionNeeded, $userPermissions)) {
            $fields[] = "starEpic = ?";
            $bindings[] = $epicValue;
            $modActions[] = 'epic';
        } else {$missingPermissions[] = $permissionNeeded;}
    }

    if(isset($params['unlisted']) || isset($params['unlisted2']) || isset($params['leveldescription']) || isset($params['levelname']) || isset($params['sharecp']) || isset($params['songid'])) {
        $sqlAlt = "SELECT userID, extID FROM levels WHERE levelID = ?";
        $stmt = $db->prepare($sqlAlt);
        $stmt->execute([$params['id']]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(count($results) != 0){ if($accountID == $results["extID"] && $userID == $results["userID"]) $isLvlOwner = true;}
        if(isset($params['leveldescription'])){
            $descriptionEncoded = $params['leveldescription'];
            $openTags = substr_count($descriptionEncoded, '<c');
            $closeTags = substr_count($descriptionEncoded, '</c>');
            if ($openTags > $closeTags) {$descriptionEncoded .= str_repeat('</c>', $openTags - $closeTags);}
            $descriptionEncoded = BrowserUtils::url_base64_encode(BrowserUtils::sanitizeText($descriptionEncoded));
            $permissionOwn = in_array('lvldescriptionown', $userPermissions);
            $permissionAll = in_array('lvldescriptionall', $userPermissions);
            if ($isAdmin || $isLvlOwner || $permissionOwn || $permissionAll) {
                $fields[] = "levelDesc = ?";
                $bindings[] = $descriptionEncoded;
                $modActions[] = 'lvldesc';
            } else {
                if (!($isLvlOwner || $permissionOwn || !$isAdmin)) $missingPermissions[] = 'levelDescriptionOwn';
                if (!$permissionAll && !$isAdmin) $missingPermissions[] = 'levelDescriptionAll';
            }
        }
        if(isset($params['levelname'])){
            $levelnameEncoded = BrowserUtils::sanitizeText($params['levelname'],255,true);
            $permissionOwn = in_array('lvlrenameown', $userPermissions);
            $permissionAll = in_array('lvlrenameall', $userPermissions);
            if ($isAdmin || ($isLvlOwner && $permissionOwn) || $permissionAll) {
                $fields[] = "levelName = ?";
                $bindings[] = $levelnameEncoded;
                $modActions[] = 'lvlname';
            } else {
                if ($isLvlOwner && !$permissionOwn && !$isAdmin) $missingPermissions[] = 'levelRenameOwn';
                if (!$permissionAll && !$isAdmin) $missingPermissions[] = 'levelRenameAll';
            }
        }
        // Unlisted
        if (isset($params['unlisted']) || isset($params['unlisted2'])) {
            $fieldUnlist = isset($params['unlisted2']) ? 'unlisted2' : 'unlisted';
            $valueUnlisted = intval($params[$fieldUnlist]);
        
            $oppositeField = $fieldUnlist === 'unlisted2' ? 'unlisted' : 'unlisted2';
            $oppositeValue = $fieldUnlist === 'unlisted2' ? 1 : 0;
        
            $permPrefix = ($valueUnlisted === 1) ? 'lvlunlisted' : 'lvlpublic';
        
            $hasOwnPerm = in_array($permPrefix . 'own', $userPermissions);
            $hasAllPerm = in_array($permPrefix . 'all', $userPermissions);
        

            if ($isAdmin || ($isLvlOwner ? $hasOwnPerm : $hasAllPerm)) {
                $fields[] = "$fieldUnlist = ?";
                $bindings[] = $valueUnlisted;
        
                $fields[] = "$oppositeField = ?";
                $bindings[] = $oppositeValue;
        
                $modActions[] = 'lvlvisibility';
            } else {
                $missingPermissions[] = $permPrefix . ($isLvlOwner ? 'own' : 'all');
            }
        }
    }

    // if (empty($fields)) {
    //     return json_encode([
    //         "error" => true,
    //         "message" => "You do not have permission to access this API."
    //     ]);
    // }


    $query .= implode(", ", $fields) . " WHERE levelID = ?";
    $bindings[] = $params['id'];

    $stmt = $db->prepare($query);
    $stmt->execute($bindings);

    if($stmt) {
        if (in_array('rate', $modActions)) setModAction(RATE_LEVEL, ['value' => $params['id'], 'value2' => intval($params['stars'])], $db, $accountID);

        if (in_array('demon', $modActions)) setModAction(DEMON_DIFFICULTY, ['value' => $params['id'], 'value2' => intval($params['diffdemon'])], $db, $accountID);

        if (in_array('diff', $modActions)) setModAction(CHANGE_DIFFICULTY_LEVEL, ['value' => $params['id'], 'value2' => intval($params['diff'])], $db, $accountID);

        if (in_array('coin', $modActions)) setModAction(CHANGE_COINS_LEVEL, ['value' => $params['id'], 'value2' => intval($params['coins'])], $db, $accountID);

        if (in_array('featured', $modActions)) setModAction(CHANGE_FEATURE_LEVEL, ['value' => $params['id'], 'value2' => $feat], $db, $accountID);

        if (in_array('epic', $modActions)) setModAction(CHANGE_EPIC_LEVEL, ['value' => $params['id'], 'value2' => $epicValue], $db, $accountID);

        if (in_array('lvldesc', $modActions)) setModAction(CHANGE_DESCRIPTION, ['value' => $params['id'], 'value2' => ''], $db, $accountID);

        if (in_array('lvlname', $modActions)) setModAction(RENAME_LEVEL, ['value' => $params['id'], 'value2' => ''], $db, $accountID);

        if (in_array('lvlvisibility', $modActions)) setModAction(CHANGE_PUBLISH_LEVEL, ['value' => $params['id'], 'value2' => $fieldUnlist, 'value3' => $valueUnlisted], $db, $accountID);

    } else {
        return json_encode([
            'error' => true,
            'message' => 'SQL Error: ' . strval($stmt->errorInfo()[2])
        ]);
    }


    if (!empty($missingPermissions)) {
        return json_encode([
            "error" => false,
            "message" => "Missing some permissions: " . implode(', ', $missingPermissions)
        ]);
    } else {
        return json_encode([
            "error" => false,
            "message" => "Level rated successfully"
        ]);
    }
}



?>