<div id="bankid-box" class="inset-container">
    <img style="max-height:5em;" src="https://www.bankid.com/assets/logo-bank-id-Bw0xWKml.svg" alt="BankID">

        <div class="bankid-qr">
            <img class="fade-in" src="https://randomqr.com/assets/images/rickroll-qrcode.webp" alt="BankID">
        </div>
        
        Skanna QR-koden med BankID-appen på din telefon eller ange ditt personnummer:
        <form method="POST" action="verification.php">
            <input type="text" name="pnr" pattern="[0-9]{12}" required="" maxlength="12" placeholder="ÅÅÅÅMMDDXXXX"></input>
            <button class="push-button" type="submit">→</button>
        </form>


        <a href="https://crouton.net/">Legitimera med BankID på denna enhet</a>
</div>
