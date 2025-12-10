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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <?php include "shared/header.php"?>
    <main>
        <?php
            if ($sesh->active())
            {
                $erp = new ERPNextInterface();
                $result = $erp->fetchAll('Patient', filters: [["Patient", "uid", "=", $sesh->id()]]);
                $usr = null;
                
                // print_r($result);
                
                if (sizeof($result['data']) == 1)
                {
                    $usr = $result['data']['0'];

                    echo "<h1>" . "Behandlingar för " . $usr['name'] . "</h1>";

                    
                    echo '<h2>' . 'Recept:' . '</h2>';
                    
                    $requests = $erp->fetchAll(
                        'Medication Request'
                        , filters: [['Medication Request', 'patient_name', '=', $usr['name']]]
                        , fields: [
                            'name'
                            , 'medication'
                            , 'medication_item'
                            , 'practitioner_name'
                            , 'dosage'
                            , 'dosage_form'
                            , 'order_date'
                            , 'total_dispensable_quantity'
                            , 'quantity'
                            , 'period'
                        ]
                    );
                    
                    if (sizeof($requests['data']) > 0)
                    {
                        // print_r($requests['data']);
                        // echo "<br><br>";
                        
                        foreach ($requests['data'] as $r)
                        {
                            echo '<div class="container">';
                            
                            echo 
                                '<h3>' . $r['medication'] . ', ' . $r['dosage_form'] . '</h3>' .
                                '<ul>' . // Gör om till tabell ist
                                    '<li>' . '<strong>Läkemedel: </strong>' . $r['medication_item'] . '</li>' .
                                    '<li>' . '<strong>Uttag: </strong>' . $r['quantity'] . ' / ' . $r['total_dispensable_quantity'] . '</li>' .
                                    '<li>' . '<strong>Dosering: </strong>' . $r['dosage'] . '</li>' .
                                    '<li>' . '<strong>Tidsperiod: </strong>' . $r['period'] . '</li>' .
                                    '<br>' . 
                                    '<li>' . '<small>' . 'Utskrivet av: ' . $r['practitioner_name'] . ', ' . $r['order_date'] . '</small>' . '</li>' .
                                '</ul>';
                            
                            echo 
                                '<form action="" method="POST">' .
                                    '<input type="hidden" name="prescription" value="'. $r['name']  .'">' .
                                    '<button class="push-button" type="submit">Begär förnyelse</button>' .
                                '</form>';

                            echo '</div>';
                        }
                    }
                    else
                    {
                        echo '<strong>' . 'Hmm... vi kan inte se att du behövt några receptbelagda läkemedel än så länge.' . '</strong>';
                    }
                }
            }
        ?>
    </main>
    <?php include "shared/footer.php"?>
</body>
</html>
