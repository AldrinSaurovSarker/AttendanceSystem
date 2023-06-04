<?php
    date_default_timezone_set('Asia/Dhaka');

    include("config.php");
    include("firebaseRDB.php");
    $db = new firebaseRDB($databaseURL);

    if ($_GET['action'] == 1) {
        $log = 'Student id '.$_GET['id'].' gave attendance.';
        $summary = 'Verified';
    } elseif ($_GET['action'] == 2) {
        $log = 'A new student with id '.$_GET['id'].' registered.';
        $summary = 'Enrolled';
    } elseif ($_GET['action'] == 3) {
        $log = 'Student failed to register as a student with id '.$_GET['id'].' already exists.';
        $summary = 'Failed';
    } elseif ($_GET['action'] == 4) {
        $log = "Fingerprint doesn't match.";
        $summary = 'Not matched';
    }

    $db->update("LatestAudit", "latest", [
        "log"     => $summary
    ]);

    $db->insert("Audits", [
        "log" => $log,
        "timestamp" => date("Y-m-d h:i:s A"),
        "status" => $_GET['action'],
        "room" => $_GET['room']
    ]);
?>