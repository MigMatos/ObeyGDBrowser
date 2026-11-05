(function() {
    "use strict";

    const scriptUrl = document.currentScript.src;
    const browserUrl = new URL("../", scriptUrl);
    const iconPrefixes = Object.freeze({
        cube: "player", ship: "ship", ball: "player_ball", ufo: "bird",
        wave: "dart", robot: "robot", spider: "spider", swing: "swing", jetpack: "jetpack"
    });
    const iconPoses = {
        robot: [
            {part: 3, position: [-7.175, -7.875], scale: [.9969, .9984], rotation: -29.6729, shade: 178 / 255},
            {part: 2, position: [-7.175, -2.025], scale: [.9968, .9984], rotation: 57.9682, shade: 178 / 255},
            {part: 4, position: [-2.675, -11.9], scale: [1, 1], rotation: 0, shade: 178 / 255},
            {part: 1, position: [.25, 4.5], scale: [.9997, .9998], rotation: -2.2859},
            {part: 3, position: [-4.525, -7.625], scale: [.9999, .9999], rotation: -42.9415},
            {part: 2, position: [-5.75, -3.15], scale: [.9994, .9997], rotation: 42.5012},
            {part: 4, position: [2.275, -11.9], scale: [1, 1], rotation: 0}
        ],
        spider: [
            {part: 2, position: [5.025, -8.725], scale: [.8838, .8838], rotation: 0, shade: 127 / 255},
            {part: 2, position: [14.35, -8.725], scale: [-.8838, .8838], rotation: 0, shade: 127 / 255},
            {part: 4, position: [-4.45, -1.925], scale: [1, 1], rotation: -7.6821},
            {part: 1, position: [.575, 2.05], scale: [1, 1], rotation: 0},
            {part: 3, position: [-13.3, -8.9], scale: [.9999, .9999], rotation: 38.964},
            {part: 2, position: [-2.475, -7.975], scale: [1, 1], rotation: 0}
        ]
    };
    const atlasCache = new Map();
    let _configPromise = null;

    function createCanvas(width, height) {
        const _canvas = document.createElement("canvas");
        _canvas.width = width;
        _canvas.height = height;
        return _canvas;
    }

    async function readJson(path) {
        const _response = await fetch(new URL(path, browserUrl), {credentials: "same-origin", mode: "same-origin"});
        if (!_response.ok) throw new Error(`Could not load ${path} (${_response.status}).`);
        return _response.json();
    }

    function getCustomPath(settings) {
        if (!settings || settings.enabled === false || settings.enabled === 0 || settings.enabled === "0") return "";
        const _path = String(settings.path || "").trim().replace(/\/$/, "");
        if (!_path) return "";
        if (!/^[a-zA-Z0-9_\-/]+$/.test(_path) || _path.split("/").some(_part => !_part || _part === "." || _part === "..")) {
            throw new Error("Custom icon path must be a local folder relative to the browser root.");
        }
        return _path;
    }

    function getConfig() {
        if (!_configPromise) {
            _configPromise = readJson("api/icons.php").then(_settings => {
                const _colors = _settings.colors;
                const icons = Object.create(null);
                const colors = Object.create(null);
                const colorOrder = Object.create(null);
                for (const _type of Object.keys(iconPrefixes)) {
                    const _limit = Number(_settings.icons?.[_type]);
                    if (!Number.isSafeInteger(_limit) || _limit < 1) throw new Error(`Invalid icon limit for ${_type}.`);
                    icons[_type] = _limit;
                }
                for (const [_key, _color] of Object.entries(_colors)) {
                    const _channels = [_color.r, _color.g, _color.b];
                    if (/^\d+$/.test(_key) && _channels.every(_channel => Number.isInteger(_channel) && _channel >= 0 && _channel <= 255)) {
                        colors[_key] = Object.freeze(_channels);
                        colorOrder[_key] = Number(_color.order) || 0;
                    }
                }
                const _path = getCustomPath(_settings.customIcons);
                return Object.freeze({
                    icons: Object.freeze(icons), colors: Object.freeze(colors), colorOrder: Object.freeze(colorOrder),
                    customIcons: Object.freeze({enabled: Boolean(_path), path: _path}),
                    iconkit: Object.freeze({enabled: _settings.iconkit?.enabled !== false, cacheSeconds: Math.max(0, Math.min(3600, Number(_settings.iconkit?.cacheSeconds) || 0))}),
                    version: String(_settings.version || "0"),
                    gameVersion: Math.max(0, Number(_settings.gameVersion ?? 22)),
                    binaryVersion: Math.max(0, Number(_settings.binaryVersion ?? 0)),
                    deathEffects: Math.max(0, Math.min(10000, Number(_settings.deathEffects ?? 20)))
                });
            }).catch(_error => {
                _configPromise = null;
                throw _error;
            });
        }
        return _configPromise;
    }

    function readInteger(value, name, min, max) {
        if (!/^\d+$/.test(String(value))) throw new Error(`Invalid ${name}.`);
        const _number = Number(value);
        if (!Number.isSafeInteger(_number) || _number < min || _number > max) {
            throw new Error(`${name} must be between ${min} and ${max}.`);
        }
        return _number;
    }

    function normalizeQuery(query, config) {
        const _params = new URLSearchParams(String(query).replace(/^\?/, ""));
        const _type = (_params.get("type") || "cube").trim().toLowerCase();
        const type = Object.hasOwn(iconPrefixes, _type) ? _type : "cube";
        const _value = Number(_params.get("value") ?? 1);
        const value = Number.isFinite(_value) && Number.isInteger(_value) ? Math.max(1, Math.min(_value, config.icons[type])) : 1;
        const _firstColor = Number(Object.keys(config.colors)[0]);
        const colors = ["color1", "color2", "color3"].map((_name, _index) => {
            const _colorId = Number(_params.get(_name) ?? ["0", "3", "12"][_index]);
            return Number.isInteger(_colorId) && Object.hasOwn(config.colors, _colorId) ? _colorId : _firstColor;
        });
        const _glow = Number(_params.get("glow") ?? 0);
        const glow = Number.isFinite(_glow) && _glow > 0;
        return {type, value, colors, glow};
    }

    function parseDictionary(element) {
        const _dictionary = Object.create(null);
        const _children = Array.from(element.children);
        for (let _index = 0; _index < _children.length; _index += 2) {
            const _key = _children[_index];
            const _value = _children[_index + 1];
            if (_key.tagName !== "key" || !_value) throw new Error("Invalid PLIST dictionary.");
            _dictionary[_key.textContent] = _value.tagName === "dict" ? parseDictionary(_value) :
                _value.tagName === "true" ? true : _value.tagName === "false" ? false : _value.textContent;
        }
        return _dictionary;
    }

    function readNumbers(value, count) {
        const _values = String(value ?? "").match(/-?\d+(?:\.\d+)?/g)?.map(Number);
        if (!_values || _values.length !== count || !_values.every(Number.isFinite)) throw new Error("Invalid PLIST coordinates.");
        return _values;
    }

    function readFrames(source, image) {
        const _document = new DOMParser().parseFromString(source, "application/xml");
        if (_document.querySelector("parsererror")) throw new Error("Invalid PLIST XML.");
        const _dictionary = _document.querySelector("plist > dict");
        if (!_dictionary) throw new Error("Missing PLIST dictionary.");
        const _frames = parseDictionary(_dictionary).frames;
        if (!_frames || typeof _frames !== "object") throw new Error("Missing PLIST frames.");
        const frames = Object.create(null);
        for (const [_name, _frame] of Object.entries(_frames)) {
            const _rect = readNumbers(_frame.textureRect ?? _frame.frame, 4);
            const _offset = readNumbers(_frame.spriteOffset ?? _frame.offset ?? "{0,0}", 2);
            const _size = readNumbers(_frame.spriteSize ?? _frame.sourceSize, 2);
            const _rotated = _frame.textureRotated === true || _frame.rotated === true;
            const [_x, _y, _width, _height] = _rect;
            const _packedWidth = _rotated ? _height : _width;
            const _packedHeight = _rotated ? _width : _height;
            if (![_x, _y, _width, _height, ..._size].every(Number.isInteger) || _x < 0 || _y < 0 ||
                _width < 1 || _height < 1 || _size[0] !== _width || _size[1] !== _height ||
                _x + _packedWidth > image.naturalWidth || _y + _packedHeight > image.naturalHeight ||
                _offset.some(_value => Math.abs(_value) > 8192)) {
                throw new Error("PLIST frame is outside the texture.");
            }
            frames[_name] = {rect: _rect, offset: _offset, rotated: _rotated};
        }
        return frames;
    }

    function loadImage(url) {
        return new Promise((_resolve, _reject) => {
            const _image = new Image();
            _image.onload = () => {
                if (_image.naturalWidth > 8192 || _image.naturalHeight > 8192) {
                    _reject(new Error("Icon texture is too large."));
                } else {
                    _resolve(_image);
                }
            };
            _image.onerror = () => _reject(new Error("Could not decode icon texture."));
            _image.src = url;
        });
    }

    function getFrameNames(type, stem) {
        if (iconPoses[type]) return [1, 2, 3, 4].map(_part => `${stem}_${String(_part).padStart(2, "0")}_001.png`);
        return [`${stem}_001.png`];
    }

    async function loadAtlas(type, value, config, isPreview) {
        const _stem = `${iconPrefixes[type]}_${String(value).padStart(2, "0")}`;
        const _folders = config.customIcons.enabled ? [config.customIcons.path, "assets/gdicons"] : ["assets/gdicons"];
        for (const _folder of [...new Set(_folders)]) {
            const _resolutions = isPreview ? [["-hd", 2], ["", 1], ["-uhd", 4]] : [["-uhd", 4], ["-hd", 2], ["", 1]];
            for (const [_suffix, _resolution] of _resolutions) {
                const _url = new URL(`${_folder}/${_stem}${_suffix}`, browserUrl);
                let _imageUrl = null;
                try {
                    const [_plistResponse, _imageResponse] = await Promise.all([
                        fetch(`${_url}.plist`, {credentials: "same-origin", mode: "same-origin"}),
                        fetch(`${_url}.png`, {credentials: "same-origin", mode: "same-origin"})
                    ]);
                    if (!_plistResponse.ok || !_imageResponse.ok) continue;
                    const [_source, _blob] = await Promise.all([_plistResponse.text(), _imageResponse.blob()]);
                    if (_source.length > 2000000 || _blob.size > 16000000) throw new Error("Icon atlas is too large.");
                    _imageUrl = URL.createObjectURL(_blob);
                    const _image = await loadImage(_imageUrl);
                    const _frames = readFrames(_source, _image);
                    if (!getFrameNames(type, _stem).every(_name => Object.hasOwn(_frames, _name))) continue;
                    return {image: _image, frames: _frames, stem: _stem, resolution: _resolution, path: `${_url}.png`};
                } catch (_error) {
                    if (_error.name === "AbortError") throw _error;
                } finally {
                    if (_imageUrl) URL.revokeObjectURL(_imageUrl);
                }
            }
        }
        throw new Error(`No valid PNG/PLIST found for ${type} ${value}.`);
    }

    function getAtlas(type, value, config, isPreview) {
        const _key = `${type}:${value}:${isPreview ? "preview" : "full"}`;
        if (atlasCache.get(_key)?.expires <= Date.now()) atlasCache.delete(_key);
        if (!atlasCache.has(_key)) {
            const _promise = loadAtlas(type, value, config, isPreview).catch(_error => {
                if (atlasCache.get(_key)?.promise === _promise) atlasCache.delete(_key);
                throw _error;
            });
            atlasCache.set(_key, {promise: _promise, expires: Date.now() + config.iconkit.cacheSeconds * 1000});
            if (atlasCache.size > 24) atlasCache.delete(atlasCache.keys().next().value);
        }
        return atlasCache.get(_key).promise;
    }

    function extractFrame(atlas, frame, color) {
        const [_x, _y, _width, _height] = frame.rect;
        const _canvas = createCanvas(_width, _height);
        const _context = _canvas.getContext("2d");
        if (frame.rotated) {
            _context.translate(0, _height);
            _context.rotate(-Math.PI / 2);
            _context.drawImage(atlas.image, _x, _y, _height, _width, 0, 0, _height, _width);
            _context.setTransform(1, 0, 0, 1, 0, 0);
        } else {
            _context.drawImage(atlas.image, _x, _y, _width, _height, 0, 0, _width, _height);
        }
        if (color) {
            const _pixels = _context.getImageData(0, 0, _width, _height);
            for (let _index = 0; _index < _pixels.data.length; _index += 4) {
                _pixels.data[_index] = Math.round(_pixels.data[_index] * color[0] / 255);
                _pixels.data[_index + 1] = Math.round(_pixels.data[_index + 1] * color[1] / 255);
                _pixels.data[_index + 2] = Math.round(_pixels.data[_index + 2] * color[2] / 255);
            }
            _context.putImageData(_pixels, 0, 0);
        }
        return _canvas;
    }

    function buildLayers(atlas, icon, config) {
        const layers = [];
        const _poses = iconPoses[icon.type] || [{position: [0, 0], scale: [1, 1], rotation: 0}];
        function addLayer(pose, suffix, color) {
            const _part = pose.part ? `_${String(pose.part).padStart(2, "0")}` : "";
            const _frame = atlas.frames[`${atlas.stem}${_part}_${suffix}.png`];
            if (!_frame) return;
            layers.push({frame: _frame, pose, color});
        }
        if (icon.glow) {
            for (const _pose of _poses) addLayer(_pose, "glow_001", config.colors[icon.colors[2]]);
        }
        for (const _pose of _poses) {
            const _shade = _pose.shade ?? 1;
            const _primary = config.colors[icon.colors[0]].map(_channel => Math.round(_channel * _shade));
            const _secondary = config.colors[icon.colors[1]].map(_channel => Math.round(_channel * _shade));
            if (icon.type === "ufo") addLayer(_pose, "3_001", null);
            addLayer(_pose, "2_001", _secondary);
            addLayer(_pose, "001", _primary);
            addLayer(_pose, "extra_001", [255, 255, 255].map(_channel => Math.round(_channel * _shade)));
        }
        return layers;
    }

    function getLayerTransform(layer, resolution) {
        const _angle = layer.pose.rotation * Math.PI / 180;
        const [_scaleX, _scaleY] = layer.pose.scale;
        return new DOMMatrix([
            Math.cos(_angle) * _scaleX, Math.sin(_angle) * _scaleX,
            -Math.sin(_angle) * _scaleY, Math.cos(_angle) * _scaleY,
            layer.pose.position[0], -layer.pose.position[1]
        ]).translate(layer.frame.offset[0] / resolution, -layer.frame.offset[1] / resolution);
    }

    async function render(query, options = {}) {
        const config = await getConfig();
        const icon = normalizeQuery(query, config);
        const size = readInteger(options.size ?? 256, "size", 16, 1024);
        let atlas;
        try {
            atlas = await getAtlas(icon.type, icon.value, config, options.quality === "preview");
        } catch (_error) {
            if (icon.value === 1) throw _error;
            icon.value = 1;
            atlas = await getAtlas(icon.type, 1, config, options.quality === "preview");
        }
        const _layers = buildLayers(atlas, icon, config);
        const _bounds = {left: Infinity, top: Infinity, right: -Infinity, bottom: -Infinity};
        for (const _layer of _layers) {
            _layer.transform = getLayerTransform(_layer, atlas.resolution);
            _layer.width = _layer.frame.rect[2] / atlas.resolution;
            _layer.height = _layer.frame.rect[3] / atlas.resolution;
            for (const _x of [-_layer.width / 2, _layer.width / 2]) {
                for (const _y of [-_layer.height / 2, _layer.height / 2]) {
                    const _point = _layer.transform.transformPoint({x: _x, y: _y});
                    _bounds.left = Math.min(_bounds.left, _point.x);
                    _bounds.top = Math.min(_bounds.top, _point.y);
                    _bounds.right = Math.max(_bounds.right, _point.x);
                    _bounds.bottom = Math.max(_bounds.bottom, _point.y);
                }
            }
        }
        const _scale = size * .88 / Math.max(_bounds.right - _bounds.left, _bounds.bottom - _bounds.top);
        const canvas = createCanvas(size, size);
        const _context = canvas.getContext("2d");
        _context.translate(size / 2, size / 2);
        _context.scale(_scale, _scale);
        _context.translate(-(_bounds.left + _bounds.right) / 2, -(_bounds.top + _bounds.bottom) / 2);
        for (const _layer of _layers) {
            const _frameCanvas = extractFrame(atlas, _layer.frame, _layer.color);
            _context.save();
            const _transform = _layer.transform;
            _context.transform(_transform.a, _transform.b, _transform.c, _transform.d, _transform.e, _transform.f);
            _context.drawImage(_frameCanvas, -_layer.width / 2, -_layer.height / 2, _layer.width, _layer.height);
            _context.restore();
            _frameCanvas.width = 0;
            _frameCanvas.height = 0;
        }
        canvas.dataset.type = icon.type;
        canvas.dataset.value = String(icon.value);
        canvas.dataset.source = atlas.path;
        canvas.dataset.color1 = String(icon.colors[0]);
        canvas.dataset.color2 = String(icon.colors[1]);
        canvas.dataset.color3 = String(icon.colors[2]);
        canvas.dataset.glow = icon.glow ? "1" : "0";
        canvas.setAttribute("role", "img");
        canvas.setAttribute("aria-label", `${icon.type} ${icon.value}`);
        return canvas;
    }

    function clearCache() {
        atlasCache.clear();
        _configPromise = null;
    }

    async function renderElements(root = document) {
        const _elements = Array.from(root.querySelectorAll("gdicon:not([rendered]):not([dontload]):not([data-rendering])"));
        for (const _element of _elements) _element.dataset.rendering = "true";
        let _next = 0;
        async function worker() {
            while (_next < _elements.length) {
                const _element = _elements[_next++];
                _element.dataset.rendering = "true";
                _element.setAttribute("aria-busy", "true");
                try {
                    const _query = new URLSearchParams({type: _element.getAttribute("iconForm") || "cube", value: _element.getAttribute("iconID") || "1", color1: _element.getAttribute("col1") ?? "0", color2: _element.getAttribute("col2") ?? "3", color3: _element.getAttribute("colg") ?? "12", glow: _element.getAttribute("glow") || "0"});
                    const _canvas = await render(_query.toString(), {size: 128});
                    _canvas.className = "gd-icon-canvas";
                    _element.replaceChildren(_canvas);
                    _element.setAttribute("rendered", "true");
                    _element.removeAttribute("title");
                    _element.dispatchEvent(new CustomEvent("gdiconrendered", {bubbles: true, detail: {canvas: _canvas}}));
                } catch (_error) {
                    _element.textContent = "?";
                    _element.title = _error.message;
                } finally {
                    delete _element.dataset.rendering;
                    _element.setAttribute("aria-busy", "false");
                }
            }
        }
        await Promise.all([worker(), worker()]);
    }

    window.GDIcons = Object.freeze({render, renderElements, getConfig, clearCache});
})();
