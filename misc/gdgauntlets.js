(function() {
    "use strict";

    const browserUrl = new URL('../', document.currentScript.src);
    const unknownUrl = new URL('assets/gauntlet.png', browserUrl).href;
    const imageCache = new Map();
    const imageVersions = new WeakMap();
    let _settingsPromise = null;
    let _atlasPromise = null;

    async function getSettings() {
        if (!_settingsPromise) {
            _settingsPromise = fetch(new URL('api/gauntlet-assets.php', browserUrl), {credentials: 'same-origin', mode: 'same-origin'}).then(async _response => {
                if (!_response.ok) {
                    throw new Error('Gauntlet settings are unavailable.');
                }
                const _settings = await _response.json();
                if (!_settings.gauntlets || typeof _settings.gauntlets !== 'object') {
                    throw new Error('Invalid gauntlet settings.');
                }
                return _settings;
            });
        }
        return _settingsPromise;
    }

    function readDictionary(element) {
        const _values = Object.create(null);
        const _children = Array.from(element.children);
        for (let _index = 0; _index < _children.length; _index += 2) {
            const _key = _children[_index];
            const _value = _children[_index + 1];
            if (_key.tagName !== 'key' || !_value) {
                throw new Error('Invalid gauntlet PLIST dictionary.');
            }
            if (_value.tagName === 'dict') {
                _values[_key.textContent] = readDictionary(_value);
            } else if (_value.tagName === 'true' || _value.tagName === 'false') {
                _values[_key.textContent] = _value.tagName === 'true';
            } else {
                _values[_key.textContent] = _value.textContent;
            }
        }
        return _values;
    }

    function readNumbers(value, count) {
        const _values = String(value ?? '').match(/-?\d+(?:\.\d+)?/g)?.map(Number);
        if (!_values || _values.length !== count || !_values.every(Number.isFinite)) {
            throw new Error('Invalid gauntlet coordinates.');
        }
        return _values;
    }

    async function getAtlas() {
        if (!_atlasPromise) {
            _atlasPromise = (async () => {
                const [_plistResponse, _imageResponse] = await Promise.all([
                    fetch(new URL('assets/GauntletSheet-uhd.plist', browserUrl), {mode: 'same-origin'}),
                    fetch(new URL('assets/GauntletSheet-uhd.png', browserUrl), {mode: 'same-origin'})
                ]);
                if (!_plistResponse.ok || !_imageResponse.ok) {
                    throw new Error('Gauntlet atlas is unavailable.');
                }
                const [_source, _blob] = await Promise.all([_plistResponse.text(), _imageResponse.blob()]);
                if (_source.length > 1000000 || _blob.size > 16000000) {
                    throw new Error('Gauntlet atlas is too large.');
                }
                const _header = new DataView(await _blob.slice(0, 24).arrayBuffer());
                if (_header.byteLength !== 24 || _header.getUint32(0) !== 0x89504e47 || _header.getUint32(4) !== 0x0d0a1a0a || _header.getUint32(12) !== 0x49484452) {
                    throw new Error('Invalid gauntlet PNG.');
                }
                const _width = _header.getUint32(16);
                const _height = _header.getUint32(20);
                if (!_width || !_height || _width > 8192 || _height > 8192) {
                    throw new Error('Invalid gauntlet atlas dimensions.');
                }
                const _document = new DOMParser().parseFromString(_source, 'application/xml');
                const _dictionary = _document.querySelector('plist > dict');
                if (!_dictionary || _document.querySelector('parsererror')) {
                    throw new Error('Invalid gauntlet PLIST.');
                }
                const _frames = readDictionary(_dictionary).frames;
                if (!_frames || Object.keys(_frames).length > 256) {
                    throw new Error('Invalid gauntlet frame list.');
                }
                const _url = URL.createObjectURL(_blob);
                try {
                    const _image = new Image();
                    _image.src = _url;
                    await _image.decode();
                    if (_image.naturalWidth !== _width || _image.naturalHeight !== _height) {
                        throw new Error('Invalid gauntlet texture.');
                    }
                    return {image: _image, width: _width, height: _height, frames: _frames};
                } finally {
                    URL.revokeObjectURL(_url);
                }
            })();
        }
        return _atlasPromise;
    }

    function getFrame(atlas, name) {
        const _data = atlas.frames[name];
        if (!_data) {
            throw new Error('Missing gauntlet frame.');
        }
        const _rect = readNumbers(_data.textureRect, 4);
        const _size = readNumbers(_data.spriteSourceSize, 2);
        const _offset = readNumbers(_data.spriteOffset, 2);
        const _rotated = _data.textureRotated === true;
        const [_x, _y, _width, _height] = _rect;
        if (!_rect.every(Number.isInteger) || _x < 0 || _y < 0 || _width < 1 || _height < 1 || _x + (_rotated ? _height : _width) > atlas.width || _y + (_rotated ? _width : _height) > atlas.height || !_size.every(Number.isInteger) || _size.some(_value => _value < 1 || _value > 4096) || _offset.some(_value => Math.abs(_value) > 4096)) {
            throw new Error('Invalid gauntlet frame bounds.');
        }
        return {rect: _rect, size: _size, offset: _offset, rotated: _rotated};
    }

    function unknownInfo(id) {
        return {id: id, name: 'Unknown', textColor: '', bgColor: '', frame: '', isKnown: false, image: unknownUrl};
    }

    async function getInfo(value, options = {}) {
        const _id = typeof value === 'number' || typeof value === 'string' ? String(value) : '';
        if (!/^[1-9]\d?$/.test(_id) || Number(_id) > 60) {
            return unknownInfo(value);
        }
        try {
            const _settings = await getSettings();
            const _binary = Number(options.binaryVersion ?? _settings.binaryVersion);
            const _info = _settings.gauntlets[_id];
            if (!_info?.isKnown || typeof _info.name !== 'string' || (_id >= 55 && (!Number.isSafeInteger(_binary) || _binary < 46))) {
                return unknownInfo(value);
            }
            const _atlas = await getAtlas();
            getFrame(_atlas, _info.frame);
            return {..._info, id: Number(_id)};
        } catch (_error) {
            return unknownInfo(value);
        }
    }

    async function getImage(value, options = {}) {
        const _info = await getInfo(value, options);
        if (!_info.isKnown) {
            return _info;
        }
        if (!imageCache.has(_info.frame)) {
            const _atlas = await getAtlas();
            const _frame = getFrame(_atlas, _info.frame);
            const [_x, _y, _width, _height] = _frame.rect;
            const _canvas = document.createElement('canvas');
            _canvas.width = _frame.size[0];
            _canvas.height = _frame.size[1];
            const _context = _canvas.getContext('2d');
            _context.translate((_canvas.width - _width) / 2 + _frame.offset[0], (_canvas.height - _height) / 2 - _frame.offset[1]);
            if (_frame.rotated) {
                _context.translate(0, _height);
                _context.rotate(-Math.PI / 2);
            }
            _context.drawImage(_atlas.image, _x, _y, _frame.rotated ? _height : _width, _frame.rotated ? _width : _height, 0, 0, _frame.rotated ? _height : _width, _frame.rotated ? _width : _height);
            imageCache.set(_info.frame, _canvas.toDataURL('image/png'));
            _canvas.width = 0;
            _canvas.height = 0;
        }
        return {..._info, image: imageCache.get(_info.frame)};
    }

    async function setImage(image, value, options = {}) {
        const _version = (imageVersions.get(image) || 0) + 1;
        imageVersions.set(image, _version);
        image.setAttribute('aria-busy', 'true');
        const _info = await getImage(value, options);
        if (imageVersions.get(image) !== _version) {
            return _info;
        }
        image.src = _info.image;
        image.alt = `${_info.name} Gauntlet`;
        image.dataset.gauntletKnown = String(_info.isKnown);
        image.setAttribute('aria-busy', 'false');
        image.dispatchEvent(new CustomEvent('gauntletrendered', {bubbles: true, detail: _info}));
        return _info;
    }

    function renderElements(root = document) {
        const _images = Array.from(root.querySelectorAll('img[data-gauntlet-id]'));
        if (root.matches?.('img[data-gauntlet-id]')) {
            _images.unshift(root);
        }
        return Promise.all(_images.map(_image => {
            const _value = _image.dataset.gauntletId;
            if (_image.dataset.gauntletRequested === _value) {
                return;
            }
            _image.dataset.gauntletRequested = _value;
            return setImage(_image, _value);
        }));
    }

    function clearCache() {
        imageCache.clear();
        _settingsPromise = null;
        _atlasPromise = null;
    }

    window.GDGauntlets = Object.freeze({getInfo, getImage, setImage, renderElements, clearCache});
    const _observer = new MutationObserver(_mutations => {
        for (const _mutation of _mutations) {
            if (_mutation.type === 'attributes') {
                renderElements(_mutation.target);
            } else {
                for (const _node of _mutation.addedNodes) {
                    if (_node.nodeType === Node.ELEMENT_NODE) {
                        renderElements(_node);
                    }
                }
            }
        }
    });
    _observer.observe(document.documentElement, {childList: true, subtree: true, attributes: true, attributeFilter: ['data-gauntlet-id']});
    renderElements();
})();
