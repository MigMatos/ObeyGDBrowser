<?php

require_once __DIR__ . '/icon-settings.php';

function normalizeEmojiAliases($values, $strict = false) {
    if (!is_array($values) || count($values) > 1024) {
        if ($strict) throw new InvalidArgumentException('Emoji aliases must be a JSON object with at most 1024 entries.');
        return array();
    }
    $aliases = array();
    foreach ($values as $_name => $_frame) {
        $_valid = preg_match('/^[a-zA-Z0-9_]{1,40}$/D', (string) $_name) && is_scalar($_frame) && preg_match('/^(?:[0-9]{1,5}f?|[a-zA-Z0-9_-]{1,100}\.png)$/D', (string) $_frame);
        if (!$_valid) {
            if ($strict) throw new InvalidArgumentException('Use shortcode names without colons and numeric frame IDs or PNG frame names.');
            continue;
        }
        $aliases[strtolower((string) $_name)] = (string) $_frame;
    }
    return $aliases;
}

function getPublicEmojiSettings($settings = null) {
    if ($settings === null) $settings = readBrowserSettings();
    $_emojiSettings = $settings['emojis'] ?? array();
    $aliases = array_replace(normalizeEmojiAliases($_emojiSettings['aliases'] ?? array()), normalizeEmojiAliases($_emojiSettings['customAliases'] ?? array()));
    $atlases = array('official' => array('image' => 'assets/GJ_ParticleSheet-uhd.png', 'plist' => 'assets/GJ_ParticleSheet-uhd.plist'));
    try { $_customPath = normalizeCustomIconPath($_emojiSettings['customPath'] ?? 'customfiles/emojis'); }
    catch (InvalidArgumentException $_error) { $_customPath = ''; }
    if (isIconOptionEnabled($_emojiSettings['customEnabled'] ?? true) && $_customPath !== '') {
        $_base = __DIR__ . '/../' . $_customPath . '/GJ_ParticleSheet-uhd';
        if (is_file($_base . '.png') && is_file($_base . '.plist')) {
            $atlases['custom'] = array('image' => $_customPath . '/GJ_ParticleSheet-uhd.png', 'plist' => $_customPath . '/GJ_ParticleSheet-uhd.plist');
        }
    }
    $publicSettings = array(
        'enabled' => isIconOptionEnabled($_emojiSettings['enabled'] ?? false),
        'gameVersion' => max(0, intval($settings['gdps_version'] ?? 22)),
        'binaryVersion' => max(0, intval($settings['gdps_binary_version'] ?? 0)),
        'unicodeMinBinaryVersion' => 49,
        'emojiMinBinaryVersion' => 51,
        'maxPerMessage' => max(0, min(50, intval($_emojiSettings['maxPerMessage'] ?? 5))),
        'aliases' => (object) $aliases,
        'atlases' => $atlases
    );
    $publicSettings['version'] = substr(hash('sha256', json_encode($publicSettings) . strval($settings['cache_counter'] ?? 0)), 0, 16);
    return $publicSettings;
}

function getPostedEmojiSettings($post, $settings) {
    $result = $settings['emojis'] ?? array('enabled' => false, 'maxPerMessage' => 5, 'customEnabled' => true, 'customPath' => 'customfiles/emojis', 'aliases' => array(), 'customAliases' => array());
    if (!isset($post['emojiSettingsSubmitted'])) return $result;
    $_limit = $post['emojiMaxPerMessage'] ?? 5;
    if (!is_scalar($_limit) || !preg_match('/^[0-9]+$/D', (string) $_limit) || $_limit > 50) throw new InvalidArgumentException('Emoji limit must be between 0 and 50.');
    $_customAliases = $post['emojiCustomAliases'] ?? '{}';
    if (!is_string($_customAliases) || strlen($_customAliases) > 100000 || substr(ltrim($_customAliases), 0, 1) !== '{') throw new InvalidArgumentException('Custom aliases must be a JSON object.');
    $_decoded = json_decode($_customAliases, true);
    if (json_last_error() !== JSON_ERROR_NONE) throw new InvalidArgumentException('Custom aliases contain invalid JSON.');
    $result['enabled'] = false;
    $result['maxPerMessage'] = intval($_limit);
    $result['customEnabled'] = isset($post['emojiCustomEnabled']);
    $result['customPath'] = normalizeCustomIconPath($post['emojiCustomPath'] ?? '');
    $result['customAliases'] = normalizeEmojiAliases($_decoded, true);
    if (($post['updateEmojiCatalog'] ?? '') === '1') {
        $_catalog = json_decode(file_get_contents(__DIR__ . '/../gdpsettings/official_emojis.json'), true);
        $result['aliases'] = normalizeEmojiAliases($_catalog['aliases'] ?? null, true);
    }
    return $result;
}

function getGameVersionCatalog() {
    $_catalog = json_decode(file_get_contents(__DIR__ . '/../gdpsettings/official_versions.json'), true);
    return $_catalog['versions'] ?? array();
}

