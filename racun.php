<?php
session_start();

// Povezivanje s bazom podataka
include "database.php";

// Provjera korisnikove sesije
if (!isset($_SESSION["user_id"])) {
    header("Location: /rabauto/login.php");
    exit;
}
define('SECRET_KEY', 'tajni_kljuc_za_hashiranje');


$user_id_hashed = hash_hmac('sha256', $_SESSION["user_id"], SECRET_KEY);


if (!isset($_COOKIE['user_id']) || $_COOKIE['user_id'] !== $user_id_hashed) {

    session_unset();
    session_destroy();
    

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



$user_id = $_SESSION["user_id"];

$sql = "SELECT ime, prezime, username, email_adresa FROM korisnici WHERE id = $user_id";
$result = $mysqli->query($sql);


if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();
    $ime = $row["ime"];
    $prezime = $row["prezime"];
    $username = $row["username"];
    $email = $row["email_adresa"];
} else {
    echo "Nema podataka o korisniku.";
}
$sql_oglasi = "SELECT oglasi.*, modeli.*, marke.naziv_marke AS marka 
FROM oglasi 
INNER JOIN modeli ON oglasi.id_modela = modeli.id_modela 
INNER JOIN marke ON modeli.id_marke = marke.id_marke WHERE id_prodavaca = $user_id";
$result_oglasi = $mysqli->query($sql_oglasi);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rabauto - RAČUN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
</head>

<body>
    <?php include "nav.php" ?><br><br><br>
    <div class="container" style="min-height: 100vh; text-align:center;">
        <?php
        if ($is_admin) {
        ?>
            <a href="admin.php"><button class="btn btn-primary">ADMIN PANEL</button></a>
        <?php
        }
        ?>
        <div class="row mt-5">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Vaši korisnički podaci</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><strong>Ime:</strong> <?php echo $ime; ?></p>
                        <p class="card-text"><strong>Prezime:</strong> <?php echo $prezime; ?></p>
                        <p class="card-text"><strong>Username:</strong> <?php echo $username; ?></p>
                        <p class="card-text"><strong>Email:</strong> <?php echo $email; ?></p>
                    </div>
                </div>
            </div>
        </div><br>
        <hr>
        <div class="row mt-5">
            <div class="col">
                <h2>Povijest vaših oglasa: </h2>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php while ($row_oglas = $result_oglasi->fetch_assoc()) : ?>
                        <?php
                        $marka = $row_oglas['marka'];
                        $model = $row_oglas['naziv_modela'];

                        $oglas_id = $row_oglas['ID'];

                        $sql_slike = "SELECT url FROM slike WHERE id_oglas = $oglas_id LIMIT 1";

                        $result_slike = $mysqli->query($sql_slike);

                        $row_slika = $result_slike->fetch_assoc();

                        if ($row_slika) {
                            $slika_url = "slike/" . $row_slika["url"];
                        } else {

                            $slika_url = "nema-slike.jpg";
                        }

                        ?>


                        <div class="col">
                            <a href="oglas.php?id=<?php echo $oglas_id; ?>" style="text-decoration:none;">
                                <div class="card">
                                    <img src="<?php echo $slika_url; ?>" class="card-img-top" alt="Slika oglasa">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $marka . ' ' . $model; ?><br>
                                            <?php
                                            if ($row_oglas['aktivan'] == 0 && $row_oglas['prodan'] == 0) {
                                                echo '<span style="color: #FF0000;"> UKLONJEN</span>';
                                            } elseif ($row_oglas['aktivan'] == 0 && $row_oglas['prodan'] == 1) {
                                                echo '<span style="color: #FFFF00;"> PRODAN</span>';
                                            } elseif ($row_oglas['aktivan'] == 1 && $row_oglas['prodan'] == 0) {
                                                echo '<span style="color: #00FF00;"> AKTIVAN</span>';
                                            } ?>
                                            </h5><br>
                                        <p class="card-text" style="color:gray;"><?php echo $row_oglas['kilometraza']; ?> km</p>
                                        <hr>
                                        <p class="card-text" style="color:gray;"><b><?php echo $row_oglas['cijena']; ?> €</b></p>

                                    </div>
                                </div>
                            </a>

                        </div>

                    <?php endwhile; ?><br>
                </div><br>
            </div>
        </div>
    </div>
    <?php include "footer.php" ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>