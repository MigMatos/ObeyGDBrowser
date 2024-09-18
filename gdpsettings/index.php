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
    
    <h4 style="margin: 0;display: flex;flex-wrap: nowrap;justify-content: center;align-items: center;">Theme: <button id="theme-toggle"><span id="theme-emoji">☀</span><span style="margin-left:1vh;" id="theme-text">Light</span></button></h3>

    <br>

    <fieldset><legend><h2>GDPS Configuration</h2></legend>

    <form id="levelForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">


    <fieldset><legend><h5>Lengths (String)</h5></legend> <button type="button" class="toggle-btn"><strong>View/Hide</strong><span>▼</span></button>
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


    <fieldset><legend><h5>Featured rates</h5></legend> 
        <button type="button" class="toggle-btn">
            <strong>View/Hide</strong>
            <span>▼</span>
        </button>    
        <div class="content hidden">
        <label for="featured-0">Featured 0:</label>
        <input type="text" id="featured-0" name="featured-0"><br>
        <label for="featured-1">Featured 1:</label>
        <input type="text" id="featured-1" name="featured-1"><br>
        </div>
    </fieldset>

    <fieldset><legend><h5>Epic rates</h5></legend>
        <button type="button" class="toggle-btn">
            <strong>View/Hide</strong>
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

    <fieldset><legend><h5>Demon difficulties</h5></legend>
        <button type="button" class="toggle-btn">
            <strong>View/Hide</strong>
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

    <fieldset><legend><h5>Difficulties</h5></legend>
        <button type="button" class="toggle-btn">
            <strong>View/Hide</strong>
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

    <fieldset><legend><h5>Gauntlets</h5></legend>
        <button type="button" class="toggle-btn">
            <strong>View/Hide</strong>
            <span>▼</span>
        </button>    
        <div class="content hidden">
        <label for="gauntlets-1">Gauntlet 1:</label>
        <input type="text" id="gauntlets-1" name="gauntlets-1" value="Fire"><br>

        <label for="gauntlets-2">Gauntlet 2:</label>
        <input type="text" id="gauntlets-2" name="gauntlets-2" value="Ice"><br>

        <label for="gauntlets-3">Gauntlet 3:</label>
        <input type="text" id="gauntlets-3" name="gauntlets-3" value="Poison"><br>

        <label for="gauntlets-4">Gauntlet 4:</label>
        <input type="text" id="gauntlets-4" name="gauntlets-4" value="Shadow"><br>

        <label for="gauntlets-5">Gauntlet 5:</label>
        <input type="text" id="gauntlets-5" name="gauntlets-5" value="Lava"><br>

        <label for="gauntlets-6">Gauntlet 6:</label>
        <input type="text" id="gauntlets-6" name="gauntlets-6" value="Bonus"><br>

        <label for="gauntlets-7">Gauntlet 7:</label>
        <input type="text" id="gauntlets-7" name="gauntlets-7" value="Chaos"><br>

        <label for="gauntlets-8">Gauntlet 8:</label>
        <input type="text" id="gauntlets-8" name="gauntlets-8" value="Demon"><br>

        <label for="gauntlets-9">Gauntlet 9:</label>
        <input type="text" id="gauntlets-9" name="gauntlets-9" value="Time"><br>

        <label for="gauntlets-10">Gauntlet 10:</label>
        <input type="text" id="gauntlets-10" name="gauntlets-10" value="Crystal"><br>

        <label for="gauntlets-11">Gauntlet 11:</label>
        <input type="text" id="gauntlets-11" name="gauntlets-11" value="Magic"><br>

        <label for="gauntlets-12">Gauntlet 12:</label>
        <input type="text" id="gauntlets-12" name="gauntlets-12" value="Spike"><br>

        <label for="gauntlets-13">Gauntlet 13:</label>
        <input type="text" id="gauntlets-13" name="gauntlets-13" value="Monster"><br>

        <label for="gauntlets-14">Gauntlet 14:</label>
        <input type="text" id="gauntlets-14" name="gauntlets-14" value="Doom"><br>

        <label for="gauntlets-15">Gauntlet 15:</label>
        <input type="text" id="gauntlets-15" name="gauntlets-15" value="Death"><br>

        <label for="gauntlets-16">Gauntlet 16:</label>
        <input type="text" id="gauntlets-16" name="gauntlets-16" value="Forest"><br>

        <label for="gauntlets-17">Gauntlet 17:</label>
        <input type="text" id="gauntlets-17" name="gauntlets-17" value="Rune"><br>

        <label for="gauntlets-18">Gauntlet 18:</label>
        <input type="text" id="gauntlets-18" name="gauntlets-18" value="Force"><br>

        <label for="gauntlets-19">Gauntlet 19:</label>
        <input type="text" id="gauntlets-19" name="gauntlets-19" value="Spooky"><br>

        <label for="gauntlets-20">Gauntlet 20:</label>
        <input type="text" id="gauntlets-20" name="gauntlets-20" value="Dragon"><br>

        <label for="gauntlets-21">Gauntlet 21:</label>
        <input type="text" id="gauntlets-21" name="gauntlets-21" value="Water"><br>

        <label for="gauntlets-22">Gauntlet 22:</label>
        <input type="text" id="gauntlets-22" name="gauntlets-22" value="Haunted"><br>

        <label for="gauntlets-23">Gauntlet 23:</label>
        <input type="text" id="gauntlets-23" name="gauntlets-23" value="Acid"><br>

        <label for="gauntlets-24">Gauntlet 24:</label>
        <input type="text" id="gauntlets-24" name="gauntlets-24" value="Witch"><br>

        <label for="gauntlets-25">Gauntlet 25:</label>
        <input type="text" id="gauntlets-25" name="gauntlets-25" value="Power"><br>

        <label for="gauntlets-26">Gauntlet 26:</label>
        <input type="text" id="gauntlets-26" name="gauntlets-26" value="Potion"><br>

        <label for="gauntlets-27">Gauntlet 27:</label>
        <input type="text" id="gauntlets-27" name="gauntlets-27" value="Snake"><br>

        <label for="gauntlets-28">Gauntlet 28:</label>
        <input type="text" id="gauntlets-28" name="gauntlets-28" value="Toxic"><br>

        <label for="gauntlets-29">Gauntlet 29:</label>
        <input type="text" id="gauntlets-29" name="gauntlets-29" value="Halloween"><br>

        <label for="gauntlets-30">Gauntlet 30:</label>
        <input type="text" id="gauntlets-30" name="gauntlets-30" value="Treasure"><br>

        <label for="gauntlets-31">Gauntlet 31:</label>
        <input type="text" id="gauntlets-31" name="gauntlets-31" value="Ghost"><br>

        <label for="gauntlets-32">Gauntlet 32:</label>
        <input type="text" id="gauntlets-32" name="gauntlets-32" value="Spider"><br>

        <label for="gauntlets-33">Gauntlet 33:</label>
        <input type="text" id="gauntlets-33" name="gauntlets-33" value="Gem"><br>

        <label for="gauntlets-34">Gauntlet 34:</label>
        <input type="text" id="gauntlets-34" name="gauntlets-34" value="Inferno"><br>

        <label for="gauntlets-35">Gauntlet 35:</label>
        <input type="text" id="gauntlets-35" name="gauntlets-35" value="Portal"><br>

        <label for="gauntlets-36">Gauntlet 36:</label>
        <input type="text" id="gauntlets-36" name="gauntlets-36" value="Strange"><br>

        <label for="gauntlets-37">Gauntlet 37:</label>
        <input type="text" id="gauntlets-37" name="gauntlets-37" value="Fantasy"><br>

        <label for="gauntlets-38">Gauntlet 38:</label>
        <input type="text" id="gauntlets-38" name="gauntlets-38" value="Christmas"><br>

        <label for="gauntlets-39">Gauntlet 39:</label>
        <input type="text" id="gauntlets-39" name="gauntlets-39" value="Surprise"><br>

        <label for="gauntlets-40">Gauntlet 40:</label>
        <input type="text" id="gauntlets-40" name="gauntlets-40" value="Mystery"><br>

        <label for="gauntlets-41">Gauntlet 41:</label>
        <input type="text" id="gauntlets-41" name="gauntlets-41" value="Cursed"><br>

        <label for="gauntlets-42">Gauntlet 42:</label>
        <input type="text" id="gauntlets-42" name="gauntlets-42" value="Cyborg"><br>

        <label for="gauntlets-43">Gauntlet 43:</label>
        <input type="text" id="gauntlets-43" name="gauntlets-43" value="Castle"><br>

        <label for="gauntlets-44">Gauntlet 44:</label>
        <input type="text" id="gauntlets-44" name="gauntlets-44" value="Grave"><br>

        <label for="gauntlets-45">Gauntlet 45:</label>
        <input type="text" id="gauntlets-45" name="gauntlets-45" value="Temple"><br>
        </div>
    </fieldset>




    <fieldset><legend><h5>GDBrowser Settings</h5></legend>

        <label for="gdbrowser_title">GDPS Title:</label>
        <input type="text" id="gdbrowser_title" name="gdbrowser_title"><br>
        <label for="gdbrowser_name">GDPS Name:</label>
        <input type="text" id="gdbrowser_name" name="gdbrowser_name"><br>
        <label for="gdbrowser_icon">GDPS Icon:</label>
        <input type="text" id="gdbrowser_icon" name="gdbrowser_icon"><br>
        <label for="gdbrowser_icon_embed">GDPS Icon URL (for embeds) <label style="color:#af0000;">[ONLY .JPG, JPEG AND .PNG]</label>: </label>
        <input type="text" id="gdbrowser_icon_embed" name="gdbrowser_icon_embed"><br>
        <label for="gdbrowser_desc">GDPS Description:</label>
        <input type="text" size="100" id="gdbrowser_desc" name="gdbrowser_desc"><br>
        <label for="gdbrowser_assets_full_url">GDPS Assets Folder URL (for embeds):</label>
        <input type="text" size="50" id="gdbrowser_assets_full_url" name="gdbrowser_assets_full_url"><br>
    <!-- More -->
        <label for="show_level_passwords">Show Level Passwords:</label>
        <input type="number" id="show_level_passwords" min="0" max="1" name="show_level_passwords"><br>
        <label for="gdps_logo_url">GDPS Logo URL:</label>
        <input type="text" id="gdps_logo_url" name="gdps_logo_url"><br>
        <label for="gdps_level_browser_logo_url">GDPS Level Browser Logo URL:</label>
        <input type="text" id="gdps_level_browser_logo_url" name="gdps_level_browser_logo_url"><br>

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
        <label for="disable_colored_texture_level_browser">Disable Colored Texture Level Browser:</label>
        <input type="number" id="disable_colored_texture_level_browser" min="0" max="1" name="disable_colored_texture_level_browser"><br>
        <label for="path_connection">Path Connection <label style="color:#af0000;">(Deprecated, please configure "Lib Folder"!):</label></label>
        <input type="text" id="path_connection" name="path_connection"><br>
        <label for="gdps_version">GDPS Version:</label>
        <input type="number" id="gdps_version" required name="gdps_version"><br>
        <label for="path_lib_folder" placeholder="../incl/lib/">Lib Folder:</label>
        <input type="text" id="path_lib_folder" required name="path_lib_folder"><br>
        <label for="path_folder_levels">Levels Path Folder (Important for the level analyzer!)</label>
        <input type="text" id="path_folder_levels" placeholder="../../data/levels/" name="path_folder_levels"><br>
    </fieldset>


        <br>

        <input type="submit" value="Save">
        <button type="button" onclick="window.location.href = '../';">Back</button>

    </form>
    </fieldset>



    <script>
    
    const jsonData = <?php echo json_encode($gdps_settings); ?>;

