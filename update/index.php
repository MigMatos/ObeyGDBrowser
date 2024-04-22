<?php


include("../_init_.php");


if ($isAdmin != "1" || $logged != true) {
    header("Location: ../");
    exit();
} else {
    header("Location: ../../ogbrowser_init_updater.php");
    exit();
}

