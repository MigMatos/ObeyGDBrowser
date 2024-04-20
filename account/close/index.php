<?php

    session_start();

    // Eliminar variables de sesión específicas
    unset($_SESSION['userName']);
    unset($_SESSION['accountID']);
    unset($_SESSION['isAdmin']);
    header("Location: ../../");
    exit();
?>