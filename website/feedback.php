<?php
  include_once "shared/sessionmanager.php";
  include_once "shared/erpnextinterface.php";
  $sesh = new SessionManager();

  if (!$sesh->active())
  {
      header("Location: logout.php");
      exit();
  }
?>

<!DOCTYPE html>
<html lang="">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php include 'shared/header.php'?>
    <main>
      <?php
            $erp = new ERPNextInterface();
            $result = $erp->fetchAll('Patient', filters: [["Patient", "uid", "=", $sesh->id()]]);
            $usr = null;

            if (sizeof($result['data']) == 1)
            {
                $usr = $result['data']['0'];

                echo '<h1>' . 'Återkoppla' . '</h1>';

                // Hämta samtliga Medication Requests för patienten med relevanta fält
                $encounters = $erp->fetchAll(
                    'Patient Encounter'
                    , filters: [['Patient Encounter', 'patient_name', '=', $usr['name']]]
                    , fields: [
                        'name'
                        , 'practitioner_name'
                        , 'encounter_date'
                        , 'patient_age'
                        , 'patient_sex'
                    ]
                );

                // echo '<pre>';
                // print_r($encounters['data']);
                // echo '</pre>';
                // echo "<br><br>";

                if (sizeof($encounters['data']) > 0)
                {
                    usort($encounters['data'], function($a, $b) { return $a['encounter_date'] <=> $b['encounter_date']; });
                }
            }
        ?>
        <form action="" method="POST">
          <input type="hidden" name="age" value="<?php echo $encounters['data'][0]['patient_age'] ?>"> 
          <input type="hidden" name="sex" value="<?php echo $encounters['data'][0]['patient_sex'] ?>">
          <label>
            Välj möte:
            <select name="encounter">
              <?php
                foreach ($encounters['data'] as $enc)
                  {
                    echo '<option value="' , $enc['name'] , '">' . $enc['practitioner_name'] . ' - ' . $enc['encounter_date'] . '</option>';
                  }
              ?>
            </select>
          </label>
          <button type="submit">Välj</button>
        </form>

        <?php
          if (isset($_POST['encounter']))
          {
            $encounter = $erp->fetchDocType('Patient Encounter', $_POST['encounter']);
                       
            // echo '<pre>';
            // print_r($encounter['data']);
            // echo '</pre>';
            
            if (isset($encounter['data']))
            {
              include 'feedback_form.php';
            }
          }
        ?>
    </main>
    <?php include 'shared/footer.php'?>
  </body>
</html>
