document.addEventListener('DOMContentLoaded', function() {

    if (typeof gdpsVersion === 'undefined') {
        console.log("Warning: GDPS version not defined");
        let gdpsVersion = "22";
    }
    let gdItems = document.querySelectorAll('[id^="gdItem"], [class*="gdItem"]');

    gdItems.forEach(function(element) {
        let id = element.id;
        let matchingClass = Array.from(element.classList).find(className => /^gdItem\d+$/.test(className));
        
        if (matchingClass) {
            console.log(`Ignorating ID ${id}, replacing with class ${matchingClass}`);
            id = matchingClass;
        }
        
        if (id.includes('-')) {
            let parts = id.match(/\d+/g);
            let minVersion = parseInt(parts[0]);
            let maxVersion = parseInt(parts[1]);
            
            if (gdpsVersion < minVersion || gdpsVersion > maxVersion) {
                element.style.setProperty("display", "none", "important")

            }
        } else {

            try {let version = parseInt(id.match(/\d+/)[0]);

            if (version > parseInt(gdpsVersion)) {
                element.style.setProperty("display", "none", "important")

            }}
            catch (e) {
                console.error("Ignorating error in Version Adapter with: ", e, " in elementID: ", element.id, element.classList);
            }
        }
    });
});