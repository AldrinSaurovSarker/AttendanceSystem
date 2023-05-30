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
    <title>Proxy Detection System | Validate</title>
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
            $data = $db->retrieve("Fingerprints");
            $data = json_decode($data, 1);

            if (!is_array($data)) {
                echo "<div class='msg'>No fingerprint found on the sensor.</div>";
            } else if (isset($data['temp'])) {
                $tempFingerprintId = $data['temp']['id'];
                if (isset($data['temp']['fingerHex'])) {
                    $tempFingerprintHex = $data['temp']['fingerHex'];
                } else {
                    $tempFingerprintHex = null;
                }
                unset($data['temp']);
            
                foreach ($data as $id => $fingerprint) {
                    if ($fingerprint['id'] === $tempFingerprintId) {
                        echo "<div class='msg success'>Fingerprint matched with id ".$fingerprint['id'].".</div>";
                        file_get_contents('http://localhost/attendance/action_edit.php?id='.$id.'&fingerHex='.$tempFingerprintHex);
                        file_get_contents('http://localhost/attendance/audit.php?id='.$id.'&action=1');
                        file_get_contents('http://localhost/attendance/delete.php?id=temp');
                        exit;
                    }
                }
                echo "<div class='msg failure'>Fingerprint doesn't match.</div>";
                file_get_contents('http://localhost/attendance/audit.php?id='.$tempFingerprintId.'&action=4');
                file_get_contents('http://localhost/attendance/delete.php?id=temp');
            } else {
                echo "<div class='msg'>No fingerprint found on the sensor.</div>";
            }
        ?>

        <div class="text-info text-center fw-bold pt-5">Place your finger on the fingerprint sensor to give attendance and wait a while.</div>
    </div>

    <script>
        const success = document.querySelector('.success');
        
        if (success == null) {
            setTimeout(() => {
                location.reload();
            }, 1);
        } else {
            setTimeout(() => {
                location.reload();
            }, 10000);
        }
    </script>
</body>

</html>