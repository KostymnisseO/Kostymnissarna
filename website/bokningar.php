
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
    <h1>Tidsbokningar</h1>
    <?php
      include "shared/erpnextinterface.php";
      $createDoc = new ERPNextInterface();

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
    ?>

    <div class="container">
      <table border='1'>
        <tr>
          <th colspan='4'> 
            Mina bokningar 
          </th>
        </tr>
        <?php
          $data=$bookings['data'];
          $rows = count($bookings['data'])-1;

          for($num = 0; $num <= $rows; $num++)
          {
            echo "<tr>";
            echo "<form action='omboka.php' name='omboka' method='post'>";
            echo "<input type='hidden'  name='bookingID' value='".$data[$num]['name']."'>";
            //echo "<td><input type='hidden'  name='bookingID' value='".$data[$num]['name']."'></td>";

            echo "<td>". $data[$num]['appointment_date']. "\n". "</td>";  
            echo "<td>". $data[$num]['appointment_time']. "\n". "</td>";  
            echo "<td>". $data[$num]['practitioner_name']. "\n". "</td>";     


            echo "<td><input type='submit' value='Omboka'></td>";
              
            echo "</form>";
            echo "</tr>";
          }
        ?>

        </table>
      </div>
      <a class='push-button' href='ansokavard.php'>Boka ny tid</a>
    </main>
    <?php include "shared/footer.php"; ?>
  </body>
</html>
