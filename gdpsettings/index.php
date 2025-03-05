<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GDPS Configuration</title>
    <link href="../assets/css/gdpssettings.css" type="text/css" rel="stylesheet">
</head>
<body bgcolor="#999999">

    <?php

    include("../_init_.php");
    include("../assets/htmlext/flayeralert.php");
	include("../assets/htmlext/loadingalert.php");


    if ($failed_conn) {

    }
    else if($logged && $isAdmin) {} else {header("Location: ../");}
    function get_gameversion($data) {
        $data = intval($data);
        
        if ($data <= 0) {
            return 1.0;
        } elseif ($data <= 7) {
            return "1." . ($data - 1);
        } elseif ($data == 10) {
            return 1.7;
        } else {
            return $data / 10;
        }
    }

   
    ?>
    
    <h3 style="margin: 0;display: flex;flex-wrap: nowrap;justify-content: center;align-items: center;">Theme: <button id="theme-toggle"><span id="theme-emoji">☀</span><span style="margin-left:1vh;" id="theme-text">Light</span></button></h3>

    <br>

    <fieldset><legend><h2>GDPS Configuration</h2></legend>

    <form id="levelForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">


    <fieldset><legend><h3>Lengths (String)</h3></legend> <button type="button" class="toggle-btn"><strong class="content-btn-viewer">View/Hide</strong><span>▼</span></button>
        <div class="content hidden">
        <label for="length-0">Length 0:</label>
        <input type="text" id="length-0" name="length-0"><br>
        <label for="length-1">Length 1:</label>
        <input type="text" id="length-1" name="length-1"><br>
        <label for="length-2">Length 2:</label>
        <input type="text" id="length-2" name="length-2"><br>
        <label for="length-3">Length 3:</label>
        <input type="text" id="length-3" name="length-3"><br>
        <label for="length-4">Length 4:</label>
        <input type="text" id="length-4" name="length-4"><br>
        <label for="length-5">Length 5:</label>
        <input type="text" id="length-5" name="length-5"><br>
        </div>
    </fieldset>


    <fieldset><legend><h3>Featured rates</h3></legend> 
        <button type="button" class="toggle-btn">
            <strong class="content-btn-viewer">View/Hide</strong>
            <span>▼</span>
        </button>    
        <div class="content hidden">
        <label for="featured-0">Featured 0:</label>
        <input type="text" id="featured-0" name="featured-0"><br>
        <label for="featured-1">Featured 1:</label>
        <input type="text" id="featured-1" name="featured-1"><br>
        </div>
    </fieldset>

    <fieldset><legend><h3>Epic rates</h3></legend>
        <button type="button" class="toggle-btn">
            <strong class="content-btn-viewer">View/Hide</strong>
            <span>▼</span>
        </button>    
        <div class="content hidden">
        <label for="epic-0">Epic 0:</label>
        <input type="text" id="epic-0" name="epic-0"><br>
        <label for="epic-1">Epic 1:</label>
        <input type="text" id="epic-1" name="epic-1"><br>
        <label for="epic-2">Epic 2:</label>
        <input type="text" id="epic-2" name="epic-2"><br>
        <label for="epic-3">Epic 3:</label>
        <input type="text" id="epic-3" name="epic-3"><br>
        </div>
    </fieldset>

    <fieldset><legend><h3>Demon difficulties</h3></legend>
        <button type="button" class="toggle-btn">
            <strong class="content-btn-viewer">View/Hide</strong>
            <span>▼</span>
        </button>    
        <div class="content hidden">
        <label for="states_demon-0">Demon Type 0:</label>
        <input type="text" id="states_demon-0" name="states_demon-0"><br>
        <label for="states_demon-3">Demon Type 3:</label>
        <input type="text" id="states_demon-3" name="states_demon-3"><br>
        <label for="states_demon-4">Demon Type 4:</label>
        <input type="text" id="states_demon-4" name="states_demon-4"><br>
        <label for="states_demon-5">Demon Type 5:</label>
        <input type="text" id="states_demon-5" name="states_demon-5"><br>
        <label for="states_demon-6">Demon Type 6:</label>
        <input type="text" id="states_demon-6" name="states_demon-6"><br>
        </div>
    </fieldset>

    <fieldset><legend><h3>Difficulties</h3></legend>
        <button type="button" class="toggle-btn">
            <strong class="content-btn-viewer">View/Hide</strong>
            <span>▼</span>
        </button>    
        <div class="content hidden">
        <label for="states_diff_num-0">Difficulty Type 0:</label>
        <input type="text" id="states_diff_num-0" name="states_diff_num-0"><br>
        <label for="states_diff_num-10">Difficulty Type 10:</label>
        <input type="text" id="states_diff_num-10" name="states_diff_num-10"><br>
        <label for="states_diff_num-20">Difficulty Type 20:</label>
        <input type="text" id="states_diff_num-20" name="states_diff_num-20"><br>
        <label for="states_diff_num-30">Difficulty Type 30:</label>
        <input type="text" id="states_diff_num-30" name="states_diff_num-30"><br>
        <label for="states_diff_num-40">Difficulty Type 40:</label>
        <input type="text" id="states_diff_num-40" name="states_diff_num-40"><br>
        <label for="states_diff_num-50">Difficulty Type 50:</label>
        <input type="text" id="states_diff_num-50" name="states_diff_num-50"><br>
        </div>
    </fieldset>

    <fieldset><legend><h3>Gauntlets</h3></legend>
        <div id="gauntletnewcont" class="newcontentdiv"><img src="../assets/newBtn.png"><h4>New gauntlet content!</h4>
            <button type="button" class="radiusdesing update" onclick="showConfirmation(confirmed => confirmed && updateContent('gauntlets'))"><strong class="content-btn-viewer">Update!</strong></button>
        </div>
        <!-- <button type="button" id="newgauntlet_content"><strong class="content-btn-viewer">View/Hide</strong></button> -->
        
        <button type="button" class="toggle-btn">
            <strong class="content-btn-viewer">View/Hide</strong>
            <span>▼</span>
        </button>    
        <div class="content hidden" id="gauntlets-content">
            <!-- Gauntlets data -->
            <fieldset><legend><h4>Add new gauntlet</h4></legend>
                <div>
                    <input type="number" id="addidgauntlet" placeholder="ID">
                    <button type="button" class="radiusdesing green-btn" onclick="showConfirmation(confirmed => confirmed && addContentID(document.getElementById('addidgauntlet').value, 'gauntlet-div'))">Add gauntlet!</button>
                </div>
            </fieldset>
        </div>
    </fieldset>

    <fieldset><legend><h3>Official songs</h3></legend>
        <div id="songnewcont" class="newcontentdiv"><img src="../assets/newBtn.png"><h4>New official songs content!</h4>
            <button type="button" class="radiusdesing update" onclick="showConfirmation(confirmed => confirmed && updateContent('songs'))"><strong class="content-btn-viewer">Update!</strong></button>
        </div>
        <button type="button" class="toggle-btn">
            <strong class="content-btn-viewer">View/Hide</strong>
            <span>▼</span>
        </button>    
        <div class="content hidden" id="songs-content">
            <!-- Songs data -->
            <fieldset><legend><h4>Add new official song</h4></legend>
                <div>
                    <input type="number" id="addidsong" placeholder="ID">
                    <button type="button" class="radiusdesing green-btn" onclick="showConfirmation(confirmed => confirmed && addContentID(document.getElementById('addidsong').value, 'officialsong-div'))">Add song!</button>
                </div>
            </fieldset>
        </div>
    </fieldset>




    <fieldset><legend><h3>GDBrowser Settings</h3></legend>

        <h2>Basic Settings</h2><br>

        <label for="gdbrowser_title">GDPS Title:</label>
        <input type="text" id="gdbrowser_title" name="gdbrowser_title"><br>
        <label for="gdbrowser_name">GDPS Name:</label>
        <input type="text" id="gdbrowser_name" name="gdbrowser_name"><br>
        <label for="gdbrowser_icon">GDPS Icon:</label>
        <input type="text" id="gdbrowser_icon" name="gdbrowser_icon"><br>
        <label for="gdps_version">GDPS Version:</label>
        <input type="number" id="gdps_version" required name="gdps_version"><br>
        <label for="show_level_passwords">Show Level Passwords:</label>
        <label for="">
            <input type="radio" id="show_level_passwords-0" name="show_level_passwords" value="0">
            Disable
        </label>
        <label for="">
            <input type="radio" id="show_level_passwords-1" name="show_level_passwords" value="1">
            Enable
        </label>
        <label for="gdbrowser_desc">GDPS Description:</label>
        <input type="text" size="100" id="gdbrowser_desc" name="gdbrowser_desc"><br>

        <label>Theme Settings:</label>
        <label for="">
            <input type="radio" id="browser_theme-0" name="browser_theme" value="0">
            Disable automatic event themes
        </label>
        <label for="">
            <input type="radio" id="browser_theme-1" name="browser_theme" value="1">
            Enable automatic event themes
        </label>
        <br>
        <label for="browser_theme_path">Custom CSS Path <label style="color:#af0000;">[Recommended to place in "customfiles/" folder]</label>: </label>
        <input type="text" size="50" id="browser_theme_path" name="browser_theme_path" placeholder="customfiles/mycustomtheme.css"><br>

        <label for="disable_colored_texture_level_browser">Colored Texture Level Browser:</label>
        <label for="">
            <input type="radio" id="disable_colored_texture_level_browser-0" name="disable_colored_texture_level_browser" value="0">
            Disable
        </label>
        <label for="">
            <input type="radio" id="disable_colored_texture_level_browser-1" name="disable_colored_texture_level_browser" value="1">
            Enable
        </label>
    <!-- More -->
        <h2>Assets Settings</h2><br>

        <label for="gdbrowser_icon_embed">GDPS Icon URL (for embeds) <label style="color:#af0000;">[ONLY .JPG, JPEG AND .PNG]</label>: </label>
        <input type="text" id="gdbrowser_icon_embed" name="gdbrowser_icon_embed"><br>
        <label for="gdbrowser_assets_full_url">GDPS Assets Folder URL (for embeds):</label>
        <input type="text" size="50" id="gdbrowser_assets_full_url" name="gdbrowser_assets_full_url"><br>
        <label for="gdps_logo_url">GDPS Logo URL:</label>
        <input type="text" id="gdps_logo_url" name="gdps_logo_url"><br>
        <label for="gdps_level_browser_logo_url">GDPS Level Browser Logo URL:</label>
        <input type="text" id="gdps_level_browser_logo_url" name="gdps_level_browser_logo_url"><br>
        
        <h2>Advanced Settings</h2><br>


        <label>Server Software:</label>
        <label for="automatic">
            <input type="radio" id="server_software-automatic" name="server_software" value="automatic">
            Automatic
        </label>
        <label for="apache">
            <input type="radio" id="server_software-apache" name="server_software" value="apache">
            Apache
        </label>
        <label for="nginx">
            <input type="radio" id="server_software-nginx" name="server_software" value="nginx">
            Nginx <label style="color:#af0000;">(Needs install nginx.conf)</label>
        </label>
        <label for="legacy">
            <input type="radio" id="server_software-legacy" name="server_software" value="legacy">
            Legacy (Compatible with most host servers)
        </label>
        <br>

        <label for="path_connection">Path Connection <label style="color:#af0000;">(Deprecated, please configure "Lib Folder"!):</label></label>
        <input type="text" id="path_connection" name="path_connection"><br>
        <label for="path_lib_folder" placeholder="../incl/lib/">Lib Folder:</label>
        <input type="text" id="path_lib_folder" required name="path_lib_folder"><br>
        <label for="path_browser_folder" placeholder="../incl/lib/">Browser Folder:</label>
        <input type="text" id="browser_path" required name="browser_path" value="browser/"><br>
        <label for="path_folder_levels">Levels Path Folder (Important for the level analyzer!)</label>
        <input type="text" id="path_folder_levels" placeholder="../../data/levels/" name="path_folder_levels"><br>
        
        <h2>App installer</h2><br>
        <!-- App Start URL -->
        <label for="manifest_start_url">App Start URL</label>
        <input type="text" id="manifest_start_url" placeholder="/browser/" name="manifest_start_url" value="/browser/" required><br>

        <!-- App Name -->
        <label for="manifest_name">App Name</label>
        <input type="text" id="manifest_name" placeholder="MyGDPS: ObeyGDBrowser" name="manifest_name" value="MyGDPS: ObeyGDBrowser" required><br>

        <!-- App Theme Color -->
        <label for="manifest_theme_color">App Theme Color</label>
        <input type="color" id="manifest_theme_color" name="manifest_theme_color" value="#000000" required><br>

        <!-- App Background Color -->
        <label for="manifest_background_color">App Background Color</label>
        <input type="color" id="manifest_background_color" name="manifest_background_color" value="#000000" required><br>

        <!-- App Short Name -->
        <label for="manifest_short_name">App Short Name</label>
        <input type="text" id="manifest_short_name" placeholder="MyGDPS: ObeyGDBrowser" name="manifest_short_name" value="MyGDPS: ObeyGDBrowser" required><br>

        <!-- App Description -->
        <label for="manifest_description">App Description</label>
        <input type="text" id="manifest_description" placeholder="My GDPS! :D" name="manifest_description" value="My GDPS! :D" required><br>
    </fieldset>


        <br>

        <input type="submit" value="Save">
        <button type="button" onclick="window.location.href = '../';">Back</button>

    </form>
    </fieldset>


    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>

    $("#loading-main").hide();
    
    const jsonData = <?php echo json_encode($gdps_settings); ?>;
    const currentGauntletsData = <?php echo json_encode(json_decode(file_get_contents('./default_gauntlets.json'),true)); ?>;
    const currentSongsData = <?php echo json_encode(json_decode(file_get_contents('./official_songs.json'),true)); ?>;


    const oldGauntletsKeys = new Set(Object.keys(jsonData.gauntlets || {}));
    const oldSongsKeys = new Set(Object.keys(jsonData.official_songs || {}));
    const newGauntletsKeys = new Set(Object.keys(currentGauntletsData || {}));
    const newSongsKeys = new Set(Object.keys(currentSongsData || {}));

    function updateContent(type) {
        const event = new Event('initLoadingAlert');
        document.dispatchEvent(event);
        changeLoadingAlert("Adding new content...");
        if(type == "songs"){
            newSongsKeys.forEach((key) => {
            if (!oldSongsKeys.has(key) || Object.keys(jsonData.official_songs[key] || {}).length === 0) {
                console.log("Adding from key songs:", key);
                if(!existElementID(`${key}-officialsongs-div`)) fillfromNewContent(key,type,1);
            }
            });
        } else if(type == "gauntlets"){
            newGauntletsKeys.forEach((key) => {
            if (!oldGauntletsKeys.has(key) || Object.keys(jsonData.gauntlets[key] || {}).length === 0) {
                console.log("Adding from key gauntlet:", key);
                if(!existElementID(`${key}-gauntlet-div`)) fillfromNewContent(key,type,1);
            }
            });
        }

        changeLoadingAlert("Content updated!","done");
        setTimeout(function () {
			const event = new Event('finishLoadingAlert');
			document.dispatchEvent(event);
		}, 500);
    }

    function fillfromNewContent(id,type,mode){
        if(type == "songs"){
            let songData = jsonData?.official_songs?.[`${id}`] ?? {};
            if(mode==1) songData = currentSongsData[`${id}`];
            if(!existElementID(`${id}-officialsong-div`)) addSongHTML(id);
            document.getElementById(`song-${id}-name`).value = songData.name;
            document.getElementById(`song-${id}-artist`).value = songData.artist;
            document.getElementById(`song-${id}-songlink`).value = songData.songLink;
        } else if (type == "gauntlets"){
            let songData = jsonData?.gauntlets?.[`${id}`] ?? {};
            if(mode==1) songData = currentGauntletsData[`${id}`];
            if(!existElementID(`${id}-gauntlet-div`)) addGauntletHTML(id);
            document.getElementById(`gauntlet-${id}-name`).value = songData.name;
            document.getElementById(`gauntlet-${id}-textcolor`).value = songData.textColor;
            document.getElementById(`gauntlet-${id}-bgcolor`).value = songData.bgColor;
        }
    }

    function addGauntletHTML(id) {
        id = parseInt(id, 10);
        if (isNaN(id) || id < 1) {
            console.error(`Error your data: ${id} is not numeric (Gauntlets).`);
            return;
        }
        
        const container = document.getElementById("gauntlets-content");
        if (!container) {
            console.error("Error finding 'gauntlets-content'.");
            return;
        }
        
        const fieldset = document.createElement("fieldset");
        fieldset.id = `${id}-gauntlet-div`
        fieldset.innerHTML = `
            <legend><h4>ID ${id}</h4></legend>
            <button type="button" class="toggle-btn">
                <strong class="content-btn-viewer">View/Hide</strong>
                <span>▼</span>
            </button>
            <div class="content hidden">
                <label for="gauntlet-${id}-name">Name:</label>
                <input type="text" id="gauntlet-${id}-name" name="gauntlet-${id}-name" value=""><br>
                <label for="gauntlet-${id}-textcolor">Text Color:</label>
                <input type="color" id="gauntlet-${id}-textcolor" name="gauntlet-${id}-textcolor" value="#ffffff"><br>
                <label for="gauntlet-${id}-bgcolor">BG Color:</label>
                <input type="color" id="gauntlet-${id}-bgcolor" name="gauntlet-${id}-bgcolor" value="#ffffff"><br>
                <button type="button" class="radiusdesing red-btn" onclick="showConfirmation(confirmed => confirmed && removeContentID('${id}','gauntlet-div'))">Delete Gauntlet ${id}</button>
                <button type="button" class="radiusdesing blue-btn" onclick="showConfirmation(confirmed => confirmed && fillfromNewContent('${id}','gauntlets',0))">Restore data</button>
                <button type="button" class="radiusdesing blue-btn" onclick="showConfirmation(confirmed => confirmed && fillfromNewContent('${id}','gauntlets',1))">New data</button>
            </div>
        `;
        container.appendChild(fieldset);
        document.dispatchEvent(new Event('DOMContentLoaded'));
    }

    function addSongHTML(id) {
        id = parseInt(id, 10);
        if (isNaN(id) || id < 1) {
            console.error(`Error your data: ${id} is not numeric (Gauntlets).`);
            return;
        }
        
        const container = document.getElementById("songs-content");
        if (!container) {
            console.error("Error finding 'songs-content'.");
            return;
        }
        
        const fieldset = document.createElement("fieldset");
        fieldset.id = `${id}-officialsong-div`
        fieldset.innerHTML = `
            <legend><h4>ID ${id}</h4></legend>
            <button type="button" class="toggle-btn">
                <strong class="content-btn-viewer">View/Hide</strong>
                <span>▼</span>
            </button>
            <div class="content hidden">
                <label for="song-${id}-name">Name:</label>
                <input type="text" id="song-${id}-name" name="song-${id}-name" value=""><br>
                <label for="song-${id}-artist">Artist:</label>
                <input type="text" id="song-${id}-artist" name="song-${id}-artist" value=""><br>
                <label for="song-${id}-songlink">Song Link:</label>
                <input type="url" id="song-${id}-songlink" name="song-${id}-songlink" value=""><br>
                <button type="button" class="radiusdesing red-btn"  onclick="showConfirmation(confirmed => confirmed && removeContentID('${id}','officialsong-div'))">Delete Song ${id}</button>
                <button type="button" class="radiusdesing blue-btn" onclick="showConfirmation(confirmed => confirmed && fillfromNewContent('${id}','songs',0))">Restore data</button>
                <button type="button" class="radiusdesing blue-btn" onclick="showConfirmation(confirmed => confirmed && fillfromNewContent('${id}','songs',1))">New data</button>
            </div>
        `;
        
        container.appendChild(fieldset);
        document.dispatchEvent(new Event('DOMContentLoaded'));
    }

    function addContentID(inputValue, targetDiv) {
        id = parseInt(inputValue, 10);
        const event = new Event('initLoadingAlert');
        document.dispatchEvent(event);
        if (isNaN(id) || id < 1) {
            changeLoadingAlert("Invalid number ID!","error");
            setTimeout(function () {
					const event = new Event('finishLoadingAlert');
					document.dispatchEvent(event);
			}, 500);
            return
        }
        changeLoadingAlert("Adding...");

        const contentDivElement = document.getElementById(id + "-" + targetDiv);
        if(existElementID(id + "-" + targetDiv)) {
            changeLoadingAlert("ID already exists!","error");
            setTimeout(function () {
					const event = new Event('finishLoadingAlert');
					document.dispatchEvent(event);
			}, 500);
            return
        }
        if (targetDiv == "gauntlet-div") {
            addGauntletHTML(id);
        } else if (targetDiv == "officialsong-div") {
            addSongHTML(id);
        }

        changeLoadingAlert("ID Added!","done");
        setTimeout(function () {
			const event = new Event('finishLoadingAlert');
			document.dispatchEvent(event);
		}, 500);
    }

    function removeContentID(inputValue, targetDiv) {
        id = parseInt(inputValue, 10);
        const event = new Event('initLoadingAlert');
        document.dispatchEvent(event);
        
        if (isNaN(id) || id < 1) {
            changeLoadingAlert("Invalid number ID!", "error");
            setTimeout(function () {
                const event = new Event('finishLoadingAlert');
                document.dispatchEvent(event);
            }, 500);
            return;
        }

        changeLoadingAlert("Removing...");

        const contentDivElement = document.getElementById(id + "-" + targetDiv);
        if (!existElementID(id + "-" + targetDiv)) {
            changeLoadingAlert("ID does not exist!", "error");
            setTimeout(function () {
                const event = new Event('finishLoadingAlert');
                document.dispatchEvent(event);
            }, 500);
            return;
        }

        contentDivElement.remove();

        changeLoadingAlert("ID Removed!", "done");
        setTimeout(function () {
            const event = new Event('finishLoadingAlert');
            document.dispatchEvent(event);
        }, 500);
    }

    function existElementID(element) {
        return document.getElementById(element) !== null;
    }


    // Gauntlets
    newGauntletsKeys.forEach((key) => {
    if (!oldGauntletsKeys.has(key) || Object.keys(jsonData.gauntlets[key] || {}).length === 0) {
            $('#gauntletnewcont').css('display', 'flex');
        }
    });

    oldGauntletsKeys.forEach((key) => {
    if (!newGauntletsKeys.has(key)) {
        console.log(`${key} Gauntlet custom`);
    }
    addGauntletHTML(key);
    });

    //Songs
    newSongsKeys.forEach((key) => {
        if (!oldSongsKeys.has(key) || Object.keys(jsonData.official_songs[key] || {}).length === 0) {
            $('#songnewcont').css('display', 'flex');
        }
    });
    
    oldSongsKeys.forEach((key) => {
    if (!newSongsKeys.has(key)) {
        console.log(`${key} Song custom`);
    }
    addSongHTML(key);
    });



