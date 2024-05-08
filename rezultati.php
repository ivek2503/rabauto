<?php
session_start();

// Povezivanje s bazom podataka
include "database.php";
// Provjera korisnikove sesije
if (!isset($_SESSION["user_id"])) {
    header("Location: /rabauto/login.php");
    exit;
}

// Izvršite upit za dohvaćanje marki automobila
$sql = "SELECT * FROM marke ORDER BY naziv_marke ASC";
$result = $mysqli->query($sql);

// Spremite rezultate u asocijativno polje
$marke = [];
while ($row = $result->fetch_assoc()) {
    $marke[$row['ID_marke']] = $row['naziv_marke'];
}

// Izvršite upit za dohvaćanje županija
$sql_zupanije = "SELECT * FROM zupanije ORDER BY naziv ASC";
$result_zupanije = $mysqli->query($sql_zupanije);

// Spremite rezultate u asocijativno polje
$zupanije = [];
while ($row_zupanije = $result_zupanije->fetch_assoc()) {
    $zupanije[$row_zupanije['id_zupanije']] = $row_zupanije['naziv'];
}

// Provjera je li zahtjev poslan metodom POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dohvaćanje vrijednosti iz forme
    $marka = $_POST['marka'];
    $model = $_POST['model'];
    $zupanija = $_POST['zupanija'];
    $minGodiste = $_POST['min_godiste'];
    $maxGodiste = $_POST['max_godiste'];
    $minKilometraza = $_POST['min_kilometraza'];
    $maxKilometraza = $_POST['max_kilometraza'];
    $minCijena = $_POST['min_cijena'];
    $maxCijena = $_POST['max_cijena'];
    $minSnaga = $_POST['min_snaga'];
    $maxSnaga = $_POST['max_snaga'];
    // Sastavljanje SQL upita za pretraživanje oglasa prema odabranim kriterijima
    $sql = "SELECT oglasi.*, modeli.*, marke.naziv_marke AS marka 
        FROM oglasi 
        INNER JOIN modeli ON oglasi.id_modela = modeli.id_modela 
        INNER JOIN marke ON modeli.id_marke = marke.id_marke 
        WHERE aktivan = 1"; // Početni SQL upit


    //var_dump($marka);
    //var_dump($model);
    // Dodavanje uvjeta u SQL upit prema odabranim kriterijima
    if (!empty($marka)) {
        $sql .= " AND marke.ID_marke = '$marka'";
    }
    if (!empty($model)) {
        // Dodaj uvjet za pretraživanje oglasa prema ID-u modela
        $sql .= " AND oglasi.id_modela = $model";
    }

    if (!empty($zupanija)) {
        $sql .= " AND zupanija = '$zupanija'";
    }
    if (!empty($minGodiste)) {
        $sql .= " AND godiste >= '{$minGodiste}'";
    }
    if (!empty($maxGodiste)) {
        $sql .= " AND godiste <= '{$maxGodiste}'";
    }
    if (!empty($minKilometraza)) {
        $sql .= " AND kilometraza >= '{$minKilometraza}'";
    }
    if (!empty($maxKilometraza)) {
        $sql .= " AND kilometraza <= '{$maxKilometraza}'";
    }
    if (!empty($minCijena)) {
        $sql .= " AND cijena >= '{$minCijena}'";
    }
    if (!empty($maxCijena)) {
        $sql .= " AND cijena <= '{$maxCijena}'";
    }
    if (!empty($minSnaga)) {
        $sql .= " AND snaga >= '{$minSnaga}'";
    }
    if (!empty($maxSnaga)) {
        $sql .= " AND snaga <= '{$maxSnaga}'";
    }



    $sort = isset($_POST['sort']) ? $_POST['sort'] : '';

    switch ($sort) {
        case 'kilometraza_asc':
            $sql .= " ORDER BY kilometraza ASC";
            break;
        case 'kilometraza_desc':
            $sql .= " ORDER BY kilometraza DESC";
            break;
        case 'godiste_asc':
            $sql .= " ORDER BY godiste ASC";
            break;
        case 'godiste_desc':
            $sql .= " ORDER BY godiste DESC";
            break;
        case 'cijena_asc':
            $sql .= " ORDER BY cijena ASC";
            break;
        case 'cijena_desc':
            $sql .= " ORDER BY cijena DESC";
            break;
        default:

            // $sql .= " ORDER BY ID ASC";
            break;
    }
}

// var_dump($sql);
// Izvršavanje SQL upita i dohvaćanje rezultata
$result_oglasi = $mysqli->query($sql);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RabAUTO - REZULTATI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>

