<?php
session_start();

$mysqli = new mysqli('localhost', 'root', '', 'zavrsni_ivan_magdalenic');
// Provjera povezivanja s bazom podataka
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

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
    header("Location: /rabauto/index.php");
    exit;
}
$sql = "SELECT * FROM marke ORDER BY naziv_marke ASC";
$result = $mysqli->query($sql);

// Spremite rezultate u asocijativno polje
$marke = [];
while ($row = $result->fetch_assoc()) {
    $marke[$row['ID_marke']] = $row['naziv_marke'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["novi_model"], $_POST["marka"])) {
        $novi_model = $_POST["novi_model"];
        $marka = $_POST["marka"];
        // Izvršavanje upita za dodavanje nove marke
        $sql_insert = "INSERT INTO modeli (id_marke,naziv_modela) VALUES ('$marka','$novi_model')";
        if ($mysqli->query($sql_insert) === TRUE) {
            // Osvježavanje stranice
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "Error: " . $sql_insert . "<br>" . $mysqli->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>nove marke</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include "nav.php" ?><br><br>
    <div class="container"><br>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="row">
                <div class="mb-3">
                    <label for="marka" class="form-label">Marka automobila</label>
                    <select class="form-select" id="marka" name="marka" required>
                        <option value="">Odaberite marku</option>
                        <?php foreach ($marke as $id => $naziv_marke) : ?>
                            <option value="<?php echo $id; ?>"><?php echo $naziv_marke; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="novi_model" placeholder="Unesite naziv novog modela" required>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">Dodaj</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>