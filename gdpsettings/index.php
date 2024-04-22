<!DOCTYPE html>
<html>
<head>
    <title>GDPS Configuration</title>
</head>
<body bgcolor="#999999">
    <h2>GDPS Configuration</h2>
    <?php

    include("../_init_.php");
    if($logged && $isAdmin) {} else {header("Location: ../");}
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

    generate_inputs($gdps_settings);
    ?>
    <br>
    <input type="button" value="Save" onclick="saveConfig()">
    <button type="button" onclick="window.location.href = '../';">Back</button>

    <script>
    function saveConfig() {
        var formData = new FormData();
        var elements = document.getElementsByTagName("input");
        for (var i = 0; i < elements.length; i++) {
            var name = elements[i].name;
            var value = elements[i].value;

            // Check if name contains a dot (.)
            if (name.indexOf('.') !== -1) {
                // Split name into parent key and subkey
                var splitName = name.split('.');
                var parentKey = splitName[0];
                var subKey = splitName[1];

                // Append to form data with correct structure
                if (!formData.has(parentKey)) {
                    formData.append(parentKey, '{"' + subKey + '":"' + value + '"}');
                } else {
                    var existingData = JSON.parse(formData.get(parentKey));
                    existingData[subKey] = value;
                    formData.set(parentKey, JSON.stringify(existingData));
                }
            } else {
                formData.append(name, value);
            }
        }

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "mod.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert(xhr.responseText);
            }
        };
        xhr.send(formData);
    }
    </script>
</body>
</html>
