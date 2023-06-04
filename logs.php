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
            $grouped_audits = [];
    
            foreach ($data as $audit) {
                $date = date('Y-m-d', strtotime($audit['timestamp']));

                if (!isset($grouped_audits[$date])) {
                    $grouped_audits[$date] = [];
                }
                $grouped_audits[$date][] = $audit;
            }
            arsort($grouped_audits);

            foreach ($grouped_audits as $date => $audit_records) {
                $count_status_1 = 0;
                foreach ($audit_records as $audit) {
                    if ($audit['status'] == 1) {
                        $count_status_1++;
                    }
                }

                $count_status_2 = 0;
                foreach ($audit_records as $audit) {
                    if ($audit['status'] == 2) {
                        $count_status_2++;
                    }
                }

                echo
                "<div class='d-flex align-items-center w-50'>
                    <i class='fas fa-calendar-alt fa-2x text-primary me-2'></i>
                    <h2 class='text-left me-auto'>$date</h2>

                    <a href='delete_audit_by_date.php?date=".$date."'>
                        <i class='fas fa-trash-alt me-2 fa-2x text-danger'></i>
                    </a>

                    <div>
                        <b>Total attendance: $count_status_1</b><br>
                        <b>New registration: $count_status_2</b>
                    </div>
                </div>";
                    
                echo "<ul class='w-50 p-0 m-0 mb-5'>";

                foreach (array_reverse($audit_records, true) as $audit) {
                    if ($audit['status'] == 1) {
                        $icon = '<i class="fas fa-info-circle text-primary"></i>';
                        $title = '<h6 class="card-title text-primary">'.$audit['log'].'</h6>';
                    } else if ($audit['status'] == 2) {
                        $icon = '<i class="fas fa-info-circle text-success"></i>';
                        $title = '<h6 class="card-title text-success">'.$audit['log'].'</h6>';
                    } else if ($audit['status'] == 3) {
                        $icon = '<i class="fas fa-info-circle text-warning"></i>';
                        $title = '<h6 class="card-title text-warning">'.$audit['log'].'</h6>';
                    } else if ($audit['status'] == 4) {
                        $icon = '<i class="fas fa-info-circle text-danger"></i>';
                        $title = '<h6 class="card-title text-danger">'.$audit['log'].'</h6>';
                    }

                    $time = date('h:i:s A', strtotime($audit['timestamp']));

                    echo
                    '<div class="card w-100 my-2">
                        <div class="card-body d-flex">
                            '.$icon.'&emsp;
                            '.$title;

                            if (isset($audit['room'])) {
                                if ($audit['room'] != "" && $audit['room'] != null) {
                                    echo '<span class="mx-auto text-muted">Room: '.$audit['room'].'</span>';
                                }
                            }
                    
                            echo'
                            <span class="ms-auto card-text text-secondary">'.$time.'</span>
                        </div>
                    </div>';
                }
                echo "</ul>";
            }
        }
    ?>

    </div>
</body>

</html>