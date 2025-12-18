<form action="" method="POST" class="container">
  <fieldset class="feedback-horizontal">
    <label>
      Ålder:
      <input type='text' name='age' required="" readonly="" value="<?php echo $_POST['age']?>"> 
    </label>
    
    <label>
      Kön:
      <input type='text' name='sex' required="" readonly="" value="<?php echo $_POST['sex']?>">
    </label>
  </fieldset>

  <fieldset class="feedback-vertical">
    <legend>Allmänt om ditt besök på vårdcentralen</legend>
    <fieldset>
      <legend>Fick du möjlighet att ställa frågorna du önskade?</legend>
      <label>
        Ja
        <input type="radio" name="questions" value="1"  required=""/>
      </label>
      <label>
        Nej
        <input type="radio" name="questions" value="0"/>
      </label>
    </fieldset>
    <fieldset>
      <legend>Var det enkelt att ta till sig informationen under vårdmötet?</legend>
      <label>
        Ja
        <input type="radio" name="accessible-info" value="1" required=""/>
      </label>
      <label>
        Nej
        <input type="radio" name="accessible-info" value="0"/>
      </label>
    </fieldset>
    <fieldset>
      <legend>Är du nöjd med det sätt du kan komma i kontakt med vårdcentralen?</legend>
      <label>
        Ja
        <input type="radio" name="contactability" value="1" required=""/>
      </label>
      <label>
        Nej
        <input type="radio" name="contactability" value="0"/>
      </label>
    </fieldset>
    <fieldset>
      <legend>Var väntan i väntrummet längre än 20 min?</legend>
      <label>
        Ja
        <input type="radio" name="wait-time" value="1"  required=""/>
      </label>
      <label>
        Nej
        <input type="radio" name="wait-time" value="0"/>
      </label>
    </fieldset>
  </fieldset>

  <fieldset class="feedback-vertical">
    <legend>Information och kunskap</legend>
    <fieldset>
      <legend>Fick du tillräckligt med information om din behandling och eventuella bieffekter?</legend>
      <label>
        Ja
        <input type="radio" name="treatment-info" value="1"  required=""/>
      </label>
      <label>
        Nej
        <input type="radio" name="treatment-info" value="0"/>
      </label>
    </fieldset>
    <fieldset>
      <legend>Om du ställde frågor till vårdpersonalen fick du svar som du förstod?</legend>
      <label>
        Ja
        <input type="radio" name="simple-answers" value="1"  required=""/>
      </label>
      <label>
        Nej
        <input type="radio" name="simple-answers" value="0"/>
      </label>
    </fieldset>
    <fieldset>
      <legend>Förklarade läkaren/sjuksköterskan/annan vårdpersonal behandlingen på ett sätt som du förstod?</legend>
      <label>
        Ja
        <input type="radio" name="simple-explanation" value="1" required=""/>
      </label>
      <label>
        Nej
        <input type="radio" name="simple-explanation" value="0"/>
      </label>
    </fieldset>
    <fieldset>
      <legend>Blev du informerad om ett kommande världsförlopp?</legend>
      <label>
        Ja
        <input type="radio" name="world-event" value="1" required=""/>
      </label>
      <label>
        Nej
        <input type="radio" name="world-event" value="0"/>
      </label>
    </fieldset>
  </fieldset>
  <fieldset>
    <legend>Är det något från de ovannämnda frågorna som du specifikt vill utveckla? (Fritext på max 500 ord)</legend>
    <textarea name="comments" maxlength="500"></textarea>
  </fieldset>
  <button class="push-button" type="submit">Lämna in</button>
</form>