<?php


error_reporting(0);

$file = str_replace("\\", "/", __FILE__);
$scriptFilename = str_replace("\\", "/", $_SERVER['SCRIPT_FILENAME']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $file == $scriptFilename) {
    include("../_init_.php");
    $action = $_POST['act'] ?? null;
    if (!$action) {
        echo json_encode(array("error" => "Please provide an action parameter in the POST request."));
        exit;
    }
    switch ($action) {
        case 'edit':
            echo rateLevel($_POST, $db, $userPermissions);
            break;
        default:
            echo json_encode(array("error" => "Invalid action specified."));
            break;
    }
}
function rateLevel($params, $db, $userPermissions) {

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

    // Fix: add updated
    $fields[] = "rateDate = ?";
    $bindings[] = intval(time());

    // ------------- //
    if (isset($params['stars'])) {
        if ($isAdmin || in_array('rates', $userPermissions)) {
            $fields[] = "starStars = ?";
            $bindings[] = intval($params['stars']);
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
            } else {
                $missingPermissions[] = 'featured';
            }
        } elseif ($feat >= 2 && $feat <= 99) {
            if ($isAdmin || in_array('epic', $userPermissions) || in_array('unepic', $userPermissions)) {
                $fields[] = "starEpic = ?, starFeatured = ?";
                $bindings[] = $feat - 1; 
                $bindings[] = 1;
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