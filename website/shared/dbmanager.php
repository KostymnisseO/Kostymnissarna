<?php
    ini_set("display_errors", 1);
    ini_set("display_startup_errors", 1);
    error_reporting(E_ALL);

    class DatabaseManager
    {   
        private string $driver = 'mysql';
        private string $dbname = 'grupp2';
        private string $host = 'localhost';
        private string $usr = 'sqllab';
        private string $pwd = 'Armadillo#2025';
        private $pdo = null;
        
        function __construct()
        {
            
            try {
                $this->pdo = new PDO(
                    $this->driver . ':' . 'dbname=' . $this->dbname . ';' . 'host=' . $this->host . ';'
                    , $this->usr
                    , $this->pwd
                );
                $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } 
            catch (PDOException $e) 
            {
                echo "<strong class='error'>";
                echo $e->getMessage();
                //echo "åtkomst nekad";
                echo "</strong>";
            }
        }
        
        public function fetchUserUID(string $sesh)
        {
            $stmt = $this->pdo->prepare('CALL get_uid(:SESSION)');
            $stmt->bindParam(':SESSION', $sesh);
            
            try
            {
                $stmt->execute();
            }
            catch (PDOException $e) 
            {
                echo "<strong class='error'>";
                echo $e->getMessage();
                echo "</strong>";
                return null;
            }
            
            return $stmt->fetchAll();
        }
        
        
        public function fetchActivityTimeDiff(string $sesh)
        {
            $stmt = $this->pdo->prepare('CALL get_timediff(:SESSION)');
            $stmt->bindParam(':SESSION', $sesh);
            
            try
            {
                $stmt->execute();
            }
            catch (PDOException $e) 
            {
                echo "<strong class='error'>";
                echo $e->getMessage();
                echo "</strong>";
                return null;
            }
            
            return $stmt->fetchAll();
        }
        
        
        public function registerSession(string $sesh, string $uid)
        {
            $stmt = $this->pdo->prepare('CALL register_session(:SESSION, :UID)');
            $stmt->bindParam(':SESSION', $sesh);
            $stmt->bindParam(':UID', $uid);
            
            try
            {
                $stmt->execute();
            }
            catch (PDOException $e) 
            {
                echo "<strong class='error'>";
                echo $e->getMessage();
                echo "</strong>";
                return false;
            }
            
            return true;
        }
        
        public function endSession(string $sesh)
        {
            $stmt = $this->pdo->prepare('CALL end_session(:SESSION)');
            $stmt->bindParam(':SESSION', $sesh);
            
            try
            {
                $stmt->execute();
            }
            catch (PDOException $e) 
            {
                echo "<strong class='error'>";
                echo $e->getMessage();
                echo "</strong>";
                return false;
            }
            
            return true;
        }
    }
    
    // if (session_status() == PHP_SESSION_NONE) {
    //     session_start();
    // }
    
    // echo session_id();
    // $db = new DatabaseManager();
    
    // $registered = $db->registerSession(session_id(), '199414166390');
    // echo '<pre>';
    // print_r($registered);
    // echo '</pre>';
    
    // $fetched = $db->fetchUserUID(session_id());
    // echo '<pre>';
    // print_r($fetched);
    // echo '</pre>';
?>
