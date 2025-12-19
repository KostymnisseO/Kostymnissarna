
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
    <div>
        <h1>Omboka tid</h1>
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

   
   
        echo "<div class='container'>";
            $patient= $usr["name"];

            //{"name":"HLC-APP-2025-00223","owner":"a24ludha@student.his.se","creation":"2025-12-18 16:39:48.895983","modified":"2025-12-18 16:39:48.983532","modified_by":"a24ludha@student.his.se","docstatus":0,"idx":0,"naming_series":"HLC-APP-.YYYY.-","title":"G2Niklas Drake with G2Alban Nwapa","status":"Scheduled","custom_status_copy":"","appointment_type":"Läkare","appointment_for":"Practitioner","company":"Hälsan","practitioner":"G2Alban Nwapa","practitioner_name":"G2Alban Nwapa","department":"G2läkarmottagning","appointment_date":"2026-01-22","patient":"G2Niklas Drake","patient_name":"G2Niklas Drake","patient_sex":"Prefer not to say","duration":0,"appointment_time":"13:00:00","appointment_datetime":"2026-01-22 13:00:00","add_video_conferencing":0,"event":"EV00287","invoiced":0,"paid_amount":0,"position_in_queue":0,"appointment_based_on_check_in":0,"reminded":0,"doctype":"Patient Appointment","__last_sync_on":"2025-12-18T16:48:50.215Z"}
            $bookings = $createDoc->fetchAll('Patient Appointment', filters:[["Patient Appointment","patient_name", "=",$patient]], fields:["appointment_date","name","appointment_time", "practitioner_name"]);

            echo "<form id='kontaktForm' action='omboka.php' method='post' id='ombokaForm'>";
            echo "<input type='hidden'  name='bookingID' value='".$_POST['bookingID']."'>";
            
            $maxDate = strtotime("+3 months");
            echo  
              "<label for='date'>Nytt datum:<br>".
              "<input type='date' id='date' name='date' min='".date('Y-m-d')."' max ='".date("Y-m-d", $maxDate)."' required><br>" . 
              "</label>";

            echo 
              "<label for='time'>Ny tid:<br>" .
              "<input type='time' id='time' name='time' min='07:00' max ='17:00' step='3600' required>" .
              "</label>";

            echo  
              "<label for='typPers'>Vill du boka med läkare eller sjuksköterska?<br>" .
                "<select id='typPers' name='typPers' form='ombokaForm'>" .
                  "<option value='Sjuksköterska'>Sjuksköterska</option>" .
                  "<option value='Läkare'>Läkare</option>" .
                "</select>" .
              "</label>";
        
            echo "<input type='submit' value='Skicka in'>";
          
            echo "</form>";

        echo "</div>";

   
        if (isset($_POST['bookingID'])){
          $bokID = $_POST['bookingID'];
        }

        $dataArr = [
          "patient"=> $usr,
          "tid" => '15:00',
          "status" => 'Begärd',
          "typvårdpersonal" => 'Sjuksköterska',
          "datum" => 1999-12-12,
          "appointment_name" => $bokID,
        ];

        if (isset($_POST['typPers'])){
          $dataArr['typvårdpersonal'] = $_POST['typPers'];
        }

        if ((isset($_POST['time'])) && (isset($_POST['date']))){
          $dataArr['datum'] = $_POST['date'];
          $dataArr['tid'] = $_POST['time'];
          $createDoc -> createDocType('G2OmbokaTid',$dataArr);
        }

      ?>
    </main>
    <?php include "shared/footer.php"; ?>
  </body>
</html>