function loadValues() {
    for (const key in jsonData) {
        let keyData = jsonData[key];

        console.log(keyData);
        
        if (keyData.constructor === ({}).constructor) {
            for (const subKey in keyData) {
                let subkeyData = keyData[subKey];
                
                try {
                    if(key != "gauntlets" && key != "official_songs") {
                        let element = document.getElementById(`${key}-${subKey}`);
                        element.value = subkeyData;
                    }
                    
                } catch (e) {
                    console.log("ID Element not found: ", key, "-", subKey);
                }

                try {
                    if(key == "gauntlets") {
                        let rkey = key.replace("gauntlets","gauntlet")
                        let element = document.getElementById(`${rkey}-${subKey}-name`);
                        element.value = (subkeyData.name ?? "") || "Unknown";
                        element = document.getElementById(`${rkey}-${subKey}-textcolor`);
                        element.value = (subkeyData.textColor ?? "") || "#c8c8c8";
                        element = document.getElementById(`${rkey}-${subKey}-bgcolor`);
                        element.value = (subkeyData.bgColor ?? "") || "#c8c8c8";
                    } else if (key == "official_songs") {

                        console.log("try offsongs")
                        let rkey = key.replace("official_songs","song")
                        let element = document.getElementById(`${rkey}-${subKey}-name`);
                        element.value = (subkeyData.name ?? "") || "Unknown";
                        element = document.getElementById(`${rkey}-${subKey}-artist`);
                        element.value = (subkeyData.artist ?? "") || "Unknown Artist";
                        element = document.getElementById(`${rkey}-${subKey}-songlink`);
                        element.value = (subkeyData.songLink ?? "") || "";
                    }
                } catch (e) {
                    console.log("ID Element not found: ", key, "-", subKey, "-name/-textcolor/-bgcolor");
                }
            }
        } else {

            try {
                
                let element = document.getElementById(`${key}`);
                element.value = keyData;

            } catch (e) {
                try {
                let element = document.getElementById(`${key}-${keyData}`);
                if (element.value === keyData){
                    element.checked = true;
                            
                } 
            } catch (e) {
                console.log("ID Element not found: ", key);
            }
            console.log("ID Element not found: ", key);
            }
        }
    }
}

