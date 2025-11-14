<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

class ERPNextInterface
{
    private $api_file = "shared/api/erpnext.api";
    private $key = "";
    private $baseurl = "http://193.93.250.83:8080/";
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
            $this->key = file_get_contents($this->api_file);
            // echo "API key found!";
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
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
            // CURLOPT_SSL_VERIFYPEER => false,
            // CURLOPT_RETURNTRANSFER => true, // Required to rerieve the response as a string, otherwise gets flushed out on the webpage
            CURLOPT_COOKIEJAR => $this->cookiepath,
            CURLOPT_COOKIEFILE => $this->cookiepath,
            CURLOPT_TIMEOUT => $this->timeout,
        ];

        try
        {
            curl_setopt_array($this->ch, $this->default_opt_arr);
            curl_setopt($this->ch, CURLOPT_URL, $this->baseurl . 'api/method/frappe.auth.get_logged_user');
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('Authorization: token ' . $this->key));
            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($this->ch);
            $response = json_decode($response, true);

            print_r($response);
        }
        catch (Exception $e)
        {
            $this->printError('Exception', $e->getMessage());
        }

        if (!empty($errID))
        {
            $this->printError(curl_errno($this->ch), curl_error($this->ch));
        }

    }

    public function login(string $usr, string $pwd)
    {

    }

    public function fetchResource(string $name, $opts = null)
    {
        $this->resetCurlHandle();
        $response = null;

        try
        {
            curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($this->ch, CURLOPT_URL, $this->baseurl . 'api/resource/' . rawurlencode($name));
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($this->ch);
            $response = json_decode($response, true);
        }
        catch (Exception $e)
        {
            $this->printError('Exception', $e->getMessage());
        }

        if (!empty($errID))
        {
            $this->printError(curl_errno($this->ch), curl_error($this->ch));
        }

        return $response;
    }

    public function printError($errID, $err)
    {
        echo '<div class="error-msg">' .
            '<strong>ERROR ' . $errID . ' :</strong>' .
            '<p>' . $err . '</p>' .
            '</div>';
    }

    protected function resetCurlHandle()
    {
        curl_reset($this->ch);
        curl_setopt_array($this->ch, $this->default_opt_arr);
    }

    function __destruct()
    {
        curl_close($this->ch);
    }
}
?>
