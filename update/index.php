<?php


include("../_init_.php");


if ($isAdmin != "1" || $logged != true) {
    header("Location: ../");
    exit();
} else {
    $source = "../ogbrowser_init_updater.php";
    $destination = "../../ogbrowser_init_updater.php";

    
    $content = file_get_contents($source);

    if ($content !== false) {
        file_put_contents($destination, $content);
    }
    
    
    header("Location: ../../ogbrowser_init_updater.php");
    exit();
}

