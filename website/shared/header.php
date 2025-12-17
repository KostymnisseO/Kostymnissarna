<?php
    include_once "shared/sessionmanager.php";
    $sesh = new SessionManager();
?>

<header>
  <a class="logo" href="http://193.93.250.83/wwwit-utv/Grupp2/dev/oscar/">
    <img src="" alt="Mölndals Vårdcentral">
  </a>
  <nav>
    <a href="">Sida 1</a>
    <a href="">Sida 2</a>
    <a href="">Sida 3</a>
    <a href="about.php">Om oss</a>
  </nav>
  <?php
    if ($sesh->active())
    {
        echo '<a class="push-button" href="profile.php">Min profil</a>';
        echo '<a class="push-button" href="logout.php">Logga ut</a>';
    }
    else
    {
        echo '<a class="push-button" href="login.php">Logga in</a>';
    }
  ?>
  
</header>
