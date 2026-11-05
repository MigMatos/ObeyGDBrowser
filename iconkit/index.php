<?php

require_once __DIR__ . '/../misc/icon-settings.php';

try {
    $iconSettings = getPublicIconSettings();
    if (!$iconSettings['iconkit']['enabled']) {
        http_response_code(404);
        exit('Icon Kit is disabled.');
    }
} catch (Throwable $_error) {
    http_response_code(503);
    exit('Icon Kit is unavailable.');
}

$sessionInfo = null;
if (session_status() === PHP_SESSION_NONE && !empty($_COOKIE[session_name()])) {
    session_start(array('read_and_close' => true));
}
if (isset($_SESSION['userName'], $_SESSION['accountID'], $_SESSION['userID']) && intval($_SESSION['accountID']) > 0 && intval($_SESSION['userID']) > 0) {
    $sessionInfo = array(
        'username' => strval($_SESSION['userName']),
        'accountID' => intval($_SESSION['accountID'])
    );
}

header('Cache-Control: private, no-store');
$template = file_get_contents(__DIR__ . '/t.html');
echo str_replace('[[ICONKITSESSION]]', json_encode($sessionInfo, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT), $template);
