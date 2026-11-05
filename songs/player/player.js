(function() {
    "use strict";

    const browserUrl = new URL('../../', document.currentScript.src);
    const query = new URLSearchParams(location.search);
    const root = document.getElementById('songPlayer');
    const isEmbedded = window.parent !== window;
    document.body.classList.toggle('is-embedded', isEmbedded);
    document.body.classList.toggle('is-compact', query.get('compact') === '1');
    const player = GDSongPlayer.create(root);
    window.songPlayer = player;
    let _requestVersion = 0;

    async function loadSong() {
        const _version = ++_requestVersion;
        try {
            const _info = await GDSongs.read(query.get('id'), query.get('type') || 'custom');
            if (_version !== _requestVersion) {
                return;
            }
            player.load(_info);
            document.title = `${_info.name || 'Unknown'} - Song player`;
            if (query.get('autoplay') === '1') {
                player.play();
            }
        } catch (_error) {
            if (_version !== _requestVersion) {
                return;
            }
            const _message = _error.status === 404 ? 'Song information was not found. The song may no longer exist.' : 'Song information could not be loaded. Please try again.';
            player.fail(navigator.onLine === false ? 'OFFLINE' : `INFO_${_error.status || 'UNAVAILABLE'}`, navigator.onLine === false ? 'You are offline. Check your internet connection.' : _message);
        }
    }

    document.getElementById('closePlayer').addEventListener('click', () => {
        if (isEmbedded) {
            window.parent.postMessage({type: 'ObeyGDBrowser', origin: location.origin, data: 'closeWindow'}, location.origin);
        } else {
            location.href = new URL('songs/index.php', browserUrl).href;
        }
    });
    document.addEventListener('keydown', _event => {
        if (_event.key === 'Escape' && isEmbedded) {
            document.getElementById('closePlayer').click();
        }
    });
    window.addEventListener('pagehide', () => {
        _requestVersion++;
        player.destroy();
    }, {once: true});
    window.addEventListener('pageshow', _event => {
        if (_event.persisted) {
            location.reload();
        }
    });
    loadSong();
})();
