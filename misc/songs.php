<?php

// Cvolton https://github.com/Cvolton/GMDprivateServer
// MegaSa1nt https://github.com/MegaSa1nt/GMDprivateServer
// GD Docs https://github.com/gd-docs/gd-docs/blob/main/docs/resources/server/song.md

require_once __DIR__ . '/song-settings.php';
require_once __DIR__ . '/song-library.php';

function normalizeBrowserSongId($value, $allowZero = false) {
    if ((!is_int($value) && !is_string($value)) || !preg_match('/^(?:0|[1-9][0-9]*)$/D', (string) $value) || strlen((string) $value) > 10 || $value > 2147483647) {
        return null;
    }
    return intval($value) > 0 || $allowZero ? intval($value) : null;
}

function safeSongUrl($value) {
    if (!is_string($value)) {
        return '';
    }
    $_url = trim($value);
    if (preg_match('/^https?%3a/i', $_url)) {
        $_url = rawurldecode($_url);
    }
    $_parts = parse_url($_url);
    if (!$_parts || !in_array(strtolower($_parts['scheme'] ?? ''), array('http', 'https'), true) || empty($_parts['host']) || isset($_parts['user']) || isset($_parts['pass']) || preg_match('/[\x00-\x20\x7f]/', $_url)) {
        return '';
    }
    return $_url;
}

function isCustomSongFilter($params) {
    return array_key_exists('customSong', $params) && is_scalar($params['customSong']) && !in_array(strtolower((string) $params['customSong']), array('0', 'false', 'no'), true);
}

function getOfficialSongCatalog($settings) {
    $_reader = new BrowserSongs(null, $settings);
    $catalog = array();
    foreach (($settings['official_songs'] ?? array()) as $_id => $_row) {
        if (normalizeBrowserSongId($_id) !== null) {
            $_song = $_reader->read($_id, 'official');
            if ($_song['isAvailable']) {
                $catalog[] = $_song;
            }
        }
    }
    usort($catalog, function($_first, $_second) {
        return $_first['id'] <=> $_second['id'];
    });
    return $catalog;
}

class BrowserSongs {
    private $db;
    private $settings;
    private $library = null;
    private $servers = null;
    private $cache = array();
    private $databaseRows = array();

    public function __construct($db, $settings) {
        $this->db = $db;
        $this->settings = $settings;
    }

    public function preload($values) {
        $ids = array_values(array_unique(array_filter(array_map('normalizeBrowserSongId', $values), function($_id) {
            return $_id !== null;
        })));
        if (!$this->db || !$ids) {
            return;
        }
        try {
            $_query = $this->db->prepare('SELECT * FROM songs WHERE ID IN (' . implode(',', array_fill(0, count($ids), '?')) . ')');
            $_query->execute($ids);
            foreach ($ids as $_id) {
                $this->databaseRows[$_id] = null;
            }
            foreach ($_query->fetchAll(PDO::FETCH_ASSOC) as $_row) {
                $_id = normalizeBrowserSongId($_row['ID'] ?? null);
                if ($_id !== null && in_array($_id, $ids, true)) {
                    $this->databaseRows[$_id] = $_row;
                }
            }
        } catch (Throwable $_error) {
        }
    }

    private function unknown($id, $type, $status = 'not_found') {
        return array(
            'id' => $id, 'name' => 'Unknown', 'authorID' => 0, 'authorName' => 'Unknown',
            'size' => null, 'duration' => null, 'downloadLink' => '', 'listenLink' => '', 'authorLink' => '',
            'songType' => $type, 'source' => 'unknown', 'isOfficial' => $type === 'official',
            'isLibrary' => false, 'libraryName' => '', 'nongType' => 0, 'nongName' => 'None',
            'extraArtists' => array(), 'isDisabled' => false, 'isAvailable' => false,
            'status' => $status, 'apiStatus' => 'unstable'
        );
    }

