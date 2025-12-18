<?php
    include_once "shared/sessionmanager.php";
    $sesh = new SessionManager();
    $sesh->end();
    header("Location: index.php");
    exit();
?>
