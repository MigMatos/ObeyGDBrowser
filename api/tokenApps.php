<?php

$file = basename(__FILE__);
$scriptFilename = basename($_SERVER['SCRIPT_NAME']);

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $file == $scriptFilename) {
    include_once("../_init_.php");
    
    $params = $_GET;
    echo getTokenApps($params, $db);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $file == $scriptFilename) {
    include_once("../_init_.php");
    include('./utils.php');
    $action = $_POST['act'] ?? null;

    if (!in_array('admin', $userPermissions) && !in_array('ogdwCreateTokenApp', $userPermissions)) {
        echo json_encode(array("error" => "You do not have permission to access this API."));
        exit(401);
    }
    if (!$action) {
        echo json_encode(array("error" => "Please provide an action parameter in the POST request."));
        exit;
    }

    $params = $_POST;

    include('actions.php');

    switch ($action) {
        case 'delete':
            echo deleteTokenApp($_POST, $db);
            break;

        case 'edit':
            echo editTokenApp($_POST, $db);
            break;

        case 'create':
            echo createTokenApp($params, $db);
            break;

        case 'regenerate':
            echo regenToken($params, $db);
            break;

        case 'refresh':
            $params["page"] = 0;
            $params["id"] = isset($params['id']) ? intval($params['id']) : 0;
            echo getTokenApps($params, $db);
            break;

        default:
            echo json_encode(array("success" => "false","error" => "Invalid action specified."));
            break;
    }
}


function getTokenApps($params, $db) {
    $id = isset($params['id']) ? intval($params['id']) : null;
    $order = "ID ASC";

    if ($id !== null && $id <= 0) {
        return json_encode(array("error" => "Invalid ID."));
    }

    $sql = "SELECT t.id, t.nameApp, t.imageURLApp, t.developer, t.nameTokenApp, t.alive, t.accountID, t.registerDate, t.expireDate, u.userName FROM tokenapp t LEFT JOIN users u ON t.accountID = u.extID";
    $bindings = [];



    if ($id !== null && is_numeric($id)) {
        $paramsSql[] = "id = ?";
        $bindings[] = $id;
    }

    if(!empty($paramsSql) ) $sql .= " WHERE (" . implode(" ) AND ( ", $paramsSql) . ")";

    $sql .= " LIMIT 10 OFFSET ? ";
    if(!isset($params['page'])) { $params['page'] = intval($params['page']); }
    $bindings[] = ($params['page'] <= 0) ? 0 : $params['page'] * 10;

    

    $stmt = $db->prepare($sql);

    foreach ($bindings as $key => $value) {
        $stmt->bindValue($key + 1, $value, PDO::PARAM_INT);
    }

    $stmt->execute();

    if($stmt->rowCount() == 0) return json_encode([]);
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //--- Results and pages counter ---//
    $sql = "SELECT COUNT(*) FROM tokenapp ";
    if(!empty($paramsSql) ) $sql .= " WHERE (" . implode(" ) AND ( ", $paramsSql) . ")";
    if ($order) $sql .= " ORDER BY $order";
    array_pop($bindings);
    $stmt = $db->prepare($sql);
    foreach ($bindings as $key => $value) { $stmt->bindValue($key + 1, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR); }
    $stmt->execute();
    $resultsTotal[] = $stmt->fetchColumn();
    $resultsTotal[] = intval(ceil($resultsTotal[0] / 3));
    $results[0]["paginator"] = $resultsTotal;
    // --- //

    
    $json_data = array_map(function ($result) {

        $level = [];
        
        

        if(isset($result["paginator"])) {
            $level["results"] = $result["paginator"][0];
            $level["pages"] = $result["paginator"][1];
        }
        $level = array_merge($level, [
            "id" => intval($result["id"]),
            "nameApp" => strval($result["nameApp"]),
            "imageURLApp" => strval($result["imageURLApp"]),
            "requester" => ["accountID" => intval($result["accountID"]), "userName" => strval($result["userName"])],
            "developer" => strval($result["developer"]),
            "registerDate" => intval($result["registerDate"]),
            "expireDate" => intval($result["expireDate"]),
            "isAlive" => intval($result["alive"]),
            "nameRGApp" => strval($result["nameTokenApp"]),
        ]);


        return $level;
    }, $results);

    return json_encode($json_data);
}

