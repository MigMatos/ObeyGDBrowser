<?php

include("../_init_.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if($logged && $isAdmin) {} else {echo "No perms";}
    foreach ($_POST as $key => $value) {
        // Check if the value is a string and starts with '{' and ends with '}'
        if (is_string($value) && $value[0] === '{' && $value[strlen($value) - 1] === '}') {
            // Decode the JSON object
            $decoded_value = json_decode($value, true);
            if ($decoded_value !== null) {
                // If successfully decoded, assign to the key
                $gdps_settings[$key] = $decoded_value;
            } else {
                // If decoding failed, treat it as a regular key-value pair
                if (strpos($key, '.') !== false) {
                    list($parent_key, $subkey) = explode('.', $key);
                    $gdps_settings[$parent_key][$subkey] = $value;
                } else {
                    $gdps_settings[$key] = $value;
                }
            }
        } else {
            // Regular key-value pair
            if (strpos($key, '.') !== false) {
                list($parent_key, $subkey) = explode('.', $key);
                $gdps_settings[$parent_key][$subkey] = $value;
            } else {
                $gdps_settings[$key] = $value;
            }
        }
    }

    if (isset($gdps_settings['gdps_version'])) {
        $gdps_settings['gdps_version'] = get_revertgameversion(floatval($gdps_settings['gdps_version']));
    }

    $json_data = json_encode($gdps_settings, JSON_PRETTY_PRINT);
    file_put_contents("../gdps_settings.json", $json_data);

    echo "Configuration saved successfully.";
} else {
    if($logged && $isAdmin) {} else {header("Location: ../");}
    echo "";
}

function get_revertgameversion($data) {
    if ($data <= 1.0) {
        return 1;
    } elseif ($data < 1.8) {
        return (round($data * 10) - 10) + 1;
    } elseif ($data == 1.7) {
        return 10;
    } else {
        return round($data * 10);
    }
}
?>
