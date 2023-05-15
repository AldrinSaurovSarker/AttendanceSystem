<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Proxy Detection System | Enroll</title>
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

   <div class="container d-flex align-items-center justify-content-center">
      <?php
         include("config.php");
         include("firebaseRDB.php");

         $db = new firebaseRDB($databaseURL);
         $id = $_GET['id'];
         if($id != ""){
            $delete = $db->delete("Fingerprints", $id);
            echo "<div class='msg'>Fingerprint deleted.</div>";
         }
      ?>
   </div>
</body>

</html>