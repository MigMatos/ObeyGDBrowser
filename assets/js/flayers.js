
// Función para cambiar el texto de los elementos con parámetros
let FLIDSelect = null;

function CreateFLSelector(selectId, title = "", maxOptions = 2, desc = "") {
    CreateFLAlert(title, desc, selectId, maxOptions); // Llama a CreateFLAlert con el ID del select como parámetro
}


function CreateFLAlert(title, desc, idObject, maxOptions = 2) {
    const titleElement = document.getElementById('fllayertitle-fancy');
    const descElement = document.getElementById('fllayerdesc-fancy');
    if (titleElement && descElement) {
        titleElement.textContent = title;
        descElement.innerHTML = sanitizerCode(processHTMLContent(desc));
        document.getElementById("gd-fancy-box").style.display = "flex";
        setTimeout(function() {
            document.querySelector(".fancy-box").style.transform = "scale(1)";
        }, 10);
    }

    if (idObject) {
        FLIDSelect = idObject;
        const selectElement = document.getElementById(idObject);
        const optionsContainer = document.getElementById('options-fl-layer-fancy');
        if (selectElement && optionsContainer) {
            const options = Array.from(selectElement.querySelectorAll('option'));
            const isMultiple = selectElement.hasAttribute('multiple');
            const selectedOptions = options.filter(option => option.selected);

            optionsContainer.innerHTML = ''; // Limpiar el contenido del contenedor antes de agregar nuevas opciones

            options.map(option => {
                const div = document.createElement('div'); // Crear un div contenedor
                div.classList.add('gdsCheckboxItems'); // Agregar la clase gdCheckboxItems

                const checkbox = document.createElement('input');
                checkbox.classList.add('gdsCheckbox'); // Agregar la clase gdCheckbox
                checkbox.type = 'checkbox';
                checkbox.id = `customsong${option.value}`; // Establecer el ID del checkbox
                checkbox.value = option.value; // Establecer el valor del checkbox igual al valor del option
                checkbox.checked = selectedOptions.some(selectedOption => selectedOption.value === option.value); // Marcar el checkbox si la opción está seleccionada
                
                //checkbox.disabled = isMultiple && selectedOptions.length >= maxOptions && !selectedOptions.some(selectedOption => selectedOption.value === option.value); // Deshabilitar el checkbox si se supera el límite de selección
                
                div.appendChild(checkbox);

                const labelForCheckbox = document.createElement('label');
                labelForCheckbox.classList.add('checkbutton-container'); // Agregar la clase checkbutton-container
                labelForCheckbox.htmlFor = `customsong${option.value}`; // Establecer el atributo htmlFor del label
                div.appendChild(labelForCheckbox);

                const labelText = document.createElement('label');
                labelText.classList.add('gdfont-Pusab', 'small'); // Agregar las clases gdfont-Pusab y small
                labelText.htmlFor = `customsong${option.value}`; // Establecer el atributo htmlFor del label
                labelText.textContent = option.textContent; // Establecer el texto del label
                div.appendChild(labelText);

                div.appendChild(document.createElement('br'));

                // Agregar evento change a cada checkbox
                var optionsChecked = 0;
                checkbox.addEventListener('change', function() {
                    
                    if (!isMultiple) {
                        const checkboxes = Array.from(optionsContainer.querySelectorAll('.gdsCheckbox'));
                        checkboxes.map( chk => { if (chk !== this && chk.checked) {chk.checked = false;} });
                    } else {
                        const checkedArray = Array.from(optionsContainer.querySelectorAll('.gdsCheckbox')).map(chk => chk.checked);
                        optionsChecked = checkedArray.filter(checked => checked).length;
                    }

                    if (this.checked) {
                        if (optionsChecked > maxOptions && isMultiple) {

                        } else {
                            option.selected = true;
                        }
                    } else {
                        option.selected = false; // Deseleccionar el option si el checkbox está desmarcado
                    }

                    optionsChecked = 0;
                });

                optionsContainer.appendChild(div);
            });
        }
    }
}

function CreateFLBrownAlert(title, desc, frameurl) {
    const titleElement = document.getElementById('fllayertitle-brown');
    const descElement = document.getElementById('fllayerdesc-brown');
    const iFrameElement = document.getElementById("fllayeriframe-brown");
    iFrameElement.style.display = "none";
    if (titleElement && descElement) {
        titleElement.textContent = title;
        descElement.innerHTML = sanitizerCode(processHTMLContent(desc));
        document.getElementById("gd-brown-box").style.display = "flex";
        setTimeout(function() {
            document.querySelector(".brown-box").style.transform = "scale(1)";
        }, 10);
    }
    if (frameurl !== ""){
        document.getElementById("fllayeriframe-brown-rotating-img").style.display = "flex";
        iFrameElement.src = frameurl;
        document.getElementById("gd-brown-box").style.display = "flex";
        setTimeout(function() {
            document.querySelector(".brown-box").style.transform = "scale(1)";
        }, 10);
    }
}

  
document.getElementById("gdclose-fancy-btn").addEventListener("click", function() {
    document.getElementById("gd-fancy-box").style.display = "none";
    document.querySelector(".fancy-box").style.transform = "scale(0)";
    document.getElementById('options-fl-layer-fancy').innerHTML = "";
    document.dispatchEvent(new Event('FLlayerclosed'));
    FLIDSelect = null;
});

document.getElementById("gdclose-brown-btn").addEventListener("click", function() {
    document.getElementById("gd-brown-box").style.display = "none";
    document.querySelector(".brown-box").style.transform = "scale(0)";
    document.getElementById("fllayeriframe-brown").src = "";
    document.dispatchEvent(new Event('FLlayerclosed'));
    FLIDSelect = null;
});

document.getElementById("fllayeriframe-brown").onload = function() {
    document.getElementById("fllayeriframe-brown").style.display = "flex";
    document.getElementById("fllayeriframe-brown-rotating-img").style.display = "none";
};