<?php

function getPath() {
    $_browserRoot = str_replace('\\', '/', realpath(__DIR__ . '/../..'));
    $_scriptFile = realpath($_SERVER['SCRIPT_FILENAME'] ?? '');
    if ($_scriptFile) {
        $_folder = str_replace('\\', '/', dirname($_scriptFile));
        if ($_folder === $_browserRoot) {
            return './';
        }
        if (strpos($_folder, $_browserRoot . '/') === 0) {
            $_relative = substr($_folder, strlen($_browserRoot) + 1);
            return str_repeat('../', substr_count($_relative, '/') + 1);
        }
    }
    return defined('BASE_PATH') ? BASE_PATH : './';
}

global $baseURL;
$baseURL = getPath();