function createTokenApp($params, $db) {
    $nameApp = substr(preg_replace('/[^a-zA-Z0-9 ]/', '', strval($params['nameApp'] ?? '')), 0, 100);
    $accountID = intval($params['accountID'] ?? 0);
    $registerDate = time();
    $expireDate = intval($params['expireDate'] ?? -1);
    $token = strval($params['token'] ?? '');
    

    if (empty($nameApp) || strlen($nameApp) <= 2 || empty($token) || $accountID <= 0) {
        return json_encode(array("sucess" => "false", "error" => "'nameApp', 'token' and 'accountID' are mandatory. when data is $nameApp - $token - $accountID"));
    }

    $nameTokenApp = "APP" . strtoupper(substr($nameApp, random_int(0, strlen($nameApp)-1),5)) . random_int(10, 99) . BrowserUtils::genToken(2,"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopeqrstuvwxyz0123456789_");
    $token = BrowserUtils::genToken(26) . BrowserUtils::genToken(6, $token);
    $token_hashed = password_hash($token, PASSWORD_BCRYPT);

    $sql = "INSERT INTO tokenapp (nameApp, accountID, registerDate, expireDate, nameTokenApp, token) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $bindings = [$nameApp, $accountID, $registerDate, $expireDate, $nameTokenApp, $token_hashed];

    $stmt = $db->prepare($sql);

    foreach ($bindings as $key => $value) {
        $stmt->bindValue($key + 1, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }

    if ($stmt->execute()) {
        $newId = $db->lastInsertId();
        return json_encode(array("sucess" => "true", "ID" => $newId, "nameApp" => $nameTokenApp, "token" => $token));
    } else {
        return json_encode(array("sucess" => "false", "error" => "Failed to create DevApp."));
    }
}

function editTokenApp($params, $db) {
    $id = intval($params['id'] ?? 0);
    $nameApp = strval($params['nameApp'] ?? '');
    $expireDate = intval($params['expireDate'] ?? -1);


    if ($id <= 0 && (empty($nameApp) && empty($expireDate))) {
        return json_encode(array("success" => "false","error" => "'id' are mandatory or empty form."));
    }

    $bindings = [];
    $fields = [];

    if(!empty($nameApp)){
        $fields[] = "nameApp = ?";
        $bindings[] = $nameApp;
    }
    if(!empty($expireDate)){
        $fields[] = "expireDate = ?";
        $bindings[] = $expireDate;
    }

    $bindings[] = $id;
    
    $sql = "UPDATE tokenapp SET " . implode(", ", $fields) . " WHERE id = ?";

    $stmt = $db->prepare($sql);

    foreach ($bindings as $key => $value) {
        $stmt->bindValue($key + 1, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }

    if ($stmt->execute()) {
        return json_encode(array("success" => "true", "ID" => $id));
    } else {
        return json_encode(array("success" => "false","error" => "Failed to update TokenApp."));
    }
}

function deleteTokenApp($params, $db) {
    $id = intval($params['id'] ?? 0);

    if ($id <= 0) {
        return json_encode(array("success" => "false","error" => "Invalid ID."));
    }

    $sql = "DELETE FROM tokenapp WHERE id = ?";
    $bindings = [$id];

    $stmt = $db->prepare($sql);

    foreach ($bindings as $key => $value) {
        $stmt->bindValue($key + 1, $value, PDO::PARAM_INT);
    }

    if ($stmt->execute()) {
        return json_encode(array("success" => "true", "ID" => $id));
    } else {
        return json_encode(array("success" => "false","error" => "Failed to delete TokenApp."));
    }
}

function regenToken($params, $db) {
    $id = intval($params['id'] ?? 0);
    $token = strval($params['token'] ?? 0);

    if (empty($token) || $id <= 0) {
        return json_encode(array("sucess" => "false", "error" => "'id' and 'token' are mandatory."));
    }
    $token = BrowserUtils::genToken(26) . BrowserUtils::genToken(6, $token);
    $token_hashed = password_hash($token, PASSWORD_BCRYPT);

    $bindings = [$token_hashed , $id];
    $sql = "UPDATE tokenapp SET token = ?, alive = 0 WHERE id = ?";

    $stmt = $db->prepare($sql);

    foreach ($bindings as $key => $value) {
        $stmt->bindValue($key + 1, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }

    if ($stmt->execute()) {
        return json_encode(array("success" => "true", "ID" => $id, "token" => $token));
    } else {
        return json_encode(array("success" => "false", "error" => "Failed to update devApptoken."));
    }
}

function verifyApp($extraData, $token, $hashedToken, $db) {
    if($_SERVER['REQUEST_METHOD'] !== 'POST') return false;
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
    $activate = intval($_POST['activate'] ?? 0);
    $nameApp = strval($_POST['nameApp'] ?? '');
    $nameDev = strval($_POST['developerName'] ?? '');
    $imageURLApp = strval($_POST['imageURLApp'] ?? '');
    $sucessVerify = true;

    if ($activate != 0 && empty($nameDev) && empty($nameApp)) {
        $sucessVerify = false;
    } 
    if (!password_verify($token, $hashedToken)) {
        $sucessVerify = false;
    }

    $bindings = [];
    $fields = [];

    if($sucessVerify) {    
        $fields[] = "developer = ?";
        $bindings[] = $nameDev;
        if(!empty($nameApp)){
            $fields[] = "nameApp = ?";
            $bindings[] = $nameApp;
        }
        if(!empty($imageURLApp)){
            $fields[] = "imageURLApp = ?";
            $bindings[] = $imageURLApp;
        }
        $bindings[] = $activate;
    } else {
        $bindings[] = intval($extraData['alive']) - 1;
        $extraData['alive'] = intval($extraData['alive']) - 1;
    }

    $fields[] = "alive = ?";

    if(intval($extraData['alive']) <= -3) {
        $fields[] = "token = ?";
        $bindings[] = "INVALID_TOKEN";
    }

    
    $bindings[] = intval($extraData['id']);
    
    $sql = "UPDATE tokenapp SET " . implode(", ", $fields) . " WHERE id = ?";

    $stmt = $db->prepare($sql);

    foreach ($bindings as $key => $value) {
        $stmt->bindValue($key + 1, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }

    if ($stmt->execute()) {
        if($sucessVerify) exit(json_encode(array("sucess" => "true", "info" => "Congratulations, your application has been activated!")));
        else {
            if(intval($extraData['alive']) <= -3) exit(json_encode(array("sucess" => "false", "info" => "The token has been invalidated, please generate a new token to activate your application.")));
            else exit(json_encode(array("sucess" => "false", "info" => "Incorrect information when trying to activate this application.")));
        }
    } else {
        exit(json_encode(array("sucess" => "false", "info" => "An SQL error occurred while trying to run the application check.")));
    }
}

function verifyToken($nameTokenApp, $token, $db) {
    $sql = "SELECT id,token,alive,accountID FROM tokenapp WHERE nameTokenApp = ?";
    $bindings = [$nameTokenApp];
    $stmt = $db->prepare($sql);
    foreach ($bindings as $key => $value) {$stmt->bindValue($key + 1, $value, PDO::PARAM_INT);}
    if ($stmt->execute()) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {return false;}
        $hashedToken = $result['token'];
        if(intval($result['alive']) <= 0) {
            verifyApp($result, $token, $hashedToken, $db);
        }
        if (password_verify($token, $hashedToken)) {return $result['accountID'];} else {return false;}
    } else {return false;}
}

function checkOGDWDevApp($db) {
    global $_CUSTOM_HEADERS;
    $appName = $_CUSTOM_HEADERS['OGDW_APPNAME'] ?? null;
    $appToken = $_CUSTOM_HEADERS['OGDW_APPTOKEN'] ?? null;

    if (!$appToken && !$appName) return false;
    $accID = verifyToken($appName, $appToken, $db);
    if(!$accID) return false;
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET');
    header("Access-Control-Allow-Headers: X-Requested-With");
    include_once("../api/roles.php");
    
    $params = ["accountid" => $accID];
    $response = getRoles($params, $db, $gdps_settings);
    $resultroles = json_decode($response, true);
    
    $_SESSION['isAdmin'] = $resultroles['user']['isAdmin'] ?? 0;
    if($_SESSION['isAdmin'] == "1" || $_SESSION['isAdmin'] == 1) $resultroles['permissions'][] = "admin";
    updateUserPerms($resultroles['permissions'] ?? []);

    return true;
}

?>