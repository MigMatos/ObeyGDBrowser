<?php

// Prevter Thumbnails https://levelthumbs.prevter.me/api-docs/openapi.json

require_once __DIR__ . '/thumbnails.php';

function sendThumbnailError($error) {
    $_status = $error instanceof ThumbnailError ? $error->httpStatus : 503;
    http_response_code($_status);
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store');
    header('X-Content-Type-Options: nosniff');
    echo json_encode(array(
        'apiStatus' => 'unstable',
        'status' => $_status,
        'code' => $error instanceof ThumbnailError ? $error->errorCode : 'SERVICE_UNAVAILABLE',
        'error' => $error instanceof ThumbnailError ? $error->getMessage() : 'Thumbnails are unavailable. Ask the server owner to check the thumbnail setup.'
    ), JSON_INVALID_UTF8_SUBSTITUTE);
}

function sendThumbnailImage($bytes, $format, $private = false) {
    header('Content-Type: image/' . $format);
    header('X-Content-Type-Options: nosniff');
    header('X-Thumbnail-API-Status: unstable');
    header('Content-Disposition: inline; filename="thumbnail.' . $format . '"');
    header('Cache-Control: ' . ($private ? 'private, no-store' : 'public, max-age=300, must-revalidate'));
    if (!$private) {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Expose-Headers: ETag, X-Thumbnail-API-Status');
        $_etag = '"' . hash('sha256', $bytes) . '"';
        header('ETag: ' . $_etag);
        if (trim($_SERVER['HTTP_IF_NONE_MATCH'] ?? '') === $_etag) {
            http_response_code(304);
            return;
        }
    }
    header('Content-Length: ' . strlen($bytes));
    if ($_SERVER['REQUEST_METHOD'] !== 'HEAD') {
        echo $bytes;
    }
}

function thumbnailRequestPath($params, $pathInfo, $defaultFormat) {
    $id = $params['id'] ?? '';
    $size = $params['size'] ?? 'full';
    $format = $params['format'] ?? $defaultFormat;
    if ($pathInfo !== '') {
        if (!preg_match('~^/([1-9][0-9]{0,9})(?:\.(png|webp))?(?:/(SMALL|FULL|HIGH)(?:\.(png|webp))?)?/?$~iD', $pathInfo, $_match)) {
            throw new ThumbnailError('INVALID_PATH', 'Use a level ID, optional .png/.webp and optional /SMALL.', 400);
        }
        $id = $_match[1];
        $size = $_match[3] ?? 'full';
        $format = !empty($_match[4]) ? strtolower($_match[4]) : (!empty($_match[2]) ? strtolower($_match[2]) : $defaultFormat);
    }
    if (!is_string($size) || !is_string($format) || !in_array(strtolower($size), array('small', 'full', 'high'), true) || !in_array(strtolower($format), array('png', 'webp'), true)) {
        throw new ThumbnailError('INVALID_IMAGE', 'Choose full or SMALL and PNG or WebP.', 400);
    }
    return array(thumbnailId($id), strtolower($size) === 'small' ? 'small' : 'full', strtolower($format));
}

function runThumbnailImageEndpoint($db, $settings) {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Expose-Headers: ETag, X-Thumbnail-API-Status');
    try {
        if (!in_array($_SERVER['REQUEST_METHOD'], array('GET', 'HEAD'), true)) {
            header('Allow: GET, HEAD');
            throw new ThumbnailError('METHOD_NOT_ALLOWED', 'Only GET and HEAD are supported.', 405);
        }
        $_options = getThumbnailSettings($settings);
        if (!$_options['enabled']) {
            throw new ThumbnailError('THUMBNAILS_DISABLED', 'Thumbnails are disabled.', 404);
        }
        $_parts = thumbnailRequestPath($_GET, $_SERVER['PATH_INFO'] ?? '', $_options['defaultFormat']);
        if (!$db) {
            throw new RuntimeException();
        }
        $_service = new BrowserThumbnails($db, array('accountID' => 0, 'isAdmin' => false, 'canModerate' => false));
        sendThumbnailImage($_service->image(...$_parts), $_parts[2]);
    } catch (Throwable $_error) {
        sendThumbnailError($_error);
    }
}

