document.addEventListener('DOMContentLoaded', function() {

    if (typeof gdpsVersion === 'undefined') {
        console.log("Warning: GDPS version not defined");
        let gdpsVersion = 22;
    }
    let gdItems = document.querySelectorAll('[id^="gdItem"]');

    gdItems.forEach(function(element) {
        let id = element.id;
        
        if (id.includes('-')) {
            let parts = id.match(/\d+/g);
            let minVersion = parseInt(parts[0]);
            let maxVersion = parseInt(parts[1]);
            
            if (gdpsVersion < minVersion || gdpsVersion > maxVersion) {
                element.style.display = 'none';
            }
        } else {
            let version = parseInt(id.match(/\d+/)[0]);

            if (version > parseInt(gdpsVersion)) {
                element.style.display = 'none';
            }
        }
    });
});