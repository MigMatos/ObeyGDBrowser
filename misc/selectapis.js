$(document).ready(function() {
    $('select[api-search-id]').each(function() {
        const $select = $(this);
        const apiUrl = $select.data('url');
        const maxselect = $select.data('max') || 10;
        const sendParam = $select.attr('send-param') || 'search'; // Parámetro dinámico
        const repeatAllowed = $select.attr('repeat') !== 'off';

        // Inicializa el select con Select2 y realiza la búsqueda en la API
        $select.select2({
            ajax: {
                url: apiUrl,
                type: "GET",
                dataType: 'json',
                minimumInputLength: 1,
                maximumSelectionLength: maxselect,
                delay: 250,
                cache: true,
                xhrFields: {
                    withCredentials: true // Enviar cookies de sesión
                },
                data: function (params) {
                    return {levelName:params.term,page:0};
                },
                processResults: function (data) {
                    
                    console.log('API Response:', data); 

                    let results = [];

                    // Asume que 'data' es un array de objetos
                    if (Array.isArray(data)) {
                        results = $.map(data, function (item) {
                            return {
                                id: item.id || item.value, 
                                text: item.name || item.label 
                            };
                        });
                    }

                    return {
                        results: results
                    };
                }
            },
            placeholder: 'Busca y selecciona una opción',
            allowClear: true
        });

        // Verificar si se permite repetir selecciones
        if (!repeatAllowed) {
            $select.on('select2:select', function (e) {
                const selectedValue = e.params.data.id;

                // Verificar si el valor ya fue seleccionado en otro select con api-select-id
                $('select[api-select-id]').not($select).each(function () {
                    if ($(this).val() === selectedValue) {
                        alert('Esta opción ya ha sido seleccionada en otro campo.');
                        $select.val(null).trigger('change'); // Desseleccionar
                    }
                });
            });
        }
    });
});
