function openGdCustomFrame(url) {

    const iframeContainer = document.createElement('div');
    iframeContainer.className = 'gdCustomFrame';
    iframeContainer.style.display = 'flex';


    const iframe = document.createElement('iframe');
    iframe.setAttribute("allowtransparency","yes");
    iframe.className = 'hide'
    iframe.src = url;
    iframe.style.border = 'none';
    iframe.style.backgroundColor = 'transparent';

    const loadingObj = document.createElement('div');
    loadingObj.className = "brownBox center";
    // <img class="spin noSelect" src="../assets/loading.png" height="105%">
    const centerLoadingObj = document.createElement('div');
    centerLoadingObj.className = "supercenter";

    const imgLoadingObj = document.createElement('div');
    imgLoadingObj.className = "spin noSelect loadingBG";

    centerLoadingObj.appendChild(imgLoadingObj);

    loadingObj.appendChild(centerLoadingObj);

    iframeContainer.appendChild(loadingObj);

    let myTimer = Date.now();

    iframe.addEventListener('load', function() {
        console.log("iFrame GD Custom Loaded with URL:", url);

        const elapsedTime = Date.now() - myTimer;
    
        if (elapsedTime >= 500) {
            loadingObj.style.display = 'none';
            iframe.className = 'show';
        } else {
            setTimeout(function() {
                loadingObj.style.display = 'none';
                iframe.className = 'show';
            }, 500 - elapsedTime);
        }
    });


    // const closeButton = document.createElement('button');
    // closeButton.className = 'closeButton';
    // closeButton.innerText = '❌';
    // closeButton.onclick = function() {
    //     closeGdCustomFrame(iframeContainer);
    // };
    // iframeContainer.appendChild(closeButton);

    iframeContainer.appendChild(iframe);

 
    document.body.appendChild(iframeContainer);

    // 
    function messageListenerWrapper(event) {
        handleGDCustomFrame(window.location.origin, event);
    }

    // 
    function registerMessageListener() {
        window.addEventListener('message', messageListenerWrapper);
    }

    function unregisterMessageListener() {
        window.removeEventListener('message', messageListenerWrapper);
    }

    registerMessageListener();

    // Handler Events

    function handleGDCustomFrame(expectedOrigin, event) {
        if (event.origin === expectedOrigin) {
            if (event.data.type === 'ObeyGDBrowser' && event.data.origin === expectedOrigin && event.data.data === 'closeWindow') {
                console.log('MD iframe:', event.data.data);
                unregisterMessageListener();
                document.body.removeChild(iframeContainer); 
            } else if (event.data.type === 'ObeyGDBrowser' && event.data.origin === expectedOrigin && event.data.data === 'restartWindow') {
                console.log('MD iframe:', event.data.data);
                unregisterMessageListener();
                document.body.removeChild(iframeContainer); 
                location.reload(true);
            }
             else {
                console.log('Security events in iFrameCustom were not met: ', event);
            }
        } else {
            console.log('Security Error in iFrameCustom event with unknown origin:', event.origin);
        }
    }

}

function closeGdCustomFrame(iframeContainer) {
    document.body.removeChild(iframeContainer); 
}

function closeMessageCustomFrame() {
    const originUrl = window.location.origin;
    window.parent.postMessage({ type: 'ObeyGDBrowser', origin: originUrl, data: 'closeWindow' }, '*');
}

function closeandrestartMessageCustomFrame() {
    const originUrl = window.location.origin;
    window.parent.postMessage({ type: 'ObeyGDBrowser', origin: originUrl, data: 'restartWindow' }, '*');
}