<?php


include("../_init_.php");


if ($isAdmin != "1" || $logged != true) {
    header("Location: ../");
    exit();
} else {
    $source = "../ogbrowser_init_updater.php";
    $destination = "../../ogbrowser_init_updater.php";

    if (file_exists($source)) {
        if (!rename($source, $destination)) {
            if (file_exists($destination) && is_writable($destination)) {
                unlink($destination);
                rename($source, $destination);
            }
        }
    }
    
    header("Location: ../../ogbrowser_init_updater.php");
    exit();
}

