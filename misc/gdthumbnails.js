(function() {
    'use strict';

    const browserUrl = new URL('../', document.currentScript.src);
    const lookupUrl = new URL('api/thumbnails.php', browserUrl);
    const _cache = new Map();

    function validId(value) {
        return /^[1-9][0-9]{0,9}$/.test(String(value)) && Number(value) <= 2147483647;
    }

    function imageUrl(id, size = 'full', version = '') {
        const _url = new URL('thumbnail/index.php', browserUrl);
        _url.search = new URLSearchParams({id, size, ...(version ? {v: version} : {})}).toString();
        return _url.href;
    }

    async function lookup(ids) {
        const _ids = [...new Set(ids.filter(validId).map(String))].slice(0, 100);
        const _missing = _ids.filter(_id => !_cache.has(_id) || Date.now() - _cache.get(_id).time > 30000);
        if (_missing.length) {
            const _url = new URL(lookupUrl);
            _url.search = new URLSearchParams({action: 'lookup', ids: _missing.join(',')}).toString();
            try {
                const _response = await fetch(_url, {credentials: 'omit'});
                const _data = _response.ok ? await _response.json() : {items: []};
                const _published = new Map((_data.items || []).map(_item => [String(_item.levelID), _item.publishedID]));
                _missing.forEach(_id => _cache.set(_id, {version: _published.get(_id) || null, time: Date.now()}));
                while (_cache.size > 200) {
                    _cache.delete(_cache.keys().next().value);
                }
            } catch (_error) {
                return new Map();
            }
        }
        return new Map(_ids.map(_id => [_id, _cache.get(_id)?.version]));
    }

    function applyImage(element, id, version, className, size) {
        const _url = imageUrl(id, size, version);
        const _image = new Image();
        _image.onload = () => {
            if (element.isConnected && (!element.dataset.thumbnailLevel || element.dataset.thumbnailLevel === String(id))) {
                element.style.setProperty('--level-thumbnail', `url("${_url}")`);
                element.classList.add(className);
            }
        };
        _image.onerror = () => {
            element.classList.remove(className);
            element.style.removeProperty('--level-thumbnail');
        };
        _image.src = _url;
    }

    async function renderSearch(container) {
        const _elements = [...container.querySelectorAll('[data-thumbnail-level]')];
        const _versions = await lookup(_elements.map(_element => _element.dataset.thumbnailLevel));
        for (const _element of _elements) {
            const _id = _element.dataset.thumbnailLevel;
            const _version = _versions.get(_id);
            if (_version && _element.isConnected) {
                applyImage(_element, _id, _version, 'has-result-thumbnail', 'small');
            }
        }
    }

    async function renderLevel(id, special = false) {
        if (!validId(id)) {
            return;
        }
        const _versions = await lookup([id]);
        const _version = _versions.get(String(id));
        if (!_version) {
            return;
        }
        if (special) {
            const _preview = document.createElement('div');
            _preview.className = 'special-level-thumbnail';
            _preview.setAttribute('aria-hidden', 'true');
            document.body.prepend(_preview);
            applyImage(_preview, id, _version, 'has-special-thumbnail', 'small');
        } else {
            applyImage(document.body, id, _version, 'has-level-thumbnail', 'full');
        }
    }

    window.GDThumbnails = Object.freeze({imageUrl, renderSearch, renderLevel});
})();
