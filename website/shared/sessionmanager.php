<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

include_once 'dbmanager.php';

class SessionManager
{
    private $db = null;
    private int $timeout_s = 3600; // 1 timme i sek

    function __construct()
    {
        $this->db = new DatabaseManager();
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if ($this->active())
        {
            $diff = $this->db->fetchActivityTimeDiff(session_id());
            
            if ($diff[0]['time_diff'] > $this->timeout_s)
            {
                $this->end();
            }
        }
    }
    
    public function register(string $uid)
    {
        if (!$this->active())
        {
            $id = $this->db->registerSession(session_id(), $uid);
        }
        
        return $this->active();
    }
    
    public function id()
    {
        if ($this->active())
        {
            $sesh = $this->db->fetchUserUID(session_id());
            return 'G2:'.$sesh[0]['uid'];
        }
        
        return null;
    }
    
    public function active()
    {
        $results = $this->db->fetchUserUID(session_id());
        return (sizeof($results) == 1);
    }
    
    public function end()
    {
        if ($this->active())
        {
            $this->db->endSession(session_id());
        }
        return session_unset();
    }
}

// $sesh = new SessionManager();

// echo session_id();

// echo '<br><br>';

// // $reg = $sesh->register('123456780000');
// // echo "REGISTERED: ";
// // echo var_dump($reg);

// $end = $sesh->end();
// echo "ENDED: ";
// echo var_dump($end);

// echo '<br><br>';

// $exists = $sesh->active();

// echo var_dump($exists);

// echo '<br><br>';

// $uid = $sesh->id();

// var_dump($sesh->id());
?>
