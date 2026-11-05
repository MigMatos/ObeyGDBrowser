const loadingAssetUrl = new URL('../', document.currentScript.src);
let _loadingHideTimer = null;

function debounce(func, wait) {
    let _timeout;

    return function executedFunction(...args) {
        const _overlay = document.getElementById('loading-main');
        clearTimeout(_timeout);
        if (_overlay) {
            _overlay.style.display = 'flex';
        }
        _timeout = setTimeout(() => {
            if (_overlay) {
                _overlay.style.display = 'none';
            }
            func(...args);
        }, wait);
    };
}

document.addEventListener('initLoadingAlert', function() {
    const _alert = document.getElementById('loading-alert-buttom-display');
    clearTimeout(_loadingHideTimer);
    if (!_alert) {
        return;
    }
    _alert.style.display = 'flex';
    _alert.classList.remove('hidden');
    changeLoadingAlert();
});

document.addEventListener('finishLoadingAlert', function() {
    const _alert = document.getElementById('loading-alert-buttom-display');
    if (!_alert) {
        return;
    }
    _alert.classList.add('hidden');
    clearTimeout(_loadingHideTimer);
    _loadingHideTimer = setTimeout(() => {
        _alert.style.display = 'none';
    }, 1000);
});

function changeLoadingAlert(message = 'Loading...', status = 'load') {
    const _text = document.getElementById('loading-alert-buttom-display-text');
    const _icon = document.getElementById('alert-buttom-icon');
    const _files = {load: 'loading.png', done: 'check.png', error: 'x.png'};
    if (_text) {
        _text.textContent = message;
    }
    if (!_icon || !Object.hasOwn(_files, status)) {
        return;
    }
    _icon.src = new URL(_files[status], loadingAssetUrl).href;
    _icon.className = status;
}
