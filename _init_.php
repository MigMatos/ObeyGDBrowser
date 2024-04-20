<?php
    session_start();

    $logged = false;
    $userName = isset($_SESSION['userName']) ? $_SESSION['userName'] : "None";
    $accountID = isset($_SESSION['accountID']) ? $_SESSION['accountID'] : 0;
    $isAdmin = isset($_SESSION['isAdmin']) ? $_SESSION['isAdmin'] : 0;
    if (isset($_SESSION['userName']) && isset($_SESSION['accountID']) && isset($_SESSION['isAdmin'])) {
        $logged = true;
    }

?>