    private function librarySong($id) {
        if ($this->library === null) {
            $this->library = array();
            $this->servers = array();
            try {
                $_options = getSongSettings($this->settings);
                if ($_options['libraryEnabled']) {
                    $_path = resolveSongPath($_options['libraryPath']);
                    $this->library = decodeSongLibrary(readSongSourceFile($_path), strtolower(pathinfo($_path, PATHINFO_EXTENSION)) === 'dat');
                    $this->servers = readSongLibraryServers(resolveSongPath($_options['libraryConfigPath']));
                }
            } catch (Throwable $_error) {
                $this->library = array();
            }
        }
        $_entries = $this->library['IDs'] ?? ($this->library['songs'] ?? array());
        $_row = $_entries[$id] ?? null;
        if (!is_array($_row) || intval($_row['type'] ?? 1) !== 1 || !is_string($_row['name'] ?? null) || trim($_row['name']) === '') {
            return null;
        }
        $_authors = $this->library['IDs'] ?? ($this->library['authors'] ?? array());
        $_authorId = normalizeBrowserSongId($_row['authorID'] ?? null);
        $_author = $_authors[$_authorId ?? 0] ?? array();
        $_row['authorName'] = $_row['authorName'] ?? ($_author['name'] ?? 'Unknown');
        $_row['listenLink'] = $_row['externalLink'] ?? ($_author['link'] ?? '');
        $_row['authorLink'] = $_row['authorLink'] ?? ($_row['artistLink'] ?? ($_author['link'] ?? ''));
        $_row['size'] = is_numeric($_row['size'] ?? null) ? round(floatval($_row['size']) / 1048576, 2) : null;
        $_row['libraryName'] = 'Music Library';
        foreach ($this->servers as $_server) {
            if (!is_array($_server) || (string) ($_server['id'] ?? ($_server[0] ?? '')) !== (string) ($_row['server'] ?? '')) {
                continue;
            }
            if (is_string($_server['name'] ?? ($_server[1] ?? null))) {
                $_row['libraryName'] = $_server['name'] ?? $_server[1];
            }
            $_base = safeSongUrl($_server['baseUrl'] ?? ($_server[2] ?? ''));
            $_original = normalizeBrowserSongId($_row['originalID'] ?? $id);
            if ($_base !== '' && $_original !== null && empty($_row['download'])) {
                $_row['download'] = rtrim($_base, '/') . '/music/' . $_original . '.ogg';
                $_row['downloadUnverified'] = true;
            }
            break;
        }
        $_row['extraArtists'] = array();
        $_artists = is_scalar($_row['artists'] ?? '') ? strval($_row['artists'] ?? '') : '';
        foreach (explode('.', $_artists) as $_artistId) {
            if (ctype_digit($_artistId) && isset($_authors[$_artistId]['name'])) {
                $_row['extraArtists'][] = array('id' => intval($_artistId), 'name' => strval($_authors[$_artistId]['name']));
            }
        }
        return $_row;
    }

