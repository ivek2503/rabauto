<?php
session_start();

include "database.php";

// Provjera korisnikove sesije
if (!isset($_SESSION["user_id"])) {
    header("Location: /rabauto/login.php");
    exit;
}
$is_admin = false;
$user_id = $_SESSION["user_id"];
$sql_check_admin = "SELECT admin FROM korisnici WHERE ID = $user_id";
$result_check_admin = $mysqli->query($sql_check_admin);

if ($result_check_admin->num_rows > 0) {
    $row = $result_check_admin->fetch_assoc();
    $is_admin = $row['admin'] == 1;
}

// Ako korisnik nije administrator, preusmjeri ga na drugu stranicu
if (!$is_admin) {
    header("Location: /rabauto/index.php"); // Promijenite "index.php" u stranicu na koju želite preusmjeriti korisnika
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Panel</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Admin Panel</h1>
        <div class="row">
            <!-- Oglasi Card -->
            <div class="col-md-6">
                <a href="pronadi.php" class="text-decoration-none text-dark">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="bi bi-car-front-fill"></i>
                            <h5 class="card-title mt-3">Oglasi</h5>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Novi Admini Card -->
            <div class="col-md-6">
                <a href="novi_admini.php" class="text-decoration-none text-dark">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-user-plus fa-5x"></i>
                            <h5 class="card-title mt-3">Novi Administratori</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row mt-4">
            <!-- Nove Marke Card -->
            <div class="col-md-6">
                <a href="nove_marke.php" class="text-decoration-none text-dark">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-tag fa-5x"></i>
                            <h5 class="card-title mt-3">Nove Marke</h5>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Novi Modeli Card -->
            <div class="col-md-6">
                <a href="novi_modeli.php" class="text-decoration-none text-dark">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-car-side fa-5x"></i>
                            <h5 class="card-title mt-3">Novi Modeli</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript biblioteke -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>