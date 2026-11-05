// GD Docs https://github.com/gd-docs/gd-docs
(function() {
    "use strict";

    const browserUrl = new URL("../", document.currentScript.src);
    const atlasCache = new Map();
    const renderVersions = new WeakMap();
    let _configPromise = null;

    function normalizeBinaryVersion(value) {
        const _number = Number(value);
        return Number.isSafeInteger(_number) && _number >= 0 && _number <= 100000 ? _number : 0;
    }

    function compatibleText(message, binaryVersion) {
        const _text = String(message ?? "");
        return normalizeBinaryVersion(binaryVersion) >= 49 ? _text : Array.from(_text, _character => _character.codePointAt(0) > 127 ? "?" : _character).join("");
    }

    function resolveAsset(path, extension) {
        if (typeof path !== "string" || !/^[a-zA-Z0-9_-]+(?:\/[a-zA-Z0-9_.-]+)+$/.test(path) || path.split("/").some(_part => _part === "." || _part === "..") || !path.endsWith(extension)) throw new Error("Invalid emoji atlas path.");
        const _url = new URL(path, browserUrl);
        if (_url.origin !== browserUrl.origin || !_url.pathname.startsWith(browserUrl.pathname)) throw new Error("Emoji atlas must stay inside the browser folder.");
        return _url.href;
    }

    function getConfig() {
        if (!_configPromise) {
            _configPromise = fetch(new URL("api/emojis.php", browserUrl), {credentials: "same-origin", mode: "same-origin"}).then(async _response => {
                if (!_response.ok) throw new Error("Could not load emoji settings.");
                const _settings = await _response.json();
                if (!_settings.aliases || !_settings.atlases?.official) throw new Error("Invalid emoji settings.");
                const aliases = Object.create(null);
                const _entries = Object.entries(_settings.aliases);
                if (_entries.length > 1024) throw new Error("Too many emoji aliases.");
                for (const [_name, _value] of _entries) {
                    if (/^[a-zA-Z0-9_]{1,40}$/.test(_name) && /^(?:[0-9]{1,5}f?|[a-zA-Z0-9_-]{1,100}\.png)$/.test(String(_value))) aliases[_name.toLowerCase()] = String(_value);
                }
                const atlases = Object.create(null);
                for (const _name of ["official", "custom"]) {
                    const _atlas = _settings.atlases[_name];
                    if (_atlas) atlases[_name] = Object.freeze({image: resolveAsset(_atlas.image, ".png"), plist: resolveAsset(_atlas.plist, ".plist")});
                }
                return Object.freeze({enabled: _settings.enabled === true, binaryVersion: normalizeBinaryVersion(_settings.binaryVersion), maxPerMessage: Math.max(0, Math.min(50, Number(_settings.maxPerMessage) || 0)), aliases: Object.freeze(aliases), atlases: Object.freeze(atlases), version: String(_settings.version || "0")});
            }).catch(_error => { _configPromise = null; throw _error; });
        }
        return _configPromise;
    }

    function parseDictionary(element) {
        const _result = Object.create(null);
        const _children = Array.from(element.children);
        for (let _index = 0; _index < _children.length; _index += 2) {
            const _key = _children[_index];
            const _value = _children[_index + 1];
            if (_key.tagName !== "key" || !_value) throw new Error("Invalid emoji PLIST dictionary.");
            _result[_key.textContent] = _value.tagName === "dict" ? parseDictionary(_value) : _value.tagName === "true" ? true : _value.tagName === "false" ? false : _value.textContent;
        }
        return _result;
    }

    function readNumbers(value, count) {
        const _values = String(value ?? "").match(/-?\d+(?:\.\d+)?/g)?.map(Number);
        if (!_values || _values.length !== count || !_values.every(Number.isFinite)) throw new Error("Invalid emoji PLIST coordinates.");
        return _values;
    }

    function readFrames(source, width, height) {
        const _document = new DOMParser().parseFromString(source, "application/xml");
        if (_document.querySelector("parsererror")) throw new Error("Invalid emoji PLIST XML.");
        const _dictionary = _document.querySelector("plist > dict");
        if (!_dictionary) throw new Error("Missing emoji PLIST dictionary.");
        const _frames = parseDictionary(_dictionary).frames;
        if (!_frames || typeof _frames !== "object" || Object.keys(_frames).length > 10000) throw new Error("Invalid emoji frame list.");
        const frames = Object.create(null);
        for (const [_name, _data] of Object.entries(_frames)) {
            const _rect = readNumbers(_data.textureRect ?? _data.frame, 4);
            const _offset = readNumbers(_data.spriteOffset ?? _data.offset ?? "{0,0}", 2);
            const _size = readNumbers(_data.spriteSourceSize ?? _data.sourceSize ?? _data.spriteSize, 2);
            const _rotated = _data.textureRotated === true || _data.rotated === true;
            const [_x, _y, _frameWidth, _frameHeight] = _rect;
            if (!_rect.every(Number.isInteger) || _x < 0 || _y < 0 || _frameWidth < 1 || _frameHeight < 1 || _x + (_rotated ? _frameHeight : _frameWidth) > width || _y + (_rotated ? _frameWidth : _frameHeight) > height || _size.some(_value => _value < 1 || _value > 4096) || _offset.some(_value => Math.abs(_value) > 4096)) throw new Error("Emoji frame is outside the atlas.");
            frames[_name] = {rect: _rect, offset: _offset, sourceSize: _size, rotated: _rotated};
        }
        return frames;
    }

    async function loadAtlas(paths) {
        const [_plistResponse, _imageResponse] = await Promise.all([
            fetch(paths.plist, {credentials: "same-origin", mode: "same-origin"}),
            fetch(paths.image, {credentials: "same-origin", mode: "same-origin"})
        ]);
        if (!_plistResponse.ok || !_imageResponse.ok) throw new Error("Emoji atlas is unavailable.");
        const [_source, _blob] = await Promise.all([_plistResponse.text(), _imageResponse.blob()]);
        if (_source.length > 4000000 || _blob.size > 16000000) throw new Error("Emoji atlas is too large.");
        const _header = new DataView(await _blob.slice(0, 24).arrayBuffer());
        if (_header.byteLength !== 24 || _header.getUint32(0) !== 0x89504e47 || _header.getUint32(4) !== 0x0d0a1a0a || _header.getUint32(12) !== 0x49484452) throw new Error("Emoji atlas must be a PNG image.");
        const _width = _header.getUint32(16);
        const _height = _header.getUint32(20);
        if (!_width || !_height || _width > 4096 || _height > 4096) throw new Error("Invalid emoji atlas dimensions.");
        const _frames = readFrames(_source, _width, _height);
        const _url = URL.createObjectURL(_blob);
        try {
            const _image = new Image();
            _image.src = _url;
            await _image.decode();
            if (_image.naturalWidth !== _width || _image.naturalHeight !== _height) throw new Error("Invalid emoji texture.");
            return {url: _url, image: _image, width: _width, height: _height, frames: _frames};
        } catch (_error) {
            URL.revokeObjectURL(_url);
            throw _error;
        }
    }

    function getAtlas(paths) {
        const _key = `${paths.image}:${paths.plist}`;
        if (!atlasCache.has(_key)) {
            const _promise = loadAtlas(paths);
            atlasCache.set(_key, _promise);
        }
        return atlasCache.get(_key);
    }

    function getFrameReference(value) {
        if (/^\d+f?$/.test(value)) {
            const _id = value.replace(/f$/, "");
            return {name: `particle_${_id.padStart(2, "0")}_001.png`, position: Number(_id), flipped: value.endsWith("f")};
        }
        return {name: value, position: null, flipped: false};
    }

    async function findFrame(reference, config) {
        for (const _name of ["custom", "official"]) {
            if (!config.atlases[_name]) continue;
            try {
                const _atlas = await getAtlas(config.atlases[_name]);
                if (Object.hasOwn(_atlas.frames, reference.name)) return {atlas: _atlas, frame: _atlas.frames[reference.name]};
            } catch (_error) {
                if (_name === "official") return null;
            }
        }
        return null;
    }

    function createEmoji(raw, reference, source) {
        const _emoji = document.createElement("span");
        _emoji.className = "gd-emoji";
        _emoji.title = raw;
        _emoji.setAttribute("role", "img");
        _emoji.setAttribute("aria-label", raw);
        _emoji.dataset.shortcode = raw;
        _emoji.dataset.frame = reference.name;
        if (reference.position !== null) _emoji.dataset.position = String(reference.position);
        if (reference.flipped) _emoji.dataset.flipped = "true";
        const [_x, _y, _width, _height] = source.frame.rect;
        const [_sourceWidth, _sourceHeight] = source.frame.sourceSize;
        const _unit = 1.25 / _sourceHeight;
        _emoji.style.width = `${_sourceWidth * _unit}em`;
        const _crop = document.createElement("span");
        _crop.className = "gd-emoji-crop";
        _crop.setAttribute("aria-hidden", "true");
        Object.assign(_crop.style, {left: `${(_sourceWidth / 2 + source.frame.offset[0] - _width / 2) * _unit}em`, top: `${(_sourceHeight / 2 - source.frame.offset[1] - _height / 2) * _unit}em`, width: `${_width * _unit}em`, height: `${_height * _unit}em`});
        const _sprite = document.createElement("span");
        _sprite.className = "gd-emoji-sprite";
        Object.assign(_sprite.style, {width: `${(source.frame.rotated ? _height : _width) * _unit}em`, height: `${(source.frame.rotated ? _width : _height) * _unit}em`, backgroundImage: `url("${source.atlas.url}")`, backgroundSize: `${source.atlas.width * _unit}em ${source.atlas.height * _unit}em`, backgroundPosition: `${-_x * _unit}em ${-_y * _unit}em`});
        if (source.frame.rotated) _sprite.style.transform = `translateY(${_height * _unit}em) rotate(-90deg)`;
        _crop.append(_sprite);
        _emoji.append(_crop);
        return _emoji;
    }

    function isEnabled(config, options) {
        return (options.enabled ?? config.enabled) === true && normalizeBinaryVersion(options.binaryVersion ?? config.binaryVersion) >= 51;
    }

    async function renderEmoji(shortcode, options = {}) {
        const _raw = String(shortcode);
        const _name = _raw.replace(/^:|:$/g, "").toLowerCase();
        const _config = await getConfig();
        if (!isEnabled(_config, options) || !Object.hasOwn(_config.aliases, _name)) return document.createTextNode(_raw);
        const _reference = getFrameReference(_config.aliases[_name]);
        const _source = await findFrame(_reference, _config);
        return _source ? createEmoji(_raw, _reference, _source) : document.createTextNode(_raw);
    }

    async function renderText(message, options = {}) {
        const _config = await getConfig();
        const _text = compatibleText(message, options.binaryVersion ?? _config.binaryVersion);
        if (_text.length > 50000) throw new Error("Text is too long.");
        const _fragment = document.createDocumentFragment();
        if (!isEnabled(_config, options)) { _fragment.append(document.createTextNode(_text)); return _fragment; }
        const _requestedMax = Number(options.max ?? _config.maxPerMessage);
        const _max = Number.isInteger(_requestedMax) && _requestedMax >= 0 ? Math.min(_requestedMax || 256, 256) : _config.maxPerMessage || 256;
        let _cursor = 0;
        let _replaced = 0;
        for (const _match of _text.matchAll(/:[a-zA-Z0-9_]{1,40}:/g)) {
            if (_replaced >= _max) break;
            const _name = _match[0].slice(1, -1).toLowerCase();
            if (!Object.hasOwn(_config.aliases, _name)) continue;
            const _reference = getFrameReference(_config.aliases[_name]);
            const _source = await findFrame(_reference, _config);
            if (!_source) continue;
            _fragment.append(document.createTextNode(_text.slice(_cursor, _match.index)), createEmoji(_match[0], _reference, _source));
            _cursor = _match.index + _match[0].length;
            _replaced++;
        }
        _fragment.append(document.createTextNode(_text.slice(_cursor)));
        return _fragment;
    }

    async function renderInto(element, message, options = {}) {
        const _version = (renderVersions.get(element) || 0) + 1;
        renderVersions.set(element, _version);
        const _fragment = await renderText(message, options);
        if (renderVersions.get(element) === _version) element.replaceChildren(_fragment);
    }

    function clearCache() {
        for (const _promise of atlasCache.values()) _promise.then(_atlas => URL.revokeObjectURL(_atlas.url)).catch(() => {});
        atlasCache.clear();
        _configPromise = null;
    }

    window.GDEmojis = Object.freeze({getConfig, renderEmoji, renderText, renderInto, compatibleText, clearCache});
})();