<body>
    <?php include "nav.php"; ?>
    <br><br>
    <div class="container" style="min-height: 100vh;">
        <h1 class="mt-5 mb-3">Pretraži oglase</h1>


        <?php if ($_SERVER["REQUEST_METHOD"] == "POST") : ?>
            <!-- Prikaz rezultata pretraživanja -->
            <?php if ($result_oglasi->num_rows > 0) : ?>
                <h2>Rezultati pretraživanja:</h2><br>
                <form method="POST" action="">

                    <?php if (isset($_POST['marka'])) : ?> <input type="hidden" name="marka" value="<?php echo $_POST['marka']; ?>"> <?php endif; ?>
                    <?php if (isset($_POST['model'])) : ?> <input type="hidden" name="model" value="<?php echo $_POST['model']; ?>"> <?php endif; ?>
                    <?php if (isset($_POST['zupanija'])) : ?> <input type="hidden" name="zupanija" value="<?php echo $_POST['zupanija']; ?>"> <?php endif; ?>
                    <?php if (isset($_POST['min_godiste'])) : ?> <input type="hidden" name="min_godiste" value="<?php echo $_POST['min_godiste']; ?>"> <?php endif; ?>
                    <?php if (isset($_POST['max_godiste'])) : ?> <input type="hidden" name="max_godiste" value="<?php echo $_POST['max_godiste']; ?>"> <?php endif; ?>
                    <?php if (isset($_POST['min_kilometraza'])) : ?> <input type="hidden" name="min_kilometraza" value="<?php echo $_POST['min_kilometraza']; ?>"> <?php endif; ?>
                    <?php if (isset($_POST['max_kilometraza'])) : ?> <input type="hidden" name="max_kilometraza" value="<?php echo $_POST['max_kilometraza']; ?>"> <?php endif; ?>
                    <?php if (isset($_POST['min_cijena'])) : ?> <input type="hidden" name="min_cijena" value="<?php echo $_POST['min_cijena']; ?>"> <?php endif; ?>
                    <?php if (isset($_POST['max_cijena'])) : ?> <input type="hidden" name="max_cijena" value="<?php echo $_POST['max_cijena']; ?>"> <?php endif; ?>
                    <?php if (isset($_POST['min_snaga'])) : ?> <input type="hidden" name="min_snaga" value="<?php echo $_POST['min_snaga']; ?>"> <?php endif; ?>
                    <?php if (isset($_POST['max_snaga'])) : ?> <input type="hidden" name="max_snaga" value="<?php echo $_POST['max_snaga']; ?>"> <?php endif; ?>

                    <div class="form-group">
                        <label for="sort">Sortiraj po:</label>
                        <select class="form-select" name="sort" id="sort">
                            <option value="">Odaberi filter</option>
                            <option value="kilometraza_asc"> Kilometraža - od najmanje</option>
                            <option value="kilometraza_desc"> Kilometraža - od najveće</option>
                            <option value="godiste_asc"> Godište - od najstarijeg</option>
                            <option value="godiste_desc"> Godište - od najmlađeg</option>
                            <option value="cijena_asc"> Cijena - od najmanje</option>
                            <option value="cijena_desc"> Cijena - od najveće</option>
                        </select>

                    </div>
                </form><br>
                <ul>
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        <?php while ($row_oglas = $result_oglasi->fetch_assoc()) : ?>
                            <?php
                            $marka = $row_oglas['marka'];
                            $model = $row_oglas['naziv_modela'];
                            // Dohvati ID oglasa
                            $oglas_id = $row_oglas['ID'];
                            //var_dump($row_oglas);
                            //var_dump($oglas_id);
                            // Upit za dohvat prvog url-a slike oglasa
                            $sql_slike = "SELECT url FROM slike WHERE id_oglas = $oglas_id LIMIT 1";

                            $result_slike = $mysqli->query($sql_slike);
                            //var_dump($result_slike);
                            $row_slika = $result_slike->fetch_assoc();

                            // Ako postoji rezultat, dohvati url slike
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
                                            <h5 class="card-title"><?php echo $marka . ' ' . $model; ?></h5><br>
                                            <p class="card-text" style="color:gray;"><?php echo $row_oglas['kilometraza']; ?> km</p>
                                            <hr>
                                            <p class="card-text" style="color:gray;"><b><?php echo $row_oglas['cijena']; ?> €</b></p>

                                        </div>
                                    </div>
                                </a>

                            </div>

                        <?php endwhile; ?>
                    </div>



                </ul>
            <?php else : ?>
                <p>Nema rezultata za odabrane kriterije pretraživanja.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <?php include "footer.php" ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
<script>
    // Funkcija za automatsko slanje forme pri odabiru opcije iz dropdowna
    document.getElementById('sort').addEventListener('change', function() {
        this.form.submit();
    });
</script>

</html>