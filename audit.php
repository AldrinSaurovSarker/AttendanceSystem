<?php
    date_default_timezone_set('Asia/Dhaka');
    
    include("config.php");
    include("firebaseRDB.php");
    $db = new firebaseRDB($databaseURL);

    if ($_GET['action'] == 1) {
        $insert = $db->insert("Audits", [
            "log" => 'Student id '.$_GET['id'].' gave attendance.',
            "timestamp" => date("Y-m-d h:i:s A"),
            "status" => $_GET['action']
        ]);
    }

    if ($_GET['action'] == 2) {
        $insert = $db->insert("Audits", [
            "log" => 'A new student with id '.$_GET['id'].' registered.',
            "timestamp" => date("Y-m-d h:i:s A"),
            "status" => $_GET['action']
        ]);
    }

    if ($_GET['action'] == 3) {
        $insert = $db->insert("Audits", [
            "log" => 'Student failed to register as a student with id '.$_GET['id'].' already exists.',
            "timestamp" => date("Y-m-d h:i:s A"),
            "status" => $_GET['action']
        ]);
    }

    if ($_GET['action'] == 4) {
        $insert = $db->insert("Audits", [
            "log" => "Fingerprint doesn't match.",
            "timestamp" => date("Y-m-d h:i:s A"),
            "status" => $_GET['action']
        ]);
    }
?>