<?php

function readBrowserSettings() {
    $_source = file_get_contents(__DIR__ . '/../gdps_settings.json');
    $settings = json_decode($_source, true);
    if (!is_array($settings)) throw new RuntimeException('Invalid browser settings.');
    return $settings;
}

function isIconOptionEnabled($value) {
    return filter_var($value, FILTER_VALIDATE_BOOLEAN);
}

function normalizeCustomIconPath($value) {
    if (!is_string($value)) return '';
    $_path = trim($value, " \t\n\r\0\x0B/");
    if ($_path === '') return '';
    if (substr(trim($value), 0, 1) === '/' || !preg_match('~^[a-zA-Z0-9_-]+(?:/[a-zA-Z0-9_-]+)*$~D', $_path)) {
        throw new InvalidArgumentException('Custom icons must use a local folder such as customfiles/gdicons.');
    }
    return $_path;
}

function getPublicIconSettings($settings = null) {
    if ($settings === null) $settings = readBrowserSettings();
    $icons = array();
    foreach (array('cube', 'ship', 'ball', 'ufo', 'wave', 'robot', 'spider', 'swing', 'jetpack') as $_type) {
        $icons[$_type] = max(1, min(10000, intval($settings['icons'][$_type] ?? 1)));
    }
    $colors = array();
    foreach (($settings['colors'] ?? array()) as $_id => $_color) {
        if (!ctype_digit((string) $_id) || !is_array($_color)) continue;
        $_valid = true;
        foreach (array('r', 'g', 'b') as $_channel) {
            if (!isset($_color[$_channel]) || !is_numeric($_color[$_channel]) || $_color[$_channel] < 0 || $_color[$_channel] > 255) $_valid = false;
        }
        if ($_valid) $colors[(string) $_id] = array('r' => intval($_color['r']), 'g' => intval($_color['g']), 'b' => intval($_color['b']), 'order' => intval($_color['order'] ?? $_id));
    }
    if (!$colors) $colors[0] = array('r' => 125, 'g' => 255, 'b' => 0, 'order' => 0);
    try {
        $_path = normalizeCustomIconPath($settings['customIcons']['path'] ?? 'customfiles/gdicons');
    } catch (InvalidArgumentException $_error) {
        $_path = '';
    }
    $publicSettings = array(
        'icons' => $icons,
        'colors' => $colors,
        'customIcons' => array('enabled' => isIconOptionEnabled($settings['customIcons']['enabled'] ?? true) && $_path !== '', 'path' => $_path),
        'iconkit' => array('enabled' => isIconOptionEnabled($settings['iconkit']['enabled'] ?? true), 'cacheSeconds' => max(0, min(3600, intval($settings['iconkit']['cacheSeconds'] ?? 300)))),
        'gameVersion' => max(0, intval($settings['gdps_version'] ?? 22)),
        'binaryVersion' => max(0, intval($settings['gdps_binary_version'] ?? 0)),
        'deathEffects' => max(0, min(10000, intval($settings['deatheffects'] ?? 20)))
    );
    $publicSettings['version'] = substr(hash('sha256', json_encode($publicSettings) . strval($settings['cache_counter'] ?? 0)), 0, 16);
    return $publicSettings;
}

function getPostedIconSettings($post, $settings) {
    $result = array(
        'icons' => $settings['icons'] ?? array(),
        'customIcons' => $settings['customIcons'] ?? array('enabled' => true, 'path' => 'customfiles/gdicons'),
        'iconkit' => $settings['iconkit'] ?? array('enabled' => true, 'cacheSeconds' => 300)
    );
    if (!isset($post['iconSettingsSubmitted'])) return $result;
    foreach (array('cube', 'ship', 'ball', 'ufo', 'wave', 'robot', 'spider', 'swing', 'jetpack') as $_type) {
        $_value = $post['icons-' . $_type] ?? ($settings['icons'][$_type] ?? 1);
        if (!is_scalar($_value) || !preg_match('/^[0-9]+$/D', (string) $_value) || $_value < 1 || $_value > 10000) {
            throw new InvalidArgumentException('Icon limits must be between 1 and 10000.');
        }
        $result['icons'][$_type] = strval(intval($_value));
    }
    $_path = normalizeCustomIconPath($post['customIconsPath'] ?? '');
    $result['customIcons'] = array('enabled' => isset($post['customIconsEnabled']), 'path' => $_path);
    $_cacheSeconds = $post['iconCacheSeconds'] ?? 300;
    if (!is_scalar($_cacheSeconds) || !preg_match('/^[0-9]+$/D', (string) $_cacheSeconds) || $_cacheSeconds > 3600) {
        throw new InvalidArgumentException('Icon cache duration must be between 0 and 3600 seconds.');
    }
    $result['iconkit'] = array('enabled' => isset($post['iconkitEnabled']), 'cacheSeconds' => intval($_cacheSeconds));
    return $result;
}
