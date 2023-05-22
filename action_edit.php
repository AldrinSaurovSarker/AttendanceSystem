<?php
    include("config.php");
    include("firebaseRDB.php");

    $db = new firebaseRDB($databaseURL);
    $id = $_GET['id'];

    $update = $db->update("Fingerprints", $id, [
        "fingerHex"     => $_GET['fingerHex']
    ]);

    echo "data updated";
?>