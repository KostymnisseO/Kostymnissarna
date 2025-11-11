<?php
    /* Mer info: https://www.php.net/manual/en/language.oop5.php */

    class MyClass 
    {
        private $var = "";

        public function __construct()
        {
            $this->$var = "Set in constructor";
        }

        public function helloClass()
        {
            echo "Output inside method</br>";

            return "Output as return value";
        }

        public function getVar() { return $this->$var; }
        public function setVar($val) { $this->$var = $val; }
    }
?>