(function() {
    "use strict";

    const sliders = new WeakMap();

    function create(input, options = {}) {
        if (!(input instanceof HTMLInputElement) || input.type !== 'range') {
            throw new TypeError('GDSlider requires a range input.');
        }
        if (sliders.has(input)) {
            return sliders.get(input);
        }
        const root = document.createElement('div');
        root.className = 'gd-slider';
        const _visual = document.createElement('div');
        _visual.className = 'gd-slider-visual';
        _visual.setAttribute('aria-hidden', 'true');
        for (const _part of ['fill', 'contour', 'thumb']) {
            const _element = document.createElement('span');
            _element.className = `gd-slider-${_part}`;
            _visual.append(_element);
        }
        input.before(root);
        root.append(_visual, input);
        const _events = new AbortController();

        function getValue() {
            return Number(input.value);
        }

        function getPercent() {
            const _range = Number(input.max) - Number(input.min);
            return _range > 0 ? Math.max(0, Math.min(100, (getValue() - Number(input.min)) / _range * 100)) : 0;
        }

        function paint() {
            root.style.setProperty('--slider-progress', `${getPercent()}%`);
            root.classList.toggle('is-disabled', input.disabled);
            input.setAttribute('aria-valuetext', options.formatValue ? options.formatValue(getValue()) : String(getValue()));
        }

        function setValue(value, emit = false) {
            const _number = Number(value);
            const _min = Number(input.min);
            const _max = Number(input.max);
            const _step = Number(input.step);
            const _clamped = Number.isFinite(_number) ? Math.max(_min, Math.min(_max, _number)) : _min;
            const _snapped = _min + Math.round((_clamped - _min) / _step) * _step;
            input.value = String(Math.max(_min, Math.min(_max, Number(_snapped.toFixed(10)))));
            paint();
            if (emit && !input.disabled) {
                input.dispatchEvent(new Event('input', {bubbles: true}));
            }
            return getValue();
        }

        function setRange(min, max, step = Number(input.step) || 1) {
            const _min = Number(min);
            const _max = Number(max);
            const _step = Number(step);
            if (!Number.isFinite(_min) || !Number.isFinite(_max) || !Number.isFinite(_step) || _min > _max || _step <= 0) {
                throw new RangeError('Invalid slider range.');
            }
            const _value = getValue();
            input.min = String(_min);
            input.max = String(_max);
            input.step = String(_step);
            setValue(_value);
        }

        function setDisabled(value) {
            input.disabled = Boolean(value);
            paint();
        }

        function setPercent(value, emit = false) {
            const _number = Number(value);
            const _percent = Number.isFinite(_number) ? Math.max(0, Math.min(100, _number)) : 0;
            return setValue(Number(input.min) + (Number(input.max) - Number(input.min)) * _percent / 100, emit);
        }

        input.addEventListener('input', () => {
            setValue(input.value);
            if (!input.disabled && options.onInput) {
                options.onInput(getValue(), getPercent());
            }
        }, {signal: _events.signal});
        input.addEventListener('change', () => {
            if (!input.disabled && options.onChange) {
                options.onChange(getValue(), getPercent());
            }
        }, {signal: _events.signal});
        setRange(options.min ?? input.min ?? 0, options.max ?? (input.max || 100), options.step ?? (input.step || 1));
        setValue(options.value ?? input.value);
        setDisabled(options.disabled ?? input.disabled);
        const slider = Object.freeze({
            input, root, getValue, getPercent, setValue, setPercent, setRange, setDisabled,
            destroy() {
                _events.abort();
                root.before(input);
                root.remove();
                sliders.delete(input);
            }
        });
        sliders.set(input, slider);
        return slider;
    }

    window.GDSlider = Object.freeze({create});
})();
