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
    if (isset($_SESSION['id']))
    {
        echo '<a class="push-button" href="profile.php">Min profil</a>';
    }
    else
    {
        echo '<a class="push-button" href="login.php">Logga in</a>';
    }
  ?>
  
</header>
