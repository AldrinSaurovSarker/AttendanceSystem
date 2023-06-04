<?php
    include("config.php");
    include("firebaseRDB.php");
    
    $db = new firebaseRDB($databaseURL);
    $date = $_GET['date'];
    $data = $db->retrieve("Audits");
    $data = json_decode($data, 1);
               
    if(is_array($data)) {
        foreach($data as $id => $audit) {
            $auditDate = date('Y-m-d', strtotime($audit['timestamp']));

            echo $auditDate;
            echo $date.'<br>';
            echo '<br><br>';

            if ($auditDate == $date) {
                $delete = $db->delete("Audits", $id);
            }
        }
    }
    header('Location: logs.php');
?>