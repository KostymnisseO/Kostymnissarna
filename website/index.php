<?php include_once "shared/erpnextinterface.php"; ?>

<!DOCTYPE html>
<html lang="sv">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php include "shared/header.php"; ?>
    <main class="container">
        <?php
            $erp = new ERPNextInterface();
        ?>

        <pre>
        <?php
           print_r($erp->fetchAll('User'));
        ?>
        </pre>
        
    </main>
    <?php include "shared/footer.php"; ?>
  </body>
</html>
