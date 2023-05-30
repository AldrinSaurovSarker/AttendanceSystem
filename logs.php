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
    <title>Proxy Detection System | Audit Logs</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/676c01a977.js"></script>
</head>

<body>
    <h1 class="header text-center py-5 text-primary">
        <a href="index.php" class="text-decoration-none d-flex align-items-center justify-content-center">
            <img src="house.png">
            <div class="ms-2">Proxy Detection System</div>
        </a>
    </h1>

    <div class="container d-flex align-items-center justify-content-center">
        <?php
            $data = $db->retrieve("Audits");
            $data = json_decode($data, 1);

            if (!is_array($data)) {
                echo "<div class='msg'>No audit logs available.</div>";
            } else {
                foreach ($data as $id => $audit) {
                    echo
                    '<div class="card w-100 my-2">
                        <div class="card-body">
                            <h6 class="card-title text-info">'.$audit['log'].'</h6>';

                            if ($audit['status'] == 1) {
                                echo '<i class="fas fa-info-circle text-primary"></i>';
                            } else if ($audit['status'] == 2) {
                                echo '<i class="fas fa-info-circle text-success"></i>';
                            } else if ($audit['status'] == 3) {
                                echo '<i class="fas fa-info-circle text-warning"></i>';
                            } else if ($audit['status'] == 4) {
                                echo '<i class="fas fa-info-circle text-danger"></i>';
                            }

                            echo '
                            <span class="card-text text-muted">'.$audit['timestamp'].'<span>
                        </div>
                    </div>';
                }                
            }
        ?>
    </div>
</body>

</html>