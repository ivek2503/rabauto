<?php
session_start();


include "database.php";

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


$sql = "SELECT * FROM marke ORDER BY naziv_marke ASC";
$result = $mysqli->query($sql);


$marke = [];
while ($row = $result->fetch_assoc()) {
    $marke[$row['ID_marke']] = $row['naziv_marke'];
}


$sql_zupanije = "SELECT * FROM zupanije ORDER BY naziv ASC";
$result_zupanije = $mysqli->query($sql_zupanije);


$zupanije = [];
while ($row_zupanije = $result_zupanije->fetch_assoc()) {
    $zupanije[$row_zupanije['id_zupanije']] = $row_zupanije['naziv'];
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RabAUTO - OBJAVI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
<?php include "nav.php";?>
    <br><br>
    <div class="container">
        <h1 class="mt-5 mb-3">Unos podataka o automobilu</h1>
        <form method="post" action="spremi.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="marka" class="form-label">Marka automobila</label>
                <select class="form-select" id="marka" name="marka" required>
                    <option value="">Odaberite marku</option>
                    <?php foreach ($marke as $id => $naziv_marke) : ?>
                        <option value="<?php echo $id; ?>"><?php echo $naziv_marke; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="model" class="form-label">Model automobila</label>
                <select class="form-select" id="model" name="model" required>
                    <option value="">Odaberite model</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="zupanija" class="form-label">Županija</label>
                <select class="form-select" id="zupanija" name="zupanija" required>
                    <option value="">Odaberite županiju</option>
                    <?php foreach ($zupanije as $id_zupanije => $naziv) : ?>
                        <option value="<?php echo $id_zupanije; ?>"><?php echo $naziv; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>


            <div class="mb-3">
                <label for="godiste" class="form-label">Godište automobila</label>
                <select class="form-select" id="godiste" name="godiste" required>
                    <option value="">Odaberite godište</option>
                    <?php
                    // Petlja za generiranje opcija za godište od 1970 do 2024
                    for ($i = 2024; $i >= 1970; $i--) {
                        echo "<option value='{$i}'>{$i}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="kilometraza" class="form-label">Kilometraža</label>
                <input type="number" class="form-control" id="kilometraza" name="kilometraza" min="0" required>
            </div>
            <div class="mb-3">
                <label for="cijena" class="form-label">Cijena</label>
                <input type="number" class="form-control" id="cijena" name="cijena" min="0" required>
            </div>
            <div class="mb-3">
                <label for="snaga" class="form-label">Konjska snaga:</label>
                <input type="number" class="form-control" id="snaga" name="snaga" min="0" required>
            </div>
            <div class="mb-3">
                <label for="opis" class="form-label">Opis automobila</label>
                <textarea class="form-control" id="opis" name="opis" rows="3" required></textarea>
            </div>
            <div class="mb-3">
    <label for="slike" class="form-label">Priložite fotografije (maksimalno 3 slike)</label>
    <input type="file" class="form-control" id="slike" name="slike[]" multiple accept="image/*" required maxlength="3">
</div>


            <input type="hidden" id="model_id" name="model_id" value="">
            <button type="submit" class="btn btn-primary" onclick="postaviModelID()">OBJAVI</button><br><br>
        </form>
    </div>

    <?php include "footer.php"?>
    <script>
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }

        function odjava() {
            window.location.href = "/rabauto/logout.php";
        }
        document.addEventListener('DOMContentLoaded', function() {
            // Postavljanje slušatelja promjene na padajući izbornik marke
            document.getElementById('marka').addEventListener('change', function() {
                var markaId = this.value; // Dobivanje ID-a odabrane marke
                var modelDropdown = document.getElementById('model'); // Padajući izbornik modela

                // Poziv AJAX-a za dohvaćanje modela povezanih s odabranom markom
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Očisti padajući izbornik modela
                            modelDropdown.innerHTML = '';

                            // Parsiraj odgovor kao JSON
                            var models = JSON.parse(xhr.responseText);

                            // Dodaj svaki model u padajući izbornik
                            models.forEach(function(model) {
                                var option = document.createElement('option');
                                option.text = model.naziv_modela;
                                option.value = model.id_modela;
                                modelDropdown.add(option);
                            });
                        } else {
                            // Prikaz greške ako dođe do problema s AJAX-om
                            console.error('Problem s dohvaćanjem modela');
                        }
                    }
                };

                // Pošalji zahtjev na server
                xhr.open('GET', 'dohvati_modele.php?marka_id=' + markaId, true);
                xhr.send();
            });
        });

        function postaviModelID() {
            var modelDropdown = document.getElementById('model');
            var modelIDInput = document.getElementById('model_id');

            // Postavljanje vrijednosti skrivenog input elementa na odabrani ID modela
            modelIDInput.value = modelDropdown.value;
        }
        document.getElementById('slike').addEventListener('change', function() {
        var files = this.files; // Dobivanje odabranih datoteka
        var maxFiles = 3; // Maksimalni broj datoteka

        // Provjera je li broj odabranih datoteka veći od maksimalnog
        if (files.length > maxFiles) {
            // Prikaz poruke korisniku
            alert('Možete odabrati najviše 3 slike.');
            // Resetiranje input polja za odabir slika kako bi korisnik mogao ponovno odabrati
            this.value = '';
        }
    });

    </script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>

</html>