function runThumbnailManagementEndpoint($db, $settings) {
    header('Content-Type: application/json; charset=utf-8');
    header('X-Content-Type-Options: nosniff');
    header('Cache-Control: no-store');
    try {
        if (!in_array($_SERVER['REQUEST_METHOD'], array('GET', 'POST'), true)) {
            header('Allow: GET, POST');
            throw new ThumbnailError('METHOD_NOT_ALLOWED', 'Only GET and POST are supported.', 405);
        }
        if (!getThumbnailSettings($settings)['enabled']) {
            throw new ThumbnailError('THUMBNAILS_DISABLED', 'Thumbnails are disabled.', 404);
        }
        if (!$db) {
            throw new RuntimeException();
        }
        $_action = $_SERVER['REQUEST_METHOD'] === 'GET' ? ($_GET['action'] ?? 'session') : ($_POST['action'] ?? '');
        if ($_action === 'lookup' && $_SERVER['REQUEST_METHOD'] === 'GET') {
            header('Access-Control-Allow-Origin: *');
            $_service = new BrowserThumbnails($db, array());
            echo json_encode(array('apiStatus' => 'unstable', 'items' => $_service->lookup($_GET['ids'] ?? '')));
            return;
        }
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (empty($_SESSION['thumbnailToken'])) {
            $_SESSION['thumbnailToken'] = bin2hex(random_bytes(32));
        }
        $_session = $_SESSION;
        session_write_close();
        $_identity = thumbnailIdentity($db, $_session);
        if (!$_identity['accountID']) {
            throw new ThumbnailError('LOGIN_REQUIRED', 'Log in to manage thumbnails.', 401);
        }
        $_service = new BrowserThumbnails($db, $_identity);
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if ($_action === 'session') {
                $_result = array('accountID' => $_identity['accountID'], 'canModerate' => $_identity['canModerate'], 'isAdmin' => $_identity['isAdmin'], 'token' => $_session['thumbnailToken']);
            } elseif ($_action === 'list') {
                $_result = $_service->listing($_GET, ($_GET['scope'] ?? '') === 'moderation');
            } elseif ($_action === 'preview') {
                $_format = $_GET['format'] ?? 'webp';
                sendThumbnailImage($_service->image($_GET['id'] ?? '', $_GET['size'] ?? 'full', $_format, true, $_GET['revision'] ?? ''), $_format, true);
                return;
            } else {
                throw new ThumbnailError('INVALID_ACTION', 'Unknown thumbnail action.', 400);
            }
        } else {
            if (!is_string($_POST['token'] ?? null) || !hash_equals($_session['thumbnailToken'], $_POST['token'])) {
                throw new ThumbnailError('INVALID_TOKEN', 'Your form expired. Reload before continuing.', 403);
            }
            if ($_action === 'install') {
                if (!$_identity['isAdmin']) {
                    throw new ThumbnailError('OWNER_REQUIRED', 'Only the server owner can install thumbnail tables.', 403);
                }
                installThumbnailSchema($db);
                $_result = array('status' => 'installed');
            } elseif ($_action === 'submit') {
                thumbnailId($_POST['levelID'] ?? '');
                $_service->checkUploadBudget(empty($_POST['id']));
                $_file = $_FILES['image'] ?? array();
                if (($_file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK || !is_string($_file['tmp_name'] ?? null) || !is_uploaded_file($_file['tmp_name'])) {
                    throw new ThumbnailError('UPLOAD_FAILED', 'Attach one PNG or WebP image up to 5 MB.', 422);
                }
                if (filesize($_file['tmp_name']) > 5 * 1024 * 1024) {
                    throw new ThumbnailError('IMAGE_SIZE', 'The image exceeds 5 MB.', 413);
                }
                $_image = prepareThumbnailImage(file_get_contents($_file['tmp_name']), $_file['name'] ?? '');
                $_result = $_service->submit($_POST['levelID'], $_POST['revision'] ?? '', $_POST['id'] ?? '', $_image);
            } elseif ($_action === 'review') {
                if (!is_string($_POST['publishedID'] ?? null) || !preg_match('/^(?:0|[1-9][0-9]{0,9})$/D', $_POST['publishedID'])) {
                    throw new ThumbnailError('INVALID_REVIEW', 'Reload the current published thumbnail before approving.', 400);
                }
                $_result = $_service->review($_POST['id'] ?? '', $_POST['revision'] ?? '', $_POST['decision'] ?? '', $_POST['reason'] ?? '', $_POST['publishedID'], ($_POST['replace'] ?? '') === '1');
            } else {
                throw new ThumbnailError('INVALID_ACTION', 'Unknown thumbnail action.', 400);
            }
        }
        echo json_encode(array_merge(array('apiStatus' => 'unstable'), $_result), JSON_INVALID_UTF8_SUBSTITUTE);
    } catch (Throwable $_error) {
        sendThumbnailError($_error);
    }
}
