<?php
    ini_set("display_errors", 1);
    ini_set("display_startup_errors", 1);
    error_reporting(E_ALL);
    
    session_start();
    
    print_r($_POST);
    
    if (isset($_POST['pnr'])
        and !empty($_POST['pnr'])
        and preg_match('/[0-9]{12}/', $_POST['pnr']))
    {
        $_SESSION['id'] = "G2:" . /* Lite magi för att göra ett token för personnummret */ $_POST['pnr'];

        header("Location: profile.php");
    }
    else
    {
        header("Location: login.php?err=invalidID");
    }
    
    exit();
?>
