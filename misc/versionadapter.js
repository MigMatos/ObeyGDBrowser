(function() {
    "use strict";

    const hiddenStyles = new WeakMap();
    const disabledStates = new WeakMap();
    const modeVersions = Object.freeze({
        cube: 0,
        ship: 0,
        ball: 12,
        ufo: 15,
        wave: 19,
        robot: 20,
        spider: 21,
        swing: 22,
        jetpack: 22
    });

    function getGameVersion(value) {
        const _version = Number(value);
        if (!Number.isFinite(_version) || _version < 0) {
            return 0;
        }
        if (_version >= 1 && _version <= 7 && Number.isInteger(_version)) {
            return _version + 9;
        }
        if (_version === 10) {
            return 17;
        }
        return _version;
    }

    function currentVersions(options) {
        const _game = options.gameVersion ?? (typeof gdpsVersion === 'undefined' ? 22 : gdpsVersion);
        const _binary = options.binaryVersion ?? (typeof gdpsBinaryVersion === 'undefined' ? 0 : gdpsBinaryVersion);
        const _binaryNumber = Number(_binary);
        return {
            gameVersion: getGameVersion(_game),
            binaryVersion: Number.isSafeInteger(_binaryNumber) && _binaryNumber > 0 ? _binaryNumber : null
        };
    }

    function isModeAvailable(type, options = {}) {
        const _version = currentVersions(options).gameVersion;
        return Object.hasOwn(modeVersions, type) && _version >= modeVersions[type];
    }

    function readRange(value, binary) {
        const _pattern = binary ? /^gdItemBinary(\d+)(?:-(?:gdItemBinary)?(\d+))?$/ : /^gdItem(\d+)(?:-(?:gdItem)?(\d+))?$/;
        const _match = value.match(_pattern);
        if (!_match) {
            return null;
        }
        return {min: Number(_match[1]), max: _match[2] ? Number(_match[2]) : Infinity};
    }

    function matchesRange(version, range) {
        return !range || (version >= range.min && version <= range.max);
    }

    function setDisabled(element, isDisabled) {
        if (isDisabled && !disabledStates.has(element)) {
            const _controls = Array.from(element.querySelectorAll('a, button, input, select, textarea, [tabindex]'));
            if (element.matches('a, button, input, select, textarea, [tabindex]')) {
                _controls.unshift(element);
            }
            disabledStates.set(element, {
                gray: element.classList.contains('gray'),
                aria: element.getAttribute('aria-disabled'),
                controls: _controls.map(_control => ({element: _control, disabled: _control.disabled, tabIndex: _control.getAttribute('tabindex')}))
            });
            element.classList.add('gray');
            element.setAttribute('aria-disabled', 'true');
            element.dataset.versionDisabled = 'true';
            for (const _control of _controls) {
                _control.tabIndex = -1;
                if ('disabled' in _control) {
                    _control.disabled = true;
                }
            }
        } else if (!isDisabled && disabledStates.has(element)) {
            const _state = disabledStates.get(element);
            element.classList.toggle('gray', _state.gray);
            if (_state.aria === null) {
                element.removeAttribute('aria-disabled');
            } else {
                element.setAttribute('aria-disabled', _state.aria);
            }
            delete element.dataset.versionDisabled;
            for (const _control of _state.controls) {
                if (_control.tabIndex === null) {
                    _control.element.removeAttribute('tabindex');
                } else {
                    _control.element.setAttribute('tabindex', _control.tabIndex);
                }
                if (_control.disabled !== undefined) {
                    _control.element.disabled = _control.disabled;
                }
            }
            disabledStates.delete(element);
        }
    }

    function apply(root = document, options = {}) {
        const _versions = currentVersions(options);
        const _elements = root.querySelectorAll('[id^="gdItem"], [class*="gdItem"], [data-min-binary-version], [data-max-binary-version], [data-enable-binary-version]');
        for (const _element of _elements) {
            const _classes = Array.from(_element.classList);
            const _gameClasses = _classes.map(_name => readRange(_name, false)).filter(Boolean);
            const _binaryClasses = _classes.map(_name => readRange(_name, true)).filter(Boolean);
            const _gameRanges = _gameClasses.length ? _gameClasses : [readRange(_element.id, false)];
            const _binaryRanges = _binaryClasses.length ? _binaryClasses : [readRange(_element.id, true)];
            const _minBinary = Number(_element.getAttribute('data-min-binary-version') ?? 0);
            const _maxBinary = Number(_element.getAttribute('data-max-binary-version') ?? Infinity);
            const _hasBinaryVersion = _versions.binaryVersion !== null;
            const _binaryVisible = !_hasBinaryVersion || (_binaryRanges.every(_range => matchesRange(_versions.binaryVersion, _range)) &&
                _versions.binaryVersion >= _minBinary && _versions.binaryVersion <= _maxBinary);
            const _isVisible = _gameRanges.every(_range => matchesRange(_versions.gameVersion, _range)) && _binaryVisible;
            const _enableBinary = Number(_element.getAttribute('data-enable-binary-version') ?? 0);
            setDisabled(_element, _isVisible && _hasBinaryVersion && _versions.binaryVersion < _enableBinary);

            if (!_isVisible) {
                if (!hiddenStyles.has(_element)) {
                    hiddenStyles.set(_element, {
                        value: _element.style.getPropertyValue('display'),
                        priority: _element.style.getPropertyPriority('display')
                    });
                }
                _element.style.setProperty('display', 'none', 'important');
            } else if (hiddenStyles.has(_element)) {
                const _original = hiddenStyles.get(_element);
                if (_original.value) {
                    _element.style.setProperty('display', _original.value, _original.priority);
                } else {
                    _element.style.removeProperty('display');
                }
                hiddenStyles.delete(_element);
            }
        }
    }

    window.GDVersionAdapter = Object.freeze({apply, getGameVersion, isModeAvailable, modeVersions});
    function preventDisabledAction(event) {
        if (event.type === 'keydown' && event.key !== 'Enter' && event.key !== ' ') {
            return;
        }
        if (event.target.closest?.('[data-version-disabled="true"]')) {
            event.preventDefault();
            event.stopImmediatePropagation();
        }
    }
    document.addEventListener('click', preventDisabledAction, true);
    document.addEventListener('keydown', preventDisabledAction, true);
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => apply(), {once: true});
    } else {
        apply();
    }
})();
