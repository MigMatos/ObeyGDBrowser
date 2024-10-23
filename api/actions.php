<?php 

define('RATE_LEVEL', 1);
define('CHANGE_FEATURE_LEVEL', 2);
define('CHANGE_COINS_LEVEL', 3);
define('CHANGE_EPIC_LEVEL', 4);
define('SET_DAILY', 5);
define('DELETE_LEVEL', 6);
define('CREATOR_CHANGE', 7);
define('RENAME_LEVEL', 8);
define('CHANGE_PASSWORD', 9);
define('DEMON_DIFFICULTY', 10);
define('SHARED_CP', 11);
define('CHANGE_PUBLISH_LEVEL', 12);
define('CHANGE_DESCRIPTION', 13);
define('CHANGE_LDM_TOGGLE', 14);
define('LEADERBOARD_BAN', 15);
define('CHANGE_SONG_ID', 16);
define('CREATE_MAP_PACK', 17);
define('CREATE_GAUNTLET', 18);
define('CHANGE_SONG', 19);
define('GRANT_MODERATOR', 20);
define('CHANGE_MAP_PACK', 21);
define('CHANGE_GAUNTLET', 22);
define('CHANGE_QUEST', 23);
define('REASSIGN_PLAYER', 24);
define('CREATE_QUEST', 25);
define('CHANGE_USERNAME_PASSWORD', 26);
define('CHANGE_SFX', 27);
define('BAN_PERSON', 28);
define('LOCK_LEVEL_UPDATING', 29);
define('RATE_LIST', 30);
define('SEND_LIST', 31);
define('CHANGE_FEATURE_LIST', 32);
define('CHANGE_PUBLISH_LIST', 33);
define('DELETE_LIST', 34);
define('CHANGE_LIST_CREATOR', 35);
define('CHANGE_LIST_NAME', 36);
define('CHANGE_LIST_DESCRIPTION', 37);
define('LOCK_LEVEL_COMMENTING', 38);
define('LOCK_LIST_COMMENTING', 39);
define('REMOVE_SENT_LEVEL', 40);
define('SUGGEST_LEVEL', 41);

// ObeyGDBrowser Actions

define('DELETE_GAUNTLET', 1042);
define('DELETE_MAP_PACK', 1043);



/**
 * setModAction - Logs a moderator action into the "modactions" table.
 * 
 * @param string $type - **Required**. The type of moderator action (must match a predefined constant, e.g., RATE_LEVEL).
 * 
 * @param array $params Array of parameters that define the moderator's action. Must include the following:
 * 
 * - 'value' (string, max: 255) - **Required**. The primary value of the action, this depends on the type of action.
 * - 'value2' (string, max: 255) - **Optional**. Secondary value for the action, if applicable.
 * - 'value3' (int) - **Optional**. A third optional value, typically a related numeric field.
 * - 'value4' (string) - **Auto-filled** set to "ObeyGDBrowser" by default.
 * - 'value5' (int) - **Optional**. Fifth optional numeric value.
 * - 'value6' (int) - **Optional**. Sixth optional numeric value.
 * - 'value7' (string, max: 255) - **Optional**. 7 value for the action, if applicable.
 * 
 * Example usage:
 * ```php
 * $params = [
 *     'type' => RATE_LEVEL,
 *     'value' => 'Level123',
 *     'account' => 456,
 *     'value2' => 'Optional extra info',
 * ];
 * setModAction($params);
 * ```
 */
function setModAction($type, $params, $db, $accountID) {

    if (!$type || !defined($type)) {
        return json_encode([
            'error' => true,
            'message' => 'Invalid or missing moderator action type.'
        ]);
    }

    $query = "INSERT INTO modactions (type, value, timestamp, value2, value3, value4, value5, value6, value7, account) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $bindings = [
        constant($type),                 
        substr(strval($params['value'] ?? ''), 0, 255),
        intval(time()),                          
        substr(strval($params['value2'] ?? ''), 0, 255),
        intval($params['value3'] ?? 0),
        substr(strval($params['value4'] ?? 'ObeyGDBrowser'), 0, 255),
        intval($params['value5'] ?? 0),
        intval($params['value6'] ?? 0),
        substr(strval($params['value7'] ?? ''), 0, 255),
        substr(strval($accountID ?? ''), 0, 255) 
    ];

    $stmt = $db->prepare($query);
    if ($stmt->execute($bindings)) {
        return json_encode([
            'error' => false,
            'message' => 'Moderator action successfully saved.'
        ]);
    } else {
        return json_encode([
            'error' => true,
            'message' => 'Failed to save moderator action: ' . strval($stmt->errorInfo()[2])
        ]);
    }
}

function getModActionsSince($params, $db) {
    try {

        if (!isset($params['timestamp']) || !is_numeric($params['timestamp'])) {
            return json_encode(['error' => true, 'message' => 'Invalid or missing timestamp parameter.']);
        }

        $timestamp = intval($params['timestamp']);


        $query = "SELECT * FROM modactions WHERE timestamp >= :timestamp";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':timestamp', $timestamp, PDO::PARAM_INT);
        $stmt->execute();


        $modActions = $stmt->fetchAll(PDO::FETCH_ASSOC);


        return json_encode([
            'error' => false,
            'modActions' => $modActions
        ]);

    } catch (PDOException $e) {
        return json_encode([
            'error' => true,
            'message' => 'SQL Error: ' . $e->getMessage()
        ]);
    }
}

?>