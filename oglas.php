<?php
session_start();

include "database.php";

// Provjera korisnikove sesije
if (!isset($_SESSION["user_id"])) {
    header("Location: /rabauto/login.php");
    exit;
}
$user_id = $_SESSION["user_id"];
$sql_check_admin = "SELECT admin FROM korisnici WHERE ID = $user_id";
$result_check_admin = $mysqli->query($sql_check_admin);

if ($result_check_admin->num_rows > 0) {
    $row = $result_check_admin->fetch_assoc();
    $is_admin = $row['admin'] == 1;
} else {
    // U slučaju greške prilikom provjere admin statusa, postavite $is_admin na false
    $is_admin = false;
}
// Provjerite je li parametar 'id' postavljen u URL-u
if (isset($_GET['id'])) {
    // Dohvatite vrijednost parametra 'id'
    $oglas_id = $_GET['id'];

    // Izvršite upit za dohvaćanje podataka o oglasu s odabranim ID-om
    $sql = "SELECT oglasi.*, modeli.*, marke.naziv_marke AS marka 
    FROM oglasi 
    INNER JOIN modeli ON oglasi.id_modela = modeli.id_modela 
    INNER JOIN marke ON modeli.id_marke = marke.id_marke WHERE ID = $oglas_id";
    $result_oglasi = $mysqli->query($sql);
    // Provjerite je li rezultat upita uspješno dohvaćen

    if ($result_oglasi->num_rows === 0) {
        echo "Nema rezultata oglasa s tim ID-om.";
        exit;
    }

    $row_oglas = $result_oglasi->fetch_assoc(); // Dohvati podatke samo za jedan oglas
    $marka = $row_oglas['marka'];
    $model = $row_oglas['naziv_modela'];

    // Upit za dohvat svih url-ova slika oglasa
    $sql_slike = "SELECT url FROM slike WHERE id_oglas = $oglas_id";
    $result_slike = $mysqli->query($sql_slike);
    // Provjeri postojanje slika
    if ($result_slike->num_rows > 0) {
        $slike = $result_slike->fetch_all(MYSQLI_ASSOC); // Dohvati sve slike
    } else {
        // Ako nema slika, prikaži sliku "nema slike"
        $slike = array(array("url" => "nema-slike.jpg"));
    }
} else {
    echo "ID oglasa nije specificiran.";
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($action === 'ukloni') {
            $oglas_id = $_POST['oglas_id'];
            $sql_update = "UPDATE oglasi SET aktivan = 0 WHERE ID = $oglas_id";
            if ($mysqli->query($sql_update) === TRUE) {
                header("location:/rabauto");
            } else {
                echo "<p>Greška prilikom uklanjanja oglasa: " . $mysqli->error . "</p>";
            }
        } elseif ($action === 'prodano') {
            $oglas_id = $_POST['oglas_id'];
            $sql_update = "UPDATE oglasi SET aktivan = 0, prodan = 1 WHERE ID = $oglas_id";
            if ($mysqli->query($sql_update) === TRUE) {
                header("location:/rabauto");
            } else {
                echo "<p>Greška prilikom označavanja oglasa kao prodanog: " . $mysqli->error . "</p>";
            }
        } elseif ($action === 'vrati') {
            $oglas_id = $_POST['oglas_id'];
            $sql_update = "UPDATE oglasi SET aktivan = 1, prodan = 0 WHERE ID = $oglas_id";
            if ($mysqli->query($sql_update) === TRUE) {
                header("location:/rabauto");
            } else {
                echo "<p>Greška prilikom vraćanja oglasa: " . $mysqli->error . "</p>";
            }
        }
    }
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oglas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .mala-slika {
            width: 50px;
            height: 50px;
            margin: 5px;
        }

        @media (max-width: 767.98px) {
            .mala-slika {
                width: 30px;
                height: 30px;
                margin: 0 5px;
            }
        }
    </style>
</head>

