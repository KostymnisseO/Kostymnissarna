<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    class ERPNextInterface 
    {
        private $api_file = "shared/api/erpnext.api";
        private $key = '';
        private $baseurl = 'http://193.93.250.83:8080/';
        private $cookiepath = "/tmp/cookies.txt";
        private $timeout = 60;
        private $default_opt_arr = [];
        private $ch;

        function __construct()
        {   
            $this->ch = curl_init();
            
            // Importera nyckel från fil
            if (file_exists($this->api_file)) 
            {
                file_get_contents($this->api_file);
                echo "API key found!";
            }
            else
            {
                $this->printError("ERPNext Error", "Missing API key.");
            }
            
            /*  för POST:
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => "{ 'key':'val', 'key':'val', ...}"
                för GET:
                    CURLOPT_URL => $baseurl . "/[destionation]" . "?key=val&key=val...",
                    CURLOPT_HTTPGET => true
            */
            
            
            $this->default_opt_arr = [
                CURLOPT_POSTFIELDS => $this->key,
                CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                // CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_COOKIEJAR => $this->cookiepath,
                CURLOPT_COOKIEFILE => $this->cookiepath,
                CURLOPT_TIMEOUT => $this->timeout
            ];
            
            try
            {
                curl_setopt_array($this->ch, $this->default_opt_arr);
                curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('Authorization: token ' . $this->key));
                curl_setopt($this->ch, CURLOPT_URL, $this->baseurl . 'api/method/frappe.auth.get_logged_user');
                
                echo '<br>';
                $response = curl_exec($this->ch);
                echo ' <- Huh?';
                
                echo '<br>$response<br><pre>';
                echo $response . "</pre><br>";
                echo "</div>";
                
                // $response = json_decode($response, true);
            }
            catch (Exception $e) 
            {
                $this->printError("Exception", $e->getMessage());
            }
            
            $this->printError(curl_errno($this->ch), curl_error($this->ch));
            
            // curl_exec($ch);
            //open curl connection
        }

        public function fetchPatientData()
        {

        }

        public function fetchStaffData()
        {
            
        }

        public function printError($errID, $err)
        {
            if (!empty($errID)) 
            {
                echo 
                    "<div class='error-msg'>" .
                    "<strong>ERROR " . $errID . " :</strong>" .
                    "<p>" . $err . "</p>" .
                    "</div>";
            }
        }

        function __destruct()
        {
            curl_close($this->ch);
        }
    }
?>
