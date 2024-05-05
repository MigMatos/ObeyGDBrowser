<!DOCTYPE html>
<html>
<head>
    <title>GDPS Configuration</title>
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

    function generate_inputs($config_data) {
        foreach ($config_data as $key => $value) {
            $display_key = ucfirst(str_replace(array('_', '-'), ' ', $key));
            if (is_array($value)) {
                echo "<fieldset><legend>$display_key</legend>";
                foreach ($value as $subkey => $subvalue) {
                    $display_subkey = ucfirst(str_replace(array('_', '-'), ' ', $subkey));
                    echo "<label for='$key.$subkey'>$display_subkey:</label>";
                    echo "<input type='text' id='$key.$subkey' name='$key.$subkey' value='$subvalue'><br>";
                }
                echo "</fieldset>";
            } else {
                echo "<label for='$key'>$display_key:</label>";
                if ($key === "gdps_version") $value = get_gameversion($value);
                echo "<input type='text' id='$key' name='$key' value='$value'><br>";
            }
        }
    }

    // generate_inputs($gdps_settings);
    ?>
    <br>

    <fieldset><legend><h2>GDPS Configuration</h2></legend>

    <form id="levelForm" method="POST" action="./savecon.php">


        <fieldset><legend><h5>Lengths (String)</h5></legend>

        <label for="length-0">Length 0:</label>
        <input type="text" id="length-0" ><br>
        <label for="length-1">Length 1:</label>
        <input type="text" id="length-1" ><br>
        <label for="length-2">Length 2:</label>
        <input type="text" id="length-2" ><br>
        <label for="length-3">Length 3:</label>
        <input type="text" id="length-3" ><br>
        <label for="length-4">Length 4:</label>
        <input type="text" id="length-4" ><br>
        <label for="length-5">Length 5:</label>
        <input type="text" id="length-5" ><br>
        
        </fieldset>


        <fieldset><legend><h5>Featured rates</h5></legend> 

        <label for="featured-0">Featured 0:</label>
        <input type="text" id="featured-0" ><br>
        <label for="featured-1">Featured 1:</label>
        <input type="text" id="featured-1" ><br>
        
        </fieldset>

        <fieldset><legend><h5>Epic rates</h5></legend>

        <label for="epic-0">Epic 0:</label>
        <input type="text" id="epic-0" ><br>
        <label for="epic-1">Epic 1:</label>
        <input type="text" id="epic-1" ><br>
        <label for="epic-2">Epic 2:</label>
        <input type="text" id="epic-2" ><br>
        <label for="epic-3">Epic 3:</label>
        <input type="text" id="epic-3" ><br>

        </fieldset>

        <fieldset><legend><h5>Demon difficulties</h5></legend>

        <label for="states_demon-0">Demon Type 0:</label>
        <input type="text" id="states_demon-0" ><br>
        <label for="states_demon-3">Demon Type 3:</label>
        <input type="text" id="states_demon-3" ><br>
        <label for="states_demon-4">Demon Type 4:</label>
        <input type="text" id="states_demon-4" ><br>
        <label for="states_demon-5">Demon Type 5:</label>
        <input type="text" id="states_demon-5"><br>
        <label for="states_demon-6">Demon Type 6:</label>
        <input type="text" id="states_demon-6" ><br>

        </fieldset>

        <fieldset><legend><h5>Difficulties</h5></legend>

        <label for="states_diff_num-0">Difficulty Type 0:</label>
        <input type="text" id="states_diff_num-0" ><br>
        <label for="states_diff_num-10">Difficulty Type 10:</label>
        <input type="text" id="states_diff_num-10" ><br>
        <label for="states_diff_num-20">Difficulty Type 20:</label>
        <input type="text" id="states_diff_num-20" ><br>
        <label for="states_diff_num-30">Difficulty Type 30:</label>
        <input type="text" id="states_diff_num-30" ><br>
        <label for="states_diff_num-40">Difficulty Type 40:</label>
        <input type="text" id="states_diff_num-40" ><br>
        <label for="states_diff_num-50">Difficulty Type 50:</label>
        <input type="text" id="states_diff_num-50"><br>

        </fieldset>
        
        <fieldset><legend><h5>GDBrowser Settings</h5></legend>
        
        <label for="gdbrowser_title">GDPS Title:</label>
        <input type="text" id="gdbrowser_title"><br>
        <label for="gdbrowser_name">GDPS Name:</label>
        <input type="text" id="gdbrowser_name"><br>
        <label for="gdbrowser_icon">GDPS Icon:</label>
        <input type="text" id="gdbrowser_icon"><br>
        <label for="gdbrowser_desc">GDPS Description:</label>
        <input type="text" size="100" id="gdbrowser_desc"><br>
        <label for="gdbrowser_assets_full_url">GDPS Assets Folder URL (for embeds):</label>
        <input type="text" size="50" id="gdbrowser_assets_full_url"><br>
        <!-- More -->
        <label for="show_level_passwords">Show Level Passwords:</label>
        <input type="number" id="show_level_passwords" min="0" max="1"><br>
        <label for="gdps_logo_url">GDPS Logo URL:</label>
        <input type="text" id="gdps_logo_url"><br>
        <label for="gdps_level_browser_logo_url">GDPS Level Browser Logo URL:</label>
        <input type="text" id="gdps_level_browser_logo_url"><br>
        <label for="disable_colored_texture_level_browser">Disable Colored Texture Level Browser:</label>
        <input type="number" id="disable_colored_texture_level_browser" min="0" max="1"><br>
        <label for="path_connection">Path Connection <label style="color:#af0000;">(Deprecated, please configure "Lib Folder"!):</label></label>
        <input type="text" id="path_connection"><br>
        <label for="gdps_version">GDPS Version:</label>
        <input type="number" id="gdps_version"><br>
        <label for="path_lib_folder" placeholder="../incl/lib/">Lib Folder:</label>
        <input type="text" id="path_lib_folder"><br><br>
        <label for="path_folder_levels">Levels Path Folder (Important for the level analyzer!)</label>
        <input type="text" id="path_folder_levels" placeholder="../../data/levels/"><br>
        </fieldset>

        <br>

        <input type="submit" value="Save">
        <button type="button" onclick="window.location.href = '../';">Back</button>

    </form>
    </fieldset>



    <script>
    
    const jsonData = <?php echo json_encode($gdps_settings); ?>

    function loadValues() {
            for (const key in jsonData) {
                let keyData = jsonData[key];
                if (keyData.constructor === ({}).constructor) {
                    for (const subKey in keyData) {
                        let subkeyData = keyData[subKey];
                        
                        try {document.getElementById(`${key}-${subKey}`).value = subkeyData;}
                        catch (e){console.log("IDElement no found: ", key, "-",subKey);}

                    } 
                    
                } else {
                    try {document.getElementById(`${key}`).value = keyData;}
                    catch (e){console.log("IDElement no found: ", key);}
                }
                
            }
    }

    loadValues();

    </script>
</body>
</html>