<body>
    <?php include "nav.php" ?><br><br><br><br>
    <div class="container mt-5">
        <div class="row justify-content-center mt-3">

            <div class="col-md-6 text-center position-relative">
                <?php if (!empty($slike)) : ?>
                    <img src="slike/<?php echo $slike[0]['url']; ?>" class="img-thumbnail oglasi-slika" alt="Oglasna slika" style="max-height: 70vh;">
                <?php else : ?>
                    <img src="nema-slike.jpg" class="img-thumbnail oglasi-slika" alt="Nema slike">
                <?php endif; ?>
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <?php foreach ($slike as $key => $slika) : ?>
                <div class="col-md-2 text-center mt-3">
                    <img src="slike/<?php echo $slika['url']; ?>" class="img-thumbnail mala-slika" alt="Mala slika <?php echo $key; ?>">
                </div>
            <?php endforeach; ?>
        </div><br>

        <hr>
        <h1 style="text-align: center; font-size: 2rem;">
            <?php echo $marka . ' ' . $model; ?>

        </h1>
        <p style="text-align: center;"><i class="far fa-calendar-alt"></i> <?php echo date('d.m.Y', strtotime($row_oglas['datum_objave'])); ?></p><br><br>
        <p style="font-size: 1.2rem; text-align: center;"><b>Cijena:</b> <?php echo $row_oglas['cijena']; ?>€</p><br>
        <p style="font-size: 1.2rem; text-align: center; border: 1px solid #ccc; padding: 10px;"><?php echo $row_oglas['opis']; ?></p><br>
        <div class="row justify-content-center mt-3">
            <div class="col-md-6">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th style="font-size: 1.2rem;">Godište</th>
                            <td style="font-size: 1.2rem;"><?php echo $row_oglas['godiste']; ?></td>
                        </tr>
                        <tr>
                            <th style="font-size: 1.2rem;">Kilometraža</th>
                            <td style="font-size: 1.2rem;"><?php echo $row_oglas['kilometraza'] . ' km'; ?></td>
                        </tr>
                        <tr>
                            <th style="font-size: 1.2rem;">Snaga</th>
                            <td style="font-size: 1.2rem;"><?php echo $row_oglas['snaga'] . ' ks'; ?></td>
                        </tr>
                        <tr>
                            <th style="font-size: 1.2rem;">Županija</th>
                            <td style="font-size: 1.2rem;">
                                <?php
                                $zupanija_id = $row_oglas['zupanija'];
                                $sql_zupanija = "SELECT naziv FROM zupanije WHERE id_zupanije = $zupanija_id";
                                $result_zupanija = $mysqli->query($sql_zupanija);
                                if ($result_zupanija->num_rows > 0) {
                                    $row_zupanija = $result_zupanija->fetch_assoc();
                                    echo $row_zupanija['naziv'];
                                } else {
                                    echo "Nepoznata županija";
                                }
                                ?>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="row justify-content-center mt-3">
                <div class="col-md-6">
                    <?php if ($row_oglas['aktivan'] && ($user_id == $row_oglas['ID_prodavaca'] || $is_admin)) : ?>
                        <form method="post" action="">
                            <input type="hidden" name="oglas_id" value="<?php echo $oglas_id; ?>">
                            <input type="hidden" name="action" value="ukloni">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Jeste li sigurni da želite ukloniti oglas?')">Ukloni</button>
                        </form>
                    <?php elseif (!$row_oglas['aktivan'] && ($user_id == $row_oglas['ID_prodavaca'] || $is_admin)) : ?>
                        <form method="post" action="">
                            <input type="hidden" name="oglas_id" value="<?php echo $oglas_id; ?>">
                            <input type="hidden" name="action" value="vrati">
                            <button type="submit" class="btn btn-success" onclick="return confirm('Jeste li sigurni da želite vratiti oglas?')">Vrati</button>
                        </form>
                    <?php endif; ?>

                    <?php if ($row_oglas['aktivan'] && $user_id == $row_oglas['ID_prodavaca'] && !$row_oglas['prodan']) : ?>
                        <form method="post" action="">
                            <input type="hidden" name="oglas_id" value="<?php echo $oglas_id; ?>">
                            <input type="hidden" name="action" value="prodano">
                            <button type="submit" class="btn btn-success" onclick="return confirm('Jeste li sigurni da je oglas prodan?')">Prodano</button>
                        </form>
                    <?php endif; ?>
                    <?php

if (isset($_SESSION["user_id"]) && $row_oglas['ID_prodavaca'] != $_SESSION["user_id"]) {
?>
<div class="row justify-content-center mt-3">
    <div class="col-md-6">
        <form action="posalji_poruku.php" method="post">
            <input type="hidden" name="oglas_id" value="<?php echo $oglas_id; ?>">
            <div class="mb-3">
                <label for="poruka" class="form-label">Vaša poruka:</label>
                <textarea class="form-control" id="poruka" name="poruka" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Pošalji</button>
        </form>
    </div>
</div>
<?php
}
?>
                    <br>
                </div>

            </div>
        </div>
        <div class="modal fade" id="slikaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <img src="" class="img-fluid" id="modalSlika" alt="Uvećana slika">
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php include "footer.php" ?>




    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".oglasi-slika").click(function() {
                var slikaUrl = $(this).attr("src");
                $("#modalSlika").attr("src", slikaUrl);
                $("#slikaModal").modal("show");
            });
        });
        $(document).ready(function() {
            var currentIndex = 0;
            var slike = <?php echo json_encode($slike); ?>;
            var maxIndex = slike.length - 1;
            $(document).keydown(function(e) {
                if (e.keyCode == 37) { // Strelica ulijevo
                    currentIndex = (currentIndex === 0) ? maxIndex : currentIndex - 1;
                    prikaziSliku(currentIndex);
                } else if (e.keyCode == 39) { // Strelica udesno
                    currentIndex = (currentIndex === maxIndex) ? 0 : currentIndex + 1;
                    prikaziSliku(currentIndex);
                }
            });


            $(".oglasi-slika").on("touchstart", function(e) {
                startX = e.changedTouches[0].pageX;
            });

            $(".oglasi-slika").on("touchmove", function(e) {
                var endX = e.changedTouches[0].pageX;
                var threshold = 50; // Minimalna udaljenost za detektiranje pokreta
                var deltaX = startX - endX;

                if (deltaX > threshold && currentIndex < maxIndex) {
                    currentIndex++;
                    prikaziSliku(currentIndex);
                } else if (deltaX < -threshold && currentIndex > 0) {
                    currentIndex--;
                    prikaziSliku(currentIndex);
                }
            });

            function prikaziSliku(index) {
                $(".oglasi-slika").attr("src", "slike/" + slike[index].url);
            }
        });
        $(document).ready(function() {
            $(".oglasi-slika").click(function() {
                var slikaUrl = $(this).attr("src");
                $("#modalSlika").attr("src", slikaUrl);
                $("#slikaModal").modal("show");
            });

            $(".mala-slika").click(function() {
                var slikaUrl = $(this).attr("src");
                $(".oglasi-slika").attr("src", slikaUrl);
            });
        });
    </script>

</body>

</html>