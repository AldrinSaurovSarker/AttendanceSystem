<?php
   include("config.php");
   include("firebaseRDB.php");
   $db = new firebaseRDB($databaseURL);

   $insert = $db->insert("Fingerprints", [
      "fingerHex"     => $_GET['fingerHex']
   ]);

   echo "data saved";
?>