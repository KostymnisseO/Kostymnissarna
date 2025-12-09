<div class="container">
    <img style="max-height:5em;" src="https://www.bankid.com/assets/logo-bank-id-Bw0xWKml.svg" alt="BankID">

        <div class="bankid-qr">


        <img class="fade-in-test" style="border:2px dotted var(--azure); padding:1.5em; border-radius:1em;max-height:14em;margin:auto;" src="https://randomqr.com/assets/images/rickroll-qrcode.webp" alt="BankID">

        Skanna QR-koden med BankID-appen på din telefon eller ange ditt personnummer:
        <form method="POST" action="verification.php">
            <input type="text" name="pnr" pattern="[0-9]{12}" required="" maxlength="12" placeholder="ÅÅÅÅMMDDXXXX"></input>
            <button type="submit">-></button>
        </form>

        </div>

        <a href="https://crouton.net/">Legitimera med BankID på denna enhet</a>
</div>
