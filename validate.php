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

<body class="d-flex align-items-center justify-content-center">
    <div class="container d-flex align-items-center justify-content-center">
        <?php
            $data = $db->retrieve("Fingerprints");
            $data = json_decode($data, 1);

            if (!is_array($data)) {
                echo "<div class='msg'>No fingerprint found on the sensor.</div>";
            } else if (isset($data['temp'])) {
                $tempFingerprint = $data['temp']['fingerHex'];
                unset($data['temp']);
            
                foreach ($data as $id => $fingerprint) {
                    if ($fingerprint['fingerHex'] === $tempFingerprint) {
                        echo "<div class='msg'>Fingerprint matched.</div>";
                        file_get_contents('http://localhost/attendance/delete.php?id=temp');
                        exit;
                    }
                }
                echo "<div class='msg'>Fingerprint doesn't match.</div>";
                file_get_contents('http://localhost/attendance/delete.php?id=temp');
            } else {
                echo "<div class='msg'>No fingerprint found on the sensor.</div>";
            }
        ?>
    </div>
</body>

</html>