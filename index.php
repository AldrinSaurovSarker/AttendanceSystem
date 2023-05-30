<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proxy Detection System</title>
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
        <div class="fingerprint-list text-center col-md-4">
            <h1 class="text-uppercase"><i class="fas fa-fingerprint mb-4 text-primary"></i> Options</h1>
            <div class="grid-options">
                <div>
                    <div class="grid-item text-decoration-none border-success mb-3">
                        <i class="fas fa-eye text-success fa-3x"></i>
                    </div>
                    <a href="fingerprints.php" class="grid-item btn btn-outline-success">View</a>
                </div>

                <div>
                    <div class="grid-item text-decoration-none border-primary mb-3">
                        <i class="fas fa-user-plus text-primary fa-3x"></i>
                    </div>
                    <a href="enroll.php" class="grid-item btn btn-outline-primary">Enroll</a>
                </div>

                <div>
                    <div class="grid-item text-decoration-none border-info mb-3">
                        <i class="fas fa-user-check fa-3x text-info"></i>
                    </div>
                    <a href="validate.php" class="grid-item btn btn-outline-info">Verify</a>
                </div>

                <div>
                    <div class="grid-item text-decoration-none border-warning mb-3">
                        <i class="fas fa-info-circle fa-3x text-warning"></i>
                    </div>
                    <a href="logs.php" class="grid-item btn btn-outline-warning">Logs</a>
                </div>
            </div>
        </div>

        <div class="info py-5">
            <ol>
                <li>To view all fingerprints, click <span class="text-info">View</span>.</li>
                <li>To enroll, place fingerprint on the fingerprint sensor and click <span class="text-info">Enroll</span>.</li>
                <li>To verify, place fingerprint on the fingerprint sensor and click <span class="text-info">Verify</span>.</li>
                <li>To view all logs, click <span class="text-info">Logs</span>.</li>
            </ol>
        </div>
    </div>
    

    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>