function loadValues() {
    for (const key in jsonData) {
        let keyData = jsonData[key];

        console.log(keyData);
        
        if (keyData.constructor === ({}).constructor) {
            for (const subKey in keyData) {
                let subkeyData = keyData[subKey];
                
                try {
                    let element = document.getElementById(`${key}-${subKey}`);
                    element.value = subkeyData;
                    
                } catch (e) {
                    console.log("ID Element not found: ", key, "-", subKey);
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

    </script>

<script>

document.querySelectorAll('.toggle-btn').forEach(button => {
        button.addEventListener('click', function() {
            const content = this.nextElementSibling;
            if (content && content.classList.contains('content')) {
                content.classList.toggle('hidden');
            }
            this.classList.toggle('collapsed');
        });
});

</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const toggleButton = document.getElementById('theme-toggle');
    
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
        const elements = document.querySelectorAll('fieldset, legend, input[type="text"], input[type="number"], input[type="submit"], button, .error-message, .info');
        elements.forEach(el => {
            el.classList.toggle('dark', theme === 'dark');
            el.classList.toggle('light', theme === 'light');
        });
    }

    const savedTheme = sessionStorage.getItem('theme') || 'light';
    applyTheme(savedTheme);

    toggleButton.addEventListener('click', () => {
        const currentTheme = document.body.classList.contains('dark') ? 'dark' : 'light';
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        applyTheme(newTheme);
        sessionStorage.setItem('theme', newTheme);
    });
});
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

    // Obtener los valores del formulario y almacenarlos en un diccionario PHP
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
        "gauntlets" => array(
            "-1" => "",
            "0" => get_post_value("gauntlets-0"),
            "1" => get_post_value("gauntlets-1"),
            "2" => get_post_value("gauntlets-2"),
            "3" => get_post_value("gauntlets-3"),
            "4" => get_post_value("gauntlets-4"),
            "5" => get_post_value("gauntlets-5"),
            "6" => get_post_value("gauntlets-6"),
            "7" => get_post_value("gauntlets-7"),
            "8" => get_post_value("gauntlets-8"),
            "9" => get_post_value("gauntlets-9"),
            "10" => get_post_value("gauntlets-10"),
            "11" => get_post_value("gauntlets-11"),
            "12" => get_post_value("gauntlets-12"),
            "13" => get_post_value("gauntlets-13"),
            "14" => get_post_value("gauntlets-14"),
            "15" => get_post_value("gauntlets-15"),
            "16" => get_post_value("gauntlets-16"),
            "17" => get_post_value("gauntlets-17"),
            "18" => get_post_value("gauntlets-18"),
            "19" => get_post_value("gauntlets-19"),
            "20" => get_post_value("gauntlets-20"),
            "21" => get_post_value("gauntlets-21"),
            "22" => get_post_value("gauntlets-22"),
            "23" => get_post_value("gauntlets-23"),
            "24" => get_post_value("gauntlets-24"),
            "25" => get_post_value("gauntlets-25"),
            "26" => get_post_value("gauntlets-26"),
            "27" => get_post_value("gauntlets-27"),
            "28" => get_post_value("gauntlets-28"),
            "29" => get_post_value("gauntlets-29"),
            "30" => get_post_value("gauntlets-30"),
            "31" => get_post_value("gauntlets-31"),
            "32" => get_post_value("gauntlets-32"),
            "33" => get_post_value("gauntlets-33"),
            "34" => get_post_value("gauntlets-34"),
            "35" => get_post_value("gauntlets-35"),
            "36" => get_post_value("gauntlets-36"),
            "37" => get_post_value("gauntlets-37"),
            "38" => get_post_value("gauntlets-38"),
            "39" => get_post_value("gauntlets-39"),
            "40" => get_post_value("gauntlets-40"),
            "41" => get_post_value("gauntlets-41"),
            "42" => get_post_value("gauntlets-42"),
            "43" => get_post_value("gauntlets-43"),
            "44" => get_post_value("gauntlets-44"),
            "45" => get_post_value("gauntlets-45")
        ),
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
        "path_folder_levels" => get_post_value("path_folder_levels")
    );

    $json_data = json_encode($gdps_settings, JSON_PRETTY_PRINT);
    file_put_contents("../gdps_settings.json", $json_data);

    ?>
    <script>
        alert("Configurations saved!");
    </script>

    <?php

} else {
    if($logged && $isAdmin) {} else {
        
    ?>
    <script>
        alert("Error saving!");
    </script>

    <?php
    } 
}
?>

</body>
</html>