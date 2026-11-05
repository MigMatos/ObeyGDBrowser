<?php

// GD Docs https://github.com/gd-docs/gd-docs/blob/main/docs/resources/server/gauntlet.md

require_once __DIR__ . '/icon-settings.php';

function normalizeGauntletId($value) {
    if ((!is_int($value) && !is_string($value)) || !preg_match('/^[1-9][0-9]*$/D', (string) $value)) {
        return 0;
    }
    return strlen((string) $value) <= 2 && intval($value) <= 60 ? intval($value) : 0;
}

function getGauntletFrameName($value) {
    $id = normalizeGauntletId($value);
    if (!$id) {
        return '';
    }
    $names = array(
        1 => 'fire', 'ice', 'poison', 'shadow', 'lava', 'bonus', 'chaos', 'demon',
        'time', 'crystal', 'magic', 'spike', 'monster', 'doom', 'death',
        51 => 'ncs01', 'ncs02', 'space', 'cosmos', 'random', 'chance', 'future', 'utopia', 'cinema', 'love'
    );
    $name = $id >= 16 && $id <= 50 ? 'new' . str_pad((string) ($id - 15), 2, '0', STR_PAD_LEFT) : $names[$id];
    return 'island_' . $name . '_001.png';
}

function getGauntletAtlasFrames() {
    static $frames = null;
    if ($frames !== null) {
        return $frames;
    }
    $frames = array();
    $_atlasPath = __DIR__ . '/../assets/GauntletSheet-uhd';
    if (!is_file($_atlasPath . '.png') || !is_file($_atlasPath . '.plist') || filesize($_atlasPath . '.plist') > 1000000) {
        return $frames;
    }
    $_size = @getimagesize($_atlasPath . '.png');
    if (!$_size || $_size[2] !== IMAGETYPE_PNG || $_size[0] > 8192 || $_size[1] > 8192) {
        return $frames;
    }
    $_document = new DOMDocument();
    $_previousErrors = libxml_use_internal_errors(true);
    try {
        if (!$_document->load($_atlasPath . '.plist', LIBXML_NONET)) {
            return $frames;
        }
        $_xpath = new DOMXPath($_document);
        $_dictionary = $_xpath->query('/plist/dict/key[.="frames"]/following-sibling::*[1][self::dict]')->item(0);
        if (!$_dictionary) {
            return $frames;
        }
        foreach ($_xpath->query('key', $_dictionary) as $_key) {
            $_data = $_xpath->query('following-sibling::*[1][self::dict]', $_key)->item(0);
            if (!$_data) {
                continue;
            }
            $_values = array();
            foreach ($_xpath->query('key', $_data) as $_field) {
                $_node = $_xpath->query('following-sibling::*[1]', $_field)->item(0);
                $_values[$_field->textContent] = $_node ? ($_node->nodeName === 'true' ? true : $_node->textContent) : '';
            }
            preg_match_all('/-?[0-9]+(?:\.[0-9]+)?/', $_values['textureRect'] ?? '', $_matches);
            $_rect = array_map('floatval', $_matches[0]);
            if (count($_rect) !== 4) {
                continue;
            }
            list($_x, $_y, $_width, $_height) = $_rect;
            $_rotated = ($_values['textureRotated'] ?? false) === true;
            if ($_x < 0 || $_y < 0 || $_width < 1 || $_height < 1 || $_x + ($_rotated ? $_height : $_width) > $_size[0] || $_y + ($_rotated ? $_width : $_height) > $_size[1]) {
                continue;
            }
            $frames[$_key->textContent] = true;
        }
    } finally {
        libxml_clear_errors();
        libxml_use_internal_errors($_previousErrors);
    }
    return $frames;
}

function getGauntletInfo($value, $settings, $binaryVersion = null) {
    $id = normalizeGauntletId($value);
    $_binary = max(0, intval($binaryVersion ?? ($settings['gdps_binary_version'] ?? 0)));
    $_frame = getGauntletFrameName($id);
    $_info = $settings['gauntlets'][(string) $id] ?? null;
    if (!$id || ($id >= 55 && $_binary < 46) || !is_array($_info) || !is_string($_info['name'] ?? null) || trim($_info['name']) === '' || !isset(getGauntletAtlasFrames()[$_frame])) {
        return array('name' => 'Unknown', 'textColor' => '', 'bgColor' => '', 'frame' => '', 'isKnown' => false);
    }
    $info = array('name' => $_info['name'], 'frame' => $_frame, 'isKnown' => true);
    foreach (array('textColor', 'bgColor') as $_key) {
        $_color = $_info[$_key] ?? '';
        $info[$_key] = is_string($_color) && preg_match('/^#[0-9a-fA-F]{6}$/D', $_color) ? $_color : '';
    }
    return $info;
}

function getPublicGauntletSettings($settings = null) {
    if ($settings === null) {
        $settings = readBrowserSettings();
    }
    $gauntlets = array();
    for ($_id = 1; $_id <= 60; $_id++) {
        $gauntlets[$_id] = getGauntletInfo($_id, $settings, 100000);
    }
    return array('binaryVersion' => max(0, intval($settings['gdps_binary_version'] ?? 0)), 'gauntlets' => $gauntlets);
}