loadValues();

// Manifest

fetch('../manifest.json')
    .then(response => response.json())
    .then(data => {
        document.getElementById('manifest_name').value = data.name;
        document.getElementById('manifest_theme_color').value = data.theme_color;
        document.getElementById('manifest_background_color').value = data.background_color;
        document.getElementById('manifest_short_name').value = data.short_name;
        document.getElementById('manifest_description').value = data.description;
        document.getElementById('manifest_start_url').value = data.start_url;
    })
    .catch(console.error);


document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.toggle-btn').forEach(button => {
        if (!button.hasAttribute('data-listener-added')) {
            const content = button.nextElementSibling;
            const textElement = button.querySelector('.content-btn-viewer');

            if (content && content.classList.contains('content')) {
                textElement.textContent = content.classList.contains('hidden') ? 'View content' : 'Hide content';
            }

            button.addEventListener('click', function() {
                if (content) {
                    content.classList.toggle('hidden');
                    button.classList.toggle('collapsed');

                    textElement.textContent = content.classList.contains('hidden') ? 'View content' : 'Hide content';
                }
            });

            button.setAttribute('data-listener-added', 'true');
        }
    });
});
</script>

<script>
function applyTheme(theme) {
        document.body.classList.toggle('dark', theme === 'dark');
        document.body.classList.toggle('light', theme === 'light');
        if(theme == 'dark') {
            document.getElementById('theme-emoji').textContent = "🌙";
            document.getElementById('theme-text').textContent = "Dark";
        } else {
            document.getElementById('theme-emoji').textContent = "☀";
            document.getElementById('theme-text').textContent = "Light";
        }
        const elements = document.querySelectorAll('fieldset, div, legend, input[type="text"],input[type="url"], input[type="number"], input[type="submit"], button, .error-message, .info');
        elements.forEach(el => {
            el.classList.toggle('dark', theme === 'dark');
            el.classList.toggle('light', theme === 'light');
        });
}

