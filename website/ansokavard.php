
<?php include_once "shared/sessionmanager.php";
$sesh = new SessionManager();

if (!$sesh->active())
{
    header("Location: logout.php");
    exit();
}
?>
<!DOCTYPE html>

<html lang="sv">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php include "shared/header.php"; ?>
    <main>
    <?php
    include "shared/erpnextinterface.php";
    
    ?>
    <h1>Ansök om vård</h1>
    <?php
      $createDoc = new ERPNextInterface();

      if ($sesh->active())
      {
        $result = $createDoc->fetchAll('Patient', filters: [["Patient", "uid", "=", $sesh->id()]]);

        if (sizeof($result['data']) == 1)
        {
          $usr = $result['data']['0'];
        }
      }
   
        echo "<div class='container'>";
          echo "<form action='ansokavard.php' method='post' id='kontaktForm'>";

          echo  
            "<label>" . 
              "<input type='checkbox' id='feverDays' name='feverDays' value=1>" . 
            "  Har du haft feber i över sju dygn?</label>";

          echo  
            "<label for='cough'>" . 
              "<input type='checkbox' id='cough' name='cough' value=1>" . 
            "  Har du hosta?</label>";

          echo  
            "<label for='coughBlood'>" . 
              "<input type='checkbox' id='coughBlood' name='coughBlood' value=1>" . 
            "  Kommer det blod när du hostar?</label>";

          echo  
            "<label for='heavyBreath'>" . 
              "<input type='checkbox' id='heavyBreath' name='heavyBreath' value=1>" . 
            "  Känns det tungt när du andas?</label>";

          echo  
            "<label for='ache'>" . 
              "<input type='checkbox' id='ache' name='ache' value=1>" . 
            "  Har du muskelvärk och/eller huvudvärk?</label>";
        
          echo  
            "<label for='sickDays'>" .
              "<input type='checkbox' id='sickDays' name='sickDays' value=1>" .
            "  Har du varit sjuk i mer än 7 dagar?</label>";

          echo  "<br><label for='misc'> Beskriv dina besvär med max 150 ord:</label>";
          echo  "<textarea id='misc' name='misc' maxlength='150'></textarea>";

          $maxDate = strtotime("+3 months");
          echo 
            "<label for='date'>Datum:<br>".
              "<input type='date' id='date' name='date' min='".date('Y-m-d')."' max ='".date("Y-m-d", $maxDate)."' required>".
            "</label>";

          echo 
            "<label for='time'>Tid:<br>".
              "<input type='time' id='time' name='time' min='07:00' max ='17:00' step='3600' required>" .
            "</label>";

          echo 
            "<label for='typPers'>Vill du boka med läkare eller sjuksköterska?<br>" .
              "<select id='typPers' name='typPers' form='kontaktForm'>" .
                "<option value='Sjuksköterska'>Sjuksköterska</option>" .
                "<option value='Läkare'>Läkare</option>" .
              "</select>" . 
            "</label>";
          
          echo 
            "<label for='bild'>Ladda upp bild på ditt besvär (valfritt):<br>" .
              "<input type='file' id='bild' name='bild' accept='image/png, image/jpeg, image/jfif'>" .
            "</label>";

          echo "<input type='submit' value='Submit'>";
        
          echo "</form>";
        echo "</div>";

        $dataArr = [
          "patient"=> $usr['name'],
          "feber_dagar" => 0,
          "hosta" => 0, 
          "blod_hosta" => 0, 
          "tung_andning" => 0, 
          "muskelvärk" => 0,
          "sjuk_dagar" => 0,
          "beskriv_besvär" => 'Nothing',
          "tid" => '15:00',
          "status" => 'Begärd',
          "typvårdpersonal" => 'Sjuksköterska',
          "bild_på_besvär" => "",
          "datum" => 1999-12-12,
        ];

        if (isset($_POST['feverDays'])){
          $dataArr['feber_dagar'] = $_POST['feverDays'];
        }
        if (isset($_POST['cough'])){
          $dataArr['hosta'] = $_POST['cough'];
        }
        if (isset($_POST['coughBlood'])){
          $dataArr['blod_hosta'] = $_POST['coughBlood'];
        }
        if (isset($_POST['heavyBreath'])){
          $dataArr['tung_andning'] = $_POST['heavyBreath'];
        }
        if (isset($_POST['ache'])){
          $dataArr['muskelvärk'] = $_POST['ache'];
        }
        if (isset($_POST['sickDays'])){
          $dataArr['sjuk_dagar'] = $_POST['sickDays'];
        }
        if (isset($_POST['misc'])){
          $dataArr['beskriv_besvär'] = $_POST['misc'];
        }
        if (isset($_POST['typPers'])){
          $dataArr['typvårdpersonal'] = $_POST['typPers'];
        }
        if (isset($_POST['bild'])){
          $dataArr['bild_på_besvär'] = $_POST['bild'];
        }

        if ((isset($_POST['time'])) && (isset($_POST['date']))){
          $dataArr['datum'] = $_POST['date'];
          $dataArr['tid'] = $_POST['time'];
          $createDoc -> createDocType('G2KontaktForm',$dataArr);
        }
      ?>
    </main>
    <?php include "shared/footer.php"; ?>
  </body>
</html>
