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
                
                echo "<div class='profile-greeter'>";
                echo "<h1>" . "Hej " . $usr['name'] . "!" . "</h1>";
                echo "<h3>" . "Hur kan vi hjälpa dig idag?" . "</h3>";
                echo "</div>";
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
                    echo '<a class="profile-link" href="journal.php"><img src="" alt="📋" />Min Journal</a>';
                    echo '<a class="profile-link" href="treatments.php"><img src="" alt="💊" />Mina Behandlingar</a>';
                    echo '<a class="profile-link" href="tests.php"><img src="" alt="🧪" />Mina Prover</a>';
                    echo '<a class="profile-link" href="bokningar.php"><img src="" alt="📅" />Mina Bokningar</a>';
                    echo '<a class="profile-link" href="feedback.php"><img src="" alt="🩵" >Återkoppla</a>';   
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
