<?php
    include "../_init_.php";

    session_start();

    
    unset($_SESSION['userName']);
    unset($_SESSION['userID']);
    unset($_SESSION['accountID']);
    unset($_SESSION['isAdmin']);
    unset($_SESSION['userPermissions']);

    exit();
?>