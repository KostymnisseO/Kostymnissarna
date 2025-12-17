<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

include_once "erpnextlistquery.php";

class ERPNextInterface
{
    private $apiFile = "shared/api/erpnext.api";
    private $key = "";
    private $baseurl = "http://193.93.250.83:8080/";
    private $cookiepath = "/tmp/G2cookies.txt";
    private $timeout = 3600;
    private $defaultCurlOptArr = [];
    private $ch;

    function __construct()
    {
        $this->ch = curl_init();

        // Importera nyckel från fil
        if (file_exists($this->apiFile))
        {
            $this->key = trim(file_get_contents($this->apiFile));
            // echo "API key found!";
        }
        else
        {
            $this->printError("ERPNext Error", "Missing API key.");
        }

        /*
            för POST:
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => "{ 'key':'val', 'key':'val', ...}"
            för GET:
                CURLOPT_URL => $baseurl . "/[destionation]" . "?key=val&key=val...",
                CURLOPT_HTTPGET => true
        */

        $this->defaultCurlOptArr = [
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
            // CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true, // Required to rerieve the response as a string, otherwise gets flushed out on the webpage. Comment out to get the error traceback!
            CURLOPT_COOKIEJAR => $this->cookiepath,
            CURLOPT_COOKIEFILE => $this->cookiepath,
            CURLOPT_TIMEOUT => $this->timeout,
        ];


        // curl_setopt_array($this->ch, $this->defaultCurlOptArr);
        // curl_setopt($this->ch, CURLOPT_URL, $this->baseurl . 'api/method/frappe.auth.get_logged_user');
        // curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('Authorization: token ' . $this->key));

        // $this->request();
    }

    // public function login(string $usr, string $pwd)
    // {

    // }

    public function createDocType(string $doctype, array $fields)
    {

        $this->resetCurlHandle();

        $url = $this->baseurl . 'api/resource/' . rawurlencode($doctype);

        // echo '<pre>';
        // print_r(json_encode($fields));
        // echo '</pre>';

        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json', 'Authorization: token ' . $this->key));
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($fields));

        return $this->request();
    }


    public function fetchDocType(string $doctype, string $name, bool $expand = false)
    {
        $this->resetCurlHandle();

        $url = $this->baseurl . 'api/resource/' . rawurlencode($doctype . '/' . $name);
        $url .= $expand ? '?expand_links=True' : '';

        // echo $url;

        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json', 'Authorization: token ' . $this->key));


        return $this->request();
    }


    public function fetchAll(string $doctype, ?array $fields = null, ?array $filters = null, ?int $pageLength = null, ?int $startPage = null, ?array $expands = null)
    {
        $this->resetCurlHandle();
        $query = new ERPNextListQuery($fields, $filters, $pageLength, $startPage, $expands);

        $url = $this->baseurl . 'api/resource/' . rawurlencode($doctype) . $query->queryString();
        // echo $url;

        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json', 'Authorization: token ' . $this->key));

        return $this->request();
    }


    public function updateDocType(string $doctype, string $name, array $data)
    {
        $this->resetCurlHandle();

        $url = $this->baseurl . 'api/resource/' . rawurlencode($doctype . '/' . $name);
        echo $url;

        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('Authorization: token ' . $this->key));


        return $this->request();
    }


    public function deleteDocType(string $doctype, string $name)
    {
        $this->resetCurlHandle();

        // Verify the existence of the doctype first?
        // We get a "does not exist error" in the response

        echo $url = $this->baseurl . 'api/resource/' . rawurlencode($doctype . '/' . $name);
        echo $url;

        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('Authorization: token ' . $this->key));

        return $this->request();
    }


    private function request()
    {
        try
        {
            $response = curl_exec($this->ch);
            $response = json_decode($response, true);
        }
        catch (Exception $e)
        {
            $this->printError('EXCEPTION:', $e->getMessage());
        }

        if (!empty(curl_errno($this->ch)))
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
        curl_setopt_array($this->ch, $this->defaultCurlOptArr);
    }


    function __destruct()
    {
        curl_close($this->ch);
    }
}
?>
