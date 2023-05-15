<?php
    include("config.php");
    include("firebaseRDB.php");
    $db = new firebaseRDB($databaseURL);
?>

<title>Proxy Detection System | Validate</title>

<?php
    $data = $db->retrieve("Fingerprints");
    $data = json_decode($data, 1);

    if (!is_array($data)) {
        echo "No fingerprint found on the sensor";
    } else if (isset($data['temp'])) {
        $tempFingerprint = $data['temp']['fingerHex'];
        unset($data['temp']);
      
        foreach ($data as $id => $fingerprint) {
            if ($fingerprint['fingerHex'] === $tempFingerprint) {
                echo "Fingerprint matched.";
                file_get_contents('http://localhost/attendance/delete.php?id=temp');
                exit;
            }
        }
        echo "Fingerprint doesn't match.";
        file_get_contents('http://localhost/attendance/delete.php?id=temp');
    } else {
        echo "No fingerprint found on the sensor";
    }
?>