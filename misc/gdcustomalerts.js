const gauntletRendererUrl = new URL('gdgauntlets.js', document.currentScript.src);
let _gauntletRendererPromise = null;

function loadGauntletRenderer() {
    if (window.GDGauntlets) {
        return Promise.resolve(window.GDGauntlets);
    }
    if (!_gauntletRendererPromise) {
        _gauntletRendererPromise = new Promise((_resolve, _reject) => {
            const _script = document.createElement('script');
            _script.src = gauntletRendererUrl.href;
            _script.onload = () => _resolve(window.GDGauntlets);
            _script.onerror = () => _reject(new Error('Gauntlet renderer is unavailable.'));
            document.head.append(_script);
        });
    }
    return _gauntletRendererPromise;
}

function eventListenerSearchType (apiURL,idObject,maxOptions) {

    const selectElement = document.getElementById(idObject);
    const optionsContainer = document.getElementById('options-fl-layer-fancy');
    let _searchVersion = 0;

    return function(event) {
        const _requestVersion = ++_searchVersion;

        const fetchURLAPI = new URL(apiURL, document.baseURI);
        fetchURLAPI.search = new URLSearchParams({levelName: event.target.value, page: 0}).toString();

        for (let i = selectElement.options.length - 1; i >= 0; i--) {
            let option = selectElement.options[i];
            

            if (!option.selected) {
                selectElement.remove(i);
            }

        }

        Fetch(fetchURLAPI).then(data => {
            if (!Array.isArray(data) || _requestVersion !== _searchVersion || FLIDSelect !== selectElement.id) {
                return;
            }


            data.forEach(item => {
                if (item) { 
                    const option = document.createElement("option");
                    option.value = item.id;
                    option.id = `genoption${item.id}`;
                    const _content = document.createElement('div');
                    _content.style.cssText = 'display:flex; margin:1vh; align-items:center;';
                    const _image = document.createElement('img');
                    const _difficulty = /^[a-z-]+$/.test(item.partialDiff) ? item.partialDiff : 'unrated';
                    _image.src = new URL(`../assets/difficulties/${_difficulty}.png`, gauntletRendererUrl).href;
                    _image.style.cssText = 'width:auto; height:4.5vh;';
                    _image.alt = '';
                    const _name = document.createElement('p');
                    _name.className = 'gdfont-Pusab small';
                    _name.style.cssText = 'margin:0 0 0 1vh; color:rgb(255,200,0); text-align:left;';
                    _name.textContent = `${String(item.name).slice(0, 20)} | ID: ${item.id}`;
                    _content.append(_image, _name);
                    option.setAttribute('html', _content.outerHTML);
                    option.textContent = `${item.id}`;
                    selectElement.appendChild(option);
                }
            });
            
            genMoreFLElements(selectElement,optionsContainer,maxOptions)
        }).catch(() => {
            if (_requestVersion === _searchVersion && FLIDSelect === selectElement.id) {
                document.getElementById('fllayerdesc-fancy').textContent = 'Level search is unavailable. Please try again.';
            }
        });
    }
}

function CreateFLAlertSearchAPI(obj,maxOptions=2,title="Search levels!",desc=""){
    obj = obj.querySelector('select');
    const apiURL = obj.getAttribute('api-url');

    console.log(obj.id, apiURL);

    if(apiURL == "" || apiURL == null) throw new Error(`'api-url' is not defined in ${obj.id}`);
    functionEventListener = eventListenerSearchType(apiURL,obj.id,maxOptions);
    CreateFLAlert(title,desc,obj.id,maxOptions,"custom")
}


