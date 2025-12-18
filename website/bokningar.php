
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
$patient= $usr["name"];
$bookings = $createDoc->fetchAll('Patient Appointment', filters:[["Patient Appointment","patient_name", "=",$patient]], fields:["appointment_date","name","appointment_time", "practitioner_name"]);
    }
    echo "<table border='1' >";
    $data=$bookings['data'];
    echo "<th> Mina bokningar </th>";

    $rows = count($bookings['data'])-1;
        for($num = 0; $num <= $rows; $num++){
        echo "<tr>";
        echo "<td><form action='omboka.php' name='omboka' method='post'>";
        echo "<input type='hidden'  name='bookingID' value='".$data[$num]['name']."'>";

        echo "<td>". $data[$num]['appointment_date']. "\n". "</td>";  
        echo "<td>". $data[$num]['appointment_time']. "\n". "</td>";  
        echo "<td>". $data[$num]['practitioner_name']. "\n". "</td>";     

  
        echo "<td><input type='submit' value='Omboka'></td>";
        
    echo "</form></td>";
        echo "</tr>";
        }

    echo "</table>";
    
   
echo "<div>";
echo "<a href='ansokavard.php'>Boka ny tid</a>";

  echo "</div>";







     ?>
    
    

    </main>
    <?php include "shared/footer.php"; ?>
  </body>
</html>
