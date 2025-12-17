<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

include_once 'dbmanager.php';

class SessionManager
{
    private $db = null;

    function __construct()
    {
        $this->db = new DatabaseManager();
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Checka att sessionen är giltig
        // if (!$this->isValid())
        // {

        // }
    }
    
    public function register(string $id)
    {
        // Magi för att registrera i databasen
        // if ($db->fetchUserUID)
        // {
        //     $db->registerSession(realSession(), $id);
        // }
        
        
        /* 
            session_id() kan användas för att få sessionen i webbläsaren.
            vi kan lagra det i databasen med en användares personnummer för att 
            hålla en patient inloggad kopplad till personnummer 
        */
        
        $_SESSION['id'] = $id;
    }
    
    public function id()
    {
        //$db->fetchUserUID(session_id());
        
        return $_SESSION['id']; // gör om för att arbeta med tokens istället
    }
    
    public function realSession()
    {
        return session_id(); // gör om för att arbeta med tokens istället
    }
    
    public function active()
    {
        // Magi för att checka mot databasen

        return (isset($_SESSION['id']) and !empty($_SESSION['id']));
    }
    
    public function end()
    {
        // Ta bort från databasen
        return session_unset();
    }
}

?>
