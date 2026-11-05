(function() {
    "use strict";

    function create(container, colors, options = {}) {
        const _fragment = document.createDocumentFragment();
        const _entries = Object.entries(colors).sort(([_first, _firstColor], [_second, _secondColor]) => {
            return Number(_firstColor.order ?? _first) - Number(_secondColor.order ?? _second);
        });
        let _group = null;

        for (let _index = 0; _index < _entries.length; _index++) {
            const [_id, _color] = _entries[_index];
            if (_index % 4 === 0) {
                _group = document.createElement('div');
                _group.className = 'colorGroup';
                _fragment.append(_group);
            }
            const _button = document.createElement('button');
            _button.type = 'button';
            _button.className = 'nodesingBtn itemSelector colorBtn color-choice';
            _button.dataset.color = _id;
            _button.setAttribute('idform', _id);
            _button.setAttribute('aria-label', `Color ${_id}`);
            _button.title = `Color ${_id}`;
            const _box = document.createElement('div');
            _box.style.backgroundColor = `rgb(${_color.r}, ${_color.g}, ${_color.b})`;
            _box.setAttribute('aria-hidden', 'true');
            _button.append(_box);
            _button.addEventListener('click', () => {
                setValue(_id);
                if (options.onChange) {
                    options.onChange(Number(_id));
                }
            });
            _group.append(_button);
        }

        container.classList.add('color-selector');
        container.replaceChildren(_fragment);

        function setValue(value) {
            for (const _button of container.querySelectorAll('button')) {
                const _selected = _button.dataset.color === String(value);
                _button.classList.toggle('selectedItem', _selected);
                _button.setAttribute('aria-pressed', String(_selected));
            }
        }

        function scrollToValue(value) {
            const _button = Array.from(container.querySelectorAll('button')).find(_item => _item.dataset.color === String(value));
            if (!_button) {
                return;
            }
            const _bounds = container.getBoundingClientRect();
            const _target = _button.getBoundingClientRect();
            if (_target.left < _bounds.left) {
                container.scrollLeft -= _bounds.left - _target.left + 4;
            } else if (_target.right > _bounds.right) {
                container.scrollLeft += _target.right - _bounds.right + 4;
            }
        }

        setValue(options.value);
        return Object.freeze({setValue, scrollToValue});
    }

    window.GDColorSelector = Object.freeze({create});
})();
