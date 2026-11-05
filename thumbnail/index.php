<?php

error_reporting(0);

require_once __DIR__ . '/../misc/thumbnail-http.php';

try {
    $_settings = readBrowserSettings();
    $_db = getThumbnailSettings($_settings)['enabled'] ? openSongDatabase($_settings) : null;
    runThumbnailImageEndpoint($_db, $_settings);
} catch (Throwable $_error) {
    sendThumbnailError($_error);
}