    public function read($value, $type = 'custom', $joinedRow = null) {
        $id = normalizeBrowserSongId($value);
        if ($id === null || !in_array($type, array('official', 'custom', 'library'), true)) {
            return $this->unknown(0, $type, 'invalid_id');
        }
        $_key = $type . ':' . $id;
        if (isset($this->cache[$_key])) {
            return $this->cache[$_key];
        }
        $info = $this->unknown($id, $type === 'library' ? 'custom' : $type);
        if ($type === 'official') {
            $_row = $this->settings['official_songs'][$id] ?? null;
            if (is_array($_row) && is_string($_row['name'] ?? null) && trim($_row['name']) !== '') {
                $info = array_replace($info, array(
                    'name' => $_row['name'], 'authorName' => strval($_row['artist'] ?? 'Unknown'),
                    'listenLink' => safeSongUrl($_row['songLink'] ?? ''), 'authorLink' => safeSongUrl($_row['authorLink'] ?? ($_row['artistLink'] ?? '')),
                    'source' => 'official', 'status' => 'found', 'isAvailable' => true
                ));
            }
        } else {
            $_hasPreloadedRow = $type !== 'library' && array_key_exists($id, $this->databaseRows);
            $_row = $_hasPreloadedRow ? $this->databaseRows[$id] : $joinedRow;
            $_databaseUnavailable = false;
            if ($_row === null && $this->db && $type !== 'library' && !$_hasPreloadedRow) {
                try {
                    $_query = $this->db->prepare('SELECT * FROM songs WHERE ID = :id LIMIT 1');
                    $_query->execute(array(':id' => $id));
                    $_row = $_query->fetch(PDO::FETCH_ASSOC) ?: null;
                } catch (Throwable $_error) {
                    $_databaseUnavailable = true;
                }
            }
            $_library = $this->librarySong($id);
            $_source = $_row ? 'database' : 'library';
            if ($_row === null) {
                $_row = $_library;
            } elseif ($_library) {
                $_row = array_replace($_library, $_row);
            }
            if (is_array($_row) && is_string($_row['name'] ?? null) && trim($_row['name']) !== '') {
                $_nong = max(0, intval($_row['nongEnum'] ?? ($_row['ncs'] ?? 0)));
                $_disabled = isIconOptionEnabled($_row['isDisabled'] ?? false);
                $info = array_replace($info, array(
                    'name' => $_row['name'], 'authorID' => intval($_row['authorID'] ?? 0), 'authorName' => is_string($_row['authorName'] ?? null) ? $_row['authorName'] : 'Unknown',
                    'size' => is_numeric($_row['size'] ?? null) && $_row['size'] >= 0 ? floatval($_row['size']) : null,
                    'duration' => is_numeric($_row['seconds'] ?? ($_row['duration'] ?? null)) ? max(0, floatval($_row['seconds'] ?? $_row['duration'])) : null,
                    'downloadLink' => $_disabled ? '' : safeSongUrl($_row['download'] ?? ''),
                    'listenLink' => $_disabled ? '' : safeSongUrl($_row['listenLink'] ?? ($_row['externalLink'] ?? '')),
                    'authorLink' => $_disabled ? '' : safeSongUrl($_row['authorLink'] ?? ($_row['artistLink'] ?? '')),
                    'source' => $_source, 'isLibrary' => $_library !== null, 'libraryName' => $_library['libraryName'] ?? '',
                    'nongType' => $_nong, 'nongName' => array(0 => 'None', 1 => 'NCS', 2 => 'CHOMPO')[$_nong] ?? 'Unknown',
                    'extraArtists' => is_array($_row['extraArtists'] ?? null) ? $_row['extraArtists'] : array(), 'isDisabled' => $_disabled,
                    'isAvailable' => !$_disabled, 'status' => $_disabled ? 'disabled' : 'found',
                    'downloadUnverified' => !empty($_row['downloadUnverified'])
                ));
                if ($info['listenLink'] === '' && !$info['isLibrary'] && !$_disabled && preg_match('~^https?://audio\.ngfiles\.com/~i', $info['downloadLink'])) {
                    $info['listenLink'] = 'https://www.newgrounds.com/audio/listen/' . $id;
                }
            } elseif ($_databaseUnavailable || (!$this->db && $type !== 'library')) {
                $info['status'] = 'source_unavailable';
            }
        }
        $this->cache[$_key] = $info;
        return $info;
    }

    public function readLevel($row) {
        $_custom = normalizeBrowserSongId($row['songID'] ?? 0, true);
        if ($_custom === 0) {
            $_track = normalizeBrowserSongId($row['audioTrack'] ?? 0, true);
            $info = $this->read($_track === null ? null : $_track + 1, 'official');
        } else {
            $_joined = null;
            if (isset($row['browserSongID'])) {
                $_joined = array(
                    'ID' => $row['browserSongID'], 'name' => $row['browserSongName'], 'authorID' => $row['browserSongAuthorID'],
                    'authorName' => $row['browserSongAuthorName'], 'size' => $row['browserSongSize'],
                    'download' => $row['browserSongDownload'], 'isDisabled' => $row['browserSongDisabled']
                );
            }
            $info = $this->read($_custom, 'custom', $_joined);
        }
        return array(
            'song' => $info, 'songName' => $info['name'], 'songAuthor' => $info['authorName'],
            'songSize' => $info['size'] === null ? 'Unknown' : number_format($info['size'], 2, '.', '') . 'MB',
            'songID' => $info['id'], 'songLink' => $info['downloadLink'], 'songListenLink' => $info['listenLink'],
            'songSource' => $info['source'], 'songType' => $info['songType'],
            'songLibrary' => $info['isLibrary'] ? ($info['nongType'] === 1 ? 'NCS' : $info['libraryName']) : '',
            'songNongType' => $info['nongType'], 'audioTrack' => intval($row['audioTrack'] ?? 0),
            'officialSongID' => $_custom === 0 ? $info['id'] : null
        );
    }
}

function getBrowserSongResponse($params, $db, $settings) {
    $_type = $params['type'] ?? 'custom';
    if ($_type === 'official' && isset($params['list'])) {
        return getOfficialSongCatalog($settings);
    }
    $_id = normalizeBrowserSongId($params['id'] ?? ($params['songID'] ?? null));
    if ($_id === null || !is_string($_type) || !in_array($_type, array('official', 'custom', 'library'), true)) {
        throw new InvalidArgumentException('Provide a positive song ID and type official, custom or library.');
    }
    $_reader = new BrowserSongs($db, $settings);
    return $_reader->read($_id, $_type);
}
