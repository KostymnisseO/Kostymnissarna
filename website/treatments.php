<?php
    include_once "shared/sessionmanager.php";
    include_once "shared/erpnextinterface.php";
    $sesh = new SessionManager();

    if (!$sesh->active())
    {
        header("Location: logout.php");
        exit();
    }

    // "Grafik" för receptets status
    function statusIndicator(string $status)
    {
        $indicator = '';

        switch ($status)
        {
            case 'Active':
                $indicator = "🟢  Aktiv";
                break;

            case 'Cancelled':
                $indicator = "🔴  Avbruten";
                break;

            case 'Completed':
                $indicator = "🔵  Genomförd";
                break;

            case 'Draft':
                $indicator = "🟡  Väntar på svar";
                break;

            case 'Ended':
                $indicator = "🔴  Avslutad";
                break;

            case 'On Hold':
                $indicator = "🟠  Pausad";
                break;

            default:
                $indicator = "❓  Okänd Status";
                break;
        }

        return $indicator;
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

                    // Hämta samtliga Medication Requests för patienten med relevanta fält
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
                            , 'quantity'
                            , 'qty_invoiced'
                            , 'number_of_repeats_allowed'
                            , 'total_dispensable_quantity'
                            , 'period'
                            , 'status'
                            , 'docstatus'
                        ]
                    );

                    if (sizeof($requests['data']) > 0)
                    {
                        usort($requests['data'], function($a, $b) { return $a['docstatus'] <=> $b['docstatus']; });

                        // echo '<pre>';
                        // print_r($requests['data']);
                        // echo "<br><br>";
                        // echo '</pre>';

                        foreach ($requests['data'] as $r)
                        {
                            // Hitta existerande Medication Requests för samma läkemedel som inväntar svar från vårdgivare
                            $drafts = $erp->fetchAll(
                                'Medication Request'
                                , filters: [
                                    ['Medication Request', 'patient_name', '=', $usr['name']]
                                    , ['Medication Request', 'status', 'like', 'draft%']
                                    , ['Medication Request', 'medication_item', '=', $r['medication_item']]
                                ]
                                , fields: ['medication_item']
                            );

                            // Status för Medication request
                            $status_code = $erp->fetchDocType("Code Value", $r['status']);
                            $status = $status_code['data']['display'];


                            // HTML-element för recept
                            echo '<div class="container">';
                            echo '<small>' . statusIndicator($status) . '</small>';

                            echo
                                '<h3>' . $r['medication'] . ', ' . $r['dosage_form'] . '</h3>';

                            if ($status != 'Draft')
                            {
                                echo
                                    '<ul>' . // Gör om till tabell ist
                                        // '<li>' . '<strong>Läkemedel: </strong>' . $r['medication_item'] . '</li>' .
                                        '<li>' . '<strong>Mängd: </strong>' . $r['quantity'] . '</li>' .
                                        '<li>' . '<strong>Dosering: </strong>' . $r['dosage'] . '</li>' .
                                        '<li>' . '<strong>Tidsperiod: </strong>' . $r['period'] . ' (' . $r['number_of_repeats_allowed'] . ($r['number_of_repeats_allowed'] == 1 ? ' påfyllning)' : ' påfyllningar)') . '</li>' .
                                        '<br>' .
                                        '<li>' . '<strong>Kvarvarande uttag: </strong>' . $r['total_dispensable_quantity'] - $r['qty_invoiced'] . ' / ' . $r['total_dispensable_quantity'] . '</li>' .
                                        '<br>' .
                                        '<li>' . '<small>' . 'Förskrivet av: ' . $r['practitioner_name'] . ', ' . $r['order_date'] . '</small>' . '</li>' .
                                    '</ul>';

                                // Visa förnya-knapp om relevant
                                if ($r['total_dispensable_quantity'] == $r['qty_invoiced']
                                    and sizeof($drafts['data']) == 0)
                                {
                                    echo
                                    '<form action="renew.php" method="POST">' .
                                        '<input type="hidden" name="presc" value="'. $r['name']  .'">' .
                                        '<button class="push-button" type="submit">Begär förnyelse</button>' .
                                    '</form>';

                                }

                            }
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
