<?php
include("../_init_.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if($logged && $isAdmin) {} else {echo "No permissions";} 
    function get_post_value($key) {
        return isset($_POST[$key]) ? $_POST[$key] : "";
    }

    // Obtener los valores del formulario y almacenarlos en un diccionario PHP
    $gdps_settings = array(
        "length" => array(
            "0" => get_post_value("length-0"),
            "1" => get_post_value("length-1"),
            "2" => get_post_value("length-2"),
            "3" => get_post_value("length-3"),
            "4" => get_post_value("length-4"),
            "5" => get_post_value("length-5")
        ),
        "featured" => array(
            "0" => get_post_value("featured-0"),
            "1" => get_post_value("featured-1")
        ),
        "epic" => array(
            "0" => get_post_value("epic-0"),
            "1" => get_post_value("epic-1"),
            "2" => get_post_value("epic-2"),
            "3" => get_post_value("epic-3")
        ),
        "states_demon" => array(
            "0" => get_post_value("states_demon-0"),
            "3" => get_post_value("states_demon-3"),
            "4" => get_post_value("states_demon-4"),
            "5" => get_post_value("states_demon-5"),
            "6" => get_post_value("states_demon-6")
        ),
        "states_diff_num" => array(
            "0" => get_post_value("states_diff_num-0"),
            "10" => get_post_value("states_diff_num-10"),
            "20" => get_post_value("states_diff_num-20"),
            "30" => get_post_value("states_diff_num-30"),
            "40" => get_post_value("states_diff_num-40"),
            "50" => get_post_value("states_diff_num-50")
        ),
        "gdbrowser_title" => get_post_value("gdbrowser_title"),
        "gdbrowser_name" => get_post_value("gdbrowser_name"),
        "gdbrowser_icon" => get_post_value("gdbrowser_icon"),
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


    header("Location: ./");
} else {
    if($logged && $isAdmin) {} else {header("Location: ../");}
    echo "";
}
?>
