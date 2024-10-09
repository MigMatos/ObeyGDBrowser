<?php 

define('RATE_LEVEL', 1);
define('FEATURE_LEVEL', 2);
define('UNVERIFY_COINS', 3);
define('EPIC_LEVEL', 4);
define('SET_DAILY', 5);
define('DELETE_LEVEL', 6);
define('CREATOR_CHANGE', 7);
define('RENAME_LEVEL', 8);
define('CHANGE_PASSWORD', 9);
define('DEMON_DIFFICULTY', 10);
define('SHARED_CP', 11);
define('PUBLISH_LEVEL', 12);
define('CHANGE_DESCRIPTION', 13);
define('LDM_TOGGLE', 14);
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
define('FEATURE_LIST', 32);
define('PUBLISH_LIST', 33);
define('DELETE_LIST', 34);
define('CHANGE_LIST_CREATOR', 35);
define('CHANGE_LIST_NAME', 36);
define('CHANGE_LIST_DESCRIPTION', 37);
define('LOCK_LEVEL_COMMENTING', 38);
define('LOCK_LIST_COMMENTING', 39);
define('REMOVE_SENT_LEVEL', 40);
define('SUGGEST_LEVEL', 41);

/**
 * setModAction - Logs a moderator action into the "modactions" table.
 * 
 * @param array $params Array of parameters that define the moderator's action. Must include the following:
 * 
 * - 'type' (string) - **Required**. The type of moderator action (must match a predefined constant, e.g., RATE_LEVEL).
 * - 'value' (string, max: 255) - **Required**. The primary value of the action, this depends on the type of action.
 * - 'value2' (string, max: 255) - **Optional**. Secondary value for the action, if applicable.
 * - 'value3' (int) - **Optional**. A third optional value, typically a related numeric field.
 * - 'value4' (string, fixed: "ObeyGDBrowser") - **Auto-filled**. Always set to "ObeyGDBrowser" by default.
 * - 'value5' (int) - **Optional**. Fifth optional numeric value.
 * - 'value6' (int) - **Optional**. Sixth optional numeric value.
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
function setModAction($params, $db, $accountID) {

    $type = $params['type'] ?? null;
    if (!$type || !defined($type)) {
        return json_encode([
            'error' => true,
            'message' => 'Invalid or missing moderator action type.'
        ]);
    }

    $query = "INSERT INTO modactions (type, value, timestamp, value2, value3, value4, value5, value6, account) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $bindings = [
        constant($type),                 
        strval($params['value']),        
        time(),                          
        strval($params['value2'] ?? null),
        intval($params['value3'] ?? null),
        strval($params['value4'] ?? 'ObeyGDBrowser'),           
        intval($params['value5'] ?? null),
        intval($params['value6'] ?? null),
        intval($accountID)                
    ];

    $stmt = $db->prepare($query);
    if ($stmt->execute($bindings)) {
        return json_encode([
            'error' => false,
            'message' => 'Moderator action successfully recorded.'
        ]);
    } else {
        return json_encode([
            'error' => true,
            'message' => 'Failed to record moderator action: ' . strval($stmt->errorInfo()[2])
        ]);
    }
}

?>