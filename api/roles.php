<?php 
header('Access-Control-Allow-Methods: GET');

error_reporting(0);

$file = basename(__FILE__);
$scriptFilename = basename($_SERVER['SCRIPT_NAME']);

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $file == $scriptFilename) {
    include("../_init_.php");
    $params = $_GET;

    if (!empty($params)) {
        $results = getAccountMaxRole($params, $db, $gdps_settings);
        echo $results;
    } else {
        echo json_encode(array("error" => "Please provide at least one search parameter in the GET request."));
    }
}



// PARAMS
// username = userName
// page = page
// accountID = extID
// userID = userID

function getAccountMaxRole($params, $db, $gdps_settings) {
    $bindings = [];
    $paramsSql = [];
    $order = "timestamp ASC";


    $accountID = strval($params["accountid"]); 
    $query = "
        SELECT r.*, acc.isAdmin, acc.userName, acc.accountID
        FROM roleassign AS ra
        JOIN roles AS r ON ra.roleID = r.roleID
        JOIN accounts AS acc ON acc.accountID = ra.accountID 
        WHERE ra.accountID = :accountID
        AND r.priority = (
            SELECT MAX(r2.priority)
            FROM roleassign AS ra2
            JOIN roles AS r2 ON ra2.roleID = r2.roleID
            WHERE ra2.accountID = ra.accountID
        );
    ";

    $stmt = $db->prepare($query);
    $stmt->execute([':accountID' => $accountID]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
    // remove columns
    $resultPermissions = array_values(array_diff(array_keys($result), ['roleID', 'priority', 'roleName', 'isDefault', 'commentColor', 'modBadgeLevel', 'userName', 'accountID']));


    $roleInfo = [
        'roleID' => $result['roleID'],
        'roleName' => $result['roleName'],
        'roleColor' => $result['commentColor'],
        'badge' => $result['modBadgeLevel'],
        'isDefault' => $result['isDefault'],
    ];

    $userInfo = [
        'userName' => $result['userName'],
        'accountID' => $result['accountID'],
        'isAdmin' => $result['isAdmin']
    ];


    $finalResult = [
        'permissions' => $resultPermissions,
        'role' => $roleInfo,
        'user' => $userInfo,
    ];



    return json_encode($finalResult, JSON_UNESCAPED_UNICODE);

} else {
    return json_encode(array(), JSON_UNESCAPED_UNICODE);
}
}

?>