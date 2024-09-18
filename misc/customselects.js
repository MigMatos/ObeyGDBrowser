document.querySelectorAll('form').forEach(form => {

    

    form.addEventListener('submit', function(event) {
        let valid = false;
        this.querySelectorAll('select[min-options][max-options]').forEach(select => {
            const minSelect = parseInt(select.getAttribute('min-options'), 10);
            const maxSelect = parseInt(select.getAttribute('max-options'), 10);
            const selectedOptions = Array.from(select.selectedOptions);

            if (selectedOptions.length < minSelect) {
                select.setCustomValidity(`You must select at least ${minSelect} options.`);
            } else if (selectedOptions.length > maxSelect) {
                select.setCustomValidity(`You cannot select more than ${maxSelect} options.`);
            } else {
                valid = true;
                select.setCustomValidity('');
            }

            select.classList.toggle('invalid', !valid);
        });

    });
});