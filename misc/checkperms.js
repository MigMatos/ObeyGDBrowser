document.addEventListener('DOMContentLoaded', function() {
    runCheckPerms();
});


function runCheckPerms() {
    if (typeof userPermissions === 'undefined') {
        console.log("Warning: userPermissions not defined");
        let userPermissions = [];
    }

    let checkPermItems = document.querySelectorAll('[class^="checkperm-"]');

    checkPermItems.forEach(function(element) {
        let classes = element.classList;
        let hideElement = true;

        if (userPermissions.includes("admin")) { hideElement = false; } 
        else {
            classes.forEach(function(cls) {
                if (cls.startsWith('checkperm-')) {
                    let permission = cls.split('-')[1];

                    if (userPermissions.includes(permission)) {
                        hideElement = false;
                    }
                }
            });
        }

        if (hideElement) { element.style.display = 'none'; }
    });
}