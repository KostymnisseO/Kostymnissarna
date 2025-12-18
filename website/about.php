<!DOCTYPE html>
<html lang="sv">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php include "shared/header.php"; 
    include_once "shared/erpnextinterface.php"?>
    <main>
        <?php 
        $erp = new ERPNextInterface(); 
        echo "<pre>";
        $sak = $erp->fetchAll('Healthcare Practitioner', pageLength:120, filters:[['first_name', 'like', '%G2%']], fields:['first_name', 'last_name', 'gender', 'department']);
        //print_r($sak);
        echo "</pre>";
        ?>
        
        <h1>Vårdcentralen i Mölndal</h1>
        <p>Välkommen till Vårdcentralen i Mölndal – din lokala vårdcentral med fokus på trygg, tillgänglig och personcentrerad vård. Vi finns här för dig genom hela livet och erbjuder hälso- och sjukvård av hög kvalitet för både barn och vuxna.</p>
        <h2>Vårt uppdrag</h2>
        <p>Vårt uppdrag är att främja hälsa, förebygga sjukdom och ge god vård när du behöver den. Vi möter varje patient med respekt, lyhördhet och professionalitet, och strävar efter att skapa långsiktiga relationer där du känner dig sedd och delaktig.</p>
        <h2>Våra tjänster</h2>
        <p>Här på Vårdcentralen i Mölndal erbjuder vi en stor variant av tjänster, allt från influensashots, sjukvård för fysiska och psykiska besvär som vanliga sjukdomar, skador och kroniska tillstånd, till digital vård ifall det önskas.</p>
        <h2></h2>
        <h1>Vårt team</h1>

        <div class="staff-view">
          <?php 
              $rows =$sak['data'] ?? [];

              foreach ($rows as $user) {

                  echo'<div class="staff-card container">';
                  echo'<img src="" alt="🧑‍⚕️" style="font-size:7em;"/>';
                  echo'<table>';

                      $first = $user['first_name'] ?? '';
                      $last = $user['last_name'] ?? '';
                      $gender = $user['gender'] ?? '';
                      $avdelning = $user['department'] ?? '';
                      echo '<tr><td>Namn</td><td>' . ($first) . ' ' . ($last) . '</td></tr>';
                      echo '<tr><td>Kön</td><td>' . ($gender) . '</td></tr>';
                      echo '<tr><td>Avdelning</td><td>' . ($avdelning) . '</td></tr>';
                  
                  echo'</table>';
                  echo'</div>';
              }
          ?>
        </div>
    </main>
    <?php include "shared/footer.php"; ?>
  </body>
</html>
