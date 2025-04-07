<?php 
header('Access-Control-Allow-Methods: GET, POST');
// error_reporting(0);

include("../_init_.php");
include("./utils.php");

$file = basename(__FILE__);
$scriptFilename = basename($_SERVER['SCRIPT_NAME']);

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $file == $scriptFilename) {
    $params = $_GET;
    if (isset($_GET["rewards"])) {
        echo getVaultRewardsTypes();
        return;
    }
    echo getVaultCodes($params, $db);
    return;
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $file == $scriptFilename) {
    $action = $_POST['act'] ?? null;
    if (!in_array('admin', $userPermissions) && !in_array('vaultcodes', $userPermissions)) {
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
            echo deleteVaultCode($_POST, $db, $accountID);
            break;
        case 'edit':
            echo editVaultCode($_POST, $db, $accountID);
            break;
        case 'create':
            echo createVaultCode($_POST, $db, $accountID);
            break;
        default:
            echo json_encode(array("error" => "Invalid action specified."));
            break;
    }
} else {
    echo json_encode(array("error" => "Invalid request method or script filename mismatch."));
}

function getVaultCodes($params, $db) {
    $bindings = [];
    $sql = "SELECT * FROM vaultcodes ORDER BY rewardID ASC LIMIT 10 OFFSET ?";
    $page = isset($params['page']) ? intval($params['page']) : 0;
    $bindings[] = ($page <= 0) ? 0 : $page * 10;

    $stmt = $db->prepare($sql);
    foreach ($bindings as $key => $value) {
        $stmt->bindValue($key + 1, $value, PDO::PARAM_INT);
    }

    $stmt->execute();
    if ($stmt->rowCount() == 0) return json_encode([]);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $countStmt = $db->query("SELECT COUNT(*) FROM vaultcodes");
    $totalResults = $countStmt->fetchColumn();
    $totalPages = intval(ceil($totalResults / 10)) + 1;
    $results[0]["paginator"] = [$totalResults, $totalPages];

    $json_data = array_map(function ($result) {

        $level = [];

        if(isset($result["paginator"])) {
            $level["results"] = $result["paginator"][0];
            $level["pages"] = $result["paginator"][1];
        }

        $level = array_merge($level, [
            "id" => intval($result["rewardID"]),
            "code" => base64_decode(strval($result["code"])),
            "rewards" => strval($result["rewards"]),
            "rewardscount" => count(explode(",", $result["rewards"])),
            "duration" => intval($result["duration"]),
            "uses" => intval($result["uses"]),
            "timestamp" => intval($result["timestamp"]),
        ]);

        return $level;
    }, $results);

    return json_encode($json_data);
}

function getVaultRewardsTypes(){
    return json_encode(BrowserUtils::getRewards());
}

function deleteVaultCode($params, $db, $accountID) {
    $id = intval($params['rewardID'] ?? 0);
    if ($id <= 0) return json_encode(["error" => "Invalid ID."]);
    $timestamp = intval(time());

    $stmt = $db->prepare("DELETE FROM vaultcodes WHERE rewardID = ?");
    $stmt->bindValue(1, $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        setModAction(DELETE_VAULT_CODE, ['value' => $id, 'value5' => $timestamp], $db, $accountID);

        return json_encode(["success" => "true", "id" => $id]);
    } else {
        return json_encode(["success" => "false"]);
    }
}

function editVaultCode($params, $db, $accountID) {
    $id = intval($params['rewardID'] ?? 0);
    if ($id <= 0) return json_encode(["error" => "Invalid ID."]);

    $code = base64_encode(strval($params['code'] ?? ''));
    $rewards = strval($params['rewards'] ?? '');
    $duration = intval($params['duration'] ?? 0);
    $uses = intval($params['uses'] ?? -1);
    $timestamp = intval($params['timestamp'] ?? time());

    if (empty($code) || empty($rewards)) {
        return json_encode(["error" => "'code' and 'rewards' are required."]);
    }

    $sql = "UPDATE vaultcodes SET code = ?, rewards = ?, duration = ?, uses = ?, timestamp = ? WHERE rewardID = ?";
    $stmt = $db->prepare($sql);
    $bindings = [$code, $rewards, $duration, $uses, $timestamp, $id];

    foreach ($bindings as $k => $v) {
        $stmt->bindValue($k + 1, $v, is_int($v) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }

    if ($stmt->execute()) {

        setModAction(CHANGE_VAULT_CODE, ['value' => $id, 'value2' => $rewards, 'value3' => $duration, 'value5' => $timestamp], $db, $accountID);


        return json_encode(["success" => "true", "id" => $id]);
    } else {
        return json_encode(["success" => "false"]);
    }
}

function createVaultCode($params, $db, $accountID) {
    $code = base64_encode(strval($params['code'] ?? ''));
    $rewardsID = $params['rewardsid'] ?? [];
    $rewardsAmount = $params['rewardsamount'] ?? [];
    $duration = intval($params['expiredate'] ?? -1);
    $uses = intval($params['uses'] ?? -1);
    $timestamp = intval(time());
    $validRewards = [];
    $rewardString = "";
    
    if (empty($code) || !is_array($rewardsID) || !is_array($rewardsAmount) || $duration < -1 ) { return json_encode(["error" => "'code', 'rewardsID', 'rewardsAmount' and 'duration' are required."]); }
    if (count($rewardsID) !== count($rewardsAmount)) { return json_encode(["error" => "'rewardsID' and 'rewardsAmount' must have the same number of elements."]); }

    for ($i = 0; $i < count($rewardsID); $i++) {
        $id = intval($rewardsID[$i]);
        $amount = intval($rewardsAmount[$i]);
        if ($id > 0 && $amount > 0) { $validRewards[] = [$id, $amount]; }
    }

    $rewardString = implode(',', array_merge(...$validRewards));

    $sql = "INSERT INTO vaultcodes (code, rewards, duration, uses, timestamp) VALUES (?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $bindings = [$code, $rewardString, $duration, $uses, $timestamp];

    foreach ($bindings as $k => $v) {
        $stmt->bindValue($k + 1, $v, is_int($v) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }

    if ($stmt->execute()) {
        $id = $db->lastInsertId();

        setModAction(CREATE_VAULT_CODE, ['value' => $id, 'value2' => $rewardString, 'value3' => $duration, 'value5' => $timestamp], $db, $accountID);

        return json_encode(["success" => "true", "id" => $id]);
    } else {
        return json_encode(["success" => "false"]);
    }
}
?>
