<?php

require_once __DIR__ . '/../misc/songs.php';
error_reporting(0);

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-store');
header('Access-Control-Allow-Methods: GET');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Allow: GET');
    http_response_code(405);
    echo json_encode(array('error' => 'Only GET is supported.', 'apiStatus' => 'unstable'));
    exit;
}

try {
    $_settings = readBrowserSettings();
    $_type = $_GET['type'] ?? 'custom';
    $_isCatalog = $_type === 'official' && isset($_GET['list']);
    if (!is_string($_type) || !in_array($_type, array('official', 'custom', 'library'), true) || (!$_isCatalog && normalizeBrowserSongId($_GET['id'] ?? ($_GET['songID'] ?? null)) === null)) {
        throw new InvalidArgumentException('Provide a positive song ID and type official, custom or library.');
    }
    $_db = $_type === 'custom' ? openSongDatabase($_settings) : null;
    $_result = getBrowserSongResponse($_GET, $_db, $_settings);
    $_status = $_result['status'] ?? 'found';
    http_response_code($_status === 'invalid_id' ? 400 : ($_status === 'source_unavailable' ? 503 : ($_status === 'not_found' ? 404 : 200)));
    echo json_encode($_result, JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
} catch (InvalidArgumentException $_error) {
    http_response_code(400);
    echo json_encode(array('error' => $_error->getMessage(), 'apiStatus' => 'unstable'));
} catch (Throwable $_error) {
    http_response_code(503);
    echo json_encode(array('error' => 'Song information is unavailable.', 'apiStatus' => 'unstable'));
}
