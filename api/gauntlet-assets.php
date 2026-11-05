<?php

require_once __DIR__ . '/../misc/gauntlet-settings.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache');
header('X-Content-Type-Options: nosniff');

try {
    echo json_encode(getPublicGauntletSettings(), JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
} catch (Throwable $_error) {
    http_response_code(503);
    echo json_encode(array('error' => 'Gauntlet assets are unavailable.'));
}