document.addEventListener("DOMContentLoaded", () => {
    const toggleButton = document.getElementById('theme-toggle');
    
    const savedTheme = localStorage.getItem('theme-settings') || 'light';
    applyTheme(savedTheme);

    toggleButton.addEventListener('click', () => {
        const currentTheme = document.body.classList.contains('dark') ? 'dark' : 'light';
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        applyTheme(newTheme);
        localStorage.setItem('theme-settings', newTheme);
    });
});

function showConfirmation(callback) {
    const modal = document.createElement('div');
    modal.classList.add("modalTop");
    
    const confirmBox = document.createElement('div');
    confirmBox.classList.add("bg");
    confirmBox.style.padding = '20px';
    confirmBox.style.borderRadius = '10px';
    confirmBox.style.textAlign = 'center';
    confirmBox.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.2)';
    
    const message = document.createElement('p');
    message.textContent = 'Do you want to confirm this action?';
    message.style.fontSize = '16px';
    message.style.marginBottom = '20px';
    
    const buttonYes = document.createElement('button');
    buttonYes.classList.add("radiusdesing");
    buttonYes.classList.add("green-btn");
    buttonYes.textContent = 'Yes';
    buttonYes.style.backgroundColor = '#4CAF50';
    
    const buttonNo = document.createElement('button');
    buttonNo.classList.add("radiusdesing");
    buttonNo.classList.add("red-btn");
    buttonNo.textContent = 'No';
    buttonNo.style.backgroundColor = '#f44336';

    
    buttonYes.addEventListener('click', () => {
        callback(true);
        document.body.removeChild(modal);
    });
    
    buttonNo.addEventListener('click', () => {
        callback(false);
        document.body.removeChild(modal);
    });
    
    confirmBox.appendChild(message);
    confirmBox.appendChild(buttonYes);
    confirmBox.appendChild(buttonNo);
    
    modal.appendChild(confirmBox);
    document.body.appendChild(modal);

    const savedTheme = localStorage.getItem('theme-settings') || 'light';
    applyTheme(savedTheme);
}

