<?php
    include_once "shared/sessionmanager.php";
    $sesh = new SessionManager();

    if ($sesh->active())
    {
        header("Location: index.php");
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
    <main style="text-align:center;display:flex;flex-direction:column;justify-content:flex-start;align-items:center;gap:2em;padding:2em;">
        <form class="login-option-container" method="GET">
          <button class="login-option" name="login-as" value="patient">
            <img src="" alt="🩹" style="font-size:5em;">
            Logga in som privatperson
          </button>
          <a class="login-option" href="http://193.93.250.83:8080/">
            <img src="" alt="🩺" style="font-size:5em;">
            Logga in som anställd &rarr;
          </a>
        </form>
        <?php
          if (isset($_GET['login-as'])
              && ($_GET['login-as'] == 'employee' || $_GET['login-as'] == 'patient'))
          {
            if(isset($_POST['login-with']))
            {
                include "shared/bankid.php";
            }
            else
            {
              include "shared/login-options.php";
            }
          }
        ?>
        <div>
          <h1>Alla ska ha rätt till en god vård.</h1>
          <a href="">Klicka här om du vill lista dig hos Vårdcentralen i Mölndal</a>
          <p>På Vårdcentralen i Mölndal är vår grundläggande övertygelse att rätten till en god och jämlik vård utgör hjärtat i ett tryggt samhälle. För oss innebär detta att varje invånare, oavsett bakgrund eller livssituation, ska ha tillgång till medicinsk expertis som präglas av både hög kompetens och djup mänsklig värme. Genom att kombinera det lokala perspektivet med en modern vård bär vi ett gemensamt ansvar för att du som patient alltid ska känna dig sedd, hörd och prioriterad. Vi strävar efter att vara en tillgänglig resurs som inte bara behandlar sjukdom, utan som främjar hälsa genom hela livet, där din rätt till god vård alltid står i centrum för varje beslut vi fattar och varje möte vi skapar här i Mölndal.</p>
          <h2>Välkommen till Din vårdcentral i Mölndal.</h2>
        </div>
    </main>
    <?php include "shared/footer.php"; ?>
  </body>
</html>
