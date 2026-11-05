<?php

// MegaSa1nt https://github.com/MegaSa1nt/GMDprivateServer

function readSongSourceFile($path) {
    if ($path === '' || !is_file($path) || !is_readable($path) || filesize($path) > 32000000) {
        return '';
    }
    return file_get_contents($path);
}

function readSongConfigValue($tokens, &$position) {
    $_token = $tokens[$position] ?? null;
    if ($_token === '[' || (is_array($_token) && $_token[0] === T_ARRAY)) {
        $_close = $_token === '[' ? ']' : ')';
        $position++;
        if ($_close === ')') {
            if (($tokens[$position] ?? null) !== '(') {
                throw new UnexpectedValueException('Invalid library array.');
            }
            $position++;
        }
        $_values = array();
        while (($tokens[$position] ?? null) !== $_close) {
            if (!isset($tokens[$position])) {
                throw new UnexpectedValueException('Incomplete library array.');
            }
            $_values[] = readSongConfigValue($tokens, $position);
            if (($tokens[$position] ?? null) !== ',') {
                break;
            }
            $position++;
        }
        if (($tokens[$position] ?? null) !== $_close) {
            throw new UnexpectedValueException('Unsupported library configuration.');
        }
        $position++;
        return $_values;
    }
    if (!is_array($_token)) {
        throw new UnexpectedValueException('Expected a literal library value.');
    }
    $position++;
    if ($_token[0] === T_CONSTANT_ENCAPSED_STRING) {
        $_value = substr($_token[1], 1, -1);
        return $_token[1][0] === "'" ? str_replace(array("\\'", '\\\\'), array("'", '\\'), $_value) : stripcslashes($_value);
    }
    if ($_token[0] === T_LNUMBER) {
        return intval($_token[1]);
    }
    if ($_token[0] === T_VARIABLE || ($_token[0] === T_STRING && strtolower($_token[1]) === 'null')) {
        return null;
    }
    throw new UnexpectedValueException('Unsupported library configuration value.');
}

function readSongLibraryServers($path) {
    $_source = readSongSourceFile($path);
    if ($_source === '') {
        return array();
    }
    if (strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'json') {
        $_servers = json_decode($_source, true);
        return is_array($_servers) ? ($_servers['servers'] ?? $_servers) : array();
    }
    $_tokens = array_values(array_filter(token_get_all($_source), function($_token) {
        return !is_array($_token) || !in_array($_token[0], array(T_WHITESPACE, T_COMMENT, T_DOC_COMMENT), true);
    }));
    foreach ($_tokens as $_position => $_token) {
        if (is_array($_token) && $_token[0] === T_VARIABLE && $_token[1] === '$customLibrary' && ($_tokens[$_position + 1] ?? null) === '=') {
            $_position += 2;
            try {
                return readSongConfigValue($_tokens, $_position);
            } catch (UnexpectedValueException $_error) {
                return array();
            }
        }
    }
    return array();
}

function decodeSongLibrary($source, $isDat = false) {
    if (!$isDat) {
        $_data = json_decode($source, true);
        return is_array($_data) ? $_data : array();
    }
    $_compressed = base64_decode(strtr(trim($source), '-_', '+/'), true);
    $_decoded = $_compressed === false ? false : @zlib_decode($_compressed, 32000000);
    if ($_decoded === false) {
        return array();
    }
    $_sections = explode('|', $_decoded);
    if (count($_sections) < 3) {
        return array();
    }
    $_data = array('authors' => array(), 'songs' => array());
    foreach (explode(';', $_sections[1]) as $_row) {
        $_fields = explode(',', $_row);
        if (count($_fields) >= 2 && ctype_digit($_fields[0])) {
            $_data['authors'][$_fields[0]] = array('name' => rawurldecode($_fields[1]), 'link' => $_fields[2] ?? '');
        }
    }
    foreach (explode(';', $_sections[2]) as $_row) {
        $_fields = explode(',', $_row);
        if (count($_fields) >= 5 && ctype_digit($_fields[0])) {
            $_data['songs'][$_fields[0]] = array(
                'ID' => $_fields[0], 'type' => 1, 'name' => rawurldecode($_fields[1]), 'authorID' => $_fields[2],
                'size' => $_fields[3], 'seconds' => $_fields[4], 'ncs' => $_fields[6] ?? 0,
                'artists' => $_fields[7] ?? '', 'externalLink' => $_fields[8] ?? '', 'new' => $_fields[9] ?? 0,
                'priorityOrder' => $_fields[10] ?? 0
            );
        }
    }
    return $_data;
}
