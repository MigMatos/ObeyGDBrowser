(function() {
    'use strict';

    const browserUrl = new URL('../', document.currentScript.src);
    const apiUrl = new URL('api/thumbnails.php', browserUrl);
    const isModeration = document.body.dataset.moderation === '1';
    const elements = id => document.getElementById(id);
    const dialog = elements('thumbnailReview');
    let _identity = null;
    let _status = 'pending';
    let _page = 0;
    let _editing = null;
    let _review = null;
    let _previewUrl = '';
    let _poll = null;
    let _listingVersion = 0;
    let _reviewVersion = 0;
    let _busy = false;
    let _queueSignature = '';

    function notice(message) {
        const _notice = elements('thumbnailNotice');
        _notice.hidden = !message;
        _notice.querySelector('p').textContent = message;
    }

    async function request(params, body = null) {
        const _url = new URL(apiUrl);
        _url.search = new URLSearchParams(params).toString();
        const _response = await fetch(_url, {method: body ? 'POST' : 'GET', body, credentials: 'same-origin', cache: 'no-store'});
        const _data = await _response.json();
        if (!_response.ok) {
            const _error = new Error(`[${_data.code || _response.status}] ${_data.error || 'The request failed.'}`);
            _error.status = _response.status;
            throw _error;
        }
        return _data;
    }

    function previewUrl(item, size = 'small') {
        const _url = new URL(apiUrl);
        _url.search = new URLSearchParams({action: 'preview', id: item.id, revision: item.revision, size}).toString();
        return _url.href;
    }

    function textNode(tag, text, className = '') {
        const _node = document.createElement(tag);
        _node.textContent = text;
        _node.className = className;
        return _node;
    }

    function button(text, callback, className = '') {
        const _button = textNode('button', text, `gdsButton ${className}`);
        _button.type = 'button';
        _button.addEventListener('click', callback);
        return _button;
    }

    function resetForm(item = null) {
        _editing = item?.status === 'approved' ? null : item;
        elements('thumbnailForm').reset();
        elements('thumbnailFilename').textContent = 'No image selected';
        elements('thumbnailFormTitle').textContent = _editing ? `Edit submission #${item.id}` : item ? 'Propose a replacement' : 'Submit a thumbnail';
        elements('thumbnailCancelEdit').hidden = !item;
        elements('thumbnailLevelID').value = item?.levelID || '';
        elements('thumbnailLevelID').readOnly = Boolean(_editing);
        elements('thumbnailFindLevel').disabled = Boolean(_editing);
        elements('thumbnailLevels').disabled = Boolean(_editing);
        clearPreview();
        if (item) {
            elements('thumbnailForm').scrollIntoView({behavior: 'smooth', block: 'start'});
            elements('thumbnailFile').focus({preventScroll: true});
        }
    }

    function renderItem(item) {
        const _row = document.createElement('article');
        _row.className = 'thumbnail-row';
        _row.dataset.submissionId = item.id;
        _row.dataset.revision = item.revision;
        const _image = document.createElement('img');
        _image.src = previewUrl(item);
        _image.loading = 'lazy';
        _image.alt = `Thumbnail for ${item.levelName || `level ${item.levelID}`}`;
        const _details = document.createElement('div');
        const _link = textNode('a', `${item.levelName || 'Deleted level'} #${item.levelID}`, 'gdButton');
        _link.href = new URL(`level/index.php?id=${item.levelID}`, browserUrl);
        const _title = document.createElement('h3');
        _title.append(_link);
        _details.append(_title, textNode('p', `By ${item.userName || 'Unknown'} · Submission #${item.id} · Revision ${item.revision}`));
        _details.append(textNode('p', `${item.requestCount} pending for this level · ${item.imageWidth}×${item.imageHeight} · ${new Date(item.updatedAt * 1000).toLocaleString()}`));
        if (item.lastAction === 'edited') {
            _details.append(textNode('p', 'Changed by the submitter. Review the new image.'));
        }
        if (item.reason) {
            _details.append(textNode('p', `Moderator feedback: ${item.reason}`));
        }
        if (item.status === 'approved') {
            _details.append(textNode('p', item.publishedID === item.id ? 'Currently published' : 'Accepted history · Replaced by a newer thumbnail'));
        }
        const _actions = document.createElement('div');
        _actions.className = 'thumbnail-actions';
        if (isModeration && item.status === 'pending') {
            _actions.classList.add('modActionBox');
            _actions.append(button('Review', () => openReview(item)));
        } else if (!isModeration) {
            _actions.append(button(item.status === 'approved' ? 'Propose replacement' : item.status === 'rejected' ? 'Improve and resubmit' : 'Edit pending image', () => resetForm(item)));
        }
        _details.append(_actions);
        _row.append(_image, _details);
        return _row;
    }

    async function loadList(isPoll = false) {
        const _version = ++_listingVersion;
        try {
            const _params = {action: 'list', status: _status, sort: elements('thumbnailSort').value, page: _page};
            if (isModeration) {
                _params.scope = 'moderation';
            }
            if (elements('thumbnailFilterLevel').value) {
                _params.levelID = elements('thumbnailFilterLevel').value;
            }
            const _data = await request(_params);
            if (_version !== _listingVersion) {
                return;
            }
            const _signature = JSON.stringify([_data.total, _data.items.map(_item => [_item.id, _item.revision, _item.publishedID])]);
            if (isPoll && isModeration && _queueSignature && _signature !== _queueSignature) {
                notice('The review queue changed. New or edited submissions require a fresh review.');
            }
            _queueSignature = _signature;
            elements('thumbnailSubmissions').replaceChildren(..._data.items.map(renderItem));
            elements('thumbnailQueueStatus').textContent = _data.total ? `${_data.total} submissions` : 'No submissions in this tab.';
            elements('thumbnailPage').textContent = `Page ${_page + 1} of ${Math.max(1, Math.ceil(_data.total / 20))}`;
            elements('thumbnailPrevious').disabled = _page === 0;
            elements('thumbnailNext').disabled = (_page + 1) * 20 >= _data.total;
            if (dialog.open && _review) {
                const _current = _data.items.find(_item => _item.id === _review.id);
                if (!_current || _current.revision !== _review.revision || _current.publishedID !== _review.publishedID) {
                    elements('thumbnailReviewNotice').textContent = 'This submission or its published image changed. Close this review and reopen the updated preview.';
                    elements('thumbnailApprove').disabled = true;
                    elements('thumbnailReject').disabled = true;
                }
            }
        } catch (_error) {
            if (!isPoll) {
                notice(_error.message);
                elements('thumbnailNotice').focus();
            }
        }
    }

    function loadReviewImage(image, url) {
        return new Promise((_resolve, _reject) => {
            image.onload = _resolve;
            image.onerror = () => _reject(new Error('The preview could not be loaded. Reload before reviewing.'));
            image.src = url;
        });
    }

    async function openReview(item) {
        _review = item;
        const _version = ++_reviewVersion;
        elements('thumbnailReviewTitle').textContent = `${item.levelName || 'Level'} #${item.levelID}`;
        elements('thumbnailReviewDetails').textContent = `Submission #${item.id} · Revision ${item.revision} · By ${item.userName || 'Unknown'}`;
        elements('thumbnailReason').value = '';
        elements('thumbnailReplace').checked = false;
        elements('thumbnailReplaceLabel').hidden = !item.publishedID;
        elements('thumbnailPublished').hidden = !item.publishedID;
        elements('thumbnailApprove').disabled = true;
        elements('thumbnailReject').disabled = true;
        elements('thumbnailReviewNotice').textContent = 'Loading the current revision…';
        dialog.showModal();
        try {
            const _loads = [loadReviewImage(elements('thumbnailReviewImage'), previewUrl(item, 'full'))];
            if (item.publishedID) {
                _loads.push(loadReviewImage(elements('thumbnailPublished').querySelector('img'), new URL(`thumbnail/index.php?id=${item.levelID}&format=webp&v=${item.publishedID}`, browserUrl)));
            }
            await Promise.all(_loads);
            if (_version === _reviewVersion && dialog.open) {
                elements('thumbnailReviewNotice').textContent = item.publishedID ? 'A thumbnail is already published. Confirm replacement to approve this one.' : 'The first approval publishes this image. Later approvals require replacement confirmation.';
                elements('thumbnailApprove').disabled = false;
                elements('thumbnailReject').disabled = false;
            }
        } catch (_error) {
            elements('thumbnailReviewNotice').textContent = _error.message;
        }
    }

    async function review(decision) {
        if (_busy || !_review) {
            return;
        }
        if (decision === 'reject' && !elements('thumbnailReason').value.trim()) {
            elements('thumbnailReviewNotice').textContent = 'Include a reason or suggestions before rejecting.';
            elements('thumbnailReason').focus();
            return;
        }
        if (decision === 'approve' && _review.publishedID && !elements('thumbnailReplace').checked) {
            elements('thumbnailReviewNotice').textContent = 'Confirm replacement of the current published thumbnail.';
            elements('thumbnailReplace').focus();
            return;
        }
        _busy = true;
        elements('thumbnailApprove').disabled = true;
        elements('thumbnailReject').disabled = true;
        const _body = new FormData();
        Object.entries({action: 'review', token: _identity.token, id: _review.id, revision: _review.revision, decision, reason: elements('thumbnailReason').value, publishedID: _review.publishedID, replace: elements('thumbnailReplace').checked ? '1' : '0'}).forEach(([_key, _value]) => _body.set(_key, _value));
        try {
            await request({}, _body);
            dialog.close();
            notice(decision === 'approve' ? 'Thumbnail approved.' : 'Submission rejected. Feedback is available to its submitter.');
            await loadList();
        } catch (_error) {
            elements('thumbnailReviewNotice').textContent = _error.message;
            if (_error.status !== 409) {
                elements('thumbnailApprove').disabled = false;
                elements('thumbnailReject').disabled = false;
            }
        } finally {
            _busy = false;
        }
    }

    function clearPreview() {
        if (_previewUrl) {
            URL.revokeObjectURL(_previewUrl);
            _previewUrl = '';
        }
        elements('thumbnailUploadPreview').hidden = true;
        elements('thumbnailUploadPreview').removeAttribute('src');
    }

    async function initialize() {
        try {
            _identity = await request({action: 'session'});
            if (isModeration && !_identity.canModerate) {
                notice('Thumbnail approval permission is required.');
                return;
            }
            elements('thumbnailWorkspace').hidden = false;
            elements('moderateThumbnails').hidden = isModeration || !_identity.canModerate;
            elements('thumbnailInstall').hidden = !isModeration || !_identity.isAdmin;
            await loadList();
            _poll = setInterval(() => {
                if (!document.hidden && !_busy) {
                    loadList(true);
                }
            }, 30000);
        } catch (_error) {
            elements('thumbnailGuest').hidden = _error.status !== 401;
            notice(_error.message);
        }
    }

    elements('thumbnailTabs').addEventListener('click', _event => {
        const _tab = _event.target.closest('[data-status]');
        if (_tab) {
            _status = _tab.dataset.status;
            _page = 0;
            elements('thumbnailTabs').querySelectorAll('button').forEach(_button => {
                _button.setAttribute('aria-pressed', String(_button === _tab));
                _button.setAttribute('activetab', _button === _tab ? 'on' : 'off');
            });
            loadList();
        }
    });
    elements('thumbnailRefresh').addEventListener('click', () => loadList());
    elements('thumbnailSort').addEventListener('change', () => {
        _page = 0;
        loadList();
    });
    elements('thumbnailFilterLevel').addEventListener('change', () => {
        _page = 0;
        loadList();
    });
    elements('thumbnailPrevious').addEventListener('click', () => {
        _page = Math.max(0, _page - 1);
        loadList();
    });
    elements('thumbnailNext').addEventListener('click', () => {
        _page++;
        loadList();
    });
    elements('thumbnailReviewClose').addEventListener('click', () => dialog.close());
    dialog.addEventListener('close', () => {
        _reviewVersion++;
        _review = null;
    });
    elements('thumbnailReviewForm').addEventListener('submit', _event => _event.preventDefault());
    elements('thumbnailApprove').addEventListener('click', () => review('approve'));
    elements('thumbnailReject').addEventListener('click', () => review('reject'));
    elements('thumbnailLogin').addEventListener('click', () => openGdCustomFrame(new URL('account/checkLogin.php', browserUrl).href));
    elements('thumbnailInstall').addEventListener('click', async () => {
        const _body = new FormData();
        _body.set('action', 'install');
        _body.set('token', _identity.token);
        try {
            await request({}, _body);
            notice('Thumbnail tables and ogdwApproveThumbnails are ready.');
            await loadList();
        } catch (_error) {
            notice(_error.message);
        }
    });
    if (!isModeration) {
        elements('thumbnailChooseImage').addEventListener('click', () => elements('thumbnailFile').click());
        elements('thumbnailCancelEdit').addEventListener('click', () => resetForm());
        elements('thumbnailFindLevel').addEventListener('click', () => CreateFLAlertSearchAPI(elements('thumbnailLevelPicker'), 1));
        document.addEventListener('FLlayerclosed', () => {
            if (!_editing && elements('thumbnailLevels').value) {
                elements('thumbnailLevelID').value = elements('thumbnailLevels').value;
            }
        });
        elements('thumbnailFile').addEventListener('change', () => {
            clearPreview();
            const _file = elements('thumbnailFile').files[0];
            elements('thumbnailFilename').textContent = _file?.name || 'No image selected';
            if (!_file) {
                return;
            }
            if (!/\.(png|webp)$/i.test(_file.name) || !['image/png', 'image/webp'].includes(_file.type) || _file.size > 5 * 1024 * 1024) {
                elements('thumbnailFile').value = '';
                elements('thumbnailFilename').textContent = 'No image selected';
                notice('Choose a PNG or WebP image up to 5 MB. The server also checks its contents.');
                return;
            }
            _previewUrl = URL.createObjectURL(_file);
            elements('thumbnailUploadPreview').src = _previewUrl;
            elements('thumbnailUploadPreview').hidden = false;
        });
        elements('thumbnailForm').addEventListener('submit', async _event => {
            _event.preventDefault();
            if (_busy) {
                return;
            }
            if (!elements('thumbnailFile').files.length) {
                notice('Choose a PNG or WebP image before sending.');
                elements('thumbnailChooseImage').focus();
                return;
            }
            _busy = true;
            elements('thumbnailSubmit').disabled = true;
            const _body = new FormData(elements('thumbnailForm'));
            _body.set('action', 'submit');
            _body.set('token', _identity.token);
            if (_editing) {
                _body.set('id', _editing.id);
                _body.set('revision', _editing.revision);
            }
            try {
                await request({}, _body);
                resetForm();
                notice('Submitted for review. You can edit the pending image; each change needs a new review.');
                await loadList();
            } catch (_error) {
                notice(_error.message);
                elements('thumbnailNotice').focus();
            } finally {
                _busy = false;
                elements('thumbnailSubmit').disabled = false;
            }
        });
    }
    window.Fetch = async url => {
        const _response = await fetch(url, {credentials: 'same-origin'});
        if (!_response.ok) {
            throw new Error('Level search is unavailable.');
        }
        return _response.json();
    };
    window.addEventListener('pagehide', () => {
        clearInterval(_poll);
        _listingVersion++;
        if (!isModeration) {
            clearPreview();
        }
    });
    window.addEventListener('pageshow', _event => {
        if (_event.persisted) {
            location.reload();
        }
    });
    initialize();
})();
