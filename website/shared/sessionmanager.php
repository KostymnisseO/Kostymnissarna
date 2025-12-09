<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

class SessionManager
{
    function __construct()
    {
        session_start();
        
        // Checka att sessionen är giltig
        // if (!$this->isValid())
        // {

        // }
    }
    
    public function register(string $id)
    {
        // Magi för att registrera i databasen
        
        $_SESSION['id'] = $id;
    }
    
    public function id()
    {
        return $_SESSION['id']; // gör om för att arbeta med tokens istället
    }
    
    public function active()
    {
        // Magi för att checka mot databasen

        return (isset($_SESSION['id']) and !empty($_SESSION['id']));
    }
    
    public function end()
    {
        return session_unset();
    }
}

?>
