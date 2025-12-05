<?php
  $filename = 'läkemedel.csv';
  include_once 'shared/erpnextinterface.php';

  if (file_exists($filename))
  {
    try
    {
      $file = fopen($filename,"r"); // Öppna en dataström till filen; dvs vi läser inte in hela filen utan har en öppen kanal till den

      $erp = new ERPNextInterface();// Skapa ett gränssnittsobjekt som pratar med vår ERPNext

      echo "<pre>";

      $first = true;
      while(!feof($file))           // Så länge som vi inte nått "end of file" (EOF)...
      {
        $row = fgetcsv($file);      // Läs av en rad och översätt från .csv till Array
                                    // (Notera att den läser en rad och kommer fortsätta från där den slutade)


        if ($first)                 // Skippa första raden som bara är rubriker
        {
          print_r($row);            // Skriv ut så vi kan se datan i webbläsaren
          $first = false;
        }
        else
        {
          //$erp->deleteDocType("Patient", "G2TESTDROG");
          $erp->createDocType("Item", ["item_code"=>"112", "item_group"=>"Drug"]);

          print_r($row);              // Skriv ut så vi kan se datan i webbläsaren


          break;                     // Bryt while-loopen
        }

      }

      echo "</pre>";
    }
    finally
    {
      fclose($file);
    }
  }
  else
  {
      echo "file not found";
  }

  //$erp->createDocType("Item", ["item_code"=>"G2Test", "item_group"=>"Drug"]);
  //$erp->deleteDocType("Item", "G2Test");
?>
