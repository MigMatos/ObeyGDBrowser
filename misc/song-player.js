(function() {
    "use strict";

    const assetUrl = new URL('../assets/', document.currentScript.src);

    function formatTime(value) {
        if (!Number.isFinite(value) || value < 0) {
            return '--:--';
        }
        const _seconds = Math.floor(value);
        const _hours = Math.floor(_seconds / 3600);
        const _minutes = Math.floor(_seconds / 60) % 60;
        const _parts = [String(_minutes).padStart(2, '0'), String(_seconds % 60).padStart(2, '0')];
        if (_hours > 0) {
            _parts.unshift(String(_hours).padStart(2, '0'));
        }
        return _parts.join(':');
    }

    function mediaError(code, isOffline = false) {
        if (isOffline) {
            return {code: 'OFFLINE', message: 'You are offline. Check your internet connection and try again.'};
        }
        const _errors = {
            1: ['MEDIA_ERR_ABORTED:1', 'Audio loading was interrupted. Reopen the player to load it again.'],
            2: ['MEDIA_ERR_NETWORK:2', 'A network error interrupted the audio download.'],
            3: ['MEDIA_ERR_DECODE:3', 'The audio is corrupt or could not be decoded.'],
            4: ['MEDIA_ERR_SRC_NOT_SUPPORTED:4', 'The audio format is not supported, or the file is unavailable.']
        };
        const _error = _errors[code] || ['MEDIA_ERROR', 'An unexpected audio error occurred.'];
        return {code: _error[0], message: _error[1]};
    }

    function create(root) {
        const audio = root.querySelector('#songAudio');
        const playButton = root.querySelector('#togglePlayback');
        const status = root.querySelector('#playerStatus');
        const loading = root.querySelector('#playerLoading');
        const _events = new AbortController();
        let _duration = 0;
        let _frame = null;
        let _timeout = null;
        let _request = null;
        let _version = 0;
        let _destroyed = false;
        let _hasError = false;

        const progress = GDSlider.create(root.querySelector('#songProgress'), {
            min: 0, max: 0, step: .01, disabled: true,
            formatValue: value => `${formatTime(value)} of ${formatTime(_duration)}`,
            onInput(value) {
                if (_duration > 0) {
                    try {
                        audio.currentTime = Math.max(0, Math.min(_duration, value));
                        root.querySelector('#currentTime').textContent = formatTime(value);
                    } catch (_error) {
                        report('SEEK_UNAVAILABLE', 'This server does not support seeking to that position.', false);
                    }
                }
            }
        });
        const volume = GDSlider.create(root.querySelector('#songVolume'), {
            min: 0, max: 1, step: .01, value: 1,
            formatValue: value => `${Math.round(value * 100)}%`,
            onInput(value) {
                audio.volume = value;
                audio.muted = value === 0;
                root.querySelector('#volumeValue').textContent = `${Math.round(audio.volume * 100)}%`;
                if (Math.abs(audio.volume - value) > .01) {
                    report('VOLUME_UNAVAILABLE', 'This browser uses the device volume controls.', false);
                }
            }
        });

        function report(code, message, isError = true) {
            if (_destroyed) {
                return;
            }
            status.textContent = `[${code}] ${message}`;
            status.classList.toggle('is-error', isError);
            root.querySelector('#playerError cr').textContent = isError ? 'Error:' : 'Warning:';
            status.dataset.code = code;
            status.hidden = false;
        }

        function clearWait() {
            clearTimeout(_timeout);
            _timeout = null;
            loading.hidden = true;
            root.setAttribute('aria-busy', 'false');
        }

        function fail(code, message) {
            if (_destroyed) {
                return;
            }
            _hasError = true;
            clearWait();
            audio.pause();
            root.dataset.playerState = 'error';
            playButton.disabled = true;
            progress.setDisabled(true);
            report(code, message);
        }

        function wait() {
            loading.hidden = false;
            root.setAttribute('aria-busy', 'true');
            status.hidden = true;
            status.textContent = '';
            delete status.dataset.code;
            status.classList.remove('is-error');
            clearTimeout(_timeout);
            _timeout = setTimeout(() => fail('LOAD_TIMEOUT', 'The audio server did not respond in time. Check your connection or try again.'), 30000);
        }

        function updateTime() {
            const _value = Number.isFinite(audio.currentTime) ? audio.currentTime : 0;
            progress.setValue(_value);
            root.querySelector('#currentTime').textContent = formatTime(_value);
            if (!audio.paused && !audio.ended && !_destroyed) {
                _frame = requestAnimationFrame(updateTime);
            } else {
                _frame = null;
            }
        }

        function updatePlayback() {
            const _playing = !audio.paused && !audio.ended;
            playButton.setAttribute('aria-label', _playing ? 'Pause' : 'Play');
            playButton.setAttribute('aria-pressed', String(_playing));
            playButton.querySelector('img').src = new URL(_playing ? 'stopbutton.png' : 'playsong.png', assetUrl).href;
            cancelAnimationFrame(_frame);
            _frame = null;
            if (_playing) {
                updateTime();
            }
            if (!_hasError) {
                root.dataset.playerState = audio.ended ? 'ended' : _playing ? 'playing' : 'paused';
                if (!loading.hidden) {
                    return;
                }
                if ((status.dataset.code === 'PLAY_BLOCKED' && !_playing) || (status.dataset.code === 'OFFLINE' && navigator.onLine === false)) {
                    return;
                }
                status.hidden = true;
                status.textContent = '';
                delete status.dataset.code;
            }
        }

        function updateDuration() {
            if (_hasError || !Number.isFinite(audio.duration) || audio.duration <= 0) {
                return;
            }
            _duration = audio.duration;
            progress.setRange(0, _duration, .01);
            progress.setValue(audio.currentTime);
            const _canSeek = audio.seekable.length > 0 && audio.seekable.end(audio.seekable.length - 1) > audio.seekable.start(0);
            progress.setDisabled(!_canSeek);
            progress.input.title = _canSeek ? 'Playback position' : 'Seeking is not supported by this audio server yet.';
            root.querySelector('#totalTime').textContent = formatTime(_duration);
            playButton.disabled = false;
            clearWait();
            updatePlayback();
        }

        async function diagnoseError() {
            const _versionAtStart = _version;
            const _error = mediaError(audio.error?.code, navigator.onLine === false);
            fail(_error.code, _error.message);
            let _url;
            try {
                _url = new URL(audio.currentSrc || audio.src);
            } catch (_ignored) {
                return;
            }
            if (_url.origin !== location.origin || navigator.onLine === false) {
                return;
            }
            _request?.abort();
            _request = new AbortController();
            const _diagnosticTimeout = setTimeout(() => _request?.abort(), 4000);
            try {
                const _response = await fetch(_url, {method: 'HEAD', signal: _request.signal, credentials: 'same-origin'});
                if (_versionAtStart !== _version || _destroyed) {
                    return;
                }
                if (_response.status === 404 || _response.status === 410) {
                    fail(`HTTP_${_response.status}`, 'This audio file no longer exists or could not be found.');
                } else if (_response.status === 401 || _response.status === 403) {
                    fail(`HTTP_${_response.status}`, 'Access to this audio file was denied. Its link may have expired.');
                } else if (!_response.ok) {
                    fail(`HTTP_${_response.status}`, 'The audio server returned an error. Please try again later.');
                } else if (audio.error?.code === 4) {
                    fail(_error.code, 'The audio file is corrupt, empty, or uses an unsupported format.');
                }
            } catch (_ignored) {
            } finally {
                clearTimeout(_diagnosticTimeout);
            }
        }

        function load(info) {
            _version++;
            _request?.abort();
            _hasError = false;
            _duration = 0;
            audio.pause();
            audio.removeAttribute('src');
            audio.load();
            progress.setRange(0, 0, .01);
            progress.setDisabled(true);
            root.querySelector('#currentTime').textContent = '00:00';
            root.querySelector('#totalTime').textContent = '--:--';
            status.hidden = true;
            status.textContent = '';
            delete status.dataset.code;
            root.querySelector('#playerTitle').textContent = `${info.name || 'Unknown'}${info.nongType === 1 ? ' · NCS' : ''}`;
            const _artist = root.querySelector('#playerArtist');
            _artist.textContent = info.authorName || 'Unknown artist';
            const _searchUrl = GDSongs.artistUrl(info);
            _artist.classList.toggle('gdButton', Boolean(_searchUrl));
            if (_searchUrl) {
                _artist.href = _searchUrl;
                _artist.target = '_top';
            } else {
                _artist.removeAttribute('href');
            }
            const _art = root.querySelector('.player-art');
            _art.src = GDSongs.artworkUrl(info) || new URL('song/disc.png', assetUrl).href;
            _art.onerror = () => {
                _art.onerror = null;
                _art.src = new URL('song/disc.png', assetUrl).href;
            };
            const _platform = GDSongs.platformInfo(info);
            root.querySelector('#playerDetails').textContent = `ID: ${info.id} · ${_platform.name}`;
            const _warning = root.querySelector('#playerWarning');
            _warning.hidden = !_platform.warning;
            _warning.querySelector('span').textContent = _platform.warning;
            const _more = root.querySelector('#playerMore');
            const _artistUrl = GDSongs.safeUrl(info.authorLink);
            _more.hidden = !_artistUrl;
            if (_artistUrl) {
                _more.href = _artistUrl;
            } else {
                _more.removeAttribute('href');
            }
            if (info.isDisabled) {
                fail('SONG_DISABLED', 'This song is disabled and cannot be played.');
                return;
            }
            const _url = GDSongs.safeUrl(info.downloadLink);
            if (!_url) {
                fail('NO_AUDIO', 'No playable audio file is available for this song.');
                return;
            }
            root.dataset.playerState = 'loading';
            wait();
            playButton.disabled = false;
            audio.src = _url;
            audio.load();
        }

        async function play() {
            if (playButton.disabled || _destroyed) {
                return;
            }
            if (!audio.paused && !audio.ended) {
                audio.pause();
                clearWait();
                updatePlayback();
                return;
            }
            if (audio.ended) {
                audio.currentTime = 0;
            }
            try {
                await audio.play();
            } catch (_error) {
                if (_destroyed) {
                    return;
                }
                if (_error.name === 'NotAllowedError') {
                    clearWait();
                    report('PLAY_BLOCKED', 'Press Play to start playback. Your browser blocked automatic playback.', false);
                } else if (_error.name !== 'AbortError') {
                    const _failure = mediaError(audio.error?.code, navigator.onLine === false);
                    fail(_failure.code, _failure.message);
                }
            }
        }

        function listen(target, event, callback) {
            target.addEventListener(event, callback, {signal: _events.signal});
        }
        listen(playButton, 'click', play);
        listen(audio, 'loadedmetadata', updateDuration);
        listen(audio, 'durationchange', updateDuration);
        listen(audio, 'canplay', updateDuration);
        listen(audio, 'progress', updateDuration);
        listen(audio, 'play', updatePlayback);
        listen(audio, 'pause', updatePlayback);
        listen(audio, 'ended', updatePlayback);
        listen(audio, 'timeupdate', () => {
            if (_frame === null) {
                updateTime();
            }
        });
        listen(audio, 'volumechange', () => {
            volume.setValue(audio.muted ? 0 : audio.volume);
            root.querySelector('#volumeValue').textContent = `${Math.round(volume.getValue() * 100)}%`;
        });
        listen(audio, 'error', diagnoseError);
        listen(audio, 'waiting', () => {
            if (!_hasError && !audio.paused) {
                wait();
            }
        });
        listen(audio, 'playing', () => {
            clearWait();
            updatePlayback();
        });
        listen(window, 'offline', () => report('OFFLINE', 'You are offline. Buffered audio may continue playing.', false));
        listen(window, 'online', () => {
            if (status.dataset.code === 'OFFLINE') {
                report('CONNECTION_RESTORED', 'Connection restored. Press Play or reopen the player to continue.', false);
            }
        });
        return Object.freeze({
            audio, progress, volume, load, play, fail,
            destroy() {
                _destroyed = true;
                _version++;
                _events.abort();
                _request?.abort();
                clearTimeout(_timeout);
                cancelAnimationFrame(_frame);
                audio.pause();
                audio.removeAttribute('src');
                audio.load();
                progress.destroy();
                volume.destroy();
            }
        });
    }

    window.GDSongPlayer = Object.freeze({create, formatTime, mediaError});
})();
