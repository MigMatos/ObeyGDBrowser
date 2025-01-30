function debounce(func, wait) {
    let timeout;

    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            document.getElementById("loading-main").style.display = "none"; // Ocultar el overlay
            func(...args);
        };

        clearTimeout(timeout);
        document.getElementById("loading-main").style.display = "flex"; // Mostrar el overlay como flex
        
        timeout = setTimeout(later, wait);
        
    };
}

// Loading alerts

document.addEventListener('initLoadingAlert', function() {
    console.log("Event: initLoadingAlert");
    const alert = document.getElementById('loading-alert-buttom-display')
    alert.style.display = "flex";
    if (alert.classList.contains("hidden")){alert.classList.remove("hidden");};
    changeLoadingAlert();
    //document.getElementById('loading-alert-buttom-display-text').textContent = "Loading...";
});

document.addEventListener('finishLoadingAlert', function() {
    console.log("Event: finishLoadingAlert");
    const alert = document.getElementById('loading-alert-buttom-display')
    if (!alert.classList.contains("hidden")){alert.classList.add("hidden");};
    setTimeout(function() {
        alert.style.display = "none";
    }, 1000);
});

/**
 * Change the message displayed in the loading alert.
 * 
 * **WARNING:** Text content is removed when `finishLoadingAlert` is dispatched.
 * @param Message - The message to be displayed in the loading alert.
 * @param Status - The icon to be displayed in the loading alert, actually only have "load","done","error".
 */
function changeLoadingAlert(Message = "Loading...",Status = "load") {
    document.getElementById('loading-alert-buttom-display-text').textContent = Message;
    let IconAlert = document.getElementById('alert-buttom-icon');
    if(Status == "load"){
        IconAlert.src = "https://migmatos.alwaysdata.net/legacy/cdn/icons/loading.png";
        IconAlert.className = Status;
    } else if (Status == "done" || Status == "error") {
        IconAlert.className = Status;
        if (Status == "done") IconAlert.src = "https://migmatos.alwaysdata.net/legacy/cdn/icons/sucess.png";
        else IconAlert.src = "https://migmatos.alwaysdata.net/legacy/cdn/icons/failed.png";
    } else {
        console.log(`Error in changeLoadingAlert(): Status "${Status}" no found.`);
    }
}