</script>


<!-- 




    PHP CODE




 -->



<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($failed_conn) {

    } else if($logged && $isAdmin) {} else {echo "No permissions";} 
    function get_post_value($key) {
        return isset($_POST[$key]) ? $_POST[$key] : "";
    }

    $gauntlets = array(
        "-1" => array(
            "name" => "",
            "textColor" => "",
            "bgColor" => ""
        )
    );

    foreach ($_POST as $key => $value) {
        if (preg_match('/^gauntlet-(\d+)-name$/', $key, $matches)) {
            $index = $matches[1];
            if ($index !== "0" && ctype_digit($index)) {
                $gauntlets[$index] = array(
                    "name" => $value,
                    "textColor" => get_post_value("gauntlet-{$index}-textcolor"),
                    "bgColor" => get_post_value("gauntlet-{$index}-bgcolor")
                );
            }
        }
    }

    $songs = array(
        "-1" => array(
            "name" => "",
            "artist" => "",
            "songLink" => ""
        )
    );

    foreach ($_POST as $key => $value) {
        if (preg_match('/^song-(\d+)-name$/', $key, $matches)) {
            $index = $matches[1];
            if ($index !== "0" && ctype_digit($index)) {
                $songs[$index] = array(
                    "name" => $value,
                    "artist" => get_post_value("song-{$index}-artist"),
                    "songLink" => get_post_value("song-{$index}-songlink")
                );
            }
        }
    }

    $gdps_settings = array(
        "length" => array(
            "-1" => "",
            "0" => get_post_value("length-0"),
            "1" => get_post_value("length-1"),
            "2" => get_post_value("length-2"),
            "3" => get_post_value("length-3"),
            "4" => get_post_value("length-4"),
            "5" => get_post_value("length-5")
        ),
        "featured" => array(
            "-1" => "",
            "0" => get_post_value("featured-0"),
            "1" => get_post_value("featured-1")
        ),
        "epic" => array(
            "-1" => "",
            "0" => get_post_value("epic-0"),
            "1" => get_post_value("epic-1"),
            "2" => get_post_value("epic-2"),
            "3" => get_post_value("epic-3")
        ),
        "states_demon" => array(
            "-1" => "",
            "0" => get_post_value("states_demon-0"),
            "3" => get_post_value("states_demon-3"),
            "4" => get_post_value("states_demon-4"),
            "5" => get_post_value("states_demon-5"),
            "6" => get_post_value("states_demon-6")
        ),
        "states_diff_num" => array(
            "-1" => "",
            "0" => get_post_value("states_diff_num-0"),
            "10" => get_post_value("states_diff_num-10"),
            "20" => get_post_value("states_diff_num-20"),
            "30" => get_post_value("states_diff_num-30"),
            "40" => get_post_value("states_diff_num-40"),
            "50" => get_post_value("states_diff_num-50")
        ),
        "gauntlets" => $gauntlets,
        "official_songs" => $songs,
        "server_software" => get_post_value("server_software"),
        "gdbrowser_title" => get_post_value("gdbrowser_title"),
        "gdbrowser_name" => get_post_value("gdbrowser_name"),
        "gdbrowser_icon" => get_post_value("gdbrowser_icon"),
        "gdbrowser_icon_embed" => get_post_value("gdbrowser_icon_embed"),
        "gdbrowser_desc" => get_post_value("gdbrowser_desc"),
        "gdbrowser_assets_full_url" => get_post_value("gdbrowser_assets_full_url"),
        "show_level_passwords" => get_post_value("show_level_passwords"),
        "gdps_logo_url" => get_post_value("gdps_logo_url"),
        "gdps_level_browser_logo_url" => get_post_value("gdps_level_browser_logo_url"),
        "disable_colored_texture_level_browser" => get_post_value("disable_colored_texture_level_browser"),
        "path_connection" => get_post_value("path_connection"),
        "gdps_version" => get_post_value("gdps_version"),
        "path_lib_folder" => get_post_value("path_lib_folder"),
        "path_folder_levels" => get_post_value("path_folder_levels"),
        "browser_path" => get_post_value("browser_path"),
        "browser_theme_path" => get_post_value("browser_theme_path"),
        "browser_theme" => get_post_value("browser_theme")
    );

    $json_data = json_encode($gdps_settings, JSON_PRETTY_PRINT);
    file_put_contents("../gdps_settings.json", $json_data);


    $jsonFile = '../manifest.json';
    $data = json_decode(file_get_contents($jsonFile), true);

    $data['name'] = get_post_value('manifest_name');
    $data['theme_color'] = get_post_value('manifest_theme_color');
    $data['background_color'] = get_post_value('manifest_background_color');
    $data['short_name'] = get_post_value('manifest_short_name');
    $data['description'] = get_post_value('manifest_description');
    $data['start_url'] = get_post_value('manifest_start_url');

    file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT));


    ?>
    <script>
        CreateFLAlert("Saved!","Your settings have been saved successfully.")
        document.addEventListener('FLlayerclosed', function() {
		    console.log('FLlayerclosed event triggered! Reloading the page...');
		    window.location.href = window.location.href;
	    });
        // alert("Configurations saved!");
        // window.location.href = window.location.href;
    </script>

    <?php

} else {
    if($logged && $isAdmin) {} else {
        
    ?>
    <script>
        CreateFLAlert("Error","Failed to save your settings due to lack of permissions.")
        document.addEventListener('FLlayerclosed', function() {
		    console.log('FLlayerclosed event triggered! Reloading the page...');
		    window.location.href = window.location.href;
	    });
    </script>

    <?php
    } 
}
?>



</body>
</html>