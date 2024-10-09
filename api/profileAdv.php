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
        case 'discord':
            echo updateDiscordInfo($logged, $accountID, $db, $_POST);
            break;
        case 'sociallinks':
                echo updateSocialMedia($logged, $accountID, $db, $_POST);
                break;
        case 'socialsettings':
                echo updateSocialSettings($logged, $accountID, $db, $_POST);
                break;
        default:
            echo json_encode(array("error" => "Invalid action specified."));
            break;
    }
}
function updateDiscordInfo($logged, $accountID, $db, $params) {
    if (!$logged) {
        return json_encode([
            "error" => true,
            "message" => "User not logged in"
        ]);
    }

    $fields = [];
    $bindings = [];

    if (isset($params['id'])) {
        $fields[] = "discordID = ?";
        $bindings[] = intval($params['id']);
    }

    $discordLinkReq = isset($params['discordLinkReq']) && intval($params['discordLinkReq']) === 1 ? 1 : 0;
    $fields[] = "discordLinkReq = ?";
    $bindings[] = $discordLinkReq;

    if (empty($fields)) {
        return json_encode([
            "error" => true,
            "message" => "No valid fields to update"
        ]);
    }

    $sql = "UPDATE accounts SET " . implode(", ", $fields) . " WHERE accountID = ?";
    $bindings[] = $accountID;

    try {
        $stmt = $db->prepare($sql);
        $stmt->execute($bindings);

        return json_encode([
            "error" => false,
            "message" => "Discord information updated successfully"
        ]);
    } catch (PDOException $e) {
        return json_encode([
            "error" => true,
            "message" => "Error updating Discord information: " . $e->getMessage()
        ]);
    }
}

function updateSocialMedia($logged, $accountID, $db, $params) {
    if (!$logged || empty(strval($accountID))) {
        return json_encode([
            "error" => true,
            "message" => "User not logged in"
        ]);
    }

    $fields = [];
    $bindings = [];

    if (isset($params['youtube'])) {
        $youtube = htmlspecialchars(strval($params['youtube']), ENT_QUOTES, 'UTF-8');
        $fields[] = "youtubeurl = ?";
        $bindings[] = $youtube;
    }

    if (isset($params['twitter'])) {
        $twitter = htmlspecialchars(strval($params['twitter']), ENT_QUOTES, 'UTF-8');
        $fields[] = "twitter = ?";
        $bindings[] = $twitter;
    }

    if (isset($params['twitch'])) {
        $twitch = htmlspecialchars(strval($params['twitch']), ENT_QUOTES, 'UTF-8');
        $fields[] = "twitch = ?";
        $bindings[] = $twitch;
    }

    if (empty($fields)) {
        return json_encode([
            "error" => true,
            "message" => "No valid social links fields to update"
        ]);
    }

    $sql = "UPDATE accounts SET " . implode(", ", $fields) . " WHERE accountID = ?";
    $bindings[] = $accountID;

    try {
        $stmt = $db->prepare($sql);
        $stmt->execute($bindings);

        return json_encode([
            "error" => false,
            "message" => "Social links information updated successfully"
        ]);
    } catch (PDOException $e) {
        return json_encode([
            "error" => true,
            "message" => "Error updating social links information: " . $e->getMessage()
        ]);
    }
}

function updateSocialSettings($logged, $accountID, $db, $params) {
    if (!$logged || empty(strval($accountID))) {
        return json_encode([
            'error' => true,
            'message' => 'User is not logged in or invalid accountID.'
        ]);
    }

    function SocialRes($value, $type) {
        return ($type === 'requests') ? (($value == 0 || $value == 1) ? intval($value) : null)
               : (($value >= 0 && $value <= 2) ? intval($value) : null);
    }

    $fields = [];
    $bindings = [];
    $updatedFields = [];

    foreach (['requests' => 'Friend requests', 'messages' => 'Messages', 'history' => 'Comments history'] as $key => $label) {
        if (isset($params[$key])) {
            $val = SocialRes($params[$key], $key);
            if ($val !== null) {
                $fields[] = ($key === 'requests' ? "frS" : ($key === 'messages' ? "mS" : "cS")) . " = ?";
                $bindings[] = $val;
                $updatedFields[] = $label;
            }
        }
    }

    if (empty($fields)) {
        return json_encode([
            'error' => true,
            'message' => 'None value to update.'
        ]);
    }

    $query = "UPDATE accounts SET " . implode(", ", $fields) . " WHERE accountID = ?";
    $bindings[] = strval($accountID);

    $stmt = $db->prepare($query);
    if ($stmt->execute($bindings)) {
        $message = count($updatedFields) == 1 ? $updatedFields[0] . " has been updated successfully."
                   : (count($updatedFields) == 2 ? implode(" and ", $updatedFields) . " have been updated successfully."
                   : "Social settings have been updated successfully.");

        return json_encode([
            'error' => false,
            'message' => $message
        ]);
    } else {
        return json_encode([
            'error' => true,
            'message' => 'Failed to update account settings: ' . strval($stmt->errorInfo()[2])
        ]);
    }
}


?>