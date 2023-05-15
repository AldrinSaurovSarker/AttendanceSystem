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

<body class="d-flex align-items-center justify-content-center">
    <div class="container d-flex align-items-center justify-content-center">
        <div class="fingerprint-list text-center col-md-3">
            <h1 class="text-uppercase"><i class="fas fa-fingerprint mb-4 text-primary"></i> Options</h1>
            <div class="grid-options">
                <a class="grid-item text-decoration-none border-success">
                    <i class="fas fa-eye text-success fa-3x"></i>
                </a>

                <a class="grid-item text-decoration-none border-primary">
                    <i class="fas fa-user-plus text-primary fa-3x"></i>
                </a>

                <a class="grid-item text-decoration-none border-info">
                    <i class="fas fa-user-check fa-3x text-info"></i>
                </a>

                <a href="fingerprints.php" class="grid-item btn btn-outline-success">View</a>
                <a href="enroll.php" class="grid-item btn btn-outline-primary">Enroll</a>
                <a href="validate.php" class="grid-item btn btn-outline-info">Verify</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>