<?php
session_start();

// Povezivanje s bazom podataka
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


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RabAUTO - PRONAĐI</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/css/multi-select-tag.css">
</head>
<body>
    <?php include "nav.php";?><br><br><br>
    <div class="container">
        <h1 class="mt-5 mb-3">Pretraži oglase</h1>
        <form method="post" action="spremi.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="marka" class="form-label">Marka automobila</label>
                <select  id="marka" name="marka" multiple>
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

            <button type="submit" class="btn btn-primary" >PRETRAŽI</button><br><br>
        </form>
    </div>
    <?php include "footer.php"?>
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/js/multi-select-tag.js"></script>
    <script>
        new MultiSelectTag('marka') 
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }

        function odjava() {
            window.location.href = "/rabauto/logout.php";
        }
        document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('marka').addEventListener('change', function() {
        var selectedMarke = Array.from(this.selectedOptions).map(option => option.value); // Dohvati ID-ove odabranih marki
        var modelDropdown = document.getElementById('model'); // Dropdown za modele

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    modelDropdown.innerHTML = ''; // Očisti dropdown za modele
                    var models = JSON.parse(xhr.responseText); // Parsiraj odgovor kao JSON

                    // Dodaj svaki model u dropdown za modele
                    models.forEach(function(model) {
                        var option = document.createElement('option');
                        option.text = model.naziv_modela;
                        option.value = model.id_modela;
                        modelDropdown.add(option);
                    });
                } else {
                    console.error('Problem s dohvaćanjem modela');
                }
            }
        };

        // Pošalji AJAX zahtjev na server
        xhr.open('GET', 'dohvati_modele1.php?marka_id=' + encodeURIComponent(selectedMarke), true);
        xhr.send();
    });
});

        </script>
</body>
</html>