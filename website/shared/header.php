<?php
    include_once "shared/sessionmanager.php";
    $sesh = new SessionManager();
?>

<header>
  <a class="logo" href="index.php">
    <img src="" alt="Mölndals Vårdcentral">
  </a>
  <!--
  <nav>
    <a href="">Sida 1</a>
    <a href="">Sida 2</a>
    <a href="contact.php">Kontakt</a>
    <a href="about.php">Om oss</a>
  </nav>
  -->
  <nav>
    <?php
      echo $sesh->active() ?
        '<a class="push-button" href="profile.php">Min profil</a>' . '<a href="logout.php">→ Logga ut</a>' :
        '<a class="push-button" href="login.php">Logga in</a>';
    ?>
  </nav>
</header>
