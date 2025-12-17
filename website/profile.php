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
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <?php include "shared/header.php"?>
    <div class="profile-grid">
        <?php
            $erp = new ERPNextInterface();

            if ($sesh->active())
            {
                $result = $erp->fetchAll('Patient', filters: [["Patient", "uid", "=", $sesh->id()]]);

                if (sizeof($result['data']) == 1)
                {
                    $usr = $result['data']['0'];
                }

                echo "<h1>" . "Hej " . $usr['name'] . "!" . "</h1>";
                echo "<h3>" . "Hur kan vi hjälpa dig idag?" . "</h3>";
            }
            else
            {
                echo "<h1>" . "Här får du inte vara!" . "</h1>";
            }
        ?>
        <main>
            <?php
                if (true /* är vårdtagare */)
                {
                    echo '<a class="profile-link" href=""><img src="" alt="⚪" style="font-size:7em"/>Min Sida 1</a>';
                    echo '<a class="profile-link" href="treatments.php"><img src="" alt="💊" style="font-size:7em"/>Mina Behandlingar</a>';
                    echo '<a class="profile-link" href="tests.php"><img src="" alt="🧪" style="font-size:7em"/>Mina Prover</a>';
                }
                else if (false /* är vårdpersonal */)
                {
                    //do stuff
                }
            ?>
        </main>
    </div>
    <?php include "shared/footer.php"?>
</body>
</html>
