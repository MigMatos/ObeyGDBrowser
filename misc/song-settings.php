<?php

require_once __DIR__ . '/icon-settings.php';

function normalizeSongPath($value, $extensions) {
    if (!is_string($value) || strlen($value) > 1000 || strpos($value, "\0") !== false) {
        throw new InvalidArgumentException('Invalid song source path.');
    }
    $path = trim(str_replace('\\', '/', $value));
    if ($path !== '' && (preg_match('~^[a-z][a-z0-9+.-]*://~i', $path) || strpos($path, '//') === 0 || !in_array(strtolower(pathinfo($path, PATHINFO_EXTENSION)), $extensions, true))) {
        throw new InvalidArgumentException('Song sources must use local files with the expected extension.');
    }
    return $path;
}

function resolveSongPath($path, $relativeToApi = false) {
    if ($path === '') {
        return '';
    }
    if ($path[0] === '/' || preg_match('~^[a-zA-Z]:/~', $path)) {
        return $path;
    }
    return __DIR__ . ($relativeToApi ? '/../api/' : '/../') . $path;
}

function getSongSettings($settings) {
    $_settings = $settings['songs'] ?? array();
    return array(
        'libraryEnabled' => isIconOptionEnabled($_settings['libraryEnabled'] ?? true),
        'libraryPath' => normalizeSongPath($_settings['libraryPath'] ?? 'music/ids.json', array('json', 'dat')),
        'libraryConfigPath' => normalizeSongPath($_settings['libraryConfigPath'] ?? 'config/dashboard.php', array('json', 'php'))
    );
}

function getPostedSongSettings($post, $settings) {
    $result = $settings['songs'] ?? array();
    if (!isset($post['songSettingsSubmitted'])) {
        return $result;
    }
    $result['libraryEnabled'] = isset($post['songLibraryEnabled']);
    $result['libraryPath'] = normalizeSongPath($post['songLibraryPath'] ?? '', array('json', 'dat'));
    $result['libraryConfigPath'] = normalizeSongPath($post['songLibraryConfigPath'] ?? '', array('json', 'php'));
    return $result;
}

function openSongDatabase($settings) {
    $_path = normalizeSongPath($settings['path_connection'] ?? '../incl/lib/connection.php', array('php'));
    $_path = resolveSongPath($_path, true);
    if (!is_file($_path)) {
        return null;
    }
    $_bufferLevel = ob_get_level();
    ob_start();
    try {
        $db = null;
        require $_path;
        return $db instanceof PDO ? $db : null;
    } catch (Throwable $_error) {
        return null;
    } finally {
        while (ob_get_level() > $_bufferLevel) {
            ob_end_clean();
        }
    }
}
