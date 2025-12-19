<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once "shared/sessionmanager.php";
include_once "shared/erpnextinterface.php";
$sesh = new SessionManager();

if (!$sesh->active())
{
    header("Location: logout.php");
    exit();
}

$erp = new ERPNextInterface ();

//echo $sesh->id();

$fetched = $erp -> fetchAll ('Patient');
$Patient_Name = $erp->fetchAll('Patient', filters: [["Patient", "uid", "=", $sesh->id()]]);

//echo "<pre>";
//print_r($Patient_Name['data'][0]);
//echo "</pre>";



$PatientId = $Patient_Name['data'][0]['name'];
// echo $PatientId;

$fetched = $erp -> fetchDocType ('Patient', $PatientId);
//echo "<pre>";
//print_r($fetched);
//echo "</pre>";

$cookiepath = "/tmp/cookies.txt";
$tmeout = 3600;
$baseurl = 'http://193.93.250.83:8080/';



// $ch = curl_init($baseurl . 'api/method/login');
// curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_POSTFIELDS, '{"usr":"b24danan@student.his.se", "pwd":"His25HT!"}'); 
// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
// curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
// curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiepath);
// curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiepath);
// curl_setopt($ch, CURLOPT_TIMEOUT, $tmeout);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// $loginResponse = curl_exec($ch);
// $loginResponse = json_decode($loginResponse, true);
// $error_no = curl_errno($ch);
// $error = curl_error($ch);
// curl_close($ch);

// echo "<div style='background-color:lightgray; border:1px solid black'>";
//echo 'LOGIN RESPONSE:<br><pre>';
//print_r($loginResponse) . "</pre><br>";
//echo "</div>";




$encounters = $erp->fetchAll(
        'Patient Encounter'
        , filters: [['Patient Encounter', 'patient_name', '=', $PatientId]]
        , fields: ['patient', 'patient_name', 'custom_symtom', 'custom_diagnos', 'encounter_date', 'practitioner_name', 'medical_department']
);
//echo "<pre>";
//print_r($encounters);
//echo "</pre>";
//echo "<pre>";
//print_r($encounters['data'][0]);
//echo "</pre>";





$labtests = $erp->fetchAll(
        'Lab Test'
        , filters: [['Lab Test', 'patient_name', '=', $PatientId]]
        , fields: ['name', 'lab_test_name', 'date', 'result_date', 'practitioner_name', 'normal_test_items']
);
//echo "<pre>";
//print_r($labtests);
//echo "</pre>";


//detaljer labtest inklusive normal_test_items
$detail_responses = [];

foreach ($labtests as &$lab) {

    if (!isset($lab['name']) || $lab['name'] === '') {
        continue;
    }

    $lab_detail_url = $baseurl . 'api/resource/Lab%20Test/' . urlencode((string)$lab['name']);

    $ch = curl_init($lab_detail_url);
    curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST  => 'GET',
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json', 'Accept: application/json'],
            CURLOPT_COOKIEJAR      => $cookiepath,
            CURLOPT_COOKIEFILE     => $cookiepath,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => $tmeout,
            CURLOPT_SSL_VERIFYPEER => false,
    ]);

    $raw_response = curl_exec($ch);

    if ($raw_response === false) {
        $detail_responses[] = [
                'lab_name' => $lab['name'],
                'error'    => curl_error($ch),
        ];
        curl_close($ch);
        continue;
    }

    $detail_response = json_decode($raw_response, true);

    if (!isset($detail_response['data'])) {
        $detail_responses[] = [
                'lab_name' => $lab['name'] ?? '[unknown]',
                'error'    => 'Invalid API response',
                'raw'      => $raw_response,
        ];
        curl_close($ch);
        continue;
    }

    // Attach data back to the lab item
    $lab['normal_test_items'] = $detail_response['data']['normal_test_items'] ?? [];

    // Collect response for debugging / logging
    $detail_responses[] = [
            'lab_name' => $lab['name'],
            'response' => $detail_response,
    ];

    curl_close($ch);
}
unset($lab); // break reference

?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <title>Min journal</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include "shared/header.php";?>
    <!-- <nav class="navbar">
        <div class="nav-brand">
            <a href="index.php" style="color: white; text-decoration: none;">
                Mölndals Vårdcentral
            </a>
        </div> -->


<main class="main-flex-vertical" style="align-items:flex-start;">
    <div class="welcome-text">
        <h1 class="welcome-title">Din Journal</h1>
        <p class="welcome-subtitle">Här kan du ta del av dina journalanteckningar och provsvar tryggt och enkelt.</p>
    </div>

<h2>Journalanteckningar</h2>

<?php if (!empty($encounters['data'])): ?>
<div class="card-container">
    <?php foreach ($encounters['data'] as $encounter): ?>
        <div class="card">
            <div class="journal-header">
                <?= htmlspecialchars($encounter['encounter_date'] ?? '') ?>
            </div>
            <p><strong>Symtom: </strong><?= htmlspecialchars($encounter['custom_symtom'] ?? 'Ej angivet') ?></p>
            <p><strong>Diagnos: </strong><?= htmlspecialchars($encounter['custom_diagnos'] ?? 'Ingen diagnos registrerad') ?></p>
            <p><strong>Vårdgivare:</strong> <?= htmlspecialchars($encounter['practitioner_name'] ?? 'Okänd') ?></p>
            <p><strong>Avdelning:</strong> <?= htmlspecialchars($encounter['medical_department'] ?? '') ?></p>
        </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
    <p>Ingen journaldata hittades för dig.</p>
<?php endif; ?>


<h2>Provsvar</h2>
<?php if (!empty($labtests['data'])): ?>
<div class="card-container">
    <?php foreach ($labtests['data'] as $lab): ?>
        <div class="lab-entry">
            <div class="lab-entry-header">
                <span><strong>Provnamn:</strong></span> <?= htmlspecialchars((string)($lab['lab_test_name'] ?? '')) ?>
            </div>
            <div>
                <span><strong>Datum:</strong></span><?= htmlspecialchars((string)($lab['date'] ?? '')) ?>
            </div>
            
            <p><strong>Utfärdat av: </strong> <?= htmlspecialchars((string)($lab['practitioner_name'] ?? '')) ?>

            <?php if (!empty($lab["normal_test_items"])): ?>
                <table class="lab-table">
                    <thead>
                        <tr>
                            <th>Analys</th>
                            <th>Resultat</th>
                            <th>Referensintervall</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lab["normal_test_items"] as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item["lab_test_name"]) ?></td>
                                <td>
                                    <?= htmlspecialchars($item["result_value"]) ?>
                                    <?= htmlspecialchars($item["lab_test_uom"]) ?>
                                </td>
                                <td><?= htmlspecialchars($item["normal_range"]) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
    <p> Inga provsvar hittades.</p>
<?php endif; ?>
</main>
<?php include "shared/footer.php";?>
<!-- <footer>
    <div class="footer-grid">
        <div>
            <h3>Kontakt</h3>
            <p>✉️ info@molndalsvardcentral.se</p>
            <p>📍 Mölndalsvägen 22</p>
        </div>

        <div>
            <h3>Öppettider</h3>
            <p>Mån–Fre: 08–20</p>
            <p>Lör: 10–14</p>
        </div>

        <div>
            <h3>Akut hjälp</h3>
            <p>Ring 112 vid livshotande tillstånd.</p>
            <p>För rådgivning – 1177 Vårdguiden.</p>
        </div>
    </div>
    <p style="margin-top:20px;">© 2025 Mölndals Vårdcentral</p>
</footer> -->
</body> 
</html>