function getGameVersionGroups() {
    $groups = array();
    foreach (getGameVersionCatalog() as $release) {
        $gameVersion = strval($release['gameVersion']);
        if (!isset($groups[$gameVersion])) {
            $groups[$gameVersion] = array('label' => $release['version'], 'releases' => array());
        }
        $groups[$gameVersion]['releases'][] = $release;
    }
    return $groups;
}

function getPostedVersionNumber($value, $minimum, $label) {
    if (!is_scalar($value) || !preg_match('/^[0-9]+$/D', (string) $value) || $value < $minimum || $value > 100000) {
        throw new InvalidArgumentException('Invalid ' . $label . '.');
    }
    return strval(intval($value));
}

function getPostedVersionSelection($post, $settings) {
    $groups = getGameVersionGroups();
    $choice = $post['gdpsVersionChoice'] ?? null;
    $binaryChoice = $post['gdpsBinaryChoice'] ?? null;
    if (!is_string($choice) || !is_string($binaryChoice)) {
        throw new InvalidArgumentException('Choose a game version and binary version.');
    }
    if ($choice === 'custom') {
        $gameVersion = getPostedVersionNumber($post['gdpsCustomVersion'] ?? null, 0, 'custom game protocol version');
    } elseif (isset($groups[$choice])) {
        $gameVersion = $choice;
    } else {
        throw new InvalidArgumentException('Unknown game version.');
    }
    $releases = $groups[$gameVersion]['releases'] ?? array();
    if ($binaryChoice === '0') {
        $binaryVersion = '0';
    } elseif ($binaryChoice === 'custom') {
        $binaryVersion = getPostedVersionNumber($post['gdpsCustomBinary'] ?? null, 1, 'custom game binary version');
    } elseif ($binaryChoice === 'latest') {
        $binaryVersion = '0';
        foreach ($releases as $release) {
            $binaryVersion = strval(max(intval($binaryVersion), $release['binaryVersion']));
        }
        if ($binaryVersion === '0') {
            throw new InvalidArgumentException('No verified binary is available for this game version. Choose Disabled or Custom.');
        }
    } else {
        $binaryVersion = getPostedVersionNumber($binaryChoice, 1, 'game binary version');
        $matches = array_filter($releases, function ($release) use ($binaryVersion) {
            return strval($release['binaryVersion']) === $binaryVersion;
        });
        if (!$matches) {
            throw new InvalidArgumentException('Choose a binary for the selected game version or use Custom.');
        }
    }
    $gameRelease = '';
    if ($choice !== 'custom' && $binaryChoice !== 'custom') {
        foreach ($releases as $release) {
            if ($binaryVersion !== '0' && strval($release['binaryVersion']) === $binaryVersion) {
                $gameRelease = $release['version'];
            }
        }
        $savedRelease = $settings['gdps_game_release'] ?? '';
        if ($binaryChoice !== 'latest') {
            foreach ($releases as $release) {
                if ($release['version'] === $savedRelease && strval($release['binaryVersion']) === $binaryVersion) {
                    $gameRelease = $savedRelease;
                }
            }
        }
    }
    return array('gdps_game_release' => $gameRelease, 'gdps_version' => $gameVersion, 'gdps_binary_version' => $binaryVersion);
}

function getPostedGameVersionSettings($post, $settings) {
    if (($post['gameVersionSettingsSubmitted'] ?? '') === '1') {
        return getPostedVersionSelection($post, $settings);
    }
    if (!array_key_exists('gdps_game_release', $post) && !array_key_exists('gdps_version', $post) && !array_key_exists('gdps_binary_version', $post)) {
        return array(
            'gdps_game_release' => $settings['gdps_game_release'] ?? '',
            'gdps_version' => strval($settings['gdps_version'] ?? 22),
            'gdps_binary_version' => strval($settings['gdps_binary_version'] ?? 0)
        );
    }
    $_release = $post['gdps_game_release'] ?? ($settings['gdps_game_release'] ?? '');
    if (!is_string($_release)) throw new InvalidArgumentException('Invalid game release.');
    if ($_release !== '') {
        foreach (getGameVersionCatalog() as $_entry) {
            if ($_entry['version'] === $_release) return array('gdps_game_release' => $_release, 'gdps_version' => strval($_entry['gameVersion']), 'gdps_binary_version' => strval($_entry['binaryVersion']));
        }
        throw new InvalidArgumentException('Unknown game release.');
    }
    $_binary = $post['gdps_binary_version'] ?? ($settings['gdps_binary_version'] ?? 0);
    if (!is_scalar($_binary) || !preg_match('/^[0-9]+$/D', (string) $_binary) || $_binary > 100000) throw new InvalidArgumentException('Invalid game binary version.');
    $_gameVersion = $post['gdps_version'] ?? ($settings['gdps_version'] ?? '22');
    if (!is_scalar($_gameVersion) || !preg_match('/^[0-9]+$/D', (string) $_gameVersion) || $_gameVersion > 100000) throw new InvalidArgumentException('Invalid game protocol version.');
    return array('gdps_game_release' => '', 'gdps_version' => strval(intval($_gameVersion)), 'gdps_binary_version' => strval(intval($_binary)));
}
