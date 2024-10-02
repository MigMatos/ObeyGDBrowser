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
    if (!$logged) {
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
            "message" => "No valid social media fields to update"
        ]);
    }

    $sql = "UPDATE accounts SET " . implode(", ", $fields) . " WHERE accountID = ?";
    $bindings[] = $accountID;

    try {
        $stmt = $db->prepare($sql);
        $stmt->execute($bindings);

        return json_encode([
            "error" => false,
            "message" => "Social media information updated successfully"
        ]);
    } catch (PDOException $e) {
        return json_encode([
            "error" => true,
            "message" => "Error updating social media information: " . $e->getMessage()
        ]);
    }
}


?>