function eventListenerSearchGauntlets(apiURL,idObject,maxOptions) {

    const selectElement = document.getElementById(idObject);
    const optionsContainer = document.getElementById('options-fl-layer-fancy');

    return function(event) {

        let fetchURLAPI = `${apiURL}?list&search=${event.target.value}`

        console.log(fetchURLAPI);

        for (let i = selectElement.options.length - 1; i >= 0; i--) {
            let option = selectElement.options[i];
            

            if (!option.selected) {
                selectElement.remove(i);
            }

        }

        Fetch(fetchURLAPI).then(async data => {
            const _renderer = await loadGauntletRenderer();
            data = await Promise.all(data.filter(Boolean).map(async _item => {
                return {..._item, ...await _renderer.getInfo(_item.id)};
            }));

            data.forEach(item => {

                if (item) {
                    const option = document.createElement("option");
                    option.value = item.id;
                    option.id = `genoption${item.id}`;

                    const _content = document.createElement('div');
                    _content.style.cssText = 'display: flex; margin-left: 1vh;';
                    const _image = document.createElement('img');
                    _image.dataset.gauntletId = String(item.id);
                    _image.style.cssText = 'width:10vh; height:auto; object-fit:contain;';
                    const _name = document.createElement('p');
                    _name.className = 'gdfont-Pusab small';
                    _name.style.cssText = 'margin-right:0; margin-left:2vh;';
                    _name.style.color = item.textColor;
                    _name.textContent = item.name.length > 15 ? item.name.slice(0, 15) + '...' : item.name;
                    _content.append(_image, _name);
                    option.setAttribute('html', _content.outerHTML);
                    // option.setAttribute('title', `${item.name.length > 13 ? item.name.slice(0, 13) + "..." : item.name} (ID: ${item.id})`)
                    option.textContent = `${item.name} Gauntlet`;
                    selectElement.appendChild(option);
                }
            });
            
            genMoreFLElements(selectElement,optionsContainer,maxOptions)
        });
    }
}


function eventListenerSearchRewardsTypes(apiURL,idObject,maxOptions) {

    const selectElement = document.getElementById(idObject);
    const selectedElement = selectElement.value;
    const optionsContainer = document.getElementById('options-fl-layer-fancy');

    return function(event) {
        let fetchURLAPI = `${apiURL}?rewards`
        Array.from(selectElement.options).map((_, i, arr) => arr[arr.length - 1 - i]).forEach(opt => !opt.selected && selectElement.remove(opt.index));
        Fetch(fetchURLAPI).then(data => {
            data.forEach(item => {
                if (item && (item.id != selectedElement)) { 
                    if(item.ignore == 1) return;
                    const option = document.createElement("option");
                    option.value = item.id;
                    option.id = `genoption${item.id}`;
                    option.setAttribute('item-type', `${item.type != "" ? item.type : "item"}`);

                    htmlGen = `<div style="display: flex; margin-left: 1vh; align-items: center;"> <img src='../../assets/rewards/${item.id}.png' style="width:20%">` + `<p class="gdfont-Pusab small" style="margin-right: 0; margin-left: 2vh;">${item.name.length > 13 ? item.name.slice(0, 13) + "..." : item.name}</p>` + "</div>";

                    option.setAttribute('html', htmlGen)
                    option.textContent = `${item.name}`;
                    selectElement.appendChild(option);
                }
            });
            genMoreFLElements(selectElement,optionsContainer,maxOptions)
        });
    }
}

function CreateFLAlertGauntletsAPI(obj,maxOptions=2,title="Select your Gauntlet!",desc=""){
    obj = obj.querySelector('select');
    const apiURL = obj.getAttribute('api-url') ?? "../api/gauntlets.php";

    console.log(obj.id, apiURL);

    if(apiURL == "" || apiURL == null) throw new Error(`'api-url' is not defined in ${obj.id}`);
    functionEventListener = eventListenerSearchGauntlets(apiURL,obj.id,maxOptions);
    CreateFLAlert(title,desc,obj.id,maxOptions,"custom");

    document.getElementById("flayersearch-layer-fancy").value = "";  
    document.getElementById("flayersearch-layer-fancy").dispatchEvent(new Event("input", { bubbles: true })); 

}

function CreateFLAlertRewardsAPI(obj,maxOptions=2,title="Select your reward type!",desc=""){
    obj = obj.querySelector('select');
    const apiURL = obj.getAttribute('api-url') ?? "../vaultcodes.php?rewards";

    console.log(obj.id, apiURL);

    if(apiURL == "" || apiURL == null) throw new Error(`'api-url' is not defined in ${obj.id}`);
    functionEventListener = eventListenerSearchRewardsTypes(apiURL,obj.id,maxOptions);
    CreateFLAlert(title,desc,obj.id,maxOptions,"custom");

    document.getElementById("flayersearch-layer-fancy").style="display: none;";
    document.getElementById("flayersearch-layer-fancy").value = "";  
    document.getElementById("flayersearch-layer-fancy").dispatchEvent(new Event("input", { bubbles: true })); 

}


// add custom searchType with functionEventListener!
