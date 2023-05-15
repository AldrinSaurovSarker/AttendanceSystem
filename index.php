<?php
   include("config.php");
   include("firebaseRDB.php");
   $db = new firebaseRDB($databaseURL);
?>

<title>Proxy Detection System | Fingerprints</title>
<link rel="stylesheet" href="style.css">
<table border="1" width="500">
   <tr align="center" bgcolor="#dddddd" ;>
      <td>ID</td>
      <td>FingerHex</td>
      <td colspan="2">Action</td>
   </tr>

   <?php
      $data = $db->retrieve("Fingerprints");
      $data = json_decode($data, 1);
      
      if(is_array($data)){
         foreach($data as $id => $Fingerprints) {
            echo
            "<tr>
               <td>{$id}</td>
               <td>{$Fingerprints['fingerHex']}</td>
               <td><a href='delete.php?id=$id'>DELETE</a></td>
            </tr>";
         }
      }
   ?>
</table>