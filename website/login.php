<!DOCTYPE html>
<html lang="sv">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php include "shared/header.php"; ?>
    <main style="text-align:center;">
        <form class="login-option-container" method="GET">
          <button class="login-option" name="login-as" value="patient">
            <img src="" alt="🩹" style="font-size:5em;">
            Logga in som privatperson
          </button>
          <button class="login-option" name="login-as" value="employee">
            <img src="" alt="🩺" style="font-size:5em;">
            Logga in som anställd
          </button>
        </form>
        <?php
          if (isset($_GET['login-as'])
              && ($_GET['login-as'] == 'employee' || $_GET['login-as'] == 'patient'))
          {
            include "shared/login-options.php";
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
