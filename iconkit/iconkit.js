(function() {
    "use strict";

    const browserUrl = new URL('../', document.currentScript.src);
    const assetUrl = new URL('assets/', browserUrl);
    const pageSize = 36;
    const thumbnailCache = new Map();
    const selectedValues = Object.create(null);
    const selection = {type: 'cube', value: 1, colors: [0, 3, 12], glow: false};
    const preview = document.getElementById('iconPreview');
    const status = document.getElementById('iconStatus');
    const grid = document.getElementById('iconGrid');
    const downloadButton = document.getElementById('downloadIcon');
    const copyButton = document.getElementById('copyIcon');
    const initialQuery = new URLSearchParams(location.search);
    const downloadUrls = new Set();
    let iconConfig;
    let colorSelector;
    let currentCanvas = null;
    let activeColor = 0;
    let currentPage = 0;
    let _previewVersion = 0;
    let _gridVersion = 0;
    let _previewTimer = null;
    let _isPreviewRendering = false;
    let _jobs = [];
    let _activeJobs = 0;
    let _observer = null;
    let _isClosed = false;
    let _hasUserSelection = false;

    function isDeathEffect(type = selection.type) {
        return type === 'deatheffect';
    }

    function isAvailable(type) {
        return isDeathEffect(type) || (Object.hasOwn(iconConfig.icons, type) && GDVersionAdapter.isModeAvailable(type, iconConfig));
    }

    function firstValue(type = selection.type) {
        return isDeathEffect(type) ? 0 : 1;
    }

    function lastValue(type = selection.type) {
        return isDeathEffect(type) ? iconConfig.deathEffects : iconConfig.icons[type];
    }

    function normalizeValue(value, type) {
        const _number = Number(value);
        if (!Number.isInteger(_number)) {
            return firstValue(type);
        }
        return Math.max(firstValue(type), Math.min(_number, lastValue(type)));
    }

    function pageCount() {
        return Math.max(1, Math.ceil((lastValue() - firstValue() + 1) / pageSize));
    }

    function getQuery() {
        const _params = new URLSearchParams({
            type: selection.type,
            value: selection.value,
            color1: selection.colors[0],
            color2: selection.colors[1],
            color3: selection.colors[2],
            glow: selection.glow ? 1 : 0,
            page: currentPage + 1,
            slot: activeColor + 1
        });
        for (const _type of [...Object.keys(iconConfig.icons), 'deatheffect']) {
            const _value = _type === selection.type ? selection.value : selectedValues[_type];
            _params.set(_type, String(_value ?? firstValue(_type)));
        }
        return _params.toString();
    }

    function saveUrl() {
        const _url = new URL(location.href);
        _url.search = getQuery();
        history.replaceState(null, '', _url.href);
    }

    function showSpinner() {
        const _spinner = document.createElement('img');
        _spinner.className = 'spin kit-loading';
        _spinner.src = new URL('loading.png', assetUrl).href;
        _spinner.alt = 'Loading icon';
        preview.replaceChildren(_spinner);
    }

    function markSelection() {
        for (const _button of grid.querySelectorAll('button')) {
            const _selected = Number(_button.dataset.value) === selection.value;
            _button.setAttribute('aria-pressed', String(_selected));
            _button.classList.toggle('iconSelected', _selected);
        }
        for (const _button of document.querySelectorAll('.mode-tab[data-type]')) {
            const _type = _button.dataset.type;
            const _selected = _type === selection.type;
            const _prefix = isDeathEffect(_type) ? 'deathEffect' : _type;
            _button.setAttribute('aria-pressed', String(_selected));
            _button.firstElementChild.src = new URL(`iconkitbuttons/${_prefix}_${_selected ? 'on' : 'off'}.png`, assetUrl).href;
        }
        const _glow = document.getElementById('enableGlow');
        _glow.setAttribute('aria-pressed', String(selection.glow));
        _glow.firstElementChild.src = new URL(`iconkitbuttons/trail_${selection.glow ? 'on' : 'off'}.png`, assetUrl).href;
        const _value = document.getElementById('iconValue');
        _value.min = firstValue();
        _value.max = lastValue();
        _value.value = selection.value;
        for (const [_index, _id] of ['colorPrimary', 'colorSecondary', 'colorGlow'].entries()) {
            document.getElementById(_id).style.backgroundColor = `rgb(${iconConfig.colors[selection.colors[_index]].join(',')})`;
        }
        for (const _button of document.querySelectorAll('.color-slot')) {
            const _selected = Number(_button.dataset.slot) === activeColor;
            _button.classList.toggle('iconSelected', _selected);
            _button.setAttribute('aria-pressed', String(_selected));
        }
        colorSelector.setValue(selection.colors[activeColor]);
    }

    async function renderDeathEffect(value, size) {
        let _value = value;
        const _image = new Image();
        try {
            _image.src = new URL(`deatheffects/${_value}.png`, assetUrl).href;
            await _image.decode();
        } catch (_error) {
            if (_value === 0) {
                throw new Error('Death effect image is unavailable.');
            }
            _value = 0;
            _image.src = new URL('deatheffects/0.png', assetUrl).href;
            await _image.decode();
        }
        const _canvas = document.createElement('canvas');
        _canvas.width = size;
        _canvas.height = size;
        const _scale = size * .88 / Math.max(_image.naturalWidth, _image.naturalHeight);
        const _width = _image.naturalWidth * _scale;
        const _height = _image.naturalHeight * _scale;
        _canvas.getContext('2d').drawImage(_image, (size - _width) / 2, (size - _height) / 2, _width, _height);
        Object.assign(_canvas.dataset, {
            type: 'deatheffect',
            value: String(_value),
            source: _image.src,
            color1: String(selection.colors[0]),
            color2: String(selection.colors[1]),
            color3: String(selection.colors[2]),
            glow: selection.glow ? '1' : '0'
        });
        _canvas.setAttribute('role', 'img');
        _canvas.setAttribute('aria-label', `Death effect ${_value}`);
        return _canvas;
    }

    function schedulePreview() {
        const _version = ++_previewVersion;
        clearTimeout(_previewTimer);
        downloadButton.disabled = true;
        copyButton.disabled = true;
        preview.setAttribute('aria-busy', 'true');
        showSpinner();
        markSelection();
        _previewTimer = setTimeout(async () => {
            if (_isPreviewRendering || _isClosed) {
                return;
            }
            _isPreviewRendering = true;
            status.textContent = 'Generating…';
            status.classList.remove('error');
            try {
                const _canvas = isDeathEffect() ? await renderDeathEffect(selection.value, 512) : await GDIcons.render(getQuery(), {size: 512});
                if (_version !== _previewVersion || _isClosed) {
                    return;
                }
                selection.value = Number(_canvas.dataset.value);
                selection.colors = [_canvas.dataset.color1, _canvas.dataset.color2, _canvas.dataset.color3].map(Number);
                selectedValues[selection.type] = selection.value;
                currentCanvas = _canvas;
                preview.replaceChildren(_canvas);
                downloadButton.disabled = false;
                copyButton.disabled = false;
                status.textContent = `${selection.type} #${selection.value}`;
                saveUrl();
                markSelection();
            } catch (_error) {
                if (_version !== _previewVersion) {
                    return;
                }
                currentCanvas = null;
                preview.replaceChildren();
                status.textContent = _error.message;
                status.classList.add('error');
            } finally {
                _isPreviewRendering = false;
                if (_version === _previewVersion) {
                    preview.setAttribute('aria-busy', 'false');
                } else if (!_isClosed) {
                    schedulePreview();
                }
            }
        }, 80);
    }

    function yieldToBrowser() {
        return new Promise(_resolve => {
            if (window.requestIdleCallback) {
                requestIdleCallback(_resolve, {timeout: 150});
            } else {
                setTimeout(_resolve, 16);
            }
        });
    }

    async function getThumbnail(type, value) {
        const _key = `${iconConfig.version}:${type}:${value}`;
        for (const [_cacheKey, _entry] of thumbnailCache) {
            if (_entry.expires <= Date.now()) {
                _entry.canvas.width = 0;
                thumbnailCache.delete(_cacheKey);
            }
        }
        if (thumbnailCache.has(_key)) {
            return thumbnailCache.get(_key).canvas;
        }
        const _canvas = isDeathEffect(type) ? await renderDeathEffect(value, 64) :
            await GDIcons.render(`type=${type}&value=${value}&color1=12&color2=17&glow=0`, {size: 64, quality: 'preview'});
        thumbnailCache.set(_key, {canvas: _canvas, expires: Date.now() + iconConfig.iconkit.cacheSeconds * 1000});
        while (thumbnailCache.size > 108) {
            const _oldest = thumbnailCache.keys().next().value;
            thumbnailCache.get(_oldest).canvas.width = 0;
            thumbnailCache.delete(_oldest);
        }
        return _canvas;
    }

    function pumpThumbnails() {
        while (!_isClosed && _activeJobs < 2 && _jobs.length) {
            const _job = _jobs.shift();
            if (_job.version !== _gridVersion) {
                continue;
            }
            _activeJobs++;
            (async () => {
                await yieldToBrowser();
                if (_job.version !== _gridVersion || _isClosed) {
                    return;
                }
                const _thumbnail = await getThumbnail(_job.type, _job.value);
                if (_job.version !== _gridVersion || !_job.button.isConnected || _isClosed) {
                    return;
                }
                const _copy = document.createElement('canvas');
                _copy.width = 64;
                _copy.height = 64;
                _copy.setAttribute('aria-hidden', 'true');
                _copy.getContext('2d').drawImage(_thumbnail, 0, 0);
                _job.button.replaceChildren(_copy);
            })().catch(() => {
                _job.button.title = `${_job.type} ${_job.value} unavailable`;
            }).finally(() => {
                _activeJobs--;
                pumpThumbnails();
                if (!_activeJobs && !_jobs.length) {
                    grid.setAttribute('aria-busy', 'false');
                }
            });
        }
    }

    function selectPage(page) {
        _hasUserSelection = true;
        currentPage = ((page % pageCount()) + pageCount()) % pageCount();
        showPage();
        saveUrl();
    }

    function buildPageDots() {
        const _dots = document.getElementById('pageDots');
        _dots.replaceChildren();
        _dots.style.setProperty('--page-count', pageCount());
        for (let _page = 0; _page < pageCount(); _page++) {
            const _button = document.createElement('button');
            _button.type = 'button';
            _button.className = 'blankButton page-dot';
            _button.dataset.page = String(_page);
            _button.setAttribute('aria-label', `Page ${_page + 1}`);
            _button.tabIndex = _page === currentPage ? 0 : -1;
            if (_page === currentPage) {
                _button.setAttribute('aria-current', 'page');
            }
            const _image = document.createElement('img');
            _image.src = new URL(`iconkitbuttons/blank_${_page === currentPage ? 'on' : 'off'}.png`, assetUrl).href;
            _image.alt = '';
            _button.append(_image);
            _button.addEventListener('click', () => selectPage(_page));
            _dots.append(_button);
        }
        document.getElementById('pageLabel').value = `${currentPage + 1} / ${pageCount()}`;
    }

    function showPage() {
        const _version = ++_gridVersion;
        _jobs = [];
        if (_observer) {
            _observer.disconnect();
        }
        currentPage = Math.max(0, Math.min(currentPage, pageCount() - 1));
        grid.replaceChildren();
        grid.setAttribute('aria-busy', 'true');
        function enqueue(button) {
            _jobs.push({button, type: selection.type, value: Number(button.dataset.value), version: _version});
            pumpThumbnails();
        }
        if ('IntersectionObserver' in window) {
            _observer = new IntersectionObserver(_entries => {
                for (const _entry of _entries) {
                    if (_entry.isIntersecting) {
                        _observer.unobserve(_entry.target);
                        enqueue(_entry.target);
                    }
                }
            }, {rootMargin: '120px'});
        }
        const _start = currentPage * pageSize + firstValue();
        let _count = 0;
        for (let _value = _start; _value <= Math.min(_start + pageSize - 1, lastValue()); _value++) {
            const _button = document.createElement('button');
            _button.type = 'button';
            _button.className = 'icon-choice blankButton gdButton';
            _button.dataset.value = String(_value);
            _button.setAttribute('aria-label', `${selection.type} ${_value}`);
            _button.title = `${selection.type} ${_value}`;
            const _label = document.createElement('span');
            _label.textContent = _value;
            _button.append(_label);
            _button.addEventListener('click', () => {
                _hasUserSelection = true;
                selection.value = _value;
                schedulePreview();
            });
            grid.append(_button);
            if (_observer) {
                _observer.observe(_button);
            } else {
                enqueue(_button);
            }
            _count++;
        }
        while (_count < pageSize) {
            const _empty = document.createElement('span');
            _empty.className = 'icon-placeholder';
            _empty.setAttribute('aria-hidden', 'true');
            grid.append(_empty);
            _count++;
        }
        document.getElementById('previousPage').disabled = pageCount() === 1;
        document.getElementById('nextPage').disabled = pageCount() === 1;
        buildPageDots();
        markSelection();
    }

    function selectMode(type) {
        if (!isAvailable(type)) {
            return;
        }
        _hasUserSelection = true;
        selectedValues[selection.type] = selection.value;
        selection.type = type;
        selection.value = selectedValues[type] ?? firstValue(type);
        currentPage = Math.floor((selection.value - firstValue()) / pageSize);
        showPage();
        schedulePreview();
    }

    function buildModes() {
        const _tabs = document.getElementById('modeTabs');
        for (const _type of [...Object.keys(iconConfig.icons), 'glow', 'deatheffect']) {
            const _button = document.createElement('button');
            _button.type = 'button';
            _button.className = 'mode-tab iconTabButton blankButton gdButton';
            const _image = document.createElement('img');
            _image.alt = '';
            _button.append(_image);
            if (_type === 'glow') {
                _button.id = 'enableGlow';
                _button.setAttribute('aria-label', 'Glow');
                _button.title = 'Glow';
                _button.addEventListener('click', () => {
                    _hasUserSelection = true;
                    selection.glow = !selection.glow;
                    schedulePreview();
                });
            } else {
                _button.dataset.type = _type;
                _button.setAttribute('aria-label', isDeathEffect(_type) ? 'Death effects' : _type);
                _button.title = isDeathEffect(_type) ? 'Death effects' : _type;
                const _minimum = GDVersionAdapter.modeVersions[_type];
                if (_minimum) {
                    _button.classList.add(`gdItem${_minimum}`);
                }
                _button.addEventListener('click', () => selectMode(_type));
            }
            _tabs.append(_button);
        }
        GDVersionAdapter.apply(_tabs, iconConfig);
    }

    function buildColors() {
        const _colors = Object.create(null);
        for (const [_id, _color] of Object.entries(iconConfig.colors)) {
            _colors[_id] = {r: _color[0], g: _color[1], b: _color[2], order: iconConfig.colorOrder[_id]};
        }
        colorSelector = GDColorSelector.create(document.getElementById('colorGrid'), _colors, {
            value: selection.colors[activeColor],
            onChange(value) {
                _hasUserSelection = true;
                selection.colors[activeColor] = value;
                schedulePreview();
            }
        });
        for (const _slot of document.querySelectorAll('.color-slot')) {
            _slot.addEventListener('click', () => {
                activeColor = Number(_slot.dataset.slot);
                markSelection();
                colorSelector.scrollToValue(selection.colors[activeColor]);
                saveUrl();
            });
        }
    }

    function applySetup(params) {
        for (const _type of [...Object.keys(iconConfig.icons), 'deatheffect']) {
            selectedValues[_type] = normalizeValue(params.get(_type) ?? firstValue(_type), _type);
        }
        const _type = (params.get('type') || 'cube').toLowerCase();
        selection.type = isAvailable(_type) ? _type : 'cube';
        selection.value = normalizeValue(params.get('value') ?? selectedValues[selection.type], selection.type);
        selectedValues[selection.type] = selection.value;
        const _firstColor = Number(Object.keys(iconConfig.colors)[0]);
        selection.colors = ['color1', 'color2', 'color3'].map((_key, _index) => {
            const _value = Number(params.get(_key) ?? [0, 3, 12][_index]);
            return Object.hasOwn(iconConfig.colors, _value) ? _value : _firstColor;
        });
        selection.glow = Number(params.get('glow') || 0) > 0;
        activeColor = Math.max(0, Math.min(2, Math.floor(Number(params.get('slot') || 1)) - 1));
        if (!Number.isFinite(activeColor)) {
            activeColor = 0;
        }
        const _page = Number(params.get('page'));
        currentPage = Number.isInteger(_page) && _page > 0 ? Math.min(_page - 1, pageCount() - 1) : Math.floor((selection.value - firstValue()) / pageSize);
    }

    function readSession() {
        try {
            return JSON.parse(document.getElementById('iconKitSession').textContent);
        } catch (_error) {
            return null;
        }
    }

    function showPlayerName(name) {
        document.body.classList.add('has-player');
        document.getElementById('iconkitlogo').hidden = true;
        const _name = document.getElementById('playerName');
        _name.textContent = name;
        _name.hidden = false;
        document.getElementById('playerPanel').hidden = false;
    }

    async function loadPlayer() {
        const _session = readSession();
        if (!_session || !Number.isSafeInteger(_session.accountID) || _session.accountID < 1) {
            return;
        }
        showPlayerName(String(_session.username));
        try {
            const _url = new URL('api/profile.php', browserUrl);
            _url.searchParams.set('accountID', _session.accountID);
            const _response = await fetch(_url, {credentials: 'same-origin', mode: 'same-origin'});
            if (!_response.ok) {
                throw new Error('Your statistics are unavailable.');
            }
            const _data = await _response.json();
            const _player = Array.isArray(_data) ? _data[0] : null;
            if (!_player || Number(_player.accountID) !== _session.accountID) {
                throw new Error('Your statistics are unavailable.');
            }
            showPlayerName(String(_player.username));
            const _stats = document.getElementById('playerStats');
            const _definitions = [
                ['stars', 'Stars', 'star.png'],
                ['moons', 'Moons', 'moon.png'],
                ['diamonds', 'Diamonds', 'diamond.png'],
                ['coins', 'Secret coins', 'coin.png'],
                ['userCoins', 'User coins', 'silvercoin.png'],
                ['demons', 'Demons', 'demon.png'],
                ['cp', 'Creator points', 'cp.png'],
                ['rank', 'Global rank', 'leaderboardarrow.png'],
                ['friendsCount', 'Friends', 'friends.png'],
                ['completedLvls', 'Completed levels', 'category-featured.png']
            ];
            for (const [_key, _label, _image] of _definitions) {
                if (!Object.hasOwn(_player, _key) || (_key === 'rank' && Number(_player[_key]) <= 0)) {
                    continue;
                }
                if (_key === 'moons' && GDVersionAdapter.getGameVersion(iconConfig.gameVersion) < 22) {
                    continue;
                }
                const _item = document.createElement('div');
                _item.dataset.stat = _key;
                const _term = document.createElement('dt');
                const _icon = document.createElement('img');
                _icon.src = new URL(_image, assetUrl).href;
                _icon.alt = _label;
                _term.append(_icon);
                const _value = document.createElement('dd');
                const _number = Number(_player[_key]);
                _value.textContent = Number.isFinite(_number) && _number >= 0 ? _number.toLocaleString('en-US') : '0';
                _item.append(_term, _value);
                _stats.append(_item);
            }
            const _setupKeys = ['type', 'value', 'color1', 'color2', 'color3', 'glow', 'page', 'slot', ...Object.keys(iconConfig.icons), 'deatheffect'];
            const _hasInitialSetup = _setupKeys.some(_key => initialQuery.has(_key));
            if (!_hasInitialSetup && !_hasUserSelection) {
                const _params = new URLSearchParams();
                for (const _type of Object.keys(iconConfig.icons)) {
                    _params.set(_type, _player[_type] ?? 1);
                }
                _params.set('deatheffect', _player.deathEffect ?? 0);
                _params.set('color1', _player.col1 ?? 0);
                _params.set('color2', _player.col2 ?? 3);
                _params.set('color3', _player.colG ?? 12);
                _params.set('glow', Number(_player.glow) > 0 ? 1 : 0);
                applySetup(_params);
                showPage();
                schedulePreview();
            }
        } catch (_error) {
            document.getElementById('playerStatus').textContent = _error.message;
        } finally {
            document.getElementById('playerLoading').hidden = true;
        }
    }

    function imageBlob() {
        const _canvas = currentCanvas;
        return new Promise((_resolve, _reject) => {
            if (!_canvas) {
                _reject(new Error('Generate an image first.'));
                return;
            }
            _canvas.toBlob(_blob => {
                if (_blob) {
                    _resolve(_blob);
                } else {
                    _reject(new Error('Could not create the PNG image.'));
                }
            }, 'image/png');
        });
    }

    document.getElementById('previousPage').addEventListener('click', () => selectPage(currentPage - 1));
    document.getElementById('nextPage').addEventListener('click', () => selectPage(currentPage + 1));
    document.getElementById('pageDots').addEventListener('keydown', _event => {
        const _pages = {ArrowLeft: currentPage - 1, ArrowRight: currentPage + 1, Home: 0, End: pageCount() - 1};
        if (Object.hasOwn(_pages, _event.key)) {
            _event.preventDefault();
            selectPage(_pages[_event.key]);
            document.querySelector('.page-dot[aria-current="page"]').focus();
        }
    });
    document.getElementById('iconValue').addEventListener('change', _event => {
        _hasUserSelection = true;
        selection.value = normalizeValue(_event.target.value, selection.type);
        currentPage = Math.floor((selection.value - firstValue()) / pageSize);
        showPage();
        schedulePreview();
    });
    document.getElementById('randomIcon').addEventListener('click', () => {
        _hasUserSelection = true;
        const _types = [...Object.keys(iconConfig.icons), 'deatheffect'].filter(isAvailable);
        const _colors = Object.keys(iconConfig.colors);
        selection.type = _types[Math.floor(Math.random() * _types.length)];
        selection.value = firstValue() + Math.floor(Math.random() * (lastValue() - firstValue() + 1));
        selection.colors = [0, 1, 2].map(() => Number(_colors[Math.floor(Math.random() * _colors.length)]));
        selection.glow = Math.random() >= .5;
        currentPage = Math.floor((selection.value - firstValue()) / pageSize);
        showPage();
        schedulePreview();
    });
    downloadButton.addEventListener('click', async () => {
        if (!currentCanvas || downloadButton.disabled) {
            return;
        }
        const _filename = `${currentCanvas.dataset.type}_${currentCanvas.dataset.value}.png`;
        try {
            const _blob = await imageBlob();
            const _url = URL.createObjectURL(_blob);
            downloadUrls.add(_url);
            const _link = document.createElement('a');
            _link.href = _url;
            _link.download = _filename;
            _link.click();
            setTimeout(() => {
                URL.revokeObjectURL(_url);
                downloadUrls.delete(_url);
            }, 1000);
        } catch (_error) {
            status.textContent = _error.message;
        }
    });
    copyButton.addEventListener('click', async () => {
        if (!currentCanvas || copyButton.disabled) {
            return;
        }
        if (!navigator.clipboard?.write || !window.ClipboardItem) {
            status.textContent = 'Image copying needs HTTPS or localhost. You can download the PNG instead.';
            return;
        }
        try {
            await navigator.clipboard.write([new ClipboardItem({'image/png': imageBlob()})]);
            status.textContent = 'Image copied.';
        } catch (_error) {
            status.textContent = 'Could not copy the image. Check clipboard access or download the PNG.';
        }
    });
    document.getElementById('copyLink').addEventListener('click', async () => {
        const _url = new URL(location.href);
        _url.search = getQuery();
        _url.hash = '';
        try {
            if (!navigator.clipboard?.writeText) {
                throw new Error('Clipboard unavailable.');
            }
            await navigator.clipboard.writeText(_url.href);
            status.textContent = 'Link copied.';
        } catch (_error) {
            const _input = document.getElementById('shareLink');
            _input.value = _url.href;
            _input.hidden = false;
            _input.focus();
            _input.select();
            status.textContent = 'Copy the selected link.';
        }
    });

    GDIcons.getConfig().then(_config => {
        iconConfig = _config;
        if (!_config.iconkit.enabled) {
            throw new Error('Icon Kit is disabled.');
        }
        applySetup(initialQuery);
        buildModes();
        buildColors();
        for (const _input of document.querySelectorAll('[disabled]')) {
            _input.disabled = false;
        }
        showPage();
        schedulePreview();
        loadPlayer();
    }).catch(_error => {
        status.textContent = _error.message;
        status.classList.add('error');
        grid.setAttribute('aria-busy', 'false');
        preview.setAttribute('aria-busy', 'false');
    });

    window.addEventListener('pagehide', () => {
        _isClosed = true;
        ++_previewVersion;
        ++_gridVersion;
        _jobs = [];
        clearTimeout(_previewTimer);
        if (_observer) {
            _observer.disconnect();
        }
        for (const _entry of thumbnailCache.values()) {
            _entry.canvas.width = 0;
        }
        thumbnailCache.clear();
        for (const _url of downloadUrls) {
            URL.revokeObjectURL(_url);
        }
        downloadUrls.clear();
    });
    window.addEventListener('pageshow', _event => {
        if (_event.persisted && iconConfig) {
            _isClosed = false;
            showPage();
            schedulePreview();
        }
    });
})();
