function eventListenerSearchType (apiURL,idObject,maxOptions) {

    const selectElement = document.getElementById(idObject);
    const optionsContainer = document.getElementById('options-fl-layer-fancy');

    return function(event) {

        let fetchURLAPI = `${apiURL}?levelName=${event.target.value}&page=0`

        for (let i = selectElement.options.length - 1; i >= 0; i--) {
            let option = selectElement.options[i];
            

            if (!option.selected) {
                selectElement.remove(i);
            }

        }

        Fetch(fetchURLAPI).then(data => {


            data.forEach(item => {
                if (item) { 
                    const option = document.createElement("option");
                    option.value = item.id;
                    option.id = `genoption${item.id}`;
                    htmltext = `<div style="display: flex; margin: 1vh 0vh 1vh 1vh; align-items: center;"> <img src='../assets/difficulties/${item.partialDiff}.png' style="width:8%; height:8%;">` + `<p class="gdfont-Pusab small" style="margin: 0vh 0vh 0vh 1vh; color:rgb(255, 200, 0); text-align: left;">${item.name.length > 20 ? item.name.slice(0, 20) + "..." : item.name}<br><span style="color: white;">ID: ${item.id}</span></p>` + "</div>"
                    option.setAttribute('html',htmltext);

                    // option.setAttribute('title',`${item.name.length > 13 ? item.name.slice(0, 13) + "..." : item.name} (ID: ${item.id})`)
                    option.textContent = `${item.id}`;
                    selectElement.appendChild(option);
                }
            });
            
            genMoreFLElements(selectElement,optionsContainer,maxOptions)
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

        Fetch(fetchURLAPI).then(data => {


            data.forEach(item => {

                if (item) { 
                    const option = document.createElement("option");
                    option.value = item.id;
                    option.id = `genoption${item.id}`;

                    htmlGen = `<div style="display: flex; margin-left: 1vh;"> <img src='../assets/gauntlets/${item.id}.png' width="20%">` + `<p class="gdfont-Pusab small" style="margin-right: 0; margin-left: 2vh;color:${item.textColor}">${item.name.length > 13 ? item.name.slice(0, 13) + "..." : item.name}</p>` + "</div>";

                    option.setAttribute('html', htmlGen)
                    // option.setAttribute('title', `${item.name.length > 13 ? item.name.slice(0, 13) + "..." : item.name} (ID: ${item.id})`)
                    option.textContent = `${item.name} Gauntlet`;
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


// add custom searchType with functionEventListener!