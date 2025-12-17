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
    <?php include 'shared/header.php'?>
    <main>
        <?php
            if ($sesh->active())
            {
                $erp = new ERPNextInterface();
                $patient = $erp->fetchAll('Patient', filters: [["Patient", "uid", "=", $sesh->id()]]);
                
                if (sizeof($patient['data']) == 1)
                {
                    $usr = $patient['data']['0'];
                    $labTests = $erp->fetchAll(
                        'Lab Test'
                        , filters: [['Lab Test', 'patient_name', '=', $usr['name']]]
                        , fields: [
                            'name'
                            , 'lab_test_name'
                            , 'date'
                            , 'result_date'
                            , 'submitted_date'
                            , 'expected_result_date'
                            , 'lab_test_comment'
                        ]
                    );
                    
                    if (sizeof($labTests['data']) > 0)
                    {
                        
                        echo "<h1>" . "Prover för " . $usr['name'] . "</h1>";
                        echo 
                            '<p>' . 'Vi kommer att kontakta dig personligen efter att dina provsvar publicerats. Notera att tiden från att resultatet publiceras och att vi kontaktar dig kan variera.' . '</p>' . 
                            '<p>' . 'Vid ytterligare frågor, vänligen kontakta vårdcentralen. Klicka ' . '<a href="contact.php">här</a>' . ' för att se vår kontaktinformation och våra öppettider.' . '</p>';
                        
                        /* --- RESULTS --- */
                        ?>
                        
                        <label for="toggleResults"><h3>Visa / Dölj Provsvar</h3></label>
                        <p> För att visa dina provsvar behöver du godkänna att det kan visas upprörande, schockerande eller livsändrande information du nödvndigtvis inte var beredd för</p>
                        <input type="checkbox" id="toggleResults" onclick="toggleResultsView()">
                        <label for="toggleResults">Tryck här ifall du godkänner att se provsvar</label>
                        
                        <div id="resultsContainer" style="display: none;">

                        <?php
                        echo '<h2>' . '🔵 Provsvar' . '</h2>';
                        $labTests = $erp->fetchAll(
                            'Lab Test'
                            , filters: [
                                ['Lab Test', 'patient_name', '=', $usr['name']]
                                , ['Lab Test', 'status', '=', 'Completed']
                                ]
                            , fields: [
                                'name'
                                , 'lab_test_name'
                                , 'date'
                                , 'result_date'
                                , 'submitted_date'
                                , 'lab_test_comment'
                            ]
                        );
                        
                        foreach ($labTests['data'] as $tst)
                        {
                            echo '<div class="container">';
                            
                            // echo '<small>' . $tst['name'] . '</small>'; // DEBUG
                            
                            /*
                                Vi kan använda MariaDB-databasen för att lagra att en patient godtyckt till och visat sitt provsvar
                            */
                            
                            echo '<h3>' . $tst['lab_test_name'] . '</h3>';
                            echo 
                                '<ul>' .
                                    '<li>' . '<strong>' . 'Inlämnades: ' . '</strong>' . $tst['date'] .'</li>' .
                                    '<li>' . '<strong>' . 'Svarsdatum: ' . '</strong>' . $tst['result_date'] . ' (Publicerat ' . strtok($tst['submitted_date'], ' ') . ')</li>';
                                    
                                    echo '<li>' . '<h4>' . 'Resultat: ' . '</h4>' . 'RESULTAT' .'</li>';
                                    
                                    if (!empty($tst['lab_test_comment']))
                                    {
                                        echo '<li>' . '<h4>' . 'Kommentar:' . '</h4>' . $tst['lab_test_comment'] .'</li>';
                                    }
                                    
                                    //echo '<li>' . '<strong>' . ': ' . '<strong>' . '' . '</li>';
                            echo '</ul>' ;
                            
                            echo '</div>';
                        }
                        ?>
                        </div>
                        <?php

                        /* --- ONGOING (DRAFTS) --- */
                        echo '<h2>' . '🟡 Pågående' . '</h2>';
                        $labTests = $erp->fetchAll(
                            'Lab Test'
                            , filters: [
                                ['Lab Test', 'patient_name', '=', $usr['name']]
                                , ['Lab Test', 'status', '=', 'Draft']
                                ]
                            , fields: [
                                'name'
                                , 'lab_test_name'
                                , 'date'
                                , 'expected_result_date'
                            ]
                        );
                        
                        foreach ($labTests['data'] as $tst)
                        {
                            echo '<div class="container">';
                            
                            // echo '<small>' . $tst['name'] . '</small>'; // DEBUG
                            
                            echo '<h3>' . $tst['lab_test_name'] . '</h3>';
                            echo 
                                '<ul>' .
                                    '<li>' . '<strong>' . 'Inlämnades: ' . '</strong>' . $tst['date'] .'</li>' .
                                    '<li>' . '<strong>' . 'Förväntat svarsdatum: ' . '</strong>' . $tst['expected_result_date'] . '</li>' .
                                '</ul>' ;
                            
                            echo '</div>';
                        }
                        
                        
                        /* --- CANCELLED --- */
                        echo '<h2>' . '🔴 Avbrutna' . '</h2>';

                        $labTests = $erp->fetchAll(
                            'Lab Test'
                            , filters: [
                                ['Lab Test', 'patient_name', '=', $usr['name']]
                                , ['Lab Test', 'status', '=', 'Cancelled']
                                ]
                            , fields: [
                                'name'
                                , 'lab_test_name'
                                , 'date'
                                , 'modified'
                                , 'lab_test_comment'
                            ]
                        );

                        foreach ($labTests['data'] as $tst)
                        {
                            echo '<div class="container">';
                            
                            // echo '<small>' . $tst['name'] . '</small>'; // DEBUG
                            
                            echo '<h3>' . $tst['lab_test_name'] . '</h3>';
                            echo 
                                '<ul>' .
                                    '<li>' . '<strong>' . 'Inlämnades: ' . '</strong>' . $tst['date'] .'</li>' .
                                    '<li>' . '<strong>' . 'Avbruten: ' . '</strong>' . $tst['modified'] . '</li>' .
                                    '<li>' . '<strong>' . 'Kommentar: ' . '</strong>' . $tst['lab_test_comment'] . '</li>' .
                                '</ul>' ;
                            
                            echo '</div>';
                        }
                        
                        // echo '<pre>';
                        // print_r($labTests['data']);
                        // echo "<br><br>";
                        // echo '</pre>';
                    }
                    else
                    {
                        echo '<strong>' . 'Hmm... vi kan inte se att du behövt några receptbelagda läkemedel än så länge.' . '</strong>';
                    }
                }
                else
                {
                    echo "<strong>" . "Ogiltig patient." . "</strong>";
                }
            }
        ?>
    </main>
    <?php include 'shared/footer.php'?>

    <script>
    function toggleResultsView(){
        var checkbox = document.getElementById("toggleResults");
        var container = document.getElementById("resultsContainer");

        if(checkbox.checked){
            container.style.display = "block";
        } else {
            container.style.display = "none";
    }
}
    </script>

</body>
</html>
