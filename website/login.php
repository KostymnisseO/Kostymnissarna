<!DOCTYPE html>
<html lang="sv">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php include "shared/header.php"; ?>
    <main style="text-align:center;display:flex;flex-direction:column;justify-content:space-evenly;align-items:center;gap:2em;padding:2em;">
        <form class="login-option-container" method="GET">
          <button class="login-option" name="login-as" value="patient">
            <img src="" alt="🩹" style="font-size:5em;">
            Logga in som privatperson
          </button>
          <a class="login-option" href="http://193.93.250.83:8080/">
            <img src="" alt="🩺" style="font-size:5em;">
            Logga in som anställd
          </a>
        </form>
        <?php
          if (isset($_GET['login-as'])
              && ($_GET['login-as'] == 'employee' || $_GET['login-as'] == 'patient'))
          {
            if(isset($_POST['login-with']))
            {
                echo '<div class="container">';
                echo '<img style="max-height:7em;" src="https://www.bankid.com/assets/logo-bank-id-Bw0xWKml.svg" alt="BankID">';
                echo '<br>';
                echo '<br>';
                echo '<div class="bankid-qr">';
                echo '<img class="fade-in-test" style="border:2px dotted var(--azure); padding:1.5em; border-radius:1em;max-height:14em;margin:auto;" src="https://randomqr.com/assets/images/rickroll-qrcode.webp" alt="BankID">';
                echo '</div>';
                echo '<br>';
                echo '<br>';
                echo 'Skanna QR-koden med BankID-appen på din telefon.';
                echo '<br>';
                echo '<a href="https://crouton.net/">Legitimera med BankID på denna enhet</a>';
                echo '</div>';
            }
            else
            {
              include "shared/login-options.php";
            }
          }
        ?>
        <div class="container">
          <h1>Alla ska ha rätt till en god vård.</h1>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin porttitor nunc at viverra congue. Nullam consectetur gravida eros viverra aliquam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Curabitur volutpat libero sed odio posuere viverra. In ipsum arcu, vulputate nec justo vel, cursus tristique tortor. Praesent vitae justo non lorem fringilla blandit. Nunc vitae quam varius, porta turpis sed, vestibulum mi. Mauris aliquet egestas justo non iaculis. Donec gravida quam eu mi eleifend, quis ullamcorper mi semper. Etiam vel diam sit amet tortor sagittis finibus volutpat non nisl. Morbi eu facilisis diam. Vestibulum auctor condimentum mattis. Duis nec tincidunt ligula, et malesuada purus. </p>
          <a href="">Klicka här för att lista dig hos Vårdcentralen i Mölndal</a>
        </div>
    </main>
    <?php include "shared/footer.php"; ?>
  </body>
</html>
