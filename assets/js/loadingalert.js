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
    document.getElementById('loading-alert-buttom-display-text').textContent = "Loading...";
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
 */
function changeLoadingAlert(Message) {
    document.getElementById('loading-alert-buttom-display-text').textContent = Message;
}