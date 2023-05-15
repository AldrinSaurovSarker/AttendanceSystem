<?php
   include("config.php");
   include("firebaseRDB.php");
   $db = new firebaseRDB($databaseURL);
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Proxy Detection System | Fingerprints</title>
   <link rel="stylesheet" href="style.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
   <script src="https://kit.fontawesome.com/676c01a977.js"></script>
</head>

<body>
   <h1 class="header text-center py-5 text-primary">
      <a href="index.php" class="text-decoration-none">
         <i class="fas fa-home"></i> Proxy Detection System
      </a>
   </h1>

   <div class="container">
      <div class="fingerprint-list text-center">
         <h1 class="text-uppercase"><i class="fas fa-fingerprint mb-4 text-primary"></i> List of all fingerprints</h1>
         <table class="table table-striped shadow rounded">
            <tr class="bg-info text-light fw-bold">
               <td>ID</td>
               <td>Fingerprint Hex</td>
               <td>Action</td>
            </tr>

            <?php
               $data = $db->retrieve("Fingerprints");
               $data = json_decode($data, 1);
               
               if(is_array($data)){
                  foreach($data as $id => $Fingerprints) {
                     if ($id != 'temp') {
                        echo
                        "<tr>
                           <td>{$Fingerprints['id']}</td>
                           <td>{$Fingerprints['fingerHex']}</td>
                           <td>
                              <i class='fas fa-trash-alt text-danger'></i> 
                              <a href='delete.php?id=$id' class='text-decoration-none'>Delete</a>
                           </td>
                        </tr>";
                     }
                  }
               } else {
                  echo
                  "<tr>
                     <td colspan='3'>
                        No fingerprints available.
                     </td>
                  </tr>
                  ";
               }
            ?>
         </table>
      </div>
   </div>

   <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>