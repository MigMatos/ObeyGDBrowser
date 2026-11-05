(function() {
    "use strict";

    const browserUrl = new URL('../', document.currentScript.src);
    let _framePromise = null;
    let _openFrame = null;

    function safeUrl(value) {
        try {
            const _url = new URL(value);
            return ['http:', 'https:'].includes(_url.protocol) && !_url.username && !_url.password ? _url.href : '';
        } catch (_error) {
            return '';
        }
    }

    function sourceLabel(info) {
        return info.nongType === 1 ? 'NCS' : '';
    }

    function displayName(info) {
        return `${info.name || 'Unknown'}${sourceLabel(info) ? ' · NCS' : ''}`;
    }

    function artistUrl(info) {
        if (typeof info.authorName !== 'string' || !info.authorName.trim() || info.authorName === 'Unknown') {
            return '';
        }
        const _url = new URL('songs/index.php', browserUrl);
        _url.searchParams.set('str', '');
        _url.searchParams.set('author', info.authorName);
        return _url.href;
    }

    function platformInfo(info) {
        let _host = '';
        try {
            _host = new URL(safeUrl(info.downloadLink)).hostname.toLowerCase();
        } catch (_error) {
        }
        let _name = 'Unknown';
        if (_host === 'cdn.discordapp.com' || _host === 'media.discordapp.net') {
            _name = 'Discord';
        } else if (String(info.authorName || '').includes('ObeyGDMusic') || String(info.authorName || '').includes('ObeyGDBot') || _host.startsWith('library.obeygdbot')) {
            _name = 'ObeyGDMusic Library';
        } else if (_host === 'audio.ngfiles.com') {
            _name = 'Newgrounds';
        } else if (_host === 'dl.dropboxusercontent.com') {
            _name = 'Dropbox';
        } else if (info.isLibrary || ['geometrydashcontent.b-cdn.net', 'geometrydashcontent.com', 'geometrydashfiles.b-cdn.net'].includes(_host)) {
            _name = info.libraryName || 'Music Library';
        }
        const _warning = info.downloadUnverified ? 'This library link may require authentication or may have expired.' :
            (_name === 'Discord' || (_name === 'Unknown' && !info.isOfficial)) ? 'Songs uploaded from this platform may be unavailable.' : '';
        return {name: _name, warning: _warning};
    }

    function artworkUrl(info) {
        try {
            const _author = String(info.authorName || '').replace('ObeyGDBot', '').replace('ObeyGDMusic', '');
            const _source = sessionStorage.getItem(`albumCover_${info.name} - ${_author}`);
            if (!_source || _source.length > 100000) {
                return '';
            }
            const _entry = JSON.parse(_source);
            const _age = Date.now() - Number(_entry.timestamp);
            if (!Number.isFinite(_age) || _age < 0 || _age >= 172800000) {
                return '';
            }
            return safeUrl(_entry.data?.album?.cover_xl || _entry.data?.album?.cover_big || _entry.data?.artist?.picture_big);
        } catch (_error) {
            return '';
        }
    }

    async function read(id, type = 'custom') {
        const _url = new URL('api/song.php', browserUrl);
        _url.searchParams.set('id', id);
        _url.searchParams.set('type', type);
        const _response = await fetch(_url, {credentials: 'same-origin', mode: 'same-origin'});
        const _info = await _response.json();
        if (!_response.ok || _info.error) {
            const _error = new Error(_info.error || 'Song information is unavailable.');
            _error.status = _response.status;
            throw _error;
        }
        return _info;
    }

    function playerUrl(info, options = {}) {
        const _url = new URL('songs/player/index.php', browserUrl);
        _url.searchParams.set('id', info.id);
        _url.searchParams.set('type', info.songType === 'official' ? 'official' : 'custom');
        _url.searchParams.set('embed', '1');
        _url.searchParams.set('autoplay', '1');
        if (options.compact) {
            _url.searchParams.set('compact', '1');
        }
        return _url.href;
    }

    async function openPlayer(info, options = {}) {
        if (!window.openGdCustomFrame) {
            if (!_framePromise) {
                _framePromise = new Promise((_resolve, _reject) => {
                    const _script = document.createElement('script');
                    _script.src = new URL('misc/gdcustomframe.js', browserUrl).href;
                    _script.onload = _resolve;
                    _script.onerror = () => _reject(new Error('The player could not be opened.'));
                    document.head.append(_script);
                });
            }
            await _framePromise;
        }
        if (!document.querySelector('link[href*="/css/utils.css"]')) {
            const _style = document.createElement('link');
            _style.rel = 'stylesheet';
            _style.href = new URL('assets/css/utils.css', browserUrl).href;
            document.head.append(_style);
        }
        if (_openFrame?.isConnected) {
            closeGdCustomFrame(_openFrame);
        }
        _openFrame = openGdCustomFrame(playerUrl(info, options));
        _openFrame.classList.add('gdSongFrame');
        _openFrame.classList.toggle('gdSongFrameCompact', options.compact === true);
        const _iframe = _openFrame.querySelector('iframe');
        _iframe.allow = 'autoplay';
        _iframe.title = 'Song player';
        return _openFrame;
    }

    async function play(info, status = null) {
        try {
            return await openPlayer(info);
        } catch (_error) {
            if (status) {
                status.textContent = '[PLAYER_UNAVAILABLE] The player could not be opened.';
                status.style.display = '';
            }
            return null;
        }
    }

    function renderSearchLabel(element, info) {
        if (!info) {
            element.textContent = 'Unknown song';
            return;
        }
        element.textContent = displayName(info);
        element.title = `${info.name} by ${info.authorName} · ID: ${info.id}`;
        element.classList.add(info.isOfficial ? 'blue' : info.isLibrary ? (info.nongType === 1 ? 'ncsLibrary' : 'songLibrary') : 'whatIfItWasPurple');
        if (info.isDisabled) {
            element.textContent += ' · Disabled';
        } else if (safeUrl(info.downloadLink)) {
            element.classList.add('gdButton');
            element.setAttribute('role', 'button');
            element.tabIndex = 0;
            element.addEventListener('click', () => play(info));
            element.addEventListener('keydown', _event => {
                if (_event.key === 'Enter' || _event.key === ' ') {
                    _event.preventDefault();
                    play(info);
                }
            });
        }
    }

    function renderLevel(root = document, info = null) {
        if (!info) {
            const _data = root.querySelector('#levelSongData');
            if (!_data) {
                return;
            }
            try {
                info = JSON.parse(_data.textContent);
            } catch (_error) {
                return;
            }
        }
        const _name = root.querySelector('#songname');
        const _author = root.querySelector('#songAuthorName');
        const _summary = root.querySelector('#songInfo');
        if (_name) {
            _name.textContent = displayName(info);
            _name.title = info.name;
        }
        if (_author) {
            _author.textContent = info.authorName;
        }
        if (_summary) {
            const _size = Number.isFinite(info.size) ? ` · Size: ${info.size.toFixed(2)} MB` : '';
            _summary.textContent = `ID: ${info.id}${_size}${info.isDisabled ? ' · Disabled' : ''}`;
        }
        const _more = root.querySelector('#moreSongsLink');
        if (_more) {
            const _url = artistUrl(info);
            _more.hidden = !_url || info.isDisabled;
            if (_url && !info.isDisabled) {
                _more.href = _url;
                _more.target = '_self';
            } else {
                _more.removeAttribute('href');
            }
        }
        const _play = root.querySelector('#playSongLink');
        if (_play) {
            _play.hidden = !safeUrl(info.downloadLink) || info.isDisabled;
            _play.onclick = () => play(info, root.querySelector('#songLoading'));
            _play.onkeydown = _event => {
                if (_event.key === 'Enter' || _event.key === ' ') {
                    _event.preventDefault();
                    play(info, root.querySelector('#songLoading'));
                }
            };
            _play.setAttribute('aria-label', 'Play or pause song');
        }
        return info;
    }

    window.GDSongs = Object.freeze({read, sourceLabel, displayName, artistUrl, artworkUrl, platformInfo, safeUrl, playerUrl, openPlayer, play, renderSearchLabel, renderLevel});
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => renderLevel(), {once: true});
    } else {
        renderLevel();
    }
})();
