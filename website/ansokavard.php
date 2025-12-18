
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
    <main>
    <?php include "shared/header.php";
    include "shared/erpnextinterface.php";
    
    ?>
    <div>
        <h1>Ansök om vård</h1>
    </div>
    <?php
    $createDoc = new erpnextinterface;

    if ($sesh->active())
    {
      $result = $createDoc->fetchAll('Patient', filters: [["Patient", "uid", "=", $sesh->id()]]);

      if (sizeof($result['data']) == 1)
      {
    $usr = $result['data']['0'];
      }


    }
   
echo "<div>";
echo "<table border='1' >";

        echo "<th>Frågor Övergrippande kontakt orsak</th>";
   
        echo "<tr>";
          echo "<form action='ansokavard.php' method='post' id='kontaktForm'>";

          echo  "<input type='checkbox' id='feverDays' name='feverDays' value=1>";
          echo  "<label for='feverDays'> Har du haft feber i över sju dygn? </label><br>";

          echo  "<input type='checkbox' id='cough' name='cough' value=1>";
          echo  "<label for='cough'> Har du hosta?</label><br>";

          echo  "<input type='checkbox' id='coughBlood' name='coughBlood' value=1>";
          echo  "<label for='coughBlood'> Kommer det blod när du hostar?</label><br>";

          echo  "<input type='checkbox' id='heavyBreath' name='heavyBreath' value=1>";
          echo  "<label for='heavyBreath'> Känns det tungt när du andas?</label><br>";

          echo  "<input type='checkbox' id='ache' name='ache' value=1>";
          echo  "<label for='ache'> Har du muskelvärk och/eller huvudvärk?</label><br>";

          echo  "<input type='checkbox' id='sickDays' name='sickDays' value=1>";
          echo  "<label for='sickDays'> Har du varit sjuk i mer än 7 dagar?</label><br>";

          echo  "<label for='misc'> Beskriv dina besvär med max 150 ord:</label><br>";
          echo  "<input type='text' id='misc' name='misc' maxlength='400'><br><br>";

          echo  "<label for='date'>datum för bokning (date and time):</label><br>";
          $maxDate = strtotime("+3 months");

          echo "<input type='date' id='date' name='date' min='".date('Y-m-d')."' max ='".date("Y-m-d", $maxDate)."' required><br>";

          echo  "<label for='time'>tid för bokning</label><br>";
          echo "<input type='time' id='time' name='time' min='07:00' max ='17:00' step='3600' required><br>";

          echo  "<label for='typPers'>Vill du boka med läkare eller sjuksköterska?</label><br>";
          echo "<select id='typPers' name='typPers' form='kontaktForm'>";
          echo    "<option value='Sjuksköterska'>Sjuksköterska</option>";
          echo    "<option value='Läkare'>Läkare</option>";
          echo "</select><br>";
          echo  "<label for='bild'>Ladda upp bild på ditt besvär</label><br>";
          echo "<input type='file' id='bild' name='bild' accept='image/png, image/jpeg, image/jfif'><br>";
      
          echo "<tr><input type='submit' value='Submit'></tr>";
        
          echo "</form>";
        echo "</tr>";

    echo "</table>";
    echo "</div>";

     $dataArr = [
  "patient"=> $usr,
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
