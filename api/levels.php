<?php
header('Access-Control-Allow-Methods: POST');

error_reporting(0);

$file = basename(__FILE__);
$scriptFilename = basename($_SERVER['SCRIPT_NAME']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $file == $scriptFilename) {
    include("../_init_.php");
    $action = $_POST['act'] ?? null;
    if (!$action) {
        echo json_encode(array("error" => "Please provide an action parameter in the POST request."));
        exit;
    }
    switch ($action) {
        case 'edit':
            echo rateLevel($_POST, $db, $userPermissions, $accountID);
            break;
        default:
            echo json_encode(array("error" => "Invalid action specified."));
            break;
    }
}
function rateLevel($params, $db, $userPermissions, $accountID) {

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

    // Fix: add updated
    $fields[] = "rateDate = ?";
    $bindings[] = intval(time());

    // ------------- //
    if (isset($params['stars'])) {
        if ($isAdmin || in_array('rates', $userPermissions)) {
            $fields[] = "starStars = ?";
            $bindings[] = intval($params['stars']);
            
            $modActions[] = 'rate';

        } else {
            $missingPermissions[] = 'rates';
        }
    }

    if (isset($params['diff'])) {
        if ($isAdmin || in_array('ratedemons', $userPermissions) || in_array('ratedifficulty', $userPermissions)) {
            $diff = intval($params['diff']);
            if (in_array($diff, [0, 10, 20, 30, 40, 50])) {
                $fields[] = "starDifficulty = ?, starDemon = ?, starDemonDiff = ?, starAuto = ?";
                $bindings = array_merge($bindings, [$diff, 0, 0, 0]);
            } elseif ($diff == 49) {
                $fields[] = "starDifficulty = ?, starAuto = ?, starDemon = ?, starDemonDiff = ?";
                $bindings = array_merge($bindings, [50, 1, 0, 0]);
            } elseif (in_array($diff, [51, 54, 55, 56, 57])) {
                $demonDiff = $diff - 51;
                $fields[] = "starDifficulty = ?, starDemon = ?, starDemonDiff = ?, starAuto = ?";
                $bindings = array_merge($bindings, [50, 1, $demonDiff, 0]);
            } 
            
        } else {
            $missingPermissions[] = 'ratedemons or ratedifficulty';
        }
    }

    if (isset($params['coins'])) {
        $coins = intval($params['coins']);

        if ($coins >= 0 && $coins <= 1) {
            if ($isAdmin || in_array('coins', $userPermissions)) {
                $fields[] = "starCoins = ?";
                $bindings[] = $coins;
                
                $modActions[] = 'coin';

            } else {
                $missingPermissions[] = 'coins';
            }
        }
    }

    if (isset($params['feat'])) {
        $feat = intval($params['feat']);
        if ($feat >= 0 && $feat <= 1) {
            if ($isAdmin || in_array('featured', $userPermissions)) {
                $fields[] = "starFeatured = ?, starEpic = ?";
                $bindings[] = $feat;
                $bindings[] = 0;

                $modActions[] = 'featured';


            } else {
                $missingPermissions[] = 'featured';
            }
        } elseif ($feat >= 2 && $feat <= 99) {
            if ($isAdmin || in_array('epic', $userPermissions) || in_array('unepic', $userPermissions)) {
                $fields[] = "starEpic = ?, starFeatured = ?";
                $bindings[] = $feat - 1; 
                $bindings[] = 1;

                $modActions[] = 'epic';

            } else {
                $missingPermissions[] = 'epic or unepic';
            }
        }
    }

    if (empty($fields)) {
        return json_encode([
            "error" => true,
            "message" => "You do not have permission to access this API."
        ]);
    }


    $query .= implode(", ", $fields) . " WHERE levelID = ?";
    $bindings[] = $params['id'];

    $stmt = $db->prepare($query);
    $stmt->execute($bindings);

    if($stmt) {
        if (in_array('rate', $modActions)) setModAction(RATE_LEVEL, ['value' => $params['id'], 'value2' => intval($params['stars'])], $db, $accountID);

        if (in_array('coin', $modActions)) setModAction(CHANGE_COINS_LEVEL, ['value' => $params['id'], 'value2' => intval($params['coins'])], $db, $accountID);

        if (in_array('featured', $modActions)) setModAction(CHANGE_FEATURE_LEVEL, ['value' => $params['id'], 'value2' => $feat], $db, $accountID);

        if (in_array('epic', $modActions)) setModAction(CHANGE_EPIC_LEVEL, ['value' => $params['id'], 'value2' => intval($feat - 1)], $db, $accountID);
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