<!DOCTYPE html>

<?php
    // if (isset($_SESSION['uid']))
    // {
    //     continue;
    // }
    // else
    // {
    //     continue; //redirect
    // }
?>

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
        <h1>
            <?php echo true ? "Hej " . "Användare" : ""; ?>
        </h1>
        <main>
            <?php
                if (true /* är vårdtagare */)
                {
                    echo '<a class="profile-link" href=""><img src="" alt="⚪"/>Min Sida 1</a>';
                    echo '<a class="profile-link" href=""><img src="" alt="⚪"/>Min Sida 2</a>';
                    echo '<a class="profile-link" href=""><img src="" alt="⚪"/>Min Sida 3</a>';
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
