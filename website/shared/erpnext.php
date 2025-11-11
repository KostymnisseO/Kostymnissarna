<?php
    class ERPNextInterface 
    {
        private string $api_file = "shared/api/erpnext.api";
        private string $key = ''; // importera från fil

        function __construct()
        {   
            if (file_exists($this->api_file))
            {
                $this->key = file_get_contents($this->api_file);
            }
            else
            {
                $this->key = "Missing API file: " . $this->api_file;
            }

            //open curl connection
        }

        public function fetchPatientData()
        {

        }

        public function fetchStaffData()
        {
            
        }

        function __destruct()
        {
            //close curl connection
        }
    }
?>