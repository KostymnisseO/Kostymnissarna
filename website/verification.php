<?php
    ini_set("display_errors", 1);
    ini_set("display_startup_errors", 1);
    error_reporting(E_ALL);
    
    
    include_once "shared/erpnextinterface.php";
    // include_once "shared/sessionmanager.php";
    session_start();
    
    print_r($_POST);
    
    if (isset($_POST['pnr'])
        and !empty($_POST['pnr'])
        and preg_match('/[0-9]{12}/', $_POST['pnr']))
    {
        $erp = new ERPNextInterface();
        $pnr_erp = "G2:" . $_POST['pnr'];
        
        $result = $erp->fetchAll('Patient', filters: [["Patient", "uid", "=", $pnr_erp]], fields: ['uid']);
 
        if (sizeof($result['data']) == 1)
        {
            $usr = $result['data']['0'];

            $_SESSION['id'] = $usr['uid'];
            header("Location: profile.php");
        }
        else
        {
            header("Location: login.php?err=doesNotExist");
        }
    }
    else
    {
        header("Location: login.php?err=invalidID");
    }
    
    exit